<?php
// Thêm debug
error_log("Loading OrderDetails.php view");
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Chi tiết đơn hàng #<?= htmlspecialchars($orderDetails[0]['order_id'] ?? '') ?></h1>
    </section>
    
    <section class="content">
        <div class="box">
            <div class="box-body">
                <?php if (!empty($orderDetails)): ?>
                <form method="post" action="?act=update_order_details">
                    <input type="hidden" name="order_id" value="<?= htmlspecialchars($orderDetails[0]['order_id'] ?? '') ?>">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Biến thể</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orderDetails as $detail): ?>
                                <tr>
                                    <td><?= htmlspecialchars($detail['product_name']) ?></td>
                                    <td><?= htmlspecialchars($detail['variant_name']) ?></td>
                                    <td><?= number_format($detail['price']) ?>đ</td>
                                    <td>
                                        <input type="number" name="quantity[<?= $detail['id'] ?>]" 
                                               value="<?= $detail['quantity'] ?>" 
                                               min="1" class="form-control" style="width: 100px">
                                    </td>
                                    <td><?= number_format($detail['price'] * $detail['quantity']) ?>đ</td>
                                    <td>
                                        <a href="?act=delete_order_detail&id=<?= $detail['id'] ?>&order_id=<?= $detail['order_id'] ?>" 
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                            Xóa
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Cập nhật số lượng</button>
                        <a href="?act=orders" class="btn btn-default">Quay lại</a>
                    </div>
                </form>
                <?php else: ?>
                    <p>Không tìm thấy chi tiết đơn hàng</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div> 