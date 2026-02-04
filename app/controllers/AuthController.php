<?php

require_once BASE_PATH . 'app/controllers/BaseController.php';
require_once BASE_PATH . 'app/models/User.php';

class AuthController extends BaseController
{
    protected $userModel;

    /**
     * Constructor for AuthController.
     * @param PDO $pdo The PDO database connection object.
     */
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->userModel = new User($pdo);
    }

    public function showLogin()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Get remembered username from cookie if it exists
        $rememberedUsername = $_COOKIE['remembered_username'] ?? '';

        $data = [
            'title' => 'Login to Your Account',
            'error' => $_SESSION['error'] ?? null,
            'success' => $_SESSION['success'] ?? null,
            'remembered_username' => $rememberedUsername,
        ];

        unset($_SESSION['error']);
        unset($_SESSION['success']);

        $this->view('auth/login', $data);
    }

    public function login()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $identifier = trim($_POST['identifier'] ?? '');
            $password = $_POST['password'] ?? '';
            $rememberMe = isset($_POST['remember_me']) && $_POST['remember_me'] === 'on';

            error_log("Auth Controller: Login attempt for identifier: '{$identifier}'");

            if (empty($identifier) || empty($password)) {
                $_SESSION['error'] = 'Please enter both username/email and password.';
                error_log("Auth Controller: Empty identifier or password.");
                header('Location: ' . BASE_URL . '/login');
                exit();
            }

            $user = $this->userModel->findByUsernameOrEmail($identifier);
            if ($user && password_verify($password, $user['password'])) {
                if ($user['is_banned']) {
                    $_SESSION['error'] = 'Your account has been banned. Please contact support.';
                    error_log("Auth Controller: Login failed: Banned user '{$identifier}' attempted to log in.");
                    header('Location: ' . BASE_URL . '/login');
                    exit();
                }

                // Login successful
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_admin'] = (bool)$user['is_admin'];
                $_SESSION['success'] = 'Welcome back, ' . htmlspecialchars($user['username']) . '!';
                $_SESSION['sync_cart_on_load'] = true;

                // Handle "Remember Me" functionality
                if ($rememberMe) {
                    // Save username in cookie for 30 days
                    setcookie('remembered_username', $user['username'], time() + (30 * 24 * 60 * 60), '/', '', false, true); // 30 days, httponly
                    error_log("Auth Controller: Remember Me cookie set for user: " . $user['username']);
                } else {
                    // Clear any existing remember me cookie
                    setcookie('remembered_username', '', time() - 3600, '/', '', false, true);
                }

                // Update last login timestamp
                $this->userModel->updateLastLogin($user['id']);

                error_log("Auth Controller: Login successful for user: " . $user['username'] . " (Admin: " . ($user['is_admin'] ? 'Yes' : 'No') . ")");

                if ($_SESSION['is_admin']) {
                    header('Location: ' . BASE_URL . '/admin/dashboard');
                } else {
                    header('Location: ' . BASE_URL . '/home');
                }
                exit();
            } else {
                // Login failed
                $_SESSION['error'] = 'Invalid username/email or password.';
                error_log("Auth Controller: Login failed for identifier: '{$identifier}' - User not found or password mismatch.");
                header('Location: ' . BASE_URL . '/login');
                exit();
            }
        } else {
            header('Location: ' . BASE_URL . '/login');
            exit();
        }
    }

    public function showRegister()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $data = [
            'title' => 'Create New Account',
            'error' => $_SESSION['error'] ?? null,
            'success' => $_SESSION['success'] ?? null,
        ];
        unset($_SESSION['error']);
        unset($_SESSION['success']);

        $this->view('auth/register', $data);
    }

    public function register()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            $createAsAdmin = isset($_POST['create_as_admin']) && $_POST['create_as_admin'] === 'on';

            error_log("Auth Controller: Registration attempt for username='{$username}', email='{$email}', admin='" . ($createAsAdmin ? 'Yes' : 'No') . "'");

            // Basic validation
            if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
                $_SESSION['error'] = 'All fields are required.';
                error_log("Auth Controller: Registration failed: Missing fields.");
                header('Location: ' . BASE_URL . '/register');
                exit();
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Invalid email format.';
                error_log("Auth Controller: Registration failed: Invalid email format.");
                header('Location: ' . BASE_URL . '/register');
                exit();
            }

            if ($password !== $confirmPassword) {
                $_SESSION['error'] = 'Passwords do not match.';
                error_log("Auth Controller: Registration failed: Passwords do not match.");
                header('Location: ' . BASE_URL . '/register');
                exit();
            }

            if (strlen($password) < 6) {
                $_SESSION['error'] = 'Password must be at least 6 characters long.';
                error_log("Auth Controller: Registration failed: Password too short.");
                header('Location: ' . BASE_URL . '/register');
                exit();
            }

            if ($this->userModel->findByUsernameOrEmail($username)) {
                $_SESSION['error'] = 'Username already exists. Please choose a different one.';
                error_log("Auth Controller: Registration failed: Username '{$username}' already exists.");
                header('Location: ' . BASE_URL . '/register');
                exit();
            }
             if ($this->userModel->findByUsernameOrEmail($email)) {
                $_SESSION['error'] = 'Email already exists. Please choose a different one.';
                error_log("Auth Controller: Registration failed: Email '{$email}' already exists.");
                header('Location: ' . BASE_URL . '/register');
                exit();
            }


            // Hash the password securely
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            error_log("Auth Controller: Password hashed successfully. Hash: '{$passwordHash}'");

            // Create the user
            $userId = $this->userModel->createUser($username, $email, $passwordHash, $createAsAdmin);

            if ($userId) {
                $successMessage = 'Account created successfully! Please log in.';
                if ($createAsAdmin) {
                    $successMessage = 'Admin account created successfully! Please log in with your new admin credentials.';
                }
                $_SESSION['success'] = $successMessage;
                error_log("Auth Controller: User registration successful. User ID: {$userId}");
                header('Location: ' . BASE_URL . '/login');
                exit();
            } else {
                $_SESSION['error'] = 'Registration failed. Please try again.';
                error_log("Auth Controller: User registration failed, createUser returned false.");
                header('Location: ' . BASE_URL . '/register');
                exit();
            }
        } else {
            header('Location: ' . BASE_URL . '/register');
            exit();
        }
    }

    public function logout()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        error_log("Auth Controller: User logging out.");
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Note: We keep the remembered_username cookie so it persists after logout
        // This allows the username to be pre-filled on next login
        
        session_destroy();

        error_log("Auth Controller: Session destroyed, redirecting to home.");
        header('Location: ' . BASE_URL . '/home'); 
        exit();
    }

}