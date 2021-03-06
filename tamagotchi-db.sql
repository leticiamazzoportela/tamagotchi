-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 30-Maio-2018 às 20:17
-- Versão do servidor: 5.7.19
-- PHP Version: 7.0.23

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
USE `tamagotchi-db`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `minigames`
--

DROP TABLE IF EXISTS `minigames`;
CREATE TABLE IF NOT EXISTS `minigames` (
  `idMinigame` int(11) NOT NULL AUTO_INCREMENT,
  `nomeMinigame` varchar(50) NOT NULL,
  `pontuacao` int(11) DEFAULT NULL,
  `idPet` int(11) NOT NULL,
  PRIMARY KEY (`idMinigame`),
  KEY `idPet` (`idPet`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `minigames`
--

INSERT INTO `minigames` (`idMinigame`, `nomeMinigame`, `pontuacao`, `idPet`) VALUES
(1, 'Pedra - Papel - Tesoura', 0, 1),
(2, 'Pedra - Papel - Tesoura', 0, 2),
(3, 'Pedra - Papel - Tesoura', 0, 3),
(4, 'Pedra - Papel - Tesoura', 0, 4),
(5, 'Pedra - Papel - Tesoura', 0, 5);

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
  `sleepPet` int(100) NOT NULL,
  `statePet` varchar(100) NOT NULL,
  `imagem` varchar(100) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idade` int(11) NOT NULL,
  `peso` int(11) NOT NULL,
  PRIMARY KEY (`idPet`),
  KEY `idUsuario` (`idUsuario`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pet`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `tempo` bigint(20) NOT NULL,
  PRIMARY KEY (`idUsuario`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
