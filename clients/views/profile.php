<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header text-center bg-primary text-white">
                <div class="position-relative d-inline-block">
                    <img src="<?php echo $user['avatar']; ?>" alt="User Avatar" class="rounded-circle" width="100" height="100">
                    <button class="btn btn-warning btn-sm position-absolute top-0 end-0 translate-middle p-2 rounded-circle">
                        ✎
                    </button>
                </div>
                <h1 class="mt-2"><?php echo $user['fullname']; ?></h1>
                <p class="text-muted"><?php echo $user['email']; ?></p>
            </div>
            <div class="card-body">
                <h2>Thông tin cá nhân</h2>
                <form action="?act=update_profile" method="POST" class="mt-3">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Họ và tên:</label>
                        <input type="text" class="form-control" name="fullname" value="<?php echo $user['fullname']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $user['email']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Số điện thoại:</label>
                        <input type="text" class="form-control" name="phone_number" value="<?php echo $user['phone_number']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="birthdate" class="form-label">Ngày sinh:</label>
                        <input type="date" class="form-control" name="birthdate" value="<?php echo $user['birthdate']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Giới tính:</label>
                        <select name="gender" class="form-select">
                            <option value="male" <?php echo $user['gender'] == 'male' ? 'selected' : ''; ?>>Nam</option>
                            <option value="female" <?php echo $user['gender'] == 'female' ? 'selected' : ''; ?>>Nữ</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ:</label>
                        <input type="text" class="form-control" name="address" value="<?php echo $user['address']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Cập nhật thông tin</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
