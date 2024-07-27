-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 10 jan. 2023 à 19:44
-- Version du serveur :  10.6.11-MariaDB
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `zulf8960_tbo`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `client` text DEFAULT NULL,
  `secteur_activite` text DEFAULT NULL,
  `contact` text DEFAULT NULL,
  `telephone` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `adresse` text DEFAULT NULL,
  `date_conversion` date DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `date_enregistrement` datetime NOT NULL DEFAULT current_timestamp(),
  `etat` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `type`, `client`, `secteur_activite`, `contact`, `telephone`, `email`, `adresse`, `date_conversion`, `id_user`, `date_enregistrement`, `etat`) VALUES
(1, 'Client', 'ENVOL IMMOBILIER', 'Industrie', 'ISSA DANFAKHA', '', 'idanfakha@envol-immo.com', 'DIAMNIADO', NULL, 27, '2023-01-04 13:44:34', 1),
(2, 'Prospect', 'OLAM AGRI SENEGAL', 'Industrie', 'ALPHA DIEDHIOU', '', 'alpha.diedhiou@olamagri.com', 'DIAMNIADO', NULL, 27, '2023-01-04 14:03:44', 1),
(3, 'Prospect', 'LSCM', 'Industrie', 'Mme CISSE', '786584249', 'dom@lscmltd.com', 'Avenue Cheikh Anta Diop', NULL, 23, '2023-01-09 18:34:28', 1),
(4, 'Prospect', 'SENELEC', 'Industrie', 'MR SYLLA', '786391670', 'mareme@groupevigilus.com', 'Centre-ville', NULL, 23, '2023-01-09 18:34:48', 1),
(5, 'Prospect', 'FORTESA', 'Industrie', 'MR LY', '775292905', 'mahmoud@fortesa.com', 'Yoff-Dakar', NULL, 23, '2023-01-09 18:40:55', 1),
(6, 'Prospect', 'AIR LIQUIDE', 'Industrie', 'MR NDOYE', '774643035', 'mareme@groupevigilus.com', 'Zone Industrielle', NULL, 23, '2023-01-09 18:42:57', 1),
(7, 'Prospect', 'SENTRAK LOGISTICS', 'Industrie', 'MR NDONG', '773613766', 'andong@sentraklogistics.com', 'Centre-ville', NULL, 23, '2023-01-09 18:47:48', 1),
(8, 'Client', 'KALIA', 'Industrie', 'MR WADJI', '785892282', 'c.wadji@zeltexinternational.com', 'POINT E', NULL, 23, '2023-01-09 18:53:18', 1),
(9, 'Prospect', 'CSE IMMOBILIER', 'Industrie', 'ATTA NDIAYE', '775319440', 'attandiaye@cseimmobilier.sn', 'DIASS', NULL, 27, '2023-01-09 18:59:42', 1),
(10, 'Prospect', 'CSE IMMOBILIER', 'Industrie', 'ATTA NDIAYE', '775319440', 'attandiaye@cseimmobilier.sn', 'DIASS', NULL, 27, '2023-01-09 18:59:58', 1),
(11, 'Client', 'AMBASSADE COREE DU SUD', 'Industrie', 'Mme TATIANA', '775665395', 'coreeamb@yahoo.fr', 'Almadies', NULL, 23, '2023-01-09 19:17:29', 1),
(12, 'Client', 'LES GRANDS MOULINS DE DAKAR', 'Industrie', 'MR KOUYATE', '776398203', 'racine.kouyate@gmd.sn', 'Centre-ville', NULL, 23, '2023-01-09 19:22:06', 1),
(13, 'Client', 'CBAO', 'Industrie', 'MR NDIAYE', '777266996', 'Ismaila.NDIAYE@cbao.sn', 'Centre-ville', NULL, 23, '2023-01-10 09:57:07', 1),
(14, 'Prospect', 'Institut Supérieur d\'Enseignement Professionnel de Thiès', 'Services Généraux', 'Mme AITA GUEYE', '33 951 24 25', 'isep@isep-thies.edu.sn', 'THIES', NULL, 30, '2023-01-10 14:04:46', 1),
(15, 'Client', 'HÔTEL DES DEPUTES', 'Services Généraux', 'MME AICHA TOURE', '781028199', 'aichason074@gmail.com', 'Centre-ville', NULL, 23, '2023-01-10 14:17:31', 1),
(16, 'Prospect', 'Ecole Superieur Polytechnique', 'Services Généraux', 'Tidiane WADE', '33 825 05 40 / 33 825 55 94', 'tidiane.wade@esp.sn', 'DAKAR: B.P 5085 - Dakar-Fann', NULL, 30, '2023-01-10 14:25:35', 1);

