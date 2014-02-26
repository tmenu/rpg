-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mer 26 Février 2014 à 15:39
-- Version du serveur: 5.5.35-0ubuntu0.13.10.2
-- Version de PHP: 5.5.3-1ubuntu2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `rpg`
--

-- --------------------------------------------------------

--
-- Structure de la table `Game`
--

CREATE TABLE IF NOT EXISTS `Game` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_user` int(11) NOT NULL,
  `ref_map` int(11) NOT NULL,
  `ref_character` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ref_user` (`ref_user`),
  KEY `ref_map` (`ref_map`),
  KEY `ref_character` (`ref_character`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Contenu de la table `Game`
--

INSERT INTO `Game` (`id`, `ref_user`, `ref_map`, `ref_character`) VALUES
(12, 27, 38, 38),
(29, 25, 55, 55),
(33, 25, 59, 59),
(34, 25, 60, 60);

-- --------------------------------------------------------

--
-- Structure de la table `Initial_character`
--

CREATE TABLE IF NOT EXISTS `Initial_character` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `position_x` int(11) NOT NULL,
  `position_y` int(11) NOT NULL,
  `direction` enum('UP','DOWN','LEFT','RIGHT') NOT NULL,
  `ref` varchar(255) NOT NULL,
  `health_max` int(10) unsigned NOT NULL,
  `health` int(10) unsigned NOT NULL,
  `strength` int(10) unsigned NOT NULL,
  `resistance` int(10) unsigned NOT NULL,
  `speed` int(10) unsigned NOT NULL,
  `posture` tinyint(1) NOT NULL,
  `round` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `Initial_character`
--

INSERT INTO `Initial_character` (`id`, `name`, `position_x`, `position_y`, `direction`, `ref`, `health_max`, `health`, `strength`, `resistance`, `speed`, `posture`, `round`) VALUES
(1, 'Guillaume', 0, 0, 'DOWN', 'mage01', 22, 22, 14, 12, 6, 1, 0),
(14, 'Rozy', 0, 0, 'DOWN', 'mage02', 18, 18, 15, 10, 4, 1, 0),
(15, 'Kévina', 0, 0, 'DOWN', 'mage03', 10, 10, 12, 20, 8, 1, 0),
(16, 'Johan', 0, 0, 'DOWN', 'mage04', 20, 20, 11, 8, 7, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `Initial_map`
--

CREATE TABLE IF NOT EXISTS `Initial_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `size_height` int(11) NOT NULL,
  `size_width` int(11) NOT NULL,
  `visible_x` int(11) NOT NULL,
  `visible_y` int(11) NOT NULL,
  `origin_x` int(11) NOT NULL,
  `origin_y` int(11) NOT NULL,
  `map` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `Initial_map`
--

INSERT INTO `Initial_map` (`id`, `name`, `size_height`, `size_width`, `visible_x`, `visible_y`, `origin_x`, `origin_y`, `map`) VALUES
(1, 'Default', 6, 6, 6, 6, 0, 0, 'a:6:{i:0;a:6:{i:0;i:6;i:1;i:1;i:2;i:2;i:3;i:2;i:4;i:2;i:5;i:1;}i:1;a:6:{i:0;i:2;i:1;i:1;i:2;i:2;i:3;i:1;i:4;i:2;i:5;i:1;}i:2;a:6:{i:0;i:2;i:1;i:2;i:2;i:2;i:3;i:1;i:4;i:2;i:5;i:1;}i:3;a:6:{i:0;i:2;i:1;i:1;i:2;i:1;i:3;i:1;i:4;i:2;i:5;i:2;}i:4;a:6:{i:0;i:2;i:1;i:2;i:2;i:2;i:3;i:1;i:4;i:1;i:5;i:2;}i:5;a:6:{i:0;i:1;i:1;i:1;i:2;i:2;i:3;i:1;i:4;i:10;i:5;i:2;}}'),
(2, 'Level 2', 12, 12, 6, 6, 0, 0, 'a:12:{i:0;a:12:{i:0;i:2;i:1;i:1;i:2;i:2;i:3;i:2;i:4;i:2;i:5;i:2;i:6;i:1;i:7;i:2;i:8;i:2;i:9;i:2;i:10;i:2;i:11;i:2;}i:1;a:12:{i:0;i:2;i:1;i:2;i:2;i:1;i:3;i:2;i:4;i:1;i:5;i:2;i:6;i:2;i:7;i:2;i:8;i:1;i:9;i:1;i:10;i:1;i:11;i:2;}i:2;a:12:{i:0;i:2;i:1;i:2;i:2;i:1;i:3;i:2;i:4;i:1;i:5;i:1;i:6;i:1;i:7;i:1;i:8;i:2;i:9;i:2;i:10;i:2;i:11;i:2;}i:3;a:12:{i:0;i:1;i:1;i:2;i:2;i:1;i:3;i:2;i:4;i:2;i:5;i:1;i:6;i:2;i:7;i:2;i:8;i:2;i:9;i:1;i:10;i:1;i:11;i:1;}i:4;a:12:{i:0;i:1;i:1;i:2;i:2;i:2;i:3;i:2;i:4;i:1;i:5;i:1;i:6;i:2;i:7;i:1;i:8;i:2;i:9;i:2;i:10;i:2;i:11;i:2;}i:5;a:12:{i:0;i:2;i:1;i:2;i:2;i:2;i:3;i:2;i:4;i:1;i:5;i:1;i:6;i:2;i:7;i:1;i:8;i:1;i:9;i:2;i:10;i:1;i:11;i:1;}i:6;a:12:{i:0;i:2;i:1;i:1;i:2;i:1;i:3;i:1;i:4;i:2;i:5;i:2;i:6;i:2;i:7;i:2;i:8;i:1;i:9;i:1;i:10;i:2;i:11;i:1;}i:7;a:12:{i:0;i:2;i:1;i:1;i:2;i:2;i:3;i:2;i:4;i:2;i:5;i:1;i:6;i:1;i:7;i:2;i:8;i:2;i:9;i:2;i:10;i:2;i:11;i:2;}i:8;a:12:{i:0;i:2;i:1;i:1;i:2;i:2;i:3;i:1;i:4;i:2;i:5;i:2;i:6;i:2;i:7;i:2;i:8;i:1;i:9;i:1;i:10;i:2;i:11;i:2;}i:9;a:12:{i:0;i:2;i:1;i:1;i:2;i:2;i:3;i:1;i:4;i:2;i:5;i:1;i:6;i:1;i:7;i:1;i:8;i:1;i:9;i:1;i:10;i:1;i:11;i:2;}i:10;a:12:{i:0;i:2;i:1;i:1;i:2;i:2;i:3;i:1;i:4;i:2;i:5;i:1;i:6;i:2;i:7;i:2;i:8;i:1;i:9;i:1;i:10;i:2;i:11;i:2;}i:11;a:12:{i:0;i:2;i:1;i:2;i:2;i:2;i:3;i:1;i:4;i:2;i:5;i:1;i:6;i:1;i:7;i:2;i:8;i:2;i:9;i:2;i:10;i:2;i:11;i:2;}}');

-- --------------------------------------------------------

--
-- Structure de la table `Initial_map_monster`
--

CREATE TABLE IF NOT EXISTS `Initial_map_monster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_map` int(11) NOT NULL,
  `ref_monster` int(11) NOT NULL,
  `position_x` int(11) NOT NULL,
  `position_y` int(11) NOT NULL,
  `direction` enum('UP','DOWN','LEFT','RIGHT') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ref_init_map` (`ref_map`),
  KEY `ref_init_monster` (`ref_monster`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `Initial_map_monster`
--

INSERT INTO `Initial_map_monster` (`id`, `ref_map`, `ref_monster`, `position_x`, `position_y`, `direction`) VALUES
(1, 1, 1, 1, 2, 'LEFT'),
(2, 1, 2, 4, 3, 'UP'),
(3, 2, 1, 1, 2, 'UP'),
(4, 2, 2, 3, 3, 'LEFT');

-- --------------------------------------------------------

--
-- Structure de la table `Initial_monster`
--

CREATE TABLE IF NOT EXISTS `Initial_monster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `position_x` int(11) NOT NULL,
  `position_y` int(11) NOT NULL,
  `direction` enum('UP','DOWN','LEFT','RIGHT') NOT NULL,
  `ref` varchar(255) NOT NULL,
  `health_max` int(10) unsigned NOT NULL,
  `health` int(10) unsigned NOT NULL,
  `strength` int(10) unsigned NOT NULL,
  `resistance` int(10) unsigned NOT NULL,
  `speed` int(10) unsigned NOT NULL,
  `posture` tinyint(1) NOT NULL,
  `round` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `Initial_monster`
--

INSERT INTO `Initial_monster` (`id`, `name`, `position_x`, `position_y`, `direction`, `ref`, `health_max`, `health`, `strength`, `resistance`, `speed`, `posture`, `round`) VALUES
(1, 'Rabivador', 0, 0, 'LEFT', 'rabivador', 15, 15, 12, 6, 7, 1, 0),
(2, 'Crazyfrog', 0, 0, 'UP', 'crazyfrog', 17, 17, 15, 4, 5, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `Playing_character`
--

CREATE TABLE IF NOT EXISTS `Playing_character` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `position_x` int(11) NOT NULL,
  `position_y` int(11) NOT NULL,
  `direction` enum('UP','DOWN','LEFT','RIGHT') NOT NULL,
  `ref` varchar(255) NOT NULL,
  `health_max` int(10) unsigned NOT NULL,
  `health` int(10) unsigned NOT NULL,
  `strength` int(10) unsigned NOT NULL,
  `resistance` int(10) unsigned NOT NULL,
  `speed` int(10) unsigned NOT NULL,
  `posture` tinyint(1) NOT NULL,
  `round` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=61 ;

--
-- Contenu de la table `Playing_character`
--

INSERT INTO `Playing_character` (`id`, `name`, `position_x`, `position_y`, `direction`, `ref`, `health_max`, `health`, `strength`, `resistance`, `speed`, `posture`, `round`) VALUES
(38, 'Rozy', 1, 1, 'RIGHT', 'mage02', 18, 18, 15, 10, 4, 1, 0),
(55, 'Guillaume', 1, 2, 'RIGHT', 'mage01', 22, 22, 14, 12, 6, 1, 0),
(59, 'Johan', 5, 5, 'DOWN', 'mage04', 20, 8, 11, 8, 7, 1, 0),
(60, 'Rozy', 3, 3, 'UP', 'mage02', 18, 13, 15, 10, 4, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `Playing_map`
--

CREATE TABLE IF NOT EXISTS `Playing_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `size_height` int(11) NOT NULL,
  `size_width` int(11) NOT NULL,
  `visible_x` int(11) NOT NULL,
  `visible_y` int(11) NOT NULL,
  `origin_x` int(11) NOT NULL,
  `origin_y` int(11) NOT NULL,
  `map` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=61 ;

--
-- Contenu de la table `Playing_map`
--

INSERT INTO `Playing_map` (`id`, `name`, `size_height`, `size_width`, `visible_x`, `visible_y`, `origin_x`, `origin_y`, `map`) VALUES
(38, 'Level 2', 12, 12, 6, 6, 0, 0, 'a:12:{i:0;a:12:{i:0;i:2;i:1;i:1;i:2;i:2;i:3;i:2;i:4;i:2;i:5;i:2;i:6;i:1;i:7;i:2;i:8;i:2;i:9;i:2;i:10;i:2;i:11;i:2;}i:1;a:12:{i:0;i:2;i:1;i:2;i:2;i:1;i:3;i:2;i:4;i:1;i:5;i:2;i:6;i:2;i:7;i:2;i:8;i:1;i:9;i:1;i:10;i:1;i:11;i:2;}i:2;a:12:{i:0;i:2;i:1;i:2;i:2;i:1;i:3;i:2;i:4;i:1;i:5;i:1;i:6;i:1;i:7;i:1;i:8;i:2;i:9;i:2;i:10;i:2;i:11;i:2;}i:3;a:12:{i:0;i:1;i:1;i:2;i:2;i:1;i:3;i:2;i:4;i:2;i:5;i:1;i:6;i:2;i:7;i:2;i:8;i:2;i:9;i:1;i:10;i:1;i:11;i:1;}i:4;a:12:{i:0;i:1;i:1;i:2;i:2;i:2;i:3;i:2;i:4;i:1;i:5;i:1;i:6;i:2;i:7;i:1;i:8;i:2;i:9;i:2;i:10;i:2;i:11;i:2;}i:5;a:12:{i:0;i:2;i:1;i:2;i:2;i:2;i:3;i:2;i:4;i:1;i:5;i:1;i:6;i:2;i:7;i:1;i:8;i:1;i:9;i:2;i:10;i:1;i:11;i:1;}i:6;a:12:{i:0;i:2;i:1;i:1;i:2;i:1;i:3;i:1;i:4;i:2;i:5;i:2;i:6;i:2;i:7;i:2;i:8;i:1;i:9;i:1;i:10;i:2;i:11;i:1;}i:7;a:12:{i:0;i:2;i:1;i:1;i:2;i:2;i:3;i:2;i:4;i:2;i:5;i:1;i:6;i:1;i:7;i:2;i:8;i:2;i:9;i:2;i:10;i:2;i:11;i:2;}i:8;a:12:{i:0;i:2;i:1;i:1;i:2;i:2;i:3;i:1;i:4;i:2;i:5;i:2;i:6;i:2;i:7;i:2;i:8;i:1;i:9;i:1;i:10;i:2;i:11;i:2;}i:9;a:12:{i:0;i:2;i:1;i:1;i:2;i:2;i:3;i:1;i:4;i:2;i:5;i:1;i:6;i:1;i:7;i:1;i:8;i:1;i:9;i:1;i:10;i:1;i:11;i:2;}i:10;a:12:{i:0;i:2;i:1;i:1;i:2;i:2;i:3;i:1;i:4;i:2;i:5;i:1;i:6;i:2;i:7;i:2;i:8;i:1;i:9;i:1;i:10;i:2;i:11;i:2;}i:11;a:12:{i:0;i:2;i:1;i:2;i:2;i:2;i:3;i:1;i:4;i:2;i:5;i:1;i:6;i:1;i:7;i:2;i:8;i:2;i:9;i:2;i:10;i:2;i:11;i:2;}}'),
(55, 'Default', 6, 6, 6, 6, 0, 0, 'a:6:{i:0;a:6:{i:0;i:6;i:1;i:1;i:2;i:2;i:3;i:2;i:4;i:2;i:5;i:1;}i:1;a:6:{i:0;i:2;i:1;i:1;i:2;i:2;i:3;i:1;i:4;i:2;i:5;i:1;}i:2;a:6:{i:0;i:2;i:1;i:2;i:2;i:2;i:3;i:1;i:4;i:2;i:5;i:1;}i:3;a:6:{i:0;i:2;i:1;i:1;i:2;i:1;i:3;i:1;i:4;i:2;i:5;i:2;}i:4;a:6:{i:0;i:2;i:1;i:2;i:2;i:2;i:3;i:1;i:4;i:1;i:5;i:2;}i:5;a:6:{i:0;i:1;i:1;i:1;i:2;i:2;i:3;i:1;i:4;i:10;i:5;i:2;}}'),
(59, 'Default', 6, 6, 6, 6, 0, 0, 'a:6:{i:0;a:6:{i:0;i:6;i:1;i:1;i:2;i:2;i:3;i:2;i:4;i:2;i:5;i:1;}i:1;a:6:{i:0;i:2;i:1;i:1;i:2;i:2;i:3;i:1;i:4;i:2;i:5;i:1;}i:2;a:6:{i:0;i:2;i:1;i:2;i:2;i:2;i:3;i:1;i:4;i:2;i:5;i:1;}i:3;a:6:{i:0;i:2;i:1;i:1;i:2;i:1;i:3;i:1;i:4;i:2;i:5;i:2;}i:4;a:6:{i:0;i:2;i:1;i:2;i:2;i:2;i:3;i:1;i:4;i:1;i:5;i:2;}i:5;a:6:{i:0;i:1;i:1;i:1;i:2;i:2;i:3;i:1;i:4;i:10;i:5;i:2;}}'),
(60, 'Level 2', 12, 12, 6, 6, 0, 0, 'a:12:{i:0;a:12:{i:0;i:2;i:1;i:1;i:2;i:2;i:3;i:2;i:4;i:2;i:5;i:2;i:6;i:1;i:7;i:2;i:8;i:2;i:9;i:2;i:10;i:2;i:11;i:2;}i:1;a:12:{i:0;i:2;i:1;i:2;i:2;i:1;i:3;i:2;i:4;i:1;i:5;i:2;i:6;i:2;i:7;i:2;i:8;i:1;i:9;i:1;i:10;i:1;i:11;i:2;}i:2;a:12:{i:0;i:2;i:1;i:2;i:2;i:1;i:3;i:2;i:4;i:1;i:5;i:1;i:6;i:1;i:7;i:1;i:8;i:2;i:9;i:2;i:10;i:2;i:11;i:2;}i:3;a:12:{i:0;i:1;i:1;i:2;i:2;i:1;i:3;i:2;i:4;i:2;i:5;i:1;i:6;i:2;i:7;i:2;i:8;i:2;i:9;i:1;i:10;i:1;i:11;i:1;}i:4;a:12:{i:0;i:1;i:1;i:2;i:2;i:2;i:3;i:2;i:4;i:1;i:5;i:1;i:6;i:2;i:7;i:1;i:8;i:2;i:9;i:2;i:10;i:2;i:11;i:2;}i:5;a:12:{i:0;i:2;i:1;i:2;i:2;i:2;i:3;i:2;i:4;i:1;i:5;i:1;i:6;i:2;i:7;i:1;i:8;i:1;i:9;i:2;i:10;i:1;i:11;i:1;}i:6;a:12:{i:0;i:2;i:1;i:1;i:2;i:1;i:3;i:1;i:4;i:2;i:5;i:2;i:6;i:2;i:7;i:2;i:8;i:1;i:9;i:1;i:10;i:2;i:11;i:1;}i:7;a:12:{i:0;i:2;i:1;i:1;i:2;i:2;i:3;i:2;i:4;i:2;i:5;i:1;i:6;i:1;i:7;i:2;i:8;i:2;i:9;i:2;i:10;i:2;i:11;i:2;}i:8;a:12:{i:0;i:2;i:1;i:1;i:2;i:2;i:3;i:1;i:4;i:2;i:5;i:2;i:6;i:2;i:7;i:2;i:8;i:1;i:9;i:1;i:10;i:2;i:11;i:2;}i:9;a:12:{i:0;i:2;i:1;i:1;i:2;i:2;i:3;i:1;i:4;i:2;i:5;i:1;i:6;i:1;i:7;i:1;i:8;i:1;i:9;i:1;i:10;i:1;i:11;i:2;}i:10;a:12:{i:0;i:2;i:1;i:1;i:2;i:2;i:3;i:1;i:4;i:2;i:5;i:1;i:6;i:2;i:7;i:2;i:8;i:1;i:9;i:1;i:10;i:2;i:11;i:2;}i:11;a:12:{i:0;i:2;i:1;i:2;i:2;i:2;i:3;i:1;i:4;i:2;i:5;i:1;i:6;i:1;i:7;i:2;i:8;i:2;i:9;i:2;i:10;i:2;i:11;i:2;}}');

-- --------------------------------------------------------

--
-- Structure de la table `Playing_map_monster`
--

CREATE TABLE IF NOT EXISTS `Playing_map_monster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_map` int(11) NOT NULL,
  `ref_monster` int(11) NOT NULL,
  `position_x` int(11) NOT NULL,
  `position_y` int(11) NOT NULL,
  `direction` enum('UP','DOWN','LEFT','RIGHT') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ref_game` (`ref_map`),
  KEY `ref_playing_monster` (`ref_monster`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=85 ;

--
-- Contenu de la table `Playing_map_monster`
--

INSERT INTO `Playing_map_monster` (`id`, `ref_map`, `ref_monster`, `position_x`, `position_y`, `direction`) VALUES
(56, 38, 74, 3, 3, 'UP'),
(73, 55, 107, 1, 2, 'UP'),
(74, 55, 108, 4, 3, 'UP');

-- --------------------------------------------------------

--
-- Structure de la table `Playing_monster`
--

CREATE TABLE IF NOT EXISTS `Playing_monster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `position_x` int(11) NOT NULL,
  `position_y` int(11) NOT NULL,
  `direction` enum('UP','DOWN','LEFT','RIGHT') NOT NULL,
  `ref` varchar(255) NOT NULL,
  `health_max` int(10) unsigned NOT NULL,
  `health` int(10) unsigned NOT NULL,
  `strength` int(10) unsigned NOT NULL,
  `resistance` int(10) unsigned NOT NULL,
  `speed` int(10) unsigned NOT NULL,
  `posture` tinyint(1) NOT NULL,
  `round` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=119 ;

--
-- Contenu de la table `Playing_monster`
--

INSERT INTO `Playing_monster` (`id`, `name`, `position_x`, `position_y`, `direction`, `ref`, `health_max`, `health`, `strength`, `resistance`, `speed`, `posture`, `round`) VALUES
(74, 'Crazyfrog', 3, 3, 'UP', 'crazyfrog', 17, 17, 12, 4, 5, 1, 0),
(77, 'Rabivador', 1, 2, 'LEFT', 'rabivador', 15, 15, 9, 6, 7, 1, 0),
(78, 'Crazyfrog', 3, 3, 'UP', 'crazyfrog', 17, 17, 12, 4, 5, 1, 0),
(79, 'Rabivador', 1, 2, 'LEFT', 'rabivador', 15, 15, 9, 6, 7, 1, 0),
(80, 'Crazyfrog', 4, 3, 'UP', 'crazyfrog', 17, 17, 12, 4, 5, 1, 0),
(81, 'Rabivador', 1, 2, 'LEFT', 'rabivador', 15, 15, 9, 6, 7, 1, 0),
(82, 'Crazyfrog', 3, 3, 'UP', 'crazyfrog', 17, 17, 12, 4, 5, 1, 0),
(83, 'Rabivador', 1, 2, 'LEFT', 'rabivador', 15, 15, 9, 6, 7, 1, 0),
(84, 'Crazyfrog', 3, 3, 'UP', 'crazyfrog', 17, 17, 12, 4, 5, 1, 0),
(87, 'Rabivador', 1, 2, 'LEFT', 'rabivador', 15, 15, 9, 6, 7, 1, 0),
(88, 'Crazyfrog', 3, 3, 'UP', 'crazyfrog', 17, 17, 12, 4, 5, 1, 0),
(89, 'Rabivador', 1, 2, 'LEFT', 'rabivador', 15, 15, 9, 6, 7, 1, 0),
(90, 'Crazyfrog', 3, 3, 'UP', 'crazyfrog', 17, 17, 12, 4, 5, 1, 0),
(91, 'Rabivador', 1, 2, 'LEFT', 'rabivador', 15, 15, 9, 6, 7, 1, 0),
(92, 'Crazyfrog', 3, 3, 'UP', 'crazyfrog', 17, 17, 12, 4, 5, 1, 0),
(93, 'Rabivador', 1, 2, 'LEFT', 'rabivador', 15, 15, 9, 6, 7, 1, 0),
(94, 'Crazyfrog', 3, 3, 'UP', 'crazyfrog', 17, 17, 12, 4, 5, 1, 0),
(107, 'Rabivador', 1, 2, 'LEFT', 'rabivador', 15, 7, 12, 6, 7, 1, 1),
(108, 'Crazyfrog', 4, 3, 'UP', 'crazyfrog', 17, 17, 15, 4, 5, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Contenu de la table `User`
--

INSERT INTO `User` (`id`, `username`, `email`, `password`, `salt`) VALUES
(1, 'tmenu', 'menu.tho@gmail.com', 'tmenu', ''),
(2, 'fmartinelli', 'floflorian89@hotmail.fr', 'fmartinelli', ''),
(25, 'test01', 'test@test.fr', 'ace54ca1b1152fe21d1fafe48228a5cd827f393c32a1f698c1e14fb00f771a44379a37e9b7c884b6bf501773a581f5b46411ba5a625a39769fbd667749e3f1a5', 'ZCOxfvesFXa4QnXrrXD2HZWVHVemUvMoA8aWNYIxadwb9Q1dyc'),
(26, 'test02', 'test@test.fr', 'c74b8ba5949659f8bf258d48791ec608949c13ebe45c32883b25ac33148375676532e97638684e6d86d8f8b88e1771173908cd0276e2956a09df9b417dbc088b', 'luP6PYUDswy7IY3XvnFr2KZ1WkiHx2VIgAfTXkQWtfyqX8zy7d'),
(27, 'Florian', 'adresse@email.com', '41c71541abdf4e6769b3a3f563a024ddf5f6bebbcb3597c4f2a0f0da004ade80d2c16d5008755710578004cfa1ff97289110015ce6d1b0b1a54982f8a1b83c83', '6UVWfh1VbFAfbmmqiCX4nUqpbDeqPdnDhQooB1mvBxd1upEsXT'),
(28, 'user', 'user@user.fr', '3ac30cb6223fef43a6dcad912432178f61423039be313d99fe374b8c1fd28c18b386314070728e877bad2af874a234dbe6ff9f69f990d8d9f2585232fba843ce', 'yjJjTsbaYclFjWQMYKQjY4dR620IRn2JMVHDPqq4ceqiXTpStX');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Game`
--
ALTER TABLE `Game`
  ADD CONSTRAINT `Game_ibfk_3` FOREIGN KEY (`ref_character`) REFERENCES `Playing_character` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Game_ibfk_1` FOREIGN KEY (`ref_user`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Game_ibfk_2` FOREIGN KEY (`ref_map`) REFERENCES `Playing_map` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Initial_map_monster`
--
ALTER TABLE `Initial_map_monster`
  ADD CONSTRAINT `Initial_map_monster_ibfk_1` FOREIGN KEY (`ref_map`) REFERENCES `Initial_map` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Initial_map_monster_ibfk_2` FOREIGN KEY (`ref_monster`) REFERENCES `Initial_monster` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Playing_map_monster`
--
ALTER TABLE `Playing_map_monster`
  ADD CONSTRAINT `Playing_map_monster_ibfk_1` FOREIGN KEY (`ref_map`) REFERENCES `Playing_map` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Playing_map_monster_ibfk_2` FOREIGN KEY (`ref_monster`) REFERENCES `Playing_monster` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;