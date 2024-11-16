<?php

class CommentController
{
    public $commentModel;

    public function __construct()
    {
        $this->commentModel = new Comment();
    }


    public function views_Comment()
{
    // Lấy giá trị tìm kiếm từ URL
    $search = $_GET['search'] ?? ''; 

    // Nếu có từ khóa tìm kiếm, gọi phương thức tìm kiếm bình luận
    if ($search !== '') {
        $commentCounts = $this->commentModel->getCommentBySearch($search); 
    } else {
        // Nếu không có từ khóa tìm kiếm, lấy tất cả bình luận
        $commentCounts = $this->commentModel->getAllCommentsCountByProduct(); 
    }

    // Bao gồm view để hiển thị danh sách bình luận
    require_once '../admin/views/Comments/comments.php'; // Đảm bảo đường dẫn đúng
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
