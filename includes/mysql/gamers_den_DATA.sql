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
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `Usuario`, `Password`, `Email`, `Rol`, `Avatar`, `Biografia`) VALUES
(1, 'admin', '$2y$10$Tqw1LUHWQ7kCSaC/HbwW..8mc/lacMnohhtQPJFLI5UNSDnZVul96', 'admin@gamersden.com', '1', 1, 'Juego o saco el banhammer?'),
(2, 'escritor', '$2y$10$ZTNUvjtNUGIih/o2lhoNh.pF7enWI2yiU9s.MdiYjgS/m3iA6rouS', 'escritor@gamersden.com', '2', 1, 'Ya habéis leído que salió el Elden Ring?'),
(3, 'usuario', '$2y$10$G9IeXOVfmIxO1akx/CJNH.fabWr4tPyKjTuvY/bEx06kE0z9UF7WO', 'usuario@gmail.com', '3', 1, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
