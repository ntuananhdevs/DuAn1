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

    public function getBannerBySearch($search)
    {
        try {

            if (empty($search)) {
                return []; 
            }
            $searchTerm = "%" . trim($search) . "%";
    
            // Chuẩn bị câu truy vấn SQL
            $stmt = $this->conn->prepare("
                SELECT 
                    id, 
                    title, 
                    description, 
                    img_url, 
                    position, 
                    start_date, 
                    end_date, 
                    status
                FROM banners
                WHERE id LIKE ? 
                   OR title LIKE ? 
                   OR description LIKE ? 
                   OR status LIKE ?
                ORDER BY start_date DESC
            ");
    
            // Thực thi câu truy vấn với các tham số tìm kiếm
            $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
    
            // Lấy tất cả kết quả và trả về dưới dạng mảng kết hợp
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        } catch (Exception $e) {
            // Nếu có lỗi xảy ra, ghi lỗi vào log và trả về mảng trống
            error_log("Error in getBannerBySearch: " . $e->getMessage());
            return [];
        }
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