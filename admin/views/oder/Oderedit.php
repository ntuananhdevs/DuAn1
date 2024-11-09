
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
                    <form method="post" action="?act=update_oder&id=<?= $orderData['id'] ?? '' ?>">
                        <input type="hidden" name="id" value="<?= $orderData['id'] ?? '' ?>">
                        <div class="box-body">
                            <div class="form-group">
                                <label>User ID</label>
                                <input type="text" class="form-control" name="user_id" 
                                       value="<?= $orderData['user_id'] ?? '' ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="guest_email" 
                                       value="<?= $orderData['guest_email'] ?? '' ?>">
                            </div>

                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="text" class="form-control" name="guest_phone" 
                                       value="<?= $orderData['guest_phone'] ?? '' ?>">
                            </div>

                            <div class="form-group">
                                <label>Địa chỉ giao hàng</label>
                                <input type="text" class="form-control" name="shipping_address" 
                                       value="<?= $orderData['shipping_address'] ?? '' ?>">
                            </div>

                            <div class="form-group">
                                <label>Tổng tiền</label>
                                <input type="number" class="form-control" name="total_amount" 
                                       value="<?= $orderData['total_amount'] ?? 0 ?>">
                            </div>

                            <div class="form-group">
                                <label>Phương thức thanh toán</label>
                                <select class="form-control" name="payment_method">
                                    <option value="cod" <?= ($orderData['payment_method'] ?? '') == 'cod' ? 'selected' : '' ?>>
                                        Thanh toán khi nhận hàng
                                    </option>
                                    <option value="bank_transfer" <?= ($orderData['payment_method'] ?? '') == 'bank_transfer' ? 'selected' : '' ?>>
                                        Chuyển khoản
                                    </option>
                                    <option value="momo" <?= ($orderData['payment_method'] ?? '') == 'momo' ? 'selected' : '' ?>>
                                        Ví MoMo
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Trạng thái thanh toán</label>
                                <select class="form-control" name="payment_status">
                                    <option value="pending" <?= ($orderData['payment_status'] ?? '') == 'pending' ? 'selected' : '' ?>>
                                        Chờ thanh toán
                                    </option>
                                    <option value="completed" <?= ($orderData['payment_status'] ?? '') == 'completed' ? 'selected' : '' ?>>
                                        Đã thanh toán
                                    </option>
                                    <option value="failed" <?= ($orderData['payment_status'] ?? '') == 'failed' ? 'selected' : '' ?>>
                                        Thanh toán thất bại
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Trạng thái vận chuyển</label>
                                <select class="form-control" name="shipping_status">
                                    <option value="pending" <?= ($orderData['shipping_status'] ?? '') == 'pending' ? 'selected' : '' ?>>
                                        Đang xử lý
                                    </option>
                                    <option value="shipped" <?= ($orderData['shipping_status'] ?? '') == 'shipped' ? 'selected' : '' ?>>
                                        Đang giao hàng
                                    </option>
                                    <option value="delivered" <?= ($orderData['shipping_status'] ?? '') == 'delivered' ? 'selected' : '' ?>>
                                        Đã giao hàng
                                    </option>
                                    <option value="canceled" <?= ($orderData['shipping_status'] ?? '') == 'canceled' ? 'selected' : '' ?>>
                                        Đã hủy
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="?act=orders" class="btn btn-default">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
