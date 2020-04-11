-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2020 at 10:52 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jogjaval_5c3-tryout`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `answer_id` int(11) NOT NULL,
  `username` char(100) NOT NULL,
  `question_title` tinytext NOT NULL,
  `total_questions` int(11) NOT NULL,
  `limit_passing_grade` int(11) NOT NULL,
  `passing_grade` int(11) NOT NULL,
  `correct_answer` int(11) NOT NULL,
  `wrong_answer` int(11) NOT NULL,
  `not_answered` int(11) NOT NULL,
  `exam_limit` int(11) NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`answer_id`, `username`, `question_title`, `total_questions`, `limit_passing_grade`, `passing_grade`, `correct_answer`, `wrong_answer`, `not_answered`, `exam_limit`, `create_at`) VALUES
(1, 'sinur', 'Try Out CAT ke-1', 28, 55, 20, 8, 20, 0, 15, '2020-04-11 03:47:41');

-- --------------------------------------------------------

--
-- Table structure for table `answers_detail`
--

CREATE TABLE `answers_detail` (
  `answer_detail_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `category` tinytext NOT NULL,
  `correct_answer` int(11) NOT NULL,
  `wrong_answer` int(11) NOT NULL,
  `not_answered` int(11) NOT NULL,
  `total_questions` int(11) NOT NULL,
  `limit_passing_grade` float NOT NULL,
  `passing_grade` float NOT NULL,
  `question_assessment` tinytext NOT NULL,
  `exam_limit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `answers_detail`
--

INSERT INTO `answers_detail` (`answer_detail_id`, `answer_id`, `category`, `correct_answer`, `wrong_answer`, `not_answered`, `total_questions`, `limit_passing_grade`, `passing_grade`, `question_assessment`, `exam_limit`) VALUES
(1, 1, 'Tes Intelegensi Umum (TIU)', 0, 10, 0, 10, 45.71, 0, 'same', 5),
(2, 1, 'Tes Wawasan Kebangsaan (TWK)', 2, 8, 0, 10, 43.33, 20, 'same', 5),
(3, 1, 'Tes Karakteristik Pribadi (TKP)', 6, 2, 0, 8, 74.29, 45, 'different', 5);

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `bank_id` int(11) NOT NULL,
  `bank_number` char(64) NOT NULL,
  `bank_type` char(32) NOT NULL,
  `bank_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`bank_id`, `bank_number`, `bank_type`, `bank_title`) VALUES
(1, '01234567890', 'BCA', 'a.n Bimbel IC Surabaya'),
(2, '11234567891', 'MANDIRI', 'a.n Bimbel IC Surabaya');

-- --------------------------------------------------------

--
-- Table structure for table `choices`
--

