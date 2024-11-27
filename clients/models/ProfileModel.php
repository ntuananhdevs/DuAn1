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
                error_log("SQL Error: " . implode(", ", $stmt->errorInfo()));
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log("Error updating profile: " . $e->getMessage());
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
