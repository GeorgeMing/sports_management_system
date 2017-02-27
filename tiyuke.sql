-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-02-27 03:47:00
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
(1, '陈老师', 'admin', '1234', 1);

-- --------------------------------------------------------

--
-- 表的结构 `think_class`
--

CREATE TABLE `think_class` (
  `id` int(11) NOT NULL,
  `grade` tinyint(1) NOT NULL,
  `classNo` tinyint(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_class`
--

INSERT INTO `think_class` (`id`, `grade`, `classNo`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(14, 1, 14),
(15, 1, 15),
(16, 1, 16),
(17, 1, 17),
(18, 1, 18),
(19, 1, 19),
(20, 1, 20),
(21, 1, 21),
(22, 1, 22),
(23, 1, 23),
(24, 1, 24),
(25, 2, 1),
(26, 2, 2),
(27, 2, 3),
(28, 2, 4),
(29, 2, 5),
(30, 2, 6),
(31, 2, 7),
(32, 2, 8),
(33, 2, 9),
(34, 2, 10),
(35, 2, 11),
(36, 2, 12),
(37, 2, 13),
(38, 2, 14),
(39, 2, 15),
(40, 2, 16),
(41, 2, 17),
(42, 2, 18),
(43, 2, 19),
(44, 2, 20),
(45, 2, 21),
(46, 2, 22),
(47, 2, 23),
(48, 2, 24),
(49, 3, 1),
(50, 3, 2),
(51, 3, 3),
(52, 3, 4),
(53, 3, 5),
(54, 3, 6),
(55, 3, 7),
(56, 3, 8),
(57, 3, 9),
(58, 3, 10),
(59, 3, 11),
(60, 3, 12),
(61, 3, 13),
(62, 3, 14),
(63, 3, 15),
(64, 3, 16),
(65, 3, 17),
(66, 3, 18),
(67, 3, 19),
(68, 3, 20),
(69, 3, 21),
(70, 3, 22),
(71, 3, 23),
(72, 3, 24);

-- --------------------------------------------------------

--
-- 表的结构 `think_course`
--

CREATE TABLE `think_course` (
  `courseId` int(11) NOT NULL,
  `courseName` varchar(10) NOT NULL COMMENT '课程名称',
  `classRangeId` json NOT NULL COMMENT '年级',
  `adminId` int(11) NOT NULL COMMENT '开课老师ID',
  `time` varchar(20) NOT NULL COMMENT '上课时间',
  `peopleNumber` int(11) NOT NULL COMMENT '课程人数',
  `choiceNumber` int(11) NOT NULL COMMENT '已选人数'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_course`
--

INSERT INTO `think_course` (`courseId`, `courseName`, `classRangeId`, `adminId`, `time`, `peopleNumber`, `choiceNumber`) VALUES
(1, '篮球', '{"1": 1, "2": 2}', 1, '周一上午一二节', 40, 0),
(2, '足球', '{"0": 6, "1": 7, "3": 8, "4": 9}', 1, '周二下午三四节', 35, 0);

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
-- 表的结构 `think_student_course`
--

CREATE TABLE `think_student_course` (
  `id` int(11) NOT NULL,
  `no` varchar(12) NOT NULL,
  `courseid` int(11) NOT NULL,
  `score` json NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
('123456', '123456', '张三', 1, 1),
('123457', '123456', '小红', 0, 7);

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
-- Indexes for table `think_student_course`
--
ALTER TABLE `think_student_course`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `think_class`
--
ALTER TABLE `think_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- 使用表AUTO_INCREMENT `think_course`
--
ALTER TABLE `think_course`
  MODIFY `courseId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `think_student_course`
--
ALTER TABLE `think_student_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
