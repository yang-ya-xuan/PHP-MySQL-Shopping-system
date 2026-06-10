-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2026-06-10 17:47:34
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `shopping`
--

-- --------------------------------------------------------

--
-- 資料表結構 `ccar`
--

CREATE TABLE `ccar` (
  `cID` int(11) NOT NULL,
  `caccount` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `price` int(11) NOT NULL,
  `image` blob NOT NULL,
  `quantity` int(100) NOT NULL,
  `ud` enum('up','down') NOT NULL,
  `cdelete` enum('N','Y') NOT NULL,
  `pricec` enum('N','C') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `ccar`
--

INSERT INTO `ccar` (`cID`, `caccount`, `name`, `price`, `image`, `quantity`, `ud`, `cdelete`, `pricec`) VALUES
(285, 'arbaarba', '芒果', 60, 0x75706c6f61642f6d616e676f2e6a7067, 1, 'up', 'N', 'N'),
(285, '888', '芒果', 60, 0x75706c6f61642f6d616e676f2e6a7067, 1, 'up', 'N', 'N');

-- --------------------------------------------------------

--
-- 資料表結構 `commodity`
--

CREATE TABLE `commodity` (
  `cID` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `price` int(11) NOT NULL,
  `cexplain` varchar(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` blob NOT NULL,
  `ud` enum('up','down') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `commodity`
--

INSERT INTO `commodity` (`cID`, `name`, `price`, `cexplain`, `quantity`, `image`, `ud`) VALUES
(266, '水蜜桃', 80, '粉紅色水蜜桃', 1, 0x75706c6f61642f70656163682e6a7067, 'up'),
(281, '橘子瓜', 35, '橘色橘子', 43, 0x75706c6f61642f6f72616e67652e6a706567, 'up'),
(282, '番茄', 320000, '大顆普通番茄', 50, 0x75706c6f61642f746f6d61746f362e6a7067, 'down'),
(283, '櫻桃', 100, '小顆紅色櫻桃', 195, 0x75706c6f61642f6368657272792e6a7067, 'down'),
(284, '西瓜', 50, '超大顆紅色西瓜', 28, 0x75706c6f61642f77617465726d656c6f6e2e6a706567, 'up'),
(285, '芒果', 60, '橘黃色芒果', 21, 0x75706c6f61642f6d616e676f2e6a7067, 'up');

-- --------------------------------------------------------

--
-- 資料表結構 `corder`
--

CREATE TABLE `corder` (
  `tID` varchar(30) NOT NULL,
  `cID` int(11) NOT NULL,
  `caccount` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `price` int(11) NOT NULL,
  `image` blob NOT NULL,
  `quantity` int(100) NOT NULL,
  `address` varchar(30) NOT NULL,
  `state` enum('N','Y') NOT NULL,
  `cancel` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `corder`
--

INSERT INTO `corder` (`tID`, `cID`, `caccount`, `name`, `price`, `image`, `quantity`, `address`, `state`, `cancel`) VALUES
('16940509841234', 266, '1234', '水蜜桃', 80, 0x75706c6f61642f70656163682e6a7067, 1, '新北市板橋區文化路313號1樓', 'Y', 'Y'),
('16940509841234', 284, '1234', '西瓜', 50, 0x75706c6f61642f77617465726d656c6f6e2e6a706567, 1, '新北市板橋區文化路313號1樓', 'Y', 'Y'),
('1694064062444', 281, '444', '橘子', 30, 0x75706c6f61642f6f72616e67652e6a706567, 1, '新北市板橋區文化路313號1樓', 'Y', 'Y'),
('1694064062444', 283, '444', '櫻桃', 100, 0x75706c6f61642f6368657272792e6a7067, 5, '新北市板橋區文化路313號1樓', 'Y', 'Y'),
('1694064421333', 266, '333', '水蜜桃', 80, 0x75706c6f61642f70656163682e6a7067, 54, '新北市板橋區文化路313號1樓', 'Y', 'Y'),
('1694083732777', 266, '777', '水蜜桃', 80, 0x75706c6f61642f70656163682e6a7067, 1, '新北市板橋區文化路313號1樓', 'Y', 'Y'),
('1694083884777', 266, '777', '水蜜桃', 80, 0x75706c6f61642f70656163682e6a7067, 1, '新北市板橋區文化路313號1樓', 'Y', 'Y'),
('1694084011888', 266, '888', '水蜜桃', 80, 0x75706c6f61642f70656163682e6a7067, 1, '新北市板橋區文化路313號1樓', 'Y', 'Y'),
('1694085147777', 281, '777', '橘子', 30, 0x75706c6f61642f6f72616e67652e6a706567, 1, '新北市板橋區文化路313號1樓', 'Y', 'Y'),
('1694085627777', 282, '777', '番茄', 32, 0x75706c6f61642f746f6d61746f362e6a7067, 1, '新北市板橋區文化路313號1樓', 'Y', 'Y'),
('1694085914777', 282, '777', '番茄', 320000, 0x75706c6f61642f746f6d61746f362e6a7067, 49, '新北市板橋區文化路313號1樓', 'Y', 'Y'),
('1694088874777', 285, '777', '芒果', 60, 0x75706c6f61642f6d616e676f2e6a7067, 1, '新北市板橋區文化路313號1樓', 'N', 'Y'),
('1694765096888', 285, '888', '芒果', 60, 0x75706c6f61642f6d616e676f2e6a7067, 1, '新北市板橋區文化路313號1樓', 'Y', 'Y'),
('1694768080888', 266, '888', '水蜜桃', 80, 0x75706c6f61642f70656163682e6a7067, 1, '新北市板橋區文化路313號1樓', 'Y', 'Y'),
('1694768080888', 281, '888', '橘子', 35, 0x75706c6f61642f6f72616e67652e6a706567, 1, '新北市板橋區文化路313號1樓', 'Y', 'Y'),
('1723047444888', 266, '888', '水蜜桃', 80, 0x75706c6f61642f70656163682e6a7067, 2, '新北市板橋區文化路313號1樓', 'N', 'N'),
('1723047444888', 281, '888', '橘子瓜', 35, 0x75706c6f61642f6f72616e67652e6a706567, 1, '新北市板橋區文化路313號1樓', 'N', 'N'),
('1723086940999', 285, '999', '芒果', 60, 0x75706c6f61642f6d616e676f2e6a7067, 1, '新北市板橋區文化路313號1樓', 'Y', 'Y'),
('1723086996999', 284, '999', '西瓜', 50, 0x75706c6f61642f77617465726d656c6f6e2e6a706567, 1, '新北市板橋區文化路313號1樓', 'Y', 'Y'),
('1723095843888', 266, '888', '水蜜桃', 80, 0x75706c6f61642f70656163682e6a7067, 2, '新北市板橋區文化路313號1樓', 'Y', 'Y'),
('1723096334000', 266, '000', '水蜜桃', 80, 0x75706c6f61642f70656163682e6a7067, 1, '新北市板橋區文化路313號1樓', 'N', 'Y'),
('1723096391000', 284, '000', '西瓜', 50, 0x75706c6f61642f77617465726d656c6f6e2e6a706567, 1, '新北市板橋區文化路313號1樓', 'N', 'Y'),
('1723096391000', 281, '000', '橘子瓜', 35, 0x75706c6f61642f6f72616e67652e6a706567, 1, '新北市板橋區文化路313號1樓', 'N', 'Y');

-- --------------------------------------------------------

--
-- 資料表結構 `register`
--

CREATE TABLE `register` (
  `cID` int(11) NOT NULL,
  `cname` varchar(10) NOT NULL,
  `cnumber` varchar(10) NOT NULL,
  `cgender` enum('F','M') NOT NULL,
  `caccount` varchar(20) NOT NULL,
  `cpassword` varchar(20) NOT NULL,
  `disabled` enum('Y','N') NOT NULL,
  `promotion` enum('0','1','2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `register`
--

INSERT INTO `register` (`cID`, `cname`, `cnumber`, `cgender`, `caccount`, `cpassword`, `disabled`, `promotion`) VALUES
(7, 'test5test5', '0977777777', 'F', '777', 'test5test5555', 'Y', '1'),
(8, 'test8', '0988888888', 'M', '888', 'iii88888', 'Y', '0'),
(9, 'test9', '0999999999', 'F', '999', 'ooo99999', 'Y', '0'),
(10, 'test10', '0910101010', 'M', '@admin10', 'qpqp101010', 'Y', '2'),
(16, 'test12', '0912121212', 'F', '1212', 'qwqw121212', 'Y', '0'),
(18, 'test13', '0913131313', 'M', '1313', 'qeqe131313', 'Y', '0'),
(20, '楊雅喧', '0912345678', 'F', '1234', 'qwe12345', 'Y', '0'),
(22, 'arba', '0908159688', 'F', 'arbaarba', 'aaa12345', 'Y', '0'),
(23, '嗨', '0977777777', 'F', '000', 'PPP00000', 'Y', '1');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `commodity`
--
ALTER TABLE `commodity`
  ADD PRIMARY KEY (`cID`);

--
-- 資料表索引 `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`cID`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `commodity`
--
ALTER TABLE `commodity`
  MODIFY `cID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=289;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `register`
--
ALTER TABLE `register`
  MODIFY `cID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
