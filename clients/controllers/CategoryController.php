<?php
class CategoryController {
    private $category;
    
    public function __construct($category) {
        $this->category = $category;
    }
    
    public function getCategories() {
        return $this->category->getAllCategories();
    }
}
?>