-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 28, 2018 at 01:02 AM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flexchange`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `FirstName` varchar(64) CHARACTER SET utf32 NOT NULL,
  `LastName` varchar(64) CHARACTER SET utf32 NOT NULL,
  `email` varchar(64) CHARACTER SET utf32 NOT NULL,
  `status` int(10) UNSIGNED NOT NULL,
  `pass_hash` varchar(64) CHARACTER SET utf32 NOT NULL,
  `pass_salt` varchar(64) CHARACTER SET utf32 NOT NULL,
  `venmo_handle` varchar(17) CHARACTER SET utf32 NOT NULL,
  `location` varchar(64) CHARACTER SET utf32 NOT NULL,
  `exchange_rate` float NOT NULL,
  `img_name` varchar(64) CHARACTER SET utf32 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `FirstName`, `LastName`, `email`, `status`, `pass_hash`, `pass_salt`, `venmo_handle`, `location`, `exchange_rate`, `img_name`) VALUES
(1, 'Steve', 'Bloniarz', 'steve.bloniarz@gmail.com', 1, 'passhash', 'stevesalt', 'realshenanigans', 'Blitman Dining Hall', 0.5, ''),
(2, 'Rex', 'Hu', 'rex.hu555@gmail.com', 1, 'passhash', 'rexsalt', 'rex-hu', '', 0, ''),
(3, 'Natalee', 'Ryan', '98natalee@gmail.com', 0, 'passhash', 'nataleesalt', 'natalee-ryan', '', 0, ''),
(4, 'Maya', 'Tung', 'mktung0@gmail.com', 2, 'passhash', 'mayasalt', 'maya-tung', '', 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
