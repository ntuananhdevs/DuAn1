<?php
class OrderModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getAll() {
        
            $stmt = $this->conn->prepare("
                SELECT o.*, u.user_name 
                FROM Orders o
                LEFT JOIN Users u ON o.user_id = u.id
                ORDER BY o.created_at DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id) {
        try {

            error_log("Getting order ID: " . $id);

            $query = "
                SELECT o.*, u.user_name 
                FROM Orders o
                LEFT JOIN Users u ON o.user_id = u.id 
                WHERE o.id = :id
            ";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            $order = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$order) {
                error_log("Order not found for ID: " . $id);
                return null;
            }


            error_log("Order found: " . print_r($order, true));

            // Lấy chi tiết đơn hàng
            $detailQuery = "
                SELECT od.*, pv.sku, pv.price, p.name as product_name, pv.color, pv.size
                FROM order_details od
                JOIN product_variants pv ON od.product_variant_id = pv.id
                JOIN products p ON pv.product_id = p.id
                WHERE od.order_id = :order_id
            ";
            $detailStmt = $this->conn->prepare($detailQuery);
            $detailStmt->bindParam(':order_id', $id);
            $detailStmt->execute();
            $orderDetails = $detailStmt->fetchAll(PDO::FETCH_ASSOC);

            $order['details'] = $orderDetails;


            error_log("Order details: " . print_r($orderDetails, true));
            
            return $order;
        } catch (Exception $e) {
            error_log("Error in getById: " . $e->getMessage());
            return null;
        }
    }

    public function update($id, $data) {
        try {
            $sql = "UPDATE Orders SET 
                user_id = ?,
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
            
            $stmt->execute([
                $data['user_id'],
                $data['guest_email'],
                $data['guest_phone'],
                $data['payment_status'],
                $data['shipping_status'],
                $data['total_amount'],
                $data['payment_method'],
                $data['shipping_address'],
                $id
            ]);
            
            if (!$stmt->rowCount()) {
                header('Location: ?act=orders');
                return false;
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Error in update: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM Orders WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }
}
