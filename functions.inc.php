<?php

function navigaatio() {                             // Funktio joka lisää navigointipalkin
    if (isset($_SESSION['User'])) {                 // jos käyttäjä on kirjautuneena niin...
        include_once "loginheader.php";             // näytä navigointipalkki
    } else {
        include_once "header.php";                  // palauta etusivulle
    }
}

function passwordMatch($password1, $password2) {    // Funktio tarkistaa että salasanat täsmäävät
    if ($password1 !== $password2) {                // jos salasanat ovat erit niin...
        header ("location:signup.php?passwordsdontmatch");      // näyttää virheilmoituksen
        echo "Salasanat eivät täsmää";
        die();
    }
}
   

function search()   {       // Funktio, jolla opettaja etsii oppilaan nimellä, sisältää myös seuraa ja lopeta seuraaminen painikkeet
    

    include "connect.php";
    $studentname = mysqli_real_escape_string($conn, $_POST['studentname']);  // Käytetään mysqli_real_escape_string jotta hakukoneeseen ei voida syöttää SQL komentoja käyttäjänä.

    $sql = "SELECT * FROM users WHERE firstname LIKE '%$studentname%' AND usertype = 1 OR lastname LIKE '%$studentname%' AND usertype = 1"; // Jos löytyy käyttäjä tämän tyylisellä nimellä ja usertype tietokannassa on 1...
    $result = mysqli_query($conn, $sql);


    if (mysqli_num_rows($result) > 0)   {               // Jos tuloksia löytyy enemmän kuin 0 niin ajetaan seuraava...
        echo '<br><table>                               
        <tr>
            <th>Nimi</th>
            <th>Seuraa opintoja</th><tr>';          // Luodaan html taulu
            while ($row = mysqli_fetch_array($result))  {
                $studentid = $row['id'];                    
                $opettaja = $_SESSION['User']['id'];        // Kirjautuneen käyttäjän id laitetaan muuttujaan
                $sqlhaku = "SELECT * FROM mystudents WHERE student_id='$studentid' AND teacher_id='$opettaja'";             // Jos mystudents taulussa on jo yhteys opettajan ja oppilaan välillä niin näkyy painike lopeta seuraaminen
                $result2 = mysqli_query($conn, $sqlhaku);
                echo '<td>';
                echo "<a href='find_student.php?id="; 
                echo $studentid; 
                echo "'>";   
                echo ucfirst($row['firstname']) . " " . ucfirst($row['lastname']);          // Pakotetaan etunimi- ja sukunimi alkamaan isolla kirjaimella ucfirst(); toiminnolla.
                echo '<td>';
                if (mysqli_num_rows($result2) > 0)   {          // Jos opettajan ja oppilaan välillä löytyy yhteys tietokannasta niin näkyy painike "Lopeta seuraaminen" oppilaan nimen vieressä
                    echo '<form action="" method="post">';
                    echo '<input type="hidden" name="delete_student" value='; echo $studentid; echo '>';
                    echo '<input type="submit" name="Lopeta" value="Lopeta seuraaminen">';
                    echo '</form>';
                    echo '</a></td><tr>';
                }
                else {                                                              // Jos opettajan ja oppilaan välillä ei ole yhteyttä mystudents taulussa, niin näkyy painike "Seuraa" oppilaan nimen vieressä.
                    echo '<form action="" method="post">';
                    echo '<input type="hidden" name="id_student" value='; echo $studentid; echo '>';
                    echo '<input type="submit" name="submit" value="Seuraa">';
                    echo '</form>';
                    echo '</a></td><tr>';
        }}
       
    } else {                                        
      
        header("location:teacher_home.php?notfound");           // Jos oppilasta ei löydy hausta niin käyttäjä ohjataan opettajan etusivulle mukana tulleella GETillä saadulla ?notfound erroviestillä.
    
    }
}
function search_student()  {    // Funktio, jossa on hakuvalikko opettajalle. Sisältää "Hae opiskelijaa" otsikon ja hakupalkin

    echo '

    <div class="searchstudent"><h2><span class="material-icons">
   </span> Hae opiskelijaa nimellä</h2>
   <form action="" method="post">
   <input type="text" name="studentname" minlength="3" placeholder="Matti Meikäläinen" required>
   <input type="submit" value="Hae opiskelijaa">
   </form></div>';
}

