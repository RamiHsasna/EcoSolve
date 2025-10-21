<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . "/../config/database.php";
$db = Database::getInstance()->getConnection();

$user_id = $_SESSION['user_id'] ?? $_GET['user_id'] ?? null;
if (!$user_id) {
    echo json_encode(['error' => 'Utilisateur non authentifié']);
    exit;
}
$city = $_GET['city'] ?? $_SESSION['user_city'] ?? '';  // Garde pour futur, mais ignore si vide

// VIRE ce check pour toujours query (pas besoin city maintenant)
// if (empty($city)) {
//     echo json_encode([]);
//     exit;
// }

try {
    $count_only = isset($_GET['count_only']) && $_GET['count_only'] == '1';
    $unread_only = isset($_GET['unread_only']) && $_GET['unread_only'] == '1';

    if ($count_only) {
        // Count rapide (sans jointure)
        $where_read = $unread_only ? 'AND n.is_read = 0' : '';
        $stmt = $db->prepare("
            SELECT COUNT(*) as unread_count
            FROM notifications n
            WHERE n.user_id = :user_id $where_read
            AND n.type IN ('event_created', 'event_update')
            AND n.created_at > DATE_SUB(NOW(), INTERVAL 7 DAY)
        ");
        $stmt->execute(['user_id' => $user_id]);  // Pas de city
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['unread_count'];
        echo json_encode(['unread_count' => (int)$count]);
        exit;  // Arrête tout ici
    }

    // Query full seulement si pas count_only (avec tes modifs tolérantes)
    $where_read = $unread_only ? 'AND n.is_read = 0' : '';
    $stmt = $db->prepare("
        SELECT n.id, n.title, n.message as description, n.link, n.is_read, 
               DATE_FORMAT(n.created_at, '%d %b %Y à %H:%i') as date,
               e.event_name as titre_evenement, e.description as desc_evenement
        FROM notifications n
        LEFT JOIN eco_event e ON e.id = CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(n.link, 'event_id=', -1), '&', 1) AS UNSIGNED)
        WHERE n.user_id = :user_id $where_read AND n.type IN ('event_created', 'event_update')
        AND n.created_at > DATE_SUB(NOW(), INTERVAL 7 DAY)
        ORDER BY n.created_at DESC LIMIT 10
    ");
    $stmt->execute(['user_id' => $user_id]);  // Pas de 'city' ici !
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($notifications as &$notif) {
        $notif['read'] = (bool)$notif['is_read'];
        $notif['title'] = $notif['titre_evenement'] ?? $notif['title'];
        $notif['description'] = $notif['desc_evenement'] ?? $notif['description'];
        $notif['created_at'] = $notif['date'];
        unset($notif['is_read'], $notif['titre_evenement'], $notif['desc_evenement'], $notif['date']);
    }

    echo json_encode($notifications);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur DB : ' . $e->getMessage()]);
}
?>