<?php
class HomeController {
    public $home;

    public function __construct() {
        $this->home = new Home();
    }

    public function views_home() {
        $total_money = $this->home->total_order();
        $list_product = $this->home->total_prd();
        $list_user = $this->home->total_users();

        require_once './views/home.php';
    }

    public function total_users() {
        require_once './views/home.php';
    }
}