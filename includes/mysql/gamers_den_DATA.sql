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
-- Passwords:
-- admin: adminpass
-- escritor: escritorpass
-- catalogador: catalogapass
-- moderador: modpass
-- usuario: userpass
-- art25: 12345

INSERT INTO `usuarios` (`ID`, `Usuario`, `Password`, `Email`, `Rol`, `Avatar`, `Biografia`) VALUES
(1, 'admin', '$2y$10$Tqw1LUHWQ7kCSaC/HbwW..8mc/lacMnohhtQPJFLI5UNSDnZVul96', 'admin@gamersden.com', '1', 'img/Avatar1.jpg', 'Juego o saco el banhammer?'),
(2, 'escritor', '$2y$10$ZTNUvjtNUGIih/o2lhoNh.pF7enWI2yiU9s.MdiYjgS/m3iA6rouS', 'escritor@gamersden.com', '2', 'img/Avatar1.jpg', 'Ya habéis leído que salió el Elden Ring?'),
(3, 'catalogador', '$2y$10$PmoO7Al71UK5fuisEiXWDu05fvq3MvIgbInzvook0enmCz/T5PlVe', 'cataloga@gamersden.com', '3', 'img/Avatar1.jpg', 'Atento al proximo gran lanzamiento de Valve'),
(4, 'moderador', '$2y$10$BGCGJpx5h6AGyfg2XkAiReshk.TYeiA6kDAhg73.ff14wsaAd8PVq', 'mod@gamersden.com', '4', 'img/Avatar1.jpg', 'Recuerda comportarte en los foros'),
(5, 'usuario', '$2y$10$G9IeXOVfmIxO1akx/CJNH.fabWr4tPyKjTuvY/bEx06kE0z9UF7WO', 'usuario@gmail.com', '5', 'img/Avatar1.jpg', NULL),
(6, 'art25', '$2y$10$81e4CjoiBRP2bJHgmzguh.eOompRylTdP.LoSfbA89pnUCVGYDgVC', '1234@gmail.com', '5', 'img/Avatar1.jpg', NULL);
COMMIT;

--
-- Volcado de datos para la tabla `lista_amigos`
--

INSERT INTO `lista_amigos` (`usuarioA`, `usuarioB`) VALUES
(1, 2),
(2, 1),
(1, 3),
(3, 1),
(2, 3),
(3, 2),
(4, 1),
(1, 4);

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`ID`, `Remitente`, `Destinatario`, `Fecha`, `Contenido`, `Tipo`) VALUES
(1, 1, 2, '2022-03-27', 'hola usuario', 1),
(2, 2, 1, '2022-03-27', '¿que tal administrador?', 1),
(3, 2, 1, '2022-03-27', 'bien, estudiando AW', 1),
(4, 2, 1, '2022-03-27', 'anda! yo también, es una asignatura muy entretenida', 1),
(5, 1, 2, '2022-03-27', 'y que lo digas pequeño usuario', 1);

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`Emisor`, `Receptor`) VALUES
(1, 2),
(3, 1);

