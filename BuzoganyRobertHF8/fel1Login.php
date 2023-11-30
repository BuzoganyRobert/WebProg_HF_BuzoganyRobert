<?php
include "connection_to_db.php";
session_start();

// Ellenőrzés, hogy van-e bejelentkezett felhasználó
if (isset($_SESSION['username'])) {

    $referer = isset($_SESSION['referer']) ? $_SESSION['referer'] : 'fel1listazas.php';
    header("Location: $referer");
    exit();
}

// Bejelentkezési adatok ellenőrzése
if (isset($conn) && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // Sikeres bejelentkezés
            if ($password == $row['password']) {
                $_SESSION['username'] = $username;

                // Visszatérés az előző oldalra (referer), ha van tárolt érték
                $referer = isset($_SESSION['referer']) ? $_SESSION['referer'] : 'fel1listazas.php';
                header("Location: $referer");
                exit();
            } else {
                echo "Hibás jelszó. Debug: " . $row['password'];
            }
        } else {
            echo "Hibás felhasználónév.";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Hiba az előkészített utasítás létrehozásakor: " . mysqli_error($conn);
    }
}
?>

<html>
<head>
    <title>Bejelentkezés</title>
</head>
<body>
<h1>Bejelentkezés</h1>
<form method="post" action="">
    <label for="username">Felhasználónév:</label>
    <input type="text" name="username" required><br>
    <label for="password">Jelszó:</label>
    <input type="password" name="password" required><br>
    <input type="submit" name="login" value="Bejelentkezés">
</form>
</body>
</html>
