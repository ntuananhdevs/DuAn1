<?php 
class products {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getPrd_Variant($id)
    {
        try {
                $sql = "SELECT 
                            p.id AS product_id,                  
                            p.product_name AS product_name,      
                            p.rating AS rating,                  
                            pv.id AS variant_id,                 
                            pv.color AS color,                   
                            pv.ram AS ram,                       
                            pv.storage AS storage,               
                            pv.price AS price,                   
                            pv.quantity AS quantity,             
                            GROUP_CONCAT(vi.img) AS images,      
                            p.description AS description,        
                            c.category_name AS category_name,    
                            d.discount_type AS discount_type,    
                            d.discount_value AS discount_value,  
                            d.status AS discount_status,         
                            COUNT(cm.id) AS total_comments       -- Tính tổng số lượng bình luận
                        FROM 
                            Products p
                        JOIN 
                            Product_variants pv ON p.id = pv.product_id      
                        LEFT JOIN 
                            Variants_img vi ON pv.id = vi.variant_id         
                        LEFT JOIN 
                            Category c ON p.category_id = c.id  
                        LEFT JOIN 
                            Discounts d ON p.id = d.product_id  
                        LEFT JOIN 
                            comments cm ON p.id = cm.product_id  
                        WHERE   
                            p.id = ?
                        GROUP BY 
                        pv.id, 
                        p.id, 
                        p.product_name, 
                        p.rating, 
                        p.description, 
                        c.category_name, 
                        d.discount_type, 
                        d.discount_value, 
                        d.status;
                ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $products;
        } catch (PDOException $e) {
            echo "SQL Error: " . $e->getMessage();
        }
    }
    public function get_prdbyid($id) {
        try {
            $sql = "SELECT 
                        p.*,                            -- Lấy tất cả các cột từ bảng Products
                        COUNT(c.id) AS total_comments   -- Đếm tổng số lượng bình luận
                    FROM 
                        Products p
                    LEFT JOIN 
                        Comments c ON p.id = c.product_id  -- Kết nối với bảng Comments
                    WHERE 
                        p.id = ?
                    GROUP BY 
                        p.id;  -- Nhóm theo từng sản phẩm
                    ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $products;
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    public function get_spect($id) {
        $sql = "SELECT 
                    sp.id AS Spect_ID,                
                    sp.product_id AS Product_ID,      
                    sp.spect_name AS Specification_Name,    
                    sp.spects_value AS Specification_Value   
                FROM 
                    products_spect sp
                WHERE 
                    sp.product_id = ?;                
                ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function get_or_creatCart($session_id) {
        $sql = "SELECT id FROM Carts WHERE session_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $session_id, PDO::PARAM_STR); 
        $stmt->execute();
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Nếu không tìm thấy giỏ hàng, tạo giỏ hàng mới
        if (!$cart) {
            $sql = "INSERT INTO Carts (session_id) VALUES (?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $session_id, PDO::PARAM_STR);
            $stmt->execute();
            return $this->conn->lastInsertId();  
        }
    
        return $cart['id'];  
    }
    
    public function add_or_UpdateItem($cart_id, $product_id, $quantity, $price) {    
        $sql = "SELECT id, quantity FROM Cart_items WHERE cart_id = ? AND product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $cart_id, PDO::PARAM_INT);  
        $stmt->bindParam(2, $product_id, PDO::PARAM_INT);  
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($item) {
            $new_quantity = $item['quantity'] + $quantity;
            $sql = "UPDATE Cart_items SET quantity = ?, price = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $new_quantity, PDO::PARAM_INT);  
            $stmt->bindParam(2, $price, PDO::PARAM_STR); // Ensure price is passed as a parameter
            $stmt->bindParam(3, $item['id'], PDO::PARAM_INT);  
        } else {
            $sql = "INSERT INTO Cart_items (cart_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $cart_id, PDO::PARAM_INT);  
            $stmt->bindParam(2, $product_id, PDO::PARAM_INT);  
            $stmt->bindParam(3, $quantity, PDO::PARAM_INT);  
            $stmt->bindParam(4, $price, PDO::PARAM_STR); // Ensure price is passed as a parameter
        }
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
    public function getCartItems($userId = null, $sessionId = null) {
        $sql = "SELECT 
                    ci.id AS cart_item_id,
                    p.product_name,
                    pv.color,
                    pv.ram,
                    pv.storage,
                    ci.quantity,
                    ci.price,
                    vi.img
                FROM 
                    carts c
                JOIN 
                    cart_items ci ON c.id = ci.cart_id
                JOIN 
                    product_variants pv ON ci.product_id = pv.id
                JOIN 
                    products p ON pv.product_id = p.id
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
    
    
}