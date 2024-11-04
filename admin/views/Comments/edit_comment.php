<?php
// Giả sử biến $comment đã được lấy từ cơ sở dữ liệu

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Bình Luận</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Sửa Bình Luận</h2>

    <form action="update_comment.php" method="POST">
        <!-- ID của bình luận (ẩn đi) -->
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($comment['id']); ?>">

        <!-- Nội dung mới của bình luận -->
        <div class="form-group">
            <label for="comment">Nội dung bình luận:</label>
            <textarea name="comment" id="comment" class="form-control" rows="5"><?php echo htmlspecialchars($comment['content']); ?></textarea>
        </div>
        
        <!-- Nút gửi form -->
        <button type="submit" class="btn btn-primary">Cập Nhật Bình Luận</button>
        <a href=".php" class="btn btn-secondary">Hủy</a>
    </form>
</div>

<!-- Bootstrap JS và các thư viện liên quan -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
