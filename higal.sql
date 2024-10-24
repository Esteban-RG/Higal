-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 24-10-2024 a las 00:25:55
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
-- Base de datos: `higal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `idAdministrador` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `apPaterno` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `apMaterno` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contrasenha` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`idAdministrador`, `nombre`, `apPaterno`, `apMaterno`, `contrasenha`) VALUES
(1, 'admin', 'admin', 'admin', '$2y$10$ozvmdu8ytkKe.KfZbzzfE.c.kEP1k3krJMw53KrLtpxeP1tEkrX/.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `nombre`) VALUES
(15, 'Entradas'),
(16, 'Segundos'),
(20, 'Fuertes'),
(21, 'Botana'),
(22, 'Postres'),
(23, 'Ensaladas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idCliente` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `correo` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `galeria`
--

CREATE TABLE `galeria` (
  `idImagen` int NOT NULL,
  `ruta` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `galeria`
--

INSERT INTO `galeria` (`idImagen`, `ruta`, `nombre`) VALUES
(3, 'assets/imgs/galeria/1.png', ''),
(4, 'assets/imgs/galeria/2.png', ''),
(5, 'assets/imgs/galeria/3.png', ''),
(6, 'assets/imgs/galeria/4.png', ''),
(7, 'assets/imgs/galeria/5.png', ''),
(8, 'assets/imgs/galeria/6.png', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa`
--

CREATE TABLE `mesa` (
  `idMesa` int NOT NULL,
  `asientos` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mesa`
--

INSERT INTO `mesa` (`idMesa`, `asientos`) VALUES
(6, 4),
(7, 4),
(8, 4),
(9, 4),
(10, 8),
(11, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platillo`
--

CREATE TABLE `platillo` (
  `idPlatillo` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `idCategoria` int DEFAULT NULL,
  `idAdministrador` int DEFAULT NULL,
  `imagen` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `visibilidad` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `platillo`
--

INSERT INTO `platillo` (`idPlatillo`, `nombre`, `descripcion`, `precio`, `idCategoria`, `idAdministrador`, `imagen`, `visibilidad`) VALUES
(24, 'Pasta del día', 'Los ingredientes varían cada semana, pregunta a nuestros\r\nasociados.', 85, 16, 1, 'uploads/Pasta.avif', 1),
(26, 'Taco Ensenada', 'Filete de pescado en tempura de garbanzo, acompañado de un\r\nguacamole rústico, con una ensalada de col morada bañada en\r\nmayonesa de chile habanero, pico de gallo contemporáneo y\r\nlimón Eureka.', 85, 20, 1, 'uploads/taco ensenada.jpeg', 1),
(27, 'Alitas', 'BBQ\r\nOriginal hot\r\nMango habanero\r\nBufalo\r\n10 Alitas, acompañadas de papas a la francesa, bastones de\r\napio y zanahoria y aderezo ranch.', 170, 21, 1, 'uploads/alitas.avif', 1),
(28, 'Strudel de manzana con helado', 'Deliciosa masa hojaldre con un relleno de manzana flameada y\r\naromatizada con licor de ciruela, acompañado de helado.', 89, 22, 1, 'uploads/strudedl.png', 1),
(29, 'Camarones en tortilla y queso', 'Los camarones en tortilla y queso son un platillo donde los camarones sazonados se cocinan y se colocan en tortillas calientes, cubiertos con queso derretido. Se sirven con guarniciones como salsa, aguacate y cilantro, ofreciendo una combinación deliciosa', 120, 20, 1, 'uploads/camarones en toritlla y queso.jpg', 1),
(30, 'Aros de cebolla', 'Los aros de cebolla son un aperitivo crujiente y delicioso. Se preparan cortando cebollas en rodajas, sumergiéndolas en una masa o empanizado, y luego friéndolas hasta que estén doradas. Son perfectos para acompañar hamburguesas, sándwiches o como snack, ', 40, 21, 1, 'uploads/Aros de cebolla.jpg', 1),
(31, 'Ensalada parrilera', 'Mix de lechugas y espinaca con vegetales blanqueados, rollitos de pechuga de pollo a la parrilla, jitomates cherry, mix de nueces, crotones y aderezo.', 85, 23, 1, 'uploads/ensalada con pechuga.avif', 1),
(33, 'Taco Ensenada', 'Filete de pescado en tempura de garbanzo, acompañado de un\r\nguacamole rústico, con una ensalada de col morada bañada en\r\nmayonesa de chile habanero, pico de gallo contemporáneo y\r\nlimón Eureka.\r\n', 80, 20, 1, 'uploads/Filete de pescado con guacamole, y col morada.jpg', 1),
(34, 'Fresas que endulzan el alma', 'Fresas cubiertas de chocolate obscuro y blanco acompañadas de colchones de plátano árabe bañados en compota de frutos rojos y crema ácida con menta.\r\n', 89, 22, 1, 'uploads/fresas con platano y chocolate.jpg', 1),
(35, 'Mini gorditas michoacanas (Orden 3 pzas)', 'Chicharron prensado en salsa de tres chiles.\r\nSuadero de res macerado.\r\nCochinita pibil y carnitas (por temporada).\r\nAcompañadas con bombones de crema ácida, queso ahumado,\r\njulianas de lechuga italiana y salsa verde cruda con menta.\r\n', 70, 15, 1, 'uploads/gordita de carnitas (por temporada).jpg', 1),
(36, 'Hamburguesa de arrachera', '200g de arrachera marinada y cocinada a la parrilla, queso cheddar, manchego y Oaxaca, crocante tocino ahumado, lechuga italiana, jitomate, cebolla morada, pepinillos, ensalada de col morada y el aderezo de casa, cama de frijoles yucatecos, guacamole rust', 160, 21, 1, 'uploads/hamburguesa de arrachera.jpg', 1),
(37, 'Hamburguesa texana', '200g de carne de res cocinada a la parrilla, queso cheddar, manchego y Oaxaca, crocante tocino ahumado, lechuga italiana, jitomate, cebolla morada, pepinillos, ensalada de col morada y el aderezo de casa. Como guarnición papas a la francesa y aros de cebo', 130, 21, 1, 'uploads/Hamburguesa texana.avif', 1),
(38, 'Papas a la francesa (250g)', 'Las papas a la francesa, también conocidas como papas fritas, son un aperitivo o acompañamiento popular. Se preparan cortando papas en tiras delgadas, que luego se fríen hasta quedar doradas y crujientes. Una porción de 250 gramos ofrece una cantidad gene', 49, 21, 1, 'uploads/papas a la francesa.webp', 1),
(39, 'Pastel de queso', 'Montado sobre pasta sablée, decorado con frutos, bañado en salsa de frambuesa, acompañado de helado.\r\n', 92, 22, 1, 'uploads/pastel de queso.avif', 1),
(40, 'Strudel de manzana con helado', 'Deliciosa masa hojaldre con un relleno de manzana flameada y aromatizada con licor de ciruela, acompañado de helado.\r\n', 89, 22, 1, 'uploads/Pludel de manzana con helado.jpg', 1),
(41, 'Mini quesadil as (Orden 3 Pza)', 'Tinga de pollo ahumada.\r\nChampiñones aromatizados con epazote.\r\nChicharrón prensado en salsa de tres chiles.\r\nAcompañadas con bombones de crema ácida, queso, julianas\r\nde lechuga italiana y salsa verde cruda con menta.\r\n', 55, 15, 1, 'uploads/quesadilla champiñones.jpg', 1),
(42, 'Mini sopecitos (Orden 5 pzas)', 'Tinga de pollo ahumada.\r\nSuadero de res macerado.\r\nChicharrón prensado en salsa de tres chiles.\r\nMasa de maíz nixtamalizada, cama de frijol refrito, bombones\r\nde crema ácida, queso ahumado y salsa verde cruda con\r\nmenta', 65, 15, 1, 'uploads/sopes de tinga aumada.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promocion`
--

CREATE TABLE `promocion` (
  `idPromocion` int NOT NULL,
  `ruta` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `promocion`
--

INSERT INTO `promocion` (`idPromocion`, `ruta`) VALUES
(5, 'assets/imgs/promocion/1.png'),
(6, 'assets/imgs/promocion/2.png'),
(7, 'assets/imgs/promocion/3.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservacion`
--

CREATE TABLE `reservacion` (
  `idReservacion` int NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `cantPersonas` int DEFAULT NULL,
  `idMesa` int DEFAULT NULL,
  `idCliente` int DEFAULT NULL,
  `estado` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `idAdministrador` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`idAdministrador`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indices de la tabla `galeria`
--
ALTER TABLE `galeria`
  ADD PRIMARY KEY (`idImagen`);

--
-- Indices de la tabla `mesa`
--
ALTER TABLE `mesa`
  ADD PRIMARY KEY (`idMesa`);

--
-- Indices de la tabla `platillo`
--
ALTER TABLE `platillo`
  ADD PRIMARY KEY (`idPlatillo`),
  ADD KEY `idCategoria` (`idCategoria`),
  ADD KEY `idAdministrador` (`idAdministrador`);

--
-- Indices de la tabla `promocion`
--
ALTER TABLE `promocion`
  ADD PRIMARY KEY (`idPromocion`);

--
-- Indices de la tabla `reservacion`
--
ALTER TABLE `reservacion`
  ADD PRIMARY KEY (`idReservacion`),
  ADD KEY `idMesa` (`idMesa`),
  ADD KEY `idCliente` (`idCliente`),
  ADD KEY `idAdministrador` (`idAdministrador`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `idAdministrador` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idCliente` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `galeria`
--
ALTER TABLE `galeria`
  MODIFY `idImagen` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `mesa`
--
ALTER TABLE `mesa`
  MODIFY `idMesa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `platillo`
--
ALTER TABLE `platillo`
  MODIFY `idPlatillo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `promocion`
--
ALTER TABLE `promocion`
  MODIFY `idPromocion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `reservacion`
--
ALTER TABLE `reservacion`
  MODIFY `idReservacion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `platillo`
--
ALTER TABLE `platillo`
  ADD CONSTRAINT `platillo_ibfk_1` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`),
  ADD CONSTRAINT `platillo_ibfk_2` FOREIGN KEY (`idAdministrador`) REFERENCES `administrador` (`idAdministrador`);

--
-- Filtros para la tabla `reservacion`
--
ALTER TABLE `reservacion`
  ADD CONSTRAINT `reservacion_ibfk_1` FOREIGN KEY (`idMesa`) REFERENCES `mesa` (`idMesa`),
  ADD CONSTRAINT `reservacion_ibfk_2` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`),
  ADD CONSTRAINT `reservacion_ibfk_3` FOREIGN KEY (`idAdministrador`) REFERENCES `administrador` (`idAdministrador`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
