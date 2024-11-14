
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
                    CASE
    WHEN NOW() < d.start_date THEN 'pending'
    WHEN NOW() BETWEEN d.start_date AND d.end_date THEN 'active'
    WHEN NOW() > d.end_date THEN 'expired'
    ELSE d.status
END AS Status

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

    // Đảm bảo start_date và end_date lưu cả ngày và giờ
    $start_date = $data['start_date']; // Giữ nguyên cả ngày và giờ
    $end_date = $data['end_date'];     // Giữ nguyên cả ngày và giờ

    // Câu lệnh INSERT không cần sử dụng $id, chỉ cần truyền thông tin giảm giá
    $sql = "INSERT INTO discounts (product_id, discount_type, discount_value, start_date, end_date, status) 
        VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $this->conn->prepare($sql);
    
    // Thực thi câu lệnh với các tham số cần thiết
    $stmt->execute([
        $data['product_id'],
        $data['discount_type'],
        $data['discount_value'], 
        $start_date,  
        $end_date,    
        $data['status']
    ]);    
}

public function update_discount($id, $data)
{
    $valid_types = ['percentage', 'fixed'];
    if (!in_array($data['discount_type'], $valid_types)) {
        throw new Exception("Giá trị discount_type không hợp lệ: " . htmlspecialchars($data['discount_type']));
    }

    // Đảm bảo start_date và end_date lưu cả ngày và giờ
    $start_date = $data['start_date']; // Giữ nguyên cả ngày và giờ
    $end_date = $data['end_date'];     // Giữ nguyên cả ngày và giờ

    // Câu lệnh UPDATE thay vì INSERT
    $sql = "UPDATE discounts SET 
                product_id = ?, 
                discount_type = ?, 
                discount_value = ?, 
                start_date = ?, 
                end_date = ?, 
                status = ? 
            WHERE id = ?";  // Chỉ cập nhật bản ghi có ID tương ứng
    $stmt = $this->conn->prepare($sql);

    // Thực thi câu lệnh với các tham số truyền vào
    $stmt->execute([
        $data['product_id'],
        $data['discount_type'],
        $data['discount_value'], 
        $start_date,  
        $end_date,    
        $data['status'],
        $id  // Sửa bản ghi với ID cụ thể
    ]);
}




 public function delete_discount($id)
 {
   
     $sql = "SELECT COUNT(*) FROM discounts WHERE id = ?";
     $stmt = $this->conn->prepare($sql);
     $stmt->execute([$id]);
     if ($stmt->fetchColumn() == 0) {
         throw new Exception("Giảm giá không tồn tại!");
     }
 
     // Tiến hành xóa
     $sql = "DELETE FROM discounts WHERE id = ?";
     $stmt = $this->conn->prepare($sql);
     return $stmt->execute([$id]);
 }

 public function get_products(){
     $sql = "SELECT 
                p.id, 
                p.product_name
            FROM 
                Products p
            LEFT JOIN 
                Discounts d ON p.id = d.product_id
            WHERE 
                d.product_id IS NULL;  
            ";
     $stmt = $this->conn->prepare($sql);
     $stmt->execute();
     return $stmt->fetchAll(PDO::FETCH_ASSOC);

 }
 
}