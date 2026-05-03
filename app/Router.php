<?php

class Router
{
    protected $routes = [];

    /**
     * Add a GET route.
     * @param string $uri The URI pattern (e.g., '/', '/products/{id}')
     * @param string $controllerAction The controller and method (e.g., 'HomeController@index')
     */
    public function get($uri, $controllerAction)
    {
        $this->routes['GET'][$this->formatRouteUri($uri)] = $controllerAction;
    }

    /**
     * Add a POST route.
     * @param string $uri The URI pattern
     * @param string $controllerAction The controller and method
     */
    public function post($uri, $controllerAction)
    {
        $this->routes['POST'][$this->formatRouteUri($uri)] = $controllerAction;
    }

    /**
     * Dispatches the incoming request to the appropriate controller action.
     * @param string $requestUri The full request URI from $_SERVER['REQUEST_URI'].
     * @param string $requestMethod The HTTP method from $_SERVER['REQUEST_METHOD'].
     * @param PDO $pdo The PDO database connection object.
     */
    public function dispatch($requestUri, $requestMethod, $pdo)
    {
        $uri = $this->formatRequestUri($requestUri); // This will now produce a clean path without query string
        $method = strtoupper($requestMethod);

        // Check if there are any routes defined for this HTTP method
        if (!isset($this->routes[$method])) {
            http_response_code(405); // Method Not Allowed
            echo "405 Method Not Allowed";
            return;
        }

        // Iterate through defined routes to find a match
        foreach ($this->routes[$method] as $routePattern => $controllerAction) {
            // Convert route pattern to a regex pattern for matching
            // Explicitly handle {id} for digits (\d+) and general parameters ([a-zA-Z0-9_]+)
            $regexPattern = preg_quote($routePattern, '#');
            $regexPattern = str_replace(preg_quote('{id}', '#'), '(\d+)', $regexPattern); // Match digits for ID
            $regexPattern = str_replace(preg_quote('{search_term}', '#'), '([a-zA-Z0-9_.\-]+)', $regexPattern); // Match search terms (alphanumeric, underscore, dash, dot)
            $regexPattern = preg_replace('/\\\{([a-zA-Z0-9_]+)\\\}/', '([a-zA-Z0-9_]+)', $regexPattern); // General alpha-numeric for others
            $regexPattern = '#^' . $regexPattern . '$#'; // Add start/end anchors

            if (preg_match($regexPattern, $uri, $matches)) {
                array_shift($matches); // Remove the full matched string (index 0)

                // Split controller and action (e.g., 'HomeController@index')
                list($controllerName, $actionName) = explode('@', $controllerAction);

                // Include the controller file
                $controllerFile = BASE_PATH . 'app/controllers/' . $controllerName . '.php';
                if (!file_exists($controllerFile)) {
                    die("Controller file not found: " . $controllerFile);
                }
                require_once $controllerFile;

                // Instantiate the controller and call the action
                $controllerInstance = new $controllerName($pdo); // Pass PDO to controller constructor

                if (!method_exists($controllerInstance, $actionName)) {
                    die("Method '{$actionName}' not found in controller '{$controllerName}'");
                }

                // Call the controller method with extracted parameters
                call_user_func_array([$controllerInstance, $actionName], $matches);
                return; // Stop after the first match
            }
        }

        // If no route matches
        http_response_code(404); // Not Found
        echo '<div class="container mx-auto p-4 pt-40">';
        echo '<h1>404 Not Found</h1>';
        echo '<p>The page you requested could not be found.</p>';
        echo '</div>';
    }

    /**
     * Formats a route URI for internal storage (used in get/post methods).
     * Ensures leading slash and no trailing slash (unless it's just '/').
     * @param string $uri
     * @return string
     */
    protected function formatRouteUri($uri)
    {
        $uri = '/' . trim($uri, '/');
        if ($uri === '//') { // Handle cases like empty string becoming '//'
            return '/';
        }
        return $uri;
    }

    /**
     * Formats the incoming request URI for matching against defined routes.
     * Removes the base path prefix and normalizes slashes, and crucially, removes the query string.
     * @param string $requestUri The full URI from $_SERVER['REQUEST_URI'].
     * @return string The clean, normalized URI path.
     */
    protected function formatRequestUri($requestUri)
    {
        // 1. Extract only the path component, discarding the query string
        $path = parse_url($requestUri, PHP_URL_PATH);
        if ($path === false) { // Handle parse_url errors
            $path = $requestUri; // Fallback to full URI if parsing fails
        }

        // 2. Remove the base path prefix
        $basePath = defined('BASE_URL') ? BASE_URL : '/pcbuild'; // This must match your server's subdirectory
        if (strpos($path, $basePath) === 0) {
            $path = substr($path, strlen($basePath));
        }

        // 3. Normalize slashes
        $uri = '/' . trim($path, '/');
        if ($uri === '//') {
            return '/';
        }
        return $uri;
    }

