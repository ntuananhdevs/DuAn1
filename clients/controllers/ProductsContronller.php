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
    public function addToCartNow() {
        session_start();

        $id = intval($_POST['id']);
        $product_id = intval($_POST['product_id']);
        $quantity = intval($_POST['quantity']);
        $price = ($_POST['price']);

        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $session_id = $userId ? null : session_id();
        $cart_id = $this->products->get_or_creatCart($userId, $session_id);

        if ($this->products->add_or_UpdateItem($cart_id, $product_id, $quantity, $price)) {
            header('Location: ?act=shoppingcart');
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
      

        if ($this->comment->addComment($user_id, $product_id, $content, $rating)) {
            header('Location: ?act=product_detail&id=' . $product_id);
        }
    }
  
    
    public function updateLikeDislike()
    {
        // Chỉ chấp nhận phương thức HTTP POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->setErrorAndRedirect('Phương thức không hợp lệ.', '?act=/');
            return;
        }
    
        // Lấy dữ liệu từ POST và SESSION
        $commentId = filter_input(INPUT_POST, 'comment_id', FILTER_VALIDATE_INT);
        $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
        $productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $userId = $_SESSION['user_id'] ?? null;
    
        // Kiểm tra tính hợp lệ của dữ liệu
        if (!$commentId || !$userId || !in_array($action, ['like', 'dislike'])) {
            $this->setErrorAndRedirect('Thông tin không hợp lệ.', '?act=/');
            return;
        }
    
        // Gọi phương thức updateLikeDislike từ model
        $result = $this->comment->updateLikeDislike($userId, $commentId, $action);
    
        // Kiểm tra kết quả và điều hướng
        if ($result) {
            // Chuyển hướng đến trang chi tiết sản phẩm nếu có productId, nếu không thì về danh sách comments
            $redirectUrl = $productId 
                ? '?act=product_detail&id=' . $productId 
                : '?act=comments';
            header('Location: ' . $redirectUrl);
        } else {
            // Nếu thất bại, hiển thị thông báo lỗi
            $this->setErrorAndRedirect('Có lỗi xảy ra khi cập nhật lượt like/dislike.', '?act=comments');
        }
        exit;
    }
    
    // Hàm hỗ trợ để thiết lập lỗi và điều hướng
    private function setErrorAndRedirect($message, $redirectUrl)
    {
        $_SESSION['error'] = $message;
        header('Location: ' . $redirectUrl);
        exit;
    }
    

}