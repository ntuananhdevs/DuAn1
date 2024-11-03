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
                    <td><?php echo number_format(floatval(str_replace('.', '', $value['price'])), 0, ',', '.'); ?> vnđ</p>
                    </td>
                    <td>
                        <a href="?act=product_detail&id=<?php echo $value['product_id'] ?>" class="btn btn-primary">Details</a>
                        <a href="?act=delete_product" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <hr class="mt-4">
    <div class="des border p-3 bg-light rounded table">
        <h3 class="mb-0 h4 font-weight-bolder mb-4 text-center">Description</h3>
        <?php foreach ($description as $key => $value) : ?>
            <p class=" mb-2"><?php echo $value['description'] ?></p>
        <?php endforeach; ?>
        <a href="?act=add-product" class="btn btn-primary mt-2">Edit</a>

    </div>

    <hr>
    <div class="des border p-3 bg-light rounded table">

    <h3 class="mb-0 h4 font-weight-bolder mb-4 text-center">Thông số kỹ thuật</h3>
    <table class="table table-bordered">
        <tbody>
            <?php foreach ($list_spect as $index => $spec) : ?>
                <tr class="<?php echo $index % 2 == 0 ? 'bg-light' : ''; ?>">
                    <td class="font-weight-bold" style="width: 20%;"><?php echo htmlspecialchars($spec['Specification_Name']); ?></td>
                    <td><?php echo htmlspecialchars($spec['Specification_Value']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="?act=add-product" class="btn btn-primary mt-2">Edit</a>
    </div>


</div>