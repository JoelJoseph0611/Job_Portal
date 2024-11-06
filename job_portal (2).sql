-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2024 at 06:10 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `job_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'joel', 'joeljoseph.mail@gmail.com', '1234', '2024-10-21 17:32:59');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `applied_date` datetime DEFAULT current_timestamp(),
  `resume` longblob DEFAULT NULL,
  `resume_name` varchar(255) DEFAULT NULL,
  `resume_mime_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `company_name`, `email`, `password`, `created_at`) VALUES
(1, 'TechInno', 'contact@techinno.com', '1234', '2024-10-22 13:22:39'),
(2, 'GreenSol', 'info@greensol.com', '1234', '2024-10-22 13:22:39'),
(3, 'GlobalVent', 'support@globalvent.com', '1234', '2024-10-22 13:22:39'),
(4, 'NextGenMkt', 'hello@nextgenmkt.com', '1234', '2024-10-22 13:22:39'),
(5, 'EcoBuild', 'contact@ecobuild.com', '1234', '2024-10-22 13:22:39'),
(6, 'SwiftLog', 'info@swiftlog.com', '1234', '2024-10-22 13:22:39'),
(7, 'DigHorizons', 'support@dighorizons.com', '1234', '2024-10-22 13:22:39'),
(8, 'FutureFin', 'info@futurefin.com', '1234', '2024-10-22 13:22:39'),
(9, 'HealthPlus', 'contact@healthplus.com', '1234', '2024-10-22 13:22:39'),
(10, 'SmartHome', 'info@smarthome.com', '1234', '2024-10-22 13:22:39');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL,
  `job_type` enum('Part-time','Full-time') NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `location` varchar(100) NOT NULL,
  `age_category` varchar(20) DEFAULT NULL,
  `gender_preference` enum('Boy','Girl','Any') DEFAULT 'Any',
  `posted_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `company_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `company`, `job_type`, `salary`, `location`, `age_category`, `gender_preference`, `posted_date`, `company_id`) VALUES
