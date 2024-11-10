<?php
class OderController {
    private $OrderModel;

    public function __construct() {
        $this->OrderModel = new OrderModel();
    }

    public function views_oder() {
        $orders = $this->OrderModel->getAll();
        include '../admin/views/oder/Oder.php';
    }


    public function delete() {
        if ($this->OrderModel->delete($_GET['id'])) {
            $_SESSION['success'] = "Xóa đơn hàng thành công";
        } else {
            $_SESSION['error'] = "Xóa đơn hàng thất bại";
        }
        header('Location: ?act=orders');
        exit;
    }

    public function print_bill() {
        try {
            if (!isset($_GET['id'])) {
                $_SESSION['error'] = "Không tìm thấy ID đơn hàng";
                header('Location: ?act=orders');
                exit;
            }

            $id = $_GET['id'];
            $order = $this->OrderModel->getById($id);
            
            if (!$order) {
                $_SESSION['error'] = "Không tìm thấy thông tin ơn hàng";
                header('Location: ?act=orders');
                exit;
            }

            if (!isset($order['payment_date'])) {
                $order['payment_date'] = date('Y-m-d H:i:s');
            }

            include '../admin/views/oder/bill_template.php';
            
        } catch (Exception $e) {
            error_log("Print Bill Error: " . $e->getMessage());
            $_SESSION['error'] = "Có lỗi xảy ra: " . $e->getMessage();
            header('Location: ?act=orders');
            exit;
        }
    }

    public function views_edit() {
        try {
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            if (!$id) {
                $_SESSION['error'] = "ID không hợp lệ";
                header('Location: ?act=orders');
                exit;
            }

            $orderData = $this->OrderModel->getById($id);
            if (!$orderData) {
                $_SESSION['error'] = "Không tìm thấy đơn hàng";
                header('Location: ?act=orders');
                exit;
            }

            include '../admin/views/oder/Oderedit.php';
        } catch (Exception $e) {
            $_SESSION['error'] = "Lỗi: " . $e->getMessage();
            header('Location: ?act=orders');
            exit;
        }
    }

    public function update() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: ?act=orders');
                exit;
            }

            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            if (!$id) {
                throw new Exception("ID không hợp lệ");
            }

            $data = [
                'user_id' => $_POST['user_id'],
                'guest_fullname' => $_POST['guest_fullname'],
                'guest_email' => $_POST['guest_email'],
                'guest_phone' => $_POST['guest_phone'],
                'payment_status' => $_POST['payment_status'],
                'shipping_status' => $_POST['shipping_status'],
                'total_amount' => $_POST['total_amount'],
                'payment_method' => $_POST['payment_method'],
                'shipping_address' => $_POST['shipping_address']
            ];

            if ($this->OrderModel->update($id, $data)) {
                $_SESSION['success'] = "Cập nhật đơn hàng thành công";
            } else {
                $_SESSION['error'] = "Cập nhật đơn hàng thất bại";
            }

            header('Location: ?act=orders');
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = "Lỗi: " . $e->getMessage();
            header('Location: ?act=orders');
            exit;
        }
    }

    
}
?>