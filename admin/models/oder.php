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
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (Exception $e) {
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

    public function getOrderDetails($order_id) {
        try {
            $sql = "SELECT od.*, p.name as product_name, v.name as variant_name 
                   FROM order_details od
                   LEFT JOIN products p ON od.product_id = p.id
                   LEFT JOIN product_variants v ON od.variant_id = v.id
                   WHERE od.order_id = ?";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$order_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in getOrderDetails: " . $e->getMessage());
            return [];
        }
    }

    public function updateOrderDetail($detail_id, $quantity) {
        try {
            $sql = "UPDATE order_details SET quantity = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$quantity, $detail_id]);
        } catch (Exception $e) {
            error_log("Error in updateOrderDetail: " . $e->getMessage());
            return false;
        }
    }

    public function updateOrderTotal($order_id) {
        try {
            $sql = "UPDATE orders SET total_amount = (
                    SELECT SUM(price * quantity) 
                    FROM order_details 
                    WHERE order_id = ?
                ) WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$order_id, $order_id]);
        } catch (Exception $e) {
            error_log("Error in updateOrderTotal: " . $e->getMessage());
            return false;
        }
    }

    public function deleteOrderDetail($detail_id) {
        try {
            $sql = "DELETE FROM order_details WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$detail_id]);
        } catch (Exception $e) {
            error_log("Error in deleteOrderDetail: " . $e->getMessage());
            return false;
        }
    }
}