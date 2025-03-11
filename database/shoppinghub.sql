-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2025 at 03:39 PM
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
(2, 'Cosmatic-slider-1', 'New Product', 'Best Cosmatic', 'active', 'uploads/291383535_hero-slider-1.jpg', NULL),
(3, 'Chair-slider-2', 'Upto 50% discount', 'Selling start from Tomorrow 8pm', 'inactive', 'uploads/919260767_hero-slider-2.jpg', NULL),
(4, 'Watches', 'Best Price', 'Buy Soon', 'active', 'uploads/861848354_hero-slider-1.jpg', NULL),
(5, 'Electronic-Slider-2', 'Upto 50% discount', 'Best Price for You', 'inactive', 'uploads/424357051_hero-slider-2.jpg', NULL);

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
(15, 'Mobile', 'active', '2025-03-10 16:15:41', '2025-03-10 16:15:41');

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
(8, 'Camera Lens', 12, 'Sony', 4649.00, 4389.00, 3, 'Product detail pages (PDPs) are crucial components of e-commerce websites, providing comprehensive information about specific products to help potential customers make informed purchasing decisions.\r\n These pages typically include high-quality images and videos that allow online shoppers to visualize the product from different angles and understand its appearance and size.\r\n Detailed product descriptions, specifications, pricing, and availability are also essential elements', 'Product detail pages (PDPs) are crucial components of e-commerce websites, providing comprehensive information about specific products to help potential customers make informed purchasing decisions.\r\n These pages typically include high-quality images and videos that allow online shoppers to visualize the product from different angles and understand its appearance and size.\r\n Detailed product descriptions, specifications, pricing, and availability are also essential elements', 29, 'active', 'uploads/786726449_default-2.jpg', 'uploads/128187807_default-2.jpg', 'uploads/761930712_default-2.jpg', 'uploads/988272722_default-2.jpg', '2025-03-10 10:31:55', '2025-03-10 14:23:34'),
(10, 'Chair', 10, 'Supreme', 599.00, 499.00, 5, 'Product detail pages (PDPs) are crucial components of e-commerce websites, providing comprehensive information about specific products to help potential customers make informed purchasing decisions.\r\nThese pages typically include high-quality images and videos that allow online shoppers to visualize the product from different angles and understand its appearance and size.\r\n Detailed product descriptions, specifications, pricing, and availability are also essential elements', 'Product detail pages (PDPs) are crucial components of e-commerce websites, providing comprehensive information about specific products to help potential customers make informed purchasing decisions.\r\nThese pages typically include high-quality images and videos that allow online shoppers to visualize the product from different angles and understand its appearance and size.\r\n Detailed product descriptions, specifications, pricing, and availability are also essential elements', 15, 'active', 'uploads/750804111_default-6.jpg', 'uploads/805636743_default-6.jpg', 'uploads/642185728_default-6.jpg', 'uploads/633989182_default-6.jpg', '2025-03-10 10:35:20', '2025-03-10 10:35:20'),
(13, 'Stand Camera', 12, 'Sony', 600.00, 500.00, 4, 'To optimize PDPs for performance, it is important to ensure that the information is clear, easy to read, and packed with the right details.', 'To optimize PDPs for performance, it is important to ensure that the information is clear, easy to read, and packed with the right details.\r\n High-quality images, detailed descriptions, and an intuitive page layout are key to capturing the visitor\'s attention and increasing the chances of a sale.\r\n Proper formatting and structure of product details can also enhance SEO efforts and improve search engine rankings.', 5, 'active', 'uploads/676496970_default-1.jpg', 'uploads/881297539_default-1.jpg', 'uploads/812400689_default-1.jpg', 'uploads/608486976_default-1.jpg', '2025-03-10 12:22:40', '2025-03-10 12:28:14'),
(14, 'Gokhru Camera', 12, 'DJI', 4000.00, 4500.00, 4, 'To optimize PDPs for performance, it is important to ensure that the information is clear, easy to read, and packed with the right details.', 'To optimize PDPs for performance, it is important to ensure that the information is clear, easy to read, and packed with the right details.\r\n High-quality images, detailed descriptions, and an intuitive page layout are key to capturing the visitor\'s attention and increasing the chances of a sale.\r\n Proper formatting and structure of product details can also enhance SEO efforts and improve search engine rankings.', 10, 'active', 'uploads/603253596_default-8.jpg', 'uploads/239241166_default-8.jpg', 'uploads/910054073_default-8.jpg', 'uploads/900241482_default-8.jpg', '2025-03-10 12:31:29', '2025-03-10 17:09:15'),
(15, 'Li-lon Chair', 10, 'Supreme', 599.00, 399.00, 3, 'November 28, 2024 Lakmé is an Indian cosmetics brand owned by Hindustan Unilever. It was named after the French opera Lakmé, which itself is the French word for the goddess Lakshmi, who is renowned for her beauty.', 'November 28, 2024: Lakmé is an Indian cosmetics brand owned by Hindustan Unilever. It was named after the French opera Lakmé, which itself is the French word for the goddess Lakshmi, who is renowned for her beauty.November 28, 2024: Lakmé is an Indian cosmetics brand owned by Hindustan Unilever. It was named after the French opera Lakmé, which itself is the French word for the goddess Lakshmi, who is renowned for her beauty.', 20, 'active', 'uploads/753523088_default-7.jpg', 'uploads/456351824_default-7.jpg', 'uploads/534782322_default-7.jpg', 'uploads/622847381_default-7.jpg', '2025-03-10 17:11:57', '2025-03-10 17:12:59'),
(16, 'Mac Book Air Pro', 12, 'Apple', 48999.00, 4589.00, 4, '🛍 Product Description Examples\r\n✅ Short Description (Concise & Catchy)\r\n\"Experience ultimate comfort and style with our premium leather office chair. Designed for durability and ergonomic support, it\'s perfect for long work hours. Elevate your workspace today!\"', '✅ Long Description (Detailed & Persuasive)\r\nUpgrade your workspace with our ergonomic leather office chair, crafted for superior comfort and durability. Made with high-quality PU leather, this chair features adjustable armrests, lumbar support, and a 360° swivel function, ensuring the perfect seating position for long hours of work or gaming.\r\n\r\nThe padded headrest and breathable cushioning provide additional support, reducing strain on your back and neck. With a sturdy metal base and smooth-rolling wheels, it offers both stability and mobility. Whether you\'re working from home or in a corporate setting, this chair combines luxury, comfort, and functionality to enhance productivity.\r\n\r\n💡 Key Features:\r\n✔ Premium PU leather with a sleek finish\r\n✔ Adjustable height & reclining feature\r\n✔ Ergonomic design with lumbar & headrest support\r\n✔ 360° swivel & smooth-rolling wheels\r\n✔ Ideal for office, home, and gaming setups\r\n\r\n✅ Order now and enjoy ultimate comfort at your desk!', 15, 'active', 'uploads/747019110_default-9.jpg', 'uploads/797283860_default-9.jpg', 'uploads/814000458_default-9.jpg', 'uploads/552901812_default-9.jpg', NULL, NULL),
(17, 'Hand Bag', 10, 'LV', 549.00, 430.00, 3, '🛍 Product Description Examples\r\n✅ Short Description (Concise & Catchy)\r\n\"Experience ultimate comfort and style with our premium leather office chair. Designed for durability and ergonomic support, it\'s perfect for long work hours. Elevate your workspace today!\"', '✅ Long Description (Detailed & Persuasive)\r\nUpgrade your workspace with our ergonomic leather office chair, crafted for superior comfort and durability. Made with high-quality PU leather, this chair features adjustable armrests, lumbar support, and a 360° swivel function, ensuring the perfect seating position for long hours of work or gaming.\r\n\r\nThe padded headrest and breathable cushioning provide additional support, reducing strain on your back and neck. With a sturdy metal base and smooth-rolling wheels, it offers both stability and mobility. Whether you\'re working from home or in a corporate setting, this chair combines luxury, comfort, and functionality to enhance productivity.\r\n\r\n💡 Key Features:\r\n✔ Premium PU leather with a sleek finish\r\n✔ Adjustable height & reclining feature\r\n✔ Ergonomic design with lumbar & headrest support\r\n✔ 360° swivel & smooth-rolling wheels\r\n✔ Ideal for office, home, and gaming setups\r\n\r\n✅ Order now and enjoy ultimate comfort at your desk!', 5, 'active', 'uploads/993034725_default-10.jpg', 'uploads/422003243_default-10.jpg', 'uploads/282023853_default-10.jpg', 'uploads/817699853_default-10.jpg', NULL, NULL);

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `products_demo`
--
ALTER TABLE `products_demo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products_demo`
--
ALTER TABLE `products_demo`
  ADD CONSTRAINT `products_demo_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
