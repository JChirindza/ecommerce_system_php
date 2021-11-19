-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2021 at 01:12 AM
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
-- Table structure for table `acquisitions`
--

CREATE TABLE `acquisitions` (
  `acquisition_id` int(11) NOT NULL,
  `fornecedor_name` varchar(255) DEFAULT NULL,
  `fornecedor_contact` varchar(255) DEFAULT NULL,
  `sub_total` double NOT NULL,
  `frete` double NOT NULL,
  `grand_total` double NOT NULL,
  `active` enum('1','2') NOT NULL,
  `status` enum('1','2') NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `brand_active` enum('1','2') NOT NULL,
  `brand_status` enum('1','2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`, `brand_active`, `brand_status`) VALUES
(1, 'Apple', '1', '1'),
(2, 'Lenovo', '1', '1'),
(3, 'Dell', '1', '1'),
(4, 'Alienware', '1', '1'),
(5, 'Google', '1', '1'),
(6, 'Hp', '1', '1'),
(7, 'Asus', '1', '1'),
(8, 'MI', '1', '1'),
(9, 'Panasonic', '2', '1'),
(10, 'Samsung', '1', '1'),
(11, 'Sandisk', '2', '1'),
(12, 'Moto', '1', '1'),
(13, 'VIVO', '1', '1'),
(14, 'Infinix', '2', '1'),
(15, 'Honor', '1', '1'),
(16, 'Bose', '1', '1'),
(17, 'Acer', '1', '1'),
(18, 'Toshiba', '1', '1'),
(19, 'Logitech', '1', '1'),
(20, 'PNY', '1', '1'),
(21, 'ARESGAME', '1', '1'),
(22, 'NZXT', '1', '1'),
(23, 'GIGABYTE', '1', '1'),
(24, 'Thermaltake', '1', '1'),
(25, 'Seagate', '1', '1'),
(26, 'zxczxc', '2', '2'),
(27, 'Intel', '1', '1'),
(28, 'vxcvxc xcv', '2', '1'),
(29, 'Sony', '1', '1'),
(30, 'Kensingston', '2', '1'),
(31, 'Invens', '2', '1'),
(32, 'Rekam', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_status` enum('1','2') NOT NULL,
  `active` enum('1','2') NOT NULL,
  `status` enum('1','2') NOT NULL,
  `cart_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `payment_status`, `active`, `status`, `cart_date`) VALUES
(1, 5, '1', '1', '1', '2021-10-17 21:45:26'),
(2, 1, '2', '1', '1', '2021-10-17 22:46:32'),
(3, 5, '1', '1', '1', '2021-10-18 12:07:51'),
(4, 6, '1', '1', '1', '2021-10-18 16:31:35'),
(5, 6, '1', '1', '1', '2021-10-18 16:38:03'),
(6, 6, '2', '1', '1', '2021-10-18 17:53:45'),
(7, 6, '1', '1', '1', '2021-10-18 19:29:22'),
(8, 5, '1', '1', '1', '2021-10-19 14:20:06'),
(9, 2, '2', '1', '1', '2021-10-21 14:20:50'),
(10, 5, '1', '1', '1', '2021-11-01 17:22:30'),
(11, 5, '2', '1', '1', '2021-11-19 02:10:14');

-- --------------------------------------------------------

--
-- Table structure for table `cart_has_paid`
--

CREATE TABLE `cart_has_paid` (
  `cart_has_paid_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `sub_total` float NOT NULL,
  `vat` float NOT NULL,
  `total_amount` float NOT NULL,
  `discount` float NOT NULL,
  `grand_total` float NOT NULL,
  `payment_type` enum('1','2','3') NOT NULL,
  `dt_paid` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart_has_paid`
--

INSERT INTO `cart_has_paid` (`cart_has_paid_id`, `cart_id`, `client_id`, `sub_total`, `vat`, `total_amount`, `discount`, `grand_total`, `payment_type`, `dt_paid`) VALUES
(1, 1, 1, 10300, 0.17, 12051, 0, 12051, '1', '2021-10-17 20:46:17'),
(2, 4, 2, 1275, 0.17, 1491.75, 0, 1491.75, '2', '2021-10-18 14:33:54'),
(3, 5, 2, 105000, 0.17, 122850, 0, 122850, '2', '2021-10-18 15:53:40'),
(5, 7, 2, 14780.5, 0.17, 17293.2, 0, 17293.2, '2', '2021-10-18 23:03:08'),
(6, 3, 1, 12500, 0.17, 14625, 0, 14625, '1', '2021-10-19 12:18:09'),
(7, 8, 1, 578302, 0.17, 676614, 0, 676614, '2', '2021-11-01 15:21:34'),
(8, 10, 1, 672676, 0.17, 787031, 0, 787031, '2', '2021-11-19 00:09:53');

-- --------------------------------------------------------

--
-- Table structure for table `cart_item`
--

CREATE TABLE `cart_item` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `active` enum('1','2') NOT NULL,
  `status` enum('1','2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart_item`
--

INSERT INTO `cart_item` (`cart_item_id`, `cart_id`, `product_id`, `quantity`, `active`, `status`) VALUES
(1, 1, 17, 2, '1', '1'),
(2, 3, 13, 1, '1', '1'),
(3, 4, 10, 1, '1', '1'),
(4, 5, 1, 1, '1', '1'),
(5, 7, 16, 1, '1', '1'),
(6, 7, 14, 1, '1', '1'),
(7, 8, 9, 2, '1', '1'),
(8, 8, 1, 1, '1', '1'),
(9, 8, 17, 1, '1', '1'),
(10, 8, 16, 1, '1', '1'),
(11, 8, 13, 1, '1', '1'),
(12, 8, 12, 1, '1', '1'),
(13, 8, 14, 1, '1', '1'),
(14, 8, 4, 1, '1', '1'),
(15, 8, 5, 1, '1', '1'),
(16, 8, 26, 3, '1', '1'),
(17, 10, 4, 1, '1', '1'),
(18, 10, 5, 1, '1', '1'),
(20, 10, 7, 1, '1', '1'),
(21, 10, 1, 1, '1', '1'),
(22, 10, 27, 1, '1', '1'),
(23, 10, 6, 5, '1', '1'),
(24, 10, 9, 1, '1', '1'),
(25, 10, 15, 1, '1', '1'),
(26, 10, 8, 1, '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `cart_item_has_paid`
--

CREATE TABLE `cart_item_has_paid` (
  `cart_item_has_paid_id` int(11) NOT NULL,
  `cart_has_paid_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `paid_price` float NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart_item_has_paid`
--

INSERT INTO `cart_item_has_paid` (`cart_item_has_paid_id`, `cart_has_paid_id`, `product_id`, `paid_price`, `quantity`) VALUES
(1, 1, 17, 5150, 2),
(2, 2, 10, 1275, 1),
(3, 3, 1, 105000, 1),
(4, 5, 16, 8730.5, 1),
(5, 5, 14, 6050, 1),
(6, 6, 13, 12500, 1),
(7, 7, 9, 64386, 2),
(8, 7, 1, 105000, 1),
(9, 7, 17, 5150, 1),
(10, 7, 16, 8730.5, 1),
(11, 7, 13, 12500, 1),
(12, 7, 12, 16600, 1),
(13, 7, 14, 6050, 1),
(14, 7, 4, 22500, 1),
(15, 7, 5, 45000, 1),
(16, 7, 26, 76000, 3),
(17, 8, 4, 22500, 1),
(18, 8, 5, 45000, 1),
(19, 8, 7, 68500, 1),
(20, 8, 1, 105000, 1),
(21, 8, 27, 175000, 1),
(22, 8, 6, 38000, 5),
(23, 8, 9, 64386, 1),
(24, 8, 15, 1340, 1),
(25, 8, 8, 950, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categories_id` int(11) NOT NULL,
  `categories_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `categories_active` enum('1','2') CHARACTER SET utf8 NOT NULL DEFAULT '1',
  `categories_status` enum('1','2') CHARACTER SET utf8 NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categories_id`, `categories_name`, `categories_active`, `categories_status`) VALUES
(1, 'Computers', '1', '1'),
(2, 'Hardware and network parts', '1', '1'),
(3, 'Computer components', '2', '1'),
(4, 'sdasdas', '2', '1'),
(5, 'rtyr rtyrtyr rtyrtyrt', '1', '1'),
(6, 'dfgdfg dfg', '2', '1'),
(7, 'egtttytr rtyrttryt', '2', '1'),
(8, 'asda', '2', '2');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gender` enum('1','2') DEFAULT NULL,
  `country` int(11) DEFAULT 1,
  `province` varchar(255) DEFAULT NULL,
  `district` int(11) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `active` enum('1','2') NOT NULL,
  `status` enum('1','2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `user_id`, `gender`, `country`, `province`, `district`, `contact`, `active`, `status`) VALUES
(1, 5, NULL, 1, NULL, NULL, '845533321', '1', '1'),
(2, 6, NULL, 1, NULL, NULL, '845454545', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_address`
--

CREATE TABLE `delivery_address` (
  `delivery_address_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `country` int(11) NOT NULL DEFAULT 1,
  `province` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `reference_point` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `delivery_address`
--

INSERT INTO `delivery_address` (`delivery_address_id`, `client_id`, `country`, `province`, `address`, `reference_point`, `postal_code`) VALUES
(1, 1, 1, 2, 'Matola Fomento, Rua das dunas, casa 321', 'Farmancia Fdsfsdfsdfsdf', '11114'),
(2, 2, 1, 2, 'Matola &quot;C&quot;, rua Carlos Viera, casa 1132', 'Escola primaria 1 de Maio', '2342');

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
  `order_status` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_date`, `client_name`, `client_contact`, `sub_total`, `vat`, `total_amount`, `discount`, `grand_total`, `paid`, `due`, `payment_type`, `payment_status`, `order_status`, `user_id`) VALUES
(1, '2020-11-20 16:38:28', 'Armandoo', '64564564', '125000.00', '21250.00', '146250.00', '10', '146240.00', '146240', '0.00', 2, 1, 1, 1),
(2, '2020-11-20 16:31:44', 'wer', '3543', '16600.00', '2822.00', '19422.00', '0', '19422.00', '19422', '0.00', 2, 1, 1, 1),
(3, '2020-11-20 15:29:23', 'dfgdf', '65464', '38000.00', '6460.00', '44460.00', '0', '44460.00', '44460', '0.00', 2, 1, 1, 1),
(4, '2021-02-04 17:49:50', 'sdfsd', '456456456', '22500.00', '3825.00', '26325.00', '0', '26325.00', '26325', '0.00', 2, 1, 1, 2),
(5, '2021-06-19 14:15:22', 'fsdfs', '42347676', '6500.00', '1105.00', '7605.00', '0', '7605.00', '7605.00', '0.00', 2, 1, 1, 1),
(6, '2021-01-24 15:03:10', 'ghhggh', '7656756', '1275.00', '216.75', '1491.75', '0', '1491.75', '1492', '-0.25', 0, 1, 1, 5),
(7, '2020-11-22 22:37:42', 'ewrwee', '345345', '45000.00', '7650.00', '52650.00', '0', '52650.00', '52650', '0.00', 2, 1, 1, 1),
(8, '2020-11-22 22:37:39', 'sdfsdf', '3453453453', '247886.00', '42140.62', '290026.62', '100', '289926.62', '289927', '-0.38', 2, 1, 1, 1),
(9, '2021-01-17 02:04:34', 'cvbcvb sdfsd', '45546565', '125000.00', '21250.00', '146250.00', '0', '146250.00', '146250', '0.00', 1, 1, 1, 1),
(10, '2021-02-04 17:49:47', 'sdfs', '8797899788', '1340.00', '227.80', '1567.80', '0', '1567.80', '0', '1567.80', 2, 1, 1, 2),
(11, '2021-01-17 14:50:54', 'dfgdf', '654645', '1340.00', '227.80', '1567.80', '0', '1567.80', '0', '1567.80', 1, 1, 1, 1),
(12, '2021-01-17 14:50:50', 'dgfdfg ', '654645465645', '5150.00', '875.50', '6025.50', '0', '6025.50', '6025.5', '0.00', 2, 1, 1, 1),
(13, '2021-02-04 17:49:44', 'sdfds sfds', '356456456', '6050.00', '1028.50', '7078.50', '0', '7078.50', '7078.5', '0.00', 2, 1, 1, 2),
(14, '2021-02-04 11:28:23', 'hdfhdfgd jhvj', '434535678', '38000.00', '6460.00', '44460.00', '0', '44460.00', '44460', '0.00', 3, 1, 1, 1),
(15, '2021-03-01 18:46:56', 'dfgdfgd', '435453453', '179252.50', '30472.93', '209725.43', '0', '209725.43', '39511.48', '170213.95', 2, 1, 1, 1),
(16, '2021-02-04 17:52:18', 'dsdf sdf', '8234345345', '503512.00', '85597.04', '589109.04', '0', '589109.04', '589109.04', '0.00', 2, 1, 1, 4),
(17, '2021-02-04 16:25:29', 'ssds sdfdf sdf', '8434345465', '176900.00', '30073.00', '206973.00', '0', '206973.00', '206973.00', '0.00', 3, 1, 1, 1),
(18, '2021-06-15 20:27:15', 'sdfdfsd sdf', '85345345', '157500.00', '26775.00', '184275.00', '0', '184275.00', '184275.00', '0.00', 2, 1, 1, 22),
(19, '2021-10-16 14:52:23', 'fsdf', '82343454567', '13000.00', '2210.00', '15210.00', '0', '15210.00', '15210.00', '0.00', 2, 1, 1, 1),
(20, '2021-03-01 17:25:50', 'swerwer erwe', '8523424564', '404457.50', '68757.77', '473215.27', '0', '473215.27', '44460.00', '428755.27', 2, 1, 1, 1),
(21, '2021-02-04 16:53:18', 'hghghg hgh', '873455466', '90000.00', '15300.00', '105300.00', '0', '105300.00', '105300.00', '0.00', 2, 1, 1, 4),
(22, '2021-03-01 18:18:46', 'Joana De Melo', '848454544', '482850.00', '82084.50', '564934.50', '0', '564934.50', '564934.50', '0.00', 2, 1, 1, 1),
(23, '2021-06-15 20:36:05', 'dsfsdf', '54564', '106500.00', '18105.00', '124605.00', '0', '124605.00', '99684', '24921.00', 2, 1, 1, 22),
(24, '2021-10-10 02:19:40', 'sdfsd', '54345345', '250000.00', '42500.00', '292500.00', '0', '292500.00', '146250.00', '146250.00', 2, 1, 1, 1),
(25, '2021-10-10 02:20:55', 'Jose Mabunda', '845200223', '85200.00', '14484.00', '99684.00', '0', '99684.00', '99684', '0.00', 2, 1, 1, 1),
(26, '2021-10-10 21:09:59', 'Jose Mabunda ds', '845200223', '85200.00', '14484.00', '99684.00', '0', '99684.00', '99684', '0.00', 2, 1, 1, 1),
(27, '2021-10-10 02:21:17', 'Jose Mabunda ds', '845200223', '85200.00', '14484.00', '99684.00', '0', '99684.00', '99684', '0.00', 2, 1, 1, 1),
(28, '2021-10-10 21:19:20', 'jnkjnkjk', '85200563', '22500.00', '3825.00', '26325.00', '0', '26325.00', '26325', '0.00', 2, 1, 1, 1),
(29, '2021-10-10 21:20:33', 'lknlkl', 'lnkmlk', '4595.50', '781.24', '5376.74', '0', '5376.74', '5376.74', '0.00', 2, 1, 1, 1),
(30, '2021-10-10 21:21:05', 'lknlkl sdasda', '84554656', '4595.50', '781.24', '5376.74', '0', '5376.74', '5376.74', '0.00', 2, 1, 1, 1),
(31, '2021-10-10 21:24:14', 'sdfsdf dsfd', '844451555', '950.00', '161.50', '1111.50', '0', '1111.50', '1111.5', '0.00', 2, 1, 1, 1),
(32, '2021-10-10 21:25:50', 'asdas', '8546846', '16600.00', '2822.00', '19422.00', '0', '19422.00', '19422', '0.00', 2, 1, 1, 1),
(33, '2021-10-10 21:26:03', 'asdas asdasda asdas', '8546846', '16600.00', '2822.00', '19422.00', '0', '19422.00', '19422', '0.00', 2, 1, 1, 1),
(34, '2021-10-10 21:30:29', 'aaaaaa', '3453453', '16600.00', '2822.00', '19422.00', '0', '19422.00', '19422', '0.00', 2, 1, 1, 1),
(35, '2021-10-10 21:32:14', 'asdas', '4564564', '6050.00', '1028.50', '7078.50', '0', '7078.50', '7078.5', '0.00', 2, 1, 1, 1),
(36, '2021-10-10 21:32:25', 'asdas', '4564564', '6050.00', '1028.50', '7078.50', '0', '7078.50', '7078.5', '0.00', 2, 1, 1, 1),
(37, '2021-10-10 21:32:44', 'asdas', '4564564', '6050.00', '1028.50', '7078.50', '0', '7078.50', '7078.5', '0.00', 2, 1, 1, 1),
(38, '2021-10-10 21:34:23', 'asdas', '1234234', '45000.00', '7650.00', '52650.00', '0', '52650.00', '52650', '0.00', 2, 1, 1, 1),
(39, '2021-10-10 21:34:32', 'asdas', '1234234', '45000.00', '7650.00', '52650.00', '0', '52650.00', '52650', '0.00', 2, 1, 1, 1),
(40, '2021-10-11 05:22:50', 'asdas', '1234234', '45000.00', '7650.00', '52650.00', '100', '52550.00', '52650', '-100.00', 2, 1, 1, 1),
(41, '2021-10-11 05:41:57', 'wwwwww', '878888555', '68500.00', '11645.00', '80145.00', '0', '80145.00', '80145', '0.00', 2, 1, 1, 1),
(42, '2021-10-15 20:47:28', 'werwerr', '3534534', '12500.00', '2125.00', '14625.00', '0', '14625.00', '14625', '0.00', 2, 1, 1, 3),
(43, '2021-10-11 06:07:11', 'dfgdfgd', '848481253', '22500.00', '3825.00', '26325.00', '0', '26325.00', '26325.00', '0.00', 2, 1, 1, 1),
(44, '2021-10-11 06:08:03', 'sdfsdf', '5464564', '16600.00', '2822.00', '19422.00', '0', '19422.00', '19422.00', '0.00', 2, 1, 1, 1),
(45, '2021-10-11 06:08:31', 'sdfsdf sdfsd', '5464564', '16600.00', '2822.00', '19422.00', '0', '19422.00', '19422.00', '0.00', 2, 1, 1, 1),
(46, '2021-10-11 06:09:33', 'asdasd', '56756756', '16600.00', '2822.00', '19422.00', '0', '19422.00', '19422.00', '0.00', 2, 1, 1, 1),
(47, '2021-10-11 06:12:31', 'ggggggg', '858585520', '1275.00', '216.75', '1491.75', '0', '1491.75', '1491.75', '0.00', 2, 1, 1, 1),
(48, '2021-11-19 00:19:11', 'Fernando Jose Maria Mabunda', '868754454', '176450.00', '29996.50', '206446.50', '0', '206446.50', '206446.50', '0.00', 3, 1, 1, 1),
(49, '2021-11-19 00:26:54', 'qweqw', '3456456', '9840.00', '1672.80', '11512.80', '0', '11512.80', '11512.80', '0.00', 2, 1, 1, 1),
(50, '2021-10-19 06:11:18', 'tyrttyty', '561561516', '68500.00', '11645.00', '80145.00', '0', '80145.00', '80145', '0', 2, 1, 1, 1),
(51, '2021-10-11 08:27:12', 'jjkjkjkj', '85542121', '1275.00', '216.75', '1491.75', '0', '1491.75', '1491.75', '0', 2, 1, 2, 1),
(52, '2021-10-11 08:35:14', 'nnnnbbbb', '585825', '16600.00', '2822.00', '19422.00', '0', '19422.00', '0', '19422.00', 2, 3, 1, 1),
(53, '2021-11-19 00:36:42', 'ghghghghg', '8585522', '64386.00', '10945.62', '75331.62', '0', '75331.62', '45331.62', '30000.00', 2, 2, 1, 1),
(54, '2021-11-19 00:49:35', 'sdasda', '45345', '45000.00', '7650.00', '52650.00', '0', '52650.00', '52650.00', '0.00', 2, 1, 1, 1),
(55, '2021-11-19 01:58:08', 'sdfsdf', '534534', '25000.00', '4250.00', '29250.00', '0', '29250.00', '29250.00', '0.00', 2, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `rate` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `order_item_status` int(11) NOT NULL
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
(249, 15, 1, '1', '125000.00', '125000.00', 1),
(407, 18, 5, '1', '45000.00', '45000.00', 1),
(408, 18, 4, '1', '22500.00', '22500.00', 1),
(409, 18, 5, '2', '45000.00', '90000.00', 1),
(412, 23, 6, '1', '38000.00', '38000.00', 1),
(413, 23, 7, '1', '68500.00', '68500.00', 1),
(417, 5, 25, '1', '6500.00', '6500.00', 1),
(418, 24, 1, '1', '125000.00', '125000.00', 1),
(419, 25, 19, '1', '85200.00', '85200.00', 1),
(420, 26, 19, '1', '85200.00', '85200.00', 1),
(421, 27, 19, '1', '85200.00', '85200.00', 1),
(422, 28, 4, '1', '22500.00', '22500.00', 1),
(423, 29, 24, '1', '4595.50', '4595.50', 1),
(424, 30, 24, '1', '4595.50', '4595.50', 1),
(425, 31, 8, '1', '950.00', '950.00', 1),
(426, 32, 12, '1', '16600.00', '16600.00', 1),
(427, 33, 12, '1', '16600.00', '16600.00', 1),
(428, 34, 12, '1', '16600.00', '16600.00', 1),
(429, 35, 14, '1', '6050.00', '6050.00', 1),
(430, 36, 14, '1', '6050.00', '6050.00', 1),
(431, 37, 14, '1', '6050.00', '6050.00', 1),
(432, 38, 5, '1', '45000.00', '45000.00', 1),
(433, 39, 5, '1', '45000.00', '45000.00', 1),
(434, 40, 5, '1', '45000.00', '45000.00', 1),
(438, 41, 7, '1', '68500.00', '68500.00', 1),
(453, 43, 4, '1', '22500.00', '22500.00', 1),
(454, 44, 12, '1', '16600.00', '16600.00', 1),
(455, 45, 12, '1', '16600.00', '16600.00', 1),
(456, 46, 12, '1', '16600.00', '16600.00', 1),
(457, 47, 10, '1', '1275.00', '1275.00', 1),
(477, 51, 10, '1', '1275.00', '1275.00', 2),
(479, 52, 12, '1', '16600.00', '16600.00', 1),
(481, 42, 13, '1', '12500.00', '12500.00', 1),
(489, 19, 25, '1', '6500.00', '6500.00', 1),
(490, 19, 25, '1', '6500.00', '6500.00', 1),
(491, 50, 7, '1', '68500.00', '68500.00', 1),
(514, 48, 19, '2', '85200.00', '170400.00', 1),
(515, 48, 14, '1', '6050.00', '6050.00', 1),
(524, 49, 17, '1', '5150.00', '5150.00', 1),
(525, 49, 11, '1', '4690.00', '4690.00', 1),
(526, 53, 9, '1', '64386.00', '64386.00', 1),
(527, 54, 5, '1', '45000.00', '45000.00', 1),
(529, 55, 13, '2', '12500.00', '25000.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(455) CHARACTER SET utf8 NOT NULL,
  `product_description` text CHARACTER SET utf8 DEFAULT NULL,
  `product_image` text CHARACTER SET utf8 NOT NULL,
  `brand_id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `quantity` mediumint(5) NOT NULL,
  `rate` decimal(8,2) NOT NULL,
  `active` enum('1','2') NOT NULL,
  `status` enum('1','2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_description`, `product_image`, `brand_id`, `categories_id`, `quantity`, `rate`, `active`, `status`) VALUES
(1, 'Apple MacBook Pro 15in Core i7 2.5GHz Retina (MGXC2LL/A), 16GB Memory, 512GB Solid State Drive', '1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n4. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n5. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam', '../assests/images/stock/16504270775f3821a011e34.jpg', 1, 1, -1, '105000.00', '1', '1'),
(4, 'Dell Inspiron 15.6 Inch HD Touchscreen Flagship High Performance Laptop PC | Intel Core i5-7200U | 8GB Ram | 256GB SSD | Bluetooth | WiFi | Windows 10 (Black)', '1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n4. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n5. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam', '../assests/images/stock/20805620935f381fbe42241.jpg', 3, 1, 1, '22500.00', '1', '1'),
(5, 'Acer Aspire 5 Slim Laptop, 15.6 inches Full HD IPS Display, AMD Ryzen 3 3200U, Vega 3 Graphics, 4GB DDR4, 128GB SSD, Backlit Keyboard, Windows 10 in S Mode, A515-43-R19L,Silver', '1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n4. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n5. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam', '../assests/images/stock/6956077385f3822d8513ca.jpg', 17, 1, 9, '45000.00', '1', '1'),
(6, 'HP Pavilion 15.6 Inch Touchscreen Laptop (Intel 4-Core i7-8565U up to 4.6GHz, 16GB DDR4 RAM, 256GB PCIe SSD, Bluetooth, HDMI, Webcam, Windows 10)', '1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n4. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n5. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam', '../assests/images/stock/20580861835f3824eb138ba.jpg', 6, 1, 14, '38000.00', '1', '1'),
(7, 'Asus TUF FX505DT Gaming Laptop, 15.6â€ 120Hz Full HD, AMD Ryzen 5 R5-3550H Processor, GeForce GTX 1650 Graphics, 8GB DDR4, 256GB PCIe SSD, Gigabit Wi-Fi 5, Windows 10 Home, FX505DT-AH51, RGB Keyboard', '1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n4. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n5. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam', '../assests/images/stock/20090931475f38257462116.jpg', 7, 1, 13, '68500.00', '1', '1'),
(8, 'Logitech Keyboard', '1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n4. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n5. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam', '../assests/images/stock/12586551835f9311d299381.jpg', 19, 3, 5, '950.00', '1', '1'),
(9, 'Dell OptiPlex 7450 All in One Desktop Computer with Touch, Intel Core i5-7500, 8GB DDR4, 500GB Hard Drive, Windows 10 Pro (31JHY) (Renewed)', '1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n4. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n5. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam', '../assests/images/stock/14723156875fa006a95f007.jpg', 3, 1, 14, '64386.00', '1', '1'),
(10, 'Logitech M525 Wireless Mouse â€“ Long 3 Year Battery Life, Ergonomic Shape for Right or Left Hand Use, Micro-Precision Scroll Wheel, and USB Unifying Receiver for Computers and Laptops, Black/Gray', '1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n4. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n5. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam', '../assests/images/stock/5229306055fb5961fbe84e.jpg', 19, 3, 3, '1275.00', '1', '1'),
(11, 'Logitech MK850 Performance Wireless Keyboard and Mouse - combo', '1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n4. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n5. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam', '../assests/images/stock/21043172265fb59704405d9.jpg', 19, 3, 7, '4690.00', '1', '1'),
(12, 'NZXT Kraken X63 280mm - RL-KRX63-01 - AIO RGB CPU Liquid Cooler - Rotating Infinity Mirror Design - Improved Pump - Powered By CAM V4 - RGB Connector - Aer P 140mm Radiator Fans (2 Included)', '1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n4. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n5. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam', '../assests/images/stock/17434396695fb599bce1e04.jpg', 22, 2, 0, '16600.00', '1', '1'),
(13, 'GIGABYTE Z390 UD, Intel LGA1151/Z390/ATX/M.2/Realtek ALC887/Realtek 8118 Gaming LAN/HDMI/Gaming Motherboard', '1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n4. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n5. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam', '../assests/images/stock/16979005775fb59a1e386f5.jpg', 23, 2, 9, '12500.00', '1', '1'),
(14, 'ARESGAME Power Supply 500W 80+ Bronze Certified PSU', '1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n4. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n5. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam', '../assests/images/stock/11697838475fb59a9f714df.jpg', 21, 2, 12, '6050.00', '1', '1'),
(15, 'PNY Quadro P620 Graphic Card - 2 GB GDDR5 - Low-Profile - Single Slot Space Required', '1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n4. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n5. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam', '../assests/images/stock/12580887025fb59b725f1ad.jpg', 20, 2, 5, '1340.00', '1', '1'),
(16, 'Thermaltake V200 Tempered Glass RGB Edition 12V MB Sync Capable ATX Mid-Tower Chassis with 3 120mm 12V RGB Fan + 1 Black 120mm Rear Fan Pre-Installed CA-1K8-00M1WN-01', '1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n4. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n5. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam', '../assests/images/stock/1776517525fb59d4683e0a.jpg', 24, 2, 16, '8730.50', '1', '1'),
(17, 'Intel Core I5 3570S - 3.1 Ghz - 4 Cores - 4 Threads - 6 Mb Cache - Lga1155 Socket - Oem \"Product Type: Computer Components/Processors\"', '1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n4. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n5. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam', '../assests/images/stock/15883469225fc048184d737.jpg', 27, 2, 7, '5150.00', '1', '1'),
(18, 'Seagate Disco ri­gido externo 6 TB - central para backup ', '1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n4. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n5. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam', '../assests/images/stock/13504770695fc7e9572e4ce.jpg', 25, 3, 18, '14750.50', '1', '1'),
(19, 'Laptop para jogos Acer Nitro 5, 9ª geração Intel Core i7-9750H, NVIDIA GeForce RTX 2060, tela Full HD IPS 144Hz, 16GB DDR4, 256GB NVMe SSD, Wi-Fi 6, Waves MaxxAudio, teclado retroiluminado, AN515-54-728C', '1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n4. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n5. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam', '../assests/images/stock/17672098385ff388ae809bb.jpg', 17, 1, 10, '85200.00', '1', '1'),
(24, 'Sony ', '1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n4. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n5. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam', '../assests/images/stock/113770375601264a59ebea.jpg', 29, 3, 41, '4595.50', '1', '1'),
(25, 'Bose', '1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n4. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n5. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam', '../assests/images/stock/2788228826012696a01bdb.jpg', 16, 3, 12, '6500.00', '1', '1'),
(26, 'Gaming Laptop Acer Nitro 5, 7ª geração Intel Core i5-5750H, NVIDIA GeForce RTX 2060, tela Full HD IPS 144Hz, 8GB DDR4, 256GB NVMe SSD, Wi-Fi 6, Waves MaxxAudio, teclado retroiluminado, AN516-54-348C', '1. 9th Generation Intel Core i5-9300H Processor (Up to 4.1 GHz)\r\n\r\n2. 15.6 inches Full HD Widescreen IPS LED-backlit display; NVIDIA GeForce GTX 1650 Graphics with 4 GB of dedicated GDDR5 VRAM\r\n\r\n3. 8GB DDR4 2666MHz Memory; 256GB PCIe NVMe SSD (2 x PCIe M.2 slots - 1 slot open for easy upgrades) and 1 - Available hard drive bay\r\n\r\n4. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam\r\n\r\n5. LAN: 10, 100, 1000 Gigabit Ethernet LAN (RJ-45 port); Wireless: Intel Wireless Wi-Fi 6 AX200 802.11ax\r\n\r\n6. Backlit keyboard; Acer Cool Boost technology with twin fans and dual exhaust ports', '../assests/images/stock/1860861486072dde24f8f4.jpg', 17, 1, 10, '76000.00', '1', '1'),
(27, 'Dell Latitude 9510 15 2 in 1 Notebook - Intel Core i7-10310U 1.7GHz', '1. Product Type:Notebook Computer;\r\n\r\n2. Item Package Weight:1.86 Kilograms;\r\n\r\n4. Item Package Dimension:8.102 cm L X35.509 cm W X39.090 cm H;\r\n\r\n5. Country Of Origin: China\r\n\r\n6. Latitude Laptops & 2-in-1 PCs Our most secure and manageable commercial laptops, delivering reliable productivity for your end-users.\r\n', '../assests/images/stock/85166466081924fc0294.jpg', 3, 1, 9, '175000.00', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE `product_details` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `detail` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `active` enum('1','2') NOT NULL,
  `status` enum('1','2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_details`
--

INSERT INTO `product_details` (`id`, `product_id`, `detail`, `description`, `active`, `status`) VALUES
(1, 9, 'Tamanho de tela vertical', '23.8 Polegadas', '1', '1'),
(2, 9, 'Maximo de resolucao da tela', '1920x1080 Pixels', '1', '1'),
(3, 9, 'Modelo de placa de video', 'Integrated Graphics', '1', '1'),
(4, 9, 'Descricao do cartao', 'Integrated', '1', '1'),
(5, 9, 'Tamanho da memoria flash', '8 GB', '1', '1'),
(6, 9, 'Memoria de video', '64 GB', '1', '1'),
(7, 9, 'Numero de portas USB 2.0', '2', '1', '1'),
(8, 9, 'Sistema operacional', 'Windows 10 Pro', '2', '1'),
(9, 9, 'Peso do produto', '3.8 kg', '1', '1'),
(10, 7, 'asd', 'asd', '1', '1'),
(11, 7, 'vcxvx', 'sdfsd', '1', '1'),
(12, 7, 'cvx', 'xcdfg', '2', '1'),
(13, 6, 'sdvsd sdf', 'sdf fgfg ', '1', '1'),
(14, 6, 'adsa a', 'sdfs cvx', '1', '1'),
(15, 6, 'sfdsd sdfsd', 'cxvc', '1', '1'),
(16, 6, 'dasdaasda', 'sdfsd', '2', '1'),
(17, 12, 'assdsdf sdf sd', 'sdf', '1', '1'),
(18, 12, 'sdfsdfs', '34', '2', '1'),
(19, 12, 'dfgdf fgfgh', '12', '1', '1'),
(20, 19, 'qqqqq', 'erwer', '1', '1'),
(21, 19, 'ffffff', 'gfgfgfg', '1', '1'),
(22, 19, 'sdfsdf', 'sdfs', '1', '1'),
(23, 19, 'gdfgdf', 'qwe3243', '1', '1'),
(24, 1, 'asdas', 'sdfsd', '1', '1'),
(25, 4, 'asdasd', 'asdasd', '1', '1'),
(26, 5, 'gfhfgg fggfgf', 'fghfgh fghfg', '1', '1'),
(27, 5, 'we we rewr', 'ew 234', '1', '1'),
(28, 25, 'dsdhfghf hf', '500', '2', '2'),
(29, 25, 'erw', '3gb', '1', '1'),
(30, 25, 'sdfsdf', 'sdfs', '1', '1'),
(31, 25, 'sdadsasd asd', 'fsfs 545', '1', '1'),
(32, 15, 'asdas ', '112px asda', '1', '1'),
(33, 26, 'dasdas', '12', '2', '2'),
(34, 26, 'sdfsd ', '23', '2', '2'),
(35, 27, 'Screen Resolution', '1920 x 1200', '1', '1'),
(36, 26, 'dfgdfgd', 'sdfsdf', '1', '1'),
(37, 26, 'sdfs 5456 df', '23r 455d', '1', '1'),
(38, 26, 'RAM', '8GB', '1', '1'),
(39, 26, 'SSD', '256GB', '1', '1'),
(40, 27, 'Standing screen display size', '15 Inches', '1', '1'),
(41, 26, 'asdasda as', '2342 fg', '1', '1'),
(44, 27, 'Max Screen Resolution', '1920 x 1200', '1', '1'),
(45, 27, 'Processor', '1.7 GHz core_i5', '1', '1'),
(46, 27, 'RAM', '16 GB', '1', '1'),
(47, 27, 'Hard Drive', '‎256 GB', '1', '1'),
(52, 27, 'CPU Model Manufacturer', 'Intel', '1', '1'),
(53, 27, 'Hard Disk Size', '256 GB', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `request_id` int(11) NOT NULL,
  `cart_has_paid_id` int(11) NOT NULL,
  `payment_type` enum('1','2','3') NOT NULL,
  `active` enum('1','2') NOT NULL,
  `dt_requested` timestamp NOT NULL DEFAULT current_timestamp(),
  `dt_responded` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`request_id`, `cart_has_paid_id`, `payment_type`, `active`, `dt_requested`, `dt_responded`) VALUES
(1, 1, '1', '2', '2021-10-17 20:46:17', '2021-10-18 21:53:32'),
(2, 2, '2', '2', '2021-10-18 14:33:54', '2021-10-18 19:53:40'),
(3, 3, '2', '2', '2021-10-18 15:53:40', '2021-10-18 19:25:23'),
(4, 5, '2', '2', '2021-10-18 23:03:08', '2021-10-19 03:19:23'),
(5, 6, '1', '2', '2021-10-19 12:18:10', '2021-10-31 08:48:30'),
(6, 7, '2', '1', '2021-11-01 15:21:34', '2021-11-01 15:21:34'),
(7, 8, '2', '1', '2021-11-19 00:09:53', '2021-11-19 00:09:53');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `sub_category_id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `sub_category_name` varchar(255) NOT NULL,
  `active` enum('1','2') NOT NULL,
  `status` enum('1','2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`sub_category_id`, `categories_id`, `sub_category_name`, `active`, `status`) VALUES
(1, 1, 'Desktop', '1', '1'),
(2, 1, 'Laptop', '1', '1'),
(3, 2, 'Routers', '1', '1'),
(4, 2, 'Motherboards', '1', '1'),
(5, 3, 'Mouse ', '1', '1'),
(6, 3, 'Keyboards', '1', '1'),
(7, 4, 'sdfsd', '1', '1'),
(8, 4, 'sdfsdf', '1', '1'),
(9, 4, 'fgjghj ghj', '1', '1'),
(10, 4, 'rtyrtbc fghf', '1', '1'),
(11, 4, 'dg dgfd dfgfdg', '1', '1'),
(12, 5, 'sdfsdfsd fdsdfs sfd', '1', '1'),
(13, 5, 'sdfsdfsdf fds', '1', '1'),
(14, 5, 'sdfsdf', '1', '1'),
(15, 6, 'sdfsffdd', '1', '1'),
(16, 6, 'qweqw qwe', '2', '1'),
(17, 7, 'sdfsd', '2', '2'),
(18, 7, 'vcbvbcvgfh fggf', '2', '2'),
(19, 3, 'Hard Disk Drive - External', '1', '1'),
(20, 2, 'CPU', '1', '1'),
(21, 2, 'Graphic card', '1', '1'),
(22, 3, 'Headphones', '1', '1'),
(39, 1, 'asdas', '2', '2'),
(40, 1, 'dfgdgdf  gdfgdf', '2', '2'),
(41, 1, 'fg dfg dfg dfg', '1', '1'),
(42, 1, 'dasda', '2', '2'),
(43, 2, 'RAM', '2', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `surname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `user_image` text CHARACTER SET utf8 NOT NULL,
  `type` int(11) NOT NULL,
  `permittion` int(11) NOT NULL,
  `active` enum('1','2') CHARACTER SET utf8 NOT NULL,
  `status` enum('1','2') CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `surname`, `email`, `password`, `user_image`, `type`, `permittion`, `active`, `status`) VALUES
(1, 'Admin1', 'user1', 'admin@users.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 1, '1', '1'),
(2, 'John', 'Chirindza', 'johnchirindza@gmail.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 2, '1', '1'),
(3, 'Miguel Mario', 'Cuna', 'miguelmario@gmail.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 3, '1', '1'),
(4, 'Armando', 'Cossa', 'armandocossa@live.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 3, '1', '1'),
(5, 'client', 'user1', 'client@users.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, '1', '1'),
(6, 'Damiao ', 'Dabo', 'client2@users.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, '1', '1'),
(7, 'cscs ', 'cscs', 'cscs@cscs.cscs', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, '1', '1'),
(8, 'asd asd', 'dsa', 'asd@asd.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, '1', '1'),
(9, 'admin2', 'user2', 'admin@pconly.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 1, '1', '1'),
(10, 'dsa', 'dsas', 'dsa@das.dsa', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 1, '2', '1'),
(11, 'rew', 'ewq', 'qwe@eqw.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, '2', '2'),
(12, 'tretr', 'treerr', 'trerer@treere.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, '1', '1'),
(13, 'xcvxc', 'vcbvbc', 'xcvxc@vcvxc.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 1, '2', '1'),
(14, 'dfgdfb', 'fgfgh', 'dfgfg@gfhfg.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, '2', '1'),
(15, 'ffgdf', 'fgfgas', 'sdfsdf@sad.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, '1', '1'),
(16, 'asd', 'asd', 'asd1@asd.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 1, '2', '2'),
(17, 'fdsa', 'fds', 'fsd@fds.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 3, '2', '2'),
(18, 'asdas', 'asdas', 'asda@sadsd.cppm', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 1, '1', '1'),
(19, 'Dddd', 'ssd', 'dddssd@dmail.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, '1', '1'),
(20, 'Fabio Julio', 'Mahumane', 'fabiom@fmail.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, '1', '1'),
(21, 'hjvhj', 'sdfsdf', 'sdfsdf@dmaasdil.com', '51d3ab6534b38f81ff65ec3a602d5b10', '../assests/images/photo_default.png', 1, 1, '2', '2'),
(22, 'ytuytuy', 'dfsdf', 'dfdfsd@fsdf.cpom', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 1, '2', '2'),
(23, 'Gustavo', 'Tome', 'gtome@gmail.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, '1', '1'),
(24, 'asd', 'asda', 'asdas@asda.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, '1', '1'),
(25, 'dercio', 'fumo', 'dercio@gmail.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, '1', '1'),
(26, 'Alfredo', 'Macombo', 'alfredo_macombo@hotmail.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, '1', '1'),
(27, 'Daria', 'Homeneno', 'dhome@fds.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, '1', '1'),
(28, 'Fulano de', 'X', 'fulanodex@clients.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, '1', '1'),
(29, 'asdasd', 'ewrwe', 'sadas@gmail.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, '1', '1'),
(30, 'Neide', 'Carlos', 'neidecarlos@hotmail.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, '1', '1'),
(31, 'asda', 'dfsadfs', 'sdfsd@dfsf.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, '1', '1'),
(32, 'Fausto', 'Malate', 'faustomalate@hotmail.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 2, '1', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acquisitions`
--
ALTER TABLE `acquisitions`
  ADD PRIMARY KEY (`acquisition_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart_has_paid`
--
ALTER TABLE `cart_has_paid`
  ADD PRIMARY KEY (`cart_has_paid_id`),
  ADD UNIQUE KEY `cart_id` (`cart_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `cart_item_has_paid`
--
ALTER TABLE `cart_item_has_paid`
  ADD PRIMARY KEY (`cart_item_has_paid_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `cart_has_paid_id` (`cart_has_paid_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categories_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `country` (`country`),
  ADD KEY `province` (`province`);

--
-- Indexes for table `delivery_address`
--
ALTER TABLE `delivery_address`
  ADD PRIMARY KEY (`delivery_address_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `categories_id` (`categories_id`);

--
-- Indexes for table `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`request_id`),
  ADD UNIQUE KEY `cart_has_paid_id` (`cart_has_paid_id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`sub_category_id`),
  ADD KEY `categories_id` (`categories_id`);

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
-- AUTO_INCREMENT for table `acquisitions`
--
ALTER TABLE `acquisitions`
  MODIFY `acquisition_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cart_has_paid`
--
ALTER TABLE `cart_has_paid`
  MODIFY `cart_has_paid_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `cart_item_has_paid`
--
ALTER TABLE `cart_item_has_paid`
  MODIFY `cart_item_has_paid_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categories_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `delivery_address`
--
ALTER TABLE `delivery_address`
  MODIFY `delivery_address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=530;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `sub_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `cart_has_paid`
--
ALTER TABLE `cart_has_paid`
  ADD CONSTRAINT `cart_has_paid_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_has_paid_ibfk_2` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD CONSTRAINT `cart_item_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `cart_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `cart_item_has_paid`
--
ALTER TABLE `cart_item_has_paid`
  ADD CONSTRAINT `cart_item_has_paid_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION;

--
-- Constraints for table `delivery_address`
--
ALTER TABLE `delivery_address`
  ADD CONSTRAINT `delivery_address_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION;

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE NO ACTION;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`brand_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`categories_id`) ON DELETE NO ACTION;

--
-- Constraints for table `product_details`
--
ALTER TABLE `product_details`
  ADD CONSTRAINT `product_details_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION;

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`cart_has_paid_id`) REFERENCES `cart_has_paid` (`cart_has_paid_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_ibfk_1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`categories_id`) ON DELETE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
