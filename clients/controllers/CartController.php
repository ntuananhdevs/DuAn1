<?php
class CartController {
    public function view_cart() {
        require_once './clients/models/CartModel.php';
        $cartModel = new CartModel();

        // Lấy session_id của người dùng
        $session_id = session_id();
        $cart_items = $cartModel->getCartItems($session_id);

        // Tính tổng số lượng và giá
        $total_price = 0;
        $total_quantity = 0;
        foreach ($cart_items as $item) {
            $total_price += $item['price'] * $item['quantity'];
            $total_quantity += $item['quantity'];
        }

        // Gửi dữ liệu sang view
        require_once './clients/views/cart.php';
    }
}