<?php
require_once 'models/Discounts.php';

class DiscountController
{
    private $discountModel;

    public function __construct()
    {
        $this->discountModel = new Discounts();
    }

    // Hiển thị danh sách giảm giá
    public function viewDiscounts()
    {
        // Lấy danh sách giảm giá từ cơ sở dữ liệu
        $discounts = $this->discountModel->getDiscounts();

        // Chuyển dữ liệu vào view
        include __DIR__ . '/../views/Discounts/discount.php';  // Sử dụng __DIR__ để xác định đường dẫn chính xác từ file hiện tại
    }

    // Thêm giảm giá mới
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'];
            $discount_type = $_POST['discount_type'];
            $discount_value = $_POST['discount_value'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];

            // Thêm giảm giá vào cơ sở dữ liệu
            $this->discountModel->addDiscount($product_id, $discount_type, $discount_value, $start_date, $end_date);
            header('Location: /discount');
        } else {
            // Lấy danh sách sản phẩm cho giảm giá
            $products = $this->discountModel->getProductListForDiscounts();
            require '/../views/Discounts/add_discount.php';  // Gọi view thêm giảm giá
        }
    }

    // Sửa giảm giá
    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $discount_type = $_POST['discount_type'];
            $discount_value = $_POST['discount_value'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];

            // Cập nhật giảm giá
            $this->discountModel->updateDiscount($id, $discount_type, $discount_value, $start_date, $end_date);
            header('Location: /discount');
        } else {
            // Lấy thông tin giảm giá hiện tại để sửa
            $discount = $this->discountModel->getDiscountById($id);
            require '/../views/Discounts/edit_discount.php';  // Gọi view sửa giảm giá
        }
    }

    // Xóa giảm giá
    public function delete($id)
    {
        $this->discountModel->deleteDiscount($id);
        header('Location: /discount');
    }
}

?>
