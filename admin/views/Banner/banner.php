<div class="container">
    <h3 class="mb-0 h4 font-weight-bolder mb-4">Quản Lý BANNER</h3>
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
            <?php foreach ($banners as $key => $banner) : ?>
                <tr>
                    <td><img src="<?= $banner['img_url'] ?>" style="width: 200px; height: 100px; border-radius: 5%;" alt=""></td>
                    <td><?= htmlspecialchars($banner['title']); ?></td>
                    <td><?= $banner['description'] ?></td>
                    <td><?= date('d-m-Y H:i:s', strtotime($banner['start_date'])); ?></td>
                    <td><?= $banner['end_date'] ? date('d-m-Y H:i:s', strtotime($banner['end_date'])) : 'N/A'; ?></td>
                    <td>
                    <select id="statusSelect" class="form-select" aria-label="Default select example" onchange="changeSelectColor()" style="width: 100px;">
                        <option selected disabled>Status</option>
                        <option value="1"  <?= $banner['status'] == 'active' ? 'selected' : ''; ?>>Hiện</option>
                        <option value="2" <?= $banner['status'] == 'inactive' ? 'selected' : ''; ?>>Ẩn</option>
                    </select>
                    </td>
                    <td>
                        <a href="index.php?controller=banner&action=edit&id=<?= $banner['id'] ?>" class="btn btn-primary"> Edit</a>
                        <a href="index.php?controller=banner&action=delete&id=<?= $banner['id'] ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
