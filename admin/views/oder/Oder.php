<?php ob_start() ?>
<div class="container">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0 h4 font-weight-bolder">Đơn hàng</h3>
    </div>
    <form action="" method="GET" class="d-flex w-20">
        <input type="hidden" name="act" value="orders">
        <input type="text" class="form-control mb-1" style="border-radius: 4px 0 0 4px  ; height: 36px;" id="search" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
        <button type="submit" class="btn btn-primary " style="border-radius: 0 4px 4px 0; "><ion-icon name="search"></ion-icon></button>
    </form>
    <table class="table table-hover" id="dataTable">
        <thead class="thead-light">
            <tr>
                <th>Mã đơn hàng</th>
                <th>Khách hàng</th>
                <th>SĐT</th>
                <th>Tổng tiền</th>
                <th>Hình Thức Thanh Toán</th>
                <th>Trạng thái thanh toán</th>
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
                    <td>
                        <?php
                        switch($order['payment_method']) {
                            case 'COD': 
                                echo '<span class="badge bg-primary">Thanh toán khi nhận hàng</span>';
                                break;
                            case 'MOMO':
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
                            case 'unpaid':
                                echo '<span class="badge bg-warning">Chưa thanh toán</span>';
                                break;
                            case 'paid':
                                echo '<span class="badge bg-success">Đã thanh toán</span>';
                                break;
                            case 'refunded':
                                echo '<span class="badge bg-info">Đã hoàn tiền</span>';
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
                            case 'in_transit':
                                echo '<span class="badge bg-primary">Đang giao hàng</span>';
                                break;
                            case 'delivered':
                                echo '<span class="badge bg-success">Đã giao hàng</span>';
                                break;
                            case 'returned':
                                echo '<span class="badge bg-info">Đã trả hàng</span>';
                                break;
                            case 'cancelled':
                                echo '<span class="badge bg-danger">Đã hủy</span>';
                                break;
                            case 'return_requested':
                                echo '<span class="badge bg-danger">Đã yêu cầu trả hàng</span>';
                                break;
                            case 'return_in_process':
                                echo '<span class="badge bg-info">Đang chờ trả hàng</span>';
                                break;
                            case 'return_completed':
                                echo '<span class="badge bg-secondary">Đã hoàn hàng</span>';
                                break;
                            case 'return_failed':
                                echo '<span class="badge bg-danger">Hoa don that bai</span>';
                                break;
                            default:
                                echo '<span class="badge bg-secondary">Không xác định</span>';
                                break;
                        }
                        ?>
                    </td>
                    <td>
                        <?php if($order['payment_status'] == 'paid' && $order['shipping_status'] == 'delivered'): ?>
                            <a href="?act=print_bill&id=<?= $order['id'] ?>" class="btn btn-success">In</a>
                        <?php endif; ?>
                        <a href="?act=view_details&id=<?= $order['id'] ?>" class="btn btn-primary">
                            Details
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>