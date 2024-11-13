<?php
class Discount
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

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

    public function get_discount_by_id($id)
{
    $sql = "SELECT * FROM discounts WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về kết quả của câu lệnh truy vấn
}

    public function add_discount($data)
    {
        $valid_types = ['percentage', 'fixed'];
        if (!in_array($data['discount_type'], $valid_types)) {
            throw new Exception("Giá trị discount_type không hợp lệ: " . htmlspecialchars($data['discount_type']));
        }
    
        // Lấy ngày (bỏ giờ) từ start_date và end_date
        $start_date = date('Y-m-d', strtotime($data['start_date']));
        $end_date = date('Y-m-d', strtotime($data['end_date']));
    
        $sql = "INSERT INTO discounts (product_id, discount_type, discount_value, start_date, end_date, status) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['product_id'],
            $data['discount_type'],
            $data['discount_value'], // Lưu giá trị giảm
            $start_date,  // Chỉ lưu ngày, bỏ giờ
            $end_date,    // Chỉ lưu ngày, bỏ giờ
            $data['status'],
        ]);
    }
    
    public function update_discount($id, $data)
    {
        // Lấy ngày (bỏ giờ) từ start_date và end_date
        $start_date = date('Y-m-d', strtotime($data['start_date']));
        $end_date = date('Y-m-d', strtotime($data['end_date']));
    
        // Cập nhật discount
        $sql = "UPDATE discounts SET 
                    discount_type = ?, 
                    discount_value = ?, 
                    start_date = ?, 
                    end_date = ?, 
                    status = ? 
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
    
        // Debug: In dữ liệu trước khi thực hiện query
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            var_dump($_POST); // Kiểm tra dữ liệu đã được gửi lên form
            $discountModel->update_discount($id, $_POST);
        }
        $result = $discountModel->update_discount($id, $_POST);
    if ($result) {
        echo "Cập nhật thành công!";
    } else {
        echo "Cập nhật thất bại!";
    }

    
 return $stmt->execute([
            $data['discount_type'],
            $data['discount_value'],
            $start_date,  // Chỉ lưu ngày, bỏ giờ
            $end_date,    // Chỉ lưu ngày, bỏ giờ
            $data['status'],
            $id
        ]);
 }
    

    public function delete_discount($id)
    {
        $sql = "DELETE FROM discounts WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}