<?php
include '../config/database.php';

$message = "";
$showForm = false;

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verify token
    $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token=? AND token_expire > NOW()");
    $stmt->execute([$token]);

    if ($stmt->rowCount() > 0) {
        $showForm = true;

        if (isset($_POST['update'])) {
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            if ($password !== $confirmPassword) {
                $message = "❌ Passwords do not match!";
            } else {
                $newPass = password_hash($password, PASSWORD_BCRYPT);
                $pdo->prepare("UPDATE users SET password=?, reset_token=NULL, token_expire=NULL WHERE reset_token=?")
                    ->execute([$newPass, $token]);
                $message = "✅ Password updated successfully! You can now <a href='index.php'>login</a>.";
                $showForm = false;
            }
        }
    } else {
        $message = "❌ Invalid or expired token.";
    }
} else {
    $message = "❌ No token provided.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .eye-icon {
            position: absolute;
            right: 1rem;
            top: -5px;
            /* move above the input bottom border */
            width: 20px;
            height: 12px;
            border: 2px solid black;
            border-radius: 12px/6px;
            cursor: pointer;
        }

        .eye-icon::after {
            content: '';
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 6px;
            height: 6px;
            background: black;
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="form-title">Reset Your Password</h2>

        <?php if (!empty($message)) echo "<p class='recover' style='text-align:center;'>$message</p>"; ?>

        <?php if ($showForm): ?>
            <form method="POST">
                <div class="input-group">
                    <input type="password" name="password" id="password" placeholder="New Password" required>
                    <label>New Password</label>
                    <div class="eye-icon" onclick="togglePassword('password')"></div>
                </div>
                <div class="input-group">
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                    <label>Confirm Password</label>
                    <div class="eye-icon" onclick="togglePassword('confirm_password')"></div>
                </div>
                <button type="submit" name="update" class="btn">Update Password</button>
            </form>
        <?php endif; ?>
    </div>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === "password" ? "text" : "password";
        }
    </script>
</body>

</html>