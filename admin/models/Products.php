<?php
class Products
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function get_products(){
        try {
            $sql = "SELECT 
                        p.id AS ID,
                        p.product_name AS Name,
                        p.description AS descriptionss,                   
                        COALESCE(MIN(vi.img), '') AS Image,            
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
                    LEFT JOIN 
                        Variants_img vi ON pv.id = vi.variant_id AND vi.is_default = 0 
                    GROUP BY 
                        p.id, p.product_name, p.description, c.category_name, p.quantity, p.views;
                    ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $products;
        } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
        }
    }
    public function getPrd_Variant($id){
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
                        c.category_name AS category_name      -- Thêm cột category_name từ bảng Categories
                    FROM 
                        Products p
                    JOIN 
                        Product_variants pv ON p.id = pv.product_id      
                    LEFT JOIN 
                        Variants_img vi ON pv.id = vi.variant_id AND vi.is_default = 0 
                    LEFT JOIN 
                        Category c ON p.category_id = c.id  -- Thêm join với bảng Categories
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
    public function get_prdbyid($id){
        try{
            $sql = "SELECT * FROM Products WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $products;
        }catch(PDOException $e){
            $e->getMessage();
        }
    }

    public function get_category(){
        try {
            $sql = "SELECT * FROM Category";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $categories;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function addProduct($name, $category, $description)
    {
        try {
            $sql = "INSERT INTO Products (product_name, category_id, description) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            if ($stmt->execute([$name, $category, $description])) {
                return $this->conn->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            echo "Error adding product: " . $e->getMessage();
            return false;
        }
    }

    public function add_variants($products_id, $color, $ram, $storage, $price, $quantity)
    {
        try {
            $sql = "INSERT INTO Product_variants (product_id, color, ram, storage, price, quantity) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            if ($stmt->execute([$products_id, $color, $ram, $storage, $price, $quantity])) {
                return $this->conn->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            echo "Error adding variant: " . $e->getMessage();
            return false;
        }
    }

    public function add_Products_spect($products_id, $name, $value)
    {
        try {
            $sql = "INSERT INTO Products_spect (product_id, spect_name, spects_value) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$products_id, $name, $value]);
        } catch (PDOException $e) {
            echo "Error adding product spec: " . $e->getMessage();
            return false;
        }
    }

    public function saveVariantImage($variantId, $imageFile)
    {
        if (!is_array($imageFile) || !isset($imageFile['tmp_name']) || !isset($imageFile['name'])) {
            throw new InvalidArgumentException("Invalid file input provided to saveVariantImage()");
        }

        $uploadDir = '../uploads/Products/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $imagePath = $uploadDir . uniqid() . '_' . basename($imageFile['name']);
        if (move_uploaded_file($imageFile['tmp_name'], $imagePath)) {
            try {
                $sql = "INSERT INTO Variants_img (variant_id, img) VALUES (:variantId, :img)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':variantId', $variantId);
                $stmt->bindParam(':img', $imagePath);

                if ($stmt->execute()) {
                    return $imagePath;
                } else {
                    unlink($imagePath);
                    return false;
                }
            } catch (PDOException $e) {
                echo "Error saving variant image: " . $e->getMessage();
                return false;
            }
        }
        return false;
    }
    public function get_spect($id){
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
    
    public function deletePrd($id){
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    public function updatePrd($id, $name, $category, $description) {
        try {
            $sql = "UPDATE Products SET product_name = ?, category_id = ?, description = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$name, $category, $description, $id]);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    
    
    public function get_Products_spect($products_id, $specName) {
        $sql = "SELECT * FROM products_spect WHERE product_id = ? AND spect_name = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$products_id, $specName]);
        $result = $stmt->fetch();
    
        return $result;
    }
    public function update_Products_spect($product_id, $specName, $specValue) {
        $sql = "UPDATE products_spect SET spects_value = ? WHERE product_id = ? AND spect_name = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$specValue, $product_id, $specName]);
    }
    
    public function delete_variant($id) {
        $sql = "DELETE FROM Product_variants WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
    public function get_variant($id) {
        $sql = "SELECT Product_variants.*, Variants_img.img, Variants_img.is_default
        FROM Product_variants
        LEFT JOIN Variants_img ON Product_variants.id = Variants_img.variant_id
        WHERE Product_variants.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $variant = $stmt->fetch(PDO::FETCH_ASSOC);
        return $variant;
    }
    
    public function update_variant($variant_id, $color, $ram, $storage, $price, $quantity) {
        $sql = "UPDATE variants SET color = ?, ram = ?, storage = ?, price = ?, quantity = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$color, $ram, $storage, $price, $quantity, $variant_id]);
    }

    public function updateDescription($id, $description) {
        $sql = "UPDATE products SET description = :description WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function updateVariant($variantId, $color, $ram, $storage, $quantity, $price) {

        $sql = "UPDATE Product_variants SET color = :color, ram = :ram, storage = :storage, quantity = :quantity, price = :price WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':color', $color);
        $stmt->bindParam(':ram', $ram);
        $stmt->bindParam(':storage', $storage);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':id', $variantId);
        return $stmt->execute();
    }

    public function updateVariantImage($variantId, $imageFile) {
        $imagePath = '../uploads/Products/' . uniqid() . '_' . basename($imageFile['name']);
        
        if (move_uploaded_file($imageFile['tmp_name'], $imagePath)) {
            // Kiểm tra xem ảnh đã tồn tại cho biến thể này chưa
            $sqlCheck = "SELECT COUNT(*) FROM Variants_img WHERE variant_id = :variant_id";
            $stmtCheck = $this->conn->prepare($sqlCheck);
            $stmtCheck->bindParam(':variant_id', $variantId);
            $stmtCheck->execute();
            $exists = $stmtCheck->fetchColumn();
    
            if ($exists) {
                // Nếu đã có ảnh, cập nhật ảnh mới
                $sql = "UPDATE Variants_img SET img = :imagePath WHERE variant_id = :variant_id";
            } else {
                // Nếu chưa có ảnh, chèn ảnh mới
                $sql = "INSERT INTO Variants_img (variant_id, img) VALUES (:variant_id, :imagePath)";
            }
    
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':imagePath', $imagePath);
            $stmt->bindParam(':variant_id', $variantId);
            
            return $stmt->execute();
        }
    
        return false;
    }
    
    
}