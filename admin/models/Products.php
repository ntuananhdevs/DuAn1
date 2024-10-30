<?php
class Products {
    public $conn;

    public function __construct(){

        $this->conn = connectDB();
    }

    public function get_products() {
        try {
            $sql = "SELECT 
                    p.product_id,
                    p.product_name,
                    c.category_name,
                    co.color_name,
                    pv.price AS variant_price,
                    pv.quantity AS variant_stock_quantity,
                    r.ram_size,
                    s.storage_size,
                    GROUP_CONCAT(CONCAT(ps.spec_name, ': ', ps.spec_value) SEPARATOR ', ') AS specifications
                        FROM 
                            products p
                        JOIN 
                            categories c ON p.category_id = c.category_id
                        JOIN 
                            product_variants pv ON p.product_id = pv.product_id
                        JOIN 
                            colors co ON pv.color_id = co.color_id
                        JOIN 
                            rams r ON pv.ram_id = r.ram_id
                        JOIN 
                            storages s ON pv.storage_id = s.storage_id
                        LEFT JOIN 
                            product_specs ps ON p.product_id = ps.product_id
                        GROUP BY 
                            pv.variant_id
                        ORDER BY 
                            p.product_id, pv.variant_id;
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