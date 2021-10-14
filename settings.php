<?php
session_start();

if(isset($_SESSION['User'])) {                  // Jos on käyttäjä on kirjautuneena niin...
    if ($_SESSION['User']['usertype'] == 0) {   // Ja jos käyttäjä on oppilas niin...
    include_once "loginheader.php";
    include_once "connect.php";
    include "functions.inc.php";
    if (isset($_POST['updatetoteacher'])) {     // Jos "Päivitä käyttäjä" painiketta on painettu niin...

        updateToTeacher();                      // Aja funktio
        header("location:settings.php?teachercreated");     // Siirry sivulle
        die();
    }

    
}
}
?>
<?php
                        if(isset($_GET['teachercreated'])) {    // Jos uusi opettaja on luotu niin...
                          $teachercreated=$_GET['teachercreated'];
                          $teachercreated="Uusi opettaja luotu!";   // Näytä "Uusi opettaja luotu" ilmoitus

                    ?>
                        <div class="alert alert-success text-center"><?php echo $teachercreated?></div>     <!-- Muotoilu ilmoitukseen -->
                    <?php
                        }
                    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h4>Lisää henkilölle opettajan oikeudet</h4>    <!-- Luodaan otsikko ja hakupalkki -->

    <form action="" method="post">

    <input type="text" name="updateteacher" value="">
    <input type="submit" name="submit" value="Etsi henkilö">
    </form>
</body>

<?php
if(isset($_POST['submit'])) {               // Jos "Etsi henkilö" painiketta on painettu niin...
    $hae = $_POST['updateteacher'];

    $sql = "SELECT * FROM users WHERE firstname LIKE '%$hae%' AND usertype = 1 OR lastname LIKE '%$hae%' AND usertype = 1";     // Tietokantahaku, haetaan etunimen tai sukunimen perusteella oppilaskäyttäjää, usertype pitää olla 1
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {     // Jos tuloksia löytyy niin luodaan taulu...
        echo '<br><table>        
        <tr>                                
            <th>Nimi</th>
            <th>Päivitä opettajaksi</th><tr>';
            while ($row = mysqli_fetch_assoc($result))  {   // While loop käy läpi löydetyt käyttäjät haun perusteella
                $studentid = $row['id'];  
                $opettaja = $_SESSION['User']['id'];
                $sqlhaku = "SELECT * FROM users WHERE id='$studentid'";     // Tietokantahaulla valitaan klikattu oppilas
                $result2 = mysqli_query($conn, $sqlhaku);
                echo '<td>';
                echo ucfirst($row['firstname']) . " " . ucfirst($row['lastname']);
                echo '<td>';
                if (mysqli_num_rows($result2) > 0)   {          // Jos tuloksia löytyy niin...
                    echo '<form action="" method="post">';
                    echo '<input type="hidden" name="updatetoteacher" value='; echo $studentid; echo '>';   // Tulostetaan käyttäjän nimi
                    echo '<input type="submit" value="Päivitä käyttäjä">';                                  // Painike käyttäjän nimen jälkeen jota painamalla käyttäjän voi päivittää
                    
                    echo '</form>';
                    echo '</a></td><tr>';
     }
    } 
 }
 
}

?>
</html>