<div class="container">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0 h4 font-weight-bolder ">Users</h3>
    </div>
    <div class="search-form d-flex gap-3 align-items-center">
        <a href="?act=add-user" class=" btn  btn-primary ">
            Thêm mới
        </a>
        <form action="" method="GET" class="d-flex">
            <input type="hidden" name="act" value="users">
            <input type="text" class="form-control mb-1" style="border-radius: 4px 0 0 4px  ; height: 36px;" id="search" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
            <button type="submit" class="btn btn-primary " style="border-radius: 0 4px 4px 0; "><ion-icon name="search"></ion-icon></button>
        </form>
    </div>
    <table class="table  table-hover" id="dataTable" cellspacing="0">
        <thead class="thead-light">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Ảnh đại diện</th>
                <th scope="col">Tên đăng nhập</th>
                <th scope="col">Email</th>
                <th scope="col">Quyền</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Ngày tạo</th>
                <th scope="col">Ngày Sửa</th>
                <th width="150">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $search = $_GET['search'] ?? '';
            if ($search) {
                $users = $this->userModel->getBySearch($search);
            } else {
                $users = $this->userModel->getAll();
            }
            ?>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="9" class="text-center">Không tìm thấy người dùng nào.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><img src="<?= $user['avatar'] ?>" style="width: 50px; height: 50px; border-radius: 100%;" alt=""></td>
                        <td><?= $user['user_name'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['role'] ?></td>
                        <td><?= $user['phone_number'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($user['updated_at'])) ?></td>
                        <td>
                            <a href="?act=edit-user&id=<?= $user['id'] ?>"
                            class="btn btn-warning ">
                            Sửa
                        </a>
                        <a href="?act=delete-user&id=<?= $user['id'] ?>"
                        class="btn btn-danger "
                        onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                        Xóa
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</div>
</div>