-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2023 at 03:00 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `open_mic`
--

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

CREATE TABLE `blocks` (
  `BLK_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `blocked_user_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `C_ID` int(11) NOT NULL,
  `post_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`C_ID`, `post_ID`, `user_ID`, `comment_text`, `created_at`) VALUES
(1, 26, 2, 'Justice will be served.', '2022-12-29 14:32:38'),
(2, 25, 2, ';)', '2022-12-29 14:36:21'),
(3, 23, 2, 'Yeah!!!', '2022-12-29 14:36:59'),
(79, 24, 30, 'hell of a fire!', '2023-01-01 04:22:20');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `L_ID` int(11) NOT NULL,
  `post_ID` int(11) DEFAULT NULL,
  `user_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`L_ID`, `post_ID`, `user_ID`) VALUES
(30, 24, 2),
(31, 26, 2),
(35, 24, 30);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `MSG_ID` int(11) NOT NULL,
  `to_user_ID` int(11) NOT NULL,
  `from_user_ID` int(11) NOT NULL,
  `msg` text NOT NULL,
  `read_status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `NTF_ID` int(11) NOT NULL,
  `to_user_ID` int(11) NOT NULL,
  `from_user_ID` int(11) NOT NULL,
  `ntf_msg` text NOT NULL,
  `read_status` int(11) NOT NULL DEFAULT 0 COMMENT '0=unread, 1=read, 2=deleted',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `post_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`NTF_ID`, `to_user_ID`, `from_user_ID`, `ntf_msg`, `read_status`, `created_at`, `post_ID`) VALUES
(18, 2, 30, 'Blocked you', 1, '2023-01-01 04:33:14', 0),
(19, 2, 30, 'Unblocked you !', 1, '2023-01-01 04:57:36', 0),
(20, 2, 30, 'liked your post !', 1, '2023-01-01 07:05:52', 24),
(21, 2, 1, 'started supporting you !', 1, '2023-01-01 07:51:37', 0),
(22, 2, 1, 'have unsupported you !', 1, '2023-01-01 07:57:06', 0);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `P_ID` int(11) NOT NULL,
  `U_ID` int(11) NOT NULL,
  `post_img` text DEFAULT NULL,
  `post_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`P_ID`, `U_ID`, `post_img`, `post_text`, `created_at`) VALUES
(23, 1, '1671958732post5.jpg', 'REVOLUTION on the horizon!', '2022-12-25 08:58:52'),
(24, 2, '1671958990post2.jpg', 'NULL', '2022-12-25 09:14:18'),
(25, 1, '1671959109post3.jpg', 'Can\'t barricade our opinions.', '2022-12-25 09:05:09'),
(26, 1, '1671959138post1.jpg', 'WE WANT JUSTICE!!!', '2022-12-25 09:05:38'),
(27, 2, 'NULL', 'This is a image free post', '2022-12-29 11:51:33'),
(28, 27, '1672115366post4.jpg', 'I am graduated', '2022-12-29 11:48:17'),
(29, 28, '1672117545post3.jpg', 'Barricade', '2022-12-29 11:51:41'),
(30, 1, '1672117587post2.jpg', 'Anonymous post', '2022-12-29 11:51:47'),
(33, 30, '1672127213post5.jpg', 'I\'m on fire!!!', '2022-12-27 07:46:53'),
(34, 31, '1672133212post1.jpg', 'We are one!!!', '2022-12-29 11:52:00'),
(35, 33, '1672142425post1.jpg', 'We are one', '2022-12-29 11:52:07');

-- --------------------------------------------------------

--
-- Table structure for table `supporters`
--

CREATE TABLE `supporters` (
  `S_ID` int(11) NOT NULL,
  `supporter_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `supporter_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supporters`
--

