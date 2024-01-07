<?php
include "Database.php";
class JobDataFetcher
{
    private $conn;

    public function __construct($dbConnection){
        $this->conn = $dbConnection;
    }
    public function fectchJobData(){
        if (isset($this->conn)) {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://job-search-api1.p.rapidapi.com/v1/job-description-search?q=software%20engineer&page=1&country=us&city=Seattle",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "X-RapidAPI-Host: job-search-api1.p.rapidapi.com",
                    "X-RapidAPI-Key: 2807b073admsh762122872445616p1e9c15jsnc77e60918b51"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($err) {
                echo "cURL Error #: " . $err;
            } else {
                $jobsData = json_decode($response, true);

                if (json_last_error() === JSON_ERROR_NONE) {
                    if (isset($jobsData['jobs']) && is_array($jobsData['jobs'])) {
                        foreach ($jobsData['jobs'] as $job) {
                            $company_name = $job['company_name'];
                            $employment_type = $job['employment_type'];
                            $employment_hour_type = $job['employment_hour_type'];
                            $plain_text_description = $job['plain_text_description'];
                            $application_url = $job['application_url'];

                            // Az adatbázisba történő beszúrás előkészítése
                            $stmt = $this->conn->prepare("INSERT IGNORE INTO employers (company_name, employment_type, employment_hour_type, job_description, application_url) VALUES (?, ?, ?, ?, ?)");
                            $stmt->bind_param("sssss", $company_name, $employment_type, $employment_hour_type, $plain_text_description, $application_url);

                            // Az utasítás végrehajtása
                            $stmt->execute();

                            // Az utasítás lezárása
                            $stmt->close();
                        }

                        echo "Állások sikeresen lekérdezve és elmentve az adatbázisban.";
                    } else {
                        echo "Hiba a kérés feldolgozásakor. HTTP válaszkód: " . $httpCode;
                    }
                } else {
                    echo "Hiba a JSON dekódolás során: " . json_last_error_msg();
                }
            }
        }

    }

}
$dbConnection = new Database("localhost", "root", "", "allaskereso");
$jobDataFetcher=new JobDataFetcher($dbConnection);
$jobDataFetcher->fectchJobData();
$dbConnection->closeConnection();
