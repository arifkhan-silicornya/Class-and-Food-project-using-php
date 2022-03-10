-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2020 at 09:08 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(10) NOT NULL,
  `username` varchar(25) NOT NULL,
  `admin_pass` varchar(250) NOT NULL,
  `profile_pic` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `admin_pass`, `profile_pic`) VALUES
(3, 'Admin_maruf', 'b714337aa8007c433329ef43c7b8252c', 'efaf98db2eac3a61946ca0282ae6ddd45f41234bb3a68');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(10) NOT NULL,
  `customer_id` int(25) NOT NULL,
  `customer_name` varchar(30) NOT NULL,
  `usertype` varchar(25) NOT NULL,
  `address` varchar(25) NOT NULL,
  `payment_type` varchar(25) NOT NULL,
  `total` int(10) NOT NULL,
  `status` varchar(20) NOT NULL,
  `order_time` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `customer_name`, `usertype`, `address`, `payment_type`, `total`, `status`, `order_time`) VALUES
(23, 201, 'Abir Khan', 'student', 'Khlilgaon ', 'cod', 10, 'cancel', '2020-08-29 05:37:45.672777'),
(24, 202, 'ArifKhan520', 'student', 'Mayakanan', 'balance', 60, 'confirmed', '2020-08-29 05:58:08.505719'),
(25, 202, 'ArifKhan520', 'student', 'Mayakanan', 'cod', 145, 'cancel', '2020-08-29 20:06:10.605465'),
(26, 201, 'Abir Khan', 'student', 'Khlilgaon ', 'cod', 200, 'confirmed', '2020-09-05 11:08:19.087922'),
(27, 203, 'Arif khan', 'teacher', 'India', 'balance', 15, 'cancel', '2020-09-06 06:32:35.629466'),
(28, 203, 'Arif khan', 'teacher', 'India', 'balance', 175, 'cancel', '2020-09-06 06:34:36.494197'),
(29, 203, 'Arif khan', 'teacher', 'India', 'balance', 175, 'cancel', '2020-09-06 06:45:47.117174'),
(30, 203, 'Arif khan', 'teacher', 'India', 'balance', 875, 'cancel', '2020-09-06 06:51:38.573276'),
(31, 203, 'Arif khan', 'teacher', 'Mayakanan', 'balance', 25, 'cancel', '2020-09-10 11:09:07.592028'),
(32, 203, 'Arif khan', 'teacher', 'India', 'balance', 350, 'cancel', '2020-09-10 11:13:17.124899'),
(33, 203, 'Arif khan', 'teacher', 'India', 'cod', 15, 'cancel', '2020-09-10 11:26:00.134396'),
(34, 203, 'Arif khan', 'teacher', 'India', 'cod', 30, 'cancel', '2020-09-10 20:36:37.080311'),
(35, 203, 'Arif khan', 'teacher', 'India', 'cod', 60, 'cancel', '2020-09-10 20:53:18.394122'),
(36, 203, 'Arif khan', 'teacher', 'India', 'cod', 120, 'cancel', '2020-09-10 20:59:46.375139'),
(37, 203, 'Arif khan', 'teacher', 'India', 'cod', 30, 'cancel', '2020-09-10 21:10:29.043734'),
(38, 203, 'Arif khan', 'teacher', 'India', 'cod', 30, 'cancel', '2020-09-10 21:12:25.044371'),
(39, 203, 'Arif khan', 'teacher', 'India', 'balance', 80, 'cancel', '2020-09-10 23:20:43.653878'),
(40, 203, 'Arif khan', 'teacher', 'India', 'balance', 255, 'cancel', '2020-09-10 23:20:44.079900'),
(41, 203, 'Arif khan', 'teacher', 'India', 'balance', 265, 'cancel', '2020-09-10 23:20:44.287912'),
(42, 203, 'Arif khan', 'teacher', 'India', 'balance', 270, 'cancel', '2020-09-10 23:20:44.404918'),
(43, 203, 'Arif khan', 'teacher', 'India', 'cod', 105, 'cancel', '2020-09-11 00:02:53.762891'),
(44, 203, 'Arif khan', 'teacher', 'India', 'cod', 105, 'cancel', '2020-09-11 00:02:54.220917'),
(45, 203, 'Arif khan', 'teacher', 'India', 'cod', 105, 'cancel', '2020-09-11 00:02:54.399927'),
(46, 203, 'Arif khan', 'teacher', 'India', 'cod', 220, 'cancel', '2020-09-11 00:08:01.655238'),
(47, 203, 'Arif khan', 'teacher', 'India', 'cod', 155, 'cancel', '2020-09-11 00:10:58.175021'),
(48, 203, 'Arif khan', 'teacher', 'India', 'cod', 25, 'cancel', '2020-09-11 00:11:29.218796'),
(49, 203, 'Arif khan', 'teacher', 'India', 'cod', 280, 'cancel', '2020-09-11 00:11:46.633793'),
(50, 203, 'Arif khan', 'teacher', 'India', 'cod', 480, 'cancel', '2020-09-11 00:12:12.658282'),
(51, 203, 'Arif khan', 'teacher', 'India', 'cod', 425, 'cancel', '2020-09-11 00:17:22.650739'),
(52, 203, 'Arif khan', 'teacher', 'India', 'cod', 300, 'cancel', '2020-09-11 00:33:05.257698'),
(53, 203, 'Arif khan', 'teacher', 'India', 'balance', 80, 'cancel', '2020-09-11 00:35:37.049981'),
(54, 203, 'Arif khan', 'teacher', 'India', 'balance', 170, 'cancel', '2020-09-11 00:51:24.661377'),
(55, 203, 'Arif khan', 'teacher', 'India', 'cod', 60, 'cancel', '2020-09-11 01:03:50.486128'),
(56, 202, 'ArifKhan520', 'student', 'abcd', 'cod', 70, 'cancel', '2020-09-11 14:18:54.567489'),
(57, 202, 'ArifKhan520', 'student', 'India', 'cod', 65, 'confirmed', '2020-09-11 15:45:55.381103'),
(58, 202, 'ArifKhan520', 'student', 'India', 'cod', 160, 'cancel', '2020-09-11 15:47:56.785045'),
(59, 202, 'ArifKhan520', 'student', 'India', 'cod', 130, 'confirmed', '2020-09-11 15:49:03.610870'),
(60, 202, 'ArifKhan520', 'student', 'India', 'cod', 95, 'cancel', '2020-09-11 15:50:41.334459'),
(61, 202, 'ArifKhan520', 'student', 'India', 'cod', 55, 'cancel', '2020-09-11 15:54:37.056939'),
(62, 202, 'ArifKhan520', 'student', 'India', 'cod', 45, 'confirmed', '2020-09-11 17:45:26.715281'),
(63, 202, 'ArifKhan520', 'student', 'Maruf er Basa', 'cod', 55, 'confirmed', '2020-09-11 17:49:03.008652'),
(64, 202, 'ArifKhan520', 'student', 'Maruf er Basa', 'cod', 10, 'confirmed', '2020-09-11 17:52:20.754961'),
(65, 202, 'ArifKhan520', 'student', 'Maruf er Basa', 'cod', 5, 'confirmed', '2020-09-11 18:02:07.694532');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `ordr_detail_id` int(10) NOT NULL,
  `customer_id` int(25) NOT NULL,
  `order_id` int(30) NOT NULL,
  `item_id` int(25) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` int(10) NOT NULL,
  `totalprice` int(10) NOT NULL,
  `order_date` date NOT NULL DEFAULT current_timestamp(),
  `order_time` time(6) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`ordr_detail_id`, `customer_id`, `order_id`, `item_id`, `quantity`, `price`, `totalprice`, `order_date`, `order_time`) VALUES
(36, 201, 23, 14, 1, 5, 5, '2020-08-29', '05:37:45.000000'),
(37, 201, 23, 17, 1, 5, 5, '2020-08-29', '05:37:45.000000'),
(38, 202, 24, 14, 1, 5, 5, '2020-08-29', '05:58:08.000000'),
(39, 202, 24, 17, 1, 5, 5, '2020-08-29', '05:58:08.000000'),
(40, 202, 24, 18, 1, 50, 50, '2020-08-29', '05:58:08.000000'),
(41, 202, 25, 14, 5, 5, 25, '2020-08-29', '20:06:10.000000'),
(42, 202, 25, 17, 4, 5, 20, '2020-08-29', '20:06:10.000000'),
(43, 202, 25, 18, 2, 50, 100, '2020-08-29', '20:06:10.000000'),
(44, 201, 26, 14, 5, 5, 25, '2020-09-05', '11:08:19.000000'),
(45, 201, 26, 15, 5, 35, 175, '2020-09-05', '11:08:19.000000'),
(46, 203, 27, 14, 3, 5, 15, '2020-09-06', '06:32:35.000000'),
(47, 203, 28, 15, 5, 35, 175, '2020-09-06', '06:34:36.000000'),
(48, 203, 29, 15, 5, 35, 175, '2020-09-06', '06:45:47.000000'),
(49, 203, 30, 15, 5, 35, 175, '2020-09-06', '06:51:38.000000'),
(50, 203, 30, 16, 10, 20, 200, '2020-09-06', '06:51:38.000000'),
(51, 203, 30, 17, 100, 5, 500, '2020-09-06', '06:51:38.000000'),
(52, 203, 31, 14, 5, 5, 25, '2020-09-10', '11:09:07.000000'),
(53, 203, 32, 15, 10, 35, 350, '2020-09-10', '11:13:17.000000'),
(54, 203, 33, 14, 3, 5, 15, '2020-09-10', '11:26:00.000000'),
(55, 203, 34, 17, 6, 5, 30, '2020-09-10', '20:36:37.000000'),
(56, 203, 35, 17, 12, 5, 60, '2020-09-10', '20:53:18.000000'),
(57, 203, 36, 17, 24, 5, 120, '2020-09-10', '20:59:46.000000'),
(58, 203, 37, 17, 6, 5, 30, '2020-09-10', '21:10:29.000000'),
(59, 203, 37, 15, 5, 35, 175, '2020-09-10', '21:10:29.000000'),
(60, 203, 38, 17, 6, 5, 30, '2020-09-10', '21:12:25.000000'),
(61, 203, 39, 16, 4, 20, 80, '2020-09-10', '23:20:43.000000'),
(62, 203, 39, 15, 5, 35, 175, '2020-09-10', '23:20:43.000000'),
(63, 203, 39, 14, 2, 5, 10, '2020-09-10', '23:20:43.000000'),
(64, 203, 39, 17, 1, 5, 5, '2020-09-10', '23:20:43.000000'),
(65, 203, 43, 14, 4, 5, 20, '2020-09-11', '00:02:53.000000'),
(66, 203, 43, 16, 4, 20, 80, '2020-09-11', '00:02:53.000000'),
(67, 203, 43, 17, 1, 5, 5, '2020-09-11', '00:02:54.000000'),
(68, 203, 46, 14, 1, 5, 5, '2020-09-11', '00:08:01.000000'),
(69, 203, 46, 15, 5, 35, 175, '2020-09-11', '00:08:01.000000'),
(70, 203, 46, 16, 2, 20, 40, '2020-09-11', '00:08:01.000000'),
(71, 203, 47, 14, 2, 5, 10, '2020-09-11', '00:10:58.000000'),
(72, 203, 47, 15, 1, 35, 35, '2020-09-11', '00:10:58.000000'),
(73, 203, 47, 16, 5, 20, 100, '2020-09-11', '00:10:58.000000'),
(74, 203, 47, 17, 2, 5, 10, '2020-09-11', '00:10:58.000000'),
(75, 203, 48, 14, 5, 5, 25, '2020-09-11', '00:11:29.000000'),
(76, 203, 49, 15, 8, 35, 280, '2020-09-11', '00:11:46.000000'),
(77, 203, 50, 16, 7, 20, 140, '2020-09-11', '00:12:12.000000'),
(78, 203, 50, 15, 8, 35, 280, '2020-09-11', '00:12:12.000000'),
(79, 203, 50, 14, 10, 5, 50, '2020-09-11', '00:12:12.000000'),
(80, 203, 50, 17, 2, 5, 10, '2020-09-11', '00:12:12.000000'),
(81, 203, 51, 15, 5, 35, 175, '2020-09-11', '00:17:22.000000'),
(82, 203, 51, 16, 10, 20, 200, '2020-09-11', '00:17:22.000000'),
(83, 203, 51, 14, 5, 5, 25, '2020-09-11', '00:17:22.000000'),
(84, 203, 51, 17, 5, 5, 25, '2020-09-11', '00:17:23.000000'),
(85, 203, 52, 14, 5, 5, 25, '2020-09-11', '00:33:05.000000'),
(86, 203, 52, 15, 5, 35, 175, '2020-09-11', '00:33:05.000000'),
(87, 203, 52, 16, 5, 20, 100, '2020-09-11', '00:33:05.000000'),
(88, 203, 53, 14, 5, 5, 25, '2020-09-11', '00:35:37.000000'),
(89, 203, 53, 15, 1, 35, 35, '2020-09-11', '00:35:37.000000'),
(90, 203, 53, 16, 1, 20, 20, '2020-09-11', '00:35:37.000000'),
(91, 203, 54, 14, 5, 5, 25, '2020-09-11', '00:51:24.000000'),
(92, 203, 54, 15, 1, 35, 35, '2020-09-11', '00:51:24.000000'),
(93, 203, 54, 16, 5, 20, 100, '2020-09-11', '00:51:24.000000'),
(94, 203, 54, 17, 2, 5, 10, '2020-09-11', '00:51:24.000000'),
(95, 203, 55, 14, 5, 5, 25, '2020-09-11', '01:03:50.000000'),
(96, 203, 55, 15, 1, 35, 35, '2020-09-11', '01:03:50.000000'),
(97, 202, 56, 15, 2, 35, 70, '2020-09-11', '14:18:54.000000'),
(98, 202, 57, 15, 1, 35, 35, '2020-09-11', '15:45:55.000000'),
(99, 202, 57, 17, 2, 5, 10, '2020-09-11', '15:45:55.000000'),
(100, 202, 57, 16, 1, 20, 20, '2020-09-11', '15:45:55.000000'),
(101, 202, 58, 15, 4, 35, 140, '2020-09-11', '15:47:56.000000'),
(102, 202, 58, 16, 1, 20, 20, '2020-09-11', '15:47:57.000000'),
(103, 202, 59, 16, 3, 20, 60, '2020-09-11', '15:49:03.000000'),
(104, 202, 59, 15, 2, 35, 70, '2020-09-11', '15:49:03.000000'),
(105, 202, 60, 16, 3, 20, 60, '2020-09-11', '15:50:41.000000'),
(106, 202, 60, 15, 1, 35, 35, '2020-09-11', '15:50:41.000000'),
(107, 202, 61, 15, 1, 35, 35, '2020-09-11', '15:54:37.000000'),
(108, 202, 61, 16, 1, 20, 20, '2020-09-11', '15:54:37.000000'),
(109, 202, 62, 15, 1, 35, 35, '2020-09-11', '17:45:26.000000'),
(110, 202, 62, 17, 2, 5, 10, '2020-09-11', '17:45:26.000000'),
(111, 202, 63, 15, 1, 35, 35, '2020-09-11', '17:49:03.000000'),
(112, 202, 63, 16, 1, 20, 20, '2020-09-11', '17:49:03.000000'),
(113, 202, 64, 14, 1, 5, 5, '2020-09-11', '17:52:20.000000'),
(114, 202, 64, 17, 1, 5, 5, '2020-09-11', '17:52:20.000000'),
(115, 202, 65, 14, 1, 5, 5, '2020-09-11', '18:02:07.000000');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(50) NOT NULL,
  `pro_name` varchar(25) NOT NULL,
  `pro_img_name` varchar(100) NOT NULL,
  `img_path` varchar(50) NOT NULL,
  `pro_quantity` int(30) NOT NULL,
  `pro_price` int(50) NOT NULL,
  `pro_details` varchar(200) NOT NULL,
  `pro_category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `pro_name`, `pro_img_name`, `img_path`, `pro_quantity`, `pro_price`, `pro_details`, `pro_category`) VALUES
