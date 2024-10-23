-- Borrar la BD si existe
DROP DATABASE IF EXISTS Sky_Cater;
-- Crear BD
CREATE DATABASE Sky_Cater;

-- CREAR TABLAS

-- Tabla Usuario_Registrado

CREATE TABLE Usuario_Registrado (
    Id_Usuario int AUTO_INCREMENT NOT NULL ,
    Nombre varchar(255)  NOT NULL ,
    Pass varchar(255)  NOT NULL ,
    CONSTRAINT pk_Usuario_Registrado PRIMARY KEY (Id_Usuario)
);

-- Tabla Registro_Log

CREATE TABLE Registro_Log (
    Id_Registro_Log int AUTO_INCREMENT NOT NULL ,
    Fecha Datetime  NOT NULL ,
    Id_Usuario int  NOT NULL ,
    CONSTRAINT pk_Registro_Log PRIMARY KEY (Id_Registro_Log),
	CONSTRAINT fk_Registro_Log_Usuario_Registrado FOREIGN KEY (Id_Usuario)
		REFERENCES Usuario_Registrado (Id_Usuario)
);

-- Tabla Estado_Vuelo
-- 1.Pendiente 2.Gestionado

CREATE TABLE Estado_Vuelo (
    Id_Estado int AUTO_INCREMENT NOT NULL ,
    Estado varchar(50)  NOT NULL ,
    CONSTRAINT pk_Estado_Vuelo PRIMARY KEY (Id_Estado)
);

-- Tabla Vuelo

CREATE TABLE Vuelo (
    Id_Vuelo int AUTO_INCREMENT NOT NULL ,
    Numero_Vuelo varchar(50) UNIQUE NOT NULL ,
    Id_Estado int  NOT NULL ,
    Id_Usuario int,
    CONSTRAINT pk_Vuelo PRIMARY KEY (Id_Vuelo),
	CONSTRAINT fk_Vuelo_Estado FOREIGN KEY (Id_Estado)
		REFERENCES Estado_Vuelo (Id_Estado),
	CONSTRAINT fk_Vuelo_Usuario_Registrado FOREIGN KEY (Id_Usuario)
		REFERENCES Usuario_Registrado (Id_Usuario)
);

-- Tabla Pasajero

CREATE TABLE Pasajero (
    Id_Pasajero int AUTO_INCREMENT NOT NULL ,
    Nombre varchar(255)  NOT NULL ,
	Apellido varchar(255) NOT NULL,
    Dni varchar(50)  UNIQUE NOT NULL ,
	Fecha_Nacimiento date NOT NULL,
    Intolerancias varchar(255)  NOT NULL ,
	Nacionalidad varchar(50) NOT NULL,
    CONSTRAINT pk_Pasajero PRIMARY KEY (Id_Pasajero)
);

-- Tabla Vuelo_Pasajero

CREATE TABLE Vuelo_Pasajero (
    Id_Vuelo_Pasajero int AUTO_INCREMENT NOT NULL ,
    Fecha_Salida datetime  NOT NULL ,
	Fecha_Llegada datetime NOT NULL,
	Origen varchar(255)  NOT NULL ,
    Destino varchar(255)  NOT NULL ,
	Asiento varchar(100) NOT NULL,
    Preferencias_Comida varchar(255)  NOT NULL ,
    Id_Vuelo int  NOT NULL ,
    Id_Pasajero int  NOT NULL ,
    CONSTRAINT pk_Vuelo_Pasajero PRIMARY KEY (Id_Vuelo_Pasajero),
	CONSTRAINT fk_VUelo_Pasajero_Vuelo FOREIGN KEY (Id_Vuelo)
		REFERENCES Vuelo (Id_Vuelo),
	CONSTRAINT fk_Vuelo_Pasajero_Pasajero FOREIGN KEY (Id_Pasajero)
		REFERENCES Pasajero (Id_Pasajero)
);

-- Tabla Proveedor

