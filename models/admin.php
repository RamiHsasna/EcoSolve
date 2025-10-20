<?php
require_once __DIR__ . '/../config/database.php';

class Admin {
    private $conn;

    public function __construct() {
        // Use the singleton Database instance
        $this->conn = Database::getInstance()->getConnection();
    }

    // 🔹 Obtenir tous les utilisateurs
    public function getUsers() {
        $query = "SELECT * FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Obtenir toutes les opportunités
    public function getOpportunities() {
        $query = "SELECT e.*, c.category_name, u.username 
                  FROM eco_event e
                  JOIN category c ON e.category_id = c.id
                  JOIN users u ON e.user_id = u.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Mettre à jour le statut d’un utilisateur
    public function updateUserStatus($user_id, $status) {
        $query = "UPDATE users SET status = :status WHERE id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }

    // 🔹 Mettre à jour le statut d’une opportunité
    public function updateOpportunityStatus($event_id, $status) {
        $query = "UPDATE eco_event SET status = :status WHERE id = :event_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':event_id', $event_id);
        return $stmt->execute();
    }

    // Delete a user
    public function deleteUser($userId){
        $query = "DELETE FROM users WHERE id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        return $stmt->execute();
    }

    // Edit user (username, optional email)
    public function editUser($userId, $username, $email = null){
        if($email !== null){
            $query = "UPDATE users SET username = :username, email = :email WHERE id = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':user_id', $userId);
            return $stmt->execute();
        } else {
            $query = "UPDATE users SET username = :username WHERE id = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':user_id', $userId);
            return $stmt->execute();
        }
    }
}
?>
