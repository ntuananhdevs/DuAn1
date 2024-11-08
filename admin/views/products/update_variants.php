    <h2 class="mb-0 h4 font-weight-bolder mb-4">Edit Variant</h2>
    <form action="?act=update_variant_post" method="post" enctype="multipart/form-data">
    <input type="hidden" name="variant_id" value="<?php echo $variant['id']; ?>">
    <input type="hidden" name="old_image" value="<?php echo $variant['img']; ?>">
        
        <div class="variant">
            <div class="color" style="display: flex; gap: 10px; align-items: center;">
                <label class="form-label mb-0 font-weight-bolder">Chọn màu sắc:</label>
                <select name="color" id="colorSelect" class="form-select" style="width: 15%;">
                    <option value="">Chọn Màu</option>
                    <option value="Black" <?php echo $variant['color'] == 'Black' ? 'selected' : ''; ?>>Đen</option>
                    <option value="Red" <?php echo $variant['color'] == 'Red' ? 'selected' : ''; ?>>Đỏ</option>
                    <option value="Green" <?php echo $variant['color'] == 'Green' ? 'selected' : ''; ?>>Xanh lá</option>
                    <option value="Blue" <?php echo $variant['color'] == 'Blue' ? 'selected' : ''; ?>>Xanh dương</option>
                </select>

                <label class="form-label mb-0 font-weight-bolder" style="margin-right: 37px;">Hình ảnh:</label>
                <input type="file" class="form-control" name="image" accept="image/*" onchange="previewImage(this, 'imagePreview')" style="width: 26%;">
                <img id="imagePreview" src="<?php echo $variant['img']; ?>" alt="Image Preview" style="width: 50px; height: 50px;">
            </div>

            <div class="ram" style="display: flex; gap: 10px; align-items: center; margin-top: 10px;">
                <label class="form-label mb-0 font-weight-bolder me-4">Chọn Ram:</label>
                <select name="ram" id="ramSelect" class="form-select" required style="width: 15%;">
                    <option value="">Ram</option>
                    <option value="4GB" <?php echo $variant['ram'] == '4GB' ? 'selected' : ''; ?>>4GB</option>
                    <option value="8GB" <?php echo $variant['ram'] == '8GB' ? 'selected' : ''; ?>>8GB</option>
                    <option value="12GB" <?php echo $variant['ram'] == '12GB' ? 'selected' : ''; ?>>12GB</option>
                    <option value="16GB" <?php echo $variant['ram'] == '16GB' ? 'selected' : ''; ?>>16GB</option>
                </select>
            </div>

            <!-- Storage -->
            <div class="storage" style="display: flex; gap: 10px; align-items: center; margin-top: 10px;">
                <label class="form-label mb-0 font-weight-bolder me-2">Chọn Storage:</label>
                <select name="storage" id="storageSelect" class="form-select" required style="width: 15%;">
                    <option value="">Storage</option>
                    <option value="64GB" <?php echo $variant['storage'] == '64GB' ? 'selected' : ''; ?>>64GB</option>
                    <option value="128GB" <?php echo $variant['storage'] == '128GB' ? 'selected' : ''; ?>>128GB</option>
                    <option value="256GB" <?php echo $variant['storage'] == '256GB' ? 'selected' : ''; ?>>256GB</option>
                    <option value="512GB" <?php echo $variant['storage'] == '512GB' ? 'selected' : ''; ?>>512GB</option>
                </select>
            </div>

            <!-- Quantity and Price -->
            <div class="quantity-price" style="display: flex; gap: 10px; align-items: center; margin-top: 10px;">
                <label class="form-label mb-0 font-weight-bolder me-3">Quantity:</label>
                <input type="number" name="quantity" value="<?php echo $variant['quantity']; ?>" min="1" class="form-control ms-3" required style="width: 15%;">

                <label class="form-label mb-0 font-weight-bolder me-3">Price:</label>
                <input type="text" name="price" value="<?php echo $variant['price']; ?>" min="0" class="form-control" required style="width: 15%;">
            </div>
        </div>

        <br>
        <button type="submit" class="btn btn-success">Cập nhật biến thể</button>
    </form>

<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'inline';
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
            preview.style.display = 'none';
        }
    }
</script>
