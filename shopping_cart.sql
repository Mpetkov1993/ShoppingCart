-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.19 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for shopping_cart
CREATE DATABASE IF NOT EXISTS `shopping_cart` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `shopping_cart`;

-- Dumping structure for table shopping_cart.category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_64C19C15E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table shopping_cart.category: ~7 rows (approximately)
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`id`, `name`) VALUES
	(4, 'Cars'),
	(2, 'Computers'),
	(8, 'Drinks'),
	(7, 'Games'),
	(3, 'Pets'),
	(1, 'Phones'),
	(6, 'Toys');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;

-- Dumping structure for table shopping_cart.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` int(11) NOT NULL,
  `picture` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D34A04AD5E237E06` (`name`),
  KEY `IDX_D34A04AD12469DE2` (`category_id`),
  CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table shopping_cart.product: ~18 rows (approximately)
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` (`id`, `name`, `description`, `quantity`, `price`, `category_id`, `picture`) VALUES
	(2, 'iPhone 7', 'Brand new!', 3, 325.00, 1, 'https://cdn.shopify.com/s/files/1/1474/7424/products/mobile-iphone-7-32gb-5.jpg'),
	(3, 'Lenovo X260', 'Business class thinkpad laptop!', 12, 1900.00, 2, 'https://www.bhphotovideo.com/images/multiple_images/item_images/1469655345000_IMG_661573.jpg'),
	(5, 'Audi RS7', 'Very good condition.', 10, 140635.15, 4, 'http://78.media.tumblr.com/26f60568e60ef15af93f7e65931aefcb/tumblr_o1wcuwNiwj1sda307o1_500.jpg'),
	(6, 'Mercedes S63', 'No need...', 5, 0.00, 4, 'https://78.media.tumblr.com/6292a192979aaeca85cf476a19799689/tumblr_oxgmjfYMnK1ulgke9o1_500.jpg'),
	(7, 'Discus', 'New breed', 8, 30.00, 3, 'http://marinefishdirect.com.au/image/cache/catalog/Created%20/Leopard%20Snakeskin%20Discus%20Fish-500x500.jpg'),
	(15, 'British Cat', 'Baby', 1, 600.00, 3, 'http://pawpost.co.uk/blog/wp-content/uploads/2015/11/tumblr_n17wsjqA7S1qz6ygbo1_500-e1448040034568.jpg'),
	(18, 'Ford Focus ST', 'Scale 1:100', 5, 20.00, 6, 'https://www.dhresource.com/0x0s/f2-albu-g5-M00-BE-C9-rBVaI1iwAvqAfaEJAACxHmvk_uc758.jpg/1-32-scale-ford-focus-st-suv-sound-light.jpg'),
	(19, 'Monopoly', 'Original', 10, 80.00, 7, 'http://truimg.toysrus.co.uk/product/images/UK/TRUP2632780001_CF0001.jpg?resize=500:500'),
	(20, 'Samsung Galaxy S8', 'Brand new', 9, 1400.00, 1, 'https://cdn.pcstore.bg/catalog/product/cache/1/small_image/9df78eab33525d08d6e5fb8d27136e95/s/m/sm-g955fzbabgl_img5970bd0113fcb4.67467514_.jpg'),
	(21, 'iPhone X', '128GB', 3, 2100.00, 1, 'https://img1.cgtrader.com/items/783329/f97ce89de8/large/apple-iphone-x-space-gray-3d-model-low-poly-max-obj-3ds-fbx-c4d.jpg'),
	(22, 'iPhone 8 Plus', '256GB', 10, 1800.00, 1, 'https://dice.bg/content/pics/31470_apple-iphone-8-plus-64gb-tymnosiv-fabrichno-otkliuchen-_1584805852.jpg'),
	(23, 'Samsung Galaxy S7 Edge', 'Black', 15, 900.00, 1, 'https://www.aset-uae.com/galimg/09262017012658SAMSUNG%20GALAXY%20S7%20edge-%20BLACK.png'),
	(24, 'BMW M4', 'Gold.', 1, 76849.45, 4, 'https://78.media.tumblr.com/ad7324ff1750f6a8daf7281b388708f9/tumblr_mzcw14UX6H1sp0h9jo1_500.jpg'),
	(25, 'MacBook Air', '2015', 4, 1999.00, 2, 'https://www.catchdeal.com.au/image/cache/data/tcf_images/Apple/macbook/macbook%20air%20MQD32/Apple%20Macbook%20Air%20MQD32%20Silver-1-500x500.jpg'),
	(26, 'MacBook Pro', '2015', 7, 2399.00, 2, 'https://assets.pcmag.com/media/images/224847-apple-macbook-pro-15-inch-core-i5.jpg?width=500&height=500'),
	(27, 'Lenovo T470', '14" Business class', 9, 2999.00, 2, 'https://www.13it.com.au/assets/thumbL/20HDS02000.jpg'),
	(28, 'Alienware M11x', 'Small beast', 3, 3299.00, 2, 'https://assets.pcmag.com/media/images/230124-alienware-m11x-core-i7.jpg?width=500&height=500'),
	(29, 'Razer Blade Stealth', 'Game or Business -> This thing is perfect for both.', 4, 3599.00, 2, 'https://dzvfs5sz5rprz.cloudfront.net/media/catalog/product/cache/1/image/1200x/040ec09b1e35df139433887a97daa66f/r/a/razer_125_blade_stealth_core_i7_256gb_multi-touch_gaming_laptop_2.jpg');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;

-- Dumping structure for table shopping_cart.product_promotions
CREATE TABLE IF NOT EXISTS `product_promotions` (
  `product_id` int(11) NOT NULL,
  `promotion_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`promotion_id`),
  KEY `IDX_797C6F1F4584665A` (`product_id`),
  KEY `IDX_797C6F1F139DF194` (`promotion_id`),
  CONSTRAINT `FK_797C6F1F139DF194` FOREIGN KEY (`promotion_id`) REFERENCES `promotion` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_797C6F1F4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table shopping_cart.product_promotions: ~0 rows (approximately)
