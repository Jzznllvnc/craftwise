<?php

// Database connection details
// For security, ideally these would come from environment variables (.env file)
// For local XAMPP setup, these are typically:
// DB_HOST = 'localhost'
// DB_NAME = 'pcbuild_db'
// DB_USER = 'root'
// DB_PASS = '' (empty for default XAMPP root user)

// Use a fallback for environment variables, common practice is to load them
// For now, let's define them directly for simplicity.
// In a real production setup, you would load these from a .env file using a library like Dotenv.

// For demonstration purposes, define directly.
// IMPORTANT: In a production environment, NEVER hardcode credentials like this.
// Use environment variables or a proper config management system.
define('DB_HOST', 'localhost');
define('DB_NAME', 'pcbuild_db');
define('DB_USER', 'root');
define('DB_PASS', '');

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
