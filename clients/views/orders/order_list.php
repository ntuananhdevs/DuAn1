<div class="container my-4">
    <h2 class="mb-4">Đơn hàng của tôi</h2>
    
    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link <?php echo !isset($_GET['status']) || $_GET['status'] == 'all' ? 'active' : ''; ?>" 
               href="index.php?act=orders">Tất cả</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo isset($_GET['status']) && $_GET['status'] == 'pending' ? 'active' : ''; ?>" 
               href="index.php?act=orders&status=pending">Chờ xác nhận</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo isset($_GET['status']) && $_GET['status'] == 'in_transit' ? 'active' : ''; ?>" 
               href="index.php?act=orders&status=in_transit">Đang giao</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo isset($_GET['status']) && $_GET['status'] == 'delivered' ? 'active' : ''; ?>" 
               href="index.php?act=orders&status=delivered">Đã giao</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo isset($_GET['status']) && $_GET['status'] == 'cancelled' ? 'active' : ''; ?>" 
               href="index.php?act=orders&status=cancelled">Đã hủy</a>
        </li>
    </ul>

    <!-- Orders List -->
    <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $order): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <span class="order-id">#<?php echo $order['id']; ?></span>
                            <span class="text-muted ms-2"><?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></span>
                        </div>
                        <div>
                            <span class="me-3">
                                <?php if($order['payment_status'] == 'paid'): ?>
                                    <span class="badge bg-success">Đã thanh toán</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Chưa thanh toán</span>
                                <?php endif; ?>
                            </span>
                            <span class="badge <?php echo $statusButtonStyle[$order['shipping_status']]; ?>">
                                <?php echo $statusMapping[$order['shipping_status']]; ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="text-end mt-3">
                        <span class="text-muted">Tổng tiền:</span>
                        <span class="text-danger fw-bold ms-2"><?php echo number_format($order['total_amount'], 0, ',', '.'); ?>đ</span>
                        <a href="index.php?act=order_detail&id=<?php echo $order['id']; ?>" 
                           class="btn btn-outline-primary btn-sm ms-3">
                            Xem chi tiết
                        </a>
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

<style>
.nav-tabs .nav-link {
    color: #666;
    border: none;
    padding: 10px 20px;
}
.nav-tabs .nav-link.active {
    color: #ee4d2d;
    border-bottom: 2px solid #ee4d2d;
    background: none;
}
.card {
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border: none;
}
.order-id {
    color: #ee4d2d;
    font-weight: 500;
}
</style> 