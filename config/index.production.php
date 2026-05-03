<?php

// Production configuration - Disable error display
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

date_default_timezone_set('Asia/Manila');

// Start session at the very beginning of the application
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Define the base path of your application
define('BASE_PATH', __DIR__ . DIRECTORY_SEPARATOR);

// Define the base URL for links
// Production: Site is at domain root, so use empty string
define('BASE_URL', '');

// Include necessary files
require_once BASE_PATH . 'config/database.php'; // Your database connection
require_once BASE_PATH . 'config/google_oauth.php'; // Google OAuth configuration
require_once BASE_PATH . 'app/Router.php';      // The Router class
require_once BASE_PATH . 'app/controllers/BaseController.php'; // Base Controller

// --- Centralized Model Includes ---
require_once BASE_PATH . 'app/models/User.php';
require_once BASE_PATH . 'app/models/Product.php';
require_once BASE_PATH . 'app/models/Order.php';
require_once BASE_PATH . 'app/models/CartItem.php';
require_once BASE_PATH . 'app/models/Address.php';

// Include Controllers
require_once BASE_PATH . 'app/controllers/HomeController.php';
require_once BASE_PATH . 'app/controllers/ProductController.php';
require_once BASE_PATH . 'app/controllers/AuthController.php';
require_once BASE_PATH . 'app/controllers/CartController.php';
require_once BASE_PATH . 'app/controllers/AiChatController.php';
require_once BASE_PATH . 'app/controllers/BuildController.php';
require_once BASE_PATH . 'app/controllers/CheckoutController.php';
require_once BASE_PATH . 'app/controllers/UserController.php';
require_once BASE_PATH . 'app/controllers/AdminController.php';
require_once BASE_PATH . 'app/controllers/GoogleOAuthController.php';
require_once BASE_PATH . 'app/controllers/PageController.php';

// Create Router instance
$router = new Router();

// Define routes
$router->defineRoutes();

// Dispatch the request
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Pass the PDO object to the dispatch method
$router->dispatch($requestUri, $requestMethod, $pdo);
