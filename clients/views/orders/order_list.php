<div class="container my-4">
    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <h2 class="mb-4">Đơn hàng của tôi</h2>

    <?php if (isset($_SESSION['success'])): ?>
    <div id="alertMessage" class="alert alert-success alert-dismissible slide-in position-fixed end-0 m-3 custom-alert" role="alert" style="z-index: 99999; max-width: 400px; top: 10px;">
        <div class="d-flex align-items-center">
            <div class="icon-container me-2">
            <i class="fas fa-check-circle"></i>

            </div>
            <div class="message-container flex-grow-1 text-white">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        </div>
    </div>
    <script>
        setTimeout(function() {
            const alertMessage = document.getElementById('alertMessage');
            if (alertMessage) alertMessage.remove();
        }, 3000);
    </script>
<?php endif; ?>
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
            <a class="nav-link <?php echo isset($_GET['status']) && $_GET['status'] == 'cancelled' ? 'active' : ''; ?>"
                href="index.php?act=orders&status=cancelled  ">
                Đã hủy
                <?php if (isset($orderCounts['cancelled']) && $orderCounts['cancelled'] > 0): ?>
                    <span class="badgee">
                        <?php echo $orderCounts['cancelled']; ?>
                    </span>
                <?php endif; ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo isset($_GET['status']) && $_GET['status'] == 'return_requested' ? 'active' : ''; ?>"
                href="index.php?act=orders&status=return_requested">
                Yêu cầu trả hàng
                <?php if (isset($orderCounts['return_requested']) && $orderCounts['return_requested'] > 0): ?>
                    <span class="badgee">
                        <?php echo $orderCounts['return_requested']; ?>
                    </span>
                <?php endif; ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo isset($_GET['status']) && $_GET['status'] == 'return_in_process' ? 'active' : ''; ?>"
                href="index.php?act=orders&status=return_in_process">
                Đang xử lý trả hàng
                <?php if (isset($orderCounts['return_in_process']) && $orderCounts['return_in_process'] > 0): ?>
                    <span class="badgee">
                        <?php echo $orderCounts['return_in_process']; ?>
                    </span>
                <?php endif; ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo isset($_GET['status']) && $_GET['status'] == 'return_completed' ? 'active' : ''; ?>"
                href="index.php?act=orders&status=return_completed">
                Trả hàng
                <?php if (isset($orderCounts['return_completed']) && $orderCounts['return_completed'] > 0): ?>
                    <span class="badgee">
                        <?php echo $orderCounts['return_completed']; ?>
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
                                <?php elseif ($order['payment_status'] == 'refunded'): ?>
                                    <span class="badge bg-info">Đã hoàn tiền</span>
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
                                <img src="<?php echo removeLeadingDots($product['img'])  ?>" alt="<?php echo $product['product_name']; ?>" style="width: 100px; height: 100px;">
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

                        <div class="order-actions" id="order-actions-<?php echo $order['id']; ?>">
                            <a href="?act=order_detail&id=<?= $order['id'] ?>" class="btn btn-primary">Chi Tiết</a>
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
                            <?php elseif ($order['shipping_status'] === 'delivered'): ?>
                                <a href="#" class="btn btn-warning" onclick="showReturnOrderModal(<?= $order['id'] ?>)">
                                    <i class="fas fa-undo"></i> Trả hàng
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php else: ?>
    <div class="alert alert-info custom-alert">
        Không có đơn hàng nào.
    </div>
<?php endif; ?>

</div>


