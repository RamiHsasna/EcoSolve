<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . "/../config/database.php";
$db = Database::getInstance()->getConnection();

$user_id = $_SESSION['user_id'] ?? $_POST['user_id'] ?? $_GET['user_id'] ?? null;

if (!$user_id) {
    echo json_encode(['success' => false, 'error' => 'Utilisateur invalide']);
    exit;
}

try {
    $stmt = $db->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = :user_id AND is_read = 0 AND type IN ('event_created', 'event_update')");
    $stmt->execute(['user_id' => $user_id]);
    echo json_encode(['success' => true, 'rows' => $stmt->rowCount()]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>