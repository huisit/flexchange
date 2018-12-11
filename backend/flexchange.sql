-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 11, 2018 at 02:56 AM
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
CREATE DATABASE IF NOT EXISTS `flexchange` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `flexchange`;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `FirstName` varchar(64) CHARACTER SET utf32 NOT NULL,
  `LastName` varchar(64) CHARACTER SET utf32 NOT NULL,
  `email` varchar(64) CHARACTER SET utf32 NOT NULL,
  `status` int(10) UNSIGNED NOT NULL DEFAULT '1',
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
(11, 'John', 'Smith', 'smithj@rpi.edu', 0, '3c4b6b58ede177852631f7301f7fe4b21b482c356034cdaea58f11f409e303b7', 'ff6c0522fcf53dc926eff7448d6b808200466b97a75fdf5f61912b1bef5a6b88', '', 'Moes', 0.6, ''),
(21, 'Steven', 'Bloniarz', 'steve.bloniarz@gmail.com', 0, '4d04c01f05318454387c04e0727fac3137f0d99eaf7893dbc7705681ef805b71', '60bb077fd39f2a8db8ecd9383f78765d0d1f16d3d071b5fc7580ff699a817bf2', '', 'EMPAC', 0.5, '21.png'),
(22, 'Salty', 'Boi', 'bois@rpi.edu', 0, '385673d7d4f99cded6a2cbb5683bfc6a4e41f9aa44e4da6d4ff32078489b7288', 'c94ecc5233397d8477c602ec17e965c48ef13d32fe922cd43ab8173157d8a2d8', '', 'Blitman', 0.25, '22.jpeg'),
(24, 'Satej', 'Sawant', 'sawans@rpi.edu', 1, '1c957c78cb218b6ce32cbf37140dba4f3fe7f58469d1207df8262c4b977c4916', '2dfbc0e88b2be2401eeedadee4083285733bb2633897bbd833d7f1de0fb7212e', '', '', 0, '');

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
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