CREATE TABLE Proveedor (
    Id_Proveedor int AUTO_INCREMENT NOT NULL ,
    Nombre_Empresa varchar(255)  NOT NULL ,
	Nombre_Persona_Contacto varchar(255) NOT NULL,
	Telefono varchar(255),
    Valoracion varchar(50)  NOT NULL , -- Índicador de confianza del proveedor. Útil para mostrar en las gráficas.
    CONSTRAINT pk_Proveedor PRIMARY KEY (Id_Proveedor)
);


-- Tabla Producto

CREATE TABLE Producto (
    Id_Producto int AUTO_INCREMENT NOT NULL ,
    Nombre varchar(255) UNIQUE NOT NULL ,
	Descripcion varchar(255), -- Detalle sobre ingredientes.
	Categoria varchar(255) NOT NULL, -- Entrante,Bebida,Primer Plato, Segundo Plato, Postre.
    Alergenos varchar(255)  NOT NULL,
    Stock_Disponible int  NOT NULL, -- Se descuenta cuando se carga en el avión, se suma cuando se está incluido en un pedido.
	Fecha_Actualizacion datetime,
	Valor_Nutricional varchar(255), -- Opcional. Serían datos tipo calorías, proteínas, etc. Puede venir bien para meter en algún indicador o gráfica.
	Id_Proveedor int NOT NULL,
   CONSTRAINT pk_Producto PRIMARY KEY (Id_Producto),
   CONSTRAINT fk_Producto_Proveedor FOREIGN KEY (Id_Proveedor)
		REFERENCES Proveedor (Id_Proveedor)
);

-- Tabla Vuelo_Producto

CREATE TABLE Vuelo_Producto (
    Id_Vuelo_Producto int AUTO_INCREMENT NOT NULL ,
    Cantidad_Comida int  NOT NULL ,
    Tipo_Comida varchar(255)  NOT NULL ,
    Id_Vuelo int  NOT NULL ,
    Id_Producto int  NOT NULL ,
    CONSTRAINT pk_Vuelo_Producto PRIMARY KEY (Id_Vuelo_Producto),
	CONSTRAINT fk_Vuelo_Producto_Vuelo FOREIGN KEY (Id_Vuelo)
		REFERENCES Vuelo (Id_Vuelo),
	CONSTRAINT fk_Vuelo_Producto_Producto FOREIGN KEY (Id_Producto)
		REFERENCES Producto (Id_Producto)
);

-- Tabla Estado_Pedido
-- 1.Pendiente, 2.Entregado 3.Cancelado

CREATE TABLE Estado_Pedido (
	Id_Estado_Pedido int AUTO_INCREMENT NOT NULL,
	Estado_Pedido varchar(255),
    CONSTRAINT pk_Estado_Pedido PRIMARY KEY (Id_Estado_Pedido)
);

-- Tabla Pedido

CREATE TABLE Pedido (
    Id_Pedido int AUTO_INCREMENT NOT NULL ,
	Numero_Pedido int UNIQUE NOT NULL,
	Fecha_Pedido datetime NOT NULL,
	Coste_Total float NOT NULL, -- Hacer un procedure que cuando se realice el pedido, multiplique la cantidad por el precio del producto y lo agrega a esta columna.
	Observaciones varchar(255),
    Id_Proveedor int  NOT NULL ,
    Id_Usuario int  NOT NULL ,
	Estado_Pedido int NOT NULL, -- Clave foránea de Estado_Pedido, en donde con un número indicamos que tipo de estado tiene el pedido, Pendiente,Entregado,Cancelado.
    CONSTRAINT pk_Pedido PRIMARY KEY (Id_Pedido),
	CONSTRAINT fk_Pedido_Proveedor FOREIGN KEY (Id_Proveedor)
		REFERENCES Proveedor (Id_Proveedor),
	CONSTRAINT fk_Pedido_Usuario_Registrado FOREIGN KEY (Id_Usuario)
		REFERENCES Usuario_Registrado (Id_Usuario),
	CONSTRAINT fk_Pedido_Estado_Pedido FOREIGN KEY (Estado_Pedido)
		REFERENCES Estado_Pedido (Id_Estado_Pedido)
);

