<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin</title>
  <link rel="stylesheet" href="../assets/css/login.css">
</head>

<body>
  <div class="login-box">
    <h2 class="admin">Welcome To Wintech</h2>
    <form action="?act=login" method="post" onsubmit="return validateForm()">
      <div class="user-box">
        <input type="text" name="email" id="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($email ?? ''); ?>">
        <div id="emailError" class="error-message" style="color: red;">
          <?php echo $emailError ?? ''; ?>
        </div>
      </div>
      <div class="user-box">
        <input type="password" name="password" id="password" placeholder="Enter your password">
        <div id="passwordError" class="error-message" style="color: red;">
          <?php echo $passwordError ?? ''; ?>
          <?php if (!empty($error)): ?>
            <div class="error-message" style="color: red;">
              *<?php echo htmlspecialchars($error); ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
      <button type="submit">Login</button>
    </form>
  </div>  
</body>
</html>