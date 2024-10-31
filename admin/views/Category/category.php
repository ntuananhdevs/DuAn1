<div class="container">
    <h2 class="">Categories</h2>
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
            <?php foreach ($listCategories as $category) : ?>
                <tr>
                    <td><?php echo $category['category_id'] ?></td>
                    <td><?php echo $category['category_name'] ?></td>
                    <td><?php echo $category['description'] ?></td>
                    <td><?php echo $category['product_count'] ?></td>
                    <td></td>
                   
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
