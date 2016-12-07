-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2016 at 12:12 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laisa`
--

-- --------------------------------------------------------

--
-- Table structure for table `adverts`
--

CREATE TABLE `adverts` (
  `id` int(11) NOT NULL,
  `user_id` varchar(300) NOT NULL,
  `description` varchar(300) NOT NULL,
  `departure` varchar(50) NOT NULL,
  `destination` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `time` varchar(30) NOT NULL,
  `amount` varchar(10) NOT NULL,
  `type` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adverts`
--

INSERT INTO `adverts` (`id`, `user_id`, `description`, `departure`, `destination`, `date`, `time`, `amount`, `type`) VALUES
(3, '1332466966795859', 'Travelling with 3 Large suitcases', 'Lebowakgomo-F, Limpopo, South Africa', 'Braamfontein, Johannesburg, Gauteng, South Africa', '2016/04/02', 'Between 13:00 and 17:00', '200', 'w'),
(4, '38565823857654', 'boshego gare', 'Jane Furse', 'Polokwane', '2016/04/19', '00:00', '50', 'o'),
(5, '38565823857654', 'Attridgeville', 'Gugulethu', 'description', '2016/01/29', '18:00-20:00', '200', 'w'),
(6, '1332466966795859', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, \r\nsed do eiusmod tempor incididunt ut labore et dolore \r\nmagna aliqua. Ut enim ad minim veniam, quis nostrud\r\nexercitation ullamco laboris nisi ut aliquip ex ea commodo \r\nconsequat.', 'Jane Furse, Limpopo, South Africa', 'Polokwane, Limpopo, South Africa', '2016/02/02', 'Between 00:00 and 00:00 ', 'R50', 'o'),
(7, '059587628293445', 'Testing if the search can find Randburg', '18 Bram Fischer Drive, Randburg, South Africa', '17 Pretorius Street, Pretoria, South Africa', '2016/12/31', '06:00-12:00', '200', 'o'),
(8, '38565823857654', 'I\'m travelling with a 7 year old baby.', 'Lebowakgomo, Limpopo, South Africa', '6a Camwood Street, Kempton Park, South Africa', '2016/05/30', 'Between 16:00 and 16:00', '200', 'o'),
(9, '1332466966795859', 'Lemonka', 'Dobsonville Bus Stop, Zembe Street, Soweto, South ', 'Atteridgeville, Pretoria, Gauteng, South Africa', '2018/03/02', 'Between 00:00 and 00:00 ', '100', 'o'),
(10, '1059587628293445', 'Grandmothers home', 'Ga-Nkoana, Limpopo, South Africa', 'Malamulele, Limpopo, South Africa', '2017/02/02', 'Between 00:00 and 00:00 ', '200', 'o'),
(18, '059587628293445', 'I leave at 2AM', 'Lebowakgomo', 'Witbank', 'Sunday,Saturday', 'Between 01:00 AM and 01:00 AM ', '100', 'w');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `session_user_id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `session_user_id`, `ad_id`) VALUES
(9, 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `friend_one` int(11) NOT NULL,
  `friend_two` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `friend_one`, `friend_two`, `status`) VALUES
(16, 5, 3, 1),
(45, 5, 4, 1),
(46, 1, 4, 1),
(73, 5, 2, 1),
(75, 3, 2, 1),
(88, 5, 1, 1),
(89, 1, 2, 1),
(90, 4, 1, 1),
(91, 4, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `time_sent` datetime NOT NULL,
  `message` text NOT NULL,
  `opened` enum('0','1') NOT NULL DEFAULT '0',
  `recipient_delete` enum('0','1') NOT NULL DEFAULT '0',
  `sender_delete` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `receiver_id`, `sender_id`, `time_sent`, `message`, `opened`, `recipient_delete`, `sender_delete`) VALUES
(53, 1, 3, '2016-11-05 13:53:27', 'Tswa Daar', '0', '0', '0'),
(54, 1, 1, '2016-11-07 09:19:29', 'Reply?', '0', '0', '0'),
(56, 1, 3, '2016-11-15 19:57:51', 'sending?', '0', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(255) NOT NULL,
  `name` varchar(30) NOT NULL,
  `picture_url` text NOT NULL,
  `phoneNumber` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `gender` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `picture_url`, `phoneNumber`, `email`, `gender`) VALUES
('059587628293445', 'Joselyne Tlagadi', 'https://www.ukmix.org/proxy.php?code=eb1cffce078fbf36a71ca9310794674b61f8b4dfe99309a300712fe579757ed3&url=aHR0cDovL2ljb25zLXNlYXJjaC5jb20vaW1nL3llbGxvd2ljb24vVE1OVF9saW4uemlwL2xpbi1wbmctMjU2eDI1Ni1Eb25hdGVsb18yNTZ4MjU2LnBuZy0yNTZ4MjU2LnBuZw%3D%3D', '012438538274', 'j.tlagadi@wits.ac.za', 'Female'),
('1332466966795859', 'Marote Thabang', 'scontent.xx.fbcdn.net/v/t1.0-1/p160x160/13728965_1199793060063251_4247681928062354885_n.jpg?_nc_eui2=v1%3AAeG6ruGYMvoJyydFDeB11-yCTx_e2R7954G0bpF4pP9ghg5Y6LHwcCSsIiuPkiV8Gt27e8oMhynfo8D-5IK92akxm5L3TFFpO-9gd3s6CuCmOQ&oh=2eb5dcc2d27306f31720b442814a42e4&oe=58CB2067', 'undefined', 'marotethabang@ymail.com', 'male'),
('38565823857654', 'Wendy Phasha', 'http://education.ipv6forum.com/images/individual.png', '385465648493', 'w.phasha@gmail.com', 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `session_user_id` text NOT NULL,
  `ad_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `session_user_id`, `ad_id`) VALUES
(9, '2332466966795859', 4),
(10, '2', 3),
(11, '2', 2),
(12, '2332466966795859', 5),
(44, '2', 6),
(45, '2332466966795859', 2),
(46, '1', 9),
(47, '1', 4),
(48, '2332466966795859', 8),
(49, '4', 6),
(51, '5', 6),
(52, '42', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adverts`
--
ALTER TABLE `adverts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adverts`
--
ALTER TABLE `adverts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
