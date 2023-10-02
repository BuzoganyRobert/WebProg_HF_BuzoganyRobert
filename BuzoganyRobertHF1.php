<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php

   


    
$tomb=[5,'5',12.3,'16.7','five','true',0xDECAFBAD,'10e200'];
foreach($tomb as $value){
    if(is_numeric($value) ){
        echo"$value:Igen <br>";}
        else {
            echo "$value:Nem <br>";
    }
}

$sec=4334;
if(gettype($sec)=="integer"){
    echo'A megadott szám átalakitva:'.$sec/3600;

}else{
    echo "Hibás érték!<br>";}

//Valtozo szamok
$elso_szam=5;
$masodik_szam=10;

//Osszeadas
$osszeadas=$elso_szam+$masodik_szam;
echo "<br>Osszeadas: {$elso_szam}+{$masodik_szam}=$osszeadas<br>";

//Kivonas
$kivon=$elso_szam-$masodik_szam;

echo"Kivonas:{$elso_szam}-{$masodik_szam}=$kivon<br>";

//Szorzas
$szorzas=$elso_szam*$masodik_szam;
echo"Szorzas: {$elso_szam}*{$masodik_szam}=$szorzas <br>";

//Osztas

if($masodik_szam!=0){
    $osztas=$elso_szam/$masodik_szam;
}else{
    echo"Nullával nem osztunk";
}

//Hatvany
$hatvany=pow($elso_szam,$masodik_szam);
echo"Hatvany: {$elso_szam}^{$masodik_szam}=$hatvany<br>";




?>
   <table width="200px" border="1px" cellspacing="0px">
        <?php
        echo"3x3 sakktabla";
        $value = 0;
        $col = 0;
  
        while($col < 3) {
            $row = 0;
            echo "<tr>";
            $value = $col;
          
            while($row < 3) {
                if($value%2 == 0) {
                    echo 
"<td height=40px width=20px bgcolor=black></td>";
                    $value++;
                }
                else {
                    echo 
"<td height=40px width=20px bgcolor=white></td>";
                    $value++;
                }
                $row++;
            }
            echo "</tr>";
            $col++;
        }
        ?>


</table>
<?php
 $szam1=6;
 $szam2=8;
 $muvjel="/";
 switch($muvjel){
    case'+':
        $erdm=$szam1+$szam2;
        break;
    case'-':
        $erdm=$szam1-$szam2;
        break;
    case'*':
        $erdm=$szam1*$szam2;
        break;
    case'/':
        if($szam2!=0){
            $erdm=$szam1-$szam2;
        }else{
            echo "Nem lehet nullaval osztani";
            exit;
        }
            
        break;
        default:
        echo "Nem jo muvelet jelet adott meg";
        exit;
 }
 echo "Eredmeny:{$szam1} {$muvjel} {$szam2}={$erdm}<br> ";

 $evszak=12;
 if($evszak>=1 && $evszak<3 || $evszak==12){
    echo "Teli honap <br>";
 }
 elseif ($evszak >2 && $evszak<6){
    echo "Tavaszi honap <br>";
 
 }elseif($evszak>5 && $evszak>9){
    echo "Nyari honap <br>";

 }elseif($evszak>8 && $evszak<12){
    echo "Oszi honap <br>";
 }else{
    echo "Ez hibas szam <br>";

    
 }
 switch($evszak){
    case'1'||'2'||'12':
        echo"Teli honap <br>";
        break;
    case '3'||'4'||'5':
        echo "Tavaszi honap <br>";
        break;
    case '6'||'7'||'8':
        echo "Nyari honap <br>";
        break;
    case '9'||'10'||'11':
        break;
    default:
    echo "Nem jo szamot adott meg <br>";
    exit;

 }  

 
 


?>
    
</body>

</html>

