<div class="container mb-5">
    <h4 class="mb-0 fw-bold mb-4 mt-4">Giỏ mua hàng</h4>
    <hr class="text-muted">

    <!-- Phần sản phẩm -->
    <div class="boxproducts d-flex gap-4 justify-content-start align-items-start mb-4">
        <div class="img-prd">
            <img src="uploads/Products/673a293d4ef22_iphone-16-1.webp" alt="Samsung S23 Ultra" width="120px">
        </div>
        <div class="spect-prd ms-4">
            <h5 class="fw-bold fs-5 mb-2">Samsung S23 Ultra 12GB 512GB - Đen</h5>
            <h6 class="fw-bold mt-3">Cấu hình</h6>
            <ul class="list-unstyled">
                <li>Part Number: 123456789</li>
                <li>Brand: Samsung</li>
                <li>Màu: Đen</li>
                <li>RAM: 12GB</li>
                <li>Bộ nhớ: 512GB</li>
            </ul>
        </div>
        <div class="quantity-prd d-flex gap-2 align-items-center justify-content-end ms-auto">
    <button class="btn border px-3 btn-decrease">-</button>
    <input type="text" class=" text-center quantity-input" value="1" min="1" style="width: 60px; border: none;">
    <button class="btn border px-3 btn-increase ">+</button>
</div>

        <div class="price-prd">
            <p class="fw-bold fs-5 mb-0">26.000.000 đ</p>
            <p class="text-end text-info mt-2" style="cursor: pointer;">Xóa</p>
        </div>
    </div>

    <hr class="text-muted">

    <!-- Tổng tiền -->
    <div class="total-mn w-50 ms-auto">
        <div class="total-1 d-flex justify-content-between align-items-center mb-2">
            <p class="fw-bold h5">Tổng phụ (Bao gồm VAT)</p>
            <p class="fw-bold h5">26.000.000 đ</p>
        </div>
        <p class="text-muted">Miễn phí vận chuyển toàn quốc</p>

        <div class="total">
            <hr>
            <div class="total-end d-flex justify-content-between align-items-center">
                <p class="fw-bold h4">Tổng (Bao gồm VAT)</p>
                <p class="fw-bold h4">26.000.000 đ</p>
            </div>
            <p class="text-muted">Trong đó VAT (10%): 2.400.000 đ</p>
        </div>
        <a href="?act=checkout" class="btn btn-info w-100 mt-3 text-white">Thanh Toán</a>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const btnDecrease = document.querySelector(".btn-decrease");
        const btnIncrease = document.querySelector(".btn-increase");
        const quantityInput = document.querySelector(".quantity-input");

        // Disable decrease button if value is 1
        function updateButtons() {
            btnDecrease.disabled = quantityInput.value <= 1;
        }

        // Decrease quantity
        btnDecrease.addEventListener("click", function () {
            if (quantityInput.value > 1) {
                quantityInput.value--;
                updateButtons();
            }
        });

        // Increase quantity
        btnIncrease.addEventListener("click", function () {
            quantityInput.value++;
            updateButtons();
        });

        // Update button state on load
        updateButtons();
    });
</script>