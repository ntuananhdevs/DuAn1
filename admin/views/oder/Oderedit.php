<div class="content-wrapper">
    <section class="content-header">
        <h1>Cập nhật đơn hàng</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thông tin đơn hàng</h3>
                    </div>
                    <form method="post" action="?act=update_oder">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($orderData['id']); ?>">
                        <div class="box-body">
                            <div class="form-group">
                                <label>User ID</label>
                                <input type="text" class="form-control" name="user_id" 
                                       value="<?php echo htmlspecialchars($orderData['user_id']); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Tên khách hàng</label>
                                <input type="text" class="form-control" name="guest_fullname" 
                                       value="<?php echo htmlspecialchars($orderData['guest_fullname']); ?>">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="guest_email" 
                                       value="<?php echo htmlspecialchars($orderData['guest_email']); ?>">
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="text" class="form-control" name="guest_phone" 
                                       value="<?php echo htmlspecialchars($orderData['guest_phone']); ?>">
                            </div>
                            <div class="form-group">
                                <label>Địa chỉ giao hàng</label>
                                <textarea class="form-control" name="shipping_address"><?php echo htmlspecialchars($orderData['shipping_address']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Tổng tiền</label>
                                <input type="number" class="form-control" name="total_amount" 
                                       value="<?php echo htmlspecialchars($orderData['total_amount']); ?>">
                            </div>
                            <div class="form-group">
                                <label>Phương thức thanh toán</label>
                                <select class="form-control" name="payment_method">
                                    <option value="cod" <?php echo $orderData['payment_method'] == 'cod' ? 'selected' : ''; ?>>COD</option>
                                    <option value="bank_transfer" <?php echo $orderData['payment_method'] == 'bank_transfer' ? 'selected' : ''; ?>>Chuyển khoản</option>
                                    <option value="momo" <?php echo $orderData['payment_method'] == 'momo' ? 'selected' : ''; ?>>Ví MoMo</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Trạng thái thanh toán</label>
                                <select class="form-control" name="payment_status" id="payment_status">
                                    <option value="unpaid" <?php echo $orderData['payment_status'] == 'unpaid' ? 'selected' : ''; ?>>Chưa thanh toán</option>
                                    <option value="paid" <?php echo $orderData['payment_status'] == 'paid' ? 'selected' : ''; ?>>Đã thanh toán</option>
                                    <option value="refunded" <?php echo $orderData['payment_status'] == 'refunded' ? 'selected' : ''; ?>>Đã hoàn tiền</option>
                                    <option value="failed" <?php echo $orderData['payment_status'] == 'failed' ? 'selected' : ''; ?>>Thanh toán thất bại</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Trạng thái vận chuyển</label>
                                <select class="form-control" name="shipping_status" id="shipping_status">
                                    <option value="pending" <?php echo $orderData['shipping_status'] == 'pending' ? 'selected' : ''; ?>>Chờ xử lý</option>
                                    <option value="in_transit" <?php echo $orderData['shipping_status'] == 'in_transit' ? 'selected' : ''; ?>>Đang giao hàng</option>
                                    <option value="delivered" <?php echo $orderData['shipping_status'] == 'delivered' ? 'selected' : ''; ?>>Đã giao hàng</option>
                                    <option value="returned" <?php echo $orderData['shipping_status'] == 'returned' ? 'selected' : ''; ?>>Đã trả hàng</option>
                                    <option value="cancelled" <?php echo $orderData['shipping_status'] == 'cancelled' ? 'selected' : ''; ?>>Đã hủy</option>
                                </select>
                            </div>
                        </div>
                        <div class="box-footer mt-4 mb-4">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="?act=orders" class="btn btn-default">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentStatus = document.getElementById('payment_status');
    const shippingStatus = document.getElementById('shipping_status');

    function handleStatusChange() {
        // Nếu phương thức thanh toán là COD
        if (paymentStatus.value === 'cod') {
            // Chỉ cho phép chọn "Đã giao hàng" hoặc "Đang giao hàng" nếu thanh toán đ�� được thực hiện
            if (paymentStatus.value === 'paid') {
                shippingStatus.value = shippingStatus.value === 'pending' ? 'in_transit' : shippingStatus.value; // Đặt trạng thái giao hàng là "Đang giao hàng" nếu đang chờ xử lý
            } else {
                alert('Để sử dụng phương thức COD, đơn hàng phải được thanh toán trước.');
                shippingStatus.value = 'pending'; // Đặt lại trạng thái giao hàng
            }
            return;
        }

        // Nếu trạng thái thanh toán là hoàn trả
        if (paymentStatus.value === 'refunded') {
            if (confirm('Bạn có muốn hoàn tiền cho đơn hàng này không?')) {
                shippingStatus.value = 'returned'; // Đặt trạng thái giao hàng là "Đã trả hàng"
            } else {
                paymentStatus.value = 'unpaid'; // Đặt lại trạng thái thanh toán nếu không xác nhận
            }
            return;
        }

        // Nếu trạng thái thanh toán là thất bại
        if (paymentStatus.value === 'failed') {
            shippingStatus.value = 'cancelled'; // Đặt trạng thái giao hàng là "Đã hủy"
            return;
        }

        // Nếu trạng thái thanh toán là đã hoàn thành
        if (paymentStatus.value === 'paid') {
            if (shippingStatus.value === 'pending' || shippingStatus.value === 'undefined') {
                shippingStatus.value = 'in_transit'; // Đặt trạng thái giao hàng là "Đang giao hàng"
            }
            return;
        }

        // Kiểm tra điều kiện giao hàng
        if (shippingStatus.value === 'delivered' && paymentStatus.value !== 'paid') {
            alert('Trạng thái vận chuyển không thể là "Đã giao hàng" khi đơn hàng chưa thanh toán!');
            shippingStatus.value = 'in_transit'; // Đặt lại trạng thái giao hàng
        }
    }

    shippingStatus.addEventListener('change', handleStatusChange);
    paymentStatus.addEventListener('change', handleStatusChange);
});
</script>