<div id="returnOrderModal" class="custom-modal">
    <div class="custom-modal-content">
        <span class="closes" onclick="closeModall()">&times;</span>
        <h5>Lý do trả hàng</h5>
        <form action="?act=return_order" method="POST">
            <div class="mb-3">
                <textarea class="form-control" name="reason" id="returnReason" rows="3" required placeholder="Nhập lý do trả hàng..."></textarea>
            </div>
            <input type="hidden" name="shipping_status" id="shippingStatus" value="return_requested">
            <input type="hidden" name="order_id" id="orderId" value="<?= htmlspecialchars($order_id) ?>">
            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>"> <!-- Lấy user_id từ session -->
            <div class="text-end">
                <button type="button" class="btn btn-secondary" onclick="closeModall()">Hủy</button>
                <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
            </div>
        </form>
    </div>
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
                alert('Đã có lỗi xảy ra. Vui lng thử lại sau.');
            }
        });
    }

    function rebuyOrder(orderId) {
        // Chuyển hướng đến trang chi tiết sản phẩm hoặc giỏ hàng
        window.location.href = `index.php?act=order_detail&id=${orderId}&rebuy=true`;
    }

    function updateOrderCounts() {
        location.reload();
    }

    //sse
    const eventSource = new EventSource('sse.php'); // Kết nối SSE
    console.log(eventSource);

    // Lắng nghe sự kiện và cập nhật trạng thái đơn hàng
    eventSource.onmessage = function(event) {
        const data = JSON.parse(event.data);
        const orderId = data.orderId;
        const status = data.status;

        // Cập nhật trạng thái đơn hàng trong giao diện
        const statusBadge = document.getElementById(`status-badge-${orderId}`);
        if (statusBadge) {
            statusBadge.textContent = getStatusText(status);
            statusBadge.className = getStatusClass(status);
        }

        // Cập nhật các nút hành động
        updateOrderActions(orderId, status);

        // Cập nhật số lượng đơn hàng trong các tab
        updateTabCounts(data.orderCounts);
    };

    // Thêm hàm mới để cập nhật số lượng trong các tab
    function updateTabCounts(counts) {
        // Cập nhật tổng số đơn hàng
        const totalCount = Object.values(counts).reduce((a, b) => a + b, 0);
        const allTab = document.querySelector('.nav-link[href="index.php?act=orders"] .badgee');
        if (allTab) {
            allTab.textContent = totalCount;
            allTab.style.display = totalCount > 0 ? '' : 'none';
        }

        // Cập nhật từng trạng thái
        const statuses = ['pending', 'in_transit', 'delivered', 'cancelled'];
        statuses.forEach(status => {
            const tab = document.querySelector(`.nav-link[href="index.php?act=orders&status=${status}"] .badgee`);
            if (tab) {
                const count = counts[status] || 0;
                tab.textContent = count;
                tab.style.display = count > 0 ? '' : 'none';
            }
        });
    }

    // Hàm trả về tên trạng thái
    function getStatusText(status) {
        const statusMapping = {
            'pending': 'Chờ xác nhận',
            'in_transit': 'Đang giao',
            'delivered': 'Đã giao',
            'returned': 'Trả hàng',
            'cancelled': 'Đã hủy'
        };
        return statusMapping[status] || 'Không xác định';
    }

    // Hàm trả về lớp CSS cho badge trạng thái
    function getStatusClass(status) {
        const statusClasses = {
            'pending': 'badge bg-warning',
            'in_transit': 'badge bg-info',
            'delivered': 'badge bg-success',
            'cancelled': 'badge bg-danger',
            'returned': 'badge bg-warning'
        };
        return statusClasses[status] || 'badge bg-secondary';
    }

    // Hàm cập nhật các nút hành động của đơn hàng
    function updateOrderActions(orderId, status) {
        const orderActions = document.getElementById(`order-actions-${orderId}`);
        console.log(orderActions);
        if (orderActions) {
            orderActions.innerHTML = ''; // Xóa nội dung cũ

            switch (status) {
                case 'pending':
                    orderActions.innerHTML = `
                    <form method="POST" action="index.php?act=cancel_order" style="display: inline;" 
                          onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">
                        <input type="hidden" name="order_id" value="${orderId}">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times"></i> Hủy đơn hàng
                        </button>
                    </form>`;
                    break;
                case 'returned':
                    orderActions.innerHTML = `
                    <a href="index.php?act=order_detail&id=${orderId}&rebuy=true" 
                       class="btn btn-primary">
                        <i class="fas fa-shopping-cart"></i> Mua lại
                    </a>`;
                    break;
                case 'delivered':
                    orderActions.innerHTML = `
                    <a href="#" class="btn btn-warning" onclick="showReturnOrderModal(${orderId})">
                        <i class="fas fa-undo"></i> Trả hàng
                    </a>`;
                    break;
            }
        }
    }

    function showReturnOrderModal(orderId) {
        document.getElementById('orderId').value = orderId;
        document.getElementById('returnOrderModal').style.display = 'block';
    }

    function closeModall() {
        document.getElementById('returnOrderModal').style.display = 'none';
    }
</script>
<style>
    .custom-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .custom-modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
        border-radius: 8px;
    }

    .closes {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .closes:hover,
    .closes:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .text-end {
        text-align: right;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover,
    .btn-primary:hover {
        opacity: 0.8;
    }

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
        width: 90%;
        margin: auto;
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
    .custom-alert {
    background-color: #28a745; /* Màu xanh lá cây */
    color: #ffffff; /* Màu trắng */
    border: none; /* Loại bỏ viền */
    border-radius: 10px; /* Bo góc */
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Tạo hiệu ứng đổ bóng */
    padding: 10px 15px; /* Căn chỉnh padding */
    animation: slideIn 0.5s ease-out; /* Hiệu ứng trượt vào */
}

.custom-alert .icon-container {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(255, 255, 255, 0.2); /* Làm nền biểu tượng nhạt hơn */
    border-radius: 50%; /* Tạo hình tròn */
    width: 40px;
    height: 40px;
}

.custom-alert .message-container {
    font-size: 14px; /* Kích thước chữ */
    line-height: 1.5; /* Khoảng cách giữa các dòng */
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
.custom-alert {
    background-color: #f0f9ff; 
    border: 1px solid #b3d7ff;
    color: #0056b3; 
    padding: 15px 20px;
    border-radius: 8px; 
    font-family: 'Arial', sans-serif; 
    font-size: 16px; 
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    display: flex; 
    align-items: center;
    gap: 10px; 
    width: 50%;
    text-align: center;
}

.custom-alert:before {
    content: "ℹ️"; 
    font-size: 20px;
    color: #0056b3;
}

</style>