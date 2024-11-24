<?php
class AuthController {
    private $authModel;

    public function __construct() {
        $this->authModel = new AuthModel();
    }

    public function register() {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user_name = $_POST['user_name'] ?? null;
                $fullname = $_POST['fullname'] ?? null;
                $phone_number = $_POST['phone_number'] ?? null;
                $email = $_POST['email'] ?? null;
                $password = $_POST['password'] ?? null;
    
                // Kiểm tra các trường thông tin
                if ($user_name && $fullname && $email && $password && $phone_number) {
                    // Thử đăng ký người dùng
                    if ($this->authModel->register($user_name, $fullname, $email, $password, $phone_number)) {
                        header('Location: index.php?act=login');
                        exit;
                    } else {
                        throw new Exception("Đăng ký không thành công. Vui lòng thử lại.");
                    }
                } else {
                    throw new Exception("Vui lòng điền đầy đủ thông tin.");
                }
            }
        } catch (Exception $e) {
            
        }
    
        // Bao gồm giao diện
        include './clients/auth/AuthLogin.php';
    }
    
    

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user = $this->authModel->login($email, $password);
            if ($user) {
                $_SESSION['user'] = $user;
                header('Location: index.php');
            }
        }
        include './clients/auth/AuthLogin.php';
    }

    public function logout() {
        session_destroy();
        header('Location: index.php');
    }
}
