<!DOCTYPE html>
<html lang="en">

<head>
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
    
</head>

<body>
<div class="header-nav">
            <div class="header-logo">
                <div class="logo-header">
                    <a href="#">
                        <img src="../public/img/header-img/ROG_normal.svg" alt="">
                        <img src="../public/img/header-img/rog_hover.svg" alt="">
                    </a>
                </div>
                <div class="logo-header">
                    <a href="#">
                        <img src="../public/img/header-img/ProArt.svg" alt="">
                        <img src="../public/img/header-img/art_hover.svg" alt="">
                    </a>
                </div>
                <div class="logo-header">
                    <a href="#">
                        <img src="../public/img/header-img/ioT.svg" alt="">
                        <img src="../public/img/header-img/ioT_hover.svg" alt="">
                    </a>
                </div>
            </div>
            <div class="header-right">
                <a href="#">Sự kiện</a>
                <a href="#">Gaming</a>
                <a href="#">Doanh Nghiệp</a>
            </div>
        </div>
    <nav class="no-blur">
        
        <div class="nav-menu ">
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
                    <a href="#"><ion-icon name="cart-outline"></ion-icon></a>

                    <div class="search-overlay" id="searchOverlay">
                        <div class="search-nav">
                            <div class="inputsearch">
                            <ion-icon name="search-outline" size="large"></ion-icon>
                                <form method="GET" action="?act=search">
                                    <input type="text" name="search" placeholder="Tìm kiếm" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                                    <input type="hidden" name="act" value="search">
                                </form>
                            </div>
                            <ul class="list-search">
                                <p>Liên Kết Nhanh</p>

                                <li><a href="?act=laptop"><ion-icon name="arrow-forward-outline"></ion-icon>Laptop</a></li>
                                <li><a href="?act=phone"><ion-icon name="arrow-forward-outline"></ion-icon>Dien Thoai</a></li>
                                <li><a href="#"><ion-icon name="arrow-forward-outline"></ion-icon>AirPods</a></li>
                                <li><a href="#"><ion-icon name="arrow-forward-outline"></ion-icon>AirTag</a></li>
                                <li><a href="#"><ion-icon name="arrow-forward-outline"></ion-icon>Apple Trade In</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="dropdown">
                        <a href="#" id="userIcon"><ion-icon name="person-outline"></ion-icon></a>
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
