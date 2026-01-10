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


