<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Chi tiết đơn hàng #<?= $order['id'] ?></h6>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Thông tin khách hàng</h5>
                    <p><strong>Họ tên:</strong> <?= $order['user_name'] ?? $order['guest_fullname'] ?></p>
                    <p><strong>Email:</strong> <?= $order['email'] ?? $order['guest_email'] ?></p>
                    <p><strong>Số điện thoại:</strong> <?= $order['phone_number'] ?? $order['guest_phone'] ?></p>

                    <p><strong>Địa chỉ:</strong> <?= $order['shipping_address'] ?></p>
                </div>
                <div class="col-md-6">
                    <h5>Thông tin đơn hàng</h5>
                    <p><strong>Ngày đặt:</strong> <?= date('H:i - d/m/Y', strtotime($order['order_date'])) ?? date($order['order_date'])  ?></p>
                    <p><strong>Trạng thái thanh toán:</strong> <?= $order['payment_status'] ?? 'Chưa có thông tin' ?></p>
                    <p><strong>Trạng thái vận chuyển:</strong> <?= $order['shipping_status'] ?? 'Chưa có thông tin' ?></p>
                    <p><strong>Phương thức thanh toán:</strong> <?= $order['payment_method'] ?? 'Chưa có thông tin' ?></p>
                </div>
            </div>

            <div class="table-responsive">
            <table class="table table-bordered">
    <thead>
        <tr>
            <th>Sản phẩm</th>
            <th>Hình ảnh</th>
            <th>Cấu hình</th>
            <th>Số lượng</th>
            <th>Đơn giá</th>
            <th>Thành tiền</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($order_details as $order): ?>
            <tr>
                <td><?= $order['product_name']?></td>
                <td>
                        <img src="<?= $order['img'] ?? '' ?>" alt="" style="width:70px;height:auto;">
                </td>
                <td>
                    <?php if ($order['color']): ?>Màu: <?= $order['color'] ?><br><?php endif; ?>
                    <?php if ($order['ram']): ?>RAM: <?= $order['ram'] ?><br><?php endif; ?>
                    <?php if ($order['storage']): ?>Bộ nhớ: <?= $order['storage'] ?><?php endif; ?>
                </td>
                <td><?= $order['quantity'] ?? 0 ?></td>
                <td><?= number_format($order['price'] ?? 0) ?>đ</td>
                <td><?= number_format(($order['price'] ?? 0) * ($order['quantity'] ?? 0)) ?>đ</td>
            </tr>
        <?php endforeach; ?>
        
        <!-- Dòng tổng tiền -->
        <tr>
            <td colspan="5" class="text-right"><strong>Tổng tiền:</strong></td>
            <td><strong><?= number_format($order['total_amount'] ?? 0) ?>đ</strong></td>
        </tr>
    </tbody>
</table>

            </div>

            <div class="text-right mt-3">
                <a href="?act=orders" class="btn btn-secondary">Quay lại</a>
                <a href="?act=print_bill&id=<?= htmlspecialchars($order['order_info']['id'] ?? '0') ?>" class="btn btn-primary" target="_blank">
                    In hóa đơn
                </a>
            </div>
        </div>
    </div>
</div>
