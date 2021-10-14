<?php

$serverName = "localhost";
$dbUsername = "root";
$dbPassword = "root";
$dbName = "opintoseuranta";

$conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);             // Tallennetaan yhteys tietokantaan muuttujaan $conn

if (!$conn) {
    die("Ei saada yhteyttä: " . mysqli_connect_error());
}