-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 14, 2026 at 08:12 AM
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
  `admin_id` int(6) NOT NULL,
  `name` varchar(99) NOT NULL,
  `password` varchar(99) NOT NULL,
  `email` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `password`, `email`) VALUES
(1, 'SuperAdmin', '0dc66e1efa21d0007ad10d9bf761854b13f67623', 'superadmin@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(6) NOT NULL,
  `member_id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `member_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13);

-- --------------------------------------------------------

--
-- Table structure for table `cart_product`
--

CREATE TABLE `cart_product` (
  `product_id` int(6) NOT NULL,
  `cart_id` int(6) NOT NULL,
  `quantity` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `order_id` int(6) NOT NULL,
  `member_id` int(6) NOT NULL,
  `order_date` datetime NOT NULL,
  `status` varchar(99) NOT NULL,
  `total_amount` double(8,2) NOT NULL,
  `street_address` varchar(999) NOT NULL,
  `post_code` int(5) NOT NULL,
  `city` varchar(99) NOT NULL,
  `state` varchar(99) NOT NULL,
  `stripe_session_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`order_id`, `member_id`, `order_date`, `status`, `total_amount`, `street_address`, `post_code`, `city`, `state`, `stripe_session_id`) VALUES
(1, 1, '2026-04-14 12:19:10', 'Preparing', 563.00, '2A Jalan Stesen Sentral 2,Level 41-18, Kuala Lumpur Sentral', 50470, 'Kuala Lumpur', 'Federal Territory of Kuala Lumpur', 'cs_test_b1cgucOSMOeB85O1vWwWhfTwh24KxzkX1EQg55HL5ukWdNDzD2oFv7conh'),
(2, 2, '2026-04-14 12:31:50', 'Preparing', 1015.28, '32 Jalan Puteri 5/5,Bandar Puteri', 47100, 'Puchong', 'Selangor', 'cs_test_b1KuHt6mjfSvktnNKpygdKkqHc8EhFY9gVxGptjTu38dtZ4W3Nn48uegww'),
(3, 2, '2026-04-14 12:32:52', 'Preparing', 325.20, '88 Jalan Badminton 13/29,Tadisma Business Park', 40100, 'Shah Alam', 'Selangor', 'cs_test_a1zaBO4B9lbeQiwsBn6Be4tdyhTOn3fGBcSqS6Yc8muggeQ7WPgrAiYFNT'),
(4, 3, '2026-04-14 12:36:27', 'Preparing', 110.00, 'No. 34 Jalan SS 2/10,SS 2', 47300, 'Petaling Jaya', 'Selangor', 'cs_test_a1U3pbrlX8Wjj10HtYmTHQML6wTJrgmPQa0mQnn0xQBlagvu6CjIBglyE0'),
(5, 4, '2026-04-14 12:44:41', 'Preparing', 214.15, 'Jalan UMS,University Apartment, Manggatal', 88450, 'Kota Kinabalu', 'Sabah', 'cs_test_a1UOO4xOP6lKvePEiXl9EW2El3Z6IIp2siNf4PShYkORQI0YG9ZW5x2FuX'),
(6, 6, '2026-04-14 12:51:40', 'Preparing', 460.00, '26 Jalan Perlis,George Town', 10400, 'George Town', 'Pulau Pinang', 'cs_test_a1NZbrpIFEzi1WFBnNoXPRpcta6ekeFOwG7NWeOJo9o3kj9RqrKjGIs3ro'),
(7, 7, '2026-04-14 12:55:46', 'Preparing', 713.90, 'Jalan Pantai Baharu,Wisma R&D, Universiti Malaya', 59100, 'Kuala Lumpur', 'Wilayah Persekutuan Kuala Lumpur', 'cs_test_a1N42lUgw0zSr5B3rxIFGsfJf5sLZQaCTshhGINPynQVl9Ipu8ftvYjBqw'),
(8, 8, '2026-04-14 13:02:00', 'Preparing', 230.00, 'Jalan Taman Rekreasi Ranchan Serian', 94700, 'Serian', 'Sarawak', 'cs_test_a1JW1IvNWwRoORsRMog9egxdFad5dc1csXFMjHk5LIqBXDzd6NEzlYyEhR'),
(9, 10, '2026-04-14 13:53:54', 'Preparing', 99.10, '61 Jalan Harmonium 23/12,Taman Desa Tebrau', 81100, 'Johor Bahru', 'Johor Darul Ta\'zim', 'cs_test_a1VmWBpHKi1f4j74PXHlwj0AsgdFqQz3UaWkTbBAcT1HrmTIBYYOxoDtWB'),
(10, 11, '2026-04-14 13:59:22', 'Preparing', 317.20, '17 Jalan Yau Tet Shin,Taman Jubilee', 30300, 'Ipoh', 'Perak', 'cs_test_a1cybVYgD4thqCVHxeejXEE5UKReWhcH2FdrqCc6pkwjfVODJeE5cScHkm'),
(11, 12, '2026-04-14 14:04:55', 'Preparing', 563.20, 'Jalan Pinang,Kuala Lumpur Convention Centre, Kuala Lumpur City Centre', 50088, 'Kuala Lumpur', 'Wilayah Persekutuan Kuala Lumpur', 'cs_test_a17xRYollFu6g2HfWP2bPcAp3IwO1TIwULm9skZVWk3d5hL4gDp0A89cLY');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_id` int(6) NOT NULL,
  `name` varchar(99) NOT NULL,
  `email` varchar(99) NOT NULL,
  `password` varchar(999) NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `image_url` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`member_id`, `name`, `email`, `password`, `phone_number`, `image_url`) VALUES