-- Tabla Pedido_Producto

CREATE TABLE Pedido_Producto (
	Id_Pedido_Producto int AUTO_INCREMENT NOT NULL ,
	Nombre_Producto varchar(255)  NOT NULL ,
	Cantidad int NOT NULL,
	Precio_Producto float NOT NULL,
	Id_Pedido int NOT NULL,
	Id_Producto int NOT NULL,
	CONSTRAINT pk_Pedido_Producto PRIMARY KEY (Id_Pedido_Producto),
	CONSTRAINT fk_Pedido_Producto_Pedido FOREIGN KEY (Id_Pedido)
		REFERENCES Pedido (Id_Pedido),
	CONSTRAINT fk_Pedido_Producto_Producto FOREIGN KEY (Id_Producto)
		REFERENCES Producto (Id_Producto)
);


-- CREAR ÍNDICES

-- Índice para agilizar las consultas a pedidos por la fecha de pedido.
CREATE INDEX idx_Fecha_Pedido ON Pedido (Fecha_Pedido);

-- RELLENAR TABLAS CON DATOS MAESTROS

-- Tabla Estado_Vuelo
INSERT INTO Estado_Vuelo (Estado) VALUES('Pendiente'),
('Gestionado');

-- Tabla Estado_Pedido
-- 1.Pendiente, 2.Entregado 3.Cancelado
INSERT INTO Estado_Pedido(Estado_Pedido) VALUES 
('Pendiente'),				  
('Entregado'),
('Cancelado');

-- Insertar datos en la tabla Vuelo
INSERT INTO Vuelo (Numero_Vuelo, Id_Estado, Id_Usuario) VALUES
('AA123', 1, 1),
('BB456', 2, 1),
('CC789', 1, 1),
('DD321', 1, 2),
('EE654', 2, 2),
('FF987', 1, 2),
('GG213', 2, 2),
('HH546', 1, 2),
('II879', 2, 2),
('JJ135', 1, 1),
('KK246', 2, 1),
('LL357', 1, 2),
('MM468', 2, 2),
('NN579', 1, 1),
('OO680', 2, 1),
('PP791', 1, 1),
('QQ802', 1, 1),
('RR913', 2, 1),
('SS024', 1, 1),
('TT135', 2, 1);

-- Insertar datos en la tabla Pasajero

INSERT INTO Pasajero (Nombre, Apellido, Dni, Fecha_Nacimiento, Intolerancias, Nacionalidad) VALUES
('Juan', 'Pérez', 'DNI12345678', '1990-01-15', 'Ninguna', 'Argentina'),
('María', 'Gómez', 'DNI23456789', '1985-05-30', 'Lactosa', 'Chile'),
('Luis', 'Martínez', 'DNI34567890', '1992-10-20', 'Gluten', 'México'),
('Ana', 'López', 'DNI45678901', '1988-07-25', 'Ninguna', 'España'),
('Carlos', 'Sánchez', 'DNI56789012', '1975-12-12', 'Nueces', 'Colombia'),
('Sofía', 'Ramírez', 'DNI67890123', '1995-03-14', 'Ninguna', 'Perú'),
('Pedro', 'Torres', 'DNI78901234', '1980-11-05', 'Gluten', 'Uruguay'),
('Lucía', 'Cruz', 'DNI89012345', '1993-08-22', 'Ninguna', 'Bolivia'),
('Diego', 'Hernández', 'DNI90123456', '1982-09-18', 'Mariscos', 'Paraguay'),
('Valentina', 'Jiménez', 'DNI01234567', '1991-04-28', 'Lactosa', 'Ecuador'),
('Javier', 'Fernández', 'DNI12345679', '1987-01-01', 'Ninguna', 'Argentina'),
('Carmen', 'Muñoz', 'DNI23456780', '1984-02-14', 'Lactosa', 'Chile'),
('Gabriel', 'Rojas', 'DNI34567881', '1990-03-21', 'Gluten', 'México'),
('Natalia', 'Vázquez', 'DNI45678982', '1983-04-30', 'Nueces', 'España'),
('Andrés', 'Castillo', 'DNI56789083', '1992-05-15', 'Ninguna', 'Colombia'),
('Isabel', 'Reyes', 'DNI67890184', '1991-06-19', 'Gluten', 'Perú'),
('Ricardo', 'Paredes', 'DNI78901285', '1985-07-27', 'Ninguna', 'Uruguay'),
('Patricia', 'Salazar', 'DNI89012386', '1988-08-02', 'Mariscos', 'Bolivia'),
('Felipe', 'Mora', 'DNI90123487', '1993-09-09', 'Lactosa', 'Paraguay'),
('Julia', 'Castro', 'DNI01234588', '1986-10-16', 'Ninguna', 'Ecuador');

