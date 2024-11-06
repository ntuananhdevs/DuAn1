<?php
require_once '../../vendor/autoload.php';

class AuthController {
    private $client;

    public function __construct() {
        $this->client = new Google_Client();
        $this->client->setClientId('766981410961-qn145eckf8k1f45l2trjg6nb6uehncol.apps.googleusercontent.com');
        $this->client->setClientSecret('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');
        $this->client->setRedirectUri('http://localhost/duan1');
        $this->client->addScope("email");
        $this->client->addScope("profile");
    }

    public function login() {
        $loginUrl = $this->client->createAuthUrl();
        header("Location: " . $loginUrl);
        exit();
    }

    public function callback() {
        if (isset($_GET['code'])) {
            $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
            $this->client->setAccessToken($token['access_token']);

            $googleService = new Google_Service_Oauth2($this->client);
            $userInfo = $googleService->userinfo->get();

            // Lưu thông tin người dùng vào session
            $_SESSION['email'] = $userInfo->email;
            $_SESSION['name'] = $userInfo->name;

            // Chuyển hướng về trang chính
            header('Location: ?action=home');
            exit();
        } else {
            // Nếu không có mã truy cập, chuyển về trang đăng nhập
            header('Location: ../login.php');
            exit();
        }
    }
}
