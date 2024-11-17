<?php
class Comment
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllCommentsCountByProduct()
    {
        try {
            // Chuẩn bị câu lệnh SQL để đếm số lượng bình luận từ bảng Comments và lấy thông tin sản phẩm
            $stmt = $this->conn->prepare("
                SELECT 
                    c.product_id AS Product_ID,
                    p.product_name AS Name_Product,
                    COUNT(c.id) AS Comment_Count,
                    MAX(c.created_at) AS Last_Comment_Date,
                    (SELECT content FROM Comments 
                     WHERE product_id = c.product_id 
                     ORDER BY created_at DESC LIMIT 1) AS Latest_Comment_Content
                FROM Comments c
                LEFT JOIN Products p ON c.product_id = p.id
                GROUP BY c.product_id, p.product_name
            ");

            // Thực hiện câu lệnh
            $stmt->execute();

            // Lấy tất cả kết quả
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            // Xử lý ngoại lệ một cách thích hợp
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

    public function getCommentBySearch($search)
    {
        try {
            // Kiểm tra giá trị $search trước khi tiếp tục (nếu không có từ khóa tìm kiếm, trả về mảng trống)
            if (empty($search)) {
                return []; // Trả về mảng trống nếu không có tìm kiếm
            }
    
            // Thêm ký tự % vào trước và sau từ khóa tìm kiếm để tìm kiếm theo mọi vị trí trong các trường
            $searchTerm = "%" . trim($search) . "%";
    
            // Chuẩn bị câu truy vấn SQL với JOIN
            $stmt = $this->conn->prepare("
                SELECT 
                    c.product_id AS Product_ID,
                    p.product_name AS Name_Product,
                    COUNT(c.id) AS Comment_Count,
                    MAX(c.created_at) AS Last_Comment_Date,
                    (
                        SELECT content 
                        FROM Comments sub_c 
                        WHERE sub_c.product_id = c.product_id 
                        ORDER BY sub_c.created_at DESC 
                        LIMIT 1
                    ) AS Latest_Comment_Content
                FROM Comments c
                LEFT JOIN Products p ON c.product_id = p.id
                WHERE 
                    p.product_name LIKE :search OR
                    EXISTS (
                        SELECT 1 
                        FROM Comments sub_c 
                        WHERE sub_c.product_id = c.product_id 
                        AND sub_c.content LIKE :search
                    )
                GROUP BY c.product_id, p.product_name
                ORDER BY Last_Comment_Date DESC
            ");
    
            // Thực thi câu truy vấn với tham số tìm kiếm
            $stmt->execute([':search' => $searchTerm]);
    
            // Lấy tất cả kết quả và trả về dưới dạng mảng kết hợp
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // Nếu có lỗi xảy ra, ghi lỗi vào log và trả về mảng trống
            error_log("Error in getCommentBySearch: " . $e->getMessage());
            return [];
        }
    }


    public function getCommentByUserOrContent($search)
    {
        try {
            // Kiểm tra giá trị $search trước khi tiếp tục (nếu không có từ khóa tìm kiếm, trả về mảng trống)
            if (empty($search)) {
                return []; // Trả về mảng trống nếu không có tìm kiếm
            }
    
            // Thêm ký tự % vào trước và sau từ khóa tìm kiếm để tìm kiếm theo mọi vị trí trong các trường
            $searchTerm = "%" . trim($search) . "%";
    
            // Chuẩn bị câu truy vấn SQL
            $stmt = $this->conn->prepare("
                SELECT 
                    c.id AS ID,
                    u.user_name AS User,
                    c.content AS Content,
                    c.`like` AS Likes,
                    c.dislike AS DisLikes,
                    c.created_at AS Ngay_Tao,
                    p.id AS Product_ID,
                    p.product_name AS Product_Name
                FROM Comments c
                JOIN Users u ON c.user_id = u.id
                JOIN Products p ON c.product_id = p.id
                WHERE 
                    u.user_name LIKE :search OR 
                    c.content LIKE :search OR
                    p.id LIKE :search OR
                    p.product_name LIKE :search
                ORDER BY c.created_at DESC
            ");
    
            // Thực thi câu truy vấn với tham số tìm kiếm
            $stmt->execute([':search' => $searchTerm]);
    
            // Lấy tất cả kết quả và trả về dưới dạng mảng kết hợp
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // Nếu có lỗi xảy ra, ghi lỗi vào log và trả về mảng trống
            error_log("Error in getCommentByUserOrContent: " . $e->getMessage());
            return [];
        }
    }
    

public function getCommentsBySearch($search)
{
    try {
        // Kiểm tra giá trị $search trước khi tiếp tục (nếu không có từ khóa tìm kiếm, trả về mảng trống)
        if (empty($search)) {
            return []; // Trả về mảng trống nếu không có tìm kiếm
        }

        // Thêm ký tự % vào trước và sau từ khóa tìm kiếm để tìm kiếm theo mọi vị trí trong các trường
        $searchTerm = "%" . trim($search) . "%";

        // Chuẩn bị câu truy vấn SQL để tìm kiếm
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
            WHERE 
                Comments.content LIKE :search OR
                Users.user_name LIKE :search
            ORDER BY Comments.created_at DESC
        ");

        // Thực thi câu truy vấn với tham số tìm kiếm
        $stmt->execute([':search' => $searchTerm]);

        // Lấy tất cả kết quả và trả về dưới dạng mảng kết hợp
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Xử lý lỗi nếu có
        error_log("Error in getCommentsBySearch: " . $e->getMessage());
        return []; // Trả về mảng rỗng trong trường hợp có lỗi
    }
}


    public function deleteComment($commentId)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM Comments WHERE id = :id");
            $stmt->bindParam(':id', $commentId, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi khi xóa bình luận: " . $e->getMessage();
            return false;
        }
    }
}
