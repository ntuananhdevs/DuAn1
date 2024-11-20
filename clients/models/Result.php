<?php

class Result {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
        
       
    }


    public function get_result()
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
                        MIN(pv.price) AS Lowest_Price,                
                        MAX(pv.price) AS Highest_Price,
                        d.discount_type AS discount_type,
                        d.discount_value AS discount_value,
                        d.status AS discount_status
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
    
    public function search_products($search)
{
    try {
        // Base SQL query
        $sql = "SELECT 
                    p.id AS id,
                    p.product_name AS product_name,
                    p.description AS description,                   
                    COALESCE(MIN(vi.img), '') AS img,            
                    c.category_name AS category_name,
                    COUNT(DISTINCT pv.color) AS Total_color,      
                    p.quantity AS quantity,
                    p.views AS views,
                    MIN(pv.price) AS Lowest_Price,                
                    MAX(pv.price) AS Highest_Price,
                    d.discount_type AS discount_type,
                    d.discount_value AS discount_value,
                    d.status AS discount_status
                FROM 
                    Products p
                JOIN 
                    Category c ON p.category_id = c.id
                LEFT JOIN 
                    Product_variants pv ON p.id = pv.product_id  
                LEFT JOIN 
                    Variants_img vi ON pv.id = vi.variant_id AND vi.is_default = 0 
                LEFT JOIN 
                    Discounts d ON p.id = d.product_id ";
        
        // Add WHERE clause if search term is provided
        if (!empty($search)) {
            $sql .= "WHERE p.product_name LIKE :search 
                     OR p.description LIKE :search ";
        }

        // Group by clause
        $sql .= "GROUP BY 
                    p.id, p.product_name, p.description, c.category_name, p.quantity, p.views, 
                    d.discount_type, d.discount_value, d.status";

        // Prepare and execute query
        $stmt = $this->conn->prepare($sql);
        
        // Bind search term if provided
        if (!empty($search)) {
            $searchTerm = '%' . $search . '%';
            $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        }
        
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

    
}


?>