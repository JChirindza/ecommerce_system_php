-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 24-Dez-2020 às 22:36
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
(9, 'Panasonic', 2, 2),
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
(24, 'Thermaltake', 1, 1),
(25, 'Seagate', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `paid` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `paid`, `status`) VALUES
(1, 5, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cart_item`
--

CREATE TABLE `cart_item` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cart_item`
--

INSERT INTO `cart_item` (`cart_item_id`, `cart_id`, `product_id`, `quantity`, `status`) VALUES
(1, 1, 1, 3, 1),
(2, 1, 2, 2, 1);

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
  `contact` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `clients`
--

INSERT INTO `clients` (`client_id`, `user_id`, `contact`, `status`, `active`) VALUES
(1, 5, '821231130', 1, 1),
(2, 6, '841441424', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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
(1, '2020-11-20 16:38:28', 'Armandoo', '64564564', '125000.00', '21250.00', '146250.00', '10', '146240.00', '146240', '0.00', 2, 1, 1, '23112.00', 1, 1),
(2, '2020-11-20 16:31:44', 'wer', '3543', '16600.00', '2822.00', '19422.00', '0', '19422.00', '19422', '0.00', 2, 1, 1, '2822.00', 1, 1),
(3, '2020-11-20 15:29:23', 'dfgdf', '65464', '38000.00', '6460.00', '44460.00', '0', '44460.00', '44460', '0.00', 2, 1, 1, '6460.00', 1, 1),
(4, '2020-11-20 16:31:41', 'sdfsd', '456456456', '22500.00', '3825.00', '26325.00', '0', '26325.00', '26325', '0.00', 2, 1, 1, '3825.00', 1, 1),
(5, '2020-11-20 15:40:02', 'fsdfs', '42347676', '50500.00', '8585.00', '59085.00', '0', '59085.00', '59085', '0.00', 2, 1, 1, '8585.00', 1, 1),
(6, '2020-11-20 19:57:43', 'ghhggh', '7656756', '1275.00', '216.75', '1491.75', '0', '1491.75', '1492', '-0.25', 2, 1, 2, '216.75', 1, 1),
(7, '2020-11-22 22:37:42', 'ewrwee', '345345', '45000.00', '7650.00', '52650.00', '0', '52650.00', '52650', '0.00', 2, 1, 1, '7650.00', 1, 1),
(8, '2020-11-22 22:37:39', 'sdfsdf', '3453453453', '247886.00', '42140.62', '290026.62', '100', '289926.62', '289927', '-0.38', 2, 1, 1, '42140.62', 1, 1);

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
(5, 1, 1, '1', '125000', '125000.00', 1),
(6, 1, 13, '1', '12500.00', '12500.00', 1),
(7, 1, 13, '1', '12500.00', '12500.00', 1),
(8, 2, 4, '1', '22500.00', '22500.00', 1),
(9, 2, 12, '1', '16600.00', '16600.00', 1),
(10, 3, 6, '1', '38000.00', '38000.00', 1),
(11, 4, 4, '1', '22500.00', '22500.00', 1),
(14, 5, 6, '1', '38000.00', '38000.00', 1),
(15, 5, 13, '1', '12500.00', '12500.00', 1),
(18, 6, 10, '1', '1275.00', '1275.00', 1),
(19, 8, 5, '4', '45000.00', '180000.00', 1),
(20, 8, 10, '2', '1275.00', '2550.00', 1),
(21, 8, 8, '1', '950.00', '950.00', 1),
(22, 8, 9, '1', '64386.00', '64386.00', 1),
(24, 7, 4, '2', '22500.00', '45000.00', 1);

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
(4, 'Dell Inspiron 15.6 Inch HD Touchscreen Flagship High Performance Laptop PC | Intel Core i5-7200U | 8GB Ram | 256GB SSD | Bluetooth | WiFi | Windows 10 (Black)', '../assests/images/stock/20805620935f381fbe42241.jpg', 3, 1, 14, '22500.00', 1, 1),
(5, 'Acer Aspire 5 Slim Laptop, 15.6 inches Full HD IPS Display, AMD Ryzen 3 3200U, Vega 3 Graphics, 4GB DDR4, 128GB SSD, Backlit Keyboard, Windows 10 in S Mode, A515-43-R19L,Silver', '../assests/images/stock/6956077385f3822d8513ca.jpg', 17, 1, 18, '45000.00', 1, 1),
(6, 'HP Pavilion 15.6 Inch Touchscreen Laptop (Intel 4-Core i7-8565U up to 4.6GHz, 16GB DDR4 RAM, 256GB PCIe SSD, Bluetooth, HDMI, Webcam, Windows 10)', '../assests/images/stock/20580861835f3824eb138ba.jpg', 6, 1, 37, '38000.00', 1, 1),
(7, 'Asus TUF FX505DT Gaming Laptop, 15.6â€ 120Hz Full HD, AMD Ryzen 5 R5-3550H Processor, GeForce GTX 1650 Graphics, 8GB DDR4, 256GB PCIe SSD, Gigabit Wi-Fi 5, Windows 10 Home, FX505DT-AH51, RGB Keyboard', '../assests/images/stock/20090931475f38257462116.jpg', 7, 1, 2, '68500.00', 1, 1),
(8, 'Keyboard', '../assests/images/stock/12586551835f9311d299381.jpg', 19, 3, 11, '950.00', 1, 1),
(9, 'Dell OptiPlex 7450 All in One Desktop Computer with Touch, Intel Core i5-7500, 8GB DDR4, 500GB Hard Drive, Windows 10 Pro (31JHY) (Renewed)', '../assests/images/stock/14723156875fa006a95f007.jpg', 3, 1, 3, '64386.00', 1, 1),
(10, 'Logitech M525 Wireless Mouse â€“ Long 3 Year Battery Life, Ergonomic Shape for Right or Left Hand Use, Micro-Precision Scroll Wheel, and USB Unifying Receiver for Computers and Laptops, Black/Gray', '../assests/images/stock/5229306055fb5961fbe84e.jpg', 19, 3, 7, '1275.00', 1, 1),
(11, 'Logitech MK850 Performance Wireless Keyboard and Mouse Conjunto', '../assests/images/stock/21043172265fb59704405d9.jpg', 19, 3, 3, '4690.00', 1, 1),
(12, 'NZXT Kraken X63 280mm - RL-KRX63-01 - AIO RGB CPU Liquid Cooler - Rotating Infinity Mirror Design - Improved Pump - Powered By CAM V4 - RGB Connector - Aer P 140mm Radiator Fans (2 Included)', '../assests/images/stock/17434396695fb599bce1e04.jpg', 2, 2, 4, '16600.00', 1, 1),
(13, 'GIGABYTE Z390 UD, Intel LGA1151/Z390/ATX/M.2/Realtek ALC887/Realtek 8118 Gaming LAN/HDMI/Gaming Motherboard', '../assests/images/stock/16979005775fb59a1e386f5.jpg', 23, 2, 1, '12500.00', 1, 1),
(14, 'ARESGAME Power Supply 500W 80+ Bronze Certified PSU', '../assests/images/stock/11697838475fb59a9f714df.jpg', 21, 2, 4, '6050.00', 1, 1),
(15, 'PNY Quadro P620 Graphic Card - 2 GB GDDR5 - Low-Profile - Single Slot Space Required', '../assests/images/stock/12580887025fb59b725f1ad.jpg', 20, 2, 2, '1340.00', 1, 1),
(16, 'Thermaltake V200 Tempered Glass RGB Edition 12V MB Sync Capable ATX Mid-Tower Chassis with 3 120mm 12V RGB Fan + 1 Black 120mm Rear Fan Pre-Installed CA-1K8-00M1WN-01', '../assests/images/stock/1776517525fb59d4683e0a.jpg', 24, 2, 3, '8730.00', 1, 1),
(17, 'Intel Core I5 3570S - 3.1 Ghz - 4 Cores - 4 Threads - 6 Mb Cache - Lga1155 Socket - Oem \"Product Type: Computer Components/Processors\"', '../assests/images/stock/15883469225fc048184d737.jpg', 23, 2, 15, '5150.00', 1, 1),
(18, 'Seagate â€” Disco rÃ­gido externo 6 TB - central para backup ', '../assests/images/stock/13504770695fc7e9572e4ce.jpg', 25, 3, 4, '14750.00', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `product_details`
--

CREATE TABLE `product_details` (
  `id` int(11) NOT NULL,
  `details_type` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) CHARACTER SET latin1 NOT NULL,
  `active` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `product_details`
--

INSERT INTO `product_details` (`id`, `details_type`, `product_id`, `name`, `description`, `active`, `status`) VALUES
(1, 2, 9, 'Tamanho de tela vertical', '23.8 Polegadas', 1, 1),
(2, 2, 9, 'Maximo de resolucao da tela', '1920x1080 Pixels', 1, 1),
(3, 2, 9, 'Modelo de placa de video', 'Integrated Graphics', 1, 1),
(4, 2, 9, 'Descricao do cartao', 'Integrated', 1, 1),
(5, 2, 9, 'Tamanho da memoria flash', '8 GB', 1, 1),
(6, 2, 9, 'Memoria de video', '64 GB', 1, 1),
(7, 2, 9, 'Numero de portas USB 2.0', '2', 1, 1),
(8, 2, 9, 'Sistema operacional', 'Windows 10 Pro', 1, 1),
(9, 2, 9, 'Peso do produto', '13.7 kg', 1, 1);

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
(2, 'John', 'Chirindza', 'johnchirindza@gmail.com', '202cb962ac59075b964b07152d234b70', '../assests/images/users/john2.png', 1, 1, 1, 1),
(3, 'Miguel Mario', 'Cuna', 'miguelmario@gmail.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 3, 1, 1),
(4, 'Armando ', 'Cossa', 'armandocossa@live.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 2, 2, 1),
(5, 'client', 'user', 'client@users.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, 1, 1),
(6, 'Damiao ', 'Dabo', 'client2@users.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 2, 1, 1),
(7, 'cscs ', 'cscs', 'cscs@cscs.cscs', 'd41d8cd98f00b204e9800998ecf8427e', '../assests/images/photo_default.png', 2, 0, 1, 1),
(8, 'asd asd', 'dsa', 'asd@asd.asd', 'd41d8cd98f00b204e9800998ecf8427e', '../assests/images/photo_default.png', 2, 0, 1, 1),
(9, 'wer', 'wers', 'wer@wer.wer', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 1, 1, 2),
(10, 'dsa', 'dsas', 'dsa@das.dsa', 'caf1a3dfb505ffed0d024130f58c5cfa', '../assests/images/photo_default.png', 1, 1, 1, 1),
(11, 'rew', 'ewq', 'qwe@eqw.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 2, 0, 1, 2),
(12, 'tretr', 'treerr', 'trerer@treere.com', 'd41d8cd98f00b204e9800998ecf8427e', '../assests/images/photo_default.png', 2, 0, 1, 1),
(13, 'xcvxc', 'vcbvbc', 'xcvxc@vcvxc.com', '202cb962ac59075b964b07152d234b70', '../assests/images/photo_default.png', 1, 1, 1, 1),
(14, 'dfgdfb', 'fgfgh', 'dfgfg@gfhfg.com', 'd41d8cd98f00b204e9800998ecf8427e', '../assests/images/photo_default.png', 2, 0, 1, 1);

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
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
