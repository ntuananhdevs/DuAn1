<?php
require_once '../commons/env.php';
require_once '../commons/core.php';

#require Controller
require_once '../clients/controllers/HomeController.php';
require_once '../clients/controllers/LoginController.php';

#require Model
require_once '../clients/models/loginModel.php';

$home = new HomeController();
$auth = new LoginController();

// Route
$act = $_GET['act'] ?? '/';

if ($act == 'login') {
    $auth->login();
} else {
    include '../clients/views/layout/header.php';
    match ($act) {
        '/' => $home->view_home(),
        default => $home->view_home(),
    };
}
