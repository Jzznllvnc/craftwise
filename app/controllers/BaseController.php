<?php

class BaseController
{
    protected $pdo;

    /**
     *
     * All child controllers will inherit this constructor.
     * @param PDO $pdo The PDO database connection object.
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * This now directly includes the header, view file, and footer.
     * @param string $viewPath Path to the view file (e.g., 'home', 'products/list')
     * @param array $data Data to pass to the view
     */
    protected function view($viewPath, $data = [])
    {
        extract($data);

        $filePath = BASE_PATH . 'app/views/' . str_replace('.', '/', $viewPath) . '.php';

        if (!file_exists($filePath)) {
            die("View file not found: " . $filePath);
        }

        require_once BASE_PATH . 'includes/header.php';
        require_once $filePath;
        require_once BASE_PATH . 'includes/footer.php';
    }

    /**
     *
     * @param array $data The data array to be encoded as JSON.
     * @param int $statusCode The HTTP status code to send (default: 200 OK).
     */
    protected function jsonResponse(array $data, int $statusCode = 200)
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($statusCode);
        echo json_encode($data);
        exit();
    }
}