<!DOCTYPE html>
<html>
<head>
    <title>Discount Management</title>
</head>
<body>
    <h2>Discount Management</h2>
    <a href="index.php?controller=discount&action=add">Add New Discount</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Discount Type</th>
            <th>Discount Value</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Action</th>
        </tr>
        <?php foreach ($discounts as $discount): ?>
            <tr>
                <td><?= $discount['id'] ?></td>
                <td><?= $discount['product_name'] ?></td>
                <td><?= $discount['discount_type'] ?></td>
                <td><?= $discount['discount_value'] ?></td>
                <td><?= $discount['start_date'] ?></td>
                <td><?= $discount['end_date'] ?></td>
                <td>
                    <a href="index.php?controller=discount&action=edit<?= $discount['id'] ?>">Edit</a>
                    <a href="index.php?controller=discount&action=delete<?= $discount['id'] ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
