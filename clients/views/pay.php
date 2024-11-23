<div class="container">
    <h3 class="mb-0 fw-bold mb-4">Thanh Toán</h3>
    
    <!-- Navigation các bước -->
    <style>
        .step-navigation .step.active::after {
            content: "";
            display: block;
            width: 400px;
            height: 4px;
            background-color: #007bff;

        }
    </style>
    <div class="step-navigation d-flex gap-4 mb-3">
        <div class="active1">
            <span class="step active" data-step="1">1. Vận chuyển</span>
        </div>
        <div class="active2">
            <span class="step" data-step="2">2. Thanh toán</span>
        </div>
    </div>

    <!-- Form 1: Vận chuyển -->
    <form id="form-shipping" class="mb-4">
        <div class="shipping">
            <h5 class="fw-bold mb-3">1. Lựa chọn phương thức vận chuyển</h5>
            <div class="border p-3 mb-3">
                <!-- Địa chỉ nhận hàng -->
                <div class="mb-3">
                    <label for="fullName" class="form-label">Họ và Tên</label>
                    <input type="text" class="form-control" id="fullName" placeholder="Nhập họ và tên">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Địa chỉ</label>
                    <input type="text" class="form-control" id="address" placeholder="Nhập địa chỉ">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" id="phone" placeholder="Nhập số điện thoại">
                </div>
                <!-- Phương thức vận chuyển -->
                <div class="mb-3">
                    <label for="shippingMethod" class="form-label">Chọn phương thức vận chuyển</label>
                    <select class="form-select" id="shippingMethod">
                        <option value="standard">Giao hàng 3 - 4 ngày</option>
                        <option value="express">Giao hàng nhanh 1 - 2 ngày</option>
                    </select>
                </div>
            </div>

            <!-- Nút để chuyển sang Form 2 -->
            <button type="button" class="btn btn-primary w-100" id="continueToPayment">Tiếp tục</button>
        </div>
    </form>

    <!-- Form 2: Thanh toán -->
    <form id="form-payment" class="mb-4 d-none">
        <div class="payment-method mb-4">
            <h5 class="fw-bold mb-3">2. Phương thức thanh toán</h5>
            <!-- Các tùy chọn thanh toán -->
            <div class="mb-3">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="paymentOption" id="cod" checked>
                    <label class="form-check-label" for="cod">
                        Thanh toán khi nhận hàng (COD)
                    </label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="paymentOption" id="atm">
                    <label class="form-check-label" for="atm">
                        Thanh toán ngay với thẻ ATM, Internet Banking, QR Code
                    </label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="paymentOption" id="international">
                    <label class="form-check-label" for="international">
                        Thanh toán ngay với thẻ quốc tế
                    </label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="paymentOption" id="installment">
                    <label class="form-check-label" for="installment">
                        Trả góp 0% lãi (có phí chuyển đổi)
                    </label>
                </div>
            </div>

            <!-- Địa chỉ thanh toán -->
            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="differentAddress">
                    <label class="form-check-label" for="differentAddress">
                        Thông tin thanh toán và nhận hàng khác nhau
                    </label>
                </div>
                <div class="mt-3">
                    <p class="mb-1">NGUYEN VAN A</p>
                    <p class="mb-1">SỐ 34</p>
                    <p class="mb-1">Phường Bình Thủy, Quận Bình Thủy, Cần Thơ</p>
                    <p class="mb-1">Việt Nam</p>
                    <p class="mb-0">0987654321</p>
                </div>
            </div>

            <!-- Nút đặt hàng -->
            <button type="submit" class="btn btn-secondary w-100">Đặt hàng</button>
        </div>
    </form>
</div>
<style>
    
</style>

<script>
    document.getElementById('continueToPayment').addEventListener('click', function () {
    // Chuyển đổi từ Form 1 sang Form 2
    document.getElementById('form-shipping').classList.remove('active');
    document.getElementById('form-payment').classList.add('active');

    // Cập nhật bước hiện tại
    document.querySelector('.step-navigation .step[data-step="1"]').classList.remove('active');
    document.querySelector('.step-navigation .step[data-step="2"]').classList.add('active');
});

// Mặc định hiển thị Form 1
document.getElementById('form-shipping').classList.add('active');

</script>