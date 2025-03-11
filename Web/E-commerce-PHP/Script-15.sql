create database E_commerce;

use E_commerce;


create table prodotti(
	codice varchar(5) primary key,
	titolo varchar(200),
	descrizione varchar(200),
	prezzo double,
	immagine varchar(250)
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
