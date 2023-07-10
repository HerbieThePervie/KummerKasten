<?php
session_start();
if (!isset($_SESSION['loggedin'], $_SESSION['id'])) {
    header('Location: ticketErfassen.php');
    exit;
}
include("connect.php");
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Ticket Erfassen</title>
    <link rel="stylesheet" href="ticket.css">
    <link rel="icon" type="image/x-icon" href="bear.ico">

    <nav class="horizontal-menu plain">
        <ul>
            <li><a href='/startseite.php'>Startseite</a></li>
            <li class="active"><a href='/ticketErfassen.php'>Tickets</a></li>
            <li><a href='/benutzerVerwaltung_Anzeige.php'>Benutzerverwaltung</a></li>
            <li><a href='/profil.php'>Profil</a></li>
        </ul>
    </nav>
</head>

<body>
    <form action="erfassenPHP.php" method="post">
        <div class="container">
            <div class="infoMsg">
                <?php if (isset($_SESSION['infoMsg'])) {echo $_SESSION['infoMsg'];unset($_SESSION['infoMsg']);} ?>
            </div>
            <div class="row">
                <div class="form-group">
                    <input type="text" class="Titel" placeholder="Titel" name="titel" id="Titel" required>
                </div>
                <div class="form-group">
                    <textarea class="Inhalt" name="inhalt" placeholder="Inhalt erfassen..." required></textarea>
                </div>
                <div class="form-group">
                    <span class="label">Kategorie:</span>
                    <select name='kategorie' id='kategorie' required>
                        <option value=''>--- Auswählen ---</option>
                        <option value='1'>Beschwerden</option>
                        <option value='2'>Ideen</option>
                        <option value='3'>Wünsche</option>
                    </select>
                </div>
                <div class="form-group">
                    <span class="label">Termin Dat.:</span>
                    <input class="EditDate" type="date" name="terminDat" min="<?= date('Y-m-d'); ?>">
                </div>
                <div class="form-group">
                    <button type="submit" class="submitChanges">Speichern</button>
                    <a class="submitExport" href="export.php">Exportieren</a>
                </div>
                </div>
            </div>
        </div>

        <?php

        $id = $_SESSION['id'];

        $berechtigung = "SELECT * from berechtigungen where Benutzer_ID=$id";
        $result = mysqli_query($connect, $berechtigung) or die(mysqli_error($connect));

        $begriffe = mysqli_fetch_array($result);

        if ($begriffe['Admin'] == 1) {

            $sql = "Select tickets.ID, tickets.titel, tickets.inhalt, tickets.erstelltAm, tickets.kommentar, tickets.terminDat, kategorie.beschreibung, stammdaten.vorname, stammdaten.nachname
            From myDB.tickets 
            join kategorie on tickets.Kategorie_ID=kategorie.ID 
            join benutzer on tickets.Benutzer_ID=benutzer.ID 
            join stammdaten on benutzer.Stammdaten_ID=stammdaten.ID 
            order by tickets.erstelltAm, tickets.ID;";

        } else {

            $sql = "Select tickets.ID, tickets.titel, tickets.inhalt, tickets.erstelltAm, tickets.kommentar, tickets.terminDat, kategorie.beschreibung 
            From myDB.tickets 
            join kategorie on tickets.Kategorie_ID=kategorie.ID 
            where Benutzer_ID = $id order by tickets.ID;";
        }

        $result = mysqli_query($connect, $sql) or die(mysqli_error($connect));

        echo "<div class='container'>
        <div class='row'>
            <div class='col-sm-8'>
                <div class='table-responsive'>
                    <table class='table table-bordered'>
                        <thead>
                            <tr>
                <th>Ticket-ID</th>";
        if ($begriffe['Admin'] == 1) {
            echo "<th>Ersteller</th>";
        }
        echo "<th>Titel</th>
                <th>Inhalt</th>
                <th>Kategorie</th>
                <th>Termin-Dat.</th> 
                <th>Erstell-Dat.</th> 
                <th>Aktionen</th>
                </tr>
                </thead>";

        while ($row = mysqli_fetch_array($result)) {

            echo "<tr>";
            echo "<td>" . $row['ID'] . "</td>";
            if ($begriffe['Admin'] == 1) {
                echo "<td>" . $row['nachname'] . " " . $row['vorname'] . "</td>";
            }
            echo "<td>" . $row['titel'] . "</td>";
            echo "<td>" . $row['inhalt'] . "</td>";
            echo "<td>" . $row['beschreibung'] . "</td>";
            echo "<td>" . $row['terminDat'] . "</td>";
            echo "<td>" . $row['erstelltAm'] . "</td>";
            if (($begriffe['ticketDelete'] == 1 and $begriffe['ticketUpdate'] == 1) or $begriffe['Admin'] == 1) {
                echo "<td> <a href='bearbeiten.php?ID=" . $row['ID'] . "'>Öffnen</a> <a> | </a> <a href='delete.php?ID=" . $row['ID'] . "'>Löschen</a> </td>";
            } elseif($begriffe['ticketDelete'] == 1){
                echo "<td> <a href='delete.php?ID=" . $row['ID'] . "'>Löschen</a> </td>";

            } elseif($begriffe['ticketUpdate'] == 1){
                echo "<td> <a href='bearbeiten.php?ID=" . $row['ID'] . "'>Öffnen</a> </td>";
            } else{
                echo "<td></td>";
            }
            echo "</tr>";
        }

        echo "</table>";


        ?>

    </form>

</body>

</html>