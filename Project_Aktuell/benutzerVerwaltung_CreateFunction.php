<?php
// Connect to the database
/**
 * Session wird gestartet und überprüft ob der Benutzer eingeloggt ist 
 **/
session_start();
if (!isset($_SESSION['loggedin'], $_SESSION['id'])) {
    header('Location: benutzerVerwaltung_Anzeige.php');
    exit;
}

/**
 * Überprüfung/Aufbau ob einer Verbindung zur Datenbank besteht
 */
require_once('connect.php');

$input_vname = $_POST['vname'];
$input_nname = $_POST['nname'];
$input_email = $_POST['email'];
$input_gebdat = $_POST['bday'];
$input_strasse = $_POST['strasse'];
$input_hsnr = $_POST['hsnr'];
$input_ort = $_POST['Ort'];
$input_plz = $_POST['Zip'];
$input_telnr = $_POST['telnr'];
$input_passwort = $_POST['pwd'];
$hashed_password = password_hash($input_passwort, PASSWORD_DEFAULT);

/**
 * for-Schleife um checkboxxen status abzufragen um diesen korrekt in die DB zu übernehmen
 */
$checkboxValues = array();
for ($i = 1; $i <= 4; $i++) {
    if (isset($_POST['checkbox' . $i])) {
        $checkboxValues[$i] = 1;
    } else {
        $checkboxValues[$i] = 0;
    }
}


$id = $_SESSION['id'];
$berechtigung = "SELECT * from berechtigungen where Benutzer_ID=$id";

$result = mysqli_query($connect, $berechtigung) or die(mysqli_error($connect));
$begriffe = mysqli_fetch_array($result);

/**
 *  Abfrage Benutzer ist kein Admin, Weiterleitung
 */    
    if ($begriffe['Admin'] == 1) {
        
    } else {
       
        header('Location: profil.php');
    }


/**
 * Insert Funktionen um neuen Benutzer zu erstellen um nur geänderte Werte zu aktualisieren
 */

 $createSuccess = true;


 /**
 * Transaktion beginnen um die Folge der Datenbankoperationen durchzuführen
 */
 $connect->begin_transaction();
 
 try {
     // Füge Ort hinzu
     $stmt = $connect->prepare("INSERT INTO ort (ortname, plz) VALUES (?, ?)");
     $stmt->bind_param("ss", $input_ort, $input_plz);
     if (!$stmt->execute()) {
         $createSuccess = false;
     }
     $ort_id = $connect->insert_id;
 
     // Füge Adresse hinzu
     $stmt = $connect->prepare("INSERT INTO adresse (strasse, hausnummer, Ort_ID) VALUES (?, ?, ?)");
     $stmt->bind_param("sss", $input_strasse, $input_hsnr, $ort_id);
     if (!$stmt->execute()) {
         $createSuccess = false;
     }
     $adresse_id = $connect->insert_id;
 
     // Füge Stammdaten hinzu
     $stmt = $connect->prepare("INSERT INTO stammdaten (vorname, nachname, telefonnummer, geburtstag, Adresse_ID) VALUES (?, ?, ?, ?, ?)");
     $stmt->bind_param("sssss", $input_vname, $input_nname, $input_telnr, $input_gebdat, $adresse_id);
     if (!$stmt->execute()) {
         $createSuccess = false;
     }
     $stammdaten_id = $connect->insert_id;
 
     // Füge Benutzer hinzu
     $stmt = $connect->prepare("INSERT INTO benutzer (eMail, passwort, stammdaten_ID) VALUES (?, ?, ?)");
     $stmt->bind_param("ssi", $input_email, $hashed_password, $stammdaten_id);
     if (!$stmt->execute()) {
         $createSuccess = false;
     }
     $benutzer_id = $connect->insert_id;
 
     // Füge Berechtigungen hinzu
     $stmt = $connect->prepare("INSERT INTO berechtigungen (Benutzer_id, ticketUpdate, ticketDelete, profilUpdate, Admin) VALUES (?, ?, ?, ?, ?)");
     $stmt->bind_param("iiiii", $benutzer_id, $checkboxValues[1],$checkboxValues[2],$checkboxValues[3],$checkboxValues[4]);
     if (!$stmt->execute()) {
        $createSuccess = false;
     }
 
      // Commit der Transaktion
      $connect->commit();
      if ($createSuccess) {
          $_SESSION['infoMsg'] = "Datensatz erfolgreich erzeugt!";
          header('Location: benutzerVerwaltung_Anzeige.php');
          exit();
      } 
 } catch (Exception $e) {
      $_SESSION['infoMsg'] = "Fehler: Datensatz konnte nicht erzeugt werden." + $e;
      header('Location: benutzerVerwaltung_Anzeige.php');
      exit();
 }
 


$stmt->close();
$connect->close();
?>