INSERT INTO `supporters` (`S_ID`, `supporter_ID`, `user_ID`, `supporter_created_at`) VALUES
(27, 27, 2, '2022-12-27 04:27:03'),
(28, 27, 1, '2022-12-27 04:27:10'),
(29, 28, 27, '2022-12-27 04:41:05'),
(30, 28, 1, '2022-12-27 04:41:11'),
(32, 28, 2, '2022-12-27 05:06:53'),
(42, 30, 1, '2022-12-27 07:46:16'),
(44, 31, 1, '2022-12-27 09:25:13'),
(45, 31, 2, '2022-12-27 09:25:15'),
(46, 33, 2, '2022-12-27 11:58:56'),
(47, 33, 1, '2022-12-27 11:58:58'),
(50, 34, 2, '2022-12-28 10:12:48'),
(51, 34, 1, '2022-12-28 10:12:51'),
(64, 2, 1, '2022-12-28 14:36:20'),
(95, 2, 28, '2022-12-29 11:44:08'),
(97, 2, 27, '2022-12-29 11:44:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `U_ID` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `pswd` text NOT NULL,
  `gender` int(11) NOT NULL,
  `DOB` date DEFAULT NULL,
  `profile_img` text NOT NULL DEFAULT 'defaultProfilepic.jpg',
  `User_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `acc_status` int(11) NOT NULL COMMENT '0=not verified,1=verified,2=blocked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`U_ID`, `first_name`, `last_name`, `email`, `username`, `pswd`, `gender`, `DOB`, `profile_img`, `User_created_at`, `updated_at`, `acc_status`) VALUES
(1, 'I am', 'nobody', '', 'anonymous', 'e807f1fcf82d132f9bb018ca6738a19f', 0, NULL, 'anonProfilepic.jpg', '2022-12-25 06:48:39', '2022-12-25 06:53:42', 1),
(2, 'Miraz', 'Kamal', 'mirazkamalhimel10@gmail.com', 'himu', '25f9e794323b453885f5181f1b624d0b', 1, NULL, '1672314655istockphoto-962366210-170667a.jpg', '2022-12-21 09:19:58', '2022-12-29 11:50:55', 1),
(27, 'arif', 'islam', 'mislam181126@bscse.uiu.ac.bd', 'arif', '25f9e794323b453885f5181f1b624d0b', 1, NULL, '1672121788profile2.jpg', '2022-12-27 04:25:30', '2022-12-27 06:16:28', 1),
(28, 'aurna', 'nawal', 'fabihanawal123@gmail.com', 'aurna', '25f9e794323b453885f5181f1b624d0b', 2, NULL, '1672117463profile3.jpg', '2022-12-27 04:35:06', '2022-12-27 05:04:23', 1),
(30, 'Md Asif', 'Khan', 'arnobasifkhan@gmail.com', 'asif', '25f9e794323b453885f5181f1b624d0b', 1, NULL, '1672127260profile.jpg', '2022-12-27 07:45:06', '2022-12-28 14:29:36', 1),
(31, 'mizanur', 'rahman', 'mrahman181066@bscse.uiu.ac.bd', 'mizan', '25f9e794323b453885f5181f1b624d0b', 1, NULL, '1672133246profile7.jpg', '2022-12-27 09:23:55', '2022-12-27 09:27:26', 1),
(33, 'sunmoon', 'hossain', 'khansiam171@gmail.com', 'pakhi', '25f9e794323b453885f5181f1b624d0b', 1, NULL, '1672142528profile.jpg', '2022-12-27 11:57:39', '2022-12-27 12:02:08', 1),
(34, 'arafat', 'riad', 'arafatriad9@gmail.com', 'arafat', '25f9e794323b453885f5181f1b624d0b', 1, NULL, 'defaultProfilepic.jpg', '2022-12-28 10:10:06', '2022-12-28 14:29:25', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`BLK_ID`),
  ADD KEY `blocks_fk_1` (`user_ID`),
  ADD KEY `blocks_fk_2` (`blocked_user_ID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`C_ID`),
  ADD KEY `comments_fk_1` (`post_ID`),
  ADD KEY `comments_fk_2` (`user_ID`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`L_ID`),
  ADD KEY `likes_fk_1` (`post_ID`),
  ADD KEY `likes_fk_2` (`user_ID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`MSG_ID`),
  ADD KEY `messages_fk_1` (`to_user_ID`),
  ADD KEY `messages_fk_2` (`from_user_ID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`NTF_ID`),
  ADD KEY `notifications_fk_1` (`to_user_ID`),
  ADD KEY `notifications_fk_2` (`from_user_ID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`P_ID`),
  ADD KEY `posts_fk_1` (`U_ID`);

--
-- Indexes for table `supporters`
--
ALTER TABLE `supporters`
  ADD PRIMARY KEY (`S_ID`),
  ADD KEY `supporters_fk_1` (`user_ID`),
  ADD KEY `supporters_fk_2` (`supporter_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`U_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blocks`
--
ALTER TABLE `blocks`
  MODIFY `BLK_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `C_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `L_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `MSG_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `NTF_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `P_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `supporters`
--
ALTER TABLE `supporters`
  MODIFY `S_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `U_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blocks`
--
ALTER TABLE `blocks`
  ADD CONSTRAINT `blocks_fk_1` FOREIGN KEY (`user_ID`) REFERENCES `users` (`U_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `blocks_fk_2` FOREIGN KEY (`blocked_user_ID`) REFERENCES `users` (`U_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_fk_1` FOREIGN KEY (`post_ID`) REFERENCES `posts` (`P_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_fk_2` FOREIGN KEY (`user_ID`) REFERENCES `users` (`U_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_fk_1` FOREIGN KEY (`post_ID`) REFERENCES `posts` (`P_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_fk_2` FOREIGN KEY (`user_ID`) REFERENCES `users` (`U_ID`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_fk_1` FOREIGN KEY (`to_user_ID`) REFERENCES `users` (`U_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_fk_2` FOREIGN KEY (`from_user_ID`) REFERENCES `users` (`U_ID`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_fk_1` FOREIGN KEY (`to_user_ID`) REFERENCES `users` (`U_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_fk_2` FOREIGN KEY (`from_user_ID`) REFERENCES `users` (`U_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_fk_1` FOREIGN KEY (`U_ID`) REFERENCES `users` (`U_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `supporters`
--
ALTER TABLE `supporters`
  ADD CONSTRAINT `supporters_fk_1` FOREIGN KEY (`user_ID`) REFERENCES `users` (`U_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `supporters_fk_2` FOREIGN KEY (`supporter_ID`) REFERENCES `users` (`U_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
