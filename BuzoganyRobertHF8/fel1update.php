<?php

include 'connection_to_db.php';
include 'backTo.php';
$row=array();
session_start();
if(!isset($_SESSION['username'])){
    header("location: fel1Login.php");
    exit();
}else{
    if (isset($conn)) {
        if (isset($_POST['update'])) {

            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $nev = isset($_POST['nev']) ? $_POST['nev'] : null;
            $szak = isset($_POST['szak']) ? $_POST['szak'] : null;
            $atlag = isset($_POST['atlag']) ? $_POST['atlag'] : null;

            if ($id && $nev && $szak && $atlag !== null) {

                $update = "UPDATE hallgatok SET nev = ?, szak = ?, atlag = ? WHERE id = ?";
                $updateStatement = mysqli_prepare($conn, $update);

                if ($updateStatement) {

                    mysqli_stmt_bind_param($updateStatement, "ssdi", $nev, $szak, $atlag, $id);


                    if (mysqli_stmt_execute($updateStatement)) {
                        echo "Sikeresen frissített";
                        header("location: fel1listazas.php");
                        exit();
                    } else {
                        echo "Sikertelen frissítés: " . mysqli_stmt_error($updateStatement);
                    }


                    mysqli_stmt_close($updateStatement);
                } else {
                    echo "Hiba az előkészített utasítás létrehozásakor: " . mysqli_error($conn);
                }
            } else {
                echo "Hiányzó vagy érvénytelen adatok a frissítéshez.";
            }
        } else {

            $id = isset($_GET['id']) ? $_GET['id'] : null;

            if ($id !== null) {

                $select = "SELECT * FROM hallgatok WHERE id = ?";
                $selectStatement = mysqli_prepare($conn, $select);

                if ($selectStatement) {

                    mysqli_stmt_bind_param($selectStatement, "i", $id);


                    if (mysqli_stmt_execute($selectStatement)) {
                        $result = mysqli_stmt_get_result($selectStatement);
                        $row = mysqli_fetch_assoc($result);
                        mysqli_free_result($result);
                    } else {
                        echo "Hiba a lekérdezés végrehajtásakor: " . mysqli_stmt_error($selectStatement);
                    }


                    mysqli_stmt_close($selectStatement);
                } else {
                    echo "Hiba az előkészített utasítás létrehozásakor: " . mysqli_error($conn);
                }
            } else {
                echo "Hiányzó vagy érvénytelen 'id' érték a lekérdezéshez.";
            }
        }
} else {
    echo "Nem elérhető a conn változó";
}


}
?>

<head>
    <title>Hallgato frissítése</title>
</head>
<body>
<h1>Hallgato frissítése</h1>
<form method="post" action="">
    Nev:<input type="Text" name="nev" value="<?php echo isset($row["nev"]) ? $row["nev"] : ''; ?>"><br>
    Szak:<input type="Text" name="szak" value="<?php echo isset($row["szak"]) ? $row["szak"] : ''; ?>"><br>
    Atlag:<input type="Text" name="atlag" value="<?php echo isset($row["atlag"]) ? $row["atlag"] : ''; ?>"><br>
    <input type="hidden" name="id" value="<?php echo isset($row['id']) ? $row['id'] : ''; ?>">
    <input type="submit" name="update" value="Update">
</form>
</body>