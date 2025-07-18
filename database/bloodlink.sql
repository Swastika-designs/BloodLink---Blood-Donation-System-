-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 18, 2025 at 08:18 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bloodlink`
--

-- --------------------------------------------------------

--
-- Table structure for table `bloodstock`
--

CREATE TABLE `bloodstock` (
  `stock_id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `blood_type` varchar(5) NOT NULL,
  `quantity` int(11) NOT NULL CHECK (`quantity` >= 0),
  `expiry_date` date NOT NULL,
  `status` enum('Available','Reserved','Expired') NOT NULL DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bloodstock`
--

INSERT INTO `bloodstock` (`stock_id`, `bank_id`, `blood_type`, `quantity`, `expiry_date`, `status`) VALUES
(1, 1112, 'A+', 5, '2025-04-10', 'Available'),
(2, 1090, 'A-', 3, '2025-04-15', 'Available'),
(3, 123123, 'B+', 7, '2025-04-20', 'Available'),
(4, 1112, 'B-', 2, '2025-04-18', 'Reserved'),
(5, 1090, 'O+', 10, '2025-04-25', 'Available'),
(6, 123123, 'O-', 1, '2025-04-12', 'Expired'),
(7, 1112, 'AB+', 4, '2025-04-30', 'Available'),
(8, 1090, 'AB-', 3, '2025-04-28', 'Reserved'),
(9, 123123, 'A+', 6, '2025-04-22', 'Available'),
(10, 1112, 'O+', 8, '2025-04-14', 'Expired'),
(11, 1112, 'B+', 6, '2025-06-10', 'Available'),
(12, 1112, 'A-', 4, '2025-06-05', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `blood_bank`
--

CREATE TABLE `blood_bank` (
  `bank_id` int(11) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `bank_location` varchar(255) NOT NULL,
  `bank_email` varchar(255) NOT NULL,
  `bank_phone` varchar(15) NOT NULL,
  `bank_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_bank`
--

INSERT INTO `blood_bank` (`bank_id`, `bank_name`, `bank_location`, `bank_email`, `bank_phone`, `bank_password`) VALUES
(1011, 'Vital Blood Bank', 'New Delhi', 'vitalblood@example.com', '456-789-0123', 'password101'),
(1090, 'Pure Life', 'Delhi', 'purelife@gmail.com', '1212121212', '898989'),
(1112, 'Lifeline', 'Howrah', 'lifeline@gmail.com', '9088890888', '90909'),
(2022, 'Red Cross Blood Bank', 'Mumbai', 'redcrossblood@example.com', '567-890-1234', 'password202'),
(3033, 'Hope Blood Bank', 'Bangalore', 'hopeblood@example.com', '678-901-2345', 'password303'),
(4044, 'Sunshine Blood Bank', 'Chennai', 'sunshineblood@example.com', '789-012-3456', 'password404'),
(5055, 'Clearview Blood Bank', 'Hyderabad', 'clearviewblood@example.com', '890-123-4567', 'password505'),
(6066, 'Riverbank Blood Bank', 'Kolkata', 'riverbankblood@example.com', '901-234-5678', 'password606'),
(7077, 'Mountain Peak Blood Bank', 'Pune', 'mountainpeakblood@example.com', '012-345-6789', 'password707'),
(9090, 'Live & Laugh', 'Kattangulathur', 'l&l@gmail.com', '70000000007', '12345'),
(123123, 'Rotary C', 'Kattangulathur', 'rotaryC@gmail.com', '90000000009', '123'),
(123124, 'Neetu Foundations', 'Pune', 'neetufoundations@gmail.com', '3334533345', 'sheismymom');

-- --------------------------------------------------------

--
-- Table structure for table `blood_requests`
--

CREATE TABLE `blood_requests` (
  `request_id` int(11) NOT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `blood_group` varchar(5) NOT NULL,
  `quantity` int(11) NOT NULL,
  `request_date` datetime DEFAULT current_timestamp(),
  `status` enum('Pending','Approved','Rejected','Fulfilled') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_requests`
--

