-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2025 at 05:50 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shoppinghub`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `marital_status` enum('married','unmarried') DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `firstname`, `lastname`, `email`, `phone`, `password`, `marital_status`, `image`, `type`, `address`, `city`, `pincode`, `state`, `country`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Avi', 'Roy', 's@gmail.com', '09641857774', '12345678', NULL, 'uploads/290859098_leader3.png', 'staff', 'Dinhata, Shital Bari Road, Word no - 5', 'Coochbehar', '736135', 'west bengal', 'India', 'active', '2025-03-13 21:52:41', '2025-03-15 16:06:28'),
(3, 'Subham', 'Roy', 's1@gmail.com', '9641857775', '12345678', NULL, 'uploads/460057026_image-2.png', 'admin', 'Dinhata, Shitala Bari Road', 'Coochbehar', '736135', 'west bengal', 'India', 'active', '2025-03-13 21:56:12', '2025-03-15 15:34:44'),
(4, 'Subham', 'Roy', 'admin@gmail.com', '9874563210', 'password', NULL, 'uploads/122909514_leader4.png', 'staff', 'Dinhata', 'Coochbehar', '736135', 'west bengal', 'India', 'active', '2025-03-13 22:46:22', '2025-03-13 22:46:34');

-- --------------------------------------------------------

--
-- Table structure for table `carousel`
--

CREATE TABLE `carousel` (
  `id` int(11) NOT NULL,
  `carousel_name` varchar(50) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `subtitle` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carousel`
--

INSERT INTO `carousel` (`id`, `carousel_name`, `title`, `subtitle`, `status`, `image`, `time`) VALUES
(3, 'Chair-slider-2', 'Upto 50% discount', 'Selling start from Tomorrow 8pm', 'active', 'uploads/919260767_hero-slider-2.jpg', NULL),
(4, 'Watches', 'Best Price', 'Buy Soon', 'active', 'uploads/861848354_hero-slider-1.jpg', NULL),
(5, 'Electronic-Slider-2', 'Upto 50% discount', 'Best Price for You', 'inactive', 'uploads/424357051_hero-slider-2.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`) VALUES
(36, 49, '2025-04-21 12:49:37'),
(37, 49, '2025-04-21 12:49:42'),
(38, 49, '2025-04-21 12:55:23'),
(39, 49, '2025-04-21 12:56:45'),
(40, 49, '2025-04-21 12:57:04'),
(51, 50, '2025-04-21 13:13:01');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `qty`, `added_at`) VALUES
(169, 51, 22, 2, '2025-04-23 15:19:12'),
(170, 51, 23, 1, '2025-04-23 15:26:47');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `c_name` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `c_name`, `status`, `create_at`, `update_at`) VALUES
(10, 'Home Accessories', 'active', '2025-03-10 16:15:41', '2025-03-10 16:15:41'),
(11, 'Cosmatics', 'active', '2025-03-10 16:15:41', '2025-03-10 16:15:41'),
(12, 'Electronics', 'active', '2025-03-10 16:15:41', '2025-03-10 16:15:41'),
(15, 'Mobile', 'inactive', '2025-03-10 16:15:41', '2025-03-14 21:57:50'),
(18, 'Jewellery', 'active', '2025-03-15 19:41:05', '2025-03-15 19:41:05');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `payment_status` enum('paid','unpaid','refunded') DEFAULT 'unpaid',
  `shipping_address` text NOT NULL,
  `billing_address` text DEFAULT NULL,
  `customer_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_amount`, `status`, `payment_status`, `shipping_address`, `billing_address`, `customer_notes`, `created_at`, `updated_at`) VALUES
