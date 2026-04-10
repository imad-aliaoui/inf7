CREATE DATABASE IF NOT EXISTS student_party_corp;
USE student_party_corp;

CREATE TABLE IF NOT EXISTS djs (
                                   id INT AUTO_INCREMENT PRIMARY KEY,
                                   nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    telephone VARCHAR(30),
    portfolio VARCHAR(255),
    date_soiree DATE,
    materiel VARCHAR(10),
    couleur VARCHAR(20),
    photo VARCHAR(255),
    nb_enceintes1 INT DEFAULT 0,
    puissance1 INT DEFAULT 0,
    nb_enceintes2 INT DEFAULT 0,
    puissance2 INT DEFAULT 0
    );