-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-07-2024 a las 08:06:43
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `water_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cobros`
--

CREATE TABLE `cobros` (
  `cobro_id` int(11) NOT NULL,
  `ci_socio` varchar(20) NOT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `fecha_cobro` date DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cobros`
--

INSERT INTO `cobros` (`cobro_id`, `ci_socio`, `monto`, `fecha_cobro`, `descripcion`) VALUES
(6, '0000012', 45.00, '2024-06-05', 'mora'),
(7, '00000', 45.00, '2024-06-05', 'deuda'),
(8, '0000012', 45.00, '2024-06-05', 'retraso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deudores`
--

CREATE TABLE `deudores` (
  `deudor_id` int(11) NOT NULL,
  `ci_socio` varchar(20) NOT NULL,
  `fecha_ultimo_aviso` date DEFAULT NULL,
  `monto_adeudado` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `deudores`
--

INSERT INTO `deudores` (`deudor_id`, `ci_socio`, `fecha_ultimo_aviso`, `monto_adeudado`) VALUES
(5, '12358', '2024-06-19', 348.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `factura_id` int(11) NOT NULL,
  `ci_socio` varchar(20) DEFAULT NULL,
  `lectura_id` int(11) DEFAULT NULL,
  `tarifa_id` int(11) DEFAULT NULL,
  `deudor_id` int(11) DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `pagado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lecturas_agua`
--

CREATE TABLE `lecturas_agua` (
  `lectura_id` int(11) NOT NULL,
  `ci_socio` varchar(20) DEFAULT NULL,
  `fecha_lectura` date DEFAULT NULL,
  `lectura_anterior` int(50) DEFAULT NULL,
  `lectura_actual` int(50) DEFAULT NULL,
  `numero_medidor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lecturas_agua`
--

INSERT INTO `lecturas_agua` (`lectura_id`, `ci_socio`, `fecha_lectura`, `lectura_anterior`, `lectura_actual`, `numero_medidor`) VALUES
(20, NULL, '2024-06-12', 1458, 1545, 1234568);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `pago_id` int(11) NOT NULL,
  `factura_id` int(11) DEFAULT NULL,
  `fecha_pago` date DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socios`
--

CREATE TABLE `socios` (
  `id_socio` int(11) NOT NULL,
  `ci_socio` varchar(20) NOT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `numero_medidor` varchar(50) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fecha_alta` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `socios`
--

INSERT INTO `socios` (`id_socio`, `ci_socio`, `apellidos`, `nombre`, `numero_medidor`, `direccion`, `telefono`, `fecha_alta`) VALUES
(1, '007856', 'Suarez Torrez', 'Ana Maria (editado)', '45452', 'C/ Teniente Lucio Canedo', '74889', '2012-12-12'),
(2, '00000', 'Jimenez  Pérez', 'Sofia Valeria', '12456', 'Zona Sud', '74889076', '2024-06-03'),
(3, '054894', 'Jimenez  Pérez', 'Juan', '45454', 'Zona Sud', '454', '2024-06-04'),
(7, '0000012', 'tarqui', 'juel', '0', 'paracaya', '2121228', '2024-06-05'),
(8, '12345', 'torrico', 'juan', '0', 'paracaya', '2121228', '2024-06-05'),
(9, 'Laborum dolore reici', 'Omnis repellendus L', 'Pariatur Necessitat', '0', 'Animi obcaecati est', 'Labore veritatis eni', '2005-09-17'),
(10, '00001', 'torrico', 'david', '0', 'paracaya', '74889076', '2024-06-05'),
(12, '1234', 'Lopez Garcia', 'Maria Ignacia', '458756', 'C/ Teniente Lucio Canedo', '74889076', '2024-06-11'),
(14, '12358', 'Camacho Carreño', 'Mijael', '1234568', 'Arani', '6544184', '2024-06-11'),
(18, '12345678', 'Suarez Torrez', 'Sofia Valeria', '454545', 'C/ Teniente Lucio Canedo', '74889076', '2020-12-12'),
(19, '1875', 'Suarez Torrez', 'Sandra', '454548', 'C/ Teniente Lucio Canedo', '74889076', '2020-12-12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarifas`
--

CREATE TABLE `tarifas` (
  `tarifa_id` int(11) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `precio_m3_estandar` decimal(10,2) DEFAULT NULL,
  `precio_m3_medio` decimal(10,2) DEFAULT NULL,
  `precio_m3_elevado` decimal(10,2) DEFAULT NULL,
  `fecha_actualizacion` date DEFAULT NULL,
  `rango_estandar_min` int(11) DEFAULT 0,
  `rango_estandar_max` int(11) DEFAULT 10,
  `rango_medio_min` int(11) DEFAULT 11,
  `rango_medio_max` int(11) DEFAULT 20,
  `rango_elevado_min` int(11) DEFAULT 21,
  `rango_elevado_max` int(11) DEFAULT 9999
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tarifas`
--

INSERT INTO `tarifas` (`tarifa_id`, `descripcion`, `precio_m3_estandar`, `precio_m3_medio`, `precio_m3_elevado`, `fecha_actualizacion`, `rango_estandar_min`, `rango_estandar_max`, `rango_medio_min`, `rango_medio_max`, `rango_elevado_min`, `rango_elevado_max`) VALUES
(31, 'esta es una seccion solo para el administrador', 1.00, 2.00, 4.00, NULL, 1, 10, 11, 20, 21, 30);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cobros`
--
ALTER TABLE `cobros`
  ADD PRIMARY KEY (`cobro_id`),
  ADD KEY `ci_socio` (`ci_socio`);

--
-- Indices de la tabla `deudores`
--
ALTER TABLE `deudores`
  ADD PRIMARY KEY (`deudor_id`),
  ADD KEY `ci_socio` (`ci_socio`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`factura_id`),
  ADD KEY `ci_socio` (`ci_socio`),
  ADD KEY `lectura_id` (`lectura_id`),
  ADD KEY `tarifa_id` (`tarifa_id`),
  ADD KEY `deudor_id` (`deudor_id`);

--
-- Indices de la tabla `lecturas_agua`
--
ALTER TABLE `lecturas_agua`
  ADD PRIMARY KEY (`lectura_id`),
  ADD KEY `ci_socio` (`ci_socio`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`pago_id`),
  ADD KEY `factura_id` (`factura_id`);

--
-- Indices de la tabla `socios`
--
ALTER TABLE `socios`
  ADD PRIMARY KEY (`id_socio`),
  ADD UNIQUE KEY `ci_socio` (`ci_socio`);

--
-- Indices de la tabla `tarifas`
--
ALTER TABLE `tarifas`
  ADD PRIMARY KEY (`tarifa_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cobros`
--
ALTER TABLE `cobros`
  MODIFY `cobro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `deudores`
--
ALTER TABLE `deudores`
  MODIFY `deudor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `factura_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `lecturas_agua`
--
ALTER TABLE `lecturas_agua`
  MODIFY `lectura_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `pago_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `socios`
--
ALTER TABLE `socios`
  MODIFY `id_socio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `tarifas`
--
ALTER TABLE `tarifas`
  MODIFY `tarifa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cobros`
--
ALTER TABLE `cobros`
  ADD CONSTRAINT `cobros_ibfk_1` FOREIGN KEY (`ci_socio`) REFERENCES `socios` (`ci_socio`);

--
-- Filtros para la tabla `deudores`
--
ALTER TABLE `deudores`
  ADD CONSTRAINT `deudores_ibfk_1` FOREIGN KEY (`ci_socio`) REFERENCES `socios` (`ci_socio`);

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`ci_socio`) REFERENCES `socios` (`ci_socio`),
  ADD CONSTRAINT `facturas_ibfk_2` FOREIGN KEY (`lectura_id`) REFERENCES `lecturas_agua` (`lectura_id`),
  ADD CONSTRAINT `facturas_ibfk_3` FOREIGN KEY (`tarifa_id`) REFERENCES `tarifas` (`tarifa_id`),
  ADD CONSTRAINT `facturas_ibfk_4` FOREIGN KEY (`deudor_id`) REFERENCES `deudores` (`deudor_id`);

--
-- Filtros para la tabla `lecturas_agua`
--
ALTER TABLE `lecturas_agua`
  ADD CONSTRAINT `lecturas_agua_ibfk_1` FOREIGN KEY (`ci_socio`) REFERENCES `socios` (`ci_socio`);

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`factura_id`) REFERENCES `facturas` (`factura_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