(45, 50, '2025-04-23 11:39:53', 5.00, 'pending', 'unpaid', '', NULL, NULL, '2025-04-23 11:39:53', '2025-04-23 11:39:53'),
(46, 50, '2025-04-23 11:39:57', 5.00, 'pending', 'unpaid', '', NULL, NULL, '2025-04-23 11:39:57', '2025-04-23 11:39:57'),
(47, 50, '2025-04-23 11:40:00', 5.00, 'pending', 'unpaid', '', NULL, NULL, '2025-04-23 11:40:00', '2025-04-23 11:40:00'),
(48, 50, '2025-04-23 13:59:12', 4505.00, 'pending', 'unpaid', 'Dinhata, Coochbehar, west bengal, India, 736135', NULL, NULL, '2025-04-23 13:59:12', '2025-04-23 13:59:12'),
(49, 50, '2025-04-23 13:59:19', 5.00, 'pending', 'unpaid', 'Dinhata, Coochbehar, west bengal, India, 736135', NULL, NULL, '2025-04-23 13:59:19', '2025-04-23 13:59:19'),
(50, 50, '2025-04-23 13:59:25', 5.00, 'pending', 'unpaid', 'Dinhata, Coochbehar, west bengal, India, 736135', NULL, NULL, '2025-04-23 13:59:25', '2025-04-23 13:59:25'),
(51, 50, '2025-04-23 14:00:33', 2905.00, 'pending', 'unpaid', 'Dinhata, Coochbehar, west bengal, India, 736135', NULL, NULL, '2025-04-23 14:00:33', '2025-04-23 14:00:33'),
(52, 50, '2025-04-23 14:04:37', 1003.00, 'pending', 'unpaid', 'Dinhata, Coochbehar, west bengal, India, 736135', NULL, NULL, '2025-04-23 14:04:37', '2025-04-23 14:04:37'),
(53, 50, '2025-04-23 14:09:36', 98003.00, 'pending', 'unpaid', 'Dinhata, Coochbehar, west bengal, India, 736135', NULL, NULL, '2025-04-23 14:09:36', '2025-04-23 14:09:36'),
(54, 50, '2025-04-23 14:16:52', 9574.00, 'pending', 'unpaid', 'Dinhata, Coochbehar, west bengal, India, 736135', NULL, NULL, '2025-04-23 14:16:52', '2025-04-23 14:16:52');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `unit_price`, `subtotal`) VALUES
(10, 48, 14, 1, 4500.00, 4500.00),
(11, 51, 7, 1, 400.00, 400.00),
(12, 51, 3, 1, 2500.00, 2500.00),
(13, 52, 10, 2, 499.00, 998.00),
(14, 53, 16, 2, 48999.00, 97998.00),
(15, 54, 14, 1, 4500.00, 4500.00),
(16, 54, 7, 1, 400.00, 400.00),
(17, 54, 22, 1, 4669.00, 4669.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_status_history`
--

CREATE TABLE `order_status_history` (
  `history_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') NOT NULL,
  `status_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('credit_card','paypal','cod','upi','bank_transfer') NOT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `status` enum('pending','completed','failed','refunded') DEFAULT 'pending',
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `amount`, `payment_method`, `transaction_id`, `status`, `payment_date`) VALUES
(25, 45, 5.00, 'credit_card', NULL, 'pending', '2025-04-23 11:39:53'),
(26, 46, 5.00, 'credit_card', NULL, 'pending', '2025-04-23 11:39:57'),
(27, 47, 5.00, 'credit_card', NULL, 'pending', '2025-04-23 11:40:00'),
(28, 48, 4505.00, 'credit_card', NULL, 'pending', '2025-04-23 13:59:12'),
(29, 49, 5.00, 'paypal', NULL, 'pending', '2025-04-23 13:59:19'),
(30, 50, 5.00, 'credit_card', NULL, 'pending', '2025-04-23 13:59:25'),
(31, 51, 2905.00, 'credit_card', NULL, 'pending', '2025-04-23 14:00:34'),
(32, 52, 1003.00, 'credit_card', NULL, 'pending', '2025-04-23 14:04:37'),
(33, 53, 98003.00, 'cod', NULL, 'pending', '2025-04-23 14:09:36'),
(34, 54, 9574.00, 'credit_card', NULL, 'pending', '2025-04-23 14:16:52');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `c_id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `mrp_price` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `reviews` int(11) DEFAULT 0,
  `description` text DEFAULT NULL,
  `long_description` text DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `image` varchar(255) DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `c_id`, `brand_name`, `mrp_price`, `price`, `reviews`, `description`, `long_description`, `stock`, `status`, `image`, `image1`, `image2`, `image3`, `create_at`, `update_at`) VALUES
