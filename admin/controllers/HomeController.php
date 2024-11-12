<?php
class HomeController {
    public $home;

    public function __construct() {
        $this->home = new Home();
    }

// Controller: HomeController.php
public function views_home() {
    $data = $this->home->getCategoryProductCounts();

    // Chuyển đổi dữ liệu thành JSON để truyền vào biểu đồ
    $chartData = json_encode($data, JSON_HEX_TAG); 
    $total_money = $this->home->total_order();
    $list_product = $this->home->total_prd();
    $list_user = $this->home->total_users();

    require_once './views/home.php';
    require_once './views/layout/footer.php';
}


}