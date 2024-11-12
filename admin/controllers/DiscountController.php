<?php
class DiscountController
{
    // Hiển thị danh sách giảm giá
    public function index()
    {
        $discountModel = new Discount();
        $discounts = $discountModel->get_all_discounts();
        include '../admin/views/Discount/index.php';
    }

    // Thêm giảm giá mới
    public function add()
    {
        $productModel = new Products();
        $products = $productModel->get_products();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'product_id' => $_POST['product_id'],
                'discount_type' => $_POST['discount_type'],
                'discount_value' => $_POST['discount_value'],
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'],
                'status' => $_POST['status']
            ];
            $discountModel = new Discount();
            $discountModel->add_discount($data);
            header('Location: index.php?controller=discount&action=index');
        }

        include '../admin/views/Discount/add_discount.php';
    }

    // Sửa giảm giá
    public function edit()
    {
        $id = $_GET['id'];
        $discountModel = new Discount();
        $productModel = new Products();

        $discount = $discountModel->get_discount_by_id($id);
        $products = $productModel->get_products();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'discount_type' => $_POST['discount_type'],
                'discount_value' => $_POST['discount_value'],
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'],
                'status' => $_POST['status']
            ];
            $discountModel->update_discount($id, $data);
            header('Location: index.php?controller=discount&action=index');
        }

        include '../admin/views/Discount/edit_discount.php';
    }

    // Xóa giảm giá
    public function delete()
    {
        $id = $_GET['id'];
        $discountModel = new Discount();
        $discountModel->delete_discount($id);
        header('Location: index.php?controller=discount&action=index');
    }
}
