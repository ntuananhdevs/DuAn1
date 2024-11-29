<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Đăng nhập</title>
   <link rel="stylesheet" href="./assets/css/login.css">
</head>

<body>
   <!-- <div id="message-popup" class="message-popup"></div> -->
   <svg class="login__blob" viewBox="0 0 566 840" xmlns="http://www.w3.org/2000/svg">
      <mask id="mask0" mask-type="alpha">
         <path d="M342.407 73.6315C388.53 56.4007 394.378 17.3643 391.538 
            0H566V840H0C14.5385 834.991 100.266 804.436 77.2046 707.263C49.6393 
            591.11 115.306 518.927 176.468 488.873C363.385 397.026 156.98 302.824 
            167.945 179.32C173.46 117.209 284.755 95.1699 342.407 73.6315Z" />
      </mask>

      <g mask="url(#mask0)">
         <path d="M342.407 73.6315C388.53 56.4007 394.378 17.3643 391.538 
            0H566V840H0C14.5385 834.991 100.266 804.436 77.2046 707.263C49.6393 
            591.11 115.306 518.927 176.468 488.873C363.385 397.026 156.98 302.824 
            167.945 179.32C173.46 117.209 284.755 95.1699 342.407 73.6315Z" />

         <!-- Insert your image (recommended size: 1000 x 1200) -->
         <image class="login__img" href="./assets/img/illustrations/backgroundlogin.jpg" />
      </g>
   </svg>
   <div class="login container grid" id="loginAccessRegister">
      <!--===== LOGIN ACCESS =====-->
      <div class="login__access">
         <h1 class="login__title">Log in to your account.</h1>

         <div class="login__area">
            <form method="POST" action="?act=login" id="loginForm" class="login__form">
               <div id="error" class="error-message" style="color: red;">
                  <?php echo $error ?? ''; ?>
               </div>
               <div class="login__content grid">
                  <div class="login__box">
                     <input type="text" name="email" id="email" placeholder=" " class="login__input">
                     <label for="email" class="login__label">Email</label>
                     <i class="ri-mail-fill login__icon"></i>
                  </div>
                  <div id="emailError" class="error-message" style="color: red;">
                     <?php echo $emailError ?? ''; ?>
                  </div>

                  <div class="login__box">
                     <input type="password" name="password" id="password" placeholder=" " class="login__input">
                     <label for="password" class="login__label">Password</label>
                     <i class="ri-eye-off-fill login__icon login__password" id="loginPassword"></i>
                  </div>
                  <div id="passwordError" class="error-message" style="color: red;">
                     <?php echo $passwordError ?? ''; ?>
                  </div>
               </div>

               <a href="#" class="login__forgot">Forgot your password?</a>

               <button type="submit" class="login__button">Login</button>
            </form>

            <div class="login__social">
               <p class="login__social-title">Or login with</p>

               <div class="login__social-links">
                  <a href="#" class="login__social-link">
                     <img src="./assets/img/logos/icon-google.svg" alt="image" class="login__social-img">
                  </a>

                  <a href="#" class="login__social-link">
                     <img src="./assets/img/logos/icon-facebook.svg" alt="image" class="login__social-img">
                  </a>

                  <a href="#" class="login__social-link">
                     <img src="./assets/img/logos/icon-apple.svg" alt="image" class="login__social-img">
                  </a>
               </div>
            </div>

            <p class="login__switch">
               Don't have an account?
               <button id="loginButtonRegister">Create Account</button>
            </p>
         </div>
      </div>
      <div class="login__register">
         <h1 class="login__title">Create new account.</h1>

         <div class="login__area">
            <form method="POST" action="index.php?act=register" id="resigers11" class="login__form">
               <div class="login__content grid">
                  <div id="message" class="error-message" style="color: red;">
                     <?php echo $message ?? ''; ?>
                  </div>
                  <div class="login__group grid">
                     <div class="login__box">
                        <input type="text" name="user_name" id="names" placeholder=" " class="login__input">
                        <label for="names" class="login__label">Names</label>
                        <i class="ri-id-card-fill login__icon"></i>
                        <div id="namesError" class="error-message" style="color: red;">
                           <?php echo $namesError ?? ''; ?>
                        </div>
                     </div>

                     <div class="login__box">
                        <input type="text" name="fullname" id="surnames" placeholder=" " class="login__input">
                        <label for="surnames" class="login__label">Fullname</label>
                        <i class="ri-id-card-fill login__icon"></i>  
                     </div>
                     <div id="surnamesError" class="error-message" style="color: red;">
                        <?php echo $surnamesError ?? ''; ?>
                     </div>
                  </div>

                  <div class="login__box">
                     <input type="email" name="email" id="emailCreate" placeholder=" " class="login__input">
                     <label for="emailCreate" class="login__label">Email</label>
                     <i class="ri-mail-fill login__icon"></i>
                  </div>
                  <div id="emailCreateError" class="error-message" style="color: red;">
                     <?php echo $emailCreateError ?? ''; ?>
                  </div>

                  <div class="login__box">
                     <input type="text" name="phone_number" id="phone_number" placeholder=" " class="login__input">
                     <label for="phone_number" class="login__label">SDT</label>
                     <i class="ri-mail-fill login__icon"></i>
                  </div>
                  <div id="phone_numberError" class="error-message" style="color: red;">
                     <?php echo $phone_numberError ?? ''; ?>
                  </div>

                  <div class="login__box">
                     <input type="password" name="password" id="passwordCreate" placeholder=" " class="login__input">
                     <label for="passwordCreate" class="login__label">Password</label>
                     <i class="ri-eye-off-fill login__icon login__password" id="loginPasswordCreate"></i>
                  </div>
                  <div id="passwordCreateError" class="error-message" style="color: red;">
                     <?php echo $passwordCreateError ?? ''; ?>
                  </div>
               </div>

               <button type="submit" class="login__button">Create account</button>
            </form>

            <p class="login__switch">
               Already have an account?
               <button id="loginButtonAccess">Log In</button>
            </p>
         </div>
      </div>
   </div>
   <script src="./assets/js/loginclient.js"></script>
</body>

</html>