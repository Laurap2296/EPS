-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-05-2025 a las 00:52:00
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
(1, 'Petición', 'Mal servicio por parte del personal', 'fdgfsgashgdf', '', '2025-05-14 22:33:41', 'respondida', 'usuario', 1, 1, 'Reciba un cordial saludo.\r\n En atenciÃ³n a su comunicaciÃ³n registrada bajo el nÃºmero de radicado PQRS-#1, presentada el\r\n dÃa 12/05/2025, en la cual manifiesta su inconformidad relacionada con el trato recibido por parte\r\n del personal durante su atenciÃ³n en nuestra instituciÃ³n, nos permitimos informarle lo siguiente:\r\n En primer lugar, lamentamos sinceramente los inconvenientes presentados y le ofrecemos\r\n disculpas por la experiencia negativa vivida. Kamkuama IPS estÃ¡ comprometida con brindar una\r\n atenciÃ³n humanizada, respetuosa y de calidad a todos nuestros usuarios, por lo que este tipo de\r\n situaciones no reflejan nuestros principios ni nuestros estÃ¡ndares de servicio.\r\n Una vez recibida su queja, se iniciÃ³ la verificaciÃ³n interna correspondiente. Se entrevistÃ³ al\r\n personal involucrado y se revisaron los registros del dÃa seÃ±alado. Como resultado de esta\r\n revisiÃ³n, se ha procedido a tomar las acciones correctivas pertinentes con el fin de evitar que\r\n situaciones similares se repitan.\r\n Le agradecemos por tomarse el tiempo de notificarnos esta situaciÃ³n, ya que sus observaciones\r\n nos permiten mejorar continuamente nuestros servicios.\r\n Para cualquier inquietud adicional, no dude en comunicarse con nuestra Oficina de AtenciÃ³n al\r\nUsuario al correo electrÃ³nico atencionalusuario@kamkuamaips.com o al telÃ©fono 0655896421.', 'respuesta_pqrs_1.pdf', 'pqrs_1747254821.pdf'),
(2, 'Petición', 'ghfgjfh', 'fghjfghjhgcjh', '', '2025-05-14 22:49:00', 'respondida', 'usuario', 1, 1, 'afdjieufwrugksfjhrgsjfdkhgshgosdhrwgykjfshvgiuefrhgrwughkfdjsghñor8ugfrhwowtr89urjhoirwhfroiugfgfsffs', 'respuesta_pqrs_2.pdf', 'pqrs_1747255740.pdf'),
(3, 'queja', 'reghfjhf', 'fgjfdfdgj', '', '2025-05-14 23:07:40', 'respondida', 'usuario', 1, 1, 'yrurturyurdyiutoidgfjkmghktdijketdu', 'respuesta_pqrs_3.pdf', 'pqrs_1747256860.pdf'),
(4, 'Sugerencia', 'rthxgchhjgf', 'htyrytzrdtgeryt', '1747257028_WhatsApp Image 2025-04-22 at 4.21.06 PM.jpeg', '2025-05-14 23:10:28', 'respondida', 'usuario', 1, 1, 'rytdrtyhdfghujyudryudyu', 'respuesta_pqrs_4.pdf', 'pqrs_1747257028.pdf'),
(5, 'reclamo\r\n', 'Mal servicio por parte del personal', 'hsthsthst', '1747258692_OIP (1).jfif', '2025-05-14 23:38:12', 'pendiente', 'usuario', 1, NULL, NULL, NULL, 'pqrs_1747258692.pdf'),
(6, 'reclamo\r\n', 'hdghd', 'fhfdfh', '1747258720_WhatsApp Image 2025-03-11 at 5.02.09 PM (3).jpeg', '2025-05-14 23:38:40', 'pendiente', 'usuario', 1, NULL, NULL, NULL, 'pqrs_1747258720.pdf'),
(7, 'peticion', ' Solicitud de información sobre cobertura médica', 'Solicito información detallada sobre la cobertura del plan de salud que ofrece Kamkuama IPS, específicamente sobre la atención en especialidades y medicamentos incluidos.', '', '2025-05-17 17:26:55', 'pendiente', 'invitado', 2, NULL, NULL, NULL, 'pqrs_1747495615.pdf'),
(8, 'peticion', ' Atención demorada en citas médicas', 'He tenido que esperar más de dos horas para ser atendido en la consulta médica, lo cual considero un mal servicio. Solicito que mejoren la puntualidad en la atención.', '', '2025-05-17 17:27:35', 'pendiente', 'invitado', 2, NULL, NULL, NULL, 'pqrs_1747495655.pdf'),
(9, 'Reclamo', 'Cobro incorrecto en factura', 'En mi última factura aparece un cobro por un medicamento que no me entregaron. Solicito la corrección del valor cobrado y la devolución correspondiente si aplica.', '', '2025-05-17 17:28:08', 'pendiente', 'invitado', 2, NULL, NULL, NULL, 'pqrs_1747495688.pdf'),
(10, 'Sugerencia', 'Implementar citas en línea', 'Sugiero que la EPS implemente un sistema de citas médicas en línea para facilitar la programación y reducir los tiempos de espera.', '1747495729_paisaje_kamkuama.jpg.jpg', '2025-05-17 17:28:49', 'respondida', 'invitado', 2, 1, 'trdururytfyhujftyujtyfhuyuj', 'respuesta_pqrs_10.pdf', 'pqrs_1747495729.pdf');

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
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documento` (`documento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pqrs`
--
ALTER TABLE `pqrs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
