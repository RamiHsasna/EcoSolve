<?php
require_once __DIR__ . "/../controllers/EcoEventController.php";
header('Content-Type: application/json');

$ville = $_GET['ville'] ?? null;
$categoryId = $_GET['category_id'] ?? null;

$controller = new EcoEventController();
$events = $controller->search($ville, $categoryId);

echo json_encode([
    'status' => 'success',
    'data' => $events
]);
?>
