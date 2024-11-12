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
        include '../admin/views/Comments/view_comments.php';
    }

  

   
    // Phương thức để xử lý việc cập nhật bình luận
    


     public function deleteComment($commentId)
    {
        $this->commentModel->deleteComment($commentId);
        header("Location: ?act=comments");
        exit();
    }
}
