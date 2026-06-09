-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2026 at 10:34 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `codevault`
--

-- --------------------------------------------------------

--
-- Table structure for table `contributor`
--

CREATE TABLE `contributor` (
  `user_id` int(30) NOT NULL,
  `repo_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `follower`
--

CREATE TABLE `follower` (
  `who_is_following` int(30) NOT NULL,
  `who_is_being_followed` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `who_sent` int(30) DEFAULT NULL,
  `who_got` int(30) NOT NULL,
  `repo_id` int(11) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` int(1) NOT NULL,
  `type` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `repo`
--

CREATE TABLE `repo` (
  `id` int(30) NOT NULL,
  `title` varchar(200) NOT NULL,
  `file` varchar(256) NOT NULL,
  `creator` int(30) NOT NULL,
  `description` varchar(400) DEFAULT NULL,
  `demo` varchar(256) DEFAULT NULL,
  `visibility` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stars`
--

CREATE TABLE `stars` (
  `user_id` int(30) NOT NULL,
  `repo_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `tag_name` varchar(30) NOT NULL,
  `repo_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(30) NOT NULL,
  `user_name` varchar(40) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(256) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_pic` varchar(250) DEFAULT NULL,
  `bio` varchar(300) DEFAULT NULL,
  `location` varchar(300) DEFAULT NULL,
  `web` varchar(300) DEFAULT NULL,
  `notification_settings` varchar(20) NOT NULL,
  `default_repo_visibility` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `version`
--

CREATE TABLE `version` (
  `id` int(30) NOT NULL,
  `repo_id` int(30) NOT NULL,
  `version_number` varchar(30) NOT NULL,
  `file_zip` varchar(256) NOT NULL,
  `description` varchar(400) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contributor`
--
ALTER TABLE `contributor`
  ADD PRIMARY KEY (`user_id`,`repo_id`),
  ADD KEY `repo_id for contributor` (`repo_id`);

--
-- Indexes for table `follower`
--
ALTER TABLE `follower`
  ADD PRIMARY KEY (`who_is_following`,`who_is_being_followed`),
  ADD KEY `who_is_being_followed` (`who_is_being_followed`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `who_sent` (`who_sent`),
  ADD KEY `who_got` (`who_got`),
  ADD KEY `repo_id for notification` (`repo_id`);

--
-- Indexes for table `repo`
--
ALTER TABLE `repo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creator` (`creator`);

--
-- Indexes for table `stars`
--
ALTER TABLE `stars`
  ADD PRIMARY KEY (`user_id`,`repo_id`),
  ADD KEY `repo_id for stars` (`repo_id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD KEY `repo_id for tag` (`repo_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `version`
--
ALTER TABLE `version`
  ADD PRIMARY KEY (`id`),
  ADD KEY `repo_id for version` (`repo_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `repo`
--
ALTER TABLE `repo`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `version`
--
ALTER TABLE `version`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contributor`
--
ALTER TABLE `contributor`
  ADD CONSTRAINT `repo_id for contributor` FOREIGN KEY (`repo_id`) REFERENCES `repo` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_id for contributor` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `follower`
--
ALTER TABLE `follower`
  ADD CONSTRAINT `who_is_being_followed` FOREIGN KEY (`who_is_being_followed`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `who_is_following` FOREIGN KEY (`who_is_following`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `repo_id for notification` FOREIGN KEY (`repo_id`) REFERENCES `repo` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `who_got` FOREIGN KEY (`who_got`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `who_sent` FOREIGN KEY (`who_sent`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `repo`
--
ALTER TABLE `repo`
  ADD CONSTRAINT `creator` FOREIGN KEY (`creator`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `stars`
--
ALTER TABLE `stars`
  ADD CONSTRAINT `repo_id for stars` FOREIGN KEY (`repo_id`) REFERENCES `repo` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_id for stars` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tag`
--
ALTER TABLE `tag`
  ADD CONSTRAINT `repo_id for tag` FOREIGN KEY (`repo_id`) REFERENCES `repo` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `version`
--
ALTER TABLE `version`
  ADD CONSTRAINT `repo_id for version` FOREIGN KEY (`repo_id`) REFERENCES `repo` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
