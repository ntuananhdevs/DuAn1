<?php 
class PayController{
    
    public $pay;

    public function __construct() {
        $this->pay = new Pay();
    }

    public function view_pay(){
        require_once './clients/views/pay.php';
    }
}