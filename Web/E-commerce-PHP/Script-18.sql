CREATE DATABASE E_commerce;
USE E_commerce;

-- Creazione della tabella materiali
CREATE TABLE materiali (
    tipo VARCHAR(50) PRIMARY KEY,
    lavaggio BOOLEAN
);

-- Creazione della tabella prodotti
CREATE TABLE prodotti (
    codice VARCHAR(5) PRIMARY KEY,
    titolo VARCHAR(200),
    descrizione VARCHAR(200),
    prezzo DOUBLE,
    immagine VARCHAR(250),
    materiale_tipo VARCHAR(50),
    FOREIGN KEY (materiale_tipo) REFERENCES materiali(tipo) ON DELETE SET NULL
);

-- Creazione della tabella taglie
CREATE TABLE taglie (
    tipo VARCHAR(50) PRIMARY KEY
);

-- Creazione della tabella prodotti_taglie (associazione tra prodotti e taglie)
CREATE TABLE prodotti_taglie (
    codice_prodotto VARCHAR(5),
    tipo_taglia VARCHAR(50),
    PRIMARY KEY (codice_prodotto, tipo_taglia),
    FOREIGN KEY (codice_prodotto) REFERENCES prodotti(codice) ON DELETE CASCADE,
    FOREIGN KEY (tipo_taglia) REFERENCES taglie(tipo) ON DELETE CASCADE
);

-- Eliminazione dei dati precedenti
DELETE FROM prodotti;

-- Popolamento della tabella materiali
INSERT INTO materiali (tipo, lavaggio) VALUES
    ('Cotone', TRUE),
    ('Poliestere', TRUE),
    ('Lana', FALSE),
    ('Pelle', FALSE),
    ('Denim', TRUE);

-- Popolamento della tabella prodotti
INSERT INTO prodotti (codice, titolo, descrizione, prezzo, immagine, materiale_tipo) VALUES
    ('P001', 'T-shirt con stampa spray', 'T-shirt eccezionale di ultima qualità con stampa spray', 19.99, 'Immagini/t5.webp', 'Cotone'),
    ('P002', 'Jeans sfrangiati', 'Jeans stile sfrangiato con ottima vestibilità', 49.99, 'Immagini/p5.webp', 'Denim'),
    ('P003', 'Felpa boxy fit', 'Felpa invernale con cappuccio e tasca frontale', 39.99, 'Immagini/f2.webp', 'Cotone'),
    ('P004', 'T-shirt nera', 'T-shirt classica nera di poliestere', 9.99, 'Immagini/a1.webp', 'Poliestere'),
    ('P005', 'Giacca in Pelle', 'Giacca in vera pelle marrone, stile classico', 129.99, 'Immagini/g5.webp', 'Pelle'),
    ('P006', 'Giubbotto in denim', 'Giubbotto in denim con doppia tasca frontale', 79.99, 'Immagini/g4.webp', 'Denim');

-- Popolamento della tabella taglie
INSERT INTO taglie (tipo) VALUES
    ('XS'),
    ('S'),
    ('M'),
    ('L'),
    ('XL'),
    ('XXL');

-- Popolamento della tabella prodotti_taglie
-- Associazioni per la T-Shirt Bianca (disponibile in tutte le taglie)
INSERT INTO prodotti_taglie (codice_prodotto, tipo_taglia) VALUES
    ('P001', 'XS'),
    ('P001', 'S'),
    ('P001', 'M'),
    ('P001', 'L'),
    ('P001', 'XL'),
    ('P001', 'XXL');

-- Associazioni per i Jeans Slim Fit (taglie da S a XXL)
INSERT INTO prodotti_taglie (codice_prodotto, tipo_taglia) VALUES
    ('P002', 'S'),
    ('P002', 'M'),
    ('P002', 'L'),
    ('P002', 'XL'),
    ('P002', 'XXL');

-- Associazioni per la Felpa con Cappuccio (taglie da S a XL)
INSERT INTO prodotti_taglie (codice_prodotto, tipo_taglia) VALUES
    ('P003', 'S'),
    ('P003', 'M'),
    ('P003', 'L'),
    ('P003', 'XL');

-- Associazioni per le Sneakers Sportive (taglie S/M/L)
INSERT INTO prodotti_taglie (codice_prodotto, tipo_taglia) VALUES
    ('P004', 'S'),
    ('P004', 'M'),
    ('P004', 'L');

-- Associazioni per la Giacca in Pelle (disponibile da M a XL)
INSERT INTO prodotti_taglie (codice_prodotto, tipo_taglia) VALUES
    ('P005', 'M'),
    ('P005', 'L'),
    ('P005', 'XL');

-- Associazioni per il Giubbotto in denim (disponibile da M a XL)
INSERT INTO prodotti_taglie (codice_prodotto, tipo_taglia) VALUES
    ('P006', 'M'),
    ('P006', 'L'),
    ('P006', 'XL');

-- Visualizzazione dei dati inseriti
SELECT * FROM prodotti;
SELECT * FROM prodotti_taglie;
