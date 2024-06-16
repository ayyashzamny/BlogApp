-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308:3008
-- Generation Time: Jun 16, 2024 at 09:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blogger_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(160) NOT NULL,
  `content` varchar(500) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `content`, `created_at`, `updated_at`) VALUES
(4, 4, 'zaa', 'sddcs vddd', '2024-06-16 00:00:00', '2024-06-16 00:00:00'),
(5, 4, 'an other ', ' vdfs vdds', '2024-06-16 00:00:00', '2024-06-16 00:00:00'),
(8, 2, 'New', 'deletion test', '2024-06-16 00:00:00', '2024-06-16 00:00:00'),
(12, 1, 'ds', 'vs', '2024-06-16 20:55:20', '2024-06-16 20:55:20'),
(13, 1, 'cdvf', 'new tii ihhasdodh ', '2024-06-16 20:55:48', '2024-06-16 21:03:59');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(160) NOT NULL,
  `email` varchar(160) NOT NULL,
  `password` varchar(160) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`) VALUES
(1, 'ayyash', 'ayyash@g.c', '$2y$10$Po5pDfc9SFedFLFnrslNdOd5yOU0I7hhurfzjEYuSwliKyyUx9e.e'),
(2, 'ay', 'ay@H.L', '$2y$10$zSu/i.HEsnEVkzhqJWoxhe4JcbT/230ESP1cYxNeb5fUNz1UPC.Oi'),
(3, 'ayy', 'ayy@g.l', '$2y$10$89oSIr7qWlM2c2aedjMmEOsmymvdHvdfPvLIVnWP/qR3klU8/4O4a'),
(4, 'zaa', 'zaa@j.l', '$2y$10$r9nQHgDaa0fRXFFqbnwY2umvULqvwgBIXtRIJJPc23miKz8o66Oz6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKuserID` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `FKuserID` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
