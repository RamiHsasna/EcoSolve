<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecosolve_db";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Connected silently
} catch (PDOException $e) {
    // Log the technical error for debugging (optional)
    error_log("Database connection error: " . $e->getMessage());

    // Show a user-friendly message
    echo "<p style='color:red; text-align:center; margin-top:20px;'>
            ❌ Unable to connect to the database. Please try again later.
          </p>";
    exit;
}
