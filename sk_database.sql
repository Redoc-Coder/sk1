-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2024 at 03:42 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sk_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(100) NOT NULL,
  `municipal` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `municipal`) VALUES
(1, 'admin@gmail.com', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `admin_passcode`
--

CREATE TABLE `admin_passcode` (
  `id` int(11) NOT NULL,
  `passcode` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_passcode`
--

INSERT INTO `admin_passcode` (`id`, `passcode`) VALUES
(1, 'adminmoto');

-- --------------------------------------------------------

--
-- Table structure for table `archived_official_records`
--

CREATE TABLE `archived_official_records` (
  `id` int(11) NOT NULL,
  `barangay_name` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `committee` varchar(20) NOT NULL,
  `barangay_position` varchar(20) NOT NULL,
  ```reg_date`` timestamp NOT NULL DEFAULT current_timestamp(),` timestamp NOT NULL DEFAULT current_timestamp(),
  `session_id` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archived_youth_records`
--

CREATE TABLE `archived_youth_records` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `birthdate` date NOT NULL,
  `marital_status` varchar(20) NOT NULL,
  `religion` varchar(50) NOT NULL,
  `osy` varchar(3) NOT NULL,
  `ws` varchar(3) NOT NULL,
  `yp` varchar(3) NOT NULL,
  `pwd` varchar(3) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `session_id` varchar(60) NOT NULL,
  `barangay_purok_no` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archived_youth_records`
--

INSERT INTO `archived_youth_records` (`id`, `first_name`, `middle_name`, `last_name`, `gender`, `contact_no`, `birthdate`, `marital_status`, `religion`, `osy`, `ws`, `yp`, `pwd`, `reg_date`, `session_id`, `barangay_purok_no`) VALUES
(22, 'zxczxczxc', '23423', 'xzxczxc', 'Male', '32423423423423', '2024-03-14', 'Widowed', 'efdghtrgdf', 'Yes', 'Yes', 'No', 'Yes', '2024-03-06 00:36:37', 'suinanlawrence5@gmail.com', 'dasdasdasdas'),
(23, 'jkasbdjkan', 'kasnd', 'asdjghas', 'Male', '19615211561', '2024-03-22', 'Married', 'wsda', 'Yes', 'Yes', 'Yes', 'Yes', '2024-03-06 00:35:23', 'suinanlawrence5@gmail.com', 'dsadsa');

-- --------------------------------------------------------

--
-- Table structure for table `barangay`
--

CREATE TABLE `barangay` (
  `id` int(11) NOT NULL,
  `street` varchar(255) NOT NULL,
  `municipal` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `gender` enum('Male','Female','Prefer not to say') DEFAULT NULL,
  `valid_id` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `status` varchar(64) NOT NULL,
  `registered_date` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangay`
--

INSERT INTO `barangay` (`id`, `street`, `municipal`, `province`, `first_name`, `middle_name`, `last_name`, `contact_no`, `gender`, `valid_id`, `email`, `password`, `session_id`, `status`, `registered_date`) VALUES
(17, 'Pansol', 'Pila', 'Laguna', 'Vince Lawrence POgi', 'B. ', 'Suinan', '09108029485', 'Male', 'uploads/545e79gm.png', 'suinanlawrence2@gmail.com', '$2y$10$IuX63lijs/ge8CxLWedS0OVbqxxUUCPA8ToQKhoxBNGKEpiQClL5K', 'suinanlawrence2@gmail.com', 'Decline', NULL),
(18, 'Masico', 'Pila', 'Laguna', 'Lawrejnce', 'A', 'Cortez', '09108029485', 'Male', 'uploads/ymavg62m.csv', 'suinanlawrence1@gmail.com', '$2y$10$JaahiTUvq1Azpet1ekiI6uXZCO8al8RTTjvcHtVD6k3dAAQyaxunu', 'suinanlawrence1@gmail.com', 'Approve', NULL),
(19, 'San Miguel', 'Pila', 'Laguna', 'Lawrejnce', 'A', 'Cortez', '09108029485', 'Male', 'uploads/ymavg62m.csv', 'suinanlawrence3@gmail.com', '$2y$10$gUP36dNYq2wNVEvAzPBy3O8YKVHvjEiHEsv6.d0Nmcj3Huma5b1NW', 'suinanlawrence3@gmail.com', 'Approve', NULL),
(20, 'Mojon', 'Pila', 'Laguna', 'Ganda', 'Cc', 'kKAssd', '09154875523', 'Male', 'uploads/ymavg62m.csv', 'suinanlawrence4@gmail.com', '$2y$10$bJA9lybE67H3JXUlcg1SZuxXSyYsSC4FI5q2ZLZ4XUbDWpq1E4Aoe', 'suinanlawrence4@gmail.com', 'Approve', NULL),
(21, 'Bukal', 'Pila', 'Laguna', 'pogia', 'G.', 'ASdsd', '09458715456', 'Prefer not to say', 'uploads/545e79gm.png', 'suinanlawrence5@gmail.com', '$2y$10$5NZ4m2dI0qj.3sSw7.8tRepATBn6qAua1TCMn2zdSkhKAEgpzaPgy', 'suinanlawrence5@gmail.com', 'Approve', '2024-03-05'),
(22, 'Bubuka', 'Sta.Cruz', 'Laguna', 'lawrence sii', 'B.', 'Suinan', '091238354321', 'Prefer not to say', 'uploads/Screenshot (398).png', 'suinanlawrence6@gmail.com', '$2y$10$TOR5xJdb9KbvqGBGafqlB.O/JUllsIBTL76LRiJcxYq3ZO2UuJhly', 'suinanlawrence6@gmail.com', 'Approve', '2024-03-06'),
(23, 'asdasd', 'asdadas', 'asdsadsa', 'vincepass', 'pass', 'passs', '09183412', 'Male', 'Screenshot (398).png', 'asdasdasd@gmail.com', '$2y$10$Cpbk6fkgKNaftCC.7zRCgefCHIwl3xwRpD8C60x/Gsbr9Kasiv9fu', 'asdasdasd@gmail.com', 'Pending', '2024-03-06'),
(24, 'asdasdaasd', 'asdadas', 'asdsadsa', 'vincepass', 'pass', 'passs', '09183412', 'Male', 'Screenshot (398).png', 'asdasdasda@gmail.com', '$2y$10$Can5qr/jSUM.X21dqxGgau8NslGSK9BaNZqfirPzuCY1Vee7K4Gxy', 'asdasdasda@gmail.com', 'Pending', '2024-03-06');

-- --------------------------------------------------------

--
-- Table structure for table `barangay_official`
--

CREATE TABLE `barangay_official` (
  `id` int(11) NOT NULL,
  `barangay_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `gender` enum('Male','Female','Prefer not to say') NOT NULL,
  `committee` varchar(255) NOT NULL,
  `barangay_position` varchar(255) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `session_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangay_official`
--

INSERT INTO `barangay_official` (`id`, `barangay_name`, `last_name`, `first_name`, `middle_name`, `contact_no`, `gender`, `committee`, `barangay_position`, `reg_date`, `session_id`) VALUES
(14, 'asdad', 'sdf', 'sdfsdfsd', 'fsdfs', '23423', 'Male', 'ssdfsd', 'sdfsdfsd', '2024-03-05 17:03:17', 'suinanlawrence5@gmail.com'),
(16, 'Bukal, Pila, Laguna', 'asd', 'asasa', 'sasdas', '42343242', 'Male', 'asedasda', 'sdasdasd', '2024-03-05 17:18:31', 'suinanlawrence5@gmail.com'),
(18, 'Bukal, Pila, Laguna', 'sheesh', 'asasa', 'sasdas', '2312312312', 'Female', 'asedasda', 'sdasdasd', '2024-03-06 00:59:48', 'suinanlawrence5@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `barangay_purok`
--

CREATE TABLE `barangay_purok` (
  `id` int(11) NOT NULL,
  `barangay_name` varchar(60) NOT NULL,
  `barangay_purok1` varchar(60) NOT NULL,
  `session_id` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangay_purok`
--

INSERT INTO `barangay_purok` (`id`, `barangay_name`, `barangay_purok1`, `session_id`) VALUES
(67, 'Bukal, Pila, Laguna', 'purok sampaguita', 'suinanlawrence5@gmail.com'),
(68, 'Bukal, Pila, Laguna', 'purok rosal', 'suinanlawrence5@gmail.com'),
(69, 'Bukal, Pila, Laguna', 'purok gumamela', 'suinanlawrence5@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `recent_activity`
--

CREATE TABLE `recent_activity` (
  `id` int(6) UNSIGNED NOT NULL,
  `barangay_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `marital_status` varchar(50) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `religion` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `osy` varchar(3) NOT NULL,
  `ws` varchar(3) NOT NULL,
  `yp` varchar(3) NOT NULL,
  `pwd` varchar(3) NOT NULL,
  `comittee` varchar(255) NOT NULL,
  `barangay_position` varchar(255) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `session_id` varchar(255) NOT NULL,
  `recent_act` varchar(255) NOT NULL,
  `barangay_purok_no` varchar(60) NOT NULL,
  `voters` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recent_activity`
--

INSERT INTO `recent_activity` (`id`, `barangay_name`, `last_name`, `first_name`, `middle_name`, `gender`, `marital_status`, `contact_no`, `religion`, `birthdate`, `osy`, `ws`, `yp`, `pwd`, `comittee`, `barangay_position`, `reg_date`, `session_id`, `recent_act`, `barangay_purok_no`, `voters`) VALUES
(17, 'Bukal, Pila, Laguna', 'asdsad', 'saadasd', '234', 'Female', 'Domestic Partnership/Civil Union', '12312312312312123', '3wdfsdfd', '2024-03-27', 'Yes', 'Yes', 'Yes', 'Yes', '', '', '2024-03-05 16:27:48', 'suinanlawrence5@gmail.com', 'asdsad,saadasd add record in Youth Resident', 'dsadsa', 'Yes'),
(18, 'Bukal, Pila, Laguna', 'xzxczxc', 'zxczxczxc', '23423', 'Male', 'Widowed', '32423423423423', 'efdghtrgdf', '2024-03-14', 'Yes', 'Yes', 'No', 'Yes', '', '', '2024-03-05 16:37:40', 'suinanlawrence5@gmail.com', 'xzxczxc,zxczxczxc add record in Youth Resident', 'dsadsa', 'No'),
(19, 'Bukal, Pila, Laguna', 'sdf', 'sdfsdfsd', 'fsdfs', 'Male', '', '23423', '', '0000-00-00', '', '', '', '', 'ssdfsd', 'sdfsdfsd', '2024-03-05 16:44:13', 'suinanlawrence5@gmail.com', 'sdf, sdfsdfsd added in Brgy.Official as sdfsdfsd', '', ''),
(20, 'Bukal, Pila, Laguna', 'asd', 'asasa', 'sasdas', 'Female', '', '2312312312', '', '0000-00-00', '', '', '', '', 'asedasda', 'sdasdasd', '2024-03-05 16:48:58', 'suinanlawrence5@gmail.com', 'asd, asasa added in Brgy.Official as sdasdasd', '', ''),
(21, 'Bukal, Pila, Laguna', 'asd', 'asasa', 'sasdas', 'Female', '', '2312312312', '', '0000-00-00', '', '', '', '', 'asedasda', 'sdasdasd', '2024-03-05 16:48:58', 'suinanlawrence5@gmail.com', 'asd, asasa added in Brgy.Official as sdasdasd', '', ''),
(22, 'Bukal, Pila, Laguna', 'asdjghas', 'jkasbdjkan', 'kasnd', 'Male', 'Married', '19615211561', 'wsda', '2024-03-22', 'Yes', 'Yes', 'Yes', 'Yes', '', '', '2024-03-06 00:35:23', 'suinanlawrence5@gmail.com', 'asdjghas,jkasbdjkan add record in Youth Resident', 'dsadsa', 'Yes'),
(23, 'Bukal, Pila, Laguna', 'Suinan', 'Vince Lawrence', 'B.', 'Male', 'Single', '09108029482', 'Muslim', '2024-03-15', 'Yes', 'No', 'Yes', 'Yes', '', '', '2024-03-06 01:06:20', 'suinanlawrence5@gmail.com', 'Suinan,Vince Lawrence add record in Youth Resident', 'purok sampaguita', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `youth_barangay`
--

CREATE TABLE `youth_barangay` (
  `id` int(6) UNSIGNED NOT NULL,
  `barangay_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `marital_status` varchar(50) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `religion` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `osy` varchar(3) NOT NULL,
  `ws` varchar(3) NOT NULL,
  `yp` varchar(3) NOT NULL,
  `pwd` varchar(3) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `session_id` varchar(255) NOT NULL,
  `barangay_purok_no` varchar(60) NOT NULL,
  `voters` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `youth_barangay`
--

INSERT INTO `youth_barangay` (`id`, `barangay_name`, `last_name`, `first_name`, `middle_name`, `gender`, `marital_status`, `contact_no`, `religion`, `birthdate`, `osy`, `ws`, `yp`, `pwd`, `reg_date`, `session_id`, `barangay_purok_no`, `voters`) VALUES
(42, '', 'lastname mo tooo', 'saadasd', '234', 'Female', 'Domestic Partnership', '12312312312312123', '3wdfsdfd', '2024-03-27', 'Yes', 'Yes', 'Yes', 'Yes', '2024-03-06 01:01:20', 'suinanlawrence5@gmail.com', '', ''),
(43, 'Bukal, Pila, Laguna', 'Suinan', 'Vince Lawrence', 'B.', 'Male', 'Single', '09108029482', 'Muslim', '2024-03-15', 'Yes', 'No', 'Yes', 'Yes', '2024-03-06 01:06:20', 'suinanlawrence5@gmail.com', 'purok sampaguita', 'Yes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_passcode`
--
ALTER TABLE `admin_passcode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `archived_official_records`
--
ALTER TABLE `archived_official_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `archived_youth_records`
--
ALTER TABLE `archived_youth_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barangay`
--
ALTER TABLE `barangay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barangay_official`
--
ALTER TABLE `barangay_official`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barangay_purok`
--
ALTER TABLE `barangay_purok`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recent_activity`
--
ALTER TABLE `recent_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `youth_barangay`
--
ALTER TABLE `youth_barangay`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_passcode`
--
ALTER TABLE `admin_passcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `archived_official_records`
--
ALTER TABLE `archived_official_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `archived_youth_records`
--
ALTER TABLE `archived_youth_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `barangay`
--
ALTER TABLE `barangay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `barangay_official`
--
ALTER TABLE `barangay_official`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `barangay_purok`
--
ALTER TABLE `barangay_purok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `recent_activity`
--
ALTER TABLE `recent_activity`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `youth_barangay`
--
ALTER TABLE `youth_barangay`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
