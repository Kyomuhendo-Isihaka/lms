-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 06, 2023 at 03:07 PM
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
-- Database: `lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `accountant`
--

CREATE TABLE `accountant` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `phone` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` text NOT NULL DEFAULT 'accountant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accountant`
--

INSERT INTO `accountant` (`id`, `firstname`, `lastname`, `phone`, `email`, `password`, `role`) VALUES
(1, 'Okumu', 'Emanuel', '+256778237748', 'emma@gmail.com', '$2y$10$uJ0DzZIoBxZB7qtS4AMcu.PM1AbQDsBUUJLvQXG05JWcENhYU45gG', 'accountant');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` text NOT NULL DEFAULT 'employee',
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `firstname`, `lastname`, `phone`, `email`, `role`, `password`) VALUES
(1, 'Emma', 'Ema', '0778237748', 'emma@gmail.com', 'employee', '$2y$10$CHpihuefdBQj/bbOFHpDK.UeU26.2Az85BwBDaN4ZHq74yImjSKp.');

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `loan_typeId` int(11) NOT NULL,
  `applicant_fname` varchar(100) NOT NULL,
  `applicant_lname` varchar(100) NOT NULL,
  `applicant_nin` text NOT NULL,
  `applicant_phone` text NOT NULL,
  `applicant_email` varchar(100) NOT NULL,
  `loan_amount` float NOT NULL,
  `loan_period` text NOT NULL,
  `intrest_amout` float NOT NULL,
  `paid_amount` int(11) NOT NULL,
  `bank_statment` varchar(255) NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loan`
--

INSERT INTO `loan` (`id`, `user_id`, `loan_typeId`, `applicant_fname`, `applicant_lname`, `applicant_nin`, `applicant_phone`, `applicant_email`, `loan_amount`, `loan_period`, `intrest_amout`, `paid_amount`, `bank_statment`, `status`) VALUES
(10, 8, 2, 'Emma', 'Emma', 'i8383893982388', '+256778237748', 'emma@gmail.com', 1000000, '6', 25000, 1025000, 'Budget.docx', '-1'),
(13, 8, 1, 'Emma', 'Emma', '1222324445', '+256778237748', 'emma@gmail.com', 90000, '6', 2250, 92250, 'dmsReport.docx', '-1'),
(14, 8, 5, 'victoria', 'Muwanguzi', 'i8383893982388', '+256778237748', 'victoriamuwanguzi19@gmail', 1000000, '12', 50000, 20000, 'PDF Scan 08-10-2023 13.19.pdf', '1');

-- --------------------------------------------------------

--
-- Table structure for table `loan_type`
--

CREATE TABLE `loan_type` (
  `id` int(11) NOT NULL,
  `type_name` varchar(100) NOT NULL,
  `loan_description` text NOT NULL,
  `interest_rate` float NOT NULL,
  `max_loan_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loan_type`
--

INSERT INTO `loan_type` (`id`, `type_name`, `loan_description`, `interest_rate`, `max_loan_amount`) VALUES
(1, 'Share Based loan', 'share based loans', 0.05, 100000),
(2, 'Savings Based loan', ' Loans provided to businesses for various purposes, such as startup capital, expansion, working capital, or equipment purchases.Business loans can be secured or unsecured and come in various forms, including term loans, lines of credit, and SBA loans (Small Business Administration loans)', 0.15, 2000000),
(4, 'Emergency Loan', 'Emergency loan', 0.03, 100000);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `user_id` text NOT NULL,
  `payment_amount` float NOT NULL,
  `payment_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `loan_id`, `user_id`, `payment_amount`, `payment_date`) VALUES
(17, 10, '8', 1025000, '2023-09-24'),
(18, 13, '8', 1000, '2023-09-25'),
(19, 13, '8', 10000, '2023-09-28'),
(20, 14, '8', 10000, '2023-10-14'),
(21, 14, '8', 10000, '2023-10-22'),
(22, 13, '8', 81250, '2023-10-25'),
(23, 13, '8', 81250, '2023-10-25');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `gender` text NOT NULL,
  `date_of_birth` date NOT NULL,
  `force_number` varchar(100) NOT NULL,
  `rank` text NOT NULL,
  `nin_num` text NOT NULL,
  `phone` varchar(45) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `user_info` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` text NOT NULL,
  `date_registered` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `gender`, `date_of_birth`, `force_number`, `rank`, `nin_num`, `phone`, `email`, `address`, `user_info`, `password`, `status`, `date_registered`) VALUES
(8, 'Emma', 'Emma', 'Male', '1994-07-23', '64', 'DCGP', 'i8383893982388', '+256778237748', 'emma@gmail.com', 'gulu', 'it me', '$2y$10$x7YaIQDpY9h8Yzhfbdd3c.CYW7k2Pa/lNmEOe3jav0Jwou2AGI15W', '0', '2023-09-22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountant`
--
ALTER TABLE `accountant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_type`
--
ALTER TABLE `loan_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accountant`
--
ALTER TABLE `accountant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `loan_type`
--
ALTER TABLE `loan_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
