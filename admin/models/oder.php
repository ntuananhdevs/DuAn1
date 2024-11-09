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
            $query = "
                SELECT o.*, u.user_name 
                FROM Orders o
                LEFT JOIN Users u ON o.user_id = u.id 
                WHERE o.id = :id
            ";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$result) {
                return null;
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("Error in getById: " . $e->getMessage());
            return null;
        }
    }

    public function update($id, $data) {
        try {
            $sql = "UPDATE Orders SET 
                user_id = :user_id,
                guest_email = :guest_email,
                guest_phone = :guest_phone,
                payment_status = :payment_status,
                shipping_status = :shipping_status,
                total_amount = :total_amount,
                payment_method = :payment_method,
                shipping_address = :shipping_address,
                updated_at = CURRENT_TIMESTAMP
                WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(':user_id', $data['user_id']);
            $stmt->bindParam(':guest_email', $data['guest_email']);
            $stmt->bindParam(':guest_phone', $data['guest_phone']);
            $stmt->bindParam(':payment_status', $data['payment_status']);
            $stmt->bindParam(':shipping_status', $data['shipping_status']);
            $stmt->bindParam(':total_amount', $data['total_amount']);
            $stmt->bindParam(':payment_method', $data['payment_method']);
            $stmt->bindParam(':shipping_address', $data['shipping_address']);
            $stmt->bindParam(':id', $id);

            $result = $stmt->execute();
            
            if (!$result) {
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
