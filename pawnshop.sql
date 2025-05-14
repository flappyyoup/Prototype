-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2025 at 05:46 AM
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
-- Database: `pawnshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile_number` varchar(15) NOT NULL,
  `birth_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `mobile_number`, `birth_date`, `created_at`) VALUES
(1, 'Jed Ismael Polong', 'polong@gmail.com', '$2y$10$couOuzSRwkFA5.lUxD1X/OWgM.hd5QTMMev1bOYRbIijBIJqKw1i6', '09292222834', '2003-10-26', '2025-05-10 09:38:57'),
(3, 'Jed', 'coco@gmail.com', '$2y$10$a.gcOVZq6Jif75GkPwAKE.nAjEhW9TuwyCU5M97/R/MOkoQVO/syW', '123456', '2025-05-30', '2025-05-10 09:52:08'),
(4, 'kevin', 'kevin@gmail.com', '$2y$10$QGFAdzHzZ0q6To.IqIjarugrvEqvZ6LpQUiol/crwipc/4hEL1oHu', '123456789', '2025-05-02', '2025-05-10 09:54:34'),
(5, 'Cyrel Bucad', 'bucadcyrel@gmail.com', '$2y$10$6tMgrNqguA3Xf2kmeHNMYu0FKBM7uwmip12TFB99XkW6qPng2JVye', '09123456789', '2003-06-29', '2025-05-14 02:57:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
