<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="../public/css/admin.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body>
    <nav>
        <div class="content-admin">
            <div class="logo-admin">
                <img>
            </div>
            <div class="menu-admin">
                <ul>
                    <li><a href="?act=/">Home</a></li>
                    <li><a href="?act=users">Users</a></li>
                    <li><a href="?act=category">Category</a></li>
                    <li><a href="?act=products">Products</a></li>
                    <li><a href="?act=comments">Comments</a></li>
                </ul> 
            </div>
            <div class="logout-admin">
                <a href="?act=logout"><ion-icon name="log-out-outline"></ion-icon>Logout</a>
            </div>
        </div>
    </nav>
