<?php
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/EcoEvent.php";

class ModelEcoEvent
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createEvent(EcoEvent $event): array
    {
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
    public function searchEvents($ville = null, $categoryId = null): array
    {
        $query = "SELECT e.*, c.category_name 
                FROM eco_event e
                LEFT JOIN category c ON e.category_id = c.id
                WHERE 1=1";
        $params = [];

        if (!empty($ville)) {
            $query .= " AND e.ville = :ville";
            $params[':ville'] = $ville;
        }

        if (!empty($categoryId)) {
            $query .= " AND e.category_id = :category_id";
            $params[':category_id'] = $categoryId;
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getEvents(): array
    {
        $query = "SELECT e.*, c.category_name 
                  FROM eco_event e
                  LEFT JOIN category c ON e.category_id = c.id
                  ORDER BY e.event_date DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
