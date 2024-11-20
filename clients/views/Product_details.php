<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
</head>
<div class="container mt-4">
    <!-- Header sản phẩm -->
    <div class="product-header">
        <div class="d-flex align-items-center gap-3 ">
            <div class="name_prd ms-3">
                <p class="product-title mb-1"><?= htmlspecialchars($product['product_name']) ?></p>
            </div>

            <div class="star-rating mb-2">
                <?php
                $rating = isset($product['rating']) ? floatval($product['rating']) : 0; // Giá trị rating từ database
                $maxStars = 5; // Tổng số sao tối đa

                for ($i = 1; $i <= $maxStars; $i++) {
                    $fullStars = floor($rating);
                    $decimal = $rating - $fullStars;

                    if ($i <= $fullStars) {
                        echo '<i class="fa-solid fa-star" style="color: gold; font-size: 20px; margin-right: 5px;"></i>';
                    } elseif ($i - 1 < $rating && $rating < $i) {
                        $starWidth = $decimal * 100; // Tỷ lệ phần sao vàng (0 đến 100)
                        echo '<span style="position: relative; display: inline-block; width: 1em; height: 1em; font-size: 20px; margin-right: 5px;">';
                        // Phần sao vàng
                        echo '<i class="fa-solid fa-star" style="color: gold; position: absolute; width: ' . $starWidth . '%; top: 4px; overflow: hidden; left: 0px;"></i>';
                        // Phần còn lại sao xám
                        echo '<i class="fa-solid fa-star" style="color: lightgray; "></i>';
                        echo '</span>';
                    } else {
                        // Sao rỗng
                        echo '<i class="fa-regular fa-star" style="color: lightgray; font-size: 20px; margin-right: 5px;"></i>';
                    }
                }
                ?>
            </div>
            <span class="text-muted mb-1">(<?= $product['total_comments'] ?> đánh giá)</span>
        </div>
    </div>
    <?php
    function removeLeadingDots($filePath)
    {
        return preg_replace('/^\.\.\//', '', $filePath);
    }
    ?>
    <!-- Hình ảnh sản phẩm -->
    <div class="row">
        <div class="box_products_details col-md-6">
            <div class="product-image swiper-container" style="   height: 300px; overflow: hidden; position: relative;">
                <div class="swiper-wrapper">
                    <?php foreach ($listPrd_Variant as $image): ?>
                    <div class="swiper-slide">
                        <img src="<?= removeLeadingDots($image['images'])  ?>" alt="Product Image"
                            class="img-fluid align-content-center justify-content-center"
                            style="width: 100px; height: 100px; object-fit: cover;">
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Navigation nằm trong product-image -->
                <div class="swiper-button-next"
                    style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); z-index: 10;"></div>
                <div class="swiper-button-prev"
                    style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%); z-index: 10;"></div>
            </div>

            <div class="thumbnails swiper-container mt-3" style="max-width: 500px;">
                <div class="swiper-wrapper">
                    <?php foreach ($listPrd_Variant as $image): ?>
                    <div class="swiper-slide ">
                        <img src="<?= removeLeadingDots($image['images'])  ?>" alt="Thumbnail" class="thumbnail"
                            style="width: 80px;  padding: 5px; border-radius: 5px;">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>



        <!-- Thông tin và lựa chọn sản phẩm -->
        <div class="col-md-6">
            <h5>Chọn dung lượng bộ nhớ và RAM:</h5>
            <div id="variant-container" class="box-option mb-3">
                <?php foreach ($listPrd_Variant as $variant): ?>
                <div class="option justify-content-between align-items-center mb-2"
                    data-id="<?= htmlspecialchars($variant['variant_id']) ?>"
                    data-color="<?= htmlspecialchars($variant['color']) ?>" onclick="selectVariant(this)">
                    <span class="fw-bold"><?= htmlspecialchars($variant['ram']) ?> /
                        <?= htmlspecialchars($variant['storage']) ?></span>
                    <p class="text-muted"><?= number_format($variant['price'], 0, ',', '.') ?> đ</p>
                </div>
                <?php endforeach; ?>
            </div>

            <h5>Chọn màu sắc:</h5>
            <div class="box-option-color d-flex flex-wrap gap-3">
                <?php
                $colors = [];
                foreach ($listPrd_Variant as $color):
                    if (!in_array($color['color'], $colors)) {
                        $colors[] = $color['color']; ?>
                <div class="option-color d-flex justify-content-center align-items-center" style="cursor: pointer;"
                    data-color="<?= htmlspecialchars($color['color']) ?>" onclick="filterVariants(this)">
                    <img src="<?= removeLeadingDots($color['images']) ?>"
                        style="width: 50px; height: 50px; cursor: pointer;" class="color-option">
                    <p class="fw-bold text-center align-items-center "><?= htmlspecialchars($color['color']) ?></p>
                </div>
                <?php
                    }
                endforeach; ?>
            </div>
            <div class="btn-details mt-5 d-flex justify-content-center align-items-center gap-3">
                <a id="buy-now-link" href="http://duan1/?act=pay&id=" class="btn btn-danger w-25"> Mua ngay </a>
                <a id="add-to-cart-link" href="http://duan1/?act=cart&id=" class="btn btn-outline-danger">Thêm vào giỏ
                    hàng</a>    
            </div>



        </div>
    </div>


    <div class="row mt-4">
    <!-- Phần mô tả và đánh giá nằm bên trái -->
    <div class="col-md-8">
        <div class="p-3 border rounded mb-4">
            <h4 class="text-danger text-center">Đặc Điểm Nổi Bật Của <?php echo $product['product_name'] ?></h4>
            <ul>
                <?php
                function splitTextIntoLines($text)
                {
                    return preg_split('/(?<=[.!?])\s+/', trim($text));
                }

                $sentences = splitTextIntoLines($product['description']);
                foreach ($sentences as $sentence) {
                    echo "<li>" . nl2br(htmlspecialchars($sentence)) . "</li>";
                }
                ?>
            </ul>
        </div>

        <div class="review-section p-3 border rounded">
            <h4 class="review-title">Đánh giá & nhận xét iPhone 16 Pro Max 512GB | Chính hãng VN/A</h4>
            <div class="d-flex align-items-center mb-3">
                <div class="star-rating me-3" style="font-size: 2rem; color: gold;">
                    &#9733;&#9733;&#9733;&#9733;&#9733;
                </div>
                <div>
                    <span>5.0/5</span> (8 đánh giá)
                </div>
            </div>
            <h5>Đánh giá theo trải nghiệm</h5>
            <div class="d-flex justify-content-between align-items-center">
                <span>5 sao</span>
                <div class="rating-bar" style="flex: 1; margin: 0 10px; height: 10px; background-color: #f0f0f0;">
                    <div class="rating-bar-fill" style="width: 100%; height: 100%; background-color: #ffcc00;"></div>
                </div>
                <span>8 đánh giá</span>
            </div>
            <!-- Thêm phần cho các đánh giá từ 1 đến 4 sao -->
        </div>
    </div>

    <!-- Phần thông số kỹ thuật nằm bên phải -->
    <div class="col-md-4">
        <div class="p-3 border rounded">
            <h4 class="text-dark">Thông số kỹ thuật</h4>
            <table class="table table-bordered">
                <tbody>
                    <?php foreach ($list_spect as $index => $spec) : ?>
                    <tr class="<?php echo $index % 2 == 0 ? 'bg-light' : ''; ?>">
                        <td class="font-weight-bold" style="width: 40%;"><?php echo htmlspecialchars($spec['Specification_Name']); ?></td>
                        <td><?php echo htmlspecialchars($spec['Specification_Value']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>


<style>
.option {
    transition: all 0.3s ease;
    border: 2px solid transparent;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    border-radius: 8px;
    cursor: pointer;
}

.option:hover {
    transform: scale(1.001);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.option.selected {
    border-color: red;
    transform: scale(1.001);
}

.option-color {
    transition: all 0.3s ease;
    border: 2px solid transparent;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    border-radius: 8px;
}

.option-color:hover {
    transform: scale(1.001);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    /* Shadow mạnh hơn khi hover */
}

/* Khi được chọn (viền màu đỏ) */
.option-color.selected {
    border-color: red;
    /* Viền đỏ khi được chọn */
    transform: scale(1.01);
    /* Phóng to như khi hover */
}
</style>

<script>
function selectVariant(element) {
    const options = document.querySelectorAll('#variant-container .option');

    // Xóa lớp "selected" khỏi tất cả các lựa chọn
    options.forEach(option => option.classList.remove('selected'));

    // Thêm lớp "selected" vào lựa chọn được chọn
    element.classList.add('selected');

    // Lấy ID của biến thể được chọn
    const selectedVariantId = element.getAttribute('data-id');

    // Cập nhật href của thẻ <a>
    const buyNowLink = document.getElementById('buy-now-link');
    const addtocartLink = document.getElementById('add-to-cart-link');
    if (buyNowLink) {
        const newHref = `http://duan1/?act=pay&id=${selectedVariantId}`;
        buyNowLink.setAttribute('href', newHref);
    }
    if (addtocartLink) {
        const newHref = `http://duan1/?act=cart&id=${selectedVariantId}`;
        addtocartLink.setAttribute('href', newHref);
    }
}

var mainSlider = new Swiper('.product-image', {
    slidesPerView: 1,
    spaceBetween: 10,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    loop: true, // Cho phép lặp lại ảnh
});

let selectedVariantId = null; // Lưu id của biến thể được chọn




function filterVariants(element) {
    const selectedColor = element.getAttribute('data-color'); // Lấy màu sắc được chọn
    const variants = document.querySelectorAll('#variant-container .option'); // Tất cả các biến thể
    const colorOptions = document.querySelectorAll('.option-color'); // Tất cả các màu sắc

    // Xóa lớp "selected" khỏi tất cả các màu sắc
    colorOptions.forEach(option => {
        option.classList.remove('selected');
    });

    // Thêm lớp "selected" vào màu sắc được chọn
    element.classList.add('selected');

    // Ẩn tất cả các biến thể
    variants.forEach(variant => {
        variant.style.display = 'none';
    });

    // Hiển thị các biến thể phù hợp
    variants.forEach(variant => {
        if (variant.getAttribute('data-color') === selectedColor) {
            variant.style.display = 'block'; // Hiện biến thể phù hợp
        }
    });
}


var mainSlider = new Swiper('.product-image', {
    slidesPerView: 1,
    spaceBetween: 10,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    thumbs: {
        swiper: thumbnailSlider
    }
});

// Khởi tạo slider ảnh nhỏ
var thumbnailSlider = new Swiper('.thumbnails', {
    slidesPerView: 4, // Số lượng ảnh nhỏ hiển thị
    spaceBetween: 10,
    freeMode: true,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
    breakpoints: {
        768: {
            slidesPerView: 3,
        },
        1024: {
            slidesPerView: 4,
        }
    }
});

// Kết nối với slider chính
mainSlider.controller.control = thumbnailSlider;
thumbnailSlider.controller.control = mainSlider;
</script>