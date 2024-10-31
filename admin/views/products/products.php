<div class="container">
<h3 class="mb-0 h4 font-weight-bolder mb-4">Products</h3>
<a href="?act=add-product" class="btn btn-primary">Add Product</a>
    <table class="table  table-hover">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">Brand</th>
                <th scope="col">Color</th>
                <th scope="col">Ram</th>
                <th scope="col">Storage</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Specifications</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listProducts as $key => $value) : ?>
                <tr>
                    <td><?php echo $value['product_id'] ?></td>
                    <td><?php echo $value['product_name'] ?></td>
                    <td></td>
                    <td><?php echo $value['category_name'] ?></td>
                    <td><?php echo $value['color_name'] ?></td>
                    <td><?php echo $value['ram_size'] ?></td>
                    <td><?php echo $value['storage_size'] ?></td>
                    <td><?php echo $value['variant_stock_quantity'] ?></td>
                    <td><?php echo number_format(floatval(str_replace('.', '', $value['variant_price'])), 0, ',', '.'); ?>đ</p></td>
                    <td><?php echo $value['specifications'] ?></td>
                    <td>
                       
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
