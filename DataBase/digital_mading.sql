-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 05, 2026 at 05:47 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `digital_mading`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id_announcement` int NOT NULL,
  `id_instansi` int DEFAULT NULL,
  `id_user` int NOT NULL,
  `id_category` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `poster_path` varchar(255) NOT NULL,
  `date_expired` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `views` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id_announcement`, `id_instansi`, `id_user`, `id_category`, `title`, `deskripsi`, `poster_path`, `date_expired`, `created_at`, `views`) VALUES
(7, 1, 1, 1, 'b  fvfd', 'fdvfv', 'Screenshot (1).png', '2026-07-15', '2026-06-01 14:44:44', 2),
(8, 2, 1, 1, 'hvghvhgb', ' b b ghvgvgh', 'Screenshot (2).png', '2026-07-15', '2026-06-01 14:45:51', 1),
(9, 5, 1, 2, 'fdvfd', 'ccefcfef', 'Screenshot (3).png', '2026-07-15', '2026-06-01 15:45:35', 8),
(13, 1, 1, 2, 'lomba', 'Untuk seluruh mahasiswa uhn', 'Screenshot 2026-06-11 154341.png', '2026-07-15', '2026-06-12 10:27:42', 0),
(14, 1, 1, 2, 'lomba', 'untuk seluruh mahasiswa', '19a4a45de454f23f95844c64d645e12f.png', '2026-07-15', '2026-06-12 10:33:52', 2),
(16, 4, 1, 1, 'fvfvfdvfdvfd', 'fvsvfdvf', '5375b46267da554a8329cb1f9287a2b9.png', '2026-11-05', '2026-11-04 14:48:23', 0),
(17, 1, 9, 1, 'seminar inter', 'fdfvdfvfdvfd', 'f6f0962523cac3730192ce0dd0ef5548.png', '2026-11-06', '2026-11-05 02:27:21', 3),
(18, 2, 1, 1, 'fsvsfvsfv', 'ssvdsdvsdv', '468d63d6d19e9a44ff6d8e848cd5ac02.jpeg', '2026-11-14', '2026-11-05 03:49:42', 0),
(19, 2, 1, 3, 'sdcdsdccd', 'dscdscsdd', '26cd6f0d0ef6579c318cbbe751191e65.png', '2026-11-27', '2026-11-05 03:50:10', 0),
(20, 3, 1, 4, 'dcsdcwdwe', 'dcsdcsdcds', '316569c404de0dccfade7c44aca6b919.jpeg', '2026-11-20', '2026-11-05 03:50:54', 0),
(21, 1, 1, 2, 'cdsdceffdsc', 'dcsdcsdc', '375536d5316174958e7755db953626cd.jpeg', '2026-11-17', '2026-11-05 03:52:08', 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id_category` int NOT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id_category`, `nama_kategori`) VALUES
(1, 'Seminar'),
(2, 'Lomba'),
(3, 'Beasiswa'),
(4, 'kof');

-- --------------------------------------------------------

--
-- Table structure for table `fakultas`
--

CREATE TABLE `fakultas` (
  `id_fakultas` int NOT NULL,
  `nama_fakultas` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fakultas`
--

INSERT INTO `fakultas` (`id_fakultas`, `nama_fakultas`) VALUES
(1, 'Fakultas Dharma Acarya'),
(2, 'Fakultas Brahma Widya'),
(3, 'saintek'),
(4, 'Fakultas Dharama Acarya'),
(5, 'uhn'),
(6, 'informatika');

-- --------------------------------------------------------

--
-- Table structure for table `instansi`
--

CREATE TABLE `instansi` (
  `id_instansi` int NOT NULL,
  `nama_instansi` varchar(100) NOT NULL,
  `kategori_tingkat` enum('Universitas','Fakultas') NOT NULL,
  `id_fakultas` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `instansi`
--

INSERT INTO `instansi` (`id_instansi`, `nama_instansi`, `kategori_tingkat`, `id_fakultas`) VALUES
(1, 'BEM Universitas', 'Universitas', NULL),
(2, 'BEM Dharma Acarya', 'Fakultas', 1),
(3, 'gvghvh', 'Universitas', NULL),
(4, 'dpm ', 'Universitas', NULL),
(5, 'ukm olahraga', 'Universitas', NULL),
(6, 'BEM Universitas', 'Universitas', NULL),
(7, 'dpm', 'Fakultas', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `id_instansi` int DEFAULT NULL,
  `role` enum('Superadmin','Admin','Mahasiswa') DEFAULT 'Mahasiswa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `nama_lengkap`, `id_instansi`, `role`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70', 'Admin Pusat UHN', NULL, 'Superadmin'),
(8, 'admin', '$2y$10$1hdQcmWuExs9I/dI50QZPuT5SG25.Yhx3RppaUfHWd75SizIVA0KG', 'Desta', 1, 'Admin'),
(9, 'Admin BEM', '$2y$10$Ta6ANlAzRV/e5VURoPSsY.oE10ZZGEeJbwAI.2s06MIaYROFSroIe', 'Desta Eralngga', 1, 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id_announcement`),
  ADD KEY `id_instansi` (`id_instansi`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_category` (`id_category`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_category`);

--
-- Indexes for table `fakultas`
--
ALTER TABLE `fakultas`
  ADD PRIMARY KEY (`id_fakultas`);

--
-- Indexes for table `instansi`
--
ALTER TABLE `instansi`
  ADD PRIMARY KEY (`id_instansi`),
  ADD KEY `id_fakultas` (`id_fakultas`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `fk_user_instansi` (`id_instansi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id_announcement` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id_category` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fakultas`
--
ALTER TABLE `fakultas`
  MODIFY `id_fakultas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `instansi`
--
ALTER TABLE `instansi`
  MODIFY `id_instansi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`id_instansi`) REFERENCES `instansi` (`id_instansi`) ON DELETE CASCADE,
  ADD CONSTRAINT `announcements_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `announcements_ibfk_3` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id_category`) ON DELETE CASCADE;

--
-- Constraints for table `instansi`
--
ALTER TABLE `instansi`
  ADD CONSTRAINT `instansi_ibfk_1` FOREIGN KEY (`id_fakultas`) REFERENCES `fakultas` (`id_fakultas`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_instansi` FOREIGN KEY (`id_instansi`) REFERENCES `instansi` (`id_instansi`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
