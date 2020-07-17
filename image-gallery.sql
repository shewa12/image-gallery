-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 17, 2020 at 03:24 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `image-gallery`
--

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

DROP TABLE IF EXISTS `gallery`;
CREATE TABLE IF NOT EXISTS `gallery` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `file_url` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=244 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `file_name`, `file_url`, `created_at`) VALUES
(238, '1594989753-shewa.png', 'http://localhost/image-gallery/backend/gallery/1594989753-shewa.png', '2020-07-17 18:42:33'),
(239, '1594989779-image-modified.jpg', 'http://localhost/image-gallery/backend/gallery/1594989779-image-modified.jpg', '2020-07-17 18:42:59'),
(240, '1594990087-FD047E1B-1578-490E-81D5-7D53B5E90ACD.jpg', 'http://localhost/image-gallery/backend/gallery/1594990087-FD047E1B-1578-490E-81D5-7D53B5E90ACD.jpg', '2020-07-17 18:48:07'),
(241, '1594990170-image-modified.jpg', 'http://localhost/image-gallery/backend/gallery/1594990170-image-modified.jpg', '2020-07-17 18:49:30'),
(242, '1594990493-image-modified.jpg', 'http://localhost/image-gallery/backend/gallery/1594990493-image-modified.jpg', '2020-07-17 18:54:53'),
(243, '1594998975-image-modified.jpg', 'http://localhost/image-gallery/backend/gallery/1594998975-image-modified.jpg', '2020-07-17 21:16:15');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
