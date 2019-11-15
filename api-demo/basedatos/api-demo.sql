-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-11-2019 a las 16:53:54
-- Versión del servidor: 10.1.16-MariaDB
-- Versión de PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `api_demo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `troles`
--

CREATE TABLE `troles` (
  `idrol` int(255) NOT NULL,
  `rol` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `configuracion` int(1) NOT NULL,
  `catalagos` int(1) NOT NULL,
  `indicadores` int(1) NOT NULL,
  `reportes` int(1) NOT NULL,
  `activo` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `troles`
--

INSERT INTO `troles` (`idrol`, `rol`, `configuracion`, `catalagos`, `indicadores`, `reportes`, `activo`) VALUES
(1, 'SUPER ADMINISTRADOR', 1, 1, 1, 1, 1),
(2, 'ADMINISTRADOR', 0, 1, 1, 1, 1),
(3, 'ALUMNOS', 0, 0, 0, 0, 1),
(4, 'DOCENTES', 0, 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tusuarios`
--

CREATE TABLE `tusuarios` (
  `idusuario` int(255) NOT NULL,
  `idrol` int(255) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ip` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `edicion` int(1) NOT NULL,
  `activo` int(1) NOT NULL,
  `sesion` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tusuarios`
--

INSERT INTO `tusuarios` (`idusuario`, `idrol`, `nombre`, `correo`, `password`, `ip`, `edicion`, `activo`, `sesion`) VALUES
(1, 1, 'ANTONIO ESPINO', 'admin@gmail.com', '3f7e8966551bc6a960cee321d830239f', '', 1, 1, 1),
(2, 2, 'JOSE ESPINO', 'jose@gmail.com', '3f7e8966551bc6a960cee321d830239f', ' ', 1, 1, 1),
(3, 2, 'JOSE LOPEZ', 'josel@gmail.com', '3f7e8966551bc6a960cee321d830239f', ' ', 1, 1, 1),
(4, 3, 'ANTONIO ESPINO', 'antonio@gmail.com', '3f7e8966551bc6a960cee321d830239f', ' ', 1, 0, 1),
(5, 4, 'JOSE ANTONIO ESPINO', 'joseantonio@gmail.com', '3f7e8966551bc6a960cee321d830239f', ' ', 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vusuarios`
--
CREATE TABLE `vusuarios` (
`id` int(255)
,`idrol` int(255)
,`rol` varchar(20)
,`nombre` varchar(100)
,`correo` varchar(100)
,`activo` int(1)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vusuarios`
--
DROP TABLE IF EXISTS `vusuarios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vusuarios`  AS  select `u`.`idusuario` AS `id`,`u`.`idrol` AS `idrol`,`r`.`rol` AS `rol`,`u`.`nombre` AS `nombre`,`u`.`correo` AS `correo`,`u`.`activo` AS `activo` from (`tusuarios` `u` join `troles` `r` on((`u`.`idrol` = `r`.`idrol`))) where (`u`.`activo` = 1) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `troles`
--
ALTER TABLE `troles`
  ADD PRIMARY KEY (`idrol`),
  ADD KEY `rol` (`rol`);

--
-- Indices de la tabla `tusuarios`
--
ALTER TABLE `tusuarios`
  ADD PRIMARY KEY (`idusuario`),
  ADD KEY `idrol` (`idrol`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `troles`
--
ALTER TABLE `troles`
  MODIFY `idrol` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `tusuarios`
--
ALTER TABLE `tusuarios`
  MODIFY `idusuario` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tusuarios`
--
ALTER TABLE `tusuarios`
  ADD CONSTRAINT `tusuarios_ibfk_1` FOREIGN KEY (`idrol`) REFERENCES `troles` (`idrol`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
