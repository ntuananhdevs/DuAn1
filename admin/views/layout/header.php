<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Admin
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="../../../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../../../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../../../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
  
</head>

<body class="g-sidenav-show  bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
        <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img" width="26" height="26" alt="main_logo">
        <span class="ms-1 text-sm text-dark">Creative Tim</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
    <ul class="navbar-nav">
  <li class="nav-item">
    <a class="nav-link <?php echo (isset($_GET['act']) && $_GET['act'] == '/' ? 'active bg-gradient-dark text-white' : 'text-dark'); ?>" href="?act=/">
      <i class="material-symbols-rounded opacity-5">dashboard</i>
      <span class="nav-link-text ms-1">Dashboard</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php echo (isset($_GET['act']) && $_GET['act'] == 'products' ? 'active bg-gradient-dark text-white' : 'text-dark'); ?>" href="?act=products">
      <i class="material-symbols-rounded opacity-5">table_view</i>
      <span class="nav-link-text ms-1">Products</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php echo (isset($_GET['act']) && $_GET['act'] == 'users' ? 'active bg-gradient-dark text-white' : 'text-dark'); ?>" href="?act=users">
    <ion-icon name="person-circle-outline" size="small"></ion-icon>
          <span class="nav-link-text ms-1">Users</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link <?php echo (isset($_GET['act']) && $_GET['act'] == 'notifications' ? 'active bg-gradient-dark text-white' : 'text-dark'); ?>" href="?act=comments">
    <ion-icon name="chatbox-ellipses-outline" size="small"></ion-icon>
          <span class="nav-link-text ms-1">Comments</span>
    </a>
  </li>

  <li class="nav-item mt-3">
    <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Account pages</h6>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php echo (isset($_GET['act']) && $_GET['act'] == 'profile' ? 'active bg-gradient-dark text-white' : 'text-dark'); ?>" href="../pages/profile.html">
      <i class="material-symbols-rounded opacity-5">person</i>
      <span class="nav-link-text ms-1">Profile</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php echo (isset($_GET['act']) && $_GET['act'] == 'sign-in' ? 'active bg-gradient-dark text-white' : 'text-dark'); ?>" href="../pages/sign-in.html">
      <i class="material-symbols-rounded opacity-5">login</i>
      <span class="nav-link-text ms-1">Sign In</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php echo (isset($_GET['act']) && $_GET['act'] == 'sign-up' ? 'active bg-gradient-dark text-white' : 'text-dark'); ?>" href="../pages/sign-up.html">
      <i class="material-symbols-rounded opacity-5">assignment</i>
      <span class="nav-link-text ms-1">Sign Up</span>
    </a>
  </li>
</ul>


    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
      <div class="mx-3">
        <a class="btn btn-outline-dark mt-4 w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard?ref=sidebarfree" type="button">Documentation</a>
        <a class="btn bg-gradient-dark w-100" href="https://www.creative-tim.com/product/material-dashboard-pro?ref=sidebarfree" type="button">Upgrade to pro</a>
      </div>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
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
                        case 'profile':
                            $pageName = 'Profile';
                            break;
                        case 'sign-in':
                            $pageName = 'Sign In';
                            break;
                        case 'sign-up':
                            $pageName = 'Sign Up';
                            break;
                        default:
                            $pageName = 'Dashboard';
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

        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
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
              <a href="../pages/sign-in.html" class="nav-link text-body font-weight-bold px-0">
                <i class="material-symbols-rounded">account_circle</i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>