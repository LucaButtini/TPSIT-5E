CREATE DATABASE E_commerce;
USE E_commerce;

-- 1. Creazione della tabella utenti
CREATE TABLE utenti (
    username VARCHAR(50) PRIMARY KEY,
    password VARCHAR(255) NOT NULL
);

-- 2. Creazione della tabella materiali
CREATE TABLE materiali (
    tipo VARCHAR(50) PRIMARY KEY,
    lavaggio BOOLEAN
);

-- 3. Creazione della tabella prodotti
CREATE TABLE prodotti (
    codice VARCHAR(5) PRIMARY KEY,
    titolo VARCHAR(200),
    descrizione VARCHAR(200),
    prezzo DOUBLE,
    immagine VARCHAR(250),
    materiale_tipo VARCHAR(50),
    FOREIGN KEY (materiale_tipo) REFERENCES materiali(tipo) ON DELETE SET NULL
);

-- 4. Creazione della tabella taglie
CREATE TABLE taglie (
    tipo VARCHAR(50) PRIMARY KEY
);

-- 5. Creazione tabella di associazione prodotti-taglie
CREATE TABLE prodotti_taglie (
    codice_prodotto VARCHAR(5),
    tipo_taglia VARCHAR(50),
    PRIMARY KEY (codice_prodotto, tipo_taglia),
    FOREIGN KEY (codice_prodotto) REFERENCES prodotti(codice) ON DELETE CASCADE,
    FOREIGN KEY (tipo_taglia) REFERENCES taglie(tipo) ON DELETE CASCADE
);

-- 6. Creazione della tabella carrello
CREATE TABLE carrello (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_creazione DATE NOT NULL,
    utente VARCHAR(50) DEFAULT 'guest',
    FOREIGN KEY (utente) REFERENCES utenti(username) 
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- 7. Creazione della tabella ordini (righe del carrello)
CREATE TABLE ordini (
    id_carrello INT NOT NULL,
    prodotto VARCHAR(5) NOT NULL,
    quantita INT NOT NULL DEFAULT 1,
    PRIMARY KEY (id_carrello, prodotto),
    FOREIGN KEY (id_carrello) REFERENCES carrello(id) ON DELETE CASCADE,
    FOREIGN KEY (prodotto) REFERENCES prodotti(codice) ON DELETE CASCADE
);

-- 8. Pulizia dati preesistenti (se necessario)
DELETE FROM prodotti;

-- 9. Popolamento della tabella utenti (esempio)
INSERT INTO utenti (username, password) VALUES
    ('guest', 'guest'),    -- per utente ospite
    ('mario', 'password'), -- esempio di utente registrato
    ('admin', 'admin');    -- esempio di admin

-- 10. Popolamento della tabella materiali
INSERT INTO materiali (tipo, lavaggio) VALUES
    ('Cotone', TRUE),
    ('Poliestere', TRUE),
    ('Lana', FALSE),
    ('Pelle', FALSE),
    ('Denim', TRUE);

-- 11. Popolamento della tabella prodotti
INSERT INTO prodotti (codice, titolo, descrizione, prezzo, immagine, materiale_tipo) VALUES
    ('P001', 'T-shirt con stampa spray', 'T-shirt eccezionale di ultima qualità con stampa spray', 19.99, 'Immagini/t5.webp', 'Cotone'),
    ('P002', 'Jeans sfrangiati', 'Jeans stile sfrangiato con ottima vestibilità', 49.99, 'Immagini/p5.webp', 'Denim'),
    ('P003', 'Felpa boxy fit', 'Felpa invernale con cappuccio e tasca frontale', 39.99, 'Immagini/f2.webp', 'Cotone'),
    ('P004', 'T-shirt nera', 'T-shirt classica nera di poliestere', 9.99, 'Immagini/a1.webp', 'Poliestere'),
    ('P005', 'Giacca in Pelle', 'Giacca in vera pelle marrone, stile classico', 129.99, 'Immagini/g5.webp', 'Pelle'),
    ('P006', 'Giubbotto in denim', 'Giubbotto in denim con doppia tasca frontale', 79.99, 'Immagini/g4.webp', 'Denim');

-- 12. Popolamento della tabella taglie
INSERT INTO taglie (tipo) VALUES
    ('XS'),
    ('S'),
    ('M'),
    ('L'),
    ('XL'),
    ('XXL');

-- 13. Popolamento della tabella prodotti_taglie
-- P001 (T-shirt con stampa spray) → XS, S, M, L, XL, XXL
INSERT INTO prodotti_taglie (codice_prodotto, tipo_taglia) VALUES
    ('P001', 'XS'),
    ('P001', 'S'),
    ('P001', 'M'),
    ('P001', 'L'),
    ('P001', 'XL'),
    ('P001', 'XXL');

-- P002 (Jeans sfrangiati) → S, M, L, XL, XXL
INSERT INTO prodotti_taglie (codice_prodotto, tipo_taglia) VALUES
    ('P002', 'S'),
    ('P002', 'M'),
    ('P002', 'L'),
    ('P002', 'XL'),
    ('P002', 'XXL');

-- P003 (Felpa boxy fit) → S, M, L, XL
INSERT INTO prodotti_taglie (codice_prodotto, tipo_taglia) VALUES
    ('P003', 'S'),
    ('P003', 'M'),
    ('P003', 'L'),
    ('P003', 'XL');

-- P004 (T-shirt nera) → S, M, L
INSERT INTO prodotti_taglie (codice_prodotto, tipo_taglia) VALUES
    ('P004', 'S'),
    ('P004', 'M'),
    ('P004', 'L');

-- P005 (Giacca in Pelle) → M, L, XL
INSERT INTO prodotti_taglie (codice_prodotto, tipo_taglia) VALUES
    ('P005', 'M'),
    ('P005', 'L'),
    ('P005', 'XL');

-- P006 (Giubbotto in denim) → M, L, XL
INSERT INTO prodotti_taglie (codice_prodotto, tipo_taglia) VALUES
    ('P006', 'M'),
    ('P006', 'L'),
    ('P006', 'XL');

-- 14. Verifica dati inseriti
SELECT * FROM prodotti;
SELECT * FROM prodotti_taglie;
SELECT * FROM utenti;
