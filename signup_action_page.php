<?php
include_once "functions.inc.php";
if (isset($_POST['register'])) {                          // Jos rekisteröinti painiketta on painettu niin...
    include_once "connect.php";
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);     // Laitetaan käyttäjän syöttämät tiedot muuttujiin, käytetään mysqli_real_escape_string tietojen turvaamiseksi
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn ,$_POST['password']);
    $passwordrepeat = mysqli_real_escape_string($conn, $_POST['passwordrepeat']);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);          // suojataan salasana password_hash toiminnolla 


    if ($password !== $passwordrepeat) {
      passwordMatch($password, $passwordrepeat);
    }

    if (!preg_match("/^[a-zA-ZåÅäÄöÖ]*$/", $firstname) || !preg_match("/^[a-zA-ZåÅäÄöÖ]*$/", $lastname)) {      // Jos käyttäjä syöttää kiellettyjä merkkejä niin...
        header("location:signup.php?invalidcharacters");                                                        // Tulostetaan virheilmoitus
        die();
    }

    else if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($passwordrepeat)) {    // Jos käyttäjä jättää jotain tyhjäksi niin...
        header("location:signup.php?emptyinput");                                                                       // Tulostetaan virheilmoitus
        die();
    }
    $sql = "SELECT * FROM users where email = '".$email."'";            // Tietokantahaku, haetaan syötettyä sähköpostia tietokannasta users taulusta
    $result = mysqli_query($conn, $sql);

    if (mysqli_fetch_assoc($result)) {                                  // Jos löytyy osumia niin...
        header("location:signup.php?emailtaken");                       // Virheilmoitus että sähköpostiosoite on jo käytössä
        die();
    }

    
    if (empty($_POST['teachercode'])) {                                 // Jos opettajakoodi kohta on tyhjä niin...
        $sql = "INSERT INTO users (firstname, lastname, email, password, usertype)
        VALUES ('$firstname', '$lastname', '$email', '$hashed_password', 1)";   // Luodaan käyttäjä joka on oppilas

        }
    else if ($_POST['teachercode'] == 'teacher') {                      // Jos opettajakoodi on oikein niin...
            $sql = "INSERT INTO users (firstname, lastname, email, password, usertype)
            VALUES ('$firstname', '$lastname', '$email', '$hashed_password', 0)";   // Luodaan käyttäjä joka on opettaja

        }
    else if ($_POST['teachercode'] !== 'teacher') {                     // Tarkistaa onko opettajakoodi oikein
        header("location:signup.php?wrongcode");
    }
      
    if ($conn->query($sql) === TRUE) {                                  // Jos tietokantaan uuden käyttäjän lisäys onnistuu niin...
    header("location:login.php?usercreated");                           // Tulostetaan ilmoitus
    } else {
     echo "Tietokantavirhe";
}
    }
   
    
   

   

  

?>