<?php
class ProfileModel {
    public $conn;
        
    public function __construct() {
        $this->conn = connectDB();
    }

    public function getUserById($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateAvatar($userId, $avatar) {
        $stmt = $this->conn->prepare("UPDATE users SET avatar = ? WHERE id = ?");
        return $stmt->execute([$avatar, $userId]);
    }
}

?>
