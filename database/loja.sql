-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2021 at 07:26 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loja`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `brand_active` int(11) NOT NULL DEFAULT 0,
  `brand_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`, `brand_active`, `brand_status`) VALUES
(1, 'Apple', 1, 1),
(2, 'Lenovo', 1, 1),
(3, 'Dell', 1, 1),
(4, 'Alienware', 1, 1),
(5, 'Google', 1, 1),
(6, 'Hp', 1, 1),
(7, 'Asus', 1, 1),
(8, 'MI', 1, 1),
(9, 'Panasonic', 2, 1),
(10, 'Samsung', 1, 1),
(11, 'Sandisk', 2, 1),
(12, 'Moto', 1, 1),
(13, 'VIVO', 1, 1),
(14, 'Infinix', 2, 1),
(15, 'Honor', 1, 1),
(16, 'Bose', 1, 1),
(17, 'Acer', 1, 1),
(18, 'Toshiba', 1, 1),
(19, 'Logitech', 1, 1),
(20, 'PNY', 1, 1),
(21, 'ARESGAME', 1, 2),
(22, 'NZXT', 1, 1),
(23, 'GIGABYTE', 1, 1),
(24, 'Thermaltake', 1, 1),
(25, 'Seagate', 1, 1),
(26, 'zxczxc', 1, 2),
(27, 'Intel', 1, 1),
(28, 'vxcvxc xcv', 2, 1),
(29, 'Sony', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_status` int(11) NOT NULL,
  `cart_status` int(11) NOT NULL,
  `cart_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `payment_status`, `cart_status`, `cart_date`) VALUES
(1, 5, 1, 1, '2021-01-03 20:22:40'),
(2, 6, 2, 1, '2021-01-04 13:26:47'),
(3, 5, 1, 1, '2021-01-04 13:26:47');

-- --------------------------------------------------------

--
-- Table structure for table `cart_item`
--

CREATE TABLE `cart_item` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart_item`
--

INSERT INTO `cart_item` (`cart_item_id`, `cart_id`, `product_id`, `quantity`, `active`, `status`) VALUES
(1, 1, 1, 3, 1, 1),
(2, 1, 4, 2, 1, 1),
(3, 2, 5, 4, 1, 1),
(4, 3, 8, 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categories_id` int(11) NOT NULL,
  `categories_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `categories_active` int(11) NOT NULL DEFAULT 0,
  `categories_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categories_id`, `categories_name`, `categories_active`, `categories_status`) VALUES
