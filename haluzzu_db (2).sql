-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2025 at 04:33 PM
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
-- Database: `haluzzu_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `campus_location` varchar(100) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `agent_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `studio_location` varchar(255) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`agent_id`, `user_id`, `business_name`, `studio_location`, `state`) VALUES
(14, 14, 'Admin Official', 'Kuala Lumpur', 'Wilayah Persekutuan Kuala Lumpur'),
(101, 1, 'Ali Realty', 'Kuala Lumpur', 'Wilayah Persekutuan Kuala Lumpur'),
(102, 2, 'Ibrahim Estates', 'Petaling Jaya', 'Selangor'),
(103, 3, 'Ah Kow Properties', 'Penang', 'Pulau Pinang'),
(104, 4, 'Mei Ling Realty', 'Johor Bahru', 'Johor'),
(105, 5, 'Kumar Agencies', 'Kuala Lumpur', 'Wilayah Persekutuan Kuala Lumpur'),
(106, 6, 'Ramasamy Realty', 'Ipoh', 'Perak'),
(107, 7, 'Azlan Properties', 'Kota Kinabalu', 'Sabah'),
(108, 8, 'Li Na Real Estate', 'Melaka', 'Melaka'),
(109, 9, 'Reddy Realty', 'Kuantan', 'Pahang'),
(110, 10, 'Wai Ming Realty', 'Shah Alam', 'Selangor'),
(111, 11, 'Sunny Studios', 'Alor Setar', 'Kedah'),
(112, 12, 'Zenith Properti 22', 'Kucing', 'Sarawak'),
(113, 13, 'Metro Homes', 'Kota Bharu', 'Kelantan');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(30) NOT NULL,
  `student_id` int(11) NOT NULL,
  `studio_id` int(11) DEFAULT NULL,
  `booking_date` date NOT NULL,
  `duration` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('pending','confirmed','canceled') DEFAULT 'pending',
  `total_price` decimal(10,2) NOT NULL,
  `payment_status` enum('paid','unpaid') DEFAULT 'unpaid',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `student_id`, `studio_id`, `booking_date`, `duration`, `start_date`, `end_date`, `status`, `total_price`, `payment_status`, `created_at`, `updated_at`) VALUES
