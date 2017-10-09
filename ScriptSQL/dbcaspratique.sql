-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Lun 09 Octobre 2017 à 15:34
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `dbcaspratique`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `avis_id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `endroit_id` int(11) NOT NULL,
  `note` int(11) NOT NULL,
  `commentaire` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `avis`
--

INSERT INTO `avis` (`avis_id`, `utilisateur_id`, `endroit_id`, `note`, `commentaire`) VALUES
(1, 1, 1, 4, 'excellent endroit pour randonnée'),
(2, 1, 1, 3, 'Jaime Tana');

-- --------------------------------------------------------

--
-- Structure de la table `endroit`
--

CREATE TABLE `endroit` (
  `endroit_id` int(11) NOT NULL,
  `ville` varchar(20) NOT NULL,
  `image` varchar(20) NOT NULL,
  `description` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `endroit`
--

INSERT INTO `endroit` (`endroit_id`, `ville`, `image`, `description`) VALUES
(1, 'Toliara', 'img.jpg', 'les plus belles endroit pour randonnées '),
(2, 'fianarantsoa', 'fianara.jpg', 'les plus belles endroit pour randonnées '),
(3, 'fianarantsoa', 'fianara.jpg', 'les plus belles endroit pour randonnées ');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `utilisateur_id` int(11) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `genre` varchar(20) NOT NULL,
  `date_anniversaire` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`utilisateur_id`, `nom`, `email`, `password`, `genre`, `date_anniversaire`) VALUES
(1, 'Randria', 'randria@gmail.com', '123', 'M', '2017-10-11'),
(2, 'toto', 'toto@gmail.com', '123', 'M', '2017-02-12');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`avis_id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`),
  ADD KEY `endroit_id` (`endroit_id`);

--
-- Index pour la table `endroit`
--
ALTER TABLE `endroit`
  ADD PRIMARY KEY (`endroit_id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`utilisateur_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `avis_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `endroit`
--
ALTER TABLE `endroit`
  MODIFY `endroit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `utilisateur_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `avis_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`utilisateur_id`),
  ADD CONSTRAINT `avis_ibfk_2` FOREIGN KEY (`endroit_id`) REFERENCES `endroit` (`endroit_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