/*!40000 ALTER TABLE `product_promotions` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_promotions` ENABLE KEYS */;

-- Dumping structure for table shopping_cart.promotion
CREATE TABLE IF NOT EXISTS `promotion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount` decimal(4,2) NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C11D7DD15E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table shopping_cart.promotion: ~1 rows (approximately)
/*!40000 ALTER TABLE `promotion` DISABLE KEYS */;
/*!40000 ALTER TABLE `promotion` ENABLE KEYS */;

-- Dumping structure for table shopping_cart.retail_product
CREATE TABLE IF NOT EXISTS `retail_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `picture` longtext COLLATE utf8_unicode_ci NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2AF5F3A28DE820D9` (`seller_id`),
  CONSTRAINT `FK_2AF5F3A28DE820D9` FOREIGN KEY (`seller_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table shopping_cart.retail_product: ~2 rows (approximately)
/*!40000 ALTER TABLE `retail_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `retail_product` ENABLE KEYS */;

-- Dumping structure for table shopping_cart.review
CREATE TABLE IF NOT EXISTS `review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_794381C64584665A` (`product_id`),
  KEY `IDX_794381C6A76ED395` (`user_id`),
  CONSTRAINT `FK_794381C64584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_794381C6A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table shopping_cart.review: ~8 rows (approximately)
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
/*!40000 ALTER TABLE `review` ENABLE KEYS */;

-- Dumping structure for table shopping_cart.role
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_57698A6A5E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table shopping_cart.role: ~2 rows (approximately)
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` (`id`, `name`) VALUES
	(1, 'ROLE_ADMIN'),
	(2, 'ROLE_EDITOR'),
	(3, 'ROLE_USER');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;

-- Dumping structure for table shopping_cart.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cash` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table shopping_cart.user: ~12 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `password`, `email`, `cash`) VALUES
	(16, 'admin', '$2y$13$vnUqKwLcOE9tzrXSxe37NOuDYqK2FbgWoLoakgvBoBaOHeZlllLiS', 'admin@admin.com', 11999.00);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Dumping structure for table shopping_cart.users_carts
CREATE TABLE IF NOT EXISTS `users_carts` (
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`product_id`),
  KEY `IDX_A977EEE5A76ED395` (`user_id`),
  KEY `IDX_A977EEE54584665A` (`product_id`),
  CONSTRAINT `FK_A977EEE54584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_A977EEE5A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table shopping_cart.users_carts: ~3 rows (approximately)
/*!40000 ALTER TABLE `users_carts` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_carts` ENABLE KEYS */;

-- Dumping structure for table shopping_cart.users_roles
CREATE TABLE IF NOT EXISTS `users_roles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `IDX_51498A8EA76ED395` (`user_id`),
  KEY `IDX_51498A8ED60322AC` (`role_id`),
  CONSTRAINT `FK_51498A8EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_51498A8ED60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table shopping_cart.users_roles: ~11 rows (approximately)
/*!40000 ALTER TABLE `users_roles` DISABLE KEYS */;
INSERT INTO `users_roles` (`user_id`, `role_id`) VALUES
	(16, 1);
/*!40000 ALTER TABLE `users_roles` ENABLE KEYS */;

-- Dumping structure for table shopping_cart.user_product
CREATE TABLE IF NOT EXISTS `user_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `picture` longtext COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8B471AA7A76ED395` (`user_id`),
  CONSTRAINT `FK_8B471AA7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table shopping_cart.user_product: ~3 rows (approximately)
/*!40000 ALTER TABLE `user_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_product` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
