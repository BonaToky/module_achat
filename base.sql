CREATE TABLE role (
    id_role SERIAL PRIMARY KEY,
    libelle VARCHAR(50) NOT NULL
);

INSERT INTO role (libelle) VALUES
('client'),
('caissier'), 
('gestionnaire des stock'),
('admin');

INSERT INTO users (nom, prenom, numero, password_hash, adress, solde, id_role, actif) VALUES
('Doe', 'John', '1234567890', 'hashed_password_1', '123 Main St', 0, 1, TRUE);

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
    date_debut TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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



CREATE TABLE livraison (
    id_livraison SERIAL PRIMARY KEY,
    id_ticket INT NOT NULL,
    adresse_livraison VARCHAR(255) NOT NULL,
    statut_livraison VARCHAR(50) DEFAULT 'en_attente', 
    date_livraison_prevue DATE,
    date_livraison_reelle TIMESTAMP,
    livreur_id INT,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_livraison_ticket
        FOREIGN KEY (id_ticket)
        REFERENCES ticket(id_ticket)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_livraison_livreur
        FOREIGN KEY (livreur_id)
        REFERENCES users(id_users)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);


CREATE TYPE type_mouvement_stock AS ENUM ('entree', 'sortie');
CREATE TYPE mode_paiement AS ENUM ('cash', 'mobile_money', 'carte');


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

