<?php
// KUN OPPILAS KLIKKAA MUOKKAA PAINIKETTA OPINNOISSAAN
session_start();                                        // Aloitetaan sessio
include_once "connect.php";                             // Sisällytetään tiedostot
include_once "loginheader.php";
if (!$conn) {                                           // Tarkistetaan onko tietokantayhteys
    die('Tietokantavirhe' . mysqli_error($conn));
} else {
$id = $_GET['id'];                                      // Laitetaan klikatun opinnon id muuttujaan
$sql = "SELECT * FROM studies WHERE id = $id";          // Tietokantahaku, etsitään studies taulusta opinnon id
        $run = $conn -> query($sql);
        if($run -> num_rows > 0) {
            while ($row = $run -> fetch_assoc()) {      // Laitetaan löydetyn opinnon tiedot muuttujiin
                $opintoaine = $row['opintoaine'];
                $tehtava = $row['tehtava'];
                $vaihe = $row['vaihe'];
                $opettajaid = $_SESSION['User']['id'];
            }          
            }           
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muokkaa opintoja</title>
</head>
<body>
<form action="" method="post">          <!-- Luodaan form johon käyttäjä voi syöttää tietoja. Opintoaine, tehtävä ja vaihe -->
    <label>Opintoaine</label>
    <input type="text" name="opintoaine" value="<?php echo $opintoaine ?>">
    <br><br>
    <label>Tehtävä</label>
    <input type="text" name="tehtava" value="<?php echo $tehtava ?>">
    <select name="vaihe">
    <option value="Aloittamatta">Aloittamatta</option>
    <option value="Kesken">Kesken</option>
    <option value="Tarvitsenapua">Tarvitsen apua</option>
    <option value="Valmis">Valmis</option>
    </select>
    <input type="submit" name="update" value="Päivitä opinnot">
</form>
</body>
</html>

<?php
if (isset($_POST['update'])) {                         // Jos "Päivitä opinnot" painiketta on klikattu niin...
    $opintoaine = $_POST['opintoaine'];                // Laitetaan käyttäjän syöttämät tiedot muuttujiin
    $tehtava = $_POST['tehtava'];
    $vaihe = $_POST['vaihe'];
   
    $sql = "UPDATE studies set opintoaine='$opintoaine', tehtava='$tehtava', vaihe='$vaihe', date=now(), muokkaaja='$opettajaid' where id = $id";   // Päivitetään käyttäjän syöttämät opinnot tietokantaan, myös päivämäärä ja muokkaajan nimi
    if (mysqli_query($conn, $sql)) {                  // Jos tietokantaan syöttö onnistuu niin...
        header("location: teacher_home.php");         // Palauta takaisin oppilaan etusivulle
    } else {
        echo mysqli_error($conn);                     // Jos ei onnistu niin tulostaa virheilmoituksen
    }
}

?>