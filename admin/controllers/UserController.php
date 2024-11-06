<?php
class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function views_users() {
        $users = $this->userModel->getAll();
        include '../admin/views/User/User.php';
    }

    public function views_add() {
        include '../admin/views/User/create.php';
    }

    public function views_edit() {
        $user = $this->userModel->getById($_GET['id']);
        include '../admin/views/User/edit.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            var_dump($_POST);
            var_dump($_FILES);
            
            $avatar = '../uploads/UserIMG/default.png';
            if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
                $uploadDir = '../uploads/UserIMG/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileName = time() . '_' . $_FILES['avatar']['name'];
                $uploadFile = $uploadDir . $fileName;
                
                if(move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile)) {
                    $avatar = $uploadFile;
                } else {
                    $_SESSION['error'] = "Không thể tải lên ảnh. Vui lòng thử lại!";
                }
            }
            
            $_POST['avatar'] = $avatar;
            var_dump($_POST);
            
            if($this->userModel->create($_POST)) {
                $_SESSION['success'] = "Thêm người dùng thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi thêm người dùng!";
            }
            die();
            header('Location:?act=users');
        }
    }

    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
                $uploadDir = '../uploads/UserIMG/';
                $fileName = time() . '_' . $_FILES['avatar']['name'];
                $uploadFile = $uploadDir . $fileName;
                
                if(move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile)) {
                    $_POST['avatar'] = $uploadFile;
                }
            } else {
                $_POST['avatar'] = $_POST['old_avatar'];
            }

            if($this->userModel->update($_GET['id'], $_POST)) {
                $_SESSION['success'] = "Cập nhật thông tin thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật!";
            }
            header('Location:?act=users');
        }
    }

    public function delete() {
        if($this->userModel->delete($_GET['id'])) {
            $_SESSION['success'] = "Xóa người dùng thành công!";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi xóa người dùng!";
        }
        header('Location:?act=users');
    }
}
?>