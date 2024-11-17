<?php
class LoginModel {
    private $pdo;

    public function __construct() {
        $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME;
        $username = "root";
        $password = '';

        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function checkLogin($email, $password) {
        try {
            $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            return false;
        }
    }
}
