# KummerKasten
The Kummerkasten is a web-app which allows companys to collect all kind of wishes, complains, ideas, .... from they're employees.

Visual Studio Code Windows: https://code.visualstudio.com/sha/download?build=stable&os=win32-x64-user
MySql Workbench: https://dev.mysql.com/get/Downloads/MySQLGUITools/mysql-workbench-community-8.0.33-winx64.msi
XAMPP: https://sourceforge.net/projects/xampp/files/latest/download
Bootstrap: https://getbootstrap.com/docs/5.1/getting-started/introduction/

Verbindung zu MySql
<?php
$servername = "localhost"; // MySQL-Servername (normalerweise localhost)
$username = "dein_benutzername"; // MySQL-Benutzername
$password = "dein_passwort"; // MySQL-Passwort
$database = "deine_datenbank"; // MySQL-Datenbankname

// Verbindung herstellen
$conn = new mysqli($servername, $username, $password, $database);

// Überprüfen der Verbindung
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}
?>

Suche
<?php
// Annahme: $suchbegriff enthält den Suchbegriff aus dem Eingabefeld

$suchbegriff = $_POST['suchbegriff']; oder $suchbegriff = $_GET['suchbegriff'];

// SQL-Abfrage vorbereiten
$sql = "SELECT * FROM deine_tabelle WHERE spaltenname LIKE '%".$suchbegriff."%'";

// SQL-Abfrage ausführen
$result = $conn->query($sql);

// Tabelle ausgeben
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Spalte 1</th><th>Spalte 2</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["spalte1"]."</td>";
        echo "<td>".$row["spalte2"]."</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Keine Ergebnisse gefunden.";
}

// Verbindung schließen
$conn->close();
?>
