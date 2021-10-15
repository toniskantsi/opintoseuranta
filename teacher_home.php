<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap/bootstrap.css">
    <title>Document</title>
</head>
<body>
<table style="width: 80%">              <!--HTML taulu alkaa tästä-->
    <tr>
        <th>Nimi</th>                   <!--HTML taulun kaikki otsikot-->
        <th>Opintoaine</th>
        <th>Tehtävä</th>
        <th>Vaihe</th>
        <th>Toiminnot</th>
        <th>Viimeksi muokattu</th>
    </tr>
</body>
</html>
<?php
ob_start();                       // Estää header errorin
session_start();                  // Käynnistetään sessio

include_once "functions.inc.php";           //liitetään haluttuja tiedostoja 
include_once "connect.php";


if(isset($_SESSION['User'])) {
    
    include_once "loginheader.php";                 // Jos session user on käytössä, liitetään mukaan loginheader.php joka on kirjautuneen opettajan valikko
    if ($_SESSION['User']['usertype'] == 0) {       // Jos User sessionin käyttäjä on 0, eli opettaja niin tee seuraavaa..
      
    }else {
        header("location:index.php");                    // Jos sessio ei ole käynnissä, eikä usertype = 0, ohjataan käyttäjä takaisin etusivulle.
    }
$opettajaid = $_SESSION['User']['id'];                  // Laitetaan käynnissä oleva sessio muuttujaan 
$sql2 = "SELECT * FROM mystudents WHERE teacher_id = $opettajaid";
$result = mysqli_query($conn, $sql2);                   // Ajetaan tietokantahaku
                      
while ($row = mysqli_fetch_assoc($result)){             // Laitetaan tulokset $row nimiseen associative arrayhin.
    
$seurattavatoppilaat = $row['student_id'];              // Laitetaan mystudents taulusta kohta student_id muuttujaan 
    $sql = "SELECT * FROM users INNER JOIN studies ON users.id = studies.student_id WHERE student_id = '$seurattavatoppilaat'";     //Yhdistetään tietoja users ja studies taulusta 
    $run = $conn -> query($sql);
    if($run -> num_rows > 0) {                                                  // Jos löytyy yli 0 riviä tietokannasta laitetaan tiedot associative arrayhin $row
        while ($row = $run -> fetch_assoc()) {
            $id = $row['id'];                                                   // Laitetaan studies taulun ID kohta $id muuttujaan 


?>  
<tr>
<td><?php echo ucfirst($row['firstname']) ." ". ucfirst($row['lastname']);?></td>       <!--Tulostetaan tietokannasta saatuja tietoja $row arrayn avulla -->
<td><?php echo $row['opintoaine']?></td>
<td><?php echo $row['tehtava']?></td>
<td class="vaihe"><?php if ($row['vaihe'] == 'Aloittamatta') {
    echo "<div id='aloittamatta'>Aloittamatta</div>";
       
    }
    else if ($row['vaihe'] == 'Kesken') {
        echo "<div id='kesken'>Kesken</div>";
    }
    else if ($row['vaihe'] == 'Tarvitsenapua') {
        echo "<div id='tarvitsenapua'>Tarvitsen apua</div>";
    }
    else if ($row['vaihe'] == 'Valmis') {
        echo "<div id='valmis'>Valmis</div>";
    }
     ?></td>
     <td>
              <a href='edit1.php?id=<?php echo $id; ?>'>Muokkaa</a>                         <!--Tästä päästään muokkaamaan opintoja-->
              <a href='delete1.php?id=<?php echo $id; ?>' onclick="return confirm('Haluatko varmasti poistaa rivin?')">Poista</a></td>
              <td>
<?php 
       $date = $row['date'];
       date_default_timezone_set("Europe/Helsinki");
       echo substr($date,8,2);
       echo ".";
       echo substr($date,5,2);
       echo ".";
       echo substr($date,0,4);
       echo " ";
       
    $muokkaaja = $row['muokkaaja'];
       $sqlz = "SELECT * FROM users INNER JOIN studies ON users.id = studies.muokkaaja WHERE muokkaaja = '$muokkaaja'";         // Haetaan tietoa sekä users että studies tauluista yhdistettynä
    $result3 = mysqli_query($conn, $sqlz);                                  // Ajetaan SQL kysely

    $resultCheck2 = mysqli_num_rows($result3);
    if ($resultCheck2 > 0) {                                    // Jos tietokantahausta löytyy yli 0 tulosta
        if ($tulos = mysqli_fetch_assoc($result3)) {                // Laitetaan tulokset $tulos assosiative arrayhin.
            $muokkaajafname = $tulos['firstname'];
            $muokkaajalname = $tulos['lastname'];
            echo ucfirst($muokkaajafname) . " " . ucfirst($muokkaajalname);
        }
    }

        
?>
    </td>
            </tr>

   
<?php
}}}}