(500, 100, 1, '2024-09-23', 2, '2024-11-05', '2024-11-05', 'confirmed', 150.00, 'paid', '2024-09-23 06:54:29', '2024-09-23 06:54:29'),
(501, 101, 1, '2024-09-24', 2, '2024-11-05', '2024-11-05', 'pending', 200.00, 'unpaid', '2024-09-23 06:54:29', '2024-09-23 06:54:29'),
(504, 104, 3, '2024-09-27', 2, '2024-11-05', '2024-11-05', 'confirmed', 150.00, 'paid', '2024-09-23 06:54:29', '2024-09-23 06:54:29'),
(505, 105, 3, '2024-09-28', 1, '2024-11-05', '2024-11-05', 'pending', 250.00, 'unpaid', '2024-09-23 06:54:29', '2024-09-23 06:54:29'),
(506, 106, 4, '2024-09-29', 2, '2024-11-05', '2024-11-05', 'confirmed', 200.00, 'paid', '2024-09-23 06:54:29', '2024-09-23 06:54:29'),
(507, 107, 4, '2024-09-30', 1, '2024-11-05', '2024-11-05', 'pending', 100.00, 'unpaid', '2024-09-23 06:54:29', '2024-09-23 06:54:29'),
(508, 108, 5, '2024-10-01', 3, '2024-11-05', '2024-11-05', 'confirmed', 180.00, 'paid', '2024-09-23 06:54:29', '2024-09-23 06:54:29'),
(509, 109, 5, '2024-10-02', 2, '2024-11-05', '2024-11-05', 'canceled', 220.00, 'unpaid', '2024-09-23 06:54:29', '2024-09-23 06:54:29'),
(510, 110, 1, '2024-09-23', 2, '2024-11-05', '2024-11-05', 'confirmed', 150.00, 'paid', '2024-09-23 07:54:06', '2024-09-23 07:54:06'),
(511, 111, 1, '2024-09-24', 1, '2024-11-05', '2024-11-05', 'confirmed', 200.00, 'paid', '2024-09-23 07:54:06', '2024-09-23 07:54:06'),
(512, 112, 2, '2024-09-25', 1, '2024-11-05', '2024-11-05', 'confirmed', 100.00, 'paid', '2024-09-23 07:54:06', '2024-09-23 07:54:06'),
(513, 113, 2, '2024-09-26', 3, '2024-11-05', '2024-12-31', 'confirmed', 300.00, 'paid', '2024-09-23 07:54:06', '2024-11-11 02:18:13'),
(514, 114, 3, '2024-09-27', 2, '2024-11-05', '2024-11-05', 'confirmed', 150.00, 'paid', '2024-09-23 07:54:06', '2024-09-23 07:54:06'),
(515, 115, 3, '2024-09-28', 1, '2024-11-05', '2024-11-05', 'confirmed', 250.00, 'paid', '2024-09-23 07:54:06', '2024-09-23 07:54:06'),
(516, 116, 4, '2024-09-29', 2, '2024-11-05', '2024-11-05', 'confirmed', 200.00, 'paid', '2024-09-23 07:54:06', '2024-09-23 07:54:06'),
(518, 118, 5, '2024-10-01', 3, '2024-11-05', '2024-11-05', 'confirmed', 180.00, 'paid', '2024-09-23 07:54:06', '2024-09-23 07:54:06'),
(519, 119, 5, '2024-10-02', 2, '2024-11-05', '2024-11-05', 'confirmed', 220.00, 'paid', '2024-09-23 07:54:06', '2024-09-23 07:54:06'),
(520, 120, 6, '2024-10-03', 1, '2024-11-05', '2024-11-05', 'confirmed', 190.00, 'paid', '2024-09-23 07:54:06', '2024-09-23 07:54:06'),
(521, 121, 6, '2024-10-04', 2, '2024-11-05', '2024-11-05', 'confirmed', 210.00, 'paid', '2024-09-23 07:54:06', '2024-09-23 07:54:06'),
(522, 122, 7, '2024-10-05', 3, '2024-11-05', '2024-11-05', 'confirmed', 220.00, 'paid', '2024-09-23 07:54:06', '2024-09-23 07:54:06'),
(523, 123, 7, '2024-10-06', 1, '2024-11-05', '2024-11-05', 'confirmed', 230.00, 'paid', '2024-09-23 07:54:06', '2024-09-23 07:54:06'),
(524, 124, 8, '2024-10-07', 2, '2024-11-05', '2024-11-05', 'confirmed', 160.00, 'paid', '2024-09-23 07:54:06', '2024-09-23 07:54:06'),
(525, 125, 8, '2024-10-08', 3, '2024-11-05', '2024-11-05', 'confirmed', 170.00, 'paid', '2024-09-23 07:54:06', '2024-09-23 07:54:06'),
(526, 126, 9, '2024-10-09', 1, '2024-11-05', '2024-11-05', 'confirmed', 140.00, 'paid', '2024-09-23 07:54:06', '2024-09-23 07:54:06'),
(527, 127, 9, '2024-10-10', 2, '2024-11-05', '2024-11-05', 'confirmed', 250.00, 'paid', '2024-09-23 07:54:06', '2024-09-23 07:54:06'),
(528, 128, 10, '2024-10-11', 3, '2024-11-05', '2024-11-05', 'confirmed', 300.00, 'paid', '2024-09-23 07:54:06', '2024-09-23 07:54:06'),
(529, 129, 10, '2024-10-12', 1, '2024-11-05', '2024-11-05', 'confirmed', 110.00, 'paid', '2024-09-23 07:54:06', '2024-09-23 07:54:06'),
(530, 100, 1, '2024-06-05', 2, '2024-11-05', '2024-11-05', 'confirmed', 150.00, 'paid', '2024-09-23 08:00:22', '2024-09-23 08:00:22'),
(532, 102, 3, '2024-07-10', 1, '2024-11-05', '2024-11-05', 'confirmed', 100.00, 'paid', '2024-09-23 08:00:22', '2024-09-23 08:00:22'),
(533, 103, 1, '2024-07-20', 3, '2024-11-05', '2024-11-05', 'confirmed', 300.00, 'paid', '2024-09-23 08:00:22', '2024-09-23 08:00:22'),
(534, 104, 2, '2024-08-05', 2, '2024-11-05', '2024-11-05', 'confirmed', 150.00, 'paid', '2024-09-23 08:00:22', '2024-09-23 08:00:22'),
(535, 105, 3, '2024-08-15', 1, '2024-11-05', '2024-11-05', 'confirmed', 250.00, 'paid', '2024-09-23 08:00:22', '2024-09-23 08:00:22'),
(536, 106, 1, '2024-06-25', 2, '2024-11-05', '2024-11-05', 'confirmed', 200.00, 'paid', '2024-09-23 08:00:22', '2024-09-23 08:00:22'),
(537, 107, 2, '2024-07-30', 1, '2024-11-05', '2024-11-05', 'confirmed', 100.00, 'paid', '2024-09-23 08:00:22', '2024-09-23 08:00:22'),
(538, 108, 3, '2024-08-10', 2, '2024-11-05', '2024-11-05', 'confirmed', 180.00, 'paid', '2024-09-23 08:00:22', '2024-09-23 08:00:22'),
(539, 109, 1, '2024-06-20', 3, '2024-11-05', '2024-11-05', 'confirmed', 220.00, 'paid', '2024-09-23 08:00:22', '2024-09-23 08:00:22'),
(540, 110, 2, '2024-07-25', 1, '2024-11-05', '2024-11-05', 'confirmed', 190.00, 'paid', '2024-09-23 08:00:22', '2024-09-23 08:00:22'),
(543, 131, 1, '2024-11-11', 1, '2025-06-11', '2025-06-12', 'confirmed', 1920.00, 'paid', '2024-11-11 02:43:11', '2024-11-11 02:43:11'),
(544, 131, 1, '2024-11-11', 1, '2025-02-11', '2025-02-12', 'confirmed', 1920.00, 'paid', '2024-11-11 02:45:23', '2024-11-11 02:45:23'),
(545, 131, 1, '2024-11-11', 1, '2025-03-12', '2025-03-13', 'confirmed', 1920.00, 'paid', '2024-11-11 02:46:13', '2024-11-11 02:46:13'),
(546, 131, 1, '2024-11-11', 1, '2026-02-12', '2026-02-13', 'confirmed', 1920.00, 'paid', '2024-11-11 02:46:56', '2024-11-11 02:46:56'),
(547, 131, 1, '2024-11-11', 1, '2026-05-12', '2026-05-13', 'confirmed', 1920.00, 'paid', '2024-11-11 03:01:40', '2024-11-11 03:01:40'),
(548, 131, 2, '2024-11-13', 1, '2026-01-01', '2026-01-02', 'confirmed', 1680.00, 'paid', '2024-11-13 01:55:32', '2024-11-13 01:55:32'),
(549, 131, 1, '2024-12-17', 1, '2024-12-18', '2024-12-19', 'confirmed', 1920.00, 'paid', '2024-12-17 03:22:28', '2024-12-17 03:22:28'),
(550, 131, 1, '2024-12-17', 1, '2025-11-18', '2025-11-19', 'confirmed', 1920.00, 'paid', '2024-12-17 03:36:57', '2024-12-17 03:36:57'),
(551, 131, 19, '2024-12-17', 1, '0000-00-00', '2024-12-18', 'confirmed', 1980.00, 'paid', '2024-12-17 03:37:58', '2024-12-17 03:37:58'),
(554, 131, 20, '2024-12-17', 1, '2024-12-17', '2024-12-18', 'confirmed', 1740.00, 'paid', '2024-12-17 03:39:43', '2024-12-17 03:39:43'),
(555, 131, 3, '2024-12-17', 1, '2024-12-17', '2024-12-18', 'confirmed', 2160.00, 'paid', '2024-12-17 03:42:27', '2024-12-17 03:42:27');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `coupon_id` int(11) NOT NULL,
  `coupon_code` varchar(50) NOT NULL,
  `discount_type` enum('percentage','fixed') NOT NULL DEFAULT 'fixed',
  `discount_value` decimal(10,2) NOT NULL,
  `usage_limit` int(11) DEFAULT 1,
  `used_count` int(11) DEFAULT 0,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`coupon_id`, `coupon_code`, `discount_type`, `discount_value`, `usage_limit`, `used_count`, `start_date`, `end_date`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'WELCOME100', 'percentage', 15.00, 100, 5, '2024-10-12', '2034-11-03', 1, '2024-09-30 11:02:58', '2024-11-04 13:42:14'),
(2, 'SAVE20', 'fixed', 20.00, 50, 10, '2024-09-15', '2024-11-30', 1, '2024-09-30 11:02:58', '2024-09-30 11:02:58'),
(3, 'FALL30', 'percentage', 30.00, 30, 0, '2024-10-01', '2024-12-14', 1, '2024-09-30 11:02:58', '2024-11-04 13:26:48');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `student_no` varchar(50) NOT NULL,
  `campus_location` varchar(100) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `user_id`, `student_no`, `campus_location`, `state`) VALUES
