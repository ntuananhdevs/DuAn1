<?php
class OderController {
    private $OderModel;

    public function __construct() {
        $this->OderModel = new User();
    }

    public function views_oder() {
        $users = $this->OderModel->getAll();
        include '../admin/views/oder/Oder.php';
    }

    public function views_add() {
        include '../admin/views/oder/Odercreate.php';
    }

    public function views_edit() {
        $user = $this->OderModel->getById($_GET['id']);
        include '../admin/views/oder/Oderedit.php';
    }

    public function add() {
        
        
    }

    public function edit() {
       
    }

    public function delete() {
        
    }
}
?>