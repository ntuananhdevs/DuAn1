<?php 
class Home {
    public $conn;
    public function __construct() { 
        $this->conn = connectDB();
    }
    public function getBanner() {
        $sql = "SELECT * FROM banners WHERE status = 'active'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function get_products()
    {
        try {
            $sql = "SELECT 
                        p.id AS id,
                        p.product_name AS product_name,
                        p.description AS description,                   
                        COALESCE(MIN(vi.img), '') AS img,            
                        c.category_name AS category_name,
                        COUNT(DISTINCT pv.color) AS Total_color,      
                        p.quantity AS quantity,
                        p.views AS views,
                        p.rating AS rating,
                        MIN(pv.price) AS Lowest_Price,                
                        MAX(pv.price) AS Highest_Price,
                        d.discount_type AS discount_type,          -- Thêm cột discount_type
                        d.discount_value AS discount_value,        -- Thêm cột discount_value
                        d.status AS discount_status                -- Thêm cột status của bảng Discounts
                    FROM 
                        Products p
                    JOIN 
                        Category c ON p.category_id = c.id
                    LEFT JOIN 
                        Product_variants pv ON p.id = pv.product_id  
                    LEFT JOIN 
                        Variants_img vi ON pv.id = vi.variant_id AND vi.is_default = 0 
                    LEFT JOIN 
                        Discounts d ON p.id = d.product_id
                    GROUP BY 
                        p.id, p.product_name, p.description, c.category_name, p.quantity, p.views, 
                        d.discount_type, d.discount_value, d.status;
                        ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $products;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
