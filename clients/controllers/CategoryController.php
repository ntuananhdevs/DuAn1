<?php
class CategoryController{
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getAllCategories(){
        $sql = "SELECT * FROM category";
        $result = $this->conn->query($sql);
        return $result;
    }
}
?>