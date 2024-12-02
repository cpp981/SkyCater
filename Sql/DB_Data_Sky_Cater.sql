
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `Sky_Cater`
--
CREATE DATABASE IF NOT EXISTS `Sky_Cater` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `Sky_Cater`;


--
-- Estructura de tabla para la tabla `Estado_Pedido`
--

DROP TABLE IF EXISTS `Estado_Pedido`;
CREATE TABLE `Estado_Pedido` (
  `Id_Estado_Pedido` int NOT NULL,
  `Estado_Pedido` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `Estado_Pedido`
--

INSERT INTO `Estado_Pedido` (`Id_Estado_Pedido`, `Estado_Pedido`) VALUES
(1, 'Pendiente'),
(2, 'Entregado'),
(3, 'Cancelado');
-- --------------------------------------------------------


--
-- Estructura de tabla para la tabla `Estado_Vuelo`
--

DROP TABLE IF EXISTS `Estado_Vuelo`;
CREATE TABLE `Estado_Vuelo` (
  `Id_Estado` int NOT NULL,
  `Estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `Estado_Vuelo`
--

INSERT INTO `Estado_Vuelo` (`Id_Estado`, `Estado`) VALUES
(1, 'Pendiente'),
(2, 'Gestionado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuario_Registrado`
--

DROP TABLE IF EXISTS `Usuario_Registrado`;
CREATE TABLE `Usuario_Registrado` (
  `Id_Usuario` int NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `Usuario_Registrado`
--

INSERT INTO `Usuario_Registrado` (`Id_Usuario`, `Nombre`, `Pass`) VALUES
(1, 'carlos', '$2y$10$uMilfFU.bXPRfljFuoSIhOp6yi4ikPfaUpyyCeUvQHxCMXY3f/Gxi'),
(2, 'admin', '$2y$10$lbWPeRA3zm0Pm5o9bK7Ko.3/o/y0qgPBugZ0n4UTRH8Wxk7qVti4.');

-- --------------------------------------------------------
--

--
-- Estructura de tabla para la tabla `Registro_Log`
--

DROP TABLE IF EXISTS `Registro_Log`;
CREATE TABLE `Registro_Log` (
  `Id_Registro_Log` int NOT NULL,
  `Fecha` datetime NOT NULL,
  `Id_Usuario` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- RELACIONES PARA LA TABLA `Registro_Log`:
--   `Id_Usuario`
--       `Usuario_Registrado` -> `Id_Usuario`
--

-- ---------------------------------------------------------

--
-- Estructura de tabla para la tabla `Pasajero`
--

DROP TABLE IF EXISTS `Pasajero`;
CREATE TABLE `Pasajero` (
  `Id_Pasajero` int NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Apellido` varchar(255) NOT NULL,
  `Dni` varchar(50) NOT NULL,
  `Fecha_Nacimiento` date NOT NULL,
  `Intolerancias` varchar(255) NOT NULL,
  `Nacionalidad` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- RELACIONES PARA LA TABLA `Pasajero`:
--

--
-- Volcado de datos para la tabla `Pasajero`
--

INSERT INTO `Pasajero` (`Id_Pasajero`, `Nombre`, `Apellido`, `Dni`, `Fecha_Nacimiento`, `Intolerancias`, `Nacionalidad`) VALUES
(1, 'Juan', 'Pérez', '12345678', '1990-01-15', 'Ninguna', 'Argentina'),
(2, 'María', 'Gómez', '23456789', '1985-05-30', 'Lactosa', 'Chile'),
(3, 'Luis', 'Martínez', '34567890', '1992-10-20', 'Gluten', 'México'),
(4, 'Ana', 'López', '45678901', '1988-07-25', 'Ninguna', 'España'),
(5, 'Carlos', 'Sánchez', '56789012', '1975-12-12', 'Nueces', 'Colombia'),
(6, 'Sofía', 'Ramírez', '67890123', '1995-03-14', 'Ninguna', 'Perú'),
(7, 'Pedro', 'Torres', '78901234', '1980-11-05', 'Gluten', 'Uruguay'),
(8, 'Lucía', 'Cruz', '89012345', '1993-08-22', 'Ninguna', 'Bolivia'),
(9, 'Diego', 'Hernández', '90123456', '1982-09-18', 'Mariscos', 'Paraguay'),
(10, 'Valentina', 'Jiménez', '01234567', '1991-04-28', 'Lactosa', 'Ecuador'),
(11, 'Javier', 'Fernández', '12345679', '1987-01-01', 'Ninguna', 'Argentina'),
(12, 'Carmen', 'Muñoz', '23456780', '1984-02-14', 'Lactosa', 'Chile'),
(13, 'Gabriel', 'Rojas', '34567881', '1990-03-21', 'Gluten', 'México'),
(14, 'Natalia', 'Vázquez', '45678982', '1983-04-30', 'Nueces', 'España'),
(15, 'Andrés', 'Castillo', '56789083', '1992-05-15', 'Ninguna', 'Colombia'),
(16, 'Isabel', 'Reyes', '67890184', '1991-06-19', 'Gluten', 'Perú'),
(17, 'Ricardo', 'Paredes', '78901285', '1985-07-27', 'Ninguna', 'Uruguay'),
(18, 'Patricia', 'Salazar', '89012386', '1988-08-02', 'Mariscos', 'Bolivia'),
(19, 'Felipe', 'Mora', '90123487', '1993-09-09', 'Lactosa', 'Paraguay'),
(20, 'Julia', 'Castro', '01234588', '1986-10-16', 'Ninguna', 'Ecuador'),
(21, 'Martín', 'Alvarez', '54321678', '1991-02-11', 'Lactosa', 'Uruguay'),
(22, 'Rosa', 'Navarro', '65432789', '1986-09-30', 'Gluten', 'Venezuela'),
(23, 'David', 'Ortiz', '76543890', '1994-06-15', 'Ninguna', 'Honduras'),
(24, 'Elena', 'Martín', '87654901', '1990-12-03', 'Frutos Secos', 'Costa Rica'),
(25, 'Héctor', 'Ruiz', '98765012', '1988-08-21', 'Mariscos', 'Panamá'),
(26, 'Camila', 'Ibáñez', '09876123', '1993-11-12', 'Ninguna', 'Guatemala'),
(27, 'Federico', 'Campos', '10987234', '1985-04-19', 'Gluten', 'Nicaragua'),
(28, 'Lorena', 'Silva', '21098345', '1992-05-08', 'Nueces', 'El Salvador'),
(29, 'Santiago', 'Morales', '32109456', '1997-07-04', 'Lactosa', 'Cuba'),
(30, 'Verónica', 'Rojas', '43210567', '1996-01-29', 'Ninguna', 'Puerto Rico'),
(31, 'Emilio', 'Pérez', '54321689', '1991-10-18', 'Frutos Secos', 'República Dominicana'),
(32, 'Nuria', 'Luna', '65432790', '1983-06-25', 'Mariscos', 'Haití'),
(33, 'Joaquín', 'Esteban', '76543801', '1999-03-03', 'Ninguna', 'Belice'),
(34, 'Alicia', 'Duarte', '87654912', '1994-09-17', 'Gluten', 'Guayana'),
(35, 'Pablo', 'Suárez', '98765023', '1995-12-28', 'Nueces', 'Surinam'),
(36, 'Claudia', 'Ramos', '09876134', '1987-05-10', 'Ninguna', 'Jamaica'),
(37, 'Mateo', 'Vidal', '10987245', '1990-07-23', 'Lactosa', 'Barbados'),
(38, 'Carla', 'Santos', '21098356', '1992-11-07', 'Frutos Secos', 'Trinidad y Tobago'),
(39, 'Guillermo', 'León', '32109467', '1989-08-11', 'Ninguna', 'Bahamas'),
(40, 'Luciana', 'Cabrera', '43210578', '1998-04-14', 'Mariscos', 'Aruba'),
(107, 'Marcelo', 'González', '11223345', '1989-02-15', 'Gluten', 'Brasil'),
(108, 'Sara', 'Hernández', '22334456', '1992-07-01', 'Nueces', 'Estados Unidos'),
(109, 'Tomás', 'López', '33445567', '1991-05-19', 'Mariscos', 'Canadá'),
(110, 'Paula', 'Martínez', '44556678', '1986-08-05', 'Frutos Secos', 'Francia'),
(111, 'Miguel', 'Pérez', '55667789', '1987-09-30', 'Lactosa', 'Alemania'),
(112, 'Laura', 'González', '66778890', '1994-10-17', 'Gluten', 'Italia'),
(113, 'Adrián', 'Sánchez', '77889901', '1993-11-22', 'Frutos Secos', 'Reino Unido'),
(114, 'Elena', 'Ramírez', '88990012', '1988-12-02', 'Mariscos', 'Australia'),
(115, 'Luis', 'Castillo', '99001123', '1990-02-27', 'Ninguna', 'Estados Unidos'),
(116, 'Carolina', 'Jiménez', '10111234', '1995-01-11', 'Lactosa', 'Nueva Zelanda'),
(117, 'David', 'Hernández', '11223356', '1983-04-20', 'Gluten', 'Suecia'),
(118, 'Marta', 'Serrano', '22334467', '1992-06-05', 'Mariscos', 'Finlandia'),
(119, 'Javier', 'Martínez', '33445578', '1989-07-14', 'Frutos Secos', 'Noruega'),
(120, 'Paula', 'Gómez', '44556689', '1991-11-12', 'Lactosa', 'Países Bajos'),
(121, 'Carlos', 'López', '55667790', '1987-12-03', 'Ninguna', 'Bélgica'),
(122, 'Antonio', 'Rodríguez', '66778801', '1994-05-25', 'Gluten', 'Irlanda'),
(123, 'Raúl', 'Vázquez', '77889912', '1986-06-30', 'Mariscos', 'Suiza'),
(124, 'Sofía', 'Reyes', '88990023', '1992-08-15', 'Ninguna', 'Portugal'),
(125, 'Pedro', 'Muñoz', '99001134', '1995-09-09', 'Frutos Secos', 'Dinamarca'),
(126, 'Eva', 'Martínez', '10111245', '1984-10-11', 'Lactosa', 'España'),
(127, 'Daniel', 'Hernández', '11223367', '1990-01-05', 'Gluten', 'Francia'),
(128, 'Lorena', 'González', '22334478', '1993-03-14', 'Mariscos', 'Italia'),
(129, 'Luis', 'Sánchez', '33445589', '1992-12-01', 'Frutos Secos', 'Reino Unido'),
(130, 'Cecilia', 'Castillo', '44556690', '1988-07-20', 'Lactosa', 'Alemania'),
(131, 'Pablo', 'Martínez', '55667701', '1985-02-14', 'Ninguna', 'Países Bajos'),
(132, 'Fernando', 'López', '66778812', '1994-11-18', 'Gluten', 'Suecia'),
(133, 'Isabel', 'González', '77889923', '1991-08-23', 'Mariscos', 'Finlandia'),
(134, 'Iván', 'Pérez', '88990034', '1989-04-08', 'Frutos Secos', 'Noruega'),
(135, 'Lucía', 'Gómez', '99001145', '1993-05-29', 'Lactosa', 'Bélgica'),
(136, 'José', 'Ramírez', '10111256', '1986-11-13', 'Ninguna', 'Irlanda'),
(137, 'Felipe', 'González', '11223378', '1990-09-09', 'Gluten', 'Portugal'),
(138, 'María', 'Castro', '22334489', '1995-06-25', 'Mariscos', 'Suiza'),
(139, 'Raúl', 'Jiménez', '33445590', '1988-12-17', 'Frutos Secos', 'Reino Unido'),
(140, 'Ana', 'Torres', '44556601', '1987-05-01', 'Lactosa', 'Australia'),
(141, 'Eduardo', 'Serrano', '55667712', '1991-07-11', 'Ninguna', 'Nueva Zelanda'),
(142, 'Carlos', 'Vázquez', '66778823', '1993-04-30', 'Gluten', 'Finlandia'),
(143, 'Patricia', 'Muñoz', '77889934', '1992-02-15', 'Mariscos', 'Suecia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Proveedor`
--

DROP TABLE IF EXISTS `Proveedor`;
CREATE TABLE `Proveedor` (
  `Id_Proveedor` int NOT NULL,
  `Nombre_Empresa` varchar(255) NOT NULL,
  `Nombre_Persona_Contacto` varchar(255) NOT NULL,
  `Telefono` varchar(255) DEFAULT NULL,
  `Valoracion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


--
-- Volcado de datos para la tabla `Proveedor`
--

INSERT INTO `Proveedor` (`Id_Proveedor`, `Nombre_Empresa`, `Nombre_Persona_Contacto`, `Telefono`, `Valoracion`) VALUES
(1, 'Delicias Aerolíneas', 'Juan Pérez', '555-1234', 'Excelente'),
(2, 'Catering Gourmet', 'María Gómez', '555-2345', 'Buena'),
(3, 'Sabores del Mundo', 'Luis Martínez', '555-3456', 'Regular'),
(4, 'Alimentos Frescos S.A.', 'Ana López', '555-4567', 'Excelente'),
(5, 'Comidas Rápidas S.L.', 'Carlos Sánchez', '555-5678', 'Buena'),
(6, 'Bocados de Lujo', 'Sofía Ramírez', '555-6789', 'Excelente'),
(7, 'Frutas y Verduras 2024', 'Pedro Torres', '555-7890', 'Regular'),
(8, 'Carnes Selectas', 'Lucía Cruz', '555-8901', 'Buena'),
(9, 'Panadería Internacional', 'Diego Hernández', '555-9012', 'Excelente'),
(10, 'Dulces y Postres', 'Valentina Jiménez', '555-0123', 'Regular'),
(11, 'Bebidas Premium', 'Javier Fernández', '555-1235', 'Buena'),
(12, 'Ensaladas Gourmet', 'Carmen Muñoz', '555-2346', 'Excelente'),
(13, 'Comidas Internacionales', 'Gabriel Rojas', '555-3457', 'Buena'),
(14, 'Salsas y Condimentos', 'Natalia Vázquez', '555-4568', 'Regular'),
(15, 'Productos Lácteos', 'Andrés Castillo', '555-5679', 'Excelente'),
(16, 'Snacks Saludables', 'Isabel Reyes', '555-6780', 'Buena'),
(17, 'Café y Té', 'Ricardo Paredes', '555-7891', 'Regular'),
(18, 'Catering Vegano', 'Patricia Salazar', '555-8902', 'Excelente'),
(19, 'Platos Típicos', 'Felipe Mora', '555-9013', 'Buena'),
(20, 'Delicias Regionales', 'Julia Castro', '555-0124', 'Excelente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Producto`
--

DROP TABLE IF EXISTS `Producto`;
CREATE TABLE `Producto` (
  `Id_Producto` int NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Descripcion` varchar(255) DEFAULT NULL,
  `Categoria` varchar(255) NOT NULL,
  `Alergenos` varchar(255) NOT NULL,
  `Stock_Disponible` int DEFAULT NULL,
  `Fecha_Actualizacion` datetime DEFAULT NULL,
  `Valor_Nutricional` varchar(255) DEFAULT NULL,
  `Id_Proveedor` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- RELACIONES PARA LA TABLA `Producto`:
--   `Id_Proveedor`
--       `Proveedor` -> `Id_Proveedor`
--

--
-- Volcado de datos para la tabla `Producto`
--

INSERT INTO `Producto` (`Id_Producto`, `Nombre`, `Descripcion`, `Categoria`, `Alergenos`, `Stock_Disponible`, `Fecha_Actualizacion`, `Valor_Nutricional`, `Id_Proveedor`) VALUES
(1, 'Ensalada César', 'Ensalada con lechuga romana, pollo, crutones y aderezo César', 'Primer Plato', 'Lácteos, Gluten', 46, '2024-10-01 10:00:00', '250 kcal', 1),
(2, 'Hummus con Pita', 'Pasta de garbanzos acompañada de pan pita', 'Primer Plato', 'Sésamo', 82, '2024-09-15 12:30:00', '200 kcal', 2),
(3, 'Sopa de Tomate', 'Sopa cremosa de tomate con albahaca', 'Primer Plato', 'Lácteos', 55, '2024-09-20 15:45:00', '150 kcal', 3),
(4, 'Bruschetta de Tomate', 'Tostadas con tomate, albahaca y ajo', 'Primer Plato', 'Gluten', 50, '2024-10-05 09:15:00', '120 kcal', 4),
(5, 'Tartar de Salmón', 'Tartar de salmón fresco con aguacate', 'Primer Plato', 'Pescado', 27, '2024-08-30 14:00:00', '300 kcal', 5),
(6, 'Rollitos de Primavera', 'Rollos de verduras frescas con salsa agridulce', 'Primer Plato', 'Gluten, Soya', 33, '2024-10-10 11:00:00', '150 kcal', 6),
(7, 'Mini Quiches', 'Pequeñas tartas rellenas de verduras y queso', 'Primer Plato', 'Lácteos, Gluten', 50, '2024-09-25 08:30:00', '220 kcal', 7),
(8, 'Antipasto Italiano', 'Selección de embutidos, quesos y aceitunas', 'Primer Plato', 'Lácteos', 48, '2024-10-08 17:00:00', '350 kcal', 8),
(9, 'Sushi Variado', 'Rollos de sushi con pescado y vegetales', 'Primer Plato', 'Pescado, Sésamo', 27, '2024-10-01 12:00:00', '350 kcal', 1),
(10, 'Pasta al Pesto', 'Pasta con salsa de albahaca y piñones', 'Primer Plato', 'Frutos secos', 33, '2024-09-18 13:30:00', '350 kcal', 2),
(11, 'Rissotto de Setas', 'Arroz cremoso con setas y parmesano', 'Primer Plato', 'Lácteos', 39, '2024-09-22 11:45:00', '400 kcal', 3),
(12, 'Gnocchi al Pomodoro', 'Pasta de patata con salsa de tomate', 'Primer Plato', 'Lácteos, Gluten', 24, '2024-10-02 16:15:00', '300 kcal', 4),
(13, 'Ensalada de Quinoa', 'Quinoa con verduras y aderezo de limón', 'Primer Plato', 'Ninguno', 49, '2024-10-07 14:30:00', '250 kcal', 5),
(15, 'Canelones de Espinaca', 'Canelones rellenos de espinaca y ricotta', 'Primer Plato', 'Lácteos, Gluten', 30, '2024-09-28 10:45:00', '350 kcal', 7),
(16, 'Ceviche de Pescado', 'Pescado marinado en limón con cebolla y cilantro', 'Primer Plato', 'Pescado', 19, '2024-10-04 13:15:00', '200 kcal', 8),
(17, 'Pollo Teriyaki', 'Pollo marinado en salsa teriyaki, servido con arroz', 'Segundo Plato', 'Soya', 33, '2024-09-20 18:30:00', '400 kcal', 1),
(18, 'Filete de Salmón a la Parrilla', 'Salmón a la parrilla con verduras asadas', 'Segundo Plato', 'Pescado', 34, '2024-09-15 12:00:00', '500 kcal', 2),
(19, 'Lomo de Cerdo a la Mostaza', 'Lomo de cerdo con salsa de mostaza y miel', 'Segundo Plato', 'Ninguno', 26, '2024-09-25 19:00:00', '450 kcal', 3),
(20, 'Vegetales Asados', 'Mezcla de vegetales de temporada asados', 'Segundo Plato', 'Ninguno', 46, '2024-10-10 17:15:00', '200 kcal', 4),
(21, 'Paella Valenciana', 'Arroz con mariscos y pollo al estilo español', 'Segundo Plato', 'Mariscos, Gluten', 16, '2024-09-22 11:30:00', '600 kcal', 5),
(22, 'Bife de Chorizo', 'Carne de res asada con chimichurri', 'Segundo Plato', 'Ninguno', 21, '2024-09-10 14:45:00', '700 kcal', 6),
(23, 'Curry Vegetal', 'Curry de verduras con arroz basmati', 'Segundo Plato', 'Ninguno', 36, '2024-11-22 17:28:46', '350 kcal', 7),
(24, 'Lasagna de Carne', 'Lasagna con carne, tomate y queso', 'Segundo Plato', 'Lácteos, Gluten', 30, '2024-10-01 16:00:00', '600 kcal', 8),
(25, 'Agua Mineral', 'Agua embotellada sin gas', 'Bebida', 'Ninguno', 99, '2024-11-23 17:38:37', '0 kcal', 2),
(26, 'Zumo de Naranja', 'Jugo natural de naranja', 'Bebida', 'Ninguno', 80, '2024-09-18 12:00:00', '120 kcal', 3),
(27, 'Cerveza Artesanal', 'Cerveza de elaboración local', 'Bebida', 'Cebada', 27, '2024-09-25 14:00:00', '150 kcal', 4),
(28, 'Vino Tinto', 'Botella de vino tinto de la región de La Rioja', 'Bebida', 'Sulfitos', 18, '2024-09-22 15:30:00', '120 kcal por copa', 5),
(29, 'Té Verde', 'Infusión de té verde, sin azúcar', 'Bebida', 'Ninguno', 77, '2024-09-28 11:15:00', '0 kcal', 6),
(30, 'Café Espresso', 'Café fuerte servido en taza pequeña', 'Bebida', 'Ninguno', 68, '2024-10-01 09:30:00', '5 kcal', 7),
(31, 'Limonada', 'Jugo de limón fresco con agua y azúcar', 'Bebida', 'Ninguno', 86, '2024-09-10 13:00:00', '100 kcal', 8),
(32, 'Batido de Frutas', 'Batido natural de plátano y fresas', 'Bebida', 'Ninguno', 52, '2024-10-03 12:45:00', '200 kcal', 1),
(33, 'Tarta de Chocolate', 'Postre de chocolate con crema y galleta', 'Postre', 'Lácteos, Gluten', 25, '2024-10-04 15:00:00', '300 kcal', 5),
(34, 'Tiramisú', 'Postre italiano con café y queso mascarpone', 'Postre', 'Lácteos, Gluten', 15, '2024-09-20 10:00:00', '400 kcal', 6),
(35, 'Mousse de Frambuesa', 'Postre ligero de frambuesas y crema', 'Postre', 'Lácteos', 20, '2024-10-02 10:30:00', '250 kcal', 1),
(36, 'Pastel de Zanahoria', 'Pastel húmedo de zanahoria con nueces', 'Postre', 'Frutos secos, Lácteos', 15, '2024-09-30 14:00:00', '300 kcal', 2),
(37, 'Pavlova', 'Merengue crujiente con frutas y crema', 'Postre', 'Lácteos, Huevos', 10, '2024-10-05 12:15:00', '350 kcal', 3),
(38, 'Flan de Caramelo', 'Flan cremoso con salsa de caramelo', 'Postre', 'Lácteos', 25, '2024-09-25 11:00:00', '200 kcal', 4),
(39, 'Tarta de Limón', 'Tarta fresca de limón con merengue', 'Postre', 'Lácteos, Gluten', 20, '2024-11-23 17:36:34', '300 kcal', 5),
(40, 'Churros con Chocolate', 'Dulces fritos espolvoreados con azúcar, acompañados de chocolate', 'Postre', 'Gluten, Lácteos', 15, '2024-09-28 13:30:00', '400 kcal', 6),
(63, 'Jamón Asado', 'Jamón de cerdo asado al horno', 'Segundo Plato', 'Ninguno', 0, '2024-11-19 20:53:23', '200 kcal', 8);

-- --------------------------------------------------------


--
-- Estructura de tabla para la tabla `Pedido`
--

DROP TABLE IF EXISTS `Pedido`;
CREATE TABLE `Pedido` (
  `Id_Pedido` int NOT NULL,
  `Numero_Pedido` int NOT NULL,
  `Fecha_Pedido` datetime NOT NULL,
  `Coste_Total` float NOT NULL,
  `Observaciones` varchar(255) DEFAULT NULL,
  `Id_Proveedor` int NOT NULL,
  `Id_Usuario` int NOT NULL,
  `Estado_Pedido` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- RELACIONES PARA LA TABLA `Pedido`:
--   `Estado_Pedido`
--       `Estado_Pedido` -> `Id_Estado_Pedido`
--   `Id_Proveedor`
--       `Proveedor` -> `Id_Proveedor`
--   `Id_Usuario`
--       `Usuario_Registrado` -> `Id_Usuario`
--

--
-- Volcado de datos para la tabla `Pedido`
--

INSERT INTO `Pedido` (`Id_Pedido`, `Numero_Pedido`, `Fecha_Pedido`, `Coste_Total`, `Observaciones`, `Id_Proveedor`, `Id_Usuario`, `Estado_Pedido`) VALUES
(5, 872607, '2024-11-30 23:16:17', 8, '', 7, 1, 1),
(7, 793044, '2024-11-30 23:25:29', 30, '', 7, 1, 1),
(9, 554268, '2024-11-30 23:39:38', 12, '', 1, 1, 1),
(10, 735823, '2024-12-01 02:33:05', 4, '', 5, 1, 1),
(11, 933836, '2024-12-01 02:41:06', 0, '', 4, 1, 1),
(12, 958257, '2024-12-01 02:41:54', 20, '', 2, 1, 3),
(13, 894548, '2024-12-01 13:34:24', 350, '', 8, 1, 1),
(14, 918252, '2024-12-01 13:36:06', 240, '', 8, 1, 2),
(15, 971973, '2024-12-01 13:36:54', 160, '', 8, 1, 1),
(16, 178977, '2024-12-01 13:56:40', 10, '', 4, 1, 1),
(17, 929359, '2024-12-01 13:57:21', 6, '', 2, 1, 1),
(18, 552468, '2024-12-01 14:00:20', 30, '', 2, 1, 1),
(19, 750225, '2024-12-01 14:03:28', 5, '', 4, 1, 2),
(20, 217390, '2024-12-02 12:27:53', 20, '', 2, 1, 2),
(21, 470609, '2024-12-02 12:31:31', 20, '', 2, 1, 2),
(22, 170934, '2024-12-02 12:35:25', 10, '', 2, 1, 2),
(23, 322570, '2024-12-02 12:40:04', 10, '', 2, 1, 2),
(24, 455789, '2024-12-02 13:30:17', 5, '', 4, 1, 2),
(25, 855132, '2024-12-02 13:32:48', 45, '', 4, 1, 1),
(26, 391959, '2024-12-02 13:38:03', 200, '', 4, 1, 3),
(27, 736929, '2024-12-02 13:40:08', 300, '', 4, 1, 1),
(28, 254999, '2024-12-02 13:41:53', 500, '', 4, 1, 3),
(29, 144477, '2024-12-02 13:44:57', 1400, '', 4, 1, 3),
(30, 188702, '2024-12-02 13:47:23', 20, '', 2, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Pedido_Producto`
--

DROP TABLE IF EXISTS `Pedido_Producto`;
CREATE TABLE `Pedido_Producto` (
  `Id_Pedido_Producto` int NOT NULL,
  `Nombre_Producto` varchar(255) NOT NULL,
  `Cantidad` int NOT NULL,
  `Precio_Producto` float NOT NULL,
  `Fecha_Entrega` datetime NOT NULL,
  `Id_Pedido` int NOT NULL,
  `Id_Producto` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- RELACIONES PARA LA TABLA `Pedido_Producto`:
--   `Id_Pedido`
--       `Pedido` -> `Id_Pedido`
--   `Id_Producto`
--       `Producto` -> `Id_Producto`
--

--
-- Volcado de datos para la tabla `Pedido_Producto`
--

INSERT INTO `Pedido_Producto` (`Id_Pedido_Producto`, `Nombre_Producto`, `Cantidad`, `Precio_Producto`, `Fecha_Entrega`, `Id_Pedido`, `Id_Producto`) VALUES
(5, 'Canelones de Espinaca', 2, 4, '2024-12-04 00:00:00', 5, 7),
(7, 'Curry Vegetal', 5, 6, '2024-12-06 00:00:00', 7, 7),
(9, 'Ensalada César', 3, 4, '2024-12-04 00:00:00', 9, 1),
(10, 'Tartar de Salmón', 2, 2, '2024-12-17 00:00:00', 10, 5),
(11, 'Flan de Caramelo', 3, 0, '2024-12-19 00:00:00', 11, 4),
(12, 'Hummus con Pita', 5, 4, '2024-12-25 00:00:00', 12, 2),
(13, 'Jamón Asado', 50, 7, '2025-01-02 00:00:00', 13, 8),
(14, 'Jamón Asado', 30, 8, '2024-12-02 00:00:00', 14, 8),
(15, 'Lasagna de Carne', 20, 8, '2025-01-03 00:00:00', 15, 8),
(16, 'Bruschetta de Tomate', 5, 2, '2025-01-02 00:00:00', 16, 4),
(17, 'Pasta al Pesto', 3, 2, '2025-01-02 00:00:00', 17, 2),
(18, 'Filete de Salmón a la Parrilla', 5, 6, '2025-01-02 00:00:00', 18, 2),
(19, 'Gnocchi al Pomodoro', 5, 1, '2024-12-02 00:00:00', 19, 4),
(20, 'Agua Mineral', 10, 2, '2024-12-02 00:00:00', 20, 2),
(21, 'Agua Mineral', 10, 2, '2024-12-02 00:00:00', 21, 2),
(22, 'Agua Mineral', 10, 1, '2024-12-02 00:00:00', 22, 2),
(23, 'Agua Mineral', 10, 1, '2024-12-02 00:00:00', 23, 2),
(24, 'Cerveza Artesanal', 5, 1, '2024-12-02 00:00:00', 24, 4),
(25, 'Cerveza Artesanal', 15, 3, '2024-12-03 00:00:00', 25, 4),
(26, 'Cerveza Artesanal', 200, 1, '2024-12-03 00:00:00', 26, 4),
(27, 'Cerveza Artesanal', 150, 2, '2024-12-03 00:00:00', 27, 4),
(28, 'Cerveza Artesanal', 500, 1, '2024-12-03 00:00:00', 28, 4),
(29, 'Cerveza Artesanal', 700, 2, '2024-12-04 00:00:00', 29, 27),
(30, 'Agua Mineral', 10, 2, '2024-12-02 00:00:00', 30, 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Vuelo`
--

DROP TABLE IF EXISTS `Vuelo`;
CREATE TABLE `Vuelo` (
  `Id_Vuelo` int NOT NULL,
  `Numero_Vuelo` varchar(50) NOT NULL,
  `Id_Estado` int NOT NULL,
  `Id_Usuario` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- RELACIONES PARA LA TABLA `Vuelo`:
--   `Id_Estado`
--       `Estado_Vuelo` -> `Id_Estado`
--   `Id_Usuario`
--       `Usuario_Registrado` -> `Id_Usuario`
--

--
-- Volcado de datos para la tabla `Vuelo`
--

INSERT INTO `Vuelo` (`Id_Vuelo`, `Numero_Vuelo`, `Id_Estado`, `Id_Usuario`) VALUES
(41, 'AA123', 2, 1),
(43, 'CC789', 2, 1),
(44, 'DD321', 2, 2),
(46, 'FF987', 1, 2),
(48, 'HH546', 1, 2),
(61, 'JJ123', 1, NULL),
(62, 'KK456', 1, NULL),
(63, 'LL789', 1, NULL),
(64, 'MM012', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Vuelo_Pasajero`
--

DROP TABLE IF EXISTS `Vuelo_Pasajero`;
CREATE TABLE `Vuelo_Pasajero` (
  `Id_Vuelo_Pasajero` int NOT NULL,
  `Fecha_Salida` datetime NOT NULL,
  `Fecha_Llegada` datetime NOT NULL,
  `Origen` varchar(255) NOT NULL,
  `Destino` varchar(255) NOT NULL,
  `Asiento` varchar(100) NOT NULL,
  `Preferencias_Comida` varchar(255) NOT NULL,
  `Id_Vuelo` int NOT NULL,
  `Id_Pasajero` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- RELACIONES PARA LA TABLA `Vuelo_Pasajero`:
--   `Id_Pasajero`
--       `Pasajero` -> `Id_Pasajero`
--   `Id_Vuelo`
--       `Vuelo` -> `Id_Vuelo`
--

--
-- Volcado de datos para la tabla `Vuelo_Pasajero`
--

INSERT INTO `Vuelo_Pasajero` (`Id_Vuelo_Pasajero`, `Fecha_Salida`, `Fecha_Llegada`, `Origen`, `Destino`, `Asiento`, `Preferencias_Comida`, `Id_Vuelo`, `Id_Pasajero`) VALUES
(1, '2024-12-01 08:00:00', '2024-12-01 12:00:00', 'Buenos Aires', 'Berlín', 'Primera Clase', 'Vegetariana', 46, 21),
(2, '2024-12-01 08:00:00', '2024-12-01 12:00:00', 'Buenos Aires', 'Berlín', 'Bussiness', 'Sin Gluten', 46, 22),
(3, '2024-12-01 08:00:00', '2024-12-01 12:00:00', 'Buenos Aires', 'Berlín', 'Bussiness', 'Normal', 46, 23),
(4, '2024-12-01 08:00:00', '2024-12-01 12:00:00', 'Buenos Aires', 'Berlín', 'Primera Clase', 'Vegetariana', 46, 24),
(5, '2024-12-01 08:00:00', '2024-12-01 12:00:00', 'Buenos Aires', 'Berlín', 'Económica', 'Sin Lactosa', 46, 25),
(6, '2024-12-01 08:00:00', '2024-12-01 12:00:00', 'Buenos Aires', 'Berlín', 'Económica', 'Normal', 46, 26),
(7, '2024-12-01 08:00:00', '2024-12-01 12:00:00', 'Buenos Aires', 'Berlín', 'Económica', 'Vegetariana', 46, 27),
(8, '2024-12-02 14:00:00', '2024-12-02 18:00:00', 'Madrid', 'París', 'Bussiness', 'Normal', 48, 28),
(9, '2024-12-02 14:00:00', '2024-12-02 18:00:00', 'Madrid', 'París', 'Bussiness', 'Sin Gluten', 48, 29),
(10, '2024-12-02 14:00:00', '2024-12-02 18:00:00', 'Madrid', 'París', 'Económica', 'Vegetariana', 48, 30),
(11, '2024-12-02 14:00:00', '2024-12-02 18:00:00', 'Madrid', 'París', 'Primera Clase', 'Sin Lactosa', 48, 31),
(12, '2024-12-02 14:00:00', '2024-12-02 18:00:00', 'Madrid', 'París', 'Bussiness', 'Normal', 48, 32),
(13, '2024-12-02 14:00:00', '2024-12-02 18:00:00', 'Madrid', 'París', 'Económica', 'Vegetariana', 48, 33),
(14, '2024-12-02 14:00:00', '2024-12-02 18:00:00', 'Madrid', 'París', 'Económica', 'Sin Gluten', 48, 34),
(21, '2024-10-15 08:00:00', '2024-10-15 10:00:00', 'Madrid', 'Nueva York', 'Económica', 'Sin gluten', 41, 3),
(22, '2024-10-15 08:00:00', '2024-10-15 10:00:00', 'Madrid', 'Nueva York', 'Primera Clase', 'Sin lactosa', 41, 2),
(23, '2024-10-15 08:00:00', '2024-10-15 10:00:00', 'Madrid', 'Nueva York', 'Bussiness', 'Sin mariscos', 41, 10),
(24, '2024-10-15 08:00:00', '2024-10-15 10:00:00', 'Madrid', 'Nueva York', 'Económica', 'Ninguna', 41, 1),
(25, '2024-10-15 08:00:00', '2024-10-15 10:00:00', 'Madrid', 'Nueva York', 'Bussiness', 'Sin nueces', 41, 6),
(26, '2024-10-15 08:00:00', '2024-10-15 10:00:00', 'Madrid', 'Nueva York', 'Primera Clase', 'Sin lactosa', 41, 15),
(27, '2024-10-15 08:00:00', '2024-10-15 10:00:00', 'Madrid', 'Nueva York', 'Económica', 'Sin gluten', 41, 4),
(28, '2024-10-15 08:00:00', '2024-10-15 10:00:00', 'Madrid', 'Nueva York', 'Primera Clase', 'Sin lactosa', 41, 14),
(29, '2024-10-15 08:00:00', '2024-10-15 10:00:00', 'Madrid', 'Nueva York', 'Bussiness', 'Sin mariscos', 41, 11),
(30, '2024-10-24 18:00:00', '2024-10-24 20:45:00', 'Barcelona', 'Beijing', 'Económica', 'Ninguna', 43, 13),
(31, '2024-10-24 18:00:00', '2024-10-24 20:45:00', 'Barcelona', 'Beijing', 'Primera Clase', 'Sin lactosa', 43, 7),
(32, '2024-10-24 18:00:00', '2024-10-24 20:45:00', 'Barcelona', 'Beijing', 'Bussiness', 'Sin gluten', 43, 12),
(33, '2024-10-24 18:00:00', '2024-10-24 20:45:00', 'Barcelona', 'Beijing', 'Económica', 'Ninguna', 43, 5),
(34, '2024-10-28 19:00:00', '2024-10-28 21:30:00', 'Buenos Aires', 'Marsella', 'Primera Clase', 'Sin nueces', 44, 16),
(35, '2024-10-28 19:00:00', '2024-10-28 21:30:00', 'Buenos Aires', 'Marsella', 'Bussiness', 'Sin lactosa', 44, 9),
(36, '2024-10-28 19:00:00', '2024-10-28 21:30:00', 'Buenos Aires', 'Marsella', 'Económica', 'Sin mariscos', 44, 8),
(37, '2024-10-28 19:00:00', '2024-10-28 21:30:00', 'Buenos Aires', 'Marsella', 'Primera Clase', 'Ninguna', 44, 17),
(38, '2024-10-28 19:00:00', '2024-10-28 21:30:00', 'Buenos Aires', 'Marsella', 'Primera Clase', 'Sin mariscos', 44, 18),
(39, '2024-10-28 19:00:00', '2024-10-28 21:30:00', 'Buenos Aires', 'Marsella', 'Primera Clase', 'Sin lactosa', 44, 19),
(40, '2024-10-28 19:00:00', '2024-10-28 21:30:00', 'Buenos Aires', 'Marsella', 'Primera Clase', 'Ninguna', 44, 20),
(41, '2024-12-11 08:00:00', '2024-12-11 12:00:00', 'Madrid', 'Londres', 'Primera Clase', 'Vegetariana', 61, 35),
(42, '2024-12-11 08:00:00', '2024-12-11 12:00:00', 'Madrid', 'Londres', 'Económica', 'Sin Gluten', 61, 36),
(43, '2024-12-11 08:00:00', '2024-12-11 12:00:00', 'Madrid', 'Londres', 'Bussiness', 'Normal', 61, 37),
(44, '2024-12-11 08:00:00', '2024-12-11 12:00:00', 'Madrid', 'Londres', 'Primera Clase', 'Sin Lactosa', 61, 107),
(45, '2024-12-11 08:00:00', '2024-12-11 12:00:00', 'Madrid', 'Londres', 'Bussiness', 'Sin Mariscos', 61, 120),
(46, '2024-12-11 08:00:00', '2024-12-11 12:00:00', 'Madrid', 'Londres', 'Económica', 'Vegetariana', 61, 121),
(47, '2024-12-11 08:00:00', '2024-12-11 12:00:00', 'Madrid', 'Londres', 'Primera Clase', 'Normal', 61, 122),
(48, '2024-12-11 08:00:00', '2024-12-11 12:00:00', 'Madrid', 'Londres', 'Bussiness', 'Sin Lactosa', 61, 123),
(49, '2024-12-11 08:00:00', '2024-12-11 12:00:00', 'Madrid', 'Londres', 'Económica', 'Sin Lactosa', 61, 124),
(50, '2024-12-11 08:00:00', '2024-12-11 12:00:00', 'Madrid', 'Londres', 'Primera Clase', 'Sin Mariscos', 61, 125),
(51, '2024-12-11 08:00:00', '2024-12-11 12:00:00', 'Madrid', 'Londres', 'Económica', 'Normal', 61, 126),
(52, '2024-12-11 08:00:00', '2024-12-11 12:00:00', 'Madrid', 'Londres', 'Bussiness', 'Vegetariana', 61, 127),
(53, '2024-12-11 08:00:00', '2024-12-11 12:00:00', 'Madrid', 'Londres', 'Económica', 'Sin Gluten', 61, 128),
(54, '2024-12-11 08:00:00', '2024-12-11 12:00:00', 'Madrid', 'Londres', 'Económica', 'Sin Lactosa', 61, 129),
(55, '2024-12-11 08:00:00', '2024-12-11 12:00:00', 'Madrid', 'Londres', 'Primera Clase', 'Normal', 61, 130),
(56, '2024-12-14 11:00:00', '2024-12-14 16:30:00', 'Barcelona', 'Roma', 'Bussiness', 'Sin Mariscos', 64, 131),
(57, '2024-12-14 11:00:00', '2024-12-14 16:30:00', 'Barcelona', 'Roma', 'Económica', 'Vegetariana', 64, 132),
(58, '2024-12-14 11:00:00', '2024-12-14 16:30:00', 'Barcelona', 'Roma', 'Primera Clase', 'Normal', 64, 133),
(59, '2024-12-14 11:00:00', '2024-12-14 16:30:00', 'Barcelona', 'Roma', 'Bussiness', 'Sin Lactosa', 64, 134),
(60, '2024-12-14 11:00:00', '2024-12-14 16:30:00', 'Barcelona', 'Roma', 'Económica', 'Sin Lactosa', 64, 135),
(61, '2024-12-14 11:00:00', '2024-12-14 16:30:00', 'Barcelona', 'Roma', 'Primera Clase', 'Sin Mariscos', 64, 136),
(62, '2024-12-14 11:00:00', '2024-12-14 16:30:00', 'Barcelona', 'Roma', 'Económica', 'Normal', 64, 137),
(63, '2024-12-14 11:00:00', '2024-12-14 16:30:00', 'Barcelona', 'Roma', 'Bussiness', 'Vegetariana', 64, 138),
(64, '2024-12-14 11:00:00', '2024-12-14 16:30:00', 'Barcelona', 'Roma', 'Económica', 'Sin Gluten', 64, 139),
(65, '2024-12-14 11:00:00', '2024-12-14 16:30:00', 'Barcelona', 'Roma', 'Económica', 'Sin Lactosa', 64, 140),
(66, '2024-12-12 09:00:00', '2024-12-12 14:00:00', 'Barcelona', 'São Paulo', 'Económica', 'Sin Lactosa', 62, 38),
(67, '2024-12-12 09:00:00', '2024-12-12 14:00:00', 'Barcelona', 'São Paulo', 'Primera Clase', 'Sin Nueces', 62, 39),
(68, '2024-12-12 09:00:00', '2024-12-12 14:00:00', 'Barcelona', 'São Paulo', 'Bussiness', 'Sin Mariscos', 62, 40),
(69, '2024-12-12 09:00:00', '2024-12-12 14:00:00', 'Barcelona', 'São Paulo', 'Económica', 'Normal', 62, 108),
(70, '2024-12-12 09:00:00', '2024-12-12 14:00:00', 'Barcelona', 'São Paulo', 'Bussiness', 'Sin Gluten', 62, 109),
(71, '2024-12-13 10:00:00', '2024-12-13 15:30:00', 'Chicago', 'Madrid', 'Primera Clase', 'Vegetariana', 63, 110),
(72, '2024-12-13 10:00:00', '2024-12-13 15:30:00', 'Chicago', 'Madrid', 'Bussiness', 'Sin Gluten', 63, 111),
(73, '2024-12-13 10:00:00', '2024-12-13 15:30:00', 'Chicago', 'Madrid', 'Económica', 'Normal', 63, 112),
(74, '2024-12-13 10:00:00', '2024-12-13 15:30:00', 'Chicago', 'Madrid', 'Económica', 'Sin Lactosa', 63, 113),
(75, '2024-12-13 10:00:00', '2024-12-13 15:30:00', 'Chicago', 'Madrid', 'Primera Clase', 'Sin Mariscos', 63, 114),
(76, '2024-12-13 10:00:00', '2024-12-13 15:30:00', 'Chicago', 'Madrid', 'Bussiness', 'Vegetariana', 63, 115),
(77, '2024-12-13 10:00:00', '2024-12-13 15:30:00', 'Chicago', 'Madrid', 'Económica', 'Sin Gluten', 63, 116),
(78, '2024-12-13 10:00:00', '2024-12-13 15:30:00', 'Chicago', 'Madrid', 'Económica', 'Normal', 63, 117),
(79, '2024-12-13 10:00:00', '2024-12-13 15:30:00', 'Chicago', 'Madrid', 'Bussiness', 'Sin Lactosa', 63, 118),
(80, '2024-12-13 10:00:00', '2024-12-13 15:30:00', 'Chicago', 'Madrid', 'Económica', 'Vegetariana', 63, 119);

-- Estructura de tabla para la tabla `AsignacionProductos`
--

DROP TABLE IF EXISTS `AsignacionProductos`;
CREATE TABLE `AsignacionProductos` (
  `id` int NOT NULL,
  `Id_Vuelo` int NOT NULL,
  `Id_Pasajero` int NOT NULL,
  `Id_Producto` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- RELACIONES PARA LA TABLA `AsignacionProductos`:
--   `Id_Vuelo`
--       `Vuelo` -> `Id_Vuelo`
--   `Id_Pasajero`
--       `Pasajero` -> `Id_Pasajero`
--   `Id_Producto`
--       `Producto` -> `Id_Producto`
--

--
-- Volcado de datos para la tabla `AsignacionProductos`
--

INSERT INTO `AsignacionProductos` (`id`, `Id_Vuelo`, `Id_Pasajero`, `Id_Producto`) VALUES
(10, 41, 4, 9),
(11, 41, 4, 23),
(12, 41, 4, 29),
(13, 41, 15, 8),
(14, 41, 15, 22),
(15, 41, 15, 25),
(16, 41, 11, 1),
(17, 41, 11, 17),
(18, 41, 11, 28),
(19, 41, 1, 3),
(20, 41, 1, 19),
(21, 41, 1, 31),
(22, 41, 1, 3),
(23, 41, 1, 19),
(24, 41, 1, 31),
(25, 41, 3, 2),
(26, 41, 3, 18),
(27, 41, 3, 32),
(28, 41, 2, 9),
(29, 41, 2, 23),
(30, 41, 2, 25),
(31, 41, 14, 12),
(32, 41, 14, 19),
(33, 41, 14, 28),
(43, 43, 5, 1),
(44, 43, 5, 17),
(45, 43, 5, 32),
(46, 43, 12, 2),
(47, 43, 12, 21),
(48, 43, 12, 25),
(49, 41, 6, 10),
(50, 41, 6, 20),
(51, 41, 6, 25),
(52, 43, 13, 8),
(53, 43, 13, 20),
(54, 43, 13, 30),
(55, 43, 7, 5),
(56, 43, 7, 17),
(57, 43, 7, 27),
(58, 41, 10, 6),
(59, 41, 10, 21),
(60, 41, 10, 30),
(61, 44, 9, 11),
(62, 44, 9, 22),
(63, 44, 9, 27),
(64, 44, 19, 5),
(65, 44, 19, 17),
(66, 44, 19, 25),
(67, 44, 16, 10),
(68, 44, 16, 23),
(69, 44, 16, 29),
(70, 44, 20, 1),
(71, 44, 20, 20),
(72, 44, 20, 25),
(73, 44, 8, 5),
(74, 44, 8, 19),
(75, 44, 8, 31),
(76, 44, 18, 3),
(77, 44, 18, 23),
(78, 44, 18, 25),
(79, 44, 17, 6),
(80, 44, 17, 17),
(81, 44, 17, 25),
(82, 46, 26, 2),
(83, 46, 26, 21),
(84, 46, 26, 32),
(85, 46, 23, 1),
(86, 46, 23, 17),
(87, 46, 23, 25),
(88, 46, 24, 13),
(89, 46, 24, 20),
(90, 46, 24, 29),
(91, 46, 27, 16),
(92, 46, 27, 21),
(93, 46, 27, 25);

-- --------------------------------------------------------


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `AsignacionProductos`
--
ALTER TABLE `AsignacionProductos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_vuelo_id` (`Id_Vuelo`),
  ADD KEY `idx_pasajero_id` (`Id_Pasajero`),
  ADD KEY `idx_producto_id` (`Id_Producto`);

--
-- Indices de la tabla `Estado_Pedido`
--
ALTER TABLE `Estado_Pedido`
  ADD PRIMARY KEY (`Id_Estado_Pedido`);

--
-- Indices de la tabla `Estado_Vuelo`
--
ALTER TABLE `Estado_Vuelo`
  ADD PRIMARY KEY (`Id_Estado`);

--
-- Indices de la tabla `Pasajero`
--
ALTER TABLE `Pasajero`
  ADD PRIMARY KEY (`Id_Pasajero`),
  ADD UNIQUE KEY `Dni` (`Dni`);

--
-- Indices de la tabla `Pedido`
--
ALTER TABLE `Pedido`
  ADD PRIMARY KEY (`Id_Pedido`),
  ADD UNIQUE KEY `Numero_Pedido` (`Numero_Pedido`),
  ADD KEY `fk_Pedido_Proveedor` (`Id_Proveedor`),
  ADD KEY `fk_Pedido_Usuario_Registrado` (`Id_Usuario`),
  ADD KEY `fk_Pedido_Estado_Pedido` (`Estado_Pedido`),
  ADD KEY `idx_Fecha_Pedido` (`Fecha_Pedido`);

--
-- Indices de la tabla `Pedido_Producto`
--
ALTER TABLE `Pedido_Producto`
  ADD PRIMARY KEY (`Id_Pedido_Producto`),
  ADD KEY `fk_Pedido_Producto_Producto` (`Id_Producto`),
  ADD KEY `fk_Pedido_Producto_Pedido` (`Id_Pedido`);

--
-- Indices de la tabla `Producto`
--
ALTER TABLE `Producto`
  ADD PRIMARY KEY (`Id_Producto`),
  ADD UNIQUE KEY `Nombre` (`Nombre`),
  ADD KEY `fk_Producto_Proveedor` (`Id_Proveedor`);

--
-- Indices de la tabla `Proveedor`
--
ALTER TABLE `Proveedor`
  ADD PRIMARY KEY (`Id_Proveedor`);

--
-- Indices de la tabla `Registro_Log`
--
ALTER TABLE `Registro_Log`
  ADD PRIMARY KEY (`Id_Registro_Log`),
  ADD KEY `fk_Registro_Log_Usuario_Registrado` (`Id_Usuario`);

--
-- Indices de la tabla `Usuario_Registrado`
--
ALTER TABLE `Usuario_Registrado`
  ADD PRIMARY KEY (`Id_Usuario`),
  ADD UNIQUE KEY `Nombre` (`Nombre`);

--
-- Indices de la tabla `Vuelo`
--
ALTER TABLE `Vuelo`
  ADD PRIMARY KEY (`Id_Vuelo`),
  ADD UNIQUE KEY `Numero_Vuelo` (`Numero_Vuelo`),
  ADD KEY `fk_Vuelo_Estado` (`Id_Estado`),
  ADD KEY `fk_Vuelo_Usuario_Registrado` (`Id_Usuario`);

--
-- Indices de la tabla `Vuelo_Pasajero`
--
ALTER TABLE `Vuelo_Pasajero`
  ADD PRIMARY KEY (`Id_Vuelo_Pasajero`),
  ADD KEY `fk_VUelo_Pasajero_Vuelo` (`Id_Vuelo`),
  ADD KEY `fk_Vuelo_Pasajero_Pasajero` (`Id_Pasajero`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `AsignacionProductos`
--
ALTER TABLE `AsignacionProductos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT de la tabla `Estado_Pedido`
--
ALTER TABLE `Estado_Pedido`
  MODIFY `Id_Estado_Pedido` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `Estado_Vuelo`
--
ALTER TABLE `Estado_Vuelo`
  MODIFY `Id_Estado` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `Pasajero`
--
ALTER TABLE `Pasajero`
  MODIFY `Id_Pasajero` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT de la tabla `Pedido`
--
ALTER TABLE `Pedido`
  MODIFY `Id_Pedido` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `Pedido_Producto`
--
ALTER TABLE `Pedido_Producto`
  MODIFY `Id_Pedido_Producto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `Producto`
--
ALTER TABLE `Producto`
  MODIFY `Id_Producto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `Proveedor`
--
ALTER TABLE `Proveedor`
  MODIFY `Id_Proveedor` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `Registro_Log`
--
ALTER TABLE `Registro_Log`
  MODIFY `Id_Registro_Log` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Usuario_Registrado`
--
ALTER TABLE `Usuario_Registrado`
  MODIFY `Id_Usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `Vuelo`
--
ALTER TABLE `Vuelo`
  MODIFY `Id_Vuelo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `Vuelo_Pasajero`
--
ALTER TABLE `Vuelo_Pasajero`
  MODIFY `Id_Vuelo_Pasajero` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `AsignacionProductos`
--
ALTER TABLE `AsignacionProductos`
  ADD CONSTRAINT `AsignacionProductos_ibfk_1` FOREIGN KEY (`Id_Vuelo`) REFERENCES `Vuelo` (`Id_Vuelo`) ON DELETE CASCADE,
  ADD CONSTRAINT `AsignacionProductos_ibfk_2` FOREIGN KEY (`Id_Pasajero`) REFERENCES `Pasajero` (`Id_Pasajero`) ON DELETE CASCADE,
  ADD CONSTRAINT `AsignacionProductos_ibfk_3` FOREIGN KEY (`Id_Producto`) REFERENCES `Producto` (`Id_Producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `Pedido`
--
ALTER TABLE `Pedido`
  ADD CONSTRAINT `fk_Pedido_Estado_Pedido` FOREIGN KEY (`Estado_Pedido`) REFERENCES `Estado_Pedido` (`Id_Estado_Pedido`),
  ADD CONSTRAINT `fk_Pedido_Proveedor` FOREIGN KEY (`Id_Proveedor`) REFERENCES `Proveedor` (`Id_Proveedor`),
  ADD CONSTRAINT `fk_Pedido_Usuario_Registrado` FOREIGN KEY (`Id_Usuario`) REFERENCES `Usuario_Registrado` (`Id_Usuario`);

--
-- Filtros para la tabla `Pedido_Producto`
--
ALTER TABLE `Pedido_Producto`
  ADD CONSTRAINT `fk_Pedido_Producto_Pedido` FOREIGN KEY (`Id_Pedido`) REFERENCES `Pedido` (`Id_Pedido`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_Pedido_Producto_Producto` FOREIGN KEY (`Id_Producto`) REFERENCES `Producto` (`Id_Producto`);

--
-- Filtros para la tabla `Producto`
--
ALTER TABLE `Producto`
  ADD CONSTRAINT `fk_Producto_Proveedor` FOREIGN KEY (`Id_Proveedor`) REFERENCES `Proveedor` (`Id_Proveedor`);

--
-- Filtros para la tabla `Registro_Log`
--
ALTER TABLE `Registro_Log`
  ADD CONSTRAINT `fk_Registro_Log_Usuario_Registrado` FOREIGN KEY (`Id_Usuario`) REFERENCES `Usuario_Registrado` (`Id_Usuario`);

--
-- Filtros para la tabla `Vuelo`
--
ALTER TABLE `Vuelo`
  ADD CONSTRAINT `fk_Vuelo_Estado` FOREIGN KEY (`Id_Estado`) REFERENCES `Estado_Vuelo` (`Id_Estado`),
  ADD CONSTRAINT `fk_Vuelo_Usuario_Registrado` FOREIGN KEY (`Id_Usuario`) REFERENCES `Usuario_Registrado` (`Id_Usuario`);

--
-- Filtros para la tabla `Vuelo_Pasajero`
--
ALTER TABLE `Vuelo_Pasajero`
  ADD CONSTRAINT `fk_Vuelo_Pasajero_Pasajero` FOREIGN KEY (`Id_Pasajero`) REFERENCES `Pasajero` (`Id_Pasajero`),
  ADD CONSTRAINT `fk_VUelo_Pasajero_Vuelo` FOREIGN KEY (`Id_Vuelo`) REFERENCES `Vuelo` (`Id_Vuelo`);
COMMIT;