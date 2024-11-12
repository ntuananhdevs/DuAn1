<?php 
class Home {
    public $conn;
    public function __construct() { 
        $this->conn = connectDB();
    }
    public function getBanner() {
        $sql = "SELECT * FROM banners WHERE status = 'active'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