--
-- Volcado de datos para la tabla `juegos`
--
INSERT INTO `juegos` (`Nombre`, `Descripcion`, `Lanzamiento`, `Desarrollador`, `Imagen`,  `Precio`) VALUES
('Elden Ring',
'EL NUEVO JUEGO DE ROL Y ACCIÓN DE AMBIENTACIÓN FANTÁSTICA.\r\nÁlzate, Sinluz, y que la gracia te guíe para abrazar el poder del Círculo de Elden y encumbrarte como señor del Círculo en las Tierras Intermedias.\r\n\r\n• Un extenso mundo lleno de emociones\r\nUn vasto mundo perfectamente conectado en el que los territorios abiertos estarán repletos de situaciones y mazmorras enormes con diseños complejos y tridimensionales. Mientras exploras, experimentarás el deleite de descubrir amenazas desconocidas y sobrecogedoras, y eso te haré sentir la emoción de la superación.\r\n\r\n• Crea tu propio personaje\r\nAdemás de personalizar la apariencia de tu personaje, puedes combinar libremente las armas, armaduras y la magia que te equipas. Puedes desarrollar a tu personaje según tu estilo de juego, tanto para aumentar tu fuerza bruta y ser un guerrero poderoso, como para dominar la magia.\r\n\r\n• Un drama épico nacido de un mito\r\nUna historia muy profunda contada en fragmentos. Un drama épico en el que las motivaciones de cada personaje se encuentran en las Tierras Intermedias.\r\n\r\n• Jugabilidad online única que te conecta libremente con otros jugadores\r\nAdemás del multijugador, en el que te puedes conectar directamente con otros jugadores y viajar juntos, el juego incluye un elemento online asíncrono único que te permite sentir la presencia de otros.',
'2022-02-25',
'From Software, Inc.',
'img/EldenRing.jpg',
'60'),
('Terraria',
'¡Cava, lucha, explora, construye! Nada es imposible en este juego de aventuras repleto de acción. El mundo es tu lienzo y la tierra misma es tu pintura.\r\n¡Coge tus herramientas y adelante! Crea armas para deshacerte de una gran variedad de enemigos en numerosos ecosistemas. Excava profundo bajo tierra para encontrar accesorios, dinero y otras cosas muy útiles. Reúne recursos para crear todo lo que necesites y conformar así tu propio mundo. Construye una casa, un fuerte o incluso un castillo. La gente se mudará a vivir ahí e incluso quizás te vendan diferentes mercancías que te ayuden en tu viaje.\r\nPero ten cuidado, aún te aguardan más desafíos... ¿Estás preparado para la tarea?\r\nCaracterísticas principales:\r\nJugabilidad \"sandbox\" (juega libremente en un mundo a tu disposición)\r\nMundos generados de forma aleatoria\r\nActualizaciones gratuitas de contenido',
'2011-05-16',
'Re-Logic',
'img/Terraria.jpg',
'10'),
('Fallout 4',
'Bethesda Game Studios, el galardonado creador de Fallout 3 y The Elder Scrolls V: Skyrim, os da la bienvenida al mundo de Fallout 4, su juego más ambicioso hasta la fecha y la siguiente generación de mundos abiertos.',
'2015-11-10',
'Bethesda Softworks',
'img/Fallout4.jpg',
'20'),
('Elite Dangerous',
'Elite Dangerous es el multijugador masivo espacial definitivo, que acerca la aventura original de mundo abierto a la nueva generación con una galaxia conectada, una narrativa en constante evolución y una recreación integral de la Vía Láctea.',
'2015-04-02',
'Frontier Developments',
'img/EliteDangerous.jpg',
'25')
;

--
-- Volcado de datos para la tabla `foro`
--

INSERT INTO `foro` (`ID`, `Autor`, `Contenido`, `Fecha`) VALUES
(1, 1, 'EL PODER DE LA AMISTAD', '2022-04-27'),
(2, 1, 'UBISOFT ME ROBA EL DINERO', '2022-04-27'),
(3, 1, 'NO SE LE PAGA LO SUFICIENTE A LOS PROGRAMADORES DE VIDEOJUEGOS', '2022-04-27'),
(4, 1, 'ELDEN RING ES MUY FACIL', '2022-04-27');

--
-- Dumping data for table `noticias`
--

