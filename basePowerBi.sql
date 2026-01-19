CREATE DATABASE powerbi_db;
/c powerbi_db;

CREATE TABLE role (
    id_role SERIAL PRIMARY KEY,
    libelle VARCHAR(50) NOT NULL
);

CREATE TABLE users (
    id_users SERIAL PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    numero VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    adress VARCHAR(100),
    solde NUMERIC(12,2) DEFAULT 0,
    id_role INT NOT NULL,
    actif BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_users_role
        FOREIGN KEY (id_role)
        REFERENCES role(id_role)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

CREATE TABLE ticket (
    id_ticket SERIAL PRIMARY KEY,
    mode_paiement VARCHAR(50) NOT NULL,
    total NUMERIC(15,2) NOT NULL,
    date_vente TIMESTAMP NOT NULL,
    id_client INT NOT NULL,
    CONSTRAINT fk_ticket_client
        FOREIGN KEY (id_client)
        REFERENCES users(id_users)
);

CREATE TABLE categorie (
    id_categorie SERIAL PRIMARY KEY,
    libelle VARCHAR(50) NOT NULL
);

CREATE TABLE produit (
    id_produit SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    image TEXT,
    id_categorie INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_produit_categorie
        FOREIGN KEY (id_categorie)
        REFERENCES categorie(id_categorie)
);


CREATE TABLE panier (
    id_panier SERIAL PRIMARY KEY,
    id_client INT NOT NULL,
    id_produit INT NOT NULL,
    quantite INT NOT NULL CHECK (quantite > 0),
    date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_panier_client
        FOREIGN KEY (id_client)
        REFERENCES users(id_users)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    
    CONSTRAINT fk_panier_produit
        FOREIGN KEY (id_produit)
        REFERENCES produit(id_produit)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    
    CONSTRAINT uq_panier_client_produit
        UNIQUE (id_client, id_produit)
);



CREATE TABLE mouvement_stock (
    id_mouvement_stock SERIAL PRIMARY KEY,
    type_mouvement_stock VARCHAR(50) NOT NULL,
    quantite INT NOT NULL,
    date_mouv TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    id_categorie INT NOT NULL,
    id_produit INT NOT NULL,
    CONSTRAINT fk_mouv_categorie
        FOREIGN KEY (id_categorie)
        REFERENCES categorie(id_categorie),
    CONSTRAINT fk_mouv_produit
        FOREIGN KEY (id_produit)
        REFERENCES produit(id_produit)
);

CREATE TABLE Limite_Stock_Produit (
    id_stock SERIAL PRIMARY KEY,
    id_produit INT NOT NULL REFERENCES produit(id_produit),
    quantite_max INT NOT NULL,
    date_debut TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_fin TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE details_vente (
    id_details_vente SERIAL PRIMARY KEY,
    id_produit INT NOT NULL,
    id_ticket INT NOT NULL,
    quantite INT NOT NULL CHECK (quantite > 0),
    prix_unitaire NUMERIC(15,2) NOT NULL,
    total_ligne NUMERIC(15,2)
        GENERATED ALWAYS AS (quantite * prix_unitaire) STORED,
    CONSTRAINT fk_details_produit
        FOREIGN KEY (id_produit)
        REFERENCES produit(id_produit),
    CONSTRAINT fk_details_ticket
        FOREIGN KEY (id_ticket)
        REFERENCES ticket(id_ticket)
);

  
CREATE TABLE historique_prix (
    id_historique SERIAL PRIMARY KEY,
    id_produit INT NOT NULL,
    prix_achat NUMERIC(15,2) NOT NULL CHECK (prix_achat >= 0),
    prix_vente NUMERIC(15,2) NOT NULL CHECK (prix_vente >= 0),
    date_debut TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_fin TIMESTAMP,
    CONSTRAINT fk_hist_prix_produit
        FOREIGN KEY (id_produit)
        REFERENCES produit(id_produit),
    CONSTRAINT chk_prix_logique
        CHECK (prix_vente >= prix_achat)
);




INSERT INTO role (libelle) VALUES
('client'),
('caissier'),
('gestionnaire des stock'),
('admin');


INSERT INTO categorie (libelle) VALUES
('Smartphones'),
('Ordinateurs portables'),
('Ordinateurs de bureau'),
('Tablettes'),
('Téléviseurs'),
('Réseaux & Connectivité'),
('Vidéo'),
('Appareils photo'),
('Alimentations & chargeurs'),
('Cartes graphiques'),
('Cartes mères'),
('Processeurs'),
('Mémoire RAM'),
('Disques durs & SSD');


INSERT INTO users (nom, prenom, numero, password_hash, adress, solde, id_role, actif) VALUES
('Martin', 'Pierre', '0612345678', 'hash123', '10 Rue de Paris, 75001 Paris', 150.50, 1, TRUE),
('Dubois', 'Marie', '0623456789', 'hash456', '25 Av. des Champs, 69002 Lyon', 75.00, 1, TRUE),
('Leroy', 'Thomas', '0634567890', 'hash789', '5 Bd Saint-Germain, 13008 Marseille', 200.00, 1, TRUE),
('Moreau', 'Sophie', '0645678901', 'hash101', '15 Rue de la République, 31000 Toulouse', 50.00, 1, TRUE),
('Simon', 'Julie', '0656789012', 'hash102', '8 Place Bellecour, 69002 Lyon', 300.00, 2, TRUE),
('Laurent', 'David', '0667890123', 'hash103', '22 Rue du Commerce, 44000 Nantes', 0.00, 2, TRUE),
('Michel', 'Sarah', '0678901234', 'hash104', '30 Av. Victor Hugo, 06000 Nice', 125.75, 3, TRUE),
('Bernard', 'Nicolas', '0689012345', 'hash105', '12 Rue de la Paix, 75002 Paris', 500.00, 3, TRUE),
('Petit', 'Camille', '0690123456', 'hash106', '18 Rue Royale, 59000 Lille', 80.00, 4, TRUE),
('Robert', 'Alexandre', '0601234567', 'hash107', '7 Place de la Bourse, 33000 Bordeaux', 45.00, 1, TRUE),
('Richard', 'Elodie', '0613456789', 'hash108', '14 Rue de Rivoli, 75004 Paris', 220.00, 1, TRUE),
('Durand', 'Paul', '0624567890', 'hash109', '9 Av. Jean Médecin, 06000 Nice', 150.00, 1, TRUE),
('Lemoine', 'Laura', '0635678901', 'hash110', '3 Rue de la Pompe, 75116 Paris', 90.00, 2, TRUE),
('Roux', 'Mathieu', '0646789012', 'hash111', '27 Rue de la Soif, 35000 Rennes', 60.00, 2, TRUE),
('Fournier', 'Chloé', '0657890123', 'hash112', '11 Place du Capitole, 31000 Toulouse', 175.00, 3, TRUE),
('Girard', 'Antoine', '0668901234', 'hash113', '6 Rue de la Liberté, 67000 Strasbourg', 250.00, 3, TRUE),
('Bonnet', 'Clara', '0679012345', 'hash114', '19 Quai des Chartrons, 33000 Bordeaux', 40.00, 4, TRUE),
('Dupont', 'Lucas', '0680123456', 'hash115', '4 Rue Sainte-Catherine, 69001 Lyon', 110.00, 1, TRUE),
('Lambert', 'Manon', '0691234567', 'hash116', '16 Av. de la Grande Armée, 75116 Paris', 85.00, 1, TRUE),
('Fontaine', 'Julien', '0602345678', 'hash117', '21 Rue de la République, 13001 Marseille', 95.00, 1, TRUE),
('Rousseau', 'Amandine', '0614567890', 'hash118', '13 Place des Jacobins, 69002 Lyon', 65.00, 2, TRUE),
('Vincent', 'Hugo', '0625678901', 'hash119', '8 Rue de la Michodière, 75002 Paris', 180.00, 2, TRUE),
('Muller', 'Léa', '0636789012', 'hash120', '2 Rue du Palais, 44000 Nantes', 140.00, 3, TRUE),
('Lefevre', 'Quentin', '0647890123', 'hash121', '26 Bd de la Liberté, 59000 Lille', 70.00, 3, TRUE),
('Faure', 'Océane', '0658901234', 'hash122', '17 Place Carnot, 31000 Toulouse', 120.00, 4, TRUE),
('Mercier', 'Baptiste', '0669012345', 'hash123', '5 Rue de la Préfecture, 06000 Nice', 55.00, 1, TRUE),
('Blanc', 'Inès', '0670123456', 'hash124', '23 Quai de la Loire, 75019 Paris', 210.00, 1, TRUE),
('Guerin', 'Maxime', '0681234567', 'hash125', '29 Rue de la Gare, 67000 Strasbourg', 95.00, 1, TRUE),
('Boyer', 'Charlotte', '0692345678', 'hash126', '1 Place de la Comédie, 34000 Montpellier', 130.00, 2, TRUE),
('Chevalier', 'Romain', '0603456789', 'hash127', '10 Rue Porte de la Craffe, 54000 Nancy', 75.00, 2, TRUE),
('Francois', 'Margaux', '0615678901', 'hash128', '14 Rue du Château, 35000 Rennes', 160.00, 3, TRUE),
('Legrand', 'Thibault', '0626789012', 'hash129', '6 Av. Foch, 64000 Pau', 45.00, 3, TRUE),
('Garcia', 'Eva', '0637890123', 'hash130', '9 Rue des Carmes, 45000 Orléans', 100.00, 4, TRUE),
('Perrin', 'Alexis', '0648901234', 'hash131', '12 Place de la Mairie, 51100 Reims', 85.00, 1, TRUE),
('Robin', 'Anaïs', '0659012345', 'hash132', '3 Rue des Halles, 76000 Rouen', 115.00, 1, TRUE),
('Clement', 'Florian', '0660123456', 'hash133', '18 Quai Louis XVIII, 17000 La Rochelle', 65.00, 1, TRUE),
('Morin', 'Justine', '0671234567', 'hash134', '7 Rue Saint-Ferréol, 13001 Marseille', 145.00, 2, TRUE),
('Nicolas', 'Benjamin', '0682345678', 'hash135', '22 Rue de la Barre, 59800 Lille', 90.00, 2, TRUE),
('Henry', 'Célia', '0693456789', 'hash136', '4 Place Saint-Pierre, 63000 Clermont-Ferrand', 110.00, 3, TRUE),
('Roussel', 'Jérémy', '0604567890', 'hash137', '11 Rue de la Clé, 25000 Besançon', 80.00, 3, TRUE);


INSERT INTO produit (nom, image, id_categorie, created_at, updated_at) VALUES
-- Smartphones (1)
('iPhone 15 Pro', 'iphone15pro.jpg', 1, '2024-01-18', '2024-12-31'),
('Samsung Galaxy S24', 'galaxys24.jpg', 1, '2024-01-24', '2024-12-31'),
('Google Pixel 8 Pro', 'pixel8pro.jpg', 1, '2024-02-04', '2024-12-31'),
('OnePlus 12', 'oneplus12.jpg', 1, '2024-02-13', '2024-12-31'),
('Xiaomi 14 Pro', 'xiaomi14pro.jpg', 1, '2024-03-05', '2024-12-31'),

-- Ordinateurs portables (2)
('MacBook Pro 16 M3', 'macbookpro16.jpg', 2, '2024-01-18', '2024-12-31'),
('Dell XPS 15', 'dellxps15.jpg', 2, '2024-01-24', '2024-12-31'),
('HP Spectre x360', 'hpspectre.jpg', 2, '2024-01-30', '2024-12-31'),
('Lenovo ThinkPad X1', 'thinkpadx1.jpg', 2, '2024-01-31', '2024-12-31'),
('Asus ROG Zephyrus', 'rogzephyrus.jpg', 2, '2024-03-07', '2024-12-31'),

-- Ordinateurs de bureau (3)
('Apple iMac 24', 'imac24.jpg', 3, '2024-01-18', '2024-12-31'),
('Dell OptiPlex', 'optiplex.jpg', 3, '2024-01-24', '2024-12-31'),
('HP EliteDesk', 'elitedesk.jpg', 3, '2024-01-30', '2024-12-31'),
('PC Gamer MSI', 'msigaming.jpg', 3, '2024-01-31', '2024-12-31'),
('Lenovo ThinkCentre', 'thinkcentre.jpg', 3, '2024-03-05', '2024-12-31'),

-- Tablettes (4)
('iPad Pro 12.9', 'ipadpro.jpg', 4, '2024-01-18', '2024-12-31'),
('Samsung Tab S9', 'tabs9.jpg', 4, '2024-01-24', '2024-12-31'),
('Microsoft Surface Pro', 'surfacepro.jpg', 4, '2024-01-30', '2024-12-31'),
('Lenovo Tab P12', 'tabp12.jpg', 4, '2024-01-31', '2024-12-31'),
('Amazon Fire HD', 'firehd.jpg', 4, '2024-03-05', '2024-12-31'),

-- Téléviseurs (5)
('LG OLED C3', 'lgoled.jpg', 5, '2024-01-18', '2024-12-31'),
('Samsung QLED QN90B', 'samsungqled.jpg', 5, '2024-01-24', '2024-12-31'),
('Sony Bravia XR', 'sonybravia.jpg', 5, '2024-02-04', '2024-12-31'),
('TCL 6-Series', 'tcl6series.jpg', 5, '2024-02-13', '2024-12-31'),
('Philips Ambilight', 'philipsambilight.jpg', 5, '2024-03-05', '2024-12-31'),

-- Réseaux & Connectivité (6)
('Routeur Wi-Fi 6 ASUS', 'routeurasus.jpg', 6, '2024-01-18', '2024-12-31'),
('Switch NETGEAR 24 ports', 'netgearswitch.jpg', 6, '2024-01-24', '2024-12-31'),
('Modem ARRIS SURFboard', 'arris.jpg', 6, '2024-01-30', '2024-12-31'),
('Point d''accès Ubiquiti', 'ubiquiti.jpg', 6, '2024-01-31', '2024-12-31'),
('Câbles Ethernet CAT6', 'cablecat6.jpg', 6, '2024-03-05', '2024-12-31'),

-- Vidéo (7)
('Caméra Sony Alpha 7 IV', 'sonya7iv.jpg', 7, '2024-01-17', '2024-12-31'),
('Drone DJI Mini 4 Pro', 'djimini4.jpg', 7, '2024-01-23', '2024-12-31'),
('GoPro HERO12', 'gopro12.jpg', 7, '2024-01-29', '2024-12-31'),
('Caméra Canon EOS R6', 'canonr6.jpg', 7, '2024-02-07', '2024-12-31'),
('Micro RØDE NT1', 'rodent1.jpg', 7, '2024-02-22', '2024-12-31'),

-- Appareils photo (8)
('Nikon Z9', 'nikonz9.jpg', 8, '2024-01-17', '2024-12-31'),
('Fujifilm X-T5', 'fujix-t5.jpg', 8, '2024-01-23', '2024-12-31'),
('Olympus OM-D E-M1', 'olympus.jpg', 8, '2024-01-29', '2024-12-31'),
('Panasonic Lumix S5', 'lumixs5.jpg', 8, '2024-02-07', '2024-12-31'),
('Leica Q3', 'leicaq3.jpg', 8, '2024-02-22', '2024-12-31'),

-- Cartes graphiques (10)
('NVIDIA RTX 4090', 'rtx4090.jpg', 10, '2024-02-27', '2024-12-31'),
('AMD Radeon RX 7900 XTX', 'rx7900.jpg', 10, '2024-02-28', '2024-12-31'),
('NVIDIA RTX 4080', 'rtx4080.jpg', 10, '2024-02-29', '2024-12-31'),
('AMD Radeon RX 7800 XT', 'rx7800.jpg', 10, '2024-03-01', '2024-12-31'),
('NVIDIA RTX 4070 Ti', 'rtx4070ti.jpg', 10, '2024-03-02', '2024-12-31');










INSERT INTO historique_prix (id_produit, prix_achat, prix_vente, date_debut, date_fin) VALUES
-- Smartphones
(1, 899.00, 1199.00, '2024-01-15', '2024-12-31'),
(2, 749.00, 999.00, '2024-01-20', '2024-12-31'),
(3, 699.00, 899.00, '2024-02-01', '2024-12-31'),
(4, 649.00, 799.00, '2024-02-10', '2024-12-31'),
(5, 599.00, 749.00, '2024-02-15', '2024-12-31'),

-- Ordinateurs portables
(6, 1999.00, 2499.00, '2024-01-25', '2024-12-31'),
(7, 1299.00, 1699.00, '2024-02-05', '2024-12-31'),
(8, 1199.00, 1499.00, '2024-02-12', '2024-12-31'),
(9, 1399.00, 1799.00, '2024-02-18', '2024-12-31'),
(10, 1499.00, 1899.00, '2024-02-20', '2024-12-31'),

-- Ordinateurs de bureau
(11, 1499.00, 1899.00, '2024-01-30', '2024-12-31'),
(12, 799.00, 1099.00, '2024-02-02', '2024-12-31'),
(13, 899.00, 1199.00, '2024-02-08', '2024-12-31'),
(14, 1899.00, 2399.00, '2024-02-14', '2024-12-31'),
(15, 699.00, 899.00, '2024-02-16', '2024-12-31'),

-- Tablettes
(16, 999.00, 1299.00, '2024-01-22', '2024-12-31'),
(17, 649.00, 849.00, '2024-01-28', '2024-12-31'),
(18, 899.00, 1199.00, '2024-02-03', '2024-12-31'),
(19, 499.00, 699.00, '2024-02-09', '2024-12-31'),
(20, 149.00, 199.00, '2024-02-11', '2024-12-31'),

-- Téléviseurs
(21, 1499.00, 1999.00, '2024-01-18', '2024-12-31'),
(22, 1299.00, 1699.00, '2024-01-24', '2024-12-31'),
(23, 1799.00, 2299.00, '2024-02-04', '2024-12-31'),
(24, 799.00, 1099.00, '2024-02-13', '2024-12-31'),
(25, 999.00, 1299.00, '2024-02-17', '2024-12-31'),

-- Réseaux
(26, 199.00, 299.00, '2024-01-19', '2024-12-31'),
(27, 299.00, 399.00, '2024-01-26', '2024-12-31'),
(28, 89.00, 129.00, '2024-02-06', '2024-12-31'),
(29, 149.00, 199.00, '2024-02-19', '2024-12-31'),
(30, 29.00, 49.00, '2024-02-21', '2024-12-31'),

-- Vidéo
(31, 2199.00, 2799.00, '2024-01-17', '2024-12-31'),
(32, 699.00, 899.00, '2024-01-23', '2024-12-31'),
(33, 349.00, 449.00, '2024-01-29', '2024-12-31'),
(34, 1899.00, 2399.00, '2024-02-07', '2024-12-31'),
(35, 199.00, 299.00, '2024-02-22', '2024-12-31'),

-- Appareils photo
(36, 4499.00, 5499.00, '2024-01-21', '2024-12-31'),
(37, 1499.00, 1899.00, '2024-01-27', '2024-12-31'),
(38, 1299.00, 1699.00, '2024-02-24', '2024-12-31'),
(39, 1799.00, 2299.00, '2024-02-25', '2024-12-31'),
(40, 4999.00, 5999.00, '2024-02-26', '2024-12-31'),

-- Cartes graphiques
(41, 1499.00, 1899.00, '2024-02-27', '2024-12-31'),
(42, 899.00, 1199.00, '2024-02-28', '2024-12-31'),
(43, 1099.00, 1399.00, '2024-02-29', '2024-12-31'),
(44, 649.00, 849.00, '2024-03-01', '2024-12-31'),
(45, 799.00, 999.00, '2024-03-02', '2024-12-31');



INSERT INTO Limite_Stock_Produit (id_produit, quantite_max, date_debut, date_fin) VALUES
(1, 50, '2024-01-01', '2024-12-31'),
(2, 50, '2024-01-01', '2024-12-31'),
(3, 40, '2024-01-01', '2024-12-31'),
(4, 60, '2024-01-01', '2024-12-31'),
(5, 70, '2024-01-01', '2024-12-31'),
(6, 30, '2024-01-01', '2024-12-31'),
(7, 40, '2024-01-01', '2024-12-31'),
(8, 45, '2024-01-01', '2024-12-31'),
(9, 35, '2024-01-01', '2024-12-31'),
(10, 25, '2024-01-01', '2024-12-31'),
(11, 20, '2024-01-01', '2024-12-31'),
(12, 50, '2024-01-01', '2024-12-31'),
(13, 40, '2024-01-01', '2024-12-31'),
(14, 15, '2024-01-01', '2024-12-31'),
(15, 60, '2024-01-01', '2024-12-31'),
(16, 40, '2024-01-01', '2024-12-31'),
(17, 55, '2024-01-01', '2024-12-31'),
(18, 35, '2024-01-01', '2024-12-31'),
(19, 80, '2024-01-01', '2024-12-31'),
(20, 100, '2024-01-01', '2024-12-31'),
(21, 25, '2024-01-01', '2024-12-31'),
(22, 30, '2024-01-01', '2024-12-31'),
(23, 65, '2024-01-01', '2024-12-31'),
(24, 45, '2024-01-01', '2024-12-31'),
(25, 55, '2024-01-01', '2024-12-31'),
(26, 100, '2024-01-01', '2024-12-31'),
(27, 50, '2024-01-01', '2024-12-31'),
(28, 120, '2024-01-01', '2024-12-31'),
(29, 80, '2024-01-01', '2024-12-31'),
(30, 200, '2024-01-01', '2024-12-31'),
(31, 15, '2024-01-01', '2024-12-31'),
(32, 40, '2024-01-01', '2024-12-31'),
(33, 60, '2024-01-01', '2024-12-31'),
(34, 65, '2024-01-01', '2024-12-31'),
(35, 90, '2024-01-01', '2024-12-31'),
(36, 10, '2024-01-01', '2024-12-31'),
(37, 25, '2024-01-01', '2024-12-31'),
(38, 30, '2024-01-01', '2024-12-31'),
(39, 20, '2024-01-01', '2024-12-31'),
(40, 5, '2024-01-01', '2024-12-31'),
(41, 20, '2024-01-01', '2024-12-31'),
(42, 30, '2024-01-01', '2024-12-31'),
(43, 25, '2024-01-01', '2024-12-31'),
(44, 35, '2024-01-01', '2024-12-31'),
(45, 40, '2024-01-01', '2024-12-31');



INSERT INTO mouvement_stock (type_mouvement_stock, quantite, date_mouv, id_categorie, id_produit) VALUES
('entree', 25, '2024-01-01', 1, 1),
('entree', 30, '2024-01-01', 1, 2),
('entree', 20, '2024-01-01', 1, 3),
('entree', 35, '2024-01-01', 1, 4),
('entree', 40, '2024-01-01', 1, 5),
('entree', 15, '2024-01-02', 2, 6),
('entree', 20, '2024-01-02', 2, 7),
('entree', 25, '2024-01-02', 2, 8),
('entree', 20, '2024-01-02', 2, 9),
('entree', 15, '2024-01-02', 2, 10),
('entree', 10, '2024-01-03', 3, 11),
('entree', 30, '2024-01-03', 3, 12),
('entree', 25, '2024-01-03', 3, 13),
('entree', 10, '2024-01-03', 3, 14),
('entree', 35, '2024-01-03', 3, 15),
('entree', 25, '2024-01-04', 4, 16),
('entree', 30, '2024-01-04', 4, 17),
('entree', 20, '2024-01-04', 4, 18),
('entree', 50, '2024-01-04', 4, 19),
('entree', 60, '2024-01-04', 4, 20),
('entree', 15, '2024-01-05', 5, 21),
('entree', 20, '2024-01-05', 5, 22),
('entree', 12, '2024-01-05', 5, 23),
('entree', 25, '2024-01-05', 5, 24),
('entree', 20, '2024-01-05', 5, 25),
('entree', 60, '2024-01-06', 6, 26),
('entree', 30, '2024-01-06', 6, 27),
('entree', 80, '2024-01-06', 6, 28),
('entree', 50, '2024-01-06', 6, 29),
('entree', 120, '2024-01-06', 6, 30),
('entree', 10, '2024-01-07', 7, 31),
('entree', 25, '2024-01-07', 7, 32),
('entree', 35, '2024-01-07', 7, 33),
('entree', 15, '2024-01-07', 7, 34),
('entree', 50, '2024-01-07', 7, 35),
('entree', 8, '2024-01-08', 8, 36),
('entree', 15, '2024-01-08', 8, 37),
('entree', 20, '2024-01-08', 8, 38),
('entree', 12, '2024-01-08', 8, 39),
('entree', 4, '2024-01-08', 8, 40),
('entree', 15, '2024-01-10', 10, 41),
('entree', 20, '2024-01-10', 10, 42),
('entree', 18, '2024-01-10', 10, 43),
('entree', 25, '2024-01-10', 10, 44),
('entree', 30, '2024-01-10', 10, 45);



INSERT INTO ticket (mode_paiement, total, date_vente, id_client) VALUES
('carte', 1199.00, '2024-03-01 10:30:00', 1),
('espèces', 999.00, '2024-03-01 11:15:00', 2),
('carte', 899.00, '2024-03-01 14:20:00', 3),
('virement', 799.00, '2024-03-01 15:45:00', 4),
('carte', 2499.00, '2024-03-02 09:10:00', 5),
('espèces', 1699.00, '2024-03-02 10:30:00', 6),
('carte', 1499.00, '2024-03-02 11:45:00', 7),
('virement', 1799.00, '2024-03-02 13:20:00', 8),
('carte', 1899.00, '2024-03-02 14:35:00', 9),
('espèces', 1899.00, '2024-03-03 10:00:00', 10),
('carte', 1099.00, '2024-03-03 11:15:00', 11),
('virement', 1199.00, '2024-03-03 12:30:00', 12),
('carte', 2399.00, '2024-03-03 13:45:00', 13),
('espèces', 899.00, '2024-03-03 15:00:00', 14),
('carte', 1299.00, '2024-03-04 09:20:00', 15),
('virement', 849.00, '2024-03-04 10:40:00', 16),
('carte', 1199.00, '2024-03-04 11:55:00', 17),
('espèces', 699.00, '2024-03-04 13:10:00', 18),
('carte', 199.00, '2024-03-04 14:25:00', 19),
('virement', 1999.00, '2024-03-05 09:30:00', 20),
('carte', 1699.00, '2024-03-05 10:45:00', 21),
('espèces', 2299.00, '2024-03-05 12:00:00', 22),
('carte', 1099.00, '2024-03-05 13:15:00', 23),
('virement', 1299.00, '2024-03-05 14:30:00', 24),
('carte', 299.00, '2024-03-06 09:40:00', 25),
('espèces', 399.00, '2024-03-06 10:55:00', 26),
('carte', 129.00, '2024-03-06 12:10:00', 27),
('virement', 199.00, '2024-03-06 13:25:00', 28),
('carte', 49.00, '2024-03-06 14:40:00', 29),
('espèces', 2799.00, '2024-03-07 09:50:00', 30),
('carte', 899.00, '2024-03-07 11:05:00', 31),
('virement', 449.00, '2024-03-07 12:20:00', 32),
('carte', 2399.00, '2024-03-07 13:35:00', 33),
('espèces', 299.00, '2024-03-07 14:50:00', 34),
('carte', 5499.00, '2024-03-08 10:00:00', 35),
('virement', 1899.00, '2024-03-08 11:15:00', 36),
('carte', 1699.00, '2024-03-08 12:30:00', 37),
('espèces', 2299.00, '2024-03-08 13:45:00', 38),
('carte', 5999.00, '2024-03-08 15:00:00', 39),
('virement', 1899.00, '2024-03-09 10:10:00', 40);



INSERT INTO details_vente 
    (id_produit, id_ticket, quantite, prix_unitaire) 
VALUES
    (1,  1,  1, 1199.00),
    (2,  2,  1,  999.00),
    (3,  3, 17,  899.00),
    (4,  4,  1,  799.00),
    (6,  5,  6, 2499.00),
    (7,  6,  1, 1699.00),
    (8,  7,  1, 1499.00),
    (9,  8,  5, 1799.00),
    (10, 9,  1, 1899.00),
    (11,10,  1, 1899.00),
    (12,11,  6, 1099.00),
    (13,12,  1, 1199.00),
    (14,13,  1, 2399.00),
    (15,14,  3,  899.00),
    (16,15,  1, 1299.00),
    (17,16,  3,  849.00),
    (18,17,  1, 1199.00),
    (19,18,  1,  699.00),
    (20,19,  1,  199.00),
    (21,20,  1, 1999.00),
    (22,21,  6, 1699.00),
    (23,22,  6, 2299.00),
    (24,23,  6, 1099.00),
    (25,24,  6, 1299.00),
    (26,25,  7,  299.00),
    (27,26,  1,  399.00),
    (28,27,  1,  129.00),
    (29,28,  1,  199.00),
    (30,29,  1,   49.00),
    (31,30,  1, 2799.00),
    (32,31, 18,  899.00),
    (33,32,  1,  449.00),
    (34,33,  1, 2399.00),
    (35,34,  1,  299.00),
    (36,35,  5, 5499.00),
    (37,36,  1, 1899.00),
    (38,37,  1, 1699.00),
    (39,38,  4, 2299.00),
    (40,39,  1, 5999.00),
    (41,40,  6, 1899.00);



INSERT INTO panier (id_client, id_produit, quantite, date_ajout, date_modification) VALUES
(1, 2, 3, '2024-03-01 10:15:00', '2024-03-01 10:15:00'),
(1, 17, 2, '2024-03-01 10:20:00', '2024-03-01 10:20:00'),
(2, 5, 1, '2024-03-01 11:30:00', '2024-03-01 11:30:00'),
(2, 19, 5, '2024-03-01 11:35:00', '2024-03-02 09:15:59'),
(3, 8, 2, '2024-03-01 14:10:00', '2024-03-01 14:10:00'),
(3, 30, 4, '2024-03-01 14:15:00', '2024-03-01 16:30:00'),
(4, 12, 1, '2024-03-01 15:40:00', '2024-03-01 15:40:00'),
(4, 26, 3, '2024-03-01 15:42:00', '2024-03-01 15:42:00'),
(5, 3, 2, '2024-03-02 08:45:00', '2024-03-02 08:45:00'),
(5, 20, 1, '2024-03-02 08:50:00', '2024-03-02 09:05:00'),
(6, 7, 3, '2024-03-02 10:15:00', '2024-03-02 10:15:00'),
(6, 25, 2, '2024-03-02 10:20:00', '2024-03-02 10:20:00'),
(7, 9, 1, '2024-03-02 11:30:00', '2024-03-02 11:30:00'),
(7, 28, 4, '2024-03-02 11:35:00', '2024-03-02 13:15:00'),
(8, 14, 3, '2024-03-02 13:10:00', '2024-03-02 13:10:00'),
(8, 29, 2, '2024-03-02 13:15:00', '2024-03-02 13:15:00'),
(9, 1, 2, '2024-03-02 14:20:00', '2024-03-02 14:20:00'),
(9, 16, 3, '2024-03-02 14:25:00', '2024-03-02 14:30:00'),
(10, 4, 1, '2024-03-03 09:45:00', '2024-03-03 09:45:00'),
(10, 18, 2, '2024-03-03 09:50:00', '2024-03-03 09:50:00'),
(11, 6, 3, '2024-03-03 10:55:00', '2024-03-03 10:55:00'),
(11, 21, 1, '2024-03-03 11:00:00', '2024-03-03 11:10:00'),
(12, 10, 2, '2024-03-03 12:15:00', '2024-03-03 12:15:00'),
(12, 22, 5, '2024-03-03 12:20:00', '2024-03-03 12:20:00'),
(13, 11, 1, '2024-03-03 13:30:00', '2024-03-03 13:30:00'),
(13, 23, 3, '2024-03-03 13:35:00', '2024-03-03 13:40:00'),
(14, 13, 2, '2024-03-03 14:45:00', '2024-03-03 14:45:00'),
(14, 24, 4, '2024-03-03 14:50:00', '2024-03-03 14:55:00'),
(15, 15, 3, '2024-03-04 09:05:00', '2024-03-04 09:05:00'),
(15, 27, 2, '2024-03-04 09:10:00', '2024-03-04 09:15:00'),
(16, 31, 5, '2024-03-04 10:25:00', '2024-03-04 10:25:00'),
(17, 32, 3, '2024-03-04 11:40:00', '2024-03-04 11:40:00'),
(18, 33, 6, '2024-03-04 12:55:00', '2024-03-04 13:05:00'),
(19, 34, 4, '2024-03-04 13:05:00', '2024-03-04 13:05:00'),
(20, 35, 2, '2024-03-04 14:10:00', '2024-03-04 14:20:00'),
(21, 36, 7, '2024-03-05 09:20:00', '2024-03-05 09:20:00'),
(22, 37, 3, '2024-03-05 10:35:00', '2024-03-05 10:35:00'),
(23, 38, 5, '2024-03-05 11:50:00', '2024-03-05 12:00:00'),
(24, 39, 2, '2024-03-05 13:05:00', '2024-03-05 13:05:00'),
(25, 40, 4, '2024-03-05 14:20:00', '2024-03-05 14:25:00');


