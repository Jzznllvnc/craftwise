<?php

require_once BASE_PATH . 'app/controllers/BaseController.php';
require_once BASE_PATH . 'app/models/User.php';
require_once BASE_PATH . 'app/models/Order.php';
require_once BASE_PATH . 'app/models/Address.php';

class UserController extends BaseController
{
    protected $userModel;
    protected $orderModel;
    protected $addressModel;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->userModel = new User($pdo);
        $this->orderModel = new Order($pdo);
        $this->addressModel = new Address($pdo);
    }

    public function orderhistory()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'You must be logged in to view your orders.';
            header('Location: ' . BASE_URL . '/login');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $username = $_SESSION['username'];

        // Fetch user's orders
        $userOrders = $this->orderModel->getOrdersByUserId($userId);

        $data = [
            'title' => 'My Orders',
            'username' => $username,
            'orders' => $userOrders
        ];

        $this->view('user/orderhistory', $data);
    }

    public function profile()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'You must be logged in to view your profile.';
            header('Location: ' . BASE_URL . '/login');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $user = $this->userModel->findById($userId);

        if (!$user) {
            $_SESSION['error'] = 'User not found.';
            header('Location: ' . BASE_URL . '/home');
            exit();
        }

        // Get saved addresses
        $addresses = $this->addressModel->getUserAddresses($userId);

        unset($_SESSION['success']);
        unset($_SESSION['error']);

        $data = [
            'title' => 'My Profile',
            'user' => $user,
            'addresses' => $addresses,
            'success' => null,
            'error' => null,
        ];

        $this->view('user/profile', $data);
    }

    public function updateGeneralInformation()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'You must be logged in to update your profile.';
            header('Location: ' . BASE_URL . '/login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Invalid request method.';
            header('Location: ' . BASE_URL . '/profile');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $newUsername = trim($_POST['username'] ?? '');

        // Basic validation
        if (empty($newUsername)) {
            $_SESSION['error'] = 'Username cannot be empty.';
            header('Location: ' . BASE_URL . '/profile');
            exit();
        }

        $existingUser = $this->userModel->findByUsernameOrEmail($newUsername);
        if ($existingUser && $existingUser['id'] != $userId) {
            $_SESSION['error'] = 'Username already taken. Please choose a different one.';
            header('Location: ' . BASE_URL . '/profile');
            exit();
        }

        $updated = $this->userModel->updateUsername($userId, $newUsername);

        if ($updated) {
            $_SESSION['username'] = $newUsername;
            header('Location: ' . BASE_URL . '/profile?success_msg=' . urlencode('Profile updated successfully!'));
            exit();
        } else {
            header('Location: ' . BASE_URL . '/profile?error_msg=' . urlencode('Failed to update profile. Please try again.'));
            exit();
        }

        header('Location: ' . BASE_URL . '/profile');
        exit();
    }

    public function updatePhoneNumber()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'You must be logged in to update your phone number.';
            header('Location: ' . BASE_URL . '/login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Invalid request method.';
            header('Location: ' . BASE_URL . '/profile');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $phoneNumber = trim($_POST['phone_number'] ?? '');

        if (!empty($phoneNumber) && !preg_match('/^[0-9]{10}$/', $phoneNumber)) {
            $_SESSION['error'] = 'Please enter a valid 10-digit Philippine mobile number (e.g., 9123456789).';
            header('Location: ' . BASE_URL . '/profile');
            exit();
        }

        $phoneNumberToStore = empty($phoneNumber) ? null : $phoneNumber;
        $updated = $this->userModel->updatePhoneNumber($userId, $phoneNumberToStore);

        if ($updated) {
            header('Location: ' . BASE_URL . '/profile?success_msg=' . urlencode('Phone number updated successfully!'));
            exit();
        } else {
            header('Location: ' . BASE_URL . '/profile?error_msg=' . urlencode('Failed to update phone number. Please try again.'));
            exit();
        }

        header('Location: ' . BASE_URL . '/profile');
        exit();
    }

    public function clearNewOrderNotificationApi()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user_id'])) {
            unset($_SESSION['new_order_notification']);
            $this->jsonResponse(['success' => true, 'message' => 'Notification cleared.']);
        } else {
            $this->jsonResponse(['success' => false, 'error' => 'Not logged in.'], 401);
        }
    }

    // Address Management Methods

    public function getAddressesApi()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            $this->jsonResponse(['success' => false, 'error' => 'Not logged in'], 401);
            return;
        }

        $addresses = $this->addressModel->getUserAddresses($_SESSION['user_id']);
        $this->jsonResponse(['success' => true, 'addresses' => $addresses]);
    }

    public function createAddress()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            $this->jsonResponse(['success' => false, 'error' => 'Not logged in'], 401);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request method'], 405);
            return;
        }

        $addressData = [
            'label' => trim($_POST['label'] ?? ''),
            'first_name' => trim($_POST['first_name'] ?? ''),
            'last_name' => trim($_POST['last_name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'country_code' => trim($_POST['country_code'] ?? '+63'),
            'mobile_number' => trim($_POST['mobile_number'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'city' => trim($_POST['city'] ?? ''),
            'state' => trim($_POST['state'] ?? ''),
            'zip_code' => trim($_POST['zip_code'] ?? ''),
            'is_default' => isset($_POST['is_default']) ? 1 : 0
        ];

        // Validate required fields
        if (empty($addressData['label']) || empty($addressData['first_name']) || empty($addressData['last_name']) || 
            empty($addressData['address']) || empty($addressData['city']) || empty($addressData['state']) || empty($addressData['zip_code'])) {
            $this->jsonResponse(['success' => false, 'error' => 'All required fields must be filled'], 400);
            return;
        }

        $created = $this->addressModel->createAddress($_SESSION['user_id'], $addressData);

        if ($created) {
            $this->jsonResponse(['success' => true, 'message' => 'Address saved successfully']);
        } else {
            $this->jsonResponse(['success' => false, 'error' => 'Failed to save address'], 500);
        }
    }

    public function updateAddress()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            $this->jsonResponse(['success' => false, 'error' => 'Not logged in'], 401);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request method'], 405);
            return;
        }

        $addressId = filter_input(INPUT_POST, 'address_id', FILTER_VALIDATE_INT);
        if (!$addressId) {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid address ID'], 400);
            return;
        }

        $addressData = [
            'label' => trim($_POST['label'] ?? ''),
            'first_name' => trim($_POST['first_name'] ?? ''),
            'last_name' => trim($_POST['last_name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'country_code' => trim($_POST['country_code'] ?? '+63'),
            'mobile_number' => trim($_POST['mobile_number'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'city' => trim($_POST['city'] ?? ''),
            'state' => trim($_POST['state'] ?? ''),
            'zip_code' => trim($_POST['zip_code'] ?? ''),
            'is_default' => isset($_POST['is_default']) ? 1 : 0
        ];

        $updated = $this->addressModel->updateAddress($addressId, $_SESSION['user_id'], $addressData);

        if ($updated) {
            $this->jsonResponse(['success' => true, 'message' => 'Address updated successfully']);
        } else {
            $this->jsonResponse(['success' => false, 'error' => 'Failed to update address'], 500);
        }
    }

    public function deleteAddress()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            $this->jsonResponse(['success' => false, 'error' => 'Not logged in'], 401);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request method'], 405);
            return;
        }

        $addressId = filter_input(INPUT_POST, 'address_id', FILTER_VALIDATE_INT);
        if (!$addressId) {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid address ID'], 400);
            return;
        }

        $deleted = $this->addressModel->deleteAddress($addressId, $_SESSION['user_id']);

        if ($deleted) {
            $this->jsonResponse(['success' => true, 'message' => 'Address deleted successfully']);
        } else {
            $this->jsonResponse(['success' => false, 'error' => 'Failed to delete address'], 500);
        }
    }
}