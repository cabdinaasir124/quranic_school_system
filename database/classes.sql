-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2025 at 11:43 PM
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
-- Database: `quranic_school`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `class_name` varchar(100) DEFAULT NULL,
  `class_code` varchar(20) DEFAULT NULL,
  `class_type` enum('Hifz','Tajweed','Reading','Academic','Duco','Hadith','Mixed') DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `max_students` int(11) DEFAULT NULL,
  `gender` enum('Male','Female','Mixed') DEFAULT NULL,
  `time_slot` varchar(50) DEFAULT NULL,
  `days_active` varchar(100) DEFAULT NULL,
  `room` varchar(50) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `class_name`, `class_code`, `class_type`, `level`, `teacher_id`, `max_students`, `gender`, `time_slot`, `days_active`, `room`, `status`) VALUES
(35, 'hifdi', 'CL-001', 'Hifz', 'beginner', 4, 27, 'Male', '01:14-00:19', 'Saturday,Sunday,Monday,Tuesday', 'room4', 'Active'),
(37, 'classA', 'CL-002', 'Hifz', 'beginner', 4, 35, 'Male', '00:16-17:16', 'Saturday,Sunday,Monday,Tuesday,Wednesday', 'banaanka', 'Active'),
(39, 'classB', 'CL-003', 'Hifz', 'beginner', 3, 36, 'Male', '05:24-05:24', 'Saturday,Sunday,Monday,Tuesday,Wednesday', 'roo5', 'Active'),
(40, 'classC', 'CL-004', 'Tajweed', 'intermadidate', 3, 30, 'Mixed', '00:28-12:28', 'Saturday,Sunday,Monday', '6', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `class_code` (`class_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
