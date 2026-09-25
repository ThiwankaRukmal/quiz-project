-- ========================================================
-- Database: quiz_db
-- Mini Project: Interactive Quiz Web Application
-- ICT 2209 - Web Technologies
-- ========================================================

CREATE DATABASE IF NOT EXISTS `quiz_db`;
USE `quiz_db`;

-- --------------------------------------------------------
-- Drop existing tables to allow safe re-importing anytime
-- --------------------------------------------------------
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `scores`;
DROP TABLE IF EXISTS `messages`;
DROP TABLE IF EXISTS `questions`;
DROP TABLE IF EXISTS `users`;
SET FOREIGN_KEY_CHECKS = 1;

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for table `questions`
-- --------------------------------------------------------
CREATE TABLE `questions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `question` VARCHAR(255) NOT NULL,
  `option_a` VARCHAR(100) NOT NULL,
  `option_b` VARCHAR(100) NOT NULL,
  `option_c` VARCHAR(100) NOT NULL,
  `option_d` VARCHAR(100) NOT NULL,
  `correct_option` CHAR(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for table `scores`
-- --------------------------------------------------------
CREATE TABLE `scores` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `score` INT NOT NULL,
  `total_questions` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for table `messages`
-- --------------------------------------------------------
CREATE TABLE `messages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `message` TEXT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Insert Sample Questions for Quiz
-- --------------------------------------------------------
INSERT INTO `questions` (`id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`) VALUES
(1, 'What does HTML stand for?', 'Hyper Text Markup Language', 'High Tech Modern Language', 'Hyperlink Tool Multi Language', 'Home Tool Markup Language', 'A'),
(2, 'Which language is used to style web pages?', 'Python', 'CSS', 'Java', 'C++', 'B'),
(3, 'Which technology makes web pages dynamic and interactive?', 'HTML', 'CSS', 'JavaScript', 'SQL', 'C'),
(4, 'What does PHP stand for?', 'Personal Home Page', 'Private Hosting Protocol', 'PHP: Hypertext Preprocessor', 'Public Hyperlink Program', 'C'),
(5, 'Which tool is commonly used to run a local web server with Apache & MySQL?', 'Photoshop', 'XAMPP', 'MS Word', 'VLC Player', 'B');

-- --------------------------------------------------------
-- Insert Demo Student Account (Password: 123456)
-- --------------------------------------------------------
INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'student', 'student@example.com', '$2y$10$0a99EvKXedzFeKH2.qLVR.FEIyRCW1rhSSWrIucH3ZCT7Q0HUHpQW');
