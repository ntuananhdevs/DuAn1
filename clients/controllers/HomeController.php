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
            include './clients/views/home.php';
        }
    }

    