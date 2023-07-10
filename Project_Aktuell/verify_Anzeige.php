<!DOCTYPE html>
<html>

<head>
    <title>Code Eingabe</title>
    <link rel="stylesheet" href="login.css">
    <link rel="icon" type="image/x-icon" href="bear.ico">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="login-box">
                <div class="FA-box">
                    <form action="verify.php" method="post">
                        <div class="form-group">
                            <label class="QR-Code-Label" >Bitte geben Sie Ihren 6-stelligen Code ein: </label>
                            <input type="text" name="otp" pattern="[0-9]{6}" class="AuthCode" title="Bitte den 6-stelligen Code eingeben" required>
                        </div>
                        <div class="loginbttm">
                            <div class="login-button">
                                <input class="loginsubmit" type="submit" value="Absenden">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>