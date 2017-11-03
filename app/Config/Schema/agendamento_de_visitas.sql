-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 03-Nov-2017 às 03:48
-- Versão do servidor: 10.1.10-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agendamento_de_visitas`
--
CREATE DATABASE IF NOT EXISTS `agendamento_de_visitas` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `agendamento_de_visitas`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cars`
--

CREATE TABLE IF NOT EXISTS `cars` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `manufacturer` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `year` varchar(4) NOT NULL,
  `type` varchar(255) NOT NULL,
  `car_plate` varchar(8) NOT NULL,
  `capacity` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cars`
--

INSERT INTO `cars` (`id`, `manufacturer`, `model`, `year`, `type`, `car_plate`, `capacity`, `enabled`, `created`, `modified`) VALUES
(1, 'Fiat', 'Ducato', '2013', 'lotacao', 'ABC-1234', 22, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'GM', 'Astra', '2010', 'lotacao', 'IWW-2541', 11, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'GM', 'Astra', '2013', 'lotacao', 'ASW-5498', 8, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'GM', 'Astra', '2013', 'lotacao', 'ASW-5847', 8, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'GM', 'Astra', '2013', 'lotacao', 'ASW-8748', 8, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'GM', 'Astra', '2013', 'lotacao', 'OED-8748', 8, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'GM', 'Astra', '2013', 'lotacao', 'AWQ-8748', 8, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'Ford', 'Fiesta', '2017', 'lotacao', 'ASW-5845', 23, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'Ford', 'Fiesta', '2017', 'lotacao', 'ASW-7458', 23, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'Ford', 'Fiesta', '2017', 'lotacao', 'ASW-3655', 23, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'Fiat', 'Ducato', '2013', 'lotacao', 'ABC-2558', 21, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'GM', 'Astra ', '2017', 'utilitario', 'EGD-4654', 10, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cities`
--

INSERT INTO `cities` (`id`, `name`, `enabled`, `created`, `modified`) VALUES
(1, 'Bento Gonçalves', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `destinations`
--

CREATE TABLE IF NOT EXISTS `destinations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `city_id` int(10) UNSIGNED NOT NULL,
  `time` time NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `diaries`
--

CREATE TABLE IF NOT EXISTS `diaries` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `destination_id` int(10) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL,
  `car_id` int(10) UNSIGNED NOT NULL,
  `driver_id` int(10) UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `establishments`
--

CREATE TABLE IF NOT EXISTS `establishments` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `number` int(11) NOT NULL,
  `complement` int(255) DEFAULT NULL,
  `neighborhood` varchar(255) NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `sequence` int(11) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `stops`
--

CREATE TABLE IF NOT EXISTS `stops` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `patient_id` int(10) UNSIGNED NOT NULL,
  `companion_id` int(11) NOT NULL,
  `diary_id` int(10) UNSIGNED NOT NULL,
  `establishment_id` int(10) UNSIGNED NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `absent` tinyint(1) NOT NULL DEFAULT '0',
  `sequence` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `document` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `number` int(11) NOT NULL,
  `complement` varchar(255) DEFAULT NULL,
  `neighborhood` varchar(255) DEFAULT NULL,
  `telephone_to_message` varchar(255) DEFAULT NULL,
  `name_for_message` varchar(255) DEFAULT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `last_access` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `document`, `phone`, `address`, `number`, `complement`, `neighborhood`, `telephone_to_message`, `name_for_message`, `city_id`, `email`, `password`, `role`, `enabled`, `created`, `modified`, `last_access`) VALUES
(1, 'Administrador', '0', '', '', 0, '', '', '', '', 1, 'admin@admin.com', '$2a$10$siUMErIX3LA09gF2Cdm/i.t2tvTNExb8Rr.wwB0.Vk1IY41BRQ91S', 'admin', 1, '2017-11-03 00:20:00', '2017-11-03 03:43:35', '2017-11-03 03:43:35');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
