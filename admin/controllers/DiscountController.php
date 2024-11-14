<?php
class DiscountController
{
    public function index()
    {
        $discountModel = new Discount();
        $discounts = $discountModel->get_all_discounts();
        include '../admin/views/Discount/discount.php';
    }

    public function add()
    {
        $productModel = new Products();
        $products = $productModel->get_products();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Kiểm tra sự tồn tại của discount_value
            $discount_value = isset($_POST['discount_value']) && !empty($_POST['discount_value']) ? $_POST['discount_value'] : 0; // Nếu không có, gán giá trị mặc định 0
    
            // Xử lý discount_type
            $discount_type = $_POST['discount_type'] == 'percentage' ? 'percentage' : 'fixed';
    
            // Chuẩn bị dữ liệu gửi đi
            $data = [
                'product_id' => $_POST['product_id'],
                'discount_type' => $discount_type, // Chỉ nhận 'percentage' hoặc 'fixed'
                'discount_value' => $discount_value, // Nếu không có giá trị, gán mặc định là 0
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'],
                'status' => $_POST['status'],
            ];
    
            // Tạo đối tượng Discount và gọi phương thức add_discount
            $discountModel = new Discount();
            try {
                $discountModel->add_discount($data);
                header('Location:?act=discount');
            } catch (Exception $e) {
                echo "Lỗi: " . $e->getMessage();
            }
        }
    
        include '../admin/views/Discount/add_discount.php';
    }
    
    public function edit()
    {
        if (!isset($_GET['id'])) {
            header('Location: ?act=discount');
            exit;
        }
    
        $id = $_GET['id'];
        $discountModel = new Discount();
        $productModel = new Products();
    
        // Lấy thông tin giảm giá
        $discount = $discountModel->get_discount_by_id($id);
        $products = $productModel->get_products();
    
        // Kiểm tra nếu có dữ liệu gửi qua form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            var_dump($_POST); // Kiểm tra xem dữ liệu có được gửi lên không
    
            $data = [
                'discount_type' => $_POST['discount_type'],
                'discount_value' => $_POST['discount_value'],
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'],
                'status' => $_POST['status'] // Trạng thái
            ];
    
            // Cập nhật dữ liệu giảm giá
            if ($discountModel->update_discount($id, $data)) {
                // Nếu cập nhật thành công, điều hướng lại trang
                header('Location: ?act=discount');
                exit;
            } else {
                // Nếu không thành công, thông báo lỗi
                echo "Cập nhật không thành công.";
            }
        }
    
        include '../admin/views/Discount/edit_discount.php';
    }
    
public function delete()
    {
        $id = $_GET['id'];
        $discountModel = new Discount();
        $discountModel->delete_discount($id);
        header('Location: ?act=discount');
    }
}