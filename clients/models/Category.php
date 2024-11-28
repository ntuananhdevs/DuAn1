<?php
class Category {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getAllCategories() {
        $sql = "SELECT * FROM category";
        return $this->conn->query($sql);
    }
}
?>