(12, 'Software Engineer', 'TechInno', 'Full-time', 85000.00, 'San Francisco', 'Adult', 'Any', '2024-10-19 18:30:00', 1),
(13, 'Data Analyst', 'TechInno', 'Full-time', 75000.00, 'New York', 'Adult', 'Any', '2024-10-20 18:30:00', 1),
(14, 'UI/UX Designer', 'TechInno', 'Full-time', 70000.00, 'Los Angeles', 'Adult', 'Any', '2024-10-21 18:30:00', 1),
(15, 'DevOps Engineer', 'TechInno', 'Full-time', 95000.00, 'San Francisco', 'Adult', 'Any', '2024-10-22 18:30:00', 1),
(16, 'Backend Developer', 'TechInno', 'Part-time', 65000.00, 'Austin', 'Adult', 'Any', '2024-10-23 18:30:00', 1),
(17, 'Cloud Engineer', 'TechInno', 'Full-time', 105000.00, 'Seattle', 'Adult', 'Any', '2024-10-24 18:30:00', 1),
(18, 'Cybersecurity Analyst', 'TechInno', '', 90000.00, 'Washington, D.C.', 'Adult', 'Any', '2024-10-25 18:30:00', 1),
(19, 'Mobile App Developer', 'TechInno', 'Full-time', 80000.00, 'San Diego', 'Adult', 'Any', '2024-10-26 18:30:00', 1),
(20, 'QA Engineer', 'TechInno', 'Full-time', 70000.00, 'New York', 'Adult', 'Any', '2024-10-27 18:30:00', 1),
(21, 'Tech Support Specialist', 'TechInno', 'Part-time', 60000.00, 'San Francisco', 'Adult', 'Any', '2024-10-28 18:30:00', 1),
(22, 'Environmental Engineer', 'GreenSol', 'Full-time', 80000.00, 'Denver', 'Adult', 'Any', '2024-10-19 18:30:00', 2),
(23, 'Sustainability Consultant', 'GreenSol', '', 65000.00, 'Portland', 'Adult', 'Any', '2024-10-20 18:30:00', 2),
(24, 'Solar Panel Technician', 'GreenSol', 'Full-time', 50000.00, 'Phoenix', 'Adult', 'Any', '2024-10-21 18:30:00', 2),
(25, 'Energy Analyst', 'GreenSol', 'Full-time', 75000.00, 'New York', 'Adult', 'Any', '2024-10-22 18:30:00', 2),
(26, 'Eco Architect', 'GreenSol', 'Full-time', 90000.00, 'San Francisco', 'Adult', 'Any', '2024-10-23 18:30:00', 2),
(27, 'Waste Management Specialist', 'GreenSol', 'Full-time', 60000.00, 'Chicago', 'Adult', 'Any', '2024-10-24 18:30:00', 2),
(28, 'Climate Change Analyst', 'GreenSol', 'Part-time', 70000.00, 'Miami', 'Adult', 'Any', '2024-10-25 18:30:00', 2),
(29, 'Sustainable Project Manager', 'GreenSol', 'Full-time', 85000.00, 'Austin', 'Adult', 'Any', '2024-10-26 18:30:00', 2),
(30, 'Recycling Program Manager', 'GreenSol', 'Full-time', 55000.00, 'Los Angeles', 'Adult', 'Any', '2024-10-27 18:30:00', 2),
(31, 'Water Resource Engineer', 'GreenSol', 'Full-time', 78000.00, 'Houston', 'Adult', 'Any', '2024-10-28 18:30:00', 2),
(32, 'Marketing Manager', 'GlobalVent', 'Full-time', 85000.00, 'Chicago', 'Adult', 'Any', '2024-10-19 18:30:00', 3),
(33, 'Brand Strategist', 'GlobalVent', 'Full-time', 75000.00, 'New York', 'Adult', 'Any', '2024-10-20 18:30:00', 3),
(34, 'SEO Specialist', 'GlobalVent', '', 60000.00, 'San Francisco', 'Adult', 'Any', '2024-10-21 18:30:00', 3),
(35, 'Digital Marketing Analyst', 'GlobalVent', 'Full-time', 70000.00, 'Los Angeles', 'Adult', 'Any', '2024-10-22 18:30:00', 3),
(36, 'Content Creator', 'GlobalVent', 'Part-time', 55000.00, 'Austin', 'Adult', 'Any', '2024-10-23 18:30:00', 3),
(37, 'Social Media Manager', 'GlobalVent', 'Full-time', 75000.00, 'Miami', 'Adult', 'Any', '2024-10-24 18:30:00', 3),
(38, 'Public Relations Specialist', 'GlobalVent', 'Full-time', 68000.00, 'Washington, D.C.', 'Adult', 'Any', '2024-10-25 18:30:00', 3),
(39, 'PPC Campaign Manager', 'GlobalVent', 'Full-time', 73000.00, 'New York', 'Adult', 'Any', '2024-10-26 18:30:00', 3),
(40, 'Marketing Analyst', 'GlobalVent', 'Full-time', 69000.00, 'San Diego', 'Adult', 'Any', '2024-10-27 18:30:00', 3),
(41, 'Email Marketing Specialist', 'GlobalVent', 'Full-time', 61000.00, 'Denver', 'Adult', 'Any', '2024-10-28 18:30:00', 3),
(42, 'Business Analyst', 'NextGenMkt', 'Full-time', 80000.00, 'San Francisco', 'Adult', 'Any', '2024-10-19 18:30:00', 4),
(43, 'Financial Analyst', 'NextGenMkt', 'Full-time', 85000.00, 'New York', 'Adult', 'Any', '2024-10-20 18:30:00', 4),
(44, 'Investment Manager', 'NextGenMkt', 'Full-time', 95000.00, 'Chicago', 'Adult', 'Any', '2024-10-21 18:30:00', 4),
(45, 'Portfolio Analyst', 'NextGenMkt', 'Full-time', 78000.00, 'Los Angeles', 'Adult', 'Any', '2024-10-22 18:30:00', 4),
(46, 'Risk Manager', 'NextGenMkt', 'Full-time', 90000.00, 'San Francisco', 'Adult', 'Any', '2024-10-23 18:30:00', 4),
(47, 'Accountant', 'NextGenMkt', 'Part-time', 70000.00, 'Austin', 'Adult', 'Any', '2024-10-24 18:30:00', 4),
(48, 'Compliance Officer', 'NextGenMkt', 'Full-time', 93000.00, 'Washington, D.C.', 'Adult', 'Any', '2024-10-25 18:30:00', 4),
(49, 'Treasury Analyst', 'NextGenMkt', 'Full-time', 87000.00, 'New York', 'Adult', 'Any', '2024-10-26 18:30:00', 4),
(50, 'Insurance Underwriter', 'NextGenMkt', 'Full-time', 74000.00, 'Miami', 'Adult', 'Any', '2024-10-27 18:30:00', 4),
(51, 'Asset Manager', 'NextGenMkt', 'Full-time', 89000.00, 'San Diego', 'Adult', 'Any', '2024-10-28 18:30:00', 4),
(52, 'Civil Engineer', 'EcoBuild', 'Full-time', 85000.00, 'San Francisco', 'Adult', 'Any', '2024-10-19 18:30:00', 5),
(53, 'Construction Manager', 'EcoBuild', 'Full-time', 95000.00, 'New York', 'Adult', 'Any', '2024-10-20 18:30:00', 5),
(54, 'Architect', 'EcoBuild', 'Full-time', 90000.00, 'Los Angeles', 'Adult', 'Any', '2024-10-21 18:30:00', 5),
(55, 'Project Manager', 'EcoBuild', 'Full-time', 92000.00, 'Austin', 'Adult', 'Any', '2024-10-22 18:30:00', 5),
(56, 'Structural Engineer', 'EcoBuild', 'Full-time', 88000.00, 'Miami', 'Adult', 'Any', '2024-10-23 18:30:00', 5),
(57, 'Surveyor', 'EcoBuild', 'Part-time', 70000.00, 'Chicago', 'Adult', 'Any', '2024-10-24 18:30:00', 5),
(58, 'Urban Planner', 'EcoBuild', 'Full-time', 85000.00, 'Washington, D.C.', 'Adult', 'Any', '2024-10-25 18:30:00', 5),
(59, 'Interior Designer', 'EcoBuild', 'Full-time', 78000.00, 'San Diego', 'Adult', 'Any', '2024-10-26 18:30:00', 5),
(60, 'Electrical Engineer', 'EcoBuild', 'Full-time', 92000.00, 'New York', 'Adult', 'Any', '2024-10-27 18:30:00', 5),
(61, 'Mechanical Engineer', 'EcoBuild', 'Full-time', 94000.00, 'San Francisco', 'Adult', 'Any', '2024-10-28 18:30:00', 5),
(62, 'Logistics Manager', 'SwiftLog', 'Full-time', 75000.00, 'Houston', 'Adult', 'Any', '2024-10-19 18:30:00', 6),
(63, 'Supply Chain Analyst', 'SwiftLog', 'Full-time', 67000.00, 'Miami', 'Adult', 'Any', '2024-10-20 18:30:00', 6),
(64, 'Warehouse Supervisor', 'SwiftLog', 'Full-time', 55000.00, 'Dallas', 'Adult', 'Any', '2024-10-21 18:30:00', 6),
(65, 'Transportation Coordinator', 'SwiftLog', 'Full-time', 60000.00, 'San Francisco', 'Adult', 'Any', '2024-10-22 18:30:00', 6),
(66, 'Inventory Manager', 'SwiftLog', 'Full-time', 72000.00, 'New York', 'Adult', 'Any', '2024-10-23 18:30:00', 6),
(67, 'Operations Manager', 'SwiftLog', 'Full-time', 85000.00, 'Los Angeles', 'Adult', 'Any', '2024-10-24 18:30:00', 6),
(68, 'Fleet Manager', 'SwiftLog', 'Full-time', 68000.00, 'Chicago', 'Adult', 'Any', '2024-10-25 18:30:00', 6),
(69, 'Procurement Specialist', 'SwiftLog', 'Full-time', 71000.00, 'Austin', 'Adult', 'Any', '2024-10-26 18:30:00', 6),
(70, 'Logistics Coordinator', 'SwiftLog', 'Part-time', 52000.00, 'Denver', 'Adult', 'Any', '2024-10-27 18:30:00', 6),
(71, 'Export Coordinator', 'SwiftLog', 'Full-time', 60000.00, 'Portland', 'Adult', 'Any', '2024-10-28 18:30:00', 6),
(72, 'Digital Strategist', 'DigHorizons', 'Full-time', 80000.00, 'Los Angeles', 'Adult', 'Any', '2024-10-19 18:30:00', 7),
(73, 'SEO Consultant', 'DigHorizons', 'Part-time', 60000.00, 'New York', 'Adult', 'Any', '2024-10-20 18:30:00', 7),
(74, 'Content Manager', 'DigHorizons', 'Full-time', 75000.00, 'Austin', 'Adult', 'Any', '2024-10-21 18:30:00', 7),
(75, 'PPC Specialist', 'DigHorizons', 'Full-time', 70000.00, 'San Francisco', 'Adult', 'Any', '2024-10-22 18:30:00', 7),
(76, 'Web Developer', 'DigHorizons', 'Full-time', 90000.00, 'Chicago', 'Adult', 'Any', '2024-10-23 18:30:00', 7),
(77, 'Social Media Coordinator', 'DigHorizons', 'Full-time', 65000.00, 'Miami', 'Adult', 'Any', '2024-10-24 18:30:00', 7),
(78, 'Graphic Designer', 'DigHorizons', 'Part-time', 50000.00, 'Dallas', 'Adult', 'Any', '2024-10-25 18:30:00', 7),
(79, 'Email Marketing Manager', 'DigHorizons', 'Full-time', 72000.00, 'Houston', 'Adult', 'Any', '2024-10-26 18:30:00', 7),
(80, 'E-commerce Manager', 'DigHorizons', 'Full-time', 85000.00, 'Denver', 'Adult', 'Any', '2024-10-27 18:30:00', 7),
(81, 'CRM Specialist', 'DigHorizons', 'Full-time', 69000.00, 'New York', 'Adult', 'Any', '2024-10-28 18:30:00', 7),
(82, 'Financial Advisor', 'FutureFin', 'Full-time', 90000.00, 'New York', 'Adult', 'Any', '2024-10-19 18:30:00', 8),
(83, 'Investment Banker', 'FutureFin', 'Full-time', 105000.00, 'Chicago', 'Adult', 'Any', '2024-10-20 18:30:00', 8),
(84, 'Credit Analyst', 'FutureFin', 'Full-time', 80000.00, 'Miami', 'Adult', 'Any', '2024-10-21 18:30:00', 8),
(85, 'Risk Analyst', 'FutureFin', 'Full-time', 85000.00, 'Los Angeles', 'Adult', 'Any', '2024-10-22 18:30:00', 8),
(86, 'Accountant', 'FutureFin', 'Full-time', 75000.00, 'San Francisco', 'Adult', 'Any', '2024-10-23 18:30:00', 8),
(87, 'Loan Officer', 'FutureFin', 'Full-time', 70000.00, 'Houston', 'Adult', 'Any', '2024-10-24 18:30:00', 8),
(88, 'Financial Planner', 'FutureFin', 'Full-time', 90000.00, 'Dallas', 'Adult', 'Any', '2024-10-25 18:30:00', 8),
(89, 'Private Equity Analyst', 'FutureFin', 'Full-time', 100000.00, 'Washington, D.C.', 'Adult', 'Any', '2024-10-26 18:30:00', 8),
(90, 'Compliance Specialist', 'FutureFin', 'Full-time', 85000.00, 'Austin', 'Adult', 'Any', '2024-10-27 18:30:00', 8),
(91, 'Tax Advisor', 'FutureFin', 'Part-time', 65000.00, 'Denver', 'Adult', 'Any', '2024-10-28 18:30:00', 8),
(92, 'Registered Nurse', 'HealthPlus', 'Full-time', 70000.00, 'New York', 'Adult', 'Any', '2024-10-19 18:30:00', 9),
(93, 'Physician Assistant', 'HealthPlus', 'Full-time', 95000.00, 'Los Angeles', 'Adult', 'Any', '2024-10-20 18:30:00', 9),
(94, 'Physical Therapist', 'HealthPlus', 'Full-time', 85000.00, 'Chicago', 'Adult', 'Any', '2024-10-21 18:30:00', 9),
(95, 'Medical Coder', 'HealthPlus', 'Full-time', 65000.00, 'Miami', 'Adult', 'Any', '2024-10-22 18:30:00', 9),
(96, 'Health Data Analyst', 'HealthPlus', 'Full-time', 78000.00, 'Austin', 'Adult', 'Any', '2024-10-23 18:30:00', 9),
(97, 'Medical Receptionist', 'HealthPlus', 'Part-time', 40000.00, 'San Francisco', 'Adult', 'Any', '2024-10-24 18:30:00', 9),
(98, 'Occupational Therapist', 'HealthPlus', 'Full-time', 83000.00, 'Houston', 'Adult', 'Any', '2024-10-25 18:30:00', 9),
(99, 'Clinical Research Coordinator', 'HealthPlus', 'Full-time', 88000.00, 'Washington, D.C.', 'Adult', 'Any', '2024-10-26 18:30:00', 9),
(100, 'Pharmacy Technician', 'HealthPlus', 'Part-time', 50000.00, 'New York', 'Adult', 'Any', '2024-10-27 18:30:00', 9),
(101, 'Medical Lab Technician', 'HealthPlus', 'Full-time', 60000.00, 'Denver', 'Adult', 'Any', '2024-10-28 18:30:00', 9),
(102, 'Home Automation Engineer', 'SmartHome', 'Full-time', 85000.00, 'Los Angeles', 'Adult', 'Any', '2024-10-19 18:30:00', 10),
(103, 'IoT Specialist', 'SmartHome', 'Full-time', 90000.00, 'San Francisco', 'Adult', 'Any', '2024-10-20 18:30:00', 10),
(104, 'Smart Device Technician', 'SmartHome', 'Part-time', 55000.00, 'Austin', 'Adult', 'Any', '2024-10-21 18:30:00', 10),
(105, 'Home Security Consultant', 'SmartHome', 'Full-time', 70000.00, 'Chicago', 'Adult', 'Any', '2024-10-22 18:30:00', 10),
(106, 'Automation Installer', 'SmartHome', 'Full-time', 65000.00, 'Miami', 'Adult', 'Any', '2024-10-23 18:30:00', 10),
(107, 'Network Technician', 'SmartHome', 'Full-time', 72000.00, 'Houston', 'Adult', 'Any', '2024-10-24 18:30:00', 10),
(108, 'SmartHome Product Manager', 'SmartHome', 'Full-time', 95000.00, 'New York', 'Adult', 'Any', '2024-10-25 18:30:00', 10),
(109, 'Voice Assistant Developer', 'SmartHome', 'Full-time', 87000.00, 'San Diego', 'Adult', 'Any', '2024-10-26 18:30:00', 10),
(110, 'Home Energy Consultant', 'SmartHome', 'Full-time', 78000.00, 'Denver', 'Adult', 'Any', '2024-10-27 18:30:00', 10),
(111, 'Smart Lighting Engineer', 'SmartHome', 'Full-time', 82000.00, 'Dallas', 'Adult', 'Any', '2024-10-28 18:30:00', 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `name`) VALUES
(1, 'joel', '$2y$10$0L7VQNIHFq5mkAk9m4KJleP1y4O5SKlRpKvSO.BIUfRdSMGzzXG/S', 'joeljoseph0611@gmail.com', 'joel'),
(2, 'karthika', '$2y$10$0L7VQNIHFq5mkAk9m4KJleP1y4O5SKlRpKvSO.BIUfRdSMGzzXG/S', 'karthika@gmail.com', 'karthika'),
(3, 'gowri', '$2y$10$0L7VQNIHFq5mkAk9m4KJleP1y4O5SKlRpKvSO.BIUfRdSMGzzXG/S', 'gowri@gmail.com', 'gowri'),
(4, 'saniya', '$2y$10$0L7VQNIHFq5mkAk9m4KJleP1y4O5SKlRpKvSO.BIUfRdSMGzzXG/S', 'saniya@gmail.com', 'saniya'),
(5, 'sdc', '$2y$10$.A7FiwXQMsI7Ez3h7SABs.0YPjtksV/m.6Pel7a7VP8Ei55DvAhI2', 'cx@gmail.com', 'sdc');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_name` (`company_name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`),
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
