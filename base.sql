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
    stock_actuel INT NOT NULL DEFAULT 0,
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

-- Smartphones (1)
('Samsung Galaxy S24 Ultra', 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=800', 1),
('iPhone 16 Pro Max', 'https://images.unsplash.com/photo-1726582400160-0c1a4e6c3a5c?w=800', 1),
('Google Pixel 9 Pro', 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=800', 1),
('Xiaomi 14T Pro', 'https://images.unsplash.com/photo-1632287713678-3eccd7731c8d?w=800', 1),

-- Ordinateurs portables (2)
('MacBook Pro 16" M4 Pro', 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=800', 2),
('ASUS ROG Zephyrus G16', 'https://images.unsplash.com/photo-1611078489935-0cb4c2497a00?w=800', 2),
('Lenovo Legion Pro 7i', 'https://images.unsplash.com/photo-1593640408182-31c70c826ce9?w=800', 2),
('Dell XPS 15 2025', 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800', 2),

-- Ordinateurs de bureau (3)
('PC Gamer Ryzen 7 9800X3D + RTX 5090', 'https://images.unsplash.com/photo-1587202372775-2f29e8b9e2e6?w=800', 3),
('Station de travail Threadripper PRO', 'https://images.unsplash.com/photo-1587202372677-87295f2e9b8d?w=800', 3),

-- Tablettes (4)
('iPad Pro 13" M4', 'https://images.unsplash.com/photo-1561154464-82e9adf32764?w=800', 4),
('Samsung Galaxy Tab S10 Ultra', 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=800', 4),
('Xiaomi Pad 7 Pro', 'https://images.unsplash.com/photo-1589739909214-325a409151a0?w=800', 4),

-- Téléviseurs (5)
('LG OLED C5 65"', 'https://images.unsplash.com/photo-1593359677879-a4bb92f829f1?w=800', 5),
('Samsung QN90D Neo QLED 75"', 'https://images.unsplash.com/photo-1593784991093-4fe72c2b3e8f?w=800', 5),
('Sony Bravia 8 55" OLED', 'https://images.unsplash.com/photo-1588108246893-c8f8907b42d0?w=800', 5),

-- Réseaux & Connectivité (6)
('Routeur Wi-Fi 7 TP-Link BE800', 'https://images.unsplash.com/photo-1563986768494-4dee2763ff3f?w=800', 6),
('Switch Gigabit 24 ports administrable', 'https://images.unsplash.com/photo-1558494949-ef0d7b4b3d95?w=800', 6),

-- Vidéo (7)
('NVIDIA Shield TV Pro 2024', 'https://images.unsplash.com/photo-1617854818583-09e7f077a156?w=800', 7),
('Apple TV 4K 2025', 'https://images.unsplash.com/photo-1574375927797-7a8e0d9e2e8f?w=800', 7),

-- Appareils photo (8)
('Sony Alpha 1 II', 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=800', 8),
('Canon EOS R5 Mark II', 'https://images.unsplash.com/photo-1516035069370-29a004b82a99?w=800', 8),
('Fujifilm X-T50', 'https://images.unsplash.com/photo-1501601983405-7c7cabaa1581?w=800', 8),

-- Alimentations & chargeurs (9)
('Corsair RM1000x 2024 80+ Gold', 'https://images.unsplash.com/photo-1587202372775-e229f457603e?w=800', 9),
('Anker Prime 100W GaN Chargeur', 'https://images.unsplash.com/photo-1629654297299-c8506221ca97?w=800', 9),

-- Cartes graphiques (10)
('NVIDIA GeForce RTX 5090', 'https://images.unsplash.com/photo-1587202372850-3c4d7b5e3f3f?w=800', 10),
('AMD Radeon RX 8900 XTX', 'https://images.unsplash.com/photo-1587202372677-87295f2e9b8d?w=800', 10),

-- Cartes mères (11)
('ASUS ROG Strix X870E-E Gaming', 'https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?w=800', 11),
('MSI MPG B650 Carbon WiFi', 'https://images.unsplash.com/photo-1593642634367-d91a135587b5?w=800', 11),

-- Processeurs (12)
('AMD Ryzen 9 9950X', 'https://images.unsplash.com/photo-1593640408182-31c70c826ce9?w=800', 12),
('Intel Core Ultra 9 285K', 'https://images.unsplash.com/photo-1587202372850-3c4d7b5e3f3f?w=800', 12),

-- Mémoire RAM (13)
('Corsair Vengeance RGB 64Go DDR5-6400', 'https://images.unsplash.com/photo-1587202372775-e229f457603e?w=800', 13),
('G.Skill Trident Z5 RGB 32Go DDR5-7200', 'https://images.unsplash.com/photo-1587202372677-87295f2e9b8d?w=800', 13),

-- Disques durs & SSD (14)
('Samsung 990 PRO 4To SSD NVMe', 'https://images.unsplash.com/photo-1593642634521-2e8d2a9d3f3f?w=800', 14),
('WD Black SN850X 8To', 'https://images.unsplash.com/photo-1587202372850-3c4d7b5e3f3f?w=800', 14),
('Seagate IronWolf Pro 20To HDD', 'https://images.unsplash.com/photo-1587202372677-87295f2e9b8d?w=800', 14);
CREATE TYPE type_mouvement_stock AS ENUM ('entree', 'sortie');
CREATE TYPE mode_paiement AS ENUM ('cash', 'mobile_money', 'carte');


INSERT INTO role (libelle) VALUES
('client'),
('caissier'),
('gestionnaire des stock'),
('admin');


