-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 14, 2021 at 03:46 PM
-- Server version: 5.7.34
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_journey`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `create_admin` (IN `V_first_name` VARCHAR(50), IN `V_last_name` VARCHAR(50), IN `V_email` VARCHAR(90), IN `V_is_admin` BOOLEAN, IN `V_password` VARCHAR(60))  BEGIN
INSERT INTO users (first_name, last_name, email, is_admin, user_password)
VALUES (V_first_name, V_last_name, V_email, V_is_admin, V_password);

    INSERT INTO user_topics(user_id, topic_id)
        SELECT  users.user_id AS user_id,
                topics.topic_id AS topic_id
        FROM users CROSS JOIN topics 
        WHERE users.email = V_email;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_topic` (IN `V_topic_name` VARCHAR(255))  BEGIN
INSERT INTO topics (topic_name)
	VALUES (V_topic_name);

	INSERT INTO user_topics (user_id, topic_id)
		SELECT  users.user_id AS user_id,
				topics.topic_id AS topic_id
		FROM topics CROSS JOIN users 
		WHERE topics.topic_name = V_topic_name
		AND users.is_admin = 1;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_user` (IN `V_first_name` VARCHAR(50), IN `V_last_name` VARCHAR(50), IN `V_email` VARCHAR(90), IN `V_is_admin` BOOLEAN, IN `V_password` VARCHAR(60))  BEGIN
INSERT INTO users (first_name, last_name, email, is_admin, user_password)
VALUES (V_first_name, V_last_name, V_email, V_is_admin, V_password);

INSERT INTO user_topics
SELECT user_id, 1, 0 FROM users WHERE email = V_email;

COMMIT;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `activity_id` bigint(20) UNSIGNED NOT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `activity_name` varchar(255) DEFAULT NULL,
  `activity_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`activity_id`, `topic_id`, `activity_name`, `activity_description`) VALUES
(1, 1, 'What is a relational database?', 'The core basics of what a relational database really is'),
(2, 2, 'What is normalization?', 'A basic description of what normalization in databases is'),
(3, 2, '1NF', 'This is about the First normal form'),
(4, 2, '2NF', 'This is about the Second normal form and how to achieve it'),
(5, 3, 'Entity relationship diagrams', 'What is an Entity Relationship Diagram and how do you use it?'),
(6, 3, 'Relationships 1', 'One to one relationships and one to many relationships'),
(7, 3, 'Relationships 2', 'Many to many relationships'),
(8, 4, 'What is SQL?', 'Structured Query Language basics'),
(9, 4, 'CRUD', 'Create read update delete 101'),
(10, 5, 'Getting started with MySQL', 'Getting started with MySQL, MAMP and phpMyAdmin for mac users'),
(11, 6, 'Connecting to the frontend', 'Using PHP with your MySQL database');

--
-- Triggers `activities`
--
DELIMITER $$
CREATE TRIGGER `log_activity_update` BEFORE UPDATE ON `activities` FOR EACH ROW BEGIN
	INSERT INTO activity_logs (activity_id, old_activity_name, old_activity_description)
	VALUES (OLD.activity_id, OLD.activity_name, OLD.activity_description);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `activity_id` int(11) DEFAULT NULL,
  `old_activity_name` varchar(255) DEFAULT NULL,
  `old_activity_description` varchar(255) DEFAULT NULL,
  `logged_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`activity_id`, `old_activity_name`, `old_activity_description`, `logged_at`) VALUES
(5, 'The basics of ERD', 'What is an Entity Relationship Diagram and how do you use it?', '2021-12-12 22:47:38');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `topic_id` bigint(20) UNSIGNED NOT NULL,
  `topic_name` varchar(255) DEFAULT NULL,
  `step` int(11) DEFAULT NULL,
  `next_step` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`topic_id`, `topic_name`, `step`, `next_step`) VALUES
(1, 'Step 1: What is a relational database?', 1, 2),
(2, 'Step 2: What is database normalization?', 2, 3),
(3, 'Step 3: What is an entity relationship diagram?', 3, 4),
(4, 'Step 4: What is SQL and how does it work to Create/ Read/ Update/ Delete data?', 4, 5),
(5, 'Step 5: How do you install a relational database?', 5, 6),
(6, 'Step 6: How does a database connect to a Web Front End.', 6, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(90) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `user_password` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `is_admin`, `user_password`) VALUES
(3, 'Student', 'Name', 'test@student.com', 0, 'password'),
(4, 'Admin', 'Name', 'test@admin.com', 1, 'password'),
(5, 'Frederik', 'Frost', 'student@student.com', 0, '$2y$10$ySZxoLuK7MGOUSMzG1K6vuEjQP2JU8.IxpVXbklKY/U89yS6H30k.'),
(6, 'Johnny', 'Boy', 'a@a.com', 0, '$2y$10$HiuK6Y4N4CMcnKLeoP0ii.lSbKgW5BXU9dhNIZDHfo8tZToOUHi8W');

-- --------------------------------------------------------

--
-- Table structure for table `user_topics`
--

CREATE TABLE `user_topics` (
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `completed` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_topics`
--

INSERT INTO `user_topics` (`user_id`, `topic_id`, `completed`) VALUES
(3, 1, 0),
(4, 1, 0),
(4, 2, 0),
(4, 3, 0),
(4, 4, 0),
(4, 5, 0),
(4, 6, 0),
(5, 1, 0),
(5, 2, 0),
(5, 3, 0),
(5, 4, 0),
(5, 5, 0),
(5, 6, 0),
(6, 1, 0),
(6, 2, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`activity_id`),
  ADD UNIQUE KEY `activity_id` (`activity_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topic_id`),
  ADD UNIQUE KEY `topic_id` (`topic_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_topics`
--
ALTER TABLE `user_topics`
  ADD PRIMARY KEY (`user_id`,`topic_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `activity_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
