<?php
class OrderController {
    private $orderModel;
    
    public function __construct() {
        require_once './clients/models/OrderModel.php';
        $this->orderModel = new OrderModel();
    }

    public function viewOrders() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?act=login');
            exit;
        }
        
        $userId = $_SESSION['user_id'];
        $status = isset($_GET['status']) ? $_GET['status'] : 'all';
        
        $orders = $this->orderModel->getOrdersByUserId($userId, $status);
        
        // Status text mapping
        $statusMapping = [
            'pending' => 'Chờ xác nhận',
            'in_transit' => 'Đang giao',
            'delivered' => 'Đã giao',
            'cancelled' => 'Đã hủy'
        ];

        // Status button style mapping
        $statusButtonStyle = [
            'pending' => 'bg-warning',
            'in_transit' => 'bg-info',
            'delivered' => 'bg-success',
            'cancelled' => 'bg-danger'
        ];
        
        require_once './clients/views/orders/order_list.php';
    }

    public function getOrderDetail($orderId) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?act=login');
            exit;
        }

        $orderDetail = $this->orderModel->getOrderDetail($orderId);
        require_once './clients/views/orders/order_detail.php';
    }
} 