-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 04, 2018 at 06:58 PM
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
-- Table structure for table `admin_current_competition`
--

CREATE TABLE IF NOT EXISTS `admin_current_competition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_name` varchar(255) NOT NULL,
  `field_value` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `admin_scheduled_competitions`
--

CREATE TABLE IF NOT EXISTS `admin_scheduled_competitions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `competition_name` varchar(255) NOT NULL,
  `graded` int(1) NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `delete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE IF NOT EXISTS `alerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(255) NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- Table structure for table `code_results`
--

CREATE TABLE IF NOT EXISTS `code_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` text NOT NULL,
  `code_hash` varchar(64) NOT NULL,
  `error` text NOT NULL,
  `output` text NOT NULL,
  `run_time` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1467 ;

-- --------------------------------------------------------

--
-- Table structure for table `competitions`
--

CREATE TABLE IF NOT EXISTS `competitions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `competition_name` varchar(255) NOT NULL,
  `competition_notes` varchar(400) NOT NULL,
  `removed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `competition_sections`
--

CREATE TABLE IF NOT EXISTS `competition_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `competition_id` int(11) NOT NULL,
  `section_name` varchar(255) NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  `removed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `competition_section_problems`
--

CREATE TABLE IF NOT EXISTS `competition_section_problems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `problem_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `removed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=92 ;

-- --------------------------------------------------------

--
-- Table structure for table `competition_section_scoreboards`
--

CREATE TABLE IF NOT EXISTS `competition_section_scoreboards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_id` int(11) NOT NULL,
  `scoreboard_data` blob NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `section_id` (`section_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `competitors`
--

CREATE TABLE IF NOT EXISTS `competitors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `l_name` varchar(255) NOT NULL,
  `school` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `grade` int(2) NOT NULL,
  `verified` int(1) NOT NULL DEFAULT '0',
  `shirt_size` varchar(30) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=105 ;

-- --------------------------------------------------------

--
-- Table structure for table `edu_problems`
--

CREATE TABLE IF NOT EXISTS `edu_problems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `problem_name` varchar(255) NOT NULL,
  `problem_description` text NOT NULL,
  `problem_sample_input` text NOT NULL,
  `problem_sample_output` text NOT NULL,
  `youtube_video_link` varchar(25) NOT NULL,
  `sample_code` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `edu_problem_state`
--

CREATE TABLE IF NOT EXISTS `edu_problem_state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `edu_problem_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `code` text NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=144 ;

-- --------------------------------------------------------

--
-- Table structure for table `mcq`
--

CREATE TABLE IF NOT EXISTS `mcq` (
  `id` int(11) NOT NULL,
  `answers` varchar(255) NOT NULL,
  `correct` varchar(255) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `problems`
--

CREATE TABLE IF NOT EXISTS `problems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `problem_title` varchar(255) NOT NULL,
  `problem_input_file` varchar(255) NOT NULL,
  `problem_description_file` varchar(255) NOT NULL,
  `problem_sample_input_file` varchar(255) NOT NULL,
  `problem_output_file` varchar(255) NOT NULL,
  `problem_sample_output_file` varchar(255) NOT NULL,
  `competition_id` int(11) NOT NULL,
  `output_hash` varchar(255) NOT NULL,
  `base_path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `problem_data`
--

CREATE TABLE IF NOT EXISTS `problem_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `problem_title` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `problem_description` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `problem_sample_input` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `problem_sample_output` varchar(2500) COLLATE utf8mb4_bin NOT NULL,
  `problem_input` varchar(2500) COLLATE utf8mb4_bin NOT NULL,
  `problem_output` varchar(2500) COLLATE utf8mb4_bin NOT NULL,
  `problem_output_trimmed` varchar(2500) COLLATE utf8mb4_bin NOT NULL,
  `problem_output_hash` varchar(48) COLLATE utf8mb4_bin NOT NULL,
  `problem_code` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `problem_code_hash` varchar(64) COLLATE utf8mb4_bin NOT NULL,
  `problem_code_ran` int(11) NOT NULL DEFAULT '0',
  `problem_code_result` int(11) NOT NULL,
  `problem_code_status` int(11) NOT NULL DEFAULT '0',
  `problem_status` int(11) NOT NULL,
  `removed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin AUTO_INCREMENT=45 ;

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE IF NOT EXISTS `quizzes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_name` varchar(255) NOT NULL,
  `removed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_answers`
--

CREATE TABLE IF NOT EXISTS `quiz_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `quiz_question_id` int(11) NOT NULL,
  `answer` varchar(1) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=304 ;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE IF NOT EXISTS `quiz_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `answer` varchar(1) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `removed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE IF NOT EXISTS `replies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thread_id` int(11) NOT NULL,
  `poster_id` int(11) NOT NULL,
  `message` varchar(500) NOT NULL,
  `post_time` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=128 ;

-- --------------------------------------------------------

--
-- Table structure for table `reviewers`
--

CREATE TABLE IF NOT EXISTS `reviewers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `problem_id` int(11) NOT NULL,
  `review_type` int(1) NOT NULL,
  `email_address` varchar(200) NOT NULL,
  `password` varchar(64) NOT NULL,
  `review_complete` tinyint(1) NOT NULL DEFAULT '0',
  `notes` text NOT NULL,
  `code` text NOT NULL,
  `code_result` int(11) NOT NULL,
  `code_hash` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

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
-- Table structure for table `scoreboards`
--

CREATE TABLE IF NOT EXISTS `scoreboards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scoreboard_data` blob NOT NULL,
  `competition_id` int(11) NOT NULL,
  `last_update` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `competition_id` (`competition_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3462 ;

-- --------------------------------------------------------

--
-- Table structure for table `section_quizzes`
--

CREATE TABLE IF NOT EXISTS `section_quizzes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `removed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `solved_problems`
--

CREATE TABLE IF NOT EXISTS `solved_problems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `problem_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `code_result` int(11) NOT NULL,
  `language` varchar(25) NOT NULL,
  `correct` tinyint(1) NOT NULL DEFAULT '0',
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1218 ;

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE IF NOT EXISTS `submissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `problem_id` int(11) NOT NULL,
  `competition_id` int(11) NOT NULL,
  `link` varchar(25) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=477 ;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `team_name` varchar(255) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `backendLogin` varchar(42) NOT NULL,
  `backendPassword` varchar(42) NOT NULL,
  `quick_access_code` varchar(50) NOT NULL DEFAULT 'none',
  `admin` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE IF NOT EXISTS `threads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `problem_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` varchar(500) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `post_time` int(11) NOT NULL,
  `solved` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=80 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=115 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=117 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
