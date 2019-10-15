-- phpMyAdmin SQL Dump
-- version 4.8.4
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Sam 16 Février 2019 à 17:06
-- Version du serveur :  3.1.7
-- Version de PHP :  7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `prwb_1819_pc08`
--
CREATE DATABASE IF NOT EXISTS `prwb_1819_pc08` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `prwb_1819_pc08`;
-- --------------------------------------------------------

--
-- Structure de la table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `isbn` char(13) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `editor` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `book`
--

INSERT INTO `book` (`id`, `isbn`, `title`, `author`, `editor`, `picture`) VALUES
(19, '000-0-0000-00', 'Java for Dummies', 'Duchmol', 'EPFC', '1549881524.png'),
(21, '000-0-0000-02', 'Le seigneur de Anneau', 'Tolkien', 'Smith &amp; Co', '1550238885.jpg'),
(22, '000-0-4080-07', 'Les Misérables', 'Victor Hugo', 'XO Editions', '1550190945.png'),
(26, 'dzadazc', 'czzc', 'csqs', 'xqsx', NULL),
(29, '1234567897', 'victor Hugue', 'ALCOOL', 'GUILLAUME APPOLINAIRE', NULL),
(30, 'trgrtg', 'rgerg', 'gregrg', 'gregr', NULL),
(31, 'rereze', 'rfzerf', 'efrefe', 'ffzez', NULL),
(42, 'gdvwvsd', 'dsvdsd', 'dssssss', 'wss', NULL),
(43, '123456797lfvd', 'zadza', 'zaza', 'as', '1550190838.jpg'),
(45, 'ghjkloiuth', 'rerfez', 'zezze', 'ezrez', NULL),
(49, '8741525521452', 'frfrfe', 'ferfer', 'rfe', NULL),
(50, '1458795623150', 'Ndjomatchoua', 'rat palmiste', 'COREFUDO', '1550237951.png');

-- --------------------------------------------------------

--
-- Structure de la table `rental`
--

CREATE TABLE `rental` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `book` int(11) NOT NULL,
  `rentaldate` datetime DEFAULT NULL,
  `returndate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(64) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `role` enum('admin','manager','member') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `fullname`, `email`, `birthdate`, `role`) VALUES
(44, 'CHENDJOU', '9a3607390bf9163847f0c2644460e025', 'IGLESIAS', 'robaince.chendjou@yahoo.fr', '1993-11-25', 'admin'),
(45, 'IDISOULE', 'f0b7002c560c222b4c6d04669f8f34d0', 'x', 'idi@gmail.com', '1994-02-10', 'manager'),
(46, 'Dongue', 'fe8cfb4357b66c2d21eb6dc6c140410f', 'ben', 'talla@gmail.com', '1999-01-01', 'member');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn_UNIQUE` (`isbn`);

--
-- Index pour la table `rental`
--
ALTER TABLE `rental`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rentalitem_book1_idx` (`book`),
  ADD KEY `fk_rentalitem_user1_idx` (`user`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_unique` (`username`) USING BTREE,
  ADD UNIQUE KEY `email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT pour la table `rental`
--
ALTER TABLE `rental`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=273;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `rental`
--
ALTER TABLE `rental`
  ADD CONSTRAINT `fk_rentalitem_book` FOREIGN KEY (`book`) REFERENCES `book` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rentalitem_user1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