INSERT INTO `noticias` (`ID`, `Titulo`, `Imagen`, `Contenido`, `Descripcion`, `Etiquetas`, `Autor`, `Fecha`) VALUES
(2, 'Battlefield 2042 recibirá una actualización enorme en abril que traerá \"cientos de cambios\"', 'img/NoticiaBattlefield.jpg', 'Si hay que elegir una gran decepción de 2021, Battlefield 2042 tiene grandes papeletas para alzarse con tal galardón. El shooter de DICE no cumplió con las expectativas desde su lanzamiento en el mes de noviembre, con numerosos bugs y errores que han llevado a EA a considerarlo un fracaso.\r\n\r\n\r\nPero desde Electronic Arts quieren seguir remando contracorriente con su plan de actualizaciones, y gracias a un mensaje en los foros oficiales sabemos que llegará un parche enorme en abril. \"La próxima (actualización) será grande y tenemos planeados cientos de cambios\", dice Straatford, community manager del equipo.\r\n\r\nEl propio miembro de DICE afirma que, por encima de todo, lo que trae tiene que ver con el arreglo de bugs y errores que pueden encontrarse durante las partidas, pero también planean otro tipo de modificaciones. Si hacemos caso a la última publicación en la web oficial de EA, podemos esperar también ciertos cambios en los mapas, con Kaleidoscope y Renewal recibiendo ajustes en la Temporada 1 y el resto siendo alterados durante la segunda.\r\n\r\n\r\nDe igual forma, se esperan mejoras respecto al equilibrio de los vehículos, a la configuración de los especialistas y al comportamiento actual de las armas, aunque a medida que se acerque el lanzamiento de la actualización nos ofrecerán las notas completas del parche. Todavía no hay fecha confirmada para el mismo, pero estaremos atentos tras las últimas informaciones procedentes de DICE, que aseguran que en el estudio han aprendido la lección y están enfocados en revertir la situación.\r\n', 'Desde DICE han adelantado que están preparando numerosos ajustes en el shooter de Electronic Arts', 1, 2, '2022-04-03'),
(4, 'Zelda: Breath of the Wild 2 retrasa su lanzamiento al 2023 para crear una \"experiencia completamente única\"', 'img/NoticiaZelda.jpg', 'Habíamos empezado 2022 con la ilusión por las nubes y, entre todos los bombazos presentados por las compañías de videojuegos, muchos usuarios tenían la mirada puesta en The Legend of Zelda: Breath of the Wild 2. Por desgracia, y aunque Nintendo había reiterado en múltiples ocasiones que su lanzamiento se quedaba en 2022, parece que nos tocará esperar para disfrutar de la próxima aventura de la saga.\r\n\r\nHemos conocido esta información por Eiji Aonuma, productor de la franquicia The Legend of Zelda y figura icónica en lo referente a esta saga. A través de un vídeo que podéis ver al inicio de esta noticia, se disculpa públicamente con la comunidad y fija el estreno de The Legend of Zelda: Breath of the Wild 2 para primavera de 2023.\r\n\r\nEn el comunicado, Aonuma no explica las razones detrás de esta decisión y simplemente comenta que se extenderá el tiempo de desarrollo para crear una experiencia especial. A continuación, recuerda algunas de las características clave del título, tales como la exploración por terrenos que están en el cielo, así como enfrentamientos inéditos y nuevas mecánicas de jugabilidad entre otros añadidos.\r\n\r\nDe este modo, y sin mucho más que comentar por parte de Aonuma, nos tocará esperar a que el icónico personaje presente su inolvidable aventura en el próximo año. Hasta entonces, podemos seguir teorizando sobre las mecánicas innovadoras que incluirá Nintendo en el juego, algunas de las cuales ya se habrían detallado con nuevas patentes, y sobre su nombre oficial, del que todavía no tenemos ninguna pista.\r\n', 'La próxima aventura exclusiva de Nintendo Switch tenía previsto su estreno en 2022; finalmente, habrá que esperar más', 1, 2, '2022-04-04'),
(5, 'PlayStation ya elimina la suscripción anual a PS Now: una forma de preparar la llegada del nuevo PS Plus', 'img/NoticiaPsNow.jpg', 'Tras varios meses de rumores y especulaciones, PlayStation confirmó lo que se había convertido en un secreto a voces: un nuevo PS Plus que divide sus suscripciones en los modelos Essential, Extra y Premium. La compañía nipona no ha tardado en darnos algunos detalles de lo que está por llegar, con detalles como los primeros juegos confirmados o las razones por las que el servicio no tendrá exclusivos de lanzamiento.\n\nLos usuarios del actual PS Now se han llevado una grata sorpresa con este anuncio, pues recibirán automáticamente la suscripción Premium (la más completa) en cuanto se lance el próximo mes de junio. Y, como no podía ser de otra manera, los usuarios ya se han percatado de un vacío legal con el que aprovechar el modelo más caro al precio más reducido posible.\n\nTal y como informa Eurogamer, la suscripción anual de PS Now estaba a 59,99 euros al año, mientras que la opción Premium del nuevo PS Plus nos deja con todas sus características a 119,99 euros anuales. Con ese cambio automático que ya os hemos comentado, los jugadores han comprado masivamente una suscripción anual a PS Now, y es por ello que PlayStation ya la ha empezado a retirar de su tienda.\n\nPor el momento, esta decisión afecta a países como EE.UU., por lo que en España todavía no se ha reflejado el último movimiento de PlayStation. Sin embargo, es cuestión de tiempo que la suscripción anual al actual PS Now desaparezca de nuestro territorio. Mientras, Jim Ryan sigue promocionando el nuevo PS Plus y ya ha dicho que contará con 200 socios para llevar juegos al servicio. Pese a esto, no todos los jugadores apoyan el modelo presentado por PlayStation.', 'La opción anual del nuevo PS Plus será más cara que la actual, razón por la que la compañía ha empezado a mover los hilos', 1, 2, '2022-04-04'),
(6, 'GTA 6 está en marcha: Rockstar confirma al fin que trabaja en el nuevo Grand Theft Auto', 'img/NoticiaGta6.jpg', 'Tras años hablando y especulando acerca del nuevo episodio de la saga GTA, Rockstar ha confirmado lo que era un secreto a voces: hay un nuevo Grand Theft Auto en desarrollo y esperan \"poder compartir más información tan pronto como estemos listos\". Mensaje que llega a la par que se ha dado a conocer la fecha de lanzamiento de GTA V en PS5 y Xbox Series X|S.\r\n\r\nEl estudio responsable del formidable Red Dead Redemption 2 no ha aportado más detalles sobre el ansiado GTA 6 (o el nombre que adopte), pero esta es la primera vez que Rockstar habla oficialmente y de forma clara de este nuevo juego de acción y mundo abierto. Hasta ahora, toda la información en torno a este sandbox procedía de rumores, filtraciones o incluso deslices en el currículum de algún empleado.\r\n\r\n\"Con la longevidad sin precedentes de Grand Theft Auto V sabemos que muchos de vosotros lleváis tiempo pidiendo un nuevo juego de la saga GTA\", comentan desde Rockstar Games. \"Con cada nuevo proyecto en el que nos embarcamos nuestra meta es la de mejorar significativamente lo que hemos hecho antes, y nos alegra confirmar que el desarrollo activo de la nueva entrega de la serie está muy avanzado. Estamos deseando compartirlo con vosotros tan pronto como estemos listos, así que estad atentos para más detalles oficiales\".\r\n\r\nLas ganas por tener noticias del juego han motivado que incluso año tras año, se analicen con lupa las previsiones económicas de Take Two en busca de datos que confirmen el lanzamiento del videojuego. Precisamente, hace tan solo unas semanas ya se especulaba con el lanzamiento de GTA 6 en dos años pero hasta el día de hoy, ni la editora ni por supuesto Rockstar habían realizado comentarios al respecto.\r\n', 'Los autores de Red Dead Redemption aseguran que el desarrollo \"está avanzado\"', 2, 2, '2022-04-04'),
(7, 'Cyberpunk 2077 recibe un nuevo parche con mejoras en misiones, jugabilidad y gráficos', 'img/NoticiaCyberpunk.jpg', 'Pese a que parecía que con la última actualización a nueva generación podríamos estar despidiéndonos de Cyberpunk 2077, desde CD Projekt RED intentarán seguir apoyándolo en los próximos meses. El compromiso del equipo de desarrollo polaco es llevar nuevas expansiones al juego próximamente, pero mientras siguen mejorando la experiencia de juego.\r\n\r\nSe ha publicado el nuevo parche 1.52 para Cyberpunk 2077, y ya está disponible en las distintas plataformas, es decir, en PC, PS4, PS5, Xbox One, Xbox Series X|S y Stadia. Esta actualización corrige varios bugs y errores del RPG, sobre todo los relacionados con ajustes en misiones que podían hacer que nuestra aventura no fuera lo suficientemente satisfactoria.\r\n\r\nOtros errores corregidos están dirigidos al funcionamiento del mundo abierto, concretamente tienen que ver con el comportamiento de los NPC en Night City y sus alrededores. Esto afecta a enemigos que hacen cosas que no deberían o a lo referente al tráfico. También nuestro vehículo debería dejar de aparecer lejos y, en otros aspectos jugables, se han solucionado fallos en Nomad, como el que hacía aparecer coches en mitad de la carretera.\r\n\r\nPor último, hay que hacer mención a las correcciones dirigidas a mejorar el apartado gráfico de Cyberpunk 2077. Se han solucionado algunos bugs relacionados con la vegetación y el clima, así como el comportamiento extraño de algunos objetos. Se han añadido también modificaciones en la interfaz y los menús.\r\n\r\nEn CD Projekt RED seguirán apoyando la llegada de ajustes y nuevo contenido a Cyberpunk 2077, pero desde el estudio polaco ya están centrados en un nuevo juego de The Witcher. El próximo título gozará de una colaboración con Epic Games y su motor Unreal Engine 5, aunque este acuerdo no hará que el juego sea exclusivo en PC, al menos por el momento.', 'El último título de CD Projekt RED sigue ajustando la experiencia de juego en varias plataformas', 2, 2, '2022-04-04'),
(8, 'Final Fantasy 14 presenta su próxima actualización, Newfound Adventure: tráiler, fecha y novedades', 'img/NoticiaFinalFantasy.jpg', 'Final Fantasy 14 viene de una situación muy atípica, su fulgurante éxito provocó que en Square Enix se viesen obligados a suspender las ventas digitales a finales del año pasado para descongestionar sus servidores. Un éxito que ha estado acompañado de constantes actualizaciones y una gran expansión de contenido. Las novedades no dejan de llegar al MMORPG y buena prueba de ello es el nuevo parche presentado por Naoki Yoshida y que llegará el próximo 12 de abril.\r\n\r\nEste parche 6.1, al que han bautizado como \"Newfound Adventure\", incluirá nuevas misiones principales y una raid para 24 jugadores entre sus novedades. Esta actualización también contará con la incorporación del nuevo Duty Support System para el contenido de A Realm Reborn™ (2.0), permitiendo que las mazmorras y desafíos para cuatro jugadores puedan superarse en solitario, en compañía de un equipo de NPCs. El estudio ha prometido expandir este sistema en futuras actualizaciones.\r\n\r\nYoshida compartió algunas de las novedades que encontraremos en esta nueva actualización:\r\n- Nuevas misiones principales: El parche 6.1 será el comienzo del nuevo capítulo de los Warriors of Light.\r\n- Nueva raid para 24 jugadores: La nueva serie de Alliance Raid recibirá su primera parte, titulada Myths of the Realm: Aglaia.\r\n- Nuevas misiones de tribus: llegarán a partir del parche 6.15, con misiones para la tribu de los Arkasodara.\r\n- Nueva área residencial: el nuevo distrito residencial en Ishgard, Empyreum, pondrá a la venta parcelas con un sistema de compra por sorteo.\r\n- The Minstrel’s Ballad Endsinger’s Aria: un nuevo desafío que pondrá a prueba a los jugadores.\r\n- Versión beta de las "Adventurer Plates": Podrán personalizarse los retratos de los jugadores con distinta iluminación, ángulos de cámara y empleando la apariencia actual de los personajes. Los perfiles podrán incluir información como oficio favorito, preferencias de juego o tiempo de juego activo.\r\n- Actualización del PvP: el nuevo contenido, Crystalline Conflict, incluirá nuevos sistemas de recompensa y calendario.\r\n- Ajustes en oficios, contenido adicional, posibilidad para probarse equipo en FFXIV Online Store y actualizaciones de sistemas.\r\n\r\nSquare Enix también ha anunciado que el equipo basado en el show de TV japonés GARO volverá con esta actualización en PvP. Los jugadores podrán hacerse con el equipo diseñado por el legendario Keita Amemiya, además de monturas especiales. En posteriores actualizaciones también recibiremos Ultima’s Bane (Unreal), un nuevo desafío, además del Unending Codex, que recogerá información de personajes y términos. Con el parche 6.11 recibiremos Dragonsong’s Reprise (Ultimate Duty), además de la misión secundaria Somehow Further Hildibrand Adventures y las nuevas entregas personalizadas con el 6.15. Los viajes de centro de datos no llegarán hasta la actualización 6.18.\r\n', 'Nuevas misiones de la historia principal, raid para 24 jugadores y nueva zona residencial llegan con el parche 6.1 del MMORPG', 2, 2, '2022-04-04'),
(9, 'GTA 5 para Xbox Series y PS5 anuncia fecha de lanzamiento y precio para su formato físico', 'img/NoticiaGtaV.jpg', 'Pese a su largo tiempo en el mercado, GTA 5 sigue siendo todo un éxito en ventas. Eso lo demuestran las últimas cifras presentadas por Rockstar, que muestran a su quinta entrega como la más exitosa de toda la franquicia. No contentos con ello, la desarrolladora ha alargado la vida de esta aventura con un lanzamiento en la next-gen y una nueva suscripción en su popular GTA Online.\r\n\r\nPues bien, aunque GTA 5 para Xbox Series y PS5 se lanzó el pasado 15 de marzo, Rockstar no ha tardado en presentar una versión en físico para todos los jugadores que deseen incorporar este juego en sus colecciones next-gen. Quien quiera hacerse con una copia de GTA 5, que incluye asimismo GTA Online, tendrá que esperar hasta el próximo 12 de abril y pagar 39,99 euros, según se lee en la web de Rockstar.\r\n\r\nSi esta cantidad os parece demasiado elevada, siempre podéis optar por una versión digital con descuento. Tal y como anunció Rockstar en su momento, GTA 5 y GTA Online para Xbox Series y PS5 estarán de oferta durante 3 meses desde su lanzamiento a mediados de marzo, por lo que tenemos la oportunidad de hacernos nuevamente con este juego con una rebaja que durará hasta el mes de junio.\r\n\r\nSi tenéis dudas en cuanto al rendimiento de GTA 5 en la nueva generación, echadle un vistazo a los modos gráficos presentados en cada plataforma. Y, si os interesa saber cómo se siente el juego en PS5 y Xbox Series, siempre podéis leer nuestro análisis para descubrir que, si todavía no has jugado a la que es una de las obras más laureadas de Rockstar, esta es la mejor manera de hacerlo.', 'La versión next-gen se estrenó el pasado 15 de marzo, pero Rockstar también nos traerá caja y CD', 3, 2, '2022-04-04'),
(10, 'Un mundo masivo y laberíntico nos espera en el nuevo juego del autor de Hyper Light Drifter', 'img/NoticiaHyperLightBreaker.jpg', 'Si sois fans de Hyper Light Drifter, os alegrará esta noticia. Si no lo sois, os animamos a probar el juego, ya que desde Heart Machine han anunciado Hyper Light Breaker, una secuela ambientada en el mismo universo del título independiente tan bien recibido en su momento. Hace unos meses tuvimos Solar Ash, también relacionado, pero este tiene un enfoque diferente.\r\n\r\n\r\nA través de la publicación de un mensaje y un tráiler en sus redes sociales oficiales hemos conocido la existencia del nuevo juego de Axl Preston, creador y director creativo del estudio californiano. También se ha abierto su página de Steam, donde se comparten algunas capturas más de lo que podemos esperar del título.\r\n\r\nDestaca por encima de todo el apartado visual y la apuesta por el 3D, aunque la misma página de la tienda extiende la descripción, especificando que puede jugarse en cooperativo. Nos dicen que en Hyper Light Breaker podremos \"explorar biomas masivos, derrotar a monstruos brutales, crear builds, sobrevivir a los misteriosos Crowns y derrocar al todopoderoso Rey Abyss\".\r\n\r\nInsisten sobre todo en su vasto mundo, que esconderá varios misterios para resolver y enemigos feroces mientras el territorio se encuentra en constante cambio. Este, desarrollado en Unreal Engine, tiene una concepción algo laberíntica, y podremos desplazarnos por él utilizando varias mecánicas jugables, como el dash. Asimismo, el hecho de crear varias combinaciones de armas y objetos parece indicar una cierta rejugabilidad, aunque habrá que esperar para conocer más detalles.\r\n\r\nSobre las plataformas en las que llegará, únicamente está confirmado el PC por el momento. Está publicado por Gearbox y tiene su fecha de lanzamiento fijada para el año 2023. El último título de Heart Machine, Solar Ash, sigue siendo exclusivo de la Epic Games Store en ordenadores, aunque también ha llegado en formato digital a PlayStation, estando disponible en PS4 y PS5.', 'Hyper Light Breaker es el nuevo desarrollo de Heart Machine, que publicó Solar Ash en 2021', 3, 2, '2022-04-04'),
(11, 'Azure Striker GUNVOLT 3 fecha su lanzamiento con un intenso tráiler cargado de acción retro', 'img/NoticiaAzure.jpg', 'Azure Striker Gunvolt fue toda una sorpresa para el catálogo de Nintendo 3DS en 2014, un juego de acción de otra época que apuntaba a los veteranos de los 16 bits que disfrutaron con la serie Mega Man. Tras esta franquicia se encontraba Keiji Inafune, diseñador del bombardero azul y veterano de Capcom en franquicias como Onimusha y Dead Rising.\r\n\r\nEl juego de Inti-Creates nos conquistó con su acción, plataformas y unas pequeñas dosis de RPG, un título que recuerda a la obra de Capcom, pero con su propia personalidad y estilo. En 2016, la saga continuaba con su segunda aventura, y posteriormente, ambas serían recogidas en una colección adaptada a Nintendo Switch: Azure Striker Gunvolt: Striker Pack.\r\n\r\nFinalmente, su tercera entrega fija su fecha de lanzamiento para el próximo 28 de julio en Nintendo Switch, y lo hará a través de la Nintendo eShop, contando también con una edición física por parte de Limited Run Games, tal y como ha compartido Gematsu. La nueva incorporación de Azure Striker Gunvolt 3 es Kirin, una hábil luchadora con la espada que también puede mantener a sus rivales a distancia con sus talismanes.\r\n\r\nSu habilidad especial le permite destruir a los enemigos al instante. Yu Sasahara (Tonari no Kyuuketsuki-san) da voz a Kirin, Kaito Ishikawa (Tobio Kageyama en Haikyu!!) interpretará a Gunvolt y la actriz y cantante, Megu Sakuragawa (Love Live! School Idol Project Series) será Lumen. Azure Striker Gunvolt 3 nos transporta a un futuro distópico donde la humanidad ha despertado nuevos poderes a los que nuestra sacerdotisa Kirin tendrá que hacer frente.\r\n', 'El juego de Nintendo Switch está producido por Keiji Inafune, veterano de Capcom y diseñador de Mega Man', 3, 2, '2022-04-04'),
(12, 'Xbox Game Pass prepara su llegada a más países en un plan para ganar millones de suscriptores', 'img/NoticiaXboxPass.jpg', 'Es cierto que esta semana se ha anunciado el nuevo PS Plus de PlayStation, pero si hay un servicio de suscripción que lidera la carrera por el momento ese es seguramente el de Microsoft. Además de multitud de juegos en su catálogo, Xbox Game Pass cada vez acumula más usuarios, y la idea es que la cifra crezca todavía más.\r\n\r\nPara ello, en la compañía de Redmond tienen planes para expandir el servicio a todos los lugares del planeta. Tal y como recoge Game World Observer, Game Pass planea llegar al sudeste asiático este mismo año, concretamente a finales de 2022. De esta manera, la suscripción aterrizaría en Indonesia, Malasia, Filipinas, Tailandia y Vietnam.\r\n\r\nQué tienen en común todos estos territorios? Aparte de ser una zona muy específica de Asia, cuentan con millones de jugadores en PC, por lo que llevar el servicio a los ordenadores de estos países puede hacer que ganen un grueso de usuarios todavía mayor. Los datos del analista Daniel Ahmad indican que hay más de 160 millones de jugadores de PC en estos mercados, y la suscripción reduciría la barrera de entrada para los juegos premium de ordenador.\r\n\r\nAprovechar el crecimiento de estos mercados no es el único objetivo de Microsoft con Game Pass. Sin ir más lejos, esta semana hemos sabido que estrenará un plan familiar para que sea más barato hacerse con el servicio en sí, y la apuesta de Xbox sigue siendo fuerte, por más que para Phil Spencer no haya un modelo ganador en la industria.', 'El servicio de suscripción de Microsoft llegará este año al sudeste asiático, que cuenta con muchos jugadores en PC.', 1, 2, '2022-04-04'),
(13, 'Los videojuegos destacados de abril: un top lanzamientos con RPG, juegos deportivos y acción', 'img/NoticiaTopJuegosAbril.jpg', 'Llevamos unas cuantas semanas disfrutando de un montón de juegazos en PC y consolas, así que no viene mal que abril sea un mes algo más tranquilo en lo que se refiere al lanzamiento de nuevos videojuegos. ¿Significa esto que no hay nada interesante en el horizonte? Nada más lejos de la realidad porque durante las próximas cuatro semanas vamos a poder disfrutar de algunos juegos tan interesantes como el esperado LEGO Star Wars: The Skywalker Saga, el remake del legendario Chrono Cross o el nuevo juego deportivo de la Gran N, Nintendo Switch Sports.\r\n\r\nY ya que hablamos de la consola híbrida… en abril se estrenan también juegos tan geniales como 13 Sentinels: Aegis Rim tras su paso por PS4, además del remake de The House of the Dead o la adaptación del ya clásico Star Wars: El Poder de la Fuerza. Los jugadores de PC, por su parte, tendrán la oportunidad de disfrutar al fin de la versión final del interesante King Arthur: Knight’s Tale, que combina rol y estrategia por turnos en un oscuro mundo de fantasía artúrica.\r\n\r\nEn consolas Xbox se estrena Godfall, uno de los primeros juegos que desembarcaron en PlayStation 5 (además de PC), y ambas plataformas de nueva generación recibirán también su versión específica de Chernobylite.\r\n\r\n- LEGO Star Wars: The Skywalker Saga (PC, PS4, Switch, XOne) - 5 de abril\r\n- MLB The Show 22 (PS5, XSeries, Switch, PS4, XOne) - 5 de abril\r\n- Chrono Cross: The Radical Dreamers Edition (PC, Switch, PS4, Xone) - 7 de abril\r\n- Godfall (XSeries, XOne) - 7 de abril\r\n- Hello Neighbor 2 (PC, XSeries, XOne, PS4)  7 de abril\r\n- The House of the Dead: Remake (Switch) - 7 de abril\r\n- Total War: Medieval 2 (iOS, Android) - 7 de abril\r\n- 13 Sentinels: Aegis Rim (Switch) - 12 de abril\r\n- Hearthstone: Viaje a la Ciudad Sumergida (PC, iOS, Android) - 12 de abril\r\n- Road 96 (PS5, XSeries, PS4, XOne) - 15 de abril\r\n- Postal 4: No Regerts (PC) - 20 de abril\r\n- Star Wars: El Poder de la Fuerza (Switch) - 20 de abril\r\n- Chernobylite (XSeries, PS5) - 21 de abril\r\n- MotoGP 22 (PC, PS5, XSeries, XOne, PS4, Switch) - 21 de abril\r\n- King Arthur: Knight’s Tale (PC) - 26 de abril\r\n- The Stanley Parable: Ultra Deluxe (Switch, XSeries, PS5, XOne, PS4) - 27 de abril\r\n- Vampire The Masquerade: Bloodhunt (PC, PS5) - 27 de abril\r\n- Nintendo Switch Sports (Switch) - 29 de abril', 'Las próximas semanas nos esperan videojuegos de lo más interesantes.', 4, 2, '2022-04-04');


