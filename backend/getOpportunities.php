<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

require_once __DIR__ . '/../controllers/EcoEventController.php';
require_once __DIR__ . "/../config/database.php";

try {
    $controller = new EcoEventController();
    $events = $controller->getAllEvents();

    // Limit to 4 for the section
    $featuredEvents = array_slice($events, 0, 4);

    // Format for frontend
    $opportunities = array_map(function ($event) {
        return [
            'id' => $event['id'],
            'title' => $event['event_name'],
            'description' => substr($event['description'], 0, 100) . '...',
            'location' => $event['ville'] . ', ' . $event['pays'],
            'date' => date('d/m/Y', strtotime($event['event_date'])),
            'category' => $event['category_name'],
            'image' => 'assets/img/opportunities/default.jpg' // Placeholder image
        ];
    }, $featuredEvents);

    echo json_encode($opportunities);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
