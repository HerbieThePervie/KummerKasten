<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}


require_once('connect.php');

$id = $_SESSION['id'];


$sql = "
SELECT * FROM benutzer 

LEFT JOIN stammdaten on benutzer.stammdaten_ID = stammdaten.id 
LEFT JOIN adresse on stammdaten.Adresse_ID = adresse.id
LEFT JOIN ort on adresse.Ort_ID = ort.id
LEFT JOIN berechtigungen on berechtigungen.benutzer_id = benutzer.id 

WHERE benutzer.id=$id";

$result = mysqli_query($connect, $sql) or die(mysqli_error($connect));
$begriffe = mysqli_fetch_array($result);


/*if ($begriffe['Admin'] == 1 or $begriffe['profilUpdate'] == 1) {
        
} else {
    // Benutzer ist kein Admin, Weiterleitung
    header('Location: profil.php');
}*/

$result->close();
$connect->close();

    




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
            <li><a href='/profil.php'>Profil</a></li>
            <li class="active"><a href='/profilEdit.php'>Profilbearbeitung</a></li>
        </ul>
    </nav>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="profil-box">
                <div class="profil-form">
                    <form action="profileSaveChanges.php" method="post">
                        <div class="form-group">
                            <input class="Edit" type="text" value="<?php echo $begriffe['vorname']; ?>" name="vname" placeholder="Vorname" <?php if ($begriffe['Admin']=='0' or $begriffe['profilUpdate']=='0') echo 'disabled="disabled"'; ?>>
                        </div>
                        <div class="form-group">
                            <input class="Edit" type="text" value="<?php echo $begriffe['nachname']; ?>" name="nname" placeholder="Nachname" <?php if (strpos($begriffe['Admin'], '0') !== false || strpos($begriffe['profilUpdate'], '0') !== false) echo 'disabled="disabled"'; ?>>
                        </div>
                        <div class="form-group">
                            <input class="Edit" type="email" value="<?php echo $begriffe['eMail']; ?>" name="email" placeholder="E-Mail" <?php if (strpos($begriffe['Admin'], '0') !== false || strpos($begriffe['profilUpdate'], '0') !== false) echo 'disabled="disabled"'; ?>>
                        </div>
                        <div class="form-group">
                            <input type="password" placeholder="Passwort" value="NiceTryBuddy" name="pwd" disabled>
                        </div>
                        <!--div class="form-group">
                            <input class="Edit" type="password" name="pwd" id="pwd" placeholder="neues Passwort" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Muss mindestens eine Zahl, einen Groß- und Kleinbuchstaben sowie mindestens 8 oder mehr Zeichen enthalten." onclick="(this.type='text')" onblur="(this.type='password')">
                        </div>
                        <div class="form-group">
                            <input class="Edit" type="password" name="pwdConfirm" id="pwdConfirm" placeholder="Passwort wiederholen" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Muss mindestens eine Zahl, einen Groß- und Kleinbuchstaben sowie mindestens 8 oder mehr Zeichen enthalten." onclick="(this.type='text')" onblur="(this.type='password')">
                        </div-->
                        <div class="form-group">
                            <input class="Edit" type="date" value="<?php echo $begriffe['geburtstag']; ?>" name="bday" placeholder="Geburtstag" <?php if (strpos($begriffe['Admin'], '0') !== false || strpos($begriffe['profilUpdate'], '0') !== false) echo 'disabled="disabled"'; ?>>
                        </div>
                        <div class="form-group">
                            <input class="Edit" type="text" value="<?php echo $begriffe['strasse']; ?>" name="strasse" placeholder="Straße" <?php if (strpos($begriffe['Admin'], '0') !== false || strpos($begriffe['profilUpdate'], '0') !== false) echo 'disabled="disabled"'; ?>>
                        </div>
                        <div class="form-group">
                            <input class="Edit" type="text" value="<?php echo $begriffe['hausnummer']; ?>" name="hsnr" maxlength="4" placeholder="Hausnummer" <?php if (strpos($begriffe['Admin'], '0') !== false || strpos($begriffe['profilUpdate'], '0') !== false) echo 'disabled="disabled"'; ?>>
                        </div>
                        <div class="form-group">
                            <input class="Edit" type="text" value="<?php echo $begriffe['ortname']; ?>" name="Ort" placeholder="Ort" <?php if (strpos($begriffe['Admin'], '0') !== false || strpos($begriffe['profilUpdate'], '0') !== false) echo 'disabled="disabled"'; ?>>
                        </div>
                        <div class="form-group">
                            <input class="Edit" type="text" value="<?php echo $begriffe['plz']; ?>" name="Zip" maxlength="6" placeholder="Postleitzahl" <?php if (strpos($begriffe['Admin'], '0') !== false || strpos($begriffe['profilUpdate'], '0') !== false) echo 'disabled="disabled"'; ?>>
                        </div>
                        <div class="form-group">
                            <input type="tel" value="<?php echo $begriffe['telefonnummer']; ?>" name="telnr" pattern="\+[0-9]{2} [0-9]{3} [0-9]{3} [0-9]{4}" maxlength="16" title="Bitte nach dem Format +43 123 456 7890 eingeben" required <?php if (strpos($begriffe['Admin'], '0') !== false || strpos($begriffe['profilUpdate'], '0') !== false) echo 'disabled="disabled"'; ?>>
                        </div>

                        <div class="container-2FA">
                            <div class="checkbox-2FA">
                                <a class="activate2FA" href='/2FA_authentication.php'>2FA aktivieren</a>
                            </div>
                        </div>

                        <div class="Changesbttm">
                            <div class="Changes-button">
                            
                                <button type="submit" name="submit" class="submitChanges" <?php if (strpos($begriffe['Admin'], '0') !== false || strpos($begriffe['profilUpdate'], '0') !== false) echo 'disabled="disabled"'; ?>>Änderungen speichern</button>
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