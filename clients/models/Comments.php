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
        
    public function get_comments_by_product($product_id)
    {
        try {
            $sql = "SELECT c.id, c.user_id, c.content, c.like, c.dislike, c.created_at, 
                           u.username AS user_name
                    FROM comments c
                    LEFT JOIN users u ON c.user_id = u.id
                    WHERE c.product_id = :product_id
                    ORDER BY c.created_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("PDOException: " . $e->getMessage());
            return [];
        }
    }
    public function add_comment($product_id, $user_id, $content, $rating = null)
    {
        try {
            // Insert comment into the comments table
            $sql = "INSERT INTO comments (product_id, user_id, content, created_at) 
                    VALUES (:product_id, :user_id, :content, NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':content', $content, PDO::PARAM_STR);
            $stmt->execute();

            // Update the product's rating if rating is provided
            if (!is_null($rating)) {
                $this->update_product_rating($product_id, $rating);
            }

            return true;
        } catch (PDOException $e) {
            error_log("PDOException: " . $e->getMessage());
            return false;
        }
    }
    public function update_product_rating($product_id, $new_rating)
    {
        try {
            // Get the current ratings
            $sql = "SELECT AVG(rating) AS average_rating 
                    FROM comments 
                    WHERE product_id = :product_id AND rating IS NOT NULL";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $average_rating = $result['average_rating'] ?? $new_rating;

            // Update the product's rating
            $sql = "UPDATE products SET rating = :rating WHERE id = :product_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':rating', $average_rating, PDO::PARAM_STR);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            error_log("PDOException: " . $e->getMessage());
            return false;
        }
    }

}
