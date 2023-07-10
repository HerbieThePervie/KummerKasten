<?php
if(isset($_POST['email']) && !empty($_POST['email'])){
    $email = $_POST['email'];
    // check if email exists in database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if($user){
        // email exists, generate a unique token and store it in the database along with the email
        $token = bin2hex(random_bytes(16));
        $stmt = $pdo->prepare("INSERT INTO password_resets (email, token) VALUES (?, ?)");
        $stmt->execute([$email, $token]);
        // send an email to the user with a link to reset their password, including the token as a parameter
        $to = $email;
        $subject = "Reset your password";
        $message = "Click on the following link to reset your password: http://example.com/reset_password.php?token=" . $token;
        mail($to, $subject, $message);
    }
}
?>
