<?php
//Datenbank Connection-String Informationen.
$DATABASE_HOST = '10.0.63.10';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'mydb';
/*$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'kummerkasten';*/
//Verbindung zur Datenbank wird aufgebaut.
$connect = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    //Ausgabe des Fehlers
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
?>