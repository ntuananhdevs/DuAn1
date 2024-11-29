<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng #<?= $order['id'] ?></title>
    <link rel="stylesheet" href="assets/css/order_detail.css">
</head>
<body>
    <div class="container">
        <div class="order-detail">
            <div class="order-header">
                <h1>Chi tiết đơn hàng #<?= $order['id'] ?></h1>
                <div class="order-status <?= $order['shipping_status'] ?>">
                    <?= $this->getStatusLabel($order['shipping_status']) ?>
                </div>
            </div>

            <div class="order-info">
                <div class="info-section">
                    <h2>Thông tin đơn hàng</h2>
                    <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></p>
                    <p><strong>Trạng thái thanh toán:</strong> <?= $this->getPaymentStatusLabel($order['payment_status']) ?></p>
                    <p><strong>Phương thức thanh toán:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
                    <p><strong>Tổng tiền:</strong> <?= number_format($order['total_amount']) ?> VNĐ</p>
                </div>

                <div class="info-section">
                    <h2>Thông tin giao hàng</h2>
                    <p><strong>Người nhận:</strong> <?= htmlspecialchars($order['fullname']) ?></p>
                    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['phone_number']) ?></p>
                    <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['shipping_address']) ?></p>
                </div>
            </div>

            <div class="order-items">
                <h2>Sản phẩm</h2>
                <div class="items-list">
                    <?php foreach ($orderDetails as $item): ?>
                        <div class="item">
                            <div class="item-image">
                                <img src="<?= htmlspecialchars($item['img_url']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
                            </div>
                            <div class="item-details">
                                <h3><?= htmlspecialchars($item['product_name']) ?></h3>
                                <p class="variant-info">
                                    Phiên bản: <?= htmlspecialchars($item['color']) ?> - 
                                    <?= $item['ram'] ?>GB/<?= $item['storage'] ?>GB
                                </p>
                                <p class="price">
                                    <?= number_format($item['price']) ?> VNĐ x <?= $item['quantity'] ?>
                                </p>
                                <p class="subtotal">
                                    Thành tiền: <?= number_format($item['subtotal']) ?> VNĐ
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="order-timeline">
                <h2>Trạng thái đơn hàng</h2>
                <div class="timeline">
                    <div class="timeline-item <?= $order['shipping_status'] == 'pending' ? 'active' : '' ?>">
                        <div class="timeline-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="timeline-content">
                            <h3>Đã đặt hàng</h3>
                            <p><?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></p>
                        </div>
                    </div>

                    <div class="timeline-item <?= $order['shipping_status'] == 'processing' ? 'active' : '' ?>">
                        <div class="timeline-icon">
                            <i class="fas fa-cog"></i>
                        </div>
                        <div class="timeline-content">
                            <h3>Đang xử lý</h3>
                            <?php if ($order['shipping_status'] == 'processing'): ?>
                                <p><?= date('d/m/Y H:i', strtotime($order['updated_at'])) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="timeline-item <?= $order['shipping_status'] == 'shipping' ? 'active' : '' ?>">
                        <div class="timeline-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="timeline-content">
                            <h3>Đang giao hàng</h3>
                            <?php if ($order['shipping_status'] == 'shipping'): ?>
                                <p><?= date('d/m/Y H:i', strtotime($order['updated_at'])) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="timeline-item <?= $order['shipping_status'] == 'completed' ? 'active' : '' ?>">
                        <div class="timeline-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="timeline-content">
                            <h3>Đã giao hàng</h3>
                            <?php if ($order['shipping_status'] == 'completed'): ?>
                                <p><?= date('d/m/Y H:i', strtotime($order['updated_at'])) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ($order['shipping_status'] == 'cancelled'): ?>
                        <div class="timeline-item cancelled active">
                            <div class="timeline-icon">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="timeline-content">
                                <h3>Đã hủy</h3>
                                <p><?= date('d/m/Y H:i', strtotime($order['cancelled_at'])) ?></p>
                                <?php if ($order['cancel_reason']): ?>
                                    <p class="cancel-reason">Lý do: <?= htmlspecialchars($order['cancel_reason']) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($order['shipping_status'] == 'pending'): ?>
                <div class="order-actions">
                    <button class="btn btn-danger" onclick="showCancelOrderModal()">
                        Hủy đơn hàng
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal hủy đơn hàng -->
    <div class="modal fade" id="cancelOrderModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hủy đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="cancelOrderForm">
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        <div class="mb-3">
                            <label for="cancelReason" class="form-label">Lý do hủy đơn</label>
                            <textarea class="form-control" id="cancelReason" name="reason" rows="3" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-danger" onclick="cancelOrder()">Xác nhận hủy</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    function showCancelOrderModal() {
        new bootstrap.Modal(document.getElementById('cancelOrderModal')).show();
    }

    function cancelOrder() {
        const form = document.getElementById('cancelOrderForm');
        const formData = new FormData(form);

        fetch('?act=cancel_order', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert(data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi hủy đơn hàng');
        });
    }
    </script>
</body>
</html>
