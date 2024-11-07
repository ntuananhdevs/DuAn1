<form method="POST" action="?act=post_update_variants" enctype="multipart/form-data">
    <input type="hidden" name="variant_id" value="<?php echo $variant['id']; ?>">
    <input type="hidden" name="product_id" value="<?php echo $variant['product_id']; ?>">
    
    <!-- Các trường nhập liệu cho color, ram, storage, quantity, price -->
    <input type="text" name="color" value="<?php echo $variant['color']; ?>">
    <input type="text" name="ram" value="<?php echo $variant['ram']; ?>">
    <input type="text" name="storage" value="<?php echo $variant['storage']; ?>">
    <input type="number" name="quantity" value="<?php echo $variant['quantity']; ?>">
    <input type="number" name="price" value="<?php echo $variant['price']; ?>">

    <!-- Trường tải lên ảnh mới -->
    <input type="file" name="image">
    
    <button type="submit">Cập nhật</button>
</form>
