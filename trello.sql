-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 09 mars 2021 à 15:54
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `trello`
--

-- --------------------------------------------------------

--
-- Structure de la table `cards`
--

DROP TABLE IF EXISTS `cards`;
CREATE TABLE IF NOT EXISTS `cards` (
  `id` varchar(60) NOT NULL,
  `name` varchar(60) NOT NULL,
  `descriptif` text NOT NULL,
  `idList` varchar(50) NOT NULL,
  `shortLink` varchar(60) NOT NULL,
  `dateLastActivity` varchar(60) NOT NULL,
  `commentaire` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cards`
--

INSERT INTO `cards` (`id`, `name`, `descriptif`, `idList`, `shortLink`, `dateLastActivity`, `commentaire`) VALUES
('6024f57c27724739487d0bb0', 'FICHE D\'INTERVENTION DAFI', 'prevoir le mode opératoire en pièce jointe \n\n> Penser à décrire toute intervention dans la partie commentaire.\n\n> Dans le cadre d\'une demande d\'autorisation, effectuer la demande via Trello et envoyer en parallèle la demande auprès de : patrice.lascombe@pmilinvest.fr\n\n> Patrice doit valider l\'intervention en ajoutant un commentaire de validation.', '6024f4b6f85d612ef7497455', 'I35ew4EZ', '2021-03-08T12:55:57.596Z', NULL),
('6024f58a31af0657d94abfd3', 'ACCES UTILISATEURS DAFI', 'Voir le mode opératoire en pièce jointe \n\n> Penser à décrire toute intervention dans la partie commentaire.\n\n> Dans le cadre d\'une demande de création ou de modification des accès utilisateurs DAFI, effectuer la demande via Trello et envoyer en parallèle la demande auprès de : patrice.lascombe@pmilinvest.fr \n\n> Patrice doit valider l\'intervention en ajoutant un commentaire de validation.', '6024f4b6f85d612ef7497455', 'qU7sRIxR', '2021-03-09T15:11:00.161Z', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `checkbox`
--

DROP TABLE IF EXISTS `checkbox`;
CREATE TABLE IF NOT EXISTS `checkbox` (
  `id` varchar(60) NOT NULL,
  `name` varchar(255) NOT NULL,
  `pos` float NOT NULL,
  `idCheckList` varchar(60) NOT NULL,
  `state` varchar(255) NOT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `checkbox`
--

INSERT INTO `checkbox` (`id`, `name`, `pos`, `idCheckList`, `state`, `dateCreation`) VALUES
('6024f58a31af0657d94abfda', 'Création d\'un utilisateur DAFI (type $$) ? Cocher pour Oui -> Si oui, demander l\'autorisation préalable et justifier l\'intervention dans la partie commentaire', 8243, '6024f58a31af0657d94abfd8', 'complete', '2021-03-05 11:41:14'),
('6024f57c27724739487d0bbb', 'Accès à DAFI EXE ? Cocher pour Oui.', 10113.3, '6024f57c27724739487d0bb5', 'complete', '2021-03-05 11:41:14'),
('6024f58a31af0657d94abfd9', 'Modification des accès d\'un utilisateur DAFI (type $$) ? Cocher pour Oui -> Si oui, demander l\'autorisation préalable et justifier l\'intervention dans la partie commentaire', 16486, '6024f58a31af0657d94abfd8', 'incomplete', '2021-03-05 11:41:14'),
('6024f57c27724739487d0bba', 'Accès à l’outil Report One ? Cocher pour Oui', 16820.6, '6024f57c27724739487d0bb5', 'incomplete', '2021-03-05 11:41:14'),
('6024f57c27724739487d0bb7', 'Accès à DAFI-MYSQL ou DAFI-TEST  ? Cocher pour Oui. ', 8516.5, '6024f57c27724739487d0bb5', 'incomplete', '2021-03-05 11:41:14'),
('6024f57c27724739487d0bb8', 'Accès aux bases clients des marques sur DAFI-MYSQL ou DAFI-TEST  ? Cocher pour Oui', 23527.9, '6024f57c27724739487d0bb5', 'incomplete', '2021-03-05 11:41:14'),
('6024f57c27724739487d0bb9', 'Accès par VPN aux bases clients Mysql (répliquées) des marques ? Cocher pour Oui', 28904.4, '6024f57c27724739487d0bb5', 'incomplete', '2021-03-05 11:41:14'),
('6024f57c27724739487d0bb6', 'Intervention sur des données personnelles des clients/prospects/fournisseurs des marques ? Cocher pour Oui -> Si oui, demander l\'autorisation préalable et justifier l\'intervention dans la partie commentaire', 34281, '6024f57c27724739487d0bb5', 'complete', '2021-03-05 11:41:14');

-- --------------------------------------------------------

--
-- Structure de la table `checklist`
--

DROP TABLE IF EXISTS `checklist`;
CREATE TABLE IF NOT EXISTS `checklist` (
  `id` varchar(50) NOT NULL,
  `name` varchar(200) NOT NULL,
  `idCard` varchar(50) NOT NULL,
  `pos` int(10) NOT NULL,
  `idBoard` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `checklist`
--

INSERT INTO `checklist` (`id`, `name`, `idCard`, `pos`, `idBoard`) VALUES
('6024f58a31af0657d94abfd8', 'Validation', '6024f58a31af0657d94abfd3', 16384, '6024ef4952b38d47046e85ad'),
('6024f57c27724739487d0bb5', 'ACTIONS DE DAFI', '6024f57c27724739487d0bb0', 16384, '6024ef4952b38d47046e85ad');

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

DROP TABLE IF EXISTS `historique`;
CREATE TABLE IF NOT EXISTS `historique` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idCheckBox` varchar(60) NOT NULL,
  `descriptif` varchar(255) NOT NULL,
  `state` varchar(60) DEFAULT NULL,
  `dateModifs` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=488 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `historique`
--

INSERT INTO `historique` (`id`, `idCheckBox`, `descriptif`, `state`, `dateModifs`, `name`) VALUES
(475, '6024f57c27724739487d0bba', 'Modification d\'une checkbox : incomplete', NULL, '2021-03-04 10:59:37', 'Accès à l’outil Report One ? Cocher pour Oui'),
(476, '6024f57c27724739487d0bbb', 'Modification d\'une checkbox : complete', NULL, '2021-03-04 11:04:22', 'Accès à DAFI EXE ? Cocher pour Oui.'),
(477, '6024f58a31af0657d94abfd9', 'Modification d\'une checkbox : incomplete', NULL, '2021-03-04 11:04:22', 'Modification des accès d\'un utilisateur DAFI (type $$) ? Cocher pour Oui -> Si oui, demander l\'autorisation préalable et justifier l\'intervention dans la partie commentaire'),
(478, '6024f57c27724739487d0bb7', 'Modification d\'une checkbox : complete', NULL, '2021-03-07 17:56:25', 'Accès à DAFI-MYSQL ou DAFI-TEST  ? Cocher pour Oui. '),
(479, '6024f57c27724739487d0bb7', 'Modification d\'une checkbox : incomplete', NULL, '2021-03-08 11:27:26', 'Accès à DAFI-MYSQL ou DAFI-TEST  ? Cocher pour Oui. '),
(480, '6024f57c27724739487d0bb6', 'Modification d\'une checkbox : incomplete', NULL, '2021-03-08 11:29:07', 'Intervention sur des données personnelles des clients/prospects/fournisseurs des marques ? Cocher pour Oui -> Si oui, demander l\'autorisation préalable et justifier l\'intervention dans la partie commentaire'),
(481, '6024f57c27724739487d0bb8', 'Modification d\'une checkbox : incomplete', NULL, '2021-03-08 11:29:07', 'Accès aux bases clients des marques sur DAFI-MYSQL ou DAFI-TEST  ? Cocher pour Oui'),
(482, '6024f57c27724739487d0bbb', 'Modification d\'une checkbox : incomplete', NULL, '2021-03-08 11:29:07', 'Accès à DAFI EXE ? Cocher pour Oui.'),
(483, '6024f57c27724739487d0bb7', 'Modification d\'une checkbox : complete', NULL, '2021-03-08 11:29:24', 'Accès à DAFI-MYSQL ou DAFI-TEST  ? Cocher pour Oui. '),
(484, '6024f57c27724739487d0bb7', 'Modification d\'une checkbox : incomplete', NULL, '2021-03-08 11:29:48', 'Accès à DAFI-MYSQL ou DAFI-TEST  ? Cocher pour Oui. '),
(485, '6024f57c27724739487d0bbb', 'Modification d\'une checkbox : complete', NULL, '2021-03-08 11:29:49', 'Accès à DAFI EXE ? Cocher pour Oui.'),
(486, '6024f57c27724739487d0bb6', 'Modification d\'une checkbox : complete', NULL, '2021-03-08 13:56:02', 'Intervention sur des données personnelles des clients/prospects/fournisseurs des marques ? Cocher pour Oui -> Si oui, demander l\'autorisation préalable et justifier l\'intervention dans la partie commentaire'),
(487, '6024f58a31af0657d94abfda', 'Modification d\'une checkbox : complete', NULL, '2021-03-09 16:11:05', 'Création d\'un utilisateur DAFI (type $$) ? Cocher pour Oui -> Si oui, demander l\'autorisation préalable et justifier l\'intervention dans la partie commentaire');

-- --------------------------------------------------------

--
-- Structure de la table `list`
--

DROP TABLE IF EXISTS `list`;
CREATE TABLE IF NOT EXISTS `list` (
  `id` varchar(120) NOT NULL,
  `name` varchar(200) NOT NULL,
  `idBoard` varchar(60) NOT NULL,
  `closed` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `list`
--

INSERT INTO `list` (`id`, `name`, `idBoard`, `closed`) VALUES
('6024f4b6f85d612ef7497455', 'INTERVENTIONS CLOTUREES', '6024ef4952b38d47046e85ad', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
