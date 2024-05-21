-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2024 at 03:23 AM
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
-- Database: `simpleordersystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `AccountID` int(11) NOT NULL,
  `FirstName` text DEFAULT NULL,
  `LastName` text DEFAULT NULL,
  `AdminUsername` text DEFAULT NULL,
  `AdminPassword` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`AccountID`, `FirstName`, `LastName`, `AdminUsername`, `AdminPassword`) VALUES
(1, 'Sample Name', 'Sample LastName', 'sampleUsername', 'samplePassword'),
(2, 'Rico', 'Parena', 'ricoparena', 'ricoparena123');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CategoryID`, `CategoryName`) VALUES
(7, 'Kakanin'),
(8, 'Latik'),
(9, 'Sweets');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` int(11) NOT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `ProductName` text DEFAULT NULL,
  `Price` int(11) DEFAULT NULL,
  `ImagePath` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `CategoryID`, `ProductName`, `Price`, `ImagePath`) VALUES
(11, 9, 'Puto', 50, '');

-- --------------------------------------------------------

--
-- Table structure for table `productpurchasedetails`
--

CREATE TABLE `productpurchasedetails` (
  `ProductPurchaseDetailsID` int(11) NOT NULL,
  `ProductName` text DEFAULT NULL,
  `PurchaseDetailsID` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `SubTotal` int(11) DEFAULT NULL,
  `ProductPrice` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productpurchasedetails`
--

INSERT INTO `productpurchasedetails` (`ProductPurchaseDetailsID`, `ProductName`, `PurchaseDetailsID`, `Quantity`, `SubTotal`, `ProductPrice`) VALUES
(28, 'Suman', 19, 1, 900, 900),
(29, 'Puto', 19, 1, 50, 50),
(30, 'Malagkit', 20, 1, 100, 100),
(31, 'Puto BumBum', 20, 2, 240, 120),
(32, 'Suman', 21, 1, 900, 900),
(33, 'Puto', 21, 3, 150, 50);

-- --------------------------------------------------------

--
-- Table structure for table `purchasebill`
--

CREATE TABLE `purchasebill` (
  `PurchaseID` int(11) NOT NULL,
  `PurchaseDetailsID` int(11) DEFAULT NULL,
  `DatePurchase` date DEFAULT NULL,
  `TotalBill` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchasebill`
--

INSERT INTO `purchasebill` (`PurchaseID`, `PurchaseDetailsID`, `DatePurchase`, `TotalBill`) VALUES
(16, 19, '2024-05-23', 950),
(17, 20, '2024-06-08', 340),
(18, 21, '2024-06-06', 1050);

-- --------------------------------------------------------

--
-- Table structure for table `purchasedetails`
--

CREATE TABLE `purchasedetails` (
  `PurchaseDetailsID` int(11) NOT NULL,
  `CustomerName` text DEFAULT NULL,
  `TransactionType` text DEFAULT NULL,
  `AccountID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchasedetails`
--

INSERT INTO `purchasedetails` (`PurchaseDetailsID`, `CustomerName`, `TransactionType`, `AccountID`) VALUES
(19, 'Nathan', 'Pick-Up', 2),
(20, 'Alyssa', 'Pick-Up', 2),
(21, 'Eloisa', 'Delivery', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`AccountID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `CategoryID` (`CategoryID`);

--
-- Indexes for table `productpurchasedetails`
--
ALTER TABLE `productpurchasedetails`
  ADD PRIMARY KEY (`ProductPurchaseDetailsID`),
  ADD KEY `ProductID` (`ProductName`(768)),
  ADD KEY `PurchaseDetailsID` (`PurchaseDetailsID`);

--
-- Indexes for table `purchasebill`
--
ALTER TABLE `purchasebill`
  ADD PRIMARY KEY (`PurchaseID`),
  ADD KEY `PurchaseDetailsID` (`PurchaseDetailsID`);

--
-- Indexes for table `purchasedetails`
--
ALTER TABLE `purchasedetails`
  ADD PRIMARY KEY (`PurchaseDetailsID`),
  ADD KEY `AccountID` (`AccountID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `AccountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `productpurchasedetails`
--
ALTER TABLE `productpurchasedetails`
  MODIFY `ProductPurchaseDetailsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `purchasebill`
--
ALTER TABLE `purchasebill`
  MODIFY `PurchaseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `purchasedetails`
--
ALTER TABLE `purchasedetails`
  MODIFY `PurchaseDetailsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`);

--
-- Constraints for table `productpurchasedetails`
--
ALTER TABLE `productpurchasedetails`
  ADD CONSTRAINT `productpurchasedetails_ibfk_2` FOREIGN KEY (`PurchaseDetailsID`) REFERENCES `purchasedetails` (`PurchaseDetailsID`);

--
-- Constraints for table `purchasebill`
--
ALTER TABLE `purchasebill`
  ADD CONSTRAINT `purchasebill_ibfk_1` FOREIGN KEY (`PurchaseDetailsID`) REFERENCES `purchasedetails` (`PurchaseDetailsID`);

--
-- Constraints for table `purchasedetails`
--
ALTER TABLE `purchasedetails`
  ADD CONSTRAINT `purchasedetails_ibfk_1` FOREIGN KEY (`AccountID`) REFERENCES `administrator` (`AccountID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
