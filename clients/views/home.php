<head>
    <link rel="stylesheet" href="./assets/css/client.css">
</head>
<style type="text/css">
    .slide-container {
        position: relative;
        width: 100%;
        height: 660px;
        margin: 0 auto;
    }

    .slides {
        width: 100%;
        height: calc(100% - 40px);
        position: relative;
        overflow: hidden;
    }

    .slides img {
        width: 100%;
        height: 100%;
        position: absolute;
        object-fit: cover;
    }

    .slides img:not(.active) {
        top: 0;
        left: -100%;
    }

    .next,
    .prev {
        width: 50px;
        height: 50px;
        background-color: #fff5;
        color: white;
        border: none;
        font-weight: bold;
        font-family: monospace;
        border-radius: 50%;
    }

    .next:hover,
    .prev:hover {
        background-color: white;
        color: black;
        opacity: 0.8;
    }

    .dotsContainer {
        position: absolute;
        bottom: 60px;
        /* Đặt cách đáy một chút để hiển thị rõ hơn */
        z-index: 3;
        left: 50%;
        transform: translateX(-50%);
    }

    .dot {
        width: 35px;
        height: 6px;
        margin: 0px 2px;
        border-radius: 20px;
        display: inline-block;
        cursor: pointer;
        transition: background-color 0.6s ease;
        background-color: #cccc;
    }



    @keyframes next1 {
        from {
            left: 0%;
        }

        to {
            left: -100%;
        }
    }

    @keyframes next2 {
        from {
            left: 100%;
        }

        to {
            left: 0%;
        }
    }

    @keyframes prev1 {
        from {
            left: 0%;
        }

        to {
            left: 100%;
        }
    }

    @keyframes prev2 {
        from {
            left: -100%;
        }

        to {
            left: 0%;
        }
    }
</style>

<div class="slide-container">
    <div class="slides">
        <?php foreach ($banners as $index => $banner) : ?>
            <img src="./uploads/BannerIMG/<?= $banner['img_url'] ?>" class="<?= $index === 0 ? 'active' : '' ?>" alt="Banner Image <?= $index + 1 ?>">
        <?php endforeach; ?>
    </div>

    <div class="buttons">
        <span class="prev" onclick="slidePrev()"><ion-icon name="arrow-back-outline"></ion-icon></span>
        <span class="next" onclick="slideNext()"><ion-icon name="arrow-forward-outline"></ion-icon></span>
    </div>

    <div class="dotsContainer">
        <?php foreach ($banners as $index => $banner) : ?>
            <span class="dot <?= $index === 0 ? 'active' : '' ?>" attr="<?= $index ?>" onclick="switchImage(this)"></span>
        <?php endforeach; ?>
    </div>
</div>

<?php
function removeLeadingDots($filePath)
{
    return preg_replace('/^\.\.\//', '', $filePath);
}

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
<h1 class="product-title">Sản phẩm bán chạy</h1>
<div class="product-container">
    <?php
    usort($products, function($a, $b) {
        return $b['views'] - $a['views'];
    });
    ?>
    <?php foreach ($products as $product) : ?>
        <div class="product-item">
            <div class="discount-container">
                <p>Giảm <?= htmlspecialchars($product['discount_value']) ?>%</p>
            </div>
            <img src="<?= htmlspecialchars(removeLeadingDots($product['img'])) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
            <hr>
            <h5><?= htmlspecialchars($product['product_name']) ?></h5>
            <div class="rating-container">
                <div class="rating">
                    <?= renderRatingStars((int)$product['rating']) ?>
                </div>
                <h7><?= htmlspecialchars($product['rating']) ?></h7>
                <p class="views"> <ion-icon name="eye-outline"></ion-icon> <?= htmlspecialchars($product['views']) ?></p>
            </div>
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
                <span class="discound"><?= htmlspecialchars(number_format($product['Lowest_Price'], 0, ',', '.')) ?> VNĐ</span>
            </span>
            <hr>
            <a href="#" class="buy-now">Mua ngay</a>
            <a href="#" class="learn-more">Xem chi tiết</a>
        </div>
    <?php endforeach; ?>
