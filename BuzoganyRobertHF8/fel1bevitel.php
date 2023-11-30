<?php
include 'connection_to_db.php';
if(!isset($_SESSION['username'])){
    header("location: fel1Login.php");
    exit();

}else{
    if (isset($conn)) {
        if (isset($_POST['submit'])) {
            $nev = $_POST['nev'];
            $szak = $_POST['szak'];
            $atlag = $_POST['atlag'];

            // Adatkötés használata
            $bevitel = "INSERT INTO hallgatok (nev, szak, atlag) VALUES (?, ?, ?)";
            $bevitelStatement = mysqli_prepare($conn, $bevitel);

            if ($bevitelStatement) {
                mysqli_stmt_bind_param($bevitelStatement,"ssd", $nev, $szak, $atlag);

                if (mysqli_stmt_execute($bevitelStatement)) {
                    echo "Sikereseen beadtuk az adatokat";
                } else {
                    echo "Adatokat nem tudtuk beadni";
                }

                mysqli_stmt_close($bevitelStatement);
            } else {
                echo "Hiba az előkészített utasítás létrehozásakor";
            }
        }

    mysqli_close($conn);
} else {
        echo "Nem elérhető a conn változó";
    }

}

i

?>

<html>
<head>
    <title>Hallgato bevitele</title>
</head>
<body>
<h1>Hallgato felvetele</h1>
<form method="post" action="">
    <label for="nev">Nev: </label>
    <input type="text" name="nev" id="nev" required><br><br>

    <label for="szak">Szak: </label>
    <input type="text" name="szak" id="szak" required><br><br>

    <label for="atlag">Atlag: </label>
    <input type="number" name="atlag" id="atlag" required><br><br>

    <input type="submit" name="submit" value="Bevitel">
</form>
</body>
</html>
