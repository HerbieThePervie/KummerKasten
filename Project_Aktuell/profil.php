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

WHERE benutzer.id=$id";

$result = mysqli_query($connect, $sql) or die(mysqli_error($connect));
$begriffe = mysqli_fetch_array($result);

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
            <li class="active"><a href='/profil.php'>Profil</a></li>
            <li><a href='/profilEdit.php'>Profilbearbeitung</a></li>
            <!--li><a href='/logOut.php'>LogOut</a></li-->
        </ul>
    </nav>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="infoMsg">
            <?php if (isset($_SESSION['infoMsg'])) {echo $_SESSION['infoMsg'];unset($_SESSION['infoMsg']);} ?>
            </div>
            <div class="profil-box">
                <div class="profil-form">
                    <div class="form-group">
                        <input type="text" value="<?php echo $begriffe['vorname']; ?>" name="vname" disabled>
                    </div>
                    <div class="form-group">
                        <input type="text" value="<?php echo $begriffe['nachname']; ?>" name="nname" disabled>
                    </div>
                    <div class="form-group">
                        <input type="email" name="username" id="username" pattern="[^ @]*@[^ @]*" class="form-control" value="<?php echo $begriffe['eMail']; ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="password" placeholder="Passwort" value="NiceTryBuddy" name="pwd" disabled>
                    </div>
                    <div class="form-group">
                        <input type="date" value="<?php echo $begriffe['geburtstag']; ?>" name="bday" disabled>
                    </div>
                    <div class="form-group">
                        <input type="text" value="<?php echo $begriffe['strasse']; ?>" name="strasse" disabled>
                    </div>
                    <div class="form-group">
                        <input type="text" value="<?php echo $begriffe['hausnummer']; ?>" name="hsnr" pattern="[0-9]+" disabled>
                    </div>
                    <div class="form-group">
                        <input type="text" value="<?php echo $begriffe['ortname']; ?>" name="Ort" disabled>
                    </div>
                    <div class="form-group">
                        <input type="text" value="<?php echo $begriffe['plz']; ?>" name="Zip" pattern="[0-9]+" disabled>
                    </div>
                    <div class="form-group">
                        <input type="tel" value="<?php echo $begriffe['telefonnummer']; ?>" name="telnr" pattern="[0-9]+" disabled>
                    </div>

                    <div class="container-checkbox">
                            <div class="checkbox-container">
                                <input type="checkbox" id="checkbox1" name="checkbox1" <?php if (strpos($begriffe['active2FA'], '1') !== false) echo 'checked="checked"'; ?> disabled>
                                <label for="checkbox1">2FA aktiviert</label>
                            </div>
                    </div>

                    <div class="logOutbttm">
                        <div class="logOut-button">
                            <!--abutton type="submit" class="submitChanges">Daten Ändern</button-->
                            <!--a class="ChangePw" href='/profilEdit.php'>Daten Ändern</a-->
                            <a class="logOut" href='/logOut.php'>LogOut</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>


</html>