<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/profile.css">
    <style>
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
        animation: slideIn 0.5s ease-in-out;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert i {
        font-size: 20px;
    }

    .alert-close {
        margin-left: auto;
        cursor: pointer;
        font-size: 20px;
        color: inherit;
        opacity: 0.5;
    }

    .alert-close:hover {
        opacity: 1;
    }

    @keyframes slideIn {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }

        to {
            opacity: 0;
        }
    }

    .avatar-wrapper {
        position: relative;
        display: inline-block;
    }

    .btn-change-avatar {
        position: absolute;
        bottom: 15px;
        right: 15px;
        background-color: #FFCC33;
        border: none;
        padding: 5px;
        cursor: pointer;
        border-radius: 50%;
        font-size: 12px;
    }

    .btn-change-avatar:hover {
        background-color: rgba(255, 255, 255, 1);
    }
    </style>
</head>

<body>
    <main>
        <div class="container">
            <div class="profile-wrapper">
                <!-- Sidebar -->
                <div class="profile-sidebar">
                    <div class="user-info">
                        <div class="avatar-wrapper">
                            <img id="avatarImage"
                                src="<?= !empty($user['avatar']) ? htmlspecialchars($user['avatar']) : '' ?>"
                                alt="Avatar" class="avatar">
                            <form action="?action=update-avatar" method="POST" enctype="multipart/form-data"
                                class="avatar-form" id="avatarForm">
                                <input type="file" name="avatar" accept="" id="avatarInput"
                                    style="display: none;" onchange="previewAvatar(event)">
                                <button type="button" class="btn-change-avatar"
                                    onclick="document.getElementById('avatarInput').click();">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                            </form>
                        </div>

                        <h3><?= htmlspecialchars($user['user_name'] ?? '') ?></h3>
                        <p class="email"><?= htmlspecialchars($user['email'] ?? '') ?></p>
                    </div>
                    <nav class="profile-nav">
                        <a href="#profile" class="active">
                            <i class="fas fa-user"></i>Thông tin cá nhân
                        </a>
                        <a href="?action=orders">
                            <i class="fas fa-shopping-bag"></i>Đơn hàng của tôi
                        </a>
                        <a href="#address">
                            <i class="fas fa-map-marker-alt"></i>Sổ địa chỉ
                        </a>
                        <a href="#password">
                            <i class="fas fa-lock"></i>Đổi mật khẩu
                        </a>
                    </nav>
                </div>

                <!-- Main Content -->
                <div class="profile-content">
                    <div class="content-section" id="profile">
                        <h2>Thông tin cá nhân</h2>

                        <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger" id="errorAlert">
                            <i class="fas fa-exclamation-circle"></i>
                            <span><?= htmlspecialchars($_SESSION['error']) ?></span>
                            <?php unset($_SESSION['error']); ?>
                            <span class="alert-close" onclick="closeAlert(this.parentElement)">&times;</span>
                        </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success" id="successAlert">
                            <i class="fas fa-check-circle"></i>
                            <span><?= htmlspecialchars($_SESSION['success']) ?></span>
                            <?php unset($_SESSION['success']); ?>
                            <span class="alert-close" onclick="closeAlert(this.parentElement)">&times;</span>
                        </div>
                        <?php endif; ?>

                        <form class="profile-form" action="?action=update-profile" method="POST"
                            enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Họ và tên</label>
                                <input type="text" name="fullname"
                                    value="<?= htmlspecialchars($user['user_name'] ?? '') ?>"
                                    placeholder="Nhập họ và tên">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="tel" name="phone"
                                    value="<?= htmlspecialchars($user['phone_number'] ?? '') ?>"
                                    placeholder="Nhập số điện thoại">
                            </div>
                            <div class="form-group">
                                <label>Ngày sinh</label>
                                <input type="date" name="birthday"
                                    value="<?= htmlspecialchars($user['birthday'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label>Giới tính</label>
                                <select name="gender">
                                    <option value="">Chọn giới tính</option>
                                    <option value="1" <?= ($user['gender'] ?? '') == 1 ? 'selected' : '' ?>>Nam</option>
                                    <option value="0" <?= ($user['gender'] ?? '') == 0 ? 'selected' : '' ?>>Nữ</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Địa chỉ</label>
                                <textarea name="address" rows="3"
                                    placeholder="Nhập địa chỉ"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                            </div>
                            <button type="submit" class="btn-save">Lưu thay đổi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'clients/views/layout/footer.php' ?>

    <script>
    // Tự động ẩn thông báo sau 5 giây
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                if (alert) {
                    fadeOutAlert(alert);
                }
            }, 5000);
        });
    });

    // Hàm đóng thông báo khi click
    function closeAlert(alert) {
        fadeOutAlert(alert);
    }

    // Hiệu ứng fade out
    function fadeOutAlert(alert) {
        alert.style.animation = 'fadeOut 0.5s ease-in-out';
        setTimeout(() => {
            alert.remove();
        }, 500);
    }

    function previewAvatar(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarImage').src = e.target.result; // Cập nhật ảnh đại diện
            }
            reader.readAsDataURL(file);
            // Gửi form ngay sau khi chọn ảnh
            document.getElementById('avatarForm').submit();
        }
    }
    </script>


    <script>
    function previewAvatar(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarImage').src = e.target.result; // Cập nhật ảnh đại diện
            }
            reader.readAsDataURL(file);
            // Gửi form ngay sau khi chọn ảnh
            document.getElementById('avatarForm').submit();
        }
    }
    </script>
</body>

</html>