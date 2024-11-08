<?php
    require_once '../commons/env.php';
    require_once '../commons/core.php';

    #require Controller
    require_once '../admin/controllers/HomeController.php';
    require_once '../admin/controllers/ProductsContronller.php';
    require_once '../admin/controllers/CommentContronller.php';
    require_once '../admin/controllers/UserController.php';
    require_once '../admin/controllers/CategoryController.php';
    require_once '../admin/controllers/OderController.php';


    #require Model
    require_once '../admin/models/products.php';
    require_once '../admin/models/user.php';
    require_once '../admin/models/Comment.php';
    require_once '../admin/models/category.php';
<<<<<<< HEAD
    require_once '../admin/models/oder.php';

=======
    require_once '../admin/models/home.php'; 
>>>>>>> dcb112fa2a8832b96ecd3eb82b621f3f5730c62b



    $home = new HomeController();
    $products = new ProductsController();
    $user = new UserController();
    $comment = new CommentController();
    $category = new CategoryController();
    $oder = new OderController();


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
            'product_detail' => $products->viewPrd_Variant($_GET['id']),
            'add-product' => $products->views_add(),
            'post-product' => $products->add_product(),
            'delete_product' => $products->deletePrd($_GET['id']),
            'update_des' => $products->views_update_des($_GET['id']),
            'post_update_des' => $products->updateProductDescription(),
            'update_spect'=> $products->views_update_spect($_GET['id']),
            'update_product' => $products->views_update_product($_GET['id']),
            'update-product-post' => $products->update_products(),
            'post_update_spect' => $products->update_spect(),
            'add_variant' => $products->viewAdd_variant(),
            'add_variants_post' => $products->add_variants(),
            'delete_variant' => $products->delete_variant($_GET['id']),
            'update_variant' => $products->viewUpdate_variant(),
            'post_update_variants' => $products->update_variants(),
            'update_variant_post' => $products->update_variants(),

        
            

            #CRUD category
            'category' => $category->index(),
            'add_category' => $category->addCategory(),
            'edit_category' => $category->editCategory($_GET['id']),
            'delete_category' => $category->deleteCategory($_GET['id']),


            #CRUD user
            'users' => $user->views_users(),
            'add-user' => $user->views_add(),
            'add-user-post' => $user->add(),
            'edit-user' => $user->views_edit(),
            'edit-user-post' => $user->edit(),
            'delete-user' => $user->delete(),

            #CRUD comment
            'comments' => $comment->views_comment(),
            'delete' => $comment->deleteComment($_GET['id']),
            'view_comments' => $comment->viewComments($_GET['product_id'] ),
           
            #CRUD oder
            'oders' => $oder->views_oder(),
            'add_oder' => $oder->views_add(),
            'add_oder_post' => $oder->add_oder(),
            'edit_oder' => $oder->views_edit(),
            'update_oder' => $oder->edit(),
            'delete_oder' => $oder->delete(),






            default => $home->views_home(),
        };
        include '../admin/views/layout/footer.php';
}