(3, 'Platter', 'Platter_5f43afc678334', '../../assets/img/product/', 10, 200, 'Rice , Chicken, Dal , fish  1 Pices', 'lunch'),
(4, 'noodles', 'noodles_5f43fe8a47aaa', '../../assets/img/product/', 500, 45, 'For one Person ', 'others'),
(5, 'Sprite', 'Sprite_5f4401e2b5c54', '../../assets/img/product/', 99, 15, '250ml Plastic Bottle', 'drinks'),
(6, 'Coca Cola', 'Coca Cola_5f4402239e81c', '../../assets/img/product/', 520, 15, '250 ml Coacola Plastic Bottle', 'drinks'),
(7, 'Aqua Drinking Water ', 'Aqua Drinking Water _5f44026417e8b', '../../assets/img/product/', 200, 20, '250 ml Plastic bottle', 'drinks'),
(8, 'Chicken Biriyani', 'Chicken Biriyani_5f4402c9c5efc', '../../assets/img/product/', 50, 120, '1 person ,with salad,lemon', 'lunch'),
(9, 'kacci Biriyani', 'kacci Biriyani_5f4402ed4f894', '../../assets/img/product/', 120, 180, '1 person ,with salad,lemon', 'lunch'),
(10, 'Tehari (Beef)', 'Tehari (Beef)_5f44031b71623', '../../assets/img/product/', 100, 80, '1 person ,with salad,lemon', 'lunch'),
(11, 'Biscuit Single', 'Biscuit Single_5f4403d8a3250', '../../assets/img/product/', 200, 5, 'Creeme Biscuits - single Wrapped', 'dryfood'),
(12, 'Big Candy', 'Big Candy_5f44041177812', '../../assets/img/product/', 60, 30, 'Single Candy - Wrapped Candy', 'dryfood'),
(13, 'Single Piece Cake', 'Single Piece Cake_5f4405747949c', '../../assets/img/product/', 30, 25, 'Single Piece Cake', 'others'),
(14, 'Shingara', 'Shingara_5f4405a59495d', '../../assets/img/product/', 7, 5, 'Regular Shingara ', 'breakfast'),
(15, 'Chicken Roll', 'Chicken Roll_5f44074704447', '../../assets/img/product/', 4, 35, '10 inch Long - Regular', 'breakfast'),
(16, 'Vegetable Roll', 'Vegetable Roll_5f4407955ff02', '../../assets/img/product/', 3, 20, '10 inch Long -Regular', 'breakfast'),
(17, 'Somosa', 'Somosa_5f4407c5cdfd5', '../../assets/img/product/', 7, 5, 'Regular Somosa', 'breakfast'),
(18, 'Dal-Porota', 'Dal-Porota_5f4673157aebc', '../../assets/img/product/', 0, 50, 'Dal-porota--1 person', 'breakfast');

