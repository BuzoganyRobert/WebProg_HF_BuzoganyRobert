<?php
if(isset($_POST["submit"])){
    $errors=array();
    if(empty($_POST["firstName"])){
        $errors[]="Keresztnév  kitöltése kötelező";
    }
    if(empty($_POST["lastName"]))
    {
        $errors[]="Vezeték kitöltése kötelező";
    }
    if (empty($_POST["email"]) || filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
        $errors[]="Rendes email cim megadása kötelező";
    }
    if(empty($_POST["attend"])){
        $errors[]="Legalább egy eventet kikel választani";
    }
    if(empty($_FILES["abstract"]["name"])){
        $errors[]="Muszáj feltölteni egy absztraktot";

    }else{
        $file_extension=pathinfo($_FILES["abstract"]["name"],PATHINFO_EXTENSION);
        if($file_extension!=="pdf"){
            $errors[]="Csak pdf fáljt lehet az absztrakra feltölteni";
        }
        if($_FILES["abstract"]["size"]>3*1024*1024){
            $errors[]="Az absztrakt max 3 MB lehet";
        }
    }
    if(empty($_POST["terms"])){
        $errors[]="A feltételeket elkell fogadni";

    }

    if(count($errors)>0){
        echo "Az ürlap kitöltése  nem teljesen megfelelö: ";
        foreach ($errors as $error) {
            echo "<p>$error</p>";

        }
        
    }
}
if (isset($_POST["firstName"])){
    echo "<p>Keresztnev: ". htmlspecialchars($_POST["firstName"])."</p>";

}if (isset($_POST["lastName"])){
    echo "<p>Keresztnev: ". htmlspecialchars($_POST["lastName"])."</p>";

}if (isset($_POST["email"])){
    echo "<p>Keresztnev: ". htmlspecialchars($_POST["email"])."</p>";
}
if(isset($_POST["attend"])) {
    $events = $_POST['attend'];
    echo "<p> Esemenyeken reszt fog venni: </p>";
    echo "<ul>";
    foreach ($events as $event) {
        echo "<li>" . htmlspecialchars($event) . "</li>";
    }
    echo  "</ul>";
}
if(!empty($_FILES["abstract"]["name"])){
    echo "<p> Absztrakt neve: ". htmlspecialchars($_FILES["abstract"]["name"]). "</p>";

}



?>
<h3>Online conference registration</h3>

<form method="post" action="">
    <label for="fname"> First name:
        <input type="text" name="firstName">
    </label>
    <br><br>
    <label for="lname"> Last name:
        <input type="text" name="lastName">
    </label>
    <br><br>
    <label for="email"> E-mail:
        <input type="text" name="email">
    </label>
    <br><br>
    <label for="attend"> I will attend:<br>
        <input type="checkbox" name="attend[]" value="Event1">Event 1<br>
        <input type="checkbox" name="attend[]" value="Event2">Event2<br>
        <input type="checkbox" name="attend[]" value="Event3">Event2<br>
        <input type="checkbox" name="attend[]" value="Event4">Event3<br>
    </label>
    <br><br>
    <label for="tshirt"> What's your T-Shirt size?<br>
        <select name="tshirt">
            <option value="P">Please select</option>
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
        </select>
    </label>
    <br><br>
    <label for="abstract"> Upload your abstract<br>
        <input type="file" name="abstract"/>
    </label>
    <br><br>
    <label>
        <input type="checkbox" name="terms" value="accepted">
    </label>I agree to terms & conditions.<br>
    <br><br>
    <input type="submit" name="submit" value="Send registration"/>
</form>
