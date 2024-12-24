-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 19-11-2024 a las 16:41:04
-- Versión del servidor: 5.7.24
-- Versión de PHP: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tinder`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coincidencias`
--

CREATE TABLE `coincidencias` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_usuario_objetivo` int(11) NOT NULL,
  `accion` enum('me_gusta','no_me_gusta') NOT NULL,
  `fecha_coincidencia` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `coincidencias`
--

INSERT INTO `coincidencias` (`id`, `id_usuario`, `id_usuario_objetivo`, `accion`, `fecha_coincidencia`) VALUES
(1, 2, 3, 'me_gusta', '2024-11-10 17:31:08'),
(2, 2, 5, 'me_gusta', '2024-11-10 17:31:08'),
(3, 3, 2, 'me_gusta', '2024-11-10 17:31:08'),
(5, 5, 6, 'me_gusta', '2024-11-10 17:31:08'),
(6, 10, 1, 'me_gusta', '2024-11-12 12:13:00'),
(7, 11, 1, 'no_me_gusta', '2024-11-12 12:18:15'),
(8, 8, 1, 'me_gusta', '2024-11-12 12:18:54'),
(9, 8, 2, 'no_me_gusta', '2024-11-12 12:29:49'),
(10, 11, 2, 'me_gusta', '2024-11-12 12:32:32'),
(11, 8, 3, 'no_me_gusta', '2024-11-12 12:32:42'),
(12, 8, 4, 'no_me_gusta', '2024-11-12 12:35:45'),
(13, 11, 3, 'me_gusta', '2024-11-12 12:37:34'),
(14, 11, 4, 'me_gusta', '2024-11-12 12:37:40'),
(15, 11, 5, 'no_me_gusta', '2024-11-12 12:37:46'),
(16, 11, 6, 'no_me_gusta', '2024-11-12 12:37:48'),
(17, 11, 7, 'no_me_gusta', '2024-11-12 12:37:50'),
(18, 11, 8, 'me_gusta', '2024-11-12 12:37:56'),
(19, 11, 9, 'no_me_gusta', '2024-11-12 12:38:02'),
(20, 11, 10, 'me_gusta', '2024-11-12 12:38:05'),
(21, 10, 2, 'me_gusta', '2024-11-12 12:45:35'),
(22, 12, 1, 'no_me_gusta', '2024-11-12 15:10:22'),
(23, 12, 2, 'me_gusta', '2024-11-12 15:10:33'),
(24, 12, 3, 'no_me_gusta', '2024-11-12 15:11:28'),
(25, 12, 4, 'no_me_gusta', '2024-11-12 15:12:00'),
(26, 12, 5, 'no_me_gusta', '2024-11-12 15:12:05'),
(27, 12, 6, 'no_me_gusta', '2024-11-12 15:12:25'),
(28, 12, 7, 'no_me_gusta', '2024-11-12 15:12:31'),
(29, 12, 8, 'no_me_gusta', '2024-11-12 15:12:47'),
(30, 12, 9, 'no_me_gusta', '2024-11-12 15:13:15'),
(31, 12, 10, 'me_gusta', '2024-11-12 15:13:39'),
(32, 12, 11, 'me_gusta', '2024-11-12 15:13:58'),
(33, 11, 12, 'me_gusta', '2024-11-12 16:24:57'),
(34, 13, 1, 'no_me_gusta', '2024-11-12 16:33:00'),
(35, 13, 2, 'no_me_gusta', '2024-11-12 16:33:04'),
(36, 13, 3, 'no_me_gusta', '2024-11-12 16:33:07'),
(37, 13, 4, 'no_me_gusta', '2024-11-12 16:33:10'),
(38, 13, 5, 'me_gusta', '2024-11-12 16:33:14'),
(39, 1, 2, 'me_gusta', '2024-11-12 16:47:49'),
(40, 10, 3, 'no_me_gusta', '2024-11-19 15:49:48'),
(43, 10, 5, 'no_me_gusta', '2024-11-19 16:02:34'),
(44, 10, 6, 'no_me_gusta', '2024-11-19 16:02:37'),
(45, 10, 7, 'no_me_gusta', '2024-11-19 16:02:41'),
(49, 1, 8, 'me_gusta', '2024-11-19 16:24:26'),
(51, 10, 12, 'me_gusta', '2024-11-19 16:30:19'),
(52, 10, 4, 'no_me_gusta', '2024-11-19 16:30:41'),
(53, 10, 8, 'me_gusta', '2024-11-19 16:30:48'),
(54, 8, 10, 'me_gusta', '2024-11-19 16:32:10'),
(55, 14, 1, 'me_gusta', '2024-11-19 16:34:21'),
(56, 14, 2, 'no_me_gusta', '2024-11-19 16:34:24'),
(57, 14, 3, 'no_me_gusta', '2024-11-19 16:34:29'),
(58, 14, 4, 'no_me_gusta', '2024-11-19 16:34:32'),
(59, 14, 5, 'no_me_gusta', '2024-11-19 16:34:36'),
(60, 14, 6, 'no_me_gusta', '2024-11-19 16:34:39'),
(61, 14, 7, 'no_me_gusta', '2024-11-19 16:34:41'),
(62, 14, 8, 'me_gusta', '2024-11-19 16:34:48'),
(63, 8, 14, 'me_gusta', '2024-11-19 16:35:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos`
--

