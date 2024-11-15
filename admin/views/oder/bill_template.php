<!DOCTYPE html>
<html>
<head>
    <title>Hóa đơn #<?= htmlspecialchars($order['id'] ?? '') ?></title>
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
            <p>Mã đơn hàng: #<?= htmlspecialchars($order['id'] ?? '') ?></p>
        </div>

        <div class="bill-info">
            <h2>Thông tin đơn hàng</h2>
            <p>Mã đơn hàng: <?= htmlspecialchars($order['id'] ?? ''); ?></p>
            <p>Khách hàng: <?= htmlspecialchars($order['guest_fullname'] ?? 'Chưa có tên'); ?></p>
            <p>Địa chỉ: <?= htmlspecialchars($order['shipping_address'] ?? 'Chưa có địa chỉ'); ?></p>
            <p>Số điện thoại: <?= htmlspecialchars($order['guest_phone'] ?? 'Chưa có số điện thoại'); ?></p>
            <p>Ngày thanh toán: <?= htmlspecialchars(date('d/m/Y H:i', strtotime($order['payment_date'] ?? ''))); ?></p>
            <p>Hình thức thanh toán: <?= htmlspecialchars($order['payment_method'] ?? 'Chưa xác định'); ?></p>
            <p>Tổng tiền: <?= htmlspecialchars(number_format($order['total_amount'] ?? 0)) . ' vnđ'; ?></p>
        </div>

        <table class="bill-table">
            <tr>
                <th>Tổng tiền</th>
                <td><?= number_format($order['total_amount']) ?> vnđ</td>
            </tr>
        </table>

        <div class="bill-footer">
            <p><strong>Tổng cộng:</strong> <?= number_format($order['total_amount']) ?> vnđ</p>
        </div>

        <button class="btn btn-primary no-print" onclick="window.print()">In hóa đơn</button>
        <a href="?act=orders" class="btn btn-primary no-print">Quay Lại</a>
    </div>
</body>
</html>
