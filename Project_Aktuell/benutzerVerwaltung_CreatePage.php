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

<script>
    /**
     * 
     */
    function checkPasswords() {
        var pwd = document.getElementById("pwd").value;
        var pwdConfirm = document.getElementById("pwdConfirm").value;

        if (pwd != pwdConfirm) {
        alert("Passwörter stimmen nicht überein!");
        return false;
    }
    return true;
}

</script>

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
            <li class="active"><a href='/benutzerVerwaltung_CreatePage.php'>Benutzer erstellen</a></li>
            <li><a href='/profil.php'>Profil</a></li>
        </ul>
    </nav>
</head>

<body>
    <?php if (isset($_SESSION['duplicateEmail'])) { echo $_SESSION['duplicateEmail'] ?? ''; unset($_SESSION['duplicateEmail']); } ?>
    <div class="container">
        <div class="row">
            <div class="profil-box">
                <div class="profil-form">
                    <form action="benutzerVerwaltung_CreateFunction.php" method="post" onsubmit="return checkPasswords()">
                        <div class="form-group">
                            <input class="Edit" type="text" name="vname" placeholder="Vorname" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input class="Edit" type="text" name="nname" placeholder="Nachname" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input class="Edit" type="email" name="email" placeholder="E-Mail" pattern="[^ @]*@[^ @]*" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input class="Edit" type="password" name="pwd" id="pwd" placeholder="neues Passwort" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Muss mindestens eine Zahl, einen Groß- und Kleinbuchstaben sowie mindestens 8 oder mehr Zeichen enthalten." onclick="(this.type='text')" onblur="(this.type='password')" required>
                        </div>
                        <div class="form-group">
                            <input class="Edit" type="password" name="pwdConfirm" id="pwdConfirm" placeholder="Passwort wiederholen" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Muss mindestens eine Zahl, einen Groß- und Kleinbuchstaben sowie mindestens 8 oder mehr Zeichen enthalten." onclick="(this.type='text')" onblur="(this.type='password')" required>
                        </div>
                        <div class="form-group">
                            <input class="Edit" type="date" name="bday" placeholder="Geburtstag">
                        </div>
                        <div class="form-group">
                            <input class="Edit" type="text" name="strasse" placeholder="Straße" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input class="Edit" type="text" name="hsnr" maxlength="4" placeholder="Hausnummer" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input class="Edit" type="text" name="Ort" placeholder="Ort" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input class="Edit" type="text" name="Zip" maxlength="6" placeholder="Postleitzahl" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input type="tel" name="telnr" placeholder="Telefonnummer" pattern="\+[0-9]{2} [0-9]{3} [0-9]{3} [0-9]{4}" maxlength="16" title="Bitte nach dem Format +43 123 456 7890 eingeben" required autocomplete="off">
                        </div>

                        <div class="container-checkbox">
                            <div class="checkbox-container">
                                <input type="checkbox" id="checkbox1" name="checkbox1">
                                <label for="ticketUpdate"> Ticket Update</label>
                            </div>
                            <div class="checkbox-container">
                                <input type="checkbox" id="checkbox2" name="checkbox2">
                                <label for="ticketDelete"> Ticket Löschen</label>
                            </div>
                            <div class="checkbox-container">
                                <input type="checkbox" id="checkbox3" name="checkbox3">
                                <label for="profilUpdate"> Profil Update</label>
                            </div>
                            <div class="checkbox-container">
                                <input type="checkbox" id="checkbox4" name="checkbox4">
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