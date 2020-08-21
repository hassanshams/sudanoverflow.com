-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 21, 2020 at 10:36 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sudan_overflow`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `body` longtext CHARACTER SET utf8 NOT NULL,
  `answerer` varchar(100) CHARACTER SET utf8 NOT NULL,
  `tags` varchar(200) CHARACTER SET utf8 NOT NULL,
  `at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `accepted` int(11) NOT NULL,
  `votes` int(11) NOT NULL,
  `answerer_id` int(11) NOT NULL,
  `answerer_username` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `body`, `answerer`, `tags`, `at`, `accepted`, `votes`, `answerer_id`, `answerer_username`) VALUES
(17, 6, '<p>fghjkl./</p>', 'a', 'HTML', '2020-08-21 11:16:54', 0, 0, 97, 'qxcvsdvzsvdrfvdfvdfvdf');

-- --------------------------------------------------------

--
-- Table structure for table `answers_comments`
--

CREATE TABLE `answers_comments` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `comment` varchar(100) NOT NULL,
  `commentor` varchar(100) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `commentor_username` varchar(100) NOT NULL,
  `commentor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `answer_votes`
--

CREATE TABLE `answer_votes` (
  `id` int(11) NOT NULL,
  `voter` varchar(100) CHARACTER SET utf8 NOT NULL,
  `answer_id` int(11) NOT NULL,
  `down_up` int(11) NOT NULL,
  `at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `comment` longtext CHARACTER SET utf8 NOT NULL,
  `question_id` int(11) NOT NULL,
  `commentor` varchar(100) CHARACTER SET utf8 NOT NULL,
  `at` timestamp NOT NULL DEFAULT current_timestamp(),
  `commentor_username` varchar(100) NOT NULL,
  `commentor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `to_` varchar(100) CHARACTER SET utf8 NOT NULL,
  `from_` varchar(100) CHARACTER SET utf8 NOT NULL,
  `link_` varchar(50) CHARACTER SET utf8 NOT NULL,
  `section` varchar(50) CHARACTER SET utf8 NOT NULL,
  `question_id` int(11) NOT NULL,
  `delete_id` int(11) NOT NULL,
  `at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `seen` int(11) NOT NULL,
  `type` varchar(100) CHARACTER SET utf8 NOT NULL,
  `answer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `to_`, `from_`, `link_`, `section`, `question_id`, `delete_id`, `at`, `seen`, `type`, `answer_id`) VALUES
(30, 'hassanshams43@gmail.com', 'a', '374930556', '6', 6, 2, '2020-08-21 07:03:49', 0, 'commented', 0),
(31, 'hassanshams43@gmail.com', 'a', '374930556', '6', 6, 3, '2020-08-21 07:09:07', 0, 'commented', 0),
(32, 'hassanshams43@gmail.com', 'a', '374930556', '6', 6, 4, '2020-08-21 07:12:11', 0, 'commented', 0),
(33, 'hassanshams43@gmail.com', 'a', '374930556', '6', 6, 5, '2020-08-21 07:12:37', 0, 'commented', 0),
(34, 'hassanshams43@gmail.com', 'a', '374930556', '17', 6, 17, '2020-08-21 11:16:54', 0, 'answered', 17);

-- --------------------------------------------------------

--
-- Table structure for table `points`
--

CREATE TABLE `points` (
  `id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `user` varchar(100) CHARACTER SET utf8 NOT NULL,
  `type_` varchar(50) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(100) NOT NULL,
  `title` varchar(200) NOT NULL,
  `body` longtext NOT NULL,
  `tags` varchar(100) NOT NULL,
  `asker` varchar(100) NOT NULL,
  `asker_id` int(11) NOT NULL,
  `votes` int(11) NOT NULL,
  `edited_at` varchar(50) CHARACTER SET latin1 NOT NULL,
  `views` int(11) NOT NULL,
  `answers` int(11) NOT NULL,
  `at` timestamp NOT NULL DEFAULT current_timestamp(),
  `asker_username` varchar(100) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `title`, `body`, `tags`, `asker`, `asker_id`, `votes`, `edited_at`, `views`, `answers`, `at`, `asker_username`) VALUES
(6, 'jjui', '<p>محتوي السوال</p>', 'HTML', 'hassanshams43@gmail.com', 79, 0, '', 0, 0, '2020-08-21 06:17:07', 'hassan shams');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`) VALUES
(1, 'PHP1'),
(2, 'HTML');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `username` varchar(100) CHARACTER SET utf8 NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 NOT NULL,
  `profile_pic` varchar(100) CHARACTER SET utf8 NOT NULL,
  `location` varchar(100) CHARACTER SET utf8 NOT NULL,
  `job` varchar(100) CHARACTER SET utf8 NOT NULL,
  `college` varchar(100) CHARACTER SET utf8 NOT NULL,
  `bio` longtext CHARACTER SET utf8 NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `points` int(11) NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 NOT NULL,
  `activated` int(11) NOT NULL,
  `token` varchar(100) NOT NULL,
  `social` int(11) NOT NULL,
  `recovery_token` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `profile_pic`, `location`, `job`, `college`, `bio`, `full_name`, `points`, `email`, `activated`, `token`, `social`, `recovery_token`, `created_at`) VALUES
(79, 'hassan shams', 'c4ca4238a0b923820dcc509a6f75849b', '79.png', 'khartoum', 'virtualization and storage administrator', 'sudan international university', 'Lorem ipsum dolor sit amet, in suas sonet maiestatis vis, ex mea dicat laudem corpora. Laoreet maiorum eos ex. Ei euismod graecis luptatum sit. Etiam viderer accusata cu ius, eos reprehendunt comprehensam id. Mel veritus volumus ex, eos semper scripta an.\n', 'hassan shamseldeen alameen', 31, 'hassanshams43@gmail.com', 1, '', 1, 10731123, '2020-06-21 06:43:17'),
(97, 'qxcvsdvzsvdrfvdfvdfvdf', '7694f4a66316e53c8cdd9d9954bd611d', 'defult.png', '', '', '', '', '', 0, 'a', 1, 'f194efc16628eea40f62f2ac9e71de82', 0, 0, '2020-07-10 09:16:21'),
(98, 'xxx', '0cc175b9c0f1b6a831c399e269772661', 'default.png', '', '', '', '', '', 0, 'hassanshamss43@yahoo.com', 0, 'e8a3c34e5aa393586e04fc6e4dc864c5', 0, 36217633, '2020-07-10 09:19:28'),
(99, 'test user', 'c4ca4238a0b923820dcc509a6f75849b', 'default.png', '', '', '', '', '', 0, 'hassanshams43@yahoo.com', 1, 'c74f317ef958075b21c39a78ef0b5c1b', 0, 0, '2020-07-13 19:05:20');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `voter` varchar(100) CHARACTER SET utf8 NOT NULL,
  `down_up` int(11) NOT NULL,
  `at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `answers_comments`
--
ALTER TABLE `answers_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `answer_votes`
--
ALTER TABLE `answer_votes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `points`
--
ALTER TABLE `points`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `answers_comments`
--
ALTER TABLE `answers_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `answer_votes`
--
ALTER TABLE `answer_votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `points`
--
ALTER TABLE `points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
