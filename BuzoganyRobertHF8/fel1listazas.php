<?php
include 'connection_to_db.php';
session_start();

// Ellenőrzés, hogy van-e bejelentkezett felhasználó
if (!isset($_SESSION['username'])) {
    // Ha nincs, akkor vissza a bejelentkező oldalra
    $_SESSION['referer'] = 'fel1listazas.php';
    header("location: fel1Login.php");
    exit();
} else {
    if (isset($conn)) {
        $sql = "SELECT * FROM hallgatok";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            echo "<table border='1'>
            <tr>
            <th>Nev</th>
            <th>Szak</th>
            <th>Atlag</th>
            <th>ID</th>
            <th>Update</th>
            <th>Delete</th>
            </tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                $nev = $row["nev"];
                $szak = $row["szak"];
                $atlag = $row["atlag"];
                $id = $row["id"];

                echo "<tr>
                <td>$nev</td>
                <td>$szak</td>
                <td>$atlag</td>
                <td>$id</td>
                <td><a href='fel1update.php?id=" . $row['id'] . "'>Update</a></td>
                <td><a href='fel1delete.php?id=" . $row['id'] . "'>Delete</a></td>
                </tr>";
            }

            echo "</table>";
        } else {
            echo "Nincsen talalat";
        }

        mysqli_close($conn);
    } else {
        echo "Nem elérhető a connt";
    }
}
?>
