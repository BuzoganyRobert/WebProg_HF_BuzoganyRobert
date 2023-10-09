<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 

    function changer($tomb,$mod){
        $eredmeny=array();

        foreach($tomb as $key =>$value){
            if($mod=="kisbetu"){
                $eredmeny[$key]=strtolower($value);
            }elseif($mod=="nagybetu"){
                $eredmeny[$key]=strtoupper($value);
            }
        }
        return $eredmeny;
    }
$szinek = array('A' => 'Kek', 'B' => 'Zold', 'c' => 'Piros');
$kisbetus_changed=changer($szinek,"kisbetu");
$nagybetu_changed=changer($szinek,"nagybetu");

print_r($kisbetus_changed);
echo "<br>";
print_r($nagybetu_changed);
echo "<br>";



function changer_to_lowercase($value){
    return strtolower($value);
}

function changer_to_uppercase($value){
    return strtoupper($value); 
}

$lowercase_szinek=array_map("changer_to_lowercase",$szinek);
$uppercase_szinek=array_map("changer_to_uppercase",$szinek);
echo"array_map-al<br>";
print_r($lowercase_szinek);
echo "<br>";
print_r($uppercase_szinek);



    ?>

</body>
</html>