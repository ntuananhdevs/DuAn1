<?php
    class ShoppingCartController {

        public $ShoppingCart;

        public function __construct() {
            $this->ShoppingCart = new ShoppingCart();
        }

        public function view_shoppingCart(){

            require_once './clients/views/ShoppingCart.php';
        }
    }
