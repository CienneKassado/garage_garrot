SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `commentaires` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `notes` int(11) DEFAULT NULL,
  `commentaires` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `commentaires` (`id`, `nom`, `notes`, `commentaires`) VALUES
(6, 'LE GARAGE DE Mr Parrot', NULL, 'L\'administrateur vous salue');

CREATE TABLE `comptes` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `rang` varchar(255) DEFAULT NULL,
  `naissance` date DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `comptes` (`id`, `nom`, `prenom`, `mot_de_passe`, `rang`, `naissance`, `mail`, `telephone`) VALUES
(1, 'Doe', 'John', 'Azerty123', 'Administrateur', NULL, 'johndoe@gmail.com', '0700000000'),
(2, 'Parrot', 'Vincent', 'Azerty123', 'Administrateur', NULL, 'parrot@gmail.com', '0700000000'),
(3, 'Mini', 'Laura', 'Azerty123', 'Mecanicien', NULL, 'minnie@gmail.com', '0700000000');

CREATE TABLE `contacts` (
  `id_con` int(11) NOT NULL,
  `nom_con` varchar(255) DEFAULT NULL,
  `prenom_con` varchar(255) DEFAULT NULL,
  `mail_con` varchar(255) DEFAULT NULL,
  `telephone_con` varchar(255) DEFAULT NULL,
  `message_con` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `contacts` (`id_con`, `nom_con`, `prenom_con`, `mail_con`, `telephone_con`, `message_con`) VALUES
(1, 'Ammet', 'Leslie', 'candys.noemie2004@gmail.com', NULL, 'Bonjour seriez vous disponible vendredi 13');

CREATE TABLE `horaires` (
  `id_hor` int(11) NOT NULL,
  `jour_semaine` varchar(255) DEFAULT NULL,
  `heure_ouverture` time DEFAULT NULL,
  `heure_fermeture` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `horaires` (`id_hor`, `jour_semaine`, `heure_ouverture`, `heure_fermeture`) VALUES
(43, 'Lundi', '08:00:00', '19:30:00'),
(44, 'Mardi', '08:00:00', '18:00:00'),
(45, 'Mercredi', '08:00:00', '18:00:00'),
(46, 'Jeudi', '08:00:00', '18:00:00'),
(47, 'Vendredi', '08:00:00', '19:00:00'),
(48, 'Samedi', '10:10:00', '12:00:00'),
(49, 'Dimanche', '10:00:00', '12:00:00');

CREATE TABLE `infos` (
  `id` int(11) NOT NULL,
  `description` text,
  `email` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `infos` (`id`, `description`, `email`, `adresse`, `telephone`, `image`) VALUES
(1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and  ially unchanged. It was popularised in the 1960s with the', 'example@example.com', '123 Rue du Commerce', '07-00-00-00-00', 'images/garage.png');

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `nom` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `services` (`id`, `description`, `nom`) VALUES
(10, 'La réparation mécanique consiste à restaurer, corriger ou remplacer les composants défectueux d\'un système mécanique, tel qu\'un moteur, une transmission ou des pièces automobiles. Cela implique souvent l\'utilisation d\'outils spécifiques et de compétences techniques pour résoudre les problèmes et rétablir le bon fonctionnement de l\'équipement. L\'objectif est de remettre en état de marche le mécanisme en minimisant les risques de panne future et en prolongeant sa durée de vie utile.', 'Reparation mecanique'),
(13, '\r\nLa réparation carrosserie consiste à restaurer ou réparer les dommages externes d\'un véhicule, comme les bosses, les rayures ou les déformations, afin de le remettre en bon état esthétique et fonctionnel. Cela implique souvent des travaux de redressement, de peinture et de remplacement de pièces endommagées.', 'Réparation carrosserie');

CREATE TABLE `voitures` (
  `id_v` int(11) NOT NULL,
  `nom_v` varchar(255) DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `image1` text,
  `image2` text,
  `image3` text,
  `annee` int(11) DEFAULT NULL,
  `kilometrage` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `voitures` (`id_v`, `nom_v`, `prix`, `image1`, `image2`, `image3`, `annee`, `kilometrage`) VALUES
(3, 'Voiture', '10000.00', 'citroen.jpg', '', '', 2020, 20000);

ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `comptes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id_con`);

