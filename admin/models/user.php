<?php
class User {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getAll() {
        $sql = "SELECT * FROM users WHERE role = 'user' ORDER BY id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(); 
    }

    public function create($data) {
        try {
        $avatar = !empty($data['avatar']) ? $data['avatar'] : '../uploads/UserIMG/default.png';
        
        $sql = "INSERT INTO users (user_name, password, email, phone_number, created_at, avatar) 
                VALUES (?, ?, ?, ?, NOW(), ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['username'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['email'],
            $data['phone_number'],
            $avatar
        ]);
        } catch (PDOException $e) {
            if($e->getCode() == 23000) {
                $_SESSION['error'] = "Tài khoản đã tồn tại!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi tạo tài khoản!";
            }
            return false;
        }
    }

    public function update($id, $data) {
        $sql = "UPDATE users SET 
                avatar = ?,
                user_name = ?, 
                email = ?, 
                phone_number = ?,
                updated_at = NOW()
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['avatar'],
            $data['user_name'],
            $data['email'],
            $data['phone_number'],
            $id
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>
