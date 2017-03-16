-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-03-16 13:55:00
-- 服务器版本： 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tiyuke`
--

-- --------------------------------------------------------

--
-- 表的结构 `think_admin`
--

CREATE TABLE `think_admin` (
  `id` int(11) NOT NULL,
  `name` varchar(5) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(25) NOT NULL,
  `root` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_admin`
--

INSERT INTO `think_admin` (`id`, `name`, `username`, `password`, `root`) VALUES
(8, '11', '11', '11', 11),
(4, '陈老师', 'admin1', '1234', 1),
(6, '王老师', 'admin', '1234', 1),
(7, '233', '233', '233', 2),
(233, '周老师', 'admin2', '77777', 2);

-- --------------------------------------------------------

--
-- 表的结构 `think_class`
--

CREATE TABLE `think_class` (
  `id` int(11) NOT NULL,
  `classId` int(11) NOT NULL,
  `grade` tinyint(1) NOT NULL,
  `classNo` tinyint(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_class`
--

INSERT INTO `think_class` (`id`, `classId`, `grade`, `classNo`) VALUES
(1, 11, 1, 1),
(2, 12, 1, 2),
(3, 13, 1, 3),
(4, 14, 1, 4),
(5, 15, 1, 5),
(6, 16, 1, 6),
(7, 17, 1, 7),
(8, 18, 1, 8),
(9, 19, 1, 9),
(10, 110, 1, 10),
(11, 111, 1, 11),
(12, 112, 1, 12),
(13, 113, 1, 13),
(14, 114, 1, 14),
(15, 115, 1, 15),
(16, 116, 1, 16),
(17, 117, 1, 17),
(18, 118, 1, 18),
(19, 119, 1, 19),
(20, 120, 1, 20),
(21, 121, 1, 21),
(22, 122, 1, 22),
(23, 123, 1, 23),
(24, 124, 1, 24),
(25, 21, 2, 1),
(26, 0, 2, 2),
(27, 0, 2, 3),
(28, 0, 2, 4),
(29, 0, 2, 5),
(30, 0, 2, 6),
(31, 0, 2, 7),
(32, 0, 2, 8),
(33, 0, 2, 9),
(34, 0, 2, 10),
(35, 0, 2, 11),
(36, 0, 2, 12),
(37, 0, 2, 13),
(38, 0, 2, 14),
(39, 0, 2, 15),
(40, 0, 2, 16),
(41, 0, 2, 17),
(42, 0, 2, 18),
(43, 0, 2, 19),
(44, 0, 2, 20),
(45, 0, 2, 21),
(46, 0, 2, 22),
(47, 0, 2, 23),
(48, 0, 2, 24),
(49, 0, 3, 1),
(50, 0, 3, 2),
(51, 0, 3, 3),
(52, 0, 3, 4),
(53, 0, 3, 5),
(54, 0, 3, 6),
(55, 0, 3, 7),
(56, 0, 3, 8),
(57, 0, 3, 9),
(58, 0, 3, 10),
(59, 0, 3, 11),
(60, 0, 3, 12),
(61, 0, 3, 13),
(62, 0, 3, 14),
(63, 0, 3, 15),
(64, 0, 3, 16),
(65, 0, 3, 17),
(66, 0, 3, 18),
(67, 0, 3, 19),
(68, 0, 3, 20),
(69, 0, 3, 21),
(70, 0, 3, 22),
(71, 0, 3, 23),
(72, 0, 3, 24);

-- --------------------------------------------------------

--
-- 表的结构 `think_course`
--

CREATE TABLE `think_course` (
  `courseId` int(11) NOT NULL,
  `courseName` varchar(10) NOT NULL COMMENT '课程名称',
  `classRangeId` json NOT NULL COMMENT '年级',
  `adminId` varchar(11) NOT NULL COMMENT '老师名字',
  `time` varchar(20) NOT NULL COMMENT '上课时间',
  `peopleNumber` int(11) NOT NULL COMMENT '课程人数',
  `choiceNumber` int(11) NOT NULL COMMENT '已选人数'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_course`
--

INSERT INTO `think_course` (`courseId`, `courseName`, `classRangeId`, `adminId`, `time`, `peopleNumber`, `choiceNumber`) VALUES
(184, '123334', '{"17": "高一（7）班", "18": "高一（8）班", "19": "高一（9）班", "25": "高二（5）班", "26": "高二（6）班", "31": "高三（1）班", "32": "高三（2）班", "33": "高三（3）班", "214": "高二（14）班"}', '123', '', 0, 0),
(180, '1231233', '{"17": "高一（7）班", "18": "高一（8）班", "19": "高一（9）班"}', '1', '1', 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `think_sex`
--

CREATE TABLE `think_sex` (
  `id` tinyint(1) NOT NULL,
  `name` varchar(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_sex`
--

INSERT INTO `think_sex` (`id`, `name`) VALUES
(0, '女'),
(1, '男');

-- --------------------------------------------------------

--
-- 表的结构 `think_student_score`
--

CREATE TABLE `think_student_score` (
  `id` int(11) NOT NULL,
  `no` varchar(12) NOT NULL,
  `courseId` int(11) NOT NULL,
  `score` json NOT NULL,
  `other_score` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_student_score`
--

INSERT INTO `think_student_score` (`id`, `no`, `courseId`, `score`, `other_score`) VALUES
(5, '123456', 175, '0', 0),
(6, '123', 174, '0', 0),
(25, '123456', 179, '0', 0),
(23, '123457', 179, '0', 0),
(26, '1234', 180, '0', 0),
(27, '123', 180, '0', 0),
(28, '123457', 180, '0', 0),
(30, '123456', 180, '0', 0);

-- --------------------------------------------------------

--
-- 表的结构 `think_stuinfo`
--

CREATE TABLE `think_stuinfo` (
  `no` varchar(12) NOT NULL,
  `password` varchar(20) NOT NULL,
  `name` varchar(5) NOT NULL,
  `sex` tinyint(1) NOT NULL,
  `classId` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_stuinfo`
--

INSERT INTO `think_stuinfo` (`no`, `password`, `name`, `sex`, `classId`) VALUES
('123456', '1234', '张三', 1, 19),
('123457', '123', '小红', 0, 17),
('123', '1234', '123', 1, 18),
('1234', '1234', '12', 1, 18);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `think_admin`
--
ALTER TABLE `think_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `think_class`
--
ALTER TABLE `think_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `think_course`
--
ALTER TABLE `think_course`
  ADD PRIMARY KEY (`courseId`);

--
-- Indexes for table `think_student_score`
--
ALTER TABLE `think_student_score`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `think_stuinfo`
--
ALTER TABLE `think_stuinfo`
  ADD PRIMARY KEY (`no`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `think_admin`
--
ALTER TABLE `think_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234;
--
-- 使用表AUTO_INCREMENT `think_class`
--
ALTER TABLE `think_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- 使用表AUTO_INCREMENT `think_course`
--
ALTER TABLE `think_course`
  MODIFY `courseId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;
--
-- 使用表AUTO_INCREMENT `think_student_score`
--
ALTER TABLE `think_student_score`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
