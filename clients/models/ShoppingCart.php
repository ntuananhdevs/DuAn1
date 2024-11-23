<?php 
    class ShoppingCart {
        public $conn;
        
        public function __construct() {
            $this->conn = connectDB();
        }
        public function get_cart() {
            $sql = "SELECT * FROM Carts";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
