-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 07, 2026 at 03:02 PM
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

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`Cart_ID`, `Member_ID`) VALUES
(1, 1);

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
  `Member_Coupon_ID` int(6) DEFAULT NULL,
  `Order_Date` datetime NOT NULL,
  `Status` varchar(30) NOT NULL,
  `Total_Amount` double(5,2) NOT NULL,
  `Discount_Amount` double(5,2) DEFAULT NULL,
  `Final_Amount` double(5,2) NOT NULL,
  `Street_Address` varchar(999) NOT NULL,
  `Post_Code` int(5) NOT NULL,
  `City` varchar(99) NOT NULL,
  `State` varchar(99) NOT NULL,
  `Stripe_Session_ID` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`Order_ID`, `Member_ID`, `Member_Coupon_ID`, `Order_Date`, `Status`, `Total_Amount`, `Discount_Amount`, `Final_Amount`, `Street_Address`, `Post_Code`, `City`, `State`, `Stripe_Session_ID`) VALUES
(17, 1, NULL, '2026-04-07 11:23:28', 'Preparing', 200.24, NULL, 200.24, 'test', 12200, 'test', 'test', 'cs_test_a1hTZx7pu1G78LtfmgLypEkRzlsPrhGz49Iy2IZkwMEjW6KVkMVAT0ZRqb'),
(18, 1, NULL, '2026-04-07 11:36:20', 'Preparing', 20.50, NULL, 20.50, 'test', 12200, 'test', 'test', 'cs_test_a1iydS1VrqCztDwlG6DzqzuKNIrMsruKld25DjfJJtDrP9ILDOkpsgOd6b'),
(19, 1, NULL, '2026-04-07 12:06:02', 'Preparing', 20.50, NULL, 20.50, 'Jalan Genting Kelang,Bangunan Tan Sri Khaw Kai Boh (Block A), Setapak', 53300, 'Kuala Lumpur', 'Federal Territory of Kuala Lumpur', 'cs_test_a1Mc4lUCHVqoG9VgYbS6QUEpTvCzTGce74l7TtdfpE81MuWsg2wQmHCPgC'),
(20, 1, NULL, '2026-04-07 12:09:31', 'Preparing', 20.50, NULL, 20.50, 'Jalan Genting Kelang,Bangunan Tan Sri Khaw Kai Boh (Block A), Setapak', 53300, 'Kuala Lumpur', 'Federal Territory of Kuala Lumpur', 'cs_test_a14KK2PKApGQ1k2G8d5pmSwAPzhKnOwDIKGX4VGJeKIHMud5UCB6XMmQy5'),
(21, 1, NULL, '2026-04-07 12:47:29', 'Preparing', 420.98, NULL, 420.98, '188 Jalan Persisiran Pantai,Pekan Klebang', 75250, 'Klebang', 'Melaka', 'cs_test_b1LxFmOv88WM484Os7RxMGecuR7HBCvV7G7fCjtA3HYnu1YWTeiQYKf5ml'),
(22, 1, NULL, '2026-04-07 15:50:59', 'Preparing', 20.50, NULL, 20.50, 'Jalan Kolej,Taman Bandar Baru', 31900, 'Kampar', 'Perak', 'cs_test_a1du9JZsziPvXjNJA0h5MUzDWzIcZdo8GBqBIVvTQGDmBRWrt4HZJNMkN5'),
(23, 1, NULL, '2026-04-07 15:55:28', 'Preparing', 200.24, NULL, 200.24, 'Wisma Merdeka,Kota Kinabalu', 88300, 'Kota Kinabalu', 'Sabah', 'cs_test_a1bU7w1W8AEdSZPUjx8SFEB5SeiUVkUfCQyIe01rEJJlmP3c8yzLtJewYh'),
(24, 1, NULL, '2026-04-07 15:56:55', 'Preparing', 20.50, NULL, 20.50, '188 Jalan Persisiran Pantai,Pekan Klebang', 75250, 'Klebang', 'Melaka', 'cs_test_a1svstrQ7RgF3NFZcJO7tsho7OQmOXd25yLMMFPS41fBHPd0Sw8014kr2b'),
(25, 1, NULL, '2026-04-07 15:58:37', 'Preparing', 20.50, NULL, 20.50, '28 Jalan Datuk Keramat,Kampung Datuk Keramat', 54000, 'Kuala Lumpur', 'Wilayah Persekutuan Kuala Lumpur', 'cs_test_a19sgn91SEURHiU8tFJShe3PubgDV1yjFhEfI8Zn2SlhVFm5xfkfW65oOi'),
(26, 1, NULL, '2026-04-07 17:03:04', 'Preparing', 220.74, NULL, 220.74, '188 Jalan Persisiran Pantai,Pekan Klebang', 75250, 'Klebang', 'Melaka', 'cs_test_b1TSAe0Pt1Pe9AV5j7YGB0UewRUYCfmKNTI5cu1lJshrPFuaZQsa7oCp48');

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
  `Image_URL` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`Member_ID`, `Name`, `Email`, `Password`, `Phone_Number`, `Image_URL`) VALUES
(1, 'test', 'test@gmail.com', 'test', 'test', '/images/image.png');

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
  `Quantity` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`Order_Details_ID`, `Order_ID`, `Product_ID`, `Quantity`) VALUES
(9, 17, 2, 1),
(10, 18, 1, 1),
(11, 19, 1, 1),
(12, 20, 1, 1),
(13, 21, 1, 1),
(14, 21, 2, 2),
(15, 22, 1, 1),
(16, 23, 2, 1),
(17, 24, 1, 1),
(18, 25, 1, 1),
(19, 26, 1, 1),
(20, 26, 2, 1);

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

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`Product_ID`, `Supplier_ID`, `Name`, `Description`, `Price`, `Stock_Quantity`, `Status`, `Scale`, `Series`, `Brand`) VALUES
(1, 1, 'test', 'test', 20.50, 1, 'test', 'test', 'test', 'test'),
(2, 1, 'test2', 'testing', 200.24, 1, 'test', 'test', 'test', 'test');

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

--
-- Dumping data for table `product_image`
--

INSERT INTO `product_image` (`Product_Image_ID`, `Product_ID`, `Image_URL`, `Alt_Text`) VALUES
(1, 1, '../images/image.png', 'test'),
(2, 2, '../images/image2.png', 'test2');

-- --------------------------------------------------------

--
-- Table structure for table `receipt`
--

CREATE TABLE `receipt` (
  `Receipt_ID` int(6) NOT NULL,
  `Order_ID` int(6) NOT NULL,
  `Payment_Date` datetime NOT NULL,
  `Amount_Paid` double(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receipt`
--

INSERT INTO `receipt` (`Receipt_ID`, `Order_ID`, `Payment_Date`, `Amount_Paid`) VALUES
(1, 25, '2026-04-07 00:00:00', 2050.00);

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

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`Supplier_ID`, `Name`, `Email`, `Phone_Number`, `Address`) VALUES
(1, 'test', 'test', '0123456789', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `Wishlist_ID` int(6) NOT NULL,
  `Member_ID` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`Wishlist_ID`, `Member_ID`) VALUES
(1, 1);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Admin_ID` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `Cart_ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `Order_ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `Member_ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `Order_Details_ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `Product_ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `Product_Image_ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `receipt`
--
ALTER TABLE `receipt`
  MODIFY `Receipt_ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `Review_ID` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `Supplier_ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `Wishlist_ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
