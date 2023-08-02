-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 10, 2023 at 05:28 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gms`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `booking_date` datetime NOT NULL,
  `expiry_date` datetime NOT NULL,
  `m_phone` varchar(10) NOT NULL,
  `packID` int(10) UNSIGNED NOT NULL,
  `month` int(2) NOT NULL,
  `m_price` decimal(10,2) NOT NULL,
  `bookingID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`bookingID`),
  KEY `m_phone` (`m_phone`),
  KEY `packID` (`packID`),
  KEY `m_phone_2` (`m_phone`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_date`, `expiry_date`, `m_phone`, `packID`, `month`, `m_price`, `bookingID`) VALUES
('2023-04-02 01:31:28', '2023-08-02 01:31:28', '9876543211', 12, 4, '7200.00', 1),
('2023-01-05 01:43:25', '2023-04-05 01:43:25', '9898989898', 15, 3, '3000.00', 2),
('2023-04-24 01:46:44', '2023-07-24 01:46:44', '9876543212', 13, 3, '3900.00', 3),
('2023-04-24 01:48:58', '2023-09-24 01:48:58', '9898989900', 14, 5, '11500.00', 4),
('2023-02-24 01:56:20', '2023-03-24 01:56:20', '9876543213', 15, 1, '1000.00', 5),
('2022-08-14 01:59:46', '2022-10-14 01:59:46', '9898989901', 15, 2, '2000.00', 6),
('2023-01-24 02:02:05', '2023-02-24 02:02:05', '9876543214', 14, 1, '2300.00', 7),
('2023-04-24 02:06:32', '2023-05-24 02:06:32', '9898989902', 12, 1, '1800.00', 8),
('2023-02-20 02:08:31', '2023-04-20 02:08:31', '9876543215', 12, 2, '3600.00', 9),
('2023-04-24 02:11:48', '2023-07-24 02:11:48', '9898989903', 13, 3, '3900.00', 10),
('2023-04-24 02:14:22', '2023-06-24 02:14:22', '9876543216', 15, 2, '2000.00', 11),
('2023-04-24 02:16:45', '2023-07-24 02:16:45', '9898989904', 12, 3, '5400.00', 12),
('2023-04-24 02:18:43', '2023-07-24 02:18:43', '9876543217', 14, 3, '6900.00', 13),
('2022-11-18 02:27:59', '2023-01-18 02:27:59', '9898989901', 12, 2, '3600.00', 14),
('2023-04-24 02:29:19', '2023-06-24 02:29:19', '9898989901', 12, 2, '3600.00', 15);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `mobile` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(500) NOT NULL,
  `insta` varchar(500) NOT NULL,
  `facebook` varchar(500) NOT NULL,
  `twitter` varchar(500) NOT NULL,
  `whatsapp` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`mobile`, `phone`, `email`, `insta`, `facebook`, `twitter`, `whatsapp`) VALUES
('9876543210', '123-456-789', 'fitnessclub@gmail.com', 'https://www.instagram.com/', 'https://www.facebook.com/', 'https://www.twitter.com/', '9876543210');

-- --------------------------------------------------------

--
-- Table structure for table `equipments`
--

DROP TABLE IF EXISTS `equipments`;
CREATE TABLE IF NOT EXISTS `equipments` (
  `equipID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `e_name` varchar(50) NOT NULL,
  `e_img` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`equipID`)
) ENGINE=InnoDB AUTO_INCREMENT=165 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `equipments`
--

INSERT INTO `equipments` (`equipID`, `e_name`, `e_img`) VALUES
(158, 'Tredmill x4', 'Screenshot (535).png'),
(159, 'Leg Press x2', 'Screenshot (538).png'),
(160, 'Bicycle x3', 'Screenshot (541).png'),
(161, 'Dumbbells', 'Screenshot (544).png'),
(162, 'Leg Curl x2', 'Screenshot (546).png'),
(163, 'Bench Press x2', 'Screenshot (549).png'),
(164, 'Chest Press Machine x1', 'Screenshot (551).png');

-- --------------------------------------------------------

--
-- Table structure for table `logininfo`
--

