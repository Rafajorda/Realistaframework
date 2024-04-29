-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 27-03-2024 a las 10:47:29
-- Versión del servidor: 8.2.0
-- Versión de PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `realistav3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ahorro`
--

DROP TABLE IF EXISTS `ahorro`;
CREATE TABLE IF NOT EXISTS `ahorro` (
  `idahorro` varchar(100) NOT NULL,
  `nameahorro` varchar(100) NOT NULL,
  `imgahorro` varchar(1000) NOT NULL,
  PRIMARY KEY (`idahorro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ahorro`
--

INSERT INTO `ahorro` (`idahorro`, `nameahorro`, `imgahorro`) VALUES
('1', 'placas solares', 'view/img/ahorro/placas.jpg'),
('2', 'termica', 'view/img/ahorro/agua.jpg'),
('3', 'colector agua lluvia', 'view/img/ahorro/lluvia.jpg'),
('4', 'aerogenerador', 'view/img/ahorro/aire.jpg'),
('5', 'domotica', 'view/img/ahorro/domotica.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `idcat` varchar(100) NOT NULL,
  `namecat` varchar(100) NOT NULL,
  `imgcat` varchar(100) NOT NULL,
  `visit` int NOT NULL,
  PRIMARY KEY (`idcat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcat`, `namecat`, `imgcat`, `visit`) VALUES
('1', 'pool', 'view/img/categoria/pool.jpg', 953),
('2', 'terrace', 'view/img/categoria/terrace.jpg', 85),
('3', 'new construction', 'view/img/categoria/newconstruction.jpg', 36),
('4', 'design', 'view/img/categoria/design.jpg', 125);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `city`
--

DROP TABLE IF EXISTS `city`;
CREATE TABLE IF NOT EXISTS `city` (
  `idcity` varchar(100) NOT NULL,
  `namecity` varchar(100) NOT NULL,
  `imgcity` varchar(1000) NOT NULL,
  `visit` int NOT NULL,
  PRIMARY KEY (`idcity`),
  KEY `idcity` (`idcity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `city`
--

INSERT INTO `city` (`idcity`, `namecity`, `imgcity`, `visit`) VALUES
('1', 'ontinyent', 'view/img/city/ontinyent.jpg', 938),
('2', 'alfarrasi', 'view/img/city/alfarrasi.jpg', 652),
('3', 'aielo', 'view/img/city/aielo.jpg', 669),
('4', 'xativa', 'view/img/city/xativa.jpg', 17),
('5', 'bufali', 'view/img/city/bufali.jpg 	', 32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `idimages` varchar(100) NOT NULL,
  `nameimages` varchar(100) NOT NULL,
  `imgimages` varchar(1000) NOT NULL,
  PRIMARY KEY (`idimages`),
  KEY `idimages` (`idimages`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `images`
--

INSERT INTO `images` (`idimages`, `nameimages`, `imgimages`) VALUES
('1', 'piso1', 'view/img/images/1/piso11.jpg:view/img/images/1/piso12.jpg:view/img/images/1/piso13.jpg:view/img/imageS/1/piso14.jpg:view/img/images/1/piso15.jpg'),
('2', 'chalet1', 'view/img/images/2/casa1.jpg:view/img/images/2/casa2.jpg:view/img/images/2/casa3.jpg:view/img/images/2/casa4.jpg:view/img/images/2/casa5.jpg'),
('3', 'bufali3', 'view/img/images/3/bufali1.jpg:view/img/images/3/bufali2.jpg:view/img/images/3/bufali3.jpg:view/img/images/3/bufali4.jpg:view/img/images/3/bufali5.jpg'),
('4', 'piso2', 'view/img/images/4/piso21.jpg:view/img/images/4/piso22.jpg:view/img/images/4/piso23.jpg:view/img/images/4/piso24.jpg:view/img/images/4/piso25.jpg'),
('5', 'apartamento', 'view/img/images/5/apartamento1.jpg:view/img/images/5/apartamento2.jpg:view/img/images/5/apartamento3.jpg:view/img/images/5/apartamento4.jpg:view/img/images/5/apartamento5.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operation`
--

DROP TABLE IF EXISTS `operation`;
CREATE TABLE IF NOT EXISTS `operation` (
  `idop` varchar(100) NOT NULL,
  `nameop` varchar(100) NOT NULL,
  `imgop` varchar(1000) NOT NULL,
  PRIMARY KEY (`idop`),
  KEY `idop` (`idop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `operation`
--

INSERT INTO `operation` (`idop`, `nameop`, `imgop`) VALUES
('1', 'compra', 'view/img/operation/buy.jpg'),
('2', 'alquiler', 'view/img/operation/rent.jpg'),
('3', 'opcion a compra', 'view/img/operation/opcioncompra.jpg'),
('4', 'compartir', 'view/img/operation/share.jpg'),
('5', 'habitacion', 'view/img/operation/bed.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

DROP TABLE IF EXISTS `tipo`;
CREATE TABLE IF NOT EXISTS `tipo` (
  `idtipo` varchar(100) NOT NULL,
  `nametipo` varchar(100) NOT NULL,
  `imgtipo` varchar(1000) NOT NULL,
  `visit` int NOT NULL,
  PRIMARY KEY (`idtipo`),
  KEY `idtipo` (`idtipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`idtipo`, `nametipo`, `imgtipo`, `visit`) VALUES
('1', 'casa', 'view/img/tipo/house.jpg', 942),
('2', 'chalet', 'view/img/tipo/chalet.jpg', 60),
('3', 'habitacion', 'view/img/tipo/bedroom.jpg', 69),
('4', 'piso', 'view/img/tipo/flat.jpg', 127),
('5', 'parking', 'view/img/tipo/parking.jpg', 76);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vivienda`
--

DROP TABLE IF EXISTS `vivienda`;
CREATE TABLE IF NOT EXISTS `vivienda` (
  `idvivienda` varchar(100) NOT NULL,
  `nameviv` varchar(100) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `operation` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `superficie` varchar(100) NOT NULL,
  `price` varchar(1000) NOT NULL,
  `ahorro` varchar(100) NOT NULL,
  `images` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `visitas` int NOT NULL,
  `lat` varchar(100) NOT NULL,
  `longi` varchar(100) NOT NULL,
  PRIMARY KEY (`idvivienda`),
  UNIQUE KEY `idvivienda` (`idvivienda`),
  KEY `tipo` (`tipo`),
  KEY `categoria` (`categoria`),
  KEY `operation` (`operation`),
  KEY `city` (`city`),
  KEY `images` (`images`),
  KEY `ahorro` (`ahorro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `vivienda`
--

INSERT INTO `vivienda` (`idvivienda`, `nameviv`, `tipo`, `categoria`, `operation`, `city`, `superficie`, `price`, `ahorro`, `images`, `visitas`, `lat`, `longi`) VALUES
('1', 'pisito en la playa', '4', '3', '1', '1', '200', '684000', '1', '4', 13, '38.8231', '-0.6158'),
('10', 'Casa rural', '4', '4', '5', '4', '200', '350000', '4', '3', 56, '38.9897', '-0.5366'),
('11', 'Apartamento luminoso', '2', '1', '1', '2', '70', '120000', '2', '5', 33, '38.8991', '-0.5024'),
('12', 'Villa junto al mar', '5', '2', '3', '3', '400', '780000', '1', '3', 68, ' 38.8803', '-0.5901'),
('13', 'Piso reformado', '1', '3', '4', '4', '90', '150000', '3', '4', 90, '38.991000', '-0.519972'),
('14', 'Casa adosada familiar', '3', '4', '5', '5', '250', '420000', '4', '2', 101, '38.8665', '-0.5089'),
('2', 'chalecito en aielo\r\n', '2', '1', '3', '3', '62', '79000', '2', '2', 101, ' 38.8783', '-0.5905'),
('3', 'muy sosa', '3', '2', '5', '2', '150', '60000', '3', '2', 3, '38.9032', '-0.4980'),
('4', 'yipicayei', '5', '4', '4', '4', '100', '20000', '2', '1', 69, '38.9878', '-0.5236'),
('5', 'coso', '1', '4', '2', '2', '6000', '9800000', '5', '1', 8, '38.9035', '-0.4985'),
('6', 'casa en bufali', '1', '2', '3', '5', '150', '200000', '4', '3', 5, '38.8668', '-0.5099'),
('7', 'Apartamento acogedor', '1', '1', '1', '1', '120', '250000', '1', '5', 12, '38.8190', '-0.6146'),
('8', 'Chalet moderno', '3', '3', '2', '2', '300', '550000', '3', '3', 7, '38.9038', '-0.4982'),
('9', 'Piso céntrico', '2', '2', '4', '3', '80', '180000', '5', '4', 2, '38.8679', '-0.5910');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `vivienda`
--
ALTER TABLE `vivienda`
  ADD CONSTRAINT `vivienda_ibfk_1` FOREIGN KEY (`tipo`) REFERENCES `tipo` (`idtipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vivienda_ibfk_2` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`idcat`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vivienda_ibfk_3` FOREIGN KEY (`operation`) REFERENCES `operation` (`idop`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vivienda_ibfk_4` FOREIGN KEY (`city`) REFERENCES `city` (`idcity`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vivienda_ibfk_5` FOREIGN KEY (`images`) REFERENCES `images` (`idimages`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vivienda_ibfk_6` FOREIGN KEY (`ahorro`) REFERENCES `ahorro` (`idahorro`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
