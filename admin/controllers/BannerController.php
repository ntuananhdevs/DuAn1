<?php

class BannerController
{
    public $bannerModel;
    public function __construct()
    {
        $this->bannerModel = new Banner();
    }

    public function views_Banner()
    {
        $banners = $this->bannerModel->getBanner();
        include './views/Banner/banner.php';
    }
    public function views_add()
    {
        include './views/Banner/add_banner.php';
    }
    public function addBanner()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Thu thập dữ liệu từ form với giá trị mặc định
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $position = $_POST['position'] ?? 'homepage';
            $start_date = $_POST['start_date'] ?? date('Y-m-d H:i:s');
            $end_date = $_POST['end_date'] ?? ''; // Nếu end_date không có, hãy gán một giá trị mặc định
            $status = $_POST['status'] ?? 'active';
    
            // Kiểm tra tệp tải lên
            $img_url = $_FILES['img_url'] ?? null;
    
            // Kiểm tra xem title có rỗng không
            if (empty($title)) {
                echo "Lỗi: Tiêu đề không được để trống.";
                return;
            }
    
            // Nếu không có tệp ảnh, gán giá trị mặc định cho img_url
            if ($img_url && $img_url['error'] === UPLOAD_ERR_OK) {
                // Nếu có tệp tải lên, gọi hàm uploadFile
                $uploadedFile = uploadFile2($img_url, '../uploads/BannerIMG/');
                if (!$uploadedFile) {
                    echo "Lỗi tải lên tệp ảnh.";
                    return;
                }
            } else {
                // Nếu không có tệp ảnh, sử dụng một giá trị mặc định (ví dụ: một hình ảnh mặc định)
                $uploadedFile = 'default_image.jpg';
            }
    
            // Gọi phương thức create() và truyền các tham số vào
            if ($this->bannerModel->create($title, $description, $uploadedFile, $position, $start_date, $end_date, $status)) {
                header('Location: index.php?act=banner');
                exit; // Sau khi chuyển hướng, dừng script lại
            } else {
                echo "Không thể tạo banner mới.";
            }
        }
    }
    public function deleteBanner()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->bannerModel->delete($id);
            header('Location: index.php?act=banner');
            exit; // Sau khi chuyển hướng, dừng script lại
        }
    }
}
