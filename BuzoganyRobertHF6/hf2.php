s
<!DOCTYPE html>
<html>
<head>
    <title>Regisztrációs űrlap</title>
</head>
<body>
    <h2>Regisztrációs űrlap</h2>
    <form method="post" action="regisztracio_feldolgozas.php">
        <label for="nev">Név:</label>
        <input type="text" name="nev" required><br><br>

        <label for="email">E-mail cím:</label>
        <input type="email" name="email" required><br><br>

        <label for="jelszo">Jelszó:</label>
        <input type="password" name="jelszo" required><br><br>

        <label for="jelszo_megerosites">Jelszó megerősítése:</label>
        <input type="password" name="jelszo_megerosites" required><br><br>

        <label for="szuletesi_datum">Születési dátum:</label>
        <input type="date" name="szuletesi_datum"><br><br>

        <label>Nem:</label>
        <input type="radio" name="nem" value="Ferfi">Férfi
        <input type="radio" name="nem" value="No">Nő
        <input type="radio" name="nem" value="Egyeb">Egyéb<br><br>

        <label>Érdeklődési területek:</label>
        <input type="checkbox" name="erdeklodes[]" value="Sport">Sport
        <input type="checkbox" name="erdeklodes[]" value="Muveszet">Művészet
        <input type="checkbox" name="erdeklodes[]" value="Tudomany">Tudomány<br><br>

        <label for="orszag">Ország:</label>
        <select name="orszag">
            <option value="Magyarorszag">Magyarország</option>
            <option value="Romania">Románia</option>
            <option value="Szlovakia">Szlovákia</option>
            <option value="Szerbia">Szerbia</option>
        </select><br><br>

        <input type="submit" name="submit" value="Regisztráció">
    </form>
</body>
</html>
