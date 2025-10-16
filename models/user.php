<?php
require_once __DIR__ . '/../config/database.php';


class User {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // 🔹 Créer un nouvel utilisateur
    public function create($data) {
        $query = "INSERT INTO users (username, email, password, role, status) 
                  VALUES (:username, :email, :password, :role, :status)";
        $stmt = $this->conn->prepare($query);

        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':status', $data['status']);

        return $stmt->execute();
    }

    // 🔹 Obtenir tous les utilisateurs
    public function getAll() {
        $query = "SELECT * FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Obtenir un utilisateur par ID
    public function getById($id) {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 🔹 Mettre à jour un utilisateur
    public function update($id, $data) {
        $query = "UPDATE users SET username = :username, email = :email, role = :role, status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // 🔹 Supprimer un utilisateur
    public function delete($id) {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // 🔹 Validation (activation)
    public function validate($id) {
        $status = "active";
        $query = "UPDATE users SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
