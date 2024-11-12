<!DOCTYPE html>
<html>
<head>
    <title>Add Discount</title>
</head>
<body>
    <h2>Add Discount</h2>
    <form method="POST" action="index.php?views=DiscountController&action=add_discount">
        <label>Product:</label>
        <select name="product_id" required>
            <?php foreach ($products as $product): ?>
                <option value="<?= $product['product_id'] ?>"><?= $product['product_name'] ?></option>
            <?php endforeach; ?>
        </select><br>

        <label>Discount Type:</label>
        <input type="text" name="discount_type" required><br>

        <label>Discount Value:</label>
        <input type="number" name="discount_value" required><br>

        <label>Start Date:</label>
        <input type="date" name="start_date" required><br>

        <label>End Date:</label>
        <input type="date" name="end_date" required><br>

        <input type="submit" value="Add Discount">
    </form>
</body>
</html>
