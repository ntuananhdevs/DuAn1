<?php
class Discounts
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy danh sách sản phẩm với ID và tên sản phẩm
    public function getProductListForDiscounts()
    {
        try {
            $sql = "SELECT 
                        p.id AS product_id,
                        p.product_name AS product_name
                    FROM 
                        Products p
                    ORDER BY 
                        p.product_name";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "SQL Error: " . $e->getMessage();
        }
    }

    // Thêm giảm giá
    public function addDiscount($product_id, $discount_type, $discount_value, $start_date, $end_date)
    {
        try {
            $sql = "INSERT INTO Discounts (product_id, discount_type, discount_value, start_date, end_date) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$product_id, $discount_type, $discount_value, $start_date, $end_date]);
        } catch (PDOException $e) {
            echo "SQL Error: " . $e->getMessage();
        }
    }

    // Sửa giảm giá
    public function updateDiscount($id, $discount_type, $discount_value, $start_date, $end_date)
    {
        try {
            $sql = "UPDATE Discounts SET discount_type = ?, discount_value = ?, start_date = ?, end_date = ? 
                    WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$discount_type, $discount_value, $start_date, $end_date, $id]);
        } catch (PDOException $e) {
            echo "SQL Error: " . $e->getMessage();
        }
    }

    // Xóa giảm giá
    public function deleteDiscount($id)
    {
        try {
            $sql = "DELETE FROM Discounts WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            echo "SQL Error: " . $e->getMessage();
        }
    }
    // Lấy thông tin giảm giá theo ID
public function getDiscountById($id)
{
    try {
        $sql = "SELECT d.id, p.product_name, d.discount_type, d.discount_value, d.start_date, d.end_date 
                FROM Discounts d
                JOIN Products p ON d.product_id = p.id
                WHERE d.id = ?";  // Câu SQL lấy giảm giá theo ID
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);  // Trả về thông tin giảm giá
    } catch (PDOException $e) {
        echo "SQL Error: " . $e->getMessage();
    }
}


    // Lấy danh sách giảm giá
   // Lấy danh sách giảm giá
public function getDiscounts()
{
    try {
        $sql = "SELECT d.id, p.product_name, d.discount_type, d.discount_value, d.start_date, d.end_date 
                FROM Discounts d 
                JOIN Products p ON d.product_id = p.id
                ORDER BY d.start_date DESC";  // Đảm bảo sắp xếp theo ngày bắt đầu
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Trả về tất cả các giảm giá
    } catch (PDOException $e) {
        echo "SQL Error: " . $e->getMessage();
    }
}

}
?>
