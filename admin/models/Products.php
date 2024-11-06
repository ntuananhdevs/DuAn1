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
        $stmt->execute([$_GET['id']]);
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
            // Kiểm tra xem category_id có tồn tại trong bảng Category không
            $checkCategorySql = "SELECT COUNT(*) FROM Category WHERE id = :category_id";
            $stmt = $this->conn->prepare($checkCategorySql);
            $stmt->bindValue(':category_id', $category, PDO::PARAM_INT);
            $stmt->execute();
            $categoryExists = $stmt->fetchColumn();
    
            if ($categoryExists == 0) {
                // Nếu category_id không tồn tại trong bảng Category
                echo "Category ID does not exist!";
                return false;
            }
    
            // Nếu category_id tồn tại, tiếp tục thực hiện cập nhật thông tin sản phẩm
            $sql = "UPDATE Products SET product_name = :product_name, category_id = :category_id, description = :description WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            
            // Gán giá trị cho các tham số
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':product_name', $name, PDO::PARAM_STR);  
            $stmt->bindValue(':category_id', $category, PDO::PARAM_INT);  
            $stmt->bindValue(':description', $description, PDO::PARAM_STR);
            
            // Thực thi câu lệnh SQL và trả về kết quả
            $result = $stmt->execute();
            
            if ($result) {
                return true; // Cập nhật thành công
            } else {
                return false; // Cập nhật thất bại
            }
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    
    
    public function update_spect($productId, $name, $value) {
        try {
            $sql = "UPDATE products_spect SET spects_value = :value WHERE product_id = :productId AND spect_name = :name";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':productId', $productId);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':value', $value);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    
    
}
