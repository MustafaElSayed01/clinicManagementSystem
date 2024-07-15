-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 01:27 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID` int(11) NOT NULL,
  `userID` varchar(14) NOT NULL,
  `userPW` varchar(200) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `age` int(2) NOT NULL,
  `nationalID` varchar(14) NOT NULL,
  `emailAddress` varchar(100) DEFAULT NULL,
  `gender` enum('ذكر','أنثى') NOT NULL,
  `address` varchar(150) DEFAULT NULL,
  `photo` varchar(150) NOT NULL DEFAULT 'default.png',
  `role` int(11) NOT NULL DEFAULT 100,
  `isLogged` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID`, `userID`, `userPW`, `name`, `phone`, `age`, `nationalID`, `emailAddress`, `gender`, `address`, `photo`, `role`, `isLogged`) VALUES
(1, '28912280210318', '$2y$10$PBuGGYbGjyGr6XAHRTxYN.mkTOOtjPcwmBblRB59a5dL2tdkhL6Oq', 'جلال محمد سامح', '01145445602', 33, '28912280210318', 'galal02@gmail.com', 'ذكر', '28ش مسجد التائبين - المندرة قبلي', '646337290d32d.png', 100, '0'),
(2, '30109280201258', '$2y$10$QYomwrhIWlqY6OoP/xm8f.MXqAuMzXw/IKLtidw42i8ZyS8KDzIRC', 'مصطفى السيد محمد', '01148990430', 22, '30109280201258', 'mustafa01148990430@gmail.com', 'ذكر', '29ش حمزة بن عبدالمطلب - السيوف', '6463419392d02.jpg', 100, '0');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `ID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `age` int(2) NOT NULL,
  `nationalID` varchar(14) NOT NULL,
  `emailAddress` varchar(100) DEFAULT NULL,
  `gender` enum('ذكر','انثى') NOT NULL,
  `address` varchar(150) DEFAULT NULL,
  `photo` varchar(50) NOT NULL DEFAULT 'default.png',
  `specialization` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `reservationPrice` int(3) NOT NULL DEFAULT 100,
  `rate` int(11) NOT NULL DEFAULT 0,
  `rateCount` int(11) NOT NULL DEFAULT 0,
  `perHour` int(11) NOT NULL DEFAULT 80,
  `salary` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`ID`, `name`, `phone`, `age`, `nationalID`, `emailAddress`, `gender`, `address`, `photo`, `specialization`, `description`, `reservationPrice`, `rate`, `rateCount`, `perHour`, `salary`) VALUES
(1, 'احمد صلاح', '', 34, '28907250200137', '', 'ذكر', '', 'default.png', 'أنف وأذن وحنجرة', 'استشارى الانف و الاذن و الحنجره.', 180, 5, 1, 350, 0),
(2, 'محمد حسن', '', 34, '28907250200157', '', 'ذكر', '', 'default.png', 'أسنان', 'إستشارى طب و جراحة الفم و الأسنان', 250, 0, 0, 300, 0),
(3, 'ثناء خالد', '', 28, '29507250200167', '', 'انثى', '', 'default.png', 'عيون', 'إستشارى طب و جراحه العيون', 300, 0, 0, 80, 0),
(4, 'صالح محمد علي', '', 30, '29307250200179', '', 'ذكر', '', 'default.png', 'أنف وأذن وحنجرة', 'استشاري و دكتوراه الانف و الاذن و الحنجرة', 250, 0, 0, 80, 0),
(5, 'اسماعيل محمد خلف', '', 34, '28907250200171', '', 'ذكر', '', 'default.png', 'أسنان', 'اخصائي زراعة و تجميل الأسنان', 250, 13, 3, 80, 0),
(6, 'مي أحمد فؤاد', '', 33, '29004250301448', '', 'انثى', '', 'default.png', 'جلدية', 'اخصائية الجلدية والتجميل والليزر', 200, 0, 0, 80, 0),
(10, 'اسماء سليم فتحي', NULL, 38, '28503210210047', NULL, 'انثى', NULL, 'default.png', 'عيون', 'إستشارى طب و جراحه العيون', 100, 0, 0, 80, 0),
(11, 'سعيد السيد طارق', NULL, 38, '28503250212578', NULL, 'ذكر', NULL, 'default.png', 'جلدية', 'أخصائى أمراض جلدية و تجميل و ليزر', 150, 0, 0, 300, 0),
(12, 'مصطفى خميس حسن', NULL, 22, '30012200201194', NULL, 'ذكر', NULL, 'default.png', 'أمراض باطنة', NULL, 200, 3, 1, 400, 0);

-- --------------------------------------------------------

--
-- Table structure for table `labanalysis`
--

CREATE TABLE `labanalysis` (
  `ID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` enum('ذكر','انثى') NOT NULL,
  `chestPainType` enum('0','1','2','3','4') DEFAULT NULL,
  `bloodPressure` int(11) DEFAULT NULL,
  `cholesterol` float DEFAULT NULL,
  `maxHeartRate` float DEFAULT NULL,
  `exerciseAngina` enum('0','1') DEFAULT NULL,
  `plasmaGlucose` float DEFAULT NULL,
  `skinThickness` float DEFAULT NULL,
  `insulin` float DEFAULT NULL,
  `bmi` float DEFAULT NULL,
  `diabetesDegree` float DEFAULT NULL,
  `hypertension` enum('0','1') DEFAULT NULL,
  `heartDisease` enum('0','1') DEFAULT NULL,
  `Pregnancies` int(1) DEFAULT 0,
  `residenceType` enum('0','1') DEFAULT NULL,
  `smokingStatus` enum('never','light','moderate','high') DEFAULT NULL,
  `triage` enum('green','yellow','orange') DEFAULT NULL,
  `ray` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `labanalysis`
--

INSERT INTO `labanalysis` (`ID`, `patientID`, `age`, `gender`, `chestPainType`, `bloodPressure`, `cholesterol`, `maxHeartRate`, `exerciseAngina`, `plasmaGlucose`, `skinThickness`, `insulin`, `bmi`, `diabetesDegree`, `hypertension`, `heartDisease`, `Pregnancies`, `residenceType`, `smokingStatus`, `triage`, `ray`) VALUES
(1, 2, 23, 'ذكر', '', 0, 0.2, 0, '', 0, 0, 0, 0, 0, '', '', 0, '1', 'never', NULL, 'NULL'),
(2, 3, 23, 'ذكر', '0', 100, 223, 142, '', 109, 70, 109, 22, 22, '', '0', 0, '', 'never', 'yellow', ''),
(3, 5, 22, 'ذكر', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(4, 4, 22, 'ذكر', '1', 120, 0, 0, '', 2, 3, 5, 9, 1, '', '', 0, NULL, NULL, NULL, NULL),
(5, 6, 24, 'انثى', '1', 0, 0, 0, '1', 0, 0, 0, 0, 0, '', '', 0, '', 'never', NULL, NULL),
(6, 7, 31, 'انثى', '1', 130, 10, 50, '1', 2, 3, 10, 120, 130, '0', '0', 0, '0', 'never', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `nurses`
--

CREATE TABLE `nurses` (
  `ID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `age` int(2) NOT NULL,
  `nationalID` varchar(14) NOT NULL,
  `emailAddress` varchar(100) DEFAULT NULL,
  `gender` enum('ذكر','انثى') NOT NULL,
  `address` varchar(150) DEFAULT NULL,
  `photo` varchar(50) NOT NULL DEFAULT 'default.png',
  `specialization` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `nurses`
