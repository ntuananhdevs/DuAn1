<?php
class AuthController {
    private $authModel;

    public function __construct() {
        $this->authModel = new AuthModel();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_name = $_POST['user_name'] ?? null;
            $fullname = $_POST['fullname'] ?? null;
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
    
            if ($user_name && $fullname && $email && $password) {
                if ($this->authModel->register($user_name, $fullname, $email, $password)) {
                    header('Location: index.php?act=login');
                    exit;
                } else {
                    echo "Đăng ký không thành công. Vui lòng thử lại.";
                }
            } else {
                echo "Vui lòng điền đầy đủ thông tin.";
            }
        }
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
