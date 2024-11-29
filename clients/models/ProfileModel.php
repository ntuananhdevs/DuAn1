<?php
class ProfileModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getUserById($userId) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting user: " . $e->getMessage());
            return false;
        }
    }

    public function updateUserProfile($userId, $data) {
        try {
            error_log('=== Database Update Debug ===');
            error_log('User ID: ' . $userId);
            error_log('Update data: ' . print_r($data, true));

            $sql = "UPDATE users SET 
                    fullname = :fullname,
                    email = :email,
                    phone_number = :phone_number,
                    updated_at = NOW()
                    WHERE id = :userId";

            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([
                ':userId' => $userId,
                ':fullname' => $data['fullname'],
                ':email' => $data['email'],
                ':phone_number' => $data['phone_number']
            ]);

            if (!$result) {
                error_log("Update failed for user ID: $userId");
                error_log("SQL Error: " . print_r($stmt->errorInfo(), true));
            } else {
                error_log("Update successful");
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function updateUserAvatar($userId, $avatarFileName) {
        try {
            $sql = "UPDATE users SET 
                    avatar = :avatar,
                    updated_at = NOW() 
                    WHERE id = :userId";
            
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':avatar' => $avatarFileName,
                ':userId' => $userId
            ]);
        } catch (PDOException $e) {
            error_log("Error updating avatar: " . $e->getMessage());
            return false;
        }
    }
}
?>
