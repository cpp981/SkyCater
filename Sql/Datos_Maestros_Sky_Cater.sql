-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 28-10-2024 a las 20:18:37
-- Versión del servidor: 8.0.39-0ubuntu0.22.04.1
-- Versión de PHP: 8.1.2-1ubuntu2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `Sky_Cater`
--
CREATE DATABASE IF NOT EXISTS `Sky_Cater` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `Sky_Cater`;

--
-- Volcado de datos para la tabla `Estado_Pedido`
--

INSERT INTO `Estado_Pedido` (`Id_Estado_Pedido`, `Estado_Pedido`) VALUES
(1, 'Pendiente'),
(2, 'Entregado'),
(3, 'Cancelado');

--
-- Volcado de datos para la tabla `Estado_Vuelo`
--

INSERT INTO `Estado_Vuelo` (`Id_Estado`, `Estado`) VALUES
(1, 'Pendiente'),
(2, 'Gestionado');

--
-- Volcado de datos para la tabla `Pasajero`
--

INSERT INTO `Pasajero` (`Id_Pasajero`, `Nombre`, `Apellido`, `Dni`, `Fecha_Nacimiento`, `Intolerancias`, `Nacionalidad`) VALUES
(1, 'Juan', 'Pérez', 'DNI12345678', '1990-01-15', 'Ninguna', 'Argentina'),
(2, 'María', 'Gómez', 'DNI23456789', '1985-05-30', 'Lactosa', 'Chile'),
(3, 'Luis', 'Martínez', 'DNI34567890', '1992-10-20', 'Gluten', 'México'),
(4, 'Ana', 'López', 'DNI45678901', '1988-07-25', 'Ninguna', 'España'),
(5, 'Carlos', 'Sánchez', 'DNI56789012', '1975-12-12', 'Nueces', 'Colombia'),
(6, 'Sofía', 'Ramírez', 'DNI67890123', '1995-03-14', 'Ninguna', 'Perú'),
(7, 'Pedro', 'Torres', 'DNI78901234', '1980-11-05', 'Gluten', 'Uruguay'),
(8, 'Lucía', 'Cruz', 'DNI89012345', '1993-08-22', 'Ninguna', 'Bolivia'),
(9, 'Diego', 'Hernández', 'DNI90123456', '1982-09-18', 'Mariscos', 'Paraguay'),
(10, 'Valentina', 'Jiménez', 'DNI01234567', '1991-04-28', 'Lactosa', 'Ecuador'),
(11, 'Javier', 'Fernández', 'DNI12345679', '1987-01-01', 'Ninguna', 'Argentina'),
(12, 'Carmen', 'Muñoz', 'DNI23456780', '1984-02-14', 'Lactosa', 'Chile'),
(13, 'Gabriel', 'Rojas', 'DNI34567881', '1990-03-21', 'Gluten', 'México'),
(14, 'Natalia', 'Vázquez', 'DNI45678982', '1983-04-30', 'Nueces', 'España'),
(15, 'Andrés', 'Castillo', 'DNI56789083', '1992-05-15', 'Ninguna', 'Colombia'),
(16, 'Isabel', 'Reyes', 'DNI67890184', '1991-06-19', 'Gluten', 'Perú'),
(17, 'Ricardo', 'Paredes', 'DNI78901285', '1985-07-27', 'Ninguna', 'Uruguay'),
(18, 'Patricia', 'Salazar', 'DNI89012386', '1988-08-02', 'Mariscos', 'Bolivia'),
(19, 'Felipe', 'Mora', 'DNI90123487', '1993-09-09', 'Lactosa', 'Paraguay'),
(20, 'Julia', 'Castro', 'DNI01234588', '1986-10-16', 'Ninguna', 'Ecuador');

--
-- Volcado de datos para la tabla `Producto`
--

