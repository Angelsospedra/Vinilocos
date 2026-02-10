-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-02-2026 a las 10:49:21
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
-- Base de datos: `vinilocos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo`
--

CREATE TABLE `catalogo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `artista` varchar(100) NOT NULL,
  `precio` decimal(6,2) NOT NULL,
  `anio` int(4) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `visible` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `catalogo`
--

INSERT INTO `catalogo` (`id`, `nombre`, `descripcion`, `artista`, `precio`, `anio`, `foto`, `visible`) VALUES
(4, '72 Seasons', 'Duodécimo álbum de estudio de Metallica que marca su regreso después de 7 años de silencio. Con una duración de casi una hora, \"72 Seasons\" combina la potencia del thrash metal con elementos melódicos, mostrando la madurez creativa de la banda. Incluye al', 'Metallica', 60.00, 1929, 'IMG/72seasons.jpg', 1),
(5, 'Anthology 4', 'Compilación de grabaciones inéditas y versiones alternativas del cuarteto de Liverpool, mostrando su evolución artística.', 'Beattles', 123.00, 1934, 'IMG/anthology4.jpg', 1),
(6, 'Abbey Road', 'Icónico álbum con los últimos trabajos de The Beatles', 'The Beatles', 35.99, 1969, 'IMG/abbey-road.jpg', 1),
(7, 'Dark Side of the Moon', 'Obra maestra del rock progresivo', 'Pink Floyd', 42.50, 1973, 'IMG/dark-side.jpg', 1),
(8, 'Rumours', 'Álbum clásico con grandes éxitos', 'Fleetwood Mac', 39.99, 1977, 'IMG/rumours.jpg', 1),
(9, 'Hotel California', 'Álbum legendario del rock', 'Eagles', 38.00, 1976, 'IMG/hotel-california.jpg', 1),
(10, 'Thriller', 'El álbum más vendido de todos los tiempos', 'Michael Jackson', 44.99, 1982, 'IMG/thriller.jpg', 1),
(11, 'Born to Run', 'Clásico del rock americano', 'Bruce Springsteen', 36.99, 1975, 'IMG/born-to-run.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opiniones`
--

CREATE TABLE `opiniones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `comentario` text NOT NULL,
  `viniloId` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(20) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `correo`, `contraseña`) VALUES
(1, 'Angel', 'Sospedra', 'angel@correo.com', '1234');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `catalogo`
--
ALTER TABLE `catalogo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `opiniones`
--
ALTER TABLE `opiniones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `viniloId` (`viniloId`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `catalogo`
--
ALTER TABLE `catalogo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `opiniones`
--
ALTER TABLE `opiniones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `opiniones`
--
ALTER TABLE `opiniones`
  ADD CONSTRAINT `opiniones_ibfk_1` FOREIGN KEY (`viniloId`) REFERENCES `catalogo` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
