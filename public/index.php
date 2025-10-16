<?php
require_once __DIR__ . '/../controllers/AdminController.php';

// Get the requested URI
$uri = $_SERVER['REQUEST_URI'];

// Remove query string if exists
$uri = strtok($uri, '?');

// Remove project folder and public folder
$uri = str_replace('/EcoSolve/public/index.php', '', $uri);

// Trim slashes
$uri = trim($uri, '/');

// Routing
if ($uri === '' || $uri === 'index.php') {
    echo "Home page"; // or load home view
} elseif ($uri === 'tableau_de_bord') {
    $controller = new AdminController();
    $controller->dashboard(); // loads the dashboard view
} else {
    echo "Page not found: '$uri'";
}
