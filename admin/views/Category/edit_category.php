<div class="container">
    <h2>Sửa Danh Mục</h2>
    <form action="index.php?act=edit_category&id=<?php echo $category['id']; ?>" method="POST">
        <div class="form-group">
            <label for="category_name">Tên Danh Mục</label>
            <input type="text" class="form-control" name="category_name" value="<?php echo $category['category_name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Mô Tả</label>
            <textarea class="form-control" name="description"><?php echo $category['description']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cập Nhật</button>
        <a href="index.php?act=category" class="btn btn-secondary">Hủy</a>
    </form>
</div>
