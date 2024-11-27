<?php
class OrderController {
    private $order;

    public function __construct() {
        $this->order = new OrderModel();
    }

    public function viewOrders() {
        // $orders = $this->order->getOrders();
        include './clients/views/order.php';
    }
}

?>