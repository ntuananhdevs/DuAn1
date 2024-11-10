<!DOCTYPE html>
<html>
<head>
    <title>Hóa đơn #<?= $order['id'] ?></title>
    <style>
        body { font-family: Arial, sans-serif; }
        .bill-container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .bill-header { text-align: center; margin-bottom: 30px; }
        .bill-info { margin-bottom: 20px; }
        .bill-table { width: 100%; border-collapse: collapse; }
        .bill-table th, .bill-table td { border: 1px solid #ddd; padding: 8px; }
        .bill-footer { margin-top: 30px; text-align: right; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="bill-container">
        <div class="bill-header">
            <h2>HÓA ĐƠN THANH TOÁN</h2>
            <p>Mã đơn hàng: #<?= $order['id'] ?></p>
        </div>

        <div class="bill-info">
            <p><strong>Khách hàng:</strong> <?= $order['user_name'] ?? $order['guest_fullname'] ?></p>
            <p><strong>Địa chỉ:</strong> <?= $order['shipping_address'] ?></p>
            <p><strong>Số điện thoại:</strong> <?= $order['guest_phone'] ?></p>
            <p><strong>Ngày thanh toán:</strong> <?= date('d/m/Y H:i', strtotime($order['payment_date'])) ?></p>
        </div>

        <table class="bill-table">
            <tr>
                <th>Hình thức thanh toán</th>
                <td><?= $order['payment_method'] == 'cash' ? 'Tiền mặt' : ($order['payment_method'] == 'bank_transfer' ? 'Chuyển khoản' : 'Ship COD') ?></td>
            </tr>
            <tr>
                <th>Tổng tiền</th>
                <td><?= number_format($order['total_amount']) ?> vnđ</td>
            </tr>
        </table>

        <div class="bill-footer">
            <p><strong>Tổng cộng:</strong> <?= number_format($order['total_amount']) ?> vnđ</p>
        </div>

        <button class="btn btn-primary" onclick="window.print()">In hóa đơn</button>
        <a href="?act=orders" class="btn btn-primary">Quay Lại</a>
    </div>
</body>
</html>