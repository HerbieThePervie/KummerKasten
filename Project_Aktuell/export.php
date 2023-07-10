<?php
session_start();
if (!isset($_SESSION['loggedin'], $_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

/** Verbindung zur DB */
require_once('connect.php');

$id = $_SESSION['id'];

$berechtigung = "SELECT * from berechtigungen where Benutzer_ID=$id";
$result = mysqli_query($connect, $berechtigung) or die(mysqli_error($connect));

$begriffe = mysqli_fetch_array($result);

if ($begriffe['Admin'] == 1) {

    $sql = "Select tickets.ID, stammdaten.vorname, stammdaten.nachname, tickets.titel, tickets.inhalt, kategorie.beschreibung, tickets.erstelltAm, tickets.kommentar
    From tickets 
    join kategorie on tickets.Kategorie_ID=kategorie.ID 
    join benutzer on tickets.Benutzer_ID=benutzer.ID 
    join stammdaten on benutzer.Stammdaten_ID=stammdaten.ID;";
    
} else {

    $sql = "Select tickets.ID, stammdaten.vorname, stammdaten.nachname, tickets.titel, tickets.inhalt, kategorie.beschreibung, tickets.erstelltAm, tickets.kommentar
    From tickets 
    join kategorie on tickets.Kategorie_ID=kategorie.ID 
    join benutzer on tickets.Benutzer_ID=benutzer.ID 
    join stammdaten on benutzer.Stammdaten_ID=stammdaten.ID Where Benutzer_ID = $id;";
}

$result = mysqli_query($connect, $sql);

/**
 * Output der Tickets in CSV Format 
 */
if (mysqli_num_rows($result) > 0) {

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=TicketsExport.csv');
    $output = fopen('php://output', 'w');



    /**
     * Output der Columns
     */
    fputcsv($output, array('Ticket-ID', 'Ersteller-Vorname', 'Ersteller-Nachname', 'Titel', 'Inhalt', 'Kategorie', 'Erstell-Dat.', 'Kommentar'));

    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
} else {
    echo "No data found";
}

mysqli_close($connect);
?>