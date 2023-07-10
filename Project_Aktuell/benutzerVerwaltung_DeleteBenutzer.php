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

/**
 * Lösche Berechtigungen, Benutzer, Stammdaten, Adresse und Ort 
 */

$benutzer_id = $_GET['ID'];

$deleteSuccess = true;

/**
 * Transaktion beginnen um die Folge der Datenbankoperationen durchzuführen
 */
$connect->begin_transaction();

try {
    /**
     * Lösche Berechtigungen
     */
    $stmt = $connect->prepare("DELETE FROM berechtigungen WHERE Benutzer_id = ?");
    $stmt->bind_param("i", $benutzer_id);
    if (!$stmt->execute()) {
        $deleteSuccess = false;
    }
    $stmt->close();

    /**
     * Hole Stammdaten-ID
     */
    $stmt = $connect->prepare("SELECT stammdaten_ID FROM benutzer WHERE id = ?");
    $stmt->bind_param("i", $benutzer_id);
    if (!$stmt->execute()) {
        $deleteSuccess = false;
    }
    $stmt->bind_result($stammdaten_id);
    $stmt->fetch();
    $stmt->close();

    /**
     * Lösche Benutzer
     */
    $stmt = $connect->prepare("DELETE FROM benutzer WHERE id = ?");
    $stmt->bind_param("i", $benutzer_id);
    if (!$stmt->execute()) {
        $deleteSuccess = false;
    }
    $stmt->close();

    /**
     * Hole Adresse-ID
     */
    $stmt = $connect->prepare("SELECT Adresse_ID FROM stammdaten WHERE id = ?");
    $stmt->bind_param("i", $stammdaten_id);
    if (!$stmt->execute()) {
        $deleteSuccess = false;
    }
    $stmt->bind_result($adresse_id);
    $stmt->fetch();
    $stmt->close();

    /**
     * Lösche Stammdaten
     */
    $stmt = $connect->prepare("DELETE FROM stammdaten WHERE id = ?");
    $stmt->bind_param("i", $stammdaten_id);
    if (!$stmt->execute()) {
        $deleteSuccess = false;
    }
    $stmt->close();

    /**
     * Hole Ort-ID
     */
    $stmt = $connect->prepare("SELECT Ort_ID FROM adresse WHERE id = ?");
    $stmt->bind_param("i", $adresse_id);
    if (!$stmt->execute()) {
        $deleteSuccess = false;
    }
    $stmt->close();

    /**
     * Lösche Adresse
     */
    $stmt = $connect->prepare("DELETE FROM adresse WHERE id = ?");
    $stmt->bind_param("i", $adresse_id);
    if (!$stmt->execute()) {
        $deleteSuccess = false;
    }
    $stmt->close();

    /**
     * Lösche ort
     */
    $stmt = $connect->prepare("DELETE FROM Ort WHERE id = ?");
    $stmt->bind_param("i", $stammdaten_id);
    if (!$stmt->execute()) {
        $deleteSuccess = false;
    }
    $stmt->close();

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



$connect->close();
header('Location: benutzerVerwaltung_Anzeige.php');
