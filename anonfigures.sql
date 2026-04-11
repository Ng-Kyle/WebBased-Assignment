-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 11, 2026 at 11:51 AM
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
  `Name` varchar(99) NOT NULL,
  `Password` varchar(99) NOT NULL,
  `Email` varchar(99) NOT NULL
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
(1, 1),
(2, 6),
(3, 7),
(4, 8),
(5, 9),
(6, 10),
(7, 11),
(8, 12);

-- --------------------------------------------------------

--
-- Table structure for table `cart_product`
--

CREATE TABLE `cart_product` (
  `Product_ID` int(6) NOT NULL,
  `Cart_ID` int(6) NOT NULL,
  `Quantity` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_product`
--

INSERT INTO `cart_product` (`Product_ID`, `Cart_ID`, `Quantity`) VALUES
(1, 1, 2),
(1, 2, 1),
(1, 3, 2),
(1, 6, 1),
(1, 7, 1),
(1, 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `Order_ID` int(6) NOT NULL,
  `Member_ID` int(6) NOT NULL,
  `Order_Date` datetime NOT NULL,
  `Status` varchar(99) NOT NULL,
  `Total_Amount` double(6,2) NOT NULL,
  `Street_Address` varchar(999) NOT NULL,
  `Post_Code` int(5) NOT NULL,
  `City` varchar(99) NOT NULL,
  `State` varchar(99) NOT NULL,
  `Stripe_Session_ID` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`Order_ID`, `Member_ID`, `Order_Date`, `Status`, `Total_Amount`, `Street_Address`, `Post_Code`, `City`, `State`, `Stripe_Session_ID`) VALUES
(1, 1, '2026-04-08 23:21:23', 'Preparing', 100.50, '188 Jalan Persisiran Pantai,Pekan Klebang', 75250, 'Klebang', 'Melaka', 'cs_test_a1A4c7IUlK546Le6oGJ5SN3XUb9zaTAwb1R7A748UzLw1irnLMuXCp049R'),
(2, 1, '2026-04-09 01:19:10', 'Preparing', 100.50, 'LOT 4242 Alur Rindu 1,Kampung Tersusun Seri Rahmat', 31000, 'Batu Gajah', 'Perak', 'cs_test_a1xdpLhEmcDgylTFfEObFOLu20a29jpaqa5WNVpkZxZBlixnu124lvN0RZ'),
(3, 1, '2026-04-09 01:26:54', 'Preparing', 100.50, '188 Jalan Persisiran Pantai,Pekan Klebang', 75250, 'Klebang', 'Melaka', 'cs_test_a1DgQYhRvzAtLcFETckLEhQmqP9TRser9lAdVNy9FK2VUSMd5rrbvVzB2r'),
(4, 6, '2026-04-09 18:41:02', 'Preparing', 201.00, 'Jalan Bayam,8-6-3, Cheras', 55100, 'Cheras', 'Wilayah Persekutuan Kuala Lumpur', 'cs_test_a1bclFrDfkRTnP61ae6OPort7wB7VFodWGzUDkBvsfEXUANIJ9AaY1Y3e4'),
(5, 7, '2026-04-09 19:02:44', 'Preparing', 100.50, '188 Jalan Persisiran Pantai,Pekan Klebang', 75250, 'Klebang', 'Melaka', 'cs_test_a1ISYAq7sZWLiCjUzCeaVFziMGsNuknmIQbSoNjujDQLlgA0kG6HlbZUvb'),
(6, 7, '2026-04-09 19:04:49', 'Preparing', 100.50, '188 Jalan Persisiran Pantai,Pekan Klebang', 75250, 'Klebang', 'Melaka', 'cs_test_a1peU9kP5dIpGfjnU7Z2p68Xfx83hSE3Xi3cbbmu1HY6uVuftw4W5Egd1n'),
(7, 7, '2026-04-09 19:11:44', 'Preparing', 100.50, 'LOT 4242 Alur Rindu 1,Kampung Tersusun Seri Rahmat', 31000, 'Batu Gajah', 'Perak', 'cs_test_a1UDadCck6ukDfmSXGBZly3l20auplzvpgXhcTNb9GaFdOvs7Q9JCVfETC'),
(8, 7, '2026-04-09 19:55:27', 'Preparing', 201.00, 'LOT 4242 Alur Rindu 1,Kampung Tersusun Seri Rahmat', 31000, 'Batu Gajah', 'Perak', 'cs_test_a18YRXfg1ZAvZag6SWwvQ1tl5RWfy2BXJxDzkIsGJrxBst4iPY6TVNMJUf'),
(9, 7, '2026-04-09 20:00:22', 'Preparing', 100.50, '1234, Lorong Desa Seni 6/3,Taman Sejahtera Jaya', 9600, 'Lunas', 'Kedah', 'cs_test_a14bQKv06gXK7q8ohbK0MPWExUL4sqydgLPczW98Vw6uBNwOtC8doRqoG1'),
(10, 8, '2026-04-09 20:24:47', 'Preparing', 100.50, '1234, Lorong Desa Seni 6/3,Taman Sejahtera Jaya', 9600, 'Lunas', 'Kedah', 'cs_test_a1uMacrVcV7FfLLE6Swv5EClo00BJDsvAxici2S7vaCp6Sn765eNFbnESf'),
(11, 8, '2026-04-09 20:33:39', 'Preparing', 100.50, 'Jalan Teluk Baru', 7000, 'Langkawi', 'Kedah', 'cs_test_a1fwpHtUcgjIlMawXnSCv9pWylmiYs4TjAF5p0yOZhQb7h1obwVqHQu05m'),
(12, 8, '2026-04-09 20:35:37', 'Preparing', 100.50, 'LOT 4242 Alur Rindu 1,Kampung Tersusun Seri Rahmat', 31000, 'Batu Gajah', 'Perak', 'cs_test_a1fHidAusuxDU94sAS03NSca2cZUHhLpS32uHMW0P27Ucvo8WaC35OS0pE'),
(13, 10, '2026-04-11 00:33:28', 'Preparing', 100.50, '12347, Jalan Terkukur 8,Bandar Putra Kulai', 81000, 'Kulai', 'Johor Darul Ta\'zim', 'cs_test_a1Jpmy9qMvm0tgDZa8UMao9SOzIOsJul1uPh7Ix8Q2D4QzCDiTgtrh9BLI'),
(14, 12, '2026-04-11 16:22:28', 'Preparing', 100.50, '4213, Lorong Ria 3b', 91000, 'Tawau', 'Sabah', 'cs_test_a1WgrzIBT4rNSJersVewgvXGehebHfM3eKVAQBkaxv6MoqeV2FtlxJkPTK');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `Member_ID` int(6) NOT NULL,
  `Name` varchar(99) NOT NULL,
  `Email` varchar(99) NOT NULL,
  `Password` varchar(999) NOT NULL,
  `Phone_Number` varchar(11) NOT NULL,
  `Image_URL` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`Member_ID`, `Name`, `Email`, `Password`, `Phone_Number`, `Image_URL`) VALUES
(1, 'Kyle', 'ngkyle.trp@gmail.com', '1', '0123456789', '/images/image.png'),
(5, 'test', '123@gmail.com', '601f1889667efaebb33b8c12572835da3f027f78', '123', '/images/69d74eb7af259.jpg'),
(6, 'test', 'test@gmai.com', '8cb2237d0679ca88db6464eac60da96345513964', '0123456789', '/images/69d77fffda72e.jpg'),
(7, '222', '222@gmail.com', '1a9b9508b6003b68ddfe03a9c8cbc4bd4388339b', '222', '/images/69d7871925572.jpg'),
(8, '123', 'agentbloon@gmail.com', '601f1889667efaebb33b8c12572835da3f027f78', '123123', '/images/69d79a5c5fdd9.jpg'),
(9, 'hi', 'hi@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '/images/69d85fc0a3841.jpg'),
(10, '12345', '12345@gmail.com', '601f1889667efaebb33b8c12572835da3f027f78', '123', '/images/69d9175b32905.jpg'),
(11, 'kyle', 'kyle@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', '1234', '/images/69d930fa730a6.jpg'),
(12, '12345', 'amongus@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', '12345', '/images/69da0451eb8de.jpg');

--
-- Triggers `member`
--
DELIMITER $$
CREATE TRIGGER `after_members_insert` AFTER INSERT ON `member` FOR EACH ROW BEGIN
	INSERT INTO cart(member_id)
    VALUES(new.member_id);
    INSERT INTO wishlist(member_id)
    VALUES(new.member_id);
END
$$
DELIMITER ;

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
(1, 1, 1, 1),
(2, 2, 1, 1),
(3, 3, 1, 1),
(4, 4, 1, 2),
(5, 5, 1, 1),
(6, 6, 1, 1),
(7, 7, 1, 1),
(8, 8, 1, 2),
(9, 9, 1, 1),
(10, 10, 1, 1),
(11, 11, 1, 1),
(12, 12, 1, 1),
(13, 13, 1, 1),
(14, 14, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `Product_ID` int(6) NOT NULL,
  `Supplier_ID` int(6) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Description` varchar(999) NOT NULL,
  `Price` double(6,2) NOT NULL,
  `Stock_Quantity` int(5) NOT NULL,
  `Status` varchar(99) NOT NULL,
  `Scale` varchar(99) NOT NULL,
  `Series` varchar(99) NOT NULL,
  `Brand` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`Product_ID`, `Supplier_ID`, `Name`, `Description`, `Price`, `Stock_Quantity`, `Status`, `Scale`, `Series`, `Brand`) VALUES
