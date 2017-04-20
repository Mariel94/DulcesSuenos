CREATE TABLE Users (
	fName VARCHAR(30) NOT NULL,
    lName VARCHAR(30) NOT NULL,
    username VARCHAR(50) NOT NULL PRIMARY KEY,
    passwrd VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    state VARCHAR(50) NOT NULL,
    product VARCHAR(50) NOT NULL
);

INSERT INTO Users(fName, lName, username, passwrd, email, gender, state)
VALUES  ('Mayela', 'Carreon', 'admin', 'admin', 'dulcessuenos@gmail.com', 'Mujer', 'Nuevo Leon');

CREATE TABLE Products (
	ID INT AUTO_INCREMENT PRIMARY KEY,
    Categoria VARCHAR(50) NOT NULL,
    Subcategoria VARCHAR(50) NOT NULL,
    Nombre VARCHAR(50) NOT NULL,
    Precio VARCHAR(30) NOT NULL,
    Descripcion VARCHAR(100) NOT NULL,
    Contiene VARCHAR(100) NOT NULL,
    Composicion VARCHAR(100) NOT NULL,
    Medidas VARCHAR(100) NOT NULL,
    Imagen VARCHAR(150) NOT NULL
);