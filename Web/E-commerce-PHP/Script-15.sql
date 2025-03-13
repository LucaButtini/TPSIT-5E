create database E_commerce;

use E_commerce;

create table prodotti(
                         codice varchar(5) primary key,
                         titolo varchar(200),
                         descrizione varchar(200),
                         prezzo double,
                         immagine varchar(250),
                         materiale_tipo varchar(50),
                         foreign key (materiale_tipo) references materiali(tipo) on delete set null
);

create table taglie(
                       tipo varchar(50) primary key
);

create table materiali(
                          tipo varchar(50) primary key,
                          lavaggio bool
);

create table prodotti_taglie (
                                 codice_prodotto VARCHAR(5),
                                 tipo_taglia VARCHAR(50),
                                 PRIMARY KEY (codice_prodotto, tipo_taglia),
                                 FOREIGN KEY (codice_prodotto) REFERENCES prodotti(codice) ON DELETE CASCADE,
                                 FOREIGN KEY (tipo_taglia) REFERENCES taglie(tipo) ON DELETE CASCADE
);

-- Aggiungere i dati come prima
delete from prodotti;

-- Popolamento della tabella prodotti
INSERT INTO prodotti (codice, titolo, descrizione, prezzo, immagine, materiale_tipo) VALUES
                                                                                         ('P001', 'T-shirt con stampa spray', 'T-shirt eccezzionale di ultima qualità con stampa spray', 19.99, '../Immagini/t5.webp', 'Cotone'),
                                                                                         ('P002', 'Jeans sfrangiati', 'Jeans stile sfrangiato con ottima vestibilità', 49.99, '../Immagini/p5.webp', 'Denim'),
                                                                                         ('P003', 'Felpa boxy fit', 'Felpa invernale con cappuccio e tasca frontale', 39.99, '../Immagini/f2.webp', 'Cotone'),
                                                                                         ('P004', 'T-shirt nera', 'T-shirt classica nera di poliestere', 9.99, '../Immagini/a1.webp', 'Poliestere'),
                                                                                         ('P005', 'Giacca in Pelle', 'Giacca in vera pelle marrone, stile classico', 129.99, '../Immagini/g5.webp', 'Pelle'),
                                                                                         ('P006', 'Giubbotto in denim', 'Giubotto in denim con doppia tasca frontale', 79.99, '../Immagini/g4.webp', 'Denim');


delete from prodotti;

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

-- Popolamento della tabella prodotti_taglie
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

INSERT INTO prodotti_taglie (codice_prodotto, tipo_taglia) VALUES
                                                               ('P006', 'M'),
                                                               ('P006', 'L'),
                                                               ('P006', 'XL');

select * from prodotti;
select * from prodotti_taglie;
