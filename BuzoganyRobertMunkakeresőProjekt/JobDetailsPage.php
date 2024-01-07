<?php
require_once "Database.php";


session_start();
class JobDetailsPage
{
    private $conn;
    private $companyName;
    private $employmentType;
    private $employmentHourType;
    private $jobDescription;
    private $applicationUrl;
    private $userFullName;



    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
        $this->userFullName = isset($_SESSION['userFullName']) ? $_SESSION['userFullName'] : '';

        

    }
    public function getUserFullName()
    {
        return $this->userFullName;
    }

    public function fetchJobDetails($jobId)
    {


        if (isset($this->conn)) {
            $stmt = $this->conn->prepare("SELECT * FROM employers WHERE id=?");
            $stmt->bind_param("i", $jobId);
            $stmt->execute();

            if ($stmt->error) {
                echo "Hiba a lekérdezés során: " . $stmt->error;
            } else {
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $this->companyName = $row['company_name'];
                    $this->employmentType = $row['employment_type'];
                    $this->employmentHourType = $row['employment_hour_type'];
                    $this->jobDescription = $row['job_description'];
                    $this->applicationUrl = $row['application_url'];
                    $this->userFullName = isset($_SESSION['user']['FullName']) ? $_SESSION['user']['FullName'] : '';
                } else {
                    echo "Nincs találat az adatbázisban ehhez az azonosítóhoz: $jobId";
                }
            }
        } else {
            echo "Hiba a kérés feldolgozásakor. Kérjük, ellenőrizze az id változó létezését.";
        }
    }

    public function displayJobDetail()
    {


        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="Learn_MoreCss.css">
            <title>Learn More</title>
        </head>
        <body>
        <nav class="nav-top">
            <a href='#'><?php echo $this->getUserFullName(); ?></a>
            <a href="SessionManager.php">Main</a>

        </nav>
        <section>
            <h1><?php echo $this->companyName; ?></h1>
            <h2>Available job</h2>
            <details>
                <summary>
                    <div>
                        <h3>
                            <strong>Description</strong>
                            <small>About the job</small>
                        </h3>
                    </div>
                </summary>
                <div>
                    <dl>
                        <div>
                            <dt>
                                <?php echo $this->jobDescription; ?>
                            </dt>
                        </div>
                    </dl>
                </div>
            </details>

            <details>
                <summary>
                    <div>
                        <h3>
                            <strong>Employment Type</strong>
                            <small>Position</small>
                        </h3>
                    </div>
                    <span>Hour Type: <?php echo $this->employmentHourType; ?> </span>
                </summary>
                <div>
                    <dl>
                        <dt> Type</dt>
                        <dd> <?php echo $this->employmentType; ?></dd>
                    </dl>
                </div>
            </details>

            <details>
                <summary>
                    <div>
                        <h3>
                            <strong>Application URL</strong>
                            <small>APPLY HERE</small>
                        </h3>
                    </div>
                </summary>
                <div>
                    <dl>
                        <dt> URL</dt>
                        <dd><a href="<?php echo $this->applicationUrl; ?>" target="_blank"><?php echo $this->applicationUrl; ?></a></dd>
                    </dl>
                </div>
            </details>
        </section>
        </body>
        </html>
        <?php
    }
}

// Adatbázis kapcsolat
$dbConnection = new Database("localhost", "root", "", "allaskereso");

// Az URL-ből kinyerjük az id-t
$jobId = isset($_GET["id"]) ? $_GET["id"] : null;

// Az oldal megjelenítése
$jobDetailsPage = new JobDetailsPage($dbConnection);
$jobDetailsPage->fetchJobDetails($jobId);
$jobDetailsPage->displayJobDetail();
?>
