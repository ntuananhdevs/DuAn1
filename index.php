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
    if($act != 'login'){
        include './clients/views/layout/header.php';
    }
        match ($act) {
            '/' => $home->view_home(),
            ##LOGIN
            'register' => $login->register(),
            'login' => $login->login(),

            //PRODUCT
            'product_details' => $products->view_products(),

            ##Result
            'result' => $result->view_result(),





            default => $home->view_home(),
        };