-- --------------------------------------------------------

--
-- Structure de la table `departement`
--

CREATE TABLE `departement` (
  `id` int(11) NOT NULL,
  `nom` text DEFAULT NULL,
  `id_succursale` int(11) NOT NULL,
  `etat` int(11) NOT NULL DEFAULT 1,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `departement`
--

INSERT INTO `departement` (`id`, `nom`, `id_succursale`, `etat`, `id_user`) VALUES
(1, 'Sécurité Incendie', 1, 1, 1),
(2, 'Sécurité Electronique', 1, 1, 1),
(3, 'Sécurité Physique', 1, 1, 1),
(4, 'Nettoyage', 1, 1, 1),
(5, 'Monetique', 1, 1, 1),
(6, 'Solutions Pompages et Produits ATEX', 1, 1, 1),
(7, 'Formations', 1, 1, 1),
(8, 'Services Généraux', 1, 1, 1),
(9, 'Solutions IT', 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `document_sollicitation`
--

CREATE TABLE `document_sollicitation` (
  `id` int(11) NOT NULL,
  `type_document` text NOT NULL,
  `nom_document` text NOT NULL,
  `chemin` longtext NOT NULL,
  `id_sollicitation` int(11) DEFAULT NULL,
  `date_enregistrement` datetime NOT NULL DEFAULT current_timestamp(),
  `id_user` int(11) NOT NULL,
  `etat` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `document_sollicitation`
--

INSERT INTO `document_sollicitation` (`id`, `type_document`, `nom_document`, `chemin`, `id_sollicitation`, `date_enregistrement`, `id_user`, `etat`) VALUES
(1, 'PJ', 'PJ', 'documents/sollicitation/1/PJ.pdf', 1, '2023-01-10 10:55:51', 23, 1),
(2, 'of', 'of', 'documents/sollicitation/1/Offre financiere.pdf', 1, '2023-01-10 10:56:56', 23, 1),
(3, 'ot', 'ot', 'documents/sollicitation/1/Offre Technique.pdf', 1, '2023-01-10 10:56:56', 23, 1);

-- --------------------------------------------------------

--
-- Structure de la table `sollicitation`
--

CREATE TABLE `sollicitation` (
  `id` int(11) NOT NULL,
  `type` text DEFAULT NULL,
  `id_client` int(11) DEFAULT NULL,
  `date_reception` date DEFAULT NULL,
  `num_dossier` varchar(255) DEFAULT NULL,
  `date_limit` date DEFAULT NULL,
  `departement` longtext DEFAULT NULL,
  `details_ao` longtext DEFAULT NULL,
  `id_commercial` int(11) DEFAULT NULL,
  `date_recup` date DEFAULT NULL,
  `offre_financiere` int(11) DEFAULT NULL,
  `marge` int(11) DEFAULT NULL,
  `date_depot` date DEFAULT NULL,
  `date_resultat` date DEFAULT NULL,
  `commentaire_resultat` longtext DEFAULT NULL,
  `date_enregistrement` datetime DEFAULT current_timestamp(),
  `etat` int(11) DEFAULT 1,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `sollicitation`
--

INSERT INTO `sollicitation` (`id`, `type`, `id_client`, `date_reception`, `num_dossier`, `date_limit`, `departement`, `details_ao`, `id_commercial`, `date_recup`, `offre_financiere`, `marge`, `date_depot`, `date_resultat`, `commentaire_resultat`, `date_enregistrement`, `etat`, `id_user`) VALUES
(1, 'Appel d\'offre', 4, '2023-01-10', 'ZZ', '2023-01-10', 'Gardiennage, Informatique, ', '', 23, '2023-01-10', 0, 0, '2023-01-10', NULL, NULL, '2023-01-10 10:55:51', 4, 23);

-- --------------------------------------------------------

--
-- Structure de la table `tache`
--

CREATE TABLE `tache` (
  `id` int(11) NOT NULL,
  `id_client` int(11) DEFAULT NULL,
  `type_tache` text DEFAULT NULL,
  `date_tache` date DEFAULT NULL,
  `commentaire` longtext DEFAULT NULL,
  `commentaire_etat` text DEFAULT NULL,
  `num_devis` varchar(255) DEFAULT NULL,
  `montant` int(11) DEFAULT NULL,
  `departement` text DEFAULT NULL,
  `date_devis` date DEFAULT NULL,
  `date_validation` date DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `id_user_validation` int(11) DEFAULT NULL,
  `etat` int(11) NOT NULL DEFAULT 1,
  `date_enregistrement` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tache`
--

INSERT INTO `tache` (`id`, `id_client`, `type_tache`, `date_tache`, `commentaire`, `commentaire_etat`, `num_devis`, `montant`, `departement`, `date_devis`, `date_validation`, `id_user`, `id_user_validation`, `etat`, `date_enregistrement`) VALUES
(4, 1, 'Devis', '2023-01-04', 'En etude', NULL, 'DEV-05467', 297360, NULL, NULL, NULL, 27, NULL, 1, '2023-01-04 13:46:12'),
(5, 0, 'Relance', '2023-01-04', 'Elle dit que nos offres sont raisonnable et qu\'elle les a déjà transmises au responsable et qu\'elle nous fera un retour ', NULL, '', 0, NULL, NULL, NULL, 24, NULL, 1, '2023-01-04 16:34:11'),
(6, 2, 'Devis', '2023-01-04', 'En etude', NULL, 'DEV-05467', 297360, NULL, NULL, NULL, 27, NULL, 1, '2023-01-05 01:53:27'),
(8, 8, 'Devis', '2022-11-18', 'Notre Offre est en phase avec leur Budget, en attente du retour de la Direction Générale', NULL, '05255', 6821580, 'Ressources Humaines', NULL, NULL, 23, NULL, 1, '2023-01-09 18:58:54'),
(9, 8, 'Devis', '2022-11-18', 'Notre Offre est en phase avec leur Budget, en attente du retour de la Direction Générale', NULL, '05255', 6821580, 'Ressources Humaines', NULL, NULL, 23, NULL, 1, '2023-01-09 19:01:03'),
(10, 8, 'Devis', '2022-12-21', 'Notre Offre est en phase avec leur Budget, en attente du retour de la Direction Générale', NULL, '05419', 39282053, 'Ressources Humaines', NULL, NULL, 23, NULL, 1, '2023-01-09 19:05:20'),
(11, 8, 'Devis', '2022-12-27', 'Offre Fourniture Extincteurs Projet POINT E P14, En attente d\'étude.', NULL, '05433', 1369803, 'Ressources Humaines', NULL, NULL, 23, NULL, 1, '2023-01-09 19:08:50'),
(12, 8, 'Devis', '2022-12-27', 'Offre Installation Système de Détection Incendie Projet POINT E P14, En attente d\'étude.', NULL, '05434', 5878004, 'Ressources Humaines', NULL, NULL, 23, NULL, 1, '2023-01-09 19:11:52'),
(13, 8, 'Devis', '2023-01-05', 'Offre Installation Colonne Sèche Projet POINT E P14, En attente d\'étude.', NULL, '05485', 7503974, 'Ressources Humaines', NULL, NULL, 23, NULL, 1, '2023-01-09 19:14:38'),
(14, 11, 'Devis', '2023-01-09', 'Offre Installation Système Anti-Intrusion, en attente le retour du client', NULL, '05504', 1017600, 'Ressources Humaines', NULL, NULL, 23, NULL, 1, '2023-01-09 19:19:53'),
(15, 12, 'Devis', '2023-01-09', 'Offre Anti-Intrusion envoyée, M.KOUYATE va nous revenir', NULL, '05428', 2182274, 'Ressources Humaines', NULL, NULL, 23, NULL, 1, '2023-01-09 19:26:41'),
(16, 13, 'Devis', '2023-01-09', 'Offre Câblage Rajout Caméras de Surveillance Agence SALY, En Attente', NULL, '05512', 236000, 'Ressources Humaines', NULL, NULL, 23, NULL, 1, '2023-01-10 09:58:50'),
(17, 13, 'Devis', '2023-01-10', 'Offre Rajout Caméras de Surveillance Agence SALY, En attente', NULL, '05518', 442500, 'Ressources Humaines', NULL, NULL, 23, NULL, 1, '2023-01-10 10:00:48'),
(18, 15, 'Devis', '2023-01-10', 'Offre Maintenance Extincteurs et Système de Détection Incendie, En Attente', NULL, '05435', 3163026, 'Sécurité Incendie', NULL, NULL, 23, NULL, 1, '2023-01-10 14:19:30');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `prenom` text NOT NULL,
  `nom` text NOT NULL,
  `profil` varchar(255) DEFAULT NULL,
  `telephone` text NOT NULL,
  `email` text NOT NULL,
  `login` text NOT NULL,
  `pwd` longtext NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `etat` int(11) NOT NULL DEFAULT 1,
  `date_enregistrement` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `prenom`, `nom`, `profil`, `telephone`, `email`, `login`, `pwd`, `id_user`, `etat`, `date_enregistrement`) VALUES
(1, 'khalifa', 'bassene', 'ass_op', '77 798 50 56', 'khalifa.ababacar@vigilus-securite.com', 'bassene@vigilus', '3bbe29e8ef937d488ec97d95b0db61d8db5706da', 1, 1, '2021-01-27 13:49:36'),
(23, 'Mareme', 'DIOP', 'direction', '77 798 50 56', 'khalifa.ababacar@vigilus-securite.com', 'mareme@vigilus', '3bbe29e8ef937d488ec97d95b0db61d8db5706da', 1, 1, '2022-11-14 08:13:36'),
(24, 'Ndeye Khar', 'SOW', 'ass_op', '77 798 50 56', 'khalifa.ababacar@vigilus-securite.com', 'khar.sow@vigilus', '3bbe29e8ef937d488ec97d95b0db61d8db5706da', 1, 1, '2022-11-14 08:13:36'),
(25, 'Khady', 'FALL', 'ass_op', '77 798 50 56', 'khalifa.ababacar@vigilus-securite.com', 'khady.fall@vigilus', '3bbe29e8ef937d488ec97d95b0db61d8db5706da', 1, 1, '2022-11-14 08:13:36'),
(26, 'Coumba', 'PENE', 'ass_op', '77 798 50 56', 'khalifa.ababacar@vigilus-securite.com', 'coumba.pene@vigilus', '3bbe29e8ef937d488ec97d95b0db61d8db5706da', 1, 1, '2022-11-14 08:13:36'),
(27, 'Khadidiatou', 'Mane', 'ass_op', '77 798 50 56', 'khalifa.ababacar@vigilus-securite.com', 'khadidiatou@vigilus', '3bbe29e8ef937d488ec97d95b0db61d8db5706da', 1, 1, '2022-11-14 08:13:36'),
(28, 'Arame', 'GUEYE', 'ass_op', '77 798 50 56', 'khalifa.ababacar@vigilus-securite.com', 'arame@vigilus', '3bbe29e8ef937d488ec97d95b0db61d8db5706da', 1, 1, '2021-01-27 13:49:36'),
(29, 'Alassane', 'MBAYE', 'direction', '77 ', 'a.mbaye@groupevigilus.com', 'a.mbaye@groupevigilus.com', '3bbe29e8ef937d488ec97d95b0db61d8db5706da', 1, 1, '2023-01-09 13:49:36'),
(30, 'Malick', 'Ka', 'ass_op', '77 798 50 56', 'khalifa.ababacar@vigilus-securite.com', 'malick@vigilus', '3bbe29e8ef937d488ec97d95b0db61d8db5706da', 1, 1, '2022-01-10 13:49:36');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `departement`
--
ALTER TABLE `departement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_succursale` (`id_succursale`),
  ADD KEY `user_departement` (`id_user`);

--
-- Index pour la table `document_sollicitation`
--
ALTER TABLE `document_sollicitation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_projet` (`id_sollicitation`);

--
-- Index pour la table `sollicitation`
--
ALTER TABLE `sollicitation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_commercial` (`id_commercial`);

--
-- Index pour la table `tache`
--
ALTER TABLE `tache`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_user_validation` (`id_user_validation`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_user` (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `departement`
--
ALTER TABLE `departement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `document_sollicitation`
--
ALTER TABLE `document_sollicitation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `sollicitation`
--
ALTER TABLE `sollicitation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `tache`
--
ALTER TABLE `tache`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
