
<?php
    require_once './commons/env.php';
    require_once './commons/core.php';

    #require Controller
    require_once './clients/controllers/HomeController.php';
    require_once './clients/controllers/BannerController.php';

    #require Model
  
    require_once './clients/models/Banner.php';
    $home = new HomeController();
    $banner = new BannerController();


    $act = $_GET['act'] ?? '/';

   include './clients/views/layout/header.php';
        match ($act) {
            '/' => $banner->getBanner(),
            
            default => $home->view_home(),
        };

