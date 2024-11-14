<div class="container">
    <h3 class="mb-0 h4 font-weight-bolder mb-4">Quản Lý BANNER</h3>

    <a href="index.php?act=view_add" class="btn btn-primary mb-3">Thêm BANNER</a>
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
            <?php foreach ($banners as $banner) : ?>
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
                            echo match($banner['status']) {
                                'active' => '<span class="badge bg-success">Active</span>',
                                'inactive' => '<span class="badge bg-secondary">Inactive</span>',
                                'expired' => '<span class="badge bg-warning">Expired</span>',
                            
                            };
                        ?>
                    </td>
                    <td style="vertical-align: middle;">
                        <a href="index.php?act=view_edit&id=<?= htmlspecialchars($banner['id']) ?>" class="btn btn-primary mt-3">Edit</a>
                        <a href="index.php?act=delete_banner&id=<?= htmlspecialchars($banner['id']) ?>" class="btn btn-danger mt-3" onclick="return confirm('Bạn có chắc muốn xóa banner này???');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
