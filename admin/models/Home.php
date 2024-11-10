<?php
class Home
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function total_users()
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM users WHERE role = 'user'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        } catch (exception $e) {
            echo $e->getMessage();
        }
    }
    public function total_prd()
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM products";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $products;
        } catch (exception $e) {
            echo $e->getMessage();
        }
    }

    public function total_order()
    {
        try {
            $sql = "SELECT 
                        SUM(o.total_amount) AS total_completed_orders
                    FROM 
                        Orders o
                    WHERE 
                        o.shipping_status = 'delivered';
                    ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $orders;
        } catch (exception $e) {
            echo $e->getMessage();
        }
    }
}
