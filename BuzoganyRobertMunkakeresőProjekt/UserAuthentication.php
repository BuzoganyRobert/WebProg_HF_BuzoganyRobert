<?php
require_once "Database.php";



class UserAuthentication
{
    private $conn;

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
    }

    public function loginUser($email, $password)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Munkamenet indítása csak akkor, ha még nem aktív
        }

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();


            if (isset($user['Password']) && password_verify($password, $user['Password'])) {
                $_SESSION['user'] = $user;
                $_SESSION['userFullName'] = $user['FullName'];


                return true;
            } else {
                global $error_message_login;
                $error_message_login = "Hibás jelszó vagy felhasználónév";


                return false;
            }
        } else {
            global $error_message_login;
            $error_message_login = "Felhasználó nem található ezzel az e-mail címmel";


            return false;
        }
    }


    public function registerUser($email, $fullName, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $checkStmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            // Hibaüzenet beállítása
            $error_message = "Az e-mail cím már regisztrálva van";
            ErrorMessageHandler::displayErrorMessage($error_message);
            return false;
        } else {
            $insertStmt = $this->conn->prepare("INSERT INTO users (email, FullName, password) VALUES (?, ?, ?)");
            $insertStmt->bind_param("sss", $email, $fullName, $hashedPassword);

            if ($insertStmt->execute()) {
                return true; // Sikeres regisztráció
            } else {
                // Hibaüzenet beállítása
                $error_message = "Hiba történt a regisztráció során";
                ErrorMessageHandler::displayErrorMessage($error_message);
                return false; // Regisztrációs hiba
            }
        }
    }

    public function handleLogin()
    {

        global $error_message_login;

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login_email']) && isset($_POST['login_pswd'])) {
            $email = $_POST['login_email'];
            $password = $_POST['login_pswd'];



            if (isset($_SESSION['user'])) {
                // A felhasználó már be van jelentkezve, irányítsd át a felhasználót az adott oldalra
                header("Location: SessionManager.php");
                exit();
            }
            $loginResult = $this->loginUser($email, $password);
            if ($loginResult) {
                // Sikeres bejelentkezés esetén átirányítás
                header("Location: SessionManager.php"); // Irányítsd át a felhasználót egy üdvözlő oldalra
                exit();
            } else {
                // Ha a bejelentkezés sikertelen, a hibaüzenet már be van állítva a loginUser metódusban
            }
        }
    }



    public function handleSignup()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup_email']) && isset($_POST['signup_pswd']) && isset($_POST['signup_full_name'])) {
            $signup_email = $_POST['signup_email'];
            $signup_full_name = $_POST['signup_full_name'];
            $signup_password = $_POST['signup_pswd'];

            $signupResult = $this->registerUser($signup_email, $signup_full_name, $signup_password);
            global $error_message_signup;
            // Hibaüzenetek beállítása
            if (!$signupResult) {
                $error_message_signup = "Hiba történt a regisztráció során. Lehet, hogy az e-mail cím már regisztrálva van.";
            }
        }
    }
}

class ErrorMessageHandler
{
    public static function displayErrorMessage($errorMessage)
    {
        if (!empty($errorMessage)) {
            echo "<div class='error-message'>$errorMessage</div>";
        }
    }
}

// Adatbázis kapcsolat
$dbConnection = new Database("localhost", "root", "", "allaskereso");

// Felhasználókezelő példány létrehozása
$userAuthentication = new UserAuthentication($dbConnection);



$error_message_login = "";
$error_message_signup = "";

// Bejelentkezési és regisztrációs műveletek kezelése
$userAuthentication->handleLogin();
$userAuthentication->handleSignup();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="UserAuthenticationCSS.css">
    <title>Bejelentkezés</title>
</head>
<body>

<div class="main">
    <input type="checkbox" id="chk" aria-hidden="true">

    <div class="signup">
        <form method="POST" action="">
            <label for="chk" aria-hidden="true">Sign up</label>
            <input type="text" name="signup_full_name" placeholder="Full Name" required="">
            <input type="email" name="signup_email" placeholder="Email" required="">
            <input type="password" name="signup_pswd" placeholder="Password" required="">
            <button>Sign up</button>
        </form>
        <?php
        // Hibaüzenet megjelenítése, ha van
        ErrorMessageHandler::displayErrorMessage($error_message_signup);
        ?>
    </div>

    <script>
        // Az üzenet eltávolításához 5 másodperc után
        setTimeout(function() {
            var errorMessageSignup = document.getElementById('error-message-signup');
            if (errorMessageSignup) {
                errorMessageSignup.style.display = 'none';
            }
        }, 5000); // 5000 milliszekundum = 5 másodperc
    </script>

    <div class="login">
        <form method="POST" action="">
            <label for="chk" aria-hidden="true">Login</label>
            <input type="email" name="login_email" placeholder="Email" required="">
            <input type="password" name="login_pswd" placeholder="Password" required="">
            <button>Login</button>
        </form>
        <?php
        // Hibaüzenet megjelenítése, ha van
        ErrorMessageHandler::displayErrorMessage($error_message_login);
        ?>
    </div>
</div>

</body>
</html>