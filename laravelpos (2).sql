-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2024 at 04:31 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravelpos`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `logged_in_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `user_id`, `logged_in_at`, `created_at`, `updated_at`) VALUES
(1, 2, '2024-01-15 04:17:42', '2024-01-15 04:17:42', '2024-01-15 04:17:42'),
(2, 1, '2024-01-15 05:06:12', '2024-01-15 05:06:12', '2024-01-15 05:06:12'),
(3, 2, '2024-01-16 16:00:24', '2024-01-16 16:00:24', '2024-01-16 16:00:24'),
(4, 1, '2024-01-16 16:48:05', '2024-01-16 16:48:05', '2024-01-16 16:48:05'),
(5, 2, '2024-01-21 15:46:49', '2024-01-21 15:46:49', '2024-01-21 15:46:49'),
(6, 2, '2024-01-22 12:43:04', '2024-01-22 12:43:04', '2024-01-22 12:43:04'),
(7, 2, '2024-01-23 00:12:37', '2024-01-23 00:12:37', '2024-01-23 00:12:37');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `email`, `phone`, `address`, `avatar`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Glovo', 'Order', NULL, NULL, NULL, '', 2, '2024-01-23 08:53:03', '2024-01-23 08:53:03');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kitchen_orders`
--

CREATE TABLE `kitchen_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_done` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_04_19_081616_create_products_table', 1),
(5, '2020_04_22_181602_add_quantity_to_products_table', 1),
(6, '2020_04_24_170630_create_customers_table', 1),
(7, '2020_04_27_054355_create_settings_table', 1),
(8, '2020_04_30_053758_create_user_cart_table', 1),
(9, '2020_05_04_165730_create_orders_table', 1),
(10, '2020_05_04_165749_create_order_items_table', 1),
(11, '2020_05_04_165822_create_payments_table', 1),
(12, '2022_03_21_125336_change_price_column', 1),
(13, '2024_01_07_014843_create_permission_tables', 1),
(14, '2024_01_09_072142_create_attendances_table', 1),
(15, '2024_01_11_192441_create_kitchen_orders_table', 1),
(16, '2024_01_11_203552_add_status_to_orders_table', 1),
(17, '2024_01_23_094034_add_comment_for_cook_to_orders_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 3);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `commentForCook` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `user_id`, `commentForCook`, `created_at`, `updated_at`, `status`) VALUES
(1, NULL, 1, NULL, '2024-01-16 16:48:37', '2024-01-16 18:07:12', 'failed'),
(2, NULL, 1, NULL, '2024-01-16 17:50:37', '2024-01-16 18:07:11', 'failed'),
(3, NULL, 1, NULL, '2024-01-16 17:50:56', '2024-01-16 18:25:59', 'failed'),
(4, NULL, 1, NULL, '2024-01-16 18:07:30', '2024-01-16 18:26:01', 'failed'),
(5, NULL, 1, NULL, '2024-01-16 18:09:43', '2024-01-16 18:26:00', 'failed'),
(6, NULL, 1, NULL, '2024-01-16 18:25:22', '2024-01-23 10:46:51', 'processed'),
(7, NULL, 1, NULL, '2024-01-16 18:26:54', '2024-01-23 10:46:54', 'failed'),
(8, NULL, 1, NULL, '2024-01-16 18:28:36', '2024-01-16 18:30:20', 'processed'),
(9, NULL, 2, NULL, '2024-01-23 01:18:46', '2024-01-23 01:18:46', 'pending'),
(10, NULL, 2, NULL, '2024-01-23 08:43:20', '2024-01-23 08:43:20', 'pending'),
(11, NULL, 2, NULL, '2024-01-23 08:45:30', '2024-01-23 08:45:30', 'pending'),
(12, 1, 2, NULL, '2024-01-23 08:53:17', '2024-01-23 08:53:17', 'pending'),
(13, NULL, 2, NULL, '2024-01-23 09:21:01', '2024-01-23 09:21:01', 'pending'),
(14, NULL, 2, 'This note is for the cook, customer said add more salt and pepper. ALso serve the rice with salad and ketup. You might want to put the protein in seperate packs. Thank you for your time. Warm', '2024-01-23 09:31:30', '2024-01-23 09:31:30', 'pending'),
(15, 1, 2, NULL, '2024-01-23 10:55:27', '2024-01-23 10:55:27', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(14,4) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `price`, `quantity`, `order_id`, `product_id`, `created_at`, `updated_at`) VALUES
(3, 1300.0000, 1, 2, 3, '2024-01-16 17:50:37', '2024-01-16 17:50:37'),
(4, 1300.0000, 1, 3, 1, '2024-01-16 17:50:56', '2024-01-16 17:50:56'),
(5, 1300.0000, 1, 3, 6, '2024-01-16 17:50:56', '2024-01-16 17:50:56'),
(6, 2000.0000, 2, 4, 4, '2024-01-16 18:07:30', '2024-01-16 18:07:30'),
(7, 300.0000, 1, 5, 7, '2024-01-16 18:09:43', '2024-01-16 18:09:43'),
(8, 1300.0000, 1, 5, 6, '2024-01-16 18:09:43', '2024-01-16 18:09:43'),
(9, 3900.0000, 3, 6, 6, '2024-01-16 18:25:22', '2024-01-16 18:25:22'),
(10, 1000.0000, 1, 7, 38, '2024-01-16 18:26:54', '2024-01-16 18:26:54'),
(11, 2400.0000, 2, 7, 16, '2024-01-16 18:26:54', '2024-01-16 18:26:54'),
(12, 1000.0000, 1, 8, 30, '2024-01-16 18:28:36', '2024-01-16 18:28:36'),
(13, 3200.0000, 2, 9, 15, '2024-01-23 01:18:46', '2024-01-23 01:18:46'),
(14, 300.0000, 1, 9, 7, '2024-01-23 01:18:46', '2024-01-23 01:18:46'),
(15, 300.0000, 1, 10, 8, '2024-01-23 08:43:20', '2024-01-23 08:43:20'),
(16, 1600.0000, 1, 10, 15, '2024-01-23 08:43:20', '2024-01-23 08:43:20'),
(17, 1200.0000, 1, 11, 16, '2024-01-23 08:45:30', '2024-01-23 08:45:30'),
(18, 1000.0000, 1, 11, 17, '2024-01-23 08:45:31', '2024-01-23 08:45:31'),
(19, 200.0000, 1, 11, 27, '2024-01-23 08:45:31', '2024-01-23 08:45:31'),
(20, 300.0000, 1, 11, 24, '2024-01-23 08:45:31', '2024-01-23 08:45:31'),
(21, 300.0000, 1, 12, 8, '2024-01-23 08:53:17', '2024-01-23 08:53:17'),
(22, 300.0000, 1, 12, 9, '2024-01-23 08:53:17', '2024-01-23 08:53:17'),
(23, 300.0000, 1, 13, 7, '2024-01-23 09:21:01', '2024-01-23 09:21:01'),
(24, 300.0000, 1, 13, 10, '2024-01-23 09:21:01', '2024-01-23 09:21:01'),
(25, 300.0000, 1, 14, 8, '2024-01-23 09:31:30', '2024-01-23 09:31:30'),
(26, 300.0000, 1, 14, 23, '2024-01-23 09:31:30', '2024-01-23 09:31:30'),
(27, 1200.0000, 1, 15, 16, '2024-01-23 10:55:28', '2024-01-23 10:55:28'),
(28, 300.0000, 1, 15, 8, '2024-01-23 10:55:28', '2024-01-23 10:55:28'),
(29, 300.0000, 1, 15, 7, '2024-01-23 10:55:28', '2024-01-23 10:55:28'),
(30, 1300.0000, 1, 15, 1, '2024-01-23 10:55:28', '2024-01-23 10:55:28'),
(31, 2000.0000, 1, 15, 2, '2024-01-23 10:55:28', '2024-01-23 10:55:28'),
(32, 800.0000, 1, 15, 33, '2024-01-23 10:55:28', '2024-01-23 10:55:28');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(14,4) NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `payment_methods` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `amount`, `order_id`, `user_id`, `payment_methods`, `created_at`, `updated_at`) VALUES
(1, 300.0000, 1, 1, '[\"Transfer\"]', '2024-01-16 16:48:37', '2024-01-16 16:48:37'),
(2, 1600.0000, 2, 1, '[\"Transfer\"]', '2024-01-16 17:50:37', '2024-01-16 17:50:37'),
(3, 2600.0000, 3, 1, '[\"Transfer\"]', '2024-01-16 17:50:56', '2024-01-16 17:50:56'),
(4, 2000.0000, 4, 1, '[\"Transfer\"]', '2024-01-16 18:07:30', '2024-01-16 18:07:30'),
(5, 1600.0000, 5, 1, '[\"Transfer\"]', '2024-01-16 18:09:43', '2024-01-16 18:09:43'),
(6, 3900.0000, 6, 1, '[\"POS\"]', '2024-01-16 18:25:22', '2024-01-16 18:25:22'),
(7, 3400.0000, 7, 1, '[\"Transfer\"]', '2024-01-16 18:26:54', '2024-01-16 18:26:54'),
(8, 1000.0000, 8, 1, '[\"POS\"]', '2024-01-16 18:28:36', '2024-01-16 18:28:36'),
(9, 3500.0000, 9, 2, '[\"POS\"]', '2024-01-23 01:18:46', '2024-01-23 01:18:46'),
(10, 1900.0000, 10, 2, '[\"Cash\"]', '2024-01-23 08:43:20', '2024-01-23 08:43:20'),
(11, 2700.0000, 11, 2, '[\"Cash\"]', '2024-01-23 08:45:31', '2024-01-23 08:45:31'),
(12, 600.0000, 12, 2, '[\"POS\"]', '2024-01-23 08:53:17', '2024-01-23 08:53:17'),
(13, 600.0000, 13, 2, '[\"Cash\"]', '2024-01-23 09:21:01', '2024-01-23 09:21:01'),
(14, 600.0000, 14, 2, '[\"POS\"]', '2024-01-23 09:31:31', '2024-01-23 09:31:31'),
(15, 5900.0000, 15, 2, '[]', '2024-01-23 10:55:28', '2024-01-23 10:55:28');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'role-list', 'web', '2024-01-15 04:16:58', '2024-01-15 04:16:58'),
(2, 'role-create', 'web', '2024-01-15 04:16:58', '2024-01-15 04:16:58'),
(3, 'role-edit', 'web', '2024-01-15 04:16:58', '2024-01-15 04:16:58'),
(4, 'role-delete', 'web', '2024-01-15 04:16:58', '2024-01-15 04:16:58'),
(5, 'product-list', 'web', '2024-01-15 04:16:58', '2024-01-15 04:16:58'),
(6, 'product-create', 'web', '2024-01-15 04:16:58', '2024-01-15 04:16:58'),
(7, 'product-edit', 'web', '2024-01-15 04:16:58', '2024-01-15 04:16:58'),
(8, 'product-delete', 'web', '2024-01-15 04:16:58', '2024-01-15 04:16:58'),
(9, 'user-list', 'web', '2024-01-15 04:16:58', '2024-01-15 04:16:58'),
(10, 'user-create', 'web', '2024-01-15 04:16:59', '2024-01-15 04:16:59'),
(11, 'user-edit', 'web', '2024-01-15 04:16:59', '2024-01-15 04:16:59'),
(12, 'user-delete', 'web', '2024-01-15 04:16:59', '2024-01-15 04:16:59'),
(13, 'settings', 'web', '2024-01-15 04:16:59', '2024-01-15 04:16:59'),
(14, 'settings-edit', 'web', '2024-01-15 04:16:59', '2024-01-15 04:16:59'),
(15, 'order-list', 'web', '2024-01-15 04:16:59', '2024-01-15 04:16:59'),
(16, 'pos-system', 'web', '2024-01-15 04:16:59', '2024-01-15 04:16:59'),
(17, 'customer-list', 'web', '2024-01-15 04:16:59', '2024-01-15 04:16:59'),
(18, 'customer-create', 'web', '2024-01-15 04:16:59', '2024-01-15 04:16:59'),
(19, 'customer-edit', 'web', '2024-01-15 04:17:00', '2024-01-15 04:17:00'),
(20, 'customer-delete', 'web', '2024-01-15 04:17:00', '2024-01-15 04:17:00'),
(21, 'dashboard', 'web', '2024-01-15 04:17:00', '2024-01-15 04:17:00'),
(22, 'staff-list', 'web', '2024-01-15 04:17:00', '2024-01-15 04:17:00'),
(23, 'staff-create', 'web', '2024-01-15 04:17:01', '2024-01-15 04:17:01'),
(24, 'staff-edit', 'web', '2024-01-15 04:17:01', '2024-01-15 04:17:01'),
(25, 'staff-delete', 'web', '2024-01-15 04:17:01', '2024-01-15 04:17:01'),
(26, 'kitchen-display', 'web', '2024-01-15 04:17:01', '2024-01-15 04:17:01');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(14,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `image`, `category`, `price`, `quantity`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Indomie & Beaf', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972618', 1300.00, 98, 1, '2023-12-23 01:44:02', '2024-01-23 10:55:28'),
(2, 'Indomie & Chicken', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972619', 2000.00, 99, 1, '2023-12-23 01:44:02', '2024-01-23 10:55:28'),
(3, 'Indomie & Egg', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972620', 1300.00, 92, 1, '2023-12-23 01:44:02', '2024-01-16 17:50:37'),
(4, 'Moi Moi & Pap', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972621', 1000.00, 92, 1, '2023-12-23 01:44:02', '2024-01-16 18:07:30'),
(5, 'Plantain & Egg Sauce', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972622', 1300.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(6, 'Yam & Egg Sauce', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972623', 1300.00, 92, 1, '2023-12-23 01:44:02', '2024-01-16 18:25:22'),
(7, 'Amala (extra)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972624', 300.00, 96, 1, '2023-12-23 01:44:02', '2024-01-23 10:55:28'),
(8, 'Eba (extra)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972625', 300.00, 96, 1, '2023-12-23 01:44:02', '2024-01-23 10:55:28'),
(9, 'Fufu (extra)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972626', 300.00, 98, 1, '2023-12-23 01:44:02', '2024-01-23 08:53:17'),
(10, 'Semo (extra)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972627', 300.00, 99, 1, '2023-12-23 01:44:02', '2024-01-23 09:21:01'),
(11, 'Yam poundo (extra)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972628', 300.00, 97, 1, '2023-12-23 01:44:02', '2024-01-06 17:18:31'),
(12, 'Assorted meat', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972629', 300.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(13, 'Beaf (Big)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972630', 1000.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(14, 'Beaf (small)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972631', 500.00, 92, 1, '2023-12-23 01:44:02', '2024-01-06 17:33:31'),
(15, 'Chicken (Big portion)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972632', 1600.00, 92, 1, '2023-12-23 01:44:02', '2024-01-23 08:43:20'),
(16, 'Chicken (small portion)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972633', 1200.00, 92, 1, '2023-12-23 01:44:02', '2024-01-23 10:55:28'),
(17, 'Fish (Big portion)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972634', 1000.00, 98, 1, '2023-12-23 01:44:02', '2024-01-23 08:45:31'),
(18, 'Fish (small)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972635', 500.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(19, 'Goat meat (Big)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972636', 1300.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(20, 'Goat meat (Small)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972637', 500.00, 68, 1, '2023-12-23 01:44:02', '2024-01-08 22:11:51'),
(21, 'Ponmo (small)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972638', 200.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(22, 'Turkey', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972639', 2500.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(23, 'Boild or Fried Egg', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972640', 300.00, 99, 1, '2023-12-23 01:44:02', '2024-01-23 09:31:30'),
(24, 'Coleslaw', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972641', 300.00, 98, 1, '2023-12-23 01:44:02', '2024-01-23 08:45:31'),
(25, 'Moi Moi', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972642', 300.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(26, 'Plain Beans', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972643', 300.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(27, 'Take away plate', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972644', 200.00, 87, 1, '2023-12-23 01:44:02', '2024-01-23 08:45:31'),
(28, 'Fried Rice (small portion)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972645', 800.00, 96, 1, '2023-12-23 01:44:02', '2024-01-06 17:37:57'),
(29, 'Jollof Rice (small portion)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972646', 800.00, 81, 1, '2023-12-23 01:44:02', '2024-01-06 17:31:37'),
(30, 'Local palm oil rice', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972647', 1000.00, 99, 1, '2023-12-23 01:44:02', '2024-01-16 18:28:36'),
(31, 'Porridge Beans', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972648', 800.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(32, 'Spaghetti', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972649', 800.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(33, 'White Rice + Stew (small portion)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972650', 800.00, 99, 1, '2023-12-23 01:44:02', '2024-01-23 10:55:28'),
(34, 'Banga Soup', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972651', 1500.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(35, 'Fisherman Soup', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972652', 3500.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(36, 'Fried Rice (Big portion)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972653', 1000.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(37, 'Sea food okro', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972654', 3500.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(38, 'Jollof Rice (Big portion)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972655', 1000.00, 98, 1, '2023-12-23 01:44:02', '2024-01-16 18:26:54'),
(39, 'White Rice + Stew (Big portion)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972656', 1000.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(40, 'White Soup', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972657', 2500.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(41, 'Bitterleaf Soup', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972658', 1000.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(42, 'Egusi Soup', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972659', 1000.00, 82, 1, '2023-12-23 01:44:02', '2024-01-06 17:33:31'),
(43, 'Ogbono Soup', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972660', 1000.00, 98, 1, '2023-12-23 01:44:02', '2024-01-04 18:01:23'),
(44, 'Oha Soup', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972661', 1000.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(45, 'Okro Soup', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972662', 1000.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(46, 'Vegetable Soup', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972663', 1000.00, 93, 1, '2023-12-23 01:44:02', '2024-01-08 22:11:51'),
(47, 'Amala (comp)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972664', 0.00, 96, 1, '2023-12-23 01:44:02', '2024-01-04 17:59:30'),
(48, 'Eba (complimentary)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972665', 0.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(49, 'Fufu (complimentary)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972666', 0.00, 93, 1, '2023-12-23 01:44:02', '2024-01-06 17:07:57'),
(50, 'Semo (complimentary', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972667', 0.00, 88, 1, '2023-12-23 01:44:02', '2024-01-04 17:54:06'),
(51, 'Yam poundo (compl)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972668', 0.00, 82, 1, '2023-12-23 01:44:02', '2024-01-08 22:11:51'),
(52, 'Water 50cl (compl.)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972669', 0.00, 95, 1, '2023-12-23 01:44:02', '2024-01-06 17:33:31'),
(53, 'American Cola 35 cl', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972670', 250.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(54, 'Amstel Malt (33cl)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972671', 350.00, 93, 1, '2023-12-23 01:44:02', '2024-01-06 17:00:34'),
(55, 'Amstel Malt (can)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972672', 400.00, 98, 1, '2023-12-23 01:44:02', '2024-01-06 17:38:14'),
(56, 'Chi Active 1 ltr', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972673', 1000.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(57, 'Chivita 1 ltr', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972674', 1000.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(58, 'Coca Cola 35cl', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972675', 250.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(59, 'Coca Cola 50cl', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972676', 300.00, 92, 1, '2023-12-23 01:44:02', '2024-01-06 17:01:23'),
(60, 'Fanta 50cl', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972677', 300.00, 95, 1, '2023-12-23 01:44:02', '2024-01-06 17:33:45'),
(61, 'Fearless', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972678', 700.00, 98, 1, '2023-12-23 01:44:02', '2024-01-04 17:23:52'),
(62, 'Hollandia Yoghurt 1ltr', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972679', 1200.00, 99, 1, '2023-12-23 01:44:02', '2024-01-06 17:31:16'),
(63, 'Mirinda 50cl', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972680', 300.00, 99, 1, '2023-12-23 01:44:02', '2024-01-03 21:48:43'),
(64, 'Nutri Milk', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972681', 700.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(65, 'Pepsi 50cl', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972682', 300.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(66, 'Planet Orange 35cl', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972683', 250.00, 99, 1, '2023-12-23 01:44:02', '2024-01-03 22:02:05'),
(67, 'Pulpy Orange 85cl', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972684', 700.00, 99, 1, '2023-12-23 01:44:02', '2024-01-03 22:03:32'),
(68, 'Sprite 50cl', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972685', 300.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(69, 'Teem 50cl', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972686', 300.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(70, 'Water 50cl', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972687', 150.00, 92, 1, '2023-12-23 01:44:02', '2024-01-06 17:31:47'),
(71, 'Water 75cl', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972688', 200.00, 92, 1, '2023-12-23 01:44:02', '2024-01-06 17:40:10'),
(72, 'Bitters (can)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972689', 700.00, 91, 1, '2023-12-23 01:44:02', '2024-01-06 17:01:23'),
(73, 'Black Bullet', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972690', 1200.00, 98, 1, '2023-12-23 01:44:02', '2024-01-04 18:06:16'),
(74, 'Double Black (smirnoff)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972691', 700.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(75, 'Guiness smooth (can)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972692', 700.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(76, 'Heineken (can)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972693', 700.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(77, 'Hero (can)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972694', 700.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(78, 'Life (can)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972695', 700.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(79, 'Star Radlar (can)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972696', 700.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(80, 'Maltina (33cl plastic)', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972697', 350.00, 86, 1, '2023-12-23 01:44:02', '2024-01-08 21:32:01'),
(81, 'Asun', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972698', 1300.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(82, 'Peppered ponmo', '', 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '2222972699', 1000.00, 100, 1, '2023-12-23 01:44:02', '0000-00-00 00:00:00'),
(83, 'Afang Soup', NULL, 'products/U5GAWpTsA8rsprHkoS5VQExeQMJWiFBVpCykvUEO.jpg', '22223323232', 2000.00, 99, 1, '2023-12-23 01:44:02', '2024-01-03 21:45:43'),
(84, 'Grand opening', 'ORDERS	PRICES \r\nRice and chicken 	N1,500\r\n3 bottles of teem 	N900\r\nFried rice and chicken with bottle water & a bottle of coke	N1,800\r\nFried rice & hell of with beef and one bottle water	N1,570\r\nFried rice and chicken 	N1680\r\n6 big chickens	N6,720\r\nFried rice and chicken 	N1,400\r\n2 plates of rice and water 	N2,900\r\n1 plate of fried rice and water 	N1,150\r\n3 bottles of water 	N300\r\n1 plate of jellof rice & chicken with a bottle water 	N1,780\r\n4 big chickens & bottle water	N4,480\r\n2 big chickens 	N2,200\r\n1 chivita 	N1,000\r\nFried rice, big chicken, salad and takeaway 	N1,900\r\n1 plate of Egusi, semo and takeaway 	N1,250\r\n1 bottle of pepsi	N200\r\n1 plate of  egusi, semo and takeaway 	N1,250\r\n2 small chickens 	N1,680\r\n1 big chicken	N1,120\r\n2 big chickens	N2,240\r\n1 big chicken	N1,120\r\n3 big chickens	N3,360\r\n2 big chickens	N2,240\r\n1 plate of fried rice and beef	N900\r\n1 plate of jellof rice and chicken with takeaway	N1,400\r\n2 plastic bottles of Amstel malt	N700\r\nTOTAL	N48,740\r\nTOTAL MONEY AVAILABLE BOTH IN THE ACCOUNT AND CASH	N50,320', 'products/HyVKDtjTFc1DYAz8LanwRIG0Pjv99FwtuSs3PfMl.jpg', '23122023', 50320.00, 0, 0, '2024-01-04 18:41:04', '2024-01-04 18:41:43'),
(85, 'Legend extra smooth', NULL, '', '2222332323', 1000.00, 98, 1, '2024-01-06 17:07:22', '2024-01-06 17:13:28'),
(87, 'Amstel Malt (Bottle)', NULL, '', '2323432423', 400.00, 48, 1, '2024-01-23 12:22:38', '2024-01-23 12:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2024-01-15 04:17:02', '2024-01-15 04:17:02'),
(2, 'Cashier', 'web', '2024-01-15 04:42:40', '2024-01-15 04:42:40');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(5, 2),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(15, 2),
(16, 1),
(16, 2),
(17, 1),
(17, 2),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'app_name', 'PEVA-POS', '2024-01-15 04:15:17', '2024-01-15 04:15:17'),
(2, 'currency_symbol', 'N', '2024-01-15 04:15:17', '2024-01-15 04:15:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'User', 'email@email.com', NULL, '$2y$10$rTgafKh93v3VaRDPxsg4IeMdikWTN1CXp5mNMxC2C5Yz1uAMU2Dka', NULL, '2024-01-15 04:15:17', '2024-01-16 16:47:57'),
(2, 'Francis', 'Onah', 'onahfa@gmail.com', NULL, '$2y$10$dAm1B4GVFkUMlo7L5vIFi.3LfIjA3frdncq7JZHO5pluGFiPLcnmK', NULL, '2024-01-15 04:17:01', '2024-01-15 05:20:07'),
(3, 'Gloria', 'Ejiga', 'ejigagloria456@gmail.com', NULL, '$2y$10$1bS7lb7S0xiYRVWmaD6Xkeq6mLwPoMemlwOwdHdpmcdoabZMYQuhO', NULL, '2024-01-15 04:59:06', '2024-01-15 04:59:06');

-- --------------------------------------------------------

--
-- Table structure for table `user_cart`
--

CREATE TABLE `user_cart` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_cart`
--

INSERT INTO `user_cart` (`user_id`, `product_id`, `quantity`) VALUES
(2, 14, 1),
(2, 16, 3),
(2, 17, 4),
(2, 19, 9),
(2, 21, 2),
(2, 22, 49);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_user_id_foreign` (`user_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kitchen_orders`
--
ALTER TABLE `kitchen_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kitchen_orders_order_id_foreign` (`order_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`),
  ADD KEY `payments_user_id_foreign` (`user_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_cart`
--
ALTER TABLE `user_cart`
  ADD KEY `user_cart_user_id_foreign` (`user_id`),
  ADD KEY `user_cart_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kitchen_orders`
--
ALTER TABLE `kitchen_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kitchen_orders`
--
ALTER TABLE `kitchen_orders`
  ADD CONSTRAINT `kitchen_orders_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_cart`
--
ALTER TABLE `user_cart`
  ADD CONSTRAINT `user_cart_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_cart_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
