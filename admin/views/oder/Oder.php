<div class="container">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0 h4 font-weight-bolder">Đơn hàng</h3>
    </div>
    <table class="table table-hover" id="dataTable">
        <thead class="thead-light">
            <tr>
                <th>Mã đơn hàng</th>
                <th>Khách hàng</th>
                <th>SĐT</th>
                <th>Tổng tiền</th>
                <th>Địa chỉ</th>
                <th>Hình Thức Thanh Toán</th>
                <th>Trạng thái</th>
                <th>Trạng thái giao hàng</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= $order['user_name'] ?? $order['guest_fullname'] ?></td>
                    <td><?= $order['guest_phone'] ?></td>
                    <td><?= number_format($order['total_amount']) ?>đ</td>
                    <td><?= $order['shipping_address'] ?></td> 
                    <td>
                        <?php
                        switch($order['payment_method']) {
                            case 'cod': 
                                echo '<span class="badge bg-primary">Thanh toán khi nhận hàng</span>';
                                break;
                            case 'momo':
                                echo '<span class="badge bg-danger">Thanh toán MoMo</span>';
                                break;
                            case 'bank_transfer':
                                echo '<span class="badge bg-info">Chuyển khoản ngân hàng</span>';
                                break;
                            default:
                                echo '<span class="badge bg-secondary">Không xác định</span>';
                                break;
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        switch($order['payment_status']) {
                            case 'completed':
                                echo '<span class="badge bg-success">Đã thanh toán</span>';
                                break;
                            case 'pending':
                                echo '<span class="badge bg-warning">Chờ thanh toán</span>';
                                break;
                            case 'failed':
                                echo '<span class="badge bg-danger">Thanh toán thất bại</span>';
                                break;
                            default:
                                echo '<span class="badge bg-secondary">Không xác định</span>';
                                break;
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        switch($order['shipping_status']) {
                            case 'pending': 
                                echo '<span class="badge bg-warning">Chờ xử lý</span>';
                                break;
                            case 'shipping':
                                echo '<span class="badge bg-primary">Đang giao hàng</span>';
                                break;
                            case 'delivered':
                                echo '<span class="badge bg-success">Đã giao hàng</span>';
                                break;
                            case 'cancelled':
                                echo '<span class="badge bg-danger">Đã hủy</span>';
                                break;
                            default:
                                echo '<span class="badge bg-secondary">Không xác định</span>';
                                break;
                        }
                        ?>
                    </td>
                    <td>
                        <?php if($order['payment_status'] == 'completed' && $order['shipping_status'] == 'delivered'): ?>
                            <a href="?act=print_bill&id=<?= $order['id'] ?>" class="btn btn-success">In</a>
                        <?php else: ?>
                            <a href="?act=edit_oder&id=<?= $order['id'] ?>" class="btn btn-warning">Sửa</a>
                            <a href="?act=delete_oder&id=<?= $order['id'] ?>" 
                               class="btn btn-danger"
                               onclick="return confirm('Bạn có chắc muốn xóa đơn hàng này?')">Xóa</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>