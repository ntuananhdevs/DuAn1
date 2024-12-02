<?php

class OderController {
    private $OrderModel;
    private $products;

    public function __construct() {
        $this->OrderModel = new OderModel();
        $this-> products = new Products();
    }

    public function views_order() {
        $search = $_GET['search'] ?? ''; // Lấy giá trị tìm kiếm từ URL
        if ($search) {
            $orders = $this->OrderModel->getBySearch($search); // Gọi phương thức tìm kiếm
        } else {
            $orders = $this->OrderModel->getAll(); // Lấy tất cả đơn hàng nếu không có tìm kiếm
        }
        require_once '../admin/views/oder/Oder.php'; // Đảm bảo đường dẫn đúng
    }
    public function print_bill() {
            if (!isset($_GET['id'])) {
                $_SESSION['error'] = "Không tìm thấy ID đơn hàng";
                header('Location: ?act=orders');
                exit;
            }

            $id = $_GET['id'];
            $order = $this->OrderModel->getById($id);
            
            if (!$order || !isset($order[0])) {
                $_SESSION['error'] = "Không tìm thấy thông tin đơn hàng";
                header('Location: ?act=orders');
                exit;
            }

            $order = $order[0];
            $order['guest_fullname'] = $order['guest_fullname'] ?? $order['fullname'] ?? 'Chưa có tên';
            $order['guest_email'] = $order['guest_email'] ?? $order['email'] ?? 'Chưa có email';
            $order['guest_phone'] = $order['guest_phone'] ?? $order['phone_number'] ?? 'Chưa có số điện thoại';
            $order['shipping_address'] = $order['shipping_address'] ?? 'Chưa có địa chỉ';
            $order['payment_method'] = $order['payment_method'] ?? 'Chưa xác định';
            $order['total_amount'] = $order['total_amount'] ?? 0;

            // $productDetails = $this->OrderModel->getProductDetails($id);
            // $order['products'] = $productDetails;

            require_once '../admin/views/oder/bill_template.php';
            
        
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
            if (!$orderData || !isset($orderData[0])) {
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
                $order = $order[0]; 
            }
    
            require_once '../admin/views/oder/OrderDetails.php';
        } catch (Exception $e) {
            header('Location: ?act=orders');
            exit;
        }
    }
    
    public function view_details() {
        try {
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            if (!$id) {
                $_SESSION['error'] = "ID không hợp lệ";
                header('Location: ?act=orders');
                exit;
            }

            $orderData = $this->OrderModel->getById($id);
            if (!$orderData || !isset($orderData[0])) {
                $_SESSION['error'] = "Không tìm thấy đơn hàng";
                header('Location: ?act=orders');
                exit;
            }

            // Ghi log ID đơn hàng
            error_log("Order ID in view: " . $orderData[0]['id']);

            include '../admin/views/oder/OrderDetails.php';
        } catch (Exception $e) {
            $_SESSION['error'] = "Lỗi: " . $e->getMessage();
            header('Location: ?act=orders');
            exit;
        }
    }
    
    public function delete() {
        try {
            if (!isset($_GET['id'])) {
                $_SESSION['error'] = "Không tìm thấy ID đơn hàng";
                header('Location: ?act=orders');
                exit;
            }

            $id = $_GET['id'];
            if ($this->OrderModel->delete($id)) {
                $_SESSION['success'] = "Xóa đơn hàng thành công";
            } else {
                $_SESSION['error'] = "Xóa đơn hàng thất bại";
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