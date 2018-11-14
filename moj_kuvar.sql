-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 31, 2018 at 07:49 PM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moj_kuvar`
--

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

DROP TABLE IF EXISTS `komentar`;
CREATE TABLE IF NOT EXISTS `komentar` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `tekst` varchar(500) NOT NULL,
  `ocena` int(1) NOT NULL,
  `ID_korisnika` int(11) DEFAULT NULL,
  `ID_recepta` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_korisnika` (`ID_korisnika`),
  KEY `ID_recepta` (`ID_recepta`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `komentar`
--

INSERT INTO `komentar` (`ID`, `tekst`, `ocena`, `ID_korisnika`, `ID_recepta`) VALUES
(44, 'Komentar za sarmu!', 4, 11, 80);

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

DROP TABLE IF EXISTS `korisnik`;
CREATE TABLE IF NOT EXISTS `korisnik` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ime` varchar(20) NOT NULL,
  `prezime` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `sifra` varchar(30) NOT NULL,
  `pol` varchar(6) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`ID`, `ime`, `prezime`, `email`, `sifra`, `pol`) VALUES
(11, 'Milos', 'Petrovic', 'milospetrovic008@gmail.com', 'milos123', 'Musko'),
(12, 'Ljubisa', 'Jovanovic', 'miroslavpetrovic@gmail.com', 'miroslav123', 'Musko');

-- --------------------------------------------------------

--
-- Table structure for table `recept`
--

DROP TABLE IF EXISTS `recept`;
CREATE TABLE IF NOT EXISTS `recept` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(50) NOT NULL,
  `tekst` varchar(500) NOT NULL,
  `vreme_pripreme` int(11) NOT NULL,
  `ID_korisnika` int(11) NOT NULL,
  `ID_slike` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_korisnika` (`ID_korisnika`),
  KEY `ID_slike` (`ID_slike`)
) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recept`
--

INSERT INTO `recept` (`ID`, `naziv`, `tekst`, `vreme_pripreme`, `ID_korisnika`, `ID_slike`) VALUES
(81, 'Sarma', 'Sarma !!!', 50, 12, 103),
(80, 'Sarma', 'Sarma!', 20, 11, 101);

-- --------------------------------------------------------

--
-- Table structure for table `slika`
--

DROP TABLE IF EXISTS `slika`;
CREATE TABLE IF NOT EXISTS `slika` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `putanja` varchar(50) NOT NULL,
  `vrsta` varchar(20) NOT NULL,
  `ID_korisnika` int(11) NOT NULL,
  `ID_recepta` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_korisnika` (`ID_korisnika`)
) ENGINE=MyISAM AUTO_INCREMENT=105 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slika`
--

INSERT INTO `slika` (`ID`, `putanja`, `vrsta`, `ID_korisnika`, `ID_recepta`) VALUES
(104, 'pocetna/azurirane slike/Slika.jpg', 'profilna', 11, NULL),
(103, 'pocetna/receptne slike/cabbage_rolls.jpg', 'receptna', 12, 81),
(102, 'slike/male_avatar.png', 'profilna', 12, NULL),
(101, 'pocetna/receptne slike/cabbage_rolls.jpg', 'receptna', 11, 80);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
