-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 10-06-2024 a las 18:23:06
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
-- Estructura de tabla para la tabla `bills`
--

DROP TABLE IF EXISTS `bills`;
CREATE TABLE IF NOT EXISTS `bills` (
  `ID` varchar(100) NOT NULL,
  `id_user` varchar(100) NOT NULL,
  `items` int NOT NULL,
  `price` int NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `bills`
--

INSERT INTO `bills` (`ID`, `id_user`, `items`, `price`) VALUES
('21-139986', '21', 4, 900000),
('21-223127', '21', 1, 150000),
('22-477640', '22', 3, 600000),
('21-159974', '21', 2, 1234000),
('2-904565', '2', 4, 1000000),
('3-312104', '3', 5, 540000),
('3-004938', '3', 1, 300000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_vivienda` varchar(100) NOT NULL,
  `quantity` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT '1',
  `bill_id` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`) USING BTREE,
  KEY `id_vivienda` (`id_vivienda`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cart`
--

INSERT INTO `cart` (`id`, `id_user`, `id_vivienda`, `quantity`, `isactive`, `bill_id`) VALUES
(4, 21, '13', '2', 0, '21-139986'),
(7, 21, '15', '2', 0, '21-139986'),
(8, 21, '2', '2', 0, '21-094317'),
(9, 21, '13', '1', 0, '21-223127'),
(10, 22, '15', '1', 0, '22-477640'),
(11, 22, '13', '2', 0, '22-477640'),
(12, 21, '1', '1', 0, '21-159974'),
(13, 21, '8', '1', 0, '21-159974'),
(14, 2, '20', '4', 0, '2-904565'),
(15, 3, '3', '3', 0, '3-312104'),
(16, 3, '23', '2', 0, '3-312104'),
(17, 3, '15', '1', 0, '3-004938');

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
-- Estructura de tabla para la tabla `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `idvivienda` varchar(100) NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`idvivienda`,`id_user`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `likes`
--

INSERT INTO `likes` (`idvivienda`, `id_user`) VALUES
('1', 2),
('13', 2),
('3', 2),
('8', 3),
('1', 4),
('12', 4),
('2', 4),
('23', 4),
('9', 4),
('3', 5),
('6', 5),
('13', 21),
('13', 22),
('20', 22),
('8', 22);

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
-- Estructura de tabla para la tabla `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `price` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `services`
--

INSERT INTO `services` (`id`, `type`, `stock`, `price`) VALUES
(1, 'limpieza', 40, '2.50'),
(2, 'jardineria', 25, '3.5'),
(3, 'mantenimiento electrico 24H', 12, '5'),
(4, 'fontaneria 24h', 23, '5.0'),
(5, 'mantenimiento piscina', 6, '4.35');

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
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `type_user` varchar(50) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `token_email` varchar(200) NOT NULL,
  `activate` tinyint(1) NOT NULL,
  `fails` int NOT NULL,
  `OTP` varchar(10) NOT NULL,
  `origin` varchar(100) NOT NULL,
  `UID` varchar(100) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `email`, `type_user`, `avatar`, `token_email`, `activate`, `fails`, `OTP`, `origin`, `UID`) VALUES
(1, 'patata', '$2y$12$jfWdFcxrlluc4wsndgT/R.hQ0UO2OkmAtxaGNmxu/gR9Lb7ggb.JW', 'patata@gmail.com', 'client', 'https://i.pravatar.cc/500?u=785fefe6795bcbd014704229986df1ac', '', 1, 0, '000000', 'local', ''),
(2, 'usuario1', '$2y$12$M6/jrBHIDFTxG0DKEwZYse8IQ/GV/fCRM5eCyMTNBeRTHnV9Ls/8i', 'usuario1@gmail.com', 'client', 'https://i.pravatar.cc/500?u=084352b66b58c811e491346111edaa24', '', 1, 0, '000000', 'local', ''),
(3, 'usuario2', '$2y$12$m21TdKtHZUx7pUYy6uX0oODLf/k0gICAw40yeA99UvnecdX28zQQW', 'usuario2@gmail.com', 'client', '/uploads/avatar/thomas-morse-r-5-mb-11-p-268-D3K0GC.jpg', '', 1, 0, '000000', 'local', ''),
(4, 'usuario3', '$2y$12$.X70VMbhxGe0rn.aN21O5uEGh9Ljg6MOfWfJsQjPHQr7DeM2ex6BS', 'usuario3@gmail.com', 'client', 'https://i.pravatar.cc/500?u=ebd4046c0fa2a2ebdb6773311bce5ef1', '', 1, 0, '000000', 'local', ''),
(5, 'usuario4', '$2y$12$yuZ2xGEwY1bDVsjOazpRq.bE6KGoJ.Pttvs3AcMEVhKBSdO/pfsqC', 'usuario4@gmail.com', 'client', 'https://i.pravatar.cc/500?u=c965762f0c00ab3b65f7306d1fbcb042', '', 1, 0, '000000', 'local', ''),
(6, 'estoesunusuariomuylargopo', '$2y$12$CBGjxtPNy03om3nFInklIeWTa1jvIs/MLMwlDgdR6I2NkypwArM8e', 'estoestodomuylargo@gmail.com', 'client', 'https://i.pravatar.cc/500?u=c541a2851191311745509436e95d46f0', '', 1, 0, '000000', 'local', ''),
(21, 'Rafael', '$2y$12$jJgqzXCKQEaB.kzBd.U3h..Y2o4liulfM.U5WCGehLPMLWuHrmIv2', 'rafajorgis@gmail.com', 'client', '/uploads/avatar/perfil.png', '', 1, 0, '903452', 'local', ''),
(22, 'rafajorgis', '', 'rafajorgis@gmail.com_google', 'client', 'https://lh3.googleusercontent.com/a/ACg8ocJ5x7BhfFbaQNiEks2cxab5FbTmV_MIxFDH_VcA-oAuD0xCGQ=s96-c', '', 1, 0, '000000', 'google', '3iEVrvk12DbkvMAbMO8nPSU1TG62');

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
  `stock` int NOT NULL DEFAULT '0',
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

INSERT INTO `vivienda` (`idvivienda`, `nameviv`, `tipo`, `categoria`, `operation`, `city`, `superficie`, `price`, `ahorro`, `images`, `visitas`, `lat`, `longi`, `stock`) VALUES
('1', 'pisito en la playa', '4', '3', '1', '1', '200', '684000', '1', '4', 24, '38.8231', '-0.6158', 25),
('10', 'Casa rural', '4', '4', '5', '4', '200', '350000', '4', '3', 58, '38.9897', '-0.5366', 3),
('11', 'Apartamento luminoso', '2', '1', '1', '2', '70', '120000', '1', '5', 34, '38.8991', '-0.5024', 2),
('12', 'Villa junto al mar', '5', '2', '3', '3', '400', '780000', '1', '3', 69, ' 38.8803', '-0.5901', 6),
('13', 'Piso reformado', '1', '3', '4', '4', '90', '150000', '3', '4', 190, '38.991000', '-0.519972', 68),
('14', 'Casa adosada familiar', '3', '4', '5', '5', '250', '420000', '4', '2', 103, '38.8665', '-0.5089', 7),
('15', 'Casa de campo', '1', '1', '1', '1', '180', '300000', '1', '1', 38, '38.8213', '-0.6140', 8),
('16', 'Piso luminoso', '4', '2', '2', '2', '100', '150000', '2', '2', 20, '38.9001', '-0.5032', 12),
('17', 'Chalet adosado', '3', '3', '3', '3', '250', '500000', '3', '3', 122, '38.8888', '-0.5900', 1),
('18', 'Apartamento moderno', '2', '4', '4', '4', '80', '200000', '4', '4', 42, '38.9888', '-0.5222', 0),
('19', 'Villa con piscina', '5', '1', '5', '5', '400', '800000', '5', '1', 50, '38.8777', '-0.5090', 4),
('2', 'chalecito en aielo\r\n', '2', '1', '3', '3', '62', '79000', '2', '2', 102, ' 38.8783', '-0.5905', 12),
('20', 'Piso céntrico', '1', '2', '1', '1', '120', '250000', '1', '2', 72, '38.8199', '-0.6149', 8),
('21', 'Chalet en las montañas', '3', '3', '2', '2', '300', '600000', '2', '3', 71, '38.9000', '-0.5000', 5),
('22', 'Casa antigua restaurada', '4', '4', '3', '3', '200', '400000', '3', '4', 96, '38.8899', '-0.5888', 0),
('23', 'Apartamento con vistas', '2', '1', '4', '4', '90', '180000', '4', '1', 128, '38.9889', '-0.5210', 10),
('24', 'Piso económico', '1', '2', '4', '5', '60', '100000', '5', '2', 100, '38.8188', '-0.6138', 2),
('3', 'muy sosa', '3', '2', '5', '2', '150', '60000', '3', '2', 17, '38.9032', '-0.4980', 1),
('4', 'yipicayei', '5', '4', '4', '4', '100', '20000', '2', '1', 70, '38.9878', '-0.5236', 0),
('5', 'coso', '1', '4', '2', '2', '6000', '9800000', '5', '1', 8, '38.9035', '-0.4985', 8),
('6', 'casa en bufali', '1', '2', '3', '5', '150', '200000', '1', '3', 7, '38.8668', '-0.5099', 0),
('7', 'Apartamento acogedor', '1', '1', '1', '1', '120', '250000', '4', '5', 16, '38.8190', '-0.6146', 0),
('8', 'Chalet moderno', '3', '3', '2', '2', '300', '550000', '3', '3', 13, '38.9038', '-0.4982', 3),
('9', 'Piso céntrico', '2', '2', '4', '3', '80', '180000', '5', '4', 2, '38.8679', '-0.5910', 0);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`idvivienda`) REFERENCES `vivienda` (`idvivienda`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

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
