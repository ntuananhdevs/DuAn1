<?php
class CartModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getCartItems($session_id) {
        $sql = "
            SELECT ci.id, p.product_name, ci.quantity, ci.price, 
                   GROUP_CONCAT(vi.img) AS images
            FROM cart_items ci
            JOIN carts c ON ci.cart_id = c.id
            JOIN products p ON ci.product_id = p.id
            LEFT JOIN product_variants pv ON p.id = pv.product_id
            LEFT JOIN variants_img vi ON pv.id = vi.variant_id
            WHERE c.session_id = ?
            GROUP BY ci.id;
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$session_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}