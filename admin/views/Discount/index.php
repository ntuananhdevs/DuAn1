<h1>Danh sách giảm giá</h1>
<a href="index.php?controller=discount&action=add">Thêm giảm giá mới</a>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Loại giảm giá</th>
            <th>Giá trị giảm giá</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($discounts as $discount): ?>
            <tr>
                <td><?= $discount['DiscountID'] ?></td>
                <td><?= $discount['ProductName'] ?></td>
                <td><?= $discount['DiscountType'] ?></td>
                <td><?= $discount['DiscountValue'] ?></td>
                <td><?= $discount['StartDate'] ?></td>
                <td><?= $discount['EndDate'] ?></td>
                <td><?= $discount['Status'] == 1 ? 'Active' : 'Inactive' ?></td>
                <td>
                    <a href="index.php?controller=discount&action=edit&id=<?= $discount['DiscountID'] ?>">Sửa</a>
                    <a href="index.php?controller=discount&action=delete&id=<?= $discount['DiscountID'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
