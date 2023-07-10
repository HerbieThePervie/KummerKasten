<?php
// Connect to the database
/**
 * Session wird gestartet und überprüft ob der Benutzer eingeloggt ist 
 **/ 
session_start();
if (!isset($_SESSION['loggedin'], $_SESSION['id']))
{
header('Location: ticketErfassen.php');
exit;
}

/**
 * Überprüfung/Aufbau ob einer Verbindung zur Datenbank besteht
 */
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


$db_vname = $begriffe['vorname'];
$db_nname = $begriffe['nachname'];
$db_email = $begriffe['eMail'];
$db_gebdat = $begriffe['geburtstag'];
$db_strasse = $begriffe['strasse'];
$db_hsnr = $begriffe['hausnummer'];
$db_ort = $begriffe['ortname'];
$db_plz = $begriffe['plz'];
$db_telnr = $begriffe['telefonnummer'];
$db_2FA = $begriffe['active2FA'];

$input_vname = $_POST['vname'];
$input_nname = $_POST['nname'];
$input_email = $_POST['email'];
$input_gebdat = $_POST['bday'];
$input_strasse = $_POST['strasse'];
$input_hsnr = $_POST['hsnr'];
$input_ort = $_POST['Ort'];
$input_plz = $_POST['Zip'];
$input_telnr = $_POST['telnr'];

$checkboxValue = $_POST['checkbox1'];
    if (isset($checkboxValue)) {
        $checkboxValue = 1;
    } else {
        $checkboxValue = 0;
    }

    /**
     * Abfrage und Updatefunktion um nur geänderte Werte zu aktualisieren
     */
    if ($input_vname != $db_vname || $input_nname != $db_nname || $input_email != $db_email || $input_gebdat != $db_gebdat || $input_strasse != $db_strasse || $input_hsnr != $db_hsnr || $input_ort != $db_ort || $input_plz != $db_plz || $input_telnr != $db_telnr || $checkboxValue != $db_2FA) {
        $stmt = $connect->prepare("UPDATE benutzer LEFT JOIN stammdaten AS s on benutzer.stammdaten_ID = s.id LEFT JOIN adresse AS a on s.Adresse_ID = a.id LEFT JOIN ort AS o on a.Ort_ID = o.id SET s.vorname=?, s.nachname=?,s.telefonnummer=?, benutzer.active2FA=?, benutzer.eMail=?, s.geburtstag=?, a.strasse=?, a.hausnummer=?, o.ortname=?, o.plz=? WHERE benutzer.id=$id");
        $stmt->bind_param("ssssssssss", $input_vname, $input_nname, $input_telnr, $checkboxValue, $input_email, $input_gebdat, $input_strasse, $input_hsnr, $input_ort, $input_plz);
        $stmt->execute();
        header('Location: profil.php');
        $_SESSION['infoMsg'] = "Datensatz erfolgreich geändert!";
    } else{
        header('Location: profil.php');
    }

$stmt->close();
$connect->close();
?>