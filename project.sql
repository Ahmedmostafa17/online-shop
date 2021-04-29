-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2020 at 09:50 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `CateID` int(6) NOT NULL,
  `Name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Description` text NOT NULL,
  `parent` int(11) NOT NULL,
  `Ordering` int(11) NOT NULL,
  `Visability` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_comment` int(11) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`CateID`, `Name`, `Description`, `parent`, `Ordering`, `Visability`, `Allow_comment`, `Allow_Ads`) VALUES
(11, 'Computers ', 'All Devices Here', 0, 5, 1, 1, 1),
(12, 'Cell Phones', 'the Good Phones ', 0, 6, 0, 0, 1),
(15, 'macs computer', 'it is a good pcs', 0, 20, 0, 0, 1),
(16, 'Oppo Reno 3', 'it\'s a good mobile phone', 12, 5, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_ID` int(11) NOT NULL,
  `comment` text COLLATE utf8_german2_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `comment_date` date NOT NULL,
  `item_ID` int(11) NOT NULL,
  `member_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_ID`, `comment`, `status`, `comment_date`, `item_ID`, `member_ID`) VALUES
(7, 'good Camera ', 1, '2020-06-07', 8, 19),
(51, 'very good', 1, '2020-07-28', 14, 19),
(52, 'very good', 0, '2020-07-28', 14, 19);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `RATING` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT 0,
  `Category_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemID`, `Name`, `Description`, `price`, `Country_Made`, `Status`, `Add_Date`, `RATING`, `Approve`, `Category_ID`, `Member_ID`, `tags`) VALUES
(8, 'iPhone XR', 'Apple iPhone XR, 64GB, Black - Fully Unlocked (Renewed)', '484.99', 'China', '1', '2020-05-29', 0, 1, 12, 19, ''),
(10, 'laptop hp ', '13.3&#34;, Intel Core i7-10510U (10th Gen), NVIDIA GeForce MX250 (2 GB), 1 TB PCIe NVMe M.2 SSD', '5563', 'China', '2', '2020-07-02', 0, 1, 11, 93, ''),
(11, 'headphones ', 'intel Core i7-10510U (10th Gen), NVIDIA GeForce MX250 (2 GB), 1 TB ', '120', 'German ', '3', '2020-07-02', 0, 1, 12, 93, ''),
(14, 'playstation 5', 'it is a new version ', '1500', 'china', '1', '2020-07-28', 0, 1, 11, 59, 'fifa,game'),
(15, 'Lenoev', 'THE good pc for game', '500', 'london', '3', '2020-07-28', 0, 1, 11, 19, 'fast,high');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0 COMMENT 'identify user group',
  `Truststatus` int(11) NOT NULL DEFAULT 0 COMMENT 'seller Rank',
  `RegStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'user  Approve',
  `Date` date NOT NULL,
  `Deletes` tinyint(4) NOT NULL DEFAULT 0,
  `image` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `UserName`, `Password`, `Email`, `FullName`, `GroupID`, `Truststatus`, `RegStatus`, `Date`, `Deletes`, `image`) VALUES
(19, 'ahmed', 'cdc8e8820ddf377ec75ef13c7d70303764e38b3a', 'amostafataha1998@hotmail.com', 'ahmed mostafa', 1, 0, 1, '0000-00-00', 1, ''),
(59, 'Mohamed Mostafa', 'mohamed123', 'mohamed123@gmail.com', 'Mohamed Mostafa Taha', 0, 0, 1, '2020-05-19', 0, ''),
(61, 'sayed taha', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'sayed123@hotmail.com', 'sayed mohamed taha', 0, 0, 1, '2020-05-19', 0, ''),
(63, 'samira sale', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'samora123@gmail.com', 'samira gaber Salim', 0, 0, 1, '2020-05-19', 0, ''),
(64, 'mando ahmed ', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'mando123@hotmail.com', 'mando ahmed taha ', 0, 0, 1, '2020-05-19', 0, ''),
(81, 'yassin', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'yassin123@hotmail.com', 'yassin ahmed taha', 0, 0, 1, '2020-06-01', 0, ''),
(93, 'Marwa ahmed', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'marwa123@gmail.com', 'marwa ahmed mahmoud', 0, 0, 1, '2020-06-08', 0, ''),
(97, 'ahmed kaak', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'kaka12345@gmail.com', 'ahmed mohamed ', 0, 0, 1, '2020-07-29', 0, '5688205_Slide1.JPG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`CateID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_ID`),
  ADD KEY `comment_1` (`item_ID`),
  ADD KEY `comment_2` (`member_ID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemID`),
  ADD KEY `member_1` (`Member_ID`),
  ADD KEY `cate_1` (`Category_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `UserName` (`UserName`),
  ADD UNIQUE KEY `UserName_2` (`UserName`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `CateID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_1` FOREIGN KEY (`item_ID`) REFERENCES `items` (`itemID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_2` FOREIGN KEY (`member_ID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cate_1` FOREIGN KEY (`Category_ID`) REFERENCES `categories` (`CateID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
