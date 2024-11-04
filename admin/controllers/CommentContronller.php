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

    public function edit($id) {
        $comment = $this->commentModel->getCommentById($id);
        include '../admin/views/comments/view_edit.php';
    }

   
    // Phương thức để xử lý việc cập nhật bình luận
    


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
