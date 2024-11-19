<?php
class LoginModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function checkLogin($email, $password) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
            if (!$stmt) {
                throw new Exception("Lỗi prepare statement: " . implode(", ", $this->conn->errorInfo()));
            }
            
            $hashedPassword = $password; // Mã hóa mật khẩu
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
            $stmt->execute();
            
            if($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            return false;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
