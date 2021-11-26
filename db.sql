-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 08, 2021 at 06:42 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rentcar`
--

-- --------------------------------------------------------

--
-- Table structure for table `facture`
--

CREATE TABLE `facture` (
  `id_facture` int(11) NOT NULL,
  `ide` int(11) NOT NULL,
  `idv` int(11) NOT NULL,
  `date_d` date NOT NULL,
  `date_f` date DEFAULT NULL,
  `valeur` double NOT NULL,
  `etat_r` tinyint(1) NOT NULL,
  `retourne` tinyint(1) DEFAULT NULL,
  `revision` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `facture`
--

INSERT INTO `facture` (`id_facture`, `ide`, `idv`, `date_d`, `date_f`, `valeur`, `etat_r`, `retourne`, `revision`) VALUES
(77, 5, 3, '2021-11-08', '2021-12-08', 7200, 1, 1, NULL),
(78, 5, 3, '2021-11-08', '2021-12-08', 7200, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8_bin NOT NULL,
  `prenom` varchar(255) COLLATE utf8_bin NOT NULL,
  `pseudo` varchar(255) COLLATE utf8_bin NOT NULL,
  `mdp` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `nomE` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'LOUEUR',
  `adresseE` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'LOUEUR',
  `role` varchar(30) COLLATE utf8_bin NOT NULL DEFAULT 'ROLE_UTILISATEUR'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `nom`, `prenom`, `pseudo`, `mdp`, `email`, `nomE`, `adresseE`, `role`) VALUES
(1, 'Balamon', 'Marco', 'marcoegy93', '$argon2id$v=19$m=65536,t=4,p=1$a0ZGLjJLbVNXZ1E5UlI4Ng$JBGuIxtKOBKcp7eZGdqVLKMmRPj/oAbfWhvaUDh/Xl0', 'marco.balamon@gmail.com', 'LOUEUR', 'LOUEUR', 'ROLE_LOUEUR'),
(2, 'Saavedra', 'Arthur', 'ciscoVersailles', '$argon2id$v=19$m=65536,t=4,p=1$LmFBaE1OTjR2ZGJCaWh4Tw$hEuorWIoQ0IG5V7iECVanrGMfgO3IVgOoD+sICCcK6Q', 'cisco@gmail.com', 'Microsoft', '143 rue de la Voie Lactée, 93000 Bobigny', 'ROLE_UTILISATEUR'),
(3, 'Sivanand', 'Nirussan', 'Niru', '$argon2id$v=19$m=65536,t=4,p=1$bkQzYlNuVmxuZzJHay42aQ$1PRI+rvQD+WwAhK9ROfd/4lo/9dNCGXjL04lpLueSDs', 'Niru@gmail.com', 'Apple', '143 rue du futur Président, 13001 Marseille', 'ROLE_UTILISATEUR'),
(4, 'Zaher', 'Lyamine', 'Lyamine', '$argon2id$v=19$m=65536,t=4,p=1$QnN1aXkzYUMwQ2EzZmdmZg$Ih7kuJEjO6QrgyFh8CZY9m/dDJEyYyJjOChUc45CHC0', 'zaher93@gmail.com', 'Amazon', '143 rue de Crimée, 75019 Paris', 'ROLE_UTILISATEUR'),
(5, 'Dem', 'Cherif', 'Cherif', '$argon2id$v=19$m=65536,t=4,p=1$dHBxMVdtbE9Mc3IxMDlXbA$7Zbf9WobM0shILjpUkKcc2YTmwjrGy46kMq/pFI+mTY', 'cherif@gmail.com', 'SpaceX', '143 rue Karl Marx, 69001 Lyon', 'ROLE_UTILISATEUR');

-- --------------------------------------------------------

--
-- Table structure for table `vehicule`
--

CREATE TABLE `vehicule` (
  `id_vehicule` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_bin NOT NULL,
  `nb` int(10) UNSIGNED NOT NULL,
  `caract` longtext COLLATE utf8_bin NOT NULL COMMENT '(DC2Type:json)',
  `prix` float NOT NULL,
  `photo` varchar(255) COLLATE utf8_bin NOT NULL,
  `vehiculesDispo` longtext COLLATE utf8_bin NOT NULL COMMENT '(DC2Type:json)',
  `vehiculesLoues` longtext COLLATE utf8_bin COMMENT '(DC2Type:json)',
  `vehiculesEnRevision` longtext COLLATE utf8_bin COMMENT '(DC2Type:json)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `vehicule`
--

INSERT INTO `vehicule` (`id_vehicule`, `type`, `nb`, `caract`, `prix`, `photo`, `vehiculesDispo`, `vehiculesLoues`, `vehiculesEnRevision`) VALUES
(1, 'Porsche 911 GT3', 3, '{\"categorie\":\"Course\",\"energie\":\"Essence\",\"moteur\":\"Thermique\",\"boite\":\"Automatique\",\"nb_portes\":\"4 portes\"}', 250, '911.jpeg', '{\"vehicule1\":\"disponible\",\"vehicule2\":\"disponible\",\"vehicule3\":\"disponible\"}', NULL, NULL),
(2, 'Chevrolet Camaro', 5, '{\"categorie\":\"MuscleCar\",\"energie\":\"Essence\",\"moteur\":\"Thermique\",\"boite\":\"Automatique\",\"nb_portes\":\"3 portes\"}', 210, 'camaro.jpeg', '{\"vehicule1\":\"disponible\",\"vehicule2\":\"disponible\",\"vehicule3\":\"disponible\",\"vehicule4\":\"disponible\",\"vehicule5\":\"disponible\"}', NULL, NULL),
(3, 'Dodge Challenger', 2, '{\"categorie\":\"MuscleCar\",\"energie\":\"Essence\",\"moteur\":\"Thermique\",\"boite\":\"Manuelle\",\"nb_portes\":\"3 portes\"}', 240, 'challenger.jpeg', '{\"vehicule1\":\"disponible\",\"vehicule2\":\"disponible\"}', '[]', NULL),
(4, 'Nissan 350z', 3, '{\"categorie\":\"Coupe\",\"energie\":\"Essence\",\"moteur\":\"Thermique\",\"boite\":\"Manuelle\",\"nb_portes\":\"4 portes\"}', 190, '350z.jpeg', '{\"vehicule1\":\"disponible\",\"vehicule2\":\"disponible\",\"vehicule3\":\"disponible\"}', NULL, NULL),
(5, 'Maserati Gran Turismo', 5, '{\"categorie\":\"Course\",\"energie\":\"Essence\",\"moteur\":\"Thermique\",\"boite\":\"Automatique\",\"nb_portes\":\"5 portes\"}', 300, 'maserati.png', '{\"vehicule1\":\"disponible\",\"vehicule2\":\"disponible\",\"vehicule3\":\"disponible\",\"vehicule4\":\"disponible\",\"vehicule5\":\"disponible\"}', NULL, NULL),
(6, 'Mercedes AMG G63', 5, '{\"categorie\":\"4x4, SUV, Crossover\",\"energie\":\"Essence\",\"moteur\":\"Thermique\",\"boite\":\"Automatique\",\"nb_portes\":\"5 portes\"}', 300, 'g63.jpeg', '{\"vehicule1\":\"disponible\",\"vehicule2\":\"disponible\",\"vehicule3\":\"disponible\",\"vehicule4\":\"disponible\",\"vehicule5\":\"disponible\"}', NULL, NULL),
(7, 'Ford Mustang', 5, '{\"categorie\":\"MuscleCar\",\"energie\":\"Essence\",\"moteur\":\"Thermique\",\"boite\":\"Automatique\",\"nb_portes\":\"5 portes\"}', 300, 'mustang.jpeg', '{\"vehicule1\":\"disponible\",\"vehicule2\":\"disponible\",\"vehicule3\":\"disponible\",\"vehicule4\":\"disponible\",\"vehicule5\":\"disponible\"}', NULL, NULL),
(8, 'Nissan GTR Nismo', 5, '{\"categorie\":\"Course\",\"energie\":\"Essence\",\"moteur\":\"Thermique\",\"boite\":\"Automatique\",\"nb_portes\":\"3 portes\"}', 400, 'nismo.jpeg', '{\"vehicule1\":\"disponible\",\"vehicule2\":\"disponible\",\"vehicule3\":\"disponible\",\"vehicule4\":\"disponible\",\"vehicule5\":\"disponible\"}', NULL, NULL),
(9, 'Rolls Royce Phantom', 5, '{\"categorie\":\"Citadine\",\"energie\":\"Essence\",\"moteur\":\"Thermique\",\"boite\":\"Automatique\",\"nb_portes\":\"5 portes\"}', 600, 'rolls.jpeg', '{\"vehicule1\":\"disponible\",\"vehicule2\":\"disponible\",\"vehicule3\":\"disponible\",\"vehicule4\":\"disponible\",\"vehicule5\":\"disponible\"}', NULL, NULL),
(10, 'Lamborghini Urus', 5, '{\"categorie\":\"4x4, SUV, Crossover\",\"energie\":\"Essence\",\"moteur\":\"Thermique\",\"boite\":\"Automatique\",\"nb_portes\":\"5 portes\"}', 450, 'urus.jpeg', '{\"vehicule1\":\"disponible\",\"vehicule2\":\"disponible\",\"vehicule3\":\"disponible\",\"vehicule4\":\"disponible\",\"vehicule5\":\"disponible\"}', NULL, NULL),
(11, 'Ferrari LaFerrari', 6, '{\"categorie\":\"Course\",\"energie\":\"Essence\",\"moteur\":\"Thermique\",\"boite\":\"Automatique\",\"nb_portes\":\"2 portes\"}', 500, 'laferrari.jpeg', '{\"vehicule1\":\"disponible\",\"vehicule2\":\"disponible\",\"vehicule3\":\"disponible\",\"vehicule4\":\"disponible\",\"vehicule5\":\"disponible\",\"vehicule6\":\"disponible\"}', NULL, NULL),
(12, 'Audi R8', 5, '{\"categorie\":\"Course\",\"energie\":\"Essence\",\"moteur\":\"Thermique\",\"boite\":\"Automatique\",\"nb_portes\":\"2 portes\"}', 430, 'r8.jpeg', '{\"vehicule1\":\"disponible\",\"vehicule2\":\"disponible\",\"vehicule3\":\"disponible\",\"vehicule4\":\"disponible\",\"vehicule5\":\"disponible\"}', NULL, NULL),
(13, 'Dodge Viper', 4, '{\"categorie\":\"Course\",\"energie\":\"Essence\",\"moteur\":\"Thermique\",\"boite\":\"Automatique\",\"nb_portes\":\"2 portes\"}', 500, 'viper.jpeg', '{\"vehicule1\":\"disponible\",\"vehicule2\":\"disponible\",\"vehicule3\":\"disponible\",\"vehicule4\":\"disponible\"}', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`id_facture`),
  ADD KEY `IDX_EC224CAA79F37AE5` (`ide`),
  ADD KEY `IDX_EC224CAAE5F14372` (`idv`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- Indexes for table `vehicule`
--
ALTER TABLE `vehicule`
  ADD PRIMARY KEY (`id_vehicule`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `facture`
--
ALTER TABLE `facture`
  MODIFY `id_facture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `vehicule`
--
ALTER TABLE `vehicule`
  MODIFY `id_vehicule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`ide`) REFERENCES `utilisateur` (`id_utilisateur`),
  ADD CONSTRAINT `facture_ibfk_2` FOREIGN KEY (`idv`) REFERENCES `vehicule` (`id_vehicule`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
