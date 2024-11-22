<?php
require_once "./clients/models/cartModel.php";

class CartController {
    public static function addToCart() {
        session_start();
        $user_id = $_SESSION['user_id'] ?? null; // User ID nếu có đăng nhập
        $session_id = session_id();
        $product_id = $_POST['product_id'] ?? '';
        $quantity = $_POST['quantity'] ?? 1;

        if ($product_id) {
            $cart_model = new CartModel();
            $cart_model->addToCart($user_id, $session_id, $product_id, $quantity);
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public static function viewCart() {
        session_start();
        $user_id = $_SESSION['user_id'] ?? null;
        $session_id = session_id();

        $cart_model = new CartModel();
        $cart_items = $cart_model->getCartItems($user_id, $session_id);

        require_once "./clients/views/cart/cart.php";
    }

    public static function removeFromCart() {
        $cart_item_id = filter_input(INPUT_POST, 'cart_item_id', FILTER_SANITIZE_NUMBER_INT);

        if (!$cart_item_id) {
            $_SESSION['error'] = 'Không tìm thấy sản phẩm cần xóa';
            header('Location: index.php?action=viewcart');
            exit();
        }

        $cart_model = new CartModel();
        $cart_model->removeFromCart($cart_item_id);

        $_SESSION['success'] = 'Đã xóa sản phẩm khỏi giỏ hàng';
        header('Location: index.php?action=viewcart');
        exit();
    }
}
