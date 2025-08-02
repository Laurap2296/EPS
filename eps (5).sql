-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-06-2025 a las 03:09:37
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
CREATE DATABASE IF NOT EXISTS `eps` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `eps`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funcionarios`
--

DROP TABLE IF EXISTS `funcionarios`;
CREATE TABLE IF NOT EXISTS `funcionarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `tipo_documento` varchar(20) NOT NULL,
  `documento` varchar(20) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `documento` (`documento`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `nombre`, `apellidos`, `tipo_documento`, `documento`, `clave`, `fecha_registro`) VALUES
(1, 'gianna sofia', 'galvis arias', 'cedula de ciudadania', '1067821264', 'Funcionario123', '2025-05-12 12:12:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invitados`
--

DROP TABLE IF EXISTS `invitados`;
CREATE TABLE IF NOT EXISTS `invitados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `tipo_documento` varchar(20) NOT NULL,
  `documento` varchar(20) NOT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `tipo_usuario` enum('invitado') DEFAULT 'invitado',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `clave` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `documento` (`documento`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

DROP TABLE IF EXISTS `notificaciones`;
CREATE TABLE IF NOT EXISTS `notificaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pqrs` int(11) DEFAULT NULL,
  `mensaje` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('normal','urgente','muy urgente') DEFAULT 'normal',
  PRIMARY KEY (`id`),
  KEY `id_pqrs` (`id_pqrs`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pqrs`
--

DROP TABLE IF EXISTS `pqrs`;
CREATE TABLE IF NOT EXISTS `pqrs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `pdf` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tipo_emisor` (`tipo_emisor`,`id_emisor`),
  KEY `fk_funcionario` (`id_funcionario`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(10, 'Sugerencia', 'Implementar citas en línea', 'Sugiero que la EPS implemente un sistema de citas médicas en línea para facilitar la programación y reducir los tiempos de espera.', '1747495729_paisaje_kamkuama.jpg.jpg', '2025-05-17 17:28:49', 'respondida', 'invitado', 2, 1, 'trdururytfyhujftyujtyfhuyuj', 'respuesta_pqrs_10.pdf', 'pqrs_1747495729.pdf'),
(11, 'Queja', 'Queja por demoras en la asignación de citas médicas', 'Señores\r\nKAMKUAMA IPS\r\nÁrea de Atención al Usuario\r\n\r\nCordial saludo:\r\n\r\nPor medio de la presente, me permito presentar una queja formal debido a las constantes demoras y dificultades para acceder a los servicios de salud a través de su entidad.\r\n\r\nSoy afiliado(a) a la EPS desde hace varios años (Número de afiliación: 123456789), y desde el pasado mes he intentado agendar una cita con medicina general sin obtener respuesta oportuna. A pesar de realizar múltiples llamadas a su línea de atención y de intentar programarla por la aplicación y página web, siempre aparece la misma respuesta: \"No hay disponibilidad\".\r\n\r\nEsta situación afecta mi derecho fundamental a la salud, ya que requiero atención médica para una condición que no puede seguir esperando. Además, no he recibido información clara sobre cuándo habrá disponibilidad ni alternativas viables de atención.\r\n\r\nSolicito de manera respetuosa una solución inmediata, así como una explicación de las razones por las cuales no se está garantizando el acceso oportuno a los servicios médicos.\r\n\r\nAgradezco la atención prestada y quedo atenta(o) a una pronta respuesta.\r\n\r\nAtentamente,\r\nJuan Pérez\r\nC.C. 1.234.567.890\r\nTel: 300 123 4567\r\nCorreo: juan.perez@email.com\r\nCiudad: valledupar\r\nFecha: 31 de mayo de 2025', '', '2025-05-31 21:23:03', 'pendiente', 'usuario', 1, NULL, NULL, NULL, 'pqrs_1748719383.pdf'),
(12, 'peticion', ': Solicitud de autorización para examen médico', 'Señores\r\nKAMKUAMA\r\nÁrea de Atención al Usuario\r\n\r\nCordial saludo:\r\n\r\nYo, Juan Pérez, identificado con cédula de ciudadanía No. 1.234.567.890, afiliado a su EPS, me permito solicitar la autorización para la realización del examen de laboratorio (especificar el examen, por ejemplo, hemograma completo), prescrito por mi médico tratante el día 20 de mayo de 2025.\r\n\r\nEste examen es fundamental para el seguimiento y diagnóstico adecuado de mi tratamiento. Agradecería que se me informe el procedimiento para obtener la autorización y la programación del mismo a la brevedad posible.\r\n\r\nQuedo atento a su pronta respuesta.\r\n\r\nAtentamente,\r\nJuan Pérez\r\nTeléfono: 300 123 4567\r\nCorreo: juan.perez@email.com\r\nCiudad: VALLEDUPAR\r\nFecha: 31 de mayo de 2025', '', '2025-05-31 21:26:09', 'pendiente', 'usuario', 1, NULL, NULL, NULL, 'pqrs_1748719569.pdf'),
(13, 'peticion', 'Mal servicio por parte del personal', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam eget sem at orci mollis finibus. Duis rhoncus, dui eget ultricies dapibus, arcu mi dictum risus, et porta velit arcu at ante. Vestibulum porttitor pellentesque sagittis. Aenean maximus eros at elementum commodo. Pellentesque nec venenatis ipsum. Mauris tincidunt varius eros laoreet aliquet. Donec tincidunt mauris a urna laoreet laoreet. Integer vitae diam leo.\r\n\r\nEtiam maximus dolor quis facilisis efficitur. Mauris porttitor commodo mattis. Sed posuere est a mollis volutpat. Fusce condimentum laoreet sem, in ultrices ante euismod nec. Duis a mattis sem. Aenean non imperdiet mi. Donec vitae volutpat urna, sed dignissim nisl. Aliquam et dapibus tellus, quis convallis ipsum. Phasellus nisl diam, luctus nec sollicitudin in, ultricies in purus. Quisque bibendum tortor quam, id pharetra nulla aliquam eget. Vivamus id ornare orci, sed cursus quam. Duis hendrerit, eros id ultricies vehicula, ex ipsum lobortis metus, sed fermentum mi odio id nunc. Ut id eros eu dui dictum consectetur.\r\n\r\nIn ut dui mattis, commodo eros eu, pharetra lorem. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec tempus malesuada nulla, vitae sodales enim mattis eget. Integer eget dui consequat, imperdiet mauris a, vulputate velit. Sed dapibus accumsan felis a rhoncus. Praesent porttitor consectetur metus, eu pharetra odio ornare sed. Cras porttitor sem et pharetra luctus.\r\n\r\nNam non tellus facilisis, iaculis dolor ut, placerat nunc. Praesent faucibus n', '1748962303_historia-de-la-tecnologia.jpg', '2025-06-03 16:51:43', 'Respondida', 'usuario', 1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus egestas metus ut mi posuere commodo. Aenean lobortis vulputate turpis, quis tempus velit accumsan ac. Ut pharetra posuere metus quis varius. Suspendisse nec laoreet nulla, a aliquam eros. Praesent aliquam dolor diam, at elementum sapien tincidunt non. Ut a tellus dictum, malesuada orci sit amet, pharetra ipsum. Integer vel enim mattis, vestibulum arcu vel, vestibulum magna. Sed urna orci, pharetra a egestas vitae, viverra vitae tortor.\r\n\r\nProin a auctor felis, eu hendrerit arcu. In commodo ligula diam, non porttitor dui cursus nec. Suspendisse odio lectus, accumsan sed varius eu, eleifend non metus. Sed vel cursus metus, vitae sodales quam. Cras semper massa lorem, vitae faucibus lorem condimentum in. Praesent gravida vestibulum ipsum, id hendrerit justo maximus eu. Mauris quis ipsum elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Pellentesque et convallis ipsum. Aliquam feugiat iaculis dolor, vitae blandit augue vehicula eu. Vivamus sollicitudin erat nec nibh ornare, nec aliquet velit laoreet.\r\n\r\nAliquam dapibus magna ac laoreet sagittis. Ut ac quam eu lorem ultricies varius in consequat orci. Donec a lectus diam. Cras euismod accumsan feugiat. Praesent sagittis dictum leo, non rhoncus mauris vulputate a. Donec non facilisis orci. Maecenas a tortor a orci eleifend imperdiet eu laoreet erat. Nam diam felis, elementum quis mauris vel, consequat malesuada sapien. In in consectetur lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae;\r\n\r\nNullam quis erat posuere, pulvinar leo eu, aliquam lectus. In sit amet neque a tellus dictum mollis. Aliquam erat volutpat. Sed lobortis quam lacinia purus rhoncus tincidunt. Mauris malesuada, erat nec venenatis placerat, diam tortor dapibus arcu, mattis sodales neque arcu vel ante. Sed eget enim libero. Integer quis est tellus. Cras urna ligula, luctus quis dapibus ut, eleifend et libero. Donec vestibulum vulputate sem, vestibulum ullamcorper est elementum nec. Nam malesuada orci velit, sed varius mi pellentesque quis.', 'respuesta_pqrs_13_1748962612.pdf', 'pqrs_1748962303.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

DROP TABLE IF EXISTS `reportes`;
CREATE TABLE IF NOT EXISTS `reportes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_report` enum('pqrs','encuestas') NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta_encuesta`
--

DROP TABLE IF EXISTS `respuesta_encuesta`;
CREATE TABLE IF NOT EXISTS `respuesta_encuesta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_emisor` enum('usuario','invitado') DEFAULT NULL,
  `id_emisor` int(11) NOT NULL,
  `resuelta` varchar(10) DEFAULT NULL,
  `explicacion` text DEFAULT NULL,
  `satisfaccion` varchar(50) DEFAULT NULL,
  `comentarios` text DEFAULT NULL,
  `fecha_respuesta` datetime DEFAULT NULL,
  `id_pqrs` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `respuesta_encuesta`
--

INSERT INTO `respuesta_encuesta` (`id`, `tipo_emisor`, `id_emisor`, `resuelta`, `explicacion`, `satisfaccion`, `comentarios`, `fecha_respuesta`, `id_pqrs`) VALUES
(1, 'usuario', 1, 'No', 'fsgdhfgh', 'Insatisfecho', 'hfhdfhgxhxdfh', '2025-05-14 23:50:56', 1),
(2, 'usuario', 1, 'No', 'tyteyetuhtry', 'Insatisfecho', 'tyterytertet', NULL, 2),
(3, 'usuario', 1, 'Si', '', 'Muy satisfecho', 'gracias', NULL, 3),
(4, 'invitado', 2, 'No', 'no me brindarona tencion', 'Insatisfecho', 'tyfuityikfukijfuitfykuy', '2025-05-17 14:18:10', 10),
(5, 'usuario', 1, 'Sí', NULL, 'Muy satisfecho', 'ghracas', '2025-05-17 14:19:13', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `documento` (`documento`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `tipo_documento`, `documento`, `celular`, `direccion`, `correo`, `tipo_usuario`, `clave`, `fecha_registro`, `estado`) VALUES
(1, 'laura', 'arias arias', 'cedula de ciudadania', '1065821822', '3107095704', 'manzana 6 casa 22', 'laurapatricia2409@gmail.com', 'afiliado', '1065821822', '2025-05-12 12:11:59', 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `fk_notificaciones_pqrs` FOREIGN KEY (`id_pqrs`) REFERENCES `pqrs` (`id`),
  ADD CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`id_pqrs`) REFERENCES `pqrs` (`id`);

--
-- Filtros para la tabla `pqrs`
--
ALTER TABLE `pqrs`
  ADD CONSTRAINT `fk_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id`),
  ADD CONSTRAINT `fk_pqrs_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
