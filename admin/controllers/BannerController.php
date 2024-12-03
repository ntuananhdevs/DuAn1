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
        $search = $_GET['search'] ?? ''; 
    
       
        if ($search) {
            $banners = $this->bannerModel->getBannerBySearch($search); 
        } else {
            $banners = $this->bannerModel->getBanner(); 
        }
    
        // Bao gồm file view để hiển thị danh sách banner
        require_once '../admin/views/Banner/banner.php'; // Đảm bảo đường dẫn đến view đúng
    }
        public function views_add()
    {
        include './views/Banner/add_banner.php';
    }
    public function views_edit($id)
    {
        $banner = $this->bannerModel->getBannerById($id);
        include './views/Banner/edit_banner.php';
    }
 
    public function addBanner()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $position = $_POST['position'] ?? 'homepage';
            $start_date = $_POST['start_date'] ?? date('Y-m-d H:i:s');
            $end_date = $_POST['end_date'] ?? ''; 
            $status = $_POST['status'] ?? 'active';
    
           
            $img_url = $_FILES['img_url'] ?? null;
    
          
            if (empty($title)) {
                echo "Lỗi: Tiêu đề không được để trống.";
                return;
            }
    
           
            if ($img_url && $img_url['error'] === UPLOAD_ERR_OK) {
             
                $uploadedFile = uploadFile2($img_url, '../uploads/BannerIMG/');
                if (!$uploadedFile) {
                    echo "Lỗi tải lên tệp ảnh.";
                    return;
                }
            } else {
               
                $uploadedFile = 'default_image.jpg';
            }
    
          
            if ($this->bannerModel->create($title, $description, $uploadedFile, $position, $start_date, $end_date, $status)) {
                header('Location: ?act=banner');
                exit; 
                echo "Không thể tạo banner mới.";
            }
        }
    }

    public function editBanner($id) {
       
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          
            $existingBanner = $this->bannerModel->getBannerById($id);
            if (!$existingBanner) {
                $_SESSION['error'] = "Banner không tồn tại.";
                header('Location: ?act=banner');
                exit;
            }
    
          
            $title = $_POST['title'] ?? $existingBanner['title'];
            $description = $_POST['description'] ?? $existingBanner['description'];
            $position = $_POST['position'] ?? $existingBanner['position'];
            $start_date = $_POST['start_date'] ?? $existingBanner['start_date'];
            $end_date = $_POST['end_date'] ?? $existingBanner['end_date'];
            $status = $_POST['status'] ?? $existingBanner['status'];
            $img = $_FILES['img_url'] ?? null;
    
     
            $img_url = $existingBanner['img_url'];
            if ($img && $img['error'] === 0) {
                $img_url = uploadFile2($img, '../uploads/BannerIMG/');
            }
    
  
            $data = [
                'title' => $title,
                'description' => $description,
                'img_url' => $img_url,
                'position' => $position,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'status' => $status,
            ];
    
    
            if ($this->bannerModel-> update($id, $title, $description, $img_url, $position, $start_date, $end_date, $status)) {
                $_SESSION['success'] = "Cập nhật banner thành công!";
                header('Location: ?act=banner');
                exit;
            } else {
                $_SESSION['error'] = "Cập nhật banner thất bại.";
            }
        } else {
 
            $banner = $this->bannerModel->getBannerById($id);
            if (!$banner) {
                $_SESSION['error'] = "Banner không tồn tại.";
                header('Location: ?act=banner');
                exit;
            }
            return $banner;
        }
    }
    
    
   
   
    public function deleteBanner()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->bannerModel->delete($id);
            header('Location: index.php?act=banner');
            exit; 
        }
    }
}