(1, 'Computadores', 1, 1),
(2, 'Hardware e Peças de rede', 1, 1),
(3, 'Componentes de Computador', 1, 1),
(4, 'sdasdas', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `adress` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `user_id`, `contact`, `adress`, `status`, `active`) VALUES
(1, 5, '821231130', '', 1, 1),
(2, 6, '841441424', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `client_name` varchar(255) NOT NULL,
  `client_contact` varchar(255) NOT NULL,
  `sub_total` varchar(255) NOT NULL,
  `vat` varchar(255) NOT NULL,
  `total_amount` varchar(255) NOT NULL,
  `discount` varchar(255) NOT NULL,
  `grand_total` varchar(255) NOT NULL,
  `paid` varchar(255) NOT NULL,
  `due` varchar(255) NOT NULL,
  `payment_type` int(11) NOT NULL,
  `payment_status` int(11) NOT NULL,
  `payment_place` int(11) NOT NULL,
  `gstn` varchar(255) NOT NULL,
  `order_status` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_date`, `client_name`, `client_contact`, `sub_total`, `vat`, `total_amount`, `discount`, `grand_total`, `paid`, `due`, `payment_type`, `payment_status`, `payment_place`, `gstn`, `order_status`, `user_id`) VALUES
(1, '2020-11-20 16:38:28', 'Armandoo', '64564564', '125000.00', '21250.00', '146250.00', '10', '146240.00', '146240', '0.00', 2, 1, 1, '23112.00', 1, 1),
(2, '2020-11-20 16:31:44', 'wer', '3543', '16600.00', '2822.00', '19422.00', '0', '19422.00', '19422', '0.00', 2, 1, 1, '2822.00', 1, 1),
(3, '2020-11-20 15:29:23', 'dfgdf', '65464', '38000.00', '6460.00', '44460.00', '0', '44460.00', '44460', '0.00', 2, 1, 1, '6460.00', 1, 1),
(4, '2021-02-04 17:49:50', 'sdfsd', '456456456', '22500.00', '3825.00', '26325.00', '0', '26325.00', '26325', '0.00', 2, 1, 1, '3825.00', 1, 2),
(5, '2021-03-01 15:42:22', 'fsdfs', '42347676', '88500.00', '15045.00', '103545.00', '0', '103545.00', '59085', '44460.00', 2, 1, 1, '8585.00', 1, 1),
(6, '2021-01-24 15:03:10', 'ghhggh', '7656756', '1275.00', '216.75', '1491.75', '0', '1491.75', '1492', '-0.25', 0, 1, 2, '216.75', 1, 5),
(7, '2020-11-22 22:37:42', 'ewrwee', '345345', '45000.00', '7650.00', '52650.00', '0', '52650.00', '52650', '0.00', 2, 1, 1, '7650.00', 1, 1),
(8, '2020-11-22 22:37:39', 'sdfsdf', '3453453453', '247886.00', '42140.62', '290026.62', '100', '289926.62', '289927', '-0.38', 2, 1, 1, '42140.62', 1, 1),
(9, '2021-01-17 02:04:34', 'cvbcvb sdfsd', '45546565', '125000.00', '21250.00', '146250.00', '0', '146250.00', '146250', '0.00', 1, 1, 1, '21250.00', 1, 1),
(10, '2021-02-04 17:49:47', 'sdfs', '8797899788', '1340.00', '227.80', '1567.80', '0', '1567.80', '0', '1567.80', 2, 1, 1, '227.80', 1, 2),
(11, '2021-01-17 14:50:54', 'dfgdf', '654645', '1340.00', '227.80', '1567.80', '0', '1567.80', '0', '1567.80', 1, 1, 1, '227.80', 1, 1),
(12, '2021-01-17 14:50:50', 'dgfdfg ', '654645465645', '5150.00', '875.50', '6025.50', '0', '6025.50', '6025.5', '0.00', 2, 1, 1, '875.50', 1, 1),
(13, '2021-02-04 17:49:44', 'sdfds sfds', '356456456', '6050.00', '1028.50', '7078.50', '0', '7078.50', '7078.5', '0.00', 2, 1, 1, '1028.50', 1, 2),
(14, '2021-02-04 11:28:23', 'hdfhdfgd jhvj', '434535678', '38000.00', '6460.00', '44460.00', '0', '44460.00', '44460', '0.00', 3, 1, 1, '', 1, 1),
(15, '2021-03-01 18:46:56', 'dfgdfgd', '435453453', '179252.50', '30472.93', '209725.43', '0', '209725.43', '39511.48', '170213.95', 2, 1, 1, '5740.98', 1, 1),
(16, '2021-02-04 17:52:18', 'dsdf sdf', '8234345345', '503512.00', '85597.04', '589109.04', '0', '589109.04', '589109.04', '0.00', 2, 1, 1, '85597.04', 1, 4),
(17, '2021-02-04 16:25:29', 'ssds sdfdf sdf', '8434345465', '176900.00', '30073.00', '206973.00', '0', '206973.00', '206973.00', '0.00', 3, 1, 1, '30073.00', 1, 1),
(18, '2021-02-04 17:51:29', 'sdfdfsd sdf', '85345345', '157500.00', '26775.00', '184275.00', '0', '184275.00', '184275.00', '0.00', 2, 1, 1, '26775.00', 1, 4),
(19, '2021-02-04 16:34:12', 'fsdf', '82343454567', '13000.00', '2210.00', '15210.00', '0', '15210.00', '15210.00', '0.00', 2, 1, 1, '2210.00', 1, 1),
(20, '2021-03-01 17:25:50', 'swerwer erwe', '8523424564', '404457.50', '68757.77', '473215.27', '0', '473215.27', '44460.00', '428755.27', 2, 1, 1, '6460.00', 1, 1),
(21, '2021-02-04 16:53:18', 'hghghg hgh', '873455466', '90000.00', '15300.00', '105300.00', '0', '105300.00', '105300.00', '0.00', 2, 1, 1, '15300.00', 1, 4),
(22, '2021-03-01 18:18:46', 'Joana De Melo', '848454544', '482850.00', '82084.50', '564934.50', '0', '564934.50', '564934.50', '0.00', 2, 1, 1, '82084.50', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL DEFAULT 0,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `quantity` varchar(255) NOT NULL,
  `rate` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `order_item_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`order_item_id`, `order_id`, `product_id`, `quantity`, `rate`, `total`, `order_item_status`) VALUES
