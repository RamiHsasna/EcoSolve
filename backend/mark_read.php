<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . "/../config/database.php";
$db = Database::getInstance()->getConnection();

$user_id = $_SESSION['user_id'] ?? $_POST['user_id'] ?? $_GET['user_id'] ?? null;
$notif_id = $_POST['notif_id'] ?? $_GET['notif_id'] ?? 0;

if (!$user_id || $notif_id < 1) {
    echo json_encode(['success' => false, 'error' => 'ID ou utilisateur invalide']);
    exit;
}

try {
    $stmt = $db->prepare("UPDATE notifications SET is_read = 1 WHERE id = :id AND user_id = :user_id");
    $stmt->execute(['id' => $notif_id, 'user_id' => $user_id]);
    echo json_encode(['success' => true, 'rows' => $stmt->rowCount()]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>