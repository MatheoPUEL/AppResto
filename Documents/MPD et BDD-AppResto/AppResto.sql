-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 06 nov. 2025 à 11:55
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `appresto`
--

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `idCommande` int(11) NOT NULL,
  `dateCommande` datetime NOT NULL,
  `totalCommande` decimal(15,2) NOT NULL,
  `typeCommande` varchar(50) NOT NULL,
  `idEtat` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

CREATE TABLE `etat` (
  `idEtat` int(11) NOT NULL AUTO_INCREMENT,
  `libEtat` varchar(50) NOT NULL,
  `descriptif` text NOT NULL,
  PRIMARY KEY (`idEtat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Données de la table `etat`
--

INSERT INTO `etat` (`idEtat`, `libEtat`, `descriptif`) VALUES
(1, 'en attente', 'la commande est payée et en attente de préparation par le restaurateur'),
(2, 'Refuser', 'la commande est refusée par le restaurateur'),
(3, 'en préparation', 'la commande est acceptée et en cours de préparation par le restaurateur'),
(4, 'prête', 'la commande est prête et en attente d être récupérée par le client');

-- --------------------------------------------------------

--
-- Structure de la table `ligne_commande`
--

CREATE TABLE `ligne_commande` (
  `idCommande` int(11) NOT NULL,
  `idProduit` int(11) NOT NULL,
  `qteCommandee` int(11) DEFAULT NULL,
  `prixHtLigneCommande` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déclencheurs `ligne_commande`
--
DELIMITER $$
CREATE TRIGGER `after_insert_commande` AFTER INSERT ON `ligne_commande` FOR EACH ROW BEGIN 
    DECLARE v_prixCommande DECIMAL (5,2); 
    DECLARE v_typeCommande VARCHAR(3);
    
    SELECT typeCommande INTO v_typeCommande FROM commande WHERE idCommande = NEW.idCommande;
    
    SELECT SUM(prixHtLigneCommande) into v_prixCommande FROM ligne_commande 
    WHERE idCommande = NEW.idCommande;

IF v_typeCommande = "SP" THEN
    UPDATE commande SET totalCommande = v_prixCommande * 1.055 WHERE idCommande = NEW.idCommande;
ELSE 
    UPDATE commande SET totalCommande = v_prixCommande * 1.10 WHERE idCommande = NEW.idCommande;
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_ligne_insert` BEFORE INSERT ON `ligne_commande` FOR EACH ROW BEGIN
    DECLARE v_prixHTTotal DECIMAL(16,2);
    DECLARE v_prixTTC DECIMAL(16,2);
    
    SELECT COALESCE(SUM(prixHtLigneCommande * qteCommandee), 0) INTO v_prixHTTotal 
    FROM `ligne_commande` 
    WHERE idCommande = NEW.idCommande;
    
    SET v_prixHTTotal = v_prixHTTotal + (NEW.prixHtLigneCommande * NEW.qteCommandee);
    
    SET v_prixTTC = v_prixHTTotal * 1.20;
    
    UPDATE commande SET totalCommande = v_prixTTC WHERE idCommande = NEW.idCommande;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_ligne_update` AFTER UPDATE ON `ligne_commande` FOR EACH ROW BEGIN
	DECLARE v_prixTotal DECIMAL(16,2);
    
    SELECT totalCommande INTO v_prixTotal FROM commande WHERE idCommande = NEW.idCommande;
    
    SET v_prixTotal = v_prixTotal - (OLD.prixHtLigneCommande * OLD.qteCommandee * 1.20);
    
    SET v_prixTotal = v_prixTotal + (NEW.prixHtLigneCommande * NEW.qteCommandee * 1.20);
    
	UPDATE commande SET totalCommande = v_prixTotal WHERE idCommande = NEW.idCommande;
END
$$
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_update_ligne_commande` BEFORE UPDATE ON `ligne_commande` FOR EACH ROW BEGIN 
 DECLARE v_prixHt DECIMAL(5,2) ; 
 
 SELECT prixHtProduit into v_prixHt from produit 
 WHERE idProduit = new.idProduit ; 
 set new.prixHtLigneCommande = v_prixHt * new.qteCommandee ;
    
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `idProduit` int(11) NOT NULL,
  `libProduit` varchar(50) NOT NULL,
  `descriptionProduit` text DEFAULT NULL,
  `prixHtProduit` decimal(15,2) NOT NULL,
  `idType` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`idProduit`, `libProduit`, `descriptionProduit`, `prixHtProduit`, `idType`) VALUES
(1, 'Carpaccio de Saint-Jacques', 'Fines tranches de Saint-Jacques marinées aux agrumes et caviar', 24.50, 1),
(2, 'Foie Gras Poêlé', 'Foie gras de canard poêlé, chutney de figues et brioche toastée', 26.00, 1),
(3, 'Tartare de Bar Royal', 'Tartare de bar sauvage, huile d’olive millésimée et citron vert', 23.00, 1),
(4, 'Caviar Impérial', 'Caviar d’esturgeon servi avec blinis maison et crème aigre', 48.00, 1),
(5, 'Velouté de Topinambour', 'Crème de topinambour, éclats de châtaigne et truffe noire', 21.00, 1),
(6, 'Homard Bleu Rôti', 'Homard breton rôti au beurre clarifié, émulsion citronnée', 58.00, 2),
(7, 'Filet de Bœuf Rossini', 'Filet de bœuf maturé, foie gras, sauce périgourdine', 52.00, 2),
(8, 'Risotto à la Truffe Noire', 'Riz Carnaroli crémeux, truffe noire fraîche', 45.00, 2),
(9, 'Saint-Pierre au Champagne', 'Saint-Pierre poché avec sauce champagne et asperges blanches', 49.00, 2),
(10, 'Pigeon Royal', 'Pigeon fermier rôti, jus corsé et légumes anciens', 47.00, 2),
(11, 'Soufflé au Grand Marnier', 'Soufflé aérien au Grand Marnier, zeste confit', 18.00, 3),
(12, 'Dôme Chocolat & Or', 'Mousse chocolat grand cru, feuille d’or comestible', 22.00, 3),
(13, 'Tartelette Citron Yuzu', 'Crème de citron yuzu, meringue légère', 17.00, 3),
(14, 'Millefeuille Vanille Bourbon', 'Feuilletage croustillant et vanille Bourbon', 19.00, 3),
(15, 'Assiette de Fruits Exotiques', 'Mangue, fruit du dragon, passion et sorbet', 18.50, 3),
(16, 'Champagne Brut Prestige', 'Flûte de champagne brut grand cru', 19.00, 4),
(17, 'Chardonnay Millésimé', 'Verre de chardonnay français haut de gamme', 14.00, 4),
(18, 'Cocktail Signature Maison', 'Création du chef barman, ingrédients premium', 16.00, 4),
(19, 'Eau Minérale Artésienne', 'Eau plate naturelle premium', 6.00, 4),
(20, 'Thé Sencha Impérial', 'Thé vert japonais de haute qualité', 8.50, 4),
(21, 'Brie de Meaux Truffé', 'Brie crémeux garni de truffe noire', 15.00, 5),
(22, 'Comté 36 Mois', 'Comté affiné 36 mois, noix et raisins secs', 14.50, 5),
(23, 'Roquefort Carles', 'Roquefort artisanal au lait cru', 13.50, 5),
(24, 'Chèvre Cendré Fermier', 'Fromage de chèvre fermier affiné', 12.00, 5),
(25, 'Assiette de Fromages Affinés', 'Sélection de 4 fromages d’exception', 19.00, 5),
(26, 'Purée de Pomme de Terre Truffée', 'Purée onctueuse à la truffe fraîche', 11.00, 6),
(27, 'Légumes Anciens Rôtis', 'Carottes, panais et betteraves glacés', 10.00, 6),
(28, 'Gratin Dauphinois Premium', 'Crème entière, ail et muscade', 12.00, 6),
(29, 'Asperges Vertes Sautées', 'Asperges poêlées au beurre noisette', 13.00, 6),
(30, 'Risotto Parfumé aux Herbes', 'Risotto crémeux aux herbes fraîches', 14.00, 6);

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE `type` (
  `idType` int(11) NOT NULL,
  `libType` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`idType`, `libType`) VALUES
(1, 'Entrée'),
(2, 'Plat Principal'),
(3, 'Dessert'),
(4, 'Boisson'),
(5, 'Fromage'),
(6, 'Accompagnement');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `idUtilisateur` int(11) NOT NULL,
  `loginUtilisateur` varchar(50) NOT NULL,
  `emailUtilisateur` varchar(50) NOT NULL,
  `mdpUtilisateur` text DEFAULT NULL,
  `nomUtil` varchar(50) NOT NULL,
  `prenomUtil` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`idUtilisateur`, `loginUtilisateur`, `emailUtilisateur`, `mdpUtilisateur`, `nomUtil`, `prenomUtil`) VALUES
