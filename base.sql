-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: mysql:3306
-- Tiempo de generación: 03-09-2025 a las 14:21:53
-- Versión del servidor: 5.7.44
-- Versión de PHP: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hexagonal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `barbers`
--

CREATE TABLE `barbers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dni` int(11) NOT NULL,
  `cellphone` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `token_auth_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `barbers`
--

INSERT INTO `barbers` (`id`, `name`, `email`, `password`, `dni`, `cellphone`, `token`, `token_auth_date`) VALUES
(1, 'mati', 'm@m', '$2y$10$2Ew1i34sx1fkNANsfMbyJ.Wah6MysjHc.L.0.Mp3zQJ7zrpxKOJ2i', 0, '', '1e0625ec1e00cc0b948544e7fd0d9f79', '2025-08-23'),
(2, 'a', '2@2', '$2y$10$Rq5.hsHdj.6leWYPvrnE/etop.J684bcqj5MBBkZJVfKmnbRxeiNa', 0, '', NULL, NULL),
(3, 'pr', 'pr@e', '$2y$10$sIzrr8ZgOqVnMDCp9h.dceBWuNjmLX7829y2X8VWWhnjcrpWIrgnK', 0, '', NULL, NULL),
(4, 'joaco', 'js@gmail', '$2y$10$gkHK2FjaPosCsb.OEovgre23sG/IUDaAPfQ82d2m9mgJhkZ7gojme', 0, '', 'cf1b1048721e1bca21719ecc6c3425f3', '2025-08-27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dni` int(11) NOT NULL,
  `cellphone` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `token_auth_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `sale_price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turns`
--

CREATE TABLE `turns` (
  `id` int(11) NOT NULL,
  `id_barber` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `hour_begin` date NOT NULL,
  `hour_end` date NOT NULL,
  `id_client` int(11) DEFAULT NULL,
  `state` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turns_config`
--

CREATE TABLE `turns_config` (
  `id` int(11) NOT NULL,
  `id_barber` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turns_config_day`
--

CREATE TABLE `turns_config_day` (
  `id` int(11) NOT NULL,
  `id_turns_config` int(11) NOT NULL,
  `day` varchar(255) NOT NULL,
  `hour_begin` date NOT NULL,
  `hour_end` date NOT NULL,
  `turn_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `barbers`
--
ALTER TABLE `barbers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `turns`
--
ALTER TABLE `turns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_barber` (`id_barber`);

--
-- Indices de la tabla `turns_config`
--
ALTER TABLE `turns_config`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_barber` (`id_barber`);

--
-- Indices de la tabla `turns_config_day`
--
ALTER TABLE `turns_config_day`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_turns_config` (`id_turns_config`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `barbers`
--
ALTER TABLE `barbers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `turns`
--
ALTER TABLE `turns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `turns_config`
--
ALTER TABLE `turns_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `turns_config_day`
--
ALTER TABLE `turns_config_day`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
