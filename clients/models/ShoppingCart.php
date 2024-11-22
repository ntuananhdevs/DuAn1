<?php 

    class ShoppingCart {
        public $conn;
        
        public function __construct() {
            $this->conn = connectDB();
        }
    }