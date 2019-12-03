-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 03, 2019 at 10:34 AM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reservationsalles`
--

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `debut` datetime NOT NULL,
  `fin` datetime NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `titre`, `description`, `debut`, `fin`, `id_utilisateur`) VALUES
(1, 'Titre?', 'Description!', '2019-11-18 08:00:00', '2019-11-18 09:00:00', 1),
(2, 'Test Ã©vÃ©nement', 'Oui.', '2019-11-18 09:00:00', '2019-11-18 10:00:00', 1),
(3, 'Encore un autre test', '', '2019-11-18 10:00:00', '2019-11-18 11:00:00', 1),
(4, 'OUIII', '', '2019-11-20 10:00:00', '2019-11-20 11:00:00', 1),
(5, 'Jeudi', '', '2019-11-20 11:00:00', '2019-11-20 12:00:00', 1),
(6, 'Mardi', '', '2019-11-19 11:00:00', '2019-11-19 12:00:00', 1),
(7, 'Jeudi', '', '2019-11-21 09:00:00', '2019-11-21 10:00:00', 1),
(8, '19h vendredi', '', '2019-11-22 19:00:00', '2019-11-22 20:00:00', 1),
(9, 'Autre utilisateur', 'a crÃ©Ã© cet Ã©vÃ©nement!', '2019-11-19 08:00:00', '2019-11-19 09:00:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `login`, `password`) VALUES
(3, 'abcdef', '$2y$10$5wZZLSJx0lgxiOSbktucYeueBWETR51JXezfy4cbp9Let2gEHtWXy'),
(4, 'test123', '$2y$10$41Z/t7acZeDwhELlEB1/5OeTQaTBBfJl7R3TJVBOzzTwoxxb2cgpK');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
