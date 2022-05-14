-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2022 at 09:42 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `wiki_page` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `name`, `wiki_page`) VALUES
(1, 'Lou Gerstner', 'https://www.wikiwand.com/en/Lou_Gerstner'),
(2, 'J.K Rolling', 'https://en.wikipedia.org/wiki/J._K._Rowling'),
(3, 'Fyodor Dostoevsky', 'https://en.wikipedia.org/wiki/Fyodor_Dostoevsky'),
(4, 'Robert Greene', 'https://en.wikipedia.org/wiki/Robert_Greene_(American_author)'),
(5, 'Jordan Peterson', 'https://en.wikipedia.org/wiki/Jordan_Peterson'),
(6, 'Viktor E. Frankl', 'https://en.wikipedia.org/wiki/Viktor_Frankl'),
(7, 'Friedrich Nietzsche', 'https://en.wikipedia.org/wiki/Friedrich_Nietzsche'),
(8, 'Elif Shafak', 'https://en.wikipedia.org/wiki/Elif_Shafak'),
(9, 'Plato', 'https://en.wikipedia.org/wiki/Plato');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
--
-- Dumping data for table `book`
--
INSERT INTO `book` (`id`, `title`, `author_id`, `genre_id`, `image_url`, `description`) VALUES
(1, '12 Rules For Life', 5, 9, './assets/img/12-rules-for-life.jpg', 'description for 12 rules for life'),
(2, 'Beyond Good and Evil', 7, 3, './assets/img/beyond-good-and-evil.jpg', 'description for beyond good and evil'),
(3, 'Crime and Punishment', 3, 7, './assets/img/crime-and-punishment.jpg', 'description for crime and punishment'),
(4, "Who Says Elephants Can't Dance", 1, 2, './assets/img/elephants-dance.jpg', 'description for who says elephants cant dance'),
(5, 'Forty Rules of Love', 8, 7, './assets/img/fortyrulesoflove.jpg', 'description for forty rules of love'),
(6, 'Harry Potter and the Chamber of Secrets', 2, 4, './assets/img/harry-potter.jpg', 'description for harry potter'),
(7, 'The 48 Laws of Power', 4, 5, './assets/img/laws-of-power.jpg', 'description for 48 laws of power'),
(8, 'The Republic', 9, 3, './assets/img/republic.jpg', 'description for the republic'),
(9, "Man's Search for Meaning", 6, 5, './assets/img/search-for-meaning.jpg', 'description for searching for meaning');

-- --------------------------------------------------------
--
-- Table structure for table `borrowing`
--

CREATE TABLE `borrowing` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Dumping data for table `borrowing`
--
INSERT INTO `borrowing` (`id`, `user_id`, `book_id`, `date`) VALUES
(1, 3, 5, '2022-04-28'),
(2, 3, 1, '2022-04-25'),
(3, 4, 8, '2022-05-01'),
(4, 4, 4, '2022-03-15');

-- --------------------------------------------------------
--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `comment_text` varchar(255) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Dumping data for table `comment`
--
INSERT INTO `comment` (`id`, `user_id`, `book_id`, `comment_text`, `date`) VALUES
(1, 3, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.','2022-04-21'),
(2, 4, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.','2021-04-21'),
(3, 3, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.','2020-01-21'),
(4, 4, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.','2021-04-11'),
(5, 3, 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.','2020-06-06'),
(6, 4, 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.','2022-04-21'),
(7, 3, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.','2022-04-21'),
(8, 4, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.','2022-04-21'),
(9, 3, 5, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.','2022-04-21'),
(10, 4, 5, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.','2022-04-21'),
(11, 3, 6, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.','2022-04-21'),
(12, 4, 6, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.','2022-04-21'),
(13, 3, 7, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.','2022-04-21'),
(14, 4, 7, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.','2022-04-21'),
(15, 3, 8, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.','2022-04-21'),
(16, 4, 8, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.','2022-04-21'),
(17, 3, 9, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.','2022-04-21'),
(18, 4, 9, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.','2022-04-21');



-- --------------------------------------------------------
--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`id`, `name`) VALUES
(1, 'Horror'),
(2, 'Business'),
(3, 'Philosophy'),
(4, 'Fiction'),
(5, 'Psychology'),
(6, 'Personality'),
(7, 'Novel'),
(8, 'Non-fiction'),
(9, 'Self-help');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'librarian'),
(3, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(16),
(17),
(18),
(19),
(20),
(21),
(22),
(23),
(24);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `role_id`, `status`, `email`, `password`, `fname`, `lname`) VALUES
(1, 1, 1, 'admin@m.com', '12345', 'ahmed', 'ali'),
(2, 2, 1, 'lib@m.com', '12345', 'khalid', 'fuad'),
(3, 3, 1, 'user@m.com', '12345', 'samir', 'hassan'),
(4, 3, 1, 'user2@m.com', '12345', 'Rashid', 'saad');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_1a7c20a2-2127-4b36-bfca-0a5505a02a13` (`author_id`),
  ADD KEY `FK_24d227f3-2132-4aa7-813a-97f59cb97b79` (`genre_id`);

--
-- Indexes for table `borrowing`
--
ALTER TABLE `borrowing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_8fa0e8f3-d73b-4169-89ed-239dba288c48` (`user_id`),
  ADD KEY `FK_4baf9999-98ad-41ad-814b-986378ce74d0` (`book_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_f15a4d7a-ab8e-4856-8578-05aa8a1e91c7` (`user_id`),
  ADD KEY `FK_b46d944a-a31f-4e8f-bb79-81651c11cae0` (`book_id`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_55520b4c-6a94-489e-b01a-dc7cd722e3b2` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `borrowing`
--
ALTER TABLE `borrowing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `FK_1a7c20a2-2127-4b36-bfca-0a5505a02a13` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_24d227f3-2132-4aa7-813a-97f59cb97b79` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `borrowing`
--
ALTER TABLE `borrowing`
  ADD CONSTRAINT `FK_4baf9999-98ad-41ad-814b-986378ce74d0` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_8fa0e8f3-d73b-4169-89ed-239dba288c48` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_b46d944a-a31f-4e8f-bb79-81651c11cae0` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_f15a4d7a-ab8e-4856-8578-05aa8a1e91c7` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_55520b4c-6a94-489e-b01a-dc7cd722e3b2` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
