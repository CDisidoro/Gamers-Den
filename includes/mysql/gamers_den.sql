-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-03-2022 a las 17:28:31
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gamers_den`
--
CREATE DATABASE IF NOT EXISTS `gamers_den` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `gamers_den`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Autor` int(11) NOT NULL,
  `Foro` int(11) NOT NULL,
  `Contenido` longtext NOT NULL,
  `Fecha` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Comentarios en los foros';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foro`
--

CREATE TABLE `foro` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Autor` int(11) NOT NULL,
  `Contenido` longtext NOT NULL,
  `Fecha` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY(`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos`
--

CREATE TABLE `juegos` (
  `ID` int(11) NOT NULL,
  `Nombre` text NOT NULL,
  `Descripcion` longtext NOT NULL,
  `Lanzamiento` date NOT NULL,
  `Desarrollador` text NOT NULL,
  `Precio` int(11) NOT NULL COMMENT 'Precio Oficial del Desarrollador',
  PRIMARY KEY(`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_amigos`
--

CREATE TABLE `lista_amigos` (
  `usuarioA` int(11) NOT NULL,
  `usuarioB` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_deseos`
--

CREATE TABLE `lista_deseos` (
  `juego` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `fecha_agregacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Remitente` int(11) NOT NULL,
  `Destinatario` int(11) NOT NULL,
  `Fecha` date NOT NULL DEFAULT current_timestamp(),
  `Contenido` longtext NOT NULL,
  PRIMARY KEY(`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Titulo` text NOT NULL,
  `Imagen` blob DEFAULT NULL,
  `Contenido` longtext NOT NULL,
  `Descripcion` text NOT NULL,
  `Etiquetas` text NOT NULL,
  `Autor` int(11) NOT NULL,
  `Fecha` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY(`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tienda`
--

CREATE TABLE `tienda` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Vendedor` int(11) NOT NULL,
  `Articulo` int(11) NOT NULL,
  `Precio` int(11) UNSIGNED NOT NULL,
  `Descripcion` longtext NOT NULL,
  `Fecha` date NOT NULL,
  `Caracteristica` text NOT NULL DEFAULT 'Nuevo',
  PRIMARY KEY(`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Usuario` text NOT NULL,
  `Password` varchar(255) NOT NULL COMMENT 'SHA',
  `Email` text NOT NULL,
  `Rol` text NOT NULL,
  `Avatar` int(11) DEFAULT 1,
  `Biografia` longtext DEFAULT NULL,
  PRIMARY KEY(`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD KEY `FK_Autor` (`Autor`) USING BTREE,
  ADD KEY `FK_Foro` (`Foro`) USING BTREE;

--
-- Indices de la tabla `foro`
--
ALTER TABLE `foro`
  ADD KEY `FK_Autor` (`Autor`) USING BTREE;

--
-- Indices de la tabla `lista_amigos`
--
ALTER TABLE `lista_amigos`
  ADD KEY `FK_usuarioA` (`usuarioA`),
  ADD KEY `FK_usuarioB` (`usuarioB`);

--
-- Indices de la tabla `lista_deseos`
--
ALTER TABLE `lista_deseos`
  ADD KEY `FK_juego` (`juego`),
  ADD KEY `FK_usuario` (`usuario`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD KEY `FK_Remitente` (`Remitente`) USING BTREE,
  ADD KEY `FK_Destinatario` (`Destinatario`) USING BTREE;

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD KEY `Autor` (`Autor`);

--
-- Indices de la tabla `tienda`
--
ALTER TABLE `tienda`
  ADD KEY `FK_Vendedor` (`Vendedor`) USING BTREE,
  ADD KEY `FK_Articulo` (`Articulo`) USING BTREE;

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD UNIQUE KEY `Usuario` (`Usuario`) USING HASH;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`Autor`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`Foro`) REFERENCES `foro` (`ID`);

--
-- Filtros para la tabla `foro`
--
ALTER TABLE `foro`
  ADD CONSTRAINT `foro_ibfk_1` FOREIGN KEY (`Autor`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `lista_amigos`
--
ALTER TABLE `lista_amigos`
  ADD CONSTRAINT `lista_amigos_ibfk_1` FOREIGN KEY (`usuarioA`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lista_amigos_ibfk_2` FOREIGN KEY (`usuarioB`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `lista_deseos`
--
ALTER TABLE `lista_deseos`
  ADD CONSTRAINT `lista_deseos_ibfk_1` FOREIGN KEY (`juego`) REFERENCES `juegos` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lista_deseos_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`Remitente`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`Destinatario`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `FK_Autor` FOREIGN KEY (`Autor`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tienda`
--
ALTER TABLE `tienda`
  ADD CONSTRAINT `tienda_ibfk_1` FOREIGN KEY (`Vendedor`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tienda_ibfk_2` FOREIGN KEY (`Articulo`) REFERENCES `juegos` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
