-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2023 at 11:21 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo_mvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `delete_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `name`, `description`, `content`, `created_at`, `delete_date`) VALUES
(1, 'bao la cai', 'mo ta bao la cai', 'noi dung bao la cai', '2023-10-10 15:14:57', '2023-10-15 10:05:53'),
(2, 'bao tien phong', 'mo ta bao tien phong', 'noi dung bao tien phong', '2023-10-10 15:17:16', NULL),
(4, 'iphone 16 ra mắt', 'mota iphone 16', 'nọi dung iphone 16', '2023-10-13 06:44:54', NULL),
(5, 't3h tuyển sinh', 'Mô tả tuyển sinh', 'Nội dung tuyển sinh', '2023-10-13 07:38:38', NULL),
(6, 't3h family', 'moo ta t3h family', 'noi dung t3h family\r\n', '2023-10-15 08:00:24', NULL),
(7, 'k36dl', 'Mota k36dl', 'Noi dung k36dl', '2023-10-15 10:02:00', NULL),
(8, 'k36Dh', 'mo ta k36dh', 'noi dung k36dh\r\n', '2023-10-15 10:08:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `code` varchar(32) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `delete_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `code`, `description`, `price`, `delete_date`) VALUES
(1, 'samsung A20', 'ssa1234567', 'white, blue,...', 12000000, '2023-10-15 10:03:20'),
(2, 'iphone 12 promax', 'i12pm', 'Blue, 3 eyes,...', 18899000, NULL),
(4, 'iphone 12 ', 'i12', 'Blue, 3 eyes,...', 12899000, NULL),
(6, '8699000', '8699000', '8699000', 8699000, '2023-10-15 11:01:28'),
(7, 'iphone xsmax', 'ixsm', 'gold, ...', 55000000, '2023-10-12 13:10:45'),
(8, 'iphone xsmax', 'ixsm', 'gold, ...', 9999000, '2023-10-12 13:10:47'),
(9, 'iphone 8', 'i8', 'white,..', 6000000, '2023-10-12 13:38:56'),
(10, 'iphone 8 plus', 'i8p', 'white,...', 9999000, NULL),
(11, 'iphone 16 pro', 'i16p', 'white, 3eyes, rich, expensive,...', 120000000, NULL),
(12, 'samsung A21', 'ssa21', 'Blue, 3 eyes,...', 8699000, NULL),
(13, 'xiaomi  note6', 'xn6', 'blue, cheap,...', 3999000, NULL),
(14, 'samsung galaxii s21 ultra', 'ssgs21u', 'white, zoom x50, ....', 12000000, NULL),
(15, 'samsung flop z4', 'ssfz4', 'gap,....', 15555000, NULL),
(16, 'redmi note9 pro', 'sn9p', 'yellow, 1 eyes, .....', 8699000, '2023-10-15 11:01:36'),
(17, 'redmi note9 pro11', 'ixsm23', 'Blue, 3 eyes,...', 10000000, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(64) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `is_admin` int(11) DEFAULT NULL,
  `delete_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `is_admin`, `delete_date`) VALUES
(1, 'tung', 'tung@edu.com', '92c75a447b4febfedde6b92db8191718', 1, NULL),
(2, 'admin', 'admin@edu.com', '92c75a447b4febfedde6b92db8191718', 1, NULL),
(3, 'hoang', 'hoang@edu.com', '11111111', NULL, NULL),
(9, 'anh', 'anh@edu.com', '8e6a5100f09253b2c4d9de5cf2af556e', 1, NULL),
(13, 'kien', 'kien@gmail.com', '1111111111', 0, NULL),
(14, 'giang', 'giang@edu.com', 'a0545a515f99d98ba1f26ec70128c2c3', 0, NULL),
(15, 'manh', 'manh@edu.com', '92c75a447b4febfedde6b92db8191718', 0, NULL),
(16, 'cuong', 'cuong@edu.com', '92c75a447b4febfedde6b92db8191718', 0, NULL),
(17, 'an', 'an@edu.com', '11111111', NULL, '2023-10-16 09:21:34'),
(18, 'viet', 'viet2edu.com', '11111', NULL, '2023-10-16 09:21:27'),
(19, 'quang', 'quang@edu.com', '111', NULL, NULL),
(20, 'quan', 'quan@edu.com', '11111111', NULL, NULL),
(22, 'nam', 'nam@edu.com', '11111111', NULL, NULL),
(24, 'admin2', 'admin2@gmail.com', '11111111', NULL, '2023-10-15 09:57:54'),
(25, 'admin3', 'admin3@edu.com', '1111111', 1, NULL),
(26, 'haha', 'hahahahah', '1111', NULL, '2023-10-16 09:21:23'),
(27, 'admin4', 'admin4@gmail.com', '111111111', 1, NULL),
(29, 'luat', 'luat@edt.com', '111111111', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
