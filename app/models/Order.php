<?php

class Order
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Creates a new order in the database.
     * @param array $orderDetails Associative array containing all order details.
     * @return int|false The ID of the newly created order, or false on failure.
     */
    public function createOrder($orderDetails)
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, total_amount, payment_method, shipping_method, shipping_cost, first_name, last_name, email, country_code, shipping_mobile_number, address, city, state, zip_code, notes, payment_mobile_number, order_date) VALUES (:user_id, :total_amount, :payment_method, :shipping_method, :shipping_cost, :first_name, :last_name, :email, :country_code, :shipping_mobile_number, :address, :city, :state, :zip_code, :notes, :payment_mobile_number, :order_date)");

            $stmt->execute([
                ':user_id' => $orderDetails['user_id'],
                ':total_amount' => $orderDetails['total_amount'],
                ':payment_method' => $orderDetails['payment_method'],
                ':shipping_method' => $orderDetails['shipping_info']['shipping_method'],
                ':shipping_cost' => $orderDetails['shipping_info']['shipping_cost'],
                ':first_name' => $orderDetails['shipping_info']['first_name'],
                ':last_name' => $orderDetails['shipping_info']['last_name'],
                ':email' => $orderDetails['shipping_info']['email'],
                ':country_code' => $orderDetails['shipping_info']['country_code'],
                ':shipping_mobile_number' => $orderDetails['shipping_info']['mobile_number'],
                ':address' => $orderDetails['shipping_info']['address'],
                ':city' => $orderDetails['shipping_info']['city'],
                ':state' => $orderDetails['shipping_info']['state'],
                ':zip_code' => $orderDetails['shipping_info']['zip_code'],
                ':notes' => $orderDetails['shipping_info']['notes'],
                ':payment_mobile_number' => $orderDetails['shipping_info']['payment_mobile_number'],
                ':order_date' => date('Y-m-d H:i:s')
            ]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log("Order Model Error: createOrder failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Adds items to a specific order.
     * @param int $orderId
     * @param array $items An array of arrays, each with product_id, product_name, quantity, price_at_purchase.
     * @return bool True on success, false on failure.
     */
    public function addOrderItems($orderId, $items)
    {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare("INSERT INTO order_items (order_id, product_id, product_name, quantity, price_at_purchase) VALUES (:order_id, :product_id, :product_name, :quantity, :price_at_purchase)");

            foreach ($items as $item) {
                $stmt->execute([
                    ':order_id' => $orderId,
                    ':product_id' => $item['id'],
                    ':product_name' => $item['name'],
                    ':quantity' => (int)$item['quantity'],
                    ':price_at_purchase' => (float)$item['price']
                ]);
            }
            return $this->pdo->commit();
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Order Model Error: addOrderItems failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Retrieves all orders for a given user ID, including their items.
     * @param int $userId The ID of the user.
     * @return array An array of orders, with each order containing its items.
     */
    public function getOrdersByUserId($userId)
    {
        $orders = [];
        try {
            // Fetch orders for the user
            $stmtOrders = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY order_date DESC");
            $stmtOrders->execute([':user_id' => $userId]);
            $rawOrders = $stmtOrders->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rawOrders as $order) {
                $order['items'] = $this->getOrderItemsByOrderId($order['id']);
                $orders[] = $order;
            }
        } catch (PDOException $e) {
            error_log("Order Model Error: getOrdersByUserId failed: " . $e->getMessage());
            return [];
        }
        return $orders;
    }

    /**
     * Retrieves all items for a given order ID.
     * @param int $orderId The ID of the order.
     * @return array An array of order items.
     */
    public function getOrderItemsByOrderId($orderId)
    {
        $items = [];
        try {
            $stmtItems = $this->pdo->prepare("SELECT oi.*, p.image_url FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = :order_id");
            $stmtItems->execute([':order_id' => $orderId]);
            $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);
            
            // Prepend BASE_URL to image_url for each item if it starts with /
            foreach ($items as &$item) {
                if (isset($item['image_url']) && strpos($item['image_url'], '/') === 0) {
                    $item['image_url'] = BASE_URL . $item['image_url'];
                }
            }
        } catch (PDOException $e) {
            error_log("Order Model Error: getOrderItemsByOrderId failed: " . $e->getMessage());
            return [];
        }
        return $items;
    }

    /**
     * Retrieves a single order by its ID, including its items.
     * @param int $orderId The ID of the order to retrieve.
     * @return array|false The order data as an associative array, including its items, or false if not found.
     */
    public function getOrderById($orderId)
    {
        try {
            $stmtOrder = $this->pdo->prepare("SELECT * FROM orders WHERE id = :order_id LIMIT 1");
            $stmtOrder->execute([':order_id' => $orderId]);
            $order = $stmtOrder->fetch(PDO::FETCH_ASSOC);

            if ($order) {
                $order['items'] = $this->getOrderItemsByOrderId($orderId);
            }
            return $order;
        } catch (PDOException $e) {
            error_log("Order Model Error: getOrderById failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get the total revenue from orders within a specified date range.
     * @param string $startDate The start date (e.g., 'YYYY-MM-DD HH:MM:SS').
     * @return float The total revenue.
     */
    public function getTotalRevenue($startDate)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT SUM(total_amount) AS total_revenue FROM orders WHERE order_date >= :start_date");
            $stmt->execute([':start_date' => $startDate]);
            return (float) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Order Model Error: getTotalRevenue failed: " . $e->getMessage());
            return 0.00;
        }
    }

    /**
     * Get the total number of orders within a specified date range.
     * @param string $startDate The start date (e.g., 'YYYY-MM-DD HH:MM:SS').
     * @return int The total number of orders.
     */
    public function getTotalOrders($startDate)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(id) AS total_orders FROM orders WHERE order_date >= :start_date");
            $stmt->execute([':start_date' => $startDate]);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Order Model Error: getTotalOrders failed: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get the number of pending orders within a specified date range.
     * @param string $startDate The start date (e.g., 'YYYY-MM-DD HH:MM:SS').
     * @return int The number of pending orders.
     */
    public function getPendingOrders($startDate)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(id) AS pending_orders FROM orders WHERE status = 'Pending' AND order_date >= :start_date");
            $stmt->execute([':start_date' => $startDate]);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Order Model Error: getPendingOrders failed: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get daily total revenue for the last N days.
     * @param int $days Number of past days to fetch data for.
     * @return array An associative array where keys are dates (YYYY-MM-DD) and values are total revenues.
     */
    public function getDailyRevenue($days = 30)
    {
        $dailyRevenue = [];
        try {
            $stmt = $this->pdo->prepare("
                SELECT
                    DATE(order_date) AS order_day,
                    SUM(total_amount) AS daily_revenue
                FROM
                    orders
                WHERE
                    order_date >= DATE_SUB(CURDATE(), INTERVAL :days DAY)
                GROUP BY
                    order_day
                ORDER BY
                    order_day ASC
            ");
            $stmt->bindValue(':days', $days, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            for ($i = $days - 1; $i >= 0; $i--) {
                $date = date('Y-m-d', strtotime("-$i days"));
                $dailyRevenue[$date] = 0.00;
            }
            foreach ($results as $row) {
                $dailyRevenue[$row['order_day']] = (float)$row['daily_revenue'];
            }

        } catch (PDOException $e) {
            error_log("Order Model Error: getDailyRevenue failed: " . $e->getMessage());
            return [];
        }
        return $dailyRevenue;
    }

    /**
     * Get monthly total revenue for a given year.
     * @param int $year The year to fetch data for. Defaults to current year.
     * @return array An associative array where keys are month numbers (1-12) and values are total revenues.
     */
    public function getMonthlyRevenue($year = null)
    {
        if ($year === null) {
            $year = date('Y');
        }

        $monthlyRevenue = array_fill(1, 12, 0.00);

        try {
            $stmt = $this->pdo->prepare("
                SELECT
                    MONTH(order_date) AS order_month,
                    SUM(total_amount) AS monthly_revenue
                FROM
                    orders
                WHERE
                    YEAR(order_date) = :year
                GROUP BY
                    order_month
                ORDER BY
                    order_month ASC
            ");
            $stmt->bindValue(':year', $year, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $row) {
                $monthlyRevenue[(int)$row['order_month']] = (float)$row['monthly_revenue'];
            }

        } catch (PDOException $e) {
            error_log("Order Model Error: getMonthlyRevenue failed: " . $e->getMessage());
            return [];
        }
        return $monthlyRevenue;
    }
}