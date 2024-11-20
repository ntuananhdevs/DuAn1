<head>
    <link rel="stylesheet" href="./assets/css/client.css">
</head> 


<?php
function removeLeadingDots($filePath) {
    return preg_replace('/^\.\.\//', '', $filePath);
}
?>

<?php if (empty($results)): ?>    
   <img src="https://colorlib.com/wp/wp-content/uploads/sites/2/404-error-template-14.png" alt="" style="width: 100% ; height: 80%;">
<?php else: ?>

<div class="product-container">
    <?php foreach ($results as $result) : ?>
        <div class="result-item">
            <div class="discount-container">
                <p>Giảm <?= htmlspecialchars($result['discount_value']) ?>%</p>
            </div>
            <img src="<?= htmlspecialchars(removeLeadingDots($result['img'])) ?>" alt="<?= htmlspecialchars($result['product_name']) ?>">
            <h2><?= htmlspecialchars($result['product_name']) ?></h2>
            <p> <i class="fa-solid fa-eye"></i> <?= htmlspecialchars($result['views']) ?></p>
            <p>Giá: <?= htmlspecialchars(number_format($result['Lowest_Price'], 0, ',', '.')) ?> VNĐ</p>
            <a href="#" class="learn-more">Mua ngay</a>
            <a href="#" class="learn-more">Xem chi tiết</a>
        </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>




