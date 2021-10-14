<?php
include_once "connect.php";
if (!$conn) {                                       // Tarkistetaan tietokantayhteys
    die('Tietokantavirhe' . mysqli_error($conn));
}

$id = $_GET['id'];                                  // Laitetaan klikatun opinnon id muuttujaan

$sql = "DELETE FROM studies WHERE id = $id";        // Tietokantahaku, poistetaan klikattu opinto tietokannasta
if(mysqli_query($conn, $sql)) {
    header("location: teacher_home.php");           // Jos onnistuu niin palataan etusivulle
}else {
    echo mysqli_error($conn);                       // Jos ei onnistu niin tulostaa virheilmoituksen
}
?>