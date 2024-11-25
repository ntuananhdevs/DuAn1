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
        public function view_apple_products($id)
        {
            $apple_category_id = $id;
            $products = $this->homeModel->get_products_by_category($apple_category_id);
            include './clients/views/apple_products.php';
        }
    }

    