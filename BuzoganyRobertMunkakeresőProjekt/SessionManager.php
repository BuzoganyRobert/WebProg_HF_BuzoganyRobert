<?php

require_once "Database.php";


class SessionManager
{

    public static function startSession(){

        if(session_status()==PHP_SESSION_NONE){

            session_start();
            if (isset($_SESSION['user'])) {
            // Ha van bejelentkezett felhasználó, akkor további műveletek...
            $loggedInUser = $_SESSION['user'];

        } else {
            // Ha nincs bejelentkezett felhasználó, akkor például átirányíthatjuk a bejelentkezési oldalra
            header("Location: UserAuthentication.php");
            exit();
        }
    }
        }


    public static function isLoggedIn()
    {
        return isset($_SESSION['user']);
    }
    public static function setUserFullName($fullName) {
        $_SESSION['userFullName'] = $fullName;
    }

    public static function getUserFullName(){
        return isset($_SESSION['userFullName']) ? $_SESSION['userFullName'] : '';
    }

    public static function getUser(){
        return isset($_SESSION['user']) ? $_SESSION['user'] :null;

    }
    private function getTotalJobs() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM employers");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_row();
        return $row[0];
    }


}
class MessageHandler{
    public static function displayErrorMessage($errorMessage){
        if(!empty($errorMessage)){
            echo "<div class='error-message'>$errorMessage</div>";
        }
    }

}
class JobListPage {
    private $conn;
    private $itemsPerPage = 10;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    private function getTotalJobs() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM employers");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_row();
        return $row[0];
    }

    public function displayJobs() {
        $page = isset($_GET['page']) ? max(1, $_GET['page']) : 1;
        $offset = ($page - 1) * $this->itemsPerPage;
        $totalJobs = $this->getTotalJobs();

        if (isset($this->conn)) {
            $stmt = $this->conn->prepare("SELECT * FROM employers LIMIT ? OFFSET ?");
            $stmt->bind_param("ii", $this->itemsPerPage, $offset);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $this->displayPageHeader();
                $this->displayNavigation($page, $totalJobs);
                $this->displayJobList($result);
                $this->displayPageFooter();
            } else {
                echo "Nincsenek elérhető állások";
            }
        }
    }


private function displayPageHeader() {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Alláskereső</title>
            <link rel="stylesheet" type="text/css" href="SessionManagerCSS.css">
        </head>
        <body>
        <?php

        // Kezdeti ellenőrzés
    SessionManager::startSession();

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
    $logged_in_user = SessionManager::getUser();
    ?>
    <nav class="nav-top">
        <?php if ($logged_in_user) : ?>
            <a href="#"><?php echo $logged_in_user['FullName']; ?></a>
        <?php else : ?>
            <a href="UserAuthentication.php">Login</a>
        <?php endif; ?>
        <a href="JobListing.php">Add A New Job</a>

    </nav>


    <ul class="cards-list">
    <?php
}

    private function displayNavigation($currentPage, $totalJobs) {
        $totalPages = ceil($totalJobs / $this->itemsPerPage);

        if ($totalPages > 1) {
            echo "<div class='pagination'>";
            // Előző oldal gomb
            if ($currentPage > 1) {
                echo "<a href='SessionManager.php?page=" . ($currentPage - 1) . "'><button type='button'>Előző</button></a> ";
            }

            // Oldalszámok
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($i == $currentPage) {
                    echo "<button type='button' disabled>$i</button> ";
                } else {
                    echo "<a href='SessionManager.php?page=$i'><button type='button'>$i</button></a>";
                }
            }

            // Következő oldal gomb
            if ($currentPage < $totalPages) {
                echo "<a href='SessionManager.php?page=" . ($currentPage + 1) . "'><button type='button'>Következő</button></a>";
            }
            echo "</div>";
        }
    }


    private function displayJobList($result) {

        while ($row = $result->fetch_assoc()) {
            $fullDescription = $row['job_description'];
            $shortDescription = strlen($fullDescription) > 120 ? substr($fullDescription, 0, 120) . '...' : $fullDescription;

            ?>
            <li class="card">
                <article class="information">
                    <span class="tag">Job</span>
                    <h2 class="job_name"><?php echo $row["company_name"]; ?></h2>
                    <p class="job_description"><?php echo $shortDescription; ?></p>
                    <a href="JobDetailsPage.php?id=<?php echo $row['id'];?>">
                        <button class="button_learn_more">
                            <span>Learn more</span>
                        </button>
                    </a>
                </article>
            </li>
            <?php
        }
        echo "</ul>";
    }

    private function displayPageFooter() {
        ?>
        </body>
        </html>
        <?php
    }
}

// Adatbázis kapcsolat
$dbConnection = new Database("localhost", "root", "", "allaskereso");

SessionManager::startSession();

// Állások oldalának megjelenítése
$jobListPage = new JobListPage($dbConnection);
$jobListPage->displayJobs();
?>
