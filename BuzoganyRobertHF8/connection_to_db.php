<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'egyetem';

// Create connection
global $conn;

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Kapcsolodasi hiba: " . mysqli_error());
}

