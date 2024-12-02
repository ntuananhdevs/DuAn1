<?php
class OrderController
{
    private $orderModel;

    public function __construct()
    {
        require_once './clients/models/OrderModel.php';
        $this->orderModel = new OrderModel();
    }

    public function viewOrders() {

        $userId = $_SESSION['user_id'];
        $status = isset($_GET['status']) ? $_GET['status'] : 'all';

        $result = $this->orderModel->getOrdersByUserId($userId, $status);
        $orders = $result['orders'];
        $orderCounts = $result['counts'];

        // Status text mapping
        $statusMapping = [
            'pending' => 'Chờ xác nhận',
            'in_transit' => 'Đang giao',
            'delivered' => 'Đã giao',
            'returned' => 'Trả hàng',
            'cancelled' => 'Đã hủy'
        ];

        $statusButtonStyle = [
            'pending' => 'bg-warning',
            'in_transit' => 'bg-info',
            'delivered' => 'bg-success',
            'cancelled' => 'bg-danger',
            'returned' => 'bg-warning'
        ];

        require_once './clients/views/orders/order_list.php';
    }

    public function cancelOrder() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập';
            header('Location: index.php?act=orders');
            return;
        }

        if (!isset($_POST['order_id'])) {
            $_SESSION['error'] = 'Thiếu thông tin đơn hàng';
            header('Location: index.php?act=orders');
            return;
        }

        $orderId = $_POST['order_id'];
        $userId = $_SESSION['user_id'];
        
        $result = $this->orderModel->cancelOrder($orderId, $userId);
        
        if ($result) {
            $_SESSION['success'] = 'Đơn hàng đã được hủy thành công';
        } else {
            $_SESSION['error'] = 'Không thể hủy đơn hàng. Vui lòng thử lại sau';
        }
        
        header('Location: index.php?act=orders');
        exit;
    }
    
}
