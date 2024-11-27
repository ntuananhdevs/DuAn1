<?php
class ProfileController {
    public $profile;

    public function __construct() {
        $this->profile = new ProfileModel();
    }

    public function showProfile() {
        $userId = $_SESSION['user_id'] ?? null;
    
        if ($userId) {
            $user = $this->profile->getUserById($userId);
            // Đảm bảo avatar có giá trị mặc định nếu không có
            if (empty($user['avatar'])) {
                $user['avatar'] = ''; // Hoặc đường dẫn tới ảnh mặc định
            }
            include './clients/views/profile.php';
        } else {
            header('Location: login.php');
            exit;
        }
    }
    

    public function updateAvatar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
            // Lấy userId từ session
            $userId = $_SESSION['user_id'] ?? null;
            if (!$userId) {
                $_SESSION['error'] = "Bạn cần đăng nhập trước.";
                header('Location: login.php');
                exit;
            }

            // Xử lý tải lên ảnh
            $avatar = $this->uploadAvatar();

            if ($avatar) {
                // Cập nhật avatar trong cơ sở dữ liệu
                if ($this->profile->updateAvatar($userId, $avatar)) {
                    $_SESSION['success'] = "Cập nhật ảnh đại diện thành công!";
                } else {
                    $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật ảnh đại diện.";
                }
            } else {
                $_SESSION['error'] = "Không thể tải lên ảnh. Vui lòng thử lại!";
            }

            // Quay lại trang profile
            header('Location: ?action=profile');
        }
    }

    private function uploadAvatar() {
        if ($_FILES['avatar']['error'] === 0) {
            $uploadDir = '../uploads/UserIMG/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = time() . '_' . $_FILES['avatar']['name'];
            $uploadFile = $uploadDir . $fileName;
    
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile)) {
                return $uploadFile; // Đường dẫn tới ảnh tải lên
            }
        }
        return false;
    }
    
}

?>