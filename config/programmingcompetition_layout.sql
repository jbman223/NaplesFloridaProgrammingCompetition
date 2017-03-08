-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 08, 2017 at 12:45 PM
-- Server version: 5.5.38-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `programmingcompetition`
--
CREATE DATABASE IF NOT EXISTS `programmingcompetition` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `programmingcompetition`;

-- --------------------------------------------------------

--
-- Table structure for table `sampleSubmissions`
--

CREATE TABLE IF NOT EXISTS `sampleSubmissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` text NOT NULL,
  `compiler_status` varchar(255) NOT NULL,
  `output` text NOT NULL,
  `error_info` text NOT NULL,
  `output_hash` varchar(64) NOT NULL,
  `link` varchar(50) NOT NULL,
  `problem_id` int(11) NOT NULL,
  `code_hash` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verified` int(1) NOT NULL,
  `verification_code` varchar(40) NOT NULL,
  `verification_email_time` int(11) NOT NULL,
  `password_reset` int(1) NOT NULL DEFAULT '0',
  `temporary_password` varchar(255) NOT NULL,
  `password_reset_time` int(11) NOT NULL,
  `level` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Table structure for table `verification`
--

CREATE TABLE IF NOT EXISTS `verification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `for_id` int(11) NOT NULL,
  `for_email` varchar(255) NOT NULL,
  `verify_code` varchar(255) NOT NULL,
  `type` int(1) NOT NULL DEFAULT '0',
  `complete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
