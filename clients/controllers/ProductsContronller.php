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
    public function addToCart() {
        session_start();
    
        $id = intval($_POST['id']);
        $product_id = intval($_POST['product_id']);
        $quantity = intval($_POST['quantity']);
        $price = ($_POST['price']);    
        $session_id = session_id();
        $cart_id = $this->products->get_or_creatCart($session_id);
    
        if ($this->products->add_or_UpdateItem($cart_id, $product_id, $quantity, $price)) {
            header('Location: ?act=product_detail&id=' . $id);
        } 
    }
    public function getCartItems($userId, $sessionId) {
            // Lấy dữ liệu từ Model
            $cart_item = $this->products->getCartItems($userId, $sessionId);
            return $cart_item;
    }
}