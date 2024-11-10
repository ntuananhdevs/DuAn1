<?php

class BannerController {
    public $bannerModel;
    public function __construct() {
        $this->bannerModel = new Banner();
}

public function getBanner() {
    $banners = $this->bannerModel->getBanner();
    include './views/Banner/banner.php';
}
}
?> 