<style>
    /* CSS cho các nút */
    .sort-button {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        font-size: 14px;
        font-weight: bold;
        padding: 8px 12px;
        border: 1px solid #ddd;
        transition: background-color 0.3s, color 0.3s, border-color 0.3s;
    }

    .sort-button.active {
        background-color: #f8d7da;
        border-color: #dc3545;
        color: #dc3545;
    }

    .sort-button ion-icon {
        font-size: 16px;
    }

    .sort-button:hover {
        background-color: #f1f1f1;
    }

    /* Tiêu đề */
    .product-title {
        margin: 0;
        color: #333;
    }

    .d-flex {
        display: flex;
    }

    .align-items-center {
        align-items: center;
    }

    .mb-4 {
        margin-bottom: 1.5rem;
    }

    .ms-3 {
        margin-left: 1rem;
    }

    .rounded-pill {
        border-radius: 50px;
    }
</style>
<?php if (empty($results) || !isset($_GET['search']) || empty($_GET['search'] ?? '')) : ?>
    <!-- Hiển thị ảnh khi không có kết quả -->
    <img src="https://colorlib.com/wp/wp-content/uploads/sites/2/404-error-template-14.png"
        alt="No results found"
        style="width: 100%; height: 80%;">
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

    <h1 class="product-title" style="margin: 30px 70px 30px; font-size: 25px;">
        Kết quả tìm kiếm cho từ khóa: <?= htmlspecialchars($_GET['search']) ?>
    </h1>

    <div class="container">
        <div class="d-flex align-items-center mb-4">
            <h4 class="product-title ms-3" style="font-size: 20px;">Sắp xếp theo</h4>
            <button type="button" class="btn btn-outline-secondary ms-3 sort-button rounded-pill " data-sort="relevance">
                <ion-icon name="filter-outline"></ion-icon> Liên quan
            </button>
            <br>
            <button type="button" class="btn btn-outline-secondary ms-3 sort-button rounded-pill" data-sort="high-price">
                Giá cao <ion-icon name="arrow-down-outline"></ion-icon>
            </button>
            <button type="button" class="btn btn-outline-secondary ms-3 sort-button rounded-pill" data-sort="low-price">
                Giá thấp<ion-icon name="arrow-up-outline"></ion-icon>
            </button>
        </div>

        <div class="result-container">
            <?php
            // Sắp xếp mặc định theo lượt xem
            usort($results, function ($a, $b) {
                return $b['views'] - $a['views'];
            });
            ?>
            <?php foreach ($results as $result) : ?>
                <div class="product-item">
                    <!-- Giảm giá -->
                    <div class="discount-container">
                        <p>Giảm <?= htmlspecialchars($result['discount_value']) ?>%</p>
                    </div>
                    <!-- Hình ảnh sản phẩm -->
                    <img src="<?= htmlspecialchars(removeLeadingDots($result['img'])) ?>"
                        alt="<?= htmlspecialchars($result['product_name']) ?>">
                    <hr>
                    <!-- Tên sản phẩm -->
                    <h5><?= htmlspecialchars($result['product_name']) ?></h5>

                    <!-- Đánh giá -->
                    <div class="rating-container">
                        <div class="rating">
                            <?= renderRatingStars((int)$result['rating']) ?>
                        </div>
                        <h7><?= htmlspecialchars($result['rating']) ?></h7>
                        <p class="views">
                            <ion-icon name="eye-outline"></ion-icon>
                            <?= htmlspecialchars($result['views']) ?>
                        </p>
                    </div>
                
                    <div class="price-home mb-0 mt-2">
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
                            
                            echo '<p>' . number_format($discounted_price, 0, ',', '.') . ' ₫</p>';
                        } else {
                            echo '<span>' . '0' . ' ₫</span>';
                        }
                        ?>
                    </div>
                    <div class="price-save d-flex gap-3 mt-0">
                        <p class="discound-1 text-decoration-line-through" style="font-size: 1rem"><?= htmlspecialchars(number_format($result['Lowest_Price'], 0, ',', '.')) ?>₫</p>
                        <p class="save-2 text-danger" style="font-size: 1rem">SAVE: <?= htmlspecialchars(number_format($result['Lowest_Price'] - $discounted_price, 0, ',', '.')) ?>₫</p>
                    </div>
                    <a href="?act=product_detail&id=<?= $result['id'] ?>" class="buy-now">Mua ngay</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php endif; ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const btns = document.querySelectorAll('.sort-button');
        const resultContainer = document.querySelector('.result-container');
        let results = <?= json_encode($results); ?>;

        btns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const sortType = e.target.dataset.sort;

                // Sắp xếp kết quả theo tiêu chí
                switch (sortType) {
                    case 'high-price':
                        results.sort((a, b) => b.Lowest_Price - a.Lowest_Price);
                        break;
                    case 'low-price':
                        results.sort((a, b) => a.Lowest_Price - b.Lowest_Price);
                        break;
                    default: // Liên quan
                        results.sort((a, b) => b.views - a.views);
                        break;
                }

                // Cập nhật HTML
                resultContainer.innerHTML = results.map(result => `
                    <div class="product-item">
                        <div class="discount-container">
                            <p>Giảm ${result.discount_value}%</p>
                        </div>
                        <img src="./Upload/${result.img}" alt="${result.product_name}">
                        <hr>
                        <h5>${result.product_name}</h5>
                        <div class="rating-container">
                            <div class="rating">
                                ${renderRatingStars(result.rating)}
                            </div>
                            <p class="views"><ion-icon name="eye-outline"></ion-icon> ${result.views}</p>
                        </div>
                        <span class="sale">
                            Sale: 
                            ${result.discount_value > 0 && result.discount_status === 'active' 
                                ? `<span class="text-danger">${calculateDiscount(result)} VND</span>` 
                                : '0 VND'}
                            <span class="discount">${result.Lowest_Price.toLocaleString()} VNĐ</span>
                        </span>
                        <hr>
                        <a href="#" class="buy-now">Mua ngay</a>
                        <a href="?act=product_detail&id=${result.id}" class="learn-more">Xem chi tiết</a>
                    </div>
                `).join('');
            });
        });

        function calculateDiscount(result) {
            return result.discount_type === 'percentage' ?
                result.Lowest_Price * (1 - result.discount_value / 100) :
                result.Lowest_Price - result.discount_value;
        }

        function renderRatingStars(rating) {
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                if (rating >= i) stars += `<i class="fa-solid fa-star" style="color: blue;"></i>`;
                else if (rating > i - 1) stars += `<i class="fa-solid fa-star-half-stroke" style="color: blue;"></i>`;
                else stars += `<i class="fa-regular fa-star" style="color: lightgray;"></i>`;
            }
            return stars;
        }
    });
</script>