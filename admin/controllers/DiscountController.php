<?php
class DiscountController
{


    public function index()
{
    $discountModel = new Discount();
    
    // Lấy tham số sắp xếp từ URL
    $sortOrder = isset($_GET['sort']) ? $_GET['sort'] : '';
    
    // Xử lý sắp xếp theo ID
    if ($sortOrder == 'id_asc') {
        $discounts = $discountModel->get_all_discounts('ASC');
    } elseif ($sortOrder == 'id_desc') {
        $discounts = $discountModel->get_all_discounts('DESC');
    } else {
        $discounts = $discountModel->get_all_discounts(); // Nếu không có tham số sắp xếp, lấy tất cả
    }

    include '../admin/views/Discount/discount.php'; // Gọi view hiển thị danh sách giảm giá
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
        // Kiểm tra ID của giảm giá trong URL
        if (!isset($_GET['id'])) {
            header('Location: ?act=discount');
            exit;
        }
    
        $id = $_GET['id'];
    
        // Lấy thông tin giảm giá và sản phẩm từ database
        $discountModel = new Discount();
        $productModel = new Products();
        $discount = $discountModel->get_discount_by_id($id);
        $products = $productModel->get_products();
    
        if (!$discount) {
            echo "Giảm giá không tồn tại!";
            exit;
        }
    
        // Nếu là phương thức POST, nghĩa là người dùng đã gửi form chỉnh sửa
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
    
            // Cập nhật dữ liệu giảm giá
            try {
                $discountModel->update_discount($id, $data);
                header('Location:?act=discount');
            } catch (Exception $e) {
                echo "Lỗi: " . $e->getMessage();
            }
        }
    
        include '../admin/views/Discount/edit_discount.php'; // Gọi view sửa giảm giá
    }
    
    
    
public function delete()
    {
        $id = $_GET['id'];
        $discountModel = new Discount();
        $discountModel->delete_discount($id);
        header('Location: ?act=discount');
    }
}