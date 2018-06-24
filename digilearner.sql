-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 24, 2018 at 07:29 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `digilearner`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_body` text NOT NULL,
  `posted_by` varchar(60) NOT NULL,
  `posted_to` varchar(60) NOT NULL,
  `date_added` datetime NOT NULL,
  `removed` varchar(3) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_body`, `posted_by`, `posted_to`, `date_added`, `removed`, `post_id`) VALUES
(69, 'scssf', 'abhishek_nair', 'abhishek_nair', '2018-06-21 00:37:54', 'no', 172);

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` int(11) NOT NULL,
  `user_to` varchar(50) NOT NULL,
  `user_from` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `grp_name` varchar(255) DEFAULT NULL,
  `grp_info` text,
  `picture` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `grp_name`, `grp_info`, `picture`, `created_by`, `status`, `created_at`) VALUES
(1, 'ksk', 'test', 'assets/images/group_cover_photos/5b2e8f3ea003a4fc598f2c9f2c0cdc5e0decc188d8d10_ft_xl.jpg', 'koushik_kanjilal', 1, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE `group_members` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_members`
--

INSERT INTO `group_members` (`id`, `group_id`, `user_name`, `added_on`) VALUES
(1, 1, 'abhishek_nair', '0000-00-00 00:00:00'),
(2, 1, 'abhishek_krishna_1', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `username`, `post_id`) VALUES
(145, 'abhishek_nair', 172);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_to` varchar(50) NOT NULL,
  `user_from` varchar(50) NOT NULL,
  `body` text NOT NULL,
  `date` datetime NOT NULL,
  `opened` varchar(3) NOT NULL,
  `viewed` varchar(3) NOT NULL,
  `deleted` varchar(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_to`, `user_from`, `body`, `date`, `opened`, `viewed`, `deleted`) VALUES
