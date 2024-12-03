<head>
    <link rel="stylesheet" href="./assets/css/client.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <link rel="icon" href="./assets/img/logo.png">
</head>
<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-aos="fade-down">
    <!-- Indicators/Dots -->
    <div class="carousel-indicators">
        <?php foreach ($banners as $index => $banner): ?>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?= $index ?>"
                class="<?= $index === 0 ? 'active' : '' ?>"
                aria-current="<?= $index === 0 ? 'true' : 'false' ?>"
                aria-label="Slide <?= $index + 1 ?>"></button>
        <?php endforeach; ?>
    </div>


    <!-- Slides -->
    <div class="carousel-inner">
        <?php foreach ($banners as $index => $banner): ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <img src="./uploads/BannerIMG/<?= htmlspecialchars($banner['img_url']) ?>" class="d-block w-100" alt="Banner Image <?= $index + 1 ?>" style="height: 600px; object-fit: cover;">
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Navigation controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>


<div class="container mt-5" data-aos="fade-up">
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


function renderRatingStars($rating, $maxStars = 5, $colorFull = 'yellow', $colorEmpty = 'lightgray', $size = '10px')
{
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
    <h4 class="product-title mb-4 mt-4 fw-400">Sản phẩm bán chạy</h4>
    <div class="product-container-wrapper">
        <button class="scroll-btn left" onclick="scrollProducts('left')"><ion-icon name="chevron-back-outline"></ion-icon></button>
        <div class="product-container">
            <?php
            usort($products, function ($a, $b) {
                return $b['views'] - $a['views'];
            });
            function limitText($text, $limit = 50)
            {
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

                    <div class="price-home mb-0 mt-2">
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

                            echo '<p>' . number_format($discounted_price, 0, ',', '.') . ' ₫</p>';
                        } else {
                            echo '<span>' . '0' . ' ₫</span>';
                        }
                        ?>
                    </div>
                    <div class="price-save d-flex gap-3 mt-0">
                        <p class="discound-1 text-decoration-line-through" style="font-size: 1rem"><?= htmlspecialchars(number_format($product['Lowest_Price'], 0, ',', '.')) ?>₫</p>
                        <p class="save-2 text-danger" style="font-size: 1rem">SAVE: <?= htmlspecialchars(number_format($product['Lowest_Price'] - $discounted_price, 0, ',', '.')) ?>₫</p>
                    </div>
                    <a href="?act=product_detail&id=<?= $product['id'] ?>" class="buy-now">Mua ngay</a>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="scroll-btn right" onclick="scrollProducts('right')"><ion-icon name="chevron-forward-outline"></ion-icon></button>
    </div>
</div>


<div class="container" data-aos="fade-up">
    <h5 class="product-title mb-4 mt-4 fw-400">Sản phẩm có đánh giá cao</h5>
    <div class="product-container-wrapper">
        <button class="scroll-btn left" onclick="scrollProducts1('left1')"><ion-icon name="chevron-back-outline"></ion-icon></button>
        <div class="product-container" id="product_container1">
            <?php
            usort($products, function ($a, $b) {
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

                    <div class="price-home mb-0 mt-2">
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

                            echo '<p>' . number_format($discounted_price, 0, ',', '.') . ' ₫</p>';
                        } else {
                            echo '<span>' . '0' . ' ₫</span>';
                        }
                        ?>
                    </div>
                    <div class="price-save d-flex gap-3 mt-0">
                        <p class="discound-1 text-decoration-line-through" style="font-size: 1rem"><?= htmlspecialchars(number_format($product['Lowest_Price'], 0, ',', '.')) ?>₫</p>
                        <p class="save-2 text-danger" style="font-size: 1rem">SAVE: <?= htmlspecialchars(number_format($product['Lowest_Price'] - $discounted_price, 0, ',', '.')) ?>₫</p>
                    </div>
                    <a href="?act=product_detail&id=<?= $product['id'] ?>" class="buy-now">Mua ngay</a>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="scroll-btn right" onclick="scrollProducts1('right1')"><ion-icon name="chevron-forward-outline"></ion-icon></button>
    </div>
</div>


<div class="container" data-aos="fade-up">
    <h4 class="product-title mb-4 mt-4 fw-400">Sản phẩm giảm giá</h4>
    <div class="product-container-wrapper">
        <button class="scroll-btn left" onclick="scrollProducts2('left2')"><ion-icon name="chevron-back-outline"></ion-icon></button>
        <div class="product-container" id="product_container2">
            <?php
            usort($products, function ($a, $b) {
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

                    <div class="price-home mb-0 mt-2">
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

                            echo '<p>' . number_format($discounted_price, 0, ',', '.') . ' ₫</p>';
                        } else {
                            echo '<span>' . '0' . ' ₫</span>';
                        }
                        ?>
                    </div>
                    <div class="price-save d-flex gap-3 mt-0">
                        <p class="discound-1 text-decoration-line-through" style="font-size: 1rem"><?= htmlspecialchars(number_format($product['Lowest_Price'], 0, ',', '.')) ?>₫</p>
                        <p class="save-2 text-danger" style="font-size: 1rem">SAVE: <?= htmlspecialchars(number_format($product['Lowest_Price'] - $discounted_price, 0, ',', '.')) ?>₫</p>
                    </div>
                    <a href="?act=product_detail&id=<?= $product['id'] ?>" class="buy-now">Mua ngay</a>
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