function show_student() {       // Funktio, joka näyttää oppilaan "profiilin" kun hänen nimeä klikataan haun jälkeen
    include "connect.php";                          // liitetään tietokantayhteys 
    $id = $_GET['id']; 
    $sql2 = "SELECT * FROM users INNER JOIN studies ON users.id = studies.student_id WHERE student_id = $id";   // Yhdistetään studies ja users taulut users.id ja studies.student_id kohtien avulla.
    $result2 = mysqli_query($conn, $sql2);                                                                      // Ajetaan tietokantakysely
    while ($row2 = mysqli_fetch_assoc($result2)){                                                               // Tulokset laitetaan $row2 arrayhin
        $firstname = $row2['firstname'];                                                                        // Laitetaan tietokannan rivien tuloksia omiin muuttujiinsa.
        $lastname = $row2['lastname'];
    }

        echo "<div class='oppilaannimi'>";
        echo "<h2>";
       echo $firstname . " " . $lastname;           // Tulostaa oppilaan nimen otsikkona
        echo "</h2>";
        echo "</div>";
    echo '<table><tr> <th>Opintoaine</th>
    <th>Tehtävä</th>
    <th>Status</th></tr>';?><?php
    $sql = "SELECT * FROM users INNER JOIN studies ON users.id = studies.student_id WHERE student_id = $id";    // Haetaan studies taulusta oppilaan opinnot, id yhteisenä tekijänä users taulun kanssa
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {        // Laitetaan saadut tulokset muuttujiin
        $fn = $row['firstname'];
        $ln = $row['lastname'];
        $email = $row['email'];
        $opintoaine =$row['opintoaine'];
        $tehtava = $row['tehtava'];
        $vaihe = $row['vaihe'];
   ?>
    <tr><td><?php echo $opintoaine?></td>               <!-- Tulostetaan saadut tulokset eli oppilaan opinnot -->
    <td><?php echo $tehtava?></td>
    <td class="vaihe"><?php if ($vaihe == 'Aloittamatta') {     // Tulostetaan oikea opinnon vaihe käyttämällä if toimintoa
    echo "<div id='aloittamatta'>Aloittamatta</div>";
       
    }
    else if ($vaihe == 'Kesken') {
        echo "<div id='kesken'>Kesken</div>";
    }
    else if ($vaihe == 'Tarvitsenapua') {
        echo "<div id='tarvitsenapua'>Tarvitsen apua</div>";
    }
    else if ($vaihe == 'Valmis') {
        echo "<div id='valmis'>Valmis</div>";
    }
     ?></td></tr>
      

<?php
}}
function mystudents() {         // Funktio, jolla oppilas lisätään opettajan seurattavaksi
    include "connect.php";
    
 $oppilas = $_POST['id_student'];       // oppilas laitetaan muuttujaan
 $opettaja = $_SESSION['User']['id'];   // opettaja laitetaan muuttujaan 
 $sqlx = "INSERT INTO mystudents (student_id, teacher_id) VALUES ($oppilas, $opettaja)";        // sql ajossa asetetaan student_id ja teacher_id "pariksi" eli opettaja seuraa kyseistä oppilasta
$returnx = mysqli_query($conn, $sqlx);
}

function deletestudent() {          // Funktio, jolla oppilas poistetaan opettajan seurauksesta
    include "connect.php";
    
    $oppilas = $_POST['delete_student'];    // oppilas laitetaan muuttujaan
    $opettaja = $_SESSION['User']['id'];    // opettaja laitetaan muuttujaan 
    $sqlpoisto = "DELETE FROM mystudents WHERE student_id='$oppilas' AND teacher_id='$opettaja'";       // sql ajossa poistetaan mystudents taulusta "pari" eli seuraus
    $resultpoisto = mysqli_query($conn, $sqlpoisto);
}

function updateToTeacher() {        // Funktio, jolla opettaja voi päivittää oppilaskäyttäjän opettajakäyttäjäksi
    include "connect.php";

    $user = $_POST['updatetoteacher'];
    $opettaja = $_SESSION['User']['id'];
    $sqlupdate = "UPDATE users SET usertype=0 WHERE id=$user";      // sql ajossa vaihdetaan käyttäjän usertype nollaksi eli opettajakäyttäjäksi
    $resultupdate = mysqli_query($conn, $sqlupdate);

    $sqldelete = "DELETE FROM studies WHERE student_id=$user";      // poistetaan kyseisen käyttäjän kaikki opinnot tietokannasta oppilaskäyttäjän muuttuessa opettajakäyttäjäksi
    $resultdelete = mysqli_query($conn, $sqldelete);
}
?>
