<?php 
class PayController{
    
    public $pay;

    public function __construct() {
        $this->pay = new Pay();
    }

    public function view_pay(){

        $provinces = $this->pay->get_Provinces();

        // Kiểm tra xem có tỉnh nào được chọn hay không
        $selectedProvince = isset($_POST['province']) ? $_POST['province'] : null;
        $selectedDistrict = isset($_POST['district']) ? $_POST['district'] : null;
        $selectedWard = isset($_POST['ward']) ? $_POST['ward'] : null;

        if ($selectedProvince) {
            // Lấy danh sách huyện theo tỉnh đã chọn
            $districts = $this->pay->getDistrictsByProvince($selectedProvince);
        }

        // Kiểm tra xem có huyện nào được chọn hay không
        $selectedDistrict = $_POST['district'] ?? null;

        if ($selectedDistrict) {
            // Lấy danh sách phường theo huyện đã chọn
            $wards = $this->pay->getWardsByDistrict($selectedDistrict);
        }
        require_once './clients/views/pay.php';
    }
}