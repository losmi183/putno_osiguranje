-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.21-MariaDB-log - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for paragraf
CREATE DATABASE IF NOT EXISTS `paragraf` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `paragraf`;

-- Dumping structure for table paragraf.dodatna_lica
CREATE TABLE IF NOT EXISTS `dodatna_lica` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nosilac_osiguranja_id` int(10) unsigned NOT NULL,
  `ime_prezime` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datum_rodjenja` date NOT NULL,
  `broj_pasosa` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_nosilac_osiguranja` (`nosilac_osiguranja_id`),
  CONSTRAINT `fk_nosilac_osiguranja` FOREIGN KEY (`nosilac_osiguranja_id`) REFERENCES `nosioci_osiguranja` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table paragraf.dodatna_lica: ~4 rows (approximately)
INSERT INTO `dodatna_lica` (`id`, `nosilac_osiguranja_id`, `ime_prezime`, `datum_rodjenja`, `broj_pasosa`) VALUES
	(1, 103, 'Ana Mikić', '1989-01-01', '987654321'),
	(2, 103, 'M. Mikić', '2024-05-01', '123456789'),
	(3, 104, 'Jelena SimiÄ‡', '1970-01-04', '54645654'),
	(4, 104, 'Vuk SimiÄ‡', '1980-12-15', '15641651651');

-- Dumping structure for table paragraf.nosioci_osiguranja
CREATE TABLE IF NOT EXISTS `nosioci_osiguranja` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ime_prezime` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datum_rodjenja` date NOT NULL,
  `broj_pasosa` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefon` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datum_putovanja_od` date NOT NULL,
  `datum_putovanja_do` date NOT NULL,
  `vrsta_polise` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datum_kreiranja` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table paragraf.nosioci_osiguranja: ~4 rows (approximately)
INSERT INTO `nosioci_osiguranja` (`id`, `ime_prezime`, `datum_rodjenja`, `broj_pasosa`, `telefon`, `email`, `datum_putovanja_od`, `datum_putovanja_do`, `vrsta_polise`, `datum_kreiranja`) VALUES
	(101, 'Petar petroviÄ‡', '1990-01-01', '65432123456', '060 000 000', 'petar@mail.com', '2024-06-01', '2024-06-15', 'individualno', '2024-05-14 18:08:50'),
	(102, 'Jovan JovanoviÄ‡', '1980-01-01', '12345654321', '069 069069', 'Jovan @mail.com', '2024-05-15', '2024-05-18', 'individualno', '2024-05-14 18:10:18'),
	(103, 'Mika MikÄ‡', '1985-05-05', '5432154321', '0610610 61', 'mila@mail.com', '2024-05-20', '2024-05-30', 'grupno', '2024-05-14 18:12:35'),
	(104, 'Sima SimiÄ‡', '1960-12-12', '192837465', '063063063', 'sima@gmail.com', '2024-05-15', '2024-05-17', 'grupno', '2024-05-14 18:17:32');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
