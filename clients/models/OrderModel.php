<?php
class OrderModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Thêm phương thức tạo đơn hàng
    public function createOrder($orderData)
    {
        try {
            $this->conn->beginTransaction();

            // 1. Tạo đơn hàng mới
            $sql = "INSERT INTO orders (user_id, guest_fullname, guest_email, guest_phone, 
                                      total_amount, payment_method, shipping_address, 
                                      payment_status, shipping_status) 
                    VALUES (:user_id, :fullname, :email, :phone, 
                           :total_amount, :payment_method, :address, 
                           'unpaid', 'pending')";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':user_id' => $_SESSION['user_id'],
                ':fullname' => $orderData['fullname'],
                ':email' => $orderData['email'],
                ':phone' => $orderData['phone'],
                ':total_amount' => $orderData['total_amount'],
                ':payment_method' => $orderData['payment_method'],
                ':address' => $orderData['address']
            ]);

            $orderId = $this->conn->lastInsertId();

            // 2. Thêm chi tiết đơn hàng
            foreach ($orderData['items'] as $item) {
                $detailSql = "INSERT INTO order_details (order_id, product_variant_id, quantity, price) 
                             VALUES (:order_id, :variant_id, :quantity, :price)";
                $detailStmt = $this->conn->prepare($detailSql);
                $detailStmt->execute([
                    ':order_id' => $orderId,
                    ':variant_id' => $item['variant_id'],
                    ':quantity' => $item['quantity'],
                    ':price' => $item['price']
                ]);
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Error creating order: " . $e->getMessage());
            return false;
        }
    }

    public function getOrdersByUserId($userId, $status = 'all')
    {
        try {
            $query = "SELECT o.*, o.id as order_id
                     FROM orders o 
                     WHERE o.user_id = :user_id";
            
            if ($status !== 'all') {
                $query .= " AND o.shipping_status = :status";
            }
            $query .= " ORDER BY o.order_date DESC";
            
            $stmt = $this->conn->prepare($query);
            $params = ['user_id' => $userId];
            if ($status !== 'all') {
                $params['status'] = $status;
            }
            $stmt->execute($params);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in getOrdersByUserId: " . $e->getMessage());
            return [];
        }
    }

    public function getOrderDetail($orderId)
    {
        try {
            $query = "SELECT o.*, o.id as order_id,
                            p.product_name,
                            pv.price as product_price,
                            pv.color, pv.ram, pv.storage,
                            od.quantity,
                            od.price as order_price,
                            vi.img as product_image,
                            ca.category_name
                     FROM orders o
                     LEFT JOIN order_details od ON o.id = od.order_id
                     LEFT JOIN product_variants pv ON od.product_variant_id = pv.id
                     LEFT JOIN products p ON pv.product_id = p.id
                     LEFT JOIN category ca ON p.category_id = ca.id
                     LEFT JOIN variants_img vi ON pv.id = vi.variant_id AND vi.is_default = 1
                     WHERE o.id = :order_id AND o.user_id = :user_id";

            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                ':order_id' => $orderId,
                ':user_id' => $_SESSION['user_id']
            ]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in getOrderDetail: " . $e->getMessage());
            return [];
        }
    }

    // Cập nhật trạng thái đơn hàng
    public function updateOrderStatus($orderId, $paymentStatus, $shippingStatus)
    {
        $query = "UPDATE orders 
                 SET payment_status = :payment_status, 
                     shipping_status = :shipping_status,
                     updated_at = CURRENT_TIMESTAMP
                 WHERE id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            'payment_status' => $paymentStatus,
            'shipping_status' => $shippingStatus,
            'order_id' => $orderId
        ]);
        return $stmt->rowCount() > 0;
    }

    // Lấy số lượng đơn hàng theo trạng thái
    public function getOrderCountByStatus($userId, $status)
    {
        $query = "SELECT COUNT(*) as count 
                 FROM orders 
                 WHERE user_id = :user_id 
                 AND shipping_status = :status";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            'user_id' => $userId,
            'status' => $status
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    // Lấy tổng giá trị đơn hàng đã mua
    public function getTotalOrderAmount($userId)
    {
        $query = "SELECT SUM(total_amount) as total 
                 FROM orders 
                 WHERE user_id = :user_id 
                 AND payment_status = 'paid'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    }
}
?>