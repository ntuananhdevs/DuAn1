<div class="container">
    <h3 class="mb-0 h4 font-weight-bolder mb-4">Comments for Product</h3>
    <table class="table table-hover">
        <thead class="text-left">
            <tr>
                <th scope="col">Comment ID</th>
                <th scope="col">Người Bình Luận</th>
                <th scope="col">Nội Dung Bình Luận</th>
                <th scope="col">Thích</th>
                <th scope="col">Không Thích</th>
                <th scope="col">Ngày Tạo</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody class="text-left">
            <?php foreach ($comments as $comment): ?>
                <tr>
                    <td><?= htmlspecialchars($comment['ID']); ?></td>
                    <td><?= htmlspecialchars($comment['User']); ?></td>
                    <td><?= htmlspecialchars($comment['Content']); ?></td>
                    <td><?= htmlspecialchars($comment['Likes']); ?></td>
                    <td><?= htmlspecialchars($comment['DisLikes']); ?></td>
                    <td><?= htmlspecialchars($comment['Ngay_Tao']); ?></td>
                    <td>
                        <a href="index.php?act=view_edit&id=<?= $comment['ID']; ?>" class="btn btn-warning">Edit</a>
                        <a href="index.php?act=delete&id=<?=  $comment['ID']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc là muôn xóa bình luận này không ?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
