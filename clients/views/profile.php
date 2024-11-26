<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

.profile-container {
    max-width: 800px;
    margin: auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.profile-header {
    text-align: center;
    margin-bottom: 20px;
}

.profile-picture {
    position: relative;
    display: inline-block;
}

.profile-picture img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
}

.edit-button {
    position: absolute;
    top: 10px;
    right: 10px;
    background: yellow;
    border: none;
    border-radius: 50%;
    cursor: pointer;
}

.user-name {
    font-size: 24px;
    margin: 10px 0 5px;
}

.user-email {
    color: gray;
}

.profile-info {
    margin-top: 20px;
}

.profile-info h2 {
    margin-bottom: 15px;
}

.profile-info label {
    display: block;
    margin: 10px 0 5px;
}

.profile-info input,
.profile-info select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.profile-info button {
    background-color: #28a745;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.profile-info button:hover {
    background-color: #218838;
}
</style>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-picture">
                <img src="<?php echo $user['avatar']; ?>" alt="User Avatar">
                <button class="edit-button"></button>
            </div>
            <h1 class="user-name"><?php echo $user['fullname']; ?></h1>
            <p class="user-email"><?php echo $user['email']; ?></p>
        </div>
        <div class="profile-info">
            <h2>Thông tin cá nhân</h2>
            <form action="?act=update_profile" method="POST">
                <label for="fullname">Họ và tên:</label>
                <input type="text" name="fullname" value="<?php echo $user['fullname']; ?>" required>
                
                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo $user['email']; ?>" >
                
                <label for="phone_number">Số điện thoại:</label>
                <input type="text" name="phone_number" value="<?php echo $user['phone_number']; ?>" required>
                
                <label for="birthdate">Ngày sinh:</label>
                <input type="date" name="birthdate" value="<?php echo $user['birthdate']; ?>" required>
                
                <label for="gender">Giới tính:</label>
                <select name="gender">
                    <option value="male" <?php echo $user['gender'] == 'male' ? 'selected' : ''; ?>>Nam</option>
                    <option value="female" <?php echo $user['gender'] == 'female' ? 'selected' : ''; ?>>Nữ</option>
                </select>
                
                <label for="address">Địa chỉ:</label>
                <input type="text" name="address" value="<?php echo $user['address']; ?>" required>
                
                <button type="submit">Cập nhật thông tin</button>
            </form>
        </div>
    </div>
</body>
</html>
