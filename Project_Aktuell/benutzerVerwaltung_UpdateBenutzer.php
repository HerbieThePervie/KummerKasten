<?php
session_start();
if (!isset($_SESSION['loggedin'], $_SESSION['id'])) {
    header('Location: ticketErfassen.php');
    exit;
}
include("benutzerVerwaltung.php");

$id = $_GET['ID'];

$sql = "
SELECT * FROM benutzer 

LEFT JOIN stammdaten on benutzer.stammdaten_ID = stammdaten.id 
LEFT JOIN adresse on stammdaten.Adresse_ID = adresse.id
LEFT JOIN ort on adresse.Ort_ID = ort.id
LEFT JOIN berechtigungen on berechtigungen.Benutzer_ID = benutzer.id

WHERE benutzer.id=$id";

$result = mysqli_query($connect, $sql) or die(mysqli_error($connect));
$begriffe = mysqli_fetch_array($result);
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Profilseite</title>
    <link rel="stylesheet" href="profil.css">
    <link rel="icon" type="image/x-icon" href="bear.ico">

    <nav class="horizontal-menu plain">
        <ul>
            <li><a href='/startseite.php'>Startseite</a></li>
            <li><a href='/ticketErfassen.php'>Tickets</a></li>
            <li><a href='/benutzerVerwaltung_Anzeige.php'>Benutzerverwaltung</a></li>
            <li class="active"><a href='/benutzerUpdate.php'>Benutzerbearbeitung</a></li>
            <li><a href='/profil.php'>Profil</a></li>
        </ul>
    </nav>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="profil-box">
                <div class="profil-form">
                    <form action="benutzerVerwaltung_Update.php?ID=<?php echo $_GET['ID']; ?>" method="post" onsubmit="return checkPasswords()">
                        <div class="form-group">
                            <input class="Edit" type="text" value="<?php echo $begriffe['vorname']; ?>" name="vname" placeholder="Vorname">
                        </div>
                        <div class="form-group">
                            <input class="Edit" type="text" value="<?php echo $begriffe['nachname']; ?>" name="nname" placeholder="Nachname">
                        </div>
                        <div class="form-group">
                            <input class="Edit" type="email" value="<?php echo $begriffe['eMail']; ?>" name="email" placeholder="E-Mail">
                        </div>
                        <div class="form-group">
                            <input class="Edit" type="date" value="<?php echo $begriffe['geburtstag']; ?>" name="bday" placeholder="Geburtstag">
                        </div>
                        <div class="form-group">
                            <input class="Edit" type="text" value="<?php echo $begriffe['strasse']; ?>" name="strasse" placeholder="Straße">
                        </div>
                        <div class="form-group">
                            <input class="Edit" type="text" value="<?php echo $begriffe['hausnummer']; ?>" name="hsnr" maxlength="4" placeholder="Hausnummer">
                        </div>
                        <div class="form-group">
                            <input class="Edit" type="text" value="<?php echo $begriffe['ortname']; ?>" name="Ort" placeholder="Ort">
                        </div>
                        <div class="form-group">
                            <input class="Edit" type="text" value="<?php echo $begriffe['plz']; ?>" name="Zip" maxlength="6" placeholder="Postleitzahl">
                        </div>
                        <div class="form-group">
                            <input type="tel" value="<?php echo $begriffe['telefonnummer']; ?>" name="telnr" pattern="\+[0-9]{2} [0-9]{3} [0-9]{3} [0-9]{4}" maxlength="16" title="Bitte nach dem Format +43 123 456 7890 eingeben" required>
                        </div>

                        <div class="container-checkbox">
                            <div class="checkbox-container">
                                <input type="checkbox" id="checkbox1" name="checkbox1" <?php if (strpos($begriffe['ticketUpdate'], '1') !== false) echo 'checked="checked"'; ?> <?php if (strpos($begriffe['Admin'], '1') !== false) echo 'disabled="disabled"'; ?>>
                                <label for="ticketUpdate"> Ticket Update</label>
                            </div>
                            <div class="checkbox-container">
                                <input type="checkbox" id="checkbox2" name="checkbox2" <?php if (strpos($begriffe['ticketDelete'], '1') !== false) echo 'checked="checked"'; ?> <?php if (strpos($begriffe['Admin'], '1') !== false) echo 'disabled="disabled"'; ?>>
                                <label for="ticketDelete"> Ticket Löschen</label>
                            </div>
                            <div class="checkbox-container">
                                <input type="checkbox" id="checkbox3" name="checkbox3" <?php if (strpos($begriffe['profilUpdate'], '1') !== false) echo 'checked="checked"'; ?> <?php if (strpos($begriffe['Admin'], '1') !== false) echo 'disabled="disabled"'; ?>>
                                <label for="profilUpdate"> Profil Update</label>
                            </div>
                            <div class="checkbox-container">
                                <input type="checkbox" id="checkbox4" name="checkbox4" <?php if (strpos($begriffe['Admin'], '1') !== false) echo 'checked="checked"'; ?>>
                                <label for="admin"> Admin</label>
                            </div>
                        </div>

                        <div class="Changesbttm">
                            <div class="Changes-button">

                                <button type="submit" name="submit" class="submitChanges">Änderungen speichern</button>
                                <!--a class="ChangePw" href='/startseite.php'>Änderungen speichern</a-->

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>


</html>