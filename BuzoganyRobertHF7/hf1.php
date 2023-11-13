<?php


if(!isset($_SESSION['random_number'])){
    $random_number = rand(1, 10);
    setcookie('random_number', $random_number, time() + (864));
}else{
    $random_number = $_SESSION['random_number'];
}

if(isset($_POST["elkuldott"]))
{
   $userGuessedNumber=$_POST["talalgatas"];


    if($random_number>$userGuessedNumber)
    {
        $error_message = "Szamod kisebb mint a gondolt szam";
    }elseif ($userGuessedNumber<$random_number)
    {
        $error_message = "Szamod nagyobb mint a gondolt szam";
    }else
    {
        $error_message = "Talalt";
       setcookie('random_number', '', time() -3600);
    }

}

?>

<form method="POST" action="">
<input type="hidden" name="elkuldott" value="true">
Melyik számra gondoltam 1 és 10 között?
<input name="talalgatas" type="text">
<br>
<br>
<input type="submit" value="Elküld">
</form>
<?php
if(isset($error_message)){
    echo $error_message;
}

?>

