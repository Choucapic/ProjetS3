-- phpMyAdmin SQL Dump
-- version 4.2.12
-- http://www.phpmyadmin.net
--
-- Client :  mysql
-- Généré le :  Mar 08 Novembre 2016 à 14:47
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
  `idCoach` int(11) NOT NULL,
  ` refClub` int(11) NOT NULL,
  `idCat` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `match`
--

CREATE TABLE IF NOT EXISTS `match` (
`idMatch` int(11) NOT NULL,
  `idTerrain` int(11) NOT NULL,
  `idLocal` int(11) NOT NULL,
  `idVisiteur` int(11) NOT NULL,
  `idArbitre1` int(11) NOT NULL,
  `idArbitre2` int(11) NOT NULL,
  `idPlage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE IF NOT EXISTS `membre` (
`idMembre` int(11) NOT NULL,
  `idEquipe` int(11) DEFAULT NULL,
  `Type` enum('Arbitre','Joueur','Coach','Benevole','Organisateur') NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `membre`
--

INSERT INTO `membre` (`idMembre`, `idEquipe`, `Type`, `nom`, `prnm`, `mail`, `numLicence`, `numTel`, `adresse`, `cp`, `ville`, `niveauArbitre`, `password`) VALUES
(5, NULL, 'Organisateur', 'ADMIN', 'admin', 'admin@admin.fr', NULL, NULL, NULL, NULL, NULL, NULL, 'd033e22ae348aeb5660fc2140aec35850c4da997'),
(6, NULL, 'Arbitre', 'ARBITRE', 'arbitre', 'arbitre@arbitre.fr', NULL, NULL, NULL, NULL, NULL, NULL, '0912e264e176a7f1be428186a022e671bed310c4');

-- --------------------------------------------------------

--
-- Structure de la table `plage`
--

CREATE TABLE IF NOT EXISTS `plage` (
`idPlage` int(11) NOT NULL,
  `jour` int(11) NOT NULL,
  `hDeb` time NOT NULL,
  `hFin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `terrain`
--

CREATE TABLE IF NOT EXISTS `terrain` (
`idTerrain` int(11) NOT NULL,
  `interieur` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
 ADD PRIMARY KEY (`idEquipe`), ADD KEY `idEquipe` (`idEquipe`), ADD KEY ` refClub` (` refClub`), ADD KEY `idCat` (`idCat`);

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
MODIFY `idEquipe` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `match`
--
ALTER TABLE `match`
MODIFY `idMatch` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
MODIFY `idMembre` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `plage`
--
ALTER TABLE `plage`
MODIFY `idPlage` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `terrain`
--
ALTER TABLE `terrain`
MODIFY `idTerrain` int(11) NOT NULL AUTO_INCREMENT;
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
ADD CONSTRAINT `equipe_ibfk_1` FOREIGN KEY (` refClub`) REFERENCES `club` (`refClub`),
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
