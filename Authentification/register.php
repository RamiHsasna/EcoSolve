<?php
include '../config/database.php'; // this defines the Database class
session_start();

// Get database connection
try {
    $pdo = Database::getInstance()->getConnection();
} catch (Exception $e) {
    die("Database connection failed: " . $e->getMessage());
}

if (isset($_POST['signUp'])) {
    $username   = trim($_POST['username']);
    $email      = trim($_POST['email']);
    $password   = md5($_POST['password']);
    $ville      = trim($_POST['ville']);
    $pays       = trim($_POST['pays']);
    $user_type  = 'user';        // default value
    $status     = 1;             // active by default
    $created_at = date('Y-m-d H:i:s');

    // Check if username OR email exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
    $stmt->execute([$email, $username]);

    if ($stmt->rowCount() > 0) {
        echo "Username or Email already exists!";
    } else {
        $insert = $pdo->prepare("INSERT INTO users (username, email, password, ville, pays, user_type, status, created_at) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($insert->execute([$username, $email, $password, $ville, $pays, $user_type, $status, $created_at])) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error inserting user!";
        }
    }
}

if (isset($_POST['signIn'])) {
    $email    = trim($_POST['email']);
    $password = md5($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->execute([$email, $password]);

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['email'] = $user['email'];
        $_SESSION['username'] = $user['username']; // store username for homepage
        header("Location: http://localhost/EcoSolve/Desktop/EcoSolve-20251011T090541Z-1-001/EcoSolve/index.html");
        exit();
    } else {
        echo "Incorrect Email or Password!";
    }
}
