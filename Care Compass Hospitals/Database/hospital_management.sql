-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 17, 2025 at 11:09 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospital_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
CREATE TABLE IF NOT EXISTS `appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch` varchar(50) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient_name` varchar(100) NOT NULL,
  `nic` varchar(12) NOT NULL,
  `birthday` date NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `appointment_date` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `doctor_id` (`doctor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `branch`, `doctor_id`, `patient_name`, `nic`, `birthday`, `phone_number`, `address`, `appointment_date`, `created_at`) VALUES
(20, 'Kandy', 1004, 'Kumara Silva', '200256451236', '2002-06-18', '0712536456', 'No 563/5 Colombo Rode,Wattala', '2025-03-21 10:00:00', '2025-03-17 19:19:42'),
(19, 'Galle', 1001, 'Dinushika Perera', '200345782546', '2025-04-10', '071895623452', 'No 256 malabe ', '2025-03-16 16:00:00', '2025-03-16 18:22:44'),
(17, 'Colombo', 1009, 'Ksun silva', '200145234563', '2001-05-25', '0710236512', 'NO 258 Colombo', '2025-03-15 08:00:00', '2025-03-16 18:19:34'),
(18, 'Kandy', 1003, 'samansiri', '200214523678', '2002-04-05', '0758956123', 'no 456 Kaluthara rode , kaluthara', '2025-03-21 11:55:00', '2025-03-16 18:20:59');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

DROP TABLE IF EXISTS `doctors`;
CREATE TABLE IF NOT EXISTS `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `specialty` varchar(100) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `specialty`, `contact`, `email`, `password`, `created_at`) VALUES
(1009, 'Dr. Malini Fernando', 'Neurology Emergency', '0784512369', 'malani@cearcompass.lk', '145289', '2025-03-16 18:10:12'),
(1003, 'Dr. Sunil Rathnayake', 'Emergency Medicine', '0754512369', 'sunil@cearcompass.lk', '145236', '2025-03-16 18:09:21'),
(1002, 'Dr. Dilani Perera', 'Critical Care', '0764512456', 'dilini@cearcompass.lk', '1234569', '2025-03-16 18:08:32'),
(1001, 'Dr. Samanthi Silva', 'Lead Pediatrician', '0112536456', 'samanthi@cearcompass.lk', '778899', '2025-03-16 18:06:52'),
(1004, 'Dr. Amara Perera', 'Chief of Surgery', '0768105310', 'amara@carecompass.lk', '147852', '2025-03-16 18:03:04'),
(1006, 'Dr. Nimal Fernando', 'Head of Cardiology', '0714523456', 'nimal@creacompas.lk', '456123', '2025-03-16 18:04:31');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `feedback_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `feedback_text`, `created_at`) VALUES
(1, 'Dulara Sandamal', 'gfbdvxccv', '2025-02-19 18:14:33'),
(2, 'admin', 'nice !!!!', '2025-03-09 18:25:30'),
(3, 'admin', 'nice !!!!', '2025-03-09 18:48:24'),
(4, 'Dinushika', 'nice Doctors ðŸ˜ðŸ˜ðŸ˜', '2025-03-11 14:54:02'),
(5, 'gihan', 'nice ðŸ˜ðŸ˜ðŸ˜', '2025-03-15 04:31:28');

-- --------------------------------------------------------

--
-- Table structure for table `lab_reports`
--

DROP TABLE IF EXISTS `lab_reports`;
CREATE TABLE IF NOT EXISTS `lab_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nic` varchar(20) NOT NULL,
  `report_date` date NOT NULL,
  `report_file` varchar(255) NOT NULL,
  `upload_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lab_reports`
--

