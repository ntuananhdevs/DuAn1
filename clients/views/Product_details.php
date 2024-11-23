<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<div class="container mt-4 mb-4">
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
            <div class="product-image swiper-container main-slider" style="height: 400px; overflow: hidden; position: relative;">
                <div class="swiper-wrapper">
                    <?php
                    $uniqueImages = [];
                    $colorsSeen = [];

                    foreach ($listPrd_Variant as $image) {
                        $color = $image['color'];
                        if (!in_array($color, $colorsSeen)) {
                            $uniqueImages[] = $image;
                            $colorsSeen[] = $color;
                        }
                    }

                    // Hiển thị ảnh đã lọc trong phần Main Slider
                    foreach ($uniqueImages as $image): ?>
                        <div class="swiper-slide d-flex align-content-center justify-content-center align-items-center"
                            data-color="<?= htmlspecialchars($image['color']) ?>">
                            <img src="<?= removeLeadingDots($image['images']) ?>" alt="Product Image"
                                class="img-fluid align-content-center justify-content-center"
                                style="width: 250px; height: 250px; object-fit: cover; align-items: center">
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-button-next"
                    style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); z-index: 10;"></div>
                <div class="swiper-button-prev"
                    style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%); z-index: 10;"></div>
            </div>


            <div class="thumbnails swiper-container thumbnail-slider mt-3">
                <div class="swiper-wrapper gap-1 box-shadow">
                    <?php
                    // Lọc ảnh để chỉ lấy một ảnh duy nhất cho mỗi màu
                    $uniqueThumbnails = [];
                    $colorsSeen = [];

                    foreach ($listPrd_Variant as $image) {
                        $color = $image['color'];
                        if (!in_array($color, $colorsSeen)) {
                            $uniqueThumbnails[] = $image;
                            $colorsSeen[] = $color; // Lưu lại màu đã gặp
                        }
                    }

                    // Hiển thị ảnh đã lọc trong phần Thumbnail Slider
                    foreach ($uniqueThumbnails as $image): ?>
                        <div class="swiper-slide" data-color="<?= htmlspecialchars($image['color']) ?>" style="cursor: pointer; max-width: 80px;  ">
                            <img src="<?= removeLeadingDots($image['images']) ?>" alt="Thumbnail" class="thumbnail"
                                style="width: 60px; height: 60px; padding: 5px; border-radius: 5px;">
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
                    <?php
                    // Lấy giá gốc và thông tin giảm giá
                    $price = $variant['price']; // Giá gốc
                    $discount_value = $variant['discount_value']; // Giá trị giảm giá
                    $discount_type = $variant['discount_type']; // Loại giảm giá (phần trăm hoặc số tiền)

                    // Tính toán giá sau giảm
                    $discounted_price = $price; // Mặc định giá sau giảm là giá gốc

                    if ($discount_type == 'percentage' && $discount_value > 0) {
                        // Giảm theo phần trăm
                        $discounted_price = $price - ($price * $discount_value / 100);
                    } elseif ($discount_type == 'fixed' && $discount_value > 0) {
                        // Giảm theo số tiền
                        $discounted_price = $price - $discount_value;
                    }

                    // Đảm bảo giá sau giảm không âm
                    $discounted_price = max($discounted_price, 0);
                    ?>

                    <div class="option justify-content-between align-items-center mb-2"
                        data-id="<?= htmlspecialchars($variant['variant_id']) ?>"
                        data-color="<?= htmlspecialchars($variant['color']) ?>"
                        data-price="<?= htmlspecialchars($variant['price']) ?>"
                        data-discount-value="<?= htmlspecialchars($variant['discount_value']) ?>"
                        data-discount-type="<?= htmlspecialchars($variant['discount_type']) ?>"
                        onclick="selectVariant(this)">
                        <span class="fw-bold"><?= htmlspecialchars($variant['ram']) ?> /
                            <?= htmlspecialchars($variant['storage']) ?></span>

                        <p class="text-muted">
                            <!-- Hiển thị giá giảm -->
                            <?php if ($discounted_price < $price): ?>
                                <span><?= number_format($discounted_price, 0, ',', '.') ?> đ</span>
                            <?php else: ?>
                                <span class="fw-bold"><?= number_format($price, 0, ',', '.') ?> đ</span>
                            <?php endif; ?>
                        </p>
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
                        <div class="option-color d-flex align-content-center justify-content-center align-items-center" style="cursor: pointer; width: 120px;  height: 60px;"
                            data-color="<?= htmlspecialchars($color['color']) ?>" onclick="filterVariants(this)">
                            <img src="<?= removeLeadingDots($color['images']) ?>"
                                style="width: 45px; height: 45px; cursor: pointer;" class="color-option">
                            <p class="fw-bold d-flex align-content-center justify-content-center align-items-center mt-3"><?= htmlspecialchars($color['color']) ?></p>
                        </div>
                <?php
                    }
                endforeach; ?>
            </div>

            <!-- Hiển thị giá biến thể đã chọn -->
            <div class="price_products_variants d-flex justify-content-center align-items-center mt-3">
                <div class="discount bg-danger w-25 h-100 d-flex justify-content-center align-items-center">
                    <p id="variant-discount" style="font-size: 16px;"></p>
                </div>
                <div class="price-vi text-center">
                    <p id="variant-price" style="font-size: 19px; font-weight: bold; color: red;"></p>
                    <p id="variant-original-price" style="font-size: 14px; color: #888;"></p>
                </div>


            </div>

            <div class="btn-details mt-5 d-flex justify-content-center align-items-center gap-3">
                <a id="buy-now-link" href="?act=pay&id=" class="btn btn-danger w-25"> Mua ngay </a>

                <form id="add-to-cart-form" action="?act=add_to_cart" method="POST">
                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                    <input type="hidden" name="product_id" id="selected-variant-id" value="">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="price" id="selected-variant-price" value="">
                    <button type="submit" class="btn btn-outline-danger">Thêm vào giỏ hàng</button>
                </form>
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

                <div class="review-section p-3 border rounded ">
                    <p class="review-title">Đánh giá & nhận xét <?= htmlspecialchars($product['product_name']) ?></p>
                    <div class="total d-flex justify-content-center gap-5   ">
                        <div class="text-center" style="border-right: 1px solid #d1d5db; padding-right: 50px">
                            <div class="average-rating" style="margin-right: 40px; align-items: center;">
                                <h4><?= number_format($product['rating'], 1) ?>/5</h4>
                                <div class="star-rating mb-2">
                                    <?php
                                    $rating = isset($product['rating']) ? floatval($product['rating']) : 0;
                                    $maxStars = 5;

                                    for ($i = 1; $i <= $maxStars; $i++) {
                                        $fullStars = floor($rating);
                                        $decimal = $rating - $fullStars;

                                        if ($i <= $fullStars) {
                                            echo '<i class="fa-solid fa-star" style="color: gold; font-size: 20px; margin-right: 5px;"></i>';
                                        } elseif ($i - 1 < $rating && $rating < $i) {
                                            $starWidth = $decimal * 100;
                                            echo '<span style="position: relative; display: inline-block; width: 1em; height: 1em; font-size: 20px; margin-right: 5px;">';
                                            echo '<i class="fa-solid fa-star" style="color: gold; position: absolute; width: ' . $starWidth . '%; top: 4px; overflow: hidden; left: 0px;"></i>';
                                            echo '<i class="fa-solid fa-star" style="color: lightgray;"></i>';
                                            echo '</span>';
                                        } else {
                                            echo '<i class="fa-regular fa-star" style="color: lightgray; font-size: 20px; margin-right: 5px;"></i>';
                                        }
                                    }
                                    ?>
                                </div>
                                <a href="#" class="text-primary"><?= $product['total_comments'] ?> đánh giá</a>
                            </div>
                        </div>
                        <div class="total_rating">

                            <h5>Đánh giá theo trải nghiệm</h5>
                            <?php
                            $ratings = [5 => 35, 4 => 3, 3 => 0, 2 => 0, 1 => 0]; // Example data
                            $totalRatings = array_sum($ratings);

                            foreach ($ratings as $stars => $count) {
                                $percentage = $totalRatings ? ($count / $totalRatings) * 100 : 0;
                                echo '<div class="d-flex justify-content-between align-items-center">';
                                echo "<span>{$stars} sao</span>";
                                echo '<div class="rating-bar" style="flex: 1; margin: 0 10px; height: 10px; background-color: #f0f0f0;">';
                                echo '<div class="rating-bar-fill" style="width: ' . $percentage . '%; height: 100%; background-color: #ff0000;"></div>';
                                echo '</div>';
                                echo "<span>{$count} đánh giá</span>";
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                    <hr>
                    <div class="comments text-center">
                        <?php if (!isset($_SESSION['user'])): ?>
                            <!-- Hiển thị thông báo yêu cầu đăng nhập -->
                            <div class="comments text-center">
                                <p>Bạn cần đăng nhập để đánh giá sản phẩm này.</p>
                                <button class="btn btn-outline-danger" onclick="showLoginModal()">Viết đánh giá</button>
                            </div>
                        <?php else: ?>
                            <!-- Hiển thị form viết đánh giá -->
                            <div class="comments text-center">
                                <p>Bạn đánh giá sao về sản phẩm này?</p>
                                <button class="btn btn-outline-danger" onclick="showReviewForm()">Viết đánh giá</button>
                            </div>
                        <?php endif; ?>

                    </div>
                    <hr>
                    <div class="comment-list ms-5">
                        <?php if (!empty($comments)) : ?>
                            <?php foreach ($comments as $comment) : ?>
                                <div class="comment">
                                    <div class="avt">
                                        <img
                                            src="./uploads/<?php echo htmlspecialchars($comment['user_avatar']); ?>" />
                                    </div>
                                    <div class="name-date">
                                        <div class="header-comment">
                                            <div class="name-user">
                                                <p><?php echo htmlspecialchars($comment['user_name']); ?></p>
                                            </div>
                                            <div class="date">
                                                <p><?php echo htmlspecialchars($comment['created_date']); ?></p>
                                            </div>
                                        </div>
                                        <div class="contents">
                                            <p><?php echo htmlspecialchars($comment['comment_content']); ?></p>
                                        </div>
                                        <div class="icon">
                                            <div class="comment__operate">
                                                <i class="comment__operate__icon like fas fa-thumbs-up"></i>
                                            </div>
                                            <div class="comment__operate">
                                                <i class="comment__operate__icon reply fas fa-reply"></i>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p>No comments available.</p>
                        <?php endif; ?>
                    </div>

                </div>


            </div>

            <!-- Phần thông số kỹ thuật nằm bên phải -->
            <div class="col-md-4">
                <div class="p-3 border rounded">
                    <h4 class="text-dark">Thông số kỹ thuật</h4>
                    <table class="table table-striped " style="border: solid 1px #e5e7eb">
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
    <div id="login-modal" class="modal">
        <div class="modal-content">
            <span class="close "><ion-icon name="close"></ion-icon></span>
            <h2>Đăng nhập Wintech</h2>

            <div class="login-fb">
                <div class="comment__operate" id="fb-login-btn">
                    <i class="comment__operate__icon fab fa-facebook"></i>
                    <span>Đăng nhập bằng Facebook</span>
                </div>
            </div>
            <div class="login-gg">
                <div class="comment__operate">
                    <i class="comment__operate__icon gg -google"></i>
                    <span>Đăng nhập bằng Google</span>
                </div>
            </div>
            <a href="?act=login"><button>Đăng nhập</button></a>

            <div class="register">
                <p>Bạn chưa có tài khoản?<a href="?act=register">register</a></p>

            </div>
        </div>
    </div>
   
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script>
    function selectVariant(element) {
        const options = document.querySelectorAll('#variant-container .option');

        // Xóa lớp "selected" khỏi tất cả các lựa chọn
        options.forEach(option => option.classList.remove('selected'));

        // Thêm lớp "selected" vào lựa chọn được chọn
        element.classList.add('selected');

        // Lấy ID, giá, discount_value và discount_type của biến thể được chọn
        const selectedVariantId = element.getAttribute('data-id');
        const price = parseInt(element.getAttribute('data-price')); // Giá gốc
        const discountValue = parseInt(element.getAttribute('data-discount-value')); // Giá trị giảm
        const discountType = element.getAttribute('data-discount-type'); // Loại giảm giá (percentage hoặc amount)

        // Tính toán giá sau khi giảm (nếu có)
        let finalPrice = price;
        let discountAmount = 0;
        let discountText = ''; // Text sẽ hiển thị giảm giá

        if (discountValue > 0) {
            if (discountType === 'percentage') {
                // Giảm theo tỷ lệ phần trăm
                discountAmount = price * discountValue / 100;
                finalPrice = price - discountAmount;
                discountText = `Sale ${discountValue}%`;
            } else if (discountType === 'amount') {
                // Giảm theo số tiền
                discountAmount = discountValue;
                finalPrice = price - discountAmount;
                discountText = `Sale ${discountAmount.toLocaleString()} VND`;
            }
        }

        // Cập nhật giá hiển thị trên giao diện
        const priceElement = document.getElementById('variant-price');
        const discountElement = document.getElementById('variant-discount');
        const originalPriceElement = document.getElementById('variant-original-price');

        if (priceElement) {
            priceElement.textContent = `${finalPrice.toLocaleString()} VND`;
        }

        if (originalPriceElement) {
            originalPriceElement.textContent = `${price.toLocaleString()} VND`;
            originalPriceElement.style.textDecoration = 'line-through'; // Để giá gốc có gạch ngang
        }

        if (discountElement) {
            discountElement.textContent = discountText; // Hiển thị phần trăm hoặc số tiền giảm
        }

        // Cập nhật href của thẻ <a>
        const buyNowLink = document.getElementById('buy-now-link');
        if (buyNowLink) {
            const newHref = `?act=pay&id=${selectedVariantId}`;
            buyNowLink.setAttribute('href', newHref);
        }

        // Update form inputs with selected variant details
        document.getElementById('selected-variant-id').value = selectedVariantId;
        document.getElementById('selected-variant-price').value = finalPrice;
    }



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
            variant.classList.remove('selected'); // Xóa selected từ tất cả variants
        });

        // Hiển thị các biến thể phù hợp và chọn biến thể đầu tiên
        let firstMatchingVariant = null;
        variants.forEach(variant => {
            if (variant.getAttribute('data-color') === selectedColor) {
                variant.style.display = 'block'; // Hiện biến thể phù hợp
                if (!firstMatchingVariant) {
                    firstMatchingVariant = variant;
                }
            }
        });

        // Tự động chọn biến thể đầu tiên của màu đã chọn
        if (firstMatchingVariant) {
            selectVariant(firstMatchingVariant);
        }
    }



    document.addEventListener('DOMContentLoaded', function() {
        // Thumbnail Slider
        var thumbnailSlider = new Swiper('.thumbnail-slider', {
            spaceBetween: 2,
            slidesPerView: 4,
            watchSlidesProgress: true,
        });

        // Main Image Slider
        var mainSlider = new Swiper('.main-slider', {
            spaceBetween: 2,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: thumbnailSlider,
            },
        });

        function getCurrentColor() {
            return mainSlider.slides[mainSlider.activeIndex].getAttribute('data-color');
        }

        // Hàm chuyển đến slide cùng màu tiếp theo
        function goToNextSameColorSlide() {
            const currentColor = getCurrentColor();
            let nextIndex = mainSlider.activeIndex + 1;

            while (nextIndex < mainSlider.slides.length) {
                const nextColor = mainSlider.slides[nextIndex].getAttribute('data-color');
                if (nextColor === currentColor) {
                    mainSlider.slideTo(nextIndex);
                    break;
                }
                nextIndex++;
            }
        }

        // Hàm chuyển đến slide cùng màu trước đó
        function goToPrevSameColorSlide() {
            const currentColor = getCurrentColor();
            let prevIndex = mainSlider.activeIndex - 1;

            while (prevIndex >= 0) {
                const prevColor = mainSlider.slides[prevIndex].getAttribute('data-color');
                if (prevColor === currentColor) {
                    mainSlider.slideTo(prevIndex);
                    break;
                }
                prevIndex--;
            }
        }

        // Gắn sự kiện cho các nút Next và Prev
        document.querySelector('.swiper-button-next').addEventListener('click', function(event) {
            event.preventDefault();
            goToNextSameColorSlide();
        });

        document.querySelector('.swiper-button-prev').addEventListener('click', function(event) {
            event.preventDefault();
            goToPrevSameColorSlide();
        });

        // Thêm class cho ảnh thumbnail khi được chọn
        mainSlider.on('slideChange', function() {
            const currentColor = getCurrentColor();
            document.querySelectorAll('.thumbnail').forEach((thumb, index) => {
                const thumbColor = thumb.parentElement.getAttribute('data-color');
                if (thumbColor === currentColor && index === mainSlider.activeIndex) {
                    thumb.style.border = '2px solid #007bff';
                } else {
                    thumb.style.border = '1px solid #d1d5db';
                }
            });
        });

        // Tự động chọn màu đầu tiên
        const firstColorOption = document.querySelector('.option-color');
        if (firstColorOption) {
            filterVariants(firstColorOption);
        }

        // Tự động chọn RAM/dung lượng đầu tiên
        const firstVariantOption = document.querySelector('#variant-container .option');
        if (firstVariantOption) {
            selectVariant(firstVariantOption);
        }
    });


    function showLoginModal() {
        const modal = document.getElementById('login-modal');
        modal.style.display = 'block';
    }

    // Show the review form
    function showReviewForm() {
        const reviewForm = document.getElementById('review-form');
        reviewForm.style.display = 'block';
    }

    // Close the login modal
    function closeModal() {
        const modal = document.getElementById('login-modal');
        modal.style.display = 'none';
    }

    // Close modal if clicked outside of modal content
    window.onclick = function(event) {
        const modal = document.getElementById('login-modal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };
</script>