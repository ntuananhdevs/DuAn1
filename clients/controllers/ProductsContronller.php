<?php 
class ProductsContronller {
    
    public $products;

    public function __construct() {
        $this->products = new products();
    }

    public function view_products($id)
    {

        $listPrd_Variant = $this->products->getPrd_Variant($id);
        $list_spect = $this->products->get_spect($id);
        $product = $this->products->get_prdbyid($id);
        if ($product) {
            $product = $product[0];
        require_once './clients/views/Product_details.php';
        }
    }
}