<?php
class Comment
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getComment(int $product_id): array
    {
        try {
            // Truy vấn để lấy danh sách bình luận kèm thông tin người dùng
            $sql = "
                SELECT 
                    c.id AS comment_id,
                    c.content AS comment_content,
                    c.like AS like_count,
                    c.dislike AS dislike_count,
                    c.created_at AS created_date,
                    u.id AS user_id,
                    u.user_name AS user_name,
                    u.avatar AS user_avatar
                FROM comments AS c
                INNER JOIN users AS u ON c.user_id = u.id
                WHERE c.product_id = :product_id
                ORDER BY c.created_at DESC";
    
            // Chuẩn bị câu lệnh
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    
            // Thực thi và lấy kết quả
            $stmt->execute();
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $comments ?: []; // Trả về mảng rỗng nếu không có dữ liệu
        } catch (PDOException $e) {
            // Ghi log lỗi để kiểm tra
            error_log("Error fetching comments for product ID $product_id: " . $e->getMessage());
            return [];
        }
    }
    
    public function addComment(int $productId, int $userId, string $content, int $rating): bool
    {
        try {
            // SQL thêm bình luận vào bảng `comments`
            $sql = "INSERT INTO comments (product_id, user_id, content, rating) 
                    VALUES (:product_id, :user_id, :content, :rating)";
            
            // Chuẩn bị câu lệnh
            $stmt = $this->conn->prepare($sql);
            
            // Xử lý nội dung
            $content = trim($content);
    
            // Bind các tham số
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':content', $content, PDO::PARAM_STR);
            $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
    
            // Thực thi câu lệnh
            $stmt->execute();
    
            return true;
        } catch (PDOException $e) {
            // Log lỗi nếu xảy ra lỗi
            error_log("PDOException: " . $e->getMessage());
            return false;
        }
    }
    
}
