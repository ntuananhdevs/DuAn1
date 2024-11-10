<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Chi tiết đơn hàng #<?= $order['id'] ?></h6>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Thông tin khách hàng</h5>
                    <p>Tên: <?= $order['customer_name'] ?></p>
                    <p>Email: <?= $order['email'] ?></p>
                    <p>SĐT: <?= $order['phone'] ?></p>
                    <p>Địa chỉ: <?= $order['address'] ?></p>
                </div>
                <div class="col-md-6">
                    <h5>Thông tin đơn hàng</h5>
                    <p>Ngày đặt: <?= $order['created_at'] ?></p>
                    <p>Trạng thái: <?= $order['status'] ?></p>
                    <p>Tổng tiền: <?= number_format($order['total_amount']) ?>đ</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Biến thể</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderDetails as $item): ?>
                        <tr>
                            <td><?= $item['product_name'] ?></td>
                            <td><?= $item['variant_name'] ?></td>
                            <td><?= number_format($item['price']) ?>đ</td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= number_format($item['price'] * $item['quantity']) ?>đ</td>
                            <td>
                                <a href="?act=edit_order_item&id=<?= $item['id'] ?>" class="btn btn-sm btn-primary">Sửa</a>
                                <a href="?act=delete_order_item&id=<?= $item['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
