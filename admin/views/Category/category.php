<div class="container">
    <h2 class="">Categories</h2>
     <td class="add">
        <a href="update_category.php?id=<?php echo $category['id'] ?>" class="btn btn-primary">Thêm</a>
        </td>
    <table class="table table-hover">
       
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Số lượng</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($listCategories) && is_array($listCategories)) : ?>
                <?php foreach ($listCategories as $category) : ?>
                    <tr>
                        <td><?php echo $category['id'] ?></td>
                        <td><?php echo $category['category_name'] ?></td>
                        <td><?php echo $category['description'] ?></td>
                        <td><?php echo $category['product_count'] ?></td>
                       
                   
                        
                        <td>   <!-- Nút Sửa -->
                            <a href="edit_category.php?id=<?php echo $category['id'] ?>" class="btn btn-warning">Sửa</a>
                       
                            <!-- Nút Xóa -->
                            <a href="delete_category.php?id=<?php echo $category['id'] ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                       </td> 
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



