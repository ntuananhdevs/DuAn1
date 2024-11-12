<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/logo.png">
  <title>
    Admin
  </title>

  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
  <!-- bootstrap.min.css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>

<body class="g-sidenav-show  bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand d-flex align-items-center px-4 py-3 m-0" target="_blank" style="gap: 8px;">
        <img src="../assets/img/logo.png" class="navbar-brand-img" width="35" height="35" alt="main_logo">
        <span class="h5 font-weight-bolder" style="position: relative; top: 5px;">WinTech</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link <?php echo (isset($_GET['act']) && $_GET['act'] == '/' ? 'active bg-gradient-dark text-white' : 'text-dark'); ?>" href="?act=/">
            <ion-icon name="home-outline" size="small" style="gap: 8px;"></ion-icon>
            <span class="nav-link-text ms-1" style="position: relative; ">Home</span>
          </a>
        </li>
        <li class="nav-item mt-1">
          <a class="nav-link <?php echo (isset($_GET['act']) && $_GET['act'] == 'users' ? 'active bg-gradient-dark text-white' : 'text-dark'); ?>" href="?act=users">
            <ion-icon name="person-circle-outline" size="small"></ion-icon>
            <span class="nav-link-text ms-1" style="position: relative; ">Users</span>
          </a>
        </li>
        <li class="nav-item mt-1">
          <a class="nav-link <?php echo (isset($_GET['act']) && $_GET['act'] == 'banner' ? 'active bg-gradient-dark text-white' : 'text-dark'); ?>" href="?act=banner">
            <ion-icon name="images-outline" size="small"></ion-icon>
            <span class="nav-link-text ms-1">Banner</span>
          </a>
        </li>
        <li class="nav-item mt-1">
          <a class="nav-link <?php echo (isset($_GET['act']) && $_GET['act'] == 'products' ? 'active bg-gradient-dark text-white' : 'text-dark'); ?>" href="?act=products">
            <i class="material-symbols-rounded opacity-5">table_view</i>
            <span class="nav-link-text ms-1" style="position: relative; ">Products</span>
          </a>
        </li>
        <li class="nav-item mt-1">
          <a class="nav-link <?php echo (isset($_GET['act']) && $_GET['act'] == 'discount' ? 'active bg-gradient-dark text-white' : 'text-dark'); ?>" href="?act=discount">
            <ion-icon name="receipt-outline" size="small"></ion-icon>
            <span class="nav-link-text ms-1">Discount</span>
          </a>
        </li>
        <li class="nav-item mt-1">
          <a class="nav-link <?php echo (isset($_GET['act']) && $_GET['act'] == 'category' ? 'active bg-gradient-dark text-white' : 'text-dark'); ?>" href="?act=category">
            <ion-icon name="albums-outline" size="small"></ion-icon>
            <span class="nav-link-text ms-1" style="position: relative; ">Categories</span>
          </a>
        </li>
        <li class="nav-item mt-2">
          <a class="nav-link <?php echo (isset($_GET['act']) && $_GET['act'] == 'comments' ? 'active bg-gradient-dark text-white' : 'text-dark'); ?>" href="?act=comments">
            <ion-icon name="chatbox-ellipses-outline" size="small"></ion-icon>
            <span class="nav-link-text ms-1">Product reviews</span>
          </a>
        </li>

        <li class="nav-item mt-1">
          <a class="nav-link <?php echo (isset($_GET['act']) && $_GET['act'] == 'orders' ? 'active bg-gradient-dark text-white' : 'text-dark'); ?>" href="?act=orders">
            <ion-icon name="cart-outline" size="small"></ion-icon>
            <span class="nav-link-text ms-1">Order management</span>
          </a>
        </li>

      </ul>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <?php
        $pageName = 'Home';
        if (isset($_GET['act'])) {
          switch ($_GET['act']) {
            case 'products':
              $pageName = 'Products';
              break;
            case 'users':
              $pageName = 'Users';
              break;
            case 'notifications':
              $pageName = 'Notifications';
              break;
            case 'comments':
              $pageName = 'Comments';
              break;
            case 'category':
              $pageName = 'Categories';
              break;
            case 'add-produc':
              $pageName = 'Them san pham';
              break;
            case 'sign-up':
              $pageName = 'Sign Up';
              break;
            default:
              $pageName = 'Hello World';
              break;
          }
        }
        ?>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
              <a class="opacity-5 text-dark" href="javascript:;">Pages</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page"><?php echo $pageName; ?></li>
          </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar" style="position: relative; top: 6px;">
          <ul class="navbar-nav d-flex align-items-center justify-content-end ms-auto">
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0">
                <i class="material-symbols-rounded fixed-plugin-button-nav">settings</i>
              </a>
            </li>
            <li class="nav-item dropdown pe-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="material-symbols-rounded">notifications</i>
              </a>
              <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img src="../assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New message</span> from Laur
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          13 minutes ago
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img src="../assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm bg-gradient-dark  me-3 ">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New album</span> by Travis Scott
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          1 day
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                          <title>credit-card</title>
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                              <g transform="translate(1716.000000, 291.000000)">
                                <g transform="translate(453.000000, 454.000000)">
                                  <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                  <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                </g>
                              </g>
                            </g>
                          </g>
                        </svg>
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          Payment successfully completed
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          2 days
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item d-flex align-items-center">
              <a href="#" class="nav-link text-body font-weight-bold px-0" id="accountIcon">
                <i class="material-symbols-rounded">account_circle</i>
              </a>

              <!-- Dropdown Menu -->
              <div id="dropdownMenu" class="dropdown-menu-custom">
                <a class="dropdown-item" href="?act=logout"><ion-icon name="log-out-outline"></ion-icon>Logout</a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        const accountIcon = document.getElementById("accountIcon");
        const dropdownMenu = document.getElementById("dropdownMenu");

        // Toggle dropdown visibility when the icon is clicked
        accountIcon.addEventListener("click", function(event) {
          event.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ <a>
          dropdownMenu.style.display = dropdownMenu.style.display === "none" ? "block" : "none";
        });

        // Close the dropdown if clicking outside of it
        document.addEventListener("click", function(event) {
          if (!accountIcon.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.style.display = "none";
          }
        });
      });
    </script>

    <style>
      /* CSS cho dropdown menu */
      /* CSS cho dropdown menu */
      .dropdown-menu-custom {
        display: none;
        position: absolute;
        top: 40px;
        right: 0;
        background-color: #fff;
        border: 1px solid #ddd;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 5px;
        width: 150px;
        z-index: 1000;

      }

      .dropdown-menu-custom a.dropdown-item {
        display: flex;
        align-items: center;
        padding: 10px;
        color: #333;
        text-decoration: none;
        text-align: center;
      }

      .dropdown-item ion-icon {
        margin-right: 8px;
        font-size: 1.2em;
        margin-left: 25px;

      }

      /* Hiệu ứng hover */
      .dropdown-menu-custom a.dropdown-item:hover {
        background-color: #f1f1f1;
        color: #007bff;
        border-radius: 5px;
      }
    </style>