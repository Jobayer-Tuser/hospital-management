-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 29, 2021 at 10:11 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mediraj_app_rdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `type` enum('Expenditure','Income') NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `title`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Electricity Bill', 'Expenditure', 'Active', '2020-12-10 01:08:41', NULL),
(4, 'Pathology Dept', 'Income', 'Active', '2020-12-10 01:49:51', '2020-12-10 02:12:23'),
(5, 'Blood Bank', 'Income', 'Active', '2020-12-10 01:57:27', '2020-12-10 03:19:30'),
(8, 'Appointment', 'Income', 'Active', '2020-12-12 22:03:12', '2020-12-23 20:58:23');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `admin_name` varchar(128) NOT NULL,
  `admin_email` varchar(128) NOT NULL,
  `admin_mobile` varchar(11) NOT NULL,
  `admin_nidcard_no` varchar(32) NOT NULL,
  `admin_gender` enum('Male','Female') NOT NULL,
  `admin_role_type` enum('Root Admin','Administrator','Editor','Author') NOT NULL,
  `admin_avatar` text NOT NULL,
  `admin_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `admin_status` enum('Active','Inactive') NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `admin_name`, `admin_email`, `admin_mobile`, `admin_nidcard_no`, `admin_gender`, `admin_role_type`, `admin_avatar`, `admin_password`, `admin_status`, `created_at`, `updated_at`) VALUES
(1, 'Abdullah Al Mamun Roni', 'md.aamroni@hotmail.com', '01316440504', '3254 128 784', 'Male', 'Root Admin', 'admin_image_20201125005337_aamroni.jpg', '59ad9220e4cfde905c0c9af7ac205d48dc2f98ba', 'Active', '2020-11-25 00:53:37', '2021-01-03 02:31:06'),
(6, 'Kabir Khan', 'kabirkhan@gmail.com', '01419453652', '2589 124 653', 'Male', 'Administrator', 'admin_image_20201201030840_b-t-2.jpg', '51f91c6f8183b7af6006eb8b00d2baf7d49513d7', 'Active', '2020-12-01 03:08:40', '2020-12-08 06:45:56');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `user_id` varchar(32) NOT NULL,
  `user_name` varchar(128) NOT NULL,
  `user_phone` varchar(32) NOT NULL,
  `user_email` varchar(128) NOT NULL,
  `date_time` datetime NOT NULL,
  `doctor_name` varchar(255) NOT NULL,
  `department` varchar(128) NOT NULL,
  `status` enum('Pending','Completed') NOT NULL DEFAULT 'Pending',
  `date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `user_name`, `user_phone`, `user_email`, `date_time`, `doctor_name`, `department`, `status`, `date`, `created_at`, `updated_at`) VALUES
