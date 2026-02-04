<?php

class Address
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createAddress(int $userId, array $addressData): bool
    {
        $sql = "INSERT INTO saved_addresses (user_id, label, first_name, last_name, email, country_code, mobile_number, address, city, state, zip_code, is_default) 
                VALUES (:user_id, :label, :first_name, :last_name, :email, :country_code, :mobile_number, :address, :city, :state, :zip_code, :is_default)";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'user_id' => $userId,
            'label' => $addressData['label'],
            'first_name' => $addressData['first_name'],
            'last_name' => $addressData['last_name'],
            'email' => $addressData['email'],
            'country_code' => $addressData['country_code'],
            'mobile_number' => $addressData['mobile_number'],
            'address' => $addressData['address'],
            'city' => $addressData['city'],
            'state' => $addressData['state'],
            'zip_code' => $addressData['zip_code'],
            'is_default' => $addressData['is_default'] ?? 0
        ]);
    }

    public function getUserAddresses(int $userId): array
    {
        $sql = "SELECT * FROM saved_addresses WHERE user_id = :user_id ORDER BY is_default DESC, created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAddressById(int $addressId, int $userId): ?array
    {
        $sql = "SELECT * FROM saved_addresses WHERE id = :id AND user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $addressId, 'user_id' => $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function updateAddress(int $addressId, int $userId, array $addressData): bool
    {
        $sql = "UPDATE saved_addresses 
                SET label = :label, first_name = :first_name, last_name = :last_name, email = :email, 
                    country_code = :country_code, mobile_number = :mobile_number, address = :address, 
                    city = :city, state = :state, zip_code = :zip_code, is_default = :is_default 
                WHERE id = :id AND user_id = :user_id";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $addressId,
            'user_id' => $userId,
            'label' => $addressData['label'],
            'first_name' => $addressData['first_name'],
            'last_name' => $addressData['last_name'],
            'email' => $addressData['email'],
            'country_code' => $addressData['country_code'],
            'mobile_number' => $addressData['mobile_number'],
            'address' => $addressData['address'],
            'city' => $addressData['city'],
            'state' => $addressData['state'],
            'zip_code' => $addressData['zip_code'],
            'is_default' => $addressData['is_default'] ?? 0
        ]);
    }

    public function deleteAddress(int $addressId, int $userId): bool
    {
        $sql = "DELETE FROM saved_addresses WHERE id = :id AND user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $addressId, 'user_id' => $userId]);
    }

    public function setDefaultAddress(int $addressId, int $userId): bool
    {
        // First, unset all default addresses for this user
        $sql1 = "UPDATE saved_addresses SET is_default = 0 WHERE user_id = :user_id";
        $stmt1 = $this->pdo->prepare($sql1);
        $stmt1->execute(['user_id' => $userId]);

        // Then set the selected address as default
        $sql2 = "UPDATE saved_addresses SET is_default = 1 WHERE id = :id AND user_id = :user_id";
        $stmt2 = $this->pdo->prepare($sql2);
        return $stmt2->execute(['id' => $addressId, 'user_id' => $userId]);
    }
}

