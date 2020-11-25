-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 06-11-2020 a las 12:00:18
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


-- Base de datos: `agenda`

CREATE DATABASE IF NOT EXISTS `liga` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `liga`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

DROP TABLE IF EXISTS `equipo`;
CREATE TABLE IF NOT EXISTS `equipo` (
                                           `id` int(11) NOT NULL AUTO_INCREMENT,
                                           `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
                                           PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;


-- Volcado de datos para la tabla `categoria`


INSERT INTO `equipo` (`id`, `nombre`) VALUES
(1, 'Depor'),
(2, 'Sociedad Deportiva'),
(3, 'Atletico'),
(4, 'Union deportiva');

-- --------------------------------------------------------


-- Estructura de tabla para la tabla `persona`


DROP TABLE IF EXISTS `jugador`;
CREATE TABLE IF NOT EXISTS `jugador` (
                                         `id` int(11) NOT NULL AUTO_INCREMENT,
                                         `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
                                         `apellidos` varchar(80) DEFAULT NULL,
                                         `posicion` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
                                         `lesionado` tinyint(1) NOT NULL DEFAULT 0,
                                         `equipoId` int(11) NOT NULL,
                                         PRIMARY KEY (`id`),
                                         KEY `fk_equipoIdIdx` (`equipoId`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;


-- Volcado de datos para la tabla `persona`


INSERT INTO `jugador` (`id`, `nombre`, `apellidos`, `posicion`, `lesionado`, `equipoId`) VALUES
(1, 'Pepe', NULL, '600111222', 0, 3),
(2, 'Mario', NULL, '688444222', 1, 1),
(3, 'Jose', NULL, '611222333', 0, 1),
(5, 'Laura', NULL, '666777888', 1, 2),
(6, 'Menganito', NULL, '699888777', 0, 3),
(11, 'Menganito', NULL, 'Fulánez', 0, 4);


-- Restricciones para tablas volcadas



-- Filtros para la tabla `persona`

ALTER TABLE `jugador`
    ADD CONSTRAINT `fk_equipoId` FOREIGN KEY (`equipoId`) REFERENCES `equipo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;
