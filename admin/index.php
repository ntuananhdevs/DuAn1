<?php
    require_once '../commons/env.php';
    require_once '../commons/core.php';

    #require Controller
    require_once '../admin/controllers/HomeController.php';
    require_once '../admin/controllers/ProductsContronller.php';
    require_once '../admin/controllers/CommentContronller.php';
    require_once '../admin/controllers/UserController.php';
    require_once '../admin/controllers/CategoryController.php';



    #require Model
    require_once '../admin/models/products.php';
    require_once '../admin/models/user.php';
    require_once '../admin/models/Comment.php';
    require_once '../admin/models/Category.php';




    $home = new HomeController();
    $products = new ProductsController();
    $user = new UserController();
    $comment = new CommentController();
    $category = new CategoryController();



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




            #CRUD category
            'category' => $category->index(),







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
            'edit' => $comment->editCommentForm($_GET['commentId' ]),
            'view_comments' => $comment->viewComments($_GET['product_id'] ),
            
            





            default => $home->views_home(),
        };
        include '../admin/views/layout/footer.php';
}
