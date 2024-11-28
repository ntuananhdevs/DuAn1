<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Đăng nhập</title>
   <link rel="stylesheet" href="./assets/css/login.css">
</head>

<body>
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
         <h5 class="login__title">Thay đổi mật khẩu</h5>
         <div class="login__area">
            <form method="POST" action="?act=changepassword" id="loginForm" class="login__form" onsubmit="return validatePasswords()">
               <div class="login__content grid">
                  <div class="login__box">
                     <input type="password" name="new_password" id="new_password" placeholder=" " class="login__input">
                     <label for="new_password" class="login__label">New Password</label>
                     <i class="ri-mail-fill login__icon"></i>
                  </div>
                  <p class="login__error" id="new_password_error"></p>

                  <div class="login__box">
                     <input type="password" name="confirm_password" id="confirm_password" placeholder=" " class="login__input">
                     <label for="confirm_password" class="login__label">Confirm New Password</label>
                     <i class="ri-eye-off-fill login__icon login__password" id="loginPassword"></i>
                  </div>
                  <p class="login__error" id="confirm_password_error"></p>

               </div>

               <button type="submit" class="login__button">Thay đổi</button>
            </form>
            
            <script>
               function validatePasswords() {
                  var newPassword = document.getElementById('new_password').value;
                  var confirmPassword = document.getElementById('confirm_password').value;
                  
                  if (newPassword === '' || confirmPassword === '') {
                     document.getElementById('new_password_error').innerHTML = 'Passwords cannot be empty.';
                     document.getElementById('confirm_password_error').innerHTML = 'Passwords cannot be empty.';
                     return false;
                  }
                  
                  if (newPassword !== confirmPassword) {
                     document.getElementById('confirm_password_error').innerHTML = 'Passwords do not match.';
                     return false;
                  }
                  
                  return true;
               }
            </script>

         </div>
      </div>
   </div>
</body>
</html>

<style>
   .login__error {
      color: red;
   }
</style>