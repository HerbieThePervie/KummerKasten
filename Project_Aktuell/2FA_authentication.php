<?php
session_start();
if (!isset($_SESSION['loggedin'], $_SESSION['id'])) {
    header('Location: index.php');
    exit;
}



use OTPHP\TOTP;
require "vendor/autoload.php";
require_once('connect.php');

$otp = TOTP::generate();
$secret = $otp->getSecret();
#echo "The OTP secret is: {$secret}\n";

$id = $_SESSION['id'];

$sql = "SELECT * FROM benutzer WHERE benutzer.id=$id";
$result = mysqli_query($connect, $sql) or die(mysqli_error($connect));
$begriffe = mysqli_fetch_array($result);

if ($begriffe['active2FA'] == 1) {
    $_SESSION['infoMsg'] = "2FA ist bereits aktiviert!";
    header('Location: profil.php');
} 

$db_2FAsecret = $begriffe['otpSecret'];

$input_2FAsecret = $secret;


if ( $input_2FAsecret != $db_2FAsecret) {
    $stmt = $connect->prepare("UPDATE benutzer SET benutzer.otpSecret=?, benutzer.active2FA=1 WHERE benutzer.id=$id");
    $stmt->bind_param("s", $input_2FAsecret);
    $stmt->execute();
    #header('Location: profil.php');
    #$_SESSION['infoMsg'] = "2FA erfolgreich aktiviert!";
} else{
    header('Location: profil.php');
}


$stmt->close();
$connect->close();


$otp = TOTP::createFromSecret($secret);
#echo "The current OTP is: {$otp->now()}\n";

// Note: You must set label before generating the QR code
$otp->setLabel('Kummerkasten.at');
$grCodeUri = $otp->getQrCodeUri(
    'https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=[DATA]&chld=M',
    '[DATA]'
);
#echo "<div style='text-align:center;'>  <img src='{$grCodeUri}' style='display:block; margin:auto;' /></div>";
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>2FA-Aktivierung</title>
    <link rel="stylesheet" href="profil.css">
    <link rel="icon" type="image/x-icon" href="bear.ico">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="FA-box">
                <div class="FA-form">
                    <label class="QR-Code-Label">QR-Code mit Authentifizierungs-App einscannen.</label>
                    <?php echo "<div style='text-align:center;'>  <img src='{$grCodeUri}' style='display:block; margin:auto;' /></div>";?>

                    <div class="container-2FA">
                            <div class="checkbox-2FA">
                                <a class="activated2FA" href='/profil.php'>Erledigt & Zurück</a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>




</body>

</html>