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

    public function view_order_details() {
        try {
            $order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            if (!$order_id) {
                throw new Exception("ID đơn hàng không hợp lệ");
            }

            $order = $this->OrderModel->getById($order_id);
            $orderDetails = $this->OrderModel->getOrderDetails($order_id);

            include '../admin/views/oder/OrderDetails.php';
        } catch (Exception $e) {
            $_SESSION['error'] = "Lỗi: " . $e->getMessage();
            header('Location: ?act=orders');
            exit;
        }
    }

    public function update_order_item() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception("Phương thức không hợp lệ");
            }

            $item_id = isset($_POST['item_id']) ? (int)$_POST['item_id'] : 0;
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
            $order_id = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;

            if (!$item_id || !$quantity || !$order_id) {
                throw new Exception("Dữ liệu không hợp lệ");
            }

            if ($this->OrderModel->updateOrderItem($item_id, $quantity)) {
                $_SESSION['success'] = "Cập nhật số lượng thành công";
            } else {
                $_SESSION['error'] = "Cập nhật thất bại";
            }

            header("Location: ?act=order_details&id=" . $order_id);
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = "Lỗi: " . $e->getMessage();
            header('Location: ?act=orders');
            exit;
        }
    }

    public function delete_order_item() {
        try {
            $item_id = isset($_GET['item_id']) ? (int)$_GET['item_id'] : 0;
            $order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

            if (!$item_id || !$order_id) {
                throw new Exception("ID không hợp lệ");
            }

            if ($this->OrderModel->deleteOrderItem($item_id)) {
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