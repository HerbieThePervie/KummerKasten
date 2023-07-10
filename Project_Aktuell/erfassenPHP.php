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
$titel = $_POST['titel'];
$inhalt = $_POST['inhalt'];
$kategorie = $_POST['kategorie'];
$terminDat = $_POST['terminDat'];
$id = $_SESSION['id'];

/** Speichern des Tickets in die DB */
if($terminDat == null){

$sql = "INSERT INTO tickets (titel, inhalt, erstelltAm, terminDat, Benutzer_ID, Kategorie_ID) VALUES ('$titel', '$inhalt', CURDATE(), null, $id, $kategorie);";
} else {
$sql = "INSERT INTO tickets (titel, inhalt, erstelltAm, terminDat, Benutzer_ID, Kategorie_ID) VALUES ('$titel', '$inhalt', CURDATE(), '$terminDat', $id, $kategorie);";
}

$result = $connect->query($sql);
if (!$result) {
    $_SESSION['infoMsg'] = "Fehler: " . $connect->error;
}
$_SESSION['infoMsg'] = "Datensatz erfolgreich hinzugefügt!";
$connect->close();
header('Location:ticketErfassen.php');
?>