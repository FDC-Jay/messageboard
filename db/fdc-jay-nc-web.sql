-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2024 at 12:01 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `msgboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `msg_connect_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `created` varchar(255) NOT NULL,
  `modified` varchar(255) NOT NULL,
  `created_ip` varchar(20) NOT NULL,
  `modified_ip` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `msg_connect_id`, `user_id`, `content`, `created`, `modified`, `created_ip`, `modified_ip`, `status`) VALUES
(1, 1, 3, 'hello jake', '1717731108', '2024-06-07 05:31:48', '', '::1', 1),
(2, 1, 3, 'hey its me, fin', '1717731281', '2024-06-07 05:34:41', '', '::1', 1),
(9, 1, 3, 'test', '1717738277', '2024-06-07 07:31:17', '', '::1', 1),
(10, 1, 3, 'test', '1717738330', '2024-06-07 07:32:10', '', '::1', 1),
(11, 1, 3, 'test 3', '1717738392', '2024-06-07 07:33:12', '', '::1', 1),
(12, 1, 3, 'test 4', '1717738424', '2024-06-07 09:25:06', '', '::1', 0),
(13, 1, 3, 'hehe', '1717738578', '2024-06-07 08:27:33', '', '::1', 0),
(16, 0, 0, '', '1717741199', '2024-06-07 08:19:59', '', '::1', 0),
(17, 0, 0, '', '1717741272', '2024-06-07 08:21:12', '', '::1', 0),
(18, 0, 0, '', '1717741284', '2024-06-07 08:21:24', '', '::1', 0),
(19, 0, 0, '', '1717741327', '2024-06-07 08:22:07', '', '::1', 0),
(20, 0, 0, '', '1717741356', '2024-06-07 08:22:36', '', '::1', 0),
(21, 0, 0, '', '1717741384', '2024-06-07 08:23:04', '', '::1', 0),
(22, 0, 0, '', '1717741541', '2024-06-07 08:25:41', '', '::1', 0),
(23, 0, 0, '', '1717741591', '2024-06-07 08:26:31', '', '::1', 0),
(24, 1, 4, 'hi fin', '1717745179', '2024-06-07 09:26:19', '', '::1', 1),
(25, 1, 4, 'how are you?', '1717745288', '2024-06-07 09:28:08', '', '::1', 1),
(26, 1, 4, 'are you good', '1717745297', '2024-06-07 09:28:17', '', '::1', 1),
(27, 1, 4, 'hehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehehe', '1717745693', '2024-06-07 09:34:53', '', '::1', 1),
(28, 1, 4, 'he he hehe ehehe he he hehe ehehehe he hehe ehehehe he hehe ehehehe he hehe ehehehe he hehe ehehehe he hehe ehehehe he hehe ehehehe he hehe ehehehe he hehe ehehehe he hehe ehehe', '1717745832', '2024-06-07 09:37:12', '', '::1', 1),
(29, 1, 4, 'are', '1717745908', '2024-06-07 09:38:28', '', '::1', 1),
(30, 1, 4, 'you', '1717746019', '2024-06-07 09:40:19', '', '::1', 1),
(31, 1, 4, 'okay', '1717746568', '2024-06-07 09:49:28', '', '::1', 1),
(32, 1, 4, '?', '1717746630', '2024-06-07 09:50:30', '', '::1', 1),
(33, 1, 4, 'testing', '1717746672', '2024-06-07 09:51:12', '', '::1', 1),
(34, 1, 4, 'ha', '1717746739', '2024-06-07 09:52:19', '', '::1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `message_connects`
--

CREATE TABLE `message_connects` (
  `id` int(11) NOT NULL,
  `user_one` int(11) NOT NULL,
  `user_two` int(11) NOT NULL,
  `created` varchar(255) NOT NULL,
  `created_ip` varchar(20) NOT NULL,
  `modified` varchar(255) NOT NULL,
  `modified_ip` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message_connects`
--

INSERT INTO `message_connects` (`id`, `user_one`, `user_two`, `created`, `created_ip`, `modified`, `modified_ip`) VALUES
(1, 3, 4, '1717731108', '', '2024-06-07 05:31:48', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birthday` varchar(255) DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL COMMENT 'M = Male; F = Female',
  `profile_pic` varchar(255) NOT NULL,
  `hobby` longtext NOT NULL,
  `created` varchar(255) NOT NULL,
  `modified` varchar(255) NOT NULL,
  `created_ip` varchar(20) NOT NULL,
  `modified_ip` varchar(20) NOT NULL,
  `last_login` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 = disabled; 1 = active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `birthday`, `gender`, `profile_pic`, `hobby`, `created`, `modified`, `created_ip`, `modified_ip`, `last_login`, `status`) VALUES
(1, '', 'test@test.com', 'admin123', NULL, NULL, '', '', '2024-06-04 04:27:36', '2024-06-04 04:27:36', '', '', '', 1),
(2, '', 'fdc@fdc.com', '$2a$10$dQeCyA3OhnbxxtfZ79n7pu231Db3HDwdKM19cNjLS.WZ1o0WB0NrK', NULL, NULL, '', '', '2024-06-04 07:01:40', '2024-06-04 07:01:41', '', '::1', '', 1),
(3, 'fin the human', 'testing@gmail.com', '$2a$10$bEi0pGXM7A6Kr.d80dvtIOwyizUjfWXPv9ewpvR0zb1We2M09Z7/2', '01-01-1970', 'M', '/messageboard/uploads/Screenshot 2024-06-07 091809.png', '', '2024-06-04 07:55:54', '2024-06-07 11:05:37', '', '::1', '2024-06-07 11:05:37', 1),
(4, 'jake the dog', 'testing2@gmail.com', '$2a$10$TwqxVYRnhOXQv8ByTeFUSOAsVM/ct8KK5J.FrmrfajM1SeOrj9yvK', '01-01-2000', 'M', '/messageboard/uploads/Screenshot 2024-06-07 093424.png', 'idk too', '2024-06-04 07:56:58', '2024-06-07 07:38:18', '', '::1', '2024-06-07 07:38:18', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_connects`
--
ALTER TABLE `message_connects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `message_connects`
--
ALTER TABLE `message_connects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
