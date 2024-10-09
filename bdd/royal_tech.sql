-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 09 oct. 2024 à 07:37
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `royal_tech`
--

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `gainTotalParCategorie`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `gainTotalParCategorie` (IN `p_nom_categorie` VARCHAR(255), OUT `p_gain_total` DECIMAL(10,2))   BEGIN
    SELECT SUM(ligne.quantite * ligne.prix_unit) 
    INTO p_gain_total
    FROM ligne
    JOIN article ON ligne.id_article = article.id_article
    WHERE article.categorie = p_nom_categorie;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id_article` varchar(5) NOT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `prix` varchar(50) DEFAULT NULL,
  `categorie` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_article`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id_article`, `designation`, `prix`, `categorie`) VALUES
('GLXS2', 'Galaxy S20 5G', '480.00', 'telephonie'),
('HUW40', 'Huawei Mate 40 Pro', '700.00', 'telephonie'),
('DL752', 'DELL PRECISION 7520', '1000.00', 'informatique'),
('LNO47', 'LENOVO THINKPAD L470', '450.00', 'informatique'),
('CS350', 'Caméscope Hitachi DZ-HS500E', '150.00', 'video'),
('SOXMP', 'PC Portable Sony Z1-XMP', '2399.00', 'informatique'),
('HW110', 'Ecran PC HUAWEI MateView GT 3', '500.00', 'video'),
('SAX15', 'Portable Samsung X15 XVM', '1999.00', 'informatique'),
('NIK55', 'Nikon F55+zoom 28/80', '269.00', 'photo'),
('NIK80', 'Nikon F80', '479.00', 'photo'),
('DVD75', 'DVD vierge par 3', '17.50', 'divers'),
('HP497', 'PC Bureau HP497 écran TFT', '1100.00', 'informatique'),
('DEL30', 'Portable Dell X300', '1715.00', 'informatique'),
('CA300', 'Canon EOS 3000V zoom 28/80', '350.00', 'photo'),
('CAS07', 'Cassette DV60 par 5', '26.90', 'divers'),
('CP100', 'Camescope Panasonic SV-AV 100', '1800.00', 'video'),
('CS330', 'Caméscope Sony DCR-PC330', '2000.00', 'video'),
('TEST1', 'Test de insertarticle()', '0', 'divers');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id_client` varchar(50) NOT NULL,
  `civilite` enum('M.','Mme') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `adresse` varchar(100) DEFAULT NULL,
  `ville` varchar(30) DEFAULT NULL,
  `code_postal` varchar(5) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `civilite`, `nom`, `prenom`, `age`, `adresse`, `ville`, `code_postal`, `mail`) VALUES
