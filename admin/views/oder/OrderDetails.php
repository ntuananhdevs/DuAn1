
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Chi tiết đơn hàng #<?= $order['order_info']['id'] ?? 'Không xác định' ?></h6>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Thông tin khách hàng</h5>
                    <p><strong>Họ tên:</strong> <?= $order['order_info']['guest_fullname'] ?? 'Chưa có thông tin' ?></p>
                    <p><strong>Email:</strong> <?= $order['order_info']['guest_email'] ?? 'Chưa có thông tin' ?></p>
                    <p><strong>Số điện thoại:</strong> <?= $order['order_info']['guest_phone'] ?? 'Chưa có thông tin' ?></p>
                    <p><strong>Địa chỉ:</strong> <?= $order['order_info']['shipping_address'] ?? 'Chưa có thông tin' ?></p>
                </div>
                <div class="col-md-6">
                    <h5>Thông tin đơn hàng</h5>
                    <p><strong>Ngày đặt:</strong> <?= isset($order['order_info']['order_date']) ? date('d/m/Y H:i', strtotime($order['order_info']['order_date'])) : 'Chưa có thông tin' ?></p>
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
                        <?php if (!empty($order['products'])): ?>
                            <?php foreach ($order['products'] as $product): ?>
                            <tr>
                                <td><?= $product['product_name'] ?? 'Không có tên sản phẩm' ?></td>
                                <td>
                                    <?php if (!empty($product['variant_img']['img'])): ?>
                                        <img src="<?= htmlspecialchars($product['variant_img']['img']) ?>" width="80px" height="80px" alt="Ảnh variant">
                                    <?php else: ?>
                                        <img src="<?= htmlspecialchars($product['product_img']) ?>" width="150px" height="150px" alt="Ảnh sản phẩm">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($product['color']): ?>Màu: <?= $product['color'] ?><br><?php endif; ?>
                                    <?php if($product['ram']): ?>RAM: <?= $product['ram'] ?><br><?php endif; ?>
                                    <?php if($product['storage']): ?>Bộ nhớ: <?= $product['storage'] ?><?php endif; ?>
                                </td>
                                <td><?= $product['quantity'] ?? 0 ?></td>
                                <td><?= number_format($product['price'] ?? 0) ?>đ</td>
                                <td><?= number_format($product['subtotal'] ?? 0) ?>đ</td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Không có sản phẩm nào trong đơn hàng.</td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td colspan="5" class="text-right"><strong>Tổng tiền:</strong></td>
                            <td><strong><?= number_format($order['order_info']['total_amount'] ?? 0) ?>đ</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-right mt-3">
                <a href="?act=orders" class="btn btn-secondary">Quay lại</a>
                <a href="?act=print_bill&id=<?= $order['order_info']['id'] ?? '0' ?>" class="btn btn-primary" target="_blank">
                    In hóa đơn
                </a>
            </div>
        </div>
    </div>
</div>