</div>


<h1 class="product-title">Sản phẩm được đánh giá cao</h1>
<div class="product-container">
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
            <hr>
            <h5><?= htmlspecialchars($product['product_name']) ?></h5>
            <div class="rating-container">
                <div class="rating">
                    <?= renderRatingStars((int)$product['rating']) ?>
                </div>
                <h7><?= htmlspecialchars($product['rating']) ?></h7>
                <p class="views"> <ion-icon name="eye-outline"></ion-icon> <?= htmlspecialchars($product['views']) ?></p>
            </div>
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
                <span class="discound"><?= htmlspecialchars(number_format($product['Lowest_Price'], 0, ',', '.')) ?> VNĐ</span>
            </span>
            <hr>
            <a href="#" class="buy-now">Mua ngay</a>
            <a href="#" class="learn-more">Xem chi tiết</a>
        </div>
    <?php endforeach; ?>
</div>



<h1 class="product-title">Sản phẩm Giảm giá sâu</h1>
<div class="product-container">
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
            <hr>
            <h5><?= htmlspecialchars($product['product_name']) ?></h5>
            <div class="rating-container">
                <div class="rating">
                    <?= renderRatingStars((int)$product['rating']) ?>
                </div>
                <h7><?= htmlspecialchars($product['rating']) ?></h7>
                <p class="views"> <ion-icon name="eye-outline"></ion-icon> <?= htmlspecialchars($product['views']) ?></p>
            </div>
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
                <span class="discound"><?= htmlspecialchars(number_format($product['Lowest_Price'], 0, ',', '.')) ?> VNĐ</span>
            </span>
            <hr>
            <a href="#" class="buy-now">Mua ngay</a>
            <a href="#" class="learn-more">Xem chi tiết</a>
        </div>
    <?php endforeach; ?>
</div>


<script>
    let slideImages = document.querySelectorAll('.slides img');
    let next = document.querySelector('.next');
    let prev = document.querySelector('.prev');
    let dots = document.querySelectorAll('.dot');
    let counter = 0;

    function slideNext() {
        slideImages[counter].style.animation = 'next1 0.5s ease-in forwards';
        counter = (counter + 1) % slideImages.length;
        slideImages[counter].style.animation = 'next2 0.5s ease-in forwards';
        indicators();
    }

    function slidePrev() {
        slideImages[counter].style.animation = 'prev1 0.5s ease-in forwards';
        counter = (counter === 0) ? slideImages.length - 1 : counter - 1;
        slideImages[counter].style.animation = 'prev2 0.5s ease-in forwards';
        indicators();
    }

    function autoSliding() {
        deleteInterval = setInterval(slideNext, 3000);
    }
    autoSliding();

    const container = document.querySelector('.slide-container');
    container.addEventListener('mouseover', () => clearInterval(deleteInterval));
    container.addEventListener('mouseout', autoSliding);

    function indicators() {
        dots.forEach(dot => dot.classList.remove('active'));
        dots[counter].classList.add('active');
    }

    function switchImage(currentImage) {
        let imageId = parseInt(currentImage.getAttribute('attr'));
        if (imageId !== counter) {
            slideImages[counter].style.animation = imageId > counter ? 'next1 0.5s ease-in forwards' : 'prev1 0.5s ease-in forwards';
            counter = imageId;
            slideImages[counter].style.animation = imageId > counter ? 'next2 0.5s ease-in forwards' : 'prev2 0.5s ease-in forwards';
            indicators();
        }
    }
    function scrollProducts(direction) {
    const container = document.querySelector('.product-container');
    const scrollAmount = 300; // Số lượng pixel di chuyển mỗi lần nhấn nút

    if (direction === 'left') {
        container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    } else if (direction === 'right') {
        container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    }
}
</script>