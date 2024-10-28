-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 28-10-2024 a las 20:17:14
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Estado_Pedido`
--

DROP TABLE IF EXISTS `Estado_Pedido`;
CREATE TABLE `Estado_Pedido` (
  `Id_Estado_Pedido` int NOT NULL,
  `Estado_Pedido` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Estado_Vuelo`
--

DROP TABLE IF EXISTS `Estado_Vuelo`;
CREATE TABLE `Estado_Vuelo` (
  `Id_Estado` int NOT NULL,
  `Estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

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
  `Id_Pedido` int NOT NULL,
  `Id_Producto` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `Stock_Disponible` int NOT NULL,
  `Fecha_Actualizacion` datetime DEFAULT NULL,
  `Valor_Nutricional` varchar(255) DEFAULT NULL,
  `Id_Proveedor` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Registro_Log`
--

DROP TABLE IF EXISTS `Registro_Log`;
CREATE TABLE `Registro_Log` (
  `Id_Registro_Log` int NOT NULL,
  `Fecha` datetime NOT NULL,
  `Id_Usuario` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Vuelo_Producto`
--

DROP TABLE IF EXISTS `Vuelo_Producto`;
CREATE TABLE `Vuelo_Producto` (
  `Id_Vuelo_Producto` int NOT NULL,
  `Cantidad_Comida` int NOT NULL,
  `Tipo_Comida` varchar(255) NOT NULL,
  `Id_Vuelo` int NOT NULL,
  `Id_Producto` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Índices para tablas volcadas
--

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
  ADD KEY `fk_Pedido_Producto_Pedido` (`Id_Pedido`),
  ADD KEY `fk_Pedido_Producto_Producto` (`Id_Producto`);

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
  ADD PRIMARY KEY (`Id_Usuario`);

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
-- Indices de la tabla `Vuelo_Producto`
--
ALTER TABLE `Vuelo_Producto`
  ADD PRIMARY KEY (`Id_Vuelo_Producto`),
  ADD KEY `fk_Vuelo_Producto_Vuelo` (`Id_Vuelo`),
  ADD KEY `fk_Vuelo_Producto_Producto` (`Id_Producto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Estado_Pedido`
--
ALTER TABLE `Estado_Pedido`
  MODIFY `Id_Estado_Pedido` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Estado_Vuelo`
--
ALTER TABLE `Estado_Vuelo`
  MODIFY `Id_Estado` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Pasajero`
--
ALTER TABLE `Pasajero`
  MODIFY `Id_Pasajero` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Pedido`
--
ALTER TABLE `Pedido`
  MODIFY `Id_Pedido` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Pedido_Producto`
--
ALTER TABLE `Pedido_Producto`
  MODIFY `Id_Pedido_Producto` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Producto`
--
ALTER TABLE `Producto`
  MODIFY `Id_Producto` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Proveedor`
--
ALTER TABLE `Proveedor`
  MODIFY `Id_Proveedor` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Registro_Log`
--
ALTER TABLE `Registro_Log`
  MODIFY `Id_Registro_Log` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Usuario_Registrado`
--
ALTER TABLE `Usuario_Registrado`
  MODIFY `Id_Usuario` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Vuelo`
--
ALTER TABLE `Vuelo`
  MODIFY `Id_Vuelo` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Vuelo_Pasajero`
--
ALTER TABLE `Vuelo_Pasajero`
  MODIFY `Id_Vuelo_Pasajero` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Vuelo_Producto`
--
ALTER TABLE `Vuelo_Producto`
  MODIFY `Id_Vuelo_Producto` int NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

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
  ADD CONSTRAINT `fk_Pedido_Producto_Pedido` FOREIGN KEY (`Id_Pedido`) REFERENCES `Pedido` (`Id_Pedido`),
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

--
-- Filtros para la tabla `Vuelo_Producto`
--
ALTER TABLE `Vuelo_Producto`
  ADD CONSTRAINT `fk_Vuelo_Producto_Producto` FOREIGN KEY (`Id_Producto`) REFERENCES `Producto` (`Id_Producto`),
  ADD CONSTRAINT `fk_Vuelo_Producto_Vuelo` FOREIGN KEY (`Id_Vuelo`) REFERENCES `Vuelo` (`Id_Vuelo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
