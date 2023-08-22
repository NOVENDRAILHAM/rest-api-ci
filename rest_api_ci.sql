-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 22, 2023 at 06:16 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rest_api_ci`
--

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

DROP TABLE IF EXISTS `materials`;
CREATE TABLE IF NOT EXISTS `materials` (
  `material_code` varchar(10) NOT NULL,
  `material_type_code` varchar(10) NOT NULL,
  `supplier_code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price_buy` double NOT NULL,
  PRIMARY KEY (`material_code`),
  KEY `material_type_code` (`material_type_code`),
  KEY `supplier_code` (`supplier_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`material_code`, `material_type_code`, `supplier_code`, `name`, `price_buy`) VALUES
('M0001', 'T0001', 'S0001', 'Bahan Kaos', 100000),
('M0002', 'T0001', 'S0001', 'Bahan Kaos', 100000),
('M0003', 'T0003', 'S0002', 'Bahan Kaos', 100000),
('M0004', 'T0001', 'S0002', 'Bahan 4', 500000),
('M0005', 'T0001', 'S0002', 'Bahan 6', 500000),
('M0006', 'T0002', 'S0002', 'Bahan Jeans', 150000);

-- --------------------------------------------------------

--
-- Table structure for table `material_type`
--

DROP TABLE IF EXISTS `material_type`;
CREATE TABLE IF NOT EXISTS `material_type` (
  `material_type_code` varchar(10) NOT NULL,
  `material_type_name` varchar(50) NOT NULL,
  PRIMARY KEY (`material_type_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `material_type`
--

INSERT INTO `material_type` (`material_type_code`, `material_type_name`) VALUES
('T0001', 'Fabric'),
('T0002', 'Jeans'),
('T0003', 'Cotton');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE IF NOT EXISTS `suppliers` (
  `supplier_code` varchar(10) NOT NULL,
  `supplier_name` varchar(100) NOT NULL,
  PRIMARY KEY (`supplier_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_code`, `supplier_name`) VALUES
('S0001', 'Supplier A'),
('S0002', 'Supplier B');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_ibfk_1` FOREIGN KEY (`supplier_code`) REFERENCES `suppliers` (`supplier_code`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `materials_ibfk_2` FOREIGN KEY (`material_type_code`) REFERENCES `material_type` (`material_type_code`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
