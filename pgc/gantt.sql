-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 04, 2016 at 09:46 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `project_gantt`
--

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(150) NOT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `project_name`) VALUES
(1, 'Admin Building'),
(2, 'Repair of Classroom');

-- --------------------------------------------------------

--
-- Table structure for table `punchlist`
--

CREATE TABLE IF NOT EXISTS `punchlist` (
  `punchlist_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `description` varchar(150) NOT NULL,
  `start_date` varchar(20) NOT NULL,
  `end_date` varchar(20) NOT NULL,
  `progress` varchar(20) NOT NULL,
  PRIMARY KEY (`punchlist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `punchlist`
--

INSERT INTO `punchlist` (`punchlist_id`, `project_id`, `description`, `start_date`, `end_date`, `progress`) VALUES
(1, 2, 'Demolition of Ceiling', '12/31/15', '01/02/16', '100'),
(2, 2, 'Construction of Ceiling', '01/01/16', '01/06/16', '60'),
(3, 1, 'checklist 1', '12/23/15', '12/25/15', '100'),
(4, 1, 'checklist 2', '12/24/15', '12/28/15', '80'),
(5, 1, 'checklist 3', '12/26/15', '01/01/16', '45'),
(6, 1, 'checklist 4', '01/03/16', '01/08/16', '0'),
(7, 1, 'checklist 5', '01/09/16', '01/12/16', '10');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
