<?php
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/EcoEvent.php";

class ModelEcoEvent {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createEvent(EcoEvent $event) {
        try {
            $data = $event->toArray();
            
            $sql = "INSERT INTO eco_event (
                event_name, description, ville, pays, 
                category_id, user_id, event_date, 
                participant_limit, status
            ) VALUES (
                :event_name, :description, :ville, :pays,
                :category_id, :user_id, :event_date,
                :participant_limit, :status
            )";

            $stmt = $this->db->prepare($sql);
            $stmt->execute($data);

            return [
                'id' => $this->db->lastInsertId(),
                'event' => $data
            ];
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }
}
?>
