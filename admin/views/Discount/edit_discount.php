<h1 class="text-center my-4">Chỉnh sửa giảm giá</h1>
<form action="?act=edit-discount" method="POST" class="container">
    <div class="form-group">
        <label for="product_id">Sản phẩm</label>
        <select name="product_id" id="product_id" class="form-control">
            <?php foreach ($products as $product): ?>
                <option value="<?= $product['ID'] ?>" <?= $product['ID'] == $discount['product_id'] ? 'selected' : '' ?>>
                    <?= $product['Name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="discount_type">Loại giảm giá</label>
        <select name="discount_type" id="discount_type" class="form-control">
            <option value="percentage" <?= $discount['discount_type'] == 'percentage' ? 'selected' : '' ?>>Phần trăm</option>
            <option value="fixed" <?= $discount['discount_type'] == 'fixed' ? 'selected' : '' ?>>Tiền mặt</option>
        </select>
    </div>

    <div class="form-group" id="discount_value_group">
        <label for="discount_value">Giá trị giảm</label>
        <input type="number" name="discount_value" id="discount_value" class="form-control" value="<?= $discount['discount_value'] ?>" placeholder="Nhập giá trị giảm" required>
    </div>

    <div class="form-group">
        <label for="start_date">Ngày và giờ bắt đầu</label>
        <input type="datetime-local" name="start_date" id="start_date" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($discount['start_date'])) ?>" required>
    </div>

    <div class="form-group">
        <label for="end_date">Ngày và giờ kết thúc</label>
        <input type="datetime-local" name="end_date" id="end_date" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($discount['end_date'])) ?>" required>
    </div>

    <div class="form-group">
        <label for="status">Trạng thái</label>
        <select name="status" id="status" class="form-control">
            <option value="1" <?= $discount['status'] == 1 ? 'selected' : '' ?>>Active</option>
            <option value="0" <?= $discount['status'] == 0 ? 'selected' : '' ?>>Expired</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Lưu thay đổi</button>
    <a href="?act=discount" class="btn btn-secondary">Hủy</a>
</form>

<script>
document.getElementById('discount_type').addEventListener('change', function() {
    let discountType = this.value;
    let discountValueInput = document.getElementById('discount_value');

    if (discountType === 'percentage') {
        discountValueInput.setAttribute('max', 100); // Giới hạn tối đa là 100% cho phần trăm
        discountValueInput.setAttribute('placeholder', 'Nhập giá trị từ 1 đến 100');
    } else {
        discountValueInput.removeAttribute('max'); // Không có giới hạn cho tiền mặt
        discountValueInput.setAttribute('placeholder', 'Nhập giá trị giảm');
    }
});

// Kiểm tra và đảm bảo giá trị giảm giá không vượt quá 100% khi nhập
document.getElementById('discount_value').addEventListener('input', function() {
    let discountType = document.getElementById('discount_type').value;
    let discountValue = parseFloat(this.value);

    if (discountType === 'percentage' && discountValue > 100) {
        this.value = 100; // Giới hạn giá trị không quá 100%
        alert("Giảm giá phần trăm không được vượt quá 100%!"); // Hiển thị thông báo
    }
});
</script>
