-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Φιλοξενητής: 127.0.0.1
-- Χρόνος δημιουργίας: 24 Ιουν 2019 στις 00:52:08
-- Έκδοση διακομιστή: 10.3.15-MariaDB
-- Έκδοση PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `warehouse`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `price` float NOT NULL,
  `price_with_tax` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Άδειασμα δεδομένων του πίνακα `product`
--

INSERT INTO `product` (`id`, `name`, `quantity`, `cat_id`, `price`, `price_with_tax`) VALUES
(25, 'Cloud Server', 5, 8, 0.07, 0),
(27, 'Mobile Edge Computing (MEC) Server', 4, 7, 5, 6.2),
(30, 'LTE Base Station (eNodeB)', 5, 7, 0.14, 0),
(36, 'LTE Evolved Packet Core (EPC)', 2, 8, 5, 0),
(39, 'Server Test For Tax', 3, 8, 15, 18.6);

--
-- Δείκτες `product`
--
DELIMITER $$
CREATE PROCEDURE tax_calculate(IN price FLOAT, OUT price_with_tax FLOAT)
BEGIN 
	
  SET price_with_tax = price + price * 0.24; 

END 
$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER `tax` BEFORE INSERT ON `product` FOR EACH ROW 
BEGIN 
		call tax_calculate(NEW.`price`, NEW.`price_with_tax`);
END 
$$

DELIMITER ;

DELIMITER $$
CREATE TRIGGER `update_tax` BEFORE UPDATE ON `product` FOR EACH ROW 
BEGIN 
   call tax_calculate(NEW.`price`, NEW.`price_with_tax`);
END
$$ 
DELIMITER ;





-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `product_category`
--

CREATE TABLE `product_category` (
  `category_id` int(11) NOT NULL,
  `category_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Άδειασμα δεδομένων του πίνακα `product_category`
--

INSERT INTO `product_category` (`category_id`, `category_title`) VALUES
(2, 'Mobile Network'),
(7, 'Server Pack'),
(8, 'Servers');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `product_pack`
--

CREATE TABLE `product_pack` (
  `pack_id` int(8) NOT NULL,
  `pack_name` varchar(100) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Άδειασμα δεδομένων του πίνακα `product_pack`
--

INSERT INTO `product_pack` (`pack_id`, `pack_name`, `product_id`, `product_quantity`) VALUES
(8, 'Network Pack', 25, 1);

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Ευρετήρια για πίνακα `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Ευρετήρια για πίνακα `product_pack`
--
ALTER TABLE `product_pack`
  ADD PRIMARY KEY (`pack_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT για πίνακα `product_category`
--
ALTER TABLE `product_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT για πίνακα `product_pack`
--
ALTER TABLE `product_pack`
  MODIFY `pack_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `product_category` (`category_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Περιορισμοί για πίνακα `product_pack`
--
ALTER TABLE `product_pack`
  ADD CONSTRAINT `product_pack_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
