<?php

class User
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Finds a user by their ID.
     * @param int $id The user ID.
     * @return array|false An associative array of user data, or false if not found.
     */
    public function findById($id)
    {
        error_log("User Model: Attempting to find user with ID: {$id}");
        try {
            // Include phone_number in SELECT statement
            $stmt = $this->pdo->prepare("SELECT id, username, email, phone_number, created_at, last_login, is_admin, is_banned FROM users WHERE id = :id LIMIT 1");
            $stmt->execute([':id' => $id]);
            $user = $stmt->fetch();
            if ($user) {
                error_log("User Model: Found user: " . $user['username'] . " (ID: " . $user['id'] . ")");
            } else {
                error_log("User Model: No user found for ID: {$id}");
            }
            return $user;
        } catch (PDOException $e) {
            error_log("User Model Error: findById failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Finds a user by their username or email.
     * @param string $identifier The username or email to search for.
     * @return array|false An associative array of user data, or false if not found.
     */
    public function findByUsernameOrEmail($identifier)
    {
        error_log("User Model: Attempting to find user with identifier: '{$identifier}'");
        try {
            $stmt = $this->pdo->prepare("SELECT id, username, email, phone_number, password, created_at, last_login, is_admin, is_banned FROM users WHERE username = :username_param OR email = :email_param LIMIT 1");
            $stmt->execute([
                ':username_param' => $identifier,
                ':email_param' => $identifier
            ]);
            $user = $stmt->fetch();
            if ($user) {
                error_log("User Model: Found user: " . $user['username'] . " (ID: " . $user['id'] . ", Admin: " . ($user['is_admin'] ? 'Yes' : 'No') . ", Banned: " . ($user['is_banned'] ? 'Yes' : 'No') . ")");
            } else {
                error_log("User Model: No user found for identifier: '{$identifier}'");
            }
            return $user;
        } catch (PDOException $e) {
            error_log("User Model Error: findByUsernameOrEmail failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Finds a user by their email address.
     * @param string $email The email address to search for.
     * @return array|false An associative array of user data, or false if not found.
     */
    public function findByEmail($email)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT id, username, email, phone_number, password, is_admin, is_banned FROM users WHERE email = :email LIMIT 1");
            $stmt->execute([':email' => $email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("User Model Error: findByEmail failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Creates a new user in the database.
     * @param string $username
     * @param string $email
     * @param string $passwordHash The hashed password.
     * @param bool $isAdmin Whether to create as admin (default: false).
     * @return int|false The ID of the newly created user, or false on failure.
     */
    public function createUser($username, $email, $passwordHash, $isAdmin = false)
    {
        $adminStatus = $isAdmin ? 1 : 0;
        error_log("User Model: Attempting to create user: username='{$username}', email='{$email}', is_admin={$adminStatus}");
        try {
            $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password, is_admin, is_banned) VALUES (:username, :email, :password, :is_admin, 0)");
            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $passwordHash,
                ':is_admin' => $adminStatus
            ]);
            $lastId = $this->pdo->lastInsertId();
            if ($lastId) {
                error_log("User Model: User created successfully with ID: {$lastId}" . ($isAdmin ? " (ADMIN)" : ""));
            } else {
                error_log("User Model: User creation failed, no lastInsertId returned.");
            }
            return $lastId;
        } catch (PDOException $e) {
            error_log("User Model Error: createUser failed: " . $e->getMessage());
            if ($e->getCode() == '23000') {
                error_log("User Model Error: Duplicate entry for username or email.");
            }
            return false;
        }
    }

    /**
     * Fetches all users from the database.
     * @param string $searchTerm Optional term to search by username or email.
     * @return array An array of associative arrays, each representing a user.
     */
    public function getAllUsers($searchTerm = '')
    {
        $sql = "SELECT id, username, email, phone_number, created_at, last_login, is_admin, is_banned FROM users";
        $params = [];

        if (!empty($searchTerm)) {
            $sql .= " WHERE LOWER(username) LIKE :searchTermUsername OR LOWER(email) LIKE :searchTermEmail";
            $params[':searchTermUsername'] = '%' . $searchTerm . '%';
            $params[':searchTermEmail'] = '%' . $searchTerm . '%';
        }

        $sql .= " ORDER BY created_at DESC";

        error_log("User Model: getAllUsers SQL: " . $sql);
        error_log("User Model: getAllUsers Params: " . json_encode($params));

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("User Model: Found " . count($users) . " users for search term '{$searchTerm}'.");
            return $users;
        } catch (PDOException $e) {
            error_log("User Model Error: getAllUsers failed: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Bans a user by their ID.
     * @param int $userId The ID of the user to ban.
     * @return bool True on success, false on failure.
     */
    public function banUser($userId)
    {
        error_log("User Model: Attempting to ban user with ID: {$userId}");
        try {
            $stmt = $this->pdo->prepare("UPDATE users SET is_banned = 1 WHERE id = :userId");
            return $stmt->execute([':userId' => $userId]);
        } catch (PDOException $e) {
            error_log("User Model Error: banUser failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Unbans a user by their ID.
     * @param int $userId The ID of the user to unban.
     * @return bool True on success, false on failure.
     */
    public function unbanUser($userId)
    {
        error_log("User Model: Attempting to unban user with ID: {$userId}");
        try {
            $stmt = $this->pdo->prepare("UPDATE users SET is_banned = 0 WHERE id = :userId");
            return $stmt->execute([':userId' => $userId]);
        } catch (PDOException $e) {
            error_log("User Model Error: unbanUser failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Deletes a user by their ID.
     * @param int $userId The ID of the user to delete.
     * @return bool True on success, false on failure.
     */
    public function deleteUser($userId)
    {
        error_log("User Model: Attempting to delete user with ID: {$userId}");
        try {
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :userId");
            return $stmt->execute([':userId' => $userId]);
        } catch (PDOException $e) {
            error_log("User Model Error: deleteUser failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Updates the last login timestamp for a user.
     * @param int $userId The ID of the user whose last login is to be updated.
     * @return bool True on success, false on failure.
     */
    public function updateLastLogin($userId)
    {
        error_log("User Model: Updating last login for user ID: {$userId}");
        try {
            $stmt = $this->pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = :userId");
            return $stmt->execute([':userId' => $userId]);
        } catch (PDOException $e) {
            error_log("User Model Error: updateLastLogin failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Updates a user's password.
     * @param int $userId The ID of the user whose password to update.
     * @param string $newPasswordHash The new hashed password.
     * @return bool True on success, false on failure.
     */
    public function updatePassword($userId, $newPasswordHash)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE users SET password = :password WHERE id = :userId");
            return $stmt->execute([
                ':password' => $newPasswordHash,
                ':userId' => $userId
            ]);
        } catch (PDOException $e) {
            error_log("User Model Error: updatePassword failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Updates a user's username.
     * @param int $userId The ID of the user to update.
     * @param string $username The new username.
     * @return bool True on success, false on failure.
     */
    public function updateUsername($userId, $username)
    {
        error_log("User Model: Attempting to update username for user ID: {$userId}");
        try {
            $stmt = $this->pdo->prepare("UPDATE users SET username = :username WHERE id = :userId");
            return $stmt->execute([
                ':username' => $username,
                ':userId' => $userId
            ]);
        } catch (PDOException $e) {
            error_log("User Model Error: updateUsername failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Updates a user's phone number.
     * @param int $userId The ID of the user to update.
     * @param string|null $phoneNumber The new phone number, or null to clear it.
     * @return bool True on success, false on failure.
     */
    public function updatePhoneNumber($userId, $phoneNumber)
    {
        error_log("User Model: Attempting to update phone number for user ID: {$userId}");
        try {
            $stmt = $this->pdo->prepare("UPDATE users SET phone_number = :phone_number WHERE id = :userId");
            return $stmt->execute([
                ':phone_number' => $phoneNumber,
                ':userId' => $userId
            ]);
        } catch (PDOException $e) {
            error_log("User Model Error: updatePhoneNumber failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get the total number of registered users.
     * @return int The total number of users.
     */
    public function getTotalUsersRegistered()
    {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(id) FROM users");
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("User Model Error: getTotalUsersRegistered failed: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Find a user by their Google ID.
     * @param string $googleId The Google ID to search for.
     * @return array|false User data or false if not found.
     */
    public function findByGoogleId($googleId)
    {
        error_log("User Model: Attempting to find user with Google ID: '{$googleId}'");
        try {
            $stmt = $this->pdo->prepare("SELECT id, username, email, phone_number, password, google_id, oauth_provider, profile_picture, created_at, last_login, is_admin, is_banned, email_verified FROM users WHERE google_id = :google_id LIMIT 1");
            $stmt->execute([':google_id' => $googleId]);
            $user = $stmt->fetch();
            if ($user) {
                error_log("User Model: Found user with Google ID: " . $user['username'] . " (ID: " . $user['id'] . ")");
            } else {
                error_log("User Model: No user found for Google ID: '{$googleId}'");
            }
            return $user;
        } catch (PDOException $e) {
            error_log("User Model Error: findByGoogleId failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Create a new user via Google OAuth.
     * @param string $username
     * @param string $email
     * @param string $googleId
     * @param string|null $profilePicture
     * @param bool $emailVerified
     * @return int|false The ID of the newly created user, or false on failure.
     */
    public function createGoogleUser($username, $email, $googleId, $profilePicture = null, $emailVerified = true)
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password, google_id, oauth_provider, profile_picture, email_verified, is_admin, is_banned) VALUES (:username, :email, :password, :google_id, 'google', :profile_picture, :email_verified, 0, 0)");
            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => null,
                ':google_id' => $googleId,
                ':profile_picture' => $profilePicture,
                ':email_verified' => $emailVerified ? 1 : 0
            ]);
            $lastId = $this->pdo->lastInsertId();
            if ($lastId) {
                error_log("User Model: Google OAuth user created successfully with ID: {$lastId}");
            } else {
                error_log("User Model: Google OAuth user creation failed, no lastInsertId returned.");
            }
            return $lastId;
        } catch (PDOException $e) {
            error_log("User Model Error: createGoogleUser failed: " . $e->getMessage());
            if ($e->getCode() == '23000') {
                error_log("User Model Error: Duplicate entry for username or email.");
            }
            return false;
        }
    }

    /**
     * Link an existing user account with Google OAuth.
     * @param int $userId
     * @param string $googleId
     * @param string|null $profilePicture
     * @param bool $emailVerified
     * @return bool True on success, false on failure.
     */
    public function linkGoogleAccount($userId, $googleId, $profilePicture = null, $emailVerified = true)
    {
        error_log("User Model: Linking Google account for user ID: {$userId}");
        try {
            $stmt = $this->pdo->prepare("UPDATE users SET google_id = :google_id, oauth_provider = 'google', profile_picture = :profile_picture, email_verified = :email_verified WHERE id = :userId");
            return $stmt->execute([
                ':google_id' => $googleId,
                ':profile_picture' => $profilePicture,
                ':email_verified' => $emailVerified ? 1 : 0,
                ':userId' => $userId
            ]);
        } catch (PDOException $e) {
            error_log("User Model Error: linkGoogleAccount failed: " . $e->getMessage());
            return false;
        }
    }

}