-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 03-09-2020 a las 16:49:47
-- Versión del servidor: 10.2.32-MariaDB-cll-lve
-- Versión de PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `zettatro_rh`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `cedula` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`cedula`, `nombre`, `apellido`, `foto`) VALUES
('00014701', 'ROQUE GILBERTO', 'ESTRADA AGUIRRE', '478324.jpg'),
('0009721691', 'DOMINIQUE', 'CHAVEZ AZPRA', ''),
('0009737751', 'ANGEL', 'SOTO GARCIA', '511366.jpg'),
('0009794184', 'FERNANDA', 'CHAVEZ AZPRA', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcados`
--

CREATE TABLE `marcados` (
  `id` int(11) NOT NULL,
  `cedula` int(11) NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tipo` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `marcados`
--

INSERT INTO `marcados` (`id`, `cedula`, `fecha_hora`, `tipo`, `fecha`) VALUES
(114, 9721691, '2019-04-08 16:02:01', 'Entrada', '2019-04-08'),
(115, 9794184, '2019-04-08 22:36:04', 'Entrada', '2019-04-08'),
(116, 9721691, '2019-04-09 00:08:04', 'Salida', '2019-04-09'),
(117, 9794184, '2019-04-09 00:08:23', 'Salida', '2019-04-09'),
(118, 9794184, '2019-04-09 00:10:06', 'Entrada', '2019-04-09'),
(119, 9737751, '2019-04-09 00:15:07', 'Entrada', '2019-04-09'),
(120, 9737751, '2019-04-09 00:15:57', 'Salida', '2019-04-09'),
(121, 9794184, '2019-04-09 00:16:21', 'Salida', '2019-04-09'),
(122, 9721691, '2019-04-09 00:16:32', 'Entrada', '2019-04-09'),
(123, 9721691, '2019-04-09 00:16:35', 'Salida', '2019-04-09'),
(124, 9737751, '2019-04-09 15:17:37', 'Entrada', '2019-04-09'),
(125, 9737751, '2019-04-09 15:17:39', 'Salida', '2019-04-09'),
(126, 9794184, '2019-04-09 15:17:43', 'Entrada', '2019-04-09'),
(127, 9721691, '2019-04-09 15:17:45', 'Entrada', '2019-04-09'),
(128, 9737751, '2019-04-10 16:48:12', 'Entrada', '2019-04-10'),
(129, 9721691, '2019-04-10 16:48:16', 'Salida', '2019-04-10'),
(130, 9794184, '2019-04-10 16:48:18', 'Salida', '2019-04-10'),
(131, 9794184, '2019-04-10 16:48:25', 'Entrada', '2019-04-10'),
(132, 9721691, '2019-04-10 16:48:28', 'Entrada', '2019-04-10'),
(133, 9737751, '2019-04-10 16:48:31', 'Salida', '2019-04-10'),
(134, 9737751, '2019-04-10 16:48:35', 'Entrada', '2019-04-10'),
(135, 9721691, '2019-04-15 15:53:02', 'Salida', '2019-04-15'),
(136, 9794184, '2019-04-15 15:53:03', 'Salida', '2019-04-15'),
(137, 9794184, '2019-04-15 15:53:05', 'Entrada', '2019-04-15'),
(138, 9721691, '2019-04-15 15:53:08', 'Entrada', '2019-04-15'),
(139, 9737751, '2019-04-15 15:53:18', 'Salida', '2019-04-15'),
(140, 9737751, '2019-04-15 15:53:22', 'Entrada', '2019-04-15'),
(141, 9721691, '2019-04-17 16:24:55', 'Salida', '2019-04-17'),
(142, 9721691, '2019-04-17 16:25:01', 'Entrada', '2019-04-17'),
(143, 9794184, '2019-04-17 16:25:04', 'Salida', '2019-04-17'),
(144, 9794184, '2019-04-17 16:25:07', 'Entrada', '2019-04-17'),
(145, 9737751, '2019-04-17 16:25:30', 'Salida', '2019-04-17'),
(146, 9737751, '2019-04-17 16:25:32', 'Entrada', '2019-04-17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `clave` varchar(255) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre_usuario`, `clave`) VALUES
(2, 'admin', 'ad3032c3adb33a777945823e34347507e99cc896');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`cedula`);

--
-- Indices de la tabla `marcados`
--
ALTER TABLE `marcados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `marcados`
--
ALTER TABLE `marcados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
