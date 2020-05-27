-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 22, 2020 at 09:07 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sairsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE `Admin` (
  `admin_ID` int(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Admin`
--

INSERT INTO `Admin` (`admin_ID`) VALUES
(7),
(21701016);

-- --------------------------------------------------------

--
-- Table structure for table `Assignment`
--

CREATE TABLE `Assignment` (
  `course_ID` varchar(32) NOT NULL,
  `task_ID` int(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Assignment`
--

INSERT INTO `Assignment` (`course_ID`, `task_ID`) VALUES
('CS-202', 4),
('CS-202', 5),
('CS-224', 4),
('CS-224', 5),
('HUM-112', 5),
('MATH-225', 5),
('PHYS-102', 5);

-- --------------------------------------------------------

--
-- Table structure for table `Assists`
--

CREATE TABLE `Assists` (
  `course_ID` varchar(32) NOT NULL,
  `ta_ID` int(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Assists`
--

INSERT INTO `Assists` (`course_ID`, `ta_ID`) VALUES
('CS-202', 95),
('CS-202', 1042),
('CS-224', 95),
('HUM-112', 95),
('MATH-225', 95),
('PHYS-102', 95);

-- --------------------------------------------------------

--
-- Table structure for table `Attendance`
--

CREATE TABLE `Attendance` (
  `course_ID` varchar(32) NOT NULL,
  `task_ID` int(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Attendance`
--

INSERT INTO `Attendance` (`course_ID`, `task_ID`) VALUES
('CS-202', 1),
('CS-202', 2),
('CS-224', 1),
('CS-224', 2),
('HUM-112', 1),
('HUM-112', 2),
('MATH-225', 1),
('MATH-225', 2),
('PHYS-102', 1),
('PHYS-102', 2);

-- --------------------------------------------------------

--
-- Table structure for table `Attends`
--

CREATE TABLE `Attends` (
  `name` varchar(64) NOT NULL,
  `seminar_date` date NOT NULL,
  `host_ID` int(64) NOT NULL,
  `person_ID` int(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Attends`
--

INSERT INTO `Attends` (`name`, `seminar_date`, `host_ID`, `person_ID`) VALUES
('Prog 101', '2020-05-21', 13, 2),
('Prog 101', '2020-05-21', 13, 21701015),
('Prog 102', '2020-05-11', 12, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Club`
--

CREATE TABLE `Club` (
  `name` varchar(64) NOT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `website` varchar(32) DEFAULT NULL,
  `budget` int(64) DEFAULT NULL,
  `head_ID` int(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Club`
--

INSERT INTO `Club` (`name`, `phone`, `website`, `budget`, `head_ID`) VALUES
('Bio club', '52324125', 'bio.com', 651, 19),
('Programming Club', '05523126478', 'prog.com', 45, 13),
('SACC', '+905530949018', 'sacc.com', 569, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Course`
--

CREATE TABLE `Course` (
  `course_ID` varchar(32) NOT NULL,
  `name` varchar(32) DEFAULT NULL,
  `a_grade` int(11) DEFAULT NULL,
  `f_grade` int(11) DEFAULT NULL,
  `info` varchar(64) DEFAULT NULL,
  `dept` varchar(32) DEFAULT NULL,
  `recommended_semester` int(11) DEFAULT NULL,
  `credits` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Course`
--

INSERT INTO `Course` (`course_ID`, `name`, `a_grade`, `f_grade`, `info`, `dept`, `recommended_semester`, `credits`) VALUES
('CS-101', 'Algo and Prog', 85, 60, 'Programming', 'Computer Engineering', 1, 4),
('CS-102', 'Algo and Prog', 85, 60, 'Programming', 'Computer Engineering', 2, 4),
('CS-201', 'Fundamentals of CS', 85, 60, 'C++', 'Computer Engineering', 3, 3),
('CS-202', 'Fundamentals of CS 2', 85, 60, 'C++ 2', 'Computer Engineering', 4, 3),
('CS-223', 'Digital Design', 85, 60, 'Basys 3', 'Computer Engineering', 3, 4),
('CS-224', 'Comp Organization', 85, 60, 'Comp Org', 'Computer Engineering', 4, 4),
('CS-315', 'PL', 85, 60, 'all langs', 'Computer Engineering', 5, 3),
('CS-319', 'OOP', 85, 60, 'Object Oriented', 'Computer Engineering', 5, 4),
('CS-342', 'OS', 85, 60, 'Semaphores', 'Computer Engineering', 6, 4),
('CS-353', 'DB', 85, 60, 'Entity', 'Computer Engineering', 6, 3),
('CS-464', 'ML', 85, 60, 'Neural Networks', 'Computer Engineering', 6, 3),
('EEE-391', 'Bsics Signals', 95, 60, 'Signaiie', 'Electrical Engineering', 6, 3),
('ENG-101', 'English', 95, 60, 'English', 'Language', 1, 3),
('ENG-102', 'English 2', 95, 60, 'English 2', 'Language', 2, 3),
('ENG-401', 'Interview', 95, 60, 'English 4', 'Language', 6, 2),
('GE-100', 'Orientation', 85, 60, 'Orient karo', 'GE', 1, 1),
('GE-301', 'Ch', 85, 60, 'Chawal', 'GE', 5, 2),
('HIST-209', 'History of turkey', 85, 60, 'Anatolian Hist', 'History', 3, 4),
('HUM-111', 'Cultures and Civil', 85, 60, 'Gilgamesh', 'Humanities', 3, 3),
('HUM-112', 'Cultures and Civil 2', 85, 60, 'Antigone', 'Humanities', 4, 3),
('MATH-101', 'Calc 1', 85, 60, 'Basic Calc', 'Mathematics', 1, 4),
('MATH-102', 'Calc 2', 85, 60, 'Basic Calc 2', 'Mathematics', 2, 4),
('MATH-132', 'Discrete', 85, 60, 'Discrete Math', 'Mathematics', 2, 3),
('MATH-225', 'Linear Algeb', 85, 60, 'Linearrr', 'Mathematics', 4, 4),
('MATH-230', 'Prob', 85, 60, 'Probbb', 'Mathematics', 5, 3),
('MBG-110', 'Intro Bio', 95, 60, 'Bio shio', 'Biology', 1, 3),
('PHYS-101', 'General Phys', 85, 60, 'Speed', 'Physics', 3, 4),
('PHYS-102', 'General Phys 2', 85, 60, 'Electric', 'Physics', 4, 4),
('PSYC-100', 'Intro Psyc', 85, 60, 'PSYCCC', 'Psycology', 5, 3),
('TRK-111', 'Basic Turk', 95, 60, 'Intro Turkish', 'Language', 1, 3),
('TRK-112', 'Basic Turk', 95, 60, 'Intro Turkish 2', 'Language', 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `Course_books`
--

CREATE TABLE `Course_books` (
  `course_ID` varchar(32) NOT NULL,
  `book` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Department`
--

CREATE TABLE `Department` (
  `name` varchar(64) NOT NULL,
  `building` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Department`
--

INSERT INTO `Department` (`name`, `building`) VALUES
('Biology', 'SB'),
('Computer Engineering', 'EA'),
('Electrical Engineering', 'EE'),
('GE', 'F'),
('History', 'B'),
('Humanities', 'B'),
('Language', 'SA'),
('Mathematics', 'SA'),
('Physics', 'SB'),
('Psycology', 'T');

-- --------------------------------------------------------

--
-- Table structure for table `Dept_Person`
--

CREATE TABLE `Dept_Person` (
  `name` varchar(64) NOT NULL,
  `person_ID` int(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Dept_Person`
--

INSERT INTO `Dept_Person` (`name`, `person_ID`) VALUES
('Computer Engineering', 2),
('Computer Engineering', 3),
('Computer Engineering', 7),
('Computer Engineering', 8),
('Computer Engineering', 10),
('Computer Engineering', 15),
('Computer Engineering', 16),
('Computer Engineering', 17),
('Computer Engineering', 95),
('Computer Engineering', 21701015),
('Computer Engineering', 21702000),
('Computer Engineering', 21702001),
('Computer Engineering', 21702002),
('Computer Engineering', 21702003),
('Computer Engineering', 21702004),
('Electrical Engineering', 19),
('GE', 12),
('History', 6969),
('Humanities', 5),
('Language', 1),
('Language', 18),
('Mathematics', 4),
('Mathematics', 9),
('Physics', 6),
('Psycology', 13);

-- --------------------------------------------------------

--
-- Table structure for table `Document`
--

CREATE TABLE `Document` (
  `document_ID` int(64) NOT NULL,
  `type` varchar(32) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `person_ID` int(64) DEFAULT NULL,
  `cost` double DEFAULT NULL,
  `method` varchar(32) DEFAULT NULL,
  `domestic_address` varchar(64) DEFAULT NULL,
  `country` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Document`
--

INSERT INTO `Document` (`document_ID`, `type`, `date`, `person_ID`, `cost`, `method`, `domestic_address`, `country`) VALUES
(1, 'Transcript', '0000-00-00', 21701015, 50, 'Standard', 'wf', 'wef');

-- --------------------------------------------------------

--
-- Table structure for table `Emergency_Contact`
--

CREATE TABLE `Emergency_Contact` (
  `person_ID` int(64) DEFAULT NULL,
  `email` varchar(32) NOT NULL,
  `first_name` varchar(32) DEFAULT NULL,
  `last_name` varchar(32) DEFAULT NULL,
  `relation` varchar(32) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Emergency_Contact`
--

INSERT INTO `Emergency_Contact` (`person_ID`, `email`, `first_name`, `last_name`, `relation`, `phone`) VALUES
(21701015, 'ali.g@gmail.com', 'ali', 'khaqan', 'brother', '05523126478'),
(2, 'ssss@gmai.com', 'Daniyal', 'Kakakhel', 'bro', '7636786'),
(21701016, 'un.l@ug.bilkent.edu.tr', 'Mian Usmansss', 'Kakakhelssss', 'bro', '5530949018'),
(6969, 'usman.kakakhel@ug.bilkent.edu.tr', 'Mian Usman Naeem', 'Kakakhel', 'bro', '5530949018');

-- --------------------------------------------------------

--
-- Table structure for table `Exam`
--

CREATE TABLE `Exam` (
  `course_ID` varchar(32) NOT NULL,
  `task_ID` int(64) NOT NULL,
  `room` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Exam`
--

INSERT INTO `Exam` (`course_ID`, `task_ID`, `room`) VALUES
('CS-202', 3, 'g-9'),
('CS-224', 3, 'g-15'),
('HUM-112', 3, 'g-9'),
('HUM-112', 4, 'g-9'),
('MATH-225', 3, 'g-9'),
('MATH-225', 4, 'g-9'),
('PHYS-102', 3, 'g-9'),
('PHYS-102', 4, 'g-9');

-- --------------------------------------------------------

--
-- Table structure for table `grades_submission`
--

CREATE TABLE `grades_submission` (
  `student_ID` int(64) NOT NULL,
  `course_ID` varchar(32) NOT NULL,
  `task_ID` int(64) NOT NULL,
  `ta_ID` int(64) DEFAULT NULL,
  `score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grades_submission`
--

INSERT INTO `grades_submission` (`student_ID`, `course_ID`, `task_ID`, `ta_ID`, `score`) VALUES
(21701015, 'CS-202', 1, 95, 2),
(21701015, 'CS-202', 2, 95, 2),
(21701015, 'CS-202', 3, 95, 54),
(21701015, 'CS-202', 4, 95, 75),
(21701015, 'CS-202', 5, 95, 85),
(21701015, 'CS-224', 1, 95, 2),
(21701015, 'CS-224', 2, 95, 2),
(21701015, 'CS-224', 3, 95, 54),
(21701015, 'CS-224', 4, 95, 75),
(21701015, 'CS-224', 5, 95, 77),
(21701015, 'HUM-112', 1, 95, 2),
(21701015, 'HUM-112', 2, 95, 1),
(21701015, 'HUM-112', 3, 95, 24),
(21701015, 'HUM-112', 4, 95, 45),
(21701015, 'HUM-112', 5, 95, 75),
(21701015, 'MATH-225', 1, 95, 1),
(21701015, 'MATH-225', 2, 95, 2),
(21701015, 'MATH-225', 3, 95, 84),
(21701015, 'MATH-225', 4, 95, 75),
(21701015, 'MATH-225', 5, 95, 85),
(21701015, 'PHYS-102', 1, 95, 2),
(21701015, 'PHYS-102', 2, 95, 2),
(21701015, 'PHYS-102', 3, 95, 77),
(21701015, 'PHYS-102', 4, 95, 12),
(21701015, 'PHYS-102', 5, 95, 85),
(21702000, 'CS-202', 1, 95, 2),
(21702000, 'CS-202', 2, 95, 1),
(21702000, 'CS-202', 3, 95, 69),
(21702000, 'CS-202', 4, 95, 90),
(21702000, 'CS-202', 5, 95, 78),
(21702001, 'CS-202', 1, 95, 2),
(21702001, 'CS-202', 2, 95, 55),
(21702001, 'CS-202', 3, 95, 67),
(21702001, 'CS-202', 4, 95, 69),
(21702001, 'CS-202', 5, 95, 19),
(21702002, 'CS-202', 1, 95, 2),
(21702002, 'CS-202', 2, 95, 2),
(21702002, 'CS-202', 3, 95, 10),
(21702002, 'CS-202', 4, 95, 50),
(21702002, 'CS-202', 5, 95, 59),
(21702003, 'CS-202', 3, 95, 100),
(21702003, 'CS-202', 4, 95, 100),
(21702004, 'CS-202', 3, 95, 30),
(21702004, 'CS-202', 4, 95, 100);

-- --------------------------------------------------------

--
-- Table structure for table `Has_Schedule`
--

CREATE TABLE `Has_Schedule` (
  `time_slot_ID` int(64) NOT NULL,
  `course_ID` varchar(32) NOT NULL,
  `instructor_ID` int(64) NOT NULL,
  `sec_ID` int(64) NOT NULL,
  `semester` enum('Spring','Fall','Summer') NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Has_Schedule`
--

INSERT INTO `Has_Schedule` (`time_slot_ID`, `course_ID`, `instructor_ID`, `sec_ID`, `semester`, `year`) VALUES
(1, 'ENG-401', 18, 1, 'Fall', 2020),
(1, 'MATH-225', 4, 1, 'Spring', 2020),
(2, 'HUM-112', 5, 1, 'Spring', 2020),
(3, 'CS-202', 2, 2, 'Spring', 2020),
(3, 'ENG-401', 18, 1, 'Spring', 2020),
(5, 'PSYC-100', 13, 1, 'Fall', 2020),
(6, 'CS-224', 3, 1, 'Spring', 2020),
(6, 'MATH-230', 9, 1, 'Fall', 2020),
(12, 'CS-202', 2, 1, 'Spring', 2020),
(12, 'CS-202', 2, 2, 'Spring', 2020),
(12, 'CS-315', 7, 1, 'Fall', 2020),
(12, 'CS-319', 8, 1, 'Fall', 2020),
(13, 'PHYS-102', 6, 1, 'Spring', 2020),
(14, 'CS-315', 7, 2, 'Fall', 2020),
(16, 'CS-202', 18, 2, 'Spring', 2020),
(17, 'CS-202', 18, 2, 'Spring', 2020),
(17, 'HUM-112', 5, 1, 'Spring', 2020),
(19, 'CS-101', 2, 1, 'Fall', 2018),
(20, 'CS-102', 8, 1, 'Spring', 2019),
(20, 'CS-202', 2, 1, 'Spring', 2020);

-- --------------------------------------------------------

--
-- Stand-in structure for view `instCourses`
-- (See below for the actual view)
--
CREATE TABLE `instCourses` (
`course_ID` varchar(32)
);

-- --------------------------------------------------------

--
-- Table structure for table `Instructor`
--

CREATE TABLE `Instructor` (
  `instructor_ID` int(64) NOT NULL,
  `rank` enum('Associate','Assistant','Professor','Coordinator','Head','Dean') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Instructor`
--

INSERT INTO `Instructor` (`instructor_ID`, `rank`) VALUES
(1, 'Assistant'),
(2, 'Assistant'),
(3, 'Professor'),
(4, 'Professor'),
(5, 'Professor'),
(6, 'Associate'),
(7, 'Coordinator'),
(8, 'Assistant'),
(9, 'Professor'),
(10, 'Coordinator'),
(12, 'Professor'),
(13, 'Associate'),
(15, 'Dean'),
(16, 'Assistant'),
(17, 'Associate'),
(18, 'Assistant'),
(19, 'Professor');

-- --------------------------------------------------------

--
-- Table structure for table `Participates`
--

CREATE TABLE `Participates` (
  `student_ID` int(64) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Participates`
--

INSERT INTO `Participates` (`student_ID`, `name`) VALUES
(1042, 'Bio club'),
(1042, 'Programming Club'),
(21701015, 'Bio club');

-- --------------------------------------------------------

--
-- Table structure for table `Person`
--

CREATE TABLE `Person` (
  `person_ID` int(64) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `hash_password` varchar(32) NOT NULL,
  `login_status` enum('On','Off') DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `email` varchar(32) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `address` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Person`
--

INSERT INTO `Person` (`person_ID`, `first_name`, `last_name`, `hash_password`, `login_status`, `phone`, `email`, `gender`, `address`) VALUES
(1, 'Ozge', 'Jale', 'd54d1702ad0f8326224b817c796763c9', 'Off', '05523126478', 'ss@gmai.com', 'Female', 'Bilkent'),
(2, 'ugur', 'dorusoz', 'd54d1702ad0f8326224b817c796763c9', 'Off', '52324125', 'OD@gmai.com', 'Male', 'Bilkent'),
(3, 'Fazli', 'Can', 'd54d1702ad0f8326224b817c796763c9', 'Off', '05523126478', 'FC@gmai.com', 'Male', 'Bilkent'),
(4, 'Metin', 'Gurses', 'd54d1702ad0f8326224b817c796763c9', 'Off', '52324125', 'MG@gmail.com', 'Male', 'Bilkent'),
(5, 'Buffy', 'Ann', 'd54d1702ad0f8326224b817c796763c9', 'Off', '45378', 'BA@gmail.com', 'Female', 'Bilkent'),
(6, 'Agnese', 'Calligari', 'd54d1702ad0f8326224b817c796763c9', 'Off', '9826982', 'AC@gmail.com', 'Female', 'Bilkent'),
(7, 'Altay', 'Guvenir', 'd54d1702ad0f8326224b817c796763c9', 'On', '59829548', 'ag@gmai.com', 'Male', 'Bilkent'),
(8, 'Eray', 'Tuzun', 'd54d1702ad0f8326224b817c796763c9', 'Off', '26958952', 'et@gmail.com', 'Male', 'Bilkent'),
(9, 'Dillek', 'Koksal', 'd54d1702ad0f8326224b817c796763c9', 'Off', '6549815', 'dk@gmail.com', 'Female', 'Bilkent'),
(10, 'mustafa', 'ozdal', 'd54d1702ad0f8326224b817c796763c9', 'Off', '02221546875', 'mus.oz@gmail.com', 'Male', '55, bilkent, merkez, Bilkent.'),
(12, 'Robin', 'Downey', 'd54d1702ad0f8326224b817c796763c9', 'Off', '65191', 'rd@gmail.com', 'Female', 'Bilkent'),
(13, 'Ayesha', 'Bilal', 'd54d1702ad0f8326224b817c796763c9', 'Off', '6284168', 'ab@gmail.com', 'Female', 'Bilkent'),
(15, 'Ibrahim', 'korpeoglu', 'd54d1702ad0f8326224b817c796763c9', 'Off', '519159615', 'ib@gmail.com', 'Male', 'Bilkent'),
(16, 'Karani', 'Kardash', 'd54d1702ad0f8326224b817c796763c9', 'Off', '91595915', 'kk@gmail.com', 'Male', 'Bilkemnt'),
(17, 'Abdullah', 'Ercument', 'd54d1702ad0f8326224b817c796763c9', 'Off', '519159159', 'ae@gmail.com', 'Male', 'Bilkent'),
(18, 'Semra', 'Akbash', 'd54d1702ad0f8326224b817c796763c9', 'Off', '95198415', 'sa@gmail.com', 'Female', 'Bilkent'),
(19, 'Haldun', 'Ozaktash', 'd54d1702ad0f8326224b817c796763c9', 'Off', '6294581295', 'ho@gmail.com', 'Male', 'Bilkent'),
(95, 'Nazanin', 'Jafri', 'd54d1702ad0f8326224b817c796763c9', 'Off', '7636786', 'nj@gmail.com', 'Female', 'Bilkent'),
(1042, 'Daniyal', 'Khalil', 'd54d1702ad0f8326224b817c796763c9', 'Off', '7636786', 'sds@gmail.com', 'Male', 'Blkent'),
(6969, 'Ye', 'Choi', 'd54d1702ad0f8326224b817c796763c9', 'Off', '05530949018', 'yec@gmail.com', 'Male', 'Bilkent'),
(21701015, 'Mian Usman Naeem', 'Kakakhel', 'd54d1702ad0f8326224b817c796763c9', 'Off', '5530949018', 'usman.kakakhel@ug.bilkent.edu.tr', 'Male', '77 dorm, main campus, bilkent university'),
(21701016, 'Mian Usmanss', 'Kakakhel', 'd54d1702ad0f8326224b817c796763c9', 'Off', '5530949018', 'n.k@ug.bilkent.edu.tr', 'Male', '77 dorm, main campus, bilkent university'),
(21702000, 'Awaein', 'Meow', '11223344', 'On', '05530949018', 'usman.kakakhel@ug.bilkent.edu.tr', 'Male', 'asaddaasasa'),
(21702001, 'Ahsan', 'Mehmood', '11223344', 'Off', '05530949018', 'usman.kakakhel@ug.bilkent.edu.tr', 'Female', 'aasfsafsafsadsadasdsad'),
(21702002, 'Khalid', 'Hussain', '11223344', 'Off', '05530949018', 'daniyalkhalil16@gmail.com', 'Male', 'assafsafaaaaaaaaaaaaaa'),
(21702003, 'Naruto', 'Uzumaki', '11223344', 'On', '7636786', 'ali.g@gmail.com', 'Male', 'Konohagakure, Near by Ichiraku'),
(21702004, 'Gaara', 'Kazekage', '11223344', 'Off', '05530949018', 'usman.kakakhel@ug.bilkent.edu.tr', 'Female', 'Kirigakure, Kazekage house');

-- --------------------------------------------------------

--
-- Table structure for table `Requires`
--

CREATE TABLE `Requires` (
  `course_ID` varchar(32) NOT NULL,
  `pre_course_ID` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Requires`
--

INSERT INTO `Requires` (`course_ID`, `pre_course_ID`) VALUES
('CS-102', 'CS-101'),
('CS-201', 'CS-102'),
('CS-202', 'CS-201'),
('CS-224', 'CS-223'),
('CS-315', 'CS-202'),
('CS-319', 'CS-202'),
('CS-342', 'CS-224'),
('CS-353', 'CS-202'),
('CS-464', 'CS-102'),
('CS-464', 'MATH-225'),
('CS-464', 'MATH-230'),
('ENG-102', 'ENG-101'),
('ENG-401', 'GE-301'),
('HUM-112', 'HUM-111'),
('MATH-102', 'MATH-101'),
('PHYS-102', 'PHYS-101'),
('TRK-112', 'TRK-111');

-- --------------------------------------------------------

--
-- Table structure for table `Sections`
--

CREATE TABLE `Sections` (
  `course_ID` varchar(32) NOT NULL,
  `sec_ID` int(64) NOT NULL,
  `semester` enum('Spring','Fall','Summer') NOT NULL,
  `year` int(11) NOT NULL,
  `instructor_ID` int(64) NOT NULL,
  `room_ID` varchar(32) DEFAULT NULL,
  `quota` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Sections`
--

INSERT INTO `Sections` (`course_ID`, `sec_ID`, `semester`, `year`, `instructor_ID`, `room_ID`, `quota`) VALUES
('CS-101', 1, 'Fall', 2018, 2, 'k-15', 20),
('CS-102', 1, 'Spring', 2019, 8, 'ea-12', 80),
('CS-201', 1, 'Fall', 2019, 18, 'h-45', 62),
('CS-202', 1, 'Spring', 2020, 2, 'h-45', 20),
('CS-202', 2, 'Spring', 2020, 2, 'B-103', 10),
('CS-202', 2, 'Spring', 2020, 18, 'u-12', 15),
('CS-223', 1, 'Fall', 2019, 10, 'ea-85', 12),
('CS-224', 1, 'Spring', 2020, 3, 'u-74', 45),
('CS-315', 1, 'Fall', 2020, 7, 'o-74', 12),
('CS-315', 2, 'Fall', 2020, 7, 'u-74', 20),
('CS-319', 1, 'Fall', 2020, 8, 'j-75', 55),
('ENG-101', 1, 'Fall', 2018, 4, 'j-25', 42),
('ENG-102', 1, 'Spring', 2019, 17, 'j-48', 24),
('ENG-401', 1, 'Spring', 2020, 18, 'p-85', 45),
('ENG-401', 1, 'Fall', 2020, 18, 'y-52', 55),
('GE-100', 1, 'Fall', 2018, 12, 'l-59', 52),
('HIST-209', 1, 'Fall', 2019, 8, 'p-74', 26),
('HUM-111', 1, 'Fall', 2019, 5, 'i-85', 52),
('HUM-112', 1, 'Spring', 2020, 5, 'i-85', 51),
('MATH-101', 1, 'Fall', 2018, 17, 'k-52', 20),
('MATH-102', 1, 'Spring', 2019, 9, 'g-42', 26),
('MATH-132', 1, 'Spring', 2019, 6, 'r-84', 44),
('MATH-225', 1, 'Spring', 2020, 4, 'y-74', 54),
('MATH-230', 1, 'Fall', 2020, 9, 't-75', 23),
('MBG-110', 1, 'Fall', 2018, 15, 'u-54', 51),
('PHYS-101', 1, 'Fall', 2019, 6, 'y-74', 45),
('PHYS-102', 1, 'Spring', 2020, 6, 'u-74', 52),
('PSYC-100', 1, 'Fall', 2020, 13, 'i-85', 52),
('TRK-111', 1, 'Fall', 2018, 1, 'u-1', 20),
('TRK-112', 1, 'Spring', 2019, 5, 'f-54', 23);

-- --------------------------------------------------------

--
-- Table structure for table `Seminar`
--

CREATE TABLE `Seminar` (
  `name` varchar(64) NOT NULL,
  `seminar_date` date NOT NULL,
  `seminar_time` time DEFAULT NULL,
  `room` varchar(32) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `host_ID` int(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Seminar`
--

INSERT INTO `Seminar` (`name`, `seminar_date`, `seminar_time`, `room`, `duration`, `host_ID`) VALUES
('Mian Usman Naeem Kakakhel', '2020-05-23', '12:00:00', 'B-102', 1, 2),
('Mian Usman Naeem Kakakhelww', '2020-05-22', '12:00:00', 'B-102', 1, 2),
('Prog 101', '2020-05-21', '18:38:53', 't-85', 2, 13),
('Prog 102', '2020-05-11', '18:38:53', 'g-15', 1, 12);

-- --------------------------------------------------------

--
-- Table structure for table `Student`
--

CREATE TABLE `Student` (
  `student_ID` int(64) NOT NULL,
  `advisor_ID` int(64) DEFAULT NULL,
  `current_semester` int(11) DEFAULT NULL,
  `total_semesters` int(11) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `degree` enum('Bachelors','Masters','PhD') DEFAULT NULL,
  `register_limit` int(11) DEFAULT NULL,
  `can_register` enum('Yes','No') DEFAULT NULL,
  `cgpa` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Student`
--

INSERT INTO `Student` (`student_ID`, `advisor_ID`, `current_semester`, `total_semesters`, `rank`, `degree`, `register_limit`, `can_register`, `cgpa`) VALUES
(95, 18, 4, 8, 56, 'Bachelors', 5, 'No', 3.26),
(1042, 2, 4, 8, 56, 'Bachelors', 30, 'No', 3.3),
(6969, 10, 4, 8, 56, 'Bachelors', 30, 'No', 0),
(21701015, 2, 4, 8, 56, 'Bachelors', 5, 'Yes', 3.3),
(21702000, 2, 4, 8, 121, 'Bachelors', 5, 'Yes', 2.56),
(21702001, 2, 6, 8, 5, 'Bachelors', 5, 'Yes', 2.5),
(21702002, 2, 4, 8, 56, 'Bachelors', 5, 'No', 3.52),
(21702003, 2, 2, 8, 1, 'Bachelors', 5, 'No', 1.2),
(21702004, 2, 6, 8, 2, 'Bachelors', 5, 'No', 3.99);

-- --------------------------------------------------------

--
-- Table structure for table `Student_Sections`
--

CREATE TABLE `Student_Sections` (
  `student_ID` int(64) NOT NULL,
  `course_ID` varchar(32) NOT NULL,
  `instructor_ID` int(64) NOT NULL,
  `sec_ID` int(64) NOT NULL,
  `semester` enum('Spring','Fall','Summer') NOT NULL,
  `year` int(11) NOT NULL,
  `grade` enum('A+','A','A-','B+','B','B-','C+','C','C-','D+','D','F') DEFAULT NULL,
  `semester_no` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Student_Sections`
--

INSERT INTO `Student_Sections` (`student_ID`, `course_ID`, `instructor_ID`, `sec_ID`, `semester`, `year`, `grade`, `semester_no`) VALUES
(1042, 'CS-224', 3, 1, 'Spring', 2020, 'A', 4),
(1042, 'HUM-112', 5, 1, 'Spring', 2020, 'A', 4),
(1042, 'MATH-225', 4, 1, 'Spring', 2020, 'F', 4),
(21701015, 'CS-101', 2, 1, 'Fall', 2018, 'A-', 1),
(21701015, 'CS-102', 8, 1, 'Spring', 2019, 'A-', 2),
(21701015, 'CS-201', 18, 1, 'Fall', 2019, 'B', 3),
(21701015, 'CS-202', 2, 1, 'Spring', 2020, NULL, 4),
(21701015, 'CS-223', 10, 1, 'Fall', 2019, 'B+', 3),
(21701015, 'CS-224', 3, 1, 'Spring', 2020, 'A-', 4),
(21701015, 'ENG-101', 4, 1, 'Fall', 2018, 'B+', 1),
(21701015, 'ENG-102', 17, 1, 'Spring', 2019, 'A', 2),
(21701015, 'GE-100', 12, 1, 'Fall', 2018, 'A', 1),
(21701015, 'HIST-209', 8, 1, 'Fall', 2019, 'B+', 3),
(21701015, 'HUM-111', 5, 1, 'Fall', 2019, 'A', 3),
(21701015, 'MATH-101', 17, 1, 'Fall', 2018, 'C+', 1),
(21701015, 'MATH-102', 9, 1, 'Spring', 2019, 'C', 2),
(21701015, 'MATH-132', 6, 1, 'Spring', 2019, 'C', 2),
(21701015, 'MBG-110', 15, 1, 'Fall', 2018, 'A-', 1),
(21701015, 'PHYS-101', 6, 1, 'Fall', 2019, 'A-', 3),
(21701015, 'TRK-111', 1, 1, 'Fall', 2018, 'A-', 1),
(21701015, 'TRK-112', 5, 1, 'Spring', 2019, 'A', 2),
(21702000, 'CS-202', 2, 1, 'Spring', 2020, NULL, 4),
(21702001, 'CS-202', 2, 2, 'Spring', 2020, NULL, 4),
(21702002, 'CS-202', 2, 1, 'Spring', 2020, NULL, 5),
(21702003, 'CS-202', 2, 2, 'Spring', 2020, NULL, 5),
(21702004, 'CS-202', 2, 1, 'Spring', 2020, NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `Task`
--

CREATE TABLE `Task` (
  `course_ID` varchar(32) NOT NULL,
  `task_ID` int(64) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `task_name` varchar(32) DEFAULT NULL,
  `total_score` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Task`
--

INSERT INTO `Task` (`course_ID`, `task_ID`, `start_date`, `end_date`, `task_name`, `total_score`, `weight`) VALUES
('CS-202', 1, '2020-03-17', '2020-03-17', 'Attendance', 2, 1),
('CS-202', 2, '2020-03-18', '2020-03-18', 'Attendance', 2, 1),
('CS-202', 3, '2020-03-18', '2020-03-18', 'Exam', 100, 50),
('CS-202', 4, '2020-03-18', '2020-03-18', 'Project', 100, 20),
('CS-202', 5, '2020-03-12', '2020-03-19', 'HW1', 100, 6),
('CS-224', 1, '2020-03-27', '2020-03-27', 'Attendance', 2, 1),
('CS-224', 2, '2020-03-22', '2020-03-22', 'Attendance', 2, 1),
('CS-224', 3, '2020-03-03', '2020-03-03', 'Exam', 100, 50),
('CS-224', 4, '2020-03-28', '2020-03-28', 'Project', 100, 20),
('CS-224', 5, '2020-03-14', '2020-03-14', 'HW1', 100, 6),
('HUM-112', 1, '2020-03-27', '2020-03-27', 'Attendance', 2, 1),
('HUM-112', 2, '2020-03-22', '2020-03-22', 'Attendance', 2, 1),
('HUM-112', 3, '2020-03-03', '2020-03-03', 'Exam', 100, 50),
('HUM-112', 4, '2020-03-28', '2020-03-28', 'Exam2', 100, 20),
('HUM-112', 5, '2020-03-14', '2020-03-14', 'HW4', 100, 6),
('MATH-225', 1, '2020-03-27', '2020-03-27', 'Attendance', 2, 1),
('MATH-225', 2, '2020-03-22', '2020-03-22', 'Attendance', 2, 1),
('MATH-225', 3, '2020-03-03', '2020-03-03', 'Mid', 100, 50),
('MATH-225', 4, '2020-03-28', '2020-03-28', 'Final', 100, 20),
('MATH-225', 5, '2020-03-14', '2020-03-14', 'HW1', 100, 6),
('PHYS-102', 1, '2020-03-27', '2020-03-27', 'Attendance', 2, 1),
('PHYS-102', 2, '2020-03-22', '2020-03-22', 'Attendance', 2, 1),
('PHYS-102', 3, '2020-03-03', '2020-03-03', 'Final', 100, 50),
('PHYS-102', 4, '2020-03-28', '2020-03-28', 'Mid', 100, 20),
('PHYS-102', 5, '2020-03-14', '2020-03-14', 'Lab', 100, 6);

-- --------------------------------------------------------

--
-- Table structure for table `Task_Assign`
--

CREATE TABLE `Task_Assign` (
  `course_ID` varchar(32) NOT NULL,
  `task_ID` int(64) NOT NULL,
  `ta_ID` int(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Task_Assign`
--

INSERT INTO `Task_Assign` (`course_ID`, `task_ID`, `ta_ID`) VALUES
('CS-202', 1, 95),
('HUM-112', 1, 95),
('PHYS-102', 1, 95),
('CS-202', 2, 95),
('HUM-112', 2, 95),
('PHYS-102', 2, 95),
('MATH-225', 3, 95),
('PHYS-102', 3, 95),
('CS-202', 3, 1042),
('PHYS-102', 5, 95);

-- --------------------------------------------------------

--
-- Table structure for table `Teaching_Assistant`
--

CREATE TABLE `Teaching_Assistant` (
  `ta_ID` int(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Teaching_Assistant`
--

INSERT INTO `Teaching_Assistant` (`ta_ID`) VALUES
(95),
(1042);

-- --------------------------------------------------------

--
-- Table structure for table `Time_Slot`
--

CREATE TABLE `Time_Slot` (
  `time_slot_ID` int(64) NOT NULL,
  `day` enum('Mon','Tue','Wed','Thu','Fri') DEFAULT NULL,
  `time` enum('8-10','10-12','13-15','15-17') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Time_Slot`
--

INSERT INTO `Time_Slot` (`time_slot_ID`, `day`, `time`) VALUES
(1, 'Mon', '8-10'),
(2, 'Mon', '10-12'),
(3, 'Mon', '13-15'),
(4, 'Mon', '15-17'),
(5, 'Tue', '8-10'),
(6, 'Tue', '10-12'),
(7, 'Tue', '13-15'),
(8, 'Tue', '15-17'),
(9, 'Wed', '8-10'),
(10, 'Wed', '10-12'),
(11, 'Wed', '13-15'),
(12, 'Wed', '15-17'),
(13, 'Thu', '8-10'),
(14, 'Thu', '10-12'),
(15, 'Thu', '13-15'),
(16, 'Thu', '15-17'),
(17, 'Fri', '8-10'),
(18, 'Fri', '10-12'),
(19, 'Fri', '13-15'),
(20, 'Fri', '15-17');

-- --------------------------------------------------------

--
-- Structure for view `instCourses`
--
DROP TABLE IF EXISTS `instCourses`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `instCourses`  AS  select `HS`.`course_ID` AS `course_ID` from `Has_Schedule` `HS` where `HS`.`instructor_ID` = '2' ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`admin_ID`);

--
-- Indexes for table `Assignment`
--
ALTER TABLE `Assignment`
  ADD PRIMARY KEY (`course_ID`,`task_ID`);

--
-- Indexes for table `Assists`
--
ALTER TABLE `Assists`
  ADD PRIMARY KEY (`course_ID`,`ta_ID`),
  ADD KEY `ta_ID` (`ta_ID`);

--
-- Indexes for table `Attendance`
--
ALTER TABLE `Attendance`
  ADD PRIMARY KEY (`course_ID`,`task_ID`);

--
-- Indexes for table `Attends`
--
ALTER TABLE `Attends`
  ADD PRIMARY KEY (`name`,`seminar_date`,`host_ID`,`person_ID`),
  ADD KEY `host_ID` (`host_ID`),
  ADD KEY `person_ID` (`person_ID`);

--
-- Indexes for table `Club`
--
ALTER TABLE `Club`
  ADD PRIMARY KEY (`name`),
  ADD KEY `head_ID` (`head_ID`);

--
-- Indexes for table `Course`
--
ALTER TABLE `Course`
  ADD PRIMARY KEY (`course_ID`),
  ADD KEY `dept` (`dept`);

--
-- Indexes for table `Course_books`
--
ALTER TABLE `Course_books`
  ADD PRIMARY KEY (`course_ID`,`book`);

--
-- Indexes for table `Department`
--
ALTER TABLE `Department`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `Dept_Person`
--
ALTER TABLE `Dept_Person`
  ADD PRIMARY KEY (`name`,`person_ID`),
  ADD KEY `person_ID` (`person_ID`);

--
-- Indexes for table `Document`
--
ALTER TABLE `Document`
  ADD PRIMARY KEY (`document_ID`),
  ADD KEY `person_ID` (`person_ID`);

--
-- Indexes for table `Emergency_Contact`
--
ALTER TABLE `Emergency_Contact`
  ADD PRIMARY KEY (`email`),
  ADD KEY `person_ID` (`person_ID`);

--
-- Indexes for table `Exam`
--
ALTER TABLE `Exam`
  ADD PRIMARY KEY (`course_ID`,`task_ID`);

--
-- Indexes for table `grades_submission`
--
ALTER TABLE `grades_submission`
  ADD PRIMARY KEY (`student_ID`,`course_ID`,`task_ID`),
  ADD KEY `ta_ID` (`ta_ID`),
  ADD KEY `course_ID` (`course_ID`,`task_ID`);

--
-- Indexes for table `Has_Schedule`
--
ALTER TABLE `Has_Schedule`
  ADD PRIMARY KEY (`time_slot_ID`,`course_ID`,`instructor_ID`,`sec_ID`,`semester`,`year`),
  ADD KEY `course_ID` (`course_ID`,`instructor_ID`,`sec_ID`,`semester`,`year`);

--
-- Indexes for table `Instructor`
--
ALTER TABLE `Instructor`
  ADD PRIMARY KEY (`instructor_ID`);

--
-- Indexes for table `Participates`
--
ALTER TABLE `Participates`
  ADD PRIMARY KEY (`student_ID`,`name`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `Person`
--
ALTER TABLE `Person`
  ADD PRIMARY KEY (`person_ID`),
  ADD KEY `theName` (`first_name`),
  ADD KEY `theLastName` (`last_name`);

--
-- Indexes for table `Requires`
--
ALTER TABLE `Requires`
  ADD PRIMARY KEY (`course_ID`,`pre_course_ID`),
  ADD KEY `pre_course_ID` (`pre_course_ID`);

--
-- Indexes for table `Sections`
--
ALTER TABLE `Sections`
  ADD PRIMARY KEY (`course_ID`,`instructor_ID`,`sec_ID`,`semester`,`year`),
  ADD KEY `instructor_ID` (`instructor_ID`);

--
-- Indexes for table `Seminar`
--
ALTER TABLE `Seminar`
  ADD PRIMARY KEY (`name`,`seminar_date`,`host_ID`),
  ADD KEY `host_ID` (`host_ID`);

--
-- Indexes for table `Student`
--
ALTER TABLE `Student`
  ADD PRIMARY KEY (`student_ID`),
  ADD KEY `advisor_ID` (`advisor_ID`),
  ADD KEY `theGpa` (`cgpa`);

--
-- Indexes for table `Student_Sections`
--
ALTER TABLE `Student_Sections`
  ADD PRIMARY KEY (`student_ID`,`course_ID`,`instructor_ID`,`sec_ID`,`semester`,`year`),
  ADD KEY `course_ID` (`course_ID`,`instructor_ID`,`sec_ID`,`semester`,`year`);

--
-- Indexes for table `Task`
--
ALTER TABLE `Task`
  ADD PRIMARY KEY (`course_ID`,`task_ID`);

--
-- Indexes for table `Task_Assign`
--
ALTER TABLE `Task_Assign`
  ADD PRIMARY KEY (`task_ID`,`ta_ID`,`course_ID`),
  ADD KEY `course_ID` (`course_ID`,`task_ID`),
  ADD KEY `ta_ID` (`ta_ID`);

--
-- Indexes for table `Teaching_Assistant`
--
ALTER TABLE `Teaching_Assistant`
  ADD PRIMARY KEY (`ta_ID`);

--
-- Indexes for table `Time_Slot`
--
ALTER TABLE `Time_Slot`
  ADD PRIMARY KEY (`time_slot_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Document`
--
ALTER TABLE `Document`
  MODIFY `document_ID` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Person`
--
ALTER TABLE `Person`
  MODIFY `person_ID` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21702005;

--
-- AUTO_INCREMENT for table `Time_Slot`
--
ALTER TABLE `Time_Slot`
  MODIFY `time_slot_ID` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Admin`
--
ALTER TABLE `Admin`
  ADD CONSTRAINT `Admin_ibfk_1` FOREIGN KEY (`admin_ID`) REFERENCES `Person` (`person_ID`);

--
-- Constraints for table `Assignment`
--
ALTER TABLE `Assignment`
  ADD CONSTRAINT `Assignment_ibfk_1` FOREIGN KEY (`course_ID`,`task_ID`) REFERENCES `Task` (`course_ID`, `task_ID`);

--
-- Constraints for table `Assists`
--
ALTER TABLE `Assists`
  ADD CONSTRAINT `Assists_ibfk_1` FOREIGN KEY (`course_ID`) REFERENCES `Course` (`course_ID`),
  ADD CONSTRAINT `Assists_ibfk_2` FOREIGN KEY (`ta_ID`) REFERENCES `Teaching_Assistant` (`ta_ID`);

--
-- Constraints for table `Attendance`
--
ALTER TABLE `Attendance`
  ADD CONSTRAINT `Attendance_ibfk_1` FOREIGN KEY (`course_ID`,`task_ID`) REFERENCES `Task` (`course_ID`, `task_ID`);

--
-- Constraints for table `Attends`
--
ALTER TABLE `Attends`
  ADD CONSTRAINT `Attends_ibfk_1` FOREIGN KEY (`name`,`seminar_date`) REFERENCES `Seminar` (`name`, `seminar_date`),
  ADD CONSTRAINT `Attends_ibfk_2` FOREIGN KEY (`host_ID`) REFERENCES `Instructor` (`instructor_ID`),
  ADD CONSTRAINT `Attends_ibfk_3` FOREIGN KEY (`person_ID`) REFERENCES `Person` (`person_ID`);

--
-- Constraints for table `Club`
--
ALTER TABLE `Club`
  ADD CONSTRAINT `Club_ibfk_1` FOREIGN KEY (`head_ID`) REFERENCES `Instructor` (`instructor_ID`);

--
-- Constraints for table `Course`
--
ALTER TABLE `Course`
  ADD CONSTRAINT `Course_ibfk_1` FOREIGN KEY (`dept`) REFERENCES `Department` (`name`);

--
-- Constraints for table `Course_books`
--
ALTER TABLE `Course_books`
  ADD CONSTRAINT `Course_books_ibfk_1` FOREIGN KEY (`course_ID`) REFERENCES `Course` (`course_ID`);

--
-- Constraints for table `Dept_Person`
--
ALTER TABLE `Dept_Person`
  ADD CONSTRAINT `Dept_Person_ibfk_1` FOREIGN KEY (`name`) REFERENCES `Department` (`name`),
  ADD CONSTRAINT `Dept_Person_ibfk_2` FOREIGN KEY (`person_ID`) REFERENCES `Person` (`person_ID`);

--
-- Constraints for table `Document`
--
ALTER TABLE `Document`
  ADD CONSTRAINT `Document_ibfk_1` FOREIGN KEY (`person_ID`) REFERENCES `Person` (`person_ID`);

--
-- Constraints for table `Emergency_Contact`
--
ALTER TABLE `Emergency_Contact`
  ADD CONSTRAINT `Emergency_Contact_ibfk_1` FOREIGN KEY (`person_ID`) REFERENCES `Person` (`person_ID`);

--
-- Constraints for table `Exam`
--
ALTER TABLE `Exam`
  ADD CONSTRAINT `Exam_ibfk_1` FOREIGN KEY (`course_ID`,`task_ID`) REFERENCES `Task` (`course_ID`, `task_ID`);

--
-- Constraints for table `grades_submission`
--
ALTER TABLE `grades_submission`
  ADD CONSTRAINT `grades_submission_ibfk_1` FOREIGN KEY (`ta_ID`) REFERENCES `Teaching_Assistant` (`ta_ID`),
  ADD CONSTRAINT `grades_submission_ibfk_2` FOREIGN KEY (`student_ID`) REFERENCES `Student` (`student_ID`),
  ADD CONSTRAINT `grades_submission_ibfk_3` FOREIGN KEY (`course_ID`,`task_ID`) REFERENCES `Task` (`course_ID`, `task_ID`);

--
-- Constraints for table `Has_Schedule`
--
ALTER TABLE `Has_Schedule`
  ADD CONSTRAINT `Has_Schedule_ibfk_1` FOREIGN KEY (`time_slot_ID`) REFERENCES `Time_Slot` (`time_slot_ID`),
  ADD CONSTRAINT `Has_Schedule_ibfk_2` FOREIGN KEY (`course_ID`,`instructor_ID`,`sec_ID`,`semester`,`year`) REFERENCES `Sections` (`course_ID`, `instructor_ID`, `sec_ID`, `semester`, `year`);

--
-- Constraints for table `Instructor`
--
ALTER TABLE `Instructor`
  ADD CONSTRAINT `Instructor_ibfk_1` FOREIGN KEY (`instructor_ID`) REFERENCES `Person` (`person_ID`);

--
-- Constraints for table `Participates`
--
ALTER TABLE `Participates`
  ADD CONSTRAINT `Participates_ibfk_1` FOREIGN KEY (`student_ID`) REFERENCES `Student` (`student_ID`),
  ADD CONSTRAINT `Participates_ibfk_2` FOREIGN KEY (`name`) REFERENCES `Club` (`name`);

--
-- Constraints for table `Requires`
--
ALTER TABLE `Requires`
  ADD CONSTRAINT `Requires_ibfk_1` FOREIGN KEY (`course_ID`) REFERENCES `Course` (`course_ID`),
  ADD CONSTRAINT `Requires_ibfk_2` FOREIGN KEY (`pre_course_ID`) REFERENCES `Course` (`course_ID`);

--
-- Constraints for table `Sections`
--
ALTER TABLE `Sections`
  ADD CONSTRAINT `Sections_ibfk_1` FOREIGN KEY (`course_ID`) REFERENCES `Course` (`course_ID`),
  ADD CONSTRAINT `Sections_ibfk_2` FOREIGN KEY (`instructor_ID`) REFERENCES `Instructor` (`instructor_ID`);

--
-- Constraints for table `Seminar`
--
ALTER TABLE `Seminar`
  ADD CONSTRAINT `Seminar_ibfk_1` FOREIGN KEY (`host_ID`) REFERENCES `Instructor` (`instructor_ID`);

--
-- Constraints for table `Student`
--
ALTER TABLE `Student`
  ADD CONSTRAINT `Student_ibfk_1` FOREIGN KEY (`advisor_ID`) REFERENCES `Instructor` (`instructor_ID`),
  ADD CONSTRAINT `Student_ibfk_2` FOREIGN KEY (`student_ID`) REFERENCES `Person` (`person_ID`);

--
-- Constraints for table `Student_Sections`
--
ALTER TABLE `Student_Sections`
  ADD CONSTRAINT `Student_Sections_ibfk_1` FOREIGN KEY (`student_ID`) REFERENCES `Student` (`student_ID`),
  ADD CONSTRAINT `Student_Sections_ibfk_2` FOREIGN KEY (`course_ID`,`instructor_ID`,`sec_ID`,`semester`,`year`) REFERENCES `Sections` (`course_ID`, `instructor_ID`, `sec_ID`, `semester`, `year`);

--
-- Constraints for table `Task`
--
ALTER TABLE `Task`
  ADD CONSTRAINT `Task_ibfk_1` FOREIGN KEY (`course_ID`) REFERENCES `Course` (`course_ID`);

--
-- Constraints for table `Task_Assign`
--
ALTER TABLE `Task_Assign`
  ADD CONSTRAINT `Task_Assign_ibfk_1` FOREIGN KEY (`course_ID`,`task_ID`) REFERENCES `Task` (`course_ID`, `task_ID`),
  ADD CONSTRAINT `Task_Assign_ibfk_2` FOREIGN KEY (`ta_ID`) REFERENCES `Teaching_Assistant` (`ta_ID`);

--
-- Constraints for table `Teaching_Assistant`
--
ALTER TABLE `Teaching_Assistant`
  ADD CONSTRAINT `Teaching_Assistant_ibfk_1` FOREIGN KEY (`ta_ID`) REFERENCES `Person` (`person_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
