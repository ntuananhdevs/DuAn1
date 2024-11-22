<?php 
class Pay {

    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }
    
}