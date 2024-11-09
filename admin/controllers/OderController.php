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
        $users = $this->UserModel->getAll();
        $order = $this->OrderModel->getById($_GET['id']);
        
        if (!$order) {
            header('Location: ?act=oders');
            exit;
        }

        $orderData = [
            'id' => $order['id'],
            'user_id' => $order['user_id'],
            'guest_fullname' => $order['guest_fullname'],
            'guest_email' => $order['guest_email'],
            'guest_phone' => $order['guest_phone'],
            'order_date' => $order['order_date'],
            'payment_status' => $order['payment_status'],
            'shipping_status' => $order['shipping_status'],
            'total_amount' => $order['total_amount'],
            'payment_method' => $order['payment_method'],
            'payment_date' => $order['payment_date'],
            'shipping_address' => $order['shipping_address']
        ];
        
        include '../admin/views/oder/Oderedit.php';
    }

    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $id = isset($_GET['id']) ? $_GET['id'] : null;
                if (!$id) {
                    throw new Exception("ID không hợp lệ");
                }

                $data = [
                    'user_id' => $_POST['user_id'] ?? null,
                    'guest_fullname' => $_POST['guest_fullname'] ?? '',
                    'guest_email' => $_POST['guest_email'] ?? '',
                    'guest_phone' => $_POST['guest_phone'] ?? '',
                    'order_date' => $_POST['order_date'] ?? null,
                    'payment_status' => $_POST['payment_status'] ?? 'pending',
                    'shipping_status' => $_POST['shipping_status'] ?? 'pending',
                    'total_amount' => $_POST['total_amount'] ?? 0,
                    'payment_method' => $_POST['payment_method'] ?? '',
                    'payment_date' => $_POST['payment_date'] ?? null,
                    'shipping_address' => $_POST['shipping_address'] ?? ''
                ];

                $result = $this->OrderModel->update($id, $data);
                
                if ($result) {
                    header('Location: ?act=oders');
                    exit;
                } else {
                    throw new Exception("Cập nhật thất bại");
                }
            } catch (Exception $e) {
                error_log("Error updating order: " . $e->getMessage());
                header('Location: ?act=oders');
                exit;
            }
        }
        header('Location: ?act=oders');
        exit;
    }

    public function delete() {
        if ($this->OrderModel->delete($_GET['id'])) {
            header('Location: ?act=oders');
            exit;
        }
        header('Location: ?act=oders');
        exit;
    }

    public function print_bill() {
        if (!isset($_GET['id'])) {
            header('Location: ?act=oders');
            exit;
        }

        $order = $this->OrderModel->getById($_GET['id']);
        
        if (!$order || $order['payment_status'] != 'completed' || $order['shipping_status'] != 'delivered') {
            header('Location: ?act=oders');
            exit;
        }

        include '../admin/views/oder/bill_template.php';
    }
}
?>