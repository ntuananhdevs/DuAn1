<?php

class CommentController
{
    public $commentModel;

    public function __construct()
    {
        $this->commentModel = new Comment();
    }

    public function views_comment()
    {
        // Fetch the count of comments per product from the model
        $commentCounts = $this->commentModel->getAllCommentsCountByProduct();

        // Display the comment count view
        include '../admin/views/Comments/comments.php';
    }
    public function viewComments($productId)
    {
        // Fetch comments for the product
        $comments = $this->commentModel->getCommentsByProductId($productId);
        include '../admin/views/comments/view_comments.php';
    }

    public function editCommentForm($commentId)
    {
        // Fetch the specific comment for editing
        $comment = $this->commentModel->getCommentById($commentId);
        include '../admin/views/Comments/edit_comment.php';
    }
    public function showComment($commentId) {
        $comment = $this->commentModel->getCommentById($commentId);
        
        if ($comment) {
            // Trả về comment dưới dạng JSON (có thể điều chỉnh theo nhu cầu)
            echo json_encode($comment);
        } else {
            // Trả về thông báo lỗi nếu không tìm thấy comment
            echo json_encode(["error" => "Comment not found."]);
        }
    }

    // Handle updating of a comment's content
    public function updateComment($commentId, $newContent) {
        // Kiểm tra xem nội dung có hợp lệ không (có thể điều chỉnh theo nhu cầu)
        if (empty($newContent)) {
            echo json_encode(["error" => "Content cannot be empty."]);
            return;
        }

        $result = $this->commentModel->updateCommentContent($commentId, $newContent);
        
        if ($result) {
            // Trả về thông báo thành công
            echo json_encode(["success" => "Comment updated successfully."]);
        } else {
            // Trả về thông báo lỗi nếu cập nhật không thành công
            echo json_encode(["error" => "Failed to update comment."]);
        }
    }
    public function deleteComment($commentId)
    {
        if ($this->commentModel->deleteComment($commentId)) {
            header("Location: index.php?act=view_comments&product_id=" . $_GET['product_id']);
            exit;
        } else {
            echo "Error deleting comment.";
        }
    }
}
