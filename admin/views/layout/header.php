<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/admin.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="?act=/">
                <img src="../public/img/logi.jpg" alt="Logo" height="40" class="rounded-circle">
            </a>

            <!-- Toggle Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu Items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="?act=/">
                            <i class="fas fa-home me-2"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?act=users">
                            <i class="fas fa-users me-2"></i>
                            <span>Users</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?act=category">
                            <i class="fas fa-list me-2"></i>
                            <span>Category</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?act=products">
                            <i class="fas fa-box me-2"></i>
                            <span>Products</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?act=comments">
                            <i class="fas fa-comments me-2"></i>
                            <span>Comments</span>
                        </a>
                    </li>
                </ul>

                <!-- Right Side Items -->
                <div class="d-flex align-items-center gap-3">
                    <!-- Theme Toggle Button -->
                    <button class="btn btn-link nav-link px-3 theme-toggle" id="theme-toggle">
                        <i class="fas fa-sun theme-icon-light"></i>
                        <i class="fas fa-moon theme-icon-dark d-none"></i>
                    </button>

                    <!-- Logout Button -->
                    <a href="?act=logout" class="btn btn-outline-light d-flex align-items-center">
                        <i class="fas fa-sign-out-alt me-2"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

  <script src="../public/js/toggle.js"></script>
