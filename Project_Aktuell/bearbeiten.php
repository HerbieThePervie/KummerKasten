<?php
session_start();
if (!isset($_SESSION['loggedin'], $_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

/** Verbindung zur DB */
require_once('connect.php');

$ticketId = $_GET['ID'];

$sql = "Select ID, titel, inhalt, Kategorie_ID, kommentar From tickets Where ID='$ticketId';";

$result = mysqli_query($connect, $sql) or die(mysqli_error($connect));
$begriffe = mysqli_fetch_array($result);


$id = $_SESSION['id'];
$berechtigung = "SELECT * from berechtigungen where Benutzer_ID=$id";

$resultBerechtigung = mysqli_query($connect, $berechtigung) or die(mysqli_error($connect));
$begriffeBerechtigung = mysqli_fetch_array($resultBerechtigung);

    
    if ($begriffeBerechtigung['ticketUpdate'] == 1 or $begriffeBerechtigung['Admin'] == 1) {
        
    } else {
        // Benutzer hat keine Rechte, Weiterleitung
        header('Location: ticketErfassen.php');
    }

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
    <form action="edit.php" method="post">
        
        <div class="container">
            <div class="row">
                <div class="form-group">
                    <input type="text" class="ticketID" placeholder="ID" value="<?php  echo "Ticket Nr.: ".$begriffe['ID']; ?>" name="ticketID"  readonly>
                </div>
                <div class="form-group">
                    <input type="text" class="Titel"  value="<?php echo $begriffe['titel']; ?>" name="titel" id="Titel" required>
                </div>
                <div class="form-group">
                    <textarea class="Inhalt" name="inhalt"  required> <?php echo $begriffe['inhalt']; ?></textarea>
                </div>
                <div class="form-group">
                <span class="label">Kategorie:</span>
                    <select name='kategorie' id='kategorie' required>
                        <option value=''>--- Auswählen ---</option>

                        <?php

                        if ($begriffe['Kategorie_ID'] == 1) {
                            echo "<option value='1' selected>Beschwerden</option>";
                        } else {
                            echo "<option value='1'>Beschwerden</option>";
                        }
                        if ($begriffe['Kategorie_ID'] == 2) {
                            echo "<option value='2' selected>Ideen</option>";
                        } else {
                            echo "<option value='2'>Ideen</option>";
                        }
                        if ($begriffe['Kategorie_ID'] == 3) {
                            echo "<option value='3' selected>Wünsche</option>";
                        } else {
                            echo "<option value='3'>Wünsche</option>";
                        }

                        ?>
                    </select>
                </div>
                <?php

                $id = $_SESSION['id'];

                $berechtigung = "SELECT * from berechtigungen where Benutzer_ID=$id";
                $result = mysqli_query($connect, $berechtigung) or die(mysqli_error($connect));
                $rolle = mysqli_fetch_array($result);

                echo '<div class="form-group">';
                if ($rolle['Admin'] == 1) {

                    echo '<textarea class="kommentar" name="kommentar" id="kommentar"" placeholder="Kommentar eingeben...">' . $begriffe["kommentar"] . '</textarea>';
                    
                } else {
        
                    echo '<textarea class="kommentar" name="kommentar" id="kommentar" placeholder="Kommentar eingeben..." readonly>' . $begriffe["kommentar"] . '</textarea>';
                }
                
                echo '</div>';
                ?>
                <div class="form-group">
                    <button type="submit" class="submitChanges"> Änderung Speichern</button>
                </div>
            </div>
        </div>
    </form>
</body>

</html>