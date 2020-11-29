-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2020 at 10:31 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sparkauth`
--

-- --------------------------------------------------------

--
-- Table structure for table `client_data`
--

CREATE TABLE `client_data` (
  `client_id` int(11) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_version` varchar(255) NOT NULL,
  `client_key` varchar(255) NOT NULL,
  `client_status` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `client_data`
--

INSERT INTO `client_data` (`client_id`, `client_name`, `client_version`, `client_key`, `client_status`) VALUES
(1, 'UnrealCheats-Fortnite', '1.0.0', 'kp9QLZDAYDF1bQ99lscV', 0);

-- --------------------------------------------------------

--
-- Table structure for table `spark_data`
--

CREATE TABLE `spark_data` (
  `spark_uid` int(11) NOT NULL,
  `Spark_username` varchar(255) NOT NULL,
  `Spark_email` varchar(255) NOT NULL,
  `Spark_password` varchar(255) NOT NULL,
  `Spark_admin` int(11) NOT NULL DEFAULT 0,
  `Spark_expires` varchar(255) DEFAULT NULL,
  `Spark_hwid` varchar(255) DEFAULT NULL,
  `Spark_ip` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `spark_data`
--

INSERT INTO `spark_data` (`spark_uid`, `Spark_username`, `Spark_email`, `Spark_password`, `Spark_admin`, `Spark_expires`, `Spark_hwid`, `Spark_ip`) VALUES
(1, 'RyzeGen', 'jase.jackson.k@gmail.com', '$2y$10$cD2h9uXfTJJUcwoOpwSAROu55XSF8gSk6cBUDdwxHEYpCAEIdp9mS', 1, '1607053774', '373616014', '::1'),
(2, 'RyzeHacker', 'RyzeHacker@gmail.com', '$2y$10$p/nZs1o/ShH/uh/FqhCl2OBEmTvTPX8dk1cR8819tYzj9PfVlCPCS', 0, '1606768977', '373616014', '::1'),
(3, 'XSKG3PB8FUOGNZYVBZMLGF', 'XSKG3PB8FUOGNZYVBZMLGF@gmail.com', '$2y$10$n/ild5ptU9VvZRRLivyRJO89xH3Xaeea9wUMp3QptT1gCcZEoBhfK', 0, '1606769074', '373616014', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `spark_keys`
--

CREATE TABLE `spark_keys` (
  `spark_id` int(11) NOT NULL,
  `spark_key` varchar(255) NOT NULL,
  `spark_days` int(11) NOT NULL,
  `spark_used` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `spark_keys`
--

INSERT INTO `spark_keys` (`spark_id`, `spark_key`, `spark_days`, `spark_used`) VALUES
(1, 'XSKG3PB8FUOGNZYVBZMLGF', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `spark_resets`
--

CREATE TABLE `spark_resets` (
  `spark_id` int(11) NOT NULL,
  `spark_token` varchar(255) NOT NULL,
  `spark_email` varchar(255) NOT NULL,
  `spark_expires` varchar(255) NOT NULL,
  `spark_done` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `spark_tokens`
--

CREATE TABLE `spark_tokens` (
  `spark_id` int(11) NOT NULL,
  `spark_token` varchar(255) NOT NULL,
  `spark_expires` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `spark_tokens`
--

INSERT INTO `spark_tokens` (`spark_id`, `spark_token`, `spark_expires`) VALUES
(22, 'Wo1ClsK4shzPmKhaac57dKWENvYRjK0D3P5bsROTGKb', '1606682742'),
(23, 'ADBp3DUips8499B6AeNY7Vujc5R9LrKAtRpbt3Y2QjL', '1606682777'),
(24, 'sfs2juZUPZ2i6Hps3cdLvteuYnwXl70IXon1LiZCxIz', '1606682802'),
(25, 'XjMiWtue01vzDNSZ7fQCLAZKy6So9w92gCKWo0vyfRq', '1606682837'),
(26, 'kBn3q6nXa8nxO8WGqmjtw56LppciMJmdwKYozxNlCuX', '1606682855'),
(27, '12liDyaYtrwR7PZ5WudTltjzeRrv2F7Pwyp1jKgaIp5', '1606683481'),
(28, '7TbvMpls2c48CXDOz4Yyw1itGSK154LTtvYgsseWJKS', '1606683576'),
(29, '4QzwiXaAajuRqTR49JXJjNQymRj1mGSZSUdBRdfVuV6', '1606683662'),
(30, 'n6bAImkFV7R0hfw1NrT83Ch2hX6TfUoKRKbZKhT7zOR', '1606683691'),
(31, 'eNpAXZxu1YLmbeY78zEfB6podgiVbjMrN5KBsP6046N', '1606683734');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client_data`
--
ALTER TABLE `client_data`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `spark_data`
--
ALTER TABLE `spark_data`
  ADD PRIMARY KEY (`spark_uid`);

--
-- Indexes for table `spark_keys`
--
ALTER TABLE `spark_keys`
  ADD PRIMARY KEY (`spark_id`);

--
-- Indexes for table `spark_resets`
--
ALTER TABLE `spark_resets`
  ADD PRIMARY KEY (`spark_id`);

--
-- Indexes for table `spark_tokens`
--
ALTER TABLE `spark_tokens`
  ADD PRIMARY KEY (`spark_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client_data`
--
ALTER TABLE `client_data`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `spark_data`
--
ALTER TABLE `spark_data`
  MODIFY `spark_uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `spark_keys`
--
ALTER TABLE `spark_keys`
  MODIFY `spark_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `spark_resets`
--
ALTER TABLE `spark_resets`
  MODIFY `spark_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spark_tokens`
--
ALTER TABLE `spark_tokens`
  MODIFY `spark_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
