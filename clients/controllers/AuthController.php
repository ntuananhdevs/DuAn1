<?php
class AuthController {
    private $authModel;

    public function __construct() {
        $this->authModel = new AuthModel();
    }

    public function register() {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user_name = trim($_POST['user_name'] ?? '');
                $fullname = trim($_POST['fullname'] ?? '');
                $phone_number = trim($_POST['phone_number'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';
                if (empty($user_name)) {
                    throw new Exception('Vui lòng nhập tên người dùng');
                }
                if (strlen($user_name) < 3) {
                    throw new Exception('Tên người dùng phải có ít nhất 3 ký tự');
                }
                
                if (empty($email)) {
                    throw new Exception('Vui lòng nhập email');
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception('Email không hợp lệ');
                }
                
                if (empty($password)) {
                    throw new Exception('Vui lòng nhập mật khẩu');
                }
                if (strlen($password) < 6) {
                    throw new Exception('Mật khẩu phải có ít nhất 6 ký tự');
                }
                
                if (empty($phone_number)) {
                    throw new Exception('Vui lòng nhập số điện thoại');
                }
                if (!preg_match('/^[0-9]{10}$/', $phone_number)) {
                    throw new Exception('Số điện thoại không hợp lệ');
                }

                if ($this->authModel->register($user_name, $fullname, $email, $password, $phone_number)) {
                    echo json_encode(['status' => 'success', 'message' => 'Đăng ký thành công']);
                    exit;
                } else {
                    throw new Exception("Đăng ký không thành công. Vui lòng thử lại.");
                }
            }
        } catch (Exception $e) {
            exit;
        }
        include './clients/auth/AuthLogin.php';
    }
    
    

    public function login() {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $email = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';
                
                if (empty($email)) {
                    throw new Exception('Vui lòng nhập email');
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception('Email không hợp lệ');
                }
                
                if (empty($password)) {
                    throw new Exception('Vui lòng nhập mật khẩu');
                }

                $user = $this->authModel->login($email, $password);
                if ($user) {
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    // echo json_encode(['status' => 'success', 'message' => 'Đăng nhập thành công']);
                    header('Location: index.php');
                    exit;
                } else {
                    throw new Exception('Email hoặc mật khẩu không chính xác');
                }
            }
        } catch (Exception $e) {
            exit;
        }
        include './clients/auth/AuthLogin.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php');
        exit;   
    }
}