CREATE TABLE `fotos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `url_foto` varchar(255) NOT NULL,
  `fecha_subida` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `fotos`
--

INSERT INTO `fotos` (`id`, `id_usuario`, `url_foto`, `fecha_subida`) VALUES
(1, 2, 'juan1.jpg', '2024-11-10 17:31:08'),
(2, 2, 'juan2.jpg', '2024-11-10 17:31:08'),
(3, 3, 'maria1.jpg', '2024-11-10 17:31:08'),
(4, 3, 'maria2.jpg', '2024-11-10 17:31:08'),
(5, 4, 'carlos1.jpg', '2024-11-10 17:31:08'),
(6, 5, 'ana1.jpg', '2024-11-10 17:31:08'),
(7, 6, 'luis1.jpg', '2024-11-10 17:31:08'),
(8, 7, 'sofia1.jpg', '2024-11-10 17:31:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `id_emisor` int(11) NOT NULL,
  `id_receptor` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_envio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `id_emisor`, `id_receptor`, `mensaje`, `fecha_envio`) VALUES
(1, 5, 8, 'test1', '2024-11-10 17:34:13'),
(2, 2, 1, 'test2', '2024-11-10 17:42:40'),
(3, 1, 2, 'test3', '2024-11-10 17:42:51'),
(4, 1, 2, 'test4', '2024-11-10 17:43:00'),
(5, 2, 1, 'test5', '2024-11-10 17:43:09'),
(6, 2, 1, 'test6\r\n', '2024-11-10 17:43:21'),
(7, 4, 1, 'test7', '2024-11-10 17:45:57'),
(8, 7, 1, 'test8', '2024-11-10 17:46:12'),
(9, 2, 1, 'test9', '2024-11-10 19:05:32'),
(10, 1, 2, 'test10', '2024-11-10 19:42:52'),
(11, 10, 2, 'hola', '2024-11-12 12:39:47'),
(12, 2, 10, 'hi', '2024-11-12 12:40:40'),
(13, 2, 10, 'que haces', '2024-11-12 12:40:48'),
(14, 10, 2, 'nada', '2024-11-12 12:41:03'),
(15, 10, 2, 'y vos', '2024-11-12 12:41:09'),
(16, 2, 10, 'https://youtu.be/dQw4w9WgXcQ', '2024-11-12 12:48:31'),
(17, 2, 10, 'hi', '2024-11-12 12:59:24'),
(18, 1, 2, 'vnvnvnv', '2024-11-12 15:01:25'),
(19, 2, 1, 'te extrañe ', '2024-11-12 15:02:32'),
(20, 1, 2, 'cuando abren el scv', '2024-11-12 15:02:56'),
(21, 2, 1, 'HOY A LAS 4', '2024-11-12 15:03:10'),
(22, 2, 1, 'oeee care root', '2024-11-12 15:04:00'),
(23, 1, 2, 'boot', '2024-11-12 15:04:04'),
(24, 2, 1, 'pegelo', '2024-11-12 15:04:18'),
(25, 1, 2, 'nel', '2024-11-12 15:04:20'),
(26, 2, 10, 'junior', '2024-11-12 15:08:19'),
(27, 2, 10, 'junior', '2024-11-12 15:08:36'),
(28, 12, 10, 'hola corazon', '2024-11-12 15:13:29'),
(29, 12, 11, 'hola corazon', '2024-11-12 15:13:50'),
(30, 11, 12, 'jajajja', '2024-11-12 16:24:07'),
(31, 11, 12, 'hola re yy', '2024-11-12 16:24:17'),
(32, 11, 12, 'hola ando cachon', '2024-11-12 16:29:25'),
(33, 13, 6, 'hola ando cachon', '2024-11-12 16:33:21'),
(34, 1, 13, 'hi', '2024-11-12 16:33:59'),
(35, 13, 1, 'hola ando cachon', '2024-11-12 16:34:19'),
(36, 1, 13, 'hi', '2024-11-12 16:34:25'),
(37, 1, 13, '1+13', '2024-11-12 16:34:33'),
(38, 13, 1, '14', '2024-11-12 16:34:40'),
(39, 1, 13, '-1', '2024-11-12 16:34:43'),
(40, 13, 1, '12+1', '2024-11-12 16:35:06'),
(41, 10, 11, 'shdgfswd', '2024-11-19 16:29:01'),
(42, 10, 9, 'hdtfgkuh', '2024-11-19 16:30:56'),
(43, 8, 10, 'hola', '2024-11-19 16:32:20'),
(44, 8, 14, 'hi', '2024-11-19 16:35:55'),
(45, 14, 8, 'hola', '2024-11-19 16:36:15'),
(46, 8, 14, 'good bay', '2024-11-19 16:36:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `genero` enum('hombre','mujer','otro') NOT NULL,
  `rol` enum('admin','usuario') DEFAULT NULL,
  `biografia` text,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_usuario`, `correo`, `contrasena`, `genero`, `rol`, `biografia`, `foto_perfil`, `fecha_creacion`) VALUES