(1, 'Matheo', 'test@gmail.com', '$2y$10$IkTVzJoAVJz.jE1QfySGEe6uqmPELs/vkYeEeGxPTecVboSYUk64m', '', 'test'),
(2, 'test1@gmail.com', 'test1@gmail.com', '$2y$10$sHdFkjSlWhQhkTDTAAOkPOE7E/rP9iiJgIhT9nklXZjXLJVx5x.Im', '', 'test1');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`idCommande`),
  ADD KEY `idEtat` (`idEtat`),
  ADD KEY `idUtilisateur` (`idUtilisateur`);

--
-- Index pour la table `etat`
--
ALTER TABLE `etat`
  ADD PRIMARY KEY (`idEtat`);

--
-- Index pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  ADD PRIMARY KEY (`idCommande`,`idProduit`),
  ADD KEY `idProduit` (`idProduit`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`idProduit`),
  ADD KEY `idType` (`idType`);

--
-- Index pour la table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`idType`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`idUtilisateur`),
  ADD UNIQUE KEY `emailUtilisateur` (`emailUtilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `idCommande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT pour la table `etat`
--
ALTER TABLE `etat`
  MODIFY `idEtat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `idProduit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`idEtat`) REFERENCES `etat` (`idEtat`),
  ADD CONSTRAINT `commande_ibfk_2` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`idUtilisateur`);

--
-- Contraintes pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  ADD CONSTRAINT `ligne_commande_ibfk_1` FOREIGN KEY (`idCommande`) REFERENCES `commande` (`idCommande`),
  ADD CONSTRAINT `ligne_commande_ibfk_2` FOREIGN KEY (`idProduit`) REFERENCES `produit` (`idProduit`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`idType`) REFERENCES `type` (`idType`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
