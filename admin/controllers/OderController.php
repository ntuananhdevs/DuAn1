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
                $_SESSION['error'] = "Không tìm thấy thông tin đơn hàng";
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

    public function view_order_details() {
        try {
            error_log("Starting view_order_details");
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            error_log("Order ID: " . $id);
            
            if (!$id) {
                throw new Exception("ID không hợp lệ");
            }
            
            $orderDetails = $this->OrderModel->getOrderDetails($id);
            error_log("Order Details Count: " . count($orderDetails));
            
            include '../admin/views/oder/OrderDetails.php';
        } catch (Exception $e) {
            error_log("Error in view_order_details: " . $e->getMessage());
            $_SESSION['error'] = "Lỗi: " . $e->getMessage();
            header('Location: ?act=orders');
            exit;
        }
    }

    public function update_order_details() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: ?act=orders');
                exit;
            }

            $order_id = $_POST['order_id'];
            $quantities = $_POST['quantity'];

            foreach ($quantities as $detail_id => $quantity) {
                $this->OrderModel->updateOrderDetail($detail_id, $quantity);
            }

            // Cập nhật tổng tiền đơn hàng
            $this->OrderModel->updateOrderTotal($order_id);

            $_SESSION['success'] = "Cập nhật chi tiết đơn hàng thành công";
            header("Location: ?act=order_details&id=" . $order_id);
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = "Lỗi: " . $e->getMessage();
            header('Location: ?act=orders');
            exit;
        }
    }

    public function delete_order_detail() {
        try {
            $detail_id = $_GET['id'];
            $order_id = $_GET['order_id'];

            if ($this->OrderModel->deleteOrderDetail($detail_id)) {
                // Cập nhật tổng tiền đơn hàng
                $this->OrderModel->updateOrderTotal($order_id);
                $_SESSION['success'] = "Xóa sản phẩm thành công";
            } else {
                $_SESSION['error'] = "Xóa sản phẩm thất bại";
            }

            header("Location: ?act=order_details&id=" . $order_id);
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = "Lỗi: " . $e->getMessage();
            header('Location: ?act=orders');
            exit;
        }
    }
}
?>