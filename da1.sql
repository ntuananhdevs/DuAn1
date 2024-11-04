-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th10 02, 2024 lúc 08:54 PM
-- Phiên bản máy phục vụ: 10.1.48-MariaDB
-- Phiên bản PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `da1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `Carts`
--

CREATE TABLE `Carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `Cart_items`
--

CREATE TABLE `Cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `Category`
--

CREATE TABLE `Category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `Category`
--

INSERT INTO `Category` (`id`, `category_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Apple', NULL, '2024-11-01 03:58:03', '2024-11-01 03:58:03'),
(2, 'Vivo', NULL, '2024-11-01 03:58:03', '2024-11-01 03:58:03'),
(3, 'Oppo', NULL, '2024-11-01 03:58:46', '2024-11-01 03:58:46'),
(4, 'Samsung', NULL, '2024-11-01 03:58:46', '2024-11-01 03:58:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `Comments`
--

CREATE TABLE `Comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `like` int(11) DEFAULT '0',
  `dislike` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `Orders`
--

CREATE TABLE `Orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_status` enum('pending','completed','failed') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `shipping_status` enum('pending','shipped','delivered') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `total_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `Order_details`
--

CREATE TABLE `Order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `Payments`
--

CREATE TABLE `Payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `payments_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','completed','failed') COLLATE utf8mb4_unicode_ci DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `Products`
--

CREATE TABLE `Products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `Products`
--

INSERT INTO `Products` (`id`, `category_id`, `quantity`, `views`, `img`, `description`, `created_at`, `updated_at`, `product_name`) VALUES
(32, 1, 57, 0, NULL, 'iPhone 16 được trang bị vi xử lý Apple A18, cho hiệu năng mạnh mẽ, đáp ứng tốt các tác vụ nặng như chơi game, thiết kế đồ họa và chạy đa nhiệm.\r\nĐiều khiển Camera - Giúp bạn truy cập nhanh các công cụ camera dễ dàng hơn chỉ cần trượt ngón tay.\r\nHệ thống camera mới - Chụp ảnh và quay video macro cực kỳ chi tiết và sắc nét dù từ xa hay gần.\r\nVỏ máy iPhone 16 được làm từ nhôm chuẩn hàng không vũ trụ cứng cáp và kính pha màu ở mặt sau vừa đẹp vừa bền bỉ.', '2024-11-02 17:34:47', '2024-11-02 17:34:47', 'IPhone 16'),
(33, 1, 43, 0, NULL, '', '2024-11-02 17:49:31', '2024-11-02 17:49:31', 'IPhone 16 Pro');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products_spect`
--

CREATE TABLE `products_spect` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `spect_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spects_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products_spect`
--

INSERT INTO `products_spect` (`id`, `product_id`, `spect_name`, `spects_value`, `created_at`, `updated_at`) VALUES
(217, 32, 'Kích thước màn hình', '6.1 inches', '2024-11-02 17:34:47', '2024-11-02 17:34:47'),
(218, 32, 'Độ phân giải màn hình', '2556 x 1179 pixels', '2024-11-02 17:34:47', '2024-11-02 17:34:47'),
(219, 32, 'Tính năng màn hình', 'Dynamic Island Màn hình HDR True Tone Dải màu rộng (P3) Haptic Touch Tỷ lệ tương phản 2.000.000:1 Độ sáng tối đa 1000 nit 460 ppi Lớp phủ kháng dầu chống in dấu vân tay Hỗ trợ hiển thị đồng thời nhiều ngôn ngữ và ký tự', '2024-11-02 17:34:47', '2024-11-02 17:34:47'),
(220, 32, 'Camera sau', 'Camera chính: 48MP, f/1.6, 26mm, Focus Pixels 100%, hỗ trợ ảnh có độ phân giải siêu cao Camera góc siêu rộng: 12MP, ƒ/2.2, 13 mm, Focus Pixels 100%, Độ phóng đại quang học 2x, độ thu nhỏ quang học 2x; phạm vi thu phóng quang học 4x Độ thu phóng kỹ thu', '2024-11-02 17:34:47', '2024-11-02 17:34:47'),
(221, 32, 'Quay video', '4K@24 fps 4K@25 fps 4K@30 fps 4K@60 fps 1080p@25fps, 1080p@30 fps, hoặc 1080p@60 fps', '2024-11-02 17:34:47', '2024-11-02 17:34:47'),
(222, 32, 'Chipset', 'Apple A18', '2024-11-02 17:34:47', '2024-11-02 17:34:47'),
(223, 32, 'GPU', 'GPU 5 lõi mới', '2024-11-02 17:34:47', '2024-11-02 17:34:47'),
(224, 33, 'Kích thước màn hình', '12.4', '2024-11-02 17:49:31', '2024-11-02 17:49:31'),
(225, 33, 'Độ phân giải màn hình', '2560 x 1600', '2024-11-02 17:49:31', '2024-11-02 17:49:31'),
(226, 33, 'Tính năng màn hình', 'Tan So Quet 90Hz', '2024-11-02 17:49:31', '2024-11-02 17:49:31'),
(227, 33, 'Camera sau', '8 MP + 8 MP', '2024-11-02 17:49:31', '2024-11-02 17:49:31'),
(228, 33, 'Quay video', 'UHD 4k', '2024-11-02 17:49:31', '2024-11-02 17:49:31'),
(229, 33, 'Chipset', 'Exion', '2024-11-02 17:49:31', '2024-11-02 17:49:31'),
(230, 33, 'GPU', 'Mali', '2024-11-02 17:49:31', '2024-11-02 17:49:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `Product_variants`
--

CREATE TABLE `Product_variants` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ram` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `storage` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `Product_variants`
--

INSERT INTO `Product_variants` (`id`, `product_id`, `quantity`, `price`, `img`, `color`, `ram`, `storage`, `created_at`, `updated_at`) VALUES
(38, 32, 23, '32000000.00', NULL, 'black', '8GB', '128GB', '2024-11-02 17:34:47', '2024-11-02 17:34:47'),
(39, 32, 34, '32000000.00', NULL, 'blue', '8GB', '128GB', '2024-11-02 17:34:47', '2024-11-02 17:34:47'),
(40, 33, 43, '23000000.00', NULL, 'black', '8GB', '128GB', '2024-11-02 17:49:31', '2024-11-02 17:49:31');

--
-- Bẫy `Product_variants`
--
DELIMITER $$
CREATE TRIGGER `update_product_quantity` AFTER INSERT ON `Product_variants` FOR EACH ROW BEGIN
    DECLARE total_variant_quantity INT;

    -- Tính tổng quantity của tất cả biến thể cho product_id hiện tại
    SELECT SUM(quantity) INTO total_variant_quantity
    FROM Product_variants
    WHERE product_id = NEW.product_id;

    -- Cập nhật quantity trong bảng Products
    UPDATE Products
    SET quantity = total_variant_quantity
    WHERE id = NEW.product_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_product_quantity_after_update` AFTER UPDATE ON `Product_variants` FOR EACH ROW BEGIN
    DECLARE total_variant_quantity INT;

    -- Tính tổng quantity của tất cả biến thể cho product_id của sản phẩm đang cập nhật
    SELECT SUM(quantity) INTO total_variant_quantity
    FROM Product_variants
    WHERE product_id = NEW.product_id;

    -- Cập nhật quantity trong bảng Products
    UPDATE Products
    SET quantity = total_variant_quantity
    WHERE id = NEW.product_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `Shipping`
--

CREATE TABLE `Shipping` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `shipping_date` timestamp NULL DEFAULT NULL,
  `delivery_date` timestamp NULL DEFAULT NULL,
  `status` enum('pending','in_transit','delivered') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `tracking_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `carrier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `google_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `Users`
--

INSERT INTO `Users` (`id`, `user_name`, `email`, `phone_number`, `avatar`, `password`, `role`, `created_at`, `updated_at`, `google_id`) VALUES
(1, 'Admin', 'admin@gmail.com', '0981714620', NULL, 'admin', 'admin', '2024-11-01 03:54:03', '2024-11-01 03:54:03', NULL),
(3, 'Ntuananhh', 'affngdy@gmail.com', '222222222222222222', '../uploads/UserIMG/default.jpg', '$2y$10$Vg2cunmz8CwQ7ktyePkiBeloyviR3Vuwfyg8mbiRM6Ke5gTp7luBi', 'user', '2024-11-02 14:51:28', '2024-11-02 14:51:28', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `variants_img`
--

CREATE TABLE `variants_img` (
  `id` int(11) NOT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `variants_img`
--

INSERT INTO `variants_img` (`id`, `variant_id`, `img`, `is_default`) VALUES
(10, 38, '../uploads/Products/672662b7ab062_Iphone16.jpg', 0),
(11, 39, '../uploads/Products/672662b7abae4_iphone-16-1.webp', 0),
(12, 40, '../uploads/Products/6726662b33c4f_600_16pd_4.webp', 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `Carts`
--
ALTER TABLE `Carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `Cart_items`
--
ALTER TABLE `Cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `Comments`
--
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `Order_details`
--
ALTER TABLE `Order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `Payments`
--
ALTER TABLE `Payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `Products`
--
ALTER TABLE `Products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `products_spect`
--
ALTER TABLE `products_spect`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_spect_ibfk_1` (`product_id`);

--
-- Chỉ mục cho bảng `Product_variants`
--
ALTER TABLE `Product_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id` (`product_id`,`color`,`ram`,`storage`);

--
-- Chỉ mục cho bảng `Shipping`
--
ALTER TABLE `Shipping`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone_number` (`phone_number`),
  ADD UNIQUE KEY `google_id` (`google_id`);

--
-- Chỉ mục cho bảng `variants_img`
--
ALTER TABLE `variants_img`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variants_img_ibfk_1` (`variant_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `Carts`
--
ALTER TABLE `Carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `Cart_items`
--
ALTER TABLE `Cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `Category`
--
ALTER TABLE `Category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `Comments`
--
ALTER TABLE `Comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `Orders`
--
ALTER TABLE `Orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `Order_details`
--
ALTER TABLE `Order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `Payments`
--
ALTER TABLE `Payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `Products`
--
ALTER TABLE `Products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `products_spect`
--
ALTER TABLE `products_spect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT cho bảng `Product_variants`
--
ALTER TABLE `Product_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `Shipping`
--
ALTER TABLE `Shipping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `variants_img`
--
ALTER TABLE `variants_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `Carts`
--
ALTER TABLE `Carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`);

--
-- Các ràng buộc cho bảng `Cart_items`
--
ALTER TABLE `Cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `Carts` (`id`),
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `Products` (`id`);

--
-- Các ràng buộc cho bảng `Comments`
--
ALTER TABLE `Comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `Products` (`id`);

--
-- Các ràng buộc cho bảng `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`);

--
-- Các ràng buộc cho bảng `Order_details`
--
ALTER TABLE `Order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `Orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `Products` (`id`);

--
-- Các ràng buộc cho bảng `Payments`
--
ALTER TABLE `Payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `Orders` (`id`);

--
-- Các ràng buộc cho bảng `Products`
--
ALTER TABLE `Products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `Category` (`id`);

--
-- Các ràng buộc cho bảng `products_spect`
--
ALTER TABLE `products_spect`
  ADD CONSTRAINT `products_spect_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `Products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `Product_variants`
--
ALTER TABLE `Product_variants`
  ADD CONSTRAINT `product_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `Products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `Shipping`
--
ALTER TABLE `Shipping`
  ADD CONSTRAINT `shipping_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `Orders` (`id`);

--
-- Các ràng buộc cho bảng `variants_img`
--
ALTER TABLE `variants_img`
  ADD CONSTRAINT `variants_img_ibfk_1` FOREIGN KEY (`variant_id`) REFERENCES `Product_variants` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
