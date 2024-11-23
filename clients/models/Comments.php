<?php
class Comment
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getComment($product_id)
    {
        try {
            $sql = "
                SELECT 
                    c.id AS comment_id,
                    c.content AS comment_content,
                    c.like AS like_count,
                    c.dislike AS dislike_count,
                    c.created_at AS created_date,
                    u.user_name AS user_name,
                    u.avatar AS user_avatar
                FROM comments AS c
                JOIN users AS u ON c.user_id = u.id
                WHERE c.product_id = :product_id
                ORDER BY c.created_at DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $comments;
        } catch (PDOException $e) {
            // Log lỗi và trả về mảng rỗng
            error_log("Error fetching comments: " . $e->getMessage());
            return [];
        }
    }
        
}
