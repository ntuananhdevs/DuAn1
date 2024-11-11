<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Chi tiết đơn hàng #<?= $order['order_info']['id'] ?></h6>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Thông tin khách hàng</h5>
                    <p><strong>Họ tên:</strong> <?= $order['order_info']['guest_fullname'] ?></p>
                    <p><strong>Email:</strong> <?= $order['order_info']['guest_email'] ?></p>
                    <p><strong>Số điện thoại:</strong> <?= $order['order_info']['guest_phone'] ?></p>
                    <p><strong>Địa chỉ:</strong> <?= $order['order_info']['shipping_address'] ?></p>
                </div>
                <div class="col-md-6">
                    <h5>Thông tin đơn hàng</h5>
                    <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($order['order_info']['order_date'])) ?></p>
                    <p><strong>Trạng thái thanh toán:</strong> <?= $order['order_info']['payment_status'] ?></p>
                    <p><strong>Trạng thái vận chuyển:</strong> <?= $order['order_info']['shipping_status'] ?></p>
                    <p><strong>Phương thức thanh toán:</strong> <?= $order['order_info']['payment_method'] ?></p>
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
                        <?php foreach ($order['products'] as $product): ?>
                        <tr>
                            <td><?= $product['product_name'] ?></td>
                            <td><img src="<?= $product['img'] ?>" width="50" height="50" alt=""></td>
                            <td>
                                <?php if($product['color']): ?>Màu: <?= $product['color'] ?><br><?php endif; ?>
                                <?php if($product['ram']): ?>RAM: <?= $product['ram'] ?><br><?php endif; ?>
                                <?php if($product['storage']): ?>Bộ nhớ: <?= $product['storage'] ?><?php endif; ?>
                            </td>
                            <td><?= $product['quantity'] ?></td>
                            <td><?= number_format($product['price']) ?>đ</td>
                            <td><?= number_format($product['subtotal']) ?>đ</td>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="5" class="text-right"><strong>Tổng tiền:</strong></td>
                            <td><strong><?= number_format($order['order_info']['total_amount']) ?>đ</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-right mt-3">
                <a href="?act=orders" class="btn btn-secondary">Quay lại</a>
                <a href="?act=print_bill&id=<?= $order['order_info']['id'] ?>" class="btn btn-primary" target="_blank">
                    In hóa đơn
                </a>
            </div>
        </div>
    </div>
</div>
