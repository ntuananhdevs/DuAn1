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
    public function vieweditComments($productId)
    {
        // Fetch comments for the product
        $comments = $this->commentModel->getCommentsByProductId($productId);
        include '../admin/views/comments/view_comments.php';
    }

    public function edit($id) {
        $comment = $this->commentModel->getCommentById($id);
        include '../admin/views/comments/edit_comment.php';
    }

   
    // Phương thức để xử lý việc cập nhật bình luận
    public function updateComment()
{
    // Kiểm tra xem phương thức yêu cầu là POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Lấy ID và nội dung mới của bình luận từ form
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $newComment = isset($_POST['comment']) ? $_POST['comment'] : null;

        // Gọi phương thức updateComment từ model
        $result = $this->updateComment($id, $newComment);

        // Xử lý kết quả
        if ($result['status'] === 'success') {
            // Chuyển hướng về trang danh sách bình luận với thông báo thành công
            header("Location: index.php?act=view_comments&product_id=" . $_GET['product_id'] . "&message=" . urlencode($result['message']));
            exit;
        } else {
            // Nếu có lỗi, hiển thị thông báo lỗi
            include '../admin/views/comments/edit_comment.php'; // Trở lại trang chỉnh sửa bình luận với thông báo lỗi
        }
    } else {
        // Nếu không phải là POST, chuyển hướng đến trang danh sách bình luận
        header("Location: index.php?act=view_comments&product_id=" . $_GET['product_id']);
        exit;
    }
}

    // Handle updating of a comment's content
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
