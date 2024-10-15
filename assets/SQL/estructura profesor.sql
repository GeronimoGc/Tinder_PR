-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-10-2024 a las 18:08:37
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto_tinder`
--
CREATE DATABASE IF NOT EXISTS `proyecto_tinder` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci;
USE `proyecto_tinder`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE IF NOT EXISTS `tipo_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` tinytext DEFAULT NULL,
  `detalle` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id`, `tipo`, `detalle`) VALUES
(1, 'Administrador', 'Usuario con permisos de administración'),
(2, 'Cliente', 'Usuario que puede acceder a los servicios del sistema'),
(3, 'Proveedor', 'Usuario que ofrece servicios en la plataforma'),
(4, 'Invitado', 'Usuario con acceso limitado al sistema');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nikname` tinytext DEFAULT NULL,
  `nombres` tinytext DEFAULT NULL,
  `apellidos` tinytext DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `estado` bit(1) DEFAULT NULL,
  `id_tipo_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_usuario_tipo_usuario_idx` (`id_tipo_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nikname`, `nombres`, `apellidos`, `fecha_registro`, `fecha_nacimiento`, `estado`, `id_tipo_usuario`) VALUES
(1, 'jdoe', 'John', 'Doe', '2024-01-01', '1990-05-15', b'1', 1),
(2, 'mgarcia', 'María', 'García', '2024-02-10', '1985-07-20', b'1', 2),
(3, 'rsmith', 'Robert', 'Smith', '2024-03-05', '1992-03-25', b'1', 2),
(4, 'lcortes', 'Luis', 'Cortés', '2024-04-15', '1991-11-30', b'1', 3),
(5, 'jperez', 'Juana', 'Pérez', '2024-05-10', '1980-09-10', b'1', 3),
(6, 'jbrown', 'James', 'Brown', '2024-06-20', '1983-06-08', b'0', 4),
(7, 'aclark', 'Anna', 'Clark', '2024-07-25', '1995-04-12', b'1', 4),
(8, 'fruiz', 'Fernando', 'Ruiz', '2024-08-30', '1988-01-18', b'0', 2),
(9, 'lmontes', 'Laura', 'Montes', '2024-09-15', '1994-12-05', b'1', 1),
(10, 'evargas', 'Ernesto', 'Vargas', '2024-10-05', '1987-02-20', b'1', 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_tipo_usuario` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipo_usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
