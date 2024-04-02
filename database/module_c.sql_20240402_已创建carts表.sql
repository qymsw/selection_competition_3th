-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2024-04-02 11:06:37
-- 服务器版本： 10.4.27-MariaDB
-- PHP 版本： 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `module_c`
--

-- --------------------------------------------------------

--
-- 表的结构 `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `admins`
--

INSERT INTO `admins` (`id`, `email`, `full_name`, `password`, `token`, `created_at`, `updated_at`) VALUES
(1, 'admin@eaphoto.com', 'admin', 'admin', NULL, '2023-06-09 16:50:20', '2023-06-09 16:50:20');

-- --------------------------------------------------------

--
-- 表的结构 `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(18, 1, '2024-04-02 00:26:15', '2024-04-02 00:26:15');

-- --------------------------------------------------------

--
-- 表的结构 `cart_photos`
--

CREATE TABLE `cart_photos` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `cart_photos`
--

INSERT INTO `cart_photos` (`id`, `cart_id`, `photo_id`, `created_at`, `updated_at`) VALUES
(19, 18, 29, '2024-04-02 00:28:48', '2024-04-02 00:28:48'),
(20, 18, 30, '2024-04-02 00:28:48', '2024-04-02 00:28:48'),
(21, 18, 31, '2024-04-02 00:28:48', '2024-04-02 00:28:48'),
(22, 18, 32, '2024-04-02 00:29:27', '2024-04-02 00:29:27'),
(23, 18, 33, '2024-04-02 00:29:27', '2024-04-02 00:29:27'),
(24, 18, 34, '2024-04-02 00:29:27', '2024-04-02 00:29:27'),
(25, 18, 32, '2024-04-02 00:31:14', '2024-04-02 00:31:14'),
(26, 18, 33, '2024-04-02 00:31:14', '2024-04-02 00:31:14'),
(27, 18, 34, '2024-04-02 00:31:14', '2024-04-02 00:31:14');

-- --------------------------------------------------------

--
-- 表的结构 `frames`
--

CREATE TABLE `frames` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `url` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double(8,2) NOT NULL,
  `size_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `frames`
--

INSERT INTO `frames` (`id`, `url`, `name`, `price`, `size_id`, `created_at`, `updated_at`) VALUES
(1, 'frames/frame_1.jpg', 'frame 1', 10.00, 1, '2023-06-09 16:50:20', '2023-06-09 16:50:20'),
(2, 'frames/frame_2.jpg', 'frame 2', 20.00, 2, '2023-06-09 16:50:20', '2023-06-09 16:50:20'),
(3, 'frames/frame_3.jpg', 'frame 3', 30.00, 3, '2023-06-09 16:50:20', '2023-06-09 16:50:20'),
(4, 'frames/frame_4.jpeg', 'frame 4', 40.00, 4, '2023-06-09 16:50:20', '2023-06-09 16:50:20'),
(5, 'frames/frame_5.png', 'frame 5', 50.00, 5, '2023-06-09 16:50:20', '2023-06-09 16:50:20'),
(6, 'frames/frame_1.jpg', 'frame 6', 60.00, 6, '2023-06-09 16:50:20', '2023-06-09 16:50:20'),
(7, 'frames/frame_2.jpg', 'frame 7', 70.00, 7, '2023-06-09 16:50:20', '2023-06-09 16:50:20');

-- --------------------------------------------------------

--
-- 表的结构 `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(61, '2023_05_23_060309_create_admins_table', 1),
(62, '2023_05_23_060423_create_users_table', 1),
(63, '2023_05_23_060612_create_sizes_table', 1),
(64, '2023_05_23_060625_create_frames_table', 1),
(65, '2023_05_23_061704_create_photos_table', 1),
(66, '2023_05_23_062059_create_orders_table', 1);

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `shipping_address` varchar(255) NOT NULL,
  `card_number` varchar(255) NOT NULL,
  `name_on_card` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Valid',
  `exp_date` date NOT NULL,
  `cvv` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `photos`
--

CREATE TABLE `photos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `edited_url` varchar(2000) NOT NULL,
  `original_url` varchar(255) NOT NULL,
  `size_id` int(11) NOT NULL,
  `frame_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `event` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `photos`
--