-- --------------------------------------------------------

--
-- Table structure for table `recharge_users`
--

CREATE TABLE `recharge_users` (
  `id` int(10) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_id` int(30) NOT NULL,
  `user_role` varchar(50) NOT NULL,
  `account_number` varchar(20) NOT NULL,
  `amount` int(20) NOT NULL,
  `rechrg_time` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recharge_users`
--

INSERT INTO `recharge_users` (`id`, `user_name`, `user_id`, `user_role`, `account_number`, `amount`, `rechrg_time`) VALUES
(4, 'Abir Khan', 201, 'student', '2', 300, '2020-08-28 01:54:55.000000'),
(6, 'Abir Khan', 201, 'student', '2', 200, '2020-08-28 06:13:00.000000'),
(7, 'Abir Khan', 201, 'student', '2', 100, '2020-08-28 06:13:28.000000'),
(10, 'Abir Khan', 201, 'student', '2', 100, '2020-08-28 02:53:12.646897'),
(13, 'ArifKhan520', 202, 'student', '3', 300, '2020-08-29 04:52:53.278781'),
(14, 'Abir Khan', 201, 'student', '2', 100, '2020-09-04 12:43:44.725049'),
(15, 'Arif khan', 203, 'teacher', '4', 800, '2020-09-04 14:50:57.144598'),
(16, 'Arif khan', 203, 'teacher', '4', -422, '2020-09-10 23:02:30.016315'),
(17, 'Arif khan', 203, 'teacher', '4', -60000, '2020-09-10 23:03:24.409426');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `user_role` varchar(100) NOT NULL,
  `username` varchar(25) NOT NULL,
  `studentid` int(50) NOT NULL,
  `email` varchar(35) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `batch` varchar(10) DEFAULT NULL,
  `gender` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `address` varchar(300) DEFAULT NULL,
  `contact` bigint(11) NOT NULL,
  `profile_picture` varchar(100) NOT NULL DEFAULT 'avatar',
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_role`, `username`, `studentid`, `email`, `department`, `batch`, `gender`, `password`, `address`, `contact`, `profile_picture`, `verified`, `deleted`) VALUES
(1, 'student', 'Abir Khan', 201, '', 'CSE', '41', 'Male', 'b714337aa8007c433329ef43c7b8252c', 'Khlilgaon ', 1741238435, 'avatar', 0, 0),
(13, 'Administrator', 'root', 1, '', '', '', '', 'toor', 'Address 1', 9898000000, 'avatar', 1, 0),
(19, 'student', 'ArifKhan520', 202, '', 'CSE', '42', 'Male', 'b714337aa8007c433329ef43c7b8252c', 'Maruf er Basa', 1913104445, '99edae97f8de92a1992b42110a0c0e7a5f49a63319bbe', 0, 0),
(20, 'teacher', 'Arif khan', 203, '', 'Department', '', 'Male', 'b714337aa8007c433329ef43c7b8252c', 'India', 1913104445, 'avatar', 0, 0),
(22, 'student', 'user1', 205, NULL, 'Department', '42', 'Male', 'b714337aa8007c433329ef43c7b8252c', NULL, 1913104445, 'avatar', 0, 0),
(23, 'student', 'user2', 206, NULL, 'CSE', '41', 'Male', 'b714337aa8007c433329ef43c7b8252c', NULL, 1913104445, 'avatar', 0, 0),
(24, 'teacher', 'user3', 207, NULL, '', '', 'Male', 'b714337aa8007c433329ef43c7b8252c', NULL, 1913104445, 'avatar', 0, 0),
(25, 'student', 'user4', 209, NULL, '', '', 'Male', 'b714337aa8007c433329ef43c7b8252c', NULL, 1913104445, 'avatar', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `id` int(10) NOT NULL,
  `user_institute_id` int(30) NOT NULL,
  `user_name` varchar(25) NOT NULL,
  `current_money` int(10) NOT NULL,
  `disabled` tinyint(2) NOT NULL DEFAULT 0,
  `create_accnt_date_time` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`id`, `user_institute_id`, `user_name`, `current_money`, `disabled`, `create_accnt_date_time`) VALUES
(2, 201, 'Abir Khan', 170, 0, '2020-08-26 01:43:19.854846'),
(3, 202, 'ArifKhan520', 240, 0, '2020-08-29 04:49:08.771940'),
(4, 203, 'Arif khan', 2240, 0, '2020-09-04 14:39:21.463808'),
(6, 205, 'user1', 0, 0, '2020-09-11 01:26:25.596538'),
(7, 206, 'user2', 0, 0, '2020-09-11 01:28:36.725038'),
(8, 207, 'user3', 0, 0, '2020-09-11 01:33:38.610305'),
(9, 209, 'user4', 0, 0, '2020-09-11 01:55:29.974311');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`ordr_detail_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recharge_users`
--
ALTER TABLE `recharge_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `ordr_detail_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `recharge_users`
--
ALTER TABLE `recharge_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