INSERT INTO `blood_requests` (`request_id`, `hospital_id`, `bank_id`, `blood_group`, `quantity`, `request_date`, `status`) VALUES
(1, 10, 1112, 'A-', 2, '2025-05-03 19:50:10', 'Approved'),
(2, 111, 1112, 'AB+', 3, '2025-05-03 21:48:00', 'Rejected'),
(3, 111, 123124, 'O+', 2, '2025-05-03 21:48:23', 'Pending'),
(4, 10, 123123, 'AB+', 6, '2025-05-04 20:50:16', 'Pending'),
(5, 100, 5055, 'B+', 9, '2025-05-31 20:48:25', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `donationevent`
--

CREATE TABLE `donationevent` (
  `Event_Id` int(11) NOT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `Event_Location` varchar(255) NOT NULL,
  `Event_Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donationevent`
--

INSERT INTO `donationevent` (`Event_Id`, `bank_id`, `Event_Location`, `Event_Date`) VALUES
(1004, 1011, 'Chennai', '2025-08-10'),
(99, 1090, 'Agra', '2025-04-03'),
(1002, 1090, 'Mumbai', '2025-06-15'),
(100, 1090, 'Saket', '2025-04-10'),
(223, 1112, 'Ichapur', '2025-04-30'),
(33333333, 1112, 'Ichapur', '2025-08-12'),
(222, 1112, 'Kadamtala', '2025-04-15'),
(99999, 1112, 'Kadamtala', '2025-05-30'),
(1001, 1112, 'New Delhi', '2025-05-01'),
(1119, 1112, 'Pune', '2025-05-22'),
(1005, 2022, 'Hyderabad', '2025-09-25'),
(1006, 3033, 'Kolkata', '2025-10-05'),
(1, 9090, 'Chengalpattu', '2025-05-04'),
(1003, 123123, 'Bangalore', '2025-07-20'),
(123, 123123, 'Chengalpattu', '2025-03-15'),
(111, 123124, 'Pune', '2025-05-04');

-- --------------------------------------------------------

--
-- Table structure for table `donationrecord`
--

CREATE TABLE `donationrecord` (
  `Record_Id` int(11) NOT NULL,
  `Event_Id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `Donation_Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donationrecord`
--

INSERT INTO `donationrecord` (`Record_Id`, `Event_Id`, `donor_id`, `Donation_Date`) VALUES
(1, 222, 3, '2025-03-31'),
(2, 223, 3, '2025-03-31'),
(3, 99, 5, '2025-03-31'),
(4, 222, 5, '2025-03-31'),
(5, 100, 6, '2025-03-31'),
(20, 1004, 2, '2025-08-10'),
(21, 99, 3, '2025-04-03'),
(22, 1002, 4, '2025-06-15'),
(23, 100, 5, '2025-04-10'),
(24, 223, 6, '2025-04-30'),
(25, 222, 7, '2025-04-15'),
(26, 1001, 8, '2025-05-01'),
(27, 1001, 5, '2025-05-01'),
(28, 1001, 5, '2025-05-03'),
(29, 1001, 5, '2025-05-03'),
(30, 1002, 14, '2025-05-03'),
(31, 1002, 15, '2025-05-03'),
(32, 1003, 15, '2025-05-03'),
(33, 1119, 2, '2025-05-05'),
(34, 1002, 2, '2025-05-31');

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

CREATE TABLE `donor` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `blood_group` enum('A','B','AB','O') NOT NULL,
  `rh_factor` enum('+','-') NOT NULL,
  `location` varchar(255) NOT NULL,
  `last_donation` date DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donor`
--

INSERT INTO `donor` (`id`, `name`, `email`, `phone`, `blood_group`, `rh_factor`, `location`, `last_donation`, `password`) VALUES
(2, 'Swastika Chowdhury', 'sc@gmail.com', '8910069849', 'A', '-', 'Kattankulathur', '2024-10-24', '1234'),
(3, 'Parakh Singh', 'parakh@gmail.com', '1111111111', 'B', '-', 'Pune', '2024-09-05', '1234'),
(4, 'Sagnika', 'sagnika@gmail.com', '9090909090', 'O', '+', 'Howrah', '2024-11-21', '1234'),
(5, 'Anahita Shrestha', 'ashre@gmail.com', '1111111112', 'AB', '+', 'Pune', '2024-11-01', '987'),
(6, 'Vishali', 'vishali@gmail.com', '7878787878', 'AB', '+', 'Visakhapatnam', '2024-09-05', '567'),
(7, 'John Doe', 'john.doe@example.com', '9876543210', 'A', '+', 'Delhi', '2025-04-01', 'password123'),
(8, 'Jane Smith', 'jane.smith@example.com', '9876543211', 'B', '-', 'Mumbai', '2025-03-15', 'password123'),
(9, 'Robert Brown', 'robert.brown@example.com', '9876543212', 'O', '+', 'Bangalore', '2025-02-28', 'password123'),
(10, 'Emily Davis', 'emily.davis@example.com', '9876543213', 'AB', '-', 'Chennai', '2025-01-10', 'password123'),
(11, 'Michael Wilson', 'michael.wilson@example.com', '9876543214', 'A', '-', 'Hyderabad', '2025-02-20', 'password123'),
(12, 'Sarah Taylor', 'sarah.taylor@example.com', '9876543215', 'B', '+', 'Kolkata', '2025-03-10', 'password123'),
(13, 'David Anderson', 'david.anderson@example.com', '9876543216', 'O', '-', 'Pune', '2025-04-05', 'password123'),
(14, 'Chirag', 'ck@gmail.com', '9990090909', 'O', '+', 'Kattankulathur', '2024-11-29', '12345'),
(15, 'Anaya Shrestha Mehta', 'anaya32@gmail.com', '9999112222', 'A', '+', 'Pune', '2025-02-24', 'ilovemymom');

-- --------------------------------------------------------

--
-- Table structure for table `hospital`
--

CREATE TABLE `hospital` (
  `hospital_id` int(11) NOT NULL,
  `hospital_name` varchar(255) NOT NULL,
  `hospital_email` varchar(255) NOT NULL,
  `hospital_phone` varchar(15) NOT NULL,
  `hospital_location` varchar(255) NOT NULL,
  `hospital_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospital`
--

INSERT INTO `hospital` (`hospital_id`, `hospital_name`, `hospital_email`, `hospital_phone`, `hospital_location`, `hospital_password`) VALUES
(1, 'City Hospital', 'contact@cityhospital.com', '9876543210', 'Mumbai', 'password123'),
(2, 'Sunrise Hospital', 'info@sunrisehospital.com', '9765432109', 'Delhi', 'password123'),
(3, 'Green Valley Hospital', 'hello@greenvalleyhospital.com', '9654321098', 'Bangalore', 'password123'),
(4, 'Riverbank Hospital', 'support@riverbankhospital.com', '9543210987', 'Chennai', 'password123'),
(5, 'Healing Touch Hospital', 'contact@healingtouchhospital.com', '9432109876', 'Hyderabad', 'password123'),
(6, 'Starlight Hospital', 'info@starlighthospital.com', '9321098765', 'Kolkata', 'password123'),
(7, 'Mountainview Hospital', 'support@mountainviewhospital.com', '9210987654', 'Pune', 'password123'),
(10, 'Saveetha ', 'saveetha@gmail.com', '1111111111', 'Thandalam', '99999'),
(100, 'SRM', 'srmhos@gmail.com', '6767676767', 'Kattangulathur', '123'),
(111, 'MediCare', 'medicare@gmail.com', '9655596555', 'Chennai', 'medicare'),
(123, 'Apollo', 'apollo@gmail.com', '1234512345', 'Maramalai Nagar', '321');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bloodstock`
--
ALTER TABLE `bloodstock`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `bank_id` (`bank_id`);

--
-- Indexes for table `blood_bank`
--
ALTER TABLE `blood_bank`
  ADD PRIMARY KEY (`bank_id`) USING BTREE,
  ADD UNIQUE KEY `bank_email` (`bank_email`);

--
-- Indexes for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `hospital_id` (`hospital_id`),
  ADD KEY `bank_id` (`bank_id`);

--
-- Indexes for table `donationevent`
--
ALTER TABLE `donationevent`
  ADD PRIMARY KEY (`Event_Id`),
  ADD UNIQUE KEY `bank_id` (`bank_id`,`Event_Location`,`Event_Date`);

--
-- Indexes for table `donationrecord`
--
ALTER TABLE `donationrecord`
  ADD PRIMARY KEY (`Record_Id`),
  ADD KEY `Event_Id` (`Event_Id`),
  ADD KEY `donor_id` (`donor_id`);

--
-- Indexes for table `donor`
--
ALTER TABLE `donor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `hospital`
--
ALTER TABLE `hospital`
  ADD PRIMARY KEY (`hospital_id`),
  ADD UNIQUE KEY `hospital_email` (`hospital_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bloodstock`
--
ALTER TABLE `bloodstock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `blood_requests`
--
ALTER TABLE `blood_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `donationrecord`
--
ALTER TABLE `donationrecord`
  MODIFY `Record_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `donor`
--
ALTER TABLE `donor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bloodstock`
--
ALTER TABLE `bloodstock`
  ADD CONSTRAINT `bloodstock_ibfk_1` FOREIGN KEY (`bank_id`) REFERENCES `blood_bank` (`bank_id`) ON DELETE CASCADE;

--
-- Constraints for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD CONSTRAINT `blood_requests_ibfk_1` FOREIGN KEY (`hospital_id`) REFERENCES `hospital` (`hospital_id`),
  ADD CONSTRAINT `blood_requests_ibfk_2` FOREIGN KEY (`bank_id`) REFERENCES `blood_bank` (`bank_id`);

--
-- Constraints for table `donationevent`
--
ALTER TABLE `donationevent`
  ADD CONSTRAINT `donationevent_ibfk_1` FOREIGN KEY (`bank_id`) REFERENCES `blood_bank` (`bank_id`) ON DELETE CASCADE;

--
-- Constraints for table `donationrecord`
--
ALTER TABLE `donationrecord`
  ADD CONSTRAINT `donationrecord_ibfk_1` FOREIGN KEY (`Event_Id`) REFERENCES `donationevent` (`Event_Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `donationrecord_ibfk_2` FOREIGN KEY (`donor_id`) REFERENCES `donor` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