(1, 'root', 'root@root.com', 'root', 'hombre', 'admin', 'root', '../root.png', '2024-11-10 17:31:08'),
(2, 'juan', 'juan@example.com', '12345', 'hombre', 'usuario', 'Me encanta la tecnología y los deportes', '2_1358222.jpeg', '2024-11-10 17:31:08'),
(3, 'maria', 'maria@example.com', '12345', 'mujer', 'usuario', 'Amo viajar y descubrir nuevas culturas', 'maria.jpg', '2024-11-10 17:31:08'),
(4, 'carlos', 'carlos@example.com', '12345', 'hombre', 'usuario', 'Amante del cine y la música', 'carlos.jpg', '2024-11-10 17:31:08'),
(5, 'ana', 'ana@example.com', '12345', 'mujer', 'usuario', 'Me apasiona la naturaleza y el senderismo', 'ana.jpg', '2024-11-10 17:31:08'),
(6, 'luis', 'luis@example.com', '12345', 'hombre', 'usuario', 'Me encanta leer libros de ciencia ficción', 'luis.jpg', '2024-11-10 17:31:08'),
(7, 'sofia', 'sofia@example.com', '12345', 'mujer', 'usuario', 'Apasionada por el arte y la fotografía', 'sofia.jpg', '2024-11-10 17:31:08'),
(8, 'Geronimo Gonzalez C', 'ggonzalezc@unitecnica.net', '1054856940', 'hombre', 'usuario', 'Let My Solo Her', 'Geronimo Gonzalez C_admin_1337508.png', '2024-11-10 20:00:44'),
(9, 'deleteme', 'deleteme1@example.com', '12345', 'mujer', 'usuario', '123', 'deleteme_usuario_1336916.png', '2024-11-10 20:01:53'),
(10, 'Junior', 'juniororozco23@outlook.es', '12345678', 'mujer', 'usuario', 'Hello Mate, what´s up?', 'Junior_2_1.jpg', '2024-11-12 12:12:28'),
(11, 'esteban', 'eb.garay@unitecnica.net', '123456', 'hombre', 'usuario', 'Estteban Brr', 'esteban_2_istockphoto-1690733685-640x640.jpg', '2024-11-12 12:17:06'),
(12, 'Daniela ', 'daniela@gmail.com', '12345678', 'mujer', 'usuario', 'Soy daniela', 'daniela _2_istockphoto-1368424494-612x612.jpg', '2024-11-12 15:10:07'),
(13, 'Arturo', 'artu.@unitecnica.net', '12345', 'otro', 'usuario', 'Ando cachondo', 'Arturo_2_images.jpeg', '2024-11-12 16:31:32'),
(14, 'daniiii', 'dani@dani.com', '123456', 'hombre', 'usuario', 'soy dani', 'dani_2_6-c5cfcac6d4fa7620c817155635217040-1024-1024.png', '2024-11-19 16:33:53');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `coincidencias`
--
ALTER TABLE `coincidencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_usuario_objetivo` (`id_usuario_objetivo`);

--
-- Indices de la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_emisor` (`id_emisor`),
  ADD KEY `id_receptor` (`id_receptor`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `coincidencias`
--
ALTER TABLE `coincidencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `fotos`
--
ALTER TABLE `fotos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `coincidencias`
--
ALTER TABLE `coincidencias`
  ADD CONSTRAINT `coincidencias_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coincidencias_ibfk_2` FOREIGN KEY (`id_usuario_objetivo`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD CONSTRAINT `fotos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`id_emisor`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`id_receptor`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
