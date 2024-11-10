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
    public function getBannerById() {
        $sql = "SELECT * FROM banners WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function create($title, $description, $img_url, $position, $start_date, $end_date, $status) {
        // Kiểm tra xem giá trị start_date có hợp lệ không
        if (empty($start_date)) {
            // Gán giá trị mặc định cho start_date nếu nó trống
            $start_date = date('Y-m-d H:i:s');
        }
    
        // Kiểm tra xem end_date có hợp lệ không
        if (empty($end_date)) {
            // Gán giá trị mặc định cho end_date nếu nó trống
            $end_date = date('Y-m-d H:i:s', strtotime('+1 day'));
        }
    
        // Sửa câu lệnh SQL để truyền đúng các giá trị vào các cột tương ứng
        $sql = "INSERT INTO `banners` (`title`, `description`, `img_url`, `position`, `start_date`, `end_date`, `status`) 
                VALUES (:title, :description, :img_url, :position, :start_date, :end_date, :status)";
    
        $stmt = $this->conn->prepare($sql);
    
        // Gắn giá trị vào các tham số trong câu lệnh SQL
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':img_url', $img_url);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->bindParam(':status', $status);
    
        // Thực thi câu lệnh SQL
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function delete ($id) {
        $sql = "DELETE FROM `banners` WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
}
