<?php
require_once "Database.php";


class JobListing{
    private $db;

    public function __construct($db){
        $this->db = $db;
        $this->startSession();


    }
    public function startSession(){
        if(session_status()==PHP_SESSION_NONE){
            session_start();
        }
    }

    public function addJob($db)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $company_name = $_POST["company_name"];
            $employment_type = $_POST["company_name"];
            $employment_hour_type = $_POST["employment_hour_type"];
            $job_description = $_POST["job_description"];
            $application_url = $_POST["application_url"];


            $stmt = $this->db->prepare("INSERT INTO employers (company_name, employment_type, employment_hour_type, job_description, application_url) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $company_name, $employment_type, $employment_hour_type, $job_description, $application_url);

            if ($stmt->execute()) {
                header("Location: SessionManager.php");
                exit();

            } else {
                echo "Hiba a munka hozzáadásával: " . $this->db->error;
            }
            $stmt->close();
        }
    }


}


$db = new Database("localhost", "root", "", "allaskereso");
$jobListing = new JobListing($db);

$jobListing->addJob($db)

?>


<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="JobListingCSSS.css">
    <title>Munka Hozzáadása</title>
</head>
<body>

<nav class="nav-top">
    <a href=''><?php echo isset($_SESSION['userFullName']) ? $_SESSION['userFullName'] : 'Vendég'; ?></a>
    <a href="SessionManager.php">Main</a>
</nav>


<script>
    function submitForm() {
        var form = document.getElementById('jobForm');
        if (form) {
            form.submit();
        } else {
            console.error('Az űrlap nem található.');
        }
    }
</script>

<form id="jobForm" action="JobListing.php" method="post">
    <div class="listing">
    <label for="company_name">Cég neve:</label><br>
    <input type="text" id="company_name" name="company_name" required><br>

    <label for="employment_type">Foglalkoztatás típusa:</label><br>
    <input type="text" id="employment_type" name="employment_type" required><br>

    <label for="employment_hour_type">Munkaidő típusa:</label><br>
    <input type="text" id="employment_hour_type" name="employment_hour_type" required><br>

    <label for="job_description">Munka leírása:</label><br>
    <textarea id="job_description" name="job_description" required></textarea><br>

    <label for="application_url">Jelentkezési URL:</label><br>
    <input type="text" id="application_url" name="application_url" required><br>
    <button type="button" onclick="submitForm()">Hozzáadás</button>
    </div>




</form>
</body>
</html>