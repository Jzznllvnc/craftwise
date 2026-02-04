<?php

class Product
{
    private $pdo;
    private $table_name = "products";

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Get a single product by its ID.
     * @param int $id The product ID.
     * @return array|false The product data as an associative array, or false if not found.
     */
    public function getProductById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Prepend BASE_URL to image_url if it starts with /
        if ($product && isset($product['image_url']) && strpos($product['image_url'], '/') === 0) {
            $product['image_url'] = BASE_URL . $product['image_url'];
        }
        
        return $product;
    }

    /**
     * Get all products with optional pagination, category, and search filters.
     * @param int $limit Number of products to return.
     * @param int $offset Offset for pagination.
     * @param string|null $category Optional category to filter by.
     * @param string|null $search Optional search term for name or description.
     * @return array A list of product data as associative arrays.
     */
    public function getProducts($limit, $offset, $category = null, $search = null)
    {
        $query = "SELECT * FROM " . $this->table_name;
        $params = [];
        $whereClauses = [];

        if (!empty($category)) {
            $whereClauses[] = "category = :category";
            $params[':category'] = $category;
        }

        if (!empty($search)) {
            $whereClauses[] = "(name LIKE :search_name OR description LIKE :search_description)";
            $params[':search_name'] = '%' . $search . '%';
            $params[':search_description'] = '%' . $search . '%';
        }

        if (!empty($whereClauses)) {
            $query .= " WHERE " . implode(" AND ", $whereClauses);
        }

        $query .= " ORDER BY id ASC LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($query);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Prepend BASE_URL to image_url for each product if it starts with /
        foreach ($products as &$product) {
            if (isset($product['image_url']) && strpos($product['image_url'], '/') === 0) {
                $product['image_url'] = BASE_URL . $product['image_url'];
            }
        }
        
        return $products;
    }

    /**
     * Get products filtered by a specific category.
     * @param string $category The category to filter products by.
     * @return array A list of product data as associative arrays.
     */
    public function getProductsByCategory($category)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM " . $this->table_name . " WHERE category = :category ORDER BY name ASC");
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get the total number of products with optional category and search filters.
     * @param string|null $category Optional category to filter by.
     * @param string|null $search Optional search term for name or description.
     * @return int The total number of products.
     */
    public function getTotalProducts($category = null, $search = null)
    {
        $query = "SELECT COUNT(*) FROM " . $this->table_name;
        $params = [];
        $whereClauses = [];

        if (!empty($category)) {
            $whereClauses[] = "category = :category";
            $params[':category'] = $category;
        }

        if (!empty($search)) {
            $whereClauses[] = "(name LIKE :search_name OR description LIKE :search_description)";
            $params[':search_name'] = '%' . $search . '%';
            $params[':search_description'] = '%' . $search . '%';
        }

        if (!empty($whereClauses)) {
            $query .= " WHERE " . implode(" AND ", $whereClauses);
        }

        $stmt = $this->pdo->prepare($query);
        // Execute with parameters.
        $stmt->execute($params);

        return (int)$stmt->fetchColumn();
    }


    /**
     * Creates a new product in the database.
     * @param string $name
     * @param string $description
     * @param float $price
     * @param string $image_url
     * @param string $category
     * @param int $stock
     * @param string|null $additional_details
     * @return int|false The ID of the newly created product, or false on failure.
     */
    public function createProduct($name, $description, $price, $image_url, $category, $stock, $additional_details = null)
    {
        try {
            $query = "INSERT INTO " . $this->table_name . " (name, description, price, image_url, category, stock, additional_details) VALUES (:name, :description, :price, :image_url, :category, :stock, :additional_details)";
            $stmt = $this->pdo->prepare($query);

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':image_url', $image_url);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':additional_details', $additional_details);

            $stmt->execute();
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log("Product Model Error: createProduct failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Updates an existing product in the database.
     * @param int $id The product ID.
     * @param string $name
     * @param string $description
     * @param float $price
     * @param string $image_url
     * @param string $category
     * @param int $stock
     * @param string|null $additional_details
     * @return bool True on success, false if no rows affected or on error.
     */
    public function updateProduct($id, $name, $description, $price, $image_url, $category, $stock, $additional_details = null)
    {
        try {
            $query = "UPDATE " . $this->table_name . " SET name = :name, description = :description, price = :price, image_url = :image_url, category = :category, stock = :stock, additional_details = :additional_details WHERE id = :id";
            $stmt = $this->pdo->prepare($query);

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':image_url', $image_url);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':additional_details', $additional_details);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Product Model Error: updateProduct failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Deletes a product from the database.
     * @param int $id The product ID.
     * @return bool|string True on successful deletion, false on general failure, 'referenced' if linked to orders.
     */
    public function deleteProduct($id)
    {
        try {
            $stmtCheck = $this->pdo->prepare("SELECT COUNT(*) FROM order_items WHERE product_id = :id");
            $stmtCheck->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtCheck->execute();
            if ($stmtCheck->fetchColumn() > 0) {
                return 'referenced';
            }

            $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Product Model Error: deleteProduct failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Calculates the total value of all products in stock (price * stock).
     * @return float The total inventory value.
     */
    public function getTotalInventoryValue()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT SUM(price * stock) FROM " . $this->table_name);
            $stmt->execute();
            return (float)$stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Product Model Error: getTotalInventoryValue failed: " . $e->getMessage());
            return 0.00;
        }
    }
}