(1, 'Anon Chihaya', 'anonchihaya@gmail.com', '5019400a88d33010b2e9dccf1bfab6044a1291a6', '0123456789', '/images/user/69ddbfa264b71.jpg'),
(2, 'Amane Kanata', 'amanekanata@gmail.com', '90e53334da55deafeaf6cc996e0a8c47a5931fb8', '01234567890', '/images/user/69ddc20f2bcce.jpg'),
(3, 'Sakiko Togawa', 'sakitogawag@gmail.com', 'e2db3b0891242badbf674dc27dc7684454c1d0b7', '01234567891', '/images/user/69ddc40c43462.jpg'),
(4, 'Kanade Yoisaki', 'k@gmail.com', '760533d735f1a585c79fdf4aa600fca1f0b469a8', '01234567892', '/images/user/69ddc4a4ae3d3.jpg'),
(5, 'Iroha Sakayori', 'iroP168@gmail.com', '29eb8a74d83d7038e82760dd27e681c00b12327b', '0168168168', '/images/user/69ddc6feebedf.jpg'),
(6, 'Kaguya', 'kaguyahime@gmail.com', '7401da4e09c15ad1d12260445ce8ddde29342eec', '0123456168', '/images/user/69ddc77d10ed1.jpg'),
(7, 'Yachiyo Runami', 'yachi8000@gmail.com', '080292f001890c1f4e7c63cd72b7983cc8a9caa2', '01234168168', '/images/user/69ddc86c8e295.jpg'),
(8, 'Kitasan Black', 'kitachan@gmail.com', 'b6830554e758cd6f6d2ee233862fa9ba65462237', '0123455555', '/images/user/69ddca14e3b01.jpg'),
(9, 'Chisato Nishikigi', 'chisatolyco@gmail.com', 'ee77eea30e7c8fc816653dcc71db34597db8d53a', '0123456666', '/images/user/69ddd5b4676be.jpg'),
(10, 'Mabayu Aki', 'mabascene0@gmail.com', 'ef4d54d14e10f1eaee366c6eecab6051ce70e63e', '0123234345', '/images/user/69ddd62b524db.jpg'),
(11, 'Bocchi', 'guitarhero@gmail.com', '52d58ba65944c43d57587235c1b77c9fb855b991', '0129991324', '/images/user/69ddd712d4cdc.jpg'),
(12, 'Akane Kurokawa', 'akaneK@gmail.com', '30fc861d526bc81ed0038df21811a5997e012375', '0193425432', '/images/user/69ddd8bf14a57.jpg'),
(13, 'Leon S. Kennedy', 'leonre@gmail.com', '6cc9704fadcbea69c9fb57fc4b5bd9094812b407', '0145231234', '/images/user/69ddd9f3ac9dc.jpg');

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
  `order_details_id` int(6) NOT NULL,
  `order_id` int(6) NOT NULL,
  `product_id` int(6) NOT NULL,
  `quantity` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_details_id`, `order_id`, `product_id`, `quantity`) VALUES
(1, 1, 2, 1),
(2, 1, 4, 2),
(3, 1, 11, 1),
(4, 2, 24, 1),
(5, 2, 30, 1),
(6, 3, 12, 2),
(7, 4, 1, 1),
(8, 5, 17, 1),
(9, 6, 18, 2),
(10, 7, 23, 1),
(11, 8, 13, 1),
(12, 9, 16, 1),
(13, 10, 15, 2),
(14, 11, 27, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(6) NOT NULL,
  `name` varchar(999) NOT NULL,
  `description` varchar(999) NOT NULL,
  `price` double(8,2) NOT NULL,
  `stock_quantity` int(5) NOT NULL,
  `status` varchar(99) NOT NULL,
  `scale` varchar(99) NOT NULL,
  `series` varchar(99) NOT NULL,
  `brand` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `name`, `description`, `price`, `stock_quantity`, `status`, `scale`, `series`, `brand`) VALUES
(1, 'BanG Dream! - Plushie MyGO!!!!! Tomori Takamatsu', 'From \"BanG Dream!\" comes a collection of \"MyGO!!!!!\" plushies.', 110.00, 5, 'Available', 'Plushie', 'BanG Dream!', 'Good Smile Company'),
(2, 'BanG Dream! - Plushie MyGO!!!!! Anon Chihaya', 'From \"BanG Dream!\" comes a collection of \"MyGO!!!!!\" plushies.', 111.00, 5, 'Available', 'Plushie', 'BanG Dream!', 'Good Smile Company'),
(3, 'BanG Dream! - Plushie MyGO!!!!! Rana Kaname', 'From \"BanG Dream!\" comes a collection of \"MyGO!!!!!\" plushies.', 110.00, 3, 'Available', 'Plushie', 'BanG Dream!', 'Good Smile Company'),
(4, 'BanG Dream! - Plushie MyGO!!!!! Soyo Nagasaki', 'From \"BanG Dream!\" comes a collection of \"MyGO!!!!!\" plushies.', 111.00, 2, 'Available', 'Plushie', 'BanG Dream!', 'Good Smile Company'),
(5, 'BanG Dream! - Plushie MyGO!!!!! Taki Shiina', 'From \"BanG Dream!\" comes a collection of \"MyGO!!!!!\" plushies.', 111.00, 5, 'Available', 'Plushie', 'BanG Dream!', 'Good Smile Company'),
(6, 'hololive production - HELLO! GOOD SMILE Ookami Mio Figure', 'HELLO! GOOD SMILE Ookami Mio\r\n\r\nFrom the popular VTuber group \"hololive production\" comes a new figure of Ookami Mio! HELLO! GOOD SMILE is a chibi figure series by Good Smile Company! The neck of each figure includes a simple joint that can be moved left and right. Made with the creative direction of art director Shigeto Koyama, HELLO! GOOD SMILE figures feature a cute chibi design that will leave you wanting more and more!', 75.30, 5, 'Available', 'HELLO! GOOD SMILE', 'hololive production', 'Good Smile Company'),
(7, 'SPY x FAMILY - HELLO! GOOD SMILE Anya Forger', 'HELLO! Anya Forger\r\n\r\nFrom the anime \"SPY x FAMILY\" comes a new figure of Anya Forger!\r\n\r\nHELLO! GOOD SMILE is a chibi figure series by Good Smile Company! The neck of each figure includes a simple joint that can be moved left and right. Made with the creative direction of art director Shigeto Koyama, HELLO! GOOD SMILE figures feature a cute chibi design that will leave you wanting more and more!', 75.30, 6, 'Available', 'HELLO! GOOD SMILE', 'SPY x FAMILY', 'Good Smile Company'),
(8, 'Honkai: Star Rail - HELLO! GOOD SMILE March 7th Figure', 'HELLO! March 7th\r\n\r\n \r\n\r\nFrom the popular game \"Honkai: Star Rail\" comes a figure of March 7th!\r\n\r\nHELLO! GOOD SMILE is a chibi figure series by Good Smile Company! The neck of each figure includes a simple joint that can be moved left and right. Made with the creative direction of art director Shigeto Koyama, HELLO! GOOD SMILE figures feature a cute chibi design that will leave you wanting more and more!', 83.25, 6, 'Available', 'HELLO! GOOD SMILE', 'Honkai: Star Rail', 'Good Smile Company'),
(9, 'Persona 3 Reload - HELLO! GOOD SMILE Aigis Figure', ' From the popular RPG \"Persona3 Reload\" comes a new figure of Aigis!\r\n\r\nHELLO! GOOD SMILE is a chibi figure series by Good Smile Company! The neck of each figure includes a simple joint that can be moved left and right. Made with the creative direction of art director Shigeto Koyama, HELLO! GOOD SMILE figures feature a cute chibi design that will leave you wanting more and more! ', 75.30, 10, 'Available', 'HELLO! GOOD SMILE', 'Persona', 'Good Smile Company'),
(10, 'hololive production - POP UP PARADE Yukihana Lamy Figure', 'A New Addition to the POP UP PARADE!\r\n\r\nPOP UP PARADE is a series of figures that are easy to collect with affordable prices and speedy releases! Each figure typically stands around 17-18cm in height and the series features a vast selection of characters from popular anime and game series, with many more to be added soon!', 134.80, 5, 'Available', 'POP UP PARADE', 'hololive production', 'Good Smile Company'),
(11, 'BanG Dream! - POP UP PARADE Anon Chihaya L Size Figure', 'With the same impact as a scale figure!\r\n\r\nPOP UP PARADE is bringing figure fans a brand new sense of excitement with the L line.', 230.00, 5, 'Available', 'POP UP PARADE', 'BanG Dream!', 'Good Smile Company'),
(12, 'hololive production - POP UP PARADE SP Hoshimachi Suisei Figure ', 'A special POP UP PARADE figure is here!\r\n\r\nPOP UP PARADE SP is a branch of POP UP PARADE figures that transcends the boundaries of the regular POP UP PARADE lineup with special surprises! Check out the details of the checkered outfit that have been intricately reproduced despite the figure\'s size!', 162.60, 5, 'Available', 'POP UP PARADE', 'hololive production', 'Good Smile Company'),
(13, 'Umamusume: Pretty Derby - POP UP PARADE Rice Shower L Size Figure', 'POP UP PARADE is bringing figure fans a brand new sense of excitement with the L line.', 230.00, 5, 'Available', 'POP UP PARADE', 'Umamusume: Pretty Derby', 'Good Smile Company'),
(14, 'SPY x FAMILY - Anya Forger: Detective Ver. 1/7 Scale Figure', 'Anya as a detective in 1/7 scale!\r\n\r\nFrom the popular anime \"SPY x FAMILY\" comes Anya as a detective! Enjoy the various visual details the figure has to offer, such as the peanuts on the ground, test papers, newspaper, Director Chimera and paw prints! An interchangeable scheming face plate is also included! Be sure to add Anya to your collection for a fun adventure together!', 475.90, 5, 'Available', '1/7', 'SPY x FAMILY', 'Good Smile Arts Shanghai'),
(15, 'Bocchi the Rock! - Nendoroid Nijika Ijichi: Casual Clothes Ver. Figure', '\"Anyway, let\'s use today to make a fun summer memory with Bocchi-chan!\"\r\n\r\n\r\nFrom \"Bocchi the Rock!\" comes a Nendoroid of Nijika Ijichi in her outfit from the 9th episode!\r\n\r\nFace plates:\r\n· Smiling face\r\n· Calm face\r\n· Grinning face\r\n\r\nOptional parts:\r\n· Backpack\r\n· Other optional parts for different poses. ', 158.60, 5, 'Available', 'Nendoroid', 'Bocchi the Rock!', 'Good Smile Company'),
(16, 'Puella Magi Madoka Magica the Movie Walpurgisnacht: Rising - Nendoroid Homura Akemi - Walpurgisnacht: Rising Ver. Figure [Basic]', 'From \"Puella Magi Madoka Magica the Movie -Walpurgisnacht: Rising-\" comes a Nendoroid [Basic] of Homura Akemi!\r\n\r\nWhat is Nendoroid [Basic]?\r\nNendoroid [Basic] is a lineup of Nendoroids that omit face plates and optional parts, resulting in more affordability and faster production!\r\nThey feature the same functionality as regular Nendoroids, allowing them to share interchangeable hand parts, leg parts, head parts and face plates with other Nendoroids! ', 99.10, 5, 'Available', 'Nendoroid', 'Puella Magi Madoka Magica', 'Good Smile Company'),
(17, 'Hatsune Miku - Nendoroid Hatsune Miku: Because You\'re Here Ver. Figure', 'Presenting a new Nendoroid of Hatsune Miku, Inspired by the music video for PinocchioP’s \"Because You’re Here\"! Joining the lineup along with Miku are PinocchioP\'s original characters, Aimaina and Doushite-chan!\r\n\r\nFace plates:\r\n· Standard face\r\n· Crying face\r\n· Smiling face\r\n\r\nOptional parts:\r\n· Microphone stand\r\n· Aimaina\r\n· Doushite-chan\r\n· Other optional parts for different poses.', 214.15, 5, 'Available', 'Nendoroid', 'Hatsune Miku', 'Good Smile Company'),
(18, 'Hatsune Miku - Nendoroid Hatsune Miku: Magical Mirai 2020 Summer Festival Ver. Figure', 'Miku in a festival outfit from Magical Mirai 2020 Summer Festival has arrived!\r\n\r\nFrom \"Character Vocal Series 01: Hatsune Miku\" comes a Nendoroid of Hatsune Miku wearing her outfit from the Magical Mirai 2019 Summer Festival main visual illustration! Illustrator Fuzichoco\'s \"Festival\" version of Miku has been brought to life.\r\n\r\nShe comes with three face plates including a standard expression, an expression with her tongue sticking out and a smiling expression. A hand fan, cotton candy and a goldfish are all included as optional parts! Be sure to add her to your collection!', 230.00, 5, 'Available', 'Nendoroid', 'Hatsune Miku', 'Good Smile Company'),
(19, 'Puella Magi Madoka Magica the Movie -Walpurgisnacht: Rising- - Nendoroid Sayaka Miki - Walpurgisnacht: Rising Ver. [Basic]', 'From \"Puella Magi Madoka Magica the Movie -Walpurgisnacht: Rising-\" comes a Nendoroid [Basic] of Sayaka Miki! \r\n\r\nWhat is Nendoroid [Basic]?\r\nNendoroid [Basic] is a lineup of Nendoroids that omit face plates and optional parts, resulting in more affordability and faster production!\r\nThey feature the same functionality as regular Nendoroids, allowing them to share interchangeable hand parts, leg parts, head parts and face plates with other Nendoroids! ', 99.10, 5, 'Available', 'Nendoroid', 'Puella Magi Madoka Magica', 'Good Smile Company'),
(20, 'Umamusume: Pretty Derby - Symboli Rudolf: Signature Racewear Ver. 1/7 scale figure', 'We are excited to present the scale figure “Symboli Rudolf: Signature Racewear Ver.” from “Umamusume: Pretty Derby”!\r\n\r\n \r\n\r\nShe is a dignified and beautiful Umamusume worthy of the name \"Emperor,\" and her elegant poise has been faithfully recreated in figure form. Her hair and costume flutter realistically as she gazes confidently straight ahead. Her pose, in which she is standing proudly and cutting the wind with her left arm, gives her a unique and unrivaled style. Her signature racewear, “Emperor’s Path,” is faithfully reproduced down to the smallest of details and decorations. The pedestal is also simple, yet sturdy with shiny gold decoration. \r\n\r\nBe sure not to miss the chance to add the powerful and beautiful “Emperor” Symboli Rudolf to your collection!', 817.02, 5, 'Available', '1/7', 'Umamusume: Pretty Derby', 'Claynel'),
(21, 'Umamusume: Pretty Derby - Manhattan Cafe ~Willow-Green Evening~ 1/7 Scale Figure', '\"A cup of coffee and a moment of bliss for you.\"\r\n\r\n \r\n\r\nFrom \"Umamusume: Pretty Derby\" comes a scale figure of Manhattan Cafe in a traditional Japanese outfit. Dressed in her Willow-Green Evening outfit from a Japanese confectionery shop, the figure features Manhattan Cafe gently preparing a cup of coffee. Her matcha-green kimono, frill apron and boots come together to create the perfect blend of Japanese and Western aesthetics, further enhancing the adorable Umamusume\'s graceful charm. Details such as the soft texture of the apron, Manhattan Cafe\'s carefully braided hair and cat motifs scattered throughout the outfit have all been carefully reproduced in figure form. Be sure to add the adorable Manhattan Cafe to your collection for a quiet and relaxing moment together!', 598.85, 5, 'Available', '1/7', 'Umamusume: Pretty Derby', 'Good Smile Company'),
(22, 'BanG Dream! - Anon Chihaya: Zero Gravity Ver. 1/7 Scale Figure', 'From \"BanG Dream!\" comes a 1/7 scale figure of the MyGO!!!!! guitarist Anon Chihaya in her popular \"Zero gravity\" outfit! The figure features Anon floating in zero gravity, as inspired by the theme of the same name. Her dynamic pose, long hair and skirt give the figure an airy atmosphere. The unique coloring of the original illustration has been faithfully captured in figure form using detailed and gradated paintwork. Enjoy admiring the beautiful color scheme brought to life in three-dimensional form. Display her with Tomori Takamatsu: Zero Gravity Ver. for an even more faithful recreation of the original illustration! Be sure to add Anon Chihaya amongst the stars to your collection!', 551.30, 5, 'Available', '1/7', 'BanG Dream!', 'Good Smile Arts Shanghai'),
(23, 'Hatsune Miku - Hatsune Miku: Happy 16th Birthday Ver. 1/7 Scale Figure', 'Blessings to all creators.\r\n\r\nFrom \"Character Vocal Series 01: Hatsune Miku\" comes a scale figure of Hatsune Miku based on her 16th birthday illustration created by Rella! The \"Wing of Form\" and \"Wing of Sound\" created with the theme of \"Wings of Creation\" have been have been faithfully captured in figure form with additional arrangement for a 3D medium. Her hopeful expression looking up at the sky is also full of charm, so be sure to take a close look from every angle!', 713.90, 5, 'Available', '1/7', 'Hatsune Miku', 'Good Smile Company'),
(24, 'hololive production - Sakamata Chloe 1/6 Scale Figure', '“Chomp, chomp, chooomp!” Introducing a 1/6 scale figure of Sakamata Chloe!\r\n\r\nSakamata Chloe, the intern who acts as a fixer and cleaner for Secret Society holoX, is now a 1/6 scale figure!\r\n\r\nThe figure is full of visual highlights, including her adorable and playful expression, beautiful pearly hair and the soft-looking sculpting of her skin.\r\n\r\nHer punk-like outfit has also been faithfully recreated to the smallest details. Enjoy the difference in texture between the jacket\'s inner lining and outer fabric, as well as the belt, buckles and studs that the jacket is adorned with.\r\n\r\nThe white base features details such as a stuffed orca and rug-like texture. Who says Chloe\'s room is messy?\r\n\r\nThe hood can also be worn or removed for different display options!\r\n\r\nHandlers and other hololive fans, be sure to add the adorable Sakamata Chloe to your collection!', 769.43, 5, 'Available', '1/6', 'hololive production', 'Max Factory'),
(25, 'Umamusume: Pretty Derby - Mihono Bourbon [CODE: ICING] Ver. 1/6 Scale Figure', 'The figure features Ruby in a Valentine\'s Day [CODE: Grasage] outfit with her skirt fluttering outstretched. Dressed in her Valentine’s outfit, [CODE: ICING], Mihono Bourbon has been brought to life in a graceful pose, gently spreading her skirt. Her soft smile conveys a deep trust in her Master, radiating a charm that makes you want to stay by her side forever.\r\nThe layered skirt is sculpted with rich, flowing detail, while the frills and accessories are carefully crafted down to the finest elements. Adorable fruit-shaped earrings, an oversized ribbon, and elegant brooches placed throughout the outfit add delightful accents you won’t want to miss.\r\nThe coloring combines chocolate-like sweetness with chic elegance, featuring subtle gradations and textures that create a luxurious finish.\r\nFrom head to toe, Mihono Bourbon is filled with irresistible cuteness—be sure to welcome her into your collection! ', 876.50, 5, 'Available', '1/6', 'Umamusume: Pretty Derby', 'Claynel'),
(26, '【OSHI NO KO】 - Kana Arima: Hoodie Style Ver. 1/6 Scale Figure', 'Introducing a 1/6 scale figure of Kana Arima, based on the Blu-ray Disc and DVD illustration!\r\n\r\nFrom the anime  \"【OSHI NO KO】\" comes a 1/6 scale figure of Kana Arima dressed in her outfit from the Blu-ray Disc and DVD illustration! Her outfit is painted with multiple shades of similar colors, enriching the figure\'s texture and three-dimensional appearance. Her ribbon feature pearlescent paintwork, allowing for an elegant shine when viewed from certain angles. Kana Arima\'s iconic red bob has been carefully sculpted to give it a light and soft look. Her hair has also been painted to give the look of the colors of her outfit reflecting on it. The base of the figure is made with real carpet-like material, adding a cute and warm touch to the overall figure. Her hat can also be removed for a different display option. Be sure to add this adorable 1/6 scale figure of Kana Arima to your collection!', 527.50, 5, 'Available', '1/6', 'OSHI NO KO', 'Good Smile Arts Shanghai'),
(27, '【OSHI NO KO】 - Ruby: Date Style Ver. 1/6 Scale Figure', 'From the anime \"【OSHI NO KO】\" comes a \"Date Style\" figure of Ruby in a casual outfit!\r\n\r\nThe 1/6 scale figure features Ruby in a sakura-colored outfit that is perfect for spring, accompanied by her adorable and charming smile.\r\n\r\nRuby\'s translucent blouse and glossy heels seem simple at a glance, but reveal an impressive amount of detail when admired closely.\r\n\r\nOther visual highlights include the paintwork of the highlights on her hair, as well as the detailed textures of her outfit.\r\n\r\nBe sure to enjoy your special date with Ruby!', 563.20, 5, 'Available', '1/6', 'OSHI NO KO', 'Good Smile Company'),
(28, 'Gun x Sword - MODEROID Dann of Thursday Model Kit', '\"Wake up, Dann!\"\r\n\r\nFrom the anime series \"Gun x Sword\" comes the very first MODEROID plastic model of the main character Van\'s armor and one of the mecha of the Original Seven, Dann of Thursday!\r\n\r\nThe model stands at approximately 190mm (7.48in) in height and comes with its sword and interchangeable hand parts. Translucent parts have been used to create the G-ER fluid sections of the mecha. The cables at the arm and leg areas of the mecha are made with flexible parts, allowing for a wide range of articulation while still preserving the unique looks of the mecha.\r\n\r\nThe included sword can be separated into a large sword and small sword, and it can also be attached to the forearm of the mecha using the included attachment parts. Dann of Thursday can also be transformed into sword mode with the use of some interchangeable parts.', 166.55, 5, 'Available', 'Model Kit', 'Gun x Sword', 'Good Smile Company'),
(29, 'Bang Brave Bang Bravern - MODEROID Bang Dragon Model Kit', '\"Isami! We have to save the world!\"\r\n\r\n\r\n· The model is approximately 220mm (8.66in) in length.\r\n· Can be combined with MODEROID Bravern (sold separately) to form Bang Bravern with the use of interchangeable parts.\r\n· Includes Bang Twin Lance and landing gear for use with Bang Dragon.\r\n· Translucent parts are used for Bang Twin Lance effect parts and a portion of Bang Dragon.\r\n· Excess parts during Bang Bravern form can be attached to the frame parts.\r\n· A special sleeve designed by director Masami Obari is included for storing Bang Dragon as a set with MODEROID Bravern (sold separately).\r\n　(Illustration is identical to the illustration on MODEROID Bang Bravern (sold separately).)\r\n· The various parts of the mecha have been separated into various colored and clear runners, and some parts of the model are pre-painted with stickers included, making it easy to recreate the mecha from the series with a simple assembly. ', 138.80, 5, 'Available', 'Model Kit', 'Bang Brave Bang Bravern', 'Good Smile Company'),
(30, 'hololive production - PLAMATEA Shirogane Noel Model Kit', 'The captain of the Order of Shirogane is now a PLAMATEA plastic model!\r\n\r\n \r\n\r\nFrom the popular VTuber group \"hololive production\" comes a PLAMATEA plastic model of Shirogane Noel! The highly articulated plastic model is a faithful rendition of the original illustration.\r\n\r\n· Pre-painted face plates: a smiling face, a closed-eyes smiling face and an angry face are included.\r\n· Includes pre-painted parts, making it easy to recreate the character with a simple assembly.\r\n· Optional parts include a beef bowl, Danin-san and mace.\r\n· Adhesive is required for certain parts.', 245.85, 5, 'Available', 'Model Kit', 'hololive production', 'Max Factory');

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
--

CREATE TABLE `product_image` (
  `product_image_id` int(6) NOT NULL,
  `product_id` int(6) NOT NULL,
  `image_url` varchar(999) NOT NULL,
  `alt_text` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_image`
