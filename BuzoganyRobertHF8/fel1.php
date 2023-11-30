<?php
include "connection_to_db.php";

if (isset($conn)) {
    // Tábla létrehozása
    $hallgatokTable = "CREATE TABLE IF NOT EXISTS hallgatok (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nev VARCHAR(255) NOT NULL,
        szak VARCHAR(255),
        atlag DOUBLE
    )";
    $usersTable = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL
)";
    $users_add="INSERT INTO users (username, password) VALUES
    ('user1', 'password1'),
    ('user2', 'password2'),
    ('user3', 'password3')";


    if (mysqli_query($conn, $hallgatokTable)) {
        echo "A hallgato tabla letrejott <br>";
    } else {
        echo "A hallgato tabla nem jott letre <br>" . mysqli_error($conn);
    }


    $insertQuery = "INSERT INTO hallgatok (nev, szak, atlag) VALUES (?, ?, ?)";
    $insertStatement = mysqli_prepare($conn, $insertQuery);


    if ($insertStatement) {

        $adatok = array(
            array('Jani', 'Info', 8.5),
            array('Anna', 'Matek', 6.8),
            array('Huni', 'Java', 4.49)
        );

        foreach ($adatok as $adat) {
            list($nev, $szak, $atlag) = $adat;


            $checkByName = "SELECT id FROM hallgatok WHERE nev = ?";
            $checkByNameStatement = mysqli_prepare($conn, $checkByName);

            if ($checkByNameStatement) {
                mysqli_stmt_bind_param($checkByNameStatement, "s", $nev);
                mysqli_stmt_execute($checkByNameStatement);
                mysqli_stmt_store_result($checkByNameStatement);


                if (mysqli_stmt_num_rows($checkByNameStatement) > 0) {
                    $deleteQuery = "DELETE FROM hallgatok";
                    mysqli_query($conn, $deleteQuery);
                    echo "Nem adtuk hozza ot mert mar benen van: ".$nev."<br>";
                }

                mysqli_stmt_close($checkByNameStatement);
            } else {
                echo "Hiba az ellenőrző utasítás létrehozásakor: " . mysqli_error($conn);
            }

            mysqli_stmt_bind_param($insertStatement, "ssd", $nev, $szak, $atlag);


            if (mysqli_stmt_execute($insertStatement)) {
                echo "Sikeresen beadtuk az adatokat: $nev<br>";
            } else {
                echo "Adatokat nem tudtuk beadni: " . mysqli_stmt_error($insertStatement) . "<br>";
            }
        }

        // Az előkészített utasítás lezárása
        mysqli_stmt_close($insertStatement);
    } else {
        echo "Hiba az előkészített utasítás létrehozásakor: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Nem elérhető a conn változó";
}
?>
