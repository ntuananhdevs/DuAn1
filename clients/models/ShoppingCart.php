<?php 
    class ShoppingCart {
        public $conn;
        
        public function __construct() {
            $this->conn = connectDB();
        }
        public function getCartItems($userId = null, $sessionId = null) {
            $sql = "SELECT 
                        ci.id AS cart_item_id,
                        p.product_name,
                        pv.id AS variant_id,
                        pv.color,
                        pv.ram,
                        pv.storage,
                        ci.quantity,
                        ci.price,
                        vi.img,
                        ca.category_name
                    FROM 
                        carts c
                    JOIN 
                        cart_items ci ON c.id = ci.cart_id
                    JOIN 
                        product_variants pv ON ci.product_id = pv.id
                    JOIN 
                        products p ON pv.product_id = p.id
                    JOIN
                        category ca ON p.category_id = ca.id
                    LEFT JOIN 
                        variants_img vi ON pv.id = vi.variant_id
                    WHERE 
                        (c.user_id = :user_id OR c.session_id = :session_id)
                    ";
                        
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':user_id' => $userId,
                ':session_id' => $sessionId
            ]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function updateCartItemQuantity($cartItemId, $productId, $newQuantity) {
            $sql = "UPDATE cart_items SET quantity = ? WHERE id = ? AND product_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$newQuantity, $cartItemId, $productId]);
            return $stmt->rowCount(); 
        }

        public function deleteCartItem($cartItemId) {
            $sql = "DELETE FROM cart_items WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([$cartItemId]);
            if ($result) {
                echo "SQL executed successfully"; // Debugging line
            } else {
                echo "SQL execution failed"; // Debugging line
                print_r($stmt->errorInfo()); // Debugging line
            }
            return $result;
        }
        
    }
