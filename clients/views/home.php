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
function removeLeadingDots($filePath) {
    return preg_replace('/^\.\.\//', '', $filePath);
}
?>

<div class="product-container">
    <?php foreach ($products as $product) : ?>
        <div class="product-item">
            <div class="discount-container">
                <p>Giảm <?= htmlspecialchars($product['discount_value']) ?>%</p>
            </div>
            <img src="<?= htmlspecialchars(removeLeadingDots($product['img'])) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
            <h2><?= htmlspecialchars($product['product_name']) ?></h2>
            <p> <i class="fa-solid fa-eye"></i> <?= htmlspecialchars($product['views']) ?></p>
            <p>Giá: <?= htmlspecialchars(number_format($product['Lowest_Price'], 0, ',', '.')) ?> VNĐ</p>
            <a href="#" class="learn-more">Mua ngay</a>
            <a href="?act=product_detail&id=<?= $product['id'] ?>" class="learn-more">Xem chi tiết</a>
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
</script>