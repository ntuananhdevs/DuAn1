<div class="container my-4">
    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <h2 class="mb-4">Đơn hàng của tôi</h2>

    <!-- Order Count Alert -->


    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link <?php echo !isset($_GET['status']) || $_GET['status'] == 'all' ? 'active' : ''; ?>"
                href="index.php?act=orders">
                Tất cả
                <?php if (array_sum($orderCounts) > 0): ?>
                    <span class="badgee">
                        <?php echo array_sum($orderCounts); ?>
                    </span>
                <?php endif; ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo isset($_GET['status']) && $_GET['status'] == 'pending' ? 'active' : ''; ?>"
                href="index.php?act=orders&status=pending">
                Chờ xác nhận
                <?php if (isset($orderCounts['pending']) && $orderCounts['pending'] > 0): ?>
                    <span class="badgee">
                        <?php echo $orderCounts['pending']; ?>
                    </span>
                <?php endif; ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo isset($_GET['status']) && $_GET['status'] == 'in_transit' ? 'active' : ''; ?>"
                href="index.php?act=orders&status=in_transit">
                Đang giao
                <?php if (isset($orderCounts['in_transit']) && $orderCounts['in_transit'] > 0): ?>
                    <span class="badgee">
                        <?php echo $orderCounts['in_transit']; ?>
                    </span>
                <?php endif; ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo isset($_GET['status']) && $_GET['status'] == 'delivered' ? 'active' : ''; ?>"
                href="index.php?act=orders&status=delivered">
                Đã giao
                <?php if (isset($orderCounts['delivered']) && $orderCounts['delivered'] > 0): ?>
                    <span class="badgee">
                        <?php echo $orderCounts['delivered']; ?>
                    </span>
                <?php endif; ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo isset($_GET['status']) && $_GET['status'] == 'returned' ? 'active' : ''; ?>"
                href="index.php?act=orders&status=returned  ">
                Đã hủy
                <?php if (isset($orderCounts['returned']) && $orderCounts['returned'] > 0): ?>
                    <span class="badgee">
                        <?php echo $orderCounts['returned']; ?>
                    </span>
                <?php endif; ?>
            </a>
        </li>
    </ul>
    <!-- Orders List -->
    <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $order): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <span class="order-id">#<?php echo array_search($order, $orders) + 1; ?></span>
                            <span class="text-muted ms-2"><?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></span>
                        </div>
                        <div class="d-flex justify-content-start align-items-center">
                            <span class="me-3">
                                <?php if ($order['payment_status'] == 'paid'): ?>
                                    <span class="badge bg-success">Đã thanh toán</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Chưa thanh toán</span>
                                <?php endif; ?>
                            </span>
                            <span class="badge <?php echo $statusButtonStyle[$order['shipping_status']]; ?>" 
                                  id="status-badge-<?php echo $order['id']; ?>">
                                <?php echo $statusMapping[$order['shipping_status']]; ?>
                            </span>
                        </div>
                    </div>

                    <div class="products_by_order mt-3">
                        <?php foreach ($order['products'] as $product): ?>
                            <div class="d-flex gap-3 mb-3">
                                <img src="<?php echo $product['img']; ?>" alt="<?php echo $product['product_name']; ?>" style="width: 100px; height: 100px;">
                                <div class="product-info">
                                    <h4 style="color:#666;"><?php echo $product['product_name']; ?> (<?php echo $product['color']; ?>, <?php echo $product['storage']; ?>)</h4>
                                    <div class="price-qty" style="margin-top: 40px;">
                                        <h5 class="quantity">x<?php echo $product['quantity']; ?></h5>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="text-end mt-3 d-flex justify-content-end align-items-center gap-4">
                        <div class="total-order">
                            <span class="text-muted">Tổng tiền:</span>
                            <span class="text-danger fw-bold ms-2"><?php echo number_format($order['total_amount'], 0, ',', '.'); ?>đ</span>
                        </div>
                       
                        <div class="order-actions">
                            <?php if ($order['shipping_status'] === 'pending'): ?>
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
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info">
            Không có đơn hàng nào.
        </div>
    <?php endif; ?>
</div>