(1, 1, 'Nendoroid Anon Chihaya', 'From \"BanG Dream!\" comes a Nendoroid of the MyGO!!!!! guitarist, Anon Chihaya!', 100.50, 1, 'Available', 'Nendoroid', 'BanG Dream!', 'Good Smile Company');

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
(1, 1, '/images/anonfigure.jpg', 'anonfigure');

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
(1, 1, '2026-04-08 23:21:23', 100.50),
(2, 2, '2026-04-09 01:19:10', 100.50),
(3, 3, '2026-04-09 01:26:54', 100.50),
(4, 4, '2026-04-09 18:41:03', 201.00),
(5, 5, '2026-04-09 19:02:44', 100.50),
(6, 6, '2026-04-09 19:04:49', 100.50),
(7, 7, '2026-04-09 19:11:44', 100.50),
(8, 8, '2026-04-09 19:55:27', 201.00),
(9, 9, '2026-04-09 20:00:22', 100.50),
(10, 10, '2026-04-09 20:24:47', 100.50),
(11, 11, '2026-04-09 20:33:39', 100.50),
(12, 12, '2026-04-09 20:35:37', 100.50),
(13, 13, '2026-04-11 00:33:28', 100.50),
(14, 14, '2026-04-11 16:22:28', 100.50);

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
  `Name` varchar(99) NOT NULL,
  `Email` varchar(99) NOT NULL,
  `Phone_Number` varchar(11) NOT NULL,
  `Address` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`Supplier_ID`, `Name`, `Email`, `Phone_Number`, `Address`) VALUES
(1, 'Anon Tokyo Figures', 'anontokyo@gmail.com', '0123456789', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `id` varchar(100) NOT NULL,
  `expire` datetime NOT NULL,
  `Member_ID` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 11),
(2, 12);

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
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`Order_ID`),
  ADD KEY `Member_ID` (`Member_ID`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`Member_ID`);

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
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`Member_ID`);

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
  MODIFY `Cart_ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `Order_ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `Member_ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `Order_Details_ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `Product_ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `Product_Image_ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `receipt`
--
ALTER TABLE `receipt`
  MODIFY `Receipt_ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
  MODIFY `Wishlist_ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`Member_ID`) REFERENCES `member` (`Member_ID`);

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
-- Constraints for table `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `token_ibfk_1` FOREIGN KEY (`Member_ID`) REFERENCES `member` (`Member_ID`);

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
