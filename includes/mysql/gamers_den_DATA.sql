TRUNCATE TABLE `usuarios`;
--
-- Volcado de datos para la tabla `usuarios`
--
-- admin: adminpass
-- escritor: escritorpass
-- usuario: userpass
INSERT INTO `usuarios` (`ID`, `Usuario`, `Password`, `Email`, `Rol`, `Avatar`, `Biografia`) VALUES
(1, 'admin', '$2y$10$Tqw1LUHWQ7kCSaC/HbwW..8mc/lacMnohhtQPJFLI5UNSDnZVul96', 'admin@gamersden.com', '1', 1, 'Juego o saco el banhammer?'),
(2, 'escritor', '$2y$10$ZTNUvjtNUGIih/o2lhoNh.pF7enWI2yiU9s.MdiYjgS/m3iA6rouS', 'escritor@gamersden.com', '2', 1, 'Ya habéis leído que salió el Elden Ring?'),
(3, 'usuario', '$2y$10$G9IeXOVfmIxO1akx/CJNH.fabWr4tPyKjTuvY/bEx06kE0z9UF7WO', 'usuario@gmail.com', '3', 1, NULL);
