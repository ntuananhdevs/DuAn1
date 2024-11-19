<?php
class LoginController {
    private $loginModel;

    public function __construct() {
        $this->loginModel = new LoginModel();
    }

    public function login() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']);

            $user = $this->loginModel->checkLogin($email, $password);
            
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                
                if ($remember) {
                    setcookie('user_email', $email, time() + (86400 * 30), "/");
                    setcookie('user_password', $password, time() + (86400 * 30), "/");
                }
                
                $_SESSION['success'] = "Đăng nhập thành công!";
                header('Location: ?act=/');
                exit();
            } else {
                $_SESSION['error'] = "Email hoặc mật khẩu không đúng!";
                header('Location: ?act=login');
                exit();
            }
        }
        
        require_once './clients/auth/login.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_name = $_POST['user_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($this->loginModel->createUser($user_name, $email, $password)) {
                $_SESSION['success'] = "Tạo tài khoản thành công!";
                header('Location: ?act=login');
                exit();
            } else {
                $_SESSION['error'] = "Đã xảy ra lỗi khi tạo tài khoản!";
            }
        }

        require_once './clients/auth/register.php';
    }
}
