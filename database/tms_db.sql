-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2024 at 06:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `discussion_list`
--

CREATE TABLE `discussion_list` (
  `id` int(30) NOT NULL,
  `project_id` int(30) NOT NULL,
  `task_id` int(30) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `user_id` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discussion_list`
--

INSERT INTO `discussion_list` (`id`, `project_id`, `task_id`, `subject`, `comment`, `status`, `user_id`, `date_created`) VALUES
(1, 44, 58, 'test', 'test', 0, 10, '2023-12-28 21:10:37'),
(2, 44, 58, 'test', 'abcd', 0, 10, '2023-12-28 21:13:54'),
(3, 44, 58, 'abcd', 'abcdfgrtyjkhikh', 0, 1, '2023-12-28 21:14:24'),
(4, 44, 58, 'test', 'qwertest@123', 0, 1, '2023-12-31 09:12:02'),
(5, 64, 59, 'color change', 'progress plz', 0, 10, '2024-01-01 21:54:34'),
(6, 64, 59, 'done', 'finalized', 0, 1, '2024-01-01 21:55:03');

-- --------------------------------------------------------

--
-- Table structure for table `project_list`
--

CREATE TABLE `project_list` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(2) NOT NULL,
  `start_date` date NOT NULL,
  `review_brief_date` date NOT NULL,
  `design_date` date NOT NULL,
  `development_date` date NOT NULL,
  `site_test_date` date NOT NULL,
  `uat_date` date NOT NULL,
  `go_live_date` date NOT NULL,
  `end_date` date NOT NULL,
  `manager_id` int(30) NOT NULL,
  `user_ids` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_list`
--

INSERT INTO `project_list` (`id`, `name`, `description`, `status`, `start_date`, `review_brief_date`, `design_date`, `development_date`, `site_test_date`, `uat_date`, `go_live_date`, `end_date`, `manager_id`, `user_ids`, `date_created`) VALUES
(44, 'test', '																		test																										', 0, '2023-12-28', '2023-12-28', '2023-12-28', '2023-12-28', '2023-12-28', '2023-12-28', '2023-12-28', '2023-12-28', 2, '16,10,4,7,3', '2023-12-28 15:15:21'),
(51, 'ERT', 'test', 0, '2023-12-31', '2023-12-31', '2023-12-31', '2023-12-31', '2023-12-31', '2023-12-31', '2023-12-31', '2023-12-31', 2, '10', '2023-12-31 23:01:31'),
(52, 'Asanaka Jayashan Urala Gamage', '																		testsaddadad gcbdfb', 0, '2023-12-31', '2023-12-31', '2023-12-31', '2023-12-31', '2023-12-31', '2023-12-31', '2023-12-31', '2023-12-31', 2, '10', '2023-12-31 23:55:20'),
(53, 'Asanaka Jayashan Urala Gamage', '																						', 0, '2023-12-31', '0000-00-00', '2023-12-31', '0000-00-00', '2023-12-31', '0000-00-00', '0000-00-00', '0000-00-00', 0, '', '2023-12-31 23:56:48'),
(54, 'Identify Used PC', 'test', 0, '2024-01-01', '2024-01-01', '2024-01-01', '2024-01-01', '2024-01-01', '2024-01-01', '2024-01-01', '2024-01-01', 2, '10', '2024-01-01 00:02:33'),
(55, 'ssssssss', '											', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, '', '2024-01-01 00:03:39'),
(56, 'test', '											', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, '', '2024-01-01 00:03:56'),
(57, 'test', '											', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, '', '2024-01-01 00:04:17'),
(58, 'ddddd', '											', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, '', '2024-01-01 00:05:09'),
(59, 'rrrrrrr', '											', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, '', '2024-01-01 00:12:12'),
(60, 'rrrttttt', '											', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, '', '2024-01-01 00:12:36'),
(61, 'gsdfgrggsdgsgdggsdgsgdsgdg', 'fggfgfg', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 2, '28', '2024-01-01 00:13:19'),
(62, 'ffffooooooo', '																						', 0, '2024-01-01', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '2024-01-01', 0, '', '2024-01-01 00:14:18'),
(63, 'eettyrtyryytyttet', 'tettetete', 0, '2024-01-01', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '2024-01-01', 0, '', '2024-01-01 00:28:31'),
(64, 'testing project', 'test try', 0, '2024-01-01', '2024-01-01', '2024-01-01', '2024-01-01', '2024-01-01', '2024-01-01', '2024-01-01', '2024-01-01', 2, '10', '2024-01-01 21:35:42');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `cover_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `address`, `cover_img`) VALUES
(1, 'Project Management System', 'abcd@gmail.com', '011', 'abc,Colombo 04', '');

-- --------------------------------------------------------

--
-- Table structure for table `task_list`
--

CREATE TABLE `task_list` (
  `id` int(30) NOT NULL,
  `project_id` int(30) NOT NULL,
  `task` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `type` tinyint(4) NOT NULL,
  `priority` tinyint(4) NOT NULL,
  `start_date` date NOT NULL,
  `due_date` date NOT NULL,
  `progress` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_list`
--

INSERT INTO `task_list` (`id`, `project_id`, `task`, `description`, `type`, `priority`, `start_date`, `due_date`, `progress`, `status`, `date_created`) VALUES
(58, 44, 'test', '																																												test																																	', 1, 3, '2023-12-28', '2023-12-28', '52', 3, '2023-12-28 16:00:04'),
(59, 64, 'testing', '																																																testing asd																																				', 2, 3, '2024-01-01', '2024-01-01', '84', 1, '2024-01-01 21:42:21');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_list`
--

CREATE TABLE `ticket_list` (
  `id` int(30) NOT NULL,
  `project_id` int(30) NOT NULL,
  `subject` varchar(30) NOT NULL,
  `description` varchar(60) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `user_id` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_list`
--

INSERT INTO `ticket_list` (`id`, `project_id`, `subject`, `description`, `type`, `status`, `user_id`, `date_created`) VALUES
(1, 44, 'test', '																								test																		', 3, 6, 1, '2023-12-28 16:54:45'),
(2, 44, 'test123', 'test123', 1, 1, 1, '2023-12-30 13:10:16'),
(3, 44, 'abc', '								abc						', 1, 1, 1, '2023-12-30 13:10:47'),
(4, 44, 'efg', '				efg			', 1, 6, 1, '2023-12-30 13:11:03'),
(5, 44, 'pqr', 'pqr', 1, 1, 1, '2023-12-30 13:11:18'),
(6, 44, 'ertyu', 'fvgjhdjfd', 1, 1, 1, '2023-12-30 13:11:31'),
(7, 44, 'kgkggjkg', 'kkdgsjdjhfjkfgfd', 1, 1, 1, '2023-12-30 13:11:45'),
(8, 64, 'color change', '				color change not working			', 2, 6, 1, '2024-01-01 21:51:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1 = admin, 2 = staff',
  `avatar` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `type`, `avatar`, `date_created`) VALUES
(1, 'SUPER_ADMIN', 'DC', 'sdc@ird.gov.lk', '8a81b501f8ced0a897572dfc4d0db8f0', 1, '1677993060_1675014180_encodeunlimited.png', '2023-03-05 10:41:29'),
(2, 'ADMIN', 'DC', 'adc@ird.gov.lk', '4481764ef88eab53eaa2b3bff6a90ede', 2, '1677993360_sdc.png', '2023-03-05 10:46:21'),
(3, 'HERATH', 'ICTO', 'herath@ird.gov.lk', '4481764ef88eab53eaa2b3bff6a90ede', 3, '1677993420_mdc.jpg', '2023-03-05 10:47:57'),
(4, 'CHAMINDA', 'ICTO', 'chaminda@ird.gov.lk', '4481764ef88eab53eaa2b3bff6a90ede', 3, '1677993480_mdc.jpg', '2023-03-05 10:48:58'),
(5, 'ALOYSIUS', 'ICTO', 'alo@ird.gov.lk', '4481764ef88eab53eaa2b3bff6a90ede', 3, '1677993600_mdc.jpg', '2023-03-05 10:50:08'),
(6, 'UDESHIKA', 'ICTO', 'udeshika@ird.gov.lk', '4481764ef88eab53eaa2b3bff6a90ede', 3, '1677993600_fmdc.png', '2023-03-05 10:50:57'),
(7, 'FAMALKA', 'ICTAD', 'famalka@ird.gov.lk', '4481764ef88eab53eaa2b3bff6a90ede', 3, '1677993660_fmdc.png', '2023-03-05 10:51:41'),
(8, 'SUGATH', 'ICTO', 'sugath@ird.gov.lk', '4481764ef88eab53eaa2b3bff6a90ede', 3, '1677993720_1677993600_mdc.jpg', '2023-03-05 10:52:32'),
(9, 'PRIYADARSHANI', 'ICTA', 'priyadarshani@ird.gov.lk', '4481764ef88eab53eaa2b3bff6a90ede', 3, '1677993780_1677993660_fmdc.png', '2023-03-05 10:53:29'),
(10, 'Asanaka', 'Jayashan', 'asanka.ird@gmail.com', '4481764ef88eab53eaa2b3bff6a90ede', 3, '1677993900_1677993720_1677993600_mdc.jpg', '2023-03-05 10:55:38'),
(11, 'SENARATH', 'ICTA', 'senarath@ird.gov.lk', '4481764ef88eab53eaa2b3bff6a90ede', 3, '1677993960_1677993720_1677993600_mdc.jpg', '2023-03-05 10:56:18'),
(12, 'GAYAN', 'ICTO', 'gayan@ird.gov.lk', '4481764ef88eab53eaa2b3bff6a90ede', 3, '1677994020_1677993720_1677993600_mdc.jpg', '2023-03-05 10:57:27'),
(13, 'RUWAN', 'ICTA', 'ruwan@ird.gov.lk', '4481764ef88eab53eaa2b3bff6a90ede', 3, '1677994080_1677993720_1677993600_mdc.jpg', '2023-03-05 10:58:12'),
(14, 'HESHAN', 'ICTA', 'heshan@ird.gov.lk', '4481764ef88eab53eaa2b3bff6a90ede', 3, '1677994080_1677994080_1677993720_1677993600_mdc.jpg', '2023-03-05 10:58:44'),
(15, 'SANJEEWA', 'ICTA', 'sanjeewa@ird.gov.lk', '4481764ef88eab53eaa2b3bff6a90ede', 3, '1677994140_mdc.jpg', '2023-03-05 10:59:14'),
(16, 'AMILA', 'ICAT', 'amila@ird.gov.lk', '4481764ef88eab53eaa2b3bff6a90ede', 3, '1677994140_mdc.jpg', '2023-03-05 10:59:53'),
(17, 'SWARNASIRI', 'ICTA', 'swarnasiri@ird.gov.lk', '4481764ef88eab53eaa2b3bff6a90ede', 3, '1677994200_mdc.jpg', '2023-03-05 11:00:31'),
(18, 'ADMIN', 'DR', 'adr@ird.gov.lk', '922bfb0ff4805c323eda63b58b1b1d0e', 2, '1678351920_1677993360_sdc.png', '2023-03-09 14:22:13'),
(19, 'Nizar', 'ICTO', 'nizar@ird.gov.lk', '922bfb0ff4805c323eda63b58b1b1d0e', 3, '1678352100_1677993420_mdc.jpg', '2023-03-09 14:25:33'),
(20, 'Jayawardhana', 'ICTO', 'jayawardhana@ird.gov.lk', '09ea63afa4187cfd4d1034b71196bbaf', 3, '1678353120_1677993420_mdc.jpg', '2023-03-09 14:42:15'),
(21, 'Nishantha', 'ICTO', 'nishantha@ird.gov.lk', '922bfb0ff4805c323eda63b58b1b1d0e', 3, '1678353180_1677993420_mdc.jpg', '2023-03-09 14:43:08'),
(22, 'Samarakoon', 'ICTA', 'samarakoon@ird.gov.lk', '922bfb0ff4805c323eda63b58b1b1d0e', 3, '1678353540_1677993660_fmdc.png', '2023-03-09 14:43:53'),
(23, 'Karunathilake', 'ICTA', 'karunathilake@ird.gov.lk', '922bfb0ff4805c323eda63b58b1b1d0e', 3, '1678353240_1677993480_mdc.jpg', '2023-03-09 14:44:31'),
(24, 'Keerthi ', 'ICTA', 'keerthi@ird.gov.lk', '922bfb0ff4805c323eda63b58b1b1d0e', 3, '1678353300_1677993480_mdc.jpg', '2023-03-09 14:45:07'),
(25, 'Weerakoon', 'ICTA', 'weerakoon@ird.gov.lk', '922bfb0ff4805c323eda63b58b1b1d0e', 3, '1678353300_1677993420_mdc.jpg', '2023-03-09 14:45:48'),
(26, 'Ranaweera', 'ICTA', 'ranaweera@ird.gov.lk', '922bfb0ff4805c323eda63b58b1b1d0e', 3, '1678353420_1677993480_mdc.jpg', '2023-03-09 14:47:04'),
(27, 'Dayarathne', 'ICTA', 'dayarathne@ird.gov.lk', '922bfb0ff4805c323eda63b58b1b1d0e', 3, '1678353420_1677993420_mdc.jpg', '2023-03-09 14:47:37'),
(28, 'Gamlath', 'ICTA', 'gamlath@ird.gov.lk', '922bfb0ff4805c323eda63b58b1b1d0e', 3, '1678353480_1677993480_mdc.jpg', '2023-03-09 14:48:18'),
(29, 'Bandara', 'ICTA', 'bandara@ird.gov.lk', '922bfb0ff4805c323eda63b58b1b1d0e', 3, '1678353480_1677993480_mdc.jpg', '2023-03-09 14:48:50'),
(30, 'KALANA', 'ICTO', 'kalana@ird.gov.lk', '4481764ef88eab53eaa2b3bff6a90ede', 3, '1691143020_mp (2).png', '2023-05-31 10:33:42');

-- --------------------------------------------------------

--
-- Table structure for table `user_productivity`
--

CREATE TABLE `user_productivity` (
  `id` int(30) NOT NULL,
  `project_id` int(30) NOT NULL,
  `task_id` int(30) NOT NULL,
  `comment` text NOT NULL,
  `subject` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `user_id` int(30) NOT NULL,
  `time_rendered` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_productivity`
--

INSERT INTO `user_productivity` (`id`, `project_id`, `task_id`, `comment`, `subject`, `date`, `start_time`, `end_time`, `user_id`, `time_rendered`, `date_created`) VALUES
(122, 44, 58, 'test', 'test', '2023-12-28', '00:00:00', '00:00:00', 1, 0, '2023-12-28 16:43:42'),
(123, 44, 58, 'test', '', '2023-12-28', '00:00:00', '00:00:00', 10, 0, '2023-12-28 17:35:55'),
(125, 44, 58, '&lt;p&gt;							&lt;img src=&quot;data:image/jpeg;base64,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&quot; data-filename=&quot;1677993420_mdc.jpg&quot; style=&quot;width: 360px;&quot;&gt;test						&lt;/p&gt;', 'test', '2023-12-08', '00:00:00', '00:00:00', 10, 0, '2023-12-28 19:10:56'),
(126, 44, 58, 'test', 'test344444', '2023-12-07', '00:00:00', '00:00:00', 10, 0, '2023-12-28 19:11:43'),
(127, 44, 58, '222222222333333333333333', 'test22222', '2023-12-13', '00:00:00', '00:00:00', 10, 0, '2023-12-28 19:12:24'),
(128, 64, 59, '&lt;p&gt;ffffff&lt;/p&gt;', 'color change', '2024-01-01', '21:49:00', '23:51:00', 1, 2.03333, '2024-01-01 21:49:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `discussion_list`
--
ALTER TABLE `discussion_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_list`
--
ALTER TABLE `project_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_list`
--
ALTER TABLE `task_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_list`
--
ALTER TABLE `ticket_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_productivity`
--
ALTER TABLE `user_productivity`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `discussion_list`
--
ALTER TABLE `discussion_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `project_list`
--
ALTER TABLE `project_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `task_list`
--
ALTER TABLE `task_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `ticket_list`
--
ALTER TABLE `ticket_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user_productivity`
--
ALTER TABLE `user_productivity`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
