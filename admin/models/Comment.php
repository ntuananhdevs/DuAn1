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
                    Users.user_name AS User,  
                    Comments.content AS Content,
                    Comments.`like` AS Likes,  
                    Comments.dislike AS DisLikes,  
                    Comments.created_at AS Ngay_Tao
                FROM Comments
                JOIN Users ON Comments.user_id = Users.id 
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
    
    public function getCommentById($id) {
        $query = "SELECT * FROM Comments WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật bình luận theo ID
    public function updateCommentById($id, $newComment) {
        $query = "UPDATE Comments 
                  SET content = :comment, updated_at = CURRENT_TIMESTAMP 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':comment', $newComment);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
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
