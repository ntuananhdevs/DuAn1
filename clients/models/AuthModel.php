        <?php
class AuthModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function register($user_name, $fullname, $email, $password) {
        $hashedPassword = $password;
        $stmt = $this->conn->prepare("INSERT INTO users (user_name, fullname, email, password) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$user_name, $fullname, $email, $hashedPassword]);
    }

    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && $user['password'] === $password) {
            return $user;
        }
        return false;
    }
}
