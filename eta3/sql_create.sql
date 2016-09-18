CREATE DATABASE a1400157;
USE a1400157;

CREATE TABLE ilmoitus(
	id INT AUTO_INCREMENT,
	nimi VARCHAR(50) NOT NULL,
	sukupuoli VARCHAR(50) NOT NULL,
	email VARCHAR(100) NOT NULL,
	puh VARCHAR(15),
	paikkakunta VARCHAR(100) NOT NULL,
	viesti VARCHAR(255),
	PRIMARY KEY (id));

INSERT INTO ilmoitus
VALUES (null,'Pena', 'Mies', 'penatyomies@maansiirtofirma.fi', '0407123456', 'Korso', 'Moikka vaan :)');

INSERT INTO ilmoitus
VALUES (null,'Marja', 'Nainen', 'marjaleena@marjaoy.fi', '0407343536', 'Vantaa', 'Heippa hei');