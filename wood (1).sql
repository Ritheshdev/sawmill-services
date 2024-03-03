-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2024 at 06:33 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wood`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `timeslot` varchar(20) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `resource_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL,
  `rating` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `number`, `message`, `rating`) VALUES
(11, 33, 'Rithesh', 'ritheshdevadiga2000@gmail.com', '9686575116', 'gjhfewejfdsjfhjfh', 'average'),
(12, 33, 'Rithesh', 'ritheshdevadiga2000@gmail.com', '7373477373', 'hfsdfkffkjsdg', 'good');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `products_price` varchar(1000) NOT NULL,
  `quantity` varchar(1000) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
  `status` varchar(50) NOT NULL DEFAULT 'notcancelled',
  `cname` varchar(200) NOT NULL,
  `cnumber` bigint(100) NOT NULL,
  `cmonth` varchar(100) NOT NULL,
  `cyear` varchar(200) NOT NULL,
  `cvv` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `products_price`, `quantity`, `total_products`, `total_price`, `placed_on`, `payment_status`, `status`, `cname`, `cnumber`, `cmonth`, `cyear`, `cvv`) VALUES
(51, 33, 'Rithesh', '7676283597', 'ritheshdevadiga2000@gmail.com', 'credit card', 'flat no. 2-80 shanthinagar sundari nilaya kavoor karnataka  - 123456', '2500', '1', 'Wood arm Chair', 2500, '22-Jun-2023', 'completed', 'notcancelled', 'Rithesh', 123456789012345, '02', '2023', 123),
(55, 33, 'Rithesh', '7676283597', 'ritheshdevadiga2000@gmail.com', 'credit card', 'flat no. 2-80 shanthinagar sundari nilaya kavoor karnataka 4567890', '3000,2500', '1,1', 'Traditional Wooden chair,Wood arm Chair', 5500, '22-Jun-2023', 'completed', 'notcancelled', 'Rithesh', 123456789012345, '01', '2023', 123),
(56, 33, 'Rithesh', '7676283597', 'ritheshdevadiga2000@gmail.com', 'cash on delivery', 'flat no. 2-80 shanthinagar sundari nilaya kavoor karnataka 12345678', '2300', '1', 'Wood Dining Chair', 2300, '22-Jun-2023', 'pending', 'notcancelled', '', 0, '', '', 0),
(57, 33, 'Rithesh', '7676283597', 'ritheshdevadiga2000@gmail.com', 'cash on delivery', 'flat no. 2-80 shanthinagar sundari nilaya kavoor karnataka 345667', '5000,5000', '1,1', 'Maharaja Chair,luxurious sofa', 10000, '23-Jun-2023', 'pending', 'notcancelled', '', 0, '', '', 0),
(58, 45, 'Prajwal', '8548034260', 'kulalprajwal65@gmail.com', 'credit card', 'flat no. 2-80 shanthinagar sundari nilaya kavoor karnataka 789987', '3000,50000', '1,2', 'Traditional Wooden chair,solid wooden 6 seater Dining set', 53000, '23-Jun-2023', 'completed', 'notcancelled', 'prajwal', 123456789123456, '02', '2023', 123),
(62, 33, 'Rithesh', '7676283597', 'ritheshdevadiga2000@gmail.com', 'cash on delivery', 'flat no. 2-80 shanthinagar sundari nilaya kavoor karnataka 2124', '2300,5000', '1,1', 'Wood Dining Chair,luxurious sofa', 7300, '03-Jul-2023', 'pending', 'cancelled', '', 0, '', '', 0),
(63, 33, 'Rithesh', '7676283597', 'ritheshdevadiga2000@gmail.com', 'credit card', 'flat no. 2-80 shanthinagar sundari nilaya kavoor karnataka  - 987756', '2500', '1', 'Wood arm Chair', 2500, '03-Jul-2023', 'completed', 'cancelled', 'Rithesh', 123456789876543, '02', '2024', 234),
(64, 33, 'Rithesh', '7676283597', 'ritheshdevadiga2000@gmail.com', 'credit card', 'flat no. 2-80 shanthinagar sundari nilaya kavoor karnataka  - 12345', '2500', '1', 'Wood arm Chair', 2500, '03-Jul-2023', 'completed', 'cancelled', 'Rithesh', 123456789876543, '01', '2024', 345),
(65, 33, 'Rithesh', '7676283597', 'ritheshdevadiga2000@gmail.com', 'credit card', 'flat no. 2-80 shanthinagar sundari nilaya kavoor karnataka 7909', '5000', '1', 'luxurious sofa', 5000, '03-Jul-2023', 'completed', 'cancelled', 'Rithesh', 123456789123456, '02', '2025', 678),
(66, 33, 'Rithesh', '7676283597', 'ritheshdevadiga2000@gmail.com', 'credit card', 'flat no. 2-80 shanthinagar sundari nilaya kavoor karnataka  - 752425', '2500', '1', 'Wood arm Chair', 2500, '03-Jul-2023', 'completed', 'cancelled', 'prajwal', 123456789876543, '02', '2025', 765),
(67, 33, 'Rithesh', '7676283597', 'ritheshdevadiga2000@gmail.com', 'credit card', 'flat no. 2-80 shanthinagar sundari nilaya kavoor karnataka 123566', '5000,2300', '1,1', 'luxurious sofa,Wood Dining Chair', 7300, '03-Jul-2023', 'completed', 'cancelled', 'Rithesh', 123456789123456, '01', '2024', 123),
(68, 33, 'Rithesh', '7676283597', 'ritheshdevadiga2000@gmail.com', 'cash on delivery', 'flat no. 2-80 shanthinagar sundari nilaya kavoor karnataka  - 25145', '2500', '1', 'Wood arm Chair', 2500, '03-Jul-2023', 'pending', 'cancelled', '', 0, '', '', 0),
(69, 33, 'Rithesh', '7676283597', 'ritheshdevadiga2000@gmail.com', 'credit card', 'flat no. 2-80 shanthinagar sundari nilaya kavoor karnataka  - 1232', '2500', '1', 'Wood arm Chair', 2500, '03-Jul-2023', 'completed', 'cancelled', 'Rithesh', 123456789123456, '03', '2024', 123),
(70, 33, 'Rithesh', '7676283597', 'ritheshdevadiga2000@gmail.com', 'credit card', 'flat no. 2-80 shanthinagar sundari nilaya kavoor karnataka  - 1234', '3000', '1', 'Traditional Wooden chair', 3000, '03-Jul-2023', 'completed', 'cancelled', 'prajwal', 123456789123456, '02', '2024', 123),
(71, 33, 'Rithesh', '7676283597', 'ritheshdevadiga2000@gmail.com', 'cash on delivery', 'flat no. 2-80 shanthinagar sundari nilaya kavoor karnataka  - 12345', '2500', '1', 'Wood arm Chair', 2500, '03-Jul-2023', 'pending', 'cancelled', '', 0, '', '', 0),
(72, 33, 'Rithesh', '7676283597', 'ritheshdevadiga2000@gmail.com', 'credit card', 'flat no. 2-80 shanthinagar sundari nilaya kavoor karnataka  - 12345', '15000', '1', 'Living Room wooden Sofa', 15000, '03-Jul-2023', 'completed', 'cancelled', 'Rithesh', 123456789123456, '02', '2025', 234),
(73, 33, 'Rithesh', '7676283597', 'ritheshdevadiga2000@gmail.com', 'credit card', 'flat no. 2-80 shanthinagar sundari nilaya kavoor karnataka  - 233', '3000', '1', 'Traditional Wooden chair', 3000, '03-Jul-2023', 'completed', 'cancelled', 'Rithesh', 123456789146795, '03', '2024', 123),
(74, 33, 'Rithesh', '7676283597', 'ritheshdevadiga2000@gmail.com', 'credit card', 'flat no. 2-80 shanthinagar sundari nilaya kavoor karnataka  - 124', '15000', '1', 'Living Room wooden Sofa', 15000, '03-Jul-2023', 'completed', 'cancelled', 'Rithesh', 123456789146795, '01', '2025', 324),
(75, 33, 'Rithesh', '7676283597', 'ritheshdevadiga2000@gmail.com', 'credit card', 'flat no. 2-80 shanthinagar sundari nilaya kavoor karnataka 12346', '20000', '1', 'Dining Table', 20000, '03-Jul-2023', 'completed', 'cancelled', 'Rithesh', 123456789012344, '01', '2024', 123),
(76, 33, 'Rithesh', '7676283597', 'ritheshdevadiga2000@gmail.com', 'credit card', 'flat no. 2-80 shanthinagar sundari nilaya kavoor karnataka 12346', '2300', '1', 'Wood Dining Chair', 2300, '03-Jul-2023', 'completed', 'cancelled', 'Rithesh', 123456789012344, '01', '2024', 123),
(77, 33, 'Rithesh', '7676283597', 'ritheshdevadiga2000@gmail.com', 'credit card', 'flat no. 2-80 shanthinagar sundari nilaya kavoor karnataka 345677', '2500', '1', 'Wood arm Chair', 2500, '03-Jul-2023', 'completed', 'cancelled', 'Rithesh', 123456789012345, '01', '2024', 123),
(78, 33, 'Rithesh', '7676283597', 'ritheshdevadiga2000@gmail.com', 'credit card', 'flat no. 2-80 shanthinagar sundari nilaya kavoor karnataka 12345', '5000', '1', 'luxurious sofa', 5000, '03-Jul-2023', 'completed', 'cancelled', 'Rithesh', 123456789012345, '01', '2023', 123),
(79, 33, 'Rithesh', '7676283597', 'ritheshdevadiga2000@gmail.com', 'credit card', 'flat no. 2-80 shanthinagar sundari nilaya kavoor karnataka 574114', '15000', '1', 'Living Room wooden Sofa', 15000, '05-Jul-2023', 'completed', 'cancelled', 'prajwal', 123456789012345, '01', '2024', 123);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(20) NOT NULL,
  `quantity` int(10) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `quantity`, `details`, `price`, `image`) VALUES
