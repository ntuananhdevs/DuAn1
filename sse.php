<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

require_once './commons/env.php';
require_once './commons/core.php';


function sendOrderStatusUpdate($orderId, $status) {
    echo "data: {\"orderId\": \"$orderId\", \"status\": \"$status\"}\n\n";
    flush();
}

$conn = connectDB();
while (true) {
    $stmt = $conn->prepare("SELECT id, shipping_status FROM Orders WHERE shipping_status IN ('pending', 'in_transit', 'delivered')");
    $stmt->execute();
    
    while ($order = $stmt->fetch(PDO::FETCH_ASSOC)) {
        sendOrderStatusUpdate($order['id'], $order['shipping_status']);
    }

    sleep(1);
}

