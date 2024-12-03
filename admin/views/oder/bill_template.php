<!DOCTYPE html>
<html>
<head>
    <title>Hóa đơn #<?= htmlspecialchars($order['id'] ?? '') ?></title>
    <style>
        body { font-family: Arial, sans-serif; }
        .bill-container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .bill-header { text-align: center; margin-bottom: 30px; }
        .bill-info { margin-bottom: 20px; }
        .bill-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .bill-table th, .bill-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .bill-table th { background-color: #f5f5f5; }
        .bill-footer { margin-top: 30px; text-align: right; }
        .btn { padding: 8px 15px; margin: 5px; border: none; border-radius: 4px; cursor: pointer; }
        .btn-primary { background-color: #007bff; color: white; }
        @media print {
            .no-print { display: none; }
            .bill-container { padding: 0; }
        }
    </style>
</head>
<body>
    <div class="bill-container">
        <div class="bill-header">
            <h2>HÓA ĐƠN THANH TOÁN</h2>
            <p>Mã đơn hàng: #<?= htmlspecialchars($order['id'] ?? '') ?></p>
        </div>

        <div class="bill-info">
            <h2><strong>Thông tin đơn hàng</strong></h2>
            <p><strong>Mã đơn hàng:</strong> <?= htmlspecialchars($order['id'] ?? ''); ?></p>
            <p><strong>Khách hàng:</strong> <?= htmlspecialchars($order['guest_fullname'] ?? 'Chưa có tên'); ?></p>
            <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['shipping_address'] ?? 'Chưa có địa chỉ'); ?></p>
            <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['guest_phone'] ?? 'Chưa có số điện thoại'); ?></p>
            <p><strong>Ngày mua hàng:</strong> <?= htmlspecialchars(date('d/m/Y H:i', strtotime($order['order_date'] ?? ''))); ?></p>
            <p><strong>Ngày thanh toán:</strong> <?= htmlspecialchars(date('d/m/Y H:i', strtotime($order['payment_date'] ?? ''))); ?></p>
            <p><strong>Hình thức thanh toán:</strong> <?= htmlspecialchars($order['payment_method'] ?? 'Chưa xác định'); ?></p>
            <p><strong>Tổng tiền:</strong> <?= htmlspecialchars(number_format($order['total_amount'] ?? 0)) . ' vnđ'; ?></p>
        </div>

        <table class="bill-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Cấu hình</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Giảm giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $grand_total = 0;
                $stt = 1;
                foreach ($order_details as $order):
                    $price = $order['price'] ?? 0;
                    $quantity = $order['quantity'] ?? 0;
                    $discount_value = $order['discount_value'] ?? 0;
                    $discount_type = $order['discount_type'] ?? '';

                    if ($discount_type == 'percentage') {
                        $discount = $price * $discount_value / 100;
                    } else {
                        $discount = $discount_value;
                    }
                    $subtotal = ($price * $quantity) - $discount;
                    $grand_total += $subtotal;
                ?>
                    <tr>
                        <td><?= $stt++ ?></td>
                        <td><?= htmlspecialchars($order['product_name']) ?></td>
                        <td class="text-center">
                            <img src="<?= htmlspecialchars($order['img'] ?? '') ?>" alt="Product Image" style="width:70px;height:auto;">
                        </td>
                        <td>
                            <?php if (!empty($order['color'])): ?>
                               Màu: <?= htmlspecialchars($order['color']) ?><br>
                            <?php endif; ?>
                            <?php if (!empty($order['ram'])): ?>
                               RAM: <?= htmlspecialchars($order['ram']) ?><br>
                            <?php endif; ?>
                            <?php if (!empty($order['storage'])): ?>
                               Bộ nhớ: <?= htmlspecialchars($order['storage']) ?>
                            <?php endif; ?>
                        </td>
                        <td><?= number_format($quantity) ?></td>
                        <td><?= number_format($price) ?>đ</td>
                        <td>
                            <?php if ($discount_type == 'percentage'): ?>
                                <?= $discount_value ?>%
                            <?php else: ?>
                                <?= number_format($discount_value) ?>đ
                            <?php endif; ?>
                        </td>
                        <td><?= number_format($subtotal) ?>đ</td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="7" class="text-right"><strong>Tổng tiền hàng:</strong></td>
                    <td><strong><?= number_format($grand_total) ?>đ</strong></td>
                </tr>
                <tr>
                    <td colspan="7" class="text-right"><strong>VAT (10%):</strong></td>
                    <td><strong><?= number_format($grand_total * 0.1) ?>đ</strong></td>
                </tr>
                <tr>
                    <td colspan="7" class="text-right"><strong>Tổng cộng:</strong></td>
                    <td><strong><?= number_format($grand_total * 1.1) ?>đ</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="bill-footer">
            <p>Ngày xuất hóa đơn: <?= date('d/m/Y H:i') ?></p>
            <p><em>Cảm ơn quý khách đã mua hàng!</em></p>
        </div>

        <div class="text-center no-print">
            <button class="btn btn-primary" onclick="window.print()">In hóa đơn</button>
            <a href="?act=orders" class="btn btn-primary">Quay Lại</a>
        </div>
    </div>
</body>
</html>
