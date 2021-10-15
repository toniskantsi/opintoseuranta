<?php
ob_start();                                         // Estää header errorin
session_start();                                    // Aloitetaan sessio

include_once "connect.php";                         // Liitetään yhteys tietokantaan
$sessio = $_SESSION['User'];                        // Laitetaan sessio muuttujaan
$sql = "SELECT * FROM users WHERE id = $sessio";                        // Valitaan kaikki users taulusta jotka täsmäävät tämän session ID:n kanssa

$result = mysqli_query($conn, $sql);                                    // SQL kysely
$resultCheck = mysqli_num_rows($result);                                // Tarkistetaan montako riviä palautuu kyselystä

if ($resultCheck > 0) {                                                 // Jos tuloksia on yli 0, tee seuraava..
    while ($row = mysqli_fetch_assoc($result)) {                        // Laitetaan tulokset assosiative arrayhin nimeltä $row
        $usertype = $row['usertype'];                                   // Laitetaan tietokannasta saatuja tietoja usertype, firstname, lastname omiin muuttujiinsa
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
    }
}

if(isset($_SESSION['User'])) {                                  // Jos sessio on käynnissä tehdään seuraavaa...
    if ( $usertype == 1) {                                      // Jos sessiossa oleva käyttäjätyyppi on 1, eli oppilas..
        include_once "studentheader.php";                          // Lisätään kirjautuneen oppilaan header

    }
    
    }
        
?>

<!DOCTYPE html>                                             <!--HTML koodi alkaa tästä-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">                    <!--Liitetään CSS tiedosto-->
    <link rel="stylesheet" href="bootstrap/bootstrap.css">          <!--Liitetään bootstrap-->
</head>
<body>
<div class="opinnot">
<h2>Minun opintoni</h2>
<form action="" method="post">                      <!--Tässä alkaa HTML formi johon opiskelija lisää opinnon, tehtävän sekä vaiheen-->
    <label>Opintoaine</label>
    <input type="text" name="opintoaine" placeholder="Opintoaine" required maxlength="20">
    <br><br>
    <label>Tehtävä</label>
    <input type="text" name="tehtava" placeholder="Tehtävä/Kurssi" required maxlength="20">
    <label>Vaihe</label>
    <select name="vaihe">                               <!--Drop down menu opinnon vaiheen valitsemiselle-->
    <option value="Aloittamatta">Aloittamatta</option>
    <option value="Kesken">Kesken</option>
    <option value="Tarvitsenapua">Tarvitsen apua</option>
    <option value="Valmis">Valmis</option>
    </select>
    <input type="submit" name="tallenna" value="Kirjaa opinnot">        <!--Kun tätä nappia painaa, oppilaan kirjoittamat opinnot tallentuvat tietokantaan-->
</form>

<hr>

<h3>Opinnot</h3>
<table style="width: 80%">
    <tr>
        <th>Opintoaine</th>
        <th>Tehtävä</th>
        <th>Vaihe</th>
        <th>Toiminnot</th>
        <th>Viimeksi muokattu</th>
    </tr>
