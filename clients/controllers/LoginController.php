<?php

session_start();
require_once __DIR__ . '/../models/LoginModel.php';
class LoginController {
    private $loginModel;

    public function __construct() {
        $this->loginModel = new LoginModel();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->loginModel->checkLogin($email, $password);

            if ($user) {
                $_SESSION['user'] = $user;
                header('Location: /DuAn1/index.php');
                exit();
            } else {
                echo "Email hoặc mật khẩu không đúng.";
            }
        } else {
            require_once __DIR__ . '/../auth/login.php';
        }
    }
}
