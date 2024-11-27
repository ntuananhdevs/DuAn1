<?php
class Category {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getAllCategories() {
        $sql = "SELECT * FROM categories WHERE status = 1";
        return $this->conn->query($sql);
    }
}
?>
