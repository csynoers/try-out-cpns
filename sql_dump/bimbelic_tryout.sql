-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2020 at 10:00 AM
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
-- Database: `bimbelic_tryout`
--

-- --------------------------------------------------------

--
-- Table structure for table `choices`
--

CREATE TABLE `choices` (
  `choice_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL DEFAULT '0',
  `weight` int(11) NOT NULL DEFAULT '0',
  `choice` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `choices`
--

INSERT INTO `choices` (`choice_id`, `question_id`, `weight`, `choice`) VALUES
(1, 1, 0, '');

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
(1, 3, 'Contact Us', 'hubungi-kami', '<p>Halaman ini berisi tentang informasi kontak seperti:</p>\r\n<ul>\r\n<li>No Telpon</li>\r\n<li>Whats App</li>\r\n<li>Alamat Kantor</li>\r\n<li>dan sebagainya .....</li>\r\n</ul>', '0', '2020-03-07 15:28:06', '2020-03-10 06:09:50'),
(2, 2, 'Q & A', 'pertanyaan-dan-jawaban', '<p>halaman ini digunakan untuk membantu peserta baru dalam hal pertanyaan dan jawaban&nbsp;</p>', '0', '2020-03-09 13:08:41', '2020-03-10 06:09:48'),
(3, 1, 'Beranda', 'home', '<p>halaman ini digunakan untuk memmbuat tampilan awal sistem sebelum peserta mendaftar</p>', '0', '2020-03-09 13:10:13', '2020-03-10 06:09:44');

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
(1, 1, 'pertanyaan no 1', '0', '2020-03-05 00:00:00', '2020-03-05 03:48:33');

-- --------------------------------------------------------

--
-- Table structure for table `question_categories`
--

CREATE TABLE `question_categories` (
  `question_categori_id` int(11) NOT NULL,
  `title` tinytext NOT NULL,
  `count_of_choices` int(11) DEFAULT '5',
  `block` enum('0','1') NOT NULL DEFAULT '0',
  `create_at` datetime NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question_categories`
--

INSERT INTO `question_categories` (`question_categori_id`, `title`, `count_of_choices`, `block`, `create_at`, `update_at`) VALUES
(1, 'Tes Intelegensi Umum (TIU)', 5, '0', '2020-03-04 00:00:00', '2020-03-23 07:07:58'),
(2, 'Tes Wawasan Kebangsaan (TWK)', 5, '0', '2020-03-09 16:02:59', '2020-03-23 07:08:01'),
(3, 'Tes Karakteristik Pribadi (TKP)', 5, '0', '2020-03-09 16:03:30', '2020-03-23 07:08:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` char(100) NOT NULL,
  `password` char(156) NOT NULL,
  `level` enum('root') NOT NULL,
  `block` enum('0','1') NOT NULL DEFAULT '0',
  `create_at` datetime NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `level`, `block`, `create_at`, `update_at`, `last_login`) VALUES
(1, 'admin', 'bc773127e932f3dd7f335f6d29de010058f5bc4c35216eb28237ee025d31fff695040f08f994c4d594f8d735ecb68955b4718033d46cd76f191f333a0c7c5f2csgtc3dACe/h+JbCV3YCTTKIcyA6C', 'root', '0', '0000-00-00 00:00:00', '2020-03-02 07:30:45', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `choices`
--
ALTER TABLE `choices`
  ADD PRIMARY KEY (`choice_id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `choices`
--
ALTER TABLE `choices`
  MODIFY `choice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `question_categories`
--
ALTER TABLE `question_categories`
  MODIFY `question_categori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