(1, 'Wall Clock', 10, 'Miton', 500.00, 400.00, 4, '🎯 Key Changes & Benefits:\r\n✔️ No need for external CSS (all styles applied inline).\r\n✔️ Ensures consistent styles when images are dynamically added.\r\n✔️ Easy to modify styles directly in the script.\r\n\r\n🚀 Now, each preview image will have the correct styles automatically! 🎉 Let me know if you need further tweaks. 😊', '🎯 Key Changes & Benefits:\r\n✔️ No need for external CSS (all styles applied inline).\r\n✔️ Ensures consistent styles when images are dynamically added.\r\n✔️ Easy to modify styles directly in the script.\r\n\r\n🚀 Now, each preview image will have the correct styles automatically! 🎉 Let me know if you need further tweaks. 😊', 52, 'inactive', 'uploads/651860635_default-3.jpg', 'uploads/596355742_default-3.jpg', 'uploads/546639862_default-3.jpg', 'uploads/356141500_default-3.jpg', '2025-03-10 08:36:06', '2025-03-10 14:54:38'),
(3, 'Camera', 12, 'Sony', 3880.00, 2500.00, 1, '🎯 Key Changes & Benefits:\r\n✔️ No need for external CSS (all styles applied inline).\r\n✔️ Ensures consistent styles when images are dynamically added.\r\n✔️ Easy to modify styles directly in the script.\r\n\r\n🚀 Now, each preview image will have the correct styles automatically! 🎉 Let me know if you need further tweaks. 😊', '🎯 Key Changes & Benefits:\r\n✔️ No need for external CSS (all styles applied inline).\r\n✔️ Ensures consistent styles when images are dynamically added.\r\n✔️ Easy to modify styles directly in the script.\r\n\r\n🚀 Now, each preview image will have the correct styles automatically! 🎉 Let me know if you need further tweaks. 😊', 10, 'active', 'uploads/889020673_default-11.jpg', 'uploads/833885719_default-11.jpg', 'uploads/824472876_default-11.jpg', 'uploads/904812724_default-11.jpg', '2025-03-10 09:18:22', '2025-03-10 16:24:05'),
(4, 'Stell Chair', 10, 'Tata Stell', 599.00, 499.00, 5, '🎯 Key Changes & Benefits:\r\n✔️ No need for external CSS (all styles applied inline).\r\n✔️ Ensures consistent styles when images are dynamically added.\r\n✔️ Easy to modify styles directly in the script.\r\n\r\n🚀 Now, each preview image will have the correct styles automatically! 🎉 Let me know if you need further tweaks. 😊', '🎯 Key Changes & Benefits:\r\n✔️ No need for external CSS (all styles applied inline).\r\n✔️ Ensures consistent styles when images are dynamically added.\r\n✔️ Easy to modify styles directly in the script.\r\n\r\n🚀 Now, each preview image will have the correct styles automatically! 🎉 Let me know if you need further tweaks. 😊', 50, 'active', 'uploads/750685153_default-1.jpg', 'uploads/926556215_default-1.jpg', 'uploads/712196849_default-1.jpg', 'uploads/692003138_default-1.jpg', '2025-03-10 09:19:48', '2025-03-10 09:19:48'),
(6, 'Google Pixel phone', 15, 'Google', 49999.00, 45000.00, 4, 'Product detail pages (PDPs) are crucial components of e-commerce websites, providing comprehensive information about specific products to help potential customers make informed purchasing decisions.\r\n These pages typically include high-quality images and videos that allow online shoppers to visualize the product from different angles and understand its appearance and size.\r\n Detailed product descriptions, specifications, pricing, and availability are also essential elements', 'Product detail pages (PDPs) are crucial components of e-commerce websites, providing comprehensive information about specific products to help potential customers make informed purchasing decisions.\r\n These pages typically include high-quality images and videos that allow online shoppers to visualize the product from different angles and understand its appearance and size.\r\n Detailed product descriptions, specifications, pricing, and availability are also essential elements', 12, 'inactive', 'uploads/171963685_default-5.jpg', 'uploads/554736767_default-5.jpg', 'uploads/303161231_default-5.jpg', 'uploads/387243947_default-5.jpg', '2025-03-10 10:28:17', '2025-03-10 10:28:17'),
(7, 'Wall Clock', 10, 'Titan', 455.00, 400.00, 2, 'Product detail pages (PDPs) are crucial components of e-commerce websites, providing comprehensive information about specific products to help potential customers make informed purchasing decisions.\r\n These pages typically include high-quality images and videos that allow online shoppers to visualize the product from different angles and understand its appearance and size.\r\n Detailed product descriptions, specifications, pricing, and availability are also essential elements', 'Product detail pages (PDPs) are crucial components of e-commerce websites, providing comprehensive information about specific products to help potential customers make informed purchasing decisions.\r\n These pages typically include high-quality images and videos that allow online shoppers to visualize the product from different angles and understand its appearance and size.\r\n Detailed product descriptions, specifications, pricing, and availability are also essential elements', 30, 'active', 'uploads/657225272_default-10.jpg', 'uploads/737615042_default-10.jpg', 'uploads/586391080_default-10.jpg', 'uploads/394104621_default-10.jpg', '2025-03-10 10:30:06', '2025-03-10 14:23:48'),
(8, 'Camera Lens', 12, 'Sony', 4649.00, 4389.00, 3, 'Product detail pages (PDPs) are crucial components of e-commerce websites, providing comprehensive information about specific products to help potential customers make informed purchasing decisions.\r\n These pages typically include high-quality images and videos that allow online shoppers to visualize the product from different angles and understand its appearance and size.\r\n Detailed product descriptions, specifications, pricing, and availability are also essential elements', 'Product detail pages (PDPs) are crucial components of e-commerce websites, providing comprehensive information about specific products to help potential customers make informed purchasing decisions.\r\n These pages typically include high-quality images and videos that allow online shoppers to visualize the product from different angles and understand its appearance and size.\r\n Detailed product descriptions, specifications, pricing, and availability are also essential elements', 29, 'inactive', 'uploads/786726449_default-2.jpg', 'uploads/128187807_default-2.jpg', 'uploads/761930712_default-2.jpg', 'uploads/988272722_default-2.jpg', '2025-03-10 10:31:55', '2025-03-13 12:40:09'),
(10, 'Chair', 10, 'Supreme', 599.00, 499.00, 5, 'Product detail pages (PDPs) are crucial components of e-commerce websites, providing comprehensive information about specific products to help potential customers make informed purchasing decisions.\r\nThese pages typically include high-quality images and videos that allow online shoppers to visualize the product from different angles and understand its appearance and size.\r\n Detailed product descriptions, specifications, pricing, and availability are also essential elements', 'Product detail pages (PDPs) are crucial components of e-commerce websites, providing comprehensive information about specific products to help potential customers make informed purchasing decisions.\r\nThese pages typically include high-quality images and videos that allow online shoppers to visualize the product from different angles and understand its appearance and size.\r\n Detailed product descriptions, specifications, pricing, and availability are also essential elements', 15, 'active', 'uploads/750804111_default-6.jpg', 'uploads/805636743_default-6.jpg', 'uploads/642185728_default-6.jpg', 'uploads/633989182_default-6.jpg', '2025-03-10 10:35:20', '2025-03-10 10:35:20'),
(13, 'Stand Camera', 12, 'Sony', 600.00, 500.00, 4, 'To optimize PDPs for performance, it is important to ensure that the information is clear, easy to read, and packed with the right details.', 'To optimize PDPs for performance, it is important to ensure that the information is clear, easy to read, and packed with the right details.\r\n High-quality images, detailed descriptions, and an intuitive page layout are key to capturing the visitor\'s attention and increasing the chances of a sale.\r\n Proper formatting and structure of product details can also enhance SEO efforts and improve search engine rankings.', 5, 'inactive', 'uploads/676496970_default-1.jpg', 'uploads/881297539_default-1.jpg', 'uploads/812400689_default-1.jpg', 'uploads/608486976_default-1.jpg', '2025-03-10 12:22:40', '2025-03-22 16:01:37'),
(14, 'Gokhru Camera', 12, 'DJI', 4000.00, 4500.00, 4, 'To optimize PDPs for performance, it is important to ensure that the information is clear, easy to read, and packed with the right details.', 'To optimize PDPs for performance, it is important to ensure that the information is clear, easy to read, and packed with the right details.\r\n High-quality images, detailed descriptions, and an intuitive page layout are key to capturing the visitor\'s attention and increasing the chances of a sale.\r\n Proper formatting and structure of product details can also enhance SEO efforts and improve search engine rankings.', 10, 'active', 'uploads/603253596_default-8.jpg', 'uploads/239241166_default-8.jpg', 'uploads/910054073_default-8.jpg', 'uploads/900241482_default-8.jpg', '2025-03-10 12:31:29', '2025-03-10 17:09:15'),
(15, 'Li-lon Chair', 10, 'Supreme', 599.00, 399.00, 3, 'November 28, 2024 Lakmé is an Indian cosmetics brand owned by Hindustan Unilever. It was named after the French opera Lakmé, which itself is the French word for the goddess Lakshmi, who is renowned for her beauty.', 'November 28, 2024: Lakmé is an Indian cosmetics brand owned by Hindustan Unilever. It was named after the French opera Lakmé, which itself is the French word for the goddess Lakshmi, who is renowned for her beauty.November 28, 2024: Lakmé is an Indian cosmetics brand owned by Hindustan Unilever. It was named after the French opera Lakmé, which itself is the French word for the goddess Lakshmi, who is renowned for her beauty.', 20, 'active', 'uploads/753523088_default-7.jpg', 'uploads/456351824_default-7.jpg', 'uploads/534782322_default-7.jpg', 'uploads/622847381_default-7.jpg', '2025-03-10 17:11:57', '2025-03-10 17:12:59'),
(16, 'Mac Book Air Pro', 12, 'Apple', 53499.00, 48999.00, 2, '🛍 Product Description Examples\r\n✅ Short Description (Concise & Catchy)\r\n\"Experience ultimate comfort and style with our premium leather office chair. Designed for durability and ergonomic support, it\'s perfect for long work hours. Elevate your workspace today!\"', '✅ Long Description (Detailed & Persuasive)\r\nUpgrade your workspace with our ergonomic leather office chair, crafted for superior comfort and durability. Made with high-quality PU leather, this chair features adjustable armrests, lumbar support, and a 360° swivel function, ensuring the perfect seating position for long hours of work or gaming.\r\n\r\nThe padded headrest and breathable cushioning provide additional support, reducing strain on your back and neck. With a sturdy metal base and smooth-rolling wheels, it offers both stability and mobility. Whether you\'re working from home or in a corporate setting, this chair combines luxury, comfort, and functionality to enhance productivity.\r\n\r\n💡 Key Features:\r\n✔ Premium PU leather with a sleek finish\r\n✔ Adjustable height & reclining feature\r\n✔ Ergonomic design with lumbar & headrest support\r\n✔ 360° swivel & smooth-rolling wheels\r\n✔ Ideal for office, home, and gaming setups\r\n\r\n✅ Order now and enjoy ultimate comfort at your desk!', 5, 'active', 'uploads/747019110_default-9.jpg', 'uploads/797283860_default-9.jpg', 'uploads/814000458_default-9.jpg', 'uploads/552901812_default-9.jpg', NULL, '2025-03-13 12:41:51'),
(17, 'Hand Bag', 10, 'LV', 549.00, 430.00, 3, '🛍 Product Description Examples\r\n✅ Short Description (Concise & Catchy)\r\n\"Experience ultimate comfort and style with our premium leather office chair. Designed for durability and ergonomic support, it\'s perfect for long work hours. Elevate your workspace today!\"', '✅ Long Description (Detailed & Persuasive)\r\nUpgrade your workspace with our ergonomic leather office chair, crafted for superior comfort and durability. Made with high-quality PU leather, this chair features adjustable armrests, lumbar support, and a 360° swivel function, ensuring the perfect seating position for long hours of work or gaming.\r\n\r\nThe padded headrest and breathable cushioning provide additional support, reducing strain on your back and neck. With a sturdy metal base and smooth-rolling wheels, it offers both stability and mobility. Whether you\'re working from home or in a corporate setting, this chair combines luxury, comfort, and functionality to enhance productivity.\r\n\r\n💡 Key Features:\r\n✔ Premium PU leather with a sleek finish\r\n✔ Adjustable height & reclining feature\r\n✔ Ergonomic design with lumbar & headrest support\r\n✔ 360° swivel & smooth-rolling wheels\r\n✔ Ideal for office, home, and gaming setups\r\n\r\n✅ Order now and enjoy ultimate comfort at your desk!', 5, 'inactive', 'uploads/993034725_default-10.jpg', 'uploads/422003243_default-10.jpg', 'uploads/282023853_default-10.jpg', 'uploads/817699853_default-10.jpg', NULL, '2025-03-12 09:14:10'),
(18, 'Stylish Chair', 10, 'Supreme', 569.00, 499.00, 3, 'Product Short Description:\r\nExperience ultimate comfort and style with our premium cotton T-shirt. Crafted from high-quality, breathable fabric, this T-shirt offers a perfect fit and all-day comfort, making it an ideal choice for casual outings or everyday wear.', 'Product Long Description:\r\nUpgrade your wardrobe with our premium cotton T-shirt, designed for both style and comfort. Made from soft, breathable fabric, this T-shirt ensures a comfortable fit while keeping you cool throughout the day. The classic design and versatile color options make it perfect for any occasion, whether you\'re heading to a casual outing, hitting the gym, or simply lounging at home. With durable stitching and high-quality material, this T-shirt is built to last and maintain its shape even after multiple washes. Pair it with your favorite jeans or shorts for a relaxed yet stylish look.', 30, 'active', 'uploads/875728100_default-7.jpg', 'uploads/666477105_default-7.jpg', 'uploads/298654650_default-7.jpg', 'uploads/726334461_default-7.jpg', NULL, NULL),
(19, 'WALL CLOCK', 10, 'Sony', 669.00, 569.00, 2, 'Product Short Description:\r\nExperience ultimate comfort and style with our premium cotton T-shirt. Crafted from high-quality, breathable fabric, this T-shirt offers a perfect fit and all-day comfort, making it an ideal choice for casual outings or everyday wear.', 'Product Long Description:\r\nUpgrade your wardrobe with our premium cotton T-shirt, designed for both style and comfort. Made from soft, breathable fabric, this T-shirt ensures a comfortable fit while keeping you cool throughout the day. The classic design and versatile color options make it perfect for any occasion, whether you\'re heading to a casual outing, hitting the gym, or simply lounging at home. With durable stitching and high-quality material, this T-shirt is built to last and maintain its shape even after multiple washes. Pair it with your favorite jeans or shorts for a relaxed yet stylish look.', 23, 'active', 'uploads/424893075_default-11.jpg', 'uploads/250798660_default-11.jpg', 'uploads/391924337_default-11.jpg', 'uploads/615867753_default-11.jpg', NULL, NULL),
(20, 'Eyes Droper', 11, 'NEVIA', 566.00, 323.00, 3, 'Product Short Description:\r\nExperience ultimate comfort and style with our premium cotton T-shirt. Crafted from high-quality, breathable fabric, this T-shirt offers a perfect fit and all-day comfort, making it an ideal choice for casual outings or everyday wear.', 'Product Short Description:\r\nExperience ultimate comfort and style with our premium cotton T-shirt. Crafted from high-quality, breathable fabric, this T-shirt offers a perfect fit and all-day comfort, making it an ideal choice for casual outings or everyday wear.\r\nProduct Short Description:\r\nExperience ultimate comfort and style with our premium cotton T-shirt. Crafted from high-quality, breathable fabric, this T-shirt offers a perfect fit and all-day comfort, making it an ideal choice for casual outings or everyday wear.', 56, 'active', 'uploads/719652144_default-14.jpg', 'uploads/362173448_default-14.jpg', 'uploads/204864949_default-14.jpg', 'uploads/726781581_default-14.jpg', NULL, NULL),
(21, 'Night Cream', 11, 'LAKEME', 184.00, 110.00, 3, 'Product Short Description:\r\nExperience ultimate comfort and style with our premium cotton T-shirt. Crafted from high-quality, breathable fabric, this T-shirt offers a perfect fit and all-day comfort, making it an ideal choice for casual outings or everyday wear.', 'Product Short Description:\r\nExperience ultimate comfort and style with our premium cotton T-shirt. Crafted from high-quality, breathable fabric, this T-shirt offers a perfect fit and all-day comfort, making it an ideal choice for casual outings or everyday wear.Product Short Description:\r\nExperience ultimate comfort and style with our premium cotton T-shirt. Crafted from high-quality, breathable fabric, this T-shirt offers a perfect fit and all-day comfort, making it an ideal choice for casual outings or everyday wear.', 5, 'active', 'uploads/816339952_default-13.jpg', 'uploads/557937555_default-13.jpg', 'uploads/124722593_default-13.jpg', 'uploads/314546528_default-13.jpg', NULL, NULL),
(22, 'Iphone 11 ', 15, 'Apple', 5656.00, 4669.00, 3, 'Product Short Description:\r\nExperience ultimate comfort and style with our premium cotton T-shirt. Crafted from high-quality, breathable fabric, this T-shirt offers a perfect fit and all-day comfort, making it an ideal choice for casual outings or everyday wear.', 'Product Short Description:\r\nExperience ultimate comfort and style with our premium cotton T-shirt. Crafted from high-quality, breathable fabric, this T-shirt offers a perfect fit and all-day comfort, making it an ideal choice for casual outings or everyday wear.Product Short Description:\r\nExperience ultimate comfort and style with our premium cotton T-shirt. Crafted from high-quality, breathable fabric, this T-shirt offers a perfect fit and all-day comfort, making it an ideal choice for casual outings or everyday wear.', 23, 'active', 'uploads/784197314_default-6.jpg', 'uploads/414903375_default-6.jpg', 'uploads/713199841_default-6.jpg', 'uploads/159083855_default-6.jpg', NULL, NULL),
(23, 'Sony Speaker', 12, 'Sony', 4565.00, 4223.00, 4, 'Product Short Description:\r\nExperience ultimate comfort and style with our premium cotton T-shirt. Crafted from high-quality, breathable fabric, this T-shirt offers a perfect fit and all-day comfort, making it an ideal choice for casual outings or everyday wear.', 'Product Short Description:\r\nExperience ultimate comfort and style with our premium cotton T-shirt. Crafted from high-quality, breathable fabric, this T-shirt offers a perfect fit and all-day comfort, making it an ideal choice for casual outings or everyday wear.Product Short Description:\r\nExperience ultimate comfort and style with our premium cotton T-shirt. Crafted from high-quality, breathable fabric, this T-shirt offers a perfect fit and all-day comfort, making it an ideal choice for casual outings or everyday wear.', 28, 'active', 'uploads/912966542_default-4.jpg', 'uploads/996229776_default-4.jpg', 'uploads/260778230_default-4.jpg', 'uploads/780315807_default-4.jpg', NULL, NULL),
(24, 'Hair Rings', 18, 'Titan', 559.00, 229.00, 4, 'Product Short Description:\r\nExperience ultimate comfort and style with our premium cotton T-shirt. Crafted from high-quality, breathable fabric, this T-shirt offers a perfect fit and all-day comfort, making it an ideal choice for casual outings or everyday wear.\r\n', 'Product Short Description:\r\nExperience ultimate comfort and style with our premium cotton T-shirt. Crafted from high-quality, breathable fabric, this T-shirt offers a perfect fit and all-day comfort, making it an ideal choice for casual outings or everyday wear.Product Short Description:\r\nExperience ultimate comfort and style with our premium cotton T-shirt. Crafted from high-quality, breathable fabric, this T-shirt offers a perfect fit and all-day comfort, making it an ideal choice for casual outings or everyday wear.', 12, 'active', 'uploads/615831506_default-9.jpg', 'uploads/529681040_default-9.jpg', 'uploads/524845298_default-9.jpg', 'uploads/285778631_default-9.jpg', NULL, NULL),
(25, 'Rings', 18, 'Titan', 7999.00, 5999.00, 3, 'Product Short Description:\r\nExperience ultimate comfort and style with our premium cotton T-shirt. Crafted from high-quality, breathable fabric, this T-shirt offers a perfect fit and all-day comfort, making it an ideal choice for casual outings or everyday wear.', 'Product Short Description:\r\nExperience ultimate comfort and style with our premium cotton T-shirt. Crafted from high-quality, breathable fabric, this T-shirt offers a perfect fit and all-day comfort, making it an ideal choice for casual outings or everyday wear.Product Short Description:\r\nExperience ultimate comfort and style with our premium cotton T-shirt. Crafted from high-quality, breathable fabric, this T-shirt offers a perfect fit and all-day comfort, making it an ideal choice for casual outings or everyday wear.', 4, 'inactive', 'uploads/121148781_default-7.jpg', 'uploads/576737368_default-7.jpg', 'uploads/915379590_default-7.jpg', 'uploads/654524676_default-7.jpg', NULL, '2025-03-22 16:51:17'),
(26, 'Shirt', 18, 'Jeans', 899.00, 499.00, 3, 'Product Short Description:\r\nExperience ultimate comfort and style with our premium cotton T-shirt. Crafted from high-quality, breathable fabric, this T-shirt offers a perfect fit and all-day comfort, making it an ideal choice for casual outings or everyday wear.', 'Product Short Description:\r\nExperience ultimate comfort and style with our premium cotton T-shirt. Crafted from high-quality, breathable fabric, this T-shirt offers a perfect fit and all-day comfort, making it an ideal choice for casual outings or everyday wear.Product Short Description:\r\nExperience ultimate comfort and style with our premium cotton T-shirt. Crafted from high-quality, breathable fabric, this T-shirt offers a perfect fit and all-day comfort, making it an ideal choice for casual outings or everyday wear.', 3, 'inactive', 'uploads/828449507_img-about.jpg', 'uploads/684173524_img-about.jpg', 'uploads/818025851_img-about.jpg', 'uploads/168196407_img-about.jpg', NULL, '2025-03-15 20:46:16');

