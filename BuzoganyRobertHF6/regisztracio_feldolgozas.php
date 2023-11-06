<?php
if(isset($_POST["submit"])) {
    $errors = [];


    if (empty($_POST["nev"])) {
        $errors[] = "Nincsen semmi a nevnel";

    }
    if (empty($_POST["email"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Ervenyes emailcimet adjon meg";
    }
    if (strlen($_POST["jelszo"]) < 8) {
        $errors[] = "Jelszo legalabb 8 karakteres kell legyen";
        if (!preg_match("/[A-Z]/", $_POST["jelszo"])) {
            $errors[] = "Nagy betut kell tartalmazon a jelszo";
            if (!preg_match("/[0-9]/", $_POST["jelszo"])) {
                $errors[] = "Szamot is kell tartalmazon a jelszo";
                if (!preg_match("/[!@#\$%^&*()_+{}:;<>,.?~[\]]/", $_POST["jelszo"])) {
                    $errors[] = "Specialis karaktert is kell tartalmazon";
                }
            }
        }
    }
    if ($_POST["jelszo"] !== $_POST["jelszo_megerosites"]) {
        $errors[] = "A jelszo es a jelszo megerosites ugyan az kell legyen";
    }
    if (count($errors) > 0) {
        echo "Az urlap kitoltese nem megfelelo:";
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
    if (isset($_POST["nev"])){
        echo "<p>Nev: ". htmlspecialchars($_POST["nev"])."</p>";
    }
    if (isset($_POST["email"])){
        echo "<p>Email: ". htmlspecialchars($_POST["email"])."</p>";
    }
    if (isset($_POST["szuletesi_datum"])){
        echo "<p>Szuletesi datum: ". htmlspecialchars($_POST["szuletesi_datum"])."</p>";
    }
    if (isset($_POST["nem"])){
        echo "<p>Nem: ". htmlspecialchars($_POST["nem"])."</p>";
    }
    if (isset($_POST["erdeklodes[]"])){
        echo "<p>Erdeklodes: ". htmlspecialchars($_POST["erdeklodes[]"])."</p>";
    }
}
?>