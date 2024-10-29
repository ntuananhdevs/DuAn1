<?php
class ProductsController
{
    public $producsts;

    public function __construct(){
        $this->producsts = new Products();
    }

    public function views_products() {
        $listProducts = $this->producsts->get_products();
        require_once './views/products.php';
    }
    public function views_add() {
        require_once './views/add_products.php';
    }

}