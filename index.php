
<?php
    require_once './commons/env.php';
    require_once './commons/core.php';

    #require Controller
    require_once './clients/controllers/HomeController.php';
 

    #require Model

    require_once './clients/models/Home.php';


    $home = new HomeController();


  

    $act = $_GET['act'] ?? '/';

   include './clients/views/layout/header.php';
        match ($act) {
            '/' => $home->view_home(),



            default => $home->view_home(),
        };
