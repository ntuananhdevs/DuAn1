<div class="container">
    <h2>Categories</h2>
    <a href="index.php?act=add_category" class="btn btn-primary mb-3">Thêm Danh Mục</a>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên Sản Phẩm</th>
                <th scope="col">Mô Tả</th>
                <th scope="col">Số Lượng</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($listCategories) && is_array($listCategories)) : ?>
                <?php foreach ($listCategories as $category) : ?>
                    <tr>
                        <td><?php echo $category['id']; ?></td>
                        <td><?php echo $category['category_name']; ?></td>
                        <td><?php echo $category['description']; ?></td>
                        <td><?php echo $category['product_count']; ?></td>
                        <td>
                            <a href="index.php?act=edit_category&id=<?php echo $category['id']; ?>" class="btn btn-warning">Sửa</a>
                            <a href="index.php?act=delete_category&id=<?php echo $category['id']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5">Không có danh mục nào</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>


