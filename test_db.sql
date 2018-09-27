-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 27, 2018 at 09:59 PM
-- Server version: 5.7.23-0ubuntu0.16.04.1
-- PHP Version: 7.0.32-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `balance`
--

CREATE TABLE IF NOT EXISTS `balance` (
  `user_id` int(11) NOT NULL,
  `balance` decimal(15,3) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `balance`
--

INSERT INTO `balance` (`user_id`, `balance`) VALUES
(1, 98910);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `amount` decimal(15,3) DEFAULT NULL,
  `new_balance` decimal(15,3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `date`, `amount`, `new_balance`) VALUES
(1, 1, '2018-09-24 17:51:48', 10, 99900),
(2, 1, '2018-09-24 17:53:17', -67, 99867),
(3, 1, '2018-09-24 17:55:10', -100, 99700),
(4, 1, '2018-09-24 17:56:35', -100, 99600),
(5, 1, '2018-09-24 17:59:45', -100, 99500),
(6, 1, '2018-09-24 18:00:49', -100, 99400),
(7, 1, '2018-09-24 18:05:18', 14, 99414),
(8, 1, '2018-09-24 18:05:26', 84, 99498),
(9, 1, '2018-09-24 18:05:33', 2, 99500),
(10, 1, '2018-09-24 18:05:43', 100, 99600),
(11, 1, '2018-09-24 18:11:58', -15, 99585),
(12, 1, '2018-09-24 18:13:55', -23, 99562),
(13, 1, '2018-09-24 18:14:06', -12, 99550),
(14, 1, '2018-09-24 18:26:44', -100, 99450),
(15, 1, '2018-09-24 18:31:40', -400, 99050),
(16, 1, '2018-09-24 18:33:06', -10, 99040),
(17, 1, '2018-09-24 22:51:35', -100, 98940),
(18, 1, '2018-09-25 00:03:58', -10, 98930),
(19, 1, '2018-09-27 21:26:26', -10, 98920),
(20, 1, '2018-09-27 21:31:43', -10, 98910);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `password`) VALUES
(1, 'ilyas', '69c5fcebaa65b560eaf06c3fbeb481ae44b8d618'),
(2, 'tester', '69c5fcebaa65b560eaf06c3fbeb481ae44b8d618');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `balance`
--
ALTER TABLE `balance`
  ADD CONSTRAINT `balance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
