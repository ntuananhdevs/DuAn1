<div class="container">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0 h4 font-weight-bolder">Đơn hàng</h3>
    </div>
    <table class="table table-hover" id="dataTable">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Email</th>
                <th>SĐT</th>
                <th>Tổng tiền</th>
                <th>Địa chỉ</th>
                <th>Phương Thức Thanh Toán</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= $order['user_name'] ?? $order['guest_fullname'] ?></td>
                    <td><?= $order['guest_email'] ?></td>
                    <td><?= $order['guest_phone'] ?></td>
                    <td><?= number_format($order['total_amount']) ?>đ</td>
                    <td><?= $order['shipping_address'] ?></td> 
                    <td>
                        <?php
                        $paymentMethod = '';
                        switch($order['payment_method']) {
                            case 'cash': 
                                echo '<span class="badge bg-primary">Tiền mặt</span>';
                                break;
                            case 'bank_transfer':
                                echo '<span class="badge bg-info">Chuyển khoản</span>';
                                break;
                            case 'ship_cod':
                                echo '<span class="badge bg-secondary">Ship COD</span>';
                                break;
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if($order['payment_status'] == 'completed' && $order['shipping_status'] == 'delivered') {
                            echo '<span class="badge bg-success">Đã giao hàng</span>';
                        } elseif($order['payment_status'] == 'pending') {
                            echo '<span class="badge bg-warning">Chưa xử lý</span>';
                        }
                        ?>
                    </td>
                    <td>
                        <?php if($order['payment_status'] == 'completed' && $order['shipping_status'] == 'delivered'): ?>
                            <a href="?act=print_bill&id=<?= $order['id'] ?>" class="btn btn-success">In</a>
                        <?php else: ?>
                            <a href="?act=edit_oder&id=<?= $order['id'] ?>" class="btn btn-warning">Sửa</a>
                            <a href="?act=delete-oder&id=<?= $order['id'] ?>" 
                               class="btn btn-danger"
                               onclick="return confirm('Bạn có chắc muốn xóa đơn hàng này?')">Xóa</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>