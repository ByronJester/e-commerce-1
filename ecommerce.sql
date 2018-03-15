-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2018 at 07:47 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `id` int(11) NOT NULL,
  `product_id` text NOT NULL,
  `cart_quantity` text NOT NULL,
  `ip` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE `tbl_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`id`, `category_name`) VALUES
(1, 'Smartphones'),
(2, 'Shoes'),
(3, 'Secret Shop');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_images`
--

CREATE TABLE `tbl_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_images`
--

INSERT INTO `tbl_images` (`id`, `product_id`, `image_link`) VALUES
(27, 35, 'assets/images/products/94641627.png'),
(28, 36, 'assets/images/products/16923617.jpg'),
(31, 42, 'assets/images/products/66029824.png'),
(32, 43, 'assets/images/products/23174319.jpg'),
(38, 51, 'assets/images/products/89315338.jpg'),
(39, 61, 'assets/images/products/6074935.jpg'),
(40, 61, 'assets/images/products/67324731.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orderinfo`
--

CREATE TABLE `tbl_orderinfo` (
  `id` int(11) NOT NULL,
  `order_num` text NOT NULL,
  `cus_name` varchar(255) NOT NULL,
  `cus_address` varchar(2555) NOT NULL,
  `cus_email` varchar(255) NOT NULL,
  `total` int(11) NOT NULL,
  `order_status` tinyint(4) NOT NULL,
  `date_closed` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_orderinfo`
--

INSERT INTO `tbl_orderinfo` (`id`, `order_num`, `cus_name`, `cus_address`, `cus_email`, `total`, `order_status`, `date_closed`) VALUES
(1, '86515309', 'Jezer Dave Vasquez Bacquian', 'Wow city', 'ion.nightowl@gmail.com', 33500, 3, '2018-03-14'),
(2, '59379569', 'Juan Tamad Dela Cruz', 'brgy. awaw sa chuchu kame', 'juandelacruz@gmail.com', 113000, 0, '2018-03-14'),
(4, '91783654', 'Jezer Dave Tamad Dela Cruz', 'asdasda', 'ion.nightowl@gmail.com', 5000, 2, '2018-03-14'),
(5, '43737732', 'Jezer Dave asdasd asdas', 'dasdasd', 'lorem@gmail.com', 34700, 2, '2018-03-14'),
(7, '86855935', '131231 sadasda sdasda', 'adasdasda', 'ion.nightowl@gmail.com', 25000, 5, '0000-00-00'),
(8, '35104800', 'asdasdasd asdasasd asdasd', 'asdasd', 'ion.nightowl@gmail.com', 25000, 5, '0000-00-00'),
(9, '73434915', 'asdasd asda asdasd', 'adasd', 'ion.nightowl@gmail.com', 25000, 5, '0000-00-00'),
(10, '39566795', 'Jezer Dave asda asdas', 'asdas', 'ion.nightowl@gmail.com', 523456, 5, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE `tbl_orders` (
  `id` int(11) NOT NULL,
  `order_num` text NOT NULL,
  `order_products` text NOT NULL,
  `order_quantity` text NOT NULL,
  `order_status` tinyint(4) NOT NULL,
  `date_closed` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_orders`
--

INSERT INTO `tbl_orders` (`id`, `order_num`, `order_products`, `order_quantity`, `order_status`, `date_closed`) VALUES
(1, '86515309', '43', '5', 3, '2018-03-14'),
(3, '59379569', '36', '3', 0, '2018-03-14'),
(4, '59379569', '42', '4', 0, '2018-03-14'),
(5, '47548898', '36', '4', 2, '2018-03-14'),
(6, '91783654', '35', '1', 2, '2018-03-14'),
(7, '43737732', '51', '1', 2, '2018-03-14'),
(8, '43737732', '36', '1', 2, '2018-03-14'),
(9, '43737732', '43', '1', 2, '2018-03-14'),
(11, '86855935', '36', '1', 5, '0000-00-00'),
(12, '35104800', '36', '1', 5, '0000-00-00'),
(13, '73434915', '36', '1', 5, '0000-00-00'),
(14, '39566795', '61', '1', 5, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `id` int(11) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` text NOT NULL,
  `product_price` varchar(255) NOT NULL,
  `product_stock` int(11) NOT NULL,
  `product_categ` varchar(255) NOT NULL,
  `slug` text NOT NULL,
  `sold` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`id`, `product_code`, `product_name`, `product_description`, `product_price`, `product_stock`, `product_categ`, `slug`, `sold`, `status`) VALUES
(35, '127375628', 'Shadow Blade', 'You weave together threads of shadow to create a sword of solidified gloom into your hand. This magic sword lasts until the spell ends. It counts as a simple melee weapon with which you are proficient. It deals 2d8 psychic damage on hit and has the finesse, light, and thrown properties (range 20/60). In addition, when you use the sword to attack a target that is in dim light or darkness, you make the attack roll with advantage.\r\n\r\nIf you drop the weapon or throw it, it dissipates at the end of the turn. Thereafter, while the spell persists, you can use a bonus action to cause the sword to reappear in your hand.', '5000', 0, 'Secret Shop', 'shadow-blade', 1, 0),
(36, '941181815', 'Aegis of the Immortal', 'Aegis of the Immortal (also known as Aegis) drops from Roshan every time he is killed. It grants the holder an extra life. The Aegis of the Immortal is reclaimed by Roshan 5 minutes after it has been picked up or when Roshan respawns. (This means it is impossible to have more than one Aegis of the Immortal in the game at the same time.)\r\nThe Aegis of the Immortal cannot be dropped, sold, or placed in the backpack.', '25000', 45, 'Secret Shop', 'aegis-of-the-immortal', 2, 0),
(42, '977870334', 'Arc of Manta', 'Manta Style generally synergizes well with heroes that have spells that summon illusions, for the same reasons that they have spells that generate illusions in the first place. Getting an item that does the same thing as an innate spell plays to a hero\\''s natural strengths.', '4500', 1, 'Secret Shop', 'arc-of-manta', 0, 0),
(43, '177075306', 'Divine Rapier', 'Divine Rapier is a powerful weapon assembled with items from the Secret Shop. Divine Rapier is generally bought as either a last-ditch attempt to win, or a way to maintain a big lead. Although it is very expensive, it is the most cost efficient damage item.\r\n\r\nDivine Rapier cannot be sold, placed in the backpack, or destroyed.', '6700', 206, 'Secret Shop', 'divine-rapier', 4, 0),
(49, '763946257', 'De Wae', 'Do you know de wae my brudah?', '500', 5, 'Shoes', 'De-Wae', 0, 1),
(51, '743328218', 'Messerschmidt''s Reaver', 'Reaver is a Secret item purchasable from the Secret Shop. It provides additional strength to the holder and builds into the powerful late game durability items Heart of Tarrasque and Satanic.', '3000', 49, 'Secret Shop', 'Messerschmidt%27s-Reaver', 1, 0),
(60, '285903827', 'adasdas''asdas', 'asdas', '5', 2, 'Smartphones', 'adasdas''asdas', 0, 1),
(61, '691252666', 'New product', 'You weave together threads of shadow to create a sword of solidified gloom into your hand. This magic sword lasts until the spell ends. It counts as a simple melee weapon with which you are proficient. It deals 2d8 psychic damage on hit and has the finesse, light, and thrown properties (range 20/60). In addition, when you use the sword to attack a target that is in dim light or darkness, you make the attack roll with advantage.\r\n\r\nIf you drop the weapon or throw it, it dissipates at the end of the turn. Thereafter, while the spell persists, you can use a bonus action to cause the sword to reappear in your hand.', '523456', 5, 'Smartphones', 'New-product', 0, 0),
(62, '975512628', 'awaw', 'asdasd', '5', 5, 'Shoes', 'awaw', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `access` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `username`, `password`, `access`) VALUES
(1, 'admin', '5f4dcc3b5aa765d61d8327deb882cf99', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_images`
--
ALTER TABLE `tbl_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_orderinfo`
--
ALTER TABLE `tbl_orderinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_images`
--
ALTER TABLE `tbl_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `tbl_orderinfo`
--
ALTER TABLE `tbl_orderinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
