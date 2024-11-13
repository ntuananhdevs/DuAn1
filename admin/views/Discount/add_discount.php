<div class="container mt-5">
    <h1>Thêm giảm giá mới</h1>
    <form id="discount_form" action="?act=add-discount" method="POST">
        <div class="form-group">
            <label for="product_id">Sản phẩm</label>
            <select name="product_id" id="product_id" class="form-control">
                <?php foreach ($products as $product): ?>
                    <option value="<?= $product['id'] ?>"><?= $product['product_name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="discount_type">Loại giảm giá</label>
            <select name="discount_type" id="discount_type" class="form-control">
                <option value="percentage">Phần trăm</option>
                <option value="fixed">Tiền mặt</option>
            </select>
        </div>

        <div class="form-group" id="discount_value_group">
            <label for="discount_value">Giá trị giảm</label>
            <input type="number" name="discount_value" id="discount_value" class="form-control" placeholder="Nhập giá trị giảm" required>
        </div>

        <div class="form-group">
            <label for="start_date">Ngày và giờ bắt đầu</label>
            <input type="datetime-local" name="start_date" id="start_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="end_date">Ngày và giờ kết thúc</label>
            <input type="datetime-local" name="end_date" id="end_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Thêm</button>
        <a href="?act=discount" class="btn btn-secondary mt-3">Hủy</a>
    </form>
</div>

<script>
document.getElementById('discount_type').addEventListener('change', function () {
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

document.getElementById('discount_value').addEventListener('input', function () {
    let discountType = document.getElementById('discount_type').value;
    let discountValue = parseFloat(this.value);

    if (discountType === 'percentage' && discountValue > 100) {
        this.value = 100; // Giới hạn giá trị không quá 100%
        alert("Giảm giá phần trăm không được vượt quá 100%!"); // Hiển thị thông báo
    }
});

document.getElementById('discount_form').addEventListener('submit', function (e) {
    const startDate = new Date(document.getElementById('start_date').value);
    const endDate = new Date(document.getElementById('end_date').value);

    if (endDate < startDate) {
        e.preventDefault(); // Ngăn gửi biểu mẫu
        alert("Ngày kết thúc không được nhỏ hơn ngày bắt đầu! Vui lòng chọn lại.");
    }
});
</script>
