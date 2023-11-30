<?php
include "connection_to_db.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("location: fel1Login.php");
    exit();
} else {
    if (isset($conn)) {
        if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $username = $_SESSION['username'];

        // Módosított lekérdezés
        $sql = "DELETE FROM hallgatok WHERE id = ? AND username = ?";

        $deleteStatement = mysqli_prepare($conn, $sql);

        if ($deleteStatement) {
            mysqli_stmt_bind_param($deleteStatement, "is", $id, $username);

            if (mysqli_stmt_execute($deleteStatement)) {
                header("location: fel1listazas.php");
                exit();
            } else {
                echo "Eror: " . mysqli_stmt_error($deleteStatement);
            }

            mysqli_stmt_close($deleteStatement);
        } else {
            echo "Hiba az előkészített utasítás létrehozásakor: " . mysqli_error($conn);
        }
    }



    } else {
        echo "nem elerheto a connt";
    }
}


?>