    /**
     * Defines all the application routes.
     */
    public function defineRoutes()
    {
        // Home Page
        $this->get('/', 'HomeController@index');
        $this->get('/home', 'HomeController@index');

        // Products Routes
        $this->get('/products', 'ProductController@index'); // List all products
        $this->get('/products/{id}', 'ProductController@show'); // Show a single product by ID

        // Authentication Routes
        $this->get('/login', 'AuthController@showLogin');      // Display login form
        $this->post('/login', 'AuthController@login');         // Process login form submission
        $this->get('/register', 'AuthController@showRegister'); // Display registration form
        $this->post('/register', 'AuthController@register');   // Process registration form submission
        $this->get('/logout', 'AuthController@logout');       // Handle logout (CHANGED TO GET)

        // Google OAuth Routes
        $this->get('/auth/google', 'GoogleOAuthController@redirectToGoogle'); // Redirect to Google
        $this->get('/auth/google/callback', 'GoogleOAuthController@handleCallback'); // Google callback

        // Cart Routes
        $this->get('/cart', 'CartController@index'); // Display the shopping cart

        // Cart API Endpoints
        $this->post('/cart/add', 'CartController@addOrUpdateCartItemApi');
        $this->post('/cart/update-quantity', 'CartController@setCartItemQuantityApi');
        $this->post('/cart/remove', 'CartController@removeCartItemApi');
        $this->post('/cart/clear', 'CartController@clearCartApi');
        $this->post('/cart/sync', 'CartController@syncCartApi');
        $this->get('/cart/get', 'CartController@getCartApi'); // For fetching cart content for logged-in users

        // AI Chat Routes
        $this->get('/ai-chat-content', 'AiChatController@getChatContent'); // Route to fetch ONLY chat content for the pop-up
        $this->post('/chat-submit', 'AiChatController@chatApi');  // AI chat message submission

        // Build Rate Routes
        $this->get('/build-rate', 'BuildController@index'); // Display the build rating interface
        $this->post('/build-rate/get', 'BuildController@getRating'); // API endpoint to get build rating

        // Checkout Routes
        $this->get('/checkout', 'CheckoutController@index'); // Display checkout form
        $this->post('/checkout/process', 'CheckoutController@processOrder'); // Process order/simulated payment
        $this->get('/checkout/success', 'CheckoutController@success'); // Order confirmation page

        // User API Endpoints
        $this->post('/user/clear-order-notification', 'UserController@clearNewOrderNotificationApi');

        // User Order History Route
        $this->get('/orderhistory', 'UserController@orderhistory'); // Order history

        // User Profile Routes
        $this->get('/profile', 'UserController@profile'); // Display user profile page
        $this->post('/profile/update-general', 'UserController@updateGeneralInformation'); // Handle profile general info update
        $this->post('/profile/update-phone', 'UserController@updatePhoneNumber'); // Handle phone number update (NEW)
        
        // Address Management Routes
        $this->get('/user/addresses', 'UserController@getAddressesApi'); // Get user addresses
        $this->post('/user/addresses/create', 'UserController@createAddress'); // Create new address
        $this->post('/user/addresses/update', 'UserController@updateAddress'); // Update address
        $this->post('/user/addresses/delete', 'UserController@deleteAddress'); // Delete address

        // Static Pages Routes
        $this->get('/privacy-policy', 'PageController@privacyPolicy'); // Privacy Policy page
        $this->get('/terms-of-service', 'PageController@termsOfService'); // Terms of Service page

        // Admin Routes
        $this->get('/admin', 'AdminController@dashboard'); // Admin dashboard for /admin
        $this->get('/admin/dashboard', 'AdminController@dashboard'); // Admin dashboard

        // Admin Product Management
        $this->get('/admin/products', 'AdminController@products'); // List products for admin
        $this->get('/admin/products/create', 'AdminController@createProductForm'); // Show create product form
        $this->post('/admin/products/create', 'AdminController@createProduct'); // Handle create product submission
        $this->get('/admin/products/edit/{id}', 'AdminController@editProductForm'); // Show edit product form
        $this->post('/admin/products/edit/{id}', 'AdminController@updateProduct'); // Handle update product submission
        $this->post('/admin/products/delete/{id}', 'AdminController@deleteProduct'); // Handle delete product submission

        // Admin User Management
        $this->get('/admin/users', 'AdminController@manageUsers'); // Display user list (standard)
        $this->get('/admin/users/{search_term}', 'AdminController@manageUsers'); // Route to catch unexpected search URLs (e.g., /users/jazz)
        $this->post('/admin/users/toggle-ban/{id}', 'AdminController@toggleUserBan'); // Toggle ban status
        $this->post('/admin/users/delete/{id}', 'AdminController@deleteUserAccount'); // Delete user
        $this->get('/admin/users/orders/{id}', 'AdminController@viewUserOrders'); // View user order history
    }
}