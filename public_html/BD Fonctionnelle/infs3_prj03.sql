-- phpMyAdmin SQL Dump
-- version 4.2.12
-- http://www.phpmyadmin.net
--
-- Client :  mysql
-- Généré le :  Ven 13 Janvier 2017 à 14:29
-- Version du serveur :  5.5.50-MariaDB
-- Version de PHP :  5.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `infs3_prj03`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `idCat` varchar(10) NOT NULL,
  `tpsJeu` time NOT NULL,
  `terrain` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`idCat`, `tpsJeu`, `terrain`) VALUES
(' ', '00:00:00', 0),
('Sénior', '00:40:00', 8),
('U10-U11', '00:40:00', 2),
('U12-U13', '00:40:00', 3),
('U14-U15', '00:40:00', 4),
('U16-U17', '00:40:00', 5),
('U18-U19-U2', '00:40:00', 7),
('U7', '00:30:00', 1),
('U8-U9', '00:40:00', 2);

-- --------------------------------------------------------

--
-- Structure de la table `club`
--

CREATE TABLE IF NOT EXISTS `club` (
  `refClub` int(11) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `adresse` varchar(250) NOT NULL,
  `cp` varchar(10) NOT NULL,
  `ville` varchar(200) NOT NULL,
  `numTel` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `club`
--

INSERT INTO `club` (`refClub`, `nom`, `adresse`, `cp`, `ville`, `numTel`) VALUES
(0, 'TBD', '', '', '', ''),
(68, 'RMV', '18 rue du chien à plume', '51100', 'REIMS', '0618475969'),
(69, 'RCB', '19 rue de la poule des champs', '51100', 'REIMS', '0658987845'),
(156, 'Tinqueux', '12 rue fouchet', '51100', 'TINQUEUX', '065892'),
(15462, 'Murigny', '12 place rené clair', '51100', 'VAL DE MURIGNY', '065923'),
(65289, 'Europe', '16 rue gougelet', '51100', 'REIMS', '0628354'),
(121212, 'Betheny', '12 rue du chien sans queue', '51100', 'Reims', '0606060606'),
(123456, 'Reims', '125 Avenue cul nu', '51100', 'REIMS', '0669696969'),
(618259, 'Epernay', '12 rue du champagne', '51289', 'EPERNAY', '067281');

-- --------------------------------------------------------

--
-- Structure de la table `dispo`
--

CREATE TABLE IF NOT EXISTS `dispo` (
  `idMembre` int(11) NOT NULL,
  `idPlage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

CREATE TABLE IF NOT EXISTS `equipe` (
`idEquipe` int(11) NOT NULL,
  `idCoach` int(11) DEFAULT NULL,
  `refClub` int(11) NOT NULL,
  `idCat` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `equipe`
--

INSERT INTO `equipe` (`idEquipe`, `idCoach`, `refClub`, `idCat`) VALUES
(0, 0, 0, ' '),
(1, 10, 121212, 'U7'),
(2, 11, 123456, 'Sénior'),
(8, 12, 156, 'U10-U11'),
(9, 13, 15462, 'U10-U11'),
(10, 13, 65289, 'U10-U11'),
(11, 13, 121212, 'U10-U11'),
(12, 13, 123456, 'U10-U11'),
(13, 13, 618259, 'U10-U11'),
(14, 10, 68, 'U10-U11'),
(15, 11, 69, 'U10-U11'),
(16, 10, 69, 'U14-U15'),
(17, 11, 68, 'U14-U15'),
(18, 13, 123456, 'U14-U15'),
(19, 12, 618259, 'U14-U15');

-- --------------------------------------------------------

--
-- Structure de la table `match`
--

CREATE TABLE IF NOT EXISTS `match` (
  `idMatch` int(11) NOT NULL,
  `idTerrain` int(11) NOT NULL,
  `idLocal` int(11) NOT NULL,
  `idVisiteur` int(11) NOT NULL,
  `scoreLocal` int(11) DEFAULT NULL,
  `scoreVisiteur` int(11) DEFAULT NULL,
  `idArbitre1` int(11) NOT NULL,
  `idArbitre2` int(11) NOT NULL,
  `idPlage` int(11) NOT NULL,
  `idNextMatch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `match`
--

INSERT INTO `match` (`idMatch`, `idTerrain`, `idLocal`, `idVisiteur`, `scoreLocal`, `scoreVisiteur`, `idArbitre1`, `idArbitre2`, `idPlage`, `idNextMatch`) VALUES
(0, 2, 8, 9, 0, 0, 6, 6, 2, 4),
(1, 2, 10, 11, 0, 0, 6, 6, 3, 4),
(2, 2, 12, 13, 0, 0, 6, 6, 4, 5),
(3, 2, 14, 15, 0, 0, 6, 6, 5, 5),
(4, 2, 0, 0, 0, 0, 6, 6, 7, 6),
(5, 2, 0, 0, 0, 0, 6, 6, 8, 6),
(6, 2, 0, 0, 0, 0, 6, 6, 10, -1),
(8, 4, 16, 17, 0, 0, 6, 6, 11, 10),
(9, 4, 18, 19, 0, 0, 6, 6, 12, 10),
(10, 4, 0, 0, 0, 0, 6, 6, 14, -1);

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE IF NOT EXISTS `membre` (
`idMembre` int(11) NOT NULL,
  `idEquipe` int(11) DEFAULT NULL,
  `Type` enum('Arbitre','Joueur','Coach','Benevole','Organisateur','Administrateur') NOT NULL,
  `nom` varchar(70) NOT NULL,
  `prnm` varchar(70) NOT NULL,
  `mail` varchar(250) NOT NULL,
  `numLicence` varchar(50) DEFAULT NULL,
  `numTel` varchar(15) DEFAULT NULL,
  `adresse` varchar(250) DEFAULT NULL,
  `cp` varchar(10) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `niveauArbitre` varchar(10) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `membre`
--

INSERT INTO `membre` (`idMembre`, `idEquipe`, `Type`, `nom`, `prnm`, `mail`, `numLicence`, `numTel`, `adresse`, `cp`, `ville`, `niveauArbitre`, `password`) VALUES
(0, NULL, 'Coach', 'NULL', 'NULL', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, NULL, 'Administrateur', 'ADMIN', 'admin', 'admin@admin.fr', NULL, NULL, NULL, NULL, NULL, NULL, 'd033e22ae348aeb5660fc2140aec35850c4da997'),
(6, NULL, 'Arbitre', 'ARBITRE', 'arbitre', 'arbitre@arbitre.fr', NULL, NULL, NULL, NULL, NULL, NULL, '0912e264e176a7f1be428186a022e671bed310c4'),
(7, NULL, 'Benevole', 'BENEVOLE', 'benevole', 'benevole@benevole.fr', NULL, NULL, NULL, NULL, NULL, NULL, 'b4cb06f9b6d6fa644da1d6c89efc616416218c04'),
(8, NULL, 'Joueur', 'JOUEUR', 'Joueur', 'joueur@joueur.fr', '123456789', '0251484845', '13 rue General Degaulle', '51100', 'Reims', NULL, '3ca1376bf29ebd170b0d900b8e5ab2f3c33a0fce'),
(9, NULL, 'Organisateur', 'ORGANISATEUR', 'organisateur', 'organisateur@organisateur.fr', NULL, '0606060606', NULL, NULL, NULL, NULL, '3c5166788137978ee0fb4681f47b5eb76834e15e'),
(10, NULL, 'Coach', 'COACH - RCB', 'coach', 'coach@coach.fr', '12345', '0651', 'Wallah', '51100', 'Ouarzazate', NULL, 'c63c8ec7f6e2308874076f269e863af55d2cc22e'),
(11, NULL, 'Coach', 'COACH - RMV', 'coach', 'coach-reims@coach.fr', NULL, '0658', 'RORORORO', '51100', 'REIMS', NULL, 'c63c8ec7f6e2308874076f269e863af55d2cc22e'),
(12, NULL, 'Coach', 'COACH', 'coach', 'coach-reims@coach.fr', NULL, '065867687', 'RORORORO', '51100', 'REIMS', NULL, 'c63c8ec7f6e2308874076f269e863af55d2cc22e'),
(13, NULL, 'Coach', 'COACH Jesus', 'coach', 'coach@coach.fr', '123459', '0651', 'Wallah', '51100', 'Ouarzazate', NULL, 'c63c8ec7f6e2308874076f269e863af55d2cc22e');

-- --------------------------------------------------------

--
-- Structure de la table `plage`
--

CREATE TABLE IF NOT EXISTS `plage` (
`idPlage` int(11) NOT NULL,
  `jour` int(11) NOT NULL,
  `hDeb` time NOT NULL,
  `hFin` time NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `plage`
--

INSERT INTO `plage` (`idPlage`, `jour`, `hDeb`, `hFin`) VALUES
(1, 1, '08:00:00', '08:00:00'),
(2, 1, '08:00:00', '08:30:00'),
(3, 1, '08:30:00', '09:00:00'),
(4, 1, '09:00:00', '09:30:00'),
(5, 1, '09:30:00', '10:00:00'),
(6, 1, '10:00:00', '10:30:00'),
(7, 1, '10:30:00', '11:00:00'),
(8, 1, '11:00:00', '11:30:00'),
(9, 1, '11:30:00', '12:00:00'),
(10, 1, '12:00:00', '12:30:00'),
(11, 1, '08:00:00', '08:30:00'),
(12, 1, '08:30:00', '09:00:00'),
(13, 1, '09:00:00', '09:30:00'),
(14, 1, '09:30:00', '10:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `terrain`
--

CREATE TABLE IF NOT EXISTS `terrain` (
`idTerrain` int(11) NOT NULL,
  `interieur` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `terrain`
--

INSERT INTO `terrain` (`idTerrain`, `interieur`) VALUES
(1, 1),
(2, 0),
(3, 0),
(4, 0);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
 ADD PRIMARY KEY (`idCat`), ADD KEY `idCat` (`idCat`);

--
-- Index pour la table `club`
--
ALTER TABLE `club`
 ADD PRIMARY KEY (`refClub`), ADD KEY `refClub` (`refClub`);

--
-- Index pour la table `dispo`
--
ALTER TABLE `dispo`
 ADD PRIMARY KEY (`idMembre`,`idPlage`), ADD KEY `idPlage` (`idPlage`), ADD KEY `idMembre` (`idMembre`);

--
-- Index pour la table `equipe`
--
ALTER TABLE `equipe`
 ADD PRIMARY KEY (`idEquipe`), ADD KEY `idEquipe` (`idEquipe`), ADD KEY `refClub` (`refClub`), ADD KEY `idCat` (`idCat`);

--
-- Index pour la table `match`
--
ALTER TABLE `match`
 ADD PRIMARY KEY (`idMatch`), ADD KEY `idMatch` (`idMatch`), ADD KEY `idPlage` (`idPlage`), ADD KEY `idArbitre2` (`idArbitre2`), ADD KEY `idArbitre1` (`idArbitre1`), ADD KEY `idVisiteur` (`idVisiteur`), ADD KEY `idTerrain` (`idTerrain`), ADD KEY `idLocal` (`idLocal`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
 ADD PRIMARY KEY (`idMembre`), ADD KEY `idMembre` (`idMembre`), ADD KEY `idEquipe` (`idEquipe`);

--
-- Index pour la table `plage`
--
ALTER TABLE `plage`
 ADD PRIMARY KEY (`idPlage`), ADD KEY `idPlage` (`idPlage`);

--
-- Index pour la table `terrain`
--
ALTER TABLE `terrain`
 ADD PRIMARY KEY (`idTerrain`), ADD KEY `idTerrain` (`idTerrain`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `equipe`
--
ALTER TABLE `equipe`
MODIFY `idEquipe` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
MODIFY `idMembre` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `plage`
--
ALTER TABLE `plage`
MODIFY `idPlage` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `terrain`
--
ALTER TABLE `terrain`
MODIFY `idTerrain` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `dispo`
--
ALTER TABLE `dispo`
ADD CONSTRAINT `dispo_ibfk_1` FOREIGN KEY (`idPlage`) REFERENCES `plage` (`idPlage`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `dispo_ibfk_2` FOREIGN KEY (`idMembre`) REFERENCES `membre` (`idMembre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `equipe`
--
ALTER TABLE `equipe`
ADD CONSTRAINT `equipe_ibfk_1` FOREIGN KEY (`refClub`) REFERENCES `club` (`refClub`),
ADD CONSTRAINT `equipe_ibfk_2` FOREIGN KEY (`idCat`) REFERENCES `categorie` (`idCat`);

--
-- Contraintes pour la table `match`
--
ALTER TABLE `match`
ADD CONSTRAINT `match_ibfk_1` FOREIGN KEY (`idTerrain`) REFERENCES `terrain` (`idTerrain`),
ADD CONSTRAINT `match_ibfk_2` FOREIGN KEY (`idLocal`) REFERENCES `equipe` (`idEquipe`),
ADD CONSTRAINT `match_ibfk_3` FOREIGN KEY (`idVisiteur`) REFERENCES `equipe` (`idEquipe`),
ADD CONSTRAINT `match_ibfk_4` FOREIGN KEY (`idArbitre1`) REFERENCES `membre` (`idMembre`),
ADD CONSTRAINT `match_ibfk_5` FOREIGN KEY (`idArbitre2`) REFERENCES `membre` (`idMembre`),
ADD CONSTRAINT `match_ibfk_6` FOREIGN KEY (`idPlage`) REFERENCES `plage` (`idPlage`);

--
-- Contraintes pour la table `membre`
--
ALTER TABLE `membre`
ADD CONSTRAINT `membre_ibfk_2` FOREIGN KEY (`idEquipe`) REFERENCES `equipe` (`idEquipe`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
