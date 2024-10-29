<?php
require_once '../commons/env.php';
require_once '../commons/core.php';

#require Controller
require_once '../admin/controllers/HomeController.php';
require_once '../admin/controllers/ProductsContronller.php';
require_once '../admin/controllers/UserController.php';






#require Model
require_once '../admin/models/products.php';
require_once '../admin/models/user.php';






$home = new HomeController();
$products = new ProductsController();
$user = new UserController();




// Route
$act = $_GET['act'] ?? '/';

if ($act == 'login') {
    $auth->login(); 
} else {
    // $auth->check_login();
    include '../admin/views/layout/header.php';

    match ($act) {
        '/' => $home->views_home(),
#CRUD product
        'products' => $products->views_products(),
        'add-product' => $products->views_add(),
        






#CRUD category








#CRUD user
'users' => $user->views_users(),
'add-user' => $user->views_add(),
'add-user-post' => $user->add(),
'edit-user' => $user->views_edit(),
'edit-user-post' => $user->edit(),
'delete-user' => $user->delete(),









#CRUD comment








    };
    include '../admin/views/layout/footer.php';
}
?>
