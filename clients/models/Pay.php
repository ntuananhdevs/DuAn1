<?php
class Pay
{

    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function get_Provinces()
    {
        $query = "SELECT code, name FROM provinces";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDistrictsByProvince($provinceCode)
    {
        $query = "SELECT code, name FROM districts WHERE province_code = :province_code";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':province_code', $provinceCode);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWardsByDistrict($districtCode)
    {
        $query = "SELECT code, name FROM wards WHERE district_code = :district_code";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':district_code', $districtCode);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Kiểm tra xem email có tồn tại không
    public function getUserByEmail($email)
    {

        $query = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $query->execute(['email' => $email]);
        return $query->fetch();
    }

    // Tạo tài khoản tạm thời
    public function createTemporaryUser($fullname, $email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = $this->conn->prepare("INSERT INTO users (fullname, email, password, is_temporary) VALUES (:fullname, :email, :password, 1)");
        $query->execute([
            'fullname' => $fullname,
            'email' => $email,
            'password' => $hashedPassword
        ]);
        return $this->conn->lastInsertId();
    }
    // Tạo đơn hàng mới
    public function createOrder($userId, $fullname, $email, $phone, $address, $total_amount, $payment_method) {
        $payment_status = ($payment_method === 'bank_transfer' || $payment_method === 'MOMO') ? 'paid' : 'unpaid';
        $payment_date = ($payment_method === 'bank_transfer' || $payment_method === 'MOMO') ? date('Y-m-d H:i:s') : null;
    
        $query = $this->conn->prepare("INSERT INTO orders 
            (user_id, guest_fullname, guest_email, guest_phone, shipping_address, total_amount, payment_method, payment_status, payment_date) 
            VALUES (:user_id, :fullname, :email, :phone, :address, :total_amount, :payment_method, :payment_status, :payment_date)");
    
        $query->execute([
            'user_id' => $userId,
            'fullname' => $fullname,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'total_amount' => $total_amount,
            'payment_method' => $payment_method,
            'payment_status' => $payment_status,
            'payment_date' => $payment_date
        ]);
    
        return $this->conn->lastInsertId();
    }
    
      // Lưu thông tin sản phẩm vào đơn hàng
      public function createOrderDetail($orderId, $productId, $quantity, $price) {
        $query = $this->conn->prepare("INSERT INTO order_details (order_id, product_variant_id, quantity, subtotal) VALUES (:order_id, :product_variant_id, :quantity, :subtotal)");
        $query->execute([
            'order_id' => $orderId,
            'product_variant_id' => $productId,
            'quantity' => $quantity,
            'subtotal' => $price
        ]);
    }
    public function delete_cart($userId, $sessionId) {
        $sql = "DELETE FROM cart_items WHERE cart_id IN (SELECT id FROM carts WHERE user_id = :user_id OR session_id = :session_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':session_id', $sessionId);
        return $stmt->execute();
    }
    
}
