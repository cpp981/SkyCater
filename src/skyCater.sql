CREATE DATABASE IF NOT EXISTS catering_aerolinea;
USE catering_aerolinea;

CREATE TABLE Pasajero (
    ID_Pasajero INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(50),
    Apellido VARCHAR(50),
    Preferencias_Alimentarias TEXT,
    Intolerancias TEXT
);

CREATE TABLE Vuelo (
    ID_Vuelo INT AUTO_INCREMENT PRIMARY KEY,
    Numero_Vuelo VARCHAR(20),
    Fecha DATE,
    Origen VARCHAR(50),
    Destino VARCHAR(50)
);

CREATE TABLE Reserva (
    ID_Reserva INT AUTO_INCREMENT PRIMARY KEY,
    ID_Pasajero INT,
    ID_Vuelo INT,
    Asiento VARCHAR(10),
    FOREIGN KEY (ID_Pasajero) REFERENCES Pasajero(ID_Pasajero),
    FOREIGN KEY (ID_Vuelo) REFERENCES Vuelo(ID_Vuelo)
);

CREATE TABLE Producto (
    ID_Producto INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(50),
    Descripcion TEXT,
    Stock INT
);

CREATE TABLE Proveedor (
    ID_Proveedor INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(50),
    Contacto VARCHAR(100)
);

CREATE TABLE Pedido (
    ID_Pedido INT AUTO_INCREMENT PRIMARY KEY,
    ID_Proveedor INT,
    Fecha_Pedido DATE,
    Fecha_Entrega DATE,
    FOREIGN KEY (ID_Proveedor) REFERENCES Proveedor(ID_Proveedor)
);

CREATE TABLE Detalle_Pedido (
    ID_Detalle_Pedido INT AUTO_INCREMENT PRIMARY KEY,
    ID_Pedido INT,
    ID_Producto INT,
    Cantidad INT,
    FOREIGN KEY (ID_Pedido) REFERENCES Pedido(ID_Pedido),
    FOREIGN KEY (ID_Producto) REFERENCES Producto(ID_Producto)
);

CREATE TABLE Carga_Comida (
    ID_Carga INT AUTO_INCREMENT PRIMARY KEY,
    ID_Vuelo INT,
    ID_Producto INT,
    Cantidad INT,
    FOREIGN KEY (ID_Vuelo) REFERENCES Vuelo(ID_Vuelo),
    FOREIGN KEY (ID_Producto) REFERENCES Producto(ID_Producto)
);

CREATE TABLE Preferencia_Comida (
    ID_Preferencia INT AUTO_INCREMENT PRIMARY KEY,
    ID_Pasajero INT,
    ID_Carga INT,
    Preferencia TEXT,
    Intolerancia TEXT,
    FOREIGN KEY (ID_Pasajero) REFERENCES Pasajero(ID_Pasajero),
    FOREIGN KEY (ID_Carga) REFERENCES Carga_Comida(ID_Carga)
);
