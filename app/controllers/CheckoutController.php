<?php

require_once BASE_PATH . 'app/controllers/BaseController.php';
require_once BASE_PATH . 'app/models/Product.php';
require_once BASE_PATH . 'app/models/Order.php';
require_once BASE_PATH . 'app/models/User.php';

class CheckoutController extends BaseController
{
    protected $productModel;
    protected $orderModel;
    protected $userModel;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->productModel = new Product($pdo);
        $this->orderModel = new Order($pdo);
        $this->userModel = new User($pdo);
    }

    public function index()
    {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'You must be logged in to proceed to checkout.';
            header('Location: ' . BASE_URL . '/login');
            exit();
        }

        $cartItems = $_SESSION['cart'] ?? [];
        $totalPrice = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cartItems));

        $user = null;
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $user = $this->userModel->findById($userId);
        }

        $data = [
            'title' => 'Complete Your Order',
            'cartItems' => $cartItems, // Ensure cartItems are passed if needed for summary
            'totalPrice' => $totalPrice, // Ensure totalPrice is passed if needed for summary
            'user' => $user // Pass user data to the view
        ];

        // This will render the multi-step form within checkout/index.php
        $this->view('checkout/index', $data);
    }

    public function processOrder()
    {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'You must be logged in to complete a purchase.';
            header('Location: ' . BASE_URL . '/login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Invalid request method for checkout process.';
            header('Location: ' . BASE_URL . '/checkout'); // Redirect to cart or appropriate page
            exit();
        }

        // --- 1. Extract all submitted data ---
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $countryCode = trim($_POST['country_code'] ?? '');
        $shippingMobileNumber = trim($_POST['mobile_number'] ?? ''); // This is the mobile number from the SHIPPING form
        $address = trim($_POST['address'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $state = trim($_POST['state'] ?? '');
        $zipCode = trim($_POST['zip_code'] ?? '');
        $notes = trim($_POST['notes'] ?? '');
        $shippingMethod = trim($_POST['shipping_method'] ?? '');
        $shippingCost = (float)($_POST['shipping_cost'] ?? 0);

        $paymentMethod = trim($_POST['payment_method'] ?? '');
        $paymentMobileNumber = trim($_POST['payment_mobile_number'] ?? ''); // This is the mobile number from the PAYMENT form

        $cartItemsJson = $_POST['cart_items_json'] ?? '[]';
        $totalAmount = (float)($_POST['total_amount'] ?? 0);

        $cartItems = json_decode($cartItemsJson, true);

        // --- 2. Server-side Validation ---
        $errors = [];

        // Basic required field validation (for shipping details)
        if (empty($firstName)) $errors[] = 'First name is required.';
        if (empty($lastName)) $errors[] = 'Last name is required.';
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
        if (empty($address)) $errors[] = 'Address is required.';
        if (empty($city)) $errors[] = 'City is required.';
        if (empty($state)) $errors[] = 'State is required.';
        if (empty($zipCode)) $errors[] = 'Zip Code is required.';
        if (empty($shippingMethod)) $errors[] = 'Shipping method is required.';

        // Validation for SHIPPING Mobile Number (based on country code)
        // The frontend already sends the *digits only* for shipping mobile number.
        if ($countryCode === '+63') {
            // For PH, expected 10 digits (e.g., 9123456789)
            if (!preg_match('/^9\d{9}$/', $shippingMobileNumber)) {
                 $errors[] = 'Please enter a valid 10-digit Philippine mobile number for shipping (e.g., 9123456789).';
            }
        } else if ($countryCode === '+1') {
            // For US, expected 10 digits
            if (!preg_match('/^\d{10}$/', $shippingMobileNumber)) {
                $errors[] = 'Please enter a valid 10-digit US mobile number for shipping.';
            }
        }
        // ... Add more country code validations as needed for shipping mobile number ...
        // If country code is not recognized, or if you need a general fallback:
        else {
             if (strlen($shippingMobileNumber) < 7 || strlen($shippingMobileNumber) > 15) {
                 $errors[] = 'Please enter a valid phone number for shipping.';
             }
        }

        // Validation for PAYMENT Mobile Number (conditional for GCash/PayPal)
        if ($paymentMethod === 'GCash' || $paymentMethod === 'PayPal') {
            if (empty($paymentMobileNumber)) {
                $errors[] = 'Mobile number is required for the selected payment method.';
            }
            // Strict 11-digit validation for GCash/PayPal (e.g., 09123456789)
            if (!preg_match('/^09\d{9}$/', $paymentMobileNumber)) {
                $errors[] = 'Please enter a valid 11-digit mobile number for GCash/PayPal (e.g., 09123456789).';
            }
        }

        if (empty($paymentMethod) || !in_array($paymentMethod, ['GCash', 'PayPal'])) {
            $errors[] = 'Please select a valid payment method.';
        }

        if (empty($cartItems) || !is_array($cartItems)) {
            $errors[] = 'Your cart is empty or invalid.';
        }

        // If there are any validation errors, redirect back with message
        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors); // Join all errors for display
            header('Location: ' . BASE_URL . '/checkout'); // Redirect back to checkout index
            exit();
        }

        // Get user ID if logged in
        $userId = $_SESSION['user_id'] ?? null;

        // --- Simulate Payment Process ---
        // In a real scenario, you would integrate with GCash/PayPal APIs here.
        $paymentSuccess = true; // Assume success for simulation

        if ($paymentSuccess) {
            // Prepare all order details to pass to the model
            $orderDataForCreation = [ // Renamed for clarity to avoid conflict with $orderDetails in the model.
                'user_id' => $userId,
                'total_amount' => $totalAmount,
                'payment_method' => $paymentMethod,
                'shipping_info' => [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'country_code' => $countryCode,
                    'mobile_number' => $shippingMobileNumber, // Shipping specific mobile
                    'address' => $address,
                    'city' => $city,
                    'state' => $state,
                    'zip_code' => $zipCode,
                    'notes' => $notes,
                    'shipping_method' => $shippingMethod,
                    'shipping_cost' => $shippingCost,
                    'payment_mobile_number' => $paymentMobileNumber // Payment specific mobile
                ]
            ];

            // Corrected: The Order model's createOrder now correctly maps this single array.
            $orderId = $this->orderModel->createOrder($orderDataForCreation);

            if ($orderId) {
                // Now add cart items to the order
                $successAddItems = $this->orderModel->addOrderItems($orderId, $cartItems);

                if (!$successAddItems) {
                    // If order items fail to save, you might want to log this and potentially
                    // mark the order as problematic or even delete the main order entry.
                    error_log("CheckoutController: Failed to add order items for Order ID: {$orderId}");
                    $_SESSION['error'] = 'Your order was placed, but there was an issue saving cart items. Please contact support.';
                    header('Location: ' . BASE_URL . '/checkout');
                    exit();
                }

                // Add this line to set the new order notification flag
                $_SESSION['new_order_notification'] = true;

                $_SESSION['last_order_id'] = $orderId; // Store order ID for success page
                header('Location: ' . BASE_URL . '/checkout/success');
                exit();
            } else {
                $_SESSION['error'] = 'There was an issue saving your order. Please try again.';
                header('Location: ' . BASE_URL . '/checkout');
                exit();
            }
        } else {
            // Simulated payment failed
            $_SESSION['error'] = 'Payment failed. Please try again or choose a different method.';
            header('Location: ' . BASE_URL . '/checkout');
            exit();
        }
    }

    /**
     * Displays the order success/confirmation page.
     */
    public function success()
    {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $orderId = $_SESSION['last_order_id'] ?? null;
        unset($_SESSION['last_order_id']); // Clear it after use

        $order = null;
        if ($orderId) {
            // Assuming getOrderById can fetch comprehensive order details including shipping and items
            $order = $this->orderModel->getOrderById($orderId);
        }

        $data = [
            'title' => 'Order Confirmed!',
            'order' => $order
        ];

        $this->view('checkout/success', $data);
    }
}