(1, '05a2822f306e63bbdf0ba900a16daa77', 'Jhoni Vai', '01645770422', 'jhonivai@gmail.com', '2020-12-12 17:54:00', 'Col. Prof. Dr. Enamul Haque Chowdhury', 'Cardiology', 'Completed', '2020-12-12', '2020-12-11 18:54:51', NULL),
(2, '8f6e656883a3ed187e32cc53ec70daf6', 'Md. Ahsan Habib', '01711589632', 'ahsan_habib@gmail.com', '2020-12-11 20:21:00', 'Dr. A.K.M. Fazlur Rahman', 'Cardiology', 'Completed', '2020-12-11', '2020-12-11 20:22:08', NULL),
(3, '5d6c5be6474c828cb7dc4dfeb3632947', 'Kabir Khan', '01419453685', 'kabirkhan@gmail.com', '2020-12-14 18:57:00', 'Col. Prof. Dr. Enamul Haque Chowdhury', 'Cardiology', 'Completed', '2020-12-14', '2020-12-14 18:57:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `appointment_request`
--

CREATE TABLE `appointment_request` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `scheduled_at` datetime NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appointment_request`
--

INSERT INTO `appointment_request` (`id`, `date`, `user_id`, `doctor_id`, `scheduled_at`, `created_at`, `updated_at`) VALUES
(7, '2020-12-23', 3, 3, '2020-12-23 23:23:00', '2020-12-23 11:56:23', NULL),
(8, '2020-12-02', 3, 4, '2020-12-21 01:23:00', '2020-12-23 11:56:54', NULL),
(9, '2020-12-23', 3, 4, '2020-12-23 11:23:00', '2020-12-23 11:59:07', NULL),
(10, '2021-01-02', 3, 4, '2021-01-21 01:23:00', '2021-01-15 10:06:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` enum('Services','Department') NOT NULL DEFAULT 'Services',
  `logo` text NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `type`, `logo`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Doctor Department', 'Department', '20201210050553_git.svg', 'Active', '2020-12-10 05:05:53', '2020-12-10 18:39:57'),
(2, 'Diagnostic Service', 'Services', '20201210060224_stripe.svg', 'Active', '2020-12-10 05:07:11', '2020-12-12 23:35:28');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comments` text NOT NULL,
  `status` enum('Pending','Published') NOT NULL DEFAULT 'Pending',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `comments`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'It\'s been a month I\'m using this service and trust me..it\'s the best!', 'Pending', '2020-12-09 15:52:49', '2021-01-03 02:32:27'),
(2, 1, 'It\\\'s been a month I\\\'m using this service and trust me..it\\\'s the best!', 'Published', '2020-12-09 15:54:52', '2021-01-10 09:37:47'),
(3, 1, 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'Pending', '2020-12-12 18:49:44', '2021-01-03 02:32:29'),
(5, 2, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout', 'Pending', '2020-12-23 12:47:31', '2021-01-03 02:32:30'),
(9, 2, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout', 'Published', '2020-12-23 12:48:34', '2021-01-03 02:32:06'),
(15, 1, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout', 'Pending', '2021-01-15 10:46:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `category_id`, `title`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 'Cardiology', 'Active', '2020-12-11 03:22:18', '2020-12-11 06:10:56'),
(4, 1, 'Neuro Medicine', 'Active', '2020-12-11 03:22:34', '2020-12-11 03:23:18'),
(5, 1, 'Medicine', 'Active', '2020-12-11 03:22:56', '2020-12-11 03:42:48');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(128) NOT NULL,
  `mobile` varchar(64) NOT NULL,
  `gender` enum('Male','Female') NOT NULL DEFAULT 'Male',
  `nid_card_no` varchar(64) NOT NULL,
  `avatar` text NOT NULL,
  `specialty` varchar(128) NOT NULL,
  `degree` varchar(512) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `organization` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `chember` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `schedule` varchar(128) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `department_id`, `full_name`, `email`, `mobile`, `gender`, `nid_card_no`, `avatar`, `specialty`, `degree`, `designation`, `organization`, `address`, `chember`, `location`, `schedule`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES
(3, 3, 'Dr. A.K.M. Fazlur Rahman', 'fazlur_rahman@gmail.com', '01911967295', 'Male', '4512 784 653', '20201211034551_b-t-2.jpg', 'Cardiologist', 'MBBS, MD(Card)', 'Associate Professor', 'Bangabandhu Sheikh Mujib Medical University (BSMMU)', 'Dhaka, Bangladesh', 'Anwer Khan Modern Hospital Ltd', 'Dhanmondi Dhaka - 1205, Bangladesh', 'Saturday, Tuesday, Thursday', '06:30:00', '09:30:00', 'Active', '2020-12-11 03:45:51', '2021-01-03 02:33:00'),
(4, 3, 'Col. Prof. Dr. Enamul Haque Chowdhury', 'dr.enamul_haque@gmail.com', '01719 122690', 'Male', '2536 789 451', '20201211034835_b-t-2.jpg', 'Cardiologist', 'MBBS, MCPS, FCPS ( Radiology &amp; Imaging)', 'Professor, Department of Radiology', 'Armed Forces Medical College &amp; Hospital', 'Dhaka, Bangladesh', 'Aysha Memorial Specialised Hospital', 'New Airport Road, Dhaka -1215, Bangladesh', 'Friday, Sunday, Tuesday, Thursday', '06:00:00', '09:00:00', 'Active', '2020-12-11 03:48:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `user_id` varchar(32) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `mobile` varchar(32) NOT NULL,
  `service` varchar(128) NOT NULL,
  `product` varchar(128) NOT NULL,
  `price` double NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `date`, `user_id`, `name`, `email`, `mobile`, `service`, `product`, `price`, `created_at`, `updated_at`) VALUES
(1, '2020-12-12', '5d6c5be6474c828cb7dc4dfeb3632947', 'Kabir Khan', 'kabirkhan@gmail.com', '01419453685', 'Blood Test', 'CVC Test', 1200, '2020-12-12 11:52:16', NULL),
(2, '2020-12-12', '5d6c5be6474c828cb7dc4dfeb3632947', 'Kabir Khan', 'kabirkhan@gmail.com', '01419453685', 'Blood Test', 'Corona Blood Test', 3000, '2020-12-12 11:52:17', NULL),
(3, '2020-12-12', '8f6e656883a3ed187e32cc53ec70daf6', 'Md. Ahsan Habib', 'ahsan_habib@gmail.com', '01711589632', 'Blood Test', 'CVC Test', 1200, '2020-12-12 18:42:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `shopcart_id` int(11) NOT NULL,
  `service_title` int(128) NOT NULL,
  `product_id` varchar(128) NOT NULL,
  `product_price` double NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `shopcart_id`, `service_title`, `product_id`, `product_price`, `created_at`, `updated_at`) VALUES
(4, 3, 1, '1', 1200, '2020-12-14 19:02:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `unique_id` varchar(128) NOT NULL,
  `title` varchar(128) NOT NULL,
  `details` varchar(128) DEFAULT NULL,
  `price` double NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `service_id`, `unique_id`, `title`, `details`, `price`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '#549A38834', 'CVC Test', 'Also known as Blood Culture', 1200, 'Active', '2020-12-10 19:25:30', NULL),
(3, 1, '#11EACC118', 'Corona Blood Test', 'Special Test for Global Climate', 3000, 'Active', '2020-12-10 19:30:33', '2020-12-10 19:48:56');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `category_id`, `title`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Blood Test', 'Active', '2020-12-10 18:49:14', '2020-12-10 19:29:59');

-- --------------------------------------------------------

--
-- Table structure for table `shopcarts`
--

CREATE TABLE `shopcarts` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `price_total` double NOT NULL,
  `status` enum('Pending','Confirmed') NOT NULL DEFAULT 'Pending',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shopcarts`
--

INSERT INTO `shopcarts` (`id`, `date`, `user_id`, `price_total`, `status`, `created_at`, `updated_at`) VALUES
(3, '2020-12-14', 1, 1200, 'Pending', '2020-12-14 19:02:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `statement`
--

CREATE TABLE `statement` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `month` enum('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec') NOT NULL,
  `type` enum('Expenditure','Income') NOT NULL,
  `account_id` int(11) NOT NULL,
  `prepared_on` datetime NOT NULL,
  `issued_by` varchar(128) NOT NULL,
  `approved` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `total_amount` double NOT NULL,
  `isAppointment` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `statement`
--

INSERT INTO `statement` (`id`, `date`, `month`, `type`, `account_id`, `prepared_on`, `issued_by`, `approved`, `description`, `total_amount`, `isAppointment`, `created_at`, `updated_at`) VALUES
(1, '2020-12-10', 'Dec', 'Expenditure', 1, '2020-12-10 03:09:00', 'Jhon Doe', 1, 'Nothing Yet', 1250, 'No', '2020-12-10 03:09:50', NULL),
(2, '2020-12-10', 'Dec', 'Income', 4, '2020-12-10 03:16:00', 'Jhon Doe', 6, 'Commission for the month of November', 4850, 'No', '2020-12-10 03:17:37', NULL),
(3, '2020-12-08', 'Dec', 'Income', 5, '2020-12-08 03:19:00', 'Istiak Ahmed', 1, 'Commission for the month of October', 1600, 'No', '2020-12-10 03:20:28', NULL),
(9, '2020-12-13', 'Dec', 'Income', 8, '2020-12-13 10:36:00', 'Jhon', 6, '', 1650, 'Yes', '2020-12-13 10:37:18', NULL),
(10, '2021-01-03', 'Jan', 'Expenditure', 1, '2021-01-03 20:35:00', 'Jhon Doe', 1, '', 150, 'No', '2021-01-03 20:35:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `statement_details`
--

CREATE TABLE `statement_details` (
  `id` int(11) NOT NULL,
  `type` enum('Expenditure','Income') NOT NULL,
  `statement_id` int(11) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `net_amount` double NOT NULL,
  `vat_amount` double DEFAULT NULL,
  `total_amount` double NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `statement_details`
--

INSERT INTO `statement_details` (`id`, `type`, `statement_id`, `purpose`, `net_amount`, `vat_amount`, `total_amount`, `created_at`, `updated_at`) VALUES
(1, 'Expenditure', 1, 'Bill of the month of November', 1250, 0, 1250, '2020-12-10 03:09:51', NULL),
(2, 'Income', 2, 'X-Ray', 2850, 0, 2850, '2020-12-10 03:17:37', NULL),
(3, 'Income', 2, 'Blood Test', 2000, 0, 2000, '2020-12-10 03:17:37', NULL),
(4, 'Income', 3, 'AB+ Blood (2 Bag)', 1600, 0, 1600, '2020-12-10 03:20:29', NULL),
(15, 'Income', 9, 'Orthopedics', 950, 0, 950, '2020-12-13 10:37:18', NULL),
(16, 'Income', 9, 'Cardiology', 700, 0, 700, '2020-12-13 10:37:18', NULL),
(17, 'Expenditure', 10, 'Biscuit', 150, 0, 150, '2021-01-03 20:35:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `todos`
--

CREATE TABLE `todos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `details` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `todos`
--

INSERT INTO `todos` (`id`, `user_id`, `details`, `created_at`, `updated_at`) VALUES
(6, 1, 'Doctors Appointment Management Software', '2020-12-09 18:08:28', NULL),
(8, 1, 'Something for test purpose', '2020-12-18 20:51:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `mobile` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `avatar` text DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `full_name`, `mobile`, `email`, `avatar`, `password`, `status`, `created_at`, `updated_at`) VALUES
(1, '5d6c5be6474c828cb7dc4dfeb3632947', 'Kabir Khan', '01419453685', 'kabirkhan@gmail.com', '20201231071414_blog-4.jpg', 'f99f269d883eacb3faccec4b9c711caec90c0683', 'Active', '2020-12-09 14:06:05', '2021-01-15 11:19:46'),
(2, '8f6e656883a3ed187e32cc53ec70daf6', 'Md. Ahsan Habib', '01711589632', 'ahsan_habib@gmail.com', '20201223140406_team4.jpg', 'f99f269d883eacb3faccec4b9c711caec90c0683', 'Active', '2020-12-09 14:07:28', '2020-12-23 14:04:06'),
(3, '05a2822f306e63bbdf0ba900a16daa77', 'Jhony Mahmud', '01495632587', 'jhony@gmail.com', '20201223140341_team1.jpg', '4b8212df910925a8328ef8594417645ce477bfef', 'Active', '2020-12-10 18:15:42', '2020-12-23 14:03:41'),
(8, 'ed9559f747c715cf7849f7bbeea5d143', 'Abu Selim Hossain', '01645825826', 'selim@hotmail.com', '20201223140146_team3.jpg', 'f99f269d883eacb3faccec4b9c711caec90c0683', 'Active', '2020-12-12 19:07:21', '2020-12-23 19:04:12'),
(14, 'e6db896454d922fcecdb323a3d15c4d9', 'Ferdous Ahmed', '01852693219', 'ferdous@gmail.com', '20201223134356_team2.jpg', 'f99f269d883eacb3faccec4b9c711caec90c0683', 'Active', '2020-12-23 13:25:14', '2020-12-23 13:45:30'),
(16, 'a93e1d212a87fda374e3ac7eb0e09e1c', 'Syhemme Ahdmed Kahn', '01552789636', 'syhemme@email.com', '20210115114148_aamroni.jpg', 'f99f269d883eacb3faccec4b9c711caec90c0683', 'Active', '2021-01-15 11:11:19', '2021-01-15 11:41:48'),
(17, 'c59f5a0ad76f89c18615b130981caf52', 'Siam Ahmed', '01852693564', 'ferdous@email.com', '20210115120057_Abdullah-Al-Mamun-Roni.jpg', 'f99f269d883eacb3faccec4b9c711caec90c0683', 'Active', '2021-01-15 11:29:08', '2021-01-15 12:00:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_email` (`admin_email`),
  ADD UNIQUE KEY `admin_mobile` (`admin_mobile`),
  ADD UNIQUE KEY `admin_nidcard_no` (`admin_nidcard_no`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment_request`
--
ALTER TABLE `appointment_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobile` (`mobile`),
  ADD UNIQUE KEY `nid_card_no` (`nid_card_no`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shopcart_id` (`shopcart_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id` (`unique_id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `shopcarts`
--
ALTER TABLE `shopcarts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `statement`
--
ALTER TABLE `statement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `approved` (`approved`);

--
-- Indexes for table `statement_details`
--
ALTER TABLE `statement_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `statement_id` (`statement_id`);

--
-- Indexes for table `todos`
--
ALTER TABLE `todos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `todos_ibfk_1` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `full_name` (`full_name`),
  ADD UNIQUE KEY `mobile` (`mobile`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `appointment_request`
--
ALTER TABLE `appointment_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shopcarts`
--
ALTER TABLE `shopcarts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `statement`
--
ALTER TABLE `statement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `statement_details`
--
ALTER TABLE `statement_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `todos`
--
ALTER TABLE `todos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment_request`
--
ALTER TABLE `appointment_request`
  ADD CONSTRAINT `appointment_request_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `appointment_request_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`shopcart_id`) REFERENCES `shopcarts` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `shopcarts`
--
ALTER TABLE `shopcarts`
  ADD CONSTRAINT `shopcarts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `statement`
--
ALTER TABLE `statement`
  ADD CONSTRAINT `statement_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `statement_ibfk_2` FOREIGN KEY (`approved`) REFERENCES `admins` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `statement_details`
--
ALTER TABLE `statement_details`
  ADD CONSTRAINT `statement_details_ibfk_1` FOREIGN KEY (`statement_id`) REFERENCES `statement` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `todos`
--
ALTER TABLE `todos`
  ADD CONSTRAINT `todos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `admins` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
