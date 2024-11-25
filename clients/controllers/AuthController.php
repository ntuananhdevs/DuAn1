<?php
class AuthController {
    private $authModel;

    public function __construct() {
        $this->authModel = new AuthModel();
    }

    public function register() {
        try {
            $message = '';
            $namesError = '';
            $surnamesError = '';
            $emailCreateError = '';
            $phone_numberError = '';
            $passwordCreateError = '';

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user_name = trim($_POST['user_name'] ?? '');
                $fullname = trim($_POST['fullname'] ?? '');
                $phone_number = trim($_POST['phone_number'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';
                if (empty($fullname)) {
                    $surnamesError = "Vui lòng nhập đầy đủ họ tên";
                }
                if (empty($email)) {
                    $emailCreateError = "Email không được để trống";
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailCreateError = "Địa chỉ email không hợp lệ";
                }
                if (empty($password)) {
                    $passwordCreateError = "Mật khẩu không được để trống";
                }
                if (empty($phone_number)) {
                    $phone_numberError = "Vui lòng nhập số điện thoại";
                }
                if ( empty($surnamesError) && empty($emailCreateError) && empty($phone_numberError) && empty($passwordCreateError)) {
                    try {
                        $this->authModel->register($user_name, $fullname, $email, $password, $phone_number);
                    } catch (PDOException $e) {
                        if ($e->getCode() == 23000 && strpos($e->getMessage(), 'Duplicate entry') !== false) {
                            $message = "Tài khoản này đã được đăng ký trong hệ thống";
                        } else {
                            throw $e;
                        }
                    }
                }
            }
            require_once './clients/auth/AuthLogin.php';
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    

    public function login() {
        try {
            $error = '';
            $emailError = '';
            $passwordError = '';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $email = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';
                
                if (empty($email)) {
                    $emailError = "Email không được để trống";
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailError = "Địa chỉ email không hợp lệ";
                }
                
                if (empty($password)) {
                    $passwordError = "Mật khẩu không được để trống";
                }

                $user = $this->authModel->login($email, $password);
                if ($user) {
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    header('Location: index.php');
                    exit;
                } else {
                    $error = "Email hoặc mật khẩu không chính xác";
                }
            }
        } catch (Exception $e) {
            exit;
        }
        require_once './clients/auth/AuthLogin.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php');
        exit;   
    }
}

