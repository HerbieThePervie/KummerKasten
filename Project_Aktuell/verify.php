<?php
session_start();
if (!isset($_SESSION['loggedin'], $_SESSION['id'])) {
    header('Location: index.php');
    exit;
}
use OTPHP\TOTP;
require "vendor/autoload.php";
require_once('connect.php');

$id = $_SESSION['id'];

$sql = "SELECT * FROM benutzer WHERE benutzer.id=$id";
$result = mysqli_query($connect, $sql) or die(mysqli_error($connect));
$begriffe = mysqli_fetch_array($result);

$secret = $begriffe['otpSecret'] ;
$input = $_POST['otp'];
$otp = TOTP::createFromSecret($secret); // create TOTP object from the secret.
$check = $otp->verify($input); // Returns true if the input is verified, otherwise false.

if($check){
    header('Location: startseite.php');
} else{
    header('Location: index.php');
}

?>