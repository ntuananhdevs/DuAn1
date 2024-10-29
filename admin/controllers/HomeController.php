<?php
class HomeController {
    public $home;

    public function __construct() {

    }

    public function views_home() {
        require_once './views/home.php';
    }
}