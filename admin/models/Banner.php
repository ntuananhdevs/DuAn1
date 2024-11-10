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
    public function create($data) {
        $img_url = !empty($data['img_url']) ? $data['img_url'] : '../uploads/BannerIMG/default.png';

        $sql = "INSERT INTO Banners (title, description, img_url, position, start_date, end_date, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $data['title'],
            $data['description'],
            $img_url,
            $data['position'],
            $data['start_date'],
            $data['end_date'],
            $data['status']
        ]);
    }
}
