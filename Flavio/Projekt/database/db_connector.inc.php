<?php
// Variabeln deklarieren
$host = 'localhost'; // host
$username = 'testuser'; // username
$password = 'Test123.'; // password
$database = 'trainingsplan'; // database



// mit der Datenbank verbinden
$mysqli = new mysqli($host, $username, $password, $database);



// Fehlermeldung, falls Verbindung fehl schlägt.
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
}
?>