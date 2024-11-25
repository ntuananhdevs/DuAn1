<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./clients/assets/css/client.css">
</head>
<body>
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
<div class="container" data-aos="fade-up">
    <div class="product-container-wrapper">
        <button class="scroll-btn left" onclick="scrollProducts('left')"><ion-icon name="chevron-back-outline"></ion-icon></button>
        <div class="product-container">
        <?php
            usort($products, function($a, $b) {
                return $b['views'] - $a['views'];
            });
            function limitText($text, $limit = 50) {
                if (mb_strlen($text) > $limit) {
                    return mb_substr($text, 0, $limit) . '...';
                }
                return $text;
            }
            ?>
            <?php foreach ($products as $product) : ?>
                <div class="product-item">
                    <div class="discount-container">
                        <p>Giảm <?= htmlspecialchars($product['discount_value']) ?>%</p>
                    </div>
                    <img src="<?= htmlspecialchars(removeLeadingDots($product['img'])) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                    <h5><?= htmlspecialchars($product['product_name']) ?></h5>
                    <div class="rating-container">
                        <div class="rating">
                            <?= renderRatingStars((int)$product['rating']) ?>
                        </div>
                    </div>
                    <p class="views"> <ion-icon name="eye-outline"></ion-icon> <?= htmlspecialchars($product['views']) ?></p>
                    <span class="sale">Sale:
                        <?php
                        $original_price = floatval(str_replace('.', '', $product['Lowest_Price']));
                        $discount_value = floatval($product['discount_value']);
                        $discount_status = $product['discount_status'];
                        if ($discount_value > 0 && $discount_status === 'active') {
                            if ($product['discount_type'] == 'percentage') {
                                $discounted_price = $original_price * (1 - $discount_value / 100);
                            } else {
                                $discounted_price = $original_price - $discount_value;
                            }
                            
                            echo '<span class="text-danger">' . number_format($discounted_price, 0, ',', '.') . ' VND</span>';
                        } else {
                            echo '<span>' . '0' . ' VND</span>';
                        }
                        ?>
                        <br>
                        <span class="discound">Giá gốc: <?= htmlspecialchars(number_format($product['Lowest_Price'], 0, ',', '.')) ?> VNĐ</span>
                    </span>
                    <hr>
                    <p class="content" ><?= limitText($product['description']); ?></p>
                    <hr>
                    <a href="#" class="buy-now">Mua ngay</a>
                    <a href="?act=product_detail&id=<?= $product['id'] ?>" class="learn-more">Xem chi tiết</a>
                </div>
                <?php endforeach; ?>
            </div>
        <button class="scroll-btn right" onclick="scrollProducts('right')"><ion-icon name="chevron-forward-outline"></ion-icon></button>
    </div>
</div>
</body>
</html>