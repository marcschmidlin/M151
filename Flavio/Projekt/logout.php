<?php
// TODO - Session starten
session_start();
// TODO - Session leeren
$_SESSION = array();
session_destroy(); 
header('Location: ./index.php');
?>