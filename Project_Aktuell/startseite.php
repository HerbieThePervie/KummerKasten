<?php
session_start();
unset($_SESSION['infoMsg']);
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Startseite</title>
    <link rel="stylesheet" href="Startseite.css">
    <link rel="icon" type="image/x-icon" href="bear.ico">

    <nav class="horizontal-menu plain">
        <ul>
            <li class="active"><a href='/startseite.php'>Startseite</a></li>
            <li><a href='/ticketErfassen.php'>Tickets</a></li>
            <li><a href='/benutzerVerwaltung_Anzeige.php'>Benutzerverwaltung</a></li>
            <li><a href='/profil.php'>Profil</a></li>
        </ul>
    </nav>

    <div>
        <img class="Logo" src="Logo.png" alt="Italian Trulli">
    </div>
</head>


</html>