(100, 15, 'S001', 'Shah Alam', 'Selangor'),
(101, 16, 'S002', 'Shah Alam', 'Selangor'),
(102, 17, 'S003', 'Sg. Petani', 'Kedah'),
(103, 18, 'S004', 'Kota Bharu', 'Kelantan'),
(104, 19, 'S005', 'Penang', 'Penang'),
(105, 20, 'S006', 'Johor Bahru', 'Johor'),
(106, 21, 'S007', 'Kuala Lumpur', 'Wilayah Persekutuan'),
(107, 22, 'S008', 'Melaka', 'Melaka'),
(108, 23, 'S009', 'Ipoh', 'Perak'),
(109, 24, 'S010', 'Kota Kinabalu', 'Sabah'),
(110, 25, 'S101122', 'UITM Shah Alam 22', 'Selangor 22'),
(111, 26, 'S1012', 'UITM Penang', 'Penang'),
(112, 27, 'S1013', 'UITM Johor', 'Johor'),
(113, 28, 'S1014', 'UITM Melaka', 'Melaka'),
(114, 29, 'S1015', 'UITM Sarawak', 'Sarawak'),
(115, 30, 'S1016', 'UITM Perlis', 'Perlis'),
(116, 31, 'S1017', 'UITM Kedah', 'Kedah'),
(117, 32, 'S1018', 'UITM Kelantan', 'Kelantan'),
(118, 33, 'S1019', 'UITM Pahang', 'Pahang'),
(119, 34, 'S1020', 'UITM Terengganu', 'Terengganu'),
(120, 35, 'S1021', 'UITM Negeri Sembilan', 'Negeri Sembilan'),
(121, 36, 'S1022', 'UITM Sabah', 'Sabah'),
(122, 37, 'S1023', 'UITM Sarawak', 'Sarawak'),
(123, 38, 'S1024', 'UITM Kuala Lumpur', 'Kuala Lumpur'),
(124, 39, 'S1025', 'UITM Selangor', 'Selangor'),
(125, 40, 'S1026', 'UITM Johor', 'Johor'),
(126, 41, 'S1027', 'UITM Melaka', 'Melaka'),
(127, 42, 'S1028', 'UITM Penang', 'Penang'),
(128, 43, 'S1029', 'UITM Kedah', 'Kedah'),
(129, 44, 'S1030', 'UITM Kelantan', 'Kelantan'),
(130, 45, 'test_1', '', 'Perlis'),
(131, 46, 'test_1', 'UITM Shah Alam 22', 'Perlis'),
(132, 47, 'test_1', 'Arau', 'Perlis'),
(133, 48, 'naan123', 'Arau', 'Perlis'),
(134, 49, 'S101122', 'Arau', 'Perak');

-- --------------------------------------------------------

--
-- Table structure for table `studioimages`
--