INSERT INTO produit (nom, image, id_categorie) VALUES
-- Smartphones (id_categorie: 1)
('iPhone 15 Pro', 'https://images.unsplash.com/photo-1695048133142-2e81d0c61e8c', 1),
('Samsung Galaxy S24 Ultra', 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf', 1),
('Google Pixel 8 Pro', 'https://images.unsplash.com/photo-1598327105666-5b89351aff97', 1),
('OnePlus 12', 'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd', 1),
('Xiaomi 14 Pro', 'https://images.unsplash.com/photo-1596558450268-9c27524ba856', 1),

-- Ordinateurs portables (id_categorie: 2)
('MacBook Pro 16" M3', 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853', 2),
('Dell XPS 15', 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5', 2),
('Lenovo ThinkPad X1 Carbon', 'https://images.unsplash.com/photo-1499951360447-b19be8fe80f5', 2),
('Asus ROG Zephyrus G14', 'https://images.unsplash.com/photo-1603302576837-37561b2e2302', 2),
('HP Spectre x360', 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed', 2),

-- Ordinateurs de bureau (id_categorie: 3)
('Apple iMac 24"', 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf', 3),
('Dell OptiPlex 7010', 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5', 3),
('HP Pavilion Gaming Desktop', 'https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea', 3),
('Corsair One i300', 'https://images.unsplash.com/photo-1555255707-c07966088b7b', 3),
('Lenovo ThinkCentre M90a', 'https://images.unsplash.com/photo-1597764690470-1501c6bdfb2c', 3),

-- Tablettes (id_categorie: 4)
('iPad Pro 12.9"', 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0', 4),
('Samsung Galaxy Tab S9 Ultra', 'https://images.unsplash.com/photo-1589739900243-4b52e30e59b6', 4),
('Microsoft Surface Pro 9', 'https://images.unsplash.com/photo-1561154464-82e9adf32764', 4),
('Amazon Fire HD 10', 'https://images.unsplash.com/photo-1526430752879-b2ebf21b4eac', 4),
('Lenovo Tab P12 Pro', 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088', 4),

-- Téléviseurs (id_categorie: 5)
('Samsung QLED 4K 65"', 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1', 5),
('LG OLED C3 55"', 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1', 5),
('Sony Bravia XR 75"', 'https://images.unsplash.com/photo-1461151304267-38535e780c79', 5),
('TCL QLED 50"', 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1', 5),
('Hisense ULED 85"', 'https://images.unsplash.com/photo-1509281373149-e957c6296406', 5),

-- Réseaux & Connectivité (id_categorie: 6)
('TP-Link Archer AX73', 'https://images.unsplash.com/photo-1614064641938-3bbee52942c7', 6),
('Netgear Nighthawk RAX70', 'https://images.unsplash.com/photo-1614064641938-3bbee52942c7', 6),
('Google Nest Wifi Pro', 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31', 6),
('Ubiquiti UniFi Dream Machine', 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64', 6),
('Asus RT-AX86U', 'https://images.unsplash.com/photo-1563013544-824ae1b704d3', 6),

-- Vidéo (id_categorie: 7)
('GoPro Hero 12', 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32', 7),
('DJI Osmo Pocket 3', 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd', 7),
('Sony ZV-E10', 'https://images.unsplash.com/photo-1502982720700-bfff97f2ecac', 7),
('Canon EOS R50', 'https://images.unsplash.com/photo-1515378791036-0648a3ef77b2', 7),
('Insta360 X3', 'https://images.unsplash.com/photo-1606983340126-99ab4feaa64a', 7),

-- Appareils photo (id_categorie: 8)
('Canon EOS R5', 'https://images.unsplash.com/photo-1515376963452-9f6a4850c346', 8),
('Nikon Z9', 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32', 8),
('Sony A7 IV', 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd', 8),
('Fujifilm X-T5', 'https://images.unsplash.com/photo-1502982720700-bfff97f2ecac', 8),
('Panasonic Lumix S5 II', 'https://images.unsplash.com/photo-1510127034890-ba27508e9f1c', 8),

-- Alimentations & chargeurs (id_categorie: 9)
('Anker 737 Power Bank', 'https://images.unsplash.com/photo-1546868871-7041f2a55e12', 9),
('Belkin 65W GaN Charger', 'https://images.unsplash.com/photo-1546868871-7041f2a55e12', 9),
('Apple MagSafe Charger', 'https://images.unsplash.com/photo-1603383928978-2b0ad0c37c09', 9),
('RAVPower 90W PD Charger', 'https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea', 9),
('Samsung 45W Super Fast Charging', 'https://images.unsplash.com/photo-1526814853725-1f8b2c0262a6', 9),

-- Cartes graphiques (id_categorie: 10)
('NVIDIA RTX 4090', 'https://images.unsplash.com/photo-1591488320449-011701bb6704', 10),
('AMD Radeon RX 7900 XTX', 'https://images.unsplash.com/photo-1591488320449-011701bb6704', 10),
('NVIDIA RTX 4070 Ti', 'https://images.unsplash.com/photo-1552832230-c0197dd311b5', 10),
('AMD Radeon RX 7800 XT', 'https://images.unsplash.com/photo-1621259182978-fbf83264f0c5', 10),
('NVIDIA RTX 4060', 'https://images.unsplash.com/photo-1591488320449-011701bb6704', 10),

-- Cartes mères (id_categorie: 11)
('ASUS ROG Maximus Z790', 'https://images.unsplash.com/photo-1552832230-c0197dd311b5', 11),
('Gigabyte X670E AORUS Master', 'https://images.unsplash.com/photo-1552832230-c0197dd311b5', 11),
('MSI MPG B650 Edge WiFi', 'https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea', 11),
('ASRock B760M Steel Legend', 'https://images.unsplash.com/photo-1555255707-c07966088b7b', 11),
('ASUS TUF Gaming B550-Plus', 'https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea', 11),

-- Processeurs (id_categorie: 12)
('Intel Core i9-14900K', 'https://images.unsplash.com/photo-1587202372775-e229f172b9d7', 12),
('AMD Ryzen 9 7950X', 'https://images.unsplash.com/photo-1587202372775-e229f172b9d7', 12),
('Intel Core i7-13700K', 'https://images.unsplash.com/photo-1552832230-c0197dd311b5', 12),
('AMD Ryzen 7 7800X3D', 'https://images.unsplash.com/photo-1587202372775-e229f172b9d7', 12),
('Apple M3 Max', 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed', 12),

-- Mémoire RAM (id_categorie: 13)
('Corsair Vengeance RGB 32GB DDR5', 'https://images.unsplash.com/photo-1552832230-c0197dd311b5', 13),
('G.Skill Trident Z5 RGB 64GB', 'https://images.unsplash.com/photo-1552832230-c0197dd311b5', 13),
('Kingston FURY Beast 16GB DDR4', 'https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea', 13),
('Crucial Pro 32GB DDR5', 'https://images.unsplash.com/photo-1555255707-c07966088b7b', 13),
('TeamGroup T-Force Delta RGB 32GB', 'https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea', 13),

-- Disques durs & SSD (id_categorie: 14)
('Samsung 990 Pro 2TB NVMe', 'https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea', 14),
('Western Digital Black SN850X 1TB', 'https://images.unsplash.com/photo-1552832230-c0197dd311b5', 14),
('Seagate BarraCuda 4TB HDD', 'https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea', 14),
('Crucial P5 Plus 2TB', 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed', 14),
('SanDisk Extreme Portable 4TB', 'https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea', 14);

CREATE TYPE type_mouvement_stock AS ENUM ('entree', 'sortie');
CREATE TYPE mode_paiement AS ENUM ('cash', 'mobile_money', 'carte');


INSERT INTO role (libelle) VALUES
('client'),
('caissier'),
('gestionnaire des stock'),
('admin');


