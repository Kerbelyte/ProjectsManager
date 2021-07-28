-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 15, 2021 at 10:48 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projects`
--
CREATE DATABASE IF NOT EXISTS `projects` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `projects`;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`) VALUES
(2, 'Haris'),
(3, 'Pepė'),
(6, 'Dartas'),
(21, 'Bitė'),
(22, 'Merė'),
(23, 'Dovilė');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`) VALUES
(1, 'PHP kursai'),
(4, 'REACT kursai'),
(5, '.NET kursai'),
(10, 'JAVASCRIPT kursai'),
(28, 'JAVA kursai'),
(36, 'C# kursai');

-- --------------------------------------------------------

--
-- Table structure for table `projects_employees`
--

CREATE TABLE `projects_employees` (
  `id_projects` int(11) DEFAULT NULL,
  `id_employees` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects_employees`
--

INSERT INTO `projects_employees` (`id_projects`, `id_employees`) VALUES
(1, 2),
(1, 3),
(1, 21),
(4, 22),
(28, 6),
(36, 23);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects_employees`
--
ALTER TABLE `projects_employees`
  ADD UNIQUE KEY `id_projects` (`id_projects`,`id_employees`),
  ADD KEY `projects_id_idx` (`id_projects`),
  ADD KEY `employees_id_idx` (`id_employees`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `projects_employees`
--
ALTER TABLE `projects_employees`
  ADD CONSTRAINT `employees_id` FOREIGN KEY (`id_employees`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `projects_id` FOREIGN KEY (`id_projects`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
