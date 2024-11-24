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
}
?>
