<?php

class CartModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function addToCart($user_id, $session_id, $product_id, $quantity) {
        try {
            // Tìm hoặc tạo giỏ hàng
            $stmt = $this->conn->prepare("
                SELECT id FROM carts 
                WHERE (user_id = :user_id OR session_id = :session_id) AND status = 'active'
            ");
            $stmt->execute(['user_id' => $user_id, 'session_id' => $session_id]);
            $cart = $stmt->fetch();

            if (!$cart) {
                $stmt = $this->conn->prepare("
                    INSERT INTO carts (user_id, session_id, created_at, status) 
                    VALUES (:user_id, :session_id, NOW(), 'active')
                ");
                $stmt->execute(['user_id' => $user_id, 'session_id' => $session_id]);
                $cart_id = $this->conn->lastInsertId();
            } else {
                $cart_id = $cart['id'];
            }

            // Thêm sản phẩm vào cart_items
            $stmt = $this->conn->prepare("
                INSERT INTO cart_items (cart_id, product_id, quantity, price, added_at) 
                VALUES (:cart_id, :product_id, :quantity, 
                    (SELECT MIN(price) FROM product_variants WHERE product_id = :product_id), NOW())
                ON DUPLICATE KEY UPDATE quantity = quantity + :quantity
            ");
            $stmt->execute([
                'cart_id' => $cart_id,
                'product_id' => $product_id,
                'quantity' => $quantity
            ]);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getCartItems($user_id, $session_id) {
        try {
            $stmt = $this->conn->prepare("
                SELECT 
                    ci.id AS cart_item_id,
                    ci.quantity,
                    p.id AS product_id,
                    p.product_name,
                    pv.price,
                    (ci.quantity * pv.price) AS total_price,
                    pv.color,
                    pv.ram,
                    pv.storage,
                    COALESCE(GROUP_CONCAT(vi.img), '') AS images,
                    d.discount_type,
                    d.discount_value,
                    d.status AS discount_status
                FROM cart_items ci
                INNER JOIN carts c ON ci.cart_id = c.id
                INNER JOIN products p ON ci.product_id = p.id
                LEFT JOIN product_variants pv ON p.id = pv.product_id
                LEFT JOIN variants_img vi ON pv.id = vi.variant_id
                LEFT JOIN discounts d ON p.id = d.product_id
                WHERE (c.user_id = :user_id OR c.session_id = :session_id) AND c.status = 'active'
                GROUP BY ci.id, p.id, pv.id, d.discount_type, d.discount_value, d.status
            ");
            $stmt->execute(['user_id' => $user_id, 'session_id' => $session_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function removeFromCart($cart_item_id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM cart_items WHERE id = :cart_item_id");
            $stmt->execute(['cart_item_id' => $cart_item_id]);
        } catch (PDOException $e) { 
            echo "Error: " . $e->getMessage();
        }
    }
}
