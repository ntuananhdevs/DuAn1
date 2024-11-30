<?php
class OrderModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Thêm phương thức tạo đơn hàng
    
public function getOrdersByUserId($userId, $status = 'all')
    {
        try {
            // First query to get order counts by status
            $countQuery = "SELECT 
                shipping_status,
                COUNT(*) as count
            FROM Orders 
            WHERE user_id = :user_id
            GROUP BY shipping_status";
            
            $countStmt = $this->conn->prepare($countQuery);
            $countStmt->execute(['user_id' => $userId]);
            $statusCounts = [];
            while ($row = $countStmt->fetch(PDO::FETCH_ASSOC)) {
                $statusCounts[$row['shipping_status']] = $row['count'];
            }

            // Main query for orders
            $query = "SELECT 
                o.id,
                o.order_date,
                o.payment_status,
                o.shipping_status,
                o.total_amount,
                od.quantity, 
                od.subtotal,
                pv.price, 
                pv.id AS variant_id,
                pv.color, 
                pv.storage, 
                p.product_name,
                vi.img
            FROM Orders o
            JOIN Order_details od ON o.id = od.order_id
            JOIN Product_variants pv ON od.product_variant_id = pv.id
            JOIN Products p ON pv.product_id = p.id
            LEFT JOIN variants_img vi ON pv.id = vi.variant_id
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
            
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Reorganize data to group products by order
            $orders = [];
            foreach ($results as $row) {
                $orderId = $row['id'];
                if (!isset($orders[$orderId])) {
                    $orders[$orderId] = [
                        'id' => $row['id'],
                        'order_date' => $row['order_date'],
                        'payment_status' => $row['payment_status'],
                        'shipping_status' => $row['shipping_status'],
                        'total_amount' => $row['total_amount'],
                        'products' => []
                    ];
                }
                
                $orders[$orderId]['products'][] = [
                    'product_name' => $row['product_name'],
                    'color' => $row['color'],
                    'storage' => $row['storage'],
                    'quantity' => $row['quantity'],
                    'img' => $row['img']
                ];
            }

            return [
                'orders' => array_values($orders),
                'counts' => $statusCounts
            ];
        } catch (Exception $e) {
            error_log("Error in getOrdersByUserId: " . $e->getMessage());
            return [
                'orders' => [],
                'counts' => []
            ];
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

    public function get_order_details($id) {
        try {
            $sql = "SELECT 
                        o.*, 
                        u.user_name, 
                        u.fullname, 
                        u.email, 
                        u.phone_number, 
                        od.quantity, 
                        od.subtotal, 
                        pv.price, 
                        pv.id as variant_id,
                        pv.color, 
                        pv.ram, 
                        pv.storage, 
                        p.product_name,
                        vi.img
                    FROM 
                        Orders o
                    JOIN 
                        Users u ON o.user_id = u.id
                    JOIN 
                        Order_details od ON o.id = od.order_id
                    JOIN 
                        Product_variants pv ON od.product_variant_id = pv.id
                    JOIN 
                        Products p ON pv.product_id = p.id
                    LEFT JOIN
                        variants_img vi ON pv.id = vi.variant_id
                    WHERE
                        o.id = ?
                    ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $products;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    
    public function cancelOrder($orderId, $userId) {
        try {
            $query = "UPDATE orders 
                     SET shipping_status = 'returned',
                         updated_at = CURRENT_TIMESTAMP
                     WHERE id = :order_id 
                     AND user_id = :user_id
                     AND shipping_status = 'pending'";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                'order_id' => $orderId,
                'user_id' => $userId
            ]);
            
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Error in cancelOrder: " . $e->getMessage());
            return false;
        }
    }
}
?>