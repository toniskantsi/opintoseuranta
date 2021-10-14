<?php


session_start();

 error_reporting(0);

if (isset($_SESSION['User'])) {     // Jos on kirjautunut käyttäjä niin...
    include "functions.inc.php";    // Sisällytä tiedostot
    include_once "loginheader.php";
    include_once "connect.php"; 
    
    
    if (isset($_POST['id_student'])) {  // Jos on painettu "Muokkaa" painiketta niin aja tämä funktio
    
        mystudents();
      


      
    }
    if (isset($_POST['delete_student'])) {  // Jos on painettu "Poista" painiketta niin aja tämä funktio

        deletestudent();
    }

}

else {                              // Jos ei ole kirjautunut käyttäjä niin...
    header("location:index.php?accessdenied");  // Siirtää käyttäjän takaisin etusivulle ja tulostaa virheilmoituksen
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarkastele opintoja</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
      <link rel="stylesheet" href="style.css">
      <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<?php

search_student();       // Ajetaan funktio

if (isset($_POST['studentname'])) {     // Jos on painettu "Hae oppilasta" painiketta niin...
    search();           // Ajetaan funktio
}

if (isset($_GET['id'])) {               // Jos on painettu oppilan nimestä niin...
    show_student();     // Ajetaan funktio
}
    ?>