-- Insertar datos en la tabla Vuelo_Pasajero

INSERT INTO Vuelo_Pasajero (Fecha_Salida, Fecha_Llegada, Origen, Destino, Asiento, Preferencias_Comida, Id_Vuelo, Id_Pasajero) VALUES
('2024-10-15 08:00:00', '2024-10-15 10:00:00', 'Buenos Aires', 'Santiago', 'Económica', 'Sin gluten', 41, 3), -- Luis Martínez (Gluten)
('2024-10-15 08:00:00', '2024-10-15 10:00:00', 'Santiago', 'Lima', 'Primera Clase', 'Sin lactosa', 41, 2), -- María Gómez (Lactosa)
('2024-10-15 08:00:00', '2024-10-15 10:00:00', 'Lima', 'Bogotá', 'Bussiness', 'Sin mariscos', 41, 10), -- Diego Hernández (Mariscos)
('2024-10-15 08:00:00', '2024-10-15 10:00:00', 'Bogotá', 'Caracas', 'Económica', 'Ninguna', 41, 1), -- Juan Pérez (Ninguna)
('2024-10-15 08:00:00', '2024-10-15 10:00:00', 'Caracas', 'Madrid', 'Bussiness', 'Sin nueces', 41, 6), -- Sofía Ramírez (Ninguna)
('2024-10-15 08:00:00', '2024-10-15 10:00:00', 'Madrid', 'Buenos Aires', 'Primera Clase', 'Sin lactosa', 41, 15), -- Felipe Mora (Lactosa)
('2024-10-15 08:00:00', '2024-10-15 10:00:00', 'Buenos Aires', 'Santiago', 'Económica', 'Sin gluten', 41, 4), -- Ana López (Ninguna)
('2024-10-15 08:00:00', '2024-10-15 10:00:00', 'Santiago', 'Lima', 'Primera Clase', 'Sin lactosa', 41, 14), -- Gabriel Rojas (Gluten)
('2024-10-15 08:00:00', '2024-10-15 10:00:00', 'Lima', 'Bogotá', 'Bussiness', 'Sin mariscos', 41, 11), -- Carmen Muñoz (Lactosa)
('2024-10-24 18:00:00', '2024-10-24 20:45:00', 'Bogotá', 'Caracas', 'Económica', 'Ninguna', 43, 13), -- Julia Castro (Ninguna)
('2024-10-24 18:00:00', '2024-10-24 20:45:00', 'Buenos Aires', 'Santiago', 'Primera Clase', 'Sin lactosa', 43, 7), -- Pedro Torres (Gluten)
('2024-10-24 18:00:00', '2024-10-24 20:45:00', 'Santiago', 'Lima', 'Bussiness', 'Sin gluten', 43, 12), -- Isabel Reyes (Gluten)
('2024-10-24 18:00:00', '2024-10-24 20:45:00', 'Lima', 'Bogotá', 'Económica', 'Ninguna', 43, 5), -- Carlos Sánchez (Nueces)
('2024-10-28 19:00:00', '2024-10-28 21:30:00', 'Bogotá', 'Caracas', 'Primera Clase', 'Sin nueces', 44, 16), -- Natalia Vázquez (Nueces)
('2024-10-28 19:00:00', '2024-10-28 21:30:00', 'Caracas', 'Madrid', 'Bussiness', 'Sin lactosa', 44, 9), -- Valentina Jiménez (Lactosa)
('2024-10-28 19:00:00', '2024-10-28 21:30:00', 'Madrid', 'Buenos Aires', 'Económica', 'Sin mariscos', 44, 8), -- Lucía Cruz (Ninguna)
('2024-10-28 19:00:00', '2024-10-28 21:30:00', 'Buenos Aires', 'Santiago', 'Primera Clase', 'Ninguna', 44, 17), -- Ricardo Paredes (Ninguna)
('2024-10-28 19:00:00', '2024-10-28 21:30:00', 'Buenos Aires', 'Santiago', 'Primera Clase', 'Sin mariscos', 44, 18), -- Patricia Salazar (Mariscos)
('2024-10-28 19:00:00', '2024-10-28 21:30:00', 'Buenos Aires', 'Santiago', 'Primera Clase', 'Sin lactosa', 44, 19), -- Felipe Mora (Lactosa)
('2024-10-28 19:00:00', '2024-10-28 21:30:00', 'Buenos Aires', 'Santiago', 'Primera Clase', 'Ninguna', 44, 20); -- Julia Castro (Ninguna)

