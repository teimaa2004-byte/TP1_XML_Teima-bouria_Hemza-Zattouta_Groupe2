-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 22 mai 2026 à 21:26
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `club_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` varchar(10) NOT NULL,
  `libelle` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `libelle`) VALUES
('C1', 'Intelligence Artificielle'),
('C2', 'Développement Web'),
('C3', 'Sécurité Informatique');

-- --------------------------------------------------------

--
-- Structure de la table `concours`
--

CREATE TABLE `concours` (
  `id` varchar(10) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `categorieRef` varchar(10) DEFAULT NULL,
  `date_concours` date DEFAULT NULL,
  `coefficient` decimal(3,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `concours`
--

INSERT INTO `concours` (`id`, `titre`, `categorieRef`, `date_concours`, `coefficient`) VALUES
('CO1', 'Concours IA 2025', 'C1', '2025-03-15', 1.5),
('CO2', 'Web Challenge', 'C2', '2025-04-10', 1.2);

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

CREATE TABLE `membres` (
  `id` varchar(10) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `categorieRef` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `membres`
--

INSERT INTO `membres` (`id`, `nom`, `prenom`, `email`, `categorieRef`) VALUES
('M001', 'Benali', 'Ahmed', 'a.benali@club.dz', 'C1'),
('M002', 'Khelif', 'Sara', 's.khelif@club.dz', 'C2'),
('M003', 'Mansouri', 'Amine', 'a.mansouri@club.dz', 'C3'),
('M004', 'Zidani', 'Lamine', 'l.zidani@club.dz', 'C1'),
('M005', 'Brahimi', 'Ines', 'i.brahimi@club.dz', 'C2'),
('M006', 'Taleb', 'Yacine', 'y.taleb@club.dz', 'C3'),
('M007', 'Saidi', 'Meriem', 'm.saidi@club.dz', 'C1'),
('M008', 'Hamidi', 'Omar', 'o.hamidi@club.dz', 'C2');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `concours`
--
ALTER TABLE `concours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorieRef` (`categorieRef`);

--
-- Index pour la table `membres`
--
ALTER TABLE `membres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorieRef` (`categorieRef`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `concours`
--
ALTER TABLE `concours`
  ADD CONSTRAINT `concours_ibfk_1` FOREIGN KEY (`categorieRef`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `membres`
--
ALTER TABLE `membres`
  ADD CONSTRAINT `membres_ibfk_1` FOREIGN KEY (`categorieRef`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
