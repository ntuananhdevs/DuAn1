<?php
class Comment {
    private $conn;

    public function __construct() {
        $this->conn = connectDB() ;
    }

    public function getAllCommentsCountByProduct()
    {
        try {
            // Prepare the SQL statement to count the number of comments per product and get relevant information
            $stmt = $this->conn->prepare("
                SELECT 
                    p.id AS Product_ID,
                    p.product_name AS Name_Product,
                    COUNT(c.id) AS Comment_Count,
                    MAX(c.created_at) AS Last_Comment_Date,
                    (SELECT content FROM Comments 
                     WHERE product_id = p.id 
                     ORDER BY created_at DESC LIMIT 1) AS Latest_Comment_Content
                FROM Products p
                LEFT JOIN Comments c ON c.product_id = p.id
                GROUP BY p.id, p.product_name
            ");
            
            // Execute the statement
            $stmt->execute();
    
            // Fetch all results
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
    
        } catch (Exception $e) {
            // Handle exceptions appropriately
            return ['error' => $e->getMessage()];
        }
    }
    public function getCommentsByProductId($productId)
    {
        try {
            // Chuẩn bị câu truy vấn SQL để lấy bình luận theo ID sản phẩm
            $stmt = $this->conn->prepare("
                SELECT 
                    Comments.id AS ID,
                    Users.user_name AS User,  -- sửa từ 'username' thành 'user_name'
                    Comments.content AS Content,
                    Comments.`like` AS Likes,  -- sửa từ 'likes' thành 'like'
                    Comments.dislike AS DisLikes,  -- sửa từ 'dislikes' thành 'dislike'
                    Comments.created_at AS Ngay_Tao
                FROM Comments
                JOIN Users ON Comments.user_id = Users.id  -- sửa từ 'users' thành 'Users' và 'user_id' thành 'id'
                WHERE Comments.product_id = :product_id
                ORDER BY Comments.created_at DESC
            ");
    
            // Liên kết tham số với giá trị thực tế
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            // Thực thi câu truy vấn
            $stmt->execute();
    
            // Trả về tất cả các bình luận dưới dạng mảng
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Xử lý lỗi nếu có
            echo "Lỗi khi lấy bình luận: " . $e->getMessage();
            return []; // Trả về mảng rỗng trong trường hợp có lỗi
        }
    }
    
    
            
            // Bind the product ID parameter to the query
            // Handle any errors that occur during the query execution
            public function getCommentById($commentId) {
                // Lấy comment theo ID
                try {
                    // Chuẩn bị câu lệnh SQL
                    $stmt = $this->conn->prepare("
                        SELECT 
                            comments.comment_id AS ID,
                            comments.content AS Content
                        FROM comments
                        WHERE comment_id = :comment_id
                    ");
                    
                    // Ràng buộc tham số comment_id
                    $stmt->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
                    
                    // Thực hiện truy vấn
                    $stmt->execute();
                    
                    // Trả về comment nếu tìm thấy
                    return $stmt->fetch(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    // Xử lý lỗi nếu có
                    echo "Error retrieving comment: " . $e->getMessage();
                    return null;
                }
            }
            
            public function updateCommentContent($commentId, $newContent) {
                // Cập nhật nội dung của comment
                try {
                    // Chuẩn bị câu lệnh SQL để cập nhật
                    $stmt = $this->conn->prepare("UPDATE comments SET content = :content WHERE comment_id = :comment_id");
                    
                    // Ràng buộc các tham số
                    $stmt->bindParam(':content', $newContent, PDO::PARAM_STR);
                    $stmt->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
                    
                    // Thực hiện cập nhật và trả về kết quả
                    return $stmt->execute();
                } catch (PDOException $e) {
                    // Xử lý lỗi nếu có
                    echo "Error updating comment: " . $e->getMessage();
                    return false;
                }
            }
            
   
    public function deleteComment($commentId)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM comments WHERE comment_id = :comment_id");
            $stmt->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error deleting comment: " . $e->getMessage();
            return false;
        }
    }
}
