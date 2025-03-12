create database E_commerce;

use E_commerce;


create table prodotti(
                         codice varchar(5) primary key,
                         titolo varchar(200),
                         descrizione varchar(200),
                         prezzo double,
                         immagine varchar(250),
);


CREATE TABLE prodotti_taglie (
                                 codice_prodotto VARCHAR(5),
                                 tipo_taglia VARCHAR(50),
                                 PRIMARY KEY (codice_prodotto, tipo_taglia),
                                 FOREIGN KEY (codice_prodotto) REFERENCES prodotti(codice) ON DELETE CASCADE,
                                 FOREIGN KEY (tipo_taglia) REFERENCES taglie(tipo) ON DELETE CASCADE
);



create table taglie(
                       tipo varchar(50) primary key
);

create table materiali(
                          tipo varchar(50) primary key,
                          lavaggio bool
);


create table users(
                      nome varchar(250) primary key,
                      password varchar(250)
);



delete from prodotti
-- -------------------------


-- Popolamento della tabella prodotti
    INSERT INTO prodotti (codice, titolo, descrizione, prezzo, immagine) VALUES
    ('P001', 'T-Shirt Bianca', 'T-shirt in cotone bianca 100%', 19.99, '../Immagini/p1.webp'),
    ('P002', 'Jeans Slim Fit', 'Jeans slim fit blu scuro', 49.99, '../Immagini/p1.webp'),
    ('P003', 'Felpa con Cappuccio', 'Felpa invernale con cappuccio e tasca frontale', 39.99, '../Immagini/p1.webp'),
    ('P004', 'Sneakers Sportive', 'Scarpe sportive leggere e traspiranti', 59.99, '../Immagini/p1.webp'),
    ('P005', 'Giacca in Pelle', 'Giacca in vera pelle nera, stile classico', 129.99, '../Immagini/p1.webp');

-- Popolamento della tabella taglie
INSERT INTO taglie (tipo) VALUES
                              ('XS'),
                              ('S'),
                              ('M'),
                              ('L'),
                              ('XL'),
                              ('XXL');

-- Popolamento della tabella materiali
INSERT INTO materiali (tipo, lavaggio) VALUES
                                           ('Cotone', TRUE),
                                           ('Poliestere', TRUE),
                                           ('Lana', FALSE),
                                           ('Pelle', FALSE),
                                           ('Denim', TRUE);



-- Associazioni per T-Shirt Bianca (disponibile in tutte le taglie)
INSERT INTO prodotti_taglie (codice_prodotto, tipo_taglia) VALUES
                                                               ('P001', 'XS'),
                                                               ('P001', 'S'),
                                                               ('P001', 'M'),
                                                               ('P001', 'L'),
                                                               ('P001', 'XL'),
                                                               ('P001', 'XXL');

-- Associazioni per Jeans Slim Fit (taglie da S a XXL)
INSERT INTO prodotti_taglie (codice_prodotto, tipo_taglia) VALUES
                                                               ('P002', 'S'),
                                                               ('P002', 'M'),
                                                               ('P002', 'L'),
                                                               ('P002', 'XL'),
                                                               ('P002', 'XXL');

-- Associazioni per Felpa con Cappuccio (taglie da S a XL)
INSERT INTO prodotti_taglie (codice_prodotto, tipo_taglia) VALUES
                                                               ('P003', 'S'),
                                                               ('P003', 'M'),
                                                               ('P003', 'L'),
                                                               ('P003', 'XL');

-- Associazioni per Sneakers Sportive (scarpe, convertiamo numeri in taglie S/M/L)
INSERT INTO prodotti_taglie (codice_prodotto, tipo_taglia) VALUES
                                                               ('P004', 'S'),  -- 40
                                                               ('P004', 'M'),  -- 41
                                                               ('P004', 'L');  -- 42

-- Associazioni per Giacca in Pelle (disponibile da M a XL)
INSERT INTO prodotti_taglie (codice_prodotto, tipo_taglia) VALUES
                                                               ('P005', 'M'),
                                                               ('P005', 'L'),
                                                               ('P005', 'XL');



select *
from prodotti_taglie;