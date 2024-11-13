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
        <?php
        $currentDateTime = date('Y-m-d H:i:s'); // Lấy thời gian hiện tại
        foreach ($discounts as $discount):
            $status = 'pending'; // Mặc định trạng thái là pending
            if ($currentDateTime >= $discount['StartDate'] && $currentDateTime <= $discount['EndDate']) {
                $status = 'active'; // Nếu đang trong thời gian giảm giá
            } elseif ($currentDateTime > $discount['EndDate']) {
                $status = 'inactive'; // Nếu đã hết thời gian giảm giá
            }
        ?>
        <tr>
            <td><?= $discount['DiscountID'] ?></td>
            <td><?= $discount['ProductName'] ?></td>
            <td><?= $discount['DiscountType'] == 'percentage' ? 'Phần trăm' : 'Tiền mặt' ?></td>
            <td>
                <?php 
                if ($discount['DiscountType'] == 'percentage') {
                    echo $discount['DiscountValue'] . '%';
                } else {
                    $discountValue = floatval(str_replace(',', '', $discount['DiscountValue']));
                    echo number_format($discountValue, 0, ',', '.') . ' VNĐ';
                }
                ?>
            </td>
            <td><?= date('Y-m-d H:i:s', strtotime($discount['StartDate'])) ?></td>
            <td><?= date('Y-m-d H:i:s', strtotime($discount['EndDate'])) ?></td>
            <td style="vertical-align: middle;">
                <?php
                echo match ($status) {
                    'active' => '<span class="badge bg-success">Active</span>',
                    'inactive' => '<span class="badge bg-secondary">Inactive</span>',
                    'pending' => '<span class="badge bg-warning">Pending</span>',
                };
                ?>
            </td>
            <td>
            <a href="?act=edit-discount&id=<?= $discount['DiscountID'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                <a href="?act=delete-discount&id=<?= $discount['DiscountID'] ?>" class="btn btn-danger btn-sm"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
