<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài khoản - <?= htmlspecialchars($user['user_name'] ?? '') ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/profile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>


<body>
    <div class="container">
        <div class="profile-header">
            <h1>Tài khoản</h1>
            <p>Chào mừng, <?= htmlspecialchars($user['user_name'] ?? '') ?>!</p>
        </div>

        <div class="profile-content">
            <!-- Left Sidebar -->
            <div class="profile-sidebar">
                <div class="user-info">
                    <div class="avatar-wrapper">
                        <?php 
                        $avatarPath = !empty($user['avatar']) ? 'uploads/UserIMG/' . $user['avatar'] : 'assets/images/default-avatar.png';
                        ?>
                        <img src="<?= $avatarPath ?>" class="sidebar-avatar" id="sidebar-avatar-preview" alt="Avatar">
                    </div>
                    <div class="user-details">
                        <h4><?= htmlspecialchars($user['fullname'] ?? $user['user_name']) ?></h4>
                        <p class="text-muted">Member since <?= date('Y', strtotime($user['created_at'])) ?></p>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="profile-nav">
                    <ul class="nav flex-column">
                        <li>
                            <a class="nav-link" href="?act=profile">
                                <i class="fas fa-home"></i> Tổng quan
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" href="?act=profile&section=messages">
                                <i class="fas fa-envelope"></i> Trung tâm tin nhắn
                            </a>
                        </li>
                        <li class="nav-section">
                            <button class="section-toggle" data-target="account-settings">
                                <i class="fas fa-cog"></i>
                                <span>Cài đặt tài khoản</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <ul id="account-settings" class="collapse">
                                <li><a href="?act=profile&section=personal">Hồ sơ cá nhân</a></li>
                                <li><a href="?act=profile&section=#">Đổi mật khẩu</a></li>
                            </ul>
                        </li>
                        <li class="nav-section">
                            <button class="section-toggle" data-target="order-status">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Trạng thái đơn hàng</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <ul id="order-status" class="collapse">
                                <li><a href="?act=orders">Đơn hàng</a></li>
                                <li><a href="?act=#">Trả hàng</a></li>
                                <li><a href="?act=#">Sổ địa chỉ</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Main Content Area -->
            <div class="profile-main">
                <?php
                // Kiểm tra và load nội dung tương ứng với section
                if (isset($_GET['section'])) {
                    switch ($_GET['section']) {
                        case 'personal':
                            require_once './clients/views/profile/personal.php';
                            break;
                        case 'login':
                            require_once './clients/views/profile/personal.php';
                            break;
                        case 'password':
                            require_once './clients/views/profile/personal.php';
                            break;
                        case 'register':
                            require_once './clients/views/profile/personal.php';
                            break;
                        default:
                            // Hiển thị nội dung mặc định
                            ?>


                <?php
                            break;
                    }
                } else {
                    // Hiển thị nội dung mặc định khi không có section
                    ?>
                <div class="content-section">
                    <h2>Đăng ký sản phẩm</h2>
                    <div class="product-registration">
                        <a href="?act=profile">
                            <img src="./assets/img/logo.png" alt="">
                        </a>
                        <p>Khi bạn hoàn thành quá trình đăng ký sản phẩm, các thiết bị sẽ hiển thị ở đây.</p>
                        <a href="#register-product" class="btn-register">Đăng ký sản phẩm đầu tiên của bạn</a>
                    </div>
                </div>


                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggles = document.querySelectorAll('.section-toggle');

        toggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const targetUl = document.getElementById(targetId);
                const parentSection = this.closest('.nav-section');

                // Toggle active state
                this.classList.toggle('active');
                parentSection.classList.toggle('open');

                // Toggle dropdown
                if (targetUl.classList.contains('show')) {
                    targetUl.classList.remove('show');
                } else {
                    // Close other dropdowns
                    document.querySelectorAll('.nav-section ul').forEach(ul => {
                        ul.classList.remove('show');
                    });
                    document.querySelectorAll('.section-toggle').forEach(t => {
                        t.classList.remove('active');
                    });
                    document.querySelectorAll('.nav-section').forEach(s => {
                        s.classList.remove('open');
                    });

                    // Open current dropdown
                    targetUl.classList.add('show');
                    this.classList.add('active');
                    parentSection.classList.add('open');
                }
            });
        });
    });
    </script>
</body>

</html>