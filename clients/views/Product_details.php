<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<?php if (isset($_SESSION['success'])): ?>
    <div id="alertMessage" class="alert alert-success alert-dismissible slide-in position-fixed end-0 m-3 custom-alert" role="alert" style="z-index: 99999; max-width: 400px; top: 10px;">
        <div class="d-flex align-items-center">
            <div class="icon-container me-2">
                <i class="fas fa-check-circle"></i>

            </div>
            <div class="message-container flex-grow-1 text-white">
                <?php echo $_SESSION['success'];
                unset($_SESSION['success']); ?>
            </div>
        </div>
    </div>
    <script>
        setTimeout(function() {
            const alertMessage = document.getElementById('alertMessage');
            if (alertMessage) alertMessage.remove();
        }, 3000);
    </script>
<?php endif; ?>
<div class="container mt-4 mb-4">
    <!-- Header sản phẩm -->
    <div class="product-header">
        <div class="d-flex align-items-center gap-3 ">
            <div class="name_prd ms-3">
                <p class="product-title mb-1"><?= htmlspecialchars($product['product_name']) ?></p>
            </div>

            <div class="star-rating mb-2">
                <?php
                $rating = isset($product['rating']) ? floatval($product['rating']) : 0;
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
                    $price = $variant['price'];
                    $discount_value = $variant['discount_value'];
                    $discount_type = $variant['discount_type'];
                    $quantity = $variant['quantity'];

                    // Tính toán giá sau giảm
                    $discounted_price = $price;
                    if ($discount_type == 'percentage' && $discount_value > 0) {
                        $discounted_price = $price - ($price * $discount_value / 100);
                    } elseif ($discount_type == 'fixed' && $discount_value > 0) {
                        $discounted_price = $price - $discount_value;
                    }
                    $discounted_price = max($discounted_price, 0);
                    ?>

                    <div class="option justify-content-between align-items-center mb-2
                        <?= $quantity == 0 ? 'disabled' : '' ?>"
                        data-id="<?= htmlspecialchars($variant['variant_id']) ?>"
                        data-color="<?= htmlspecialchars($variant['color']) ?>"
                        data-price="<?= htmlspecialchars($variant['price']) ?>"
                        data-discount-value="<?= htmlspecialchars($variant['discount_value']) ?>"
                        data-discount-type="<?= htmlspecialchars($variant['discount_type']) ?>"
                        data-quantity="<?= htmlspecialchars($variant['quantity']) ?>"
                        onclick="selectVariant(this)">
                        <span class="fw-bold"><?= htmlspecialchars($variant['ram']) ?> /
                            <?= htmlspecialchars($variant['storage']) ?></span>

                        <p class="text-muted">
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

            <div class="price_products_variants">
                <div class="price-vi text-center">
                    <div class="discount_sale">
                        <p id="variant-discount" style="font-size: 16px;"></p>
                    </div>
                    <p id="variant-price" style="font-size: 19px; font-weight: bold; color: red;"></p>
                    <p id="variant-original-price" style="font-size: 29px; color: #888;"></p>
                </div>
                <div class="button-mcx">
                    <div class="button-container">
                        <form id="add-to-cart-now" action="?act=add_to_cart_now" method="POST">
                            <input type="hidden" name="id" value="<?= $product['id'] ?>">
                            <input type="hidden" name="product_id" id="selected-variant-id-now" value="">
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="price" id="selected-variant-price-now" value="">
                            <button type="submit" id="buy-now-link" class="btn btn-danger w-100 mb-2">Mua ngay</button>
                        </form>

                        <form id="add-to-cart-form" action="?act=add_to_cart" method="POST">
                            <input type="hidden" name="id" value="<?= $product['id'] ?>">
                            <input type="hidden" name="product_id" id="selected-variant-id" value="">
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="price" id="selected-variant-price" value="">
                            <button type="submit" id="add-to-cart-link" class="btn btn-outline-danger w-100">Thêm vào giỏ hàng</button>
                        </form>
                    </div>
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
                        <?php if (!isset($_SESSION['user_id'])): ?>
                            <p>Bạn cần đăng nhập để đánh giá sản phẩm này.</p>
                            <button class="btn btn-outline-danger" onclick="showLoginModal()">Viết đánh giá</button>

                            <div id="login-modal" class="modal ">
                                <div class="modal-content">

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
                                    <a href="?act=login" class="me-5"><button>Đăng nhập</button></a>

                                    <div class="register">
                                        <p>Bạn chưa có tài khoản?<a href="?act=register">register</a></p>

                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- Hiển thị form viết đánh giá -->

                            <p>Bạn đánh giá sao về sản phẩm này?</p>
                            <button class="btn btn-outline-danger" onclick="toggleReviewForm(true)">Viết đánh giá</button>

                            <div id="review-form" class="review-form" style="display: none;">
                                <span class="close "><ion-icon name="close"></ion-icon></span>
                                <form id="rating-form" action="?act=add_review" method="post">
                                    <h2>Đánh giá & nhận xét</h2>
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

                                    <div class="section-title">Đánh giá chung</div>
                                    <div class="stars overall-rating">
                                        <input type="hidden" name="rating" id="rating" value="0" required>
                                        <i class="fa fa-star" data-value="1"></i>
                                        <i class="fa fa-star" data-value="2"></i>
                                        <i class="fa fa-star" data-value="3"></i>
                                        <i class="fa fa-star" data-value="4"></i>
                                        <i class="fa fa-star" data-value="5"></i>
                                    </div>

                                    <!-- Thông báo lỗi -->
                                    <p id="rating-error" style="color: red; display: none;">Vui lòng chọn số sao để đánh giá!</p>

                                    <textarea name="content" id="review-content" placeholder="Xin mời chia sẻ một số cảm nhận về sản phẩm (nhập tối thiểu 15 kí tự)"></textarea>
                                    <p id="content-error" style="color: red; display: none;">Bình luận phải có ít nhất 5 ký tự!</p>

                                    <button class="submit-btn" type="submit">Gửi đánh giá</button>
                                </form>

                            </div>
                        <?php endif; ?>
                    </div>
                    <hr>


                    <div class="comment-list ms-5">
                        <?php if (!empty($comments)) : ?>
                            <?php foreach ($comments as $comment) : ?>
                                <div class="comment">
                                    <!-- Avatar -->
                                    <?php
                                    $avatarPath = !empty($comment['user_avatar']) ? 'uploads/UserIMG/' . $comment['user_avatar'] : './assets/images/default-avatar.png';
                                    ?>
                                    <img src="<?= $avatarPath ?>"
                                        class="profile-avatar"
                                        id="avatar-preview"
                                        alt="Avatar">

                                    <!-- User Information and Comment -->
                                    <div class="name-date">
                                        <!-- Header: User Name and Date -->
                                        <div class="header-comment">
                                            <div class="name-user">
                                                <p><?php echo htmlspecialchars($comment['user_name']); ?></p>
                                            </div>
                                            <div class="date">
                                                <p><?php echo htmlspecialchars($comment['created_date']); ?></p>
                                            </div>
                                        </div>

                                        <!-- Comment Content -->
                                        <div class="contents">
                                            <p><?php echo htmlspecialchars($comment['comment_content']); ?></p>
                                        </div>

                                        <!-- Like, Dislike, and Reply Actions -->
                                        <div class="icon">
                                            <!-- Like Button -->
                                            <div class="comment__operate">
                                                <form
                                                    action="?act=update_like_dislike"
                                                    method="POST"
                                                    class="like-form d-flex align-items-center">
                                                    <input type="hidden" name="comment_id" value="<?php echo $comment['comment_id']; ?>">
                                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                                    <button
                                                        type="submit"
                                                        name="action"
                                                        value="like"
                                                        class="btn comment__operate__icon like fas fa-thumbs-up">
                                                    </button>
                                                    <p class=""><?php echo $comment['like_count']; ?></p>
                                                </form>
                                            </div>

                                            <!-- Dislike Button -->
                                            <div class="comment__operate">
                                                <form
                                                    action="?act=update_like_dislike"
                                                    method="POST"
                                                    class="dislike-form d-flex align-items-center ms-3">
                                                    <input type="hidden" name="comment_id" value="<?php echo $comment['comment_id']; ?>">
                                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                                    <button
                                                        type="submit"
                                                        name="action"
                                                        value="dislike"
                                                        class="btn comment__operate__icon dislike fas fa-thumbs-down">
                                                    </button>
                                                    <p class=""><?php echo $comment['dislike_count']; ?></p>
                                                </form>
                                            </div>

                                            <!-- Reply Button -->
                                            <div class="comment__operate">
                                                <button
                                                    class="btn comment__operate__icon reply fas fa-reply ms-3">
                                                </button>
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


    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <script>
        function selectVariant(element) {
            const quantity = parseInt(element.getAttribute('data-quantity'));
            if (quantity === 0) {
                return; // Do not select variants with zero quantity
            }

            const options = document.querySelectorAll('#variant-container .option');

            // Remove "selected" class from all options
            options.forEach(option => option.classList.remove('selected'));

            // Add "selected" class to the clicked option
            element.classList.add('selected');

            // Get the ID, price, discount_value, and discount_type of the selected variant
            const selectedVariantId = element.getAttribute('data-id');
            const price = parseInt(element.getAttribute('data-price')); // Original price
            const discountValue = parseInt(element.getAttribute('data-discount-value')); // Discount value
            const discountType = element.getAttribute('data-discount-type'); // Discount type (percentage or amount)

            // Calculate the final price after discount (if any)
            let finalPrice = price;
            let discountAmount = 0;
            let discountText = ''; // Text to display discount

            if (discountValue > 0) {
                if (discountType === 'percentage') {
                    // Percentage discount
                    discountAmount = price * discountValue / 100;
                    finalPrice = price - discountAmount;
                    discountText = `Sale ${discountValue}%`;
                } else if (discountType === 'amount') {
                    // Fixed amount discount
                    discountAmount = discountValue;
                    finalPrice = price - discountAmount;
                    discountText = `Sale ${discountAmount.toLocaleString()} VND`;
                }
            }

            // Update the displayed price on the interface
            const priceElement = document.getElementById('variant-price');
            const discountElement = document.getElementById('variant-discount');
            const originalPriceElement = document.getElementById('variant-original-price');

            if (priceElement) {
                priceElement.textContent = `${finalPrice.toLocaleString()} VND`;
            }
            if (discountElement) {
                discountElement.textContent = discountText;
            }
            if (originalPriceElement) {
                originalPriceElement.textContent = `${price.toLocaleString()} VND`;
            }

            // Update hidden inputs for form submission
            document.getElementById('selected-variant-id').value = selectedVariantId;
            document.getElementById('selected-variant-price').value = finalPrice;
            document.getElementById('selected-variant-id-now').value = selectedVariantId;
            document.getElementById('selected-variant-price-now').value = finalPrice;
        }



        let selectedVariantId = null; // Lưu id của biến thể được chọn

        function filterVariants(element) {
            const selectedColor = element.getAttribute('data-color');
            const colorOptions = document.querySelectorAll('.option-color');
            const variants = document.querySelectorAll('#variant-container .option');

            // Remove "selected" class from all color options
            colorOptions.forEach(option => option.classList.remove('selected'));

            // Add "selected" class to the clicked color option
            element.classList.add('selected');

            // Hide all variants and remove "selected" class
            variants.forEach(variant => {
                variant.style.display = 'none';
                variant.classList.remove('selected');
            });

            // Show and select the first available variant with non-zero quantity
            let firstAvailableVariant = null;
            variants.forEach(variant => {
                if (variant.getAttribute('data-color') === selectedColor) {
                    const quantity = parseInt(variant.getAttribute('data-quantity'));
                    if (quantity > 0 && !firstAvailableVariant) {
                        firstAvailableVariant = variant;
                    }
                    variant.style.display = 'block'; // Show matching variants
                }
            });

            if (firstAvailableVariant) {
                selectVariant(firstAvailableVariant);
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
            const variants = document.querySelectorAll('#variant-container .option');
            let firstAvailableVariant = null;

            variants.forEach(variant => {
                const quantity = parseInt(variant.getAttribute('data-quantity'));
                if (quantity > 0 && !firstAvailableVariant) {
                    firstAvailableVariant = variant;
                }
            });

            if (firstAvailableVariant) {
                selectVariant(firstAvailableVariant);
            }

            // Disable variants with zero quantity
            variants.forEach(variant => {
                const quantity = parseInt(variant.getAttribute('data-quantity'));
                if (quantity === 0) {
                    variant.classList.add('disabled');
                    variant.style.pointerEvents = 'none';
                    variant.style.opacity = '0.5';
                }
            });

            // Disable main product image if all variants are out of stock
            const allOutOfStock = Array.from(variants).every(variant => parseInt(variant.getAttribute('data-quantity')) === 0);
            if (allOutOfStock) {
                const mainImage = document.querySelector('.product-image');
                if (mainImage) {
                    mainImage.style.pointerEvents = 'none';
                    mainImage.style.opacity = '0.5';
                }
            }
        });



        // Hàm xử lý chọn sao
        function setupStarRatings() {
            // Tìm tất cả các khối đánh giá sao
            document.querySelectorAll('.stars').forEach(starContainer => {
                const stars = starContainer.querySelectorAll('i'); // Lấy tất cả các sao trong container

                stars.forEach((star, index) => {
                    // Sự kiện click để chọn sao
                    star.addEventListener('click', () => {
                        // Xóa trạng thái đã chọn của tất cả các sao
                        stars.forEach(s => s.classList.remove('selected'));

                        // Đánh dấu tất cả các sao từ đầu đến sao được chọn
                        for (let i = 0; i <= index; i++) {
                            stars[i].classList.add('selected');
                        }

                        // Lưu giá trị sao đã chọn vào thuộc tính data-rating của container
                        const ratingValue = index + 1;
                        starContainer.dataset.rating = ratingValue;

                        // Gán giá trị vào input ẩn trong form (nếu có)
                        const ratingInput = document.getElementById('rating');
                        if (ratingInput) {
                            ratingInput.value = ratingValue;
                        }

                        // In giá trị ra console (hoặc xử lý logic khác)
                        console.log(`Đánh giá: ${ratingValue} sao cho phần ${starContainer.classList}`);
                    });

                    // Hiệu ứng hover để làm nổi bật sao
                    star.addEventListener('mouseover', () => {
                        stars.forEach((s, i) => {
                            if (i <= index) {
                                s.classList.add('hover');
                            } else {
                                s.classList.remove('hover');
                            }
                        });
                    });

                    // Xóa hiệu ứng hover khi chuột rời đi
                    starContainer.addEventListener('mouseleave', () => {
                        stars.forEach(s => s.classList.remove('hover'));
                    });
                });
            });

            // Kiểm tra trước khi gửi biểu mẫu
            const reviewForm = document.querySelector('#review-form form');

        }
        document.getElementById('rating-form').addEventListener('submit', function(event) {
            let isValid = true;

            // Kiểm tra số sao
            const ratingInput = document.getElementById('rating');
            const ratingError = document.getElementById('rating-error');
            if (!ratingInput.value || parseInt(ratingInput.value) === 0) {
                ratingError.style.display = 'block'; // Hiển thị thông báo lỗi
                isValid = false;
            } else {
                ratingError.style.display = 'none'; // Ẩn thông báo lỗi
            }

            // Kiểm tra nội dung bình luận
            const contentInput = document.getElementById('review-content');
            const contentError = document.getElementById('content-error');
            if (!contentInput.value || contentInput.value.trim().length < 5) {
                contentError.style.display = 'block'; // Hiển thị thông báo lỗi
                isValid = false;
            } else {
                contentError.style.display = 'none'; // Ẩn thông báo lỗi
            }

            // Nếu không hợp lệ, ngăn gửi biểu mẫu
            if (!isValid) {
                event.preventDefault();
            }
        });


        // Hiển thị form đánh giá
        // Hiển thị hoặc ẩn form đánh giá
        // Hiển thị modal đăng nhập
        // Hiển thị modal đăng nhập
        function showLoginModal() {
            document.getElementById('login-modal').style.display = 'block';
        }

        // Đóng modal hoặc form đánh giá khi nhấn nút close
        document.querySelectorAll('.close').forEach(btn => {
            btn.addEventListener('click', closeAll);
        });

        // Hiển thị hoặc ẩn form đánh giá
        function toggleReviewForm(show) {
            const form = document.getElementById('review-form');
            form.style.display = show ? 'block' : 'none';
        }

        // Xử lý đánh giá sao
        document.querySelectorAll('.stars .fa-star').forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-value');
                document.getElementById('rating').value = rating;

                // Đánh dấu các sao đã chọn
                document.querySelectorAll('.stars .fa-star').forEach(s => s.classList.remove('active'));
                for (let i = 0; i < rating; i++) {
                    document.querySelectorAll('.stars .fa-star')[i].classList.add('active');
                }
            });
        });

        // Đóng tất cả modal/form và reset trạng thái
        function closeAll() {
            // Ẩn modal đăng nhập
            const loginModal = document.getElementById('login-modal');
            if (loginModal) loginModal.style.display = 'none';

            // Ẩn form đánh giá
            const reviewForm = document.getElementById('review-form');
            if (reviewForm) reviewForm.style.display = 'none';

            // Reset ánh giá sao
            const ratingInput = document.getElementById('rating');
            if (ratingInput) ratingInput.value = "0";

            // Xóa đánh dấu các sao
            document.querySelectorAll('.stars .fa-star').forEach(s => s.classList.remove('active'));

            // Reset nội dung bình luận
            const reviewContent = document.getElementById('review-content');
            if (reviewContent) reviewContent.value = "";
        }

        // Đóng modal khi nhấn vào vùng ngoài modal
        window.addEventListener('click', function(event) {
            const loginModal = document.getElementById('login-modal');
            const reviewForm = document.getElementById('review-form');

            if (event.target === loginModal || event.target === reviewForm) {
                closeAll();
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            // Giả sử rằng bạn có một cách để xác định người dùng đã thích hay không
            // Đây là ví dụ đơn giản: biến trạng thái như đã thích hoặc đã dislike
            var likedComments = new Set(); // Lưu trữ các ID của bình luận đã like
            var dislikedComments = new Set(); // Lưu trữ các ID của bình luận đã dislike

            // Xử lý click cho nút Like
            document.querySelectorAll('.comment__operate .like').forEach(function(likeButton) {
                likeButton.addEventListener('click', function(event) {
                    var commentId = event.target.closest('form').querySelector('input[name="comment_id"]').value;

                    // Nếu đã like rồi thì ngừng hành động này
                    if (likedComments.has(commentId)) {
                        event.preventDefault(); // Ngừng hành động của form
                        return; // Không thực hiện hành động gì thêm
                    }

                    likedComments.add(commentId);

                    if (dislikedComments.has(commentId)) {
                        dislikedComments.delete(commentId);
                    }

                    // Cập nhật giao diện hoặc gửi dữ liệu lên server nếu cần
                    // Ví dụ: thay đổi icon, số lượt thích, v.v.
                });
            });

            // Xử lý click cho nút Dislike
            document.querySelectorAll('.comment__operate .dislike').forEach(function(dislikeButton) {
                dislikeButton.addEventListener('click', function(event) {
                    var commentId = event.target.closest('form').querySelector('input[name="comment_id"]').value;

                    // Nếu đã dislike rồi thì ngừng hành động này
                    if (dislikedComments.has(commentId)) {
                        event.preventDefault(); // Ngừng hành động của form
                        return; // Không thực hiện hành động gì thêm
                    }

                    // Nếu chưa dislike, đánh dấu là đã dislike
                    dislikedComments.add(commentId);

                    // Nếu đã like, bỏ like trước
                    if (likedComments.has(commentId)) {
                        likedComments.delete(commentId);
                    }

                    // Cập nhật giao diện hoặc gửi dữ liệu lên server nếu cần
                    // Ví dụ: thay đổi icon, số lượt không thích, v.v.
                });
            });
        });



        // Khởi chạy sau khi DOM được tải
        document.addEventListener('DOMContentLoaded', setupStarRatings);

        document.addEventListener('DOMContentLoaded', function() {
            // Automatically select the first available color
            const firstColorOption = document.querySelector('.option-color');
            if (firstColorOption) {
                filterVariants(firstColorOption);
            }

            // Automatically select the first available variant with non-zero quantity
            const variants = document.querySelectorAll('#variant-container .option');
            let firstAvailableVariant = null;

            variants.forEach(variant => {
                const quantity = parseInt(variant.getAttribute('data-quantity'));
                if (quantity > 0 && !firstAvailableVariant) {
                    firstAvailableVariant = variant;
                }
            });

            if (firstAvailableVariant) {
                selectVariant(firstAvailableVariant);
            }
        });
    </script>
    <style>
        .price_products_variants {
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding: 15px;
            border-radius: 8px;
        }

        .discount_sale {
            padding: 8px 20px;
            border-radius: 25px;
            position: relative;
            overflow: hidden;
            background: linear-gradient(45deg, #dc3545, #ff6b6b);
            box-shadow: 0 2px 10px rgba(220, 53, 69, 0.2);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .discount_sale p {
            color: white;
            font-size: 15px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            z-index: 2;
            top: 20px;
            height: 50px;
            text-align: left;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .discount_sale:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, 0.3),
                    transparent);
            transition: 0.5s;
        }

        .discount_sale:hover:before {
            left: 100%;
        }

        .discount_sale:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        /* Animation */
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-5px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        

        /* Responsive styles */
        @media (max-width: 768px) {
            .discount_sale {
                padding: 6px 15px;
            }

            .discount_sale p {
                font-size: 13px;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .discount_sale {
                background: linear-gradient(45deg, #c82333, #e74c3c);
                box-shadow: 0 2px 10px rgba(231, 76, 60, 0.2);
                height: 75px;
            }
        }

        .price-vi {
            height: 160px;
            width: 350px;
            padding: 15px 20px;
            border-radius: 8px;
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;

        }

        .price-vi:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, 0.2),
                    transparent);
            transition: 0.5s;
        }

        .price-vi:hover:before {
            left: 100%;
        }

        .price-vi:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        #variant-price {
            font-size: 26px !important;
            font-weight: 700 !important;
            color: #dc3545 !important;
            margin-bottom: 8px;
            display: block;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.05);
        }

        #variant-original-price {
            font-size: 29px !important;
            color: #b0b0b0 !important;
            text-decoration: line-through;
            margin: 0;
            font-weight: 300;
            display: block;
            position: relative;
            top: -39px;
        }

        @media (max-width: 768px) {
            .price-vi {
                padding: 12px 15px;
            }

            #variant-price {
                font-size: 24px !important;
            }

            #variant-original-price {
                font-size: 14px !important;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .price-vi {
                background: #2d2d2d;
                border-color: rgba(255, 255, 255, 0.1);
            }

            #variant-price {
                color: #ffffff !important;
                position: relative;
                top: -64px;
                right: -45px;
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .button-mcx {
            margin-top: 15px;
        }

        .button-container {
            margin-top: -191px;
            width: 250px;
            max-width: 350px;
            /* Độ rộng giống với khối giá */
            margin-left: auto;
            /* Căn phải */
        }

        .button-mcx button {
            padding: 12px 25px;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* Style cho nút Mua ngay */
        .button-mcx .btn-danger {
            background: linear-gradient(45deg, #dc3545, #ff6b6b);
            border: none;
            box-shadow: 0 2px 10px rgba(220, 53, 69, 0.2);
        }

        /* Style cho nút Thêm vào giỏ hàng */
        .button-mcx .btn-outline-danger {
            border: 2px solid #dc3545;
            background: transparent;
            color: #dc3545;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        /* Hiệu ứng hover */
        .button-mcx button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        /* Hiệu ứng shine */
        .button-mcx button:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, 0.3),
                    transparent);
            transition: 0.5s;
        }

        .button-mcx button:hover:before {
            left: 100%;
        }

        /* Animation float */
        .button-mcx button {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-5px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .button-container {
                margin: 0 auto;
                /* Căn giữa trên mobile */
            }

            .button-mcx button {
                padding: 8px 20px;
                font-size: 14px;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .button-mcx .btn-danger {
                background: linear-gradient(45deg, #c82333, #e74c3c);
            }

            .button-mcx .btn-outline-danger {
                border-color: #e74c3c;
                color: #e74c3c;
            }
        }

        #buy-now-link,
        #add-to-cart-link {
            text-decoration: none;
            height: 75px;
        }

        /* Toast Message */
        .toast-message {
            position: fixed;
            top: 80px;
            right: 20px;
            background: #4CAF50;
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            animation: slideIn 0.5s ease-out;
        }

        .toast-message i {
            font-size: 20px;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .toast-message.hide {
            animation: slideOut 0.5s ease-out forwards;
        }

        .custom-alert {
            background-color: #28a745;
            /* Màu xanh lá cây */
            color: #ffffff;
            /* Màu trắng */
            border: none;
            /* Loại bỏ viền */
            border-radius: 10px;
            /* Bo góc */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            /* Tạo hiệu ứng đổ bóng */
            padding: 10px 15px;
            /* Căn chỉnh padding */
            animation: slideIn 0.5s ease-out;
            /* Hiệu ứng trượt vào */
        }

        .custom-alert .icon-container {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(255, 255, 255, 0.2);
            /* Làm nền biểu tượng nhạt hơn */
            border-radius: 50%;
            /* Tạo hình tròn */
            width: 40px;
            height: 40px;
        }

        .custom-alert .message-container {
            font-size: 14px;
            /* Kích thước chữ */
            line-height: 1.5;
            /* Khoảng cách giữa các dòng */
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .disabled {
            pointer-events: none;
            opacity: 0.5;
        }
    </style>