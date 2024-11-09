<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN</title>
  <link rel="stylesheet" href="../assets/css/login.css">
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body>
  <div class="login-box">
    <h2>Wellcome To Wintech</h2>
    <p>To get started, sign in to your account.</p>
    <form action="/?act=login" method="post">
      <div class="user-box">
        <input type="email" name="email" placeholder=" Enter your email" required>
      </div>
      <div class="user-box">
        <input type="password" name="password" placeholder="Enter your password" required>
      </div>
      <button type="submit">Sign in</button>
    </form>
    <a href="#">Forgot password?</a>
    <button type="submit">Sign in</button>
    
    <div class="social-login">
      <p>Or sign in with</p>
      <div class="social-buttons">
        <button class="google-btn" onclick="window.location.href='google-login.php'">
          <ion-icon name="logo-google"></ion-icon>
          Sign in with Google
        </button>
        <button class="facebook-btn" onclick="window.location.href='facebook-login.php'">
          <ion-icon name="logo-facebook"></ion-icon>
          Sign in with Facebook
        </button>
      </div>
    </div>
  </div>
</body>
</html>