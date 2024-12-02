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
            <div class="shipping_status  mb-3 ">
                <p><strong>Trạng thái vận chuyển:</strong>
                        <form method="POST" action="update_shipping_status" class="d-flex gap-3 align-items-center">
                            <select name="shipping_status" class="form-select" aria-label="Chọn trạng thái vận chuyển" style="width: 200px; height: 40px;">
                                <option value="pending" <?= $order['shipping_status'] === 'pending' ? 'selected' : '' ?>>Chờ xử lý</option>
                                <option value="shipped" <?= $order['shipping_status'] === 'shipped' ? 'selected' : '' ?>>Đã gửi</option>
                                <option value="delivered" <?= $order['shipping_status'] === 'delivered' ? 'selected' : '' ?>>Đã giao</option>
                                <option value="cancelled" <?= $order['shipping_status'] === 'cancelled' ? 'selected' : '' ?>>Đã hủy</option>
                            </select>
                            <button type="submit" class="btn btn-primary mt-3">Cập nhật trạng thái</button>
                        </form>
                    
                </p>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
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
                                <td><?= htmlspecialchars($order['product_name']) ?></td>
                                <td>
                                    <img src="<?= htmlspecialchars($order['img'] ?? '') ?>" alt="Product Image" style="width:70px;height:auto;">
                                </td>
                                <td>
                                    <?php if (!empty($order['color'])): ?>Màu: <?= htmlspecialchars($order['color']) ?><br><?php endif; ?>
                                <?php if (!empty($order['ram'])): ?>RAM: <?= htmlspecialchars($order['ram']) ?><br><?php endif; ?>
                            <?php if (!empty($order['storage'])): ?>Bộ nhớ: <?= htmlspecialchars($order['storage']) ?><?php endif; ?>
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
                            <td colspan="6" class="text-right"><strong>Tổng tiền </strong>(đã bao gồm VAT 10%):</td>
                            <td><strong><?= number_format($grand_total * 1.10) ?>đ</strong></td>
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