<?php 
class Banner {
    public $conn;
    public function __construct() { 
        $this->conn = connectDB();
    }
}
?>