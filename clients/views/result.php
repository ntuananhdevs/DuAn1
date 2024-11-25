<head>
    <link rel="stylesheet" href="./assets/css/client.css">
</head> 




<?php if (empty($results) || !isset($_GET['search']) || empty( $_GET['search'] ?? '')) :  ?>    
   <img src="https://colorlib.com/wp/wp-content/uploads/sites/2/404-error-template-14.png" alt="" style="width: 100% ; height: 80%;">
<?php else: ?>

    <?php

function renderRatingStars($rating)
{
    $stars = '';
    for ($i = 1; $i <= 5; $i++) {
        if ($rating >= $i) {
            $stars .= '<i class="fa-solid fa-star" style="color: blue;"></i>';
        } elseif ($rating > $i - 1 && $rating < $i) {
            $stars .= '<i class="fa-solid fa-star-half-stroke" style="color: blue;"></i>';
        } else {
            $stars .= '<i class="fa-regular fa-star" style="color: lightgray;"></i>';
        }
    }
    return $stars;
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
            <hr>
            <h5><?= htmlspecialchars($result['product_name']) ?></h5>
            <div class="rating-container">
                <div class="rating">
                    <?= renderRatingStars((int)$result['rating']) ?>
                </div>
                <h7><?= htmlspecialchars($result['rating']) ?></h7>
                <p class="views"> <ion-icon name="eye-outline"></ion-icon> <?= htmlspecialchars($result['views']) ?></p>
            </div>
            <span class="sale">Sale:
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
                    
                    echo '<span class="text-danger">' . number_format($discounted_price, 0, ',', '.') . ' VND</span>';
                } else {
                    echo '<span>' . '0' . ' VND</span>';
                }
                ?>
                <span class="discound"><?= htmlspecialchars(number_format($result['Lowest_Price'], 0, ',', '.')) ?> VNĐ</span>
            </span>
            <hr>
            <a href="#" class="buy-now">Mua ngay</a>
            <a href="?act=product_detail&id=<?= $result['id'] ?>" class="learn-more">Xem chi tiết</a>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?> 
</div>