-- Insertar datos en la tabla Proveedor

INSERT INTO Proveedor (Nombre_Empresa, Nombre_Persona_Contacto, Telefono, Valoracion) VALUES
('Delicias Aerolíneas', 'Juan Pérez', '555-1234', 'Excelente'),
('Catering Gourmet', 'María Gómez', '555-2345', 'Buena'),
('Sabores del Mundo', 'Luis Martínez', '555-3456', 'Regular'),
('Alimentos Frescos S.A.', 'Ana López', '555-4567', 'Excelente'),
('Comidas Rápidas S.L.', 'Carlos Sánchez', '555-5678', 'Buena'),
('Bocados de Lujo', 'Sofía Ramírez', '555-6789', 'Excelente'),
('Frutas y Verduras 2024', 'Pedro Torres', '555-7890', 'Regular'),
('Carnes Selectas', 'Lucía Cruz', '555-8901', 'Buena'),
('Panadería Internacional', 'Diego Hernández', '555-9012', 'Excelente'),
('Dulces y Postres', 'Valentina Jiménez', '555-0123', 'Regular'),
('Bebidas Premium', 'Javier Fernández', '555-1235', 'Buena'),
('Ensaladas Gourmet', 'Carmen Muñoz', '555-2346', 'Excelente'),
('Comidas Internacionales', 'Gabriel Rojas', '555-3457', 'Buena'),
('Salsas y Condimentos', 'Natalia Vázquez', '555-4568', 'Regular'),
('Productos Lácteos', 'Andrés Castillo', '555-5679', 'Excelente'),
('Snacks Saludables', 'Isabel Reyes', '555-6780', 'Buena'),
('Café y Té', 'Ricardo Paredes', '555-7891', 'Regular'),
('Catering Vegano', 'Patricia Salazar', '555-8902', 'Excelente'),
('Platos Típicos', 'Felipe Mora', '555-9013', 'Buena'),
('Delicias Regionales', 'Julia Castro', '555-0124', 'Excelente');

-- Insertar datos en la tabla Producto