('1', 'M.', 'RESTOUEIX', 'Sacha', 36, '5 Avenue Albert Einstein', 'Le Saillant', '19240', 'sacha@gmail.com'),
('2', 'M.', 'Rapp', 'Paul', 44, '32 Avenue Foch', 'Paris', '75001', 'rapp@libert.com'),
('3', 'M.', 'Devos', 'Marie', 18, '75 Boulevard Hochimin', 'Lille', '75001', 'grav@wanadoo.com'),
('4', 'M.', 'Hauchon', 'Paul', 22, '12 Rue Tsétsé', 'Chartres', '28000', 'hauch@gmail.com'),
('5', 'M.', 'Grave', 'Nuyen', 18, '75 Boulevard Hochimin', 'Lille', '59000', 'grave@gmail.com'),
('6', 'Mme', 'Hachette', 'Jeanne', 45, '60 Rue d\'Amiens', 'Versailles', '78000', NULL),
('7', 'M.', 'Marti', 'Pierre', 25, '4 Avenue Henry 8', 'Paris', '75008', 'marti@gmail.com'),
('8', 'M.', 'Mac Neal', 'John', 52, '59 Rue Diana', 'Lyon', '69000', 'macneal@gmail.com'),
('9', 'M.', 'Basile', 'Did', 37, '26 Rue Gallas', 'Nantes', '44000', 'bas@walabi.com'),
('10', 'Mme', 'Darc', 'Jeanne', 19, '9 Avenue d\'Orléans', 'Paris', '75012', NULL),
('11', 'M.', 'Gate', 'Bill', 75, '9 Boulevard des Bugs', 'Lyon', '78000', 'bill@microhard.be'),
('14', 'M.', 'RESTOUEIX', 'Sacha', 54, '25 Route de la Plaine', 'Allassac', '19240', 'sacha8milo@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_comm` varchar(50) NOT NULL,
  `date_comm` date DEFAULT NULL,
  `id_client` varchar(50) NOT NULL,
  PRIMARY KEY (`id_comm`),
  KEY `id_client` (`id_client`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_comm`, `date_comm`, `id_client`) VALUES
('1', '2012-06-11', '5'),
('2', '2012-06-25', '9'),
('3', '2012-07-12', '1'),
('4', '2012-07-14', '3'),
('5', '2012-07-31', '9'),
('6', '2012-08-08', '10'),
('7', '2012-08-25', '2'),
('8', '2012-09-04', '7'),
('9', '2012-10-15', '11'),
('10', '2012-11-23', '4'),
('11', '2013-01-21', '8'),
('12', '2013-02-01', '5'),
('13', '2013-03-03', '9');

-- --------------------------------------------------------

--
-- Structure de la table `ligne`
--

DROP TABLE IF EXISTS `ligne`;
CREATE TABLE IF NOT EXISTS `ligne` (
  `id_article` varchar(5) NOT NULL,
  `id_comm` varchar(50) NOT NULL,
  `quantite` int DEFAULT NULL,
  `prix_unit` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_article`,`id_comm`),
  KEY `id_comm` (`id_comm`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `ligne`
--

INSERT INTO `ligne` (`id_article`, `id_comm`, `quantite`, `prix_unit`) VALUES
('CA300', '5', 1, '329'),
('CAS07', '1', 3, '26.9'),
('CAS07', '6', 3, '26.9'),
('CAS07', '12', 4, '26.9'),
('CP100', '6', 1, '1490'),
('CP100', '8', 1, '1490'),
('CS330', '1', 1, '1629'),
('CS330', '3', 2, '1629'),
('CS330', '12', 3, '1629'),
('DEL30', '10', 2, '1715'),
('DVD75', '4', 2, '17.5'),
('DVD75', '11', 10, '17.5'),
('HP497', '2', 2, '1500'),
('NIK55', '9', 1, '269'),
('NIK80', '3', 5, '479'),
('SAX15', '7', 5, '1999'),
('SAX15', '10', 1, '1999'),
('SAX15', '13', 2, '1999'),
('SOXMP', '4', 3, '2399'),
('SOXMP', '8', 1, '2399');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int NOT NULL AUTO_INCREMENT,
  `role` enum('Admin','Éditeur','Lecteur') NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id_role`, `role`) VALUES
(1, 'Admin'),
(2, 'Éditeur'),
(3, 'Lecteur');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `login` varchar(50) NOT NULL,
  `mdp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_role` int NOT NULL,
  PRIMARY KEY (`login`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`login`, `mdp`, `id_role`) VALUES
('Lecteur', '$2y$10$qwybbamZ31dAYWpvD/GR0OlLLSFvDWOSW0fEHp01w554yk7rPFL3q', 3),
('Editeur', '$2y$10$uFbzc4zk7HPsf/v.ByW2suvIIOzJvcNGsG7.kVn43piFKdjWS4sXq', 2),
('Admin', '$2y$10$Vyi46Yt5TLNyOeC6SSkeh.3a0ee/CpDD.z.4uTSfB4B6HrfQiwXFm', 1),
('test', '$2y$10$BuWqTa74.aAQDawfO6vpUOg9Xretol73rlBAtBMaO7Z2dPGS32Grq', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
