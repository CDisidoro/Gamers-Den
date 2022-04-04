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
INSERT INTO `tienda` (`ID`, `Vendedor`, `Articulo`, `Descripcion`, `Fecha`, 'UrlImagen', 'Caracteristica', 'Precio') VALUES
(1, 1, 'Apuntes de AW','ME he pasado todo el año trabajando en unos buenos apuntes para mi clase favorita', current_timestamp,'Avatar7', 'Destacado', 23.50),
(2, 2, 'Amigos','Dicen que los amigos tienen un valor incalculable, bueno pues estos no', current_timestamp,'Avatar6', 'Destacado', 1),
(3, 1, 'Hollow Knight PS4','Me lo he pasado tantas veces que me se el dialogo de memoria', current_timestamp,'Avatar5', 'Destacado', 10.253),
(4, 3, 'Parchis PS4','Le compre el parchis a mi abuelo pero no vi que era de videoconsola', current_timestamp,'Avatar4', 'Destacado', 19);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;