<?php

class BannerController {
    public $bannerModel;
    public function __construct() {
        $this->bannerModel = new Banner();
}

public function getBanner() {
    $banner = $this->bannerModel->getBanner();
    require_once './views/Banner/banner.php';
}
}
?> 