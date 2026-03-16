-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 16 mars 2026 à 08:35
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
  `EST_ACTIVE` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
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
-- Structure de la table `commande_detail`
--

CREATE TABLE `commande_detail` (
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
  `EST_ACTIVE` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `entree`
--

CREATE TABLE `entree` (
  `ID_ENTREE` bigint(20) UNSIGNED NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `ID_PRODUIT_LOT` int(11) NOT NULL,
  `QTE` float NOT NULL,
  `ID_UNITE_MESURE` int(11) NOT NULL,
  `ID_FOURNISSEUR` int(11) NOT NULL,
  `PU` double NOT NULL,
  `DATE_INSERTION` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

CREATE TABLE `fournisseur` (
  `ID_FOURNISSEUR` int(10) UNSIGNED NOT NULL,
  `NOM_FOURNISSEUR` varchar(100) NOT NULL,
  `ADRESSE` varchar(100) NOT NULL,
  `TEL` int(11) NOT NULL,
  `EST_ACTIVE` tinyint(1) NOT NULL,
  `DATE_INSERTION` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `ID_PRODUIT` int(10) UNSIGNED NOT NULL,
  `DESC_PRODUIT` varchar(100) NOT NULL,
  `ID_CATEGORIE` int(11) NOT NULL,
  `EST_ACTIVE` tinyint(1) NOT NULL,
  `DATE_INSERTION` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produits_lot`
--

CREATE TABLE `produits_lot` (
  `ID_PRODUIT_LOT` int(10) UNSIGNED NOT NULL,
  `ID_PRODUIT` int(11) NOT NULL,
  `ID_CATEGORIE` int(11) NOT NULL,
  `QTE` float NOT NULL,
  `PU` double NOT NULL,
  `ID_UNITE_MESURE` int(11) NOT NULL,
  `QTE_MINIMAL` int(11) NOT NULL COMMENT 'Quantite a laquelle i faut signaler l''alimentation du stock',
  `DATE_EXPIRATION` datetime DEFAULT NULL,
  `EST_ACTIVE` tinyint(1) NOT NULL,
  `DATE_INSERTION` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `IS_DETTE` tinyint(1) UNSIGNED NOT NULL COMMENT '0.Pas dette 1.dette 2. dette paye'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `PHOTO_PROFIL` varchar(100) NOT NULL,
  `EST_ACTIVE` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`ID_CATEGORIE`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`ID_COMMANDE`);

--
-- Index pour la table `commande_detail`
--
ALTER TABLE `commande_detail`
  ADD PRIMARY KEY (`ID_COMMANDE_DETAIL`);

--
-- Index pour la table `commande_origine`
--
ALTER TABLE `commande_origine`
  ADD PRIMARY KEY (`ID_ORIGINE_COMMANDE`);

--
-- Index pour la table `entree`
--
ALTER TABLE `entree`
  ADD PRIMARY KEY (`ID_ENTREE`);

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
  MODIFY `ID_CATEGORIE` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `ID_COMMANDE` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commande_detail`
--
ALTER TABLE `commande_detail`
  MODIFY `ID_COMMANDE_DETAIL` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commande_origine`
--
ALTER TABLE `commande_origine`
  MODIFY `ID_ORIGINE_COMMANDE` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `entree`
--
ALTER TABLE `entree`
  MODIFY `ID_ENTREE` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  MODIFY `ID_FOURNISSEUR` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `ID_PRODUIT` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produits_lot`
--
ALTER TABLE `produits_lot`
  MODIFY `ID_PRODUIT_LOT` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `ID_SORTIE` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `unite_mesure`
--
ALTER TABLE `unite_mesure`
  MODIFY `ID_UNITE_MESURE` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `ID_USER` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