INSERT INTO `lab_reports` (`id`, `nic`, `report_date`, `report_file`, `upload_time`) VALUES
(1, '200272000503', '2025-02-05', 'Dulara Sandamal_.pdf', '2025-02-17 18:39:41'),
(2, '200272000503', '2025-02-12', '4235621-200.png', '2025-02-17 18:39:57'),
(3, '200272000503', '2025-02-12', '4235621-200.png', '2025-02-17 18:50:32'),
(4, '200272000503', '2025-02-13', '4235621-200.png', '2025-02-17 18:53:44'),
(5, '200223801828', '2025-02-13', 'Lecture Materials - 121.pdf', '2025-02-17 18:55:25'),
(6, '200223801828', '2025-02-13', 'Lecture Materials - 121.pdf', '2025-02-17 18:55:53'),
(7, '200272000503', '2025-02-07', 'Dulara Sandamal_.pdf', '2025-02-17 18:56:11'),
(8, '20152365879', '2025-02-13', 'Dulara Sandamal_.pdf', '2025-02-22 09:06:08'),
(9, '20023645213', '2025-03-13', 'neww.jpg', '2025-03-13 15:34:24'),
(10, '20023645213', '2025-03-14', 'Lecture Materials - 121.pdf', '2025-03-13 15:45:50'),
(11, '20023645213', '2025-03-28', 'Lecture Materials - 121.pdf', '2025-03-13 15:47:58'),
(12, '200225458936', '2025-03-13', 'Lecture Materials - 121.pdf', '2025-03-15 14:43:33');

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

DROP TABLE IF EXISTS `prescriptions`;
CREATE TABLE IF NOT EXISTS `prescriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nic` varchar(20) NOT NULL,
  `patient_id` varchar(20) NOT NULL,
  `medication_name` varchar(100) NOT NULL,
  `dosage` varchar(50) NOT NULL,
  `prescription_file` varchar(255) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`id`, `nic`, `patient_id`, `medication_name`, `dosage`, `prescription_file`, `upload_date`) VALUES
