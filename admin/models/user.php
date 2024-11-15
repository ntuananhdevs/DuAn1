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
        $avatar = !empty($data['avatar']) ? $data['avatar'] : '../assets/img/login.png';
        
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

    public function getBySearch($search) {
        $sql = "SELECT * FROM users WHERE (user_name LIKE ? OR email LIKE ? OR id LIKE ?) AND role = 'user' ORDER BY id ASC";
        $stmt = $this->conn->prepare($sql);
        $searchTerm = "%$search%";
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
}
?>
