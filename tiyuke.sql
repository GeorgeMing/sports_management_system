-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-03-23 10:06:27
-- 服务器版本： 5.7.14
-- PHP Version: 7.0.10

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
  `root` tinyint(1) NOT NULL COMMENT '超级管理员为1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_admin`
--

INSERT INTO `think_admin` (`id`, `name`, `username`, `password`, `root`) VALUES
(234, '吴老师', 'admin3', '1234', 0),
(4, '陈老师', 'admin1', '1234', 0),
(6, '王老师', 'admin', '1234', 1),
(7, '刘老师', '233', '233', 0),
(233, '周老师', 'admin2', '77777', 0);

-- --------------------------------------------------------

--
-- 表的结构 `think_android_test`
--

CREATE TABLE `think_android_test` (
  `account` varchar(16) NOT NULL,
  `password` varchar(16) NOT NULL,
  `problem` varchar(30) NOT NULL,
  `answer` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_android_test`
--

INSERT INTO `think_android_test` (`account`, `password`, `problem`, `answer`) VALUES
('123', '123', '123', '123');

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
(72, 324, 3, 24),
(71, 323, 3, 23),
(70, 322, 3, 22),
(69, 321, 3, 21),
(68, 320, 3, 20),
(67, 319, 3, 19),
(66, 318, 3, 18),
(65, 317, 3, 17),
(64, 316, 3, 16),
(63, 315, 3, 15),
(62, 314, 3, 14),
(61, 313, 3, 13),
(60, 312, 3, 12),
(59, 311, 3, 11),
(58, 310, 3, 10),
(57, 39, 3, 9),
(56, 38, 3, 8),
(55, 37, 3, 7),
(54, 36, 3, 6),
(53, 35, 3, 5),
(52, 34, 3, 4),
(51, 33, 3, 3),
(50, 32, 3, 2),
(49, 31, 3, 1),
(26, 22, 2, 2),
(27, 23, 2, 3),
(28, 24, 2, 4),
(29, 25, 2, 5),
(30, 26, 2, 6),
(31, 27, 2, 7),
(32, 28, 2, 8),
(33, 29, 2, 9),
(34, 210, 2, 10),
(35, 211, 2, 11),
(36, 212, 2, 12),
(37, 213, 2, 13),
(38, 214, 2, 14),
(39, 215, 2, 15),
(40, 216, 2, 16),
(41, 217, 2, 17),
(42, 218, 2, 18),
(43, 219, 2, 19),
(44, 220, 2, 20),
(45, 221, 2, 21),
(46, 222, 2, 22),
(47, 223, 2, 23),
(48, 224, 2, 24);

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
(184, '123334', '{"17": "高一（7）班", "18": "高一（8）班", "19": "高一（9）班", "25": "高二（5）班", "26": "高二（6）班", "31": "高三（1）班", "32": "高三（2）班", "33": "高三（3）班", "214": "高二（14）班"}', '刘老师', '', 0, 0),
(447, '123', '{"25": "高二（5）班"}', '周老师', '23', 23, 0),
(448, '234', '{"22": "高二（2）班"}', '吴老师', '123', 123, 0),
(449, '足球', '{"17": "高一（7）班", "27": "高二（7）班", "222": "高二（22）班"}', '王老师', '周三八九节', 5, 1);

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
  `other_score` json NOT NULL,
  `semester` int(1) NOT NULL COMMENT '1是上学期2是下学期',
  `score_proportion` json NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_student_score`
--

INSERT INTO `think_student_score` (`id`, `no`, `courseId`, `score`, `other_score`, `semester`, `score_proportion`) VALUES
(5, '123456', 175, '12', '0', 1, '0'),
(6, '123', 174, '12', '0', 1, '0'),
(25, '123456', 179, '23', '0', 1, '0'),
(23, '123457', 179, '41', '0', 1, '0'),
(63, '123', 180, '0', '0', 1, '0'),
(67, '1234', 180, '0', '{"考试成绩": "90"}', 1, '0'),
(70, '123456', 449, '0', '{"平时成绩": "90", "考试成绩": "90"}', 1, '{"1": "60", "2": "40"}'),
(144, '123457', 449, '0', '0', 1, '0');

-- --------------------------------------------------------

--
-- 表的结构 `think_stuinfo`
--

CREATE TABLE `think_stuinfo` (
  `no` varchar(12) NOT NULL,
  `password` varchar(20) NOT NULL,
  `name` varchar(5) NOT NULL,
  `sex` tinyint(1) NOT NULL,
  `classId` int(11) NOT NULL,
  `semester` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_stuinfo`
--

INSERT INTO `think_stuinfo` (`no`, `password`, `name`, `sex`, `classId`, `semester`) VALUES
('123456', '1234', '张三', 1, 27, 1),
('123457', '123', '小红', 0, 27, 1),
('123', '1234', '小军', 1, 32, 1),
('1234', '1234', '宝宝', 1, 222, 2),
('140201011022', '1234', '小治', 1, 171, 1),
('140201011031', '123', '小明', 1, 173, 1);

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
-- Indexes for table `think_android_test`
--
ALTER TABLE `think_android_test`
  ADD PRIMARY KEY (`account`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=235;
--
-- 使用表AUTO_INCREMENT `think_class`
--
ALTER TABLE `think_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;
--
-- 使用表AUTO_INCREMENT `think_course`
--
ALTER TABLE `think_course`
  MODIFY `courseId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=456;
--
-- 使用表AUTO_INCREMENT `think_student_score`
--
ALTER TABLE `think_student_score`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
