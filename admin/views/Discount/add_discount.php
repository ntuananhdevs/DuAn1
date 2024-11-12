<h1>Thêm giảm giá mới</h1>
<form method="POST">
    <label for="product_id">Sản phẩm</label>
    <select name="product_id" id="product_id">
        <?php foreach ($products as $product): ?>
            <option value="<?= $product['ID'] ?>"><?= $product['Name'] ?></option>
        <?php endforeach; ?>
    </select><br>

    <label for="discount_type">Loại giảm giá</label>
    <input type="text" name="discount_type" id="discount_type" required><br>

    <label for="discount_value">Giá trị giảm giá</label>
    <input type="text" name="discount_value" id="discount_value" required><br>

    <label for="start_date">Ngày bắt đầu</label>
    <input type="date" name="start_date" id="start_date" required><br>

    <label for="end_date">Ngày kết thúc</label>
    <input type="date" name="end_date" id="end_date" required><br>

    <button type="submit">Thêm</button>
</form>
