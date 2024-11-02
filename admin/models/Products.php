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
                    vi.img AS variant_image,               -- Lấy hình ảnh từ bảng Variants_img
                    pv.color AS color,                   
                    pv.ram AS ram,                       
                    pv.storage AS storage,                
                    pv.price AS price,                   
                    pv.quantity AS quantity              
                FROM 
                    Products p
                JOIN 
                    Product_variants pv ON p.id = pv.product_id
                LEFT JOIN 
                    Variants_img vi ON pv.id = vi.id AND vi.is_default = 0 -- Kết hợp bảng Variants_img
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

    public function get_category()
    {
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
                // Trả về variant_id mới được tạo để dùng trong saveVariantImage
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
        // Kiểm tra `$imageFile` là mảng và chứa các key cần thiết
        if (!is_array($imageFile) || !isset($imageFile['tmp_name']) || !isset($imageFile['name'])) {
            throw new InvalidArgumentException("Invalid file input provided to saveVariantImage()");
        }

        // Đảm bảo thư mục `../uploads/` tồn tại
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Tạo đường dẫn đích cho file
        $imagePath = $uploadDir . uniqid() . '_' . basename($imageFile['name']);

        // Kiểm tra và di chuyển file
        if (move_uploaded_file($imageFile['tmp_name'], $imagePath)) {
            try {
                // Thêm đường dẫn ảnh vào cơ sở dữ liệu
                $sql = "INSERT INTO Variants_img (variant_id, img) VALUES (:variantId, :img)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':variantId', $variantId);
                $stmt->bindParam(':img', $imagePath);

                if ($stmt->execute()) {
                    return $imagePath; // Trả về đường dẫn ảnh nếu thành công
                } else {
                    // Xóa file nếu lưu cơ sở dữ liệu thất bại
                    unlink($imagePath);
                    return false;
                }
            } catch (PDOException $e) {
                echo "Error saving variant image: " . $e->getMessage();
                return false;
            }
        }

        return false; // Trả về false nếu di chuyển file thất bại
    }
}
