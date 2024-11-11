
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin người dùng</h6>
                </div>
                <div class="card-body">
                    <form action="index.php?act=edit-user-post&id=<?= $user['id'] ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Tên đăng nhập</label>
                            <div class="col-sm-9">
                                <input type="text" name="user_name" class="form-control" 
                                       value="<?= $user['user_name'] ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control" 
                                       value="<?= $user['email'] ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Số điện thoại</label>
                            <div class="col-sm-9">
                                <input type="text" name="phone_number" class="form-control" 
                                       value="<?= $user['phone_number'] ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Avatar</label>
                            <div class="col-sm-9">
                                <?php if(!empty($user['avatar'])): ?>
                                    <img src="<?= $user['avatar'] ?>" alt="Current avatar" style="width: 100px; margin-bottom: 10px;">
                                <?php endif; ?>
                                <input type="file" name="avatar" class="form-control" accept="image/*">
                                <input type="hidden" name="old_avatar" value="<?= $user['avatar'] ?>">
                            </div>
                        </div>
                        <div class="form-group row ">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="fas fa-save"></i> Cập nhật
                                </button>
                                <a href="index.php?act=users" class="btn btn-secondary mt-3 ">
                                    <i class="fas fa-times"></i> Hủy
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
