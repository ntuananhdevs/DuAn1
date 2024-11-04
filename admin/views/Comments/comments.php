<div class="container">
    <h3 class="mb-0 h4 font-weight-bolder mb-4">Comment Counts by Product</h3>
    <table class="table table-hover">
        <thead class="text-left">
            <tr>
                <th scope="col">Product ID</th>
                <th scope="col">Tên Sản phẩm</th>
                <th scope="col">Số Lượng Bình Luận</th>
                <th scope="col">Nội Dung Bình Luận Gần Nhất</th>
                <th scope="col">Ngày Bình Luận Gần Nhất</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody class="text-left">
            <?php foreach ($commentCounts as $comment): ?>
                <tr>
                    <td><?= htmlspecialchars($comment['Product_ID']); ?></td>
                    <td><?= htmlspecialchars($comment['Name_Product']); ?></td>
                    <td><?= htmlspecialchars($comment['Comment_Count']); ?></td>
                    <td><?= htmlspecialchars($comment['Latest_Comment_Content']); ?></td>
                    <td><?= htmlspecialchars($comment['Last_Comment_Date']); ?></td>


                    <td>
                        <a href="index.php?act=view_comments&product_id=<?= $comment['Product_ID']; ?>" class="btn btn-primary">View Comments</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
