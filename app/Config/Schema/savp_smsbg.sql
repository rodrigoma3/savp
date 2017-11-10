-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 10-Nov-2017 às 08:01
-- Versão do servidor: 10.1.10-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `savp_smsbg`
--
CREATE DATABASE IF NOT EXISTS `savp_smsbg` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `savp_smsbg`;

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
  `km` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cars`
--

INSERT INTO `cars` (`id`, `manufacturer`, `model`, `year`, `type`, `car_plate`, `capacity`, `km`, `enabled`, `created`, `modified`) VALUES
(1, 'Fiat', 'Ducato', '2013', 'lotacao', 'ABC-1234', 22, 100, 1, '0000-00-00 00:00:00', '2017-11-10 07:18:53'),
(2, 'GM', 'Astra', '2010', 'lotacao', 'IWW-2541', 11, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'GM', 'Astra', '2013', 'lotacao', 'ASW-5498', 8, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'GM', 'Astra', '2013', 'lotacao', 'ASW-5847', 8, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'GM', 'Astra', '2013', 'lotacao', 'ASW-8748', 8, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'GM', 'Astra', '2013', 'lotacao', 'OED-8748', 8, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'GM', 'Astra', '2013', 'lotacao', 'AWQ-8748', 8, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'Ford', 'Fiesta', '2017', 'lotacao', 'ASW-5845', 23, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'Ford', 'Fiesta', '2017', 'lotacao', 'ASW-7458', 23, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'Ford', 'Fiesta', '2017', 'lotacao', 'ASW-3655', 23, 200, 1, '0000-00-00 00:00:00', '2017-11-10 07:19:01'),
(11, 'Fiat', 'Ducato', '2013', 'lotacao', 'ABC-2558', 21, 300, 1, '0000-00-00 00:00:00', '2017-11-10 07:19:08'),
(12, 'GM', 'Astra ', '2017', 'utilitario', 'EGD-4654', 10, 400, 1, '0000-00-00 00:00:00', '2017-11-10 07:19:15');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cities`
--

