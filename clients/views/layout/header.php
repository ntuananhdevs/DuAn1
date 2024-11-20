 <!DOCTYPE html>
<html lang="en">

<head>
    <!-- Trong phần <head> của header.php -->
<style>
    /* CSS của giỏ hàng */
    #cart-dropdown {
        position: absolute;
        top: 50px; /* Vị trí giỏ hàng */
        right: 0;
        width: 300px;
        background-color: white;
        border: 1px solid #ddd;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        padding: 10px;
        display: none;
    }

    .cart-items {
        max-height: 400px;
        overflow-y: auto;
    }

    .cart-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .cart-item img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        margin-right: 10px;
    }

    .cart-item-info {
        flex-grow: 1;
    }

    .cart-item-info h4 {
        font-size: 14px;
        margin: 0;
        font-weight: 600;
        color: #333;
    }

    .cart-item-info p {
        font-size: 12px;
        margin: 3px 0;
        color: #555;
    }

    .cart-total {
        margin-top: 10px;
        font-size: 14px;
        text-align: right;
        font-weight: 600;
        color: #333;
    }

    .cart-total p {
        margin: 5px 0;
    }

    a {
        cursor: pointer;
    }

    #cart-container {
        display: none;
        position: absolute;
        top: 0;
        right: 0;
        z-index: 999;
    }
</style>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Default Title'; ?></title>
    <link rel="icon" type="image/svg" href="public/img/header-img/rog_hover.svg" />
    <link rel="stylesheet" href="assets/css/client.css">
    <link rel="stylesheet" href="assets/css/banner.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</head>

<body>
    <div class="header-nav">

        <div class="header-right">

        </div>
    </div>
    <nav class="no-blur">

        <div class="nav-menu">
            <div class="logo-nav">
                <a href="?act=/">
                    <img src="../assets/img/logo.png" alt="">
                </a>
            </div>
            <div class="nav-center">
                <a href="?act=laptop">Laptop</a>
                <a href="?act=phone">Thiết bị di động</a>
                <a href="#">Màn Hình / Máy Bàn</a>
                <a href="#">Bo Mạch Chủ / Linh Kiện</a>
                <a href="#">Thiết Bị Mạng / IoT / Servers</a>
                <a href="#">Phụ Kiện</a>
            </div>
            <div class="nav-right">
                <div class="text">
                    <a href="#">Mua hàng</a>
                    <a href="#">Hỗ Trợ</a>
                </div>
                <div class="icon-nav">
                    <ion-icon name="search-outline" id="searchIcon"></ion-icon>
                    <a href="javascript:void(0);" onclick="toggleCart();">
                        <ion-icon name="cart-outline"></ion-icon>
                    </a>
                    <div id="cart-container" style="display: none;"></div>

                    <script>
                    function toggleCart() {
                        const cartContainer = document.getElementById('cart-container');
                        cartContainer.style.display = cartContainer.style.display === 'none' ? 'block' : 'none';

                        // Gửi yêu cầu AJAX để lấy giỏ hàng
                        fetch('index.php?act=view_cart')
                            .then(response => response.text())
                            .then(html => {
                                cartContainer.innerHTML = html;
                            })
                            .catch(err => console.error('Lỗi khi tải giỏ hàng:', err));
                    }
                    </script>

                    <div class="search-overlay" id="searchOverlay">
                        <div class="search-nav">
                            <div class="inputsearch">
                            <ion-icon name="search-outline" size="large"></ion-icon>
                                <form method="GET" action="?act=result">
                                    <input type="hidden" name="act" value="result">
                                    <input type="text" name="search" placeholder="Tìm kiếm" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                                   
                                </form>
                            </div>
                            <ul class="list-search">
                                <p>Liên Kết Nhanh</p>

                                <li><a href="?act=laptop">
                                        <ion-icon name="arrow-forward-outline"></ion-icon>Laptop
                                    </a></li>
                                <li><a href="?act=phone">
                                        <ion-icon name="arrow-forward-outline"></ion-icon>Dien Thoai
                                    </a></li>
                                <li><a href="#">
                                        <ion-icon name="arrow-forward-outline"></ion-icon>AirPods
                                    </a></li>
                                <li><a href="#">
                                        <ion-icon name="arrow-forward-outline"></ion-icon>AirTag
                                    </a></li>
                                <li><a href="#">
                                        <ion-icon name="arrow-forward-outline"></ion-icon>Apple Trade In
                                    </a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="dropdown">

                        <a href="#" id="userIcon">
                            <ion-icon name="person-outline"></ion-icon>
                        </a>
                        <div class="dropdown-menu">

                            <?php if (isset($_SESSION['user_id'])) : ?>

                            <a href="?act=profile">Tài khoản của tôi</a>
                            <a href="?act=orders">Kiểm tra đơn hàng</a>
                            <a href="?act=logout">Đăng xuất</a>
                            <?php else : ?>

                            <a href="?act=login">Đăng nhập</a>
                            <a href="?act=profile">Tài khoản của tôi</a>
                            <a href="?act=orders">Kiểm tra đơn hàng</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <script>
    document.getElementById('userIcon').addEventListener('click', function(event) {
        event.preventDefault();
        document.querySelector('.dropdown-menu').classList.toggle('show');
    });
    let lastScrollTop = 0;

    document.getElementById('searchIcon').addEventListener('click', function() {
        document.getElementById('searchOverlay').classList.toggle('active');
        document.querySelector('.main-content').classList.toggle('blurred');
    });

    // Close overlay when clicking outside
    document.addEventListener('click', function(event) {
        var searchOverlay = document.getElementById('searchOverlay');
        if (!searchOverlay.contains(event.target) && !event.target.closest('#searchIcon')) {
            searchOverlay.classList.remove('active');
            document.querySelector('.main-content').classList.remove('blurred');
        }
    });

    // Prevent closing overlay when clicking inside it
    document.querySelector('.search-overlay').addEventListener('click', function(event) {
        event.stopPropagation();
    });

    // Close search overlay on scroll
    window.addEventListener('scroll', function() {
        let st = window.pageYOffset || document.documentElement.scrollTop;
        if (st > lastScrollTop) {
            document.getElementById('searchOverlay').classList.remove('active');
            document.querySelector('.main-content').classList.remove('blurred');
        }
        lastScrollTop = st <= 0 ? 0 : st; // For Mobile or negative scrolling
    });
    </script>

    <script>
    AOS.init();
    </script>

    <script src="../assets/js/main.js"></script>
    <script src="path/to/your/js/cart.js">
    document.querySelector("a[href='#']").addEventListener("mouseenter", function() {
        document.getElementById('cart-dropdown').style.display = 'block';
    });

    document.querySelector("a[href='#']").addEventListener("mouseleave", function() {
        document.getElementById('cart-dropdown').style.display = 'none';
    });
</script>
