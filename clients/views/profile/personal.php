<div class="content-section">
    <!-- Header Section -->
    <div class="section-header">
        <h2 class="section-title">Thông tin cá nhân</h2>
        <p class="section-desc">Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
    </div>

    <!-- Alerts Section -->
    <div class="alerts-container">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i>
                <?= $_SESSION['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i>
                <?= $_SESSION['success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="profile-layout">
        <!-- Left Column - Avatar -->
        <div class="profile-avatar-section">
            <div class="avatar-container">
                <?php 
                $avatarPath = !empty($user['avatar']) ? 'uploads/UserIMG/' . $user['avatar'] : 'assets/images/default-avatar.png';
                ?>
                <img src="<?= $avatarPath ?>" 
                     class="profile-avatar" 
                     id="avatar-preview" 
                     alt="Avatar">
                
                <div class="avatar-edit">
                    <form id="avatar-form" enctype="multipart/form-data">
                        <label for="avatar-upload" class="avatar-upload-btn">
                            <i class="fas fa-camera"></i>
                        </label>
                        <input type="file" 
                               id="avatar-upload" 
                               name="avatar" 
                               accept="image/png, image/jpeg, image/gif" 
                               style="display: none;">
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column - Form -->
        <div class="profile-form-section">
            <form action="?act=update_profile" method="POST" id="profile-form" class="needs-validation" novalidate>
                <div class="form-group form-group-static">
                    <label for="user_name" class="form-label-static">Tên đăng nhập</label>
                    <input type="text" id="user_name" 
                           value="<?= htmlspecialchars($user['user_name'] ?? '') ?>" 
                           class="form-control-static" readonly>
                </div>

                <div class="form-group">
                    <label for="fullname">Họ và tên <span class="required">*</span></label>
                    <input type="text" id="fullname" name="fullname"
                           value="<?= htmlspecialchars($user['fullname'] ?? '') ?>" 
                           class="form-control" required>
                    <div class="invalid-feedback">Vui lòng nhập họ và tên</div>
                </div>

                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input readonly  type="email" id="email" name="email"
                           value="<?= htmlspecialchars($user['email'] ?? '') ?>" 
                           class="form-control" required>
                    <div class="invalid-feedback">Vui lòng nhập email hợp lệ</div>
                </div>

                <div class="form-group">
                    <label for="phone_number">Số điện thoại <span class="required">*</span></label>
                    <input type="tel" id="phone_number" name="phone_number"
                           value="<?= htmlspecialchars($user['phone_number'] ?? '') ?>" 
                           class="form-control" pattern="[0-9]{10}" required>
                    <div class="invalid-feedback">Vui lòng nhập số điện thoại hợp lệ (10 chữ số)</div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu thay đổi
                    </button>
                    <a href="?act=profile" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('avatar-upload').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    // Kiểm tra kích thước file
    if (file.size > 5 * 1024 * 1024) {
        alert('File quá lớn. Vui lòng chọn file nhỏ hơn 5MB');
        this.value = '';
        return;
    }

    // Kiểm tra loại file
    if (!file.type.match('image.*')) {
        alert('Vui lòng chọn file ảnh');
        this.value = '';
        return;
    }

    const formData = new FormData();
    formData.append('avatar', file);

    const mainPreview = document.getElementById('avatar-preview');
    const sidebarPreview = document.getElementById('sidebar-avatar-preview');
    const container = mainPreview.parentElement;
    
    // Hiển thị loading
    mainPreview.style.opacity = '0.5';
    if (sidebarPreview) sidebarPreview.style.opacity = '0.5';
    
    const loadingSpinner = document.createElement('div');
    loadingSpinner.className = 'loading-spinner';
    container.appendChild(loadingSpinner);

    // Gửi request
    fetch('?act=update-avatar', {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Thêm timestamp để tránh cache
            const newUrl = data.avatarUrl + '?t=' + new Date().getTime();
            
            // Cập nhật cả hai ảnh
            mainPreview.src = newUrl;
            if (sidebarPreview) sidebarPreview.src = newUrl;
            
            // Hiển thị thông báo thành công
            const alertHtml = `
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> ${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`;
            document.querySelector('.alerts-container').innerHTML = alertHtml;
        } else {
            throw new Error(data.message || 'Có lỗi xảy ra');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Hiển thị thông báo lỗi
        const alertHtml = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> ${error.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
        document.querySelector('.alerts-container').innerHTML = alertHtml;
    })
    .finally(() => {
        // Xóa loading
        mainPreview.style.opacity = '1';
        if (sidebarPreview) sidebarPreview.style.opacity = '1';
        container.querySelector('.loading-spinner')?.remove();
        this.value = ''; // Reset input file
    });
});
</script>

<style>
.profile-form-section {
    background: #fff;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
}

.form-control {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 0.75rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #4a90e2;
    box-shadow: 0 0 0 0.2rem rgba(74,144,226,0.25);
}

.gender-options {
    display: flex;
    gap: 1rem;
    padding: 0.5rem 0;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #4a90e2;
    border: none;
}

.btn-primary:hover {
    background: #357abd;
    transform: translateY(-1px);
}

.btn-secondary {
    background: #6c757d;
    border: none;
}

.btn i {
    margin-right: 0.5rem;
}

.required {
    color: #dc3545;
}

.invalid-feedback {
    font-size: 0.875rem;
    color: #dc3545;
}

@media (max-width: 768px) {
    .profile-form-section {
        padding: 1rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
    }
}

/* Thêm CSS cho loading spinner */
.loading-spinner {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}

.profile-avatar-section {
    text-align: center;
    margin-bottom: 2rem;
}

.avatar-container {
    position: relative;
    width: 200px;
    height: 200px;
    margin: 0 auto;
    border-radius: 50%;
    overflow: hidden;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.profile-avatar {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-edit {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: rgba(255, 255, 255, 0.9);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.avatar-edit:hover {
    background: #fff;
    transform: scale(1.1);
}

.avatar-upload-btn {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.avatar-upload-btn i {
    font-size: 1.2rem;
    color: #333;
}

/* Thêm style cho ảnh sidebar */
.sidebar-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #fff;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

/* Style cho ảnh chính */
.profile-avatar {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #fff;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}

.avatar-container {
    position: relative;
    margin: 0 auto;
    width: fit-content;
}

.loading-spinner {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}

/* Readonly field styles */
.form-control-static {
    background-color: #f8f9fa !important;
    border: 1px solid #e9ecef !important;
    color: #6c757d !important;
    cursor: not-allowed !important;
    pointer-events: none;
    padding: 0.6rem 1rem;
    border-radius: 6px;
    font-size: 14px;
    width: 100%;
}

.form-control-static:focus {
    box-shadow: none !important;
    border-color: #e9ecef !important;
}

.form-label-static {
    color: #6c757d;
}

/* Add visual indication for readonly fields */
.form-group-static {
    position: relative;
}

.form-group-static::after {
    content: '\f023';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #adb5bd;
    font-size: 14px;
    pointer-events: none;
}
</style> 