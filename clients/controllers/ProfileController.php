<?php
class ProfileController {
    private $profile;

    public function __construct() {
        // Khởi động session nếu chưa start
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->profile = new ProfileModel();
    }

    public function showProfile() {
        // Debug session
        error_log('Current session user_id: ' . ($_SESSION['user_id'] ?? 'not set'));
        
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            $_SESSION['error'] = "Vui lòng đăng nhập để xem thông tin";
            header('Location: ?act=login');
            exit;
        }

        $user = $this->profile->getUserById($userId);
        if (!$user) {
            $_SESSION['error'] = "Không tìm thấy thông tin người dùng";
            header('Location: /');
            exit;
        }

        $section = $_GET['section'] ?? 'personal';
        require_once './clients/views/profile.php';
    }

    public function updateProfile() {
        error_log('=== Update Profile Debug ===');
        error_log('Request Method: ' . $_SERVER['REQUEST_METHOD']);
        error_log('POST data: ' . print_r($_POST, true));

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?act=profile&section=personal');
            exit;
        }

        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            $_SESSION['error'] = "Vui lòng đăng nhập để cập nhật thông tin";
            header('Location: index.php?act=login');
            exit;
        }

        $fullname = trim($_POST['fullname'] ?? '');
        $phone_number = trim($_POST['phone_number'] ?? '');
        $email = trim($_POST['email'] ?? '');

        // Validation
        if (empty($fullname) || empty($phone_number)) {
            $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin bắt buộc";
            header('Location: index.php?act=profile&section=personal');
            exit;
        }

        $updateData = [
            'fullname' => $fullname,
            'email' => $email,
            'phone_number' => $phone_number
        ];

        if ($this->profile->updateUserProfile($userId, $updateData)) {
            $_SESSION['success'] = "Cập nhật thông tin thành công!";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật thông tin";
        }

        header('Location: index.php?act=profile&section=personal');
        exit;
    }

    public function updateAvatar() {
        // Debug session và request
        error_log('Update Avatar - Session user_id: ' . ($_SESSION['user_id'] ?? 'not set'));
        error_log('Files received: ' . print_r($_FILES, true));
        
        header('Content-Type: application/json');
        
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Phương thức không hợp lệ');
            }

            $userId = $_SESSION['user_id'] ?? null;
            if (!$userId) {
                throw new Exception('Vui lòng đăng nhập');
            }

            if (empty($_FILES['avatar'])) {
                throw new Exception('Không tìm thấy file upload');
            }

            $file = $_FILES['avatar'];
            
            // Kiểm tra lỗi upload
            if ($file['error'] !== UPLOAD_ERR_OK) {
                throw new Exception('Lỗi khi upload file: ' . $file['error']);
            }

            // Kiểm tra kích thước file (5MB)
            if ($file['size'] > 5 * 1024 * 1024) {
                throw new Exception('File quá lớn. Vui lòng chọn file nhỏ hơn 5MB');
            }

            // Kiểm tra loại file
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($fileInfo, $file['tmp_name']);
            finfo_close($fileInfo);

            if (!in_array($mimeType, $allowedTypes)) {
                throw new Exception('Chỉ chấp nhận file ảnh (JPG, PNG, GIF)');
            }

            // Tạo thư mục upload nếu chưa tồn tại
            $uploadDir = 'uploads/UserIMG/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Tạo tên file mới
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $fileName = 'avatar_' . $userId . '_' . time() . '.' . $extension;
            $targetPath = $uploadDir . $fileName;

            // Di chuyển file upload
            if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                throw new Exception('Không thể lưu file');
            }

            // Xóa ảnh cũ
            $user = $this->profile->getUserById($userId);
            if (!empty($user['avatar'])) {
                $oldAvatarPath = 'uploads/UserIMG/' . $user['avatar'];
                if (file_exists($oldAvatarPath)) {
                    unlink($oldAvatarPath);
                }
            }

            // Cập nhật database
            if (!$this->profile->updateUserAvatar($userId, $fileName)) {
                // Nếu không cập nhật được DB, xóa file mới upload
                unlink($targetPath);
                throw new Exception('Lỗi khi cập nhật thông tin avatar');
            }

            echo json_encode([
                'success' => true,
                'avatarUrl' => $targetPath,
                'message' => 'Cập nhật ảnh đại diện thành công'
            ]);

        } catch (Exception $e) {
            error_log('Avatar update error: ' . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }
}
?>
