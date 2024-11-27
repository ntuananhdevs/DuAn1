<?php
    require_once './commons/env.php';
    require_once './commons/core.php';

    #require Controller
    require_once './clients/controllers/HomeController.php';
    require_once './clients/controllers/AuthController.php';
    require_once './clients/controllers/ProductsContronller.php';
    require_once './clients/controllers/ResultController.php';
    require_once './clients/controllers/PayController.php';
    require_once './clients/controllers/SpCartContronller.php';
    require_once './clients/controllers/ProfileController.php';
    require_once './clients/controllers/OrderContronller.php';

    #require Model
    require_once './clients/models/Home.php';
    require_once './clients/models/Products_details.php';
    require_once './clients/models/Result.php';
    require_once './clients/models/Pay.php';
    require_once './clients/models/ShoppingCart.php';
    require_once './clients/models/AuthModel.php';
    require_once './clients/models/Comments.php';
    require_once './clients/models/ProfileModel.php';
    require_once './clients/models/OrderModel.php';

    $home = new HomeController();
    $result = new ResultController();
    $pay = new PayController();
    $shoppingCart = new ShoppingCartController();
    $auth = new AuthController();
    $products = new ProductsContronller();
    $profile = new ProfileController();
    $order = new OrderController();

    $act = $_GET['act'] ?? '/';

    $title = match ($act) {
        'login' => 'Login',
        'register' => 'Register',
        'logout' => 'Logout',
        '/' => 'Home',
        'product_detail' => 'Product Details',
        'shoppingcart' => 'WinTech Cart',
        'phone' => 'Phones',
        'result' => 'Search Results',
        'add_comment' => 'Add Comment',
        'add_review' => 'Add Review',
        'profile' => 'Profile',
        'update-avatar' => 'Update Avatar',
        'update-profile' => 'Update Profile',
        'orders' => 'My Orders',
        'order-detail' => 'Order Detail',
        default => 'Home',
    };
    
    if ($act == 'login') {
        $auth->login();
    } else if ($act == 'register') {
        $auth->register();
    } else if ($act == 'logout') {
        $auth->logout();
    } else if ($act == 'update-avatar') {  
        $profile->updateAvatar(); 
    } else if ($act == 'update-profile') {  
        $profile->updateProfile();
    } else {
        include './clients/views/layout/header.php';
        match ($act) {
            '/' => $home->view_home(),
            'product_detail' => $products->view_products($_GET['id']),
            'add_to_cart' => $products->addToCart(),
            'shoppingcart' => $shoppingCart->view_shoppingCart(),
            'update_cart' => $shoppingCart->updateQuantity(),
            'delete_items' => $shoppingCart->deleteItem($_GET['product_id']),
            'profile' => $profile->showProfile(),
            'update_profile' => $profile->updateProfile(),
            'pay' => $pay->view_pay(),
            'order' => $pay->add_order(),
            'loadbuy' => $pay->loadbuy(),
            'add_review' => $products->addComment($_POST),
            'result' => $result->view_result(),
            'apple_products' => $home->view_apple_products($_GET['id']),
            'orders' => $order->viewOrders(),
            'order-detail' => $order->viewOrderDetail($_GET['id']),
            'cancel-order' => $order->cancelOrder($_GET['id']),
            default => $home->view_home(),
        };
        include './clients/views/layout/footer.php';
    }
?>
