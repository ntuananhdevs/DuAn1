<div class="container">
    <h2>Thêm Danh Mục</h2>
    <form action="index.php?act=add_category" method="POST">
        <div class="form-group">
            <label for="category_name">Tên Danh Mục</label>
            <input type="text" class="form-control" name="category_name" required>
        </div>
        <div class="form-group">
            <label for="description">Mô Tả</label>
            <textarea class="form-control" name="description"></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Thêm</button>
        <a href="index.php?act=category" class="btn btn-secondary mt-3">Hủy</a>
    </form>
</div>
