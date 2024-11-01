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
                <th scope="col">Total color</th>
                <th scope="col">Quantity</th>
                <th scope="col">Views</th>
                <th scope="col">Lowest Price</th>
                <th scope="col">Highest price</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listProducts as $key => $value) : ?>
                <tr>
                    <td><?php echo $value['ID'] ?></td>
                    <td><?php echo $value['Name'] ?></td>
                    <td></td>
                    <td><?php echo $value['Category_name'] ?></td>
                    <td><?php echo $value['Total_color'] ?></td>
                    <td><?php echo $value['Quantity'] ?></td>
                    <td><?php echo $value['Views'] ?></td>
                    <td><?php echo number_format(floatval(str_replace('.', '', $value['Lowest_Price'])), 0, ',', '.'); ?> vnđ</p></td>
                    <td><?php echo number_format(floatval(str_replace('.', '', $value['Highest_Price'])), 0, ',', '.'); ?> vnđ</p></td>
                    <td>
                    <a href="?act=product_detail&id=<?php echo $value['ID'] ?>" class="btn btn-primary">Details</a>
                    <a href="?act=delete_product" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
