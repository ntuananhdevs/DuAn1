<h3 class="mb-0 h4 font-weight-bolder mb-4">Quản Lý Giảm Giá</h3>
<div class="search d-flex gap-3 align-items-center p-2">
    <a href="?act=add-discount" class="btn btn-primary">Thêm giảm giá </a>

    <!-- Thanh tìm kiếm -->
    <form method="GET" action="" class="d-flex">
        <input type="hidden" name="act" value="discount"> 
        <input type="text" name="search" class="form-control mb-1" style="border-radius: 4px 0 0 4px  ; height: 36px;" placeholder="Nhập tên sản phẩm" 
               value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
        <button type="submit" class="btn btn-primary" style="border-radius: 0 4px 4px 0; "><ion-icon name="search"></ion-icon></button>
    </form>
</div>
<table class="table">
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
    <?php if (!empty($discounts)): ?>
        <?php
        $currentDateTime = date('Y-m-d H:i:s'); 
        foreach ($discounts as $discount):
            $status = 'pending'; 
            if ($currentDateTime >= $discount['StartDate'] && $currentDateTime <= $discount['EndDate']) {
                $status = 'active'; 
            } elseif ($currentDateTime > $discount['EndDate']) {
                $status = 'expired'; 
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
            <td>
                <?php
              echo match ($discount['Status']) {
                'active' => '<span class="badge bg-success">Active</span>',
                'pending' => '<span class="badge bg-warning">Pending</span>',        
             'expired' => '<span class="badge bg-danger">Expired</span>',
            };
            
                ?>
            </td>
            <td>
                <a href="?act=edit-discount&id=<?= $discount['DiscountID'] ?>" class="btn btn-warning">Sửa</a>
                <a href="?act=delete-discount&id=<?= $discount['DiscountID'] ?>" class="btn btn-danger"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" class="text-center">Không tìm thấy sản phẩm nào.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>