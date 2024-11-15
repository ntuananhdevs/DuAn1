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
                    o.id = ?
";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function getOrderWithDetails($orderId)
    {
        try {
            $sql = "SELECT o.*, 
                           od.quantity as order_quantity, 
                           od.subtotal,
                           p.product_name,
                           CONCAT('../uploads/Products/', p.img) as product_img,
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
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($result)) {
                error_log("Không tìm thấy đơn hàng ID: " . $orderId);
                return null;
            }

            $order = [
                'order_info' => [
                    'id' => $result[0]['id'],
                    'user_id' => $result[0]['user_id'],
                    'guest_fullname' => $result[0]['guest_fullname'],
                    'guest_email' => $result[0]['guest_email'],
                    'guest_phone' => $result[0]['guest_phone'],
                    'order_date' => $result[0]['order_date'],
                    'payment_status' => $result[0]['payment_status'],
                    'shipping_status' => $result[0]['shipping_status'],
                    'total_amount' => $result[0]['total_amount'],
                    'payment_method' => $result[0]['payment_method'],
                    'payment_date' => $result[0]['payment_date'],
                    'shipping_address' => $result[0]['shipping_address'],
                    'created_at' => $result[0]['created_at'],
                    'updated_at' => $result[0]['updated_at']
                ],
                'products' => []
            ];

            foreach ($result as $row) {
                $order['products'][] = [
                    'product_name' => $row['product_name'],
                    'product_img' => $row['product_img'],
                    'variant_img' => [
                        'id' => $row['variant_img_id'],
                        'img' => $row['variant_img'],
                        'is_default' => $row['is_default']
                    ],
                    'color' => $row['color'],
                    'ram' => $row['ram'],
                    'storage' => $row['storage'],
                    'quantity' => $row['order_quantity'],
                    'price' => $row['variant_price'],
                    'subtotal' => $row['subtotal']
                ];
            }

            // Debug log
            error_log("Order details retrieved successfully for ID: " . $orderId);

            return $order;
        } catch (PDOException $e) {
            error_log("Database Error in getOrderWithDetails: " . $e->getMessage());
            return null;
        } catch (Exception $e) {
            error_log("General Error in getOrderWithDetails: " . $e->getMessage());
            return null;
        }
    }
}
