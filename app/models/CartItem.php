<?php

require_once BASE_PATH . 'app/models/Product.php';

class CartItem
{
    protected $pdo;
    protected $productModel;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->productModel = new Product($pdo);
    }

    /**
     * Adds a product to a user's cart or updates its quantity if it already exists.
     * @param int $userId The ID of the user.
     * @param int $productId The ID of the product.
     * @param int $quantity The quantity to add/set.
     * @return bool True on success, false on failure.
     */
    public function addOrUpdateItem(int $userId, int $productId, int $quantity): bool
    {
        if ($quantity <= 0) {
            return $this->removeItem($userId, $productId);
        }

        // Check if the product already exists in the cart for this user
        $stmt = $this->pdo->prepare("SELECT id, quantity FROM cart_items WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingItem) {
            $newQuantity = $existingItem['quantity'] + $quantity;
            $updateStmt = $this->pdo->prepare("UPDATE cart_items SET quantity = :quantity, updated_at = NOW() WHERE id = :id");
            return $updateStmt->execute(['quantity' => $newQuantity, 'id' => $existingItem['id']]);
        } else {
            $insertStmt = $this->pdo->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
            return $insertStmt->execute(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]);
        }
    }

    /**
     * Sets the quantity of a product in a user's cart.
     * If quantity is 0 or less, the item is removed.
     * @param int $userId The ID of the user.
     * @param int $productId The ID of the product.
     * @param int $newQuantity The new quantity to set.
     * @return bool True on success, false on failure.
     */
    public function setItemQuantity(int $userId, int $productId, int $newQuantity): bool
    {
        if ($newQuantity <= 0) {
            return $this->removeItem($userId, $productId);
        }

        $stmt = $this->pdo->prepare("UPDATE cart_items SET quantity = :quantity, updated_at = NOW() WHERE user_id = :user_id AND product_id = :product_id");
        return $stmt->execute(['quantity' => $newQuantity, 'user_id' => $userId, 'product_id' => $productId]);
    }

    /**
     * Removes a product from a user's cart.
     * @param int $userId The ID of the user.
     * @param int $productId The ID of the product to remove.
     * @return bool True on success, false on failure.
     */
    public function removeItem(int $userId, int $productId): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM cart_items WHERE user_id = :user_id AND product_id = :product_id");
        return $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    }

    /**
     * Clears all items from a user's cart.
     * @param int $userId The ID of the user.
     * @return bool True on success, false on failure.
     */
    public function clearCart(int $userId): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM cart_items WHERE user_id = :user_id");
        return $stmt->execute(['user_id' => $userId]);
    }

    /**
     * Retrieves all cart items for a specific user, with product details.
     * @param int $userId The ID of the user.
     * @return array An array of cart items, each including product details.
     */
    public function getCartItems(int $userId): array
    {
        $stmt = $this->pdo->prepare("SELECT product_id, quantity FROM cart_items WHERE user_id = :user_id ORDER BY created_at ASC");
        $stmt->execute(['user_id' => $userId]);
        $rawCartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $cart = [];
        foreach ($rawCartItems as $item) {
            $product = $this->productModel->getProductById($item['product_id']);
            if ($product) {
                $cart[] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => (float)$product['price'],
                    'image' => $product['image_url'],
                    'quantity' => (int)$item['quantity'],
                    'stock' => (int)$product['stock']
                ];
            }
        }
        return $cart;
    }
}