    <div class="container mt-3">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Mã đơn hàng #<?= $order['id'] ?></h6>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Thông tin của bạn</h5>
                    <p><strong>Họ tên:</strong> <?= $order['fullname'] ?? '' ?></p>
                    <p><strong>Số điện thoại:</strong> <?= $order['phone_number'] ?? $order['guest_phone'] ?></p>

                    <p><strong>Địa chỉ:</strong> <?= $order['shipping_address'] ?></p>
                </div>
                <div class="col-md-6">
                    <h5>Thông tin đơn hàng</h5>
                    <p><strong>Ngày đặt:</strong> <?= date('d/m/Y', strtotime($order['order_date'])) ?? date($order['order_date'])  ?></p>
                    <!-- <p><strong>Trạng thái thanh toán:</strong>
                        <?php
                        switch ($order['payment_status']) {
                            case 'unpaid':
                                echo 'Chưa thanh toán';
                                break;
                            case 'paid':
                                echo 'Đã thanh toán';
                                break;
                            case 'refunded':
                                echo 'Đã hoàn tiền';
                                break;
                            case 'failed':
                                echo 'Thanh toán thất bại';
                                break;
                            default:
                                echo 'Chưa có thông tin';
                                break;
                        }
                        ?>
                    </p> -->
                    <p><strong>Trạng thái vận chuyển:</strong>
                        <?php
                        switch ($order['shipping_status']) {
                            case 'pending':
                                echo 'Chờ xử lý';
                                break;
                            case 'in_transit':
                                echo 'Đang giao hàng';
                                break;
                            case 'delivered':
                                echo 'Đã giao hàng';
                                break;
                            case 'returned':
                                echo 'Đã trả hàng';
                                break;
                            case 'cancelled':
                                echo 'Đã hủy';
                                break;
                            case 'return_requested':
                                echo 'Đã yêu cầu trả hàng';
                                break;
                            case 'return_in_process':
                                echo 'Đang chờ trả hàng';
                                break;
                            case 'return_completed':
                                echo 'Trả hàng thành công';
                                break;
                            case 'return_failed':
                                echo 'Trả hàng thất bại';
                                break;
                            case 'reject':
                                echo 'Đã từ chối trả hàng';
                                break;
                            default:
                                echo 'Chưa có thông tin';
                                break;
                        }
                        ?>
                    </p>
                    <p><strong>Phương thức thanh toán:</strong>
                        <?php
                        switch ($order['payment_method']) {
                            case 'COD':
                                echo 'Thanh toán khi nhận hàng';
                                break;
                            case 'bank_transfer':
                                echo 'Thanh toán ngân hàng';
                                break;
                            case 'MOMO':
                                echo 'Thanh toán momo';
                                break;
                            default:
                                echo 'Chưa có thông tin';
                                break;
                        }
                        ?>
                    </p>
                </div>
            </div>
           

            <div class="request_custommer">
                <?php if (isset($order['reason']) && !empty($order['reason'])): ?>
                    <strong>Yêu cầu của bạn:</strong> <br>
                    <span>Nội dung: </span><?= htmlspecialchars($order['reason']) ?><br>
                    <span>
                        <?= isset($order['return_date']) && !empty($order['return_date'])
                            ? 'Ngày yêu cầu: ' . date('d/m/Y', strtotime($order['return_date']))
                            : ''
                        ?>
                    </span>
                <?php endif; ?>
                <?php if (!empty($order['admin_note'])): ?>
                    <div class="reson_admin mt-3">
                        <hr class="mt-3 col-4">
                        <strong>Phản hồi của admin:</strong> <br>
                        <span>Nội dung: </span><?= $order['admin_note'] ?><br>
                        <span>Ngày phản hồi: 
                        <?= isset($order['return_updated_at']) && !empty($order['return_updated_at'])
                            ? date('H:i d/m/Y', strtotime($order['return_updated_at']))
                            : ''
                        ?>
                        </span>
                    </div>
                <?php endif; ?>
               
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
                                    <img src="<?= removeLeadingDots($order['img'] ?? '') ?>" alt="Product Image" style="width:70px;height:auto;">
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
                <!-- <?php if ($order['shipping_status'] === 'pending'): ?>
                                <form method="POST" action="index.php?act=cancel_order" style="display: inline;"
                                    onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">
                                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-times"></i> Hủy đơn hàng
                                    </button>
                                </form>
                            <?php elseif ($order['shipping_status'] === 'returned'): ?>
                                <a href="index.php?act=order_detail&id=<?= $order['id'] ?>&rebuy=true"
                                    class="btn btn-primary">
                                    <i class="fas fa-shopping-cart"></i> Mua lại
                                </a>
                            <?php elseif ($order['shipping_status'] === 'delivered'): ?>
                                <a href="#" class="btn btn-warning" onclick="showReturnOrderModal(<?= $order['id'] ?>)">
                                    <i class="fas fa-undo"></i> Trả hàng
                                </a>
                            <?php endif; ?> -->
            </div>
        </div>
    </div>
</div>
