<?php 
class Banner {
    public $conn;
    public function __construct() { 
        $this->conn = connectDB();
    }
    public function getBanner() {
        $sql = "SELECT * FROM banners";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getBannerById($id) {
        $query = "SELECT * FROM Banners WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function create($title, $description, $img_url, $position, $start_date, $end_date, $status) {
        if (empty($start_date)) {
            $start_date = date('Y-m-d H:i:s');
        }
        if (empty($end_date)) {
            $end_date = date('Y-m-d H:i:s', strtotime('+1 day'));
        }
        $sql = "INSERT INTO `banners` (`title`, `description`, `img_url`, `position`, `start_date`, `end_date`, `status`) 
                VALUES (:title, :description, :img_url, :position, :start_date, :end_date, :status)";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':img_url', $img_url);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->bindParam(':status', $status);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function update ($id, $title, $description, $img_url, $position, $start_date, $end_date, $status) {
        $sql = "UPDATE `banners` SET `title` = :title, `description` = :description, `img_url` = :img_url, `position` = :position,  `start_date` = :start_date, `end_date` = :end_date, `status` = :status WHERE `id` = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);        
        $stmt->bindParam(':img_url', $img_url);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    
    public function delete ($id) {
        $sql = "DELETE FROM `banners` WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
}