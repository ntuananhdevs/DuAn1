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
            // Collect form data with default values
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $position = $_POST['position'] ?? 'homepage';
            $start_date = $_POST['start_date'] ?? date('Y-m-d H:i:s');
            $end_date = $_POST['end_date'];
            $status = $_POST['status'] ?? 'active';
            $img = $_FILES['img_url'];

            if ($this->bannerModel->create($title, $description, uploadFile($img, '../uploads/BannerIMG/'), $position, $start_date, $end_date, $status)) {
                header('Location: index.php?act=banner');

                // Default image if no file is uploaded
            }
        }
    }
}
