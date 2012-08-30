-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Jeu 30 Août 2012 à 20:15
-- Version du serveur: 5.5.9
-- Version de PHP: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `ginger`
--

-- --------------------------------------------------------

--
-- Structure de la table `auth`
--

CREATE TABLE `auth` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Association` varchar(200) NOT NULL,
  `Details` text NOT NULL,
  `Cle` varchar(50) NOT NULL,
  `Droits` enum('simple','etendu') NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Cle` (`Cle`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `auth`
--

INSERT INTO `auth` VALUES(1, 'SiMDE', 'Accès pour les tests', 'kyY4hCbk52LcpV6Zw3qX3TfzUf9b3EWPgN6Mk53W8NETAtSzVy', 'simple');

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

CREATE TABLE `personne` (
  `Login` varchar(8) NOT NULL,
  `Prenom` varchar(100) NOT NULL,
  `Nom` varchar(100) NOT NULL,
  `Mail` varchar(200) NOT NULL,
  `Type` enum('etu','pers','escom','escompers','ext') NOT NULL,
  `DateAjout` datetime NOT NULL,
  `DateMaj` datetime NOT NULL,
  `DateExpiration` datetime NOT NULL,
  `DateNaissance` date DEFAULT NULL,
  `Badge` varchar(10) DEFAULT NULL,
  `Tel` varchar(15) DEFAULT NULL,
  `Tel2` varchar(15) DEFAULT NULL,
  `Adresse` text,
  `Adresse2` text,
  `Branche` varchar(3) DEFAULT NULL,
  `Semestre` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`Login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `personne`
--

INSERT INTO `personne` VALUES('puyouart', 'Arthur', 'Puyou', 'arthur@puyou.fr', 'etu', '2012-06-06 01:09:00', '2012-06-06 01:09:03', '2034-06-06 01:09:05', '1991-02-16', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
