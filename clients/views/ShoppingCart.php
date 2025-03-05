<?php
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $sessionId = null;
} else {
    $userId = null;
    $sessionId = session_id();
}
$cart = new ShoppingCartController(new ShoppingCart());
$cart_item = $cart->getCartItems($userId, $sessionId);
?>
<div class="container mb-5">
    <h4 class="mb-0 fw-bold mb-4 mt-4">Giỏ mua hàng</h4>

    <!-- Phần sản phẩm -->
    <?php foreach ($cart_item as $item): ?>
        <hr class="text-muted">
        <div class="boxproducts d-flex gap-4 justify-content-start align-items-start mb-4" style="width: 80%; margin: auto;">
            <div class="img-prd ">
                <img src="<?php echo removeLeadingDots($item['img']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" width="120px">
            </div>
            <div class="spect-prd ms-4">
                <h4 class="fw-bold fs-5 mb-2 "><?php echo htmlspecialchars($item['product_name']); ?> <?php echo htmlspecialchars($item['color']); ?> <?php echo htmlspecialchars($item['storage']); ?></h4>
                <h6 class="fw-bold">Cấu hình</h6>
                <ul class="list-unstyled ms-2">
                    <li><strong>Brand: </strong> <?php echo htmlspecialchars($item['category_name']); ?></li>
                    <li><strong>Mau sắc: </strong><?php echo htmlspecialchars($item['color']); ?></li>
                    <li><strong>RAM: </strong><?php echo htmlspecialchars($item['ram']); ?></li>
                    <li><strong>Bộ nhớ: </strong><?php echo htmlspecialchars($item['storage']); ?></li>
                </ul>
            </div>
            <div class="quantity-prd d-flex gap-2 align-items-center justify-content-end ms-auto">
                <form action="?act=update_cart" method="POST" class="d-flex align-items-center">
                    <input type="hidden" name="product_id" value="<?php echo $item['variant_id']; ?>">

                    <button type="submit" name="action" value="decrease" class="btn border px-3 me-3">-</button>

                    <input type="number" name="quantity" class="text-center quantity-input fs-3" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1" style="width: 50px; border: none; background-color: #fcfcfc;" readonly>

                    <button type="submit" name="action" value="increase" class="btn border px-3">+</button>
                </form>

            </div>
            <?php if (isset($_SESSION['error'])): ?>
    <div id="alertMessage" class="alert alert-danger alert-dismissible slide-in position-fixed end-0 m-3 custom-error" role="alert" style="z-index: 99999; max-width: 400px; top: 10px;">
        <div class="d-flex align-items-center">
            <div class="icon-container me-2">
            <ion-icon name="alert-circle-outline" size="large"></ion-icon>
                </div>
            <div class="message-container flex-grow-1 text-white">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
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

            <div class="price-prd">
                <p class="fw-bold fs-5 mb-0" data-unit-price="<?php echo $item['price']; ?>">
                    <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> đ
                </p>

                <a href="?act=delete_items&cart_item_id=<?php echo $item['cart_item_id']; ?>" class="text-end text-info fw-550 d-block text-right" style="text-decoration: none;" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">Xóa</a>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Tổng tiền -->
    <hr class="text-muted">
    <div class="total-mn ms-auto" style="width: 450px;">
        <div class="total-1 d-flex justify-content-between align-items-center mb-2">
            <p class="fw-bold h5">Tổng phụ</p>
            <?php
            $total = 0;
            foreach ($cart_item as $item) {
                $total += $item['price'] * $item['quantity'];
            }
            ?>
            <p class="fw-bold h5 tongphu"><?php echo number_format($total, 0, ',', '.'); ?> đ</p>
        </div>
        <p class="text-muted ms-3">Miễn phí vận chuyển toàn quốc</p>

        <div class="total">
            <hr>
            <?php
            $total = 0;
            $vat = 0;
            foreach ($cart_item as $item) {
                $total += $item['price'] * $item['quantity'];
                $vat += $item['price'] * $item['quantity'] * 0.1;
            }
            ?>
            <div class="total-end d-flex justify-content-between align-items-center">
                <p class="fw-bold h4">Tổng (Bao gồm VAT)</p>
                <p class="fw-bold h4 tong"><?php echo number_format($total + $vat, 0, ',', '.'); ?> đ</p>
            </div>
            <p class="text-muted ms-3">Trong đó VAT (10%): <?php echo number_format($vat, 0, ',', '.'); ?> đ</p>
        </div>
        <a href="?act=pay" class="btn btn-info w-100 mt-3 text-white">Thanh Toán</a>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const btnDecrease = document.querySelectorAll(".btn-decrease");
        const btnIncrease = document.querySelectorAll(".btn-increase");
        const quantityInputs = document.querySelectorAll(".quantity-input");
        const totalDisplay = document.querySelector(".total-end .tong");
        const vatDisplay = document.querySelector(".total .text-muted");
        const subtotalDisplay = document.querySelector(".total-1  .tongphu");

        function formatCurrency(value) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(value);
        }

        // Update total and subtotal
        function updateTotals() {
            let subtotal = 0;
            let vat = 0;

            quantityInputs.forEach((input, index) => {
                const quantity = parseInt(input.value);
                const priceElement = btnIncrease[index].closest(".boxproducts").querySelector(".price-prd p.fw-bold");
                const unitPrice = parseInt(priceElement.dataset.unitPrice);

                const totalPrice = quantity * unitPrice;
                subtotal += totalPrice;

                // Update product price
                priceElement.textContent = formatCurrency(totalPrice);
            });

            vat = subtotal * 0.1; // VAT is 10%
            totalDisplay.textContent = formatCurrency(subtotal + vat);
            vatDisplay.textContent = `Trong đó VAT (10%): ${formatCurrency(vat)}`;
            subtotalDisplay.textContent = formatCurrency(subtotal);
        }

        // Attach events to buttons
        btnDecrease.forEach((button, index) => {
            button.addEventListener("click", function() {
                const input = quantityInputs[index];
                if (input.value > 1) {
                    input.value--;
                    updateTotals();
                }
            });
        });

        btnIncrease.forEach((button, index) => {
            button.addEventListener("click", function() {
                const input = quantityInputs[index];
                input.value++;
                updateTotals();
            });
        });
        updateTotals();
    });
</script>

    
<style>
    .custom-error {
    background-color: #dc3545; 
    color: #ffffff; 
    border: none; 
    border-radius: 10px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); 
    padding: 10px 15px; 
    animation: slideIn 0.5s ease-out; 
}

.custom-error .icon-container {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    width: 40px;
    height: 40px;
}

.custom-error .message-container {
    font-size: 14px; 
    line-height: 1.5; 
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

</style>

