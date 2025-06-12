-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2025 at 11:54 AM
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
-- Database: `street_care`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `message`, `created_at`) VALUES
(1, 4, 'its good', '2025-03-26 09:38:28'),
(2, 4, 'doesnt clean', '2025-03-26 10:01:52'),
(3, 4, 'washeddd', '2025-03-27 04:39:01'),
(4, 4, 'qwerty', '2025-03-29 06:51:17'),
(5, 4, 'clea hostel', '2025-04-03 10:11:12');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `status` enum('pending','in-progress','completed') DEFAULT 'pending',
  `before_photo` varchar(255) DEFAULT NULL,
  `after_photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `assigned_to`, `status`, `before_photo`, `after_photo`, `created_at`) VALUES
(1, 'abc', 'cleaning', 3, 'pending', '../uploads/1742981563_before_1111.jpeg', '../uploads/1742981563_after_2222.jpeg', '2025-03-26 09:27:26'),
(2, 'clean', 'cleaning', 3, 'completed', '../uploads/1742983288_before_1111.jpeg', '../uploads/1742983288_after_2222.jpeg', '2025-03-26 10:00:25'),
(3, 'washing', 'wash', 3, 'completed', '../uploads/1743050316_before_1111.jpeg', '../uploads/1743050316_after_2222.jpeg', '2025-03-27 04:37:48'),
(4, 'clean', 'washing', 3, 'completed', '../uploads/1743231044_before_1111.jpeg', '../uploads/1743231044_after_2222.jpeg', '2025-03-29 06:49:58'),
(5, 'clean', 'street number 23', 3, 'in-progress', NULL, NULL, '2025-03-29 06:54:27'),
(6, 'clean', 'clean', 3, 'pending', NULL, NULL, '2025-03-30 13:41:57'),
(7, 'report complte', 'phase 1', 12, 'pending', NULL, NULL, '2025-04-03 06:15:43'),
(8, 'clean', 'clweaminghghg', 14, 'completed', '../uploads/1743675046_before_1111.jpeg', '../uploads/1743675046_after_2222.jpeg', '2025-04-03 10:09:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','worker','resident') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'aaa', 'a@gmail.com', '$2y$10$iVJf4/Obf/O/onqVqfTCQuPUz5.htAoM/LfV.tLUt/wE3eyzkHqKO', 'admin', '2025-03-26 09:04:13'),
(3, 'aa', 'aa@gmail.com', '$2y$10$bJRfw6s0TYtyLefeNnrqguuR2y/Ky1rnRb8Fb/bbSwiVYL7H71zdW', 'worker', '2025-03-26 09:24:16'),
(4, 'res', 'res@gmail.com', '$2y$10$73jP.mAe0yM4DkwfkbrlXu27TU.U8IBn7Exb2usAzgljMV4KOhq5a', 'resident', '2025-03-26 09:33:41'),
(5, 'adm', 'adm@gmail.com', '$2y$10$L5mV47ikZimhkkhogJMVGuDJ6Z1vOe1GCvYWEuEXG/X/KTwzhJwhy', 'admin', '2025-03-26 09:59:58'),
(6, 'harshi', 'harshi@gmail.com', '$2y$10$MrqSyCjfPjbnt2vEf15F2u.quhcW4epgMrMDnO56ANqBLtUVL10ke', 'admin', '2025-03-29 06:49:08'),
(7, 'mamatha N B', 'M@gmail.com', '$2y$10$ZYEcClDJxgKGsMYy1YilxuieusNDRpOfCHebZM1CVl7NnZIbL2ioO', 'worker', '2025-03-29 06:57:58'),
(8, 'akila', 'ak@gmail.com', '$2y$10$0Bid87my880vJ80ZF7MZbebbjiLF6MUcfHuN/xv5wYSv2TdfvGo2K', 'worker', '2025-03-29 06:58:39'),
(9, 'adarsh', 'sh@gmail.com', '$2y$10$i/.5utNSOnVJkfSl3AtuJ.hqpJuhLKUd0XQnNrGK/s6c.pLx7FR76', 'worker', '2025-03-29 06:59:24'),
(10, 'dhanu', 'dh@gmail.com', '$2y$10$KGGgRkkHKCMl2OHq9cfvU.2cTsU8AbbFSFVe3A77wcHvQo45yTI4e', 'admin', '2025-03-29 07:00:22'),
(11, 'bharat', 'b@gmail.com', '$2y$10$Y7b2OF/a1RNY/UvefXlANuWGM3sW5NepKBGNogp8ghA6OYbpIlaFy', 'admin', '2025-03-30 13:41:36'),
(12, 'mamatha N B', 'mam@gmail.com', '$2y$10$j80Y.IlC4TnTuTvWhxIxbuT9gH1SJlbHMM50fLTbbccZiKwhtPRjy', 'worker', '2025-04-03 06:14:33'),
(13, 'peddu', 'peddu@gmail.com', '$2y$10$17Q7b81Qec4neNSj.45iy.k8chVXDxqNCNyNK2kICi9kaZ..vEArW', 'worker', '2025-04-03 06:21:52'),
(14, 'abc', 'abc@gmail.com', '$2y$10$CfTNPePXXw73vWGrMfSFke9esIpt6so4m8VroVnr0lpqo1Q8bx0H6', 'worker', '2025-04-03 06:24:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
