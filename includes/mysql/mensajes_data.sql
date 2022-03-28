-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 22-03-2022 a las 21:48:46
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

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

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`ID`, `Remitente`, `Destinatario`, `Fecha`, `Contenido`) VALUES
(1, 1, 2, current_timestamp, 'hola usuario'),
(2, 2, 1, current_timestamp, '¿que tal administrador?'),
(3, 2, 1, current_timestamp, 'por favor no me denuncies'),
(4, 2, 1, current_timestamp, 'no sabia que era menor'),
(5, 1, 2, current_timestamp, 'Asqueroso usuario la recogias del insti');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;