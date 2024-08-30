-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2024 at 08:03 AM
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
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `author_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`author_id`, `first_name`, `last_name`) VALUES
(1, 'Martin', 'Lomeli Jimenez');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category`) VALUES
(1, 'Food'),
(2, 'Entertainment'),
(3, 'Dining'),
(4, 'Music'),
(5, 'Technology'),
(6, 'Animals');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `content` varchar(4096) NOT NULL,
  `author` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `title`, `date`, `content`, `author`) VALUES
(1, 'Funny Cat Names', '2021-05-04', 'Cat names can be hilarious. Picture a fluffy feline named Sir Meowsalot or a mischievous kitty answering Professor Whiskerbottoms. These playful monikers add a dash of whimsy to daily life, turning ordinary moments into laughter-filled adventures.', 1),
(2, 'Healthy Foods Dishes', '2021-05-06', '\r\nHealthy food comprises a variety of nutrient-dense options such as fruits, vegetables, whole grains, lean proteins, and healthy fats. These foods provide essential vitamins, minerals, and antioxidants that support overall well-being and help prevent chronic diseases. Eating a balanced diet rich in healthy foods can boost energy levels, improve mental clarity, and promote a healthy weight. Prioritizing whole, unprocessed foods over sugary, high-fat, and highly processed items is key to maintaining optimal health and vitality.', 1),
(3, 'Coffee is tasty', '2021-05-05', 'Coffee is renowned for its rich, aromatic flavor and comforting warmth, making it a beloved beverage worldwide. Each sip offers a delightful balance of bitterness and subtle sweetness, often complemented by notes of chocolate, caramel, or fruity undertones, depending on the bean and roast. Whether enjoyed black or enhanced with milk and sugar, coffee\'s complex and enticing taste can be tailored to individual preferences, making every cup a unique and enjoyable experience.', 1),
(4, 'Sparkling water is only good when flavored', '2021-05-27', 'Sparking water is a weird thing to have as a drink of choice with foods unless with flavor. It can be seen as a little better if you are known for poor decisions.', 1),
(5, 'Journey to CSS Understanding', '2024-05-15', '\r\nEmbarking on a journey to understand CSS (Cascading Style Sheets) is both challenging and rewarding. This styling language is fundamental for web development, allowing designers to control the look and feel of websites with precision. Initially, learning CSS can seem daunting due to its vast array of properties and the intricacies of layout techniques like Flexbox and Grid. However, with practice, the logic behind CSS becomes clearer, enabling developers to create visually appealing and responsive web pages. The journey is marked by continuous learning and experimentation, ultimately leading to mastery and the ability to craft sophisticated web designs.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `post_category`
--

CREATE TABLE `post_category` (
  `post_category_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `post_category`
--

INSERT INTO `post_category` (`post_category_id`, `post_id`, `category_id`) VALUES
(1, 1, 6),
(2, 2, 3),
(3, 2, 1),
(4, 3, 4),
(5, 3, 3),
(6, 4, 3),
(7, 4, 1),
(8, 1, 2),
(9, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `post_tag`
--

CREATE TABLE `post_tag` (
  `post_tag_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `post_tag`
--

INSERT INTO `post_tag` (`post_tag_id`, `post_id`, `tag_id`) VALUES
(1, 1, 4),
(2, 1, 5),
(3, 1, 3),
(6, 2, 4),
(7, 2, 5),
(8, 3, 6),
(9, 3, 7),
(10, 3, 8),
(11, 3, 9),
(12, 4, 4),
(13, 4, 6),
(14, 4, 14),
(15, 2, 14),
(16, 2, 15),
(17, 3, 1),
(18, 3, 5),
(19, 3, 16),
(20, 5, 2),
(21, 5, 4),
(22, 5, 15);

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `tag` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`id`, `tag`) VALUES
(1, 'music'),
(2, 'tech'),
(3, 'animals'),
(4, 'influences'),
(5, 'social'),
(6, 'food'),
(14, 'fun'),
(15, 'journey'),
(16, 'location');

-- --------------------------------------------------------

--
-- Table structure for table `tag_description`
--

CREATE TABLE `tag_description` (
  `description_id` int(11) NOT NULL,
  `description_content` varchar(50) CHARACTER SET utf16 COLLATE utf16_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`author_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `post_category`
--
ALTER TABLE `post_category`
  ADD PRIMARY KEY (`post_category_id`);

--
-- Indexes for table `post_tag`
--
ALTER TABLE `post_tag`
  ADD PRIMARY KEY (`post_tag_id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tag_description`
--
ALTER TABLE `tag_description`
  ADD PRIMARY KEY (`description_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `post_category`
--
ALTER TABLE `post_category`
  MODIFY `post_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `post_tag`
--
ALTER TABLE `post_tag`
  MODIFY `post_tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tag_description`
--
ALTER TABLE `tag_description`
  MODIFY `description_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
