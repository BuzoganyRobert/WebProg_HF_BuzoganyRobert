<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $napok = array(
        "HU" => array("H", "K", "Sze", "Cs", "P", "Szo", "V"),
        "EN" => array("M", "Tu", "W", "Th", "F", "Sa", "Su"),
        "DE" => array("Mo", "Di", "Mi", "Do", "F", "Sa", "So"),
    );

foreach($napok as $lang =>$days_list){
    echo "$lang: ";
    foreach($days_list as $index=>$day){
        if($index==1 || $index==3 || $index==5){
            echo "<strong>$day</strong>";
        }else{
            echo"$day ";
        }
        if($index <count($days_list)-1){
            echo ", ";
        }

    }
    echo "<br>";
}







?>
</body>
</html>