(232, 'abhishek_nair', 'abhishek_nair', 'hi', '2018-06-21 00:38:04', 'yes', 'no', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_to` varchar(50) NOT NULL,
  `user_from` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `link` varchar(100) NOT NULL,
  `datetime` datetime NOT NULL,
  `opened` varchar(3) NOT NULL,
  `viewed` varchar(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `body` text NOT NULL,
  `added_by` varchar(60) NOT NULL,
  `user_to` varchar(60) NOT NULL,
  `date_added` datetime NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `deleted` varchar(3) NOT NULL,
  `likes` int(11) NOT NULL,
  `image` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `body`, `added_by`, `user_to`, `date_added`, `user_closed`, `deleted`, `likes`, `image`) VALUES
(174, 'hello', 'abhishek_nair', 'none', '2018-06-21 13:20:13', 'no', 'no', 0, ''),
(172, 'hai', 'abhishek_nair', 'none', '2018-06-21 00:37:40', 'no', 'no', 1, ''),
(173, 'hello', 'abhishek_nair', 'none', '2018-06-21 11:46:36', 'no', 'no', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `reg_teach`
--

CREATE TABLE `reg_teach` (
  `id` int(11) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `sighup_date` date NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `County Code` int(11) NOT NULL,
  `phone_number` varchar(12) NOT NULL,
  `institution` varchar(255) NOT NULL,
  `gender` varchar(7) NOT NULL,
  `date_of_birth` date NOT NULL,
  `connection_array` text NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `num_posts` int(11) NOT NULL,
  `user_activation_code` varchar(250) NOT NULL,
  `email_activation` varchar(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reg_teach`
--

INSERT INTO `reg_teach` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `sighup_date`, `profile_pic`, `County Code`, `phone_number`, `institution`, `gender`, `date_of_birth`, `connection_array`, `user_closed`, `num_posts`, `user_activation_code`, `email_activation`) VALUES
(44, 'Abhishek', 'Nair', 'abhishek_nair', 'Abhi@gmail.com', 'e807f1fcf82d132f9bb018ca6738a19f', '2018-06-21', 'assets/images/profile_pics/abhishek_nair8ae0470793f5bc5bb07edcc37e9178b8n.jpeg', 0, '7025731901', 'Cusat', 'male', '2007-08-09', ',', 'no', 3, '', ''),
(45, 'Abhishek', 'Krishna', 'abhishek_krishna', 'Q@q.c', 'e807f1fcf82d132f9bb018ca6738a19f', '2018-06-21', 'assets/images/profile_pics/defaults/teacher.png', 0, '7025731901', 'Cusat', 'male', '2009-12-31', ',', 'no', 0, 'e3844e186e6eb8736e9f53c0c5889527', 'no'),
(46, 'Abhishek', 'Krishna', 'abhishek_krishna_1', 'Qa@q.c', 'e807f1fcf82d132f9bb018ca6738a19f', '2018-06-21', 'assets/images/profile_pics/defaults/teacher.png', 0, '7025731901', 'Cusat', 'male', '2009-12-31', ',', 'no', 0, 'd501091236ae1875a06c4fa666166697', 'no'),
(47, 'Krishna', 'Nair', 'krishna_nair', 'Nico@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2018-06-21', 'assets/images/profile_pics/defaults/teacher.png', 0, '7025731901', 'Cusat', 'male', '2010-01-01', ',', 'no', 0, '4764f37856fc727f70b666b8d0c4ab7a', 'no'),
(48, 'Abhishek', 'Aa', 'abhishek_aa', 'Jiji@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2018-06-21', 'assets/images/profile_pics/defaults/teacher.png', 0, '7025731901', '1', 'male', '2010-01-01', ',', 'no', 0, 'ed4227734ed75d343320b6a5fd16ce57', 'no'),
(49, 'Abhishek', 'Nair', 'abhishek_nair_1', 'Wadwa@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2018-06-21', 'assets/images/profile_pics/defaults/teacher.png', 0, '7025731901', 'Cusat', 'male', '2010-01-01', ',', 'no', 0, '6e1ff1976ef507dfe2693cfcbdd9aae6', 'no'),
(50, 'Digital', 'Qqq', 'digital_qqq', 'Aa@b.c', 'e807f1fcf82d132f9bb018ca6738a19f', '2018-06-21', 'assets/images/profile_pics/defaults/teacher.png', 0, '7025731901', 'Cusat', 'male', '2010-01-01', ',', 'no', 0, 'e3cbb2b5450e080ca960e2958f20e0ee', 'no'),
(51, 'Digital', 'Qqq', 'digital_qqq_1', 'Aaa@b.c', 'e10adc3949ba59abbe56e057f20f883e', '2018-06-21', 'assets/images/profile_pics/defaults/teacher.png', 0, '7025731901', 'Cusat', 'male', '2010-01-01', ',', 'no', 0, '97e8527feaf77a97fc38f34216141515', 'no'),
(52, 'Digital', 'Qqq', 'digital_qqq_1_2', 'Aaaa@b.c', 'e10adc3949ba59abbe56e057f20f883e', '2018-06-21', 'assets/images/profile_pics/defaults/teacher.png', 0, '7025731901', 'Cusat', 'male', '2010-01-01', ',', 'no', 0, '38225eda9bcf2606642402111288fc24', 'no'),
(53, 'Digital', 'Qqq', 'digital_qqq_1_2_3', 'Aaaaa@b.c', 'e10adc3949ba59abbe56e057f20f883e', '2018-06-21', 'assets/images/profile_pics/defaults/teacher.png', 0, '7025731901', 'Cusat', 'male', '2010-01-01', ',', 'no', 0, '82d1c46a6014199790e16ead8a170b98', 'no'),
(54, 'Digital', 'Qqq', 'digital_qqq_1_2_3_4', 'Aaaaaa@b.c', 'e10adc3949ba59abbe56e057f20f883e', '2018-06-21', 'assets/images/profile_pics/defaults/teacher.png', 0, '7025731901', 'Cusat', 'male', '2010-01-01', ',', 'no', 0, 'c0faf875b8596a0999b426631c0b5ff8', 'no'),
(55, 'Abhishek', 'Nair', 'abhishek_nair_1_2', 'Qq@q.q', 'e807f1fcf82d132f9bb018ca6738a19f', '2018-06-21', 'assets/images/profile_pics/defaults/teacher.png', 91, '7025731901', 'Cusat', 'male', '2010-01-01', ',', 'no', 0, '9a5a511ca4f18a61719b12acf46f14c0', 'no'),
(56, 'Koushik', 'Kanjilal', 'koushik_kanjilal', 'Kanjilalkoushik18@gmail.com', '1e9bc3587302f1704bb34c27b672e02d', '2018-06-23', 'assets/images/profile_pics/defaults/teacher.png', 91, '8583063630', 'Smu', 'male', '1991-11-17', ',subrata_roy,', 'no', 0, '5bcaed28930679b919fe66464b0c3693', 'no'),
(57, 'Subrata', 'Roy', 'subrata_roy', 'Subrataroy@gmail.com', '78a8f834561c67fa660760d41a61dc62', '2018-06-23', 'assets/images/profile_pics/defaults/teacher.png', 91, '7896541230', 'Smu', 'male', '1990-10-18', ',koushik_kanjilal,', 'no', 0, 'af5ea63e84c19d4e1f0d2d1d3543f50c', 'no');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_members`
--
ALTER TABLE `group_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reg_teach`
--
ALTER TABLE `reg_teach`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `group_members`
--
ALTER TABLE `group_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;
--
-- AUTO_INCREMENT for table `reg_teach`
--
ALTER TABLE `reg_teach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `group_members`
--
ALTER TABLE `group_members`
  ADD CONSTRAINT `grp_id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
