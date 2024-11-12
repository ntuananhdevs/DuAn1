<!DOCTYPE html>
<html>
<head>
    <title>Edit Discount</title>
</head>
<body>
    <h2>Edit Discount</h2>
    <form method="POST" action="index.php?controllers=DiscountController&action=edit<?= $discount['id'] ?>">
        <label>Discount Type:</label>
        <input type="text" name="discount_type" value="<?= $discount['discount_type'] ?>" required><br>

        <label>Discount Value:</label>
        <input type="number" name="discount_value" value="<?= $discount['discount_value'] ?>" required><br>

        <label>Start Date:</label>
        <input type="date" name="start_date" value="<?= $discount['start_date'] ?>" required><br>

        <label>End Date:</label>
        <input type="date" name="end_date" value="<?= $discount['end_date'] ?>" required><br>

        <input type="submit" value="Update Discount">
    </form>
</body>
</html>
