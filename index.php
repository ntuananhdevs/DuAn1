<?php
    require_once './commons/env.php';
    require_once './commons/core.php';

#require Controller
    require_once './clients/controllers/HomeController.php';
    require_once './clients/controllers/LoginController.php';
    require_once './clients/controllers/ProductsContronller.php';
    require_once './clients/controllers/ResultController.php';


#require Model

    require_once './clients/models/Home.php';
    require_once './clients/models/Products_details.php';
    require_once './clients/models/LoginModel.php';
    require_once './clients/models/Result.php';


    $home = new HomeController();
    $login = new LoginController();
    $products = new ProductsContronller();
    $result = new ResultController();

    $act = $_GET['act'] ?? '/';

    $title = match ($act) {
        'login' => 'Login',
        'register' => 'Register',
        'logout' => 'Logout',
        '/' => 'Home',
        'product_detail' => 'Product Details',
        'laptop' => 'Laptops',
        'phone' => 'Phones',
        'result' => 'Search Results',
        'add_comment' => 'Add Comment',
        default => 'Home',
    };

    if ($act == 'login') {
        $auth->login();
    } else if ($act == 'register') {
        $auth->register();
    } else if ($act == 'logout') {
        $auth->logout();
    } else {
        include './clients/views/layout/header.php';
        match ($act) {
            '/' => $home->view_home(),

            'product_detail' => $products->view_products($_GET['id']),


            'result' => $result->view_result(),

            default => $home->view_home(),
        };
        include './clients/views/layout/footer.php';
    }
