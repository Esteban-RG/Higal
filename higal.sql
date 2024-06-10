-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 10-06-2024 a las 02:25:38
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `higal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Administrador`
--

CREATE TABLE `Administrador` (
  `idAdministrador` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apPaterno` varchar(100) DEFAULT NULL,
  `apMaterno` varchar(100) DEFAULT NULL,
  `contrasenha` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Administrador`
--

INSERT INTO `Administrador` (`idAdministrador`, `nombre`, `apPaterno`, `apMaterno`, `contrasenha`) VALUES
(1, 'admin', 'admin', 'admin', '$2y$10$ozvmdu8ytkKe.KfZbzzfE.c.kEP1k3krJMw53KrLtpxeP1tEkrX/.'),
(4, 'Esteban', 'Reyes', 'Gutierrez', '$2y$10$jQzCytPbuzUMNkR8gcVrEeaAo0eukUYdL8rhYyCK.UlqQs17FNCX.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Categoria`
--

CREATE TABLE `Categoria` (
  `idCategoria` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Categoria`
--

INSERT INTO `Categoria` (`idCategoria`, `nombre`) VALUES
(5, 'Postres'),
(6, 'Bebidas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cliente`
--

CREATE TABLE `Cliente` (
  `idCliente` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Cliente`
--

INSERT INTO `Cliente` (`idCliente`, `nombre`, `correo`) VALUES
(7, 'Ricardo Esteban', 'ricardoespace@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Menu`
--

CREATE TABLE `Menu` (
  `idPlatillo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Mesa`
--

CREATE TABLE `Mesa` (
  `idMesa` int(11) NOT NULL,
  `asientos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Mesa`
--

INSERT INTO `Mesa` (`idMesa`, `asientos`) VALUES
(6, 4),
(7, 4),
(8, 4),
(9, 4),
(10, 8),
(11, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Platillo`
--

CREATE TABLE `Platillo` (
  `idPlatillo` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `idCategoria` int(11) DEFAULT NULL,
  `idAdministrador` int(11) DEFAULT NULL,
  `imagen` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Reservacion`
--

CREATE TABLE `Reservacion` (
  `idReservacion` int(11) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `cantPersonas` int(11) DEFAULT NULL,
  `idMesa` int(11) DEFAULT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `estado` varchar(15) DEFAULT NULL,
  `idAdministrador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Reservacion`
--

INSERT INTO `Reservacion` (`idReservacion`, `fecha`, `cantPersonas`, `idMesa`, `idCliente`, `estado`, `idAdministrador`) VALUES
(27, '2024-06-12 18:20:00', 4, 7, 7, 'Pendiente', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Administrador`
--
ALTER TABLE `Administrador`
  ADD PRIMARY KEY (`idAdministrador`);

--
-- Indices de la tabla `Categoria`
--
ALTER TABLE `Categoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `Cliente`
--
ALTER TABLE `Cliente`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indices de la tabla `Menu`
--
ALTER TABLE `Menu`
  ADD KEY `idPlatillo` (`idPlatillo`);

--
-- Indices de la tabla `Mesa`
--
ALTER TABLE `Mesa`
  ADD PRIMARY KEY (`idMesa`);

--
-- Indices de la tabla `Platillo`
--
ALTER TABLE `Platillo`
  ADD PRIMARY KEY (`idPlatillo`),
  ADD KEY `idCategoria` (`idCategoria`),
  ADD KEY `idAdministrador` (`idAdministrador`);

--
-- Indices de la tabla `Reservacion`
--
ALTER TABLE `Reservacion`
  ADD PRIMARY KEY (`idReservacion`),
  ADD KEY `idMesa` (`idMesa`),
  ADD KEY `idCliente` (`idCliente`),
  ADD KEY `idAdministrador` (`idAdministrador`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Administrador`
--
ALTER TABLE `Administrador`
  MODIFY `idAdministrador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `Categoria`
--
ALTER TABLE `Categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `Cliente`
--
ALTER TABLE `Cliente`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `Mesa`
--
ALTER TABLE `Mesa`
  MODIFY `idMesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `Platillo`
--
ALTER TABLE `Platillo`
  MODIFY `idPlatillo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `Reservacion`
--
ALTER TABLE `Reservacion`
  MODIFY `idReservacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Menu`
--
ALTER TABLE `Menu`
  ADD CONSTRAINT `Menu_ibfk_1` FOREIGN KEY (`idPlatillo`) REFERENCES `Platillo` (`idPlatillo`);

--
-- Filtros para la tabla `Platillo`
--
ALTER TABLE `Platillo`
  ADD CONSTRAINT `Platillo_ibfk_1` FOREIGN KEY (`idCategoria`) REFERENCES `Categoria` (`idCategoria`),
  ADD CONSTRAINT `Platillo_ibfk_2` FOREIGN KEY (`idAdministrador`) REFERENCES `Administrador` (`idAdministrador`);

--
-- Filtros para la tabla `Reservacion`
--
ALTER TABLE `Reservacion`
  ADD CONSTRAINT `Reservacion_ibfk_1` FOREIGN KEY (`idMesa`) REFERENCES `Mesa` (`idMesa`),
  ADD CONSTRAINT `Reservacion_ibfk_2` FOREIGN KEY (`idCliente`) REFERENCES `Cliente` (`idCliente`),
  ADD CONSTRAINT `Reservacion_ibfk_3` FOREIGN KEY (`idAdministrador`) REFERENCES `Administrador` (`idAdministrador`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