INSERT INTO `Producto` (`Id_Producto`, `Nombre`, `Descripcion`, `Categoria`, `Alergenos`, `Stock_Disponible`, `Fecha_Actualizacion`, `Valor_Nutricional`, `Id_Proveedor`) VALUES
(1, 'Ensalada César', 'Ensalada con lechuga romana, pollo, crutones y aderezo César', 'Entrante', 'Lácteos, Gluten', 50, '2024-10-01 10:00:00', '250 kcal', 1),
(2, 'Hummus con Pita', 'Pasta de garbanzos acompañada de pan pita', 'Entrante', 'Sésamo', 45, '2024-09-15 12:30:00', '200 kcal', 2),
(3, 'Sopa de Tomate', 'Sopa cremosa de tomate con albahaca', 'Entrante', 'Lácteos', 60, '2024-09-20 15:45:00', '150 kcal', 3),
(4, 'Bruschetta de Tomate', 'Tostadas con tomate, albahaca y ajo', 'Entrante', 'Gluten', 40, '2024-10-05 09:15:00', '120 kcal', 4),
(5, 'Tartar de Salmón', 'Tartar de salmón fresco con aguacate', 'Entrante', 'Pescado', 30, '2024-08-30 14:00:00', '300 kcal', 5),
(6, 'Rollitos de Primavera', 'Rollos de verduras frescas con salsa agridulce', 'Entrante', 'Gluten, Soya', 35, '2024-10-10 11:00:00', '150 kcal', 6),
(7, 'Mini Quiches', 'Pequeñas tartas rellenas de verduras y queso', 'Entrante', 'Lácteos, Gluten', 50, '2024-09-25 08:30:00', '220 kcal', 7),
(8, 'Antipasto Italiano', 'Selección de embutidos, quesos y aceitunas', 'Entrante', 'Lácteos', 20, '2024-10-08 17:00:00', '350 kcal', 8),
(9, 'Sushi Variado', 'Rollos de sushi con pescado y vegetales', 'Primer Plato', 'Pescado, Sésamo', 30, '2024-10-01 12:00:00', '350 kcal', 1),
(10, 'Pasta al Pesto', 'Pasta con salsa de albahaca y piñones', 'Primer Plato', 'Frutos secos', 35, '2024-09-18 13:30:00', '350 kcal', 2),
(11, 'Rissotto de Setas', 'Arroz cremoso con setas y parmesano', 'Primer Plato', 'Lácteos', 40, '2024-09-22 11:45:00', '400 kcal', 3),
(12, 'Gnocchi al Pomodoro', 'Pasta de patata con salsa de tomate', 'Primer Plato', 'Lácteos, Gluten', 25, '2024-10-02 16:15:00', '300 kcal', 4),
(13, 'Ensalada de Quinoa', 'Quinoa con verduras y aderezo de limón', 'Primer Plato', 'Ninguno', 50, '2024-10-07 14:30:00', '250 kcal', 5),
(14, 'Tortilla Española', 'Tortilla de patatas y cebolla', 'Primer Plato', 'Huevo', 40, '2024-09-30 09:00:00', '200 kcal', 6),
(15, 'Canelones de Espinaca', 'Canelones rellenos de espinaca y ricotta', 'Primer Plato', 'Lácteos, Gluten', 30, '2024-09-28 10:45:00', '350 kcal', 7),
(16, 'Ceviche de Pescado', 'Pescado marinado en limón con cebolla y cilantro', 'Primer Plato', 'Pescado', 20, '2024-10-04 13:15:00', '200 kcal', 8),
(17, 'Pollo Teriyaki', 'Pollo marinado en salsa teriyaki, servido con arroz', 'Segundo Plato', 'Soya', 40, '2024-09-20 18:30:00', '400 kcal', 1),
(18, 'Filete de Salmón a la Parrilla', 'Salmón a la parrilla con verduras asadas', 'Segundo Plato', 'Pescado', 35, '2024-09-15 12:00:00', '500 kcal', 2),
(19, 'Lomo de Cerdo a la Mostaza', 'Lomo de cerdo con salsa de mostaza y miel', 'Segundo Plato', 'Ninguno', 30, '2024-09-25 19:00:00', '450 kcal', 3),
(20, 'Vegetales Asados', 'Mezcla de vegetales de temporada asados', 'Segundo Plato', 'Ninguno', 50, '2024-10-10 17:15:00', '200 kcal', 4),
(21, 'Paella Valenciana', 'Arroz con mariscos y pollo al estilo español', 'Segundo Plato', 'Mariscos, Gluten', 20, '2024-09-22 11:30:00', '600 kcal', 5),
(22, 'Bife de Chorizo', 'Carne de res asada con chimichurri', 'Segundo Plato', 'Ninguno', 25, '2024-09-10 14:45:00', '700 kcal', 6),
(23, 'Curry Vegetal', 'Curry de verduras con arroz basmati', 'Segundo Plato', 'Ninguno', 40, '2024-10-02 13:00:00', '350 kcal', 7),
(24, 'Lasagna de Carne', 'Lasagna con carne, tomate y queso', 'Segundo Plato', 'Lácteos, Gluten', 30, '2024-10-01 16:00:00', '600 kcal', 8),
(25, 'Agua Mineral', 'Agua embotellada sin gas', 'Bebida', 'Ninguno', 100, '2024-10-01 10:00:00', '0 kcal', 2),
(26, 'Zumo de Naranja', 'Jugo natural de naranja', 'Bebida', 'Ninguno', 80, '2024-09-18 12:00:00', '120 kcal', 3),
(27, 'Cerveza Artesanal', 'Cerveza de elaboración local', 'Bebida', 'Cebada', 30, '2024-09-25 14:00:00', '150 kcal', 4),
(28, 'Vino Tinto', 'Botella de vino tinto de la región de La Rioja', 'Bebida', 'Sulfitos', 20, '2024-09-22 15:30:00', '120 kcal por copa', 5),
(29, 'Té Verde', 'Infusión de té verde, sin azúcar', 'Bebida', 'Ninguno', 80, '2024-09-28 11:15:00', '0 kcal', 6),
(30, 'Café Espresso', 'Café fuerte servido en taza pequeña', 'Bebida', 'Ninguno', 70, '2024-10-01 09:30:00', '5 kcal', 7),
(31, 'Limonada', 'Jugo de limón fresco con agua y azúcar', 'Bebida', 'Ninguno', 90, '2024-09-10 13:00:00', '100 kcal', 8),
(32, 'Batido de Frutas', 'Batido natural de plátano y fresas', 'Bebida', 'Ninguno', 55, '2024-10-03 12:45:00', '200 kcal', 1),
(33, 'Tarta de Chocolate', 'Postre de chocolate con crema y galleta', 'Postre', 'Lácteos, Gluten', 25, '2024-10-04 15:00:00', '300 kcal', 5),
(34, 'Tiramisú', 'Postre italiano con café y queso mascarpone', 'Postre', 'Lácteos, Gluten', 15, '2024-09-20 10:00:00', '400 kcal', 6),
(35, 'Mousse de Frambuesa', 'Postre ligero de frambuesas y crema', 'Postre', 'Lácteos', 20, '2024-10-02 10:30:00', '250 kcal', 1),
(36, 'Pastel de Zanahoria', 'Pastel húmedo de zanahoria con nueces', 'Postre', 'Frutos secos, Lácteos', 15, '2024-09-30 14:00:00', '300 kcal', 2),
(37, 'Pavlova', 'Merengue crujiente con frutas y crema', 'Postre', 'Lácteos, Huevos', 10, '2024-10-05 12:15:00', '350 kcal', 3),
(38, 'Flan de Caramelo', 'Flan cremoso con salsa de caramelo', 'Postre', 'Lácteos', 25, '2024-09-25 11:00:00', '200 kcal', 4),
(39, 'Tarta de Limón', 'Tarta fresca de limón con merengue', 'Postre', 'Lácteos, Gluten', 20, '2024-10-01 16:30:00', '300 kcal', 5),
(40, 'Churros con Chocolate', 'Dulces fritos espolvoreados con azúcar, acompañados de chocolate', 'Postre', 'Gluten, Lácteos', 15, '2024-09-28 13:30:00', '400 kcal', 6);

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

