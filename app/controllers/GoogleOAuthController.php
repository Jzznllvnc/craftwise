<?php

require_once BASE_PATH . 'app/controllers/BaseController.php';
require_once BASE_PATH . 'app/models/User.php';
require_once BASE_PATH . 'app/helpers/GoogleOAuthHelper.php';

class GoogleOAuthController extends BaseController
{
    protected $userModel;
    protected $googleOAuth;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->userModel = new User($pdo);
        $this->googleOAuth = new GoogleOAuthHelper();
    }

    /**
     * Redirect user to Google for authentication
     */
    public function redirectToGoogle()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!$this->googleOAuth->isConfigured()) {
            $_SESSION['error'] = 'Google Sign-In is not configured. Please contact the administrator.';
            error_log("Google OAuth: Not configured properly. Check config/google_oauth.php");
            header('Location: ' . BASE_URL . '/login');
            exit();
        }

        $authUrl = $this->googleOAuth->getAuthorizationUrl();
        header('Location: ' . $authUrl);
        exit();
    }

    /**
     * Handle the callback from Google after authentication
     */
    public function handleCallback()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_GET['code'])) {
            $_SESSION['error'] = 'Google authentication failed. Please try again.';
            error_log("Google OAuth: No authorization code received");
            header('Location: ' . BASE_URL . '/login');
            exit();
        }

        $code = $_GET['code'];

        $tokenData = $this->googleOAuth->getAccessToken($code);
        if (!$tokenData || !isset($tokenData['access_token'])) {
            $_SESSION['error'] = 'Failed to authenticate with Google. Please try again.';
            error_log("Google OAuth: Failed to get access token");
            header('Location: ' . BASE_URL . '/login');
            exit();
        }

        $userInfo = $this->googleOAuth->getUserInfo($tokenData['access_token']);
        if (!$userInfo) {
            $_SESSION['error'] = 'Failed to retrieve user information from Google.';
            error_log("Google OAuth: Failed to get user info");
            header('Location: ' . BASE_URL . '/login');
            exit();
        }

        $googleId = $userInfo['id'];
        $email = $userInfo['email'];
        $name = $userInfo['name'] ?? 'User';
        $picture = $userInfo['picture'] ?? null;
        $emailVerified = $userInfo['verified_email'] ?? true;

        error_log("Google OAuth: User authenticated - Email: {$email}, Google ID: {$googleId}");

        $existingUser = $this->userModel->findByGoogleId($googleId);

        if ($existingUser) {
            $this->loginUser($existingUser);
        } else {
            $existingEmailUser = $this->userModel->findByEmail($email);
            
            if ($existingEmailUser) {
                if (empty($existingEmailUser['google_id'])) {
                    $this->userModel->linkGoogleAccount(
                        $existingEmailUser['id'], 
                        $googleId, 
                        $picture,
                        $emailVerified
                    );
                    error_log("Google OAuth: Linked existing account with email: {$email}");
                }
                $this->loginUser($existingEmailUser);
            } else {
                $username = $this->generateUniqueUsername($name, $email);
                $userId = $this->userModel->createGoogleUser(
                    $username,
                    $email,
                    $googleId,
                    $picture,
                    $emailVerified
                );

                if ($userId) {
                    $newUser = $this->userModel->findById($userId);
                    error_log("Google OAuth: Created new user with ID: {$userId}");
                    $this->loginUser($newUser);
                } else {
                    $_SESSION['error'] = 'Failed to create your account. Please try again.';
                    error_log("Google OAuth: Failed to create new user");
                    header('Location: ' . BASE_URL . '/register');
                    exit();
                }
            }
        }
    }

    /**
     * Log in the user and redirect to appropriate page
     */
    private function loginUser($user)
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = (bool)$user['is_admin'];
        $_SESSION['success'] = 'Welcome back, ' . htmlspecialchars($user['username']) . '!';
        $_SESSION['sync_cart_on_load'] = true;

        $this->userModel->updateLastLogin($user['id']);

        if ($_SESSION['is_admin']) {
            header('Location: ' . BASE_URL . '/admin/dashboard');
        } else {
            header('Location: ' . BASE_URL . '/home');
        }
        exit();
    }

    /**
     * Generate a unique username from Google name/email
     */
    private function generateUniqueUsername($name, $email)
    {
        $baseUsername = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', explode('@', $email)[0]));
        
        if (empty($baseUsername)) {
            $baseUsername = 'user';
        }

        $username = $baseUsername;
        $counter = 1;

        while ($this->userModel->findByUsernameOrEmail($username)) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }
}