(29, 'Traditional Wooden chair', 'chair', 9, 'Traditional wooden Chair made with sheesham wood\r\nMulti-purpose chair for living room\r\nColor: Honey oak\r\nDimension:161.3Dx161.3Wx271H Cm\r\nitem weight:14kg', 3000, 'istockphoto-1010668084-1024x10241.jpg'),
(30, 'Wood arm Chair', 'chair', 10, 'Comfortable arm chair\r\nmade with Sheesham Wood\r\nFinished with durable polish\r\nColor: wallnut\r\nDimension:59Lx48W cm\r\nTheme:Vintage\r\n', 2500, 'istockphoto-156938318-1024x10241.jpg'),
(31, 'Wood Dining Chair', 'chair', 7, 'Elegantly Styled,dining chair made with Sheesham solid Wood\r\neasily seating adults while still leaving you enough space\r\nColor:Brown\r\nDimension:38.1Dx81.3Wx24.4H cm\r\nweight:15kg', 2300, 'istockphoto-92465135-1024x1024.jpg'),
(32, 'Maharaja Chair', 'chair', 9, 'Maharaja Chair for Bedroom,Living room hall and office \r\nMade with teak wood\r\nColor: Brown\r\nDimension:59.5Dx58.4Wx81.3H cm\r\nweight: 8kg\r\n', 5000, 'chair3.jpg'),
(33, 'luxurious sofa', 'sofa', 6, 'Luxurious 2 Seater Sofa with cushion\r\nMade with Sheesham Wood\r\nExcellent finish\r\nstyle: Modern\r\nType: Wood Carved\r\nDimension:50Lx27.5wx31.4H\r\n', 5000, 'sofa1.jpg'),
(34, 'Living Room wooden Sofa', 'sofa', 10, '3 seater Living room wooden sofa made with sheesham wood with cushion\r\nand excellent finish\r\ncolor:brown\r\nstyle:Modern\r\ntype:wood carving\r\nDimension:73Dx187wx69H cm', 15000, 'sofa2.jpg'),
(35, 'Traditional Sofa', 'sofa', 10, '2+1 seater Living room wooden sofa made with sheesham wood with cushion\r\nand excellent finish\r\ncolor:brown\r\nstyle:Modern\r\ntype:wood carving\r\nDimension:73Dx187wx69H cm', 10000, 'sofa5.jpg'),
(36, 'Dining Table', 'table', 10, 'Soloid sheesham wood 4 Seater Dining set \r\ncolor:brown\r\nstyle:Modern\r\ntype:wood carving\r\nDimension:144x76x89(WxHxD)', 20000, 'dtable1.jpg'),
(37, 'solid wooden 6 seater Dining set', 'table', 8, 'sheesham woood dining table with 6 seater set for restraunts\r\nmade with excellent finish\r\ncolor: provincial teak finish\r\ntype: living room,dining room\r\nstyle: traditional\r\ndimension: 55inch Lx 35inch Wx30inch H', 25000, 'dt3.jpg'),
(38, 'wooden dining table', 'table', 10, 'Sheesham wood 4 seater dining table with 3 chairs and 1 bench\r\nmade with excellent finish\r\ncolor: Natural Teak finish\r\nsize:4 seater\r\nweight: 80kilo\r\nstyle:contemporary\r\n', 18000, 'dtable3.jpg'),
(39, 'Royal dining table', 'table', 10, 'Elite wood Handicraft Dining table set made with teak wood\r\ncolor: Natural Teak finish\r\nsize: 6seater\r\nweight: 80kilo\r\nstyle: Royal Traditional\r\n', 35000, 'dt8.jpg'),
(40, 'wooden cupboard', 'other', 10, 'Platinum wood decor Solid sheesham Wood Cupboard/bookshelf\r\nall in one wooden decor with diamond cut design doors\r\nmounting type: floor mount\r\ntype:bedroom\r\nnumber of shelves:4\r\ndimension:45Dx90Wx180H', 20000, 'c2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `id` int(20) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `name`) VALUES
(0, 'resocutting'),
(1, 'BladeSharpening');

-- --------------------------------------------------------

--
-- Table structure for table `service_requests`
--

CREATE TABLE `service_requests` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` bigint(10) NOT NULL,
  `service` varchar(50) NOT NULL,
  `height` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `wood` varchar(50) NOT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `photo` varchar(255) NOT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_requests`
--

INSERT INTO `service_requests` (`id`, `user_id`, `name`, `email`, `number`, `service`, `height`, `width`, `wood`, `price`, `photo`, `status`, `created_at`) VALUES
(51, 33, 'Rithesh', 'ritheshdevadiga2000@gmail.com', 7676283597, 'table', 45, 56, 'mahgoni', '4000.00', 'uploads/chair2.jpg', 'Accepted', '2023-07-05 01:20:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` bigint(10) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user',
  `image` varchar(100) NOT NULL,
  `code` int(10) NOT NULL,
  `status` varchar(20) NOT NULL,
  `otp_expiry` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `number`, `password`, `user_type`, `image`, `code`, `status`, `otp_expiry`) VALUES
(31, 'Rithesh', 'ritheshdevadiga3000@gmail.com', 9686575116, 'f027a997496dee5b5049148bc635aa0e', 'admin', 'IMG_20200828_071113_885.jpg', 875747, '', '2023-11-17 15:10:05'),
(33, 'Rithesh devadiga', 'ritheshdevadiga2000@gmail.com', 7676283597, '9cd3f3c1e8a067099dfbc45885e1434a', 'user', 'IMG_20200828_071113_885.jpg', 670892, '', '2023-12-05 16:51:24'),
(34, 'shashikanth', 'rao19shashi@gmail.com', 0, '8dfd9ba3da0337afcedd5cae0f8c0c85', 'user', 'IMG_20211103_132448_992.jpg', 0, '', '2023-04-28 15:06:27'),
(43, 'Dhanraj', 'Cogdanny@icloud.com', 0, '950c490e74c3b902a85207219957d16f', 'user', '', 0, '', '2023-05-24 14:50:09'),
(44, 'dixen', 'dixenrodrigues2@gmail.com', 8971512871, '1dc2ad1f4c2d29b755998151c407314d', 'user', '', 0, '', '2023-06-05 08:17:05'),
(45, 'Prajwal', 'kulalprajwal65@gmail.com', 8548034260, 'b09cbdd30af9dac98091001d94211fbd', 'user', '', 0, '', '2023-06-23 08:12:43'),
(47, 'p', 'p@gmail.com', 8548034260, 'b09cbdd30af9dac98091001d94211fbd', 'user', '', 0, '', '2023-06-23 08:16:11');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `wood_data`
--

CREATE TABLE `wood_data` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `safety` int(11) DEFAULT NULL,
  `total_safety` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wood_data`
--

INSERT INTO `wood_data` (`id`, `name`, `price`, `safety`, `total_safety`, `total_price`) VALUES
(3, 'Sagoni', '1000.00', 0, 40, '40000.00'),
(4, 'Maple', '555.00', 0, 45, '24975.00'),
(6, 'Mahogany', '799.00', 0, 23, '18377.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wood_data`
--
ALTER TABLE `wood_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `service_requests`
--
ALTER TABLE `service_requests`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `wood_data`
--
ALTER TABLE `wood_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
