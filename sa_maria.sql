-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 16 mars 2026 à 19:36
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
-- Base de données : `sa_maria`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `ID_CATEGORIE` int(10) UNSIGNED NOT NULL,
  `DESC_CATEGORIE` varchar(100) NOT NULL,
  `EST_ACTIVE` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`ID_CATEGORIE`, `DESC_CATEGORIE`, `EST_ACTIVE`) VALUES
(1, 'Boisson', 1),
(2, 'Nourriture', 1);

-- --------------------------------------------------------

--
-- Structure de la table `categorie_sous_categ`
--

CREATE TABLE `categorie_sous_categ` (
  `ID_SOUS_CATEGORIE` int(10) UNSIGNED NOT NULL,
  `ID_CATEGORIE` int(11) NOT NULL,
  `DESC_SOUS_CATEGORIE` varchar(100) NOT NULL,
  `EST_ACTIVE` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie_sous_categ`
--

INSERT INTO `categorie_sous_categ` (`ID_SOUS_CATEGORIE`, `ID_CATEGORIE`, `DESC_SOUS_CATEGORIE`, `EST_ACTIVE`) VALUES
(1, 1, 'Bières locales', 1),
(2, 1, 'Bières importés', 1),
(3, 1, 'Jus', 1),
(4, 1, 'Boissons gazeuses(Fanta)', 1);

-- --------------------------------------------------------

--
-- Structure de la table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('ci_session:13d6kdukl2sm2tbf3b1c75vn5b39trin', '::1', 4294967295, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737333638353336363b5f63695f70726576696f75735f75726c7c733a33333a22687474703a2f2f6c6f63616c686f73743a383038302f6c6f67696e2f6c6f67696e223b757365725f69647c733a313a2231223b),
('ci_session:2n674c9b6olanmcicsf2jnsubke6pak0', '::1', 4294967295, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737333638353030373b5f63695f70726576696f75735f75726c7c733a33333a22687474703a2f2f6c6f63616c686f73743a383038302f6c6f67696e2f6c6f67696e223b),
('ci_session:753344a64e54pvhoudhdeqk347dk74p6', '::1', 4294967295, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737333638353336363b5f63695f70726576696f75735f75726c7c733a33333a22687474703a2f2f6c6f63616c686f73743a383038302f6c6f67696e2f6c6f67696e223b757365725f69647c733a313a2231223b);

-- --------------------------------------------------------

--
-- Structure de la table `commande_client`
--

CREATE TABLE `commande_client` (
  `ID_COMMANDE` int(10) UNSIGNED NOT NULL,
  `ID_ORIGINE_COMMANDE` int(11) NOT NULL,
  `ID_USER_TRAITEUR` int(11) DEFAULT NULL COMMENT 'Si origine n''est pas client',
  `ID_USER_SERVEUR` int(11) DEFAULT NULL,
  `TEL` int(11) DEFAULT NULL COMMENT 'sI origine est client',
  `PT` double NOT NULL,
  `STATUT` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1. En cours 2.Valide et distribue 3. Rejete',
  `MOTIF_REJET` text NOT NULL COMMENT 'obligatoire si commande rejete',
  `DATE_DEMANDE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commande_client_detail`
--

CREATE TABLE `commande_client_detail` (
  `ID_COMMANDE_DETAIL` int(10) UNSIGNED NOT NULL,
  `ID_PRODUIT` int(11) NOT NULL,
  `QTE_DEMANDE` float NOT NULL,
  `QTE_DISTRIBUE` float NOT NULL,
  `ID_UNITE_MESURE` int(11) NOT NULL,
  `PU` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commande_origine`
--

CREATE TABLE `commande_origine` (
  `ID_ORIGINE_COMMANDE` tinyint(1) UNSIGNED NOT NULL,
  `DESC_ORIGINE_COMM` varchar(100) NOT NULL,
  `EST_ACTIVE` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commande_origine`
--

INSERT INTO `commande_origine` (`ID_ORIGINE_COMMANDE`, `DESC_ORIGINE_COMM`, `EST_ACTIVE`) VALUES
(1, 'Client', 1),
(2, 'Serveur', 1);

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

CREATE TABLE `fournisseur` (
  `ID_FOURNISSEUR` int(10) UNSIGNED NOT NULL,
  `NOM_FOURNISSEUR` varchar(100) NOT NULL,
  `ADRESSE` varchar(100) NOT NULL,
  `TEL` int(11) NOT NULL,
  `EST_ACTIVE` tinyint(1) NOT NULL DEFAULT 1,
  `DATE_INSERTION` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `fournisseur`
--

INSERT INTO `fournisseur` (`ID_FOURNISSEUR`, `NOM_FOURNISSEUR`, `ADRESSE`, `TEL`, `EST_ACTIVE`, `DATE_INSERTION`) VALUES
(1, 'Dépot Gasenyi', 'Gasenyi', 6200355, 1, '2026-03-16 19:40:23');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `ID_PRODUIT` int(10) UNSIGNED NOT NULL,
  `DESC_PRODUIT` varchar(100) NOT NULL,
  `QTE_MINIMAL` float NOT NULL COMMENT 'Pour alerter',
  `ID_UNITE_MESURE` tinyint(1) UNSIGNED NOT NULL COMMENT 'Toujours bouteille si categorie est boisson',
  `ID_SOUS_CATEGORIE` int(11) NOT NULL,
  `NBR_BOUTEILLE_PAR_CASIER` tinyint(1) UNSIGNED NOT NULL,
  `EST_ACTIVE` tinyint(1) NOT NULL DEFAULT 1,
  `DATE_INSERTION` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`ID_PRODUIT`, `DESC_PRODUIT`, `QTE_MINIMAL`, `ID_UNITE_MESURE`, `ID_SOUS_CATEGORIE`, `NBR_BOUTEILLE_PAR_CASIER`, `EST_ACTIVE`, `DATE_INSERTION`) VALUES
(1, 'Primus 72 Cl', 6, 3, 1, 12, 1, '2026-03-16 17:40:43'),
(2, 'Primus 50Cl', 10, 3, 1, 20, 1, '2026-03-16 16:41:05');

-- --------------------------------------------------------

--
-- Structure de la table `produits_lot`
--

CREATE TABLE `produits_lot` (
  `ID_PRODUIT_LOT` int(10) UNSIGNED NOT NULL,
  `ID_PRODUIT` int(11) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `QTE` float NOT NULL,
  `QTE_RESTANT` float NOT NULL,
  `PU_ACHAT` double NOT NULL COMMENT 'prix d''achat',
  `PU_VENTE` double NOT NULL COMMENT 'prix de vente',
  `DATE_EXPIRATION` datetime DEFAULT NULL,
  `ID_FOURNISSEUR` int(11) NOT NULL,
  `ID_TYPE_ENTRE` tinyint(1) NOT NULL COMMENT 'Entre par saisie simple ou par validation de la commande',
  `EST_ACTIVE` tinyint(1) NOT NULL COMMENT '1.Active 2.Expire 3.Stock fini',
  `DATE_INSERTION` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produits_lot`
--

INSERT INTO `produits_lot` (`ID_PRODUIT_LOT`, `ID_PRODUIT`, `DESCRIPTION`, `QTE`, `QTE_RESTANT`, `PU_ACHAT`, `PU_VENTE`, `DATE_EXPIRATION`, `ID_FOURNISSEUR`, `ID_TYPE_ENTRE`, `EST_ACTIVE`, `DATE_INSERTION`) VALUES
(1, 1, 'Commande dépôt gasenyi', 36, 36, 4000, 5000, '2026-08-01 19:41:28', 1, 2, 1, '2026-03-16 19:44:25'),
(2, 2, 'Commande dépôt gasenyi', 40, 40, 3000, 3500, '2026-08-01 19:41:28', 1, 2, 1, '2026-03-16 19:44:25');

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

CREATE TABLE `profil` (
  `ID_PROFIL` tinyint(1) UNSIGNED NOT NULL,
  `DESC_PROFIL` varchar(100) NOT NULL,
  `EST_ACTIVE` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `raison_sortie`
--

CREATE TABLE `raison_sortie` (
  `ID_RAISON_SORTIE` tinyint(1) UNSIGNED NOT NULL,
  `DESC_RAISON_SORTIE` varchar(100) NOT NULL,
  `EST_ACTIVE` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `raison_sortie`
--

INSERT INTO `raison_sortie` (`ID_RAISON_SORTIE`, `DESC_RAISON_SORTIE`, `EST_ACTIVE`) VALUES
(1, 'Vente', 1),
(2, 'Produit périmé', 1);

-- --------------------------------------------------------

--
-- Structure de la table `sortie`
--

CREATE TABLE `sortie` (
  `ID_SORTIE` bigint(20) UNSIGNED NOT NULL,
  `ID_PRODUIT_LOT` int(11) NOT NULL,
  `QTE` float NOT NULL,
  `ID_RAISON_SORTIE` tinyint(1) UNSIGNED NOT NULL,
  `PU` double NOT NULL,
  `DATE_INSERTION` datetime NOT NULL DEFAULT current_timestamp(),
  `IS_DETTE` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0.Pas dette 1.dette 2. dette paye'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `sortie`
--

INSERT INTO `sortie` (`ID_SORTIE`, `ID_PRODUIT_LOT`, `QTE`, `ID_RAISON_SORTIE`, `PU`, `DATE_INSERTION`, `IS_DETTE`) VALUES
(1, 1, 3, 1, 5000, '2026-03-16 20:08:18', 0),
(2, 2, 5, 1, 4000, '2026-03-16 20:08:18', 0);

-- --------------------------------------------------------

--
-- Structure de la table `type_entre`
--

CREATE TABLE `type_entre` (
  `ID_TYPE_ENTRE` tinyint(1) UNSIGNED NOT NULL,
  `DESC_TYPE_ENTRE` varchar(100) NOT NULL,
  `EST_ACTIVE` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `type_entre`
--

INSERT INTO `type_entre` (`ID_TYPE_ENTRE`, `DESC_TYPE_ENTRE`, `EST_ACTIVE`) VALUES
(1, 'Saisie', 1),
(2, 'Validation de la commande', 1);

-- --------------------------------------------------------

--
-- Structure de la table `unite_mesure`
--

CREATE TABLE `unite_mesure` (
  `ID_UNITE_MESURE` tinyint(1) UNSIGNED NOT NULL,
  `DESC_UNITE_MESURE` varchar(100) NOT NULL,
  `EST_ACTIVE` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `unite_mesure`
--

INSERT INTO `unite_mesure` (`ID_UNITE_MESURE`, `DESC_UNITE_MESURE`, `EST_ACTIVE`) VALUES
(1, 'kg', 1),
(2, 'casier', 1),
(3, 'Bouteille', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `ID_USER` int(11) NOT NULL,
  `NOM_USER` varchar(50) NOT NULL,
  `PRENOM_USER` varchar(50) NOT NULL,
  `TELEPHONE` varchar(30) NOT NULL,
  `USERNAME` varchar(50) NOT NULL,
  `PASSWORD` varchar(50) NOT NULL,
  `ID_PROFIL` int(11) NOT NULL,
  `PHOTO_PROFIL` varchar(100) DEFAULT NULL,
  `EST_ACTIVE` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`ID_USER`, `NOM_USER`, `PRENOM_USER`, `TELEPHONE`, `USERNAME`, `PASSWORD`, `ID_PROFIL`, `PHOTO_PROFIL`, `EST_ACTIVE`) VALUES
(1, 'Alain Charbel', 'NDERAGAKURA', '62003522', '62003522', '12345', 1, NULL, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`ID_CATEGORIE`);

--
-- Index pour la table `categorie_sous_categ`
--
ALTER TABLE `categorie_sous_categ`
  ADD PRIMARY KEY (`ID_SOUS_CATEGORIE`);

--
-- Index pour la table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commande_client`
--
ALTER TABLE `commande_client`
  ADD PRIMARY KEY (`ID_COMMANDE`);

--
-- Index pour la table `commande_client_detail`
--
ALTER TABLE `commande_client_detail`
  ADD PRIMARY KEY (`ID_COMMANDE_DETAIL`);

--
-- Index pour la table `commande_origine`
--
ALTER TABLE `commande_origine`
  ADD PRIMARY KEY (`ID_ORIGINE_COMMANDE`);

--
-- Index pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  ADD PRIMARY KEY (`ID_FOURNISSEUR`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`ID_PRODUIT`);

--
-- Index pour la table `produits_lot`
--
ALTER TABLE `produits_lot`
  ADD PRIMARY KEY (`ID_PRODUIT_LOT`);

--
-- Index pour la table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`ID_PROFIL`);

--
-- Index pour la table `raison_sortie`
--
ALTER TABLE `raison_sortie`
  ADD PRIMARY KEY (`ID_RAISON_SORTIE`);

--
-- Index pour la table `sortie`
--
ALTER TABLE `sortie`
  ADD PRIMARY KEY (`ID_SORTIE`);

--
-- Index pour la table `type_entre`
--
ALTER TABLE `type_entre`
  ADD PRIMARY KEY (`ID_TYPE_ENTRE`);

--
-- Index pour la table `unite_mesure`
--
ALTER TABLE `unite_mesure`
  ADD PRIMARY KEY (`ID_UNITE_MESURE`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID_USER`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `ID_CATEGORIE` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `categorie_sous_categ`
--
ALTER TABLE `categorie_sous_categ`
  MODIFY `ID_SOUS_CATEGORIE` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `commande_client`
--
ALTER TABLE `commande_client`
  MODIFY `ID_COMMANDE` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commande_client_detail`
--
ALTER TABLE `commande_client_detail`
  MODIFY `ID_COMMANDE_DETAIL` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commande_origine`
--
ALTER TABLE `commande_origine`
  MODIFY `ID_ORIGINE_COMMANDE` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  MODIFY `ID_FOURNISSEUR` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `ID_PRODUIT` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `produits_lot`
--
ALTER TABLE `produits_lot`
  MODIFY `ID_PRODUIT_LOT` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `profil`
--
ALTER TABLE `profil`
  MODIFY `ID_PROFIL` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `raison_sortie`
--
ALTER TABLE `raison_sortie`
  MODIFY `ID_RAISON_SORTIE` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `sortie`
--
ALTER TABLE `sortie`
  MODIFY `ID_SORTIE` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `type_entre`
--
ALTER TABLE `type_entre`
  MODIFY `ID_TYPE_ENTRE` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `unite_mesure`
--
ALTER TABLE `unite_mesure`
  MODIFY `ID_UNITE_MESURE` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `ID_USER` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
