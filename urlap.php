<?php
// Adatbázis kapcsolat létrehozása (például MySQL)
$servername = "localhost";
$username = "felhasznalonev";
$password = "jelszo";
$dbname = "adatbazis_neve";

$conn = new mysqli($servername, $username, $password, $dbname);

// Ellenőrizzük, hogy van-e kapcsolati hiba
if ($conn->connect_error) {
    die("Kapcsolati hiba: " . $conn->connect_error);
}

// Űrlap adatok feldolgozása
$nev = $_POST['nev'];
$szuletesi_ev = $_POST['szuletesi_ev'];
$email = $_POST['email'];
$telefonszam = $_POST['telefonszam'];
$munkahely_neve = $_POST['munkahely_neve'];
$munkahely_cime = $_POST['munkahely_cime'];
$munkakor = $_POST['munkakor'];

// Arckép feltöltése és útvonala meghatározása
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["arckep"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Ellenőrizzük, hogy a feltöltött fájl valóban egy kép-e
$check = getimagesize($_FILES["arckep"]["tmp_name"]);
if($check !== false) {
// A feltöltött fájl egy kép, folytatjuk a feltöltést
if (move_uploaded_file($_FILES["arckep"]["tmp_name"], $target_file)) {
// Az arckép sikeresen feltöltve
echo "Az arckép sikeresen feltöltve.";
} else {
// Hiba történt az arckép feltöltése közben
echo "Hiba történt az arckép feltöltése közben.";
}
} else {
// A feltöltött fájl nem kép
echo "Az arckép csak kép formátumban tölthető fel.";
}

// Adatok mentése az adatbázisba
$sql = "INSERT INTO jelentkezesek (nev, szuletesi_ev, email, telefonszam, munkahely_neve, munkahely_cime, munkakor, arckep) VALUES ('$nev', '$szuletesi_ev', '$email', '$telefonszam', '$munkahely_neve', '$munkahely_cime', '$munkakor', '$target_file')";

if ($conn->query($sql) === TRUE) {
echo "Jelentkezés sikeresen rögzítve.";
} else {
echo "Hiba történt a jelentkezés rögzítése közben: " . $conn->error;
}

// Adatbázis kapcsolat bezárása
$conn->close();

include('CAPTCHA.php');
?>

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Rendezvény Jelentkezési Űrlap</h1>
    <form action="jelentkezes_feldolgozas.php" method="post" enctype="multipart/form-data">
      <label for="nev">Név:</label>
      <input type="text" id="nev" name="nev" required><br>

      <label for="szuletesi_ev">Születési évszám:</label>
      <input type="number" id="szuletesi_ev" name="szuletesi_ev" required><br>

      <label for="email">E-mail cím:</label>
      <input type="email" id="email" name="email" required><br>

      <label for="telefonszam">Telefonszám:</label>
      <input type="tel" id="telefonszam" name="telefonszam" required><br>

      <label for="munkahely_neve">Munkahely neve:</label>
      <input type="text" id="munkahely_neve" name="munkahely_neve" required><br>

      <label for="munkahely_cime">Munkahely címe:</label>
      <input type="text" id="munkahely_cime" name="munkahely_cime" required><br>

      <label for="munkakor">Munkakör / Beosztás:</label>
      <input type="text" id="munkakor" name="munkakor" required><br>

      <label for="arckep">Arckép:</label>
      <input type="file" id="arckep" name="arckep" accept="image/*" required><br>

      <input type="submit" value="Jelentkezés">
    </form>
</body>
</html>