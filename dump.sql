-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Ven 28 Février 2014 à 15:58
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
  `ref_initial_map` int(11) NOT NULL,
  `ref_initial_character` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ref_user` (`ref_user`),
  KEY `ref_map` (`ref_map`),
  KEY `ref_character` (`ref_character`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

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
  `life` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `Initial_character`
--

INSERT INTO `Initial_character` (`id`, `name`, `position_x`, `position_y`, `direction`, `ref`, `health_max`, `health`, `strength`, `resistance`, `speed`, `posture`, `round`, `life`) VALUES
(1, 'Guillaume', 0, 0, 'DOWN', 'mage01', 23, 23, 19, 19, 19, 1, 0, 3),
(14, 'Rozy', 0, 0, 'DOWN', 'mage02', 20, 20, 16, 27, 17, 1, 0, 3),
(15, 'Kévina', 0, 0, 'DOWN', 'mage03', 21, 21, 17, 17, 23, 1, 0, 3),
(16, 'Johan', 0, 0, 'DOWN', 'mage04', 25, 25, 16, 22, 13, 1, 0, 3);

-- --------------------------------------------------------

--
-- Structure de la table `Initial_item`
--

CREATE TABLE IF NOT EXISTS `Initial_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `position_x` int(11) NOT NULL,
  `position_y` int(11) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `health` int(10) unsigned NOT NULL DEFAULT '0',
  `health_max` int(10) unsigned NOT NULL DEFAULT '0',
  `strength` int(10) unsigned NOT NULL DEFAULT '0',
  `resistance` int(10) unsigned NOT NULL DEFAULT '0',
  `speed` int(10) unsigned NOT NULL DEFAULT '0',
  `life` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `Initial_item`
--

