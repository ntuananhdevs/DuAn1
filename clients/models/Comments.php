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

    public function updateLikeDislike($user_id, $comment_id, $action , $product_id)
    {
        // Kiểm tra hành động hợp lệ
        if (!in_array($action, ['like', 'dislike'])) {
            return false;
        }
    
        // Kiểm tra xem người dùng đã thực hiện hành động với bình luận này chưa
        $sqlCheck = "SELECT action FROM comment_likes_dislikes WHERE user_id = :user_id AND comment_id = :comment_id";
        $stmtCheck = $this->conn->prepare($sqlCheck);
        $stmtCheck->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmtCheck->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
        $stmtCheck->execute();
        $existingAction = $stmtCheck->fetch(PDO::FETCH_ASSOC);
    
        if ($existingAction) {
            // Nếu người dùng đã thực hiện hành động
            if ($existingAction['action'] === $action) {
                // Nếu hành động giống nhau, xóa hành động
                $sqlDelete = "DELETE FROM comment_likes_dislikes WHERE user_id = :user_id AND comment_id = :comment_id";
                $stmtDelete = $this->conn->prepare($sqlDelete);
                $stmtDelete->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmtDelete->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
                if ($stmtDelete->execute()) {
                    // Giảm số lượng like/dislike trong bảng comments
                    $field = $action === 'like' ? '`like`' : '`dislike`';
                    $sqlAdjust = "UPDATE comments SET $field = $field - 1 WHERE id = :comment_id";
                    $stmtAdjust = $this->conn->prepare($sqlAdjust);
                    $stmtAdjust->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
                    return $stmtAdjust->execute();
                }
            } else {
                // Nếu hành động khác, cập nhật hành động trong bảng
                $sqlUpdateAction = "UPDATE comment_likes_dislikes SET action = :action WHERE user_id = :user_id AND comment_id = :comment_id";
                $stmtUpdateAction = $this->conn->prepare($sqlUpdateAction);
                $stmtUpdateAction->bindParam(':action', $action, PDO::PARAM_STR);
                $stmtUpdateAction->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmtUpdateAction->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
                if ($stmtUpdateAction->execute()) {
                    // Cập nhật số lượng like/dislike trong bảng comments
                    if ($action === 'like') {
                        $sqlAdjust = "
                            UPDATE comments 
                            SET `like` = `like` + 1, `dislike` = `dislike` - 1 
                            WHERE id = :comment_id";
                    } else {
                        $sqlAdjust = "
                            UPDATE comments 
                            SET `dislike` = `dislike` + 1, `like` = `like` - 1 
                            WHERE id = :comment_id";
                    }
    
                    $stmtAdjust = $this->conn->prepare($sqlAdjust);
                    $stmtAdjust->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
                    return $stmtAdjust->execute();
                }
            }
        } else {
            // Nếu chưa có hành động, thêm mới
            $sqlInsert = "INSERT INTO comment_likes_dislikes (user_id, comment_id, action) VALUES (:user_id, :comment_id, :action)";
            $stmtInsert = $this->conn->prepare($sqlInsert);
            $stmtInsert->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmtInsert->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
            $stmtInsert->bindParam(':action', $action, PDO::PARAM_STR);
    
            if ($stmtInsert->execute()) {
                // Cập nhật số lượng like/dislike
                $field = $action === 'like' ? '`like`' : '`dislike`';
                $sqlUpdate = "UPDATE comments SET $field = $field + 1 WHERE id = :comment_id";
                $stmtUpdate = $this->conn->prepare($sqlUpdate);
                $stmtUpdate->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
                return $stmtUpdate->execute();
            }
        }
    
        return false;
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

