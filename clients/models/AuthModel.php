        <?php
class AuthModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function register($user_name, $fullname, $first_name, $last_name, $email, $password, $phone_number) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (user_name, fullname, first_name, last_name, email, password, phone_number) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$user_name, $fullname, $first_name, $last_name, $email, $hashedPassword, $phone_number]);
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
    public function checkUserNameExists($username) {
        $sql = "SELECT COUNT(*) FROM users WHERE user_name = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetchColumn() > 0;
    }
    
    public function checkEmailExists($email) {
        $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }
    
    public function checkPhoneExists($phone) {
        $sql = "SELECT COUNT(*) FROM users WHERE phone_number = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$phone]);
        return $stmt->fetchColumn() > 0;
    }
}