INSERT INTO `Initial_item` (`id`, `name`, `position_x`, `position_y`, `ref`, `health`, `health_max`, `strength`, `resistance`, `speed`, `life`) VALUES
(1, 'Potion', 0, 0, 'potion', 7, 0, 0, 0, 0, 0),
(2, 'Force+', 0, 0, 'force', 0, 0, 4, 0, 0, 0),
(3, 'Défense+', 0, 0, 'defense', 0, 0, 0, 4, 0, 0),
(4, 'Santé+', 0, 0, 'sante', 3, 3, 0, 0, 0, 0),
(5, 'Vitesse+', 0, 0, 'vitesse', 0, 0, 0, 0, 4, 0),
(6, 'Orbe Chuck Norris', 0, 0, 'chucknorris', 0, 3, 3, 3, 3, 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `Initial_map`
--

INSERT INTO `Initial_map` (`id`, `name`, `size_height`, `size_width`, `visible_x`, `visible_y`, `origin_x`, `origin_y`, `map`) VALUES
(1, 'Level 1', 6, 6, 6, 6, 0, 0, 'a:6:{i:0;a:6:{i:0;i:70;i:1;i:17;i:2;i:66;i:3;i:66;i:4;i:66;i:5;i:17;}i:1;a:6:{i:0;i:66;i:1;i:17;i:2;i:66;i:3;i:33;i:4;i:66;i:5;i:17;}i:2;a:6:{i:0;i:66;i:1;i:66;i:2;i:66;i:3;i:33;i:4;i:66;i:5;i:17;}i:3;a:6:{i:0;i:66;i:1;i:33;i:2;i:33;i:3;i:33;i:4;i:66;i:5;i:66;}i:4;a:6:{i:0;i:66;i:1;i:66;i:2;i:66;i:3;i:33;i:4;i:33;i:5;i:66;}i:5;a:6:{i:0;i:17;i:1;i:17;i:2;i:66;i:3;i:33;i:4;i:74;i:5;i:66;}}'),
(2, 'Level 2', 9, 9, 6, 6, 0, 0, 'a:9:{i:0;a:9:{i:0;i:1030;i:1;i:1026;i:2;i:257;i:3;i:257;i:4;i:257;i:5;i:257;i:6;i:1026;i:7;i:1026;i:8;i:1034;}i:1;a:9:{i:0;i:257;i:1;i:1026;i:2;i:257;i:3;i:1026;i:4;i:1026;i:5;i:1026;i:6;i:257;i:7;i:1026;i:8;i:257;}i:2;a:9:{i:0;i:1026;i:1;i:1026;i:2;i:257;i:3;i:1026;i:4;i:257;i:5;i:1026;i:6;i:257;i:7;i:1026;i:8;i:1026;}i:3;a:9:{i:0;i:1026;i:1;i:257;i:2;i:1026;i:3;i:1026;i:4;i:1026;i:5;i:1026;i:6;i:257;i:7;i:257;i:8;i:1026;}i:4;a:9:{i:0;i:1026;i:1;i:1026;i:2;i:1026;i:3;i:257;i:4;i:1026;i:5;i:257;i:6;i:1026;i:7;i:1026;i:8;i:1026;}i:5;a:9:{i:0;i:257;i:1;i:257;i:2;i:257;i:3;i:1026;i:4;i:1026;i:5;i:257;i:6;i:1026;i:7;i:1026;i:8;i:257;}i:6;a:9:{i:0;i:1026;i:1;i:1026;i:2;i:1026;i:3;i:1026;i:4;i:257;i:5;i:257;i:6;i:257;i:7;i:1026;i:8;i:257;}i:7;a:9:{i:0;i:257;i:1;i:257;i:2;i:1026;i:3;i:257;i:4;i:1026;i:5;i:1026;i:6;i:1026;i:7;i:1026;i:8;i:1026;}i:8;a:9:{i:0;i:1026;i:1;i:1026;i:2;i:1026;i:3;i:1026;i:4;i:1026;i:5;i:257;i:6;i:257;i:7;i:257;i:8;i:1026;}}'),
(3, 'Level 3', 12, 12, 6, 6, 0, 0, 'a:12:{i:0;a:12:{i:0;i:70;i:1;i:17;i:2;i:66;i:3;i:66;i:4;i:66;i:5;i:66;i:6;i:17;i:7;i:66;i:8;i:66;i:9;i:66;i:10;i:66;i:11;i:66;}i:1;a:12:{i:0;i:66;i:1;i:66;i:2;i:17;i:3;i:66;i:4;i:17;i:5;i:66;i:6;i:66;i:7;i:66;i:8;i:17;i:9;i:17;i:10;i:17;i:11;i:66;}i:2;a:12:{i:0;i:66;i:1;i:66;i:2;i:17;i:3;i:66;i:4;i:17;i:5;i:17;i:6;i:17;i:7;i:17;i:8;i:66;i:9;i:66;i:10;i:66;i:11;i:66;}i:3;a:12:{i:0;i:17;i:1;i:66;i:2;i:17;i:3;i:66;i:4;i:66;i:5;i:17;i:6;i:66;i:7;i:66;i:8;i:66;i:9;i:17;i:10;i:17;i:11;i:17;}i:4;a:12:{i:0;i:17;i:1;i:66;i:2;i:66;i:3;i:66;i:4;i:17;i:5;i:17;i:6;i:66;i:7;i:17;i:8;i:66;i:9;i:66;i:10;i:66;i:11;i:66;}i:5;a:12:{i:0;i:66;i:1;i:66;i:2;i:66;i:3;i:66;i:4;i:17;i:5;i:17;i:6;i:66;i:7;i:17;i:8;i:17;i:9;i:66;i:10;i:17;i:11;i:17;}i:6;a:12:{i:0;i:66;i:1;i:17;i:2;i:17;i:3;i:17;i:4;i:66;i:5;i:66;i:6;i:66;i:7;i:66;i:8;i:17;i:9;i:17;i:10;i:66;i:11;i:17;}i:7;a:12:{i:0;i:66;i:1;i:17;i:2;i:66;i:3;i:66;i:4;i:66;i:5;i:17;i:6;i:17;i:7;i:66;i:8;i:66;i:9;i:66;i:10;i:66;i:11;i:66;}i:8;a:12:{i:0;i:66;i:1;i:17;i:2;i:66;i:3;i:17;i:4;i:66;i:5;i:66;i:6;i:66;i:7;i:66;i:8;i:17;i:9;i:17;i:10;i:66;i:11;i:66;}i:9;a:12:{i:0;i:66;i:1;i:17;i:2;i:66;i:3;i:17;i:4;i:66;i:5;i:17;i:6;i:17;i:7;i:17;i:8;i:17;i:9;i:17;i:10;i:17;i:11;i:66;}i:10;a:12:{i:0;i:66;i:1;i:17;i:2;i:66;i:3;i:17;i:4;i:66;i:5;i:17;i:6;i:74;i:7;i:66;i:8;i:17;i:9;i:17;i:10;i:66;i:11;i:66;}i:11;a:12:{i:0;i:66;i:1;i:66;i:2;i:66;i:3;i:17;i:4;i:66;i:5;i:17;i:6;i:17;i:7;i:66;i:8;i:66;i:9;i:66;i:10;i:66;i:11;i:66;}}');

-- --------------------------------------------------------

--
-- Structure de la table `Initial_map_item`
--

CREATE TABLE IF NOT EXISTS `Initial_map_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_map` int(11) NOT NULL,
  `ref_item` int(11) NOT NULL,
  `position_x` int(11) NOT NULL,
  `position_y` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ref_map` (`ref_map`),
  KEY `ref_item` (`ref_item`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `Initial_map_item`
--

INSERT INTO `Initial_map_item` (`id`, `ref_map`, `ref_item`, `position_x`, `position_y`) VALUES
(1, 1, 1, 2, 5),
(2, 2, 2, 0, 8),
(3, 2, 1, 8, 8),
(4, 2, 5, 6, 0),
(5, 3, 3, 6, 1),
(6, 3, 1, 3, 5),
(7, 3, 1, 10, 6),
(8, 3, 2, 9, 5),
(9, 3, 1, 7, 8),
(10, 3, 5, 2, 0),
(11, 2, 3, 5, 3),
(12, 2, 1, 6, 4);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Contenu de la table `Initial_map_monster`
--

INSERT INTO `Initial_map_monster` (`id`, `ref_map`, `ref_monster`, `position_x`, `position_y`, `direction`) VALUES
(1, 1, 1, 1, 2, 'LEFT'),
(2, 1, 2, 4, 3, 'UP'),
(4, 2, 2, 3, 2, 'DOWN'),
(5, 1, 2, 0, 4, 'UP'),
(6, 2, 3, 2, 7, 'UP'),
(7, 2, 5, 7, 6, 'DOWN'),
(8, 2, 4, 7, 1, 'DOWN'),
(9, 3, 1, 1, 3, 'UP'),
(10, 3, 3, 5, 1, 'UP'),
(11, 3, 3, 7, 1, 'UP'),
(12, 3, 2, 2, 7, 'DOWN'),
(13, 3, 2, 4, 7, 'LEFT'),
(14, 3, 4, 9, 7, 'LEFT'),
(15, 3, 5, 7, 11, 'RIGHT');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `Initial_monster`
--

INSERT INTO `Initial_monster` (`id`, `name`, `position_x`, `position_y`, `direction`, `ref`, `health_max`, `health`, `strength`, `resistance`, `speed`, `posture`, `round`) VALUES
(1, 'Rabivador', 0, 0, 'LEFT', 'rabivador', 18, 18, 18, 17, 17, 1, 0),
(2, 'Crazyfrog', 0, 0, 'UP', 'crazyfrog', 16, 16, 17, 18, 19, 1, 0),
(3, 'Kevindiesel', 0, 0, 'LEFT', 'kevindiesel', 20, 20, 16, 22, 22, 1, 0),
(4, 'Thomagneto', 0, 0, 'RIGHT', 'thomagneto', 22, 22, 21, 17, 20, 1, 0),
(5, 'Floracle', 0, 0, 'DOWN', 'floracle', 24, 24, 20, 20, 16, 1, 0);

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
  `life` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `Playing_item`
--

CREATE TABLE IF NOT EXISTS `Playing_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `position_x` int(11) NOT NULL,
  `position_y` int(11) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `health` int(11) NOT NULL DEFAULT '0',
  `health_max` int(11) NOT NULL DEFAULT '0',
  `strength` int(11) NOT NULL DEFAULT '0',
  `resistance` int(11) NOT NULL DEFAULT '0',
  `speed` int(11) NOT NULL DEFAULT '0',
  `life` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `Playing_map_item`
--

CREATE TABLE IF NOT EXISTS `Playing_map_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_map` int(11) NOT NULL,
  `ref_item` int(11) NOT NULL,
  `position_x` int(11) NOT NULL,
  `position_y` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `User`
--

INSERT INTO `User` (`id`, `username`, `email`, `password`, `salt`) VALUES
(1, 'test01', 'test@test.fr', 'd1720a98f4e55492c669a2318bd99eaa7c1becff5b54b344c17e5778893be811434bbe831938303c93cab482414dd7403113f7bdcd3222e425177da6d5dbc2b7', 'caNlvVrIBFH3XmU2wWih12O4hr4M7hfrgVXYLxOSO9hieZMKR2'),
(2, 'test', 'test@test.fr', '424a6423d066d696fceb5a29a66987402ceb27208348ec2bdaae52e33cf26a9efbc25c4b3c9e38501fcc7773e752b324defb5e2a0e04978be95620dc4a09b0a1', 'Cg8ewgHDbWVhynCUxiDHQEtV2MVdSmgld5pFBOnafRInBIggMc');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;