--

INSERT INTO `product_image` (`product_image_id`, `product_id`, `image_url`, `alt_text`) VALUES
(1, 1, '/images/products/4bb2eea8b95c0e87cf6a4f70736d4074.jpg', 'TomoriPlush'),
(2, 2, '/images/products/8fff155b76f266628bf6e4230d1cd3dd.jpg', 'AnonPlush'),
(3, 3, '/images/products/613e8bd0e7623e06731a5242541312bc.jpg', 'RanaPlush'),
(4, 4, '/images/products/79631fd9e324eea57e1575109bbc5a82.jpg', 'SoyoPlush'),
(5, 5, '/images/products/274254438ad21c3fccebecfe116269ac.jpg', 'TakiPlush'),
(6, 6, '/images/products/01_2409051009116913.jpg', 'HelloGoodSmileMio'),
(7, 7, '/images/products/data_2Fproductimages_2FHELLO_2FAnyaForger_2F101_2506021027372310.jpg', 'HelloGoodSmileAnya'),
(8, 8, '/images/products/101_3e70b2c1-17a0-4a32-b39f-687ce87716fe.jpg', 'HelloGoodSmileMarch'),
(9, 9, '/images/products/101_24f81e0e-5736-4749-ac2e-9058608c2f30.jpg', 'HelloGoodSmileAigis'),
(10, 10, '/images/products/101_91a35087-567c-476e-8dfe-aad08099c729.jpg', 'PopUpParadeLamy1'),
(11, 10, '/images/products/102_aaf5bab4-cdeb-4420-82a6-829279bfabde.jpg', 'PopUpParadeLamy2'),
(12, 10, '/images/products/105_09c5685a-b780-471d-9317-9e59c453d035.jpg', 'PopUpParadeLamy3'),
(13, 24, '/images/products/01_2409061042324095.jpg', '1/6Chloe'),
(14, 13, '/images/products/data_2Fproductimages_2FPOP_2FRiceShower_LSize_2F104_2505271014451682.jpg', 'PopUpParadeRice'),
(15, 13, '/images/products/data_2Fproductimages_2FPOP_2FRiceShower_LSize_2F101_2505271014452971.jpg', 'PopUpParadeRice2'),
(16, 13, '/images/products/data_2Fproductimages_2FPOP_2FRiceShower_LSize_2F106_2505271014469903.jpg', 'PopUpParadeRice2'),
(17, 11, '/images/products/101_0e5c6688-bab0-4826-a3fd-75ea3a396f38.jpg', 'PopUpParadeAnon'),
(18, 11, '/images/products/104_d4a2d1ef-fcdd-473c-b07c-0983afcdc60a.jpg', 'PopUpParadeAnon1'),
(19, 11, '/images/products/105_05873557-297a-4bfa-9d6c-7974f4b8605b.jpg', 'PopUpParadeAnon2'),
(20, 12, '/images/products/101_ed947fd4-24b7-4478-ab60-9ffe715ef9a8.jpg', 'PopUpParadeSuisei'),
(21, 12, '/images/products/104_935cf6c4-eb6e-4b9e-b899-a1469f2868ba.jpg', 'PopUpParadeSuisei1'),
(22, 12, '/images/products/105_b77a66ff-0c4e-493e-b687-6e0bfbe894d2.jpg', 'PopUpParadeSuisei2'),
(23, 14, '/images/products/101_2502271211545986.jpg', '1/7Anya'),
(24, 25, '/images/products/102_912b842c-cfa2-4d42-b84d-e61a89da16c1.jpg', '1/6Bourbon'),
(25, 14, '/images/products/105_2502271211553456.jpg', '1/7Anya1'),
(26, 14, '/images/products/104_2502271211553506.jpg', '1/7Anya1'),
(27, 15, '/images/products/101_2502130952567802.jpg', 'NendoroidNijika'),
(28, 15, '/images/products/102_2502130952573976.jpg', 'NendoroidNijika1'),
(29, 15, '/images/products/103_2502130952578531.jpg', 'NendoroidNijika2'),
(30, 15, '/images/products/105_2502130952578450.jpg', 'NendoroidNijika3'),
(31, 16, '/images/products/101_9891a9ae-8b7d-47d4-81ad-6859d3e51e81.jpg', 'NendoroidHomura'),
(32, 17, '/images/products/101_0c1f15c1-7203-4ddc-a10e-4695954f5f87.jpg', 'NendoroidMikuPino'),
(33, 17, '/images/products/102_3a5fcff9-9256-4325-a6c1-b54d043b8af6.jpg', 'NendoroidMikuPino1'),
(34, 17, '/images/products/103_da3123fa-c805-4d27-b626-2a966c88b5b0.jpg', 'NendoroidMikuPino2'),
(35, 17, '/images/products/104_206bb2f6-1d72-4664-a57d-243f4261b4d6.jpg', 'NendoroidMikuPino3'),
(36, 17, '/images/products/105_ad00eeac-9e06-4e25-845d-c93794f87783.jpg', 'NendoroidMikuPino4'),
(37, 18, '/images/products/data_2Fproductimages_2FNendoroids_2FHatsuneMiku_MagicalMirai_2020SummerFestivalVer_2F101_2507101051338528.jpg', 'NendoroidMikuMirai'),
(38, 18, '/images/products/data_2Fproductimages_2FNendoroids_2FHatsuneMiku_MagicalMirai_2020SummerFestivalVer_2F102_2507101051332930.jpg', 'NendoroidMikuMirai1'),
(39, 18, '/images/products/data_2Fproductimages_2FNendoroids_2FHatsuneMiku_MagicalMirai_2020SummerFestivalVer_2F103_2507101051346794.jpg', 'NendoroidMikuMirai1'),
(40, 18, '/images/products/data_2Fproductimages_2FNendoroids_2FHatsuneMiku_MagicalMirai_2020SummerFestivalVer_2F104_250710105134225.jpg', 'NendoroidMikuMirai1'),
(41, 18, '/images/products/data_2Fproductimages_2FNendoroids_2FHatsuneMiku_MagicalMirai_2020SummerFestivalVer_2F105_2507101051342088.jpg', 'NendoroidMikuMirai1'),
(42, 18, '/images/products/data_2Fproductimages_2FNendoroids_2FHatsuneMiku_MagicalMirai_2020SummerFestivalVer_2F106_2507101051342581.jpg', 'NendoroidMikuMirai1'),
(43, 19, '/images/products/101_3cf22128-4e28-40bd-968c-bc7c26ffca72.jpg', 'NendoroidSayaka'),
(44, 20, '/images/products/101_db8e3a7f-7925-4a2f-acb9-63e4a996b8d4.jpg', '1/7Rudolf'),
(45, 20, '/images/products/103_bb3ed8e3-f97e-4c9a-84e6-d2ce8ce256fe.jpg', '1/7Rudolf1'),
(46, 20, '/images/products/107_27c26501-d4d7-4b89-ba0c-442f25d13fd3.jpg', '1/7Rudolf2'),
(47, 21, '/images/products/103_13a195e7-25c1-46d8-a2c7-77a73c8d7f34.jpg', '1/7Cafe'),
(48, 21, '/images/products/102_3cdc9f99-9252-4b71-808b-842ba21ef5f2.jpg', '1/7Cafe1'),
(49, 21, '/images/products/106_bd38a368-fb94-4778-b05b-d5bc3a87e50e.jpg', '1/7Cafe2'),
(50, 22, '/images/products/101_1d2ed7ed-a9ec-4236-a20d-7c9ed08be70b.jpg', '1/7Anon'),
(51, 23, '/images/products/01_2308290953059690.jpg', '1/7MikuBirthday'),
(52, 23, '/images/products/03_2308290953062190.jpg', '1/7MikuBirthday1'),
(53, 25, '/images/products/104_b25f498f-b64a-4d29-9ccc-9c27b5e9456c.jpg', '1/6Bourbon1'),
(54, 25, '/images/products/101_b67b5ec1-da20-4843-94a5-2c05149c788f.jpg', '1/6Bourbon2'),
(55, 26, '/images/products/data_2Fproductimages_2FScaleFigures_2FKanaArima_HoodieStyleVer_2FImage_1_2505231034584555.jpg', '1/6Kana'),
(56, 26, '/images/products/data_2Fproductimages_2FScaleFigures_2FKanaArima_HoodieStyleVer_2FImage_4_25052310345941.jpg', '1/6Kana1'),
(57, 26, '/images/products/data_2Fproductimages_2FScaleFigures_2FKanaArima_HoodieStyleVer_2FImage_9_2505231034594984.jpg', '1/6Kana2'),
(58, 27, '/images/products/101_2411061006045990.jpg', '1/6Ruby'),
(59, 27, '/images/products/102_2411061006046480.jpg', '1/6Ruby1'),
(60, 27, '/images/products/107_2411061006049607.jpg', '1/6Ruby2'),
(61, 28, '/images/products/data_2Fproductimages_2FMODEROID_2FDannOfThursday_2F101_2503281233304206.jpg', 'ModelDann'),
(62, 28, '/images/products/data_2Fproductimages_2FMODEROID_2FDannOfThursday_2F103_2503281233306965.jpg', 'ModelDann1'),
(63, 28, '/images/products/data_2Fproductimages_2FMODEROID_2FDannOfThursday_2F104_2503281233307660.jpg', 'ModelDann2'),
(64, 29, '/images/products/101_2501301126164489.jpg', 'ModelDragon'),
(65, 29, '/images/products/105_2501301126188601.jpg', 'ModelDragon1'),
(66, 29, '/images/products/103_2501301126175864.jpg', 'ModelDragon2'),
(67, 29, '/images/products/107_2501301126193941.jpg', 'ModelDragon2'),
(68, 30, '/images/products/101_2418c099-2ae4-4703-bc32-23ba2063f9da.jpg', 'ModelNoel'),
(69, 30, '/images/products/102_1e20a778-eb36-4a55-8309-698c9648f1f1.jpg', 'ModelNoel1'),
(70, 30, '/images/products/103_99d0bc66-fdb4-4bb9-ba5b-158b17e8a8b0.jpg', 'ModelNoel2'),
(71, 30, '/images/products/105_04555145-7e0c-4cb5-b9ac-802bc795d08a.jpg', 'ModelNoel3'),
(72, 30, '/images/products/109_5e85672f-13a6-44d4-a11d-dd3c6e7f3951.jpg', 'ModelNoel4');

