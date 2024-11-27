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

    public function updateLikeDislike($userId, $commentId, $action)
    {
        // Lấy trạng thái hiện tại của comment
        $sqlFetch = "SELECT `like`, `dislike` FROM comments WHERE id = :comment_id";
        $stmtFetch = $this->conn->prepare($sqlFetch);
        $stmtFetch->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
        $stmtFetch->execute();
        $comment = $stmtFetch->fetch(PDO::FETCH_ASSOC);
    
        if (!$comment) {
            // Comment không tồn tại
            return false;
        }
    
        try {
            // Bắt đầu giao dịch
            $this->conn->beginTransaction();
    
            if ($action === 'like') {
                if ($comment['like'] > 0) {
                    // Nếu đã like, giảm like
                    $sqlLike = "UPDATE comments SET `like` = `like` - 1 WHERE id = :comment_id";
                    $stmtLike = $this->conn->prepare($sqlLike);
                    $stmtLike->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
                    $stmtLike->execute();
                } else {
                    // Nếu chưa like, tăng like và giảm dislike nếu có
                    if ($comment['dislike'] > 0) {
                        $sqlDislike = "UPDATE comments SET `dislike` = `dislike` - 1 WHERE id = :comment_id";
                        $stmtDislike = $this->conn->prepare($sqlDislike);
                        $stmtDislike->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
                        $stmtDislike->execute();
                    }
    
                    $sqlLike = "UPDATE comments SET `like` = `like` + 1 WHERE id = :comment_id";
                    $stmtLike = $this->conn->prepare($sqlLike);
                    $stmtLike->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
                    $stmtLike->execute();
                }
            } elseif ($action === 'dislike') {
                if ($comment['dislike'] > 0) {
                    // Nếu đã dislike, giảm dislike
                    $sqlDislike = "UPDATE comments SET `dislike` = `dislike` - 1 WHERE id = :comment_id";
                    $stmtDislike = $this->conn->prepare($sqlDislike);
                    $stmtDislike->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
                    $stmtDislike->execute();
                } else {
                    // Nếu chưa dislike, tăng dislike và giảm like nếu có
                    if ($comment['like'] > 0) {
                        $sqlLike = "UPDATE comments SET `like` = `like` - 1 WHERE id = :comment_id";
                        $stmtLike = $this->conn->prepare($sqlLike);
                        $stmtLike->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
                        $stmtLike->execute();
                    }
    
                    $sqlDislike = "UPDATE comments SET `dislike` = `dislike` + 1 WHERE id = :comment_id";
                    $stmtDislike = $this->conn->prepare($sqlDislike);
                    $stmtDislike->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
                    $stmtDislike->execute();
                }
            }
    
            // Commit giao dịch
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            // Rollback nếu có lỗi
            $this->conn->rollBack();
            return false;
        }
    }
    
    
    public function addComment($user_id, $product_id, $content, $rating)
    {
        $sql = "INSERT INTO comments (user_id, product_id, content, rating) 
                VALUES (:user_id, :product_id, :content, :rating)";
        $stmt = $this->conn->prepare($sql);
        
        // Gắn các giá trị vào tham số
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_STR);

        return $stmt->execute();
    }
    
}

