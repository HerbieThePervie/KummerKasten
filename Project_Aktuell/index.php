<?php
session_start();
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="icon" type="image/x-icon" href="bear.ico">
</head>


<body>
    <div class="container">
        <img class="Logo" src="Logo.png" alt="Italian Trulli">
        <div class="row">
            <div class="login-box">
             <div class="infoMsg"><?php if (isset($_SESSION['infoMsg'])) {echo $_SESSION['infoMsg'];unset($_SESSION['infoMsg']);} ?> </div>
                <div class="login-form">
                    <form action="authenticate.php" method="post">
                        <div class="form-group">
                            <input type="email" name="username" id="username" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="E-Mail" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Passwort" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Muss mindestens eine Zahl, einen Groß- und Kleinbuchstaben sowie mindestens 8 oder mehr Zeichen enthalten." required>
                        </div>

                        <div class="loginbttm">
                            <div class="login-button">
                                <button type="submit" class="loginsubmit">Anmelden</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




</body>

</html>