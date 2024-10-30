<?php
class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function views_users() {
        $users = $this->userModel->getAll();
        include '../admin/views/User.php';
    }

    public function views_add() {
        include '../admin/views/create.php';
    }

    public function views_edit() {
        $user = $this->userModel->getById($_GET['id']);
        include '../admin/views/edit.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->userModel->create($_POST);
            header('Location: index.php?act=users');
        }
    }

    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->userModel->update($_GET['id'], $_POST);
            header('Location: index.php?act=users');
        }
    }

    public function delete() {
        $this->userModel->delete($_GET['id']);
        header('Location: index.php?act=users');
    }
}
?>