<head>
    <link rel="stylesheet" href="./assets/css/client.css">
</head> 




<?php if (empty($results) || !isset($_GET['search']) || empty( $_GET['search'] ?? '')) :  ?>    
   <img src="https://colorlib.com/wp/wp-content/uploads/sites/2/404-error-template-14.png" alt="" style="width: 100% ; height: 80%;">
<?php else: ?>

    <?php

function renderRatingStars($rating, $maxStars = 5, $colorFull = 'yellow', $colorEmpty = 'lightgray', $size = '10px') {
    $stars = '';
    for ($i = 1; $i <= $maxStars; $i++) {
        if ($rating >= $i) {
            // Sao đầy
            $stars .= '<i class="fa-solid fa-star" style="color: ' . $colorFull . '; font-size: ' . $size . '; margin-right: 5px;"></i>';
        } elseif ($rating >= $i - 0.5 && $rating < $i) {
            // Sao nửa
            $stars .= '<i class="fa-solid fa-star-half-stroke" style="color: ' . $colorFull . '; font-size: ' . $size . '; margin-right: 5px;"></i>';
        } else {
            // Sao rỗng
            $stars .= '<i class="fa-regular fa-star" style="color: ' . $colorEmpty . '; font-size: ' . $size . '; margin-right: 5px;"></i>';
        }
    }
    
    $tooltip = '<div title="Rating: ' . $rating . '/' . $maxStars . '">' . $stars . '</div>';
    return $tooltip;
}

?>
<div class="container">
<h1 class="product-title" style="margin-top: 30px; margin-bottom: 30px; font-size: 25px">Kết quả tìm kiếm cho từ khóa  : <?= $_GET['search']?></h1>
<div class="result-container">
    <?php
    usort($results, function($a, $b) {
        return $b['views'] - $a['views'];
    });
    ?>
    <?php foreach ($results as $result) : ?>
        <div class="product-item">
                    <div class="discount-container">
                        <p>Giảm <?= htmlspecialchars($result['discount_value']) ?>%</p>
                    </div>
                    <img src="<?= htmlspecialchars(removeLeadingDots($result['img'])) ?>" alt="<?= htmlspecialchars($result['product_name']) ?>">
                    <h5><?= htmlspecialchars($result['product_name']) ?></h5>
                    <div class="rating-container">
                        <div class="rating">
                            <?= renderRatingStars((int)$result['rating']) ?>
                        </div>
                    </div>
                
                    <div class="price-home mb-0 mt-2">
                        <?php
                        $original_price = floatval(str_replace('.', '', $result['Lowest_Price']));
                        $discount_value = floatval($result['discount_value']);
                        $discount_status = $result['discount_status'];
                        if ($discount_value > 0 && $discount_status === 'active') {
                            if ($result['discount_type'] == 'percentage') {
                                $discounted_price = $original_price * (1 - $discount_value / 100);
                            } else {
                                $discounted_price = $original_price - $discount_value;
                            }
                            
                            echo '<p>' . number_format($discounted_price, 0, ',', '.') . ' ₫</p>';
                        } else {
                            echo '<span>' . '0' . ' ₫</span>';
                        }
                        ?>
                    </div>
                    <div class="price-save d-flex gap-3 mt-0">
                        <p class="discound-1 text-decoration-line-through" style="font-size: 1rem"><?= htmlspecialchars(number_format($result['Lowest_Price'], 0, ',', '.')) ?>₫</p>
                        <p class="save-2 text-danger" style="font-size: 1rem">SAVE: <?= htmlspecialchars(number_format($result['Lowest_Price'] - $discounted_price, 0, ',', '.')) ?>₫</p>
                    </div>
                    <a href="?act=product_detail&id=<?= $result['id'] ?>" class="buy-now">Mua ngay</a>
                </div>
    <?php endforeach; ?>
</div>
<?php endif; ?> 
</div>




