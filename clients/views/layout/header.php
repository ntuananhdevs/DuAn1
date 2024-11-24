<?php
    session_start();
    ob_start();
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        $sessionId = null; // Khi người dùng đã đăng nhập, không cần session_id
    } else {
        $userId = null;
        $sessionId = session_id(); // Sử dụng session_id() để theo dõi phiên
    }
    $cart = new ProductsContronller(new products());
    $cart_item = $cart->getCartItems($userId, $sessionId);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Default Title'; ?></title>
    <link rel="icon" href="./assets/img/logo.png" />
    <link rel="stylesheet" href="assets/css/client.css">
    <link rel="stylesheet" href="assets/css/banner.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>

<body>
    <div class="header-nav">
        <div class="header-right">
        </div>
    </div>
    <nav class="no-blur">
        <div class="nav-menu">
            <div class="logo-nav d-flex align-content-center">
                <a href="?act=/">
                    <img src="./assets/img/logo.png" alt="">
                </a>
                <p class="fw-bold">WinTech</p>
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
                                <li><a href="?act=laptop"><ion-icon name="arrow-forward-outline"></ion-icon>Laptop</a></li>
                                <li><a href="?act=phone"><ion-icon name="arrow-forward-outline"></ion-icon>Dien Thoai</a></li>
                                <li><a href="#"><ion-icon name="arrow-forward-outline"></ion-icon>AirPods</a></li>
                                <li><a href="#"><ion-icon name="arrow-forward-outline"></ion-icon>AirTag</a></li>
                                <li><a href="#"><ion-icon name="arrow-forward-outline"></ion-icon>Apple Trade In</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="cart-container">
                        <ion-icon name="cart-outline" id="CartIcon"></ion-icon>
                        <?php if (count($cart_item) > 0): ?>
                            <span class="cart-badge">
                                <div class="cart-badge-content">
                                    <?php echo count($cart_item); ?>
                                </div>
                            </span>
                        <?php endif; ?>
                        <div class="drop-down-cart" id="CartDropdown" style="border-radius: 4px;">
                            <p class="fw-bold"><?php echo count($cart_item); ?> items in cart</p>
                            <div class="cart-items" style="max-height: 200px; overflow-y: auto; position: relative; scrollbar-width: none; -ms-overflow-style: none;">
                                <?php foreach ($cart_item as $item): ?>
                                    <div class="cart-item d-flex gap-3 mt-3">
                                        <div class="img-cart ms-2">
                                            <img src="<?php echo removeLeadingDots(($item['img'])); ?>" alt="" style="height: 50px;">
                                        </div>
                                        <div class="text-cart">
                                            <div class="name-item">
                                                <p class="fw-bold"><?php echo htmlspecialchars($item['product_name']); ?></p>
                                                <p><?php echo htmlspecialchars($item['color']); ?>, <?php echo htmlspecialchars($item['ram']); ?>, <?php echo htmlspecialchars($item['storage']); ?></p>
                                                <div class="price-item d-flex justify-content-between">
                                                    <p class="fw-500">x<?php echo htmlspecialchars($item['quantity']); ?></p>
                                                    <p class="fw-500"><?php echo number_format($item['price'], 0, ',', '.'); ?>₫</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                <?php endforeach; ?>
                            </div>
                            <div class="fade-effect" style="position: absolute; bottom: 0; left: 0; right: 0; height: 20px; background: linear-gradient(to bottom, transparent, white);"></div>
                            <div class="subtotal d-flex justify-content-end mt-2">
                                <p class="me-2 fw-400">Cart subtotal</p>
                            </div>
                            <div class="subtotal d-flex justify-content-end">
                                <?php
                                $subtotal = 0;
                                foreach ($cart_item as $item) {
                                    $subtotal += $item['price'] * $item['quantity'];
                                }
                                ?>
                                <p class="me-2 fw-bold h3"><?php echo number_format($subtotal, 0, ',', '.'); ?>₫</p>
                            </div>
                            <form action="?act=shoppingcart" method="post">
                                <button type="submit" class="checkout-btn mt-3">Thanh toán</button>
                            </form>
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

    <style>
        .cart-container {
            margin-left: 10px;
            position: relative;
            display: inline-block;
        }

        .drop-down-cart {
            position: absolute;
            right: 0;
            top: 33px;
            width: 400px;
            background: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            display: none;
            z-index: 1000;
        }
        .checkout-btn {
            width: 100%;
            padding: 8px 16px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            height: 50px;
        }

        .checkout-btn:hover {
            background: #0056b3;
        }

        .cart-badge {
            height: 8px;
            width: 8px;
            position: absolute;
            top: -5px;
            right: -6px;
            background-color: blue;
            color: white;
            border-radius: 100%;
            padding: 6px;
            font-weight: bold;
        }
        .cart-items {
            max-height: 200px;
            overflow-y: auto;
            scrollbar-width: none;
            /* For Firefox */
            -ms-overflow-style: none;
            /* For Internet Explorer and Edge */
        }

        .cart-items::-webkit-scrollbar {
            display: none;
            /* For Chrome, Safari, and Opera */
        }
        .cart-badge-content {
            position: relative;
            margin-left: -2.5px;
            margin-top: -9px;
            font-size: 11px;
            padding: 0px;
        }
    </style>

    <script>
        document.getElementById("CartIcon").addEventListener("click", function() {
            const dropdown = document.getElementById("CartDropdown");
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        });

        window.addEventListener("click", function(e) {
            const dropdown = document.getElementById("CartDropdown");
            const cartIcon = document.getElementById("CartIcon");
            if (!dropdown.contains(e.target) && e.target !== cartIcon) {
                dropdown.style.display = "none";
            }
        });
    </script>