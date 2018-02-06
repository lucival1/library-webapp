-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.26-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for librarydb
CREATE DATABASE IF NOT EXISTS `librarydb` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `librarydb`;

-- Dumping structure for table librarydb.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table librarydb.admin: ~0 rows (approximately)
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`id`, `username`, `password`) VALUES
	(1, 'admin', '122f42374b0f886ef03091698b7062f76d7256c9c2e88ef179609ed946058670250313413d7d9ec067503dd16a4fbfdbedcd19584d68ad3d9a92dafe09da1661');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;

-- Dumping structure for table librarydb.books
CREATE TABLE IF NOT EXISTS `books` (
  `title` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `isbn` int(10) unsigned zerofill NOT NULL,
  `quantity` int(3) unsigned zerofill NOT NULL DEFAULT '000',
  PRIMARY KEY (`isbn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table librarydb.books: ~14 rows (approximately)
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` (`title`, `author`, `isbn`, `quantity`) VALUES
	('Les gens heureux lisent et boivent du cafe', 'Agnes Martin-Lugand', 0000023265, 001),
	('Entre mes mains le bonheur se faufile', 'Agnes Martin-Lugand', 0000106325, 004),
	('The Alchemist', 'Paulo Coelho', 0000133586, 004),
	('Avant toi', 'Jojo Moyes', 0000892572, 002),
	('Who moved my cheese?', 'Spencer Johnson', 0005189345, 004),
	('I\'m off then', 'Hape Kerkeling', 0005535255, 004),
	('The rules of life', 'Richard Templar', 0007987524, 001),
	('Eat, Pray, Love', 'Elizabeth Gilbert', 0008703015, 004),
	('Sur la route', 'Jack Kerouac', 0172615420, 002),
	('Dubliners', 'James Joyce', 0401129416, 004),
	('The day', 'Tom Hanks', 1010101011, 001),
	('The afternoon', 'Tom Hanks', 1010101012, 003),
	('The night', 'Tom Hanks', 1010101013, 001);
/*!40000 ALTER TABLE `books` ENABLE KEYS */;

-- Dumping structure for table librarydb.checked_out_books
CREATE TABLE IF NOT EXISTS `checked_out_books` (
  `student_id` int(7) unsigned zerofill NOT NULL,
  `isbn` int(10) unsigned zerofill NOT NULL,
  `quantity` int(3) unsigned zerofill NOT NULL,
  `acquire_date` date NOT NULL,
  `return_date` date NOT NULL,
  KEY `isbn` (`isbn`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `isbn` FOREIGN KEY (`isbn`) REFERENCES `books` (`isbn`),
  CONSTRAINT `student_id` FOREIGN KEY (`student_id`) REFERENCES `users` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table librarydb.checked_out_books: ~4 rows (approximately)
/*!40000 ALTER TABLE `checked_out_books` DISABLE KEYS */;
INSERT INTO `checked_out_books` (`student_id`, `isbn`, `quantity`, `acquire_date`, `return_date`) VALUES
	(2016227, 0000106325, 001, '2017-11-16', '2017-11-23'),
	(2016228, 0005535255, 001, '2017-11-16', '2017-11-23'),
	(2016228, 0401129416, 001, '2017-11-16', '2017-11-23'),
	(2016227, 0000023265, 001, '2017-11-20', '2017-11-27');
/*!40000 ALTER TABLE `checked_out_books` ENABLE KEYS */;

-- Dumping structure for table librarydb.users
CREATE TABLE IF NOT EXISTS `users` (
  `student_id` int(7) unsigned zerofill NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table librarydb.users: ~4 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`student_id`, `username`, `password`, `tm`) VALUES
	(2016222, 'kyle', '122f42374b0f886ef03091698b7062f76d7256c9c2e88ef179609ed946058670250313413d7d9ec067503dd16a4fbfdbedcd19584d68ad3d9a92dafe09da1661', '2017-12-18 10:23:04'),
	(2016225, 'sean', '122f42374b0f886ef03091698b7062f76d7256c9c2e88ef179609ed946058670250313413d7d9ec067503dd16a4fbfdbedcd19584d68ad3d9a92dafe09da1661', '2017-12-05 10:41:37'),
	(2016227, 'lucival', '122f42374b0f886ef03091698b7062f76d7256c9c2e88ef179609ed946058670250313413d7d9ec067503dd16a4fbfdbedcd19584d68ad3d9a92dafe09da1661', '2017-10-17 10:35:14'),
	(2016228, 'user', '122f42374b0f886ef03091698b7062f76d7256c9c2e88ef179609ed946058670250313413d7d9ec067503dd16a4fbfdbedcd19584d68ad3d9a92dafe09da1661', '2017-10-17 10:39:26'),
	(2016993, 'greg', '122f42374b0f886ef03091698b7062f76d7256c9c2e88ef179609ed946058670250313413d7d9ec067503dd16a4fbfdbedcd19584d68ad3d9a92dafe09da1661', '2017-12-18 10:30:21'),
	(2016999, 'john', '122f42374b0f886ef03091698b7062f76d7256c9c2e88ef179609ed946058670250313413d7d9ec067503dd16a4fbfdbedcd19584d68ad3d9a92dafe09da1661', '2017-12-05 10:34:22');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
