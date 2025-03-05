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



    // Lấy tổng giá trị đơn hàng đã mua

    public function cancelOrder($orderId, $userId)
    {
        try {
            $query = "UPDATE orders 
                      SET shipping_status = 'cancelled',
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
    public function returnOrder($orderId, $userId, $reason)
    {
        $sql = "INSERT INTO returns (order_id, user_id, reason, created_at) VALUES (?, ?, ?, CURRENT_TIMESTAMP)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$orderId, $reason, $userId,]);
        return $stmt->rowCount() > 0;
    }
    public function updateStatus($orderId, $status)
    {
        $sql = "UPDATE orders SET shipping_status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$status, $orderId]);
        return $stmt->rowCount() > 0;
    }
    public function getOrderDetail($id)
    {
        $query = "SELECT 
                    o.*, 
                    u.user_name, 
                    u.fullname, 
                    u.email, 
                    u.phone_number, 
                    od.quantity, 
                    od.subtotal, 
                    pv.price, 
                    pv.color, 
                    pv.ram, 
                    pv.storage, 
                    p.product_name,
                    r.id AS return_id,
                    r.created_at AS return_date,
                    r.admin_note,
                    r.updated_at AS return_updated_at,
                    r.reason
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
                    Returns r ON r.order_id = o.id  -- Kết nối bảng returns
                WHERE 
                    o.id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($products)) {
            return null; // Không có dữ liệu, trả về null
        }

        return $products; // Trả về dữ liệu
    }
    public function get_order_details($id)
    {
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
    pv.id AS variant_id,
    pv.color, 
    pv.ram, 
    pv.storage, 
    p.product_name,
    vi.img,
    d.discount_type,
    d.discount_value
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
    Variants_img vi ON pv.id = vi.variant_id
LEFT JOIN
    Discounts d ON p.id = d.product_id
WHERE
    o.id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $products;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
