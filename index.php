<?php
    require_once './commons/env.php';
    require_once './commons/core.php';

    #require Controller
    require_once './clients/controllers/HomeController.php';
    require_once './clients/controllers/LoginController.php';
    require_once './clients/controllers/ProductsContronller.php';
    require_once './clients/controllers/CartController.php';

    #require Model

    require_once './clients/models/Home.php';
    require_once './clients/models/Products_details.php';
    require_once './clients/models/LoginModel.php';
    require_once './clients/models/CartModel.php';


    $home = new HomeController();
    $login = new LoginController();
    $products = new ProductsContronller();
    $cart = new CartController();

  

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
            'product_detail' => $products->view_products($_GET['id']),
                // CART
            'view_cart' => $cart->view_cart(),





            default => $home->view_home(),
        };
    include './clients/views/layout/footer.php';