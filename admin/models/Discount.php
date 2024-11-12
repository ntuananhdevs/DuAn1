<?php
class Discount
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy tất cả các giảm giá
    public function get_all_discounts()
    {
        $sql = "SELECT 
                    d.id AS DiscountID,
                    p.product_name AS ProductName,
                    d.discount_type AS DiscountType,
                    d.discount_value AS DiscountValue,
                    d.start_date AS StartDate,
                    d.end_date AS EndDate,
                    d.status AS Status
                FROM discounts d
                JOIN products p ON d.product_id = p.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết giảm giá theo id
    public function get_discount_by_id($id)
    {
        $sql = "SELECT * FROM discounts WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm giảm giá mới
    public function add_discount($data)
    {
        $sql = "INSERT INTO discounts (product_id, discount_type, discount_value, start_date, end_date, status) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['product_id'],
            $data['discount_type'],
            $data['discount_value'],
            $data['start_date'],
            $data['end_date'],
            $data['status']
        ]);
    }

    // Cập nhật thông tin giảm giá
    public function update_discount($id, $data)
    {
        $sql = "UPDATE discounts SET 
                    discount_type = ?, 
                    discount_value = ?, 
                    start_date = ?, 
                    end_date = ?, 
                    status = ? 
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['discount_type'],
            $data['discount_value'],
            $data['start_date'],
            $data['end_date'],
            $data['status'],
            $id
        ]);
    }

    // Xóa giảm giá
    public function delete_discount($id)
    {
        $sql = "DELETE FROM discounts WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
