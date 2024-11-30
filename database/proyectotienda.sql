-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 30-11-2024 a las 23:12:00
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
-- Base de datos: `proyectotienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `car_fk_producto` int(11) NOT NULL,
  `car_fk_usuario` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `cat_id` int(11) NOT NULL,
  `cat_nombre` varchar(50) DEFAULT NULL,
  `cat_descripcion` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`cat_id`, `cat_nombre`, `cat_descripcion`) VALUES
(1, 'Ropa de Mujer', 'Categoría de ropa para mujeres, incluyendo prendas de vestir, accesorios, etc.'),
(2, 'Electrónicos', 'Categoría que incluye productos electrónicos como computadoras, teléfonos, etc.'),
(3, 'Videojuegos', 'Categoría de videojuegos para diversas plataformas de entretenimiento.'),
(4, 'Libros', 'Categoría que incluye libros de todos los géneros y para todas las edades.'),
(5, 'Hogar y Cocina', 'Categoría para productos del hogar, electrodomésticos, utensilios de cocina, etc.'),
(6, 'Mascotas', 'Categoría que incluye productos para el cuidado y bienestar de las mascotas.'),
(7, 'Juguetes', 'Categoría de juguetes para niños de diferentes edades.'),
(8, 'Bebidas', 'Categoría que incluye una variedad de bebidas, desde refrescos hasta bebidas alcohólicas.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `inv_id_producto` int(11) NOT NULL,
  `inv_stock` int(11) DEFAULT NULL,
  `inv_NombreAlmacen` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

CREATE TABLE `ordenes` (
  `ord_id` int(11) NOT NULL,
  `ord_vendedor` int(11) DEFAULT NULL,
  `ord_cliente` int(11) DEFAULT NULL,
  `ord_fecha_pedido` date DEFAULT NULL,
  `ord_fecha_entrega` date DEFAULT NULL,
  `ord_fk_ordenproducto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_productos`
--

CREATE TABLE `orden_productos` (
  `orpd_id` int(11) NOT NULL,
  `orpd_idorden` int(11) DEFAULT NULL,
  `orpd_idproducto` int(11) NOT NULL,
  `orpd_cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idproducto` int(11) NOT NULL,
  `prd_nombre` varchar(100) DEFAULT NULL,
  `prd_descrip` text,
  `prd_precio` float DEFAULT NULL,
  `prd_marca` varchar(50) DEFAULT NULL,
  `prd_imagen` text,
  `prd_estado` varchar(50) DEFAULT NULL,
  `prd_categoria` int(50) DEFAULT NULL,
  `prd_id_publicacion` int(11) DEFAULT NULL,
  `prd_id_vendedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idproducto`, `prd_nombre`, `prd_descrip`, `prd_precio`, `prd_marca`, `prd_imagen`, `prd_estado`, `prd_categoria`, `prd_id_publicacion`, `prd_id_vendedor`) VALUES
(25, 'Libreta', 'Azul', '25.23', 'Scribe', NULL, 'Disponible', NULL, NULL, NULL),
(31, 'Prueba1', 'prueba', '123.00', 'asda', NULL, 'dasdas', NULL, NULL, NULL),
(32, 'Jordan', 'tennis ', '123.00', 'Nike', 'data:image/webp;base64,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', 'Disponible', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usr_id` int(11) NOT NULL,
  `usr_nombre` varchar(50) DEFAULT NULL,
  `usr_apaterno` varchar(50) DEFAULT NULL,
  `usr_amaterno` varchar(50) DEFAULT NULL,
  `usr_usuario` varchar(50) DEFAULT NULL,
  `usr_psword` varchar(255) DEFAULT NULL,
  `usr_correo` varchar(100) DEFAULT NULL,
  `usr_telefono` varchar(20) DEFAULT NULL,
  `usr_direccion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedor`
--

CREATE TABLE `vendedor` (
  `usr_fk_usuario` int(11) NOT NULL,
  `usr_ranking` int(11) DEFAULT NULL,
  `usr_NumVentas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`car_fk_producto`,`car_fk_usuario`),
  ADD KEY `car_fk_usuario` (`car_fk_usuario`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`inv_id_producto`);

--
-- Indices de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD PRIMARY KEY (`ord_id`),
  ADD KEY `ord_vendedor` (`ord_vendedor`),
  ADD KEY `ord_cliente` (`ord_cliente`);

--
-- Indices de la tabla `orden_productos`
--
ALTER TABLE `orden_productos`
  ADD PRIMARY KEY (`orpd_id`),
  ADD KEY `orpd_idproducto` (`orpd_idproducto`),
  ADD KEY `orden_productos_ibfk_2` (`orpd_idorden`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idproducto`),
  ADD KEY `prd_categoria` (`prd_categoria`),
  ADD KEY `prd_id_vendedor` (`prd_id_vendedor`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usr_id`),
  ADD UNIQUE KEY `usr_usuario` (`usr_usuario`);

--
-- Indices de la tabla `vendedor`
--
ALTER TABLE `vendedor`
  ADD PRIMARY KEY (`usr_fk_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `ord_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orden_productos`
--
ALTER TABLE `orden_productos`
  MODIFY `orpd_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`car_fk_producto`) REFERENCES `productos` (`idproducto`),
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`car_fk_usuario`) REFERENCES `usuarios` (`usuarioId`);

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`inv_id_producto`) REFERENCES `productos` (`idproducto`);

--
-- Filtros para la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD CONSTRAINT `ordenes_ibfk_1` FOREIGN KEY (`ord_vendedor`) REFERENCES `vendedor` (`usr_fk_usuario`),
  ADD CONSTRAINT `ordenes_ibfk_2` FOREIGN KEY (`ord_cliente`) REFERENCES `usuarios` (`usr_id`);

--
-- Filtros para la tabla `orden_productos`
--
ALTER TABLE `orden_productos`
  ADD CONSTRAINT `orden_productos_ibfk_1` FOREIGN KEY (`orpd_idproducto`) REFERENCES `productos` (`idproducto`),
  ADD CONSTRAINT `orden_productos_ibfk_2` FOREIGN KEY (`orpd_idorden`) REFERENCES `ordenes` (`ord_id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`prd_categoria`) REFERENCES `categorias` (`cat_id`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`prd_id_vendedor`) REFERENCES `vendedor` (`usr_fk_usuario`);

--
-- Filtros para la tabla `vendedor`
--
ALTER TABLE `vendedor`
  ADD CONSTRAINT `vendedor_ibfk_1` FOREIGN KEY (`usr_fk_usuario`) REFERENCES `usuarios` (`usr_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
