<?php 
class ProductsContronller {
    
    public $products;
    public $comment;

    public function __construct() {
        $this->products = new products();
        $this->comment = new Comment();
    }

    public function view_products($id)
    {
        $comments = $this->comment->getComment($id);
        $listPrd_Variant = $this->products->getPrd_Variant($id);
        $list_spect = $this->products->get_spect($id);
        $product = $this->products->get_prdbyid($id);
        if ($product) {
            $product = $product[0];
        require_once './clients/views/Product_details.php';
        }
    }

    
}