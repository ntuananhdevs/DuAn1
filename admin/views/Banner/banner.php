<div class="container">
    <h3 class="mb-0 h4 font-weight-bolder mb-4">Quản Lý BANNER</h3>


    <form action="" method="GET" class="d-flex mb-3z     ">
    <a href="index.php?act=view_add" class="btn btn-primary mb-3">Thêm BANNER</a>
    <input type="hidden" name="act" value="banner">
    <input type="text" class="form-control mb-1  ms-3" style="border-radius: 4px 0 0 4px; height: 36px ; width: 180px" id="search" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
    <button type="submit" class="btn btn-primary" style="border-radius: 0 4px 4px 0; ">
        <ion-icon name="search"></ion-icon>
    </button>
</form>
<?php if (empty($banners)): ?>    
    <p class="">Không có kết quả phù hợp.</p>
<?php else: ?>
    <table class="table table-hover">
        <thead class="text-left">
            <tr>
                <th scope="col">Ảnh</th>
                <th scope="col">Tên Ảnh</th>
                <th scope="col">Mô Tả</th>
                <th scope="col">Ngày Bắt Đầu</th>
                <th scope="col">Ngày Kết Thúc</th>
                <th scope="col">Trạng Thái</th>
                <th scope="col">Thao Tác</th>
            </tr>
        </thead>
        <tbody class="text-left">


            <?php
            $currentDateTime = date('Y-m-d H:i:s');
            foreach ($banners as $banner) :
                $status = 'pending'; // Mặc định trạng thái là pending
                if ($currentDateTime >= $banner['start_date'] && $currentDateTime <= $banner['end_date']) {
                    $status = 'active'; // Nếu đang trong thời gian giảm giá
                } elseif ($currentDateTime > $banner['end_date']) {
                    $status = 'inactive'; // Nếu đã hết thời gian giảm giá
                }

            ?>
                <tr>
                    <td>
                        <img src="../uploads/BannerIMG/<?= htmlspecialchars($banner['img_url']) ?>" style="width: 200px; height: 100px; border-radius: 5px; object-fit: cover;" alt="Banner Image">
                    </td>
                    <td style="vertical-align: middle;"><?= htmlspecialchars($banner['title']); ?></td>
                    <td style="vertical-align: middle;"><?= htmlspecialchars($banner['description']) ?></td>
                    <td style="vertical-align: middle;"><?= date('d-m-Y H:i:s', strtotime($banner['start_date'])); ?></td>
                    <td style="vertical-align: middle;"><?= $banner['end_date'] ? date('d-m-Y H:i:s', strtotime($banner['end_date'])) : 'N/A'; ?></td>
                    <td style="vertical-align: middle;">
                        <?php
                        echo match ($banner['status']) {
                            'active' => '<span class="badge bg-success">Active</span>',
                            'inactive' => '<span class="badge bg-secondary">Inactive</span>',
                            'pending' => '<span class="badge bg-warning">Pending</span>',
                        };
                        ?>
                    </td>
                    <td style="vertical-align: middle;">
                        <a href="index.php?act=view_edit&id=<?= htmlspecialchars($banner['id']) ?>" class="btn btn-primary mt-3">Edit</a>
                        <a href="index.php?act=delete_banner&id=<?= htmlspecialchars($banner['id']) ?>" class="btn btn-danger mt-3" onclick="return confirm('Bạn có chắc muốn xóa banner này???');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>