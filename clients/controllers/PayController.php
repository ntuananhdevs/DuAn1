<?php 
class PayController{
    
    public $pay;
    public $mail;

    public function __construct() {
        $this->pay = new Pay();
        $this->mail = new MailService();
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

    public function add_order(){
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $total_amount = $_POST['total'];
        $payment_method = $_POST['payment-method'];

        $user = $this->pay->getUserByEmail($email);

        if(!$user){
            $password = bin2hex(random_bytes(8)); 
            $userId = $this->pay->createTemporaryUser($fullname, $email, $password);
        } else {
            $userId = $user['id'];
        }
        $orderId = $this->pay->createOrder($userId, $fullname, $email, $phone, $address, $total_amount, $payment_method);

        // Lưu thông tin sản phẩm vào đơn hàng
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $sessionId = null; 
        } else {
            $userId = null;
            $sessionId = session_id();
        }
        $cart = new ProductsContronller(new products());
        $cart_item = $cart->getCartItems($userId, $sessionId);
        foreach ($cart_item as $item) {
            $this->pay->createOrderDetail($orderId, $item['variant_id'], $item['quantity'], $item['price']);
        }

        // Xóa gio hang
        $this->pay->delete_cart($userId, $sessionId);
        // Gửi email kích hoạt tài khoản
        if (!$user) {
            $this->mail->sendActivationEmail($email, $password);
        }

        header('Location: ?act=loadbuy');
    }





    public function loadbuy(){
        require_once './clients/views/loadbuy.php';
    }

    public function getDistrictsJson() {
        $provinceCode = $_GET['province_code'] ?? null;
        if ($provinceCode) {
            $districts = $this->pay->getDistrictsByProvince($provinceCode);
            header('Content-Type: application/json');
            echo json_encode($districts);
            exit;
        }
    }

    public function getWardsJson() {
        $districtCode = $_GET['district_code'] ?? null;
        if ($districtCode) {
            $wards = $this->pay->getWardsByDistrict($districtCode);
            header('Content-Type: application/json');
            echo json_encode($wards);
            exit;
        }
    }

}