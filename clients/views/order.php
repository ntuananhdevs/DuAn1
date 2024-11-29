<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/order.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<div class="content-section">
    <div class="section-header">
        <h2 class="section-title">Đơn hàng của tôi</h2>
        <p class="section-desc">Quản lý và theo dõi đơn hàng của bạn</p>
    </div>

    <div class="order-progress">
        <div class="progress-step completed">
            <div class="step-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="step-label">Đơn Hàng Đã Đặt</div>
            <div class="step-date">20.04.2024 14:30</div>
        </div>
        <div class="progress-step completed">
            <div class="step-icon">
                <i class="fa-solid fa-money-bills"></i>
            </div>
            <div class="step-label">Đã Xác Nhận Thông Tin Thanh Toán</div>
            <div class="step-date">20.04.2024 15:00</div>
        </div>
        <div class="progress-step active">
            <div class="step-icon">
                <i class="fa-solid fa-truck"></i>
            </div>
            <div class="step-label">Chờ Lấy Hàng</div>
            <div class="step-date">20.04.2024 15:30</div>
        </div>
        <div class="progress-step">
            <div class="step-icon">
                <i class="fa-solid fa-shipping-fast"></i>
            </div>
            <div class="step-label">Đang Giao</div>
        </div>
        <div class="progress-step">
            <div class="step-icon">
                <i class="fa-solid fa-star"></i>
            </div>
            <div class="step-label">Đánh Giá</div>
        </div>
    </div>

    <div class="orders-list">
        <!-- Sample Order Card -->
        <div class="order-card">
            <div class="order-header">
                <div class="order-id">#ORDER123456</div>
                <div class="order-date">27/03/2024 15:30</div>
                <div class="order-status pending">Chờ xác nhận</div>
            </div>

            <div class="order-products">
                <div class="product-item">
                    <img src="assets/img/sample-product.jpg" alt="iPhone">
                    <div class="product-info">
                        <h4>iPhone 15 Pro Max</h4>
                        <p class="variant">Phiên bản: 256GB</p>
                        <div class="price-qty">
                            <span class="price">34.990.000đ</span>
                            <span class="quantity">x1</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="order-footer">
                <div class="order-total">
                    <span>Tổng tiền:</span>
                    <span class="total-amount">34.990.000đ</span>
                </div>
                <div class="order-actions">
                    <button class="btn btn-outline-primary">Chi tiết đơn hàng</button>
                    <button class="btn btn-danger">Hủy đơn hàng</button>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div class="empty-state" style="display: none;">
            <img src="assets/img/empty-order.png" alt="No orders">
            <p>Bạn chưa có đơn hàng nào</p>
            <a href="?act=shop" class="btn btn-primary">Mua sắm ngay</a>
        </div>
    </div>
</div>


</body>
</html>