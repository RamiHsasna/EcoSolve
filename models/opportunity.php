<?php
require_once __DIR__ . '/../config/database.php';


class Opportunity {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // 🔹 Créer une opportunité
    public function create($data) {
        $query = "INSERT INTO eco_event (event_name, description, ville, category_id, user_id, status)
                  VALUES (:event_name, :description, :ville, :category_id, :user_id, :status)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':event_name', $data['event_name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':ville', $data['ville']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':status', $data['status']);
        return $stmt->execute();
    }

    // 🔹 Récupérer toutes les opportunités
    public function getAll() {
        $query = "SELECT e.*, c.category_name, u.username 
                  FROM eco_event e
                  JOIN category c ON e.category_id = c.id
                  JOIN users u ON e.user_id = u.id
                  ORDER BY e.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Récupérer une opportunité par ID
    public function getById($id) {
        $query = "SELECT * FROM eco_event WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 🔹 Mettre à jour une opportunité
    public function update($id, $data) {
        $query = "UPDATE eco_event SET event_name = :event_name, description = :description,
                  ville = :ville, category_id = :category_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':event_name', $data['event_name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':ville', $data['ville']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // 🔹 Supprimer une opportunité
    public function delete($id) {
        $query = "DELETE FROM eco_event WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // 🔹 Valider (approuver)
    public function validate($id) {
        $status = "approved";
        $query = "UPDATE eco_event SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
