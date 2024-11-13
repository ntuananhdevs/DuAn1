<h1 class="text-center my-4">Danh sách giảm giá</h1>
<a href="?act=add-discount" class="btn btn-primary mb-3">Thêm giảm giá mới</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Loại giảm giá</th>
            <th>Phần giảm giá</th>
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
            <td><?= $discount['DiscountType'] == 'percentage' ? 'Phần trăm' : 'Tiền mặt' ?></td>
            <td>
                <?php 
        // Kiểm tra loại giảm giá và thêm ký tự VNĐ hoặc %
        if ($discount['DiscountType'] == 'percentage') {
            echo $discount['DiscountValue'] . '%';
        } else {
            // Ép kiểu DiscountValue thành float trước khi định dạng
            $discountValue = floatval(str_replace(',', '', $discount['DiscountValue'])); // Loại bỏ dấu phẩy nếu có
            echo number_format($discountValue, 0, ',', '.') . ' VNĐ';
        }
    ?>
            </td>
            <td><?= date('Y-m-d', strtotime($discount['StartDate'])) ?></td>
            <td><?= date('Y-m-d', strtotime($discount['EndDate'])) ?></td>
            <td><?= (int)$discount['Status'] == 1 ? 'Hoạt động' : 'Không Hoạt Động' ?></td>


            <td>
                <a href="?act=edit-discount&id=<?= $discount['DiscountID'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                <a href="?act=delete-discount&id=<?= $discount['DiscountID'] ?>" class="btn btn-danger btn-sm"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>