(5, 1, 1, '1', '125000', '125000.00', 1),
(6, 1, 13, '1', '12500.00', '12500.00', 1),
(7, 1, 13, '1', '12500.00', '12500.00', 1),
(8, 2, 4, '1', '22500.00', '22500.00', 1),
(9, 2, 12, '1', '16600.00', '16600.00', 1),
(10, 3, 6, '1', '38000.00', '38000.00', 1),
(11, 4, 4, '1', '22500.00', '22500.00', 1),
(18, 6, 10, '1', '1275.00', '1275.00', 1),
(19, 8, 5, '4', '45000.00', '180000.00', 1),
(20, 8, 10, '2', '1275.00', '2550.00', 1),
(21, 8, 8, '1', '950.00', '950.00', 1),
(22, 8, 9, '1', '64386.00', '64386.00', 1),
(24, 7, 4, '2', '22500.00', '45000.00', 1),
(32, 9, 1, '1', '125000.00', '125000.00', 1),
(39, 10, 15, '1', '1340.00', '1340.00', 1),
(40, 11, 15, '1', '1340.00', '1340.00', 1),
(41, 12, 17, '1', '5150.00', '5150.00', 1),
(42, 13, 14, '1', '6050.00', '6050.00', 1),
(55, 14, 6, '1', '38000.00', '38000.00', 1),
(60, 16, 1, '1', '125000.00', '125000.00', 1),
(61, 16, 4, '4', '22500.00', '90000.00', 1),
(62, 16, 10, '2', '1275.00', '2550.00', 1),
(63, 16, 9, '1', '64386.00', '64386.00', 1),
(64, 16, 18, '1', '14750.00', '14750.00', 1),
(65, 16, 19, '2', '85200.00', '170400.00', 1),
(66, 16, 24, '1', '4595.50', '4595.50', 1),
(67, 16, 25, '1', '6500.00', '6500.00', 1),
(68, 16, 16, '1', '8730.50', '8730.50', 1),
(69, 16, 12, '1', '16600.00', '16600.00', 1),
(72, 17, 19, '2', '85200.00', '170400.00', 1),
(73, 17, 25, '1', '6500.00', '6500.00', 1),
(74, 18, 5, '1', '45000.00', '45000.00', 1),
(75, 18, 4, '1', '22500.00', '22500.00', 1),
(76, 18, 5, '2', '45000.00', '90000.00', 1),
(77, 19, 25, '1', '6500.00', '6500.00', 1),
(78, 19, 25, '1', '6500.00', '6500.00', 1),
(79, 0, 6, '1', '38000.00', '38000.00', 1),
(80, 0, 6, '1', '38000.00', '38000.00', 1),
(81, 0, 6, '1', '38000.00', '38000.00', 1),
(82, 0, 6, '1', '38000.00', '38000.00', 1),
(83, 0, 6, '1', '38000.00', '38000.00', 1),
(85, 21, 5, '2', '45000.00', '90000.00', 1),
(226, 20, 6, '1', '38000.00', '38000.00', 1),
(227, 20, 19, '4', '85200.00', '340800.00', 1),
(228, 20, 15, '2', '1340.00', '2680.00', 1),
(229, 20, 24, '5', '4595.50', '22977.50', 1),
(230, 22, 13, '3', '12500.00', '37500.00', 1),
(231, 22, 8, '3', '950.00', '2850.00', 1),
(232, 22, 4, '3', '22500.00', '67500.00', 1),
(233, 22, 1, '3', '125000.00', '375000.00', 1),
(245, 15, 10, '7', '1275.00', '8925.00', 1),
(246, 15, 24, '5', '4595.50', '22977.50', 1),
(247, 15, 25, '3', '6500.00', '19500.00', 1),
(248, 15, 8, '3', '950.00', '2850.00', 1),
(249, 15, 1, '1', '125000.00', '125000.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(455) CHARACTER SET utf8 NOT NULL,
  `product_image` text CHARACTER SET utf8 NOT NULL,
  `brand_id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `quantity` mediumint(5) NOT NULL,
  `rate` decimal(8,2) NOT NULL,
  `active` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_image`, `brand_id`, `categories_id`, `quantity`, `rate`, `active`, `status`) VALUES