CREATE TABLE `studioimages` (
  `image_id` int(11) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `studio_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studioimages`
--

INSERT INTO `studioimages` (`image_id`, `caption`, `studio_id`, `image_path`, `created_at`) VALUES
(1, 'Rooms', 1, 'cover12.jpg', '2024-09-18 11:28:01'),
(2, 'Rooms', 1, 'cover11.jpg', '2024-09-18 11:28:01'),
(3, 'Bathroom', 1, 'cover13.jpg', '2024-09-18 11:28:33'),
(4, 'Living Room', 1, 'cover14.jpg', '2024-09-18 11:28:33'),
(5, 'Room', 2, 'cover1.jpg', '2024-09-18 13:01:15'),
(6, 'Living Room', 2, 'cover8.jpg', '2024-09-18 13:01:15'),
(7, 'Bathroom', 2, 'cover14.jpg', '2024-09-18 13:01:15'),
(8, 'Kitchen', 2, 'cover17.jpg', '2024-09-18 13:01:15'),
(9, 'Room', 3, 'cover5.jpg', '2024-09-18 13:01:15'),
(10, 'Living Room', 3, 'cover19.jpg', '2024-09-18 13:01:15'),
(11, 'Bathroom', 3, 'cover2.jpg', '2024-09-18 13:01:15'),
(12, 'Kitchen', 3, 'cover10.jpg', '2024-09-18 13:01:15'),
(13, 'Room', 4, 'cover16.jpg', '2024-09-18 13:01:15'),
(14, 'Living Room', 4, 'cover4.jpg', '2024-09-18 13:01:15'),
(15, 'Bathroom', 4, 'cover11.jpg', '2024-09-18 13:01:15'),
(16, 'Kitchen', 4, 'cover18.jpg', '2024-09-18 13:01:15'),
(17, 'Room', 5, 'cover6.jpg', '2024-09-18 13:01:15'),
(18, 'Living Room', 5, 'cover12.jpg', '2024-09-18 13:01:15'),
(19, 'Bathroom', 5, 'cover1.jpg', '2024-09-18 13:01:15'),
(20, 'Kitchen', 5, 'cover15.jpg', '2024-09-18 13:01:15'),
(21, 'Room', 6, 'cover2.jpg', '2024-09-18 13:01:15'),
(22, 'Living Room', 6, 'cover20.jpg', '2024-09-18 13:01:15'),
(23, 'Bathroom', 6, 'cover3.jpg', '2024-09-18 13:01:15'),
(24, 'Kitchen', 6, 'cover7.jpg', '2024-09-18 13:01:15'),
(25, 'Room', 7, 'cover4.jpg', '2024-09-18 13:01:15'),
(26, 'Living Room', 7, 'cover6.jpg', '2024-09-18 13:01:15'),
(27, 'Bathroom', 7, 'cover9.jpg', '2024-09-18 13:01:15'),
(28, 'Kitchen', 7, 'cover11.jpg', '2024-09-18 13:01:15'),
(29, 'Room', 8, 'cover5.jpg', '2024-09-18 13:01:15'),
(30, 'Living Room', 8, 'cover8.jpg', '2024-09-18 13:01:15'),
(31, 'Bathroom', 8, 'cover14.jpg', '2024-09-18 13:01:15'),
(32, 'Kitchen', 8, 'cover13.jpg', '2024-09-18 13:01:15'),
(33, 'Room', 9, 'cover10.jpg', '2024-09-18 13:01:15'),
(34, 'Living Room', 9, 'cover15.jpg', '2024-09-18 13:01:15'),
(35, 'Bathroom', 9, 'cover18.jpg', '2024-09-18 13:01:15'),
(36, 'Kitchen', 9, 'cover19.jpg', '2024-09-18 13:01:15'),
(37, 'Room', 10, 'cover6.jpg', '2024-09-18 13:01:15'),
(38, 'Living Room', 10, 'cover17.jpg', '2024-09-18 13:01:15'),
(39, 'Bathroom', 10, 'cover12.jpg', '2024-09-18 13:01:15'),
(40, 'Kitchen', 10, 'cover3.jpg', '2024-09-18 13:01:15'),
(41, 'Room', 11, 'cover4.jpg', '2024-09-18 13:01:15'),
(42, 'Living Room', 11, 'cover9.jpg', '2024-09-18 13:01:15'),
(43, 'Bathroom', 11, 'cover13.jpg', '2024-09-18 13:01:15'),
(44, 'Kitchen', 11, 'cover16.jpg', '2024-09-18 13:01:15'),
(45, 'Room', 12, 'cover11.jpg', '2024-09-18 13:01:15'),
(46, 'Living Room', 12, 'cover1.jpg', '2024-09-18 13:01:15'),
(47, 'Bathroom', 12, 'cover20.jpg', '2024-09-18 13:01:15'),
(48, 'Kitchen', 12, 'cover5.jpg', '2024-09-18 13:01:15'),
(49, 'Room', 13, 'cover18.jpg', '2024-09-18 13:01:15'),
(50, 'Living Room', 13, 'cover7.jpg', '2024-09-18 13:01:15'),
(51, 'Bathroom', 13, 'cover6.jpg', '2024-09-18 13:01:15'),
(52, 'Kitchen', 13, 'cover2.jpg', '2024-09-18 13:01:15'),
(53, 'Room', 14, 'cover3.jpg', '2024-09-18 13:01:15'),
(54, 'Living Room', 14, 'cover10.jpg', '2024-09-18 13:01:15'),
(55, 'Bathroom', 14, 'cover8.jpg', '2024-09-18 13:01:15'),
(56, 'Kitchen', 14, 'cover15.jpg', '2024-09-18 13:01:15'),
(57, 'Room', 15, 'cover19.jpg', '2024-09-18 13:01:15'),
(58, 'Living Room', 15, 'cover17.jpg', '2024-09-18 13:01:15'),
(59, 'Bathroom', 15, 'cover14.jpg', '2024-09-18 13:01:15'),
(60, 'Kitchen', 15, 'cover16.jpg', '2024-09-18 13:01:15'),
(61, 'Room', 16, 'cover12.jpg', '2024-09-18 13:01:15'),
(62, 'Living Room', 16, 'cover8.jpg', '2024-09-18 13:01:15'),
(63, 'Bathroom', 16, 'cover7.jpg', '2024-09-18 13:01:15'),
(64, 'Kitchen', 16, 'cover9.jpg', '2024-09-18 13:01:15'),
(65, 'Room', 17, 'cover20.jpg', '2024-09-18 13:01:15'),
(66, 'Living Room', 17, 'cover4.jpg', '2024-09-18 13:01:15'),
(67, 'Bathroom', 17, 'cover13.jpg', '2024-09-18 13:01:15'),
(68, 'Kitchen', 17, 'cover15.jpg', '2024-09-18 13:01:15'),
(69, 'Room', 18, 'cover1.jpg', '2024-09-18 13:01:15'),
(70, 'Living Room', 18, 'cover11.jpg', '2024-09-18 13:01:15'),
(71, 'Bathroom', 18, 'cover6.jpg', '2024-09-18 13:01:15'),
(72, 'Kitchen', 18, 'cover2.jpg', '2024-09-18 13:01:15'),
(73, 'Room', 19, 'cover17.jpg', '2024-09-18 13:01:15'),
(74, 'Living Room', 19, 'cover16.jpg', '2024-09-18 13:01:15'),
(75, 'Bathroom', 19, 'cover10.jpg', '2024-09-18 13:01:15'),
(76, 'Kitchen', 19, 'cover9.jpg', '2024-09-18 13:01:15'),
(77, 'Room', 20, 'cover14.jpg', '2024-09-18 13:01:15'),
(78, 'Living Room', 20, 'cover5.jpg', '2024-09-18 13:01:15'),
(79, 'Bathroom', 20, 'cover19.jpg', '2024-09-18 13:01:15'),
(80, 'Kitchen', 20, 'cover12.jpg', '2024-09-18 13:01:15'),
(96, 'Image for studio TESTT', 29, 'studio_img_677e8f4d45cad9.39216665.png', '2025-01-08 14:44:29'),
(97, 'Image for studio TESTT', 29, 'studio_img_677e8f4d47f049.25567955.png', '2025-01-08 14:44:29'),
(98, 'Image for studio TESSTT 4 xxx', 30, 'studio_img_677e9252841d13.10343085.png', '2025-01-08 14:57:22'),
(99, 'Image for studio TESSTT 4 xxx', 30, 'studio_img_677e9252849810.53022670.jpeg', '2025-01-08 14:57:22'),
(100, 'Image for studio TESSTT 4 xxx', 30, 'studio_img_677e9252850777.54990492.png', '2025-01-08 14:57:22');

-- --------------------------------------------------------

--
-- Table structure for table `studios`
--

CREATE TABLE `studios` (
  `studio_id` int(11) NOT NULL,
  `studio_name` varchar(100) NOT NULL,
  `image_cover` varchar(700) NOT NULL,
  `location` varchar(255) NOT NULL,
  `state` varchar(50) NOT NULL,
  `capacity` int(11) NOT NULL,
  `facilities` text DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `original_monthly_rate` decimal(10,2) NOT NULL,
  `monthly_rate` decimal(10,2) NOT NULL,
  `availability_status` enum('available','under maintenance') DEFAULT 'available',
  `trending` int(5) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `address` varchar(255) DEFAULT NULL,
  `master_bedroom` int(11) DEFAULT 0,
  `regular_bedroom` int(11) DEFAULT 0,
  `small_bedroom` int(11) DEFAULT 0,
  `master_bath` int(11) DEFAULT 0,
  `regular_bath` int(11) DEFAULT 0,
  `small_bath` int(11) DEFAULT 0,
  `agent_id` int(50) DEFAULT NULL,
  `latitude` decimal(9,6) DEFAULT NULL,
  `longitude` decimal(9,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studios`
--

INSERT INTO `studios` (`studio_id`, `studio_name`, `image_cover`, `location`, `state`, `capacity`, `facilities`, `slug`, `type`, `description`, `original_monthly_rate`, `monthly_rate`, `availability_status`, `trending`, `created_at`, `updated_at`, `address`, `master_bedroom`, `regular_bedroom`, `small_bedroom`, `master_bath`, `regular_bath`, `small_bath`, `agent_id`, `latitude`, `longitude`) VALUES
(1, 'Seri Harmoni Studio', 'cover1.jpg', 'Kuala Lumpur', 'Wilayah Persekutuan', 4, 'Wi-Fi, Air Conditioning, Kitchenette, Washing Machine', 'seri-harmoni-studio', 'Apartment', 'Cozy studio with a modern design, ideal for students seeking comfort and convenience. Located close to campus with all necessary amenities.', 350.00, 320.00, 'available', 1, '2024-09-15 08:15:51', '2024-09-20 02:04:07', 'No. 15, Jalan Damai, Kuala Lumpur, Wilayah Persekutuan', 1, 1, 0, 1, 1, 0, 105, 3.139003, 101.686855),
(2, 'Vista Damai Residence', 'cover2.jpg', 'Shah Alam', 'Selangor', 2, 'Wi-Fi, Parking, Air Conditioning, Laundry Room', 'vista-damai-residence', 'Apartment', 'Bright and spacious studio with a city view. Features include a fully-equipped kitchen and easy access to local amenities and public transport.\n\nRare 1 bedroom unit in ara sentral condo first beautiful\nWelcome to Ara Sentral Condo - Where Convenience Meets Comfort!\n\nDiscover a modern living experience in our 1-bedroom, 1-bathroom condos, each boasting a spacious 550 sqft and comes with the convenience of 1 car park.\n\nKey Features:\n\nOnly condo with a Link Bridge directly to LRT Ara Damansara (just 98M away!)\nEvolve Concept Mall - less than 3 minutes away for all your shopping and entertainment needs', 300.00, 280.00, 'available', 1, '2024-09-15 08:15:51', '2024-09-20 02:04:07', 'No. 9, Jalan Titiwangsa, Shah Alam, Selangor', 1, 0, 1, 1, 0, 1, 102, 3.073837, 101.518347),
(3, 'Danga Bay Studio', 'cover3.jpg', 'Johor Bahru', 'Johor', 6, 'Wi-Fi, Swimming Pool, Gym, Parking', 'danga-bay-studio', 'Apartment', 'Elegant studio with contemporary furnishings. Perfect for students who value style and functionality, with plenty of natural light and a central location.', 360.00, 0.00, 'available', 0, '2024-09-15 08:15:51', '2024-09-20 02:04:07', 'No. 25, Jalan Danga Bay, Johor Bahru, Johor', 1, 1, 0, 1, 1, 0, 104, 1.492659, 103.741359),
(4, 'Gurney Heights Studio', 'cover4.jpg', 'George Town', 'Penang', 4, 'Wi-Fi, Kitchenette, Parking, 24-hour Security', 'gurney-heights-studio', 'Apartment', 'Affordable and practical studio, offering a comfortable living space with basic amenities. Located near the university, making it an excellent choice for students.', 400.00, 340.00, 'under maintenance', 0, '2024-09-15 08:15:51', '2024-09-20 02:04:07', 'No. 22, Jalan Gurney, George Town, Penang', 1, 0, 1, 1, 0, 1, 103, 5.414171, 100.328750),
(5, 'Ipoh City Apartments', 'cover5.jpg', 'Ipoh', 'Perak', 5, 'Wi-Fi, Air Conditioning, Kitchenette, Parking', 'ipoh-city-apartments', 'Apartment', 'Modern studio featuring a chic interior and high-quality fixtures. Close to shops and cafes, providing a vibrant and convenient living experience.', 400.00, 380.00, 'available', 0, '2024-09-15 08:15:51', '2024-09-20 02:04:07', 'No. 10, Jalan Permai, Ipoh, Perak', 1, 1, 1, 1, 1, 1, 106, 4.597479, 101.090106),
(6, 'Kota Kinabalu Suites', 'cover6.jpg', 'Kota Kinabalu', 'Sabah', 6, 'Wi-Fi, Sea View, Kitchenette, Balcony', 'kota-kinabalu-suites', 'Condominium', 'Spacious studio with a relaxing atmosphere. Ideal for students who prefer a tranquil environment, yet still want to be close to campus and local attractions.', 550.00, 480.00, 'available', 0, '2024-09-15 08:15:51', '2024-09-20 02:04:07', 'No. 45, Jalan Kota Kinabalu, Kota Kinabalu, Sabah', 2, 0, 1, 1, 0, 1, 107, 5.980408, 116.073457),
(7, 'Kuching Living Space', 'cover7.jpg', 'Kuching', 'Sarawak', 4, 'Wi-Fi, Parking, Kitchenette, 24-hour Security', 'kuching-living-space', 'Condominium', 'Newly renovated studio with a stylish design and upgraded amenities. Located in a prime area with easy access to both educational institutions and leisure spots.', 350.00, 0.00, 'available', 0, '2024-09-15 08:15:51', '2024-09-20 02:04:07', 'No. 8, Jalan Satok, Kuching, Sarawak', 1, 1, 1, 1, 1, 0, 112, 1.553392, 110.359252),
(8, 'Alor Setar Residence', 'cover8.jpg', 'Alor Setar', 'Kedah', 3, 'Wi-Fi, Kitchen, Air Conditioning, Parking', 'alor-setar-residence', 'Condominium', 'Compact yet comfortable studio with all essential features. Perfect for students on a budget who need a functional space near their studies.', 300.00, 250.00, 'available', 1, '2024-09-15 08:15:51', '2024-09-20 02:04:07', 'No. 5, Jalan Alor Setar, Alor Setar, Kedah', 1, 0, 1, 0, 1, 1, 111, 6.121435, 100.367775),
(9, 'Kuantan View Studio', 'cover9.jpg', 'Kuantan', 'Pahang', 4, 'Wi-Fi, Gym, Air Conditioning, Parking', 'kuantan-view-studio', 'Condominium', 'Charming studio with a warm and inviting ambiance. Equipped with modern conveniences and situated in a well-connected neighborhood.', 370.00, 320.00, 'available', 1, '2024-09-15 08:15:51', '2024-09-20 02:04:07', 'No. 20, Jalan Gambang, Kuantan, Pahang', 1, 1, 0, 1, 0, 1, 109, 3.814582, 103.323963),
(10, 'Melaka Central Apartments', 'cover10.jpg', 'Melaka', 'Melaka', 5, 'Wi-Fi, Air Conditioning, Kitchen, River View', 'melaka-central-apartments', 'Condominium', 'Luxury studio with upscale finishes and a modern layout. Located in a prestigious area with easy access to high-end dining and shopping.', 450.00, 400.00, 'available', 1, '2024-09-15 08:15:51', '2024-09-20 02:04:07', 'No. 30, Jalan Melaka Raya, Melaka, Melaka', 1, 1, 0, 1, 1, 1, 108, 2.189594, 102.250086),
(11, 'Sunrise Residences', 'cover11.jpg', 'Petaling Jaya', 'Selangor', 4, 'Wi-Fi, Swimming Pool, Air Conditioning, 24-hour Security, Sea View, River View, Kitchenette, Washing Machine, Parking, Gym, Balcony', 'sunrise-residences', 'Flat', 'Bright and airy studio with a spacious layout. Features include a large window, contemporary decor, and a convenient location close to public transport.', 330.00, 0.00, 'available', 0, '2024-09-15 08:16:29', '2024-10-23 13:44:23', 'Jalan SS3/33, Petaling Jaya, Selangor', 1, 1, 1, 1, 1, 0, 102, 3.107228, 101.606713),
(12, 'Harmony Heights', 'cover12.jpg', 'Kuala Lumpur', 'Wilayah Persekutuan Kuala Lumpur', 5, 'Wi-Fi, Swimming Pool, Kitchenette, Gym', 'harmony-heights', 'Flat', 'Stylish studio with a minimalistic design. Ideal for students who appreciate simplicity and functionality, located in a lively part of the city.', 420.00, 350.00, 'available', 0, '2024-09-15 08:16:29', '2024-09-30 10:34:11', 'No. 12, Jalan Seri Hartamas, Kuala Lumpur', 1, 0, 1, 0, 1, 1, 101, 3.139003, 101.686855),
(13, 'Tropicana Apartments', 'cover13.jpg', 'Subang Jaya', 'Selangor', 3, 'Wi-Fi, Air Conditioning, Kitchenette, Washing Machine, Parking', 'tropicana-apartments', 'Flat', 'Affordable studio with a cozy interior and essential amenities. Perfect for students seeking a comfortable and cost-effective living arrangement.', 330.00, 300.00, 'available', 0, '2024-09-15 08:16:29', '2024-10-23 13:30:09', 'Jalan Subang 22, Subang Jaya, Selangor', 1, 1, 0, 1, 1, 0, 102, 3.043933, 101.580657),
(14, 'Vista Perdana', 'cover14.jpg', 'Kota Bharu', 'Kelantan', 6, 'Wi-Fi, Swimming Pool, Parking, Air Conditioning', 'vista-perdana', 'Flat', 'Elegant and modern studio with a great view. Close to the university and local services, offering a blend of comfort and accessibility.', 450.00, 370.00, 'available', 1, '2024-09-15 08:16:29', '2024-09-20 02:04:07', 'No. 5, Jalan Kota Bharu, Kota Bharu, Kelantan', 1, 1, 1, 1, 0, 1, 113, 6.125430, 102.238094),
(15, 'Bayview Studio', 'cover15.jpg', 'Langkawi', 'Kedah', 4, 'Wi-Fi, Kitchenette, Beach Access, Parking', 'bayview-studio', 'Flat', 'Compact studio with a smart layout and practical features. Situated in a vibrant neighborhood with easy access to cafes and shops.', 310.00, 0.00, 'available', 0, '2024-09-15 08:16:29', '2024-09-20 02:04:07', 'Lot 1234, Pantai Cenang, Langkawi, Kedah', 2, 1, 0, 1, 1, 0, 111, 6.362778, 99.774556),
(16, 'Emerald Residence', 'cover16.jpg', 'Kuching', 'Sarawak', 5, 'Wi-Fi, Air Conditioning, Gym, Parking', 'emerald-residence', 'Semi-D', 'Well-furnished studio with a pleasant atmosphere. Located in a quiet area, ideal for students who need a peaceful study environment.', 420.00, 360.00, 'available', 0, '2024-09-15 08:16:29', '2024-09-20 02:04:07', 'No. 45, Jalan Bukit, Kuching, Sarawak', 1, 0, 1, 0, 1, 1, 112, 1.553392, 110.359252),
(17, 'Seri Maya Apartments', 'cover17.jpg', 'Malacca', 'Melaka', 2, 'Wi-Fi, Kitchenette, Air Conditioning', 'seri-maya-apartments', 'Semi-D', 'Contemporary studio with stylish furnishings and an open layout. Close to campus, making it an excellent choice for busy students.', 300.00, 240.00, 'available', 1, '2024-09-15 08:16:29', '2024-09-20 02:04:07', 'No. 10, Jalan Melaka Raya, Malacca, Melaka', 1, 1, 0, 1, 1, 0, 108, 2.189594, 102.250086),
(18, 'Grandview Studios', 'cover18.jpg', 'Kuantan', 'Pahang', 6, 'Wi-Fi, Swimming Pool, Gym, Air Conditioning', 'grandview-studios', 'Semi-D', 'Spacious studio with a modern touch. Includes a full kitchen and ample living space, perfect for students who enjoy having room to spread out.', 470.00, 450.00, 'available', 0, '2024-09-15 08:16:29', '2024-09-20 02:04:07', 'Jalan Besar, Kuantan, Pahang', 2, 1, 0, 1, 1, 1, 109, 3.814582, 103.323963),
(19, 'Northview Apartments', 'cover19.jpg', 'Alor Setar', 'Kedah', 4, 'Wi-Fi, Kitchenette, Air Conditioning, Parking', 'northview-apartments', 'Semi-D', 'Cozy studio with a warm and inviting design. Located near the university, offering a balance of comfort and convenience.', 400.00, 330.00, 'available', 0, '2024-09-15 08:16:29', '2024-09-20 02:04:07', 'No. 25, Jalan Alor Setar, Alor Setar, Kedah', 1, 0, 1, 1, 1, 0, 111, 6.121435, 100.367775),
(20, 'City Central Residences', 'cover20.jpg', 'George Town', 'Penang', 3, 'Wi-Fi, Air Conditioning, Laundry Room', 'city-central-residences', 'Semi-D', 'Functional studio with essential features and a convenient location. Ideal for students who need a practical living space close to their studies.', 350.00, 290.00, 'available', 1, '2024-09-15 08:16:29', '2024-09-20 02:04:07', 'No. 8, Jalan Tanjung Bungah, George Town, Penang', 1, 1, 0, 1, 1, 1, 103, 5.414171, 100.328750),
(29, 'TESTT', '', 'ipoh', 'Perak', 2, 'Wi-Fi', 'ipoh-studio', 'Apartment', 'aaaa', 4000.00, 3000.00, 'available', 0, '2025-01-08 14:44:29', '2025-01-08 14:49:30', 'aaa', 1, 1, 0, 0, 0, 0, 14, 4.597479, 101.090103),
(30, 'TESSTT 4 xxx', '', 'ipoh', 'Sarawak', 1, '24-hour Security', 'est-x', 'Apartment', 'asdasd', 3000.00, 3400.00, 'available', 0, '2025-01-08 14:57:22', '2025-01-08 14:57:22', 'asd', 1, 1, 0, 0, 0, 0, 14, 4.597479, 101.090103);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `image_profile` varchar(366) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `user_type` enum('student','agent','admin') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `image_profile`, `password`, `phone_number`, `user_type`, `created_at`, `updated_at`) VALUES
(1, 'Ahmad Bin Ali', 'ahmad.ali@example.com', 'agent1.jpg', 'password123', '+60123456789', 'agent', '2024-09-17 10:58:28', '2024-09-17 11:24:29'),
(2, 'Siti Aishah Binti Ibrahim', 'siti.ibrahim@example.com', 'mgirl1.jpg', 'password123', '+60123456780', 'agent', '2024-09-17 10:58:28', '2024-09-17 11:25:55'),
(3, 'Tan Ah Kow', 'tan.ahkow@example.com', 'agent2.jpg', 'password123', '+60123456781', 'agent', '2024-09-17 10:58:28', '2024-09-17 11:26:05'),
(4, 'Lim Mei Ling', 'lim.meiling@example.com', 'cgirl1.jpg', 'password123', '+60123456782', 'agent', '2024-09-17 10:58:28', '2024-09-17 11:33:37'),
(5, 'Raj Kumar', 'raj.kumar@example.com', 'indian1.jpg', 'password123', '+60123456783', 'agent', '2024-09-17 10:58:28', '2024-09-17 11:26:22'),
(6, 'Suresh Ramasamy', 'suresh.ramasamy@example.com', 'indian2.jpg', 'password123', '+60123456784', 'agent', '2024-09-17 10:58:28', '2024-09-17 11:26:29'),
(7, 'Mohd Azlan', 'mohd.azlan@example.com', 'agent4.jpg', 'password123', '+60123456785', 'agent', '2024-09-17 10:58:28', '2024-09-17 11:26:44'),
(8, 'Tan Li Na', 'tan.lina@example.com', 'agent5.jpg', 'password123', '+60123456786', 'agent', '2024-09-17 10:58:28', '2024-09-17 11:26:56'),
(9, 'Mohan Reddy', 'mohan.reddy@example.com', 'agent7.jpg', 'password123', '+60123456787', 'agent', '2024-09-17 10:58:28', '2024-09-17 11:27:11'),
(10, 'Chong Wai Ming', 'chong.waiming@example.com', 'cm1.jpg', 'password123', '+60123456788', 'agent', '2024-09-17 10:58:28', '2024-09-17 11:27:30'),
(11, 'Nizam Bin Najmi', 'nizam@example.com', 'agent3.jpg', 'password123', '+60123456789', 'agent', '2024-09-17 11:13:35', '2024-09-17 11:27:40'),
(12, 'Ammar Bin Abu22', 'ammar22@example.com', 'razer-logo.png', 'password123', '+6012345622', 'agent', '2024-09-17 11:13:35', '2024-09-30 09:32:05'),
(13, 'Lee Wong', 'lee.wongg@example.com', 'cm2.jpg', 'password123', '+60123456788', 'agent', '2024-09-17 11:13:35', '2024-09-17 11:28:07'),
(14, 'Super Admin', 'admin@gmail.com', 'agent2.jpg', 'admin123', '0123456789', 'admin', '2024-09-23 05:59:02', '2025-01-08 14:50:51'),
(15, 'John Doe', 'john.doe@example.com', '6711b8161dce7.png', 'hashed_password_1', '0123456789', 'student', '2024-09-23 06:43:51', '2024-10-18 01:21:26'),
(16, 'Jane Smith', 'jane.smith@example.com', NULL, 'hashed_password_2', '0123456790', 'student', '2024-09-23 06:43:51', '2024-09-23 06:43:51'),
(17, 'Ali Ahmad', 'ali.ahmad@example.com', NULL, 'hashed_password_3', '0123456791', 'student', '2024-09-23 06:43:51', '2024-09-23 06:43:51'),
(18, 'Sara Lee', 'sara.lee@example.com', NULL, 'hashed_password_4', '0123456792', 'student', '2024-09-23 06:43:51', '2024-09-23 06:43:51'),
(19, 'Michael Tan', 'michael.tan@example.com', NULL, 'hashed_password_5', '0123456793', 'student', '2024-09-23 06:43:51', '2024-09-23 06:43:51'),
(20, 'Linda Wong', 'linda.wong@example.com', NULL, 'hashed_password_6', '0123456794', 'student', '2024-09-23 06:43:51', '2024-09-23 06:43:51'),
(21, 'Kevin Lim', 'kevin.lim@example.com', NULL, 'hashed_password_7', '0123456795', 'student', '2024-09-23 06:43:51', '2024-09-23 06:43:51'),
(22, 'Fatimah Yusuf', 'fatimah.yusuf@example.com', NULL, 'hashed_password_8', '0123456796', 'student', '2024-09-23 06:43:51', '2024-09-23 06:43:51'),
(23, 'Hassan Omar', 'hassan.omar@example.com', NULL, 'hashed_password_9', '0123456797', 'student', '2024-09-23 06:43:51', '2024-09-23 06:43:51'),
(24, 'Nina Patel', 'nina.patel@example.com', NULL, 'hashed_password_10', '0123456798', 'student', '2024-09-23 06:43:51', '2024-09-23 06:43:51'),
(25, 'Alice Tan', 'alice.tan22@example.com', '66fa6e9cc48ad.jpg', '123', '0123456722', 'student', '2024-09-23 07:48:57', '2024-12-09 09:04:21'),
(26, 'Brian Lim', 'brian.lim@example.com', '6711b829162b9.png', 'hashedpassword2', '0123456788', 'student', '2024-09-23 07:48:57', '2024-10-18 01:21:45'),
(27, 'Chloe Ng', 'chloe.ng@example.com', NULL, 'hashedpassword3', '0123456787', 'student', '2024-09-23 07:48:57', '2024-09-25 11:21:06'),
(28, 'Daniel Wong', 'daniel.wong@example.com', '66fa892dee0aa.jpg', 'hashedpassword4', '0123456786', 'student', '2024-09-23 07:48:57', '2024-09-30 11:19:09'),
(29, 'Evelyn Lee', 'evelyn.lee@example.com', NULL, 'hashedpassword5', '0123456785', 'student', '2024-09-23 07:48:57', '2024-09-25 11:21:01'),
(30, 'Frank Chen', 'frank.chen@example.com', NULL, 'hashedpassword6', '0123456784', 'student', '2024-09-23 07:48:57', '2024-09-25 11:20:59'),
(31, 'Grace Ho', 'grace.ho@example.com', NULL, 'hashedpassword7', '0123456783', 'student', '2024-09-23 07:48:57', '2024-09-25 11:20:55'),
(32, 'Henry Lim', 'henry.lim@example.com', NULL, 'password123', '0123456782', 'student', '2024-09-23 07:48:57', '2024-11-01 14:50:20'),
(33, 'Irene Tan', 'irene.tan@example.com', NULL, 'hashedpassword9', '0123456781', 'student', '2024-09-23 07:48:57', '2024-09-25 11:20:50'),
(34, 'Jack Wong', 'jack.wong@example.com', NULL, 'hashedpassword10', '0123456780', 'student', '2024-09-23 07:48:57', '2024-09-25 11:20:48'),
(35, 'Kelly Ng', 'kelly.ng@example.com', NULL, 'hashedpassword11', '0123456790', 'student', '2024-09-23 07:48:57', '2024-09-25 11:20:45'),
(36, 'Leo Tan', 'leo.tan@example.com', NULL, 'hashedpassword12', '0123456791', 'student', '2024-09-23 07:48:57', '2024-09-25 11:20:35'),
(37, 'Mia Lee', 'mia.lee@example.com', NULL, 'hashedpassword13', '0123456792', 'student', '2024-09-23 07:48:57', '2024-09-25 11:20:38'),
(38, 'Nina Lim', 'nina.lim@example.com', NULL, 'hashedpassword14', '0123456793', 'student', '2024-09-23 07:48:57', '2024-09-25 11:20:40'),
(39, 'Oliver Chan', 'oliver.chan@example.com', NULL, 'hashedpassword15', '0123456794', 'student', '2024-09-23 07:48:57', '2024-09-25 11:20:43'),
(40, 'Paula Tan', 'paula.tan@example.com', NULL, 'hashedpassword16', '0123456795', 'student', '2024-09-23 07:48:57', '2024-09-25 11:20:25'),
(41, 'Quinn Lee', 'quinn.lee@example.com', NULL, 'hashedpassword17', '0123456796', 'student', '2024-09-23 07:48:57', '2024-09-25 11:20:20'),
(42, 'Raymond Ng', 'raymond.ng@example.com', NULL, 'hashedpassword18', '0123456797', 'student', '2024-09-23 07:48:57', '2024-09-25 11:20:17'),
(43, 'Sophia Wong', 'sophia.wong@example.com', NULL, 'hashedpassword19', '0123456798', 'student', '2024-09-23 07:48:57', '2024-09-25 11:20:14'),
(44, 'Tommy Lim', 'tommy.lim@example.com', NULL, 'hashedpassword20', '0123456799', 'student', '2024-09-23 07:48:57', '2024-09-25 11:20:23'),
(45, 'Test1', 'test@gmail.com', NULL, 'test123', '1234', 'student', '2024-11-01 14:00:10', '2024-11-01 14:00:10'),
(46, 'Test Dua', 'test2@gmail.com', '6747d3848d644.png', 'test123', '1234', 'student', '2024-11-01 14:01:13', '2024-11-28 02:20:52'),
(47, 'Test2', 'test3@gmail.com', NULL, 'test123', '1234', 'student', '2024-11-01 14:01:38', '2024-11-01 14:01:38'),
(48, 'nana', 'nana@gmail.com', NULL, 'nana123', '0123123', 'student', '2024-11-04 13:40:56', '2024-11-04 13:40:56'),
(49, 'nizam3@gmail.com', 'nizam3@gmail.com', NULL, 'test3', '0165043802', 'student', '2024-11-11 02:22:52', '2024-11-11 02:22:52');

-- --------------------------------------------------------

--
-- Table structure for table `user_coupons`
--

CREATE TABLE `user_coupons` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `redeemed` tinyint(1) DEFAULT 0,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `redeemed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_coupons`
--

INSERT INTO `user_coupons` (`id`, `user_id`, `coupon_id`, `redeemed`, `assigned_at`, `redeemed_at`) VALUES
(1, 15, 1, 0, '2024-11-04 13:13:29', NULL),
(2, 45, 2, 0, '2024-11-04 13:13:29', NULL),
(3, 46, 3, 0, '2024-11-04 13:13:29', NULL),
(4, 46, 1, 0, '2024-11-04 13:13:29', NULL),
(5, 15, 2, 0, '2024-11-04 13:13:29', NULL),
(6, 48, 1, 0, '2024-11-04 13:40:56', NULL),
(7, 49, 1, 0, '2024-11-11 02:22:52', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`agent_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `studio_id` (`studio_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`coupon_id`),
  ADD UNIQUE KEY `coupon_code` (`coupon_code`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `studioimages`
--
ALTER TABLE `studioimages`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `studio_id` (`studio_id`);

--
-- Indexes for table `studios`
--
ALTER TABLE `studios`
  ADD PRIMARY KEY (`studio_id`),
  ADD KEY `fk_agent` (`agent_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_coupons`
--
ALTER TABLE `user_coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `coupon_id` (`coupon_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=556;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `coupon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `studioimages`
--
ALTER TABLE `studioimages`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `studios`
--
ALTER TABLE `studios`
  MODIFY `studio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `user_coupons`
--
ALTER TABLE `user_coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `agents`
--
ALTER TABLE `agents`
  ADD CONSTRAINT `agents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`studio_id`) REFERENCES `studios` (`studio_id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `studioimages`
--
ALTER TABLE `studioimages`
  ADD CONSTRAINT `studioimages_ibfk_1` FOREIGN KEY (`studio_id`) REFERENCES `studios` (`studio_id`);

--
-- Constraints for table `studios`
--
ALTER TABLE `studios`
  ADD CONSTRAINT `fk_agent` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`agent_id`);

--
-- Constraints for table `user_coupons`
--
ALTER TABLE `user_coupons`
  ADD CONSTRAINT `user_coupons_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_coupons_ibfk_2` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`coupon_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
