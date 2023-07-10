<?php
session_start();
if (!isset($_SESSION['loggedin'], $_SESSION['id'])) {
    header('Location: ticketErfassen.php');
    exit;
}
include("benutzerVerwaltung.php");

$id = $_SESSION['id'];
$berechtigung = "SELECT * from berechtigungen where Benutzer_ID=$id";

$result = mysqli_query($connect, $berechtigung) or die(mysqli_error($connect));
$begriffe = mysqli_fetch_array($result);


if ($begriffe['Admin'] == 1) {
} else {
    // Benutzer ist kein Admin, Weiterleitung
    header('Location: profil.php');
}

?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Profilseite</title>
    <link rel="stylesheet" href="benutzerVerwaltung.css">
    <link rel="icon" type="image/x-icon" href="bear.ico">

    <nav class="horizontal-menu plain">
        <ul>
            <li><a href='/startseite.php'>Startseite</a></li>
            <li><a href='/ticketErfassen.php'>Tickets</a></li>
            <li class="active"><a href='/benutzerVerwaltung_Anzeige.php'>Benutzerverwaltung</a></li>
            <li><a href='/benutzerVerwaltung_CreatePage.php'>Benutzer erstellen</a></li>
            <li><a href='/profil.php'>Profil</a></li>
        </ul>
    </nav>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <?php if (isset($_SESSION['infoMsg'])) {
                    echo $_SESSION['infoMsg'];
                    unset($_SESSION['infoMsg']);
                } ?>
                <div class="table-responsive">
                    <table id="myTable2" class="table table-bordered">
                        <thead>
                            <tr>
                                <th onclick="sortTable(0)">ID</th>
                                <th onclick="sortTable(1)">Benutzername</th>
                                <th>Passwort</th>
                                <th>Aktionen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (is_array($fetchData)) {
                                $sn = 1;
                                foreach ($fetchData as $data) {
                            ?>
                                    <tr>
                                        <td><?php echo $data['ID'] ?? ''; ?></td>
                                        <td><?php echo $data['eMail'] ?? ''; ?></td>
                                        <td><?php echo '*********************' ?? ''; ?></td>
                                        <td><?php echo "<a href='benutzerVerwaltung_UpdateBenutzer.php?ID=" . $data['ID'] . "'>Bearbeiten</a> <a> | </a> <a href='benutzerVerwaltung_DeleteBenutzer.php?ID=" . $data['ID'] . "'>Löschen</a>"; ?></td>
                                    </tr>
                                <?php
                                    $sn++;
                                }
                            } else { ?>
                                <tr>
                                    <td colspan="8">
                                        <?php echo $fetchData; ?>
                                    </td>
                                <tr>
                                <?php
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("myTable2");
        switching = true;
        // Set the sorting direction to ascending:
        dir = "asc";
        /* Make a loop that will continue until
        no switching has been done: */
        while (switching) {
            // Start by saying: no switching is done:
            switching = false;
            rows = table.rows;
            /* Loop through all table rows (except the
            first, which contains table headers): */
            for (i = 1; i < (rows.length - 1); i++) {
                // Start by saying there should be no switching:
                shouldSwitch = false;
                /* Get the two elements you want to compare,
                one from current row and one from the next: */
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                /* Check if the two rows should switch place,
                based on the direction, asc or desc: */
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        // If so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        // If so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                /* If a switch has been marked, make the switch
                and mark that a switch has been done: */
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                // Each time a switch is done, increase this count by 1:
                switchcount++;
            } else {
                /* If no switching has been done AND the direction is "asc",
                set the direction to "desc" and run the while loop again. */
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
</script>

</html>