(1, 'Apple MacBook Pro 15in Core i7 2.5GHz Retina (MGXC2LL/A), 16GB Memory, 512GB Solid State Drive', '../assests/images/stock/16504270775f3821a011e34.jpg', 1, 1, 9, '125000.00', 1, 1),
(4, 'Dell Inspiron 15.6 Inch HD Touchscreen Flagship High Performance Laptop PC | Intel Core i5-7200U | 8GB Ram | 256GB SSD | Bluetooth | WiFi | Windows 10 (Black)', '../assests/images/stock/20805620935f381fbe42241.jpg', 3, 1, 3, '22500.00', 1, 1),
(5, 'Acer Aspire 5 Slim Laptop, 15.6 inches Full HD IPS Display, AMD Ryzen 3 3200U, Vega 3 Graphics, 4GB DDR4, 128GB SSD, Backlit Keyboard, Windows 10 in S Mode, A515-43-R19L,Silver', '../assests/images/stock/6956077385f3822d8513ca.jpg', 17, 1, 10, '45000.00', 1, 1),
(6, 'HP Pavilion 15.6 Inch Touchscreen Laptop (Intel 4-Core i7-8565U up to 4.6GHz, 16GB DDR4 RAM, 256GB PCIe SSD, Bluetooth, HDMI, Webcam, Windows 10)', '../assests/images/stock/20580861835f3824eb138ba.jpg', 6, 1, 21, '38000.00', 1, 1),
(7, 'Asus TUF FX505DT Gaming Laptop, 15.6â€ 120Hz Full HD, AMD Ryzen 5 R5-3550H Processor, GeForce GTX 1650 Graphics, 8GB DDR4, 256GB PCIe SSD, Gigabit Wi-Fi 5, Windows 10 Home, FX505DT-AH51, RGB Keyboard', '../assests/images/stock/20090931475f38257462116.jpg', 7, 1, 20, '68500.00', 1, 1),
(8, 'Logitech Keyboard', '../assests/images/stock/12586551835f9311d299381.jpg', 19, 3, 30, '950.00', 1, 1),
(9, 'Dell OptiPlex 7450 All in One Desktop Computer with Touch, Intel Core i5-7500, 8GB DDR4, 500GB Hard Drive, Windows 10 Pro (31JHY) (Renewed)', '../assests/images/stock/14723156875fa006a95f007.jpg', 3, 1, 20, '64386.00', 1, 1),
(10, 'Logitech M525 Wireless Mouse â€“ Long 3 Year Battery Life, Ergonomic Shape for Right or Left Hand Use, Micro-Precision Scroll Wheel, and USB Unifying Receiver for Computers and Laptops, Black/Gray', '../assests/images/stock/5229306055fb5961fbe84e.jpg', 19, 3, 12, '1275.00', 1, 1),
(11, 'Logitech MK850 Performance Wireless Keyboard and Mouse - combo', '../assests/images/stock/21043172265fb59704405d9.jpg', 19, 3, 10, '4690.00', 1, 1),
(12, 'NZXT Kraken X63 280mm - RL-KRX63-01 - AIO RGB CPU Liquid Cooler - Rotating Infinity Mirror Design - Improved Pump - Powered By CAM V4 - RGB Connector - Aer P 140mm Radiator Fans (2 Included)', '../assests/images/stock/17434396695fb599bce1e04.jpg', 22, 2, 3, '16600.00', 1, 1),
(13, 'GIGABYTE Z390 UD, Intel LGA1151/Z390/ATX/M.2/Realtek ALC887/Realtek 8118 Gaming LAN/HDMI/Gaming Motherboard', '../assests/images/stock/16979005775fb59a1e386f5.jpg', 23, 2, 17, '12500.00', 1, 1),
(14, 'ARESGAME Power Supply 500W 80+ Bronze Certified PSU', '../assests/images/stock/11697838475fb59a9f714df.jpg', 21, 2, 3, '6050.00', 1, 1),
(15, 'PNY Quadro P620 Graphic Card - 2 GB GDDR5 - Low-Profile - Single Slot Space Required', '../assests/images/stock/12580887025fb59b725f1ad.jpg', 20, 2, 8, '1340.00', 1, 1),
(16, 'Thermaltake V200 Tempered Glass RGB Edition 12V MB Sync Capable ATX Mid-Tower Chassis with 3 120mm 12V RGB Fan + 1 Black 120mm Rear Fan Pre-Installed CA-1K8-00M1WN-01', '../assests/images/stock/1776517525fb59d4683e0a.jpg', 24, 2, 22, '8730.50', 1, 1),
(17, 'Intel Core I5 3570S - 3.1 Ghz - 4 Cores - 4 Threads - 6 Mb Cache - Lga1155 Socket - Oem \"Product Type: Computer Components/Processors\"', '../assests/images/stock/15883469225fc048184d737.jpg', 27, 2, 16, '5150.00', 1, 1),
(18, 'Seagate â€” Disco rÃ­gido externo 6 TB - central para backup ', '../assests/images/stock/13504770695fc7e9572e4ce.jpg', 25, 3, 6, '14750.50', 1, 1),
(19, 'Laptop para jogos Acer Nitro 5, 9ª geração Intel Core i7-9750H, NVIDIA GeForce RTX 2060, tela Full HD IPS 144Hz, 16GB DDR4, 256GB NVMe SSD, Wi-Fi 6, Waves MaxxAudio, teclado retroiluminado, AN515-54-728C', '../assests/images/stock/17672098385ff388ae809bb.jpg', 17, 1, 18, '85200.00', 1, 1),
(24, 'Sony ', '../assests/images/stock/113770375601264a59ebea.jpg', 29, 3, 50, '4595.50', 1, 1),
(25, 'Bose', '../assests/images/stock/2788228826012696a01bdb.jpg', 16, 3, 24, '6500.00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE `product_details` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `detail` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `active` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_details`
--

INSERT INTO `product_details` (`id`, `product_id`, `detail`, `description`, `active`, `status`) VALUES
(1, 9, 'Tamanho de tela vertical', '23.8 Polegadas', 1, 1),
(2, 9, 'Maximo de resolucao da tela', '1920x1080 Pixels', 1, 1),
(3, 9, 'Modelo de placa de video', 'Integrated Graphics', 1, 1),
(4, 9, 'Descricao do cartao', 'Integrated', 1, 1),
(5, 9, 'Tamanho da memoria flash', '8 GB', 1, 1),
(6, 9, 'Memoria de video', '64 GB', 1, 1),
(7, 9, 'Numero de portas USB 2.0', '2', 1, 1),
(8, 9, 'Sistema operacional', 'Windows 10 Pro', 2, 1),
(9, 9, 'Peso do produto', '3.8 kg', 1, 1),
(10, 7, 'asd', 'asd', 1, 1),
(11, 7, 'vcxvx', 'sdfsd', 1, 1),
(12, 7, 'cvx', 'xcdfg', 2, 1),
(13, 6, 'sdvsd sdf', 'sdf fgfg ', 1, 1),
(14, 6, 'adsa a', 'sdfs cvx', 1, 1),
(15, 6, 'sfdsd sdfsd', 'cxvc', 1, 1),
(16, 6, 'dasdaasda', 'sdfsd', 2, 1),
(17, 12, 'assdsdf sdf sd', 'sdf', 1, 1),
(18, 12, 'sdfsdfs', '34', 2, 1),
(19, 12, 'dfgdf fgfgh', '12', 1, 1),
(20, 19, 'qqqqq', 'erwer', 1, 1),
(21, 19, 'ffffff', 'gfgfgfg', 1, 1),
(22, 19, 'sdfsdf', 'sdfs', 1, 1),
(23, 19, 'gdfgdf', 'qwe3243', 1, 1),
(24, 1, 'asdas', 'sdfsd', 1, 1),
(25, 4, 'asdasd', 'asdasd', 1, 1),
(26, 5, 'gfhfgg fggfgf', 'fghfgh fghfg', 1, 1),
(27, 5, 'we we rewr', 'ew 234', 1, 1),
(28, 25, 'dsdhfghf hf', '500', 1, 1),
(29, 25, 'erw', '3gb', 1, 1),
(30, 25, 'sdfsdf', 'sdfs', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `sub_category_id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `sub_category_name` varchar(255) NOT NULL,
  `active` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`sub_category_id`, `categories_id`, `sub_category_name`, `active`, `status`) VALUES
(1, 1, 'Desktop', 1, 1),
(2, 1, 'Laptop', 1, 1),
(3, 2, 'Roteadores', 1, 1),
(4, 2, 'Motherboards', 1, 1),
(5, 3, 'Mouse ', 1, 1),
(6, 3, 'Teclado', 1, 1),
(7, 4, 'sdfsd', 1, 1),
(8, 4, 'sdfsdf', 1, 1),
(9, 4, 'fgjghj ghj', 1, 1),
(10, 4, 'rtyrtbc fghf', 1, 1),
(11, 4, 'dg dgfd dfgfdg', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `user_image` text CHARACTER SET utf8 NOT NULL,
  `type` int(11) NOT NULL,
  `permittion` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `surname`, `email`, `password`, `user_image`, `type`, `permittion`, `active`, `status`) VALUES
(1, 'Admin1', 'user1', 'admin@users.com', '202cb962ac59075b964b07152d234b70', '../assests/images/users/john.jpg', 1, 1, 1, 1),
(2, 'John', 'Chirindza', 'johnchirindza@gmail.com', '202cb962ac59075b964b07152d234b70', '../assests/images/users/john2.png', 1, 2, 1, 1),
(3, 'Miguel Mario', 'Cuna', 'miguelmario@gmail.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 3, 2, 1),
(4, 'Armando', 'Cossa', 'armandocossa@live.com', 'd41d8cd98f00b204e9800998ecf8427e', '../assests/images/photo_default.png', 1, 3, 1, 1),
(5, 'client', 'user', 'client@users.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, 1, 1),
(6, 'Damiao sdfsdfs sdfsdf ', 'Dabo sdfsd sdf', 'client2@users.com', '7363a0d0604902af7b70b271a0b96480', '../assests/images/photo_default.png', 2, 0, 1, 1),
(7, 'cscs ', 'cscs', 'cscs@cscs.cscs', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, 1, 1),
(8, 'asd asd', 'dsa', 'asd@asd.asd', 'd41d8cd98f00b204e9800998ecf8427e', '../assests/images/photo_default.png', 2, 0, 1, 1),
(9, 'admin2', 'user2', 'admin@pconly.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 1, 1, 1),
(10, 'dsa', 'dsas', 'dsa@das.dsa', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 1, 2, 1),
(11, 'rew', 'ewq', 'qwe@eqw.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, 2, 2),
(12, 'tretr', 'treerr', 'trerer@treere.com', 'd41d8cd98f00b204e9800998ecf8427e', '../assests/images/photo_default.png', 2, 0, 1, 1),
(13, 'xcvxc', 'vcbvbc', 'xcvxc@vcvxc.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 1, 1, 1),
(14, 'dfgdfb', 'fgfgh', 'dfgfg@gfhfg.com', 'd41d8cd98f00b204e9800998ecf8427e', '../assests/images/photo_default.png', 2, 0, 2, 1),
(15, 'ffgdf', 'fgfgas', 'sdfsdf@sad.com', 'd41d8cd98f00b204e9800998ecf8427e', '../assests/images/photo_default.png', 2, 0, 1, 1),
(16, 'asd', 'asd', 'asd1@asd.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 1, 1, 1),
(17, 'fdsa', 'fds', 'fsd@fds.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 3, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`cart_item_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categories_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`order_item_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`sub_category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categories_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `sub_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
