<?php

 session_start();
 if (!isset($_SESSION['loggedin'],$_SESSION['id']))
{
header('Location: index.php');
exit;
}

/** Verbindung zur DB */
require_once('connect.php');


/** Daten werden vom Frontend in Variablen gespeichert */
$idUncut = $_POST['ticketID'];
$id = substr($idUncut, 11);
$titel = $_POST['titel'];
$inhalt = $_POST['inhalt'];
$kategorie = $_POST['kategorie'];
$kommentar = $_POST['kommentar'];

/** Bearbeiten der Tickets */
$sql ="Update tickets Set titel = '$titel', inhalt = '$inhalt', Kategorie_ID = $kategorie, kommentar = '$kommentar'  Where ID = $id;";

$result = $connect->query($sql);
if (!$result) {
    $_SESSION['infoMsg'] = "Fehler: " . $connect->error;
}
$_SESSION['infoMsg'] = "Datensatz erfolgreich bearbeitet!";
$connect->close();
header('Location:ticketErfassen.php');
?>