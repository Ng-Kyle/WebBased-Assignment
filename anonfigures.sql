-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2026 at 02:36 PM
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
-- Database: `anonfigures`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Admin_ID` int(6) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `Cart_ID` int(6) NOT NULL,
  `Member_ID` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_product`
--

CREATE TABLE `cart_product` (
  `Product_ID` int(6) NOT NULL,
  `Cart_ID` int(6) NOT NULL,
  `Quantity` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `Coupon_ID` int(6) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Type` varchar(30) NOT NULL,
  `Discount_Value` double(4,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `Order_ID` int(6) NOT NULL,
  `Member_ID` int(6) NOT NULL,
  `Member_Coupon_ID` int(6) NOT NULL,
  `Order_Date` date NOT NULL,
  `Status` varchar(30) NOT NULL,
  `Total_Amount` double(4,2) NOT NULL,
  `Discount_Amount` double(4,3) NOT NULL,
  `Final_Amount` double(4,2) NOT NULL,
  `Street_Address` varchar(50) NOT NULL,
  `Post_Code` int(5) NOT NULL,
  `City` varchar(30) NOT NULL,
  `State` varchar(30) NOT NULL,
  `Country` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `Member_ID` int(6) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `Phone_Number` varchar(11) NOT NULL,
  `Street_Address` varchar(50) NOT NULL,
  `Post_Code` int(5) NOT NULL,
  `City` varchar(30) NOT NULL,
  `State` varchar(30) NOT NULL,
  `Country` varchar(30) NOT NULL,
  `Image_URL` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member_coupon`
--

CREATE TABLE `member_coupon` (
  `Member_Coupon_ID` int(6) NOT NULL,
  `Member_ID` int(6) NOT NULL,
  `Coupon_ID` int(6) NOT NULL,
  `Date_Earned` date NOT NULL,
  `Expiry_Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `Order_Details_ID` int(6) NOT NULL,
  `Order_ID` int(6) NOT NULL,
  `Product_ID` int(6) NOT NULL,
  `Quantity` int(5) NOT NULL,
  `Unit_Price` double(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `Product_ID` int(6) NOT NULL,
  `Supplier_ID` int(6) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Description` varchar(100) NOT NULL,
  `Price` double(5,2) NOT NULL,
  `Stock_Quantity` int(5) NOT NULL,
  `Status` varchar(30) NOT NULL,
  `Scale` varchar(30) NOT NULL,
  `Series` varchar(50) NOT NULL,
  `Brand` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
--

CREATE TABLE `product_image` (
  `Product_Image_ID` int(6) NOT NULL,
  `Product_ID` int(6) NOT NULL,
  `Image_URL` varchar(100) NOT NULL,
  `Alt_Text` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `receipt`
--

CREATE TABLE `receipt` (
  `Receipt_ID` int(6) NOT NULL,
  `Order_ID` int(6) NOT NULL,
  `Payment_Date` date NOT NULL,
  `Payment_Method` varchar(10) NOT NULL,
  `Amount_Paid` double(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `Review_ID` int(6) NOT NULL,
  `Order_Details_ID` int(6) NOT NULL,
  `Rating` double(2,2) NOT NULL,
  `Comment` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `Supplier_ID` int(6) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Phone_Number` varchar(11) NOT NULL,
  `Address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `Wishlist_ID` int(6) NOT NULL,
  `Member_ID` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_product`
--

CREATE TABLE `wishlist_product` (
  `Wishlist_ID` int(6) NOT NULL,
  `Product_ID` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Admin_ID`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`Cart_ID`),
  ADD KEY `Member_ID` (`Member_ID`);

--
-- Indexes for table `cart_product`
--
ALTER TABLE `cart_product`
  ADD PRIMARY KEY (`Product_ID`,`Cart_ID`),
  ADD KEY `Cart_ID` (`Cart_ID`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`Coupon_ID`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`Order_ID`),
  ADD KEY `Member_ID` (`Member_ID`),
  ADD KEY `Member_Coupon_ID` (`Member_Coupon_ID`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`Member_ID`);

--
-- Indexes for table `member_coupon`
--
ALTER TABLE `member_coupon`
  ADD PRIMARY KEY (`Member_Coupon_ID`),
  ADD KEY `Member_ID` (`Member_ID`),
  ADD KEY `Coupon_ID` (`Coupon_ID`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`Order_Details_ID`),
  ADD KEY `Order_ID` (`Order_ID`),
  ADD KEY `Product_ID` (`Product_ID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`Product_ID`),
  ADD KEY `Supplier_ID` (`Supplier_ID`);

--
-- Indexes for table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`Product_Image_ID`),
  ADD KEY `Product_ID` (`Product_ID`);

--
-- Indexes for table `receipt`
--
ALTER TABLE `receipt`
  ADD PRIMARY KEY (`Receipt_ID`),
  ADD KEY `Order_ID` (`Order_ID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`Review_ID`),
  ADD KEY `Order_Details_ID` (`Order_Details_ID`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`Supplier_ID`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`Wishlist_ID`),
  ADD KEY `Member_ID` (`Member_ID`);

--
-- Indexes for table `wishlist_product`
--
ALTER TABLE `wishlist_product`
  ADD PRIMARY KEY (`Wishlist_ID`,`Product_ID`),
  ADD KEY `Product_ID` (`Product_ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`Member_ID`) REFERENCES `member` (`Member_ID`);

--
-- Constraints for table `cart_product`
--
ALTER TABLE `cart_product`
  ADD CONSTRAINT `cart_product_ibfk_1` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`Product_ID`),
  ADD CONSTRAINT `cart_product_ibfk_2` FOREIGN KEY (`Cart_ID`) REFERENCES `cart` (`Cart_ID`);

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`Member_ID`) REFERENCES `member` (`Member_ID`),
  ADD CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`Member_Coupon_ID`) REFERENCES `member_coupon` (`Member_Coupon_ID`);

--
-- Constraints for table `member_coupon`
--
ALTER TABLE `member_coupon`
  ADD CONSTRAINT `member_coupon_ibfk_1` FOREIGN KEY (`Member_ID`) REFERENCES `member` (`Member_ID`),
  ADD CONSTRAINT `member_coupon_ibfk_2` FOREIGN KEY (`Coupon_ID`) REFERENCES `coupon` (`Coupon_ID`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`Order_ID`) REFERENCES `invoice` (`Order_ID`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`Product_ID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`Supplier_ID`) REFERENCES `supplier` (`Supplier_ID`);

--
-- Constraints for table `product_image`
--
ALTER TABLE `product_image`
  ADD CONSTRAINT `product_image_ibfk_1` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`Product_ID`);

--
-- Constraints for table `receipt`
--
ALTER TABLE `receipt`
  ADD CONSTRAINT `receipt_ibfk_1` FOREIGN KEY (`Order_ID`) REFERENCES `invoice` (`Order_ID`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`Order_Details_ID`) REFERENCES `order_details` (`Order_Details_ID`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`Member_ID`) REFERENCES `member` (`Member_ID`);

--
-- Constraints for table `wishlist_product`
--
ALTER TABLE `wishlist_product`
  ADD CONSTRAINT `wishlist_product_ibfk_1` FOREIGN KEY (`Wishlist_ID`) REFERENCES `wishlist` (`Wishlist_ID`),
  ADD CONSTRAINT `wishlist_product_ibfk_2` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`Product_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