CREATE TABLE `choices` (
  `choice_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL DEFAULT '0',
  `question_code` char(1) NOT NULL,
  `weight` int(11) NOT NULL DEFAULT '0',
  `choice` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `choices`
--

INSERT INTO `choices` (`choice_id`, `question_id`, `question_code`, `weight`, `choice`) VALUES
(1, 1, 'A', 5, '<p>Masukan isi jawaban A disini...</p>'),
(2, 1, 'B', 4, '<p>Masukan isi jawaban B disini...</p>'),
(3, 1, 'C', 3, '<p>Masukan isi jawaban C disini...</p>'),
(4, 1, 'D', 2, '<p>Masukan isi jawaban D disini...</p>'),
(5, 1, 'E', 1, '<p>Masukan isi jawaban E disini...</p>'),
(6, 2, 'A', 5, '<p>Masukan isi jawaban A disini...</p>'),
(7, 2, 'B', 0, '<p>Masukan isi jawaban B disini...</p>'),
(8, 2, 'C', 0, '<p>Masukan isi jawaban C disini...</p>'),
(9, 2, 'D', 0, '<p>Masukan isi jawaban D disini...</p>'),
(10, 2, 'E', 0, '<p>Masukan isi jawaban E disini...</p>'),
(11, 3, 'A', 5, '<p>Masukan isi jawaban A disini...</p>'),
(12, 3, 'B', 0, '<p>Masukan isi jawaban B disini...</p>'),
(13, 3, 'C', 0, '<p>Masukan isi jawaban C disini...</p>'),
(14, 3, 'D', 0, '<p>Masukan isi jawaban D disini...</p>'),
(15, 3, 'E', 0, '<p>Masukan isi jawaban E disini...</p>'),
(21, 5, 'A', 0, '<p>Masukan isi jawaban A disini...</p>'),
(22, 5, 'B', 5, '<p>Masukan isi jawaban B disini...</p>'),
(23, 5, 'C', 0, '<p>Masukan isi jawaban C disini...</p>'),
(24, 5, 'D', 0, '<p>Masukan isi jawaban D disini...</p>'),
(25, 5, 'E', 0, '<p>Masukan isi jawaban E disini...</p>'),
(26, 6, 'A', 0, '<p>Masukan isi jawaban A disini...</p>'),
(27, 6, 'B', 0, '<p>Masukan isi jawaban B disini...</p>'),
(28, 6, 'C', 5, '<p>Masukan isi jawaban C disini...</p>'),
(29, 6, 'D', 0, '<p>Masukan isi jawaban D disini...</p>'),
(30, 6, 'E', 0, '<p>Masukan isi jawaban E disini...</p>'),
(31, 7, 'A', 0, '<p>Masukan isi jawaban A disini...</p>'),
(32, 7, 'B', 0, '<p>Masukan isi jawaban B disini...</p>'),
(33, 7, 'C', 0, '<p>Masukan isi jawaban C disini...</p>'),
(34, 7, 'D', 5, '<p>Masukan isi jawaban D disini...</p>'),
(35, 7, 'E', 0, '<p>Masukan isi jawaban E disini...</p>'),
(36, 8, 'A', 0, 'Masukan isi jawaban A disini...'),
(37, 8, 'B', 0, 'Masukan isi jawaban B disini...'),
(38, 8, 'C', 0, 'Masukan isi jawaban C disini...'),
(39, 8, 'D', 0, 'Masukan isi jawaban D disini...'),
(40, 8, 'E', 5, 'Masukan isi jawaban E disini...'),
(41, 9, 'A', 5, '<p>Masukan isi jawaban A disini...</p>'),
(42, 9, 'B', 0, '<p>Masukan isi jawaban B disini...</p>'),
(43, 9, 'C', 0, '<p>Masukan isi jawaban C disini...</p>'),
(44, 9, 'D', 0, '<p>Masukan isi jawaban D disini...</p>'),
(45, 9, 'E', 0, '<p>Masukan isi jawaban E disini...</p>'),
(46, 10, 'A', 0, '<p>Masukan isi jawaban A disini...</p>'),
(47, 10, 'B', 5, '<p>Masukan isi jawaban B disini...</p>'),
(48, 10, 'C', 0, '<p>Masukan isi jawaban C disini...</p>'),
(49, 10, 'D', 0, '<p>Masukan isi jawaban D disini...</p>'),
(50, 10, 'E', 0, '<p>Masukan isi jawaban E disini...</p>'),
(51, 11, 'A', 0, '<p>Masukan isi jawaban A disini...</p>'),
(52, 11, 'B', 0, '<p>Masukan isi jawaban B disini...</p>'),
(53, 11, 'C', 5, '<p>Masukan isi jawaban C disini...</p>'),
(54, 11, 'D', 0, '<p>Masukan isi jawaban D disini...</p>'),
(55, 11, 'E', 0, '<p>Masukan isi jawaban E disini...</p>'),
(56, 12, 'A', 0, 'Masukan isi jawaban A disini...'),
(57, 12, 'B', 0, 'Masukan isi jawaban B disini...'),
(58, 12, 'C', 0, 'Masukan isi jawaban C disini...'),
(59, 12, 'D', 5, 'Masukan isi jawaban D disini...'),
(60, 12, 'E', 0, 'Masukan isi jawaban E disini...'),
(61, 13, 'A', 0, '<p>Masukan isi jawaban A disini...</p>'),
(62, 13, 'B', 0, '<p>Masukan isi jawaban B disini...</p>'),
(63, 13, 'C', 0, '<p>Masukan isi jawaban C disini...</p>'),
(64, 13, 'D', 5, '<p>Masukan isi jawaban D disini...</p>'),
(65, 13, 'E', 0, '<p>Masukan isi jawaban E disini...</p>'),
(66, 14, 'A', 0, '<p>Masukan isi jawaban A disini...</p>'),
(67, 14, 'B', 0, '<p>Masukan isi jawaban B disini...</p>'),
(68, 14, 'C', 0, '<p>Masukan isi jawaban C disini...</p>'),
(69, 14, 'D', 0, '<p>Masukan isi jawaban D disini...</p>'),
(70, 14, 'E', 5, '<p>Masukan isi jawaban E disini...</p>'),
(71, 15, 'A', 0, '<p>Masukan isi jawaban A disini...</p>'),
(72, 15, 'B', 5, '<p>Masukan isi jawaban B disini...</p>'),
(73, 15, 'C', 0, '<p>Masukan isi jawaban C disini...</p>'),
(74, 15, 'D', 0, '<p>Masukan isi jawaban D disini...</p>'),
(75, 15, 'E', 0, '<p>Masukan isi jawaban E disini...</p>'),
(76, 16, 'A', 0, '<p>Masukan isi jawaban A disini...</p>'),
(77, 16, 'B', 0, '<p>Masukan isi jawaban B disini...</p>'),
(78, 16, 'C', 5, '<p>Masukan isi jawaban C disini...</p>'),
(79, 16, 'D', 0, '<p>Masukan isi jawaban D disini...</p>'),
(80, 16, 'E', 0, '<p>Masukan isi jawaban E disini...</p>'),
(81, 17, 'A', 0, '<p>Masukan isi jawaban A disini...</p>'),
(82, 17, 'B', 0, '<p>Masukan isi jawaban B disini...</p>'),
(83, 17, 'C', 0, '<p>Masukan isi jawaban C disini...</p>'),
(84, 17, 'D', 5, '<p>Masukan isi jawaban D disini...</p>'),
(85, 17, 'E', 0, '<p>Masukan isi jawaban E disini...</p>'),
(86, 18, 'A', 0, '<p>Masukan isi jawaban A disini...</p>'),
(87, 18, 'B', 0, '<p>Masukan isi jawaban B disini...</p>'),
(88, 18, 'C', 0, '<p>Masukan isi jawaban C disini...</p>'),
(89, 18, 'D', 0, '<p>Masukan isi jawaban D disini...</p>'),
(90, 18, 'E', 5, '<p>Masukan isi jawaban E disini...</p>'),
(91, 19, 'A', 0, '<p>Masukan isi jawaban A disini...</p>'),
(92, 19, 'B', 5, '<p>Masukan isi jawaban B disini...</p>'),
(93, 19, 'C', 0, '<p>Masukan isi jawaban C disini...</p>'),
(94, 19, 'D', 0, '<p>Masukan isi jawaban D disini...</p>'),
(95, 19, 'E', 0, '<p>Masukan isi jawaban E disini...</p>'),
(96, 20, 'A', 0, '<p>Masukan isi jawaban A disini...</p>'),
(97, 20, 'B', 0, '<p>Masukan isi jawaban B disini...</p>'),
(98, 20, 'C', 5, '<p>Masukan isi jawaban C disini...</p>'),
(99, 20, 'D', 0, '<p>Masukan isi jawaban D disini...</p>'),
(100, 20, 'E', 0, '<p>Masukan isi jawaban E disini...</p>'),
(101, 21, 'A', 0, '<p>Masukan isi jawaban A disini...</p>'),
(102, 21, 'B', 0, '<p>Masukan isi jawaban B disini...</p>'),
(103, 21, 'C', 0, '<p>Masukan isi jawaban C disini...</p>'),
(104, 21, 'D', 5, '<p>Masukan isi jawaban D disini...</p>'),
(105, 21, 'E', 0, '<p>Masukan isi jawaban E disini...</p>'),
(106, 22, 'A', 0, '<p>Masukan isi jawaban A disini...</p>'),
(107, 22, 'B', 0, '<p>Masukan isi jawaban B disini...</p>'),
(108, 22, 'C', 0, '<p>Masukan isi jawaban C disini...</p>'),
(109, 22, 'D', 0, '<p>Masukan isi jawaban D disini...</p>'),
(110, 22, 'E', 5, '<p>Masukan isi jawaban E disini...</p>'),
(111, 23, 'A', 5, '<p>Masukan isi jawaban A disini...</p>'),
(112, 23, 'B', 0, '<p>Masukan isi jawaban B disini...</p>'),
(113, 23, 'C', 0, '<p>Masukan isi jawaban C disini...</p>'),
(114, 23, 'D', 0, '<p>Masukan isi jawaban D disini...</p>'),
(115, 23, 'E', 0, '<p>Masukan isi jawaban E disini...</p>'),
(116, 24, 'A', 0, '<p>Masukan isi jawaban A disini...</p>'),
(117, 24, 'B', 5, '<p>Masukan isi jawaban B disini...</p>'),
(118, 24, 'C', 0, '<p>Masukan isi jawaban C disini...</p>'),
(119, 24, 'D', 0, '<p>Masukan isi jawaban D disini...</p>'),
(120, 24, 'E', 0, '<p>Masukan isi jawaban E disini...</p>'),
(121, 25, 'A', 0, '<p>Masukan isi jawaban A disini...</p>'),
(122, 25, 'B', 0, '<p>Masukan isi jawaban B disini...</p>'),
(123, 25, 'C', 5, '<p>Masukan isi jawaban C disini...</p>'),
(124, 25, 'D', 0, '<p>Masukan isi jawaban D disini...</p>'),
(125, 25, 'E', 0, '<p>Masukan isi jawaban E disini...</p>'),
(126, 26, 'A', 0, '<p>Masukan isi jawaban A disini...</p>'),
(127, 26, 'B', 0, '<p>Masukan isi jawaban B disini...</p>'),
(128, 26, 'C', 0, '<p>Masukan isi jawaban C disini...</p>'),
(129, 26, 'D', 5, '<p>Masukan isi jawaban D disini...</p>'),
(130, 26, 'E', 0, '<p>Masukan isi jawaban E disini...</p>'),
(131, 27, 'A', 0, '<p>Masukan isi jawaban A disini...</p>'),
(132, 27, 'B', 0, '<p>Masukan isi jawaban B disini...</p>'),
(133, 27, 'C', 0, '<p>Masukan isi jawaban C disini...</p>'),
(134, 27, 'D', 0, '<p>Masukan isi jawaban D disini...</p>'),
(135, 27, 'E', 5, '<p>Masukan isi jawaban E disini...</p>'),
(136, 28, 'A', 5, '<p>Masukan isi jawaban A disini...</p>'),
(137, 28, 'B', 0, '<p>Masukan isi jawaban B disini...</p>'),
(138, 28, 'C', 0, '<p>Masukan isi jawaban C disini...</p>'),
(139, 28, 'D', 0, '<p>Masukan isi jawaban D disini...</p>'),
(140, 28, 'E', 0, '<p>Masukan isi jawaban E disini...</p>'),
(141, 29, 'A', 0, '<p>Masukan isi jawaban A disini...</p>'),
(142, 29, 'B', 5, '<p>Masukan isi jawaban B disini...</p>'),
(143, 29, 'C', 4, '<p>Masukan isi jawaban C disini...</p>'),
(144, 29, 'D', 3, '<p>Masukan isi jawaban D disini...</p>'),
(145, 29, 'E', 2, '<p>Masukan isi jawaban E disini...</p>'),
(146, 30, 'A', 2, '<p>Masukan isi jawaban A disini...</p>'),
(147, 30, 'B', 0, '<p>Masukan isi jawaban B disini...</p>'),
(148, 30, 'C', 5, '<p>Masukan isi jawaban C disini...</p>'),
(149, 30, 'D', 4, '<p>Masukan isi jawaban D disini...</p>'),
(150, 30, 'E', 3, '<p>Masukan isi jawaban E disini...</p>'),
(151, 31, 'A', 3, '<p>Masukan isi jawaban A disini...</p>'),
(152, 31, 'B', 2, '<p>Masukan isi jawaban B disini...</p>'),
(153, 31, 'C', 0, '<p>Masukan isi jawaban C disini...</p>'),
(154, 31, 'D', 5, '<p>Masukan isi jawaban D disini...</p>'),
(155, 31, 'E', 4, '<p>Masukan isi jawaban E disini...</p>'),
(156, 32, 'A', 4, '<p>Masukan isi jawaban A disini...</p>'),
(157, 32, 'B', 3, '<p>Masukan isi jawaban B disini...</p>'),
(158, 32, 'C', 2, '<p>Masukan isi jawaban C disini...</p>'),
(159, 32, 'D', 0, '<p>Masukan isi jawaban D disini...</p>'),
(160, 32, 'E', 5, '<p>Masukan isi jawaban E disini...</p>'),
(161, 33, 'A', 5, '<p>Masukan isi jawaban A disini...</p>'),
(162, 33, 'B', 4, '<p>Masukan isi jawaban B disini...</p>'),
(163, 33, 'C', 3, '<p>Masukan isi jawaban C disini...</p>'),
(164, 33, 'D', 2, '<p>Masukan isi jawaban D disini...</p>'),
(165, 33, 'E', 0, '<p>Masukan isi jawaban E disini...</p>'),
(166, 34, 'A', 0, '<p>Masukan isi jawaban A disini...</p>'),
(167, 34, 'B', 5, '<p>Masukan isi jawaban B disini...</p>'),
(168, 34, 'C', 4, '<p>Masukan isi jawaban C disini...</p>'),
(169, 34, 'D', 3, '<p>Masukan isi jawaban D disini...</p>'),
(170, 34, 'E', 2, '<p>Masukan isi jawaban E disini...</p>'),
(171, 35, 'A', 2, '<p>Masukan isi jawaban A disini...</p>'),
(172, 35, 'B', 0, '<p>Masukan isi jawaban B disini...</p>'),
(173, 35, 'C', 3, '<p>Masukan isi jawaban C disini...</p>'),
(174, 35, 'D', 4, '<p>Masukan isi jawaban D disini...</p>'),
(175, 35, 'E', 5, '<p>Masukan isi jawaban E disini...</p>');

-- --------------------------------------------------------

--
-- Table structure for table `configs`
--

CREATE TABLE `configs` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `configs`
--

INSERT INTO `configs` (`id`, `title`, `text`) VALUES
(1, 'Pasing Grade Ujian', '55'),
(2, 'Biaya aktivasi token', '100000');

-- --------------------------------------------------------

--
-- Table structure for table `exam_configs`
--

CREATE TABLE `exam_configs` (
  `exam_config_id` int(11) NOT NULL,
  `question_categori_id` int(11) NOT NULL DEFAULT '0',
  `exam_limit` tinyint(4) NOT NULL DEFAULT '0',
  `number_of_questions` int(11) NOT NULL DEFAULT '0',
  `passing_grade` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exam_configs`
--

INSERT INTO `exam_configs` (`exam_config_id`, `question_categori_id`, `exam_limit`, `number_of_questions`, `passing_grade`) VALUES
(1, 1, 5, 10, 45.71),
(2, 2, 5, 10, 43.33),
(3, 3, 5, 8, 74.29);

-- --------------------------------------------------------

--
-- Table structure for table `exam_user_configs`
--

CREATE TABLE `exam_user_configs` (
  `exam_user_config_id` int(11) NOT NULL,
  `username` char(100) NOT NULL,
  `token` char(6) NOT NULL,
  `total_payment` float NOT NULL,
  `bank_transfer` tinytext NOT NULL,
  `confirm_payment` enum('0','1') NOT NULL,
  `proof_payment` tinytext,
  `create_at` datetime NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exam_user_configs`
--

INSERT INTO `exam_user_configs` (`exam_user_config_id`, `username`, `token`, `total_payment`, `bank_transfer`, `confirm_payment`, `proof_payment`, `create_at`, `update_at`) VALUES
(3, 'sinur', '200401', 100785, '(BCA) 01234567890 a.n Bimbel IC Surabaya', '1', '2000_2d1j_small.jpg', '2020-03-31 23:43:17', '2020-04-01 06:42:09'),
(4, 'userdua', '200412', 100709, '(MANDIRI) 11234567891 a.n Bimbel IC Surabaya', '1', '2ribuanbaru.jpg', '2020-04-12 01:33:08', '2020-04-11 20:07:32');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `sorting` tinyint(4) NOT NULL,
  `title` tinytext NOT NULL,
  `slug` tinytext NOT NULL,
  `description` text NOT NULL,
  `block` enum('0','1') NOT NULL DEFAULT '0',
  `create_at` datetime NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `sorting`, `title`, `slug`, `description`, `block`, `create_at`, `update_at`) VALUES
(1, 3, 'Contact Us', 'hubungi-kami', '<div class=\"jumbotron\">\r\n<h1>Hubungi Kami</h1>\r\n<p>Halaman ini berisi tentang informasi kontak seperti:</p>\r\n<ul>\r\n<li>No Telpon</li>\r\n<li>Whats App</li>\r\n<li>Alamat Kantor</li>\r\n<li>dan sebagainya .....</li>\r\n</ul>\r\n</div>', '0', '2020-03-07 15:28:06', '2020-03-30 18:29:28'),
(2, 2, 'Q & A', 'pertanyaan-dan-jawaban', '<div class=\"jumbotron\">\r\n<h1>Question &amp; Answer</h1>\r\n<p>halaman ini digunakan untuk membantu peserta baru dalam hal pertanyaan dan jawaban terkait try out&nbsp;</p>\r\n</div>', '0', '2020-03-09 13:08:41', '2020-03-30 18:28:39'),
(3, 1, 'Beranda', 'home', '<div class=\"jumbotron\">\r\n<h1>Try Out CAT CPNS BIMBEL IC SURABAYA</h1>\r\n<p>halaman ini digunakan untuk memmbuat tampilan awal sistem sebelum peserta mendaftar</p>\r\n</div>', '0', '2020-03-09 13:10:13', '2020-03-30 18:18:11');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `question_categori_id` int(11) NOT NULL,
  `question` text,
  `block` enum('0','1') NOT NULL DEFAULT '0',
  `create_at` datetime NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `question_categori_id`, `question`, `block`, `create_at`, `update_at`) VALUES
(1, 3, '<p>Masukan Pertanyaan TKP 1 disini .<strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', '0', '2020-03-28 14:41:44', '2020-03-30 18:04:41'),
(2, 1, '<p>Masukan Pertanyaan TIU 1 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-28 14:42:50', '2020-04-02 08:57:36'),
(3, 2, '<p>Masukan Pertanyaan TWK 1 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-28 14:43:03', '2020-04-02 08:57:38'),
(5, 1, '<p>Masukan Pertanyaan&nbsp;TIU 2 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-30 19:27:37', '2020-04-02 08:57:40'),
(6, 1, '<p>Masukan Pertanyaan&nbsp;TIU 3 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-30 19:27:55', '2020-04-02 08:57:43'),
(7, 1, '<p>Masukan Pertanyaan&nbsp;TIU 4 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-30 19:28:17', '2020-04-02 08:57:46'),
(8, 1, '<p>Masukan Pertanyaan&nbsp;TIU 5 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-30 19:28:50', '2020-04-02 08:57:51'),
(9, 1, '<p>Masukan Pertanyaan&nbsp;TIU 6 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-30 19:29:09', '2020-04-02 08:57:53'),
(10, 1, '<p>Masukan Pertanyaan&nbsp;TIU 7 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-30 19:29:20', '2020-04-02 08:57:55'),
(11, 1, '<p>Masukan Pertanyaan&nbsp;TIU 8 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-30 19:29:30', '2020-04-02 08:57:57'),
(12, 1, '<p>Masukan Pertanyaan&nbsp;TIU 9 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-30 19:29:40', '2020-04-02 08:57:58'),
(13, 1, '<p>Masukan Pertanyaan&nbsp;TIU 10 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-30 19:29:51', '2020-04-02 08:58:00'),
(14, 1, '<p>Masukan Pertanyaan&nbsp;TIU 11 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-30 19:30:07', '2020-04-02 08:58:02'),
(15, 1, '<p>Masukan Pertanyaan&nbsp;TIU 12 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-30 19:55:11', '2020-04-02 08:58:03'),
(16, 1, '<p>Masukan Pertanyaan&nbsp;TIU 13 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-30 19:55:25', '2020-04-02 08:58:05'),
(17, 1, '<p>Masukan Pertanyaan&nbsp;TIU 14 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-30 19:55:53', '2020-04-02 08:58:07'),
(18, 1, '<p>Masukan Pertanyaan&nbsp;TIU 15 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-30 19:56:04', '2020-04-02 08:58:08'),
(19, 2, '<p>Masukan Pertanyaan TWK 2 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-31 00:15:09', '2020-04-02 08:58:10'),
(20, 2, '<p>Masukan Pertanyaan&nbsp;TWK 3 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-31 00:15:26', '2020-04-02 08:58:11'),
(21, 2, '<p>Masukan Pertanyaan&nbsp;TWK 4 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-31 00:15:43', '2020-04-02 08:58:13'),
(22, 2, '<p>Masukan Pertanyaan&nbsp;TWK 5 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-31 00:16:03', '2020-04-02 08:58:15'),
(23, 2, '<p>Masukan Pertanyaan&nbsp;TWK 6 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-31 00:16:19', '2020-04-02 08:58:17'),
(24, 2, '<p>Masukan Pertanyaan&nbsp;TWK 7 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-31 00:16:38', '2020-04-02 08:58:19'),
(25, 2, '<p>Masukan Pertanyaan&nbsp;TWK 8 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-31 00:16:57', '2020-04-02 08:58:20'),
(26, 2, '<p>Masukan Pertanyaan&nbsp;TWK 9 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-31 00:17:19', '2020-04-02 08:58:25'),
(27, 2, '<p>Masukan Pertanyaan&nbsp;TWK 10 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-31 00:17:46', '2020-04-02 08:58:37'),
(28, 2, '<p>Masukan Pertanyaan&nbsp;TWK 11 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-31 00:17:59', '2020-04-02 08:58:39'),
(29, 3, '<p>Masukan Pertanyaan&nbsp;TKP 2 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-31 00:19:35', '2020-04-02 08:58:41'),
(30, 3, '<p>Masukan Pertanyaan&nbsp;TKP 3 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-31 00:20:41', '2020-04-02 08:58:42'),
(31, 3, '<p>Masukan Pertanyaan&nbsp;TKP 4 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-31 00:21:07', '2020-04-02 08:58:43'),
(32, 3, '<p>Masukan Pertanyaan&nbsp;TKP 5 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-31 00:21:34', '2020-04-02 08:58:45'),
(33, 3, '<p>Masukan Pertanyaan&nbsp;TKP 6 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-31 00:22:09', '2020-04-02 08:58:46'),
(34, 3, '<p>Masukan Pertanyaan&nbsp;TKP 7 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-31 00:22:40', '2020-04-02 08:58:48'),
(35, 3, '<p>Masukan Pertanyaan&nbsp;TKP 8 disini ...</p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '0', '2020-03-31 00:23:58', '2020-04-02 08:58:51');

-- --------------------------------------------------------

--
-- Table structure for table `question_categories`
--

CREATE TABLE `question_categories` (
  `question_categori_id` int(11) NOT NULL,
  `title` tinytext NOT NULL,
  `count_of_choices` int(11) DEFAULT '5',
  `true_question` enum('same','different') NOT NULL,
  `true_grade` int(11) NOT NULL,
  `block` enum('0','1') NOT NULL DEFAULT '0',
  `create_at` datetime NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question_categories`
--

INSERT INTO `question_categories` (`question_categori_id`, `title`, `count_of_choices`, `true_question`, `true_grade`, `block`, `create_at`, `update_at`) VALUES
(1, 'Tes Intelegensi Umum (TIU)', 5, 'same', 5, '0', '2020-03-04 00:00:00', '2020-03-30 06:16:07'),
(2, 'Tes Wawasan Kebangsaan (TWK)', 5, 'same', 5, '0', '2020-03-09 16:02:59', '2020-03-24 08:11:34'),
(3, 'Tes Karakteristik Pribadi (TKP)', 5, 'different', 0, '0', '2020-03-09 16:03:30', '2020-03-24 08:10:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` char(100) NOT NULL,
  `password` char(160) NOT NULL,
  `level` enum('root','user') NOT NULL,
  `block` enum('0','1') NOT NULL DEFAULT '0',
  `create_at` datetime NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `level`, `block`, `create_at`, `update_at`, `last_login`) VALUES
(1, 'admin', 'd4a2d1f4463233df7c1e359163c4205589e3e42afaf9c180fd3880f54afae3739e42806bef2e6bff93db0c32843ee4508dfc705634bb94064bc89375a82d3c3eFdl29xSvL3lrtWKuyCRyQgx09QmY', 'root', '0', '0000-00-00 00:00:00', '2020-04-11 18:26:12', '2020-04-12 01:26:12'),
(5, 'sinur', 'f45169cb04b9019b3f333dadc3dc4470bea1535064edb195af7a1480498b1ae63a921a520b94472fd990c7acad4442d05cd7a2f609bba26ca8593b9139619da11UYxdy9e72kRVZmp5rCZiPfYWw8Zyg==', 'user', '0', '2020-03-31 13:43:03', '2020-04-11 18:26:12', '2020-04-12 01:26:12'),
(6, 'userdua', '61dd55d4a4352fef2efd8f9989f6fd43c60266ecfd0975ed5fcf4ad4acb08b9df33b45ee8288e071854dc9f35ff1acba33b1937467f06458fe2bb131a7344c52/Nrp0MdHbL12g0Q5y6kNS0RTTyncKWI=', 'user', '0', '2020-04-12 00:57:00', '2020-04-11 18:32:55', '2020-04-12 01:32:55');

-- --------------------------------------------------------

--
-- Table structure for table `users_detail`
--

CREATE TABLE `users_detail` (
  `user_detail_id` int(11) NOT NULL,
  `username` char(100) NOT NULL,
  `nik` char(16) NOT NULL,
  `fullname` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `telp` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_detail`
--

INSERT INTO `users_detail` (`user_detail_id`, `username`, `nik`, `fullname`, `email`, `telp`) VALUES
(1, 'admin', '1234567890123456', 'ADMIN', 'pinsus2017surabaya@gmail.com', '081234567890'),
(2, 'sinur', '1234567890123457', 'Jogjasite \' Developer', 'tryscm@gmail.com', '081225306889'),
(3, 'userdua', '1234567890123457', 'User ke Dua', '3s0c9m7@gmail.com', '081225306789');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`answer_id`);

--
-- Indexes for table `answers_detail`
--
ALTER TABLE `answers_detail`
  ADD PRIMARY KEY (`answer_detail_id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`bank_id`);

--
-- Indexes for table `choices`
--
ALTER TABLE `choices`
  ADD PRIMARY KEY (`choice_id`);

--
-- Indexes for table `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_configs`
--
ALTER TABLE `exam_configs`
  ADD PRIMARY KEY (`exam_config_id`);

--
-- Indexes for table `exam_user_configs`
--
ALTER TABLE `exam_user_configs`
  ADD PRIMARY KEY (`exam_user_config_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `question_categories`
--
ALTER TABLE `question_categories`
  ADD PRIMARY KEY (`question_categori_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_detail`
--
ALTER TABLE `users_detail`
  ADD PRIMARY KEY (`user_detail_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `answers_detail`
--
ALTER TABLE `answers_detail`
  MODIFY `answer_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `bank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `choices`
--
ALTER TABLE `choices`
  MODIFY `choice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `configs`
--
ALTER TABLE `configs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `exam_configs`
--
ALTER TABLE `exam_configs`
  MODIFY `exam_config_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `exam_user_configs`
--
ALTER TABLE `exam_user_configs`
  MODIFY `exam_user_config_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `question_categories`
--
ALTER TABLE `question_categories`
  MODIFY `question_categori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users_detail`
--
ALTER TABLE `users_detail`
  MODIFY `user_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
