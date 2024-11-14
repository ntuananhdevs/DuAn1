<?php
class OrderModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getAll() {
        try {
            $stmt = $this->conn->prepare("
                SELECT o.*, u.user_name 
                FROM Orders o
                LEFT JOIN Users u ON o.user_id = u.id
                ORDER BY o.created_at ASC
            ");
            $stmt->execute();
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Debug để kiểm tra dữ liệu
            error_log("Orders data: " . print_r($orders, true));
            
            return $orders;
        } catch (Exception $e) {
            error_log("Error in getAll: " . $e->getMessage());
            return [];
        }
    }
    public function getById($id) {
        try {
            // Debug
            error_log("Getting order ID: " . $id);

            $query = "SELECT * FROM Orders WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            $order = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Debug kết quả
            error_log("Query result: " . print_r($order, true));
            
            if (!$order) {
                error_log("No order found with ID: " . $id);
                return null;
            }
            
            return $order;
        } catch (Exception $e) {
            error_log("Error in getById: " . $e->getMessage());
            return null;
        }
    }
    
    public function delete($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM orders WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error in delete: " . $e->getMessage());
            return false;
        }
    }

    public function update($id, $data) {
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
    
    public function getOrderWithDetails($orderId) {
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

    public function updateOrderDetails($orderId, $details) {
        try {
            $this->conn->beginTransaction();
            
            // Cập nhật tổng tiền trong bảng orders
            $orderSql = "UPDATE orders SET 
                total_amount = :total_amount,
                updated_at = CURRENT_TIMESTAMP
                WHERE id = :order_id";
                
            $orderStmt = $this->conn->prepare($orderSql);
            $orderStmt->execute([
                ':total_amount' => $details['total_amount'],
                ':order_id' => $orderId
            ]);

            // Cập nhật chi tiết đơn hàng trong bảng order_details
            foreach ($details['products'] as $product) {
                $detailSql = "UPDATE order_details SET 
                    quantity = :quantity,
                    subtotal = :subtotal
                    WHERE order_id = :order_id 
                    AND product_variant_id = :variant_id";
                    
                $detailStmt = $this->conn->prepare($detailSql);
                
                // Thêm var_dump để kiểm tra dữ liệu
                var_dump($product); // Kiểm tra từng sản phẩm
                exit; // Dừng thực thi để xem kết quả
                
                $detailStmt->execute([
                    ':order_id' => $orderId,
                    ':quantity' => $product['quantity'],
                    ':subtotal' => $product['quantity'] * $product['price'],
                    ':variant_id' => $product['variant_id']
                ]);
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Error in updateOrderDetails: " . $e->getMessage());
            return false;
        }
    }
}   