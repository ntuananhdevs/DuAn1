<?php


class CommentController {
    public $commentModel;

    public function __construct() {
        $this->commentModel = new Comment();
    }

    public function views_comment()
    {
        // Fetch all comments from the model
        $comments = $this->commentModel->getAllComments();
        
        // Display the comment view
        include '../admin/views/comments/comment.php';
    }
    public function edit($id, $data) {
        $this->commentModel->updateComment($id, $data);
        header("Location: ../admin/views/comment.php");
    }
    public function delete($id) {
        $this->commentModel->deleteComment($id);
        header("Location: ../admin/views/comment.php");
    }
}
