-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 02, 2013 at 05:42 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT=0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `d0133e48`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `available` smallint(6) NOT NULL,
  `factor` int(11) NOT NULL,
  `value` float NOT NULL,
  `savings` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `description`, `available`, `factor`, `value`, `savings`) VALUES
(1, 'Dinner Plate', '23cm/9in melamine plate', 230, 24, 8, 0.1),
(2, 'Dinner Fork', 'Stainless steel dinner fork', 309, 24, 2, 0.05),
(3, 'Dinner Knife', 'Stainless steel dinner knife', 188, 24, 2, 0.05),
(4, 'Dinner Spoon', 'Stainless steel dinner spoon', 230, 24, 2, 0.05),
(5, 'Salad Fork', 'Stainless steel salad fork', 226, 24, 2, 0.05),
(6, 'Steak Knife', 'Stainless steel steak knife', 140, 24, 2, 0.05),
(7, 'Teaspoon', 'Stainless steel teaspoon', 181, 24, 2, 0.05),
(8, 'Cup', '240ml/8oz melamine cup', 146, 24, 6, 0.1),
(9, 'Saucer', 'Melamine saucer', 50, 24, 5, 0.5),
(10, 'Bowl', '240ml/8oz melamine bowl', 178, 24, 6, 0.1),
(11, 'Serving Bowl', '3.3L/3qt melamine mixing bowl', 4, 1, 12, 2),
(12, 'Water Glass', '240ml/8oz polycarbonate plastic water glass', 75, 25, 5, 0.15),
(13, 'Wine Glass', '240ml/8oz polycarbonate plastic stem wine glass', 250, 25, 5, 0.2),
(14, 'Pitcher', '1.8L/60oz bouncer pitcher', 10, 1, 15, 2),
(15, 'Carafe', '1.0L/32oz cooling beverage carafe', 4, 1, 25, 5),
(16, 'Corkscrew', 'Metal corkscrew', 1, 1, 12, 3),
(17, 'Percolator', '42-cup stainless steel percolator', 2, 1, 80, 5),
(18, 'Slow Cooker', '6.6L/6qt ceramic slow cooker', 2, 1, 100, 5),
(19, 'Food Warmer', 'Electric warming tray and buffet server 3x1.5L/1.5qt', 2, 1, 120, 5),
(20, 'Tong', 'Medium plastic and steel tong', 10, 1, 12, 1),
(21, 'Cake Dome/Platter', 'Cake dome/salsa&chips platter', 5, 1, 60, 5),
(22, 'Serving Platter', 'Plastic serving platter', 26, 1, 5, 1),
(23, 'Perforated Storage Box', 'Perforated storage box with lid', 3, 1, 20, 3),
(24, 'Cart', 'Pneumatic heavy-duty cart', 1, 1, 900, 0),
(25, 'SM Storage Box', NULL, 18, 1, 15, NULL),
(26, 'LG Storage Box', NULL, 16, 1, 25, NULL),
(27, 'Water Glass Rack', NULL, 3, 1, 75, NULL),
(28, 'Wine Glass Rack', NULL, 12, 1, 75, NULL),
(29, 'Cutlery Rack', NULL, 8, 1, 30, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `requestitems`
--

DROP TABLE IF EXISTS `requestitems`;
CREATE TABLE IF NOT EXISTS `requestitems` (
  `requestID` int(10) unsigned NOT NULL,
  `itemID` int(10) unsigned NOT NULL,
  `amount` int(10) unsigned NOT NULL DEFAULT '0',
  `amount_returned` int(10) unsigned NOT NULL DEFAULT '0',
  `amount_dirty` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`requestID`,`itemID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

DROP TABLE IF EXISTS `requests`;
CREATE TABLE IF NOT EXISTS `requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_from` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_until` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_returned` timestamp NULL DEFAULT NULL,
  `approved` tinyint(1) NOT NULL,
  `comment` text,
  `pending` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `concordia` tinyint(1) NOT NULL,
  `email` int(11) NOT NULL,
  `phone` int(11) NOT NULL,
  `studentID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