INSERT INTO Producto (Nombre, Descripcion, Categoria, Alergenos, Stock_Disponible, Fecha_Actualizacion, Valor_Nutricional, Id_Proveedor) VALUES
-- Entrantes
('Ensalada César', 'Ensalada con lechuga romana, pollo, crutones y aderezo César', 'Entrante', 'Lácteos, Gluten', 50, '2024-10-01 10:00:00', '250 kcal', 1),
('Hummus con Pita', 'Pasta de garbanzos acompañada de pan pita', 'Entrante', 'Sésamo', 45, '2024-09-15 12:30:00', '200 kcal', 2),
('Sopa de Tomate', 'Sopa cremosa de tomate con albahaca', 'Entrante', 'Lácteos', 60, '2024-09-20 15:45:00', '150 kcal', 3),
('Bruschetta de Tomate', 'Tostadas con tomate, albahaca y ajo', 'Entrante', 'Gluten', 40, '2024-10-05 09:15:00', '120 kcal', 4),
('Tartar de Salmón', 'Tartar de salmón fresco con aguacate', 'Entrante', 'Pescado', 30, '2024-08-30 14:00:00', '300 kcal', 5),
('Rollitos de Primavera', 'Rollos de verduras frescas con salsa agridulce', 'Entrante', 'Gluten, Soya', 35, '2024-10-10 11:00:00', '150 kcal', 6),
('Mini Quiches', 'Pequeñas tartas rellenas de verduras y queso', 'Entrante', 'Lácteos, Gluten', 50, '2024-09-25 08:30:00', '220 kcal', 7),
('Antipasto Italiano', 'Selección de embutidos, quesos y aceitunas', 'Entrante', 'Lácteos', 20, '2024-10-08 17:00:00', '350 kcal', 8),

-- Primeros Platos
('Sushi Variado', 'Rollos de sushi con pescado y vegetales', 'Primer Plato', 'Pescado, Sésamo', 30, '2024-10-01 12:00:00', '350 kcal', 1),
('Pasta al Pesto', 'Pasta con salsa de albahaca y piñones', 'Primer Plato', 'Frutos secos', 35, '2024-09-18 13:30:00', '350 kcal', 2),
('Rissotto de Setas', 'Arroz cremoso con setas y parmesano', 'Primer Plato', 'Lácteos', 40, '2024-09-22 11:45:00', '400 kcal', 3),
('Gnocchi al Pomodoro', 'Pasta de patata con salsa de tomate', 'Primer Plato', 'Lácteos, Gluten', 25, '2024-10-02 16:15:00', '300 kcal', 4),
('Ensalada de Quinoa', 'Quinoa con verduras y aderezo de limón', 'Primer Plato', 'Ninguno', 50, '2024-10-07 14:30:00', '250 kcal', 5),
('Tortilla Española', 'Tortilla de patatas y cebolla', 'Primer Plato', 'Huevo', 40, '2024-09-30 09:00:00', '200 kcal', 6),
('Canelones de Espinaca', 'Canelones rellenos de espinaca y ricotta', 'Primer Plato', 'Lácteos, Gluten', 30, '2024-09-28 10:45:00', '350 kcal', 7),
('Ceviche de Pescado', 'Pescado marinado en limón con cebolla y cilantro', 'Primer Plato', 'Pescado', 20, '2024-10-04 13:15:00', '200 kcal', 8),

