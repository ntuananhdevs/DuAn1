<?php
class OderModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB(); // Kết nối đến cơ sở dữ liệu
    }

    public function getAll()
    {
        try {
            $stmt = $this->conn->prepare("
                SELECT 
                    id, 
                    user_id, 
                    guest_fullname, 
                    guest_email, 
                    guest_phone, 
                    order_date, 
                    payment_status, 
                    shipping_status, 
                    total_amount, 
                    payment_method, 
                    payment_date, 
                    shipping_address, 
                    updated_at 
                FROM orders
                ORDER BY order_date DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in getAll: " . $e->getMessage());
            return [];
        }
    }
    public function getById($id)
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
                    p.product_name
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
                WHERE 
                    o.id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($products)) {
            return null;
        }

        return $products;
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


    public function update($id, $data)
    {
        try {
            $sql = "UPDATE Orders SET 
                user_id = ?,
                guest_fullname = ?,
                guest_email = ?,
                guest_phone = ?,
                payment_status = ?,
                shipping_status = ?,
                total_amount = ?,
                payment_method = ?,
                shipping_address = ?,
                updated_at = CURRENT_TIMESTAMP
                WHERE id = ?";

            $stmt = $this->conn->prepare($sql);

            $values = [
                $data['user_id'],
                $data['guest_fullname'],
                $data['guest_email'],
                $data['guest_phone'],
                $data['payment_status'],
                $data['shipping_status'],
                $data['total_amount'],
                $data['payment_method'],
                $data['shipping_address'],
                $id
            ];

            $result = $stmt->execute($values);

            if (!$result) {
                error_log("Update failed. Error: " . print_r($stmt->errorInfo(), true));
                return false;
            }

            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Error in update: " . $e->getMessage());
            return false;
        }
    }
//     public function getProductDetails($orderId)
// {
//     try {
//         $sql = "SELECT pv.*, p.product_name, MIN(vi.img) as img
//                 FROM order_details od
//                 JOIN product_variants pv ON od.product_variant_id = pv.id
//                 LEFT JOIN products p ON pv.product_id = p.id
//                 LEFT JOIN variants_img vi ON pv.id = vi.variant_id 
//                 WHERE od.order_id = ?
//                 GROUP BY pv.id";
        
//         $stmt = $this->conn->prepare($sql);
//         $stmt->execute([$orderId]);
        
//         $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
//         // Ghi log để kiểm tra
//         error_log("Products for order ID $orderId: " . print_r($products, true));
        
//         return $products ?: []; // Trả về mảng trống nếu không có sản phẩm nào
//     } catch (PDOException $e) {
//         error_log("Database Error: " . $e->getMessage());
//         return []; // Trả về mảng trống khi gặp lỗi
//     }
// }


    public function getOrderWithDetails($orderId)
    {
        try {
            $sql = "SELECT o.*, 
                           od.quantity as order_quantity, 
                           od.subtotal,
                           p.product_name,
                           CONCAT('../uploads/Products/', vi.img) as product_img,
                           pv.color,
                           pv.ram,
                           pv.storage,
                           pv.price as variant_price,
                           vi.id as variant_img_id,
                           vi.img as variant_img,
                           vi.is_default
                    FROM Orders o
                    JOIN order_details od ON o.id = od.order_id
                    JOIN product_variants pv ON od.product_variant_id = pv.id
                    JOIN products p ON pv.product_id = p.id
                    LEFT JOIN variants_img vi ON pv.id = vi.variant_id
                    WHERE o.id = :order_id";
    
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
    
            if (!$stmt->execute()) {
                error_log("Failed to execute query for order ID: $orderId");
                return null;
            }
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($result)) {
                error_log("No order found with ID: " . $orderId);
                return null;
            }
    
            // Get order information
            $orderInfo = $result[0];
            if (empty($orderInfo)) {
                error_log("No order information found for ID: " . $orderId);
                return null;
            }
    
            $order = [
                'order_info' => [
                    'id' => $orderInfo['id'] ?? null,
                    'user_id' => $orderInfo['user_id'] ?? null,
                    'guest_fullname' => $orderInfo['guest_fullname'] ?? null,
                    'guest_email' => $orderInfo['guest_email'] ?? null,
                    'guest_phone' => $orderInfo['guest_phone'] ?? null,
                    'order_date' => $orderInfo['order_date'] ?? null,
                    'payment_status' => $orderInfo['payment_status'] ?? null,
                    'shipping_status' => $orderInfo['shipping_status'] ?? null,
                    'total_amount' => $orderInfo['total_amount'] ?? null,
                    'payment_method' => $orderInfo['payment_method'] ?? null,
                    'payment_date' => $orderInfo['payment_date'] ?? null,
                    'shipping_address' => $orderInfo['shipping_address'] ?? null,
                    'created_at' => $orderInfo['created_at'] ?? null,
                    'updated_at' => $orderInfo['updated_at'] ?? null
                ],
                'products' => []
            ];
    
            foreach ($result as $row) {
                $order['products'][] = [
                    'product_name' => $row['product_name'] ?? 'Không có tên sản phẩm',
                    'product_img' => $row['product_img'] ?? 'Không có hình ảnh',
                    'variant_img' => [
                        'id' => $row['variant_img_id'] ?? null,
                        'img' => $row['variant_img'] ?? null,
                        'is_default' => $row['is_default'] ?? false
                    ],
                    'color' => $row['color'] ?? 'Không có màu',
                    'ram' => $row['ram'] ?? 'Không có RAM',
                    'storage' => $row['storage'] ?? 'Không có dung lượng',
                    'quantity' => $row['order_quantity'] ?? 0,
                    'price' => $row['variant_price'] ?? 0,
                    'subtotal' => $row['subtotal'] ?? 0
                ];
            }
    
            // Log successful retrieval
            error_log("Order details retrieved successfully for ID: " . $orderId);

            return $order;
        } catch (PDOException $e) {
            error_log("Database Error in getOrderWithDetails: " . $e->getMessage());
            return null;
        } catch (Exception $e) {
            error_log("General Error in getOrderWithDetails: " . $e->getMessage());
            return null;
        }
        error_log(print_r($order, true));

    }
    public function getBySearch($search)
    {
        try {
            $stmt = $this->conn->prepare("
                SELECT 
                    id, 
                    user_id, 
                    guest_fullname, 
                    guest_email, 
                    guest_phone, 
                    order_date, 
                    payment_status, 
                    shipping_status, 
                    total_amount, 
                    payment_method, 
                    payment_date, 
                    shipping_address, 
                    updated_at 
                FROM orders
                WHERE id LIKE ? OR guest_fullname LIKE ? OR guest_email LIKE ?
                ORDER BY order_date DESC
            ");
            $searchTerm = "%$search%"; // Thêm ký tự % để tìm kiếm
            $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in getBySearch: " . $e->getMessage());
            return [];
        }
    }
    public function delete($id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT payment_status, shipping_status FROM orders WHERE id = ?");
            $stmt->execute([$id]);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$order) {
                return false;
            }

            if ($order['shipping_status'] === 'cancelled' || ($order['shipping_status'] === 'delivered' && $order['payment_status'] === 'paid')) {

                $stmt = $this->conn->prepare("DELETE FROM order_details WHERE order_id = ?");
                $stmt->execute([$id]);
                $stmt = $this->conn->prepare("DELETE FROM orders WHERE id = ?");
                return $stmt->execute([$id]);
            } else {
                return false;
            }
        } catch (Exception $e) {
            error_log("Error in delete: " . $e->getMessage());
            return false;
        }
    }
}
