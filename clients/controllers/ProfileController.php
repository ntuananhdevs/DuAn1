<?php
class ProfileController {
    public $profile;

        public function __construct() {
            $this->profile = new ProfileModel();
        }

    public function showProfile($userId) {
        $user = $this->profile->getUserById($userId);
        include './clients/views/profile.php';
    }
}
?>
