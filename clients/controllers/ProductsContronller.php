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
    public function getComments($product_id)
    {
        if (!$product_id) {
            echo json_encode(['success' => false, 'message' => 'Invalid product ID.']);
            return;
        }

        $comments = $this->comment->get_comments_by_product($product_id);

        if ($comments) {
            echo json_encode(['success' => true, 'comments' => $comments]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No comments found for this product.']);
        }
    }
    public function addReview($request)
    {
        // Extract and sanitize inputs
        $product_id = isset($request['product_id']) ? (int)$request['product_id'] : null;
        $user_id = isset($request['user_id']) ? (int)$request['user_id'] : null;
        $content = isset($request['content']) ? trim($request['content']) : '';
        $rating = isset($request['rating']) ? (int)$request['rating'] : null;
    
        // Validate inputs
        if (!$product_id || !$user_id) {
            echo json_encode(['success' => false, 'message' => 'Invalid product or user ID.']);
            return;
        }
    
        if (strlen($content) < 3) {
            echo json_encode(['success' => false, 'message' => 'Content must be at least 15 characters long.']);
            return;
        }
    
        if ($rating !== null && ($rating < 1 || $rating > 5)) {
            echo json_encode(['success' => false, 'message' => 'Rating must be between 1 and 5.']);
            return;
        }
    

        $success = $this->comment->add_comment($product_id, $user_id, $content, $rating);
    
        // Respond with JSON
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Review added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add review. Please try again later.']);
        }
    }
    
}

