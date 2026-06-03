-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 03-06-2026 a las 19:06:19
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
-- Base de datos: `blog`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `categoria_id` int(11) NOT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`categoria_id`, `nombre`, `descripcion`) VALUES
(1, 'Anime', 'Noticias, recomendaciones y análisis de anime.'),
(2, 'Videojuegos', 'Reviews, novedades y opiniones sobre videojuegos.'),
(3, 'Peliculas', 'Recomendaciones sobre las ultimas peliculas en cartelera'),
(4, 'Manga', 'Contenido de calidad.'),
(5, 'Series', 'Las mejores series');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE `comentario` (
  `comentario_id` int(11) NOT NULL,
  `entrada_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `contenido` mediumtext DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentario`
--

INSERT INTO `comentario` (`comentario_id`, `entrada_id`, `usuario_id`, `contenido`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(11, 1, 1, 'hola que tal', '2026-06-03 12:49:09', '2026-06-03 12:49:09'),
(12, 1, 2, 'Hola que tal gente xd', '2026-06-03 12:50:10', '2026-06-03 12:50:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada`
--

CREATE TABLE `entrada` (
  `entrada_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `titulo` varchar(150) DEFAULT NULL,
  `slug` varchar(200) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `contenido` mediumtext DEFAULT NULL,
  `fecha_registro` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `entrada`
--

INSERT INTO `entrada` (`entrada_id`, `usuario_id`, `categoria_id`, `titulo`, `slug`, `imagen`, `contenido`, `fecha_registro`, `fecha_actualizacion`) VALUES
(1, 1, 3, 'Spiderman', 'spiderman', '1780428212-spiderman.jpg', 'Luego de sufrir la picadura de una araña genéticamente modificada, un estudiante de secundaria tímido y torpe adquiere increíbles capacidades como arácnido. Pronto comprenderá que su misión es utilizarlas para luchar contra el mal y defender a sus vecinos.', '2026-06-02 15:23:32', '2026-06-02 15:23:32'),
(2, 1, 1, 'Steins;Gate', 'steins-gate', '1780428935-SteinsGate.webp', 'Un grupo de amigos crea una máquina que envía mensajes al pasado y altera el presente.', '2026-06-02 15:35:35', '2026-06-02 17:25:45'),
(4, 1, 3, 'Promo-semana-santa', 'promo-semana-santa', '', 'ya viene semana santa xd ', '2026-06-03 12:46:57', '2026-06-03 12:46:57'),
(5, 2, 5, 'The boys', 'the-boys', '', 'Que final decepcionante', '2026-06-03 12:51:11', '2026-06-03 12:51:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(200) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `rol` varchar(20) DEFAULT 'usuario',
  `fecha_registro` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `nombre`, `apellidos`, `nombre_usuario`, `email`, `contraseña`, `avatar`, `bio`, `rol`, `fecha_registro`, `fecha_actualizacion`) VALUES
(1, 'Gimena', 'Flores', 'gimi', 'gimi@gmail.com', '$2y$04$R8KEoTJlSmobAhLiIqLFp.l9MiEhG3UStm0zIFX9lfGDd3vAPxJYC', '1780439302-jimena.jpg', 'soy una aspirante a desarrollador web', 'admin', '2026-06-02 14:03:48', '2026-06-02 18:28:22'),
(2, 'Adrian', 'Castillo', 'adrxsg', 'adrix@gmail.com', '$2y$04$og5jsKId1Jm/pftKL7PMvuvIq5/MFX.fOYlikzkaPr7hKSK4NBoQW', NULL, NULL, 'usuario', '2026-06-03 11:45:01', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`categoria_id`);

--
-- Indices de la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`comentario_id`),
  ADD KEY `comentario_entrada_fk` (`entrada_id`),
  ADD KEY `comentario_usuario_fk` (`usuario_id`);

--
-- Indices de la tabla `entrada`
--
ALTER TABLE `entrada`
  ADD PRIMARY KEY (`entrada_id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `entrada_usuario_fk` (`usuario_id`),
  ADD KEY `entrada_categoria_fk` (`categoria_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `categoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `comentario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `entrada`
--
ALTER TABLE `entrada`
  MODIFY `entrada_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `comentario_entrada_fk` FOREIGN KEY (`entrada_id`) REFERENCES `entrada` (`entrada_id`),
  ADD CONSTRAINT `comentario_usuario_fk` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`);

--
-- Filtros para la tabla `entrada`
--
ALTER TABLE `entrada`
  ADD CONSTRAINT `entrada_categoria_fk` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`categoria_id`),
  ADD CONSTRAINT `entrada_usuario_fk` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
