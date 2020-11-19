-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 19-Nov-2020 às 03:05
-- Versão do servidor: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- Estrutura da tabela `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `brand_active` int(11) NOT NULL DEFAULT '0',
  `brand_status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `brands`
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
(21, 'ARESGAME', 1, 1),
(22, 'NZXT', 1, 1),
(23, 'GIGABYTE', 1, 1),
(24, 'Thermaltake', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `categories`
--

CREATE TABLE `categories` (
  `categories_id` int(11) NOT NULL,
  `categories_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `categories_active` int(11) NOT NULL DEFAULT '0',
  `categories_status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `categories`
--

INSERT INTO `categories` (`categories_id`, `categories_name`, `categories_active`, `categories_status`) VALUES
(1, 'Computadores', 1, 1),
(2, 'Hardware e PeÃ§as de rede', 1, 1),
(3, 'Componentes de Computador', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `clients`
--

INSERT INTO `clients` (`client_id`, `user_id`, `name`, `surname`, `contact`, `status`, `active`) VALUES
(1, 5, 'Armando', 'Cossa', '821231130', 1, 1),
(2, 6, 'Jaime', 'Fontes', '841441424', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
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
  `order_status` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `orders`
--

INSERT INTO `orders` (`order_id`, `order_date`, `client_name`, `client_contact`, `sub_total`, `vat`, `total_amount`, `discount`, `grand_total`, `paid`, `due`, `payment_type`, `payment_status`, `payment_place`, `gstn`, `order_status`, `user_id`) VALUES
(1, '1970-01-01', 'Armando', '64564564', '147500.00', '25075.00', '172575.00', '10', '172565.00', '152000', '20565.00', 2, 1, 2, '23112.00', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `order_item`
--

CREATE TABLE `order_item` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT '0',
  `quantity` varchar(255) NOT NULL,
  `rate` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `order_item_status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `order_item`
--

INSERT INTO `order_item` (`order_item_id`, `order_id`, `product_id`, `quantity`, `rate`, `total`, `order_item_status`) VALUES
(5, 0, 2, '1', '16000', '16000.00', 1),
(6, 1, 1, '1', '125000', '125000.00', 1),
(7, 1, 4, '1', '22500', '22500.00', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `product_image` text CHARACTER SET utf8 NOT NULL,
  `brand_id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `quantity` mediumint(5) NOT NULL,
  `rate` decimal(8,2) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_image`, `brand_id`, `categories_id`, `quantity`, `rate`, `active`, `status`) VALUES
(1, 'Apple MacBook Pro 15in Core i7 2.5GHz Retina (MGXC2LL/A), 16GB Memory, 512GB Solid State Drive', '../assests/images/stock/16504270775f3821a011e34.jpg', 1, 1, 5, '125000.00', 1, 1),
(4, 'Dell Inspiron 15.6 Inch HD Touchscreen Flagship High Performance Laptop PC | Intel Core i5-7200U | 8GB Ram | 256GB SSD | Bluetooth | WiFi | Windows 10 (Black)', '../assests/images/stock/20805620935f381fbe42241.jpg', 3, 1, 25, '22500.00', 1, 1),
(5, 'Acer Aspire 5 Slim Laptop, 15.6 inches Full HD IPS Display, AMD Ryzen 3 3200U, Vega 3 Graphics, 4GB DDR4, 128GB SSD, Backlit Keyboard, Windows 10 in S Mode, A515-43-R19L,Silver', '../assests/images/stock/6956077385f3822d8513ca.jpg', 17, 1, 25, '45000.00', 1, 1),
(6, 'HP Pavilion 15.6 Inch Touchscreen Laptop (Intel 4-Core i7-8565U up to 4.6GHz, 16GB DDR4 RAM, 256GB PCIe SSD, Bluetooth, HDMI, Webcam, Windows 10)', '../assests/images/stock/20580861835f3824eb138ba.jpg', 6, 1, 40, '38000.00', 1, 1),
(7, 'Asus TUF FX505DT Gaming Laptop, 15.6â€ 120Hz Full HD, AMD Ryzen 5 R5-3550H Processor, GeForce GTX 1650 Graphics, 8GB DDR4, 256GB PCIe SSD, Gigabit Wi-Fi 5, Windows 10 Home, FX505DT-AH51, RGB Keyboard', '../assests/images/stock/20090931475f38257462116.jpg', 7, 1, 2, '68500.00', 1, 1),
(8, 'Keyboard', '../assests/images/stock/12586551835f9311d299381.jpg', 19, 3, 12, '950.00', 1, 1),
(9, 'Dell OptiPlex 7450 All in One Desktop Computer with Touch, Intel Core i5-7500, 8GB DDR4, 500GB Hard Drive, Windows 10 Pro (31JHY) (Renewed)', '../assests/images/stock/14723156875fa006a95f007.jpg', 3, 1, 5, '64386.00', 1, 1),
(10, 'Logitech M525 Wireless Mouse â€“ Long 3 Year Battery Life, Ergonomic Shape for Right or Left Hand Use, Micro-Precision Scroll Wheel, and USB Unifying Receiver for Computers and Laptops, Black/Gray', '../assests/images/stock/5229306055fb5961fbe84e.jpg', 19, 3, 12, '1275.00', 1, 1),
(11, 'Logitech MK850 Performance Wireless Keyboard and Mouse Conjunto', '../assests/images/stock/21043172265fb59704405d9.jpg', 19, 3, 5, '4690.00', 1, 1),
(12, 'NZXT Kraken X63 280mm - RL-KRX63-01 - AIO RGB CPU Liquid Cooler - Rotating Infinity Mirror Design - Improved Pump - Powered By CAM V4 - RGB Connector - Aer P 140mm Radiator Fans (2 Included)', '../assests/images/stock/17434396695fb599bce1e04.jpg', 2, 2, 5, '16600.00', 1, 1),
(13, 'GIGABYTE Z390 UD, Intel LGA1151/Z390/ATX/M.2/Realtek ALC887/Realtek 8118 Gaming LAN/HDMI/Gaming Motherboard', '../assests/images/stock/16979005775fb59a1e386f5.jpg', 23, 2, 4, '12500.00', 1, 1),
(14, 'ARESGAME Power Supply 500W 80+ Bronze Certified PSU', '../assests/images/stock/11697838475fb59a9f714df.jpg', 21, 2, 4, '6050.00', 1, 1),
(15, 'PNY Quadro P620 Graphic Card - 2 GB GDDR5 - Low-Profile - Single Slot Space Required', '../assests/images/stock/12580887025fb59b725f1ad.jpg', 20, 2, 2, '1340.00', 1, 1),
(16, 'Thermaltake V200 Tempered Glass RGB Edition 12V MB Sync Capable ATX Mid-Tower Chassis with 3 120mm 12V RGB Fan + 1 Black 120mm Rear Fan Pre-Installed CA-1K8-00M1WN-01', '../assests/images/stock/1776517525fb59d4683e0a.jpg', 24, 2, 3, '8730.00', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
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
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`user_id`, `name`, `surname`, `email`, `password`, `user_image`, `type`, `permittion`, `active`, `status`) VALUES
(1, 'Admin', 'user1', 'admin@users.com', '202cb962ac59075b964b07152d234b70', '../assests/images/users/john.jpg', 1, 1, 1, 1),
(2, 'John', 'Chirindza', 'johnchirindza@gmail.com', '202cb962ac59075b964b07152d234b70', '../assests/images/users/john2.png', 1, 2, 1, 1),
(3, 'Miguel Mario', 'Cuna', 'miguelmario@gmail.com', 'd9b1d7db4cd6e70935368a1efb10e377', '../assests/images/photo_default.png', 1, 3, 0, 1),
(4, 'Armando ', 'Cossa', 'armandocossa@live.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 2, 2, 1),
(5, 'Jaime', 'Fontes', 'client@hotmail.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, 1, 1),
(6, 'Damiao ', 'Dabo', 'ddabo@gmail.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 2, 1, 1),
(7, 'cscs ', 'cscs', 'cscs@cscs.cscs', 'd41d8cd98f00b204e9800998ecf8427e', '../assests/images/photo_default.png', 2, 0, 1, 1),
(8, 'asd asd', 'dsa', 'asd@asd.asd', 'd41d8cd98f00b204e9800998ecf8427e', '../assests/images/photo_default.png', 2, 0, 1, 1),
(9, 'wer', 'wers', 'wer@wer.wer', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 1, 1, 1),
(10, 'dsa', 'dsas', 'dsa@das.dsa', 'caf1a3dfb505ffed0d024130f58c5cfa', '../assests/images/photo_default.png', 1, 1, 1, 1),
(11, 'rew', 'ewq', 'qwe@eqw.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, 1, 1),
(12, 'tretr', 'treerr', 'trerer@treere.com', 'd41d8cd98f00b204e9800998ecf8427e', '../assests/images/photo_default.png', 2, 0, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

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
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categories_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
