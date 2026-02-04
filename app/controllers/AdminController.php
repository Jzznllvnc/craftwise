<?php

require_once BASE_PATH . 'app/controllers/BaseController.php';
require_once BASE_PATH . 'app/models/Product.php';
require_once BASE_PATH . 'app/models/User.php';
require_once BASE_PATH . 'app/models/Order.php';

class AdminController extends BaseController
{
    protected $productModel;
    protected $userModel;
    protected $orderModel;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->productModel = new Product($pdo);
        $this->userModel = new User($pdo);
        $this->orderModel = new Order($pdo);

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            $_SESSION['error'] = 'Access denied. You must be an administrator to access this section.';
            header('Location: ' . BASE_URL . '/login');
            exit();
        }
    }

    public function dashboard()
    {
        $thirtyDaysAgo = date('Y-m-d H:i:s', strtotime('-30 days'));

        // Fetch Dashboard Data for top cards
        $newOrders = $this->orderModel->getTotalOrders($thirtyDaysAgo);
        $totalIncome = $this->orderModel->getTotalRevenue($thirtyDaysAgo);
        $totalCustomers = $this->userModel->getTotalUsersRegistered();
        $pendingDelivery = $this->orderModel->getPendingOrders($thirtyDaysAgo);
        $totalExpense = $this->productModel->getTotalInventoryValue();
        $newUser = $totalCustomers;
        $currentYear = date('Y');
        $monthlyRevenueData = $this->orderModel->getMonthlyRevenue($currentYear);
        $monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $monthlyDataValues = array_values($monthlyRevenueData);
        $yearlyStatsTotal = array_sum($monthlyDataValues);

        $data = [
            'title' => 'Admin Dashboard',
            'newOrders' => $newOrders,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'newUser' => $newUser,
            'yearlyStatsTotal' => $yearlyStatsTotal,
            'monthlyLabels' => json_encode($monthlyLabels),
            'monthlyDataValues' => json_encode($monthlyDataValues),
        ];
        $this->view('admin/dashboard', $data);
    }

    public function products()
    {
        unset($_SESSION['success']);
        unset($_SESSION['error']);
        
        $category = $_GET['category'] ?? null;
        $search = $_GET['search'] ?? null;
        $products = $this->productModel->getProducts(10000, 0, $category, $search);

        $data = [
            'title' => 'Manage Products',
            'products' => $products,
            'currentCategory' => $category,
            'currentSearch' => $search,
        ];

        $this->view('admin/products/index', $data);
    }

    public function createProductForm()
    {
        $data = [
            'title' => 'Add New Product',
            'error' => $_SESSION['error'] ?? null
        ];
        unset($_SESSION['error']);
        $this->view('admin/products/create', $data);
    }

    public function createProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Invalid request.';
            header('Location: ' . BASE_URL . '/admin/products/create');
            exit();
        }

        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'price' => (float)($_POST['price'] ?? 0),
            'image_url' => '',
            'category' => trim($_POST['category'] ?? ''),
            'stock' => (int)($_POST['stock'] ?? 0),
            'additional_details' => trim($_POST['additional_details'] ?? '')
        ];

        // Basic validation
        if (empty($data['name']) || empty($data['price']) || $data['price'] <= 0 || empty($data['category'])) {
            $_SESSION['error'] = 'Name, price (must be positive), and category are required.';
            header('Location: ' . BASE_URL . '/admin/products/create');
            exit();
        }
        if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->handleImageUpload($_FILES['image_upload']);
            if ($uploadResult['success']) {
                $data['image_url'] = $uploadResult['file_path'];
            } else {
                $_SESSION['error'] = $uploadResult['error_message'];
                header('Location: ' . BASE_URL . '/admin/products/create');
                exit();
            }
        } else {
            $data['image_url'] = 'https://placehold.co/300x300/e2e8f0/475569?text=No+Image';
        }
        $productId = $this->productModel->createProduct(
            $data['name'],
            $data['description'],
            $data['price'],
            $data['image_url'],
            $data['category'],
            $data['stock'],
            $data['additional_details']
        );


        if ($productId) {
            header('Location: ' . BASE_URL . '/admin/products?success_msg=' . urlencode('Product "' . htmlspecialchars($data['name']) . '" added successfully!'));
            exit();
        } else {
            $_SESSION['error'] = 'Failed to add product. Please try again.';
            header('Location: ' . BASE_URL . '/admin/products/create');
            exit();
        }
    }

    /**
     * Displays the form to edit an existing product.
     * @param int $id Product ID.
     */
    public function editProductForm($id)
    {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            $_SESSION['error'] = 'Product not found.';
            header('Location: ' . BASE_URL . '/admin/products');
            exit();
        }

        $data = [
            'title' => 'Edit Product: ' . htmlspecialchars($product['name']),
            'product' => $product,
            'error' => $_SESSION['error'] ?? null
        ];
        unset($_SESSION['error']);
        $this->view('admin/products/edit', $data);
    }

    /**
     * Handles the submission of the edit product form.
     * @param int $id Product ID.
     */
    public function updateProduct($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Invalid request.';
            header('Location: ' . BASE_URL . '/admin/products/edit/' . $id);
            exit();
        }

        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'price' => (float)($_POST['price'] ?? 0),
            'image_url' => null,
            'category' => trim($_POST['category'] ?? ''),
            'stock' => (int)($_POST['stock'] ?? 0),
            'additional_details' => trim($_POST['additional_details'] ?? '')
        ];

        // Basic validation
        if (empty($data['name']) || empty($data['price']) || $data['price'] <= 0 || empty($data['category'])) {
            $_SESSION['error'] = 'Name, price (must be positive), and category are required.';
            header('Location: ' . BASE_URL . '/admin/products/edit/' . $id);
            exit();
        }
        
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            $_SESSION['error'] = 'Product not found during update.';
            header('Location: ' . BASE_URL . '/admin/products');
            exit();
        }
        $data['image_url'] = $product['image_url'];

        if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->handleImageUpload($_FILES['image_upload']);
            if ($uploadResult['success']) {
                if (!empty($product['image_url']) && strpos($product['image_url'], 'https://placehold.co/') === false) {
                    $oldImagePath = BASE_PATH . str_replace('/pcbuild', '', $product['image_url']);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $data['image_url'] = $uploadResult['file_path'];
            } else {
                $_SESSION['error'] = $uploadResult['error_message'];
                header('Location: ' . BASE_URL . '/admin/products/edit/' . $id);
                exit();
            }
        }
        $updated = $this->productModel->updateProduct(
            $id,
            $data['name'],
            $data['description'],
            $data['price'],
            $data['image_url'],
            $data['category'],
            $data['stock'],
            $data['additional_details']
        );

        if ($updated) {
            header('Location: ' . BASE_URL . '/admin/products?success_msg=' . urlencode('Product "' . htmlspecialchars($data['name']) . '" updated successfully!'));
            exit();
        } else {
            $_SESSION['error'] = 'Failed to update product. Please try again or check if changes were made.';
            header('Location: ' . BASE_URL . '/admin/products/edit/' . $id);
            exit();
        }
    }

    /**
     * Handles product deletion.
     * @param int $id Product ID.
     */
    public function deleteProduct($id)
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Invalid request method for deletion.']);
            http_response_code(400);
            exit();
        }

        // Check if user is logged in and is admin
        if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            echo json_encode(['error' => 'Authentication required or not an admin.']);
            http_response_code(403);
            return;
        }
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo json_encode(['error' => 'Product not found.']);
            http_response_code(404); // Not Found
            return;
        }
        if (!empty($product['image_url']) && strpos($product['image_url'], 'https://placehold.co/') === false) {
            $imagePath = BASE_PATH . str_replace('/pcbuild', '', $product['image_url']);
            if (file_exists($imagePath)) {
                $deletedFile = @unlink($imagePath); 
                if (!$deletedFile) {
                }
            }
        }

        $deleted = $this->productModel->deleteProduct($id);

        if ($deleted === 'referenced') {
            $_SESSION['error'] = 'Cannot delete product: It is linked to existing orders.';
            header('Location: ' . BASE_URL . '/admin/products');
            exit();
        } elseif ($deleted) {
            header('Location: ' . BASE_URL . '/admin/products?success_msg=' . urlencode('Product deleted successfully!'));
            exit();
        } else {
            $_SESSION['error'] = 'Failed to delete product. It might not exist or a database error occurred.';
            header('Location: ' . BASE_URL . '/admin/products');
            exit();
        }
    }

    /**
     * Helper function to handle image uploads.
     * @param array
     * @return array
     */
    private function handleImageUpload($file)
    {
        $targetDir = BASE_PATH . 'app/views/products/images/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = basename($file["name"]);
        $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $uniqueFileName = uniqid('product_', true) . '.' . $imageFileType;
        $targetFilePath = $targetDir . $uniqueFileName;
        $relativePathForDb = '/app/views/products/images/' . $uniqueFileName;

        $maxFileSize = 2 * 1024 * 1024;
        $allowedTypes = ['jpg', 'png', 'jpeg', 'gif', 'webp'];

        if ($file["size"] > $maxFileSize) {
            return ['success' => false, 'error_message' => 'Sorry, your file is too large (max 2MB).'];
        }

        if (!in_array($imageFileType, $allowedTypes)) {
            return ['success' => false, 'error_message' => 'Sorry, only JPG, JPEG, PNG, GIF, & WEBP files are allowed.'];
        }

        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            return ['success' => true, 'file_path' => $relativePathForDb];
        } else {
            return ['success' => false, 'error_message' => 'Sorry, there was an error uploading your file.'];
        }
    }

    // User Management Methods
    /**
     * Displays the list of users.
     * @param string|null $search_term Optional term to search by username or email.
     */
    public function manageUsers($search_term = null)
    {
        unset($_SESSION['success']);
        unset($_SESSION['error']);

        $searchTerm = $_GET['search'] ?? $search_term ?? '';
        $searchTerm = trim($searchTerm);

        $users = $this->userModel->getAllUsers($searchTerm);

        $data = [
            'title' => 'Manage Users',
            'users' => $users,
        ];

        $this->view('admin/users/index', $data);
    }

    /**
     * Toggles the ban status of a user.
     * @param int $userId The ID of the user to ban/unban.
     */
    public function toggleUserBan($userId)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request method.'], 405);
            return;
        }

        // Ensure user is admin (redundant with constructor, but good for specific actions)
        if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            $this->jsonResponse(['success' => false, 'error' => 'Authentication required or not an admin.'], 403);
            return;
        }

        $user = $this->userModel->findById($userId);

        if (!$user) {
            $this->jsonResponse(['success' => false, 'error' => 'User not found.'], 404);
            return;
        }

        // Prevent banning/deleting oneself if user_id is the current admin's ID
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $userId) {
            $this->jsonResponse(['success' => false, 'error' => 'You cannot ban or delete your own admin account.'], 403);
            return;
        }

        if ($user['is_banned']) {
            if ($this->userModel->unbanUser($userId)) {
                $this->jsonResponse(['success' => true, 'message' => 'User ' . htmlspecialchars($user['username']) . ' has been unbanned.']);
            } else {
                $this->jsonResponse(['success' => false, 'error' => 'Failed to unban user ' . htmlspecialchars($user['username']) . '.'], 500);
            }
        } else {
            if ($this->userModel->banUser($userId)) {
                $this->jsonResponse(['success' => true, 'message' => 'User ' . htmlspecialchars($user['username']) . ' has been banned.']);
            } else {
                $this->jsonResponse(['success' => false, 'error' => 'Failed to ban user ' . htmlspecialchars($user['username']) . '.'], 500);
            }
        }
    }

    /**
     * Deletes a user account.
     * @param int $userId The ID of the user to delete.
     */
    public function deleteUserAccount($userId)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request method.'], 405);
            return;
        }

        // Ensure user is admin (redundant with constructor, but good for specific actions)
        if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            $this->jsonResponse(['success' => false, 'error' => 'Authentication required or not an admin.'], 403);
            return;
        }

        $user = $this->userModel->findById($userId);

        if (!$user) {
            $this->jsonResponse(['success' => false, 'error' => 'User not found.'], 404);
            return;
        }

        // Prevent banning/deleting oneself if user_id is the current admin's ID
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $userId) {
            $this->jsonResponse(['success' => false, 'error' => 'You cannot ban or delete your own admin account.'], 403);
            return;
        }

        if ($this->userModel->deleteUser($userId)) {
            $this->jsonResponse(['success' => true, 'message' => 'User ' . htmlspecialchars($user['username']) . ' and all associated data have been deleted.']);
        } else {
            $this->jsonResponse(['success' => false, 'error' => 'Failed to delete user ' . htmlspecialchars($user['username']) . '.'], 500);
        }
    }

    /**
     * Displays a user's order history.
     * @param int $userId The ID of the user whose orders to display.
     */
    public function viewUserOrders($userId)
    {
        $user = $this->userModel->findById($userId);
        if (!$user) {
            $_SESSION['error'] = 'User not found.';
            header('Location: ' . BASE_URL . '/admin/users');
            exit();
        }

        $orders = $this->orderModel->getOrdersByUserId($userId);

        $data = [
            'title' => 'Order History for ' . htmlspecialchars($user['username']),
            'user' => $user,
            'orders' => $orders
        ];
        $this->view('admin/users/orders', $data);
    }
}