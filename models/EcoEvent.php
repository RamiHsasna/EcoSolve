<?php
class EcoEvent {
    private string $eventName;
    private string $description;
    private string $ville;
    private string $pays;
    private int $categoryId;
    private int $userId;
    private string $eventDate;
    private ?int $participantLimit;
    private string $status = 'pending';

    public function __construct($eventName, $description, $ville, $pays, $categoryId, $userId, $eventDate, $participantLimit = null, $status = 'pending') {
        $this->eventName = $eventName;
        $this->description = $description;
        $this->ville = $ville;
        $this->pays = $pays;
        $this->categoryId = $categoryId;
        $this->userId = $userId;
        $this->eventDate = $eventDate;
        $this->participantLimit = $participantLimit;
        $this->status = $status;
    }

    public function setPhoto($photo) {
        $this->photo = $photo;
    }

    public function toArray() {
        return [
            'event_name' => $this->eventName,
            'description' => $this->description,
            'ville' => $this->ville,
            'pays' => $this->pays,
            'category_id' => $this->categoryId,
            'user_id' => $this->userId,
            'event_date' => $this->eventDate,
            'participant_limit' => $this->participantLimit,
            'status' => $this->status
        ];
    }

    public function show() {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr>
                <th>Nom</th><th>Description</th><th>Ville</th><th>Pays</th>
                <th>Catégorie</th><th>Utilisateur</th><th>Date</th><th>Participants</th><th>Statut</th>
              </tr>";
        echo "<tr>";
        echo "<td>{$this->eventName}</td>";
        echo "<td>{$this->description}</td>";
        echo "<td>{$this->ville}</td>";
        echo "<td>{$this->pays}</td>";
        echo "<td>{$this->categoryId}</td>";
        echo "<td>{$this->userId}</td>";
        echo "<td>{$this->eventDate}</td>";
        echo "<td>{$this->participantLimit}</td>";
        echo "<td>{$this->status}</td>";
        echo "</tr>";
        echo "</table>";
    }
}