<head>
    <link rel="stylesheet" href="./assets/css/client.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="icon" href="./assets/img/logo.png">
</head>
<div class="slide-container" data-aos="fade-down">
    <div class="slides">
        <?php foreach ($banners as $index => $banner) : ?>
            <img src="./uploads/BannerIMG/<?= $banner['img_url'] ?>" class="<?= $index === 0 ? 'active' : '' ?>" alt="Banner Image <?= $index + 1 ?>">
        <?php endforeach; ?>
    </div>
    
    <div class="dotsContainer">
        <?php foreach ($banners as $index => $banner) : ?>
            <span class="dot <?= $index === 0 ? 'active' : '' ?>" attr="<?= $index ?>" onclick="switchImage(this)"></span>
            <?php endforeach; ?>
        </div>
    </div>
    
<div class="container" data-aos="fade-up">
    <h1 class="event-title">Chương trình và Sự kiện</h1>
    <a href="#" class="view-all">Xem tất cả &gt;</a>
    <div class="event-container">
        <div class="event-item">
            <img src="https://duet-cdn.vox-cdn.com/thumbor/0x0:1679x1319/2400x1885/filters:focal(840x660:841x661):format(webp)/cdn.vox-cdn.com/uploads/chorus_asset/file/25589537/Screenshot_2024_08_26_at_12.00.35_PM.png" alt="Event 1">
            <p>Review sản phẩm - Nhận quà liền tay</p>
        </div>
        <div class="event-item">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS2Ofbp25udJPNMoJLGS5JEFsbMrhDwD77d8w&s" alt="Event 2">
            <p>Ưu đãi Education</p>
        </div>
        <div class="event-item">
            <img src="https://cdn.shopify.com/s/files/1/0024/0684/2441/files/Blog-REDMAGIC-8S-Pro-Launch-Event-Winners-960x480.jpg?v=1690448232" alt="Event 3">
            <p>Mua RedMagic 8S Pro nhận ngay game độc quyền</p>
        </div>
    </div>
</div>

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
    <h1 class="product-title">Sản phẩm bán chạy</h1>
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
                    <span class="sale">
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
                            
                            echo '<span class="text-danger">' . number_format($discounted_price, 0, ',', '.') . '₫</span>';
                        } else {
                            echo '<span>' . '0' . ' ₫</span>';
                        }
                        ?>
                    </span>
                        <br>
                        <span class="discound"><?= htmlspecialchars(number_format($product['Lowest_Price'], 0, ',', '.')) ?>₫</span>
                        <span class="save">SAVE: <?= htmlspecialchars(number_format($product['Lowest_Price'] - $discounted_price, 0, ',', '.')) ?>₫</span>
                    <p class="content-warp" >Mức giá này có thể không ứng với các thông số kỹ thuật bên dưới.</p>
                    <hr>    
                    <a href="#" class="buy-now">Mua ngay</a>
                    <a href="?act=product_detail&id=<?= $product['id'] ?>" class="learn-more">Xem chi tiết</a>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="scroll-btn right" onclick="scrollProducts('right')"><ion-icon name="chevron-forward-outline"></ion-icon></button>
    </div>
</div>


<div class="container" data-aos="fade-up">
    <h1 class="product-title">Sản phẩm có đánh giá cao</h1>
    <div class="product-container-wrapper">
        <button class="scroll-btn left" onclick="scrollProducts1('left1')"><ion-icon name="chevron-back-outline"></ion-icon></button>
        <div class="product-container" id="product_container1">
            <?php
            usort($products, function($a, $b) {
                return $b['rating'] - $a['rating'];
            });
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
                    <p class="views"><ion-icon name="eye-outline"></ion-icon> <?= htmlspecialchars($product['views']) ?></p>
                    <span class="sale">
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
                            
                            echo '<span class="text-danger">' . number_format($discounted_price, 0, ',', '.') . ' ₫</span>';
                        } else {
                            echo '<span>' . '0' . ' ₫</span>';
                        }
                        ?>
                    </span>
                        <br>
                        <span class="discound"><?= htmlspecialchars(number_format($product['Lowest_Price'], 0, ',', '.')) ?>₫</span>
                        <span class="save">SAVE: <?= htmlspecialchars(number_format($product['Lowest_Price'] - $discounted_price, 0, ',', '.')) ?>₫</span>
                    <p class="content-warp" >Mức giá này có thể không ứng với các thông số kỹ thuật bên dưới.</p>
                    <hr>    
                    <a href="#" class="buy-now">Mua ngay</a>
                    <a href="?act=product_detail&id=<?= $product['id'] ?>" class="learn-more">Xem chi tiết</a>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="scroll-btn right" onclick="scrollProducts1('right1')"><ion-icon name="chevron-forward-outline"></ion-icon></button>
    </div>
</div>


<div class="container" data-aos="fade-up">
    <h1 class="product-title">Sản phẩm giảm giá</h1>
    <div class="product-container-wrapper">
        <button class="scroll-btn left" onclick="scrollProducts2('left2')"><ion-icon name="chevron-back-outline"></ion-icon></button>
        <div class="product-container" id="product_container2">
            <?php
            usort($products, function($a, $b) {
                return $b['discount_value'] - $a['discount_value'];
            });
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
                    <span class="sale">
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
                            
                            echo '<span class="text-danger">' . number_format($discounted_price, 0, ',', '.') . ' ₫</span>';
                        } else {
                            echo '<span>' . '0' . ' ₫</span>';
                        }
                        ?>
                    </span>
                        <br>
                        <span class="discound"><?= htmlspecialchars(number_format($product['Lowest_Price'], 0, ',', '.')) ?>₫</span>
                        <span class="save">SAVE: <?= htmlspecialchars(number_format($product['Lowest_Price'] - $discounted_price, 0, ',', '.')) ?>₫</span>
                    <p class="content-warp" >Mức giá này có thể không ứng với các thông số kỹ thuật bên dưới.</p>
                    <hr>    
                    <a href="#" class="buy-now">Mua ngay</a>
                    <a href="?act=product_detail&id=<?= $product['id'] ?>" class="learn-more">Xem chi tiết</a>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="scroll-btn right" onclick="scrollProducts2('right2')"><ion-icon name="chevron-forward-outline"></ion-icon></button>
    </div>
</div>

<script>
  AOS.init();
</script>
<script src="./assets/js/client.js"></script>