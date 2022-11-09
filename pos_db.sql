-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2018 at 04:21 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer_tb`
--

CREATE TABLE `customer_tb` (
  `customer_no` varchar(11) NOT NULL,
  `customer_lastname` varchar(30) NOT NULL,
  `customer_firstname` varchar(30) NOT NULL,
  `customer_middlename` varchar(30) NOT NULL,
  `customer_city` tinytext NOT NULL,
  `customer_barangay` tinytext NOT NULL,
  `customer_street` varchar(255) NOT NULL,
  `customer_date_added` date NOT NULL,
  `customer_status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_tb`
--

INSERT INTO `customer_tb` (`customer_no`, `customer_lastname`, `customer_firstname`, `customer_middlename`, `customer_city`, `customer_barangay`, `customer_street`, `customer_date_added`, `customer_status`) VALUES
('CT000000001', 'Walk', 'In', 'Customer', '--', '--', '', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `discount_tb`
--

CREATE TABLE `discount_tb` (
  `discount_code` varchar(11) NOT NULL,
  `discount_name` varchar(30) NOT NULL,
  `discounted_price` decimal(3,2) NOT NULL,
  `discount_status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `discount_tb`
--

INSERT INTO `discount_tb` (`discount_code`, `discount_name`, `discounted_price`, `discount_status`) VALUES
('NONE', 'NONE', '0.00', '');


-- --------------------------------------------------------

--
-- Table structure for table `hardware_tb`
--

CREATE TABLE `hardware_tb` (
  `hardware_code` varchar(3) NOT NULL,
  `hardware_name` varchar(30) NOT NULL,
  `hardware_address` text NOT NULL,
  `tax_rate` decimal(3,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hardware_tb`
--


-- --------------------------------------------------------

--
-- Table structure for table `invoice_rl`
--

CREATE TABLE `invoice_rl` (
  `transaction_no` varchar(11) NOT NULL,
  `barcode` varchar(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_product_price` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_rl`
--
-- --------------------------------------------------------

--
-- Table structure for table `product_tb`
--

CREATE TABLE `product_tb` (
  `barcode` varchar(11) NOT NULL,
  `product_category` tinytext NOT NULL,
  `product_name` text NOT NULL,
  `product_list_price` decimal(10,2) NOT NULL,
  `product_selling_price` decimal(10,2) NOT NULL,
  `product_status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_tb`
--

-- --------------------------------------------------------

--
-- Table structure for table `rl_address`
--

CREATE TABLE `rl_address` (
  `city_code` varchar(5) NOT NULL,
  `barangay_code` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_barangay`
--

CREATE TABLE `tb_barangay` (
  `barangay_code` varchar(5) NOT NULL,
  `barangay_name` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_barangay`
--

INSERT INTO `tb_barangay` (`barangay_code`, `barangay_name`) VALUES
('ABL', 'Abella'),
('CRL', 'Carolina'),
('PCL', 'Pacol'),
('PF', 'Penafrancia'),
('SF', 'San Felipe'),
('TNG', 'Tinago'),
('TGL', 'Triangulo'),
('ABL', 'Abella'),
('CRL', 'Carolina'),
('PCL', 'Pacol'),
('PF', 'Penafrancia'),
('SF', 'San Felipe'),
('TNG', 'Tinago'),
('TGL', 'Triangulo'),
('BN', 'Bagumbayan Norte'),
('BS', 'Bagumbayan SUr'),
('BLT', 'Balatas'),
('CLG', 'Calaug'),
('CRN', 'Cararayan'),
('CG', 'Concepcion Grande'),
('CP', 'Concepcion Pequena'),
('DYD', 'Dayagndang'),
('DR', 'Del Rosario'),
('DNG', 'Dinaga'),
('IGI', 'Igualdad Interior'),
('LRM', 'Lerma'),
('LBT', 'Liboton'),
('MBL', 'Mabolo'),
('PAN', 'Panicuason'),
('SB', 'Sabang'),
('SFC', 'San Fransico'),
('SID', 'San Isidro'),
('STC', 'Santa Cruz'),
('TBC', 'Tabuco');

-- --------------------------------------------------------

--
-- Table structure for table `tb_city`
--

CREATE TABLE `tb_city` (
  `city_code` varchar(5) NOT NULL,
  `city_name` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_city`
--

INSERT INTO `tb_city` (`city_code`, `city_name`) VALUES
('NC', 'Naga City');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_rl`
--

CREATE TABLE `transaction_rl` (
  `transaction_no` varchar(11) NOT NULL,
  `hardware_code` varchar(3) NOT NULL,
  `user_no` varchar(11) NOT NULL,
  `customer_no` varchar(11) NOT NULL,
  `discount_code` varchar(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `transaction_date` date NOT NULL,
  `transaction_status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction_rl`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_tb`
--

CREATE TABLE `user_tb` (
  `user_no` varchar(11) NOT NULL,
  `user_name` varchar(15) NOT NULL,
  `user_password` varchar(15) NOT NULL,
  `user_firstname` varchar(30) NOT NULL,
  `user_middlename` varchar(30) NOT NULL,
  `user_lastname` varchar(30) NOT NULL,
  `access_type` varchar(25) NOT NULL,
  `user_status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_tb`
--


--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer_tb`
--
ALTER TABLE `customer_tb`
  ADD PRIMARY KEY (`customer_no`);

--
-- Indexes for table `discount_tb`
--
ALTER TABLE `discount_tb`
  ADD PRIMARY KEY (`discount_code`);

--
-- Indexes for table `hardware_tb`
--
ALTER TABLE `hardware_tb`
  ADD PRIMARY KEY (`hardware_code`);

--
-- Indexes for table `invoice_rl`
--
ALTER TABLE `invoice_rl`
  ADD KEY `transaction_no` (`transaction_no`),
  ADD KEY `barcode` (`barcode`);

--
-- Indexes for table `product_tb`
--
ALTER TABLE `product_tb`
  ADD PRIMARY KEY (`barcode`);

--
-- Indexes for table `transaction_rl`
--
ALTER TABLE `transaction_rl`
  ADD PRIMARY KEY (`transaction_no`),
  ADD KEY `hardware_code` (`hardware_code`),
  ADD KEY `costumer_no` (`customer_no`),
  ADD KEY `user_no` (`user_no`),
  ADD KEY `discount_code` (`discount_code`);

--
-- Indexes for table `user_tb`
--
ALTER TABLE `user_tb`
  ADD PRIMARY KEY (`user_no`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice_rl`
--
ALTER TABLE `invoice_rl`
  ADD CONSTRAINT `invoice_rl_ibfk_1` FOREIGN KEY (`transaction_no`) REFERENCES `transaction_rl` (`transaction_no`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `invoice_rl_ibfk_2` FOREIGN KEY (`barcode`) REFERENCES `product_tb` (`barcode`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `transaction_rl`
--
ALTER TABLE `transaction_rl`
  ADD CONSTRAINT `transaction_rl_ibfk_2` FOREIGN KEY (`customer_no`) REFERENCES `customer_tb` (`customer_no`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `transaction_rl_ibfk_3` FOREIGN KEY (`hardware_code`) REFERENCES `hardware_tb` (`hardware_code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `transaction_rl_ibfk_4` FOREIGN KEY (`user_no`) REFERENCES `user_tb` (`user_no`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `transaction_rl_ibfk_5` FOREIGN KEY (`discount_code`) REFERENCES `discount_tb` (`discount_code`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
