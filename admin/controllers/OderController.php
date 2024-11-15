<?php

class OderController {
    private $OrderModel;
    private $products;

    public function __construct() {
        $this->OrderModel = new OderModel();
        $this-> products = new Products();
    }

    public function views_order() {
        $orders = $this->OrderModel->getAll();
        include '../admin/views/oder/Oder.php'; // Đảm bảo đường dẫn đúng
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
                'shipping_address' => $_POST['shipping_address'],
                'order_date' => date('Y-m-d H:i:s')
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

    public function details($id) {
        try {
            // Lấy chi tiết đơn hàng từ phương thức `get_order_details`
            $order_details = $this->OrderModel->get_order_details($id);
            
            // Lấy thông tin đơn hàng từ phương thức `getById`
            $order = $this->OrderModel->getById($id);
            
            if ($order) {
                $order = $order[0]; // Lấy dòng đầu tiên từ kết quả trả về nếu có
                
                // // Lấy hình ảnh từ phương thức `get_img_by_id`
                // $img_data = $this->OrderModel->get_img_by_id($id);
                
                // // Nếu có hình ảnh, lấy ảnh đầu tiên
                // if ($img_data && count($img_data) > 0) {
                //     $img = $img_data[0]['img'];
                // } else {
                //     $img = null; // Không có ảnh nào, gán `img` là `null`
                // }
            }
    
            require_once '../admin/views/oder/OrderDetails.php';
        } catch (Exception $e) {
            header('Location: ?act=orders');
            exit;
        }
    }
    
    
    
}