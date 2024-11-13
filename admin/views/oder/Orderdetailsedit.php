<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Sửa Chi Tiết Đơn Hàng #<?= $order['order_info']['id'] ?></h1>

    <form action="?act=update_order_details" method="POST">
        <input type="hidden" name="order_id" value="<?= $order['order_info']['id'] ?>">
        
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Thông Tin Sản Phẩm</h6>
            </div>
            <div class="card-body">
                <?php foreach ($order['products'] as $value => $product): ?>
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <?php if (!empty($product['variant_img']['img'])): ?>
                                <img src="<?= htmlspecialchars($product['variant_img']['img']) ?>" 
                                     class="img-fluid" 
                                     alt="<?= htmlspecialchars($product['product_name']) ?>">
                            <?php else: ?>
                                <img src="<?= htmlspecialchars($product['product_img']) ?>" 
                                     class="img-fluid"
                                     alt="<?= htmlspecialchars($product['product_name']) ?>">
                            <?php endif; ?>
                        </div>
                        <div class="col-md-10">
                            <h5><?= htmlspecialchars($product['product_name'] ?? 'Tên sản phẩm không xác định') ?></h5>
                            <div class="form-group">
                                <label>Màu sắc:</label>
                                <input type="text" 
                                       class="form-control" 
                                       name="products[<?= $value ?>][color]" 
                                       value="<?= htmlspecialchars($product['color'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label>RAM (GB):</label>
                                <input type="text"
                                       class="form-control"
                                       name="products[<?= $value ?>][ram]" 
                                       value="<?= htmlspecialchars($product['ram'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label>Bộ nhớ (GB):</label>
                                <input type="text" 
                                       class="form-control" 
                                       name="products[<?= $value ?>][storage]" 
                                       value="<?= htmlspecialchars($product['storage'] ?? '') ?>">
                            </div>
                            <input type="hidden" name="products[<?= $value ?>][variant_id]" value="<?= htmlspecialchars($product['variant_id'] ?? '') ?>">
                            <input type="hidden" name="products[<?= $value ?>][price]" value="<?= htmlspecialchars($product['price'] ?? 0) ?>">
                            
                            <div class="form-group">
                                <label>Số lượng:</label>
                                <input type="number" 
                                       class="form-control" 
                                       name="products[<?= $value ?>][quantity]" 
                                       value="<?= htmlspecialchars($product['quantity'] ?? 1) ?>" 
                                       min="1">
                            </div>
                            <p>Giá: <?= number_format($product['price'] ?? 0) ?> VNĐ</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="text-center mb-4">
            <button type="submit" class="btn btn-primary">Cập Nhật</button>
            <a href="?act=order_details&id=<?= $order['order_info']['id'] ?>" class="btn btn-secondary">Quay Lại</a>
        </div>
    </form>
</div>

