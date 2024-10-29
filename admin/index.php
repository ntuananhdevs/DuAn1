<?php
require_once '../commons/env.php';
require_once '../commons/core.php';

#require Controller
require_once '../admin/controllers/HomeController.php';

// require_once '../admin/models/products.php';

$home = new HomeController();


// Route
$act = $_GET['act'] ?? '/';

if ($act == 'login') {
    $auth->login(); 
} else {
    // $auth->check_login();
    include '../admin/views/layout/header.php';


    match ($act) {
        '/' => $home->views_home(),

    };
    include '../admin/views/layout/footer.php';
}
?>
