<?php
class Comment {
    private $conn;

    public function __construct() {
        $this->conn = connectDB() ;
    }

    public function getAllComments()
    {
        try {
            // Prepare the SQL statement to fetch comments along with product and user details
            $stmt = $this->conn->prepare("
                SELECT 
                    comments.comment_id AS ID,
                    products.product_name AS Name_Product,
                    products.quantity AS So_Luong,
                    users.username AS User,
                    comments.content AS Content,
                    comments.likes AS Likes,
                    comments.dislikes AS DisLikes,
                    comments.created_at AS Ngay_Tao
                FROM comments
                JOIN products ON comments.product_id = products.product_id
                JOIN users ON comments.user_id = users.user_id
            ");
            
            // Execute the statement
            $stmt->execute();
            
            // Fetch all comments as an associative array
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log the error message or handle it as needed
            echo "Error retrieving comments: " . $e->getMessage();
            return []; // Return an empty array or handle error as needed
        }
    }
    
    
    

    // public function addComment($data) {
    //     $stmt = $this->conn->prepare("INSERT INTO comments (user_id, product_id, content) VALUES (?, ?, ?)");
    //     return $stmt->execute([$data['user_id'], $data['product_id'], $data['content']]);
    // }

    // public function getComment($id) {
    //     $stmt = $this->conn->prepare("SELECT * FROM comments WHERE comment_id = ?");
    //     $stmt->execute([$id]);
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }
    public function updateComment($id, $data) {
        try {
            // Prepare the SQL statement to update the comment details
            $stmt = $this->conn->prepare("
                UPDATE comments 
                SET content = :content, likes = :likes, dislikes = :dislikes 
                WHERE comment_id = :id
            ");
    
            // Bind parameters to ensure safe data handling
            $stmt->bindParam(':content', $data['content']);
            $stmt->bindParam(':likes', $data['likes']);
            $stmt->bindParam(':dislikes', $data['dislikes']);
            $stmt->bindParam(':id', $id);
    
            // Execute the statement
            return $stmt->execute();
        } catch (PDOException $e) {
            // Log or display the error message as needed
            echo "Error updating comment: " . $e->getMessage();
            return false; // Return false or handle the error as needed
        }
    }
    

        public function deleteComment($id) {
            $stmt = $this->conn->prepare("DELETE FROM comments WHERE comment_id = ?");
            return $stmt->execute([$id]);
        }
}
