<div class="container">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0 h4 font-weight-bolder ">Users</h3>
    </div>
    <a href="?act=add-user" class=" btn  btn-primary ">
     Thêm mới
    </a>
    <table class="table  table-hover" id="dataTable" cellspacing="0">
        <thead class="thead-light">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên đăng nhập</th>
                <th scope="col">Email</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Ngày tạo</th>
                <th scope="col">Ngày Sửa</th>
                <th width="150">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['user_id'] ?></td>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['phone_number'] ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($user['updated_at'])) ?></td>
                    <td>
                        <a href="?act=edit-user&id=<?= $user['user_id'] ?>"
                            class="btn btn-warning ">
                            Sửa
                        </a>
                        <a href="?act=delete-user&id=<?= $user['user_id'] ?>"
                            class="btn btn-danger "
                            onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                            Xóa
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>