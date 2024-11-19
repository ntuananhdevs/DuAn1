<?php
    class HomeController


    {
        public $homeModel;
        public function __construct() {
            $this->homeModel = new Home();
        }

        public function view_home()
        {
            $banners = $this->homeModel->getBanner();
            $products = $this->homeModel->get_products();
            include './clients/views/home.php';
        }
    }

    