--

INSERT INTO `nurses` (`ID`, `name`, `phone`, `age`, `nationalID`, `emailAddress`, `gender`, `address`, `photo`, `specialization`) VALUES
(1, 'سلمى احمد رفعت', '', 23, '30001010200144', '', 'انثى', '', 'default.png', 'عيون'),
(2, 'اسماء سليم زكي', '', 25, '29805060201964', '', 'انثى', '', 'default.png', 'جلدية'),
(3, 'شيماء سعيد محمد', NULL, 25, '29802140213261', NULL, 'انثى', NULL, 'default.png', 'أنف وأذن وحنجرة'),
(4, 'يارا ابراهيم', NULL, 22, '30110300200626', NULL, 'انثى', NULL, 'default.png', 'أمراض باطنة');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `ID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `emergencyContact` varchar(11) DEFAULT NULL,
  `age` int(3) NOT NULL,
  `nationalID` varchar(14) NOT NULL,
  `emailAddress` varchar(100) DEFAULT NULL,
  `gender` enum('ذكر','انثى') NOT NULL,
  `address` varchar(150) DEFAULT NULL,
  `photo` varchar(50) NOT NULL DEFAULT 'default.png',
  `warnings` int(2) NOT NULL DEFAULT 0,
  `toPay` int(11) DEFAULT 0,
  `paid` int(11) NOT NULL DEFAULT 0,
  `reservations` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`ID`, `name`, `phone`, `emergencyContact`, `age`, `nationalID`, `emailAddress`, `gender`, `address`, `photo`, `warnings`, `toPay`, `paid`, `reservations`) VALUES
(2, 'احمد محمد صلاح', '01149651641', '01253889986', 23, '30001010200137', 'ahmed@yahoo.com', 'ذكر', 'سموحة', '644feb7517f8e.jpg', 0, 350, 0, 2),
(4, 'يوسف محمد', '01210181268', '01212736651', 22, '30106291500193', 'youssef@gmail.com', 'ذكر', 'طوسون', '64634bbed0e93.jpg', 0, 300, 0, 2),
(5, 'مش مصطفى خميس', NULL, NULL, 22, '30012200201175', NULL, 'ذكر', NULL, 'default.png', 0, 0, 0, 0),
(6, 'تسنيم حامد جميل', '01523154861', '01523154863', 24, '29904140212348', 'tasneem@yahoo.com', 'انثى', 'محرم بك', 'default.png', 0, 550, 0, 2),
(7, 'سمية خلف', NULL, NULL, 31, '29204140212348', NULL, 'انثى', NULL, 'default.png', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `receptionists`
--

CREATE TABLE `receptionists` (
  `ID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `age` int(2) NOT NULL,
  `nationalID` varchar(14) NOT NULL,
  `emailAddress` varchar(100) DEFAULT NULL,
  `gender` enum('ذكر','انثى') NOT NULL,
  `address` varchar(150) DEFAULT NULL,
  `photo` varchar(50) NOT NULL DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `receptionists`
--

INSERT INTO `receptionists` (`ID`, `name`, `phone`, `age`, `nationalID`, `emailAddress`, `gender`, `address`, `photo`) VALUES
(1, 'احمد محسن العباسي', '', 27, '29604250201257', '', 'ذكر', '', 'default.png'),
(3, 'زكي صلاح نجيب', '', 27, '29604250201297', '', 'ذكر', '', 'default.png');

-- --------------------------------------------------------

--
-- Table structure for table `reservationtable`
--

