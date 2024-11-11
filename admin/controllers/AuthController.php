<?php
class AuthController {
    public $auth;
    public function __construct() {
        $this->auth = new Auth();
    }

    public function login() {
        try {
            // Biến để lưu lỗi nếu có
            $error = '';
            $emailError = '';
            $passwordError = '';
    
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';
    
                // Kiểm tra lỗi đầu vào phía backend (email, password)
                if (empty($email)) {
                    $emailError = "Email không được để trống";
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailError = "Địa chỉ email không hợp lệ";
                }
                if (empty($password)) {
                    $passwordError = "Mật khẩu không được để trống";
                }
    
                // Tiếp tục xử lý đăng nhập nếu không có lỗi phía backend
                if (empty($emailError) && empty($passwordError)) {
                    $data = $this->auth->login($email, $password);
                    if ($data) {
                        if ($data['role'] === 'admin') {
                            session_start();
                            $_SESSION['user_id'] = $data['id'];
                            $_SESSION['email'] = $data['email'];
                            $_SESSION['role'] = $data['role'];
                            header("Location: ?act=/");
                            exit();
                        } else {
                            $error = "Bạn không có quyền truy cập";
                        }
                    } else {
                        $error = "Tài khoản hoặc mật khẩu không chính xác";
                    }
                }
            }
            require '../admin/auth/login.php';
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    
    public function check_login() {
        session_start();
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['email'])) {
            header("Location: ?act=login");
            exit();
        }
    }
    public function logout() {
        session_unset();
        session_destroy();
        header("Location: ?act=login");
        exit();
    }
}
?>
