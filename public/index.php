<?php
// Enable error reporting for development (remove or adjust for production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Autoload Composer dependencies
require_once __DIR__ . '/../vendor/autoload.php';

// Simple routing example (you can replace this with a more robust router later)
$requestUri = $_SERVER['REQUEST_URI'];

if ($requestUri === '/' || $requestUri === '/index.php') {
    echo json_encode(['message' => 'Welcome to the E-Commerce Backend API']);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Not Found']);
}
