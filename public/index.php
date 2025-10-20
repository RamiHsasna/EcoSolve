<?php
require_once __DIR__ . '/../controllers/AdminController.php';

// If called with query params controller & action, dispatch to controller
if (isset($_GET['controller'])) {
    $controllerName = $_GET['controller'];
    $action = $_GET['action'] ?? 'dashboard';
    if ($controllerName === 'admin') {
        $controller = new AdminController();
        if (method_exists($controller, $action)) {
            // call the action and exit (controller methods will echo/return JSON or redirect)
            $controller->{$action}();
            exit;
        } else {
            header("HTTP/1.1 404 Not Found");
            echo "Unknown action: " . htmlspecialchars($action);
            exit;
        }
    }
}

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
