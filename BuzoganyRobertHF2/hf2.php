<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $orszagok = array(
        "Magyarország" => "Budapest",
        "Románia" => "Bukarest",
        "Belgium" => "Brussels",
        "Austria" => "Vienna",
        "Poland" => "Warsaw"
    );
    foreach ($orszagok as $orszag => $varos) {
        echo "<p><span>$orszag</span> fővárosa <span style='color: red;'>$varos</span></p>";
    }
    ?>
</body>
</html>