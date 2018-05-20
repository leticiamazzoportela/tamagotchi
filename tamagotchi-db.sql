-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 20-Maio-2018 às 22:12
-- Versão do servidor: 5.7.19
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
-- Database: `tamagotchi-db`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `pet`
--

DROP TABLE IF EXISTS `pet`;
CREATE TABLE IF NOT EXISTS `pet` (
  `idPet` int(11) NOT NULL AUTO_INCREMENT,
  `nomePet` varchar(100) NOT NULL,
  `happyPet` int(100) NOT NULL,
  `hungerPet` int(100) NOT NULL,
  `healthPet` int(100) NOT NULL,
  `sleepPet` int(11) NOT NULL,
  `statePet` varchar(100) NOT NULL,
  `imagem` longblob NOT NULL,
  `idUsuario` int(11) NOT NULL,
  PRIMARY KEY (`idPet`),
  KEY `idUsuario` (`idUsuario`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pet`
--

INSERT INTO `pet` (`idPet`, `nomePet`, `happyPet`, `hungerPet`, `healthPet`, `sleepPet`, `statePet`, `imagem`, `idUsuario`) VALUES
(3, 'lalala', 100, 70, 100, 90, 'normal', 0x73646173, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(50) NOT NULL,
  PRIMARY KEY (`idUsuario`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