INSERT INTO `photos` (`id`, `edited_url`, `original_url`, `size_id`, `frame_id`, `user_id`, `order_id`, `event`, `created_at`, `updated_at`) VALUES
(27, '', 'http://localhost/uploads/7I9lvoyrgMHOVuoESwnQj4u2u2qqNDOVwgwm9ydv.jpg', 1, 4, NULL, NULL, 1, '2024-04-01 18:40:34', '2024-04-01 18:59:49'),
(28, '', 'http://localhost/uploads/26LMHPQfTcmlRNdv6FP55FiYai8u8NZSwCBdc9FQ.jpg', 4, 4, NULL, NULL, 1, '2024-04-01 18:51:38', '2024-04-01 18:51:38'),
(29, 'http://localhost/uploads/elXn7g7iL6tPOwzwq9TNWPw3i8tbxyuhDlRLu3fP.jpg', 'http://localhost/uploads/elXn7g7iL6tPOwzwq9TNWPw3i8tbxyuhDlRLu3fP.jpg', 4, 4, NULL, NULL, 1, '2024-04-01 19:10:49', '2024-04-01 19:10:49'),
(30, 'http://localhost/edited/QccVn2mXb54FBAa7lGfxIdzPZ12kMxX7bdVZQ774.jpg', 'http://localhost/uploads/QccVn2mXb54FBAa7lGfxIdzPZ12kMxX7bdVZQ774.jpg', 4, 4, NULL, NULL, 1, '2024-04-01 19:21:24', '2024-04-01 19:21:24'),
(31, 'http://localhost/edited/CuQXIMmPPu9o2AzjJlOxgjaPLnTrE4aA6xnfxiRm.jpg', 'http://localhost/uploads/CuQXIMmPPu9o2AzjJlOxgjaPLnTrE4aA6xnfxiRm.jpg', 4, 4, NULL, NULL, 1, '2024-04-01 19:21:47', '2024-04-01 19:21:47'),
(32, 'http://localhost/edited/XREjI2yqplLFKTbdJKUcGpoR9MKDeV4gno68UpK2.jpg', 'http://localhost/uploads/XREjI2yqplLFKTbdJKUcGpoR9MKDeV4gno68UpK2.jpg', 1, 1, NULL, NULL, 1, '2024-04-01 19:22:12', '2024-04-01 19:22:12'),
(33, 'http://localhost/edited/kwI5B6hmpdVxqms91pi9FGLWMT53boQDVD473z8x.gif', 'http://localhost/uploads/kwI5B6hmpdVxqms91pi9FGLWMT53boQDVD473z8x.gif', 1, 1, NULL, NULL, 1, '2024-04-01 19:25:17', '2024-04-01 19:25:17'),
(34, 'http://localhost/edited/j9jDGXtBHTlD8LJEWrvYU7pVbttxG0W9qazxOCAY.gif', 'http://localhost/uploads/j9jDGXtBHTlD8LJEWrvYU7pVbttxG0W9qazxOCAY.gif', 3, 3, NULL, NULL, 1, '2024-04-01 19:25:37', '2024-04-01 19:25:37');

-- --------------------------------------------------------

--
-- 表的结构 `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `size` varchar(255) NOT NULL,
  `width` double(8,2) NOT NULL,
  `height` double(8,2) NOT NULL,
  `price` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `sizes`
--

INSERT INTO `sizes` (`id`, `size`, `width`, `height`, `price`, `created_at`, `updated_at`) VALUES
(1, '1 Inch', 2.50, 3.60, 0.10, '2023-06-09 16:50:20', '2023-06-09 16:50:20'),
(2, '2 Inch', 3.40, 5.20, 0.15, '2023-06-09 16:50:20', '2023-06-09 16:50:20'),
(3, '3 Inch', 5.50, 8.40, 0.60, '2023-06-09 16:50:20', '2023-06-09 16:50:20'),
(4, '5 Inch', 8.90, 12.70, 0.70, '2023-06-09 16:50:20', '2023-06-09 16:50:20'),
(5, '6 Inch', 10.20, 15.20, 1.00, '2023-06-09 16:50:20', '2023-06-09 16:50:20'),
(6, '7 Inch', 12.70, 17.80, 1.20, '2023-06-09 16:50:20', '2023-06-09 16:50:20'),
(7, '8 Inch', 15.20, 20.30, 1.50, '2023-06-09 16:50:20', '2023-06-09 16:50:20');

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `token`, `created_at`, `updated_at`) VALUES
(1, 'user@eaphoto.com', 'user', 'user', 'dcf13440cd32ffb4289931d392b06993', '2023-06-09 16:50:20', '2024-04-01 19:52:24');

--
-- 转储表的索引
--

--
-- 表的索引 `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cart_photos`
--
ALTER TABLE `cart_photos`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `frames`
--
ALTER TABLE `frames`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- 使用表AUTO_INCREMENT `cart_photos`
--
ALTER TABLE `cart_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- 使用表AUTO_INCREMENT `frames`
--
ALTER TABLE `frames`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- 使用表AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `photos`
--
ALTER TABLE `photos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- 使用表AUTO_INCREMENT `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