CREATE TABLE `reservationtable` (
  `ID` int(11) NOT NULL,
  `patientName` varchar(100) DEFAULT NULL,
  `patientPhone` varchar(11) DEFAULT NULL,
  `patientNID` varchar(14) DEFAULT NULL,
  `doctorID` int(11) NOT NULL,
  `reservedDateFrom` datetime NOT NULL,
  `reservedDateTo` datetime NOT NULL,
  `price` int(11) DEFAULT NULL,
  `reservedDay` enum('Sat','Sun','Mon','Tue','Wed','Thu') NOT NULL,
  `reservedDayAR` enum('السبت','الأحد','الاثنين','الثلاثاء','الأربعاء','الخميس') NOT NULL,
  `reservedBy` varchar(14) NOT NULL,
  `prescription` varchar(50) DEFAULT NULL,
  `isAvailable` enum('0','1') NOT NULL DEFAULT '1',
  `isBusy` enum('0','1') NOT NULL DEFAULT '0',
  `isRated` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reservationtable`
--

INSERT INTO `reservationtable` (`ID`, `patientName`, `patientPhone`, `patientNID`, `doctorID`, `reservedDateFrom`, `reservedDateTo`, `price`, `reservedDay`, `reservedDayAR`, `reservedBy`, `prescription`, `isAvailable`, `isBusy`, `isRated`) VALUES
(21, 'احمد محمد صلاح', '01149651641', '30001010200137', 5, '2023-05-12 20:15:00', '2023-05-12 20:30:00', 250, 'Thu', 'الخميس', '', '645eb61678278.jpg', '0', '1', '1'),
(71, NULL, NULL, NULL, 1, '2023-05-15 17:00:00', '2023-05-15 17:15:00', 180, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(72, 'احمد محمد صلاح', '01149651641', '30001010200137', 1, '2023-05-15 17:15:00', '2023-05-15 17:30:00', 180, 'Mon', 'الاثنين', '', NULL, '0', '1', '1'),
(73, NULL, NULL, NULL, 1, '2023-05-15 17:30:00', '2023-05-15 17:45:00', 180, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(74, NULL, NULL, NULL, 1, '2023-05-15 17:45:00', '2023-05-15 18:00:00', 180, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(75, NULL, NULL, NULL, 1, '2023-05-15 18:00:00', '2023-05-15 18:15:00', 180, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(76, NULL, NULL, NULL, 1, '2023-05-15 18:15:00', '2023-05-15 18:30:00', 180, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(77, NULL, NULL, NULL, 1, '2023-05-15 18:30:00', '2023-05-15 18:45:00', 180, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(78, NULL, NULL, NULL, 1, '2023-05-15 18:45:00', '2023-05-15 19:00:00', 180, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(79, NULL, NULL, NULL, 1, '2023-05-15 19:00:00', '2023-05-15 19:15:00', 180, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(80, NULL, NULL, NULL, 1, '2023-05-15 19:15:00', '2023-05-15 19:30:00', 180, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(81, NULL, NULL, NULL, 1, '2023-05-15 19:30:00', '2023-05-15 19:45:00', 180, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(82, NULL, NULL, NULL, 1, '2023-05-15 19:45:00', '2023-05-15 20:00:00', 180, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(83, NULL, NULL, NULL, 2, '2023-05-16 18:00:00', '2023-05-16 18:15:00', 250, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(84, 'احمد محمد صلاح', NULL, '30001010200137', 2, '2023-05-16 18:15:00', '2023-05-16 18:30:00', 250, 'Tue', 'الثلاثاء', '', NULL, '0', '1', '0'),
(85, NULL, NULL, NULL, 2, '2023-05-16 18:30:00', '2023-05-16 18:45:00', 250, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(86, NULL, NULL, NULL, 2, '2023-05-16 18:45:00', '2023-05-16 19:00:00', 250, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(87, 'تسنيم حامد جميل', '', '29904140212348', 2, '2023-05-16 19:00:00', '2023-05-16 19:15:00', 250, 'Tue', 'الثلاثاء', '29904140212348', NULL, '0', '1', '0'),
(88, NULL, NULL, NULL, 2, '2023-05-16 19:15:00', '2023-05-16 19:30:00', 250, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(89, NULL, NULL, NULL, 2, '2023-05-16 19:30:00', '2023-05-16 19:45:00', 250, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(90, NULL, NULL, NULL, 2, '2023-05-16 19:45:00', '2023-05-16 20:00:00', 250, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(91, 'شخص غير مسجل', '01148742321', '29811030312448', 3, '2023-05-17 16:00:00', '2023-05-17 16:15:00', 300, 'Wed', 'الأربعاء', '29604250201257', NULL, '0', '1', '0'),
(92, NULL, NULL, NULL, 3, '2023-05-17 16:15:00', '2023-05-17 16:30:00', 300, 'Wed', 'الأربعاء', '', NULL, '0', '0', '0'),
(93, 'تسنيم حامد جميل', '', '29904140212348', 3, '2023-05-17 16:30:00', '2023-05-17 16:45:00', 300, 'Wed', 'الأربعاء', '29904140212348', NULL, '0', '1', '0'),
(94, NULL, NULL, NULL, 3, '2023-05-17 16:45:00', '2023-05-17 17:00:00', 300, 'Wed', 'الأربعاء', '', NULL, '0', '0', '0'),
(95, NULL, NULL, NULL, 10, '2023-05-18 16:00:00', '2023-05-18 16:15:00', 100, 'Thu', 'الخميس', '', NULL, '0', '0', '0'),
(96, 'احمد محمد صلاح', '01149651641', '30001010200137', 10, '2024-05-23 16:15:00', '2024-05-23 16:30:00', 100, 'Thu', 'الخميس', '30001010200137', NULL, '1', '1', '0'),
(97, NULL, NULL, NULL, 10, '2024-05-23 16:30:00', '2024-05-23 16:45:00', 100, 'Thu', 'الخميس', '', NULL, '1', '0', '0'),
(98, NULL, NULL, NULL, 10, '2023-05-18 16:45:00', '2023-05-18 17:00:00', 100, 'Thu', 'الخميس', '', NULL, '0', '0', '0'),
(99, 'يوسف محمد', '', '30106291500193', 10, '2023-05-18 17:00:00', '2023-05-18 17:15:00', 100, 'Thu', 'الخميس', '30106291500193', NULL, '0', '1', '0'),
(100, NULL, NULL, NULL, 10, '2023-05-18 17:15:00', '2023-05-18 17:30:00', 100, 'Thu', 'الخميس', '', NULL, '0', '0', '0'),
(101, NULL, NULL, NULL, 10, '2023-05-18 17:30:00', '2023-05-18 17:45:00', 100, 'Thu', 'الخميس', '', NULL, '0', '0', '0'),
(102, NULL, NULL, NULL, 10, '2023-05-18 17:45:00', '2023-05-18 18:00:00', 100, 'Thu', 'الخميس', '', NULL, '0', '0', '0'),
(103, NULL, NULL, NULL, 2, '2023-05-22 21:00:00', '2023-05-22 21:15:00', 250, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(104, NULL, NULL, NULL, 2, '2023-05-22 21:15:00', '2023-05-22 21:30:00', 250, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(105, NULL, NULL, NULL, 2, '2023-05-22 21:30:00', '2023-05-22 21:45:00', 250, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(106, NULL, NULL, NULL, 2, '2023-05-22 21:45:00', '2023-05-22 22:00:00', 250, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(107, NULL, NULL, NULL, 2, '2023-05-22 22:00:00', '2023-05-22 22:15:00', 250, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(108, NULL, NULL, NULL, 2, '2023-05-22 22:15:00', '2023-05-22 22:30:00', 250, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(109, NULL, NULL, NULL, 2, '2023-05-22 22:30:00', '2023-05-22 22:45:00', 250, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(110, NULL, NULL, NULL, 2, '2023-05-22 22:45:00', '2023-05-22 23:00:00', 250, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(111, NULL, NULL, NULL, 3, '2023-05-25 16:00:00', '2023-05-25 16:15:00', 300, 'Thu', 'الخميس', '', NULL, '0', '0', '0'),
(112, NULL, NULL, NULL, 3, '2023-05-25 16:15:00', '2023-05-25 16:30:00', 300, 'Thu', 'الخميس', '', NULL, '0', '0', '0'),
(113, NULL, NULL, NULL, 3, '2023-05-25 16:30:00', '2023-05-25 16:45:00', 300, 'Thu', 'الخميس', '', NULL, '0', '0', '0'),
(114, NULL, NULL, NULL, 3, '2023-05-25 16:45:00', '2023-05-25 17:00:00', 300, 'Thu', 'الخميس', '', NULL, '0', '0', '0'),
(115, NULL, NULL, NULL, 3, '2023-05-25 17:00:00', '2023-05-25 17:15:00', 300, 'Thu', 'الخميس', '', NULL, '0', '0', '0'),
(116, NULL, NULL, NULL, 3, '2023-05-25 17:15:00', '2023-05-25 17:30:00', 300, 'Thu', 'الخميس', '', NULL, '0', '0', '0'),
(117, NULL, NULL, NULL, 3, '2023-05-25 17:30:00', '2023-05-25 17:45:00', 300, 'Thu', 'الخميس', '', NULL, '0', '0', '0'),
(118, NULL, NULL, NULL, 3, '2023-05-25 17:45:00', '2023-05-25 18:00:00', 300, 'Thu', 'الخميس', '', NULL, '0', '0', '0'),
(119, NULL, NULL, NULL, 3, '2023-05-25 18:00:00', '2023-05-25 18:15:00', 300, 'Thu', 'الخميس', '', NULL, '0', '0', '0'),
(120, NULL, NULL, NULL, 3, '2023-05-25 18:15:00', '2023-05-25 18:30:00', 300, 'Thu', 'الخميس', '', NULL, '0', '0', '0'),
(121, NULL, NULL, NULL, 3, '2023-05-25 18:30:00', '2023-05-25 18:45:00', 300, 'Thu', 'الخميس', '', NULL, '0', '0', '0'),
(122, NULL, NULL, NULL, 3, '2023-05-25 18:45:00', '2023-05-25 19:00:00', 300, 'Thu', 'الخميس', '', NULL, '0', '0', '0'),
(123, NULL, NULL, NULL, 5, '2023-05-27 14:00:00', '2023-05-27 14:15:00', 250, 'Sat', 'السبت', '', NULL, '0', '0', '0'),
(124, NULL, NULL, NULL, 5, '2023-05-27 14:15:00', '2023-05-27 14:30:00', 250, 'Sat', 'السبت', '', NULL, '0', '0', '0'),
(125, NULL, NULL, NULL, 5, '2023-05-27 14:30:00', '2023-05-27 14:45:00', 250, 'Sat', 'السبت', '', NULL, '0', '0', '0'),
(126, NULL, NULL, NULL, 5, '2023-05-27 14:45:00', '2023-05-27 15:00:00', 250, 'Sat', 'السبت', '', NULL, '0', '0', '0'),
(127, NULL, NULL, NULL, 5, '2023-05-27 15:00:00', '2023-05-27 15:15:00', 250, 'Sat', 'السبت', '', NULL, '0', '0', '0'),
(128, NULL, NULL, NULL, 5, '2023-05-27 15:15:00', '2023-05-27 15:30:00', 250, 'Sat', 'السبت', '', NULL, '0', '0', '0'),
(129, NULL, NULL, NULL, 5, '2023-05-27 15:30:00', '2023-05-27 15:45:00', 250, 'Sat', 'السبت', '', NULL, '0', '0', '0'),
(130, NULL, NULL, NULL, 5, '2023-05-27 15:45:00', '2023-05-27 16:00:00', 250, 'Sat', 'السبت', '', NULL, '0', '0', '0'),
(131, NULL, NULL, NULL, 12, '2023-05-17 09:00:00', '2023-05-17 09:15:00', 200, 'Wed', 'الأربعاء', '', NULL, '0', '0', '0'),
(132, NULL, NULL, NULL, 12, '2023-05-17 09:15:00', '2023-05-17 09:30:00', 200, 'Wed', 'الأربعاء', '', NULL, '0', '0', '0'),
(133, NULL, NULL, NULL, 12, '2023-05-17 09:30:00', '2023-05-17 09:45:00', 200, 'Wed', 'الأربعاء', '', NULL, '0', '0', '0'),
(134, NULL, NULL, NULL, 12, '2023-05-17 09:45:00', '2023-05-17 10:00:00', 200, 'Wed', 'الأربعاء', '', NULL, '0', '0', '0'),
(135, NULL, NULL, NULL, 12, '2023-05-17 10:00:00', '2023-05-17 10:15:00', 200, 'Wed', 'الأربعاء', '', NULL, '0', '0', '0'),
(136, NULL, NULL, NULL, 12, '2023-05-17 10:15:00', '2023-05-17 10:30:00', 200, 'Wed', 'الأربعاء', '', NULL, '0', '0', '0'),
(137, NULL, NULL, NULL, 12, '2023-05-17 10:30:00', '2023-05-17 10:45:00', 200, 'Wed', 'الأربعاء', '', NULL, '0', '0', '0'),
(138, NULL, NULL, NULL, 12, '2023-05-17 10:45:00', '2023-05-17 11:00:00', 200, 'Wed', 'الأربعاء', '', NULL, '0', '0', '0'),
(139, NULL, NULL, NULL, 12, '2023-05-16 12:00:00', '2023-05-16 12:15:00', 200, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(140, NULL, NULL, NULL, 12, '2023-05-16 12:15:00', '2023-05-16 12:30:00', 200, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(141, NULL, NULL, NULL, 12, '2023-05-16 12:30:00', '2023-05-16 12:45:00', 200, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(142, 'يوسف محمد', '01210181268', '30106291500193', 12, '2023-05-16 12:45:00', '2023-05-16 13:00:00', 200, 'Tue', 'الثلاثاء', '30106291500193', NULL, '0', '1', '1'),
(143, NULL, NULL, NULL, 4, '2023-05-16 12:00:00', '2023-05-16 12:15:00', 250, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(144, NULL, NULL, NULL, 4, '2023-05-16 12:15:00', '2023-05-16 12:30:00', 250, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(145, NULL, NULL, NULL, 4, '2023-05-16 12:30:00', '2023-05-16 12:45:00', 250, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(146, NULL, NULL, NULL, 4, '2023-05-16 12:45:00', '2023-05-16 13:00:00', 250, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(147, NULL, NULL, NULL, 4, '2023-05-16 13:00:00', '2023-05-16 13:15:00', 250, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(148, NULL, NULL, NULL, 4, '2023-05-16 13:15:00', '2023-05-16 13:30:00', 250, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(149, NULL, NULL, NULL, 4, '2023-05-16 13:30:00', '2023-05-16 13:45:00', 250, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(150, NULL, NULL, NULL, 4, '2023-05-16 13:45:00', '2023-05-16 14:00:00', 250, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(151, NULL, NULL, NULL, 6, '2023-05-27 15:00:00', '2023-05-27 15:15:00', 200, 'Sat', 'السبت', '', NULL, '0', '0', '0'),
(152, NULL, NULL, NULL, 6, '2023-05-27 15:15:00', '2023-05-27 15:30:00', 200, 'Sat', 'السبت', '', NULL, '0', '0', '0'),
(153, NULL, NULL, NULL, 6, '2023-05-27 15:30:00', '2023-05-27 15:45:00', 200, 'Sat', 'السبت', '', NULL, '0', '0', '0'),
(154, NULL, NULL, NULL, 6, '2023-05-27 15:45:00', '2023-05-27 16:00:00', 200, 'Sat', 'السبت', '', NULL, '0', '0', '0'),
(155, NULL, NULL, NULL, 6, '2023-05-27 16:00:00', '2023-05-27 16:15:00', 200, 'Sat', 'السبت', '', NULL, '0', '0', '0'),
(156, NULL, NULL, NULL, 6, '2023-05-27 16:15:00', '2023-05-27 16:30:00', 200, 'Sat', 'السبت', '', NULL, '0', '0', '0'),
(157, NULL, NULL, NULL, 6, '2023-05-27 16:30:00', '2023-05-27 16:45:00', 200, 'Sat', 'السبت', '', NULL, '0', '0', '0'),
(158, NULL, NULL, NULL, 6, '2023-05-27 16:45:00', '2023-05-27 17:00:00', 200, 'Sat', 'السبت', '', NULL, '0', '0', '0'),
(171, NULL, NULL, NULL, 12, '2023-05-28 19:00:00', '2023-05-28 19:15:00', 200, 'Sun', 'الأحد', '', NULL, '0', '0', '0'),
(172, NULL, NULL, NULL, 12, '2023-05-28 19:15:00', '2023-05-28 19:30:00', 200, 'Sun', 'الأحد', '', NULL, '0', '0', '0'),
(173, NULL, NULL, NULL, 12, '2023-05-28 19:30:00', '2023-05-28 19:45:00', 200, 'Sun', 'الأحد', '', NULL, '0', '0', '0'),
(174, NULL, NULL, NULL, 12, '2023-05-28 19:45:00', '2023-05-28 20:00:00', 200, 'Sun', 'الأحد', '', NULL, '0', '0', '0'),
(175, NULL, NULL, NULL, 12, '2023-05-28 20:00:00', '2023-05-28 20:15:00', 200, 'Sun', 'الأحد', '', NULL, '0', '0', '0'),
(176, NULL, NULL, NULL, 12, '2023-05-28 20:15:00', '2023-05-28 20:30:00', 200, 'Sun', 'الأحد', '', NULL, '0', '0', '0'),
(177, NULL, NULL, NULL, 12, '2023-05-28 20:30:00', '2023-05-28 20:45:00', 200, 'Sun', 'الأحد', '', NULL, '0', '0', '0'),
(178, NULL, NULL, NULL, 12, '2023-05-28 20:45:00', '2023-05-28 21:00:00', 200, 'Sun', 'الأحد', '', NULL, '0', '0', '0'),
(179, NULL, NULL, NULL, 10, '2024-05-23 18:00:00', '2024-05-23 18:15:00', 100, 'Sun', 'الأحد', '', NULL, '0', '0', '0'),
(180, NULL, NULL, NULL, 10, '2023-05-28 18:15:00', '2023-05-28 18:30:00', 100, 'Sun', 'الأحد', '', NULL, '0', '0', '0'),
(181, NULL, NULL, NULL, 10, '2023-05-28 18:30:00', '2023-05-28 18:45:00', 100, 'Sun', 'الأحد', '', NULL, '0', '0', '0'),
(182, NULL, NULL, NULL, 10, '2023-05-28 18:45:00', '2023-05-28 19:00:00', 100, 'Sun', 'الأحد', '', NULL, '0', '0', '0'),
(183, NULL, NULL, NULL, 10, '2023-05-28 19:00:00', '2023-05-28 19:15:00', 100, 'Sun', 'الأحد', '', NULL, '0', '0', '0'),
(184, NULL, NULL, NULL, 10, '2023-05-28 19:15:00', '2023-05-28 19:30:00', 100, 'Sun', 'الأحد', '', NULL, '0', '0', '0'),
(185, NULL, NULL, NULL, 10, '2023-05-28 19:30:00', '2023-05-28 19:45:00', 100, 'Sun', 'الأحد', '', NULL, '0', '0', '0'),
(186, NULL, NULL, NULL, 10, '2023-05-28 19:45:00', '2023-05-28 20:00:00', 100, 'Sun', 'الأحد', '', NULL, '0', '0', '0'),
(187, NULL, NULL, NULL, 11, '2023-05-23 16:00:00', '2023-05-23 16:15:00', 150, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(188, NULL, NULL, NULL, 11, '2023-05-23 16:15:00', '2023-05-23 16:30:00', 150, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(189, NULL, NULL, NULL, 11, '2023-05-23 16:30:00', '2023-05-23 16:45:00', 150, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(190, NULL, NULL, NULL, 11, '2023-05-23 16:45:00', '2023-05-23 17:00:00', 150, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(191, NULL, NULL, NULL, 11, '2023-05-23 17:00:00', '2023-05-23 17:15:00', 150, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(192, NULL, NULL, NULL, 11, '2023-05-23 17:15:00', '2023-05-23 17:30:00', 150, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(193, NULL, NULL, NULL, 11, '2023-05-23 17:30:00', '2023-05-23 17:45:00', 150, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(194, NULL, NULL, NULL, 11, '2023-05-23 17:45:00', '2023-05-23 18:00:00', 150, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(195, NULL, NULL, NULL, 11, '2023-05-23 18:00:00', '2023-05-23 18:15:00', 150, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(196, NULL, NULL, NULL, 11, '2023-05-23 18:15:00', '2023-05-23 18:30:00', 150, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(197, NULL, NULL, NULL, 11, '2023-05-23 18:30:00', '2023-05-23 18:45:00', 150, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(198, NULL, NULL, NULL, 11, '2023-05-23 18:45:00', '2023-05-23 19:00:00', 150, 'Tue', 'الثلاثاء', '', NULL, '0', '0', '0'),
(199, NULL, NULL, NULL, 1, '2023-05-24 17:00:00', '2023-05-24 17:15:00', 180, 'Wed', 'الأربعاء', '', NULL, '0', '0', '0'),
(200, NULL, NULL, NULL, 1, '2023-05-24 17:15:00', '2023-05-24 17:30:00', 180, 'Wed', 'الأربعاء', '', NULL, '0', '0', '0'),
(201, NULL, NULL, NULL, 1, '2023-05-24 17:30:00', '2023-05-24 17:45:00', 180, 'Wed', 'الأربعاء', '', NULL, '0', '0', '0'),
(202, NULL, NULL, NULL, 1, '2023-05-24 17:45:00', '2023-05-24 18:00:00', 180, 'Wed', 'الأربعاء', '', NULL, '0', '0', '0'),
(203, NULL, NULL, NULL, 1, '2023-05-24 18:00:00', '2023-05-24 18:15:00', 180, 'Wed', 'الأربعاء', '', NULL, '0', '0', '0'),
(204, NULL, NULL, NULL, 1, '2023-05-24 18:15:00', '2023-05-24 18:30:00', 180, 'Wed', 'الأربعاء', '', NULL, '0', '0', '0'),
(205, NULL, NULL, NULL, 1, '2023-05-24 18:30:00', '2023-05-24 18:45:00', 180, 'Wed', 'الأربعاء', '', NULL, '0', '0', '0'),
(206, NULL, NULL, NULL, 1, '2023-05-24 18:45:00', '2023-05-24 19:00:00', 180, 'Wed', 'الأربعاء', '', NULL, '0', '0', '0'),
(207, NULL, NULL, NULL, 12, '2023-12-11 18:00:00', '2023-12-11 18:15:00', 200, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(208, NULL, NULL, NULL, 12, '2023-12-11 18:15:00', '2023-12-11 18:30:00', 200, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(209, NULL, NULL, NULL, 12, '2023-12-11 18:30:00', '2023-12-11 18:45:00', 200, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(210, NULL, NULL, NULL, 12, '2023-12-11 18:45:00', '2023-12-11 19:00:00', 200, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(211, NULL, NULL, NULL, 12, '2023-12-11 19:00:00', '2023-12-11 19:15:00', 200, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(212, NULL, NULL, NULL, 12, '2023-12-11 19:15:00', '2023-12-11 19:30:00', 200, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(213, NULL, NULL, NULL, 12, '2023-12-11 19:30:00', '2023-12-11 19:45:00', 200, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(214, NULL, NULL, NULL, 12, '2023-12-11 19:45:00', '2023-12-11 20:00:00', 200, 'Mon', 'الاثنين', '', NULL, '0', '0', '0'),
(215, NULL, NULL, NULL, 3, '2023-12-09 18:00:00', '2023-12-09 18:15:00', 300, 'Thu', 'الخميس', '', NULL, '0', '0', '0'),
(216, NULL, NULL, NULL, 3, '2023-12-07 18:15:00', '2023-12-07 18:30:00', 300, 'Thu', 'الخميس', '', NULL, '0', '0', '0'),
(217, NULL, NULL, NULL, 3, '2023-12-07 18:30:00', '2023-12-07 18:45:00', 300, 'Thu', 'الخميس', '', NULL, '0', '0', '0'),
(218, NULL, NULL, NULL, 3, '2023-12-07 18:45:00', '2023-12-07 19:00:00', 300, 'Thu', 'الخميس', '', NULL, '0', '0', '0'),
(219, NULL, NULL, NULL, 5, '2024-04-20 21:00:00', '2024-04-20 21:15:00', 250, 'Sat', 'السبت', '', NULL, '0', '0', '0'),
(220, NULL, NULL, NULL, 5, '2024-04-20 21:15:00', '2024-04-20 21:30:00', 250, 'Sat', 'السبت', '', NULL, '0', '0', '0'),
(221, NULL, NULL, NULL, 5, '2024-04-20 21:30:00', '2024-04-20 21:45:00', 250, 'Sat', 'السبت', '', NULL, '0', '0', '0'),
(222, NULL, NULL, NULL, 5, '2024-04-20 21:45:00', '2024-04-20 22:00:00', 250, 'Sat', 'السبت', '', NULL, '0', '0', '0'),
(223, NULL, NULL, NULL, 5, '2024-04-20 22:00:00', '2024-04-20 22:15:00', 250, 'Sat', 'السبت', '', NULL, '0', '0', '0'),
(224, NULL, NULL, NULL, 5, '2024-04-20 22:15:00', '2024-04-20 22:30:00', 250, 'Sat', 'السبت', '', NULL, '0', '0', '0'),
(225, NULL, NULL, NULL, 5, '2024-04-20 22:30:00', '2024-04-20 22:45:00', 250, 'Sat', 'السبت', '', NULL, '0', '0', '0'),
(226, NULL, NULL, NULL, 5, '2024-04-20 22:45:00', '2024-04-20 23:00:00', 250, 'Sat', 'السبت', '', NULL, '0', '0', '0'),
(227, NULL, NULL, NULL, 1, '2024-05-25 22:00:00', '2024-05-25 22:15:00', 180, 'Sat', 'السبت', '', NULL, '1', '0', '0'),
(228, NULL, NULL, NULL, 1, '2024-05-25 22:15:00', '2024-05-25 22:30:00', 180, 'Sat', 'السبت', '', NULL, '1', '0', '0'),
(229, NULL, NULL, NULL, 1, '2024-05-25 22:30:00', '2024-05-25 22:45:00', 180, 'Sat', 'السبت', '', NULL, '1', '0', '0'),
(230, NULL, NULL, NULL, 1, '2024-05-25 22:45:00', '2024-05-25 23:00:00', 180, 'Sat', 'السبت', '', NULL, '1', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `specializations`
--

CREATE TABLE `specializations` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `doctorID` int(11) DEFAULT NULL,
  `nurseID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `specializations`
--

INSERT INTO `specializations` (`ID`, `name`, `doctorID`, `nurseID`) VALUES
(2, 'أنف وأذن وحنجرة', 4, 3),
(3, 'أسنان', 2, NULL),
(4, 'أسنان', 5, NULL),
(6, 'جلدية', 6, 2),
(7, 'عيون', 3, 1),
(11, 'أنف وأذن وحنجرة', 1, 3),
(15, 'عيون', 10, 1),
(16, 'جلدية', 11, 2),
(18, 'أمراض باطنة', 12, 4);

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE `timetable` (
  `ID` int(11) NOT NULL,
  `day` varchar(50) NOT NULL,
  `dayAR` varchar(50) NOT NULL,
  `specialization` varchar(50) NOT NULL,
  `doctorName` varchar(50) NOT NULL,
  `doctorID` int(10) NOT NULL,
  `currentWeek` date DEFAULT NULL,
  `cWeekFrom` time NOT NULL,
  `cWeekTo` time NOT NULL,
  `nextWeek` date DEFAULT NULL,
  `nWeekFrom` time NOT NULL,
  `nWeekTo` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `timetable`
--

INSERT INTO `timetable` (`ID`, `day`, `dayAR`, `specialization`, `doctorName`, `doctorID`, `currentWeek`, `cWeekFrom`, `cWeekTo`, `nextWeek`, `nWeekFrom`, `nWeekTo`) VALUES
(1, 'Sat', 'السبت', 'أسنان', 'اسماعيل محمد خلف', 5, '2023-04-29', '00:00:00', '00:00:00', NULL, '00:00:00', '00:00:00'),
(2, 'Sun', 'الأحد', 'أنف وأذن وحنجرة', 'صالح محمد علي', 4, '2023-04-30', '00:00:00', '00:00:00', NULL, '00:00:00', '00:00:00'),
(3, 'Thu', 'الخميس', 'عيون', 'ثناء خالد', 3, '2023-05-04', '00:00:00', '00:00:00', NULL, '00:00:00', '00:00:00'),
(4, 'Wed', 'الأربعاء', 'أسنان', 'محمد حسن', 2, '2023-05-03', '00:00:00', '00:00:00', NULL, '00:00:00', '00:00:00'),
(5, 'Mon', 'الاثنين', 'أنف وأذن وحنجرة', 'صالح محمد علي', 4, '2023-05-01', '00:00:00', '00:00:00', NULL, '00:00:00', '00:00:00'),
(6, 'Mon', 'الاثنين', 'جلدية', 'احمد صلاح', 1, '2023-05-01', '00:00:00', '00:00:00', NULL, '00:00:00', '00:00:00'),
(7, 'Sun', 'الأحد', 'أسنان', 'اسماعيل محمد خلف', 5, '2023-04-30', '00:00:00', '00:00:00', NULL, '00:00:00', '00:00:00'),
(8, 'Sat', 'السبت', 'أسنان', 'اسماعيل محمد خلف', 5, '2023-05-13', '14:00:00', '15:00:00', NULL, '00:00:00', '00:00:00'),
(9, 'Mon', 'الاثنين', 'أسنان', 'محمد حسن', 2, '2023-05-01', '00:00:00', '00:00:00', NULL, '00:00:00', '00:00:00'),
(10, 'Sat', 'السبت', 'أسنان', 'محمد حسن', 2, '2023-04-29', '00:00:00', '00:00:00', NULL, '00:00:00', '00:00:00'),
(11, 'Thu', 'الخميس', 'عيون', 'ثناء خالد', 3, '2023-12-07', '20:00:00', '22:00:00', NULL, '00:00:00', '00:00:00'),
(12, 'Sat', 'السبت', 'عيون', 'ثناء خالد', 3, '2023-04-29', '00:00:00', '00:00:00', NULL, '00:00:00', '00:00:00'),
(13, 'Mon', 'الاثنين', 'جلدية', 'احمد صلاح', 1, '2023-05-08', '16:00:00', '22:00:00', NULL, '00:00:00', '00:00:00'),
(15, 'Wed', 'الأربعاء', 'عيون', 'ثناء خالد', 3, '2023-05-10', '13:00:00', '17:00:00', NULL, '00:00:00', '00:00:00'),
(16, 'Sat', 'السبت', 'جلدية', 'مي أحمد فؤاد', 6, '2023-05-06', '12:00:00', '17:00:00', NULL, '00:00:00', '00:00:00'),
(19, 'Sun', 'الأحد', 'أنف وأذن وحنجرة', 'صالح محمد علي', 4, '2023-05-07', '12:00:00', '18:00:00', NULL, '00:00:00', '00:00:00'),
(20, 'Sun', 'الأحد', 'أسنان', 'اسماعيل محمد خلف', 5, '2023-05-14', '00:00:00', '00:00:00', NULL, '00:00:00', '00:00:00'),
(21, 'Wed', 'الأربعاء', 'جلدية', 'احمد صلاح', 1, '2023-05-10', '12:00:00', '18:00:00', NULL, '00:00:00', '00:00:00'),
(32, 'Mon', 'الاثنين', 'أنف وأذن وحنجرة', 'احمد صلاح', 1, '2023-05-15', '17:00:00', '20:00:00', NULL, '00:00:00', '00:00:00'),
(33, 'Tue', 'الثلاثاء', 'أسنان', 'محمد حسن', 2, '2023-05-16', '18:00:00', '20:00:00', NULL, '00:00:00', '00:00:00'),
(34, 'Wed', 'الأربعاء', 'عيون', 'ثناء خالد', 3, '2023-05-17', '16:00:00', '17:00:00', NULL, '00:00:00', '00:00:00'),
(35, 'Thu', 'الخميس', 'عيون', 'اسماء سليم فتحي', 10, '2024-05-23', '16:00:00', '18:00:00', NULL, '00:00:00', '00:00:00'),
(36, 'Mon', 'الاثنين', 'أسنان', 'محمد حسن', 2, NULL, '00:00:00', '00:00:00', '2023-05-22', '21:00:00', '23:00:00'),
(37, 'Thu', 'الخميس', 'عيون', 'ثناء خالد', 3, NULL, '00:00:00', '00:00:00', '2023-05-25', '16:00:00', '19:00:00'),
(38, 'Sat', 'السبت', 'أسنان', 'اسماعيل محمد خلف', 5, NULL, '00:00:00', '00:00:00', '2023-05-27', '14:00:00', '16:00:00'),
(39, 'Wed', 'الأربعاء', 'أمراض باطنة', 'مصطفى خميس حسن', 12, '2023-05-17', '09:00:00', '11:00:00', NULL, '00:00:00', '00:00:00'),
(40, 'Tue', 'الثلاثاء', 'أمراض باطنة', 'مصطفى خميس حسن', 12, '2023-05-16', '09:00:00', '11:00:00', NULL, '00:00:00', '00:00:00'),
(41, 'Tue', 'الثلاثاء', 'أنف وأذن وحنجرة', 'صالح محمد علي', 4, '2023-05-16', '12:00:00', '14:00:00', NULL, '00:00:00', '00:00:00'),
(42, 'Sat', 'السبت', 'جلدية', 'مي أحمد فؤاد', 6, NULL, '00:00:00', '00:00:00', '2023-05-27', '15:00:00', '17:00:00'),
(44, 'Sun', 'الأحد', 'أمراض باطنة', 'مصطفى خميس حسن', 12, NULL, '00:00:00', '00:00:00', '2023-05-28', '19:00:00', '21:00:00'),
(45, 'Sun', 'الأحد', 'عيون', 'اسماء سليم فتحي', 10, NULL, '00:00:00', '00:00:00', '2023-05-28', '18:00:00', '20:00:00'),
(46, 'Tue', 'الثلاثاء', 'جلدية', 'سعيد السيد طارق', 11, NULL, '00:00:00', '00:00:00', '2023-05-23', '16:00:00', '19:00:00'),
(47, 'Wed', 'الأربعاء', 'أنف وأذن وحنجرة', 'احمد صلاح', 1, NULL, '00:00:00', '00:00:00', '2023-05-24', '17:00:00', '19:00:00'),
(48, 'Mon', 'الاثنين', 'أمراض باطنة', 'مصطفى خميس حسن', 12, NULL, '00:00:00', '00:00:00', '2023-12-11', '18:00:00', '20:00:00'),
(49, 'Sat', 'السبت', 'أسنان', 'اسماعيل محمد خلف', 5, NULL, '00:00:00', '00:00:00', '2024-04-20', '21:00:00', '23:00:00'),
(50, 'Sat', 'السبت', 'أنف وأذن وحنجرة', 'احمد صلاح', 1, '2024-05-18', '22:00:00', '23:00:00', NULL, '00:00:00', '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `userID` varchar(14) NOT NULL,
  `userPW` varchar(200) NOT NULL,
  `role` enum('100','1','2','3','4') NOT NULL,
  `createdBy` varchar(14) DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `isLogged` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `userID`, `userPW`, `role`, `createdBy`, `createdAt`, `isLogged`) VALUES
(5, '30251489745632', '$2y$10$dHpnElItzCUTvbfpjmyjSeA8QoUx0A4.2hHCxD8QwJgL4rYHI5Bv6\n', '2', '28912280210318', '2023-04-30 19:30:21', '0'),
(6, '29604250201257', '$2y$10$dtIqlRKuXuEEyHnBulezluwuz.ro/dWFJlj6y8p7Dj/Vg1ex6bwnS', '3', '28912280210318', '2023-04-30 19:32:59', '0'),
(10, '28907250200137', '$2y$10$ZNuckoLyxqcxF0cXN2aX6eoF.DpYQ3OsEn2tl14v8SHIN141UVQbW\n', '1', '28912280210318', '2023-05-01 15:23:40', '0'),
(11, '28907250200157', '$2y$10$p6JsMh.h.nOC7ueTy3XDoujqnsCieOIW5LPVXWeixPtFBZOiVTJly', '1', '28912280210318', '2023-05-01 15:26:52', '0'),
(12, '28907250200177', '$2y$10$SpGzsXqOcn56OHPyzst.yeJ3Xjr8au6qaCZMlcJE/Yub.Qabeyz82\n', '1', '28912280210318', '2023-05-01 15:29:03', '0'),
(13, '28907250200179', '$2y$10$cGTnaj3LtmINf8p2GWr01OAfc6lmlVjOgscBCioipr/v3aRH6eqtu', '1', '28912280210318', '2023-05-01 15:29:42', '0'),
(16, '28907250200171', '$2y$10$WvDfIP/thUMcOLHl.Fo/HuLCibnztOUUOLohB31dhkRoJaLjA4b.K', '1', '28912280210318', '2023-05-01 15:31:17', '0'),
(17, '30001010200144', '$2y$10$XSFfiMTx1af86ESqyZavyuAnBdqM3aRctSKRt3UlxZAHSMZ7Ki2.6', '2', '28912280210318', '2023-05-01 15:49:45', '0'),
(18, '30001010200137', '$2y$10$9ChN9jKhimdTxpXIF3ihM.aEwWESSlawA9Ua8yDdLrUP.GVJIQFWm', '4', '28912280210318', '2023-05-01 16:01:21', '0'),
(19, '29604250201277', '$2y$10$5MzK9veVvnPx8tHDtbNb8uX9zLLfM.wFkVHy.p6Hcuja3/z8hvxHW', '3', '28912280210318', '2023-05-01 16:23:23', '0'),
(20, '29604250201297', '$2y$10$BqWgD63mxnro0x6Cfgc4/.nPLS0qWCw2tWbdXKCOCx29G7omscS9S', '3', '28912280210318', '2023-05-01 16:24:31', '0'),
(22, '29805060201964', '$2y$10$.BDB6Nf6jpxT3aMfF4l9Ye0p8hrxB5qWBNyhDEHD8ZurelvN8OTYS', '2', '28912280210318', '2023-05-05 14:24:05', '0'),
(23, '28905240203058', '$2y$10$pbWXrkoZw6nQ16Q4VZ9xOe1MVYCs/TEEEGoygHirqZQQzflxL.ZAS', '1', '28912280210318', '2023-05-06 14:49:56', '0'),
(24, '28503210210047', '$2y$10$Gmtt5cBI.zH4Sbe8T0zS8eOlqee5JIx.J318wQNBiBoPEB8jcJYzW', '1', '28912280210318', '2023-05-09 20:45:49', '0'),
(27, '28503250212578', '$2y$10$51jkcPIkteKg9hlmtxFv2.IHNfvhRkbIG5BkGyGXT2kUUzJGJ6v0i', '1', '28912280210318', '2023-05-10 14:37:35', '0'),
(28, '29802140213261', '$2y$10$2SvDJrG4QSJ45YaJegFJ4uFTQGftiSX8hIem4CWoVH02zInY.0RO6', '2', '28912280210318', '2023-05-11 14:52:44', '0'),
(30, '30012200201194', '$2y$10$PT4wVda0s9h0OxFx89cTgeRG9tXZrunNXP6uc.mNyw1uEcMtUqtbq', '1', '28912280210318', '2023-05-16 11:10:37', '0'),
(31, '30106291500193', '$2y$10$mguP5aCX8gSwgt4I55VNLu23RMQ8/4g6PHNR3aiYdLGtyg3uoERgm', '4', '28912280210318', '2023-05-16 11:11:17', '0'),
(32, '30110300200626', '$2y$10$cAxfyOD1IFm14tFZVipDme0foFBY/RNjsaU8K1UDXeXi6PT9QvHrq', '2', '28912280210318', '2023-05-16 11:12:48', '0'),
(33, '30012200201175', '$2y$10$Vzkm98O5OPzg3G83wdPfiegsoTf0xnaToudrV4ri9fxz.xRoFIwBW', '4', '30109280201258', '2023-05-16 12:45:48', '0'),
(34, '29904140212348', '$2y$10$HcqY7NXTkDtzSWbzcQCHH.AgX9yHmDXR0pBiOafh0gHYmejxRb7Fa', '4', '30109280201258', '2023-05-16 17:20:52', '0'),
(35, '29204140212348', '$2y$10$cbDAn7bi.e30zzc00ppSPeWfKTAbRnAthh4s8T3XDTWvw.ovjgoju', '4', '29604250201297', '2023-12-08 17:45:58', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `userID` (`userID`),
  ADD UNIQUE KEY `nationalID` (`nationalID`),
  ADD UNIQUE KEY `emailAddress` (`emailAddress`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD UNIQUE KEY `nationalID` (`nationalID`,`emailAddress`);

--
-- Indexes for table `labanalysis`
--
ALTER TABLE `labanalysis`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `patientID_2` (`patientID`),
  ADD UNIQUE KEY `patientID_3` (`patientID`),
  ADD KEY `patientID` (`patientID`);

--
-- Indexes for table `nurses`
--
ALTER TABLE `nurses`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `specialization` (`specialization`),
  ADD UNIQUE KEY `nationalID` (`nationalID`,`emailAddress`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `nationalID` (`nationalID`,`emailAddress`);

--
-- Indexes for table `receptionists`
--
ALTER TABLE `receptionists`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `nationalID` (`nationalID`,`emailAddress`);

--
-- Indexes for table `reservationtable`
--
ALTER TABLE `reservationtable`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `specializations`
--
ALTER TABLE `specializations`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `doctorID` (`doctorID`);

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD KEY `doctorID` (`doctorID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `userID` (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `labanalysis`
--
ALTER TABLE `labanalysis`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `nurses`
--
ALTER TABLE `nurses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `receptionists`
--
ALTER TABLE `receptionists`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reservationtable`
--
ALTER TABLE `reservationtable`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT for table `specializations`
--
ALTER TABLE `specializations`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
