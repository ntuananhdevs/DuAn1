<div class="container">
    <h3 class="mb-0 h4 font-weight-bolder mb-4">Comments</h3>
        <table class="table table-hover">
            <thead class="text-left">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tên Sản phẩm</th>
                    <th scope="col">Người dùng</th>
                    <th scope="col">Nội dung</th>
                    <th scope="col">Số Lượng</th>
                    <th scope="col">Thích</th>
                    <th scope="col">Không thích</th>
                    <th scope="col">Ngày tạo</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody class="text-left">
                    <?php foreach ($comments as  $key => $value): ?>
                        <tr>
                            <th scope="row"><?= $value['ID']; ?></th>
                            <td><?= htmlspecialchars($value['Name_Product']); ?></td>                           
                            <td><?= htmlspecialchars($value['User']); ?></td>
                            <td><?= htmlspecialchars($value['Content']); ?></td>
                            <td><?= $value['So_Luong']; ?></td>
                            <td><?= $value['Likes']; ?></td>
                            <td><?= $value['DisLikes']; ?></td>
                            <td><?= $value['Ngay_Tao']; ?></td>
                            <td>
                                <a href="index.php?act=edit&id=<?= $value['ID']; ?>" class="btn btn-warning">Sửa</a>
                                <a href="index.php?act=delete&id=<?= $value['ID']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa bình luận này?')">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
    </div>

