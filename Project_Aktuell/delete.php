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
$ticketId = $_GET['ID'];

/** Löschen der Tickets aus der DB */
$sql ="Delete From tickets Where ID='$ticketId';";

$result = $connect->query($sql);
if (!$result) {
    $_SESSION['infoMsg'] = "Fehler: " . $connect->error;
}
$_SESSION['infoMsg'] = "Datensatz erfolgreich gelöscht!";
$connect->close();
header('Location:ticketErfassen.php');
?>