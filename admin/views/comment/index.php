<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Quản lý Bình luận</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Danh sách Bình luận</h1>
       
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Tên Sản phẩm</th>
                    <th>Người dùng</th>
                    <th>Nội dung</th>
                    <th>Số Lượng</th>
                    <th>Thích</th>
                    <th>Không thích</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
               
                    <?php foreach ($comments as  $key => $value): ?>
                        <tr>
                            <td><?= $value['ID']; ?></td>
                            <td><?= htmlspecialchars($value['Name_Product']); ?></td>                           
                            <td><?= htmlspecialchars($value['User']); ?></td>
                            <td><?= htmlspecialchars($value['Content']); ?></td>
                            <td><?= $value['So_Luong']; ?></td>
                            <td><?= $value['Likes']; ?></td>
                            <td><?= $value['DisLikes']; ?></td>
                            <td><?= $value['Ngay_Tao']; ?></td>
                            <td>
                                <a href="index.php?act=edit&id=<?= $value['ID']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                                <a href="index.php?act=delete&id=<?= $value['ID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa bình luận này?')">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
             
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
