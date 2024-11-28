        <?php
class AuthModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function register($user_name, $fullname, $email, $password, $phone_number) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (user_name, fullname, email, password, phone_number) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$user_name, $fullname, $email, $hashedPassword, $phone_number]);
    }

    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function updatePassword($userId, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = $this->conn->prepare("UPDATE users SET password = :password WHERE id = :user_id");
        return $query->execute([
            'password' => $hashedPassword,
            'user_id' => $userId
        ]);
    }

    public function markAsPermanent($userId) {
        $query = $this->conn->prepare("UPDATE users SET is_temporary = 0 WHERE id = :user_id");
        $query->execute(['user_id' => $userId]);
    }
}
