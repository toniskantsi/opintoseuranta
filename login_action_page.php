<?php
session_start();
require_once "connect.php";                         // Tietokantayhteys

$email = mysqli_real_escape_string($conn, $_POST['email']);            // Laitetaan käyttäjän syöttämä sähköposti muuttujaan               
$password = mysqli_real_escape_string($conn, $_POST['password']);       // Laitetaan käyttäjän syöttämä salasana muuttujaan

if (isset($_POST['login'])) {                                           // Jos "kirjaudu sisään" painiketta on painettu niin...
    if (empty($email) || empty($password)) {                            // Jos sähköposti tai salasana on tyhjä niin...
        header ("location:login.php?missinginfo");                      // Tulosta virheilmoitus
    } else {
        $sql = "SELECT * FROM users where email = '$email'";            // Valitsee taulusta users kirjoitetun sähköpostin
        $result = mysqli_query($conn, $sql);                            
        $resultCheck = mysqli_num_rows($result);                        // Tarkistaa montako riviä palautetaan tuloksena tietokannasta

        if ($resultCheck < 1) {
            header("location:login.php?usernotfound");              // Jos ei palaudu yhtäkään riviä tietokannasta = error = usernotfound eli käyttäjää syötetyllä sähköpostilla ei löydy
            die();
        } else {
            if ($row = mysqli_fetch_assoc($result)){                    // Tulos laitetaan associative arrayhin
                $salasananmuunnos = password_verify($password, $row['password']);           // Varmistetaan että hashattu salasana vastaa syötettyä salasanaa.
                if ($salasananmuunnos == FALSE) {
                    header("location:login.php?wrongpassword");
                    die();
                }
                
                else if ($salasananmuunnos == TRUE) {                   // Jos salasanat täsmäävät, tehdään User sessio
                    $_SESSION['User'] = $row;
                    if($row['usertype'] == 0) {                            // Jos users taulussa usertype = 0
                        header ("location:teacher_home.php");              // Ohjataan käyttäjä teacher_home sivulle, eli kirjautuneen opettajan sivulle
                    } else {
                        
                        $sql = "SELECT * FROM users WHERE email = '$email'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) == 1){
                            
                            while ($row = mysqli_fetch_assoc($result)) {
                                $_SESSION['User'] = $row['id'];                 // User sessio = tietokannasta users taulun ID rivi
                                header("location:student_home.php");        // Jos usertype = 1, ohjataan student_home sivulle, eli kirjautuneen opiskelijan sivulle
                            }
                        }
                        


                        
                    
                    }
                }
            }
        }
 
    }
}
 

 
 
 
 
  