--
-- Volcado de datos para la tabla `tienda`
--
INSERT INTO `tienda` (`Vendedor`, `Articulo`, `Precio`, `Descripcion`, `Caracteristica`) VALUES
('6', '4', '20', 'Es muy divertido pero gasta mucho tiempo', 'Nuevo'),
('6', '4', '19', 'Me compre otro sin querer y lo quiero vender también', 'Destacado');


--
-- Volcado de datos para la tabla `categorias`
--
INSERT INTO `categorias` (`Nombre`, `Descripcion`) VALUES
('Nuevo', 'Estos son los últimos juegos que han salido al mercado, aquí encontrarás lo último de la industria'),
('Mas vendidos', 'Aquí encontrarás a los juegos más vendidos de los últimos tiempos'),
('GOTY', 'Estos juegos han sido los mejores que fueron lanzados en su respectivo año'),
('RPG', 'Quieres tener tu propio personaje y personalizarlo a tu modo en mundos gigantescos donde tus acciones tienen consecuencias? Este es el lugar correcto'),
('MMO', 'Te interesa formar grupos con jugadores alrededor del globo para completar eventos o competir para ser el mejor? Entonces los MMO son tu tipo de juego'),
('Sandbox', 'Eres de los que quiere hacer su propia casa en un videojuego, recogiendo materiales y recursos de un mundo prácticamente infinito, donde el límite es tu imaginación? Entonces los Sandbox son perfectos para tí'),
('Simulador', 'Tanto si quieres simular que tienes una granja y recoger cultivos, como si quieres aventurarte a la infinidad del espacio, habrá un juego de Simulación que se adapte a tus necesidades'),
('Shooter', 'No hay nada mejor que cuando le haces un 360 noscope a ese jugador que no se ha movido de esa esquina en toda la partida y que te ha matado 3 veces seguidas'),
('Battle Royale', 'Donde caemos gente? En los Battle Royale tendrás que sobrevivir en un entorno cada vez más pequeño hasta ser el último hombre en pie, o el último escuadrón en pie');

--
-- Volcado de datos para la tabla `juegoCategoria`
--
INSERT INTO `juegoCategoria` (`juego`, `categoria`) VALUES
(1, 1),
(1, 4),
(2, 6),
(3, 4),
(4, 7);


--
-- Volcado de datos para la tabla `eventos`
--
INSERT INTO `Eventos`(`id`, `userid`, `title`, `startDate`, `endDate`, `backgroundColor`, `isPublic`) VALUES 
('1','1','Evento Público','2022-04-27 00:00','2022-04-28 00:00', '#be27b2', 'true'),
('2','1','Evento Privado','2022-05-27 15:00','2022-05-29 16:00', '#be27b2', 'false');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
