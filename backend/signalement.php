<?php
require_once __DIR__ . "/../controllers/EcoEventController.php";
require_once __DIR__ . "/../models/modelEcoEvent.php";
require_once __DIR__ . "/../config/database.php";

header('Content-Type: application/json');

try {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Basic validation
        if (empty($_POST['titre']) || empty($_POST['description'])) {
            throw new Exception("Title and description are required");
        }

        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $categorie = $_POST['categorie'] ?? 1;
        // Ensure category exists to avoid foreign key constraint errors
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare('SELECT id FROM category WHERE id = :id LIMIT 1');
            $stmt->execute(['id' => (int)$categorie]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                // Try to pick any existing category as fallback
                $row2 = $db->query('SELECT id FROM category LIMIT 1')->fetch(PDO::FETCH_ASSOC);
                if ($row2 && isset($row2['id'])) {
                    $categorie = (int)$row2['id'];
                } else {
                    // No category exists — create a default one
                    $ins = $db->prepare('INSERT INTO category (category_name, description) VALUES (:name, :desc)');
                    $ins->execute(['name' => 'Uncategorized', 'desc' => 'Auto-created category']);
                    $categorie = (int)$db->lastInsertId();
                }
            }
        } catch (Exception $e) {
            // If DB check fails, rethrow so caller sees the error
            throw $e;
        }
        $pays = $_POST['pays'] ?? '';
        $ville = $_POST['ville'] ?? '';
        
        // Handle file upload
        $photoPath = null;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileName = uniqid() . '_' . basename($_FILES['photo']['name']);
            $uploadFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
                $photoPath = 'uploads/' . $fileName;
            }
        }

        $userId = 1; // TODO: Replace with actual user authentication
        $eventDate = date('Y-m-d H:i:s');
        $participantLimit = null;

        // Ensure user exists to avoid foreign key constraint errors
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare('SELECT id FROM users WHERE id = :id LIMIT 1');
            $stmt->execute(['id' => (int)$userId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                // Create a default user if none exists
                $ins = $db->prepare('INSERT INTO users (username, email, password, ville, pays) VALUES (:username, :email, :password, :ville, :pays)');
                $ins->execute([
                    'username' => 'default_user',
                    'email' => 'default@example.com',
                    'password' => password_hash('password', PASSWORD_DEFAULT),
                    'ville' => 'Default City',
                    'pays' => 'Default Country'
                ]);
                $userId = (int)$db->lastInsertId();
            }
        } catch (Exception $e) {
            // If DB check fails, rethrow so caller sees the error
            throw $e;
        }

        $event = new EcoEvent(
            $titre,
            $description,
            $pays,
            $ville,
            (int)$categorie,
            (int)$userId,
            $eventDate,
            $participantLimit,
            'pending'
        );

        if ($photoPath) {
            $event->setPhoto($photoPath);
        }

        $controller = new EcoEventController();
        $result = $controller->createEvent($event);

        echo json_encode([
            'status' => 'success',
            'message' => 'Event created successfully',
            'data' => $result
        ]);
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
