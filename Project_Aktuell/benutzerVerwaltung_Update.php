<?php
// Connect to the database
/**
 * Session wird gestartet und überprüft ob der Benutzer eingeloggt ist 
 **/ 
session_start();
if (!isset($_SESSION['loggedin'], $_SESSION['id']))
{
header('Location: benutzerVerwaltung_Anzeige.php');
exit;
}

/**
 * Überprüfung/Aufbau ob einer Verbindung zur Datenbank besteht
 */
require_once('connect.php');

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


$db_vname = $begriffe['vorname'];
$db_nname = $begriffe['nachname'];
$db_email = $begriffe['eMail'];
$db_gebdat = $begriffe['geburtstag'];
$db_strasse = $begriffe['strasse'];
$db_hsnr = $begriffe['hausnummer'];
$db_ort = $begriffe['ortname'];
$db_plz = $begriffe['plz'];
$db_telnr = $begriffe['telefonnummer'];
$db_ticketUpdate = $begriffe['ticketUpdate'];
$db_ticketDelete = $begriffe['ticketDelete'];
$db_profilUpdate = $begriffe['profilUpdate'];
$db_Admin = $begriffe['Admin'];
 
$input_vname = $_POST['vname'];
$input_nname = $_POST['nname'];
$input_email = $_POST['email'];
$input_gebdat = $_POST['bday'];
$input_strasse = $_POST['strasse'];
$input_hsnr = $_POST['hsnr'];
$input_ort = $_POST['Ort'];
$input_plz = $_POST['Zip'];
$input_telnr = $_POST['telnr'];


$checkboxValues = array();
for ($i = 1; $i <= 4; $i++) {
    if (isset($_POST['checkbox' . $i])) {
        $checkboxValues[$i] = 1;
    } else {
        $checkboxValues[$i] = 0;
    }
}


/**
 * Passwort hashen
 */
/*$password = $_POST['passwort'];
$salt = bin2hex(random_bytes(16));
$pepper = bin2hex(random_bytes(16));
$secret_key = bin2hex(random_bytes(32)); 
$hashed_password = hash_hmac('sha256', $salt . $password . $pepper, $secret_key);*/

    /**
     * Abfrage und Updatefunktion um nur geänderte Werte zu aktualisieren
     */
    if ($input_vname != $db_vname || $input_nname != $db_nname || $input_email != $db_email || $input_gebdat != $db_gebdat || $input_strasse != $db_strasse || $input_hsnr != $db_hsnr || $input_ort != $db_ort || $input_plz != $db_plz || $input_telnr != $db_telnr || $checkboxValues[1] != $db_ticketUpdate || $checkboxValues[2] != $db_ticketDelete || $checkboxValues[3] != $db_profilUpdate || $checkboxValues[4] != $db_Admin) {
        $stmt = $connect->prepare("UPDATE benutzer LEFT JOIN stammdaten AS s on benutzer.stammdaten_ID = s.id LEFT JOIN berechtigungen AS b on benutzer.ID = b.Benutzer_id LEFT JOIN adresse AS a on s.Adresse_ID = a.id LEFT JOIN ort AS o on a.Ort_ID = o.id SET s.vorname=?, s.nachname=?,s.telefonnummer=?, b.ticketUpdate=?, b.ticketDelete=?, b.profilUpdate=?, b.Admin=?, benutzer.eMail=?, s.geburtstag=?, a.strasse=?, a.hausnummer=?, o.ortname=?, o.plz=? WHERE benutzer.id=$id");
        $stmt->bind_param("sssssssssssss", $input_vname, $input_nname, $input_telnr,  $checkboxValues[1], $checkboxValues[2], $checkboxValues[3], $checkboxValues[4], $input_email, $input_gebdat, $input_strasse, $input_hsnr, $input_ort, $input_plz);
        $stmt->execute();
        header('Location: benutzerVerwaltung_Anzeige.php');
        $_SESSION['infoMsg'] = "Datensatz erfolgreich geändert!";
    } else{
        header('Location: benutzerVerwaltung_Anzeige.php');
    }


$stmt->close();
$connect->close();
?>