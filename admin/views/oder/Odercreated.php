<div class="content-wrapper">
    <section class="content-header">
        <h1>Thêm đơn hàng mới</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thông tin đơn hàng</h3>
                    </div>
                    <form role="form" method="post" action="admin/oder/created" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Tên khách hàng</label>
                                <input type="text" class="form-control" name="fullname" required>
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="text" class="form-control" name="phone" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                            <div class="form-group">
                                <label>Địa chỉ</label>
                                <textarea class="form-control" name="address" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Ghi chú</label>
                                <textarea class="form-control" name="note"></textarea>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Tạo đơn hàng</button>
                            <a class="btn btn-default" href="admin/oder">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
