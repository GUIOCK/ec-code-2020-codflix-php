-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 25 juin 2020 à 18:31
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `codflix`
--
CREATE DATABASE IF NOT EXISTS `codflix` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `codflix`;

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

DROP TABLE IF EXISTS `genre`;
CREATE TABLE IF NOT EXISTS `genre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `genre`
--

INSERT INTO `genre` (`id`, `name`) VALUES
(1, 'Action'),
(2, 'Horreur'),
(3, 'Science-Fiction');

-- --------------------------------------------------------

--
-- Structure de la table `history`
--

DROP TABLE IF EXISTS `history`;
CREATE TABLE IF NOT EXISTS `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `finish_date` datetime DEFAULT NULL,
  `watch_duration` int(11) NOT NULL DEFAULT 0 COMMENT 'in seconds',
  PRIMARY KEY (`id`),
  KEY `history_user_id_fk_media_id` (`user_id`),
  KEY `history_media_id_fk_media_id` (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `genre_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `release_date` date NOT NULL,
  `summary` longtext NOT NULL,
  `trailer_url` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `media_genre_id_fk_genre_id` (`genre_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `media`
--

INSERT INTO `media` (`id`, `genre_id`, `title`, `type`, `status`, `release_date`, `summary`, `trailer_url`) VALUES
(1, 2, 'Batman & Robin (1997)', 'movie', 'published', '1997-06-12', 'Bon, je vais pas faire un lorem ipsum pour celui la, juste parce que c\'est un clin d\'oeil à l\'un des meilleurs PO qu\'on ai eu cette année, qui a fait son possible et a réussi à faire de la première semaine de cours en confinement une réussite agréable pour tous', 'https://www.youtube.com/embed/4RBXypX4qWI'),
(2, 1, 'My little pony - The movie', 'movie', 'published', '2017-10-06', 'Parce que pourquoi pas, je craque, il est 1h du mat et voila, ce truc est passé dans ma tête sans aucune raison, me demandez pas comment je sais qu\'il y a eu un film, je sais plus non plus', 'https://www.youtube.com/embed/aeQe_mZcyf8'),
(4, 3, 'Meme saga', 'serie', 'in progress', '2020-06-25', 'Ne perdez pas trop de temps à regarder ça, c\'était surtout pour me faire une pause tout en ayant de quoi remplir et test la fonctionnalité avec des séries et pas que des films', 'https://www.youtube.com/embed/g2ERO71UIns');

-- --------------------------------------------------------

--
-- Structure de la table `media_content`
--

DROP TABLE IF EXISTS `media_content`;
CREATE TABLE IF NOT EXISTS `media_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `media_id` int(11) NOT NULL,
  `episode_title` varchar(200) NOT NULL,
  `season_number` int(11) NOT NULL,
  `episode_number` int(11) NOT NULL,
  `content_url` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `media_id` (`media_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `media_content`
--

INSERT INTO `media_content` (`id`, `media_id`, `episode_title`, `season_number`, `episode_number`, `content_url`) VALUES
(1, 1, 'Batman & Robin (1997)', 0, 0, 'https://www.youtube.com/embed/3M8FC7uZj3M'),
(2, 2, 'My little pony - The movie', 0, 0, 'https://www.youtube.com/embed/eYoooGb0Fmw'),
(3, 4, 'Bohemian rapsody but cooler', 1, 1, 'https://www.youtube.com/embed/tgbNymZ7vqY'),
(4, 4, 'Bohemian rapsody but worst', 1, 2, 'https://www.youtube.com/embed/V8Ni1-VTDqc'),
(5, 4, 'Mangez 5 fruits et légumes par jour', 1, 3, 'https://www.youtube.com/embed/1wnE4vF9CQ4'),
(6, 4, 'Pas du tout un rick roll', 1, 4, 'https://www.youtube.com/embed/dQw4w9WgXcQ'),
(7, 4, 'Le truc qui m\'a fait tenir toute la nuit', 1, 5, 'https://www.youtube.com/embed/32FB-gYr49Y'),
(8, 4, 'Parce que les memes, c\'est comme le bon vin', 1, 6, 'https://www.youtube.com/embed/BBGEG21CGo0'),
(9, 4, 'Pour la transition vers la prochaine saison !', 2, 1, 'https://www.youtube.com/embed/AQx_KMoCgJU'),
(10, 4, 'Vous avez deviner le theme de cette saison ?', 2, 2, 'https://www.youtube.com/embed/wLoRiTk-awo'),
(11, 4, 'Parce que le point godwin', 2, 3, 'https://www.youtube.com/embed/m_2GWS9fxwg'),
(12, 4, 'Parce que je vous aime, et c\'est pas pour gratter des points', 2, 4, 'https://www.youtube.com/embed/UQ-g0BdpbDM');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(254) NOT NULL,
  `validationHash` varchar(257) NOT NULL,
  `isValidated` tinyint(1) NOT NULL DEFAULT 0,
  `password` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `validationHash`, `isValidated`, `password`) VALUES
(18, 'test@codflix.com', 'd4e33e2934280979f580a63f992daa7d0de2cd64a145d5c403a75c3dc5c0004e', 1, '4813494d137e1631bba301d5acab6e7bb7aa74ce1185d456565ef51d737677b2'),
(24, 'coding@gmail.com', 'bb9b8ef813475d1e0ad84e2505af6656d16c990b1f77efaf9324e8fbcae2db67', 1, '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_media_id_fk_media_id` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `history_user_id_fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_genre_id_b1257088_fk_genre_id` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
