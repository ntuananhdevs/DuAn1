<?php
class OderController {
    private $OrderModel;
    private $UserModel;

    public function __construct() {
        $this->OrderModel = new OrderModel();
        $this->UserModel = new User();
    }

    public function views_oder() {
        $orders = $this->OrderModel->getAll();
        include '../admin/views/oder/Oder.php';
    }

    public function views_edit() {
        try {
            $id = $_GET['id'];
            if (!$id) {
                $_SESSION['error'] = "Không tìm thấy ID đơn hàng";
                header('Location: ?act=orders');
                exit;
            }

            $orderData = $this->OrderModel->getById($id);
            
            // Debug để kiểm tra dữ liệu
            error_log("Order Data: " . print_r($orderData, true));
            
            if (!$orderData) {
                $_SESSION['error'] = "Không tìm thấy thông tin đơn hàng";
                header('Location: ?act=orders');
                exit;
            }

            $orderData = [
                'id' => $orderData['id'] ?? '',
                'user_id' => $orderData['user_id'] ?? '',
                'guest_email' => $orderData['guest_email'] ?? '',
                'guest_phone' => $orderData['guest_phone'] ?? '',
                'shipping_address' => $orderData['shipping_address'] ?? '',
                'total_amount' => $orderData['total_amount'] ?? 0,
                'payment_method' => $orderData['payment_method'] ?? 'cod',
                'payment_status' => $orderData['payment_status'] ?? 'pending',
                'shipping_status' => $orderData['shipping_status'] ?? 'pending'
            ];

            include '../admin/views/oder/Oderedit.php';
        } catch (Exception $e) {
            $_SESSION['error'] = "Có lỗi xảy ra: " . $e->getMessage();
            header('Location: ?act=oders');
            exit;
        }
    }

    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            if (!$id) {
                header('Location: ?act=orders');
                exit;
            }

            $data = [
                'user_id' => $_POST['user_id'] ?? null,
                'guest_email' => $_POST['guest_email'] ?? '',
                'guest_phone' => $_POST['guest_phone'] ?? '',
                'payment_status' => $_POST['payment_status'] ?? 'pending',
                'shipping_status' => in_array($_POST['shipping_status'], ['pending', 'shipped', 'delivered', 'canceled']) 
                    ? $_POST['shipping_status'] 
                    : 'pending',
                'total_amount' => $_POST['total_amount'] ?? 0,
                'payment_method' => $_POST['payment_method'] ?? '',
                'shipping_address' => $_POST['shipping_address'] ?? ''
            ];

            if ($this->OrderModel->update($id, $data)) {
                $_SESSION['success'] = "Cập nhật đơn hàng thành công";
            } else {
                $_SESSION['error'] = "Cập nhật đơn hàng thất bại";
            }
            header('Location: ?act=orders');
            exit;
        }
    }

    public function delete() {
        $this->OrderModel->delete($_GET['id']);
        header('Location: ?act=orders');
        exit;
    }

    public function print_bill() {
        if (!isset($_GET['id'])) {
            header('Location: ?act=orders');
            exit;
        }

        $order = $this->OrderModel->getById($_GET['id']);
        
        if (!$order || $order['payment_status'] != 'completed' || $order['shipping_status'] != 'delivered') {
            header('Location: ?act=orders');
            exit;
        }

        include '../admin/views/oder/bill_template.php';
    }
}
?>