<script>
function cancelOrder(orderId) {
    if (!confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')) {
        return;
    }
    $.ajax({
        url: 'index.php?act=cancel_order',
        type: 'POST',
        data: {
            order_id: orderId
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert(response.message);
                // Cập nhật UI
                const btnCancel = $(`#btn-cancel-${orderId}`);
                const statusBadge = $(`#status-badge-${orderId}`);
                
                // Thay đổi nút hủy thành nút mua lại
                btnCancel.removeClass('btn-danger').addClass('btn-primary');
                btnCancel.html('<i class="fas fa-shopping-cart"></i> Mua lại');
                btnCancel.attr('onclick', `rebuyOrder(${orderId})`);
                
                // Cập nhật trạng thái
                statusBadge.removeClass('bg-warning bg-info bg-success')
                          .addClass('bg-danger')
                          .text('Đã hủy');
                
                // Cập nhật số lượng đơn hàng trong các tab
                updateOrderCounts();
            } else {
                alert('Không thể hủy đơn hàng. Vui lòng thử lại sau.');
            }
        },
        error: function() {
            alert('Đã có lỗi xảy ra. Vui lòng thử lại sau.');
        }
    });
}

function rebuyOrder(orderId) {
    // Chuyển hướng đến trang chi tiết sản phẩm hoặc giỏ hàng
    window.location.href = `index.php?act=order_detail&id=${orderId}&rebuy=true`;
}

function updateOrderCounts() {
    // Tải lại trang để cập nhật số lượng
    location.reload();
}
</script>
<style>
    .badgee {
        background-color: #ee4d2d;
        color: #fff;
        padding: 2px 5px;
        border-radius: 100%;
        font-weight: 600;
        font-size: .65rem;
        position: relative;
        top: -10px;
        left: -4px;
        text-align: center;
    }

    /* Tabs Navigation */
    .nav-tabs .nav-link {
        color: #555;
        /* Tông màu trung tính hơn */
        border: none;
        padding: 12px 25px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link.active {
        color: #ee4d2d;
        border-bottom: 3px solid #ee4d2d;
        /* Tăng độ dày border */
        background: none;
        font-weight: 600;
    }

    .nav-tabs .nav-link:hover {
        color: #ee4d2d;
        /* Hiệu ứng hover */
    }

    /* Card Styles */
    .card {
        border-radius: 12px;
        /* Bo tròn mềm mại hơn */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        /* Hiệu ứng bóng mềm */
        border: 1px solid #f0f0f0;
        /* Viền nhẹ nhàng */
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        /* Hiệu ứng bóng khi hover */
    }

    /* Order ID and Header */
    .order-id {
        color: #ee4d2d;
        font-weight: 600;
        font-size: 1.2rem;
    }

    .card .text-muted {
        font-size: 0.9rem;
        color: #888;
    }

    /* Product Section */
    .products_by_order img {
        border-radius: 8px;
        object-fit: cover;
        /* Đảm bảo hình ảnh không bị méo */
    }

    .product-info h4 {
        font-size: 1.1rem;
        font-weight: 500;
        color: #444;
        margin: 0;
    }

    .product-info .price-qty h5 {
        font-size: 1rem;
        font-weight: 400;
        color: #888;
    }

    /* Badge Styles */
    .badge {
        font-size: 0.9rem;
        padding: 5px 10px;
        border-radius: 6px;
        text-transform: capitalize;
    }

    .badge.bg-success {
        background-color: #4caf50;
        color: white;
    }

    .badge.bg-warning {
        background-color: #ffc107;
        color: #fff;
    }

    .badge.bg-danger {
        background-color: #f44336;
        color: #fff;
    }

    /* Button Styles */
    .btn-outline-primary {
        color: #007bff;
        border-color: #007bff;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-outline-danger {
        color: #f44336;
        border-color: #f44336;
        transition: all 0.3s ease;
    }

    .btn-outline-danger:hover {
        color: #fff;
        background-color: #f44336;
        border-color: #f44336;
    }

    /* Total Amount Section */
    .text-danger.fw-bold {
        font-size: 1.1rem;
        font-weight: 700;
        color: #e53935;
    }

    /* General Spacing and Alignment */

    .card-body {
        padding: 20px;
    }

    .d-flex.justify-content-between {
        margin-bottom: 20px;
    }

    .text-end span {
        font-size: 0.95rem;
        color: #555;
    }

    .text-end .text-danger {
        font-size: 1.2rem;
        font-weight: bold;
        margin-left: 10px;
    }
</style>