$sqllause = "SELECT * FROM mystudents WHERE teacher_id = $opettajaid";          // Valitaan kaikki mystudents taulusta jossa teacher_id täsmää sisäänkirjautuneeseen sessioon

$resultlause = mysqli_query($conn, $sqllause);                                  // SQL ajo

$resultcheck5 = mysqli_num_rows($resultlause);              

if ($resultcheck5 < 1) {                                                    // Jos tuloksia löytyy alle 1, tee seuraavaa..

    echo '                                                                  



    <div class="searchstudent"><h4><span class="material-icons">
 
    </span> Et seuraa vielä ketään! Hae ensimmäinen opiskelija</h4>
 
    <form action="" method="post">
 
    <input type="text" name="studentname" minlength="3" placeholder="Matti Meikäläinen" required>
 
    <input type="submit" value="Hae opiskelijaa">
 
    </form></div>';

} else {
    search_student();                   // Jos tuloksia on 1 tai enemmän, ajetaan search_student funktio
}
echo '<div class="searchstudent">';

if (isset($_POST['id_student'])) {          // Jos on painettu "Seuraa" painiketta ajetaan funktio mystudents
    
    mystudents();

    header("location:teacher_home.php?seurattu");               // Kun funktio on ajettu, ohjataan käyttäjä takaisin etusivulle ?seurattu viestin kera. 

    
    
  


  
}
if (isset($_POST['delete_student'])) {              // JOs on painetta "lopeta seuraaminen" painiketta niin ajetaan deletestudent funktio.

    deletestudent();

    header("location:teacher_home.php?seurantapoistettu");          // Ohjataan etusivulle ?seurantapoistettu viestin kera
}

            // search_student();

            if (isset($_POST['studentname'])) {                 // Jos on painettu hae opiskelija painiketta, ajetaan search funktio
                search();
            }

            if (isset($_GET['id'])) {                           // JOs ID löytyy, näytetään taulussa oppilaan nimi
                show_student();
            
           
            }
            echo '</div>';  
?>

<?php

if(isset($_GET['seurattu'])) {      // Tässä otetaan vastaan GETillä urlista saadut viestit. Viestit tulostetaan käyttäjälle siistillä CSSällä tehdyllä tekstillä.
$seurattu=$_GET['seurattu'];
$seurattu="Oppilas lisätty seurantaan!";
?>

<div class="alert alert-success text-center"><?php echo $seurattu?></div>

<?php

}

?>

<?php

    if(isset($_GET['seurantapoistettu'])) {     // Jos GET metodilla saadaan vastaan tieto että oppilas on painettu pois seurannasta niin...
    $seurantapoistettu=$_GET['seurantapoistettu'];
    $seurantapoistettu="Oppilas poistettu seurannasta!";    // Tulostetaan ilmoitus

    ?>

    <div class="alert alert-warning text-center"><?php echo $seurantapoistettu?></div>

<?php

}

if (isset($_GET['id'])) {           // Jos oppilaan nimeä on klikattu niin...
    show_student(); }               // Ajetaan funktio
?>

<?php

    if(isset($_GET['notfound'])) {      // Jos GET metodilla saadaan vastaan tieto että oppilaita ei löydy niin...
    $notfound=$_GET['notfound'];
    $notfound="Haulla ei löytynyt yhtään opiskelijaa";  // Tulostetaan ilmoitus

    ?>

    <div class="alert alert-warning text-center"><?php echo $notfound?></div>

    <?php

    }
    ob_end_flush();
 ?>







   