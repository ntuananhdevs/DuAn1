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
        comments cm ON p.id = cm.product_id  -- Thêm bảng Comments
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

 -- Nhóm theo từng biến thể


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


}