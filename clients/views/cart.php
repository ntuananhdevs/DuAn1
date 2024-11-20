<div id="cart-dropdown" style="position: relative;">
    <div class="cart-items">
        <?php if (!empty($cart_items)): ?>
            <?php foreach ($cart_items as $item): ?>
                <div class="cart-item">
                    <img src="<?= $item['images'] ?>" alt="<?= $item['product_name'] ?>" style="width: 50px; height: 50px;">
                    <div class="cart-item-info">
                        <h4><?= $item['product_name'] ?></h4>
                        <p>Số lượng: <?= $item['quantity'] ?></p>
                        <p>Giá: <?= number_format($item['price'], 0, ',', '.') ?> VND</p>
                    </div>
                </div>
            <?php endforeach; ?>
            <hr>
            <div class="cart-total">
                <p><strong>Tổng số lượng:</strong> <?= $total_quantity ?></p>
                <p><strong>Tổng giá:</strong> <?= number_format($total_price, 0, ',', '.') ?> VND</p>
            </div>
        <?php else: ?>
            <p>Giỏ hàng trống.</p>
        <?php endif; ?>
    </div>
</div>
