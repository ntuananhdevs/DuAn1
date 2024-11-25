<?php
class ProductsContronller
{

    public $products;
    public $comment;

    public function __construct()
    {
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

    public function addToCart()
    {
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
    public function getCartItems($userId, $sessionId)
    {
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
  
    
    public function updateLikeDislike()
    {
        // Kiểm tra phương thức HTTP
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Phương thức không hợp lệ.';
            $this->redirectToHome();
            return;
        }
    
        // Lấy dữ liệu từ POST và SESSION
        $commentId = filter_input(INPUT_POST, 'comment_id', FILTER_VALIDATE_INT);
        $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
        $productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $userId = $_SESSION['user_id'] ?? null;
    
        // Kiểm tra tính hợp lệ của dữ liệu
        if (!$commentId || !$userId || !in_array($action, ['like', 'dislike'])) {
            $_SESSION['error'] = 'Thông tin không hợp lệ.';
            $this->redirectToHome();
            return;
        }
    
        // Gọi phương thức updateLikeDislike từ model
        $result = $this->comment->updateLikeDislike($userId, $commentId, $action , $productId);
    
        if ($result) {
            // Nếu thành công, chuyển hướng đến trang chi tiết sản phẩm
            if (!$productId) {
                header('Location: ?act=product_detail&id=' . $productId);
            } else {
                header('Location: ?act=comments');
            }
        } else {
            // Nếu thất bại, lưu thông báo lỗi
            $_SESSION['error'] = 'Có lỗi xảy ra khi cập nhật lượt like/dislike.';
            header('Location: ?act=comments');
        }
        exit;
    }
    
    // Phương thức hỗ trợ để điều hướng về trang chủ
    private function redirectToHome()
    {
        header('Location: ?act=/');
        exit;
    }
    

}
