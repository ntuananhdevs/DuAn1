<!-- <head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
</head> -->
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
                        echo '<i class="fa-solid fa-star" style="color: gold; position: absolute; width: '.$starWidth.'%; top: 4px; overflow: hidden; left: 0px;"></i>';
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


    <!-- Hình ảnh sản phẩm -->
    <div class="row">
        <div class="box_products_details col-md-6">
            <!-- Slider chính (chỉ nằm trong .product-image) -->
            <div class="product-image swiper-container" style="   height: 300px; overflow: hidden; position: relative;">
                <div class="swiper-wrapper">
                    <?php foreach ($listPrd_Variant as $image): ?>
                        <div class="swiper-slide">
                            <img src="<?= $image['images'] ?>" alt="Product Image" class="img-fluid align-content-center justify-content-center" style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Navigation nằm trong product-image -->
                <div class="swiper-button-next" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); z-index: 10;"></div>
                <div class="swiper-button-prev" style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%); z-index: 10;"></div>
            </div>

            <div class="thumbnails swiper-container mt-3" style="max-width: 500px;">
                <div class="swiper-wrapper">
                    <?php foreach ($listPrd_Variant as $image): ?>
                        <div class="swiper-slide">
                            <img src="<?= $image['images'] ?>" alt="Thumbnail" class="thumbnail" style="width: 80px;  padding: 5px; border-radius: 5px;">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Thông tin và lựa chọn sản phẩm -->
        <div class="col-md-6">
            <div class="option-group">
                <div class="box-option">
                    <div class="option">
                        <span class="fw-bold">1TB</span>
                        <p>46.490.000 đ</p>
                    </div>
                    <div class="option">
                        <span class="fw-bold">1TB</span>
                        <p>46.490.000 đ</p>
                    </div>
                </div>
            </div>

            <div class="option-group-color mt-4">
                <h5>Chọn màu để xem giá và chi nhánh có hàng</h5>
                <div class="box-option-color">
                    <div class="option-color d-flex justify-content-center align-items-center">
                        <img src="uploads/Products/673a293d4ef22_iphone-16-1.webp" alt="Titan Tự Nhiên" style="width: 40px; height: 40px;">
                        <p clas s="fw-bold justify-content-center align-items-center">Titan Tự Nhiên</p>
                    </div>
                    <div class="option-color d-flex justify-content-center align-items-center">
                        <img src="uploads/Products/673a293d4ef22_iphone-16-1.webp" alt="Titan Tự Nhiên" style="width: 40px; height: 40px;">
                        <p class="fw-bold justify-content-center align-items-center">Titan Tự Nhiên</p>
                    </div>
                    <div class="option-color d-flex justify-content-center align-items-center">
                        <img src="uploads/Products/673a293d4ef22_iphone-16-1.webp" alt="Titan Tự Nhiên" style="width: 40px; height: 40px;">
                        <p class="fw-bold justify-content-center align-items-center">Titan Tự Nhiên</p>
                    </div>
                    <div class="option-color d-flex justify-content-center align-items-center">
                        <img src="uploads/Products/673a293d4ef22_iphone-16-1.webp" alt="Titan Tự Nhiên" style="width: 40px; height: 40px;">
                        <p class="fw-bold justify-content-center align-items-center">Titan Tự Nhiên</p>
                    </div>

                </div>
            </div>

            <div class="btn-details mt-5 d-flex justify-content-center align-items-center gap-3">
                <button type="button" class="btn btn-danger w-25">Mua ngay</button>
                <button type="button" class="btn btn-danger ">Them vao gio hang</button>
            </div>
        </div>
    </div>
    <!-- Giá sản phẩm -->

    <div class="row mt-4 d-flex gap-3">
        <!-- Đặc điểm nổi bật -->

        <div class="description d-flex gap-4">
            <div class="col-md-8 p-3 border rounded">
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
            <div class="col-md-4 p-3 border rounded">
                <h4 class="text-dark">Thông số kỹ thuật</h4>
                <table class="table table-bordered">
                    <tbody>
                        <?php foreach ($list_spect as $index => $spec) : ?>
                            <tr class="<?php echo $index % 2 == 0 ? 'bg-light' : ''; ?>">
                                <td class="font-weight-bold" style="width: 20%;"><?php echo htmlspecialchars($spec['Specification_Name']); ?></td>
                                <td><?php echo htmlspecialchars($spec['Specification_Value']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Đánh giá sản phẩm -->
    <div class="review-section mt-4">
        <h4 class="review-title">Đánh giá & nhận xét iPhone 16 Pro Max 512GB | Chính hãng VN/A</h4>
        <div class="d-flex align-items-center">
            <div class="star-rating mr-3" style="font-size: 2rem;">
                &#9733;&#9733;&#9733;&#9733;&#9733;
            </div>
            <div>
                <span>5.0/5</span> (8 đánh giá)
            </div>
        </div>
        <div class="mt-3">
            <h5>Đánh giá theo trải nghiệm</h5>
            <div class="d-flex justify-content-between align-items-center">
                <span>5 sao</span>
                <div class="rating-bar">
                    <div class="rating-bar-fill" style="width: 100%;"></div>
                </div>
                <span>8 đánh giá</span>
            </div>
            <!-- Thêm phần cho các đánh giá từ 1 đến 4 sao tương tự -->
        </div>
    </div>
</div>
</div>

<script>
    // Khởi tạo slider chính chỉ nằm trong .product-image
    var mainSlider = new Swiper('.product-image', {
        slidesPerView: 1,
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        loop: true, // Cho phép lặp lại ảnh
    });

    // const options = document.querySelectorAll('.option');

    // options.forEach(option => {
    //     option.addEventListener('click', () => {
    //         // Loại bỏ trạng thái active trước đó
    //         document.querySelectorAll('.option.active').forEach(active => active.classList.remove('active'));
    //         // Thêm trạng thái active cho phần tử được chọn
    //         option.classList.add('active');
    //     });
    // });
    // Khởi tạo slider chính
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