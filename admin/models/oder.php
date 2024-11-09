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
                ORDER BY o.created_at DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("
            SELECT o.*, u.user_name 
            FROM Orders o
            LEFT JOIN Users u ON o.user_id = u.id 
            WHERE o.id = :id
        ");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add_oder($data) {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO Orders (user_id, guest_fullname, guest_email, guest_phone, 
                payment_status, shipping_status, total_amount, payment_method, shipping_address)
                VALUES (:user_id, :guest_fullname, :guest_email, :guest_phone,
                :payment_status, :shipping_status, :total_amount, :payment_method, :shipping_address)
            ");
            return $stmt->execute($data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function update($id, $data) {
        try {
            $sql = "UPDATE Orders SET 
                user_id = :user_id,
                guest_fullname = :guest_fullname,
                guest_email = :guest_email,
                guest_phone = :guest_phone,
                order_date = :order_date,
                payment_status = :payment_status,
                shipping_status = :shipping_status,
                total_amount = :total_amount,
                payment_method = :payment_method,
                payment_date = :payment_date,
                shipping_address = :shipping_address,
                updated_at = CURRENT_TIMESTAMP
                WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            $params = [
                ':id' => $id,
                ':user_id' => $data['user_id'],
                ':guest_fullname' => $data['guest_fullname'],
                ':guest_email' => $data['guest_email'],
                ':guest_phone' => $data['guest_phone'],
                ':order_date' => $data['order_date'],
                ':payment_status' => $data['payment_status'],
                ':shipping_status' => $data['shipping_status'],
                ':total_amount' => $data['total_amount'],
                ':payment_method' => $data['payment_method'],
                ':payment_date' => $data['payment_date'],
                ':shipping_address' => $data['shipping_address']
            ];

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            return $stmt->execute();
        } catch (Exception $e) {
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
