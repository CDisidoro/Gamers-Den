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
USE `gamers_den`;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `Usuario`, `Password`, `Email`, `Rol`, `Avatar`, `Biografia`) VALUES
(1, 'admin', '$2y$10$Tqw1LUHWQ7kCSaC/HbwW..8mc/lacMnohhtQPJFLI5UNSDnZVul96', 'admin@gamersden.com', '1', 2, 'Juego o saco el banhammer?'),
(2, 'escritor', '$2y$10$ZTNUvjtNUGIih/o2lhoNh.pF7enWI2yiU9s.MdiYjgS/m3iA6rouS', 'escritor@gamersden.com', '2', 1, 'Ya habéis leído que salió el Elden Ring?'),
(3, 'usuario', '$2y$10$G9IeXOVfmIxO1akx/CJNH.fabWr4tPyKjTuvY/bEx06kE0z9UF7WO', 'usuario@gmail.com', '3', 3, NULL),
(4, 'art25', '$2y$10$81e4CjoiBRP2bJHgmzguh.eOompRylTdP.LoSfbA89pnUCVGYDgVC', '1234@gmail.com', '3', 1, NULL);
COMMIT;

--
-- Volcado de datos para la tabla `lista_amigos`
--

INSERT INTO `lista_amigos` (`usuarioA`, `usuarioB`) VALUES
(1, 2),
(2, 1),
(1, 3),
(3, 1),
(4, 1),
(1, 4);

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
-- Volcado de datos para la tabla `juegos`
--
INSERT INTO `juegos` (`Nombre`, `Descripcion`, `Lanzamiento`, `Desarrollador`, `Precio`) VALUES
('Elden Ring',
'EL NUEVO JUEGO DE ROL Y ACCIÓN DE AMBIENTACIÓN FANTÁSTICA.\r\nÁlzate, Sinluz, y que la gracia te guíe para abrazar el poder del Círculo de Elden y encumbrarte como señor del Círculo en las Tierras Intermedias.\r\n\r\n• Un extenso mundo lleno de emociones\r\nUn vasto mundo perfectamente conectado en el que los territorios abiertos estarán repletos de situaciones y mazmorras enormes con diseños complejos y tridimensionales. Mientras exploras, experimentarás el deleite de descubrir amenazas desconocidas y sobrecogedoras, y eso te haré sentir la emoción de la superación.\r\n\r\n• Crea tu propio personaje\r\nAdemás de personalizar la apariencia de tu personaje, puedes combinar libremente las armas, armaduras y la magia que te equipas. Puedes desarrollar a tu personaje según tu estilo de juego, tanto para aumentar tu fuerza bruta y ser un guerrero poderoso, como para dominar la magia.\r\n\r\n• Un drama épico nacido de un mito\r\nUna historia muy profunda contada en fragmentos. Un drama épico en el que las motivaciones de cada personaje se encuentran en las Tierras Intermedias.\r\n\r\n• Jugabilidad online única que te conecta libremente con otros jugadores\r\nAdemás del multijugador, en el que te puedes conectar directamente con otros jugadores y viajar juntos, el juego incluye un elemento online asíncrono único que te permite sentir la presencia de otros.',
'2022-02-25',
'From Software, Inc.',
'60'),
('Terraria',
'¡Cava, lucha, explora, construye! Nada es imposible en este juego de aventuras repleto de acción. El mundo es tu lienzo y la tierra misma es tu pintura.\r\n¡Coge tus herramientas y adelante! Crea armas para deshacerte de una gran variedad de enemigos en numerosos ecosistemas. Excava profundo bajo tierra para encontrar accesorios, dinero y otras cosas muy útiles. Reúne recursos para crear todo lo que necesites y conformar así tu propio mundo. Construye una casa, un fuerte o incluso un castillo. La gente se mudará a vivir ahí e incluso quizás te vendan diferentes mercancías que te ayuden en tu viaje.\r\nPero ten cuidado, aún te aguardan más desafíos... ¿Estás preparado para la tarea?\r\nCaracterísticas principales:\r\nJugabilidad \"sandbox\" (juega libremente en un mundo a tu disposición)\r\nMundos generados de forma aleatoria\r\nActualizaciones gratuitas de contenido',
'2011-05-16',
'Re-Logic',
'10'),
('Fallout 4',
'Bethesda Game Studios, el galardonado creador de Fallout 3 y The Elder Scrolls V: Skyrim, os da la bienvenida al mundo de Fallout 4, su juego más ambicioso hasta la fecha y la siguiente generación de mundos abiertos.',
'2015-11-10',
'Bethesda Softworks',
'20'),
('Elite Dangerous',
'Elite Dangerous es el multijugador masivo espacial definitivo, que acerca la aventura original de mundo abierto a la nueva generación con una galaxia conectada, una narrativa en constante evolución y una recreación integral de la Vía Láctea.',
'2015-04-02',
'Frontier Developments',
'25')
;

--
-- Volcado de datos para la tabla `tienda`
--
INSERT INTO `tienda` (`Vendedor`, `Articulo`, `Precio`, `Descripcion`, `Caracteristica`) VALUES
('4', '4', '20', 'Es muy divertido pero gasta mucho tiempo', 'Nuevo');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
