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

    public function addToCart() {
        session_start();
    
        $id = intval($_POST['id']);
        $product_id = intval($_POST['product_id']);
        $quantity = intval($_POST['quantity']);
        $price = ($_POST['price']);
        
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $session_id = $userId ? null : session_id();
        $cart_id = $this->products->get_or_creatCart($userId, $session_id);
    
        if ($this->products->add_or_UpdateItem($cart_id, $product_id, $quantity, $price)) {
            header('Location: ?act=product_detail&id=' . $id);
            exit();
        } else {
            echo "Failed to add item to cart.";
        }
    }
    public function getCartItems($userId, $sessionId) {
            $cart_item = $this->products->getCartItems($userId, $sessionId);
            return $cart_item;
    }
    
    public function addComment()
    {
        $product_id = (int)$_POST['product_id'];
        $user_id = (int)$_SESSION['user_id'];
        $content = trim($_POST['content']);
        $rating = (int)$_POST['rating'];

        if ($this->comment->addComment($product_id, $user_id, $content, $rating)) {
            header('Location: ?act=product_detail&id=' . $product_id);
        }
    }

    
}

