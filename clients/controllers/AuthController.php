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
                
                // Validation
                $errors = [];
                
                if (empty($user_name)) {
                    $errors['user_name'] = 'Vui lòng nhập tên người dùng';
                } elseif (strlen($user_name) < 3) {
                    $errors['user_name'] = 'Tên người dùng phải có ít nhất 3 ký tự';
                }
                
                if (empty($email)) {
                    $errors['email'] = 'Vui lòng nhập email';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors['email'] = 'Email không hợp lệ';
                }
                
                if (empty($password)) {
                    $errors['password'] = 'Vui lòng nhập mật khẩu';
                } elseif (strlen($password) < 6) {
                    $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự';
                }
                
                if (empty($phone_number)) {
                    $errors['phone'] = 'Vui lòng nhập số điện thoại';
                } elseif (!preg_match('/^[0-9]{10}$/', $phone_number)) {
                    $errors['phone'] = 'Số điện thoại không hợp lệ';
                }
                
                if (empty($errors)) {
                    if ($this->authModel->register($user_name, $fullname, $email, $password, $phone_number)) {
                        header('Location: index.php?act=login');
                        exit;
                    } else {
                        throw new Exception("Đăng ký không thành công. Vui lòng thử lại.");
                    }
                } else {
                    // Trả về lỗi dưới dạng JSON
                    header('Content-Type: application/json');
                    echo json_encode(['errors' => $errors]);
                    exit;
                }
            }
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
        include './clients/auth/AuthLogin.php';
    }
    
    

    public function login() {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $email = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';
                
                $errors = [];
                
                if (empty($email)) {
                    $errors['email'] = 'Vui lòng nhập email';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors['email'] = 'Email không hợp lệ';
                }
                
                if (empty($password)) {
                    $errors['password'] = 'Vui lòng nhập mật khẩu';
                }
                
                if (empty($errors)) {
                    $user = $this->authModel->login($email, $password);
                    if ($user) {
                        session_start();
                        $_SESSION['user_id'] = $user['id'];
                        header('Location: index.php');
                        exit;
                    } else {
                        throw new Exception('Email hoặc mật khẩu không chính xác');
                    }
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['errors' => $errors]);
                    exit;
                }
            }
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
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

