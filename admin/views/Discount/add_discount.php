
    <div class="container mt-5">
        <h1>Thêm giảm giá mới</h1>
        <form action="?act=add-discount" method="POST">
        
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
                <input type="text" name="discount_value" id="discount_value" class="form-control" placeholder="Nhập giá trị giảm">
            </div>

            <div class="form-group">
                <label for="start_date">Ngày bắt đầu</label>
                <input type="date" name="start_date" id="start_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="end_date">Ngày kết thúc</label>
                <input type="date" name="end_date" id="end_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="status">Trạng thái</label>
                <select name="status" id="status" class="form-control">
                    <option value="1">Hoạt động</option>
                    <option value="0">Không hoạt động</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" >Thêm</button>
            <a href="?act=discount" class="btn btn-secondary">Hủy</a>

            
        </form>
    </div>
    <script>
    // Lắng nghe sự kiện thay đổi giá trị chọn loại giảm giá
    document.getElementById('discount_type').addEventListener('change', function() {
        let discountValueInput = document.getElementById('discount_value');
        let discountType = this.value;

        // Nếu chọn 'percentage', chỉ cho phép nhập giá trị <= 100
        if (discountType === 'percentage') {
            discountValueInput.removeAttribute('disabled');  // Cho phép nhập giá trị
        } else {
            discountValueInput.removeAttribute('disabled');  // Nếu là 'fixed', cho phép nhập
        }
    });

    // Kiểm tra khi người dùng nhập giá trị giảm
    document.getElementById('discount_value').addEventListener('input', function() {
        let discountValue = parseFloat(this.value);
        let discountType = document.getElementById('discount_type').value;

        // Kiểm tra nếu chọn 'percentage' và giá trị lớn hơn 100
        if (discountType === 'percentage' && discountValue > 100) {
            alert('Giảm giá phần trăm không thể lớn hơn 100%.');
            this.value = '';  // Xóa giá trị nhập vào
        }
    });
</script>

  
