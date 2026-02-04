<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Asia/Manila');

// Start session at the very beginning of the application
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Define the base path of your application
define('BASE_PATH', __DIR__ . DIRECTORY_SEPARATOR);

// Define the base URL for links (adjust based on your environment)
// For local development in a subdirectory: '/pcbuild'
// For production at domain root: ''
define('BASE_URL', '/pcbuild');

// Include necessary files
require_once BASE_PATH . 'config/database.php'; // Your database connection
require_once BASE_PATH . 'config/google_oauth.php'; // Google OAuth configuration
require_once BASE_PATH . 'app/Router.php';      // The Router class
require_once BASE_PATH . 'app/controllers/BaseController.php'; // Base Controller

// --- Centralized Model Includes ---
require_once BASE_PATH . 'app/models/User.php';
require_once BASE_PATH . 'app/models/Product.php';
require_once BASE_PATH . 'app/models/Order.php';
// --- END Centralized Model Includes ---


// Include Controllers
require_once BASE_PATH . 'app/controllers/HomeController.php';
require_once BASE_PATH . 'app/controllers/ProductController.php';
require_once BASE_PATH . 'app/controllers/AuthController.php';
require_once BASE_PATH . 'app/controllers/CartController.php';
require_once BASE_PATH . 'app/controllers/AiChatController.php';
require_once BASE_PATH . 'app/controllers/BuildController.php';
require_once BASE_PATH . 'app/controllers/CheckoutController.php';
require_once BASE_PATH . 'app/controllers/UserController.php';
require_once BASE_PATH . 'app/controllers/AdminController.php'; // Include the new AdminController

// Create a new Router instance
$router = new Router();

// Define your routes using the new get/post methods
$router->defineRoutes(); // Call the new method to define all routes

// Dispatch the request
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// DEBUG: Uncomment to see routing info
// echo "Request URI: " . $requestUri . "<br>";
// echo "Request Method: " . $requestMethod . "<br>";
// die();

// Pass the PDO object to the dispatch method
$router->dispatch($requestUri, $requestMethod, $pdo);

?>