INSERT INTO `cities` (`id`, `name`, `enabled`, `created`, `modified`) VALUES
(1, 'Bento Gonçalves', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Caxias do Sul', 1, '2017-11-07 04:38:06', '2017-11-07 04:38:06');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `destinations`
--

INSERT INTO `destinations` (`id`, `city_id`, `time`, `enabled`, `created`, `modified`) VALUES
(1, 1, '06:00:00', 1, '2017-11-05 00:03:36', '2017-11-05 00:03:36'),
(2, 1, '11:00:00', 1, '2017-11-05 00:03:46', '2017-11-05 00:03:46');

-- --------------------------------------------------------

--
-- Estrutura da tabela `diaries`
--

CREATE TABLE IF NOT EXISTS `diaries` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `destination_id` int(10) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL,
  `initial_km` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `final_km` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `car_id` int(10) UNSIGNED NOT NULL,
  `driver_id` int(10) UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `diaries`
--

INSERT INTO `diaries` (`id`, `date`, `destination_id`, `status`, `initial_km`, `final_km`, `car_id`, `driver_id`, `created`, `modified`) VALUES
(6, '2017-11-10', 1, 'opened', 0, 0, 3, 5, '2017-11-10 07:12:01', '2017-11-10 07:12:01'),
(7, '2017-11-10', 2, 'opened', 0, 0, 1, 5, '2017-11-10 07:12:19', '2017-11-10 07:12:19'),
(8, '2017-11-10', 1, 'opened', 0, 0, 8, 5, '2017-11-10 07:12:34', '2017-11-10 07:12:34'),
(9, '2017-11-10', 2, 'opened', 0, 0, 11, 5, '2017-11-10 07:12:44', '2017-11-10 07:12:44');

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
  `sequence` int(11) NOT NULL DEFAULT '1',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `establishments`
--

INSERT INTO `establishments` (`id`, `name`, `phone`, `address`, `number`, `complement`, `neighborhood`, `city_id`, `sequence`, `enabled`, `created`, `modified`) VALUES
(1, 'Tacchini', '99999999', 'rua', 5, NULL, 'centro', 1, 1, 1, '2017-11-05 00:02:57', '2017-11-07 04:51:44'),
(3, 'UPA 24h', '9999', 'rua', 2, NULL, 'centro', 1, 2, 1, '2017-11-07 00:29:08', '2017-11-07 04:51:44');

-- --------------------------------------------------------

--
-- Estrutura da tabela `stops`
--

CREATE TABLE IF NOT EXISTS `stops` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `patient_id` int(10) UNSIGNED NOT NULL,
  `companion_id` int(11) DEFAULT NULL,
  `diary_id` int(10) UNSIGNED NOT NULL,
  `establishment_id` int(10) UNSIGNED NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `bedridden` tinyint(1) NOT NULL DEFAULT '0',
  `absent` tinyint(1) NOT NULL DEFAULT '0',
  `sequence` int(11) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `stops`
--

INSERT INTO `stops` (`id`, `patient_id`, `companion_id`, `diary_id`, `establishment_id`, `start_time`, `end_time`, `bedridden`, `absent`, `sequence`, `created`, `modified`) VALUES
(81, 6, NULL, 6, 1, '04:13:00', '04:13:00', 0, 0, 8, '2017-11-10 07:13:12', '2017-11-10 07:13:12'),
(82, 3, 6, 6, 1, '04:13:00', '04:13:00', 1, 0, 7, '2017-11-10 07:13:12', '2017-11-10 07:13:12'),
(83, 8, NULL, 6, 1, '04:30:00', '04:30:00', 0, 0, 6, '2017-11-10 07:30:37', '2017-11-10 07:30:37'),
(84, 7, 8, 6, 1, '04:30:00', '04:30:00', 0, 0, 5, '2017-11-10 07:30:37', '2017-11-10 07:30:37'),
(85, 10, NULL, 6, 1, '04:30:00', '04:30:00', 0, 0, 4, '2017-11-10 07:30:48', '2017-11-10 07:30:48'),
(86, 9, 10, 6, 1, '04:30:00', '04:30:00', 1, 0, 3, '2017-11-10 07:30:48', '2017-11-10 07:30:48'),
(87, 12, NULL, 6, 1, '04:30:00', '04:30:00', 0, 0, 2, '2017-11-10 07:30:58', '2017-11-10 07:30:58'),
(88, 11, 12, 6, 1, '04:30:00', '04:30:00', 0, 0, 1, '2017-11-10 07:30:58', '2017-11-10 07:30:58');

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
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `last_access` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `document`, `phone`, `address`, `number`, `complement`, `neighborhood`, `telephone_to_message`, `name_for_message`, `city_id`, `email`, `password`, `role`, `enabled`, `created`, `modified`, `last_access`) VALUES
(1, 'Administrador', '0', '', '', 0, '', '', '', '', 1, 'admin@admin.com', '$2a$10$siUMErIX3LA09gF2Cdm/i.t2tvTNExb8Rr.wwB0.Vk1IY41BRQ91S', 'admin', 1, '2017-11-03 00:20:00', '2017-11-10 07:46:42', '2017-11-10 07:46:42'),
(3, 'paciente 1', '0', '', '', 1, '', '', '', '', 1, 'paciente1@email.com', '$2a$10$tICKdR7NNPsFZKMbTkxBpOVxRsGdJne1Yip7m9AMr6Xnyv0NNrugC', 'patient', 1, '2017-11-04 21:09:51', '2017-11-04 21:14:23', '2017-11-04 21:14:23'),
(4, 'Secretario 1', '1', '', '', 1, '', '', NULL, NULL, 1, 'secretario@email.com', NULL, 'secretary', 1, '2017-11-04 23:56:04', '2017-11-04 23:59:21', '0000-00-00 00:00:00'),
(5, 'Motorista 1', '2', '', '', 2, '', '', NULL, NULL, 1, 'motorista@email.com', NULL, 'driver', 1, '2017-11-04 23:58:08', '2017-11-04 23:59:17', '0000-00-00 00:00:00'),
(6, 'Paciente 2', '2', '', '', 2, '', '', '', '', 1, 'paciente2@email.com', NULL, 'patient', 1, '2017-11-06 02:31:00', '2017-11-06 02:31:00', '0000-00-00 00:00:00'),
(7, 'Paciente 3', '3', '', '', 3, '', '', '', '', 1, 'paciente3@email.com', NULL, 'patient', 1, '2017-11-06 23:16:07', '2017-11-06 23:16:07', '0000-00-00 00:00:00'),
(8, 'Paciente 4', '4', '', '', 4, '', '', '', '', 1, 'paciente4@email.com', NULL, 'patient', 1, '2017-11-06 23:16:37', '2017-11-06 23:16:37', '0000-00-00 00:00:00'),
(9, 'Paciente 5', '5', '', '', 5, '', '', '', '', 1, 'paciente5@email.com', NULL, 'patient', 1, '2017-11-06 23:17:24', '2017-11-06 23:17:24', '0000-00-00 00:00:00'),
(10, 'Paciente 6', '6', '', '', 6, '', '', '', '', 1, 'paciente6@email.com', NULL, 'patient', 1, '2017-11-06 23:18:10', '2017-11-06 23:18:10', '0000-00-00 00:00:00'),
(11, 'Paciente 7', '7', '', '', 7, '', '', '', '', 1, 'paciente7@email.com', NULL, 'patient', 1, '2017-11-06 23:18:28', '2017-11-06 23:18:28', '0000-00-00 00:00:00'),
(12, 'Paciente 8', '8', '', '', 8, '', '', '', '', 1, 'paciente8@email.com', NULL, 'patient', 1, '2017-11-06 23:18:45', '2017-11-06 23:18:45', '0000-00-00 00:00:00'),
(13, 'Motorista 2', '2', '', '', 2, '', '', NULL, NULL, 2, 'motorista2@email.com', NULL, 'driver', 1, '2017-11-10 07:21:53', '2017-11-10 07:21:53', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
