<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LOGIN WINTECH</title>
    <link rel="stylesheet" href="./assets/css/loginClient.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
  </head>
  <body cal>
    <div class="gravity-bg">
      <div class="gravity-item pink"></div>
      <div class="gravity-item purple"></div>
      <div class="gravity-item yellow"></div>
      <div class="gravity-item blue"></div>
    </div>
    
    <div class="container" id="container">
      <div class="form-container register-container">
        <form>
          <h3>Sign Up To Wintech</h3>
          <div class="form-control">
            <input type="text" id="username" placeholder="Name" />
            <small id="username-error"></small>
            <span></span>
          </div>
          <div class="form-control">
            <input type="email" id="email" placeholder="Email" />
            <small id="email-error"></small>
            <span></span>
          </div>
          <div class="form-control">
            <input type="password" id="password" placeholder="Password" />
            <small id="password-error"></small>
            <span></span>
          </div>
          <button type="submit" value="submit">sign up</button>
          <span>Sign in</span>
          <div class="social-container">
            <a href="#" class="social"
              ><i class="fa-brands fa-facebook-f"></i
            ></a>
            <a href="#" class="social"><i class="fa-brands fa-google"></i></a>
            <a href="#" class="social"><i class="fa-brands fa-tiktok"></i></a>
          </div>
        </form>
      </div>

      <div class="form-container login-container">
        <form class="form-lg" action="../controllers/LoginController.php" method="POST">
          <h2>Wellcome to WINTECH</h2>
          <div class="form-control2">
            <input type="email" name="email" class="email-2" placeholder="Email" required />
            <small class="email-error-2"></small>
            <span></span>
          </div>
          <div class="form-control2">
            <input type="password" name="password" class="password-2" placeholder="Password" required />
            <small class="password-error-2"></small>
            <span></span>
          </div>

          <div class="content">
            <div class="checkbox">
              <input type="checkbox" name="remember" id="checkbox" />
              <label for="">Remember me</label>
            </div>
            <div class="pass-link">
              <a href="#">Forgot password?</a>
            </div>
          </div>
          <button type="submit" name="login">Login</button>
          <span>Or use your account</span>
          <div class="social-container">
            <a href="#" class="social"
              ><i class="fa-brands fa-facebook-f"></i
            ></a>
            <a href="#" class "social"><i class="fa-brands fa-google"></i></a>
            <a href="#" class="social"><i class="fa-brands fa-tiktok"></i></a>
          </div>
        </form>
      </div>

      <div class="overlay-container">
        <div class="overlay">
          <div class="overlay-panel overlay-left">
            <h1 class="title">
              Hello <br />
              friends
            </h1>
            <p>If you have an account, login here and enjoy</p>
            <button class="ghost" id="login">
              Login
              <i class="fa-solid fa-arrow-left"></i>
            </button>
          </div>

          <div class="overlay-panel overlay-right">
            <h1 class="title">
              Start your <br />
              journey now
            </h1>
            <p>
                If you don't have an account, join us and start your journey
            </p>
            <button class="ghost" id="register">
              Register
              <i class="fa-solid fa-arrow-right"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </body>
  <script src="./assets/js/loginclient.js"></script>
</html>
