-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server versie:                5.6.16 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Versie:              8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Structuur van  tabel magazijn.barcodes wordt geschreven
DROP TABLE IF EXISTS `barcodes`;
CREATE TABLE IF NOT EXISTS `barcodes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `leverancier` int(11) unsigned DEFAULT NULL,
  `returned` int(1) unsigned NOT NULL DEFAULT '0',
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `code_UNIQUE` (`code`),
  KEY `leverancier_fk_idx` (`leverancier`),
  CONSTRAINT `leverancier_fk` FOREIGN KEY (`leverancier`) REFERENCES `leveranciers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporteren was gedeselecteerd


-- Structuur van  tabel magazijn.leveranciers wordt geschreven
DROP TABLE IF EXISTS `leveranciers`;
CREATE TABLE IF NOT EXISTS `leveranciers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `naam` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `naam_UNIQUE` (`naam`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporteren was gedeselecteerd
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
