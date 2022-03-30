-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-03-2022 a las 17:29:10
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

--
-- Truncar tablas antes de insertar `comentarios`
--

TRUNCATE TABLE `comentarios`;
--
-- Truncar tablas antes de insertar `foro`
--

TRUNCATE TABLE `foro`;
--
-- Truncar tablas antes de insertar `juegos`
--

TRUNCATE TABLE `juegos`;
--
-- Truncar tablas antes de insertar `lista_amigos`
--

TRUNCATE TABLE `lista_amigos`;
--
-- Volcado de datos para la tabla `lista_amigos`
--

INSERT INTO `lista_amigos` (`usuarioA`, `usuarioB`) VALUES
(1, 2),
(1, 3),
(4, 1),
(1, 4);

--
-- Truncar tablas antes de insertar `lista_deseos`
--

TRUNCATE TABLE `lista_deseos`;
--
-- Truncar tablas antes de insertar `mensajes`
--

TRUNCATE TABLE `mensajes`;
--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`ID`, `Remitente`, `Destinatario`, `Fecha`, `Contenido`) VALUES
(1, 1, 2, '2022-03-27', 'hola usuario'),
(2, 2, 1, '2022-03-27', '¿que tal administrador?'),
(3, 2, 1, '2022-03-27', 'por favor no me denuncies'),
(4, 2, 1, '2022-03-27', 'no sabia que era menor'),
(5, 1, 2, '2022-03-27', 'Asqueroso usuario la recogias del insti');

--
-- Truncar tablas antes de insertar `noticias`
--

TRUNCATE TABLE `noticias`;
--
-- Truncar tablas antes de insertar `tienda`
--

TRUNCATE TABLE `tienda`;
--
-- Truncar tablas antes de insertar `usuarios`
--

TRUNCATE TABLE `usuarios`;
--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `Usuario`, `Password`, `Email`, `Rol`, `Avatar`, `Biografia`) VALUES
(1, 'admin', '$2y$10$Tqw1LUHWQ7kCSaC/HbwW..8mc/lacMnohhtQPJFLI5UNSDnZVul96', 'admin@gamersden.com', '1', 2, 'Juego o saco el banhammer?'),
(2, 'escritor', '$2y$10$ZTNUvjtNUGIih/o2lhoNh.pF7enWI2yiU9s.MdiYjgS/m3iA6rouS', 'escritor@gamersden.com', '2', 1, 'Ya habéis leído que salió el Elden Ring?'),
(3, 'usuario', '$2y$10$G9IeXOVfmIxO1akx/CJNH.fabWr4tPyKjTuvY/bEx06kE0z9UF7WO', 'usuario@gmail.com', '3', 3, NULL),
(4, 'art25', '$2y$10$81e4CjoiBRP2bJHgmzguh.eOompRylTdP.LoSfbA89pnUCVGYDgVC', '1234@gmail.com', '3', 1, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
