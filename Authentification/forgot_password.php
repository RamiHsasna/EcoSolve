<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
include '../config/database.php'; // DB connection

$message = ""; // Initialize message

if (isset($_POST['reset'])) {
    $email = $_POST['email'];

    // Check if email exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        $token = bin2hex(random_bytes(50));
        $expire = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Save token and expiry
        $pdo->prepare("UPDATE users SET reset_token=?, token_expire=? WHERE email=?")
            ->execute([$token, $expire, $email]);

        // Reset link
        $resetLink = "http://localhost/EcoSolve/Authentification/reset_password.php?token=$token";

        // Send email via PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'khoiadjatesnim@gmail.com'; // your Gmail
            $mail->Password = 'gpyt qtxj nbqz lrhs';    // your Gmail app password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('your_email@gmail.com', 'EcoSolve Support');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = "Click this link to reset your password:<br><br>
                           <a href='$resetLink'>$resetLink</a><br><br>
                           This link expires in 1 hour.";

            $mail->send();
            $message = "✅ A reset link has been sent to your email.";
        } catch (Exception $e) {
            $message = "❌ Email could not be sent. Error: {$mail->ErrorInfo}";
        }
    } else {
        $message = "❌ Email not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2 class="form-title">Forgot Password</h2>

        <!-- Centered message -->
        <?php if (!empty($message)) echo "<p class='recover' style='text-align:center;'>$message</p>"; ?>

        <form method="POST">
            <div class="input-group">
                <input type="email" name="email" placeholder="Enter your email" required>
                <label>Email</label>
            </div>
            <button type="submit" name="reset" class="btn">Send Reset Link</button>
        </form>
    </div>
</body>

</html>