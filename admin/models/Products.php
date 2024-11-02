<?php
class Products
{
    public $conn;

    public function __construct()
    {

        $this->conn = connectDB();
    }

    public function get_products()
    {
        try {
            $sql = "SELECT 
                    p.id AS ID,
                    p.product_name AS Name,
                    p.img AS Image,
                    c.category_name AS Category_name,
                    COUNT(DISTINCT pv.color) AS Total_color,      
                    p.quantity AS Quantity,
                    p.views AS Views,
                    MIN(pv.price) AS Lowest_Price,                
                    MAX(pv.price) AS Highest_Price                
                FROM 
                    Products p
                JOIN 
                    Category c ON p.category_id = c.id
                LEFT JOIN 
                    Product_variants pv ON p.id = pv.product_id  
                GROUP BY 
                    p.id, p.product_name, p.img, c.category_name, p.quantity, p.views;
                ";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $products;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    public function getPrd_Variant($id)
    {
        try {
            $sql = "SELECT 
                        p.id AS product_id,                  
                        p.product_name AS product_name,      
                        pv.id AS variant_id,                 
                        pv.img AS variant_image,             
                        pv.color AS color,                   
                        pv.ram AS ram,                       
                        pv.storage AS storage,               
                        pv.price AS price,                   
                        pv.quantity AS quantity              
                    FROM 
                        Products p
                    JOIN 
                        Product_variants pv ON p.id = pv.product_id
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
}
