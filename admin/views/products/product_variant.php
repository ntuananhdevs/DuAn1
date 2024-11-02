<div class="container">
    <h3 class="mb-0 h4 font-weight-bolder mb-4">Products Variant</h3>
    <a href="?act=add-product" class="btn btn-primary">Add Product</a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">Color</th>
                <th scope="col">Ram</th>
                <th scope="col">Storage</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($listPrd_Variant as $key => $value) : ?>
                <tr>
                    <td><?php echo $value['variant_id'] ?></td>
                    <td><?php echo $value['product_name'] ?> | <?php echo $value['ram'] ?> | <?php echo $value['storage'] ?></td>
                    <td><img src="<?php echo $value['img']; ?>" alt="img" style="width:50px;height:auto;"></td>
                    <td><?php echo $value['color'] ?></td>
                    <td><?php echo $value['ram'] ?></td>
                    <td><?php echo $value['storage'] ?></td>
                    <td><?php echo $value['quantity'] ?></td>
                    <td><?php echo number_format(floatval(str_replace('.', '', $value['price'])), 0, ',', '.'); ?> vnđ</p></td>
                    <td>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

