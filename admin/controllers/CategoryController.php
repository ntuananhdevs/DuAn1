<?php
require_once 'models/Category.php';

class CategoryController {
    public $categoryModel;

    public function __construct() {
        $this->categoryModel = new Category();
    }

    public function index() {
        $listCategories = $this->categoryModel->get_categories();
        require_once './views/Category/category.php';
    }

    public function addCategory() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_name = $_POST['category_name'];
            $description = $_POST['description'];
            $this->categoryModel->add($category_name, $description);
            header("Location: ?act=category");
        } else {
            require_once './views/Category/add_category.php';
        }
    }

    public function editCategory($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_name = $_POST['category_name'];
            $description = $_POST['description'];
            $this->categoryModel->update($id, $category_name, $description);
            header("Location: ?act=category");
        } else {
            $category = $this->categoryModel->categorybyid($id);
            require_once './views/Category/edit_category.php';
        }
    }

    public function deleteCategory($id) {
        $this->categoryModel->delete($id);
        header("Location: ?act=category");
    }
}