--
-- Volcado de datos para la tabla `Usuario_Registrado`
--

INSERT INTO `Usuario_Registrado` (`Id_Usuario`, `Nombre`, `Pass`) VALUES
(1, 'carlos', '$2y$10$uMilfFU.bXPRfljFuoSIhOp6yi4ikPfaUpyyCeUvQHxCMXY3f/Gxi'),
(2, 'admin', '$2y$10$lbWPeRA3zm0Pm5o9bK7Ko.3/o/y0qgPBugZ0n4UTRH8Wxk7qVti4.');

--
-- Volcado de datos para la tabla `Vuelo`
--

INSERT INTO `Vuelo` (`Id_Vuelo`, `Numero_Vuelo`, `Id_Estado`, `Id_Usuario`) VALUES
(41, 'AA123', 1, 1),
(42, 'BB456', 2, 1),
(43, 'CC789', 1, 1),
(44, 'DD321', 1, 2),
(45, 'EE654', 2, 2),
(46, 'FF987', 1, 2),
(47, 'GG213', 2, 2),
(48, 'HH546', 1, 2),
(49, 'II879', 2, 2),
(50, 'JJ135', 1, 1),
(51, 'KK246', 2, 1),
(52, 'LL357', 1, 2),
(53, 'MM468', 2, 2),
(54, 'NN579', 1, 1),
(55, 'OO680', 2, 1),
(56, 'PP791', 1, 1),
(57, 'QQ802', 1, 1),
(58, 'RR913', 2, 1),
(59, 'SS024', 1, 1),
(60, 'TT135', 2, 1);

--
-- Volcado de datos para la tabla `Vuelo_Pasajero`
--

INSERT INTO `Vuelo_Pasajero` (`Id_Vuelo_Pasajero`, `Fecha_Salida`, `Fecha_Llegada`, `Origen`, `Destino`, `Asiento`, `Preferencias_Comida`, `Id_Vuelo`, `Id_Pasajero`) VALUES
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
(40, '2024-10-28 19:00:00', '2024-10-28 21:30:00', 'Buenos Aires', 'Marsella', 'Primera Clase', 'Ninguna', 44, 20);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
