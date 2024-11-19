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
            
            $hashedPassword = $password;
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

    public function createUser($user_name, $email, $password) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $this->conn->prepare("INSERT INTO users (user_name, email, password) VALUES (:user_name, :email, :password)");
            if (!$stmt) {
                throw new Exception("Lỗi prepare statement: " . implode(", ", $this->conn->errorInfo()));
            }
            $stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
