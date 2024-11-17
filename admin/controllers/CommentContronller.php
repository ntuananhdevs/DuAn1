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
        $commentCounts = $this->commentModel->getCommentsBySearch($search); 
    } else {
        // Nếu không có từ khóa tìm kiếm, lấy tất cả bình luận
        $commentCounts = $this->commentModel->getAllCommentsCountByProduct(); 
    }

    // Bao gồm view để hiển thị danh sách bình luận
    require_once '../admin/views/Comments/comments.php'; // Đảm bảo đường dẫn đúng
}
 public function viewComments($productId)
{
    // Lấy giá trị tìm kiếm từ URL
    $search = $_GET['search'] ?? '';
     $productId = $_GET['product_id'] ?? '';

    // Nếu có từ khóa tìm kiếm, gọi phương thức tìm kiếm bình luận theo nội dung hoặc người bình luận
    if ($search !== '') {
        $comments = $this->commentModel->getCommentByUserOrContent($search);
    } else {
        // Nếu không có từ khóa tìm kiếm, lấy tất cả bình luận cho sản phẩm
        $comments = $this->commentModel->getCommentsByProductId($productId);
    }

    // Kết hợp với giao diện hiển thị
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
