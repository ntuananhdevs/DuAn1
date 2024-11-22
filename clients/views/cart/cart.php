<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/cart.css">
</head>

<body>
    <?php require_once "./clients/views/layout/header.php"; ?>

    <div class="cart-container">
        <h2>Giỏ hàng của bạn</h2>

        <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php 
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                ?>
        </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
        </div>
        <?php endif; ?>

        <?php if (empty($cart_items)): ?>
        <p>Giỏ hàng trống</p>
        <?php else: ?>
        <div class="cart-items">
            <?php foreach ($cart_items as $item): ?>
            <div class="cart-item">
                <img src="Uploads/Product/<?php echo $item['img']; ?>" alt="<?php echo $item['product_name ']; ?>">
                <div class="item-details">
                    <h3><?php echo $item['product_name ']; ?></h3>
                    <p>Phiên bản: <?php echo $item['storage_type']; ?></p>
                    <p>Màu sắc: <?php echo $item['color_type']; ?></p>
                    <p>Giá: <?php echo number_format($item['final_price']); ?>đ</p>
                    <p>Số lượng: <?php echo $item['quantity']; ?></p>
                    <p>Tổng: <?php echo number_format($item['final_price'] * $item['quantity']); ?>đ</p>

                    <form action="index.php?action=remove-from-cart" method="POST" class="remove-form">
                        <input type="hidden" name="cart_item_id" value="<?php echo $item['id']; ?>">
                        <button type="submit" class="remove-btn">Xóa</button>
                    </form>

                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-summary">
            <h3>Tổng giỏ hàng</h3>
            <?php
                $total = array_reduce($cart_items, function($carry, $item) {
                    return $carry + ($item['final_price'] * $item['quantity']);
                }, 0);
                ?>
            <p>Tổng tiền: <?php echo number_format($total); ?>đ</p>
            <button class="checkout-btn">Thanh toán</button>
        </div>
        <?php endif; ?>
    </div>

    <?php require_once "clients/views/layout/footer.php"; ?>

    <style>
    .remove-btn {
        background-color: #ff4444;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
    }

    .remove-btn:hover {
        background-color: #cc0000;
    }

    .remove-form {
        margin-top: 10px;
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert {
        animation: fadeOut 0.5s ease-in-out 3s forwards;
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }

        to {
            opacity: 0;
            display: none;
        }
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.display = 'none';
            });
        }, 3500);
    });
    </script>
</body>

</html>