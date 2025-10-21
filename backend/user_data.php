<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'user_id' => $_SESSION['user_id'] ?? 1,
    'user_city' => $_SESSION['user_city'] ?? 'Monastir'  // Fallback ta ville
]);
?>