DROP TABLE IF EXISTS `logininfo`;
CREATE TABLE IF NOT EXISTS `logininfo` (
  `loginID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `passwords` varchar(20) NOT NULL,
  `user_type` varchar(10) NOT NULL,
  `m_phone` varchar(10) NOT NULL,
  PRIMARY KEY (`loginID`),
  KEY `m_phone` (`m_phone`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logininfo`
--

INSERT INTO `logininfo` (`loginID`, `passwords`, `user_type`, `m_phone`) VALUES
(1, 'admin@123', 'admin', '0123456789'),
(2, 'aarav', 'member', '9876543210'),
(3, 'riya', 'member', '9898989898'),
(4, 'rohit', 'member', '9876543211'),
(5, 'nisha', 'member', '9898989899'),
(6, 'rahul', 'member', '9876543212'),
(7, 'priya', 'member', '9898989900'),
(8, 'arnav', 'member', '9876543213'),
(9, 'divya', 'member', '9898989901'),
(10, 'sameer', 'member', '9876543214'),
(11, 'tanvi', 'member', '9898989902'),
(12, 'ankit', 'member', '9876543215'),
(13, 'neha', 'member', '9898989903'),
(14, 'vivek', 'member', '9876543216'),
(15, 'ritu', 'member', '9898989904'),
(16, 'kavita', 'member', '9876543217'),
(17, 'asdf', 'member', '3955555533');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `m_name` varchar(50) NOT NULL,
  `m_age` int(3) NOT NULL,
  `m_gender` varchar(20) NOT NULL,
  `m_address` varchar(100) NOT NULL,
  `m_medical` varchar(50) NOT NULL,
  `m_phone` varchar(10) NOT NULL,
  `m_email` varchar(50) DEFAULT NULL,
  `m_shift` varchar(30) NOT NULL,
  PRIMARY KEY (`m_phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`m_name`, `m_age`, `m_gender`, `m_address`, `m_medical`, `m_phone`, `m_email`, `m_shift`) VALUES
('Aarav Sharma', 25, 'male', 'Ramghat road, Aligharh', 'none', '9876543210', 'aarav.sharma@gmail.com', '6AM-8AM'),
('Rohit Singh', 28, 'male', 'Qwarsi Chauraha, Aligarh', 'low_blood_pressure', '9876543211', 'rohit.singh@gmail.com', '6AM-8AM'),
('Rahul Jain', 48, 'other', 'Centre Point, Aligarh', 'other', '9876543212', 'rahul.jain@gmail.com', '5PM-7PM'),
('Arnav Verma', 25, 'male', 'Shamshad, Aligarh', 'none', '9876543213', 'arnav.verma@hotmail.com', '7PM-9PM'),
('Sameer Gupta', 24, 'male', 'Royal Kaveri Apartments, Aligarh', 'thyroid', '9876543214', 'sameer.gupta@gmail.com', '7PM-9PM'),
('Ankit Sharma', 27, 'male', 'Ozone City, Aligarh', 'none', '9876543215', 'ankit.sharma@gmail.com', '7PM-9PM'),
('Vivek Singh', 30, 'male', 'ADA Colony, Aligarh', 'none', '9876543216', 'vivek.singh@gmail.com', '5PM-7PM'),
('Kavita Sharma', 24, 'female', 'Mansarovar Colony, Aligarh', 'none', '9876543217', 'kavita.sharma@gmail.com', '5PM-7PM'),
('Riya Patel', 30, 'female', 'Swarnjayanti, Aligarh', 'diabetes', '9898989898', 'riya.patel@yahoo.com', '10AM-12PM'),
('Nisha Gupta', 35, 'female', 'Laal Mandir, Aligarh', 'thyroid', '9898989899', 'nisha.gupta@hotmail.com', '10AM-12PM'),
('Priya Sharma', 27, 'female', 'Marris Road, Aligarh', 'none', '9898989900', 'priya.sharma@gmail.com', '3PM-5PM'),
('Divya Patel', 28, 'female', 'Ramesh Vihar, Aligarh', 'asthma', '9898989901', 'divya.patel@gmail.com', '8AM-10AM'),
('Tanvi Singh', 33, 'female', 'Sarsol, Aligarh', 'high_blood_pressure', '9898989902', 'tanvi.singh@gmail.com', '3PM-5PM'),
('Neha Patel', 27, 'female', 'Sir Syed Nagar, Aligarh', 'recent_childbirth', '9898989903', 'neha.patel@gamil.com', '6AM-8AM'),
('Ritu Gupta', 35, 'female', 'Basant Vihar, Aligarh', 'none', '9898989904', 'ritu.gupta@gmail.com', '10AM-12PM');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

DROP TABLE IF EXISTS `packages`;
CREATE TABLE IF NOT EXISTS `packages` (
  `packID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `p_name` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `p_desc` varchar(500) NOT NULL,
  PRIMARY KEY (`packID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`packID`, `p_name`, `price`, `p_desc`) VALUES
(12, 'Weight Loss (6days/week)', '1800.00', 'Standard workout 6days/week + Cardio 6days/week + Yoga 1day/week + Diet Chart'),
(13, 'Senior Fitness (6days/week)', '1300.00', 'Yoga 3days/week + Cardio 3days/week'),
(14, 'Gain Muscles (6days/week)', '2300.00', 'Workout 6days/week + Cardio 6days/week + Aerobics 2days/week+ Diet Chart'),
(15, 'Fitness (3days/week)', '1000.00', 'Standard Workout + Aerobics + Cardio + Diet');

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

DROP TABLE IF EXISTS `trainers`;
CREATE TABLE IF NOT EXISTS `trainers` (
  `trainerID` int(10) NOT NULL AUTO_INCREMENT,
  `t_name` varchar(50) NOT NULL,
  `t_img` varchar(100) DEFAULT NULL,
  `t_desc` varchar(500) NOT NULL,
  `t_shift` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`trainerID`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`trainerID`, `t_name`, `t_img`, `t_desc`, `t_shift`) VALUES
(44, 'Mark Johnson', 't1.jpeg', 'Mark is a former professional athlete turned personal trainer. He specializes in sports-specific training and injury prevention.', '6AM-8AM'),
(47, 'John Doe', 't3.jpeg', 'John is a certified personal trainer with over 10 years of experience in the fitness industry. He specializes in weight loss and strength training.', '8AM-10AM'),
(48, 'Jane Smith', 't2.jpeg', 'Jane is a yoga instructor with a passion for helping people achieve mental and physical balance through yoga. She has been teaching for 5 years', '10AM-12PM'),
(49, 'Emma Jewel', 't4.jpeg', 'Emma is a instructor with a passion for helping people achieve mental and physical balance through Aerobics. She has been teaching for 3 years', '3PM-5PM'),
(50, 'Jeon Jungkook', 'Screenshot (555).png', 'Jeon Jungkook is a certified trainer with over 3 years of experience in the fitness industry. He specializes in muscle gaining and strength training.', '5PM-7PM'),
(51, 'Luca Roy', 'Screenshot (556).png', 'Luca is a certified trainer in the fitness industry. He specializes in fitness and strength training.', '7PM-9PM');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`packID`) REFERENCES `packages` (`packID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
