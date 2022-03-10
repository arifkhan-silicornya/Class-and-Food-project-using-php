-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2020 at 03:36 PM
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
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `email` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`email`, `password`) VALUES
('sunnygkp10@gmail.com', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(10) NOT NULL,
  `course_code` varchar(25) NOT NULL,
  `course_title` varchar(30) NOT NULL,
  `credit` double NOT NULL,
  `department` varchar(50) NOT NULL,
  `course_create_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_code`, `course_title`, `credit`, `department`, `course_create_date`) VALUES
(1, 'CSE-101', 'Computer Fundamental', 3, 'CSE', '2020-11-15 23:59:08'),
(2, 'CSE-102', 'Structure Programming Language', 3, 'CSE', '2020-11-15 23:59:08'),
(3, 'CSE-342', 'Software Quality Assurance', 3, 'CSE', '2020-11-17 01:51:33'),
(4, 'CSE-343', 'Advanced Java ', 3, 'CSE', '2020-11-17 01:54:27'),
(5, 'CSE-465', 'Advanced Java Labratory', 1.5, 'CSE', '2020-11-17 02:02:02'),
(6, 'CSE-501', 'Physics Laboratory', 1.5, 'CSE', '2020-11-17 02:14:28');

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `exmid` int(100) NOT NULL,
  `exmType` varchar(50) NOT NULL,
  `course_code` varchar(25) NOT NULL,
  `course_title` varchar(60) NOT NULL,
  `batch` varchar(25) NOT NULL,
  `totalQuestion` int(10) NOT NULL,
  `rightAnswerMarks` double NOT NULL,
  `wrongAnswerMarks` double NOT NULL,
  `semisterYear` varchar(20) NOT NULL,
  `describtion` varchar(300) NOT NULL,
  `teacher_id` varchar(50) NOT NULL,
  `exmdate` date NOT NULL,
  `exmtime` time NOT NULL,
  `totaltime` int(10) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exam`
--

INSERT INTO `exam` (`exmid`, `exmType`, `course_code`, `course_title`, `batch`, `totalQuestion`, `rightAnswerMarks`, `wrongAnswerMarks`, `semisterYear`, `describtion`, `teacher_id`, `exmdate`, `exmtime`, `totaltime`, `create_date`) VALUES
(3, 'Midterm', 'CSE-101', 'Computer Fundamental', '41', 3, 2, 2, 'Summer-2020', 'Nothing to Say.......', '101', '0000-00-00', '00:00:00', 0, '2020-11-18 04:11:40'),
(4, 'Final', 'CSE-501', 'Differencial Equation', '41', 3, 1, 1, 'Spring-2020', 'Total time - 5 mins', '105', '0000-00-00', '00:00:00', 0, '2020-11-19 16:37:52'),
(5, 'Final', 'CSE-501', 'Advanced Java Labratory', '41', 3, 2, 1, 'Summer-2020', 'Final Exam', '105', '2020-11-27', '09:30:00', 180, '2020-11-19 17:22:05');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `question_id` int(100) NOT NULL,
  `exmid` int(50) NOT NULL,
  `questn` varchar(1000) NOT NULL,
  `opOne` varchar(1000) NOT NULL,
  `optwo` varchar(1000) NOT NULL,
  `opThree` varchar(1000) NOT NULL,
  `opFour` varchar(1000) NOT NULL,
  `correctAnswer` int(10) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`question_id`, `exmid`, `questn`, `opOne`, `optwo`, `opThree`, `opFour`, `correctAnswer`, `create_date`) VALUES
(2, 3, '', 'a', 'b', 'c', 'd', 4, '2020-11-19 16:28:57'),
(8, 4, '', 'Birla Industrial & Technological Museum', 'Bit in the Middle', 'Bengal Institute of Technology & Management', 'BASIS Institute of Technology & Management', 4, '2020-11-19 16:51:53'),
(9, 4, 'What is the full form of AIM?', 'Birla Industrial & Technological Museum', 'Bit in the Middle', 'Bengal Institute of Technology & Management', 'BASIS Institute of Technology & Management', 4, '2020-11-19 16:57:10'),
(10, 4, 'What is the full form of BITM?', 'Birla Industrial & Technological Museum', 'Bit in the Middle', 'Bengal Institute of Technology & Management', 'BASIS Institute of Technology & Management', 4, '2020-11-19 16:57:25'),
(11, 4, 'What is the full form of BITM?', 'Birla Industrial & Technological Museum', 'Bit in the Middle', 'Bengal Institute of Technology & Management', 'BASIS Institute of Technology & Management', 4, '2020-11-19 16:57:43'),
(12, 5, 'What is the full form of BITM?', 'Birla Industrial & Technological Museum', 'Bit in the Middle', 'Bengal Institute of Technology & Management', 'BASIS Institute of Technology & Management', 4, '2020-11-19 19:51:36'),
(13, 5, 'National Animal of India', 'Tiger', 'Panda', 'Deer', 'Horse', 1, '2020-11-19 19:56:45'),
(14, 5, 'What is the national bird of Bangladesh?', 'Oriental magpie-robin', 'Peacock', 'Sparrow', 'Pigeon', 1, '2020-11-19 20:01:12'),
(15, 3, 'What is the full form of AIM?', 'AOL Instant Messenger', 'Action International Ministries', 'Addictive Instant Messenger', 'Aminul Islam Maruf', 4, '2020-11-19 20:27:48');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(50) NOT NULL,
  `name` varchar(25) NOT NULL,
  `versityid` varchar(30) NOT NULL,
  `gender` varchar(25) NOT NULL,
  `usertype` varchar(25) NOT NULL,
  `depertment` varchar(25) DEFAULT NULL,
  `batch` varchar(10) DEFAULT NULL,
  `mobile` int(20) NOT NULL,
  `password` varchar(300) NOT NULL,
  `delete` tinyint(2) NOT NULL DEFAULT 0,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `time` time NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `versityid`, `gender`, `usertype`, `depertment`, `batch`, `mobile`, `password`, `delete`, `date`, `time`) VALUES
(1, 'Arif Khan', '101', 'M', 'teacher', '', '', 1913104445, 'b714337aa8007c433329ef43c7b8252c', 0, '2020-10-17', '19:19:27'),
(2, 'aminul islam maruf', '102', 'M', 'student', 'CSE', '41', 1913104445, 'b714337aa8007c433329ef43c7b8252c', 0, '2020-10-17', '19:20:30'),
(3, 'Aliya', '103', 'F', 'teacher', '', '', 1913104445, 'b714337aa8007c433329ef43c7b8252c', 0, '2020-10-21', '22:09:05'),
(4, 'Tamim Iqbal', '105', 'M', 'teacher', '', '', 1912535431, 'b714337aa8007c433329ef43c7b8252c', 0, '2020-11-19', '16:32:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`exmid`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `exmid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `question_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