<?php
        
        $sql = "SELECT * FROM studies WHERE student_id = $sessio";              // Valitsee kaikki opinnot jossa student_id täsmää $sessio:n $row['id'] kanssa users taulusta
        $run = $conn -> query($sql);
        if($run -> num_rows > 0) {                                                  // Jos löytyy yli 0 riviä tietokannasta laitetaan tiedot associative arrayhin $row
            while ($row = $run -> fetch_assoc()) {
                $id = $row['id'];                                                   // Tietokannan studies taulun ID kohta laitetaan muuttujaan $id
          
?> 
    <tr>
        <td><?php echo $row['opintoaine'] ?></td>                                   <!--Näytetään taulussa oppilaan opintoaine, tehtävä vaihe jne...-->
        <td><?php echo $row['tehtava'] ?></td>
        <td class="vaihe"><?php if ($row['vaihe'] == 'Aloittamatta') {
            echo "<div id='aloittamatta'>Aloittamatta</div>";                       // Laitoin kaikki eri vaiheet omaan DIViinsä ja css avulla vaihdan taustaväriä sen mukaan missä vaiheessa opinto on.
        }
        else if ($row['vaihe'] == 'Kesken') {
            echo "<div id='kesken'>Kesken</div>";                                   // Kaikki vaiheet omissa diveissään jotta taulun solu muuttuu sen mukaan missä vaiheessa opinnot menevät
        }
        else if ($row['vaihe'] == 'Tarvitsenapua') {                                
            echo "<div id='tarvitsenapua'>Tarvitsen apua</div>";
        }
        else if ($row['vaihe'] == 'Valmis') {
            echo "<div id='valmis'>Valmis</div>";
        }
?></td>
            

<td>
<a href='edit.php?id=<?php echo $id; ?>'>Muokkaa</a>                      <!--Tästä pääsee muokkaamaan opintoja-->                                                                     
<a href='delete.php?id=<?php echo $id; ?>' onclick="return confirm('Haluatko varmasti poistaa rivin?')">Poista</a></td><!--Tästä poistetaan opinto taulusta, kun poisto nappia painetaan, javascript kysyy vielä haluatko varmasti poistaa opinnon.-->
<td>
<?php
    $date = $row['date'];                                                     // Laitetaan päivämäärä tietokannasta omaan muuttujaan
    date_default_timezone_set("Europe/Helsinki");
    echo substr($date,8,2);                                                     // Käytetään substr() funktiota jossa kerrotaan ensin mistä numerosta, kirjaimesta alkaa echotus sekä montako kirjainta eteenpäin echotetaan.
    echo ".";
    echo substr($date,5,2);
    echo ".";
    echo substr($date,0,4);
    echo " ";
    
    $muokkaaja = $row['muokkaaja'];
    $sqlz = "SELECT * FROM users INNER JOIN studies ON users.id = studies.muokkaaja WHERE muokkaaja = '$muokkaaja'";            // HAetaan tietoa users taulusta ja yhdistetään studies users.id ja studies.muokkaaja kohtien avulla
 $result3 = mysqli_query($conn, $sqlz);                                         // SQL ajo

 $resultCheck2 = mysqli_num_rows($result3);
 if ($resultCheck2 > 0) {                                           // Jos taulusta löytyy yli 0 tulosta..
     if ($tulos = mysqli_fetch_assoc($result3)) {                   // Laitetaan löydetyt tiedot $tulos nimiseen assosiative arrayhin.
         $muokkaajafname = $tulos['firstname'];                         // Laitetaan tuloksia omiin muuttujiinsa.
         $muokkaajalname = $tulos['lastname'];
         echo ucfirst($muokkaajafname) . " " . ucfirst($muokkaajalname);            // Echotetaan haluamiamme tietoja
     }
 }
?>
    </td>
            
    </tr> 
    <!--Leikattu osa päättyy tähän-->
<?php
            }}
         
?>
</table>


<?php

if (isset($_POST['tallenna'])) {                        // Jos tallenna painiketta on painettu, tee seuraavaa..
   $opintoaine = $_POST['opintoaine'];                 // $_POST globalista tiedot muuttujiin
  $tehtava = $_POST['tehtava'];
    $vaihe = $_POST['vaihe'];                           // Laitetaan formista saadut tiedot omiin muuttujiinsa jotta on helpompi käsitellä SQL kyselyssä.
    date_default_timezone_set("Europe/Helsinki");
    $date = date('Y-m-d');
    $muokkaaja = $_SESSION['User'];
    
       

    
   

    $sqlxx = "INSERT INTO studies (student_id, opintoaine, tehtava, vaihe, date, muokkaaja) VALUES ('$sessio', '$opintoaine', '$tehtava', '$vaihe', '$date', '$muokkaaja')";
    if (mysqli_query($conn, $sqlxx)) {            // Jos ajo onnistuu, tee seuraavaa.
header("location:student_home.php");
    } else {
        echo mysqli_error($conn);                   // Jos ajo ei toimi, näytetään ruudulle mikä error ilmestyi.
    }
}
ob_end_flush();
?>
</div>
</body>
</div>
</html>