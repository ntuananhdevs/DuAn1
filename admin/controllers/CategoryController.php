<?php
require_once 'models/Category.php';

class CategoryController {
    public $categoryModel;

    public function __construct(){
        $this->categoryModel = new Category();
    }

    public function index() {
        $listCategories = $this->categoryModel->get_categories();
        require_once './views/Category/category.php';
    }
}
