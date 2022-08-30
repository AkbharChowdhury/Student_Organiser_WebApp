-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 06, 2022 at 08:01 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `AC_StudentOrganiser`
--

-- --------------------------------------------------------

--
-- Table structure for table `AccountDeletionDate`
--

CREATE TABLE `AccountDeletionDate` (
  `student_id` int(11) NOT NULL,
  `deletion_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='AccountDeletionDate';

-- --------------------------------------------------------

--
-- Table structure for table `AccountSuspended`
--

CREATE TABLE `AccountSuspended` (
  `student_id` int(11) NOT NULL,
  `reason` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ActivityType`
--

CREATE TABLE `ActivityType` (
  `activity_id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `colour_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ActivityType`
--

INSERT INTO `ActivityType` (`activity_id`, `type`, `colour_id`) VALUES
(3, 'GP appointment', 1),
(4, 'dentist appointment', 2),
(5, 'gym session', 3),
(6, 'Other', 5),
(14, 'Swimming', 8);

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE `Admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` char(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Admin`
--

INSERT INTO `Admin` (`admin_id`, `username`, `password`) VALUES
(1, 'admin', '0f70a94a28f34390dc752bed24d2012abd994886');

-- --------------------------------------------------------

--
-- Table structure for table `Campuses`
--

CREATE TABLE `Campuses` (
  `campus_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `campus` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(30) NOT NULL,
  `postcode` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Campuses`
--

INSERT INTO `Campuses` (`campus_id`, `student_id`, `campus`, `address`, `city`, `postcode`) VALUES
(1, 1, 'Greenwich Maritime', 'Old Royal Naval College, Park Row', 'London', 'SE10 9LS'),
(7, 20, 'balg', 'ss', 'sdsd', 'dsd'),
(13, 1, 'university of greenwich 2', 'asas', 'london', 'eq');

-- --------------------------------------------------------

--
-- Table structure for table `Checklist`
--

CREATE TABLE `Checklist` (
  `checklist_id` int(11) NOT NULL,
  `coursework_id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `due_date` datetime NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Checklist`
--

INSERT INTO `Checklist` (`checklist_id`, `coursework_id`, `title`, `due_date`, `status_id`, `created_at`) VALUES
(19, 35, 'new told', '2022-01-31 14:00:00', 1, '2022-03-07 22:38:23'),
(20, 35, 'UPDATED HF', '2022-02-28 14:00:00', 1, '2022-03-07 22:38:23'),
(33, 34, 'intro', '2022-03-10 00:00:00', 3, '2022-03-09 14:05:32'),
(34, 34, 'Conclusion  TEST', '2022-04-25 15:00:00', 3, '2022-03-09 14:05:32'),
(35, 32, 'ITEM 5', '2022-03-15 12:00:00', 2, '2022-03-09 14:06:39'),
(36, 32, 'TEST', '2022-03-29 15:00:00', 3, '2022-03-09 14:06:39'),
(37, 32, 'conclusion final', '2022-03-30 12:00:00', 1, '2022-03-09 14:06:39'),
(48, 24, 'INTRO', '2022-02-21 12:00:00', 2, '2022-04-18 11:59:17'),
(49, 24, 'CONCLUSION', '2022-02-28 12:00:00', 3, '2022-04-18 11:59:17'),
(50, 24, 'FINAL', '2022-03-23 15:00:00', 2, '2022-04-18 11:59:17'),
(51, 38, 'intro', '2022-04-27 12:34:00', 3, '2022-04-26 10:36:48'),
(52, 38, 'conclusion', '2022-05-10 16:34:00', 2, '2022-04-26 10:36:49'),
(53, 36, 'serrddf', '2022-04-04 11:40:00', 2, '2022-04-26 14:46:13'),
(54, 36, 'item 4332', '2022-04-05 21:40:00', 3, '2022-04-26 14:46:13'),
(55, 12, 'introduction', '2022-01-01 00:00:00', 2, '2022-04-26 14:46:28'),
(56, 12, 'conclusion', '2022-01-01 00:00:00', 2, '2022-04-26 14:46:28'),
(57, 39, 'intro', '2022-04-28 15:57:00', 3, '2022-04-26 14:58:56'),
(58, 39, 'conclusion', '2022-05-24 18:57:00', 2, '2022-04-26 14:58:56');

-- --------------------------------------------------------

--
-- Table structure for table `Classes`
--

CREATE TABLE `Classes` (
  `class_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `campus_id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `room` varchar(30) DEFAULT NULL,
  `colour` varchar(30) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Classes`
--

INSERT INTO `Classes` (`class_id`, `module_id`, `semester_id`, `campus_id`, `day_id`, `start_time`, `end_time`, `room`, `colour`, `type_id`) VALUES
(4, 10, 1, 7, 2, '09:00:00', '10:00:00', '', '#000000', 2),
(5, 1, 1, 1, 5, '13:00:00', '15:00:00', 'QA180', '#4d9e0a', 1),
(12, 2, 1, 1, 2, '11:00:00', '12:00:00', 'KW315', '#0a8bdb', 1),
(13, 1, 1, 1, 5, '15:05:00', '16:00:00', 'D165', '#9a1fa3', 2),
(14, 2, 1, 1, 2, '13:00:00', '14:00:00', 'KW103B', '#81710e', 2),
(15, 3, 1, 1, 1, '11:00:00', '13:00:00', 'KW215', '#3c25bb', 2),
(16, 3, 1, 1, 1, '13:00:00', '14:00:00', 'SL101', '#3dd1a5', 1),
(17, 3, 2, 1, 1, '11:00:00', '12:00:00', 'KW002', '#3314cc', 1),
(18, 33, 2, 1, 1, '14:00:00', '17:00:00', 'KW103B', '#4e1ebe', 2),
(19, 33, 2, 1, 4, '13:00:00', '15:00:00', 'KW103B', '#95af12', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ClassTypes`
--

CREATE TABLE `ClassTypes` (
  `type_id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ClassTypes`
--

INSERT INTO `ClassTypes` (`type_id`, `type`) VALUES
(1, 'Lecture'),
(2, 'Tutorial'),
(3, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `Colours`
--

CREATE TABLE `Colours` (
  `colour_id` int(11) NOT NULL,
  `colour_class` varchar(30) NOT NULL,
  `hex_colour` varchar(30) NOT NULL,
  `colour_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Colours`
--

INSERT INTO `Colours` (`colour_id`, `colour_class`, `hex_colour`, `colour_name`) VALUES
(1, 'primary', '#0d6efd', 'blue'),
(2, 'secondary', '#6c757d', 'gray'),
(3, 'success', '#28a745', 'green'),
(4, 'danger', '#dc3545', 'red'),
(5, 'warning', '#ffc107', 'yellow'),
(6, 'info', '#17a2b8', 'light-blue'),
(7, 'light', '#f8f9fa', 'white'),
(8, 'dark', '#343a40', 'black');

-- --------------------------------------------------------

--
-- Table structure for table `CommunicationPreferences`
--

CREATE TABLE `CommunicationPreferences` (
  `student_id` int(11) NOT NULL,
  `pref_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `CommunicationPreferences`
--

INSERT INTO `CommunicationPreferences` (`student_id`, `pref_id`) VALUES
(1, 1),
(22, 1),
(22, 2),
(27, 1),
(27, 2),
(28, 1),
(28, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Coursework`
--

CREATE TABLE `Coursework` (
  `coursework_id` int(11) NOT NULL,
  `module_id` int(11) DEFAULT NULL,
  `priority_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `colour_tag` varchar(30) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Coursework`
--

INSERT INTO `Coursework` (`coursework_id`, `module_id`, `priority_id`, `title`, `description`, `colour_tag`, `due_date`, `status_id`) VALUES
(1, 2, 3, 'Skiing prototype', '<p>create a skiing prototype</p>', '#000000', '2021-12-10 16:13:00', 1),
(2, 3, 1, 'web project', '<p>uysydusydusydusdsdds</p>', '#000000', '2022-01-26 12:50:00', 2),
(3, 4, 2, 'requirement title', 'dhjsdhjshd', '#2ad585', '2022-01-29 23:05:00', 2),
(12, 3, 2, 'TEST MODULE', '<p>sdssddsds</p>', '#000000', '2022-04-06 12:05:00', 2),
(13, 4, 2, 'wewew', '<p>ddfdfdfd</p>', '#000000', '2022-01-30 12:50:00', 1),
(14, 1, 2, 'asas', '<p><strong>asassasa</strong></p>', '#000000', '2022-01-31 13:54:00', 2),
(15, 3, 2, 'asasasas', '<p>sdsdsd</p>', '#000000', '2022-01-31 13:54:00', 2),
(17, 2, 3, 'asas', '', '#000000', '1970-01-01 13:43:00', 3),
(18, 4, 2, 'TESTING 234s', '', '#000000', '1970-01-01 08:15:00', 1),
(20, 4, 1, 'My local pharmacy', '<p>test description for My local pharmacy</p>', '#000000', '2022-02-27 22:00:00', 1),
(21, 4, 2, 'Human Resources Assistant IV	', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', '#971212', '2022-02-26 18:00:00', 1),
(22, 3, 2, 'test dfff', '<p>szdssddsdsds</p>', '#1c4cab', '2022-02-28 09:15:00', 2),
(24, 1, 1, 'CMS website', '<p>build a cms website for RAH</p>', '#000000', '2022-03-24 16:00:00', 1),
(25, 2, 2, 'HCI resit', '<p>test blah</p>', '#000000', '2022-02-27 11:30:00', 2),
(28, 1, 2, 'lorem ipsuem updated', '<p>ksjdksdjkjksd</p>', '#000000', '2022-02-28 00:00:00', 2),
(31, 8, 2, ',smd,sd', '', '#000000', '2022-02-23 00:00:00', 2),
(32, 8, 1, 'sdsd', '', '#000000', '2022-03-31 00:00:00', 3),
(34, 32, 1, 'Sunderland coursework', '<figure class=\"table\"><table><tbody><tr><td><strong>sdsdh</strong></td><td>jshdjsdhjs</td><td>sdsdsd</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table></figure><blockquote><p>hell world</p></blockquote><ul><li>sdsd</li><li>skdskdjskdk</li></ul>', '#000000', '2022-06-21 14:00:00', 2),
(35, 32, 2, 'go out', '', '#000000', '2022-10-18 14:00:00', 2),
(36, 33, 3, 'NEW ONE', '<p><strong>dfdfddf</strong></p>', '#774b4b', '2022-04-07 23:40:00', 2),
(38, 35, 2, 'new coursework test', '<p><strong>blag</strong> test</p><ol><li>sdksjdksd</li></ol>', '#000000', '2022-05-24 14:34:00', 2),
(39, 36, 3, 'test', '<p>sdjshdjsd</p><p><strong>sdsdds</strong></p><ul><li><strong>aasas</strong></li><li><strong>asas</strong></li></ul>', '#000000', '2022-05-27 17:57:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Days`
--

CREATE TABLE `Days` (
  `day_id` int(11) NOT NULL,
  `day` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Days`
--

INSERT INTO `Days` (`day_id`, `day`) VALUES
(5, 'Friday'),
(1, 'Monday'),
(6, 'Saturday'),
(7, 'Sunday'),
(4, 'Thursday'),
(2, 'Tuesday'),
(3, 'Wednesday');

-- --------------------------------------------------------

--
-- Table structure for table `Modules`
--

CREATE TABLE `Modules` (
  `module_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `module_code` varchar(100) NOT NULL,
  `module_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Modules`
--

INSERT INTO `Modules` (`module_id`, `student_id`, `module_code`, `module_name`) VALUES
(1, 1, 'COMP1643', 'Information & content management'),
(2, 1, 'COMP1649', 'HCI'),
(3, 1, 'COMP1682', 'Final Year Projects'),
(4, 1, 'COMP1787', 'Requirements Management'),
(8, 1, 'COMP1611', 'Programming'),
(10, 20, 'COMP1412', 'Business Systems'),
(11, 20, 'COMP1235', 'Personal Development'),
(32, 1, 'COMP4321', 'Test Module upd'),
(33, 1, 'COMP1634', 'Database Management and Administration'),
(35, 27, 'comp123', 'test'),
(36, 1, 'comp1521', 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `ModuleTeachers`
--

CREATE TABLE `ModuleTeachers` (
  `module_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ModuleTeachers`
--

INSERT INTO `ModuleTeachers` (`module_id`, `teacher_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 3),
(2, 4),
(3, 1),
(3, 4),
(4, 2),
(4, 3),
(8, 3),
(10, 14),
(11, 15),
(32, 2),
(33, 4),
(35, 17);

-- --------------------------------------------------------

--
-- Table structure for table `Notes`
--

CREATE TABLE `Notes` (
  `note_id` int(11) NOT NULL,
  `coursework_id` int(11) DEFAULT NULL,
  `note_description` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `attachments` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Notes`
--

INSERT INTO `Notes` (`note_id`, `coursework_id`, `note_description`, `image`, `attachments`) VALUES
(1, 2, '<p>sdsdds</p>', '', NULL),
(2, 3, '<p>jsdhjsdhjsdjh</p><p>sdksldklsdklds</p>', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTFkpwrEO8OBU-gpAZVQsAuPVZFQyediNZQkffrMcqIhzPM1X5GO0S9wxImNwh6wtYngMY&usqp=CAU', NULL),
(3, 1, '<p>asas</p>', 'data:image/jpeg;base64,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', NULL),
(9, 12, '<p>ydgdhdghsds</p>', '', NULL),
(10, 13, '<p>sdsdsd</p>', '', NULL),
(11, 14, '<p>asaasasas</p>', '', NULL),
(12, 15, '<p>aaaa</p>', '', NULL),
(13, 20, '<p>test notes for My local pharmacy</p>', '', NULL),
(14, 21, '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', 'data:image/jpeg;base64,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', NULL),
(15, 22, '<p>ssdds</p>', 'www.google.com', NULL),
(16, 24, '<p>yes</p>', '', NULL),
(19, 34, '<p><strong>Another test</strong></p>', 'data:image/jpeg;base64,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', NULL),
(20, 36, '<p>sdsds</p>', 'data:image/jpeg;base64,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', NULL),
(21, 38, '<p>test</p>', 'data:image/jpeg;base64,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', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `PersonalCalendar`
--

CREATE TABLE `PersonalCalendar` (
  `personal_calendar_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `status_id` int(11) NOT NULL,
  `priority_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `PersonalCalendar`
--

INSERT INTO `PersonalCalendar` (`personal_calendar_id`, `student_id`, `title`, `description`, `location`, `start`, `end`, `status_id`, `priority_id`, `activity_id`) VALUES
(1, 1, 'GP appointment updated', 'GP appointment at RLH', 'Royal London hospital', '2022-02-04 16:05:00', '2022-02-05 18:05:00', 1, 1, 3),
(28, 1, 'friday prayers', 'ELM jummah', 'ELM', '2022-02-11 12:45:00', '2022-02-11 13:30:00', 1, 3, 6),
(29, 1, 'Go to the beach', 'test description', 'error', '2022-02-18 13:00:00', '2022-02-18 14:00:00', 1, 1, 4),
(30, 1, 'go to dentist', 'retainer', 'ODL Moorgate', '2022-02-05 15:00:00', '2022-02-05 16:10:00', 1, 1, 4),
(31, 1, 'Gym session for', '', '', '2022-02-19 14:00:00', '2022-02-23 10:00:00', 3, 3, 5),
(34, 1, 'Zoo activity', '', 'qwq', '2022-02-03 00:00:00', '2022-02-04 00:00:00', 1, 1, 3),
(35, 1, 'test', 'asas', 'sasa', '2022-02-25 16:00:00', '2022-02-25 18:00:00', 1, 1, 4),
(36, 1, 'Park', 'sdsdsd', NULL, '2022-03-04 22:13:20', '2022-03-05 22:13:20', 1, 2, 3),
(37, 1, 'test', 'hjsdhjshd', '', '2022-03-25 00:00:00', '2022-03-25 17:00:00', 2, 2, 3),
(41, 1, 'Brother birthday', '', '', '2022-03-14 00:00:00', '2022-03-14 23:55:00', 1, 1, 6),
(42, 1, 'test for updated', 'sdsd', 'sdsdsd', '2022-03-10 14:00:00', '2022-03-11 16:00:00', 2, 1, 4),
(43, 1, 'updated fg', 'jhjhjsdsd', 'sdsdssdsd', '2022-04-01 14:00:00', '2022-04-01 17:00:00', 3, 3, 6),
(44, 1, 'dentist', 'dffdfd', 'dfdfdfdf', '2022-03-25 16:45:00', '2022-03-25 17:50:00', 2, 1, 6),
(45, 1, 'FYP Demo', '', '', '2022-04-28 00:00:00', '2022-04-29 00:00:00', 2, 2, 4),
(46, 1, 'revision', 'dsds', 'asasa', '2022-04-29 00:00:00', '2022-04-29 22:00:00', 3, 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `Preferences`
--

CREATE TABLE `Preferences` (
  `pref_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Preferences`
--

INSERT INTO `Preferences` (`pref_id`, `type`) VALUES
(1, 'email'),
(2, 'phone');

-- --------------------------------------------------------

--
-- Table structure for table `Priority`
--

CREATE TABLE `Priority` (
  `priority_id` int(11) NOT NULL,
  `priority_level` varchar(50) NOT NULL,
  `priority_colour` varchar(30) NOT NULL,
  `colour_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Priority`
--

INSERT INTO `Priority` (`priority_id`, `priority_level`, `priority_colour`, `colour_id`) VALUES
(1, 'High', 'danger', 4),
(2, 'Medium', 'warning', 5),
(3, 'Low', 'success', 3);

-- --------------------------------------------------------

--
-- Table structure for table `Semester`
--

CREATE TABLE `Semester` (
  `semester_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Semester`
--

INSERT INTO `Semester` (`semester_id`, `name`, `start_date`, `end_date`) VALUES
(1, ' Year 3: Semester 1', '2021-09-27', '2021-12-17'),
(2, ' Year 3: Semester 2', '2022-01-17', '2022-04-28'),
(21, 'Year 3: Semester 3', '2022-04-10', '2022-05-17'),
(22, 'Semester 4', '2022-05-02', '2022-05-31');

-- --------------------------------------------------------

--
-- Table structure for table `Status`
--

CREATE TABLE `Status` (
  `status_id` int(11) NOT NULL,
  `status_level` varchar(30) NOT NULL,
  `status_description` varchar(100) NOT NULL,
  `colour_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Status`
--

INSERT INTO `Status` (`status_id`, `status_level`, `status_description`, `colour_id`) VALUES
(1, 'Completed', 'task is completed', 3),
(2, 'Not completed', 'task not completed', 4),
(3, 'In progress', 'Task is in progress', 5);

-- --------------------------------------------------------

--
-- Table structure for table `Students`
--

CREATE TABLE `Students` (
  `student_id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `password` char(40) DEFAULT NULL,
  `date_registered` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Students`
--

INSERT INTO `Students` (`student_id`, `firstname`, `lastname`, `email`, `phone`, `password`, `date_registered`) VALUES
(1, 'Milicent', 'Smith', 'mc8852u@gre.ac.uk', '02398239823', 'e75769cb7955a8d86d2dce70d68a83fda1fd7e80', '2022-01-26 14:14:32'),
(20, 'Richard', 'Reese', 'RichardNReese@dayrep.com', '09184727359', 'e75769cb7955a8d86d2dce70d68a83fda1fd7e80', '2022-02-28 21:53:15'),
(22, 'barry', 'tompson', 'ksdjksd@aaa.com', '02938923892', 'e52f6e98196bdba2db9e2be8a6eee8485bc9b41d', '2022-03-04 17:17:14'),
(27, 'Lucas', 'Smith', 'lucasSmith@gmail.com', '00923029309', 'e75769cb7955a8d86d2dce70d68a83fda1fd7e80', '2022-04-26 10:31:38'),
(28, 'Barry', 'Smith', 'bary@gmail.com', '01029102190', 'e75769cb7955a8d86d2dce70d68a83fda1fd7e80', '2022-04-26 14:44:28');

-- --------------------------------------------------------

--
-- Table structure for table `Teachers`
--

CREATE TABLE `Teachers` (
  `teacher_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `colour_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Teachers`
--

INSERT INTO `Teachers` (`teacher_id`, `student_id`, `firstname`, `lastname`, `email`, `colour_id`) VALUES
(1, 1, 'Madlin', 'Alliband', 'malliband0@walmart.com', 3),
(2, 1, 'Davina', 'Romeo', 'dromeo1@networksolutions.com', 3),
(3, 1, 'Hilario', 'Millier', 'hmillier2@engadget.com', 2),
(4, 1, 'Norris', 'Craiker', 'ncraiker3@psu.edu', 1),
(13, 1, 'san', 'don', 'sjhds@aa.com', 2),
(14, 20, 'Martin', 'Caron', 'MartinBCaron@dayrep.com', 5),
(15, 20, 'Nelson', 'Johnson', 'NelsonKKwiatkowski@dayrep.com', 6),
(17, 27, 'new', 'teacher', 't@a.com', 3),
(18, 1, 'mat', 'smith', 'mat@gmail.com', 6);

-- --------------------------------------------------------

--
-- Table structure for table `TermsAndConditions`
--

CREATE TABLE `TermsAndConditions` (
  `termsAndConditions_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `TermsAndConditions`
--

INSERT INTO `TermsAndConditions` (`termsAndConditions_id`, `content`, `last_updated`) VALUES
(1, '<h2>Privacy Policy2</h2><p>This Privacy Policy describes Our policies and procedures on the collection, use and disclosure of Your information when You use the Service and tells You about Your privacy rights and how the law protects You.</p><p>We use Your Personal data to provide and improve the Service. By using the Service, You agree to the collection and use of information in accordance with this Privacy Policy. This Privacy Policy has been created with the help of the <a href=\"https://www.freeprivacypolicy.com/blog/sample-privacy-policy-template/\">Privacy Policy Template</a>.</p><h2>Password</h2><p>You are responsible with the password which you create to access this website for the services we provide to you. We strongly encourage you to use a strong password which contains:</p><ul><li>A mixure of upper, lowercase and special characters characters and numbers</li><li>at least 8 characters</li><li>A password wish cannot be easily guessed such as you date of birth or anything identifiable to you</li></ul><p>Note that it is important that you <strong>do not</strong> use the same password across multiple accounts and/ or websites as this could lead to potential security threats. StudentPlanner <strong>cannot and will not</strong> be liable for any loss or damaged caused by failure to use strong passwords.</p><p>&nbsp;</p><h2>Profile and The Right To Account Deletion</h2><p>Once you become a registered or existing user of our services, we provide you the access to add and modify some elements of your account details.</p><p>If you wish to delete your account you can do so by filling in the delete form provided in the profile page under the link \"I wish to delete my account\". After filling in the delete account form, your account will be deactivated for a month (in case you accidentally delete your account or change your mind), after which your account will be permanently deleted from our systems. This can take up to a week for security purposes and legal obligations under the GDPR - if we suspect that your account contains suspicious activities or illegal activities such as hacking.</p><h2>Interpretation and Definitions</h2><h2>Interpretation</h2><p>The words of which the initial letter is capitalized have meanings defined under the following conditions. The following definitions shall have the same meaning regardless of whether they appear in singular or in plural.</p><h2>Definitions</h2><p>For the purposes of this Privacy Policy:</p><p><strong>Account</strong> means a unique account created for You to access our Service or parts of our Service.</p><p><strong>Company</strong> (referred to as either \"the Company\", \"We\", \"Us\" or \"Our\" in this Agreement) refers to Student Planner.</p><p><strong>Cookies</strong> are small files that are placed on Your computer, mobile device or any other device by a website, containing the details of Your browsing history on that website among its many uses.</p><p><strong>Country</strong> refers to: United Kingdom</p><p><strong>Device</strong> means any device that can access the Service such as a computer, a cellphone or a digital tablet.</p><p><strong>Personal Data</strong> is any information that relates to an identified or identifiable individual.</p><p><strong>Service</strong> refers to the Website.</p><p><strong>Service Provider</strong> means any natural or legal person who processes the data on behalf of the Company. It refers to third-party companies or individuals employed by the Company to facilitate the Service, to provide the Service on behalf of the Company, to perform services related to the Service or to assist the Company in analyzing how the Service is used.</p><p><strong>Usage Data</strong> refers to data collected automatically, either generated by the use of the Service or from the Service infrastructure itself (for example, the duration of a page visit).</p><p><strong>Website</strong> refers to Student Planner, accessible from <a href=\"www.studentplanner.com\">www.studentplanner.com</a></p><p><strong>You</strong> means the individual accessing or using the Service, or the company, or other legal entity on behalf of which such individual is accessing or using the Service, as applicable.</p><h2>Collecting and Using Your Personal Data</h2><h2>Types of Data Collected</h2><h3>Personal Data</h3><p>While using Our Service, We may ask You to provide Us with certain personally identifiable information that can be used to contact or identify You. Personally identifiable information may include, but is not limited to:</p><p>Email address</p><p>First name and last name</p><p>Phone number</p><p>Usage Data</p><h3>Usage Data</h3><p>Usage Data is collected automatically when using the Service.</p><p>Usage Data may include information such as Your Device\'s Internet Protocol address (e.g. IP address), browser type, browser version, the pages of our Service that You visit, the time and date of Your visit, the time spent on those pages, unique device identifiers and other diagnostic data.</p><p>When You access the Service by or through a mobile device, We may collect certain information automatically, including, but not limited to, the type of mobile device You use, Your mobile device unique ID, the IP address of Your mobile device, Your mobile operating system, the type of mobile Internet browser You use, unique device identifiers and other diagnostic data.</p><p>We may also collect information that Your browser sends whenever You visit our Service or when You access the Service by or through a mobile device.</p><h3>Tracking Technologies and Cookies</h3><p>We use Cookies and similar tracking technologies to track the activity on Our Service and store certain information. Tracking technologies used are beacons, tags, and scripts to collect and track information and to improve and analyze Our Service. The technologies We use may include:</p><ul><li><strong>Cookies or Browser Cookies.</strong> A cookie is a small file placed on Your Device. You can instruct Your browser to refuse all Cookies or to indicate when a Cookie is being sent. However, if You do not accept Cookies, You may not be able to use some parts of our Service. Unless you have adjusted Your browser setting so that it will refuse Cookies, our Service may use Cookies.</li><li><strong>Flash Cookies.</strong> Certain features of our Service may use local stored objects (or Flash Cookies) to collect and store information about Your preferences or Your activity on our Service. Flash Cookies are not managed by the same browser settings as those used for Browser Cookies. For more information on how You can delete Flash Cookies, please read \"Where can I change the settings for disabling, or deleting local shared objects?\" available at <a href=\"https://helpx.adobe.com/flash-player/kb/disable-local-shared-objects-flash.html#main_Where_can_I_change_the_settings_for_disabling__or_deleting_local_shared_objects_\">https://helpx.adobe.com/flash-player/kb/disable-local-shared-objects-flash.html#main_Where_can_I_change_the_settings_for_disabling__or_deleting_local_shared_objects_</a></li><li><strong>Web Beacons.</strong> Certain sections of our Service and our emails may contain small electronic files known as web beacons (also referred to as clear gifs, pixel tags, and single-pixel gifs) that permit the Company, for example, to count users who have visited those pages or opened an email and for other related website statistics (for example, recording the popularity of a certain section and verifying system and server integrity).</li></ul><p>Cookies can be \"Persistent\" or \"Session\" Cookies. Persistent Cookies remain on Your personal computer or mobile device when You go offline, while Session Cookies are deleted as soon as You close Your web browser. Learn more about cookies: <a href=\"https://www.freeprivacypolicy.com/blog/sample-privacy-policy-template/#Use_Of_Cookies_And_Tracking\">Use of Cookies by Free Privacy Policy</a>.</p><p>We use both Session and Persistent Cookies for the purposes set out below:</p><p><strong>Necessary / Essential Cookies</strong></p><p>Type: Session Cookies</p><p>Administered by: Us</p><p>Purpose: These Cookies are essential to provide You with services available through the Website and to enable You to use some of its features. They help to authenticate users and prevent fraudulent use of user accounts. Without these Cookies, the services that You have asked for cannot be provided, and We only use these Cookies to provide You with those services.</p><p><strong>Cookies Policy / Notice Acceptance Cookies</strong></p><p>Type: Persistent Cookies</p><p>Administered by: Us</p><p>Purpose: These Cookies identify if users have accepted the use of cookies on the Website.</p><p><strong>Functionality Cookies</strong></p><p>Type: Persistent Cookies</p><p>Administered by: Us</p><p>Purpose: These Cookies allow us to remember choices You make when You use the Website, such as remembering your login details or language preference. The purpose of these Cookies is to provide You with a more personal experience and to avoid You having to re-enter your preferences every time You use the Website.</p><p>For more information about the cookies we use and your choices regarding cookies, please visit our Cookies Policy or the Cookies section of our Privacy Policy.</p><h2>Use of Your Personal Data</h2><p>The Company may use Personal Data for the following purposes:</p><p><strong>To provide and maintain our Service</strong>, including to monitor the usage of our Service.</p><p><strong>To manage Your Account:</strong> to manage Your registration as a user of the Service. The Personal Data You provide can give You access to different functionalities of the Service that are available to You as a registered user.</p><p><strong>For the performance of a contract:</strong> the development, compliance and undertaking of the purchase contract for the products, items or services You have purchased or of any other contract with Us through the Service.</p><p><strong>To contact You:</strong> To contact You by email, telephone calls, SMS, or other equivalent forms of electronic communication, such as a mobile application\'s push notifications regarding updates or informative communications related to the functionalities, products or contracted services, including the security updates, when necessary or reasonable for their implementation.</p><p><strong>To provide You</strong> with news, special offers and general information about other goods, services and events which we offer that are similar to those that you have already purchased or enquired about unless You have opted not to receive such information.</p><p><strong>To manage Your requests:</strong> To attend and manage Your requests to Us.</p><p><strong>For business transfers:</strong> We may use Your information to evaluate or conduct a merger, divestiture, restructuring, reorganization, dissolution, or other sale or transfer of some or all of Our assets, whether as a going concern or as part of bankruptcy, liquidation, or similar proceeding, in which Personal Data held by Us about our Service users is among the assets transferred.</p><p><strong>For other purposes</strong>: We may use Your information for other purposes, such as data analysis, identifying usage trends, determining the effectiveness of our promotional campaigns and to evaluate and improve our Service, products, services, marketing and your experience.</p><p>We may share Your personal information in the following situations:</p><ul><li><strong>With Service Providers:</strong> We may share Your personal information with Service Providers to monitor and analyze the use of our Service, to contact You.</li><li><strong>For business transfers:</strong> We may share or transfer Your personal information in connection with, or during negotiations of, any merger, sale of Company assets, financing, or acquisition of all or a portion of Our business to another company.</li><li><strong>With Affiliates:</strong> We may share Your information with Our affiliates, in which case we will require those affiliates to honor this Privacy Policy. Affiliates include Our parent company and any other subsidiaries, joint venture partners or other companies that We control or that are under common control with Us.</li><li><strong>With business partners:</strong> We may share Your information with Our business partners to offer You certain products, services or promotions.</li><li><strong>With other users:</strong> when You share personal information or otherwise interact in the public areas with other users, such information may be viewed by all users and may be publicly distributed outside.</li><li><strong>With Your consent</strong>: We may disclose Your personal information for any other purpose with Your consent.</li></ul><h2>Retention of Your Personal Data</h2><p>The Company will retain Your Personal Data only for as long as is necessary for the purposes set out in this Privacy Policy. We will retain and use Your Personal Data to the extent necessary to comply with our legal obligations (for example, if we are required to retain your data to comply with applicable laws), resolve disputes, and enforce our legal agreements and policies.</p><p>The Company will also retain Usage Data for internal analysis purposes. Usage Data is generally retained for a shorter period of time, except when this data is used to strengthen the security or to improve the functionality of Our Service, or We are legally obligated to retain this data for longer time periods.</p><h2>Transfer of Your Personal Data</h2><p>Your information, including Personal Data, is processed at the Company\'s operating offices and in any other places where the parties involved in the processing are located. It means that this information may be transferred to — and maintained on — computers located outside of Your state, province, country or other governmental jurisdiction where the data protection laws may differ than those from Your jurisdiction.</p><p>Your consent to this Privacy Policy followed by Your submission of such information represents Your agreement to that transfer.</p><p>The Company will take all steps reasonably necessary to ensure that Your data is treated securely and in accordance with this Privacy Policy and no transfer of Your Personal Data will take place to an organization or a country unless there are adequate controls in place including the security of Your data and other personal information.</p><h2>Disclosure of Your Personal Data</h2><h3>Business Transactions</h3><p>If the Company is involved in a merger, acquisition or asset sale, Your Personal Data may be transferred. We will provide notice before Your Personal Data is transferred and becomes subject to a different Privacy Policy.</p><h3>Law enforcement</h3><p>Under certain circumstances, the Company may be required to disclose Your Personal Data if required to do so by law or in response to valid requests by public authorities (e.g. a court or a government agency).</p><h3>Other legal requirements</h3><p>The Company may disclose Your Personal Data in the good faith belief that such action is necessary to:</p><ul><li>Comply with a legal obligation</li><li>Protect and defend the rights or property of the Company</li><li>Prevent or investigate possible wrongdoing in connection with the Service</li><li>Protect the personal safety of Users of the Service or the public</li><li>Protect against legal liability</li></ul><h2>Security of Your Personal Data</h2><p>The security of Your Personal Data is important to Us, but remember that no method of transmission over the Internet, or method of electronic storage is 100% secure. While We strive to use commercially acceptable means to protect Your Personal Data, We cannot guarantee its absolute security.</p><h2>Children\'s Privacy</h2><p>Our Service does not address anyone under the age of 13. We do not knowingly collect personally identifiable information from anyone under the age of 13. If You are a parent or guardian and You are aware that Your child has provided Us with Personal Data, please contact Us. If We become aware that We have collected Personal Data from anyone under the age of 13 without verification of parental consent, We take steps to remove that information from Our servers.</p><p>If We need to rely on consent as a legal basis for processing Your information and Your country requires consent from a parent, We may require Your parent\'s consent before We collect and use that information.</p><h2>Links to Other Websites</h2><p>Our Service may contain links to other websites that are not operated by Us. If You click on a third party link, You will be directed to that third party\'s site. We strongly advise You to review the Privacy Policy of every site You visit.</p><p>We have no control over and assume no responsibility for the content, privacy policies or practices of any third party sites or services.</p><h2>Changes to this Privacy Policy</h2><p>We may update Our Privacy Policy from time to time. We will notify You of any changes by posting the new Privacy Policy on this page.</p><p>We will let You know via email and/or a prominent notice on Our Service, prior to the change becoming effective and update the \"Last updated\" date at the top of this Privacy Policy.</p><p>You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.</p><h2>Contact Us</h2><p>If you have any questions about this Privacy Policy, You can contact us:</p><p>By emailing the <a href=\"mailto:<?= Mail::getInstance()->getAdminEmail() ?>\">Support team</a></p><p>By visiting this page on our website: <a href=\"terms_and_conditions.inc.php\">Terms and conditions</a></p><h2>Links to Other Websites</h2><p>© 2020 by Student Planner all rights reserved</p>', '2022-04-26 14:55:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AccountDeletionDate`
--
ALTER TABLE `AccountDeletionDate`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `AccountSuspended`
--
ALTER TABLE `AccountSuspended`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `ActivityType`
--
ALTER TABLE `ActivityType`
  ADD PRIMARY KEY (`activity_id`),
  ADD KEY `colour_id` (`colour_id`);

--
-- Indexes for table `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `Campuses`
--
ALTER TABLE `Campuses`
  ADD PRIMARY KEY (`campus_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `Checklist`
--
ALTER TABLE `Checklist`
  ADD PRIMARY KEY (`checklist_id`),
  ADD KEY `coursework_id` (`coursework_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `Classes`
--
ALTER TABLE `Classes`
  ADD PRIMARY KEY (`class_id`,`module_id`,`semester_id`,`type_id`),
  ADD KEY `campus_id` (`campus_id`,`day_id`),
  ADD KEY `day_id` (`day_id`),
  ADD KEY `semester_id` (`semester_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `ClassTypes`
--
ALTER TABLE `ClassTypes`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `Colours`
--
ALTER TABLE `Colours`
  ADD PRIMARY KEY (`colour_id`);

--
-- Indexes for table `CommunicationPreferences`
--
ALTER TABLE `CommunicationPreferences`
  ADD PRIMARY KEY (`student_id`,`pref_id`),
  ADD KEY `pref_id` (`pref_id`);

--
-- Indexes for table `Coursework`
--
ALTER TABLE `Coursework`
  ADD PRIMARY KEY (`coursework_id`),
  ADD KEY `module_id` (`module_id`),
  ADD KEY `priority_id` (`priority_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `Days`
--
ALTER TABLE `Days`
  ADD PRIMARY KEY (`day_id`),
  ADD UNIQUE KEY `day` (`day`);

--
-- Indexes for table `Modules`
--
ALTER TABLE `Modules`
  ADD PRIMARY KEY (`module_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `ModuleTeachers`
--
ALTER TABLE `ModuleTeachers`
  ADD PRIMARY KEY (`module_id`,`teacher_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `Notes`
--
ALTER TABLE `Notes`
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `coursework_id` (`coursework_id`);

--
-- Indexes for table `PersonalCalendar`
--
ALTER TABLE `PersonalCalendar`
  ADD PRIMARY KEY (`personal_calendar_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `status_id` (`status_id`,`priority_id`),
  ADD KEY `priority_id` (`priority_id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indexes for table `Preferences`
--
ALTER TABLE `Preferences`
  ADD PRIMARY KEY (`pref_id`);

--
-- Indexes for table `Priority`
--
ALTER TABLE `Priority`
  ADD PRIMARY KEY (`priority_id`),
  ADD UNIQUE KEY `priority_level` (`priority_level`),
  ADD KEY `colour_id` (`colour_id`);

--
-- Indexes for table `Semester`
--
ALTER TABLE `Semester`
  ADD PRIMARY KEY (`semester_id`);

--
-- Indexes for table `Status`
--
ALTER TABLE `Status`
  ADD PRIMARY KEY (`status_id`),
  ADD UNIQUE KEY `status_level` (`status_level`),
  ADD KEY `colour_id` (`colour_id`);

--
-- Indexes for table `Students`
--
ALTER TABLE `Students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `Teachers`
--
ALTER TABLE `Teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD KEY `teacher_id` (`teacher_id`,`student_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `colour_id` (`colour_id`);

--
-- Indexes for table `TermsAndConditions`
--
ALTER TABLE `TermsAndConditions`
  ADD PRIMARY KEY (`termsAndConditions_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ActivityType`
--
ALTER TABLE `ActivityType`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `Admin`
--
ALTER TABLE `Admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Campuses`
--
ALTER TABLE `Campuses`
  MODIFY `campus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `Checklist`
--
ALTER TABLE `Checklist`
  MODIFY `checklist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `Classes`
--
ALTER TABLE `Classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `ClassTypes`
--
ALTER TABLE `ClassTypes`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Colours`
--
ALTER TABLE `Colours`
  MODIFY `colour_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `Coursework`
--
ALTER TABLE `Coursework`
  MODIFY `coursework_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `Days`
--
ALTER TABLE `Days`
  MODIFY `day_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `Modules`
--
ALTER TABLE `Modules`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `Notes`
--
ALTER TABLE `Notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `PersonalCalendar`
--
ALTER TABLE `PersonalCalendar`
  MODIFY `personal_calendar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `Preferences`
--
ALTER TABLE `Preferences`
  MODIFY `pref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Priority`
--
ALTER TABLE `Priority`
  MODIFY `priority_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Semester`
--
ALTER TABLE `Semester`
  MODIFY `semester_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `Status`
--
ALTER TABLE `Status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Students`
--
ALTER TABLE `Students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `Teachers`
--
ALTER TABLE `Teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `TermsAndConditions`
--
ALTER TABLE `TermsAndConditions`
  MODIFY `termsAndConditions_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `AccountDeletionDate`
--
ALTER TABLE `AccountDeletionDate`
  ADD CONSTRAINT `accountdeletiondate_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `Students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `AccountSuspended`
--
ALTER TABLE `AccountSuspended`
  ADD CONSTRAINT `accountsuspended_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `Students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ActivityType`
--
ALTER TABLE `ActivityType`
  ADD CONSTRAINT `activitytype_ibfk_1` FOREIGN KEY (`colour_id`) REFERENCES `Colours` (`colour_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Campuses`
--
ALTER TABLE `Campuses`
  ADD CONSTRAINT `campuses_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `Students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Checklist`
--
ALTER TABLE `Checklist`
  ADD CONSTRAINT `checklist_ibfk_1` FOREIGN KEY (`coursework_id`) REFERENCES `Coursework` (`coursework_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `checklist_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `Status` (`status_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Classes`
--
ALTER TABLE `Classes`
  ADD CONSTRAINT `classes_ibfk_2` FOREIGN KEY (`campus_id`) REFERENCES `Campuses` (`campus_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `classes_ibfk_3` FOREIGN KEY (`day_id`) REFERENCES `Days` (`day_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `classes_ibfk_4` FOREIGN KEY (`semester_id`) REFERENCES `Semester` (`semester_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `classes_ibfk_5` FOREIGN KEY (`type_id`) REFERENCES `ClassTypes` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `CommunicationPreferences`
--
ALTER TABLE `CommunicationPreferences`
  ADD CONSTRAINT `communicationpreferences_ibfk_1` FOREIGN KEY (`pref_id`) REFERENCES `Preferences` (`pref_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `communicationpreferences_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `Students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Coursework`
--
ALTER TABLE `Coursework`
  ADD CONSTRAINT `coursework_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `Status` (`status_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `coursework_ibfk_2` FOREIGN KEY (`priority_id`) REFERENCES `Priority` (`priority_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `coursework_ibfk_3` FOREIGN KEY (`module_id`) REFERENCES `Modules` (`module_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Modules`
--
ALTER TABLE `Modules`
  ADD CONSTRAINT `modules_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `Students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ModuleTeachers`
--
ALTER TABLE `ModuleTeachers`
  ADD CONSTRAINT `moduleteachers_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `Teachers` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `moduleteachers_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `Modules` (`module_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Notes`
--
ALTER TABLE `Notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`coursework_id`) REFERENCES `Coursework` (`coursework_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `PersonalCalendar`
--
ALTER TABLE `PersonalCalendar`
  ADD CONSTRAINT `personalcalendar_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `Students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `personalcalendar_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `Status` (`status_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `personalcalendar_ibfk_3` FOREIGN KEY (`priority_id`) REFERENCES `Priority` (`priority_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `personalcalendar_ibfk_4` FOREIGN KEY (`activity_id`) REFERENCES `ActivityType` (`activity_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Priority`
--
ALTER TABLE `Priority`
  ADD CONSTRAINT `priority_ibfk_1` FOREIGN KEY (`colour_id`) REFERENCES `Colours` (`colour_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Status`
--
ALTER TABLE `Status`
  ADD CONSTRAINT `status_ibfk_1` FOREIGN KEY (`colour_id`) REFERENCES `Colours` (`colour_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Teachers`
--
ALTER TABLE `Teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `Students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teachers_ibfk_2` FOREIGN KEY (`colour_id`) REFERENCES `Colours` (`colour_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