(1, '200272000503', '011', 'panadol', 'oluwe kakkuma', '4235621-200.png', '2025-02-17 19:13:00'),
(2, '200272000503', '011', 'panadol', 'oluwe kakkuma', '4235621-200.png', '2025-02-17 19:27:45'),
(3, '200225458936', '011', 'panadol', 'oluwe kakkuma', 'Lecture Materials - 121.pdf', '2025-03-15 18:04:45'),
(4, '200225458936', '011', 'panadol', 'oluwe kakkuma', 'Lecture Materials - 121.pdf', '2025-03-15 18:07:32'),
(5, '200223801828', '0118', 'panadol', 'oluwe kakkuma', 'Dulara Sandamal_.pdf', '2025-03-15 18:09:05');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
CREATE TABLE IF NOT EXISTS `staff` (
  `epf` int(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` int(10) NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`epf`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`epf`, `name`, `position`, `address`, `phone`, `password`) VALUES
(2222, 'Dulara Sandamal', 'nurse', '416/62/2 Atabagahawatta, Demanhandiya', 712563456, '5555'),
(1000, 'admin', 'admin', '416/62/2Atabagahawaththa,Damnhanadiya', 710338510, 'admin'),
(5000, 'kumra', 'nurse', '416/62/2Atabagahawaththa,Damnhanadiya', 710338510, '666'),
(5, 'Saman', 'admin', 'NO 526 Negombo', 710338510, '111111'),
(8080, 'Dinushika', 'nurse', 'No 256 Colombo', 712312456, '505050'),
(80, 'Deshan', 'nurse', '416/62/2Atabagahawaththa,Damnhanadiya', 710338510, '102030');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nic` varchar(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `payment_status` enum('success','failed') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `nic`, `amount`, `transaction_id`, `payment_status`, `created_at`) VALUES
(1, '200225458936', '100.00', '67cdda260235f', 'success', '2025-03-09 18:12:54'),
(2, '200225458936', '100.00', '67cddb54c50cb', 'success', '2025-03-09 18:17:56'),
(3, '200225458936', '100.00', '67cddbcc85aa7', 'success', '2025-03-09 18:19:56'),
(4, '200215452378', '100.00', '67cddc056bbcc', 'success', '2025-03-09 18:20:53'),
(5, '200215452378', '100.00', '67cdde1d0f17f', 'success', '2025-03-09 18:29:49'),
(6, '200215452378', '100.00', '67cddf0c3e0a9', 'success', '2025-03-09 18:33:48'),
(7, '200215452378', '100.00', '67cddf153a55d', 'success', '2025-03-09 18:33:57'),
(8, '200223801828', '100.00', '67cddf4a5721e', 'success', '2025-03-09 18:34:50'),
(9, '200223801828', '2500.00', '67cde056f0ea0', 'success', '2025-03-09 18:39:18'),
(10, '200223801828', '2500.00', '67cde095612d3', 'success', '2025-03-09 18:40:21'),
(11, '20023645213', '2500.00', '67cde10b377db', 'success', '2025-03-09 18:42:19'),
(12, '200225458936', '2500.00', '67d04cb6bc735', 'success', '2025-03-11 14:46:14'),
(13, '20023645213', '2500.00', '67d04d88bf374', 'success', '2025-03-11 14:49:44'),
(14, '200225458936', '2500.00', '67d521df41468', 'success', '2025-03-15 06:44:47'),
(15, '200145234563', '2500.00', '67d71636e33bb', 'success', '2025-03-16 18:19:34'),
(16, '200214523678', '2500.00', '67d7168b6a7ec', 'success', '2025-03-16 18:20:59'),
(17, '200345782546', '2500.00', '67d716f4bc14f', 'success', '2025-03-16 18:22:44'),
(18, '200256451236', '2500.00', '67d875ce55521', 'success', '2025-03-17 19:19:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `address` text NOT NULL,
  `dob` date NOT NULL,
  `nic` varchar(12) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password` (`password`) USING HASH
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `gender`, `address`, `dob`, `nic`, `phone_number`, `email`, `password`) VALUES
(7, 'Dulara', 'Sandamal', 'female', '416/62/2Atabagahawaththa,Damnhanadiya\r\n416\\62\\2 Atabghawaththa Damanhandiya', '2025-02-13', '200223801827', '0710338510', 'dularasandamal2@gmail.com', '111111'),
(8, 'Kasun', 'Silva', 'male', '416/62/2 Atabagahawatta, Demanhandiya', '2025-02-22', '200223801828', '0712563456', 'kasun@gail.com', '123456'),
(9, 'Saman', 'Kumara', 'male', 'No 400 Kahatagasdigiliya', '2001-06-14', '20023645213', '0321456236', 'saman@gmail.com', '10101010'),
(10, 'Gihan', 'Rajapaksha', 'male', 'No 269 colombo', '1995-10-05', '200225451236', '0785245236', 'Gihan@gmail.com', '232323'),
(12, 'Dinushika', 'perera', 'female', 'No 589 Colombo', '2002-04-10', '200225458936', '0712536456', 'dinushika@gimal.com', '505050'),
(13, 'Dulara', 'Sandamal', 'female', '416/62/2Atabagahawaththa,Damnhanadiya\r\n416\\62\\2 Atabghawaththa Damanhandiya', '2025-02-28', '20025623456', '0710338510', 'dularasandamal2j@gmail.com', '102030'),
(14, 'GIhan ', 'pakaya', 'male', 'n 562 angoda', '1953-06-10', '200225451236', '0712356894', 'gihan@rokx.com', '789456'),
(15, 'kasun', 'kumara', 'male', '416\\62\\2 Atabghawaththa Damanhandiya\r\n416\\62\\2 Atabghawaththa Damanhandiya', '2025-03-19', '20025785412', '0768105310', 'dulara@gmail.com', '10203040'),
(16, 'Dulara', 'Sandamal', 'male', '416\\62\\2 Atabghawaththa Damanhandiya\r\n416\\62\\2 Atabghawaththa Damanhandiya', '2025-03-22', '20025785415', '0768105310', 'new@gmail.com', '000000'),
(17, 'Dulara', 'Sandamal', 'female', '416\\62\\2 Atabghawaththa Damanhandiya\r\n416\\62\\2 Atabghawaththa Damanhandiya', '2025-03-29', '200223801822', '0768105310', 'qihqcasjc@gmail.com', '112233'),
(18, 'gihan', 'rox', 'male', 'sbgfmhsdabgn', '2025-03-01', '200223801820', '0768105310', 'gihan@gimail.com', '147852'),
(19, 'Kumara', 'Silva', 'male', 'No 263/5 Colombo Rode, Wattala', '2002-06-20', '200256451236', '0712563456', 'Kumara10@gmail.com', 'kumara20');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
