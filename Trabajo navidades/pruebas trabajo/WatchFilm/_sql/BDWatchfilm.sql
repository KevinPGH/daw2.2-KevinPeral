-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-12-2020 a las 15:13:57
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET
time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `watchfilm`
--
CREATE
DATABASE IF NOT EXISTS `watchfilm` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE
`watchfilm`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista`
--

DROP TABLE IF EXISTS `lista`;
CREATE TABLE `lista`
(
    `id`        int(11) NOT NULL,
    `nombre`    varchar(40) COLLATE utf8_spanish_ci NOT NULL,
    `usuarioId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `lista`
--

INSERT INTO `lista` (`id`, `nombre`, `usuarioId`)
VALUES (1, 'Favoritos', 1),
       (2, 'Favoritos', 2),
       (3, 'Favoritos', 3),
       (4, 'Pendientes', 1),
       (5, 'Pendientes', 2),
       (6, 'Pendientes', 3),
       (7, 'Vistas', 1),
       (8, 'Vistas', 2),
       (9, 'Vistas', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listausuariopeliculas`
--

DROP TABLE IF EXISTS `listausuariopeliculas`;
CREATE TABLE `listausuariopeliculas`
(
    `peliculaId` int(11) NOT NULL,
    `listaId`    int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `listausuariopeliculas`
--

INSERT INTO `listausuariopeliculas` (`peliculaId`, `listaId`)
VALUES (1, 1),
       (1, 2),
       (1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pelicula`
--

DROP TABLE IF EXISTS `pelicula`;
CREATE TABLE `pelicula`
(
    `id`           int(11) NOT NULL,
    `nombre`       varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
    `director`     varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
    `genero`       varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
    `anio`         int(4) NOT NULL,
    `puntuacion`   int(11) NOT NULL,
    `plataformaId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pelicula`
--

INSERT INTO `pelicula` (`id`, `nombre`, `director`, `genero`, `anio`, `puntuacion`, `plataformaId`)
VALUES (1, 'Colega dónde está mi coche', 'Danny Leiner', 'Comedia', 2000, 2, 1),
       (2, 'No respires', 'Fede Álvarez', 'Thriller', 2016, 3, 1),
       (3, 'It', 'Andy Muschietti', 'Terror', 2017, 3, 3),
       (4, 'Titanic', 'James Cameron', 'Drama', 1997, 4, 1),
       (5, 'El Show de Truman', 'Peter Weir', 'Drama', 1998, 4, 2),
       (6, 'Gladiator', 'Ridley Scott', 'Acción', 2000, 5, 2),
       (7, 'Malditos Bastardos', 'Quentin Tarantino', 'Acción', 2009, 5, 2),
       (8, 'Tiburón', 'Steven Spielberg', 'Terror', 1975, 3, 1),
       (9, 'El señor de los anillos: La comunidad del anillo', 'Peter Jackson', 'Fantástico', 2001, 4, 3),
       (10, 'El señor de los anillos: Las dos torres', 'Peter Jackson', 'Fantástico', 2002, 5, 3),
       (11, 'El señor de los anillos: el retorno del rey', 'Peter Jackson', 'Fantástico', 2003, 5, 3),
       (12, 'Iron Man', 'Jon Favreau', 'Fantástico', 2008, 3, 1),
       (13, 'Iron Man 2', 'Jon Favreau', 'Fantástico', 2010, 2, 1),
       (14, 'Terminator', 'James Cameron', 'Acción', 1984, 4, 2),
       (15, 'Terminator 2: El juicio final', 'James Cameron', 'Acción', 1991, 4, 2),
       (16, 'Terminator 3: La rebelión de las máquinas', 'Jonathan Mostow', 'Acción', 2003, 2, 2),
       (17, 'Interstellar', 'Christopher Nolan', 'Ciencia Ficción', 2014, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plataforma`
--

DROP TABLE IF EXISTS `plataforma`;
CREATE TABLE `plataforma`
(
    `id`     int(11) NOT NULL,
    `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `plataforma`
--

INSERT INTO `plataforma` (`id`, `nombre`)
VALUES (1, 'Netflix'),
       (2, 'HBO'),
       (3, 'Amazon Prime');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario`
(
    `id`            int(11) NOT NULL,
    `identificador` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
    `nombre`        varchar(40) COLLATE utf8_spanish_ci NOT NULL,
    `apellidos`     varchar(40) COLLATE utf8_spanish_ci NOT NULL,
    `email`         varchar(40) COLLATE utf8_spanish_ci NOT NULL,
    `contrasenna`   varchar(80) COLLATE utf8_spanish_ci NOT NULL,
    `codigoCookie`  varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `identificador`, `nombre`, `apellidos`, `email`, `contrasenna`, `codigoCookie`)
VALUES (1, 'jlopez', 'José', 'López', 'j@c', 'j', NULL),
       (2, 'mgarcia', 'María', 'García', 'm@c', 'm', NULL),
       (3, 'fpi', 'Felipe', 'Pi', 'f@c', 'f', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `lista`
--
ALTER TABLE `lista`
    ADD PRIMARY KEY (`id`),
  ADD KEY `usuarioId` (`usuarioId`);

--
-- Indices de la tabla `listausuariopeliculas`
--
ALTER TABLE `listausuariopeliculas`
    ADD KEY `listaId` (`listaId`),
  ADD KEY `peliculaId` (`peliculaId`);

--
-- Indices de la tabla `pelicula`
--
ALTER TABLE `pelicula`
    ADD PRIMARY KEY (`id`),
  ADD KEY `plataformaId` (`plataformaId`);

--
-- Indices de la tabla `plataforma`
--
ALTER TABLE `plataforma`
    ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
    ADD PRIMARY KEY (`id`);

--
-- Restricciones para tablas volcadas
--


--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Pelicula`
--
ALTER TABLE `pelicula`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 9;

--
-- AUTO_INCREMENT de la tabla `Usuario`
--
ALTER TABLE `usuario`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 9;

--
-- AUTO_INCREMENT de la tabla `Lista`
--
ALTER TABLE `lista`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 9;


--
-- Filtros para la tabla `lista`
--
ALTER TABLE `lista`
    ADD CONSTRAINT `lista_ibfk_1` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `listausuariopeliculas`
--
ALTER TABLE `listausuariopeliculas`
    ADD CONSTRAINT `listausuariopeliculas_ibfk_1` FOREIGN KEY (`listaId`) REFERENCES `lista` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `listausuariopeliculas_ibfk_2` FOREIGN KEY (`peliculaId`) REFERENCES `pelicula` (`id`) ON
DELETE
CASCADE ON
UPDATE CASCADE;

--
-- Filtros para la tabla `pelicula`
--
ALTER TABLE `pelicula`
    ADD CONSTRAINT `pelicula_ibfk_1` FOREIGN KEY (`plataformaId`) REFERENCES `plataforma` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
