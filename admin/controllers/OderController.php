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
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            if ($this->OrderModel->delete($id)) {
                $_SESSION['success'] = "Xóa đơn hàng thành công";
            } else {
                $_SESSION['error'] = "Xóa đơn hàng thất bại";
            }
        } else {
            $_SESSION['error'] = "ID không hợp lệ";
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

    public function view_details() {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception("Không tìm thấy ID đơn hàng");
            }

            $orderId = (int)$_GET['id'];
            $order = $this->OrderModel->getOrderWithDetails($orderId);
            
            if (!$order) {
                throw new Exception("Không tìm thấy thông tin đơn hàng");
            }

            include '../admin/views/oder/OrderDetails.php';
        } catch (Exception $e) {
            $_SESSION['error'] = "Lỗi: " . $e->getMessage();
            header('Location: ?act=orders');
            exit;
        }
    }

    public function views_edit_details() {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception("Không tìm thấy ID đơn hàng");
            }

            $orderId = (int)$_GET['id'];
            $order = $this->OrderModel->getOrderWithDetails($orderId);
            
            if (!$order) {
                throw new Exception("Không tìm thấy thông tin đơn hàng");
            }

            include '../admin/views/oder/Orderdetailsedit.php';
        } catch (Exception $e) {
            $_SESSION['error'] = "Lỗi: " . $e->getMessage();
            header('Location: ?act=orders');
            exit;
        }
    }

    // public function update_details() {
    //     try {
    //         if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    //             throw new Exception("Phương thức không hợp lệ");
    //         }

    //         $orderId = (int)$_POST['order_id'];
    //         $details = [
    //             'total_amount' => 0,
    //             'products' => []
    //         ];

    //         foreach ($_POST['products'] as $product) {
    //             if (!empty($product['variant_id']) && !empty($product['quantity'])) {
    //                 $quantity = (int)$product['quantity'];
    //                 $price = (float)$product['price'];
    //                 $subtotal = $quantity * $price;

    //                 $details['products'][] = [
    //                     'variant_id' => $product['variant_id'],
    //                     'quantity' => $quantity,
    //                     'price' => $price,
    //                     'color' => $product['color'],
    //                     'ram' => $product['ram'],
    //                     'storage' => $product['storage']
    //                 ];

    //                 $details['total_amount'] += $subtotal;
    //             } else {
    //                 error_log("Missing variant_id or quantity for product: " . print_r($product, true));
    //             }
    //         }

    //         // var_dump($details);
    //         // exit;

    //         if ($this->OrderModel->updateOrderDetails($orderId, $details)) {
    //             $_SESSION['success'] = "Cập nhật chi tiết đơn hàng thành công";
    //         } else {
    //             $_SESSION['error'] = "Cập nhật chi tiết đơn hàng thất bại";
    //         }

    //         header('Location: ?act=order_details&id=' . $orderId);
    //         exit;
    //     } catch (Exception $e) {
    //         $_SESSION['error'] = "Lỗi: " . $e->getMessage();
    //         header('Location: ?act=orders');
    //         exit;
    //     }
    // }

}
?>