-- --------------------------------------------------------

--
-- Table structure for table `receipt`
--

CREATE TABLE `receipt` (
  `receipt_id` int(6) NOT NULL,
  `order_id` int(6) NOT NULL,
  `payment_date` datetime NOT NULL,
  `amount_paid` double(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receipt`
--

INSERT INTO `receipt` (`receipt_id`, `order_id`, `payment_date`, `amount_paid`) VALUES
(1, 1, '2026-04-14 12:19:10', 563.00),
(2, 2, '2026-04-14 12:31:50', 1015.28),
(3, 3, '2026-04-14 12:32:52', 325.20),
(4, 4, '2026-04-14 12:36:27', 110.00),
(5, 5, '2026-04-14 12:44:41', 214.15),
(6, 6, '2026-04-14 12:51:40', 460.00),
(7, 7, '2026-04-14 12:55:46', 713.90),
(8, 8, '2026-04-14 13:02:00', 230.00),
(9, 9, '2026-04-14 13:53:54', 99.10),
(10, 10, '2026-04-14 13:59:22', 317.20),
(11, 11, '2026-04-14 14:04:55', 563.20);

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `id` varchar(100) NOT NULL,
  `expire` datetime NOT NULL,
  `member_id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(6) NOT NULL,
  `member_id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wishlist_id`, `member_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_product`
--

CREATE TABLE `wishlist_product` (
  `Wishlist_ID` int(6) NOT NULL,
  `Product_ID` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist_product`
--

INSERT INTO `wishlist_product` (`Wishlist_ID`, `Product_ID`) VALUES
(1, 1),
(1, 2),
(1, 11),
(1, 22),
(2, 6),
(4, 23),
(6, 17),
(8, 25),
(10, 19),
(12, 26);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `cart_product`
--
ALTER TABLE `cart_product`
  ADD PRIMARY KEY (`product_id`,`cart_id`),
  ADD KEY `Cart_ID` (`cart_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `Member_ID` (`member_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_details_id`),
  ADD KEY `Order_ID` (`order_id`),
  ADD KEY `Product_ID` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`product_image_id`),
  ADD KEY `Product_ID` (`product_id`);

--
-- Indexes for table `receipt`
--
ALTER TABLE `receipt`
  ADD PRIMARY KEY (`receipt_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`member_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD KEY `wishlist_ibfk_1` (`member_id`);

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
  MODIFY `admin_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `order_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_details_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `product_image_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `receipt`
--
ALTER TABLE `receipt`
  MODIFY `receipt_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`Member_ID`);

--
-- Constraints for table `cart_product`
--
ALTER TABLE `cart_product`
  ADD CONSTRAINT `cart_product_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`),
  ADD CONSTRAINT `cart_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`Product_ID`);

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
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `product_image`
--
ALTER TABLE `product_image`
  ADD CONSTRAINT `product_image_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `receipt`
--
ALTER TABLE `receipt`
  ADD CONSTRAINT `receipt_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `invoice` (`Order_ID`);

--
-- Constraints for table `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `token_ibfk_1` FOREIGN KEY (`Member_ID`) REFERENCES `member` (`Member_ID`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`);

--
-- Constraints for table `wishlist_product`
--
ALTER TABLE `wishlist_product`
  ADD CONSTRAINT `wishlist_product_ibfk_1` FOREIGN KEY (`Wishlist_ID`) REFERENCES `wishlist` (`Wishlist_ID`),
  ADD CONSTRAINT `wishlist_product_ibfk_2` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
