<?php
    require_once '../commons/env.php';
    require_once '../commons/core.php';

    #require Controller
    require_once '../clients/controllers/HomeController.php';

    #require Model


    $home = new HomeController();


    // Route
    $act = $_GET['act'] ?? '/';

    if ($act == 'login') {
        $auth->login();
    } else {
        // $auth->check_login();
        include '../clients/views/layout/header.php';
        match ($act) {
            '/' => $home->view_home(),

            default => $home->view_home(),
        };
}