-- Segundos Platos
('Pollo Teriyaki', 'Pollo marinado en salsa teriyaki, servido con arroz', 'Segundo Plato', 'Soya', 40, '2024-09-20 18:30:00', '400 kcal', 1),
('Filete de Salmón a la Parrilla', 'Salmón a la parrilla con verduras asadas', 'Segundo Plato', 'Pescado', 35, '2024-09-15 12:00:00', '500 kcal', 2),
('Lomo de Cerdo a la Mostaza', 'Lomo de cerdo con salsa de mostaza y miel', 'Segundo Plato', 'Ninguno', 30, '2024-09-25 19:00:00', '450 kcal', 3),
('Vegetales Asados', 'Mezcla de vegetales de temporada asados', 'Segundo Plato', 'Ninguno', 50, '2024-10-10 17:15:00', '200 kcal', 4),
('Paella Valenciana', 'Arroz con mariscos y pollo al estilo español', 'Segundo Plato', 'Mariscos, Gluten', 20, '2024-09-22 11:30:00', '600 kcal', 5),
('Bife de Chorizo', 'Carne de res asada con chimichurri', 'Segundo Plato', 'Ninguno', 25, '2024-09-10 14:45:00', '700 kcal', 6),
('Curry Vegetal', 'Curry de verduras con arroz basmati', 'Segundo Plato', 'Ninguno', 40, '2024-10-02 13:00:00', '350 kcal', 7),
('Lasagna de Carne', 'Lasagna con carne, tomate y queso', 'Segundo Plato', 'Lácteos, Gluten', 30, '2024-10-01 16:00:00', '600 kcal', 8),

-- Bebidas
('Agua Mineral', 'Agua embotellada sin gas', 'Bebida', 'Ninguno', 100, '2024-10-01 10:00:00', '0 kcal', 2),
('Zumo de Naranja', 'Jugo natural de naranja', 'Bebida', 'Ninguno', 80, '2024-09-18 12:00:00', '120 kcal', 3),
('Cerveza Artesanal', 'Cerveza de elaboración local', 'Bebida', 'Cebada', 30, '2024-09-25 14:00:00', '150 kcal', 4),
('Vino Tinto', 'Botella de vino tinto de la región de La Rioja', 'Bebida', 'Sulfitos', 20, '2024-09-22 15:30:00', '120 kcal por copa', 5),
('Té Verde', 'Infusión de té verde, sin azúcar', 'Bebida', 'Ninguno', 80, '2024-09-28 11:15:00', '0 kcal', 6),
('Café Espresso', 'Café fuerte servido en taza pequeña', 'Bebida', 'Ninguno', 70, '2024-10-01 09:30:00', '5 kcal', 7),
('Limonada', 'Jugo de limón fresco con agua y azúcar', 'Bebida', 'Ninguno', 90, '2024-09-10 13:00:00', '100 kcal', 8),
('Batido de Frutas', 'Batido natural de plátano y fresas', 'Bebida', 'Ninguno', 55, '2024-10-03 12:45:00', '200 kcal', 1),

-- Postres
('Tarta de Chocolate', 'Postre de chocolate con crema y galleta', 'Postre', 'Lácteos, Gluten', 25, '2024-10-04 15:00:00', '300 kcal', 5),
('Tiramisú', 'Postre italiano con café y queso mascarpone', 'Postre', 'Lácteos, Gluten', 15, '2024-09-20 10:00:00', '400 kcal', 6),
('Mousse de Frambuesa', 'Postre ligero de frambuesas y crema', 'Postre', 'Lácteos', 20, '2024-10-02 10:30:00', '250 kcal', 1),
('Pastel de Zanahoria', 'Pastel húmedo de zanahoria con nueces', 'Postre', 'Frutos secos, Lácteos', 15, '2024-09-30 14:00:00', '300 kcal', 2),
('Pavlova', 'Merengue crujiente con frutas y crema', 'Postre', 'Lácteos, Huevos', 10, '2024-10-05 12:15:00', '350 kcal', 3),
('Flan de Caramelo', 'Flan cremoso con salsa de caramelo', 'Postre', 'Lácteos', 25, '2024-09-25 11:00:00', '200 kcal', 4),
('Tarta de Limón', 'Tarta fresca de limón con merengue', 'Postre', 'Lácteos, Gluten', 20, '2024-10-01 16:30:00', '300 kcal', 5),
('Churros con Chocolate', 'Dulces fritos espolvoreados con azúcar, acompañados de chocolate', 'Postre', 'Gluten, Lácteos', 15, '2024-09-28 13:30:00', '400 kcal', 6);
