<?php
    class ShoppingCartController {

        public $ShoppingCart;

        public function __construct() {
            $this->ShoppingCart = new ShoppingCart();
        }

        public function view_shoppingCart(){

            require_once './clients/views/ShoppingCart.php';
        }

        public function getCartItems($userId, $sessionId) {
            // Lấy dữ liệu từ Model
            $cart_item = $this->ShoppingCart->getCartItems($userId, $sessionId);
            return $cart_item;
        }

        public function updateQuantity() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $productId = intval($_POST['product_id']);
                $action = $_POST['action'];
                $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
                $sessionId = $userId ? null : session_id();

                if ($productId > 0) {
                    $cartItems = $this->ShoppingCart->getCartItems($userId, $sessionId);

                    // Ensure $cartItems is an associative array with product IDs as keys
                    foreach ($cartItems as $item) {
                        if ($item['variant_id'] == $productId) {
                            $newQuantity = ($action === 'increase') ? $item['quantity'] + 1 : max($item['quantity'] - 1, 1);
                            $cartId = $item['cart_item_id'];
                            $this->ShoppingCart->updateCartItemQuantity($cartId, $productId, $newQuantity);
                            break;
                        }
                    }
                }
                header('Location: ?act=shoppingcart');
            }
        }

        public function deleteItem() {
            if (isset($_GET['cart_item_id'])) {
                $cartItemId = intval($_GET['cart_item_id']);
                if ($this->ShoppingCart->deleteCartItem($cartItemId)) {
                    echo "Item deleted successfully"; // Debugging line
                } else {
                    echo "Failed to delete item"; // Debugging line
                }
            } else {
                echo "cart_item_id not set"; // Debugging line
            }
            header('Location: ?act=shoppingcart');
            exit();
        }
    }
