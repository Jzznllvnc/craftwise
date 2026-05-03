<?php

require_once BASE_PATH . 'config/env.php';

loadEnv();

define('DB_HOST', env('DB_HOST', 'localhost'));
define('DB_NAME', env('DB_NAME', 'pcbuild_db'));
define('DB_USER', env('DB_USER', 'root'));
define('DB_PASS', env('DB_PASS', ''));

try {
    // Create a new PDO instance
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,   // Throw exceptions on errors
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch results as associative arrays
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Disable emulation for better security/performance
        ]
    );
    // echo "Database connection successful!"; // Uncomment for testing, then comment out

} catch (PDOException $e) {
    // Handle connection errors
    // In a production environment, you would log this error and display a user-friendly message
    // DO NOT expose raw error messages to the public
    die("Database connection failed: " . $e->getMessage());
}
