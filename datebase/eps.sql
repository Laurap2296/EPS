-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-05-2025 a las 14:07:51
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `eps`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `tipo_documento` varchar(20) NOT NULL,
  `documento` varchar(20) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `nombre`, `apellidos`, `tipo_documento`, `documento`, `clave`, `fecha_registro`) VALUES
(1, 'gianna sofia', 'galvis arias', 'cedula de ciudadania', '1067821264', 'Funcionario123', '2025-05-12 12:12:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invitados`
--

CREATE TABLE `invitados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `tipo_documento` varchar(20) NOT NULL,
  `documento` varchar(20) NOT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `tipo_usuario` enum('invitado') DEFAULT 'invitado',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `clave` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `invitados`
--

INSERT INTO `invitados` (`id`, `nombre`, `apellidos`, `tipo_documento`, `documento`, `celular`, `direccion`, `correo`, `tipo_usuario`, `fecha_registro`, `clave`) VALUES
(2, 'gyan stiphen', 'Arias', 'CC', '1067818958', '3022092240', 'manzana 6 casa 23 buenos aires', 'laurapatricia2409@gmail.com', 'invitado', '2025-05-15 19:47:46', '$2y$10$kY8NVUH5PoIhOOLydXBgnen.HCrqpV7wSiprVb0zNbCVGKicPExsO'),
(3, 'ramiro', 'Galvis Martinez', 'CC', '1065204813', '3046228652', 'manzana 6 casa 23 buenos aires', 'ramiagm94@gmail.com', 'invitado', '2025-05-15 20:08:53', '$2y$10$BlrF6FT1FmdvPHFGQAJQZOW29nqszuFK0zlAjd10W1jsVPhhXxXNu');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL,
  `id_pqrs` int(11) DEFAULT NULL,
  `mensaje` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('normal','urgente','muy urgente') DEFAULT 'normal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pqrs`
--

CREATE TABLE `pqrs` (
  `id` int(11) NOT NULL,
  `tipo_solicitud` varchar(100) NOT NULL,
  `motivo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `fecha_solicitud` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` varchar(50) DEFAULT 'pendiente',
  `tipo_emisor` enum('usuario','invitado') NOT NULL,
  `id_emisor` int(11) NOT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `respuesta` text DEFAULT NULL,
  `respuesta_pdf` varchar(255) DEFAULT NULL,
  `pdf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pqrs`
--

INSERT INTO `pqrs` (`id`, `tipo_solicitud`, `motivo`, `descripcion`, `archivo`, `fecha_solicitud`, `estado`, `tipo_emisor`, `id_emisor`, `id_funcionario`, `respuesta`, `respuesta_pdf`, `pdf`) VALUES
(1, 'Petición', 'Mal servicio por parte del personal', 'fdgfsgashgdf', '', '2025-05-14 22:33:41', 'pendiente', 'usuario', 1, NULL, NULL, NULL, 'pqrs_1747254821.pdf'),
(2, 'Petición', 'ghfgjfh', 'fghjfghjhgcjh', '', '2025-05-14 22:49:00', 'pendiente', 'usuario', 1, NULL, NULL, NULL, 'pqrs_1747255740.pdf'),
(3, 'Consulta', 'reghfjhf', 'fgjfdfdgj', '', '2025-05-14 23:07:40', 'pendiente', 'usuario', 1, NULL, NULL, NULL, 'pqrs_1747256860.pdf'),
(4, 'Sugerencia', 'rthxgchhjgf', 'htyrytzrdtgeryt', '1747257028_WhatsApp Image 2025-04-22 at 4.21.06 PM.jpeg', '2025-05-14 23:10:28', 'pendiente', 'usuario', 1, NULL, NULL, NULL, 'pqrs_1747257028.pdf'),
(5, 'Consulta', 'Mal servicio por parte del personal', 'hsthsthst', '1747258692_OIP (1).jfif', '2025-05-14 23:38:12', 'pendiente', 'usuario', 1, NULL, NULL, NULL, 'pqrs_1747258692.pdf'),
(6, 'Consulta', 'hdghd', 'fhfdfh', '1747258720_WhatsApp Image 2025-03-11 at 5.02.09 PM (3).jpeg', '2025-05-14 23:38:40', 'pendiente', 'usuario', 1, NULL, NULL, NULL, 'pqrs_1747258720.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `id` int(11) NOT NULL,
  `tipo_report` enum('pqrs','encuestas') NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta_encuesta`
--

CREATE TABLE `respuesta_encuesta` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `resuelta` varchar(10) DEFAULT NULL,
  `explicacion` text DEFAULT NULL,
  `satisfaccion` varchar(50) DEFAULT NULL,
  `comentarios` text DEFAULT NULL,
  `fecha_respuesta` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `respuesta_encuesta`
--

INSERT INTO `respuesta_encuesta` (`id`, `id_usuario`, `resuelta`, `explicacion`, `satisfaccion`, `comentarios`, `fecha_respuesta`) VALUES
(1, 1, 'No', 'fsgdhfgh', 'Insatisfecho', 'hfhdfhgxhxdfh', '2025-05-14 23:50:56'),
(2, 1, 'No', 'tyteyetuhtry', 'Insatisfecho', 'tyterytertet', NULL),
(3, 1, 'Si', '', 'Muy satisfecho', 'gracias', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `tipo_documento` varchar(20) NOT NULL,
  `documento` varchar(20) NOT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `tipo_usuario` enum('afiliado','invitado') DEFAULT 'afiliado',
  `clave` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `tipo_documento`, `documento`, `celular`, `direccion`, `correo`, `tipo_usuario`, `clave`, `fecha_registro`, `estado`) VALUES
(1, 'laura patricia', 'arias arias', 'cedula de ciudadania', '1065821822', '3107095704', 'manzana 6 casa 22', 'laurapatricia2409@gmail.com', 'afiliado', '1065821822', '2025-05-12 12:11:59', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documento` (`documento`);

--
-- Indices de la tabla `invitados`
--
ALTER TABLE `invitados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documento` (`documento`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pqrs` (`id_pqrs`);

--
-- Indices de la tabla `pqrs`
--
ALTER TABLE `pqrs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_emisor` (`tipo_emisor`,`id_emisor`),
  ADD KEY `fk_funcionario` (`id_funcionario`);

--
-- Indices de la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `respuesta_encuesta`
--
ALTER TABLE `respuesta_encuesta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documento` (`documento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `invitados`
--
ALTER TABLE `invitados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pqrs`
--
ALTER TABLE `pqrs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `reportes`
--
ALTER TABLE `reportes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `respuesta_encuesta`
--
ALTER TABLE `respuesta_encuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`id_pqrs`) REFERENCES `pqrs` (`id`);

--
-- Filtros para la tabla `pqrs`
--
ALTER TABLE `pqrs`
  ADD CONSTRAINT `fk_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
