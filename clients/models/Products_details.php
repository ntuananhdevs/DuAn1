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
                        pv.id AS variant_id,                 
                        pv.color AS color,                   
                        pv.ram AS ram,                       
                        pv.storage AS storage,               
                        pv.price AS price,                   
                        pv.quantity AS quantity,             
                        vi.img AS img,                       
                        p.description AS description,        
                        c.category_name AS category_name,    
                        d.discount_type AS discount_type,    -- Thêm cột discount_type
                        d.discount_value AS discount_value,  -- Thêm cột discount_value
                        d.status AS discount_status          -- Thêm cột status của bảng Discounts
                    FROM 
                        Products p
                    JOIN 
                        Product_variants pv ON p.id = pv.product_id      
                    LEFT JOIN 
                        Variants_img vi ON pv.id = vi.variant_id AND vi.is_default = 0 
                    LEFT JOIN 
                        Category c ON p.category_id = c.id  
                    LEFT JOIN 
                        Discounts d ON p.id = d.product_id  -- Thêm JOIN với bảng Discounts qua product_id
                    WHERE   
                        p.id = ?;


      
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
            $sql = "SELECT * FROM Products WHERE id = ?";
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