-- --------------------------------------------------------

--
-- Table structure for table `products_demo`
--

CREATE TABLE `products_demo` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `c_id` int(11) DEFAULT NULL,
  `brand_name` varchar(255) DEFAULT NULL,
  `mrp_price` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `reviews` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `long_description` text DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products_demo`
--

INSERT INTO `products_demo` (`id`, `name`, `c_id`, `brand_name`, `mrp_price`, `price`, `reviews`, `description`, `long_description`, `stock`, `status`, `image`, `image1`, `image2`, `image3`, `create_at`, `update_at`) VALUES
(12, 'OTG Cabel', 12, NULL, 459, NULL, NULL, 'Premium Wireless Headphones – Immersive Sound & Comfort\r\n\r\nExperience crystal-clear audio with our Premium Wireless Headphones, designed for superior sound quality and all-day comfort. Featuring advanced noise cancellation, seamless Bluetooth connectivity', NULL, 12, 'active', 'uploads/67cdf875e303d_default-7.jpg', NULL, NULL, NULL, '2025-03-09 21:11:03', '2025-03-09 21:11:03'),
(13, 'Cosmatic-1', 11, NULL, 499, NULL, NULL, 'Premium Wireless Headphones – Immersive Sound & Comfort\r\n\r\nExperience crystal-clear audio with our Premium Wireless Headphones, designed for superior sound quality and all-day comfort. Featuring advanced noise cancellation, seamless Bluetooth connectivity', NULL, 48, 'active', 'uploads/299709984_default-1.jpg', NULL, NULL, NULL, '2025-03-09 21:11:03', '2025-03-09 21:11:03'),
(15, 'CCTV Camera-1', 12, NULL, 789, NULL, NULL, 'Experience crystal-clear audio with our Premium Wireless Headphones, designed for superior sound quality and all-day comfort. Featuring advanced noise cancellation, seamless Bluetooth connectivity, and up to 30 hours of battery life, these headphones are ', NULL, 45, 'inactive', 'uploads/879409055_default-1.jpg', NULL, NULL, NULL, '2025-03-09 21:11:03', '2025-03-09 21:11:03'),
(17, 'Chair-2', 10, NULL, 780, NULL, NULL, 'Premium Wireless Headphones – Immersive Sound & Comfort\r\n\r\nExperience crystal-clear audio with our Premium Wireless Headphones, designed for superior sound quality and all-day comfort. Featuring advanced noise cancellation, seamless Bluetooth connectivity', NULL, 23, 'active', 'uploads/708452700_default-6.jpg', NULL, NULL, NULL, '2025-03-09 21:11:03', '2025-03-09 21:11:03'),
(18, 'Google Phone', 12, NULL, 47899, NULL, NULL, 'Premium Wireless Headphones – Immersive Sound & Comfort Experience crystal-clear audio with our Premium Wireless Headphones, designed for superior sound quality and all-day comfort. Featuring advanced noise cancellation, seamless Bluetooth connectivity', NULL, 52, 'inactive', 'uploads/990671910_default-8.jpg', NULL, NULL, NULL, '2025-03-09 21:11:03', '2025-03-09 21:11:03'),
(19, 'Laptop', 12, NULL, 48999, NULL, NULL, 'Next-Gen Smartwatch – Stay Connected Anytime\r\nExperience the future on your wrist with our advanced smartwatch, featuring a crystal-clear AMOLED display, 24/7 health tracking, and seamless Bluetooth connectivity. Stay updated with real-time notifications,', NULL, 25, 'active', 'uploads/127773281_default-9.jpg', NULL, NULL, NULL, '2025-03-09 21:11:03', '2025-03-09 21:11:03'),
(23, 'Iphone 11', 15, 'Apple', 54595, 48442, 5, 'Next-Gen Smartwatch – Stay Connected Anytime\r\nExperience the future on your wrist with our advanced smartwatch, featuring a crystal-clear AMOLED display, 24/7 health tracking, and seamless Bluetooth connectivity. Stay updated with real-time notifications, heart rate monitoring, and sleep tracking—all in a sleek and stylish design.\r\n\r\n', 'Next-Gen Smartwatch – Stay Connected Anytime\r\nExperience the future on your wrist with our advanced smartwatch, featuring a crystal-clear AMOLED display, 24/7 health tracking, and seamless Bluetooth connectivity. Stay updated with real-time notifications, heart rate monitoring, and sleep tracking—all in a sleek and stylish design.\r\n\r\n', 10, 'inactive', 'uploads/746734151_default-6.jpg', 'uploads/123307575_default-6.jpg', 'uploads/813246278_default-6.jpg', 'uploads/207106275_default-6.jpg', '2025-03-09 17:35:57', '2025-03-09 17:35:57'),
(24, 'Wall Clock', 10, 'Titan', 499, 399, 3, 'Next-Gen Smartwatch – Stay Connected Anytime\r\nExperience the future on your wrist with our advanced smartwatch, featuring a crystal-clear AMOLED display, 24/7 health tracking, and seamless Bluetooth connectivity. Stay updated with real-time notifications, heart rate monitoring, and sleep tracking—all in a sleek and stylish design.\r\n\r\n', 'Next-Gen Smartwatch – Stay Connected Anytime\r\nExperience the future on your wrist with our advanced smartwatch, featuring a crystal-clear AMOLED display, 24/7 health tracking, and seamless Bluetooth connectivity. Stay updated with real-time notifications, heart rate monitoring, and sleep tracking—all in a sleek and stylish design.\r\nNext-Gen Smartwatch – Stay Connected Anytime\r\nExperience the future on your wrist with our advanced smartwatch, featuring a crystal-clear AMOLED display, 24/7 health tracking, and seamless Bluetooth connectivity. Stay updated with real-time notifications, heart rate monitoring, and sleep tracking—all in a sleek and stylish design.\r\n\r\nNext-Gen Smartwatch – Stay Connected Anytime\r\nExperience the future on your wrist with our advanced smartwatch, featuring a crystal-clear AMOLED display, 24/7 health tracking, and seamless Bluetooth connectivity. Stay updated with real-time notifications, heart rate monitoring, and sleep tracking—all in a sleek and stylish design.', 80, 'active', 'uploads/899529925_default-11.jpg', 'uploads/993629539_default-11.jpg', 'uploads/241274739_default-11.jpg', 'uploads/843774423_default-11.jpg', '2025-03-09 17:38:26', '2025-03-09 17:38:26'),
(25, 'Wall Clock', 10, 'Titan', 48444, 32998, 5, 'Next-Gen Smartwatch – Stay Connected Anytime\r\nExperience the future on your wrist with our advanced smartwatch, featuring a crystal-clear AMOLED display, 24/7 health tracking, and seamless Bluetooth connectivity. Stay updated with real-time notifications, heart rate monitoring, and sleep tracking—all in a sleek and stylish design.\r\n\r\n', 'Next-Gen Smartwatch – Stay Connected Anytime\r\nExperience the future on your wrist with our advanced smartwatch, featuring a crystal-clear AMOLED display, 24/7 health tracking, and seamless Bluetooth connectivity. Stay updated with real-time notifications, heart rate monitoring, and sleep tracking—all in a sleek and stylish design.\r\n\r\nNext-Gen Smartwatch – Stay Connected Anytime\r\nExperience the future on your wrist with our advanced smartwatch, featuring a crystal-clear AMOLED display, 24/7 health tracking, and seamless Bluetooth connectivity. Stay updated with real-time notifications, heart rate monitoring, and sleep tracking—all in a sleek and stylish design.\r\n\r\nNext-Gen Smartwatch – Stay Connected Anytime\r\nExperience the future on your wrist with our advanced smartwatch, featuring a crystal-clear AMOLED display, 24/7 health tracking, and seamless Bluetooth connectivity. Stay updated with real-time notifications, heart rate monitoring, and sleep tracking—all in a sleek and stylish design.\r\n\r\n', 5, 'active', 'uploads/697617412_default-11.jpg', 'uploads/140808485_default-11.jpg', 'uploads/939335440_default-11.jpg', 'uploads/159481937_default-11.jpg', '2025-03-09 17:42:46', '2025-03-09 17:42:46'),
(26, 'Stell Bottle', 10, 'Miton', 569, 450, 4, '✔️ No need for external CSS (all styles applied inline).\r\n✔️ Ensures consistent styles when images are dynamically added.\r\n✔️ Easy to modify styles directly in the script.\r\n\r\n🚀 Now, each preview image will have the correct styles automatically! 🎉 Let me know if you need further tweaks. 😊', '✔️ No need for external CSS (all styles applied inline).\r\n✔️ Ensures consistent styles when images are dynamically added.\r\n✔️ Easy to modify styles directly in the script.\r\n\r\n🚀 Now, each preview image will have the correct styles automatically! 🎉 Let me know if you need further tweaks. 😊', 10, 'active', 'uploads/599277449_default-3.jpg', 'uploads/710734449_default-3.jpg', 'uploads/663469441_default-3.jpg', 'uploads/707071371_default-3.jpg', '2025-03-10 03:02:07', '2025-03-10 03:02:07');

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `shipping_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `tracking_number` varchar(50) DEFAULT NULL,
  `carrier` varchar(50) DEFAULT NULL,
  `status` enum('processing','shipped','in_transit','delivered','returned') DEFAULT 'processing',
  `estimated_delivery` date DEFAULT NULL,
  `actual_delivery` date DEFAULT NULL,
  `shipping_date` timestamp NULL DEFAULT NULL,
  `delivery_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `address2` text DEFAULT NULL,
  `city2` varchar(50) DEFAULT NULL,
  `pincode2` varchar(10) DEFAULT NULL,
  `state2` varchar(50) DEFAULT NULL,
  `country2` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `email`, `phone`, `password`, `address`, `city`, `pincode`, `state`, `country`, `status`, `address2`, `city2`, `pincode2`, `state2`, `country2`, `created_at`, `updated_at`) VALUES
(44, 'Subham', 'Roy', 'roy@gmail.com1', '9641857771', '$2y$10$.LAigT6kVmiHGvfPQGHfTOdsW78Tq/uTt10WYatX.5NxWv8DnfUHu', 'Dinhata, Gopal Nagar', 'Coochbehar', '736135', 'west bengal', 'India', 'active', 'Dinhata, Shitala Bari Road, Ward no 5', 'Coochbehar', '736135', 'west bengal', 'India', '2025-03-14 19:55:22', '2025-04-19 13:25:25'),
(45, 'Admin', 'Admin', 'admin@gmail.com1', '9876543210', '$2y$10$YfNelMU53xNk9VqqesyHWOhK2csAN867WyUgVg.7esrHObN2sBgIe', 'Mahisbatan, Sector 5', 'Salt lake', '700102', 'west bengal', 'India', 'active', 'Dinhata', 'Coochbehar', '736135', 'west bengal', 'India', '2025-03-14 20:14:32', '2025-04-19 13:25:32'),
(49, 'Admin', 'Admin', 'admin@gmail.com', '9641857774', '$2y$10$7PqbH0L6za420SqS9p.7Ge2zMIVyZlpzPz/FPz.rr5B4DKQewfFsG', NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, '2025-04-19 13:25:44', '2025-04-21 17:48:11'),
(50, 'Ashoka', 'Roy', 'ashok@gmail.com', '9932639491', '$2y$10$qQz..PRJkaleuzCs06mj3.ktpJDFtL4Us3tRmhZN.dZeK2M2K8lS2', 'Dinhata, Shital Bari Road, Word no - 5', 'Coochbehar', '736135', 'west bengal', 'India', 'active', 'Mahisbatan, Sector 5', 'Salt lake', '700102', 'west bengal', 'India', '2025-04-21 13:03:33', '2025-04-23 14:52:17');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `wishlist_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`wishlist_id`, `user_id`, `product_id`, `create_at`, `update_at`) VALUES
(16, 44, 3, '2025-03-21 18:45:09', '2025-03-21 18:45:09'),
(17, 44, 10, '2025-03-21 18:47:50', '2025-03-21 18:47:50'),
(36, 44, 22, '2025-03-21 21:48:22', '2025-03-21 21:48:22'),
(37, 44, 23, '2025-03-21 21:48:34', '2025-03-21 21:48:34'),
(40, 45, 14, '2025-03-22 14:30:01', '2025-03-22 14:30:01'),
(41, 45, 16, '2025-03-22 14:30:03', '2025-03-22 14:30:03'),
(44, 45, 22, '2025-03-22 14:44:59', '2025-03-22 14:44:59'),
(45, 45, 3, '2025-03-22 14:46:48', '2025-03-22 14:46:48'),
(52, 45, 13, '2025-03-22 14:58:23', '2025-03-22 14:58:23'),
(53, 49, 21, '2025-04-19 13:26:09', '2025-04-19 13:26:09'),
(54, 49, 23, '2025-04-19 13:26:13', '2025-04-19 13:26:13'),
(55, 49, 24, '2025-04-19 13:26:15', '2025-04-19 13:26:15'),
(56, 49, 14, '2025-04-19 13:26:20', '2025-04-19 13:26:20'),
(57, 49, 16, '2025-04-19 13:26:22', '2025-04-19 13:26:22'),
(58, 49, 10, '2025-04-19 13:26:28', '2025-04-19 13:26:28'),
(67, 50, 16, '2025-04-21 17:11:25', '2025-04-21 17:11:25'),
(68, 50, 15, '2025-04-21 17:11:30', '2025-04-21 17:11:30'),
(69, 50, 14, '2025-04-22 12:15:10', '2025-04-22 12:15:10'),
(70, 50, 3, '2025-04-22 12:17:25', '2025-04-22 12:17:25'),
(76, 50, 7, '2025-04-22 14:45:28', '2025-04-22 14:45:28'),
(77, 50, 10, '2025-04-22 14:45:41', '2025-04-22 14:45:41'),
(78, 50, 22, '2025-04-23 15:23:41', '2025-04-23 15:23:41'),
(79, 50, 20, '2025-04-23 15:26:51', '2025-04-23 15:26:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `order_status_history`
--
ALTER TABLE `order_status_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_demo`
--
ALTER TABLE `products_demo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `c_id` (`c_id`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`shipping_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `order_status_history`
--
ALTER TABLE `order_status_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `products_demo`
--
ALTER TABLE `products_demo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `shipping_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_status_history`
--
ALTER TABLE `order_status_history`
  ADD CONSTRAINT `order_status_history_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

--
-- Constraints for table `products_demo`
--
ALTER TABLE `products_demo`
  ADD CONSTRAINT `products_demo_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `shipping`
--
ALTER TABLE `shipping`
  ADD CONSTRAINT `shipping_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `wishlists_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
