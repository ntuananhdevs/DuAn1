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

                // Kiểm tra username đã tồn tại
                if (empty($user_name)) {
                    $namesError = "Vui lòng nhập tên đăng nhập";
                } elseif ($this->authModel->checkUserNameExists($user_name)) {
                    $namesError = "Tên đăng nhập đã tồn tại";
                }

                // Kiểm tra fullname
                if (empty($fullname)) {
                    $surnamesError = "Vui lòng nhập đầy đủ họ tên";
                }

                // Kiểm tra email
                if (empty($email)) {
                    $emailCreateError = "Email không được để trống";
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailCreateError = "Địa chỉ email không hợp lệ";
                } elseif ($this->authModel->checkEmailExists($email)) {
                    $emailCreateError = "Email này đã được đăng ký";
                }

                // Kiểm tra password
                if (empty($password)) {
                    $passwordCreateError = "Mật khẩu không được để trống";
                } elseif (strlen($password) < 8) {
                    $passwordCreateError = "Mật khẩu phải có ít nhất 8 ký tự";
                } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d).+$/', $password)) {
                    $passwordCreateError = "Mật khẩu phải chứa cả chữ và số";
                }

                // Kiểm tra số điện thoại
                if (empty($phone_number)) {
                    $phone_numberError = "Vui lòng nhập số điện thoại";
                } elseif (!preg_match('/^[0-9]{10}$/', $phone_number)) {
                    $phone_numberError = "Số điện thoại không hợp lệ";
                } elseif ($this->authModel->checkPhoneExists($phone_number)) {
                    $phone_numberError = "Số điện thoại này đã được đăng ký";
                }

                // Nếu không có lỗi thì tiến hành đăng ký
                if (empty($namesError) && empty($surnamesError) && empty($emailCreateError) && 
                    empty($phone_numberError) && empty($passwordCreateError)) {
                    try {
                        $this->authModel->register($user_name, $fullname, $email, $password, $phone_number);
                        $message = "Đăng ký thành công!";
                        header("Location: ?act=login");
                        exit();
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
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailError = "Địa chỉ email không hợp lệ";
                }
                if (empty($password)) {
                    $passwordError = "Mật khẩu không được để trống";
                }
                if (empty($emailError) && empty($passwordError)) {
                    $user = $this->authModel->login($email, $password);
                    if ($user) {
                        if (password_verify($password, $user['password'])) {
                            $_SESSION['user_id'] = $user['id'];

                            if ($user['is_temporary'] == 1) {
                                header("Location: ?act=changer_password");
                                exit();
                            } else {
                                header('Location: index.php');
                                exit();
                            }
                        } else {
                            $error = "Email hoặc mật khẩu không chính xác";
                        }
                    } else {
                        $error = "Không tìm thấy tài khoản";
                    }
                }
            }
        } catch (Exception $e) {
            echo "Đã xảy ra lỗi: " . htmlspecialchars($e->getMessage());
        }
    
        require_once './clients/auth/AuthLogin.php';
    }
    

    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php');
        exit;   
    }

    public function changePassword() {
        require_once './clients/auth/ChangePassword.php';
    }
    public function changePassword_action() {
        session_start();
        $userId = $_SESSION['user_id'];
        $confirmPassword = $_POST['confirm_password'];

        $this->authModel->updatePassword($userId, $confirmPassword);

        $this->authModel->markAsPermanent($userId);
        header("Location: ?act=login");
    }

}

