<?php
declare(strict_types=1);

// Enable error reporting for development (adjust for production)
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Include Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;

// Create an instance of our Router
$router = new Router();

// Define routes
$router->get('/', function() {
    echo json_encode(['message' => 'Welcome to the E-Commerce Backend API']);
});

// Example route mapping to a controller action
// This maps the URI '/products' for GET requests to the index() method of ProductController.
$router->get('/products', 'App\\Controller\\ProductController@index');

// Dispatch the current request based on HTTP method and URI
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
