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
                    <form method="post" action="?act=update_oder&id=<?php echo htmlspecialchars($orderData['id']); ?>">
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
                                <input type="text" class="form-control" name="shipping_address" 
                                       value="<?php echo htmlspecialchars($orderData['shipping_address']); ?>">
                            </div>
                            <div class="form-group">
                                <label>Ngày đặt hàng</label>
                                <input type="datetime-local" class="form-control" name="order_date" 
                                       value="<?php echo date('Y-m-d\TH:i', strtotime($orderData['order_date'])); ?>">
                            </div>

                            <div class="form-group">
                                <label>Tổng tiền</label>
                                <input type="number" class="form-control" name="total_amount" 
                                       value="<?php echo htmlspecialchars($orderData['total_amount']); ?>">
                            </div>

                            <div class="form-group">
                                <label>Phương thức thanh toán</label>
                                <select class="form-control" name="payment_method">
                                    <option value="cod" <?php echo $orderData['payment_method'] == 'cod' ? 'selected' : ''; ?>>Thanh toán khi nhận hàng</option>
                                    <option value="bank_transfer" <?php echo $orderData['payment_method'] == 'bank_transfer' ? 'selected' : ''; ?>>Chuyển khoản</option>
                                    <option value="momo" <?php echo $orderData['payment_method'] == 'momo' ? 'selected' : ''; ?>>Ví MoMo</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Trạng thái thanh toán</label>
                                <select class="form-control" name="payment_status">
                                    <option value="pending" <?php echo $orderData['payment_status'] == 'pending' ? 'selected' : ''; ?>>Chờ thanh toán</option>
                                    <option value="completed" <?php echo $orderData['payment_status'] == 'completed' ? 'selected' : ''; ?>>Đã thanh toán</option>
                                    <option value="failed" <?php echo $orderData['payment_status'] == 'failed' ? 'selected' : ''; ?>>Thanh toán thất bại</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Ngày thanh toán</label>
                                <input type="datetime-local" class="form-control" name="payment_date" 
                                       value="<?php echo $orderData['payment_date'] ? date('Y-m-d\TH:i', strtotime($orderData['payment_date'])) : ''; ?>">
                            </div>

                            <div class="form-group">
                                <label>Trạng thái vận chuyển</label>
                                <select class="form-control" name="shipping_status">
                                    <option value="pending" <?php echo $orderData['shipping_status'] == 'pending' ? 'selected' : ''; ?>>Đang xử lý</option>
                                    <option value="shipping" <?php echo $orderData['shipping_status'] == 'shipping' ? 'selected' : ''; ?>>Đang giao hàng</option>
                                    <option value="delivered" <?php echo $orderData['shipping_status'] == 'delivered' ? 'selected' : ''; ?>>Đã giao hàng</option>
                                    <option value="cancelled" <?php echo $orderData['shipping_status'] == 'cancelled' ? 'selected' : ''; ?>>Đã hủy</option>
                                </select>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="?act=oders" class="btn btn-default">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
