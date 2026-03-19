-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-03-2026 a las 22:27:38
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tmc`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `are_id` int(11) NOT NULL,
  `are_nombre` text COLLATE utf8mb4_unicode_ci,
  `are_fecha_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `are_fecha_update` datetime DEFAULT NULL,
  `are_fecha_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

CREATE TABLE `cargos` (
  `car_id` int(11) NOT NULL,
  `car_nombre` text COLLATE utf8mb4_unicode_ci,
  `car_fecha_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `car_fecha_update` datetime DEFAULT NULL,
  `car_fecha_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centro_costo`
--

CREATE TABLE `centro_costo` (
  `cenco_id` int(11) NOT NULL,
  `cenco_codigo` text COLLATE utf8mb4_unicode_ci,
  `cenco_nombre` text COLLATE utf8mb4_unicode_ci,
  `cenco_fecha_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cenco_fecha_update` datetime DEFAULT NULL,
  `cenco_fecha_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config_series`
--

CREATE TABLE `config_series` (
  `conf_seri_id` int(11) NOT NULL,
  `conf_seri_tipo` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conf_seri_moneda` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conf_seri_serie` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conf_seri_ultimo_numero` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `config_series`
--

INSERT INTO `config_series` (`conf_seri_id`, `conf_seri_tipo`, `conf_seri_moneda`, `conf_seri_serie`, `conf_seri_ultimo_numero`) VALUES
(1, 'INGRESO', 'SOLES', '001', 0),
(2, 'INGRESO', 'DOLARES', '001', 0),
(3, 'EGRESO', 'SOLES', '001', 0),
(4, 'EGRESO', 'DOLARES', '001', 0),
(5, 'INGRESO', 'SOLES', '002', 0),
(6, 'EGRESO', 'SOLES', '002', 0),
(7, 'INGRESO', 'SOLES', '003', 0),
(8, 'EGRESO', 'SOLES', '003', 0),
(9, 'EGRESO', 'SOLES', '004', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_movimiento`
--

CREATE TABLE `detalle_movimiento` (
  `deta_movi_id` int(11) NOT NULL,
  `deta_movi_movimiento_id` int(11) DEFAULT NULL,
  `deta_movi_item` int(11) DEFAULT NULL,
  `deta_movi_descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deta_movi_importe` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `emple_id` int(11) NOT NULL,
  `emple_codigo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emple_tipo_documento` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_numero_documento` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_apellido_paterno` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_apellido_materno` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_nombres` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_fecha_nacimiento` date DEFAULT NULL,
  `emple_nacionalidad` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_sexo` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_estado_civil` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_telefono_movil` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_telefono_fijo` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_correo` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_departamento` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_provincia` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_distrito` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_lugar_residencia` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_empresa_id` int(11) NOT NULL,
  `emple_fecha_ingreso` date DEFAULT NULL,
  `emple_categoria_ocupacional` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_cenco_id` int(11) NOT NULL,
  `emple_area_id` int(11) NOT NULL,
  `emple_cargo_id` int(11) NOT NULL,
  `emple_estado` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_fecha_cese` date DEFAULT NULL,
  `emple_situacion_educativa` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_estado_educativa` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_tipo_regimen` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_tipo_institucion` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_institucion` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_carrera` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_anio` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_nombre_familiar` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_telefono_familiar` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_parentesco` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_fecha_vencimiento_documento` date DEFAULT NULL,
  `emple_archivo_documento` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_licencia` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_fecha_vencimiento_a1` date DEFAULT NULL,
  `emple_archivo_a1` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_fecha_vencimiento_a2a` date DEFAULT NULL,
  `emple_archivo_a2a` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_fecha_vencimiento_a2b` date DEFAULT NULL,
  `emple_archivo_a2b` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_fecha_vencimiento_a3a` date DEFAULT NULL,
  `emple_archivo_a3a` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_fecha_vencimiento_a3b` date DEFAULT NULL,
  `emple_archivo_a3b` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_fecha_vencimiento_a3c` date DEFAULT NULL,
  `emple_archivo_a3c` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_fecha_vencimiento_b1` date DEFAULT NULL,
  `emple_archivo_b1` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_fecha_vencimiento_b2a` date DEFAULT NULL,
  `emple_archivo_b2a` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_fecha_vencimiento_b2b` date DEFAULT NULL,
  `emple_archivo_b2b` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_fecha_vencimiento_b2c` date DEFAULT NULL,
  `emple_archivo_b2c` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emple_id_usuario` int(11) NOT NULL,
  `emple_fecha_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `emple_fecha_update` datetime DEFAULT NULL,
  `emple_fecha_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `empre_id` int(11) NOT NULL,
  `empre_ruc` text COLLATE utf8mb4_unicode_ci,
  `empre_razon_social` text COLLATE utf8mb4_unicode_ci,
  `empre_nombre_comercial` text COLLATE utf8mb4_unicode_ci,
  `empre_domicilio_legal` text COLLATE utf8mb4_unicode_ci,
  `empre_numero_contacto` text COLLATE utf8mb4_unicode_ci,
  `empre_email_contacto` text COLLATE utf8mb4_unicode_ci,
  `empre_fecha_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `empre_fecha_update` datetime DEFAULT NULL,
  `empre_fecha_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `movi_id` int(11) NOT NULL,
  `movi_tipo` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `movi_serie` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `movi_numero` int(11) DEFAULT NULL,
  `movi_moneda` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `movi_fecha` date DEFAULT NULL,
  `movi_emple_id` int(11) DEFAULT NULL,
  `movi_total` decimal(10,2) DEFAULT NULL,
  `movi_fecha_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `movi_fecha_update` datetime DEFAULT NULL,
  `movi_fecha_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opts`
--

CREATE TABLE `opts` (
  `opt_id` int(11) NOT NULL,
  `opt_cenco_codigo` text COLLATE utf8mb4_unicode_ci,
  `opt_vehiculo_id` int(11) DEFAULT NULL,
  `opt_cliente` text COLLATE utf8mb4_unicode_ci,
  `opt_lugar` text COLLATE utf8mb4_unicode_ci,
  `opt_fecha` date NOT NULL,
  `opt_observado` text COLLATE utf8mb4_unicode_ci,
  `opt_observador` text COLLATE utf8mb4_unicode_ci,
  `opt_bps_encontrada` text COLLATE utf8mb4_unicode_ci,
  `opt_500_pregunta1` text COLLATE utf8mb4_unicode_ci,
  `opt_500_pregunta2` text COLLATE utf8mb4_unicode_ci,
  `opt_500_pregunta3` text COLLATE utf8mb4_unicode_ci,
  `opt_500_pregunta4` text COLLATE utf8mb4_unicode_ci,
  `opt_500_pregunta5` text COLLATE utf8mb4_unicode_ci,
  `opt_500_pregunta6` text COLLATE utf8mb4_unicode_ci,
  `opt_500_pregunta7` text COLLATE utf8mb4_unicode_ci,
  `opt_500_pregunta8` text COLLATE utf8mb4_unicode_ci,
  `opt_500_pregunta9` text COLLATE utf8mb4_unicode_ci,
  `opt_500_pregunta10` text COLLATE utf8mb4_unicode_ci,
  `opt_500_pregunta11` text COLLATE utf8mb4_unicode_ci,
  `opt_500_pregunta12` text COLLATE utf8mb4_unicode_ci,
  `opt_500_pregunta13` text COLLATE utf8mb4_unicode_ci,
  `opt_500_pregunta14` text COLLATE utf8mb4_unicode_ci,
  `opt_500_pregunta15` text COLLATE utf8mb4_unicode_ci,
  `opt_500_otros` text COLLATE utf8mb4_unicode_ci,
  `opt_501_pregunta1` text COLLATE utf8mb4_unicode_ci,
  `opt_501_pregunta2` text COLLATE utf8mb4_unicode_ci,
  `opt_501_pregunta3` text COLLATE utf8mb4_unicode_ci,
  `opt_501_pregunta4` text COLLATE utf8mb4_unicode_ci,
  `opt_501_pregunta5` text COLLATE utf8mb4_unicode_ci,
  `opt_501_pregunta6` text COLLATE utf8mb4_unicode_ci,
  `opt_501_pregunta7` text COLLATE utf8mb4_unicode_ci,
  `opt_501_pregunta8` text COLLATE utf8mb4_unicode_ci,
  `opt_501_pregunta9` text COLLATE utf8mb4_unicode_ci,
  `opt_501_pregunta10` text COLLATE utf8mb4_unicode_ci,
  `opt_501_pregunta11` text COLLATE utf8mb4_unicode_ci,
  `opt_501_pregunta12` text COLLATE utf8mb4_unicode_ci,
  `opt_501_pregunta13` text COLLATE utf8mb4_unicode_ci,
  `opt_501_pregunta14` text COLLATE utf8mb4_unicode_ci,
  `opt_501_otros` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta1` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta2` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta3` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta4` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta5` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta6` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta7` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta8` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta9` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta10` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta11` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta12` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta13` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta14` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta15` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta16` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta17` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta18` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta19` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta20` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta21` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta22` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta23` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta24` text COLLATE utf8mb4_unicode_ci,
  `opt_504_pregunta25` text COLLATE utf8mb4_unicode_ci,
  `opt_504_otros` text COLLATE utf8mb4_unicode_ci,
  `opt_506_pregunta1` text COLLATE utf8mb4_unicode_ci,
  `opt_506_pregunta2` text COLLATE utf8mb4_unicode_ci,
  `opt_506_pregunta3` text COLLATE utf8mb4_unicode_ci,
  `opt_506_pregunta4` text COLLATE utf8mb4_unicode_ci,
  `opt_506_pregunta5` text COLLATE utf8mb4_unicode_ci,
  `opt_506_pregunta6` text COLLATE utf8mb4_unicode_ci,
  `opt_506_pregunta7` text COLLATE utf8mb4_unicode_ci,
  `opt_506_pregunta8` text COLLATE utf8mb4_unicode_ci,
  `opt_506_pregunta9` text COLLATE utf8mb4_unicode_ci,
  `opt_506_pregunta10` text COLLATE utf8mb4_unicode_ci,
  `opt_506_pregunta11` text COLLATE utf8mb4_unicode_ci,
  `opt_506_pregunta12` text COLLATE utf8mb4_unicode_ci,
  `opt_506_pregunta13` text COLLATE utf8mb4_unicode_ci,
  `opt_506_otros` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta1` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta2` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta3` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta4` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta5` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta6` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta7` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta8` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta9` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta10` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta11` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta12` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta13` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta14` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta15` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta16` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta17` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta18` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta19` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta20` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta21` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta22` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta23` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta24` text COLLATE utf8mb4_unicode_ci,
  `opt_507_pregunta25` text COLLATE utf8mb4_unicode_ci,
  `opt_507_otros` text COLLATE utf8mb4_unicode_ci,
  `opt_508_pregunta1` text COLLATE utf8mb4_unicode_ci,
  `opt_508_pregunta2` text COLLATE utf8mb4_unicode_ci,
  `opt_508_pregunta3` text COLLATE utf8mb4_unicode_ci,
  `opt_508_pregunta4` text COLLATE utf8mb4_unicode_ci,
  `opt_508_pregunta5` text COLLATE utf8mb4_unicode_ci,
  `opt_508_pregunta6` text COLLATE utf8mb4_unicode_ci,
  `opt_508_pregunta7` text COLLATE utf8mb4_unicode_ci,
  `opt_508_pregunta8` text COLLATE utf8mb4_unicode_ci,
  `opt_508_pregunta9` text COLLATE utf8mb4_unicode_ci,
  `opt_508_pregunta10` text COLLATE utf8mb4_unicode_ci,
  `opt_508_pregunta11` text COLLATE utf8mb4_unicode_ci,
  `opt_508_pregunta12` text COLLATE utf8mb4_unicode_ci,
  `opt_508_pregunta13` text COLLATE utf8mb4_unicode_ci,
  `opt_508_otros` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta1` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta2` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta3` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta4` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta5` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta6` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta7` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta8` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta9` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta10` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta11` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta12` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta13` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta14` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta15` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta16` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta17` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta18` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta19` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta20` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta21` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta22` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta23` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta24` text COLLATE utf8mb4_unicode_ci,
  `opt_509_pregunta25` text COLLATE utf8mb4_unicode_ci,
  `opt_509_otros` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta1` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta2` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta3` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta4` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta5` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta6` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta7` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta8` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta9` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta10` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta11` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta12` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta13` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta14` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta15` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta16` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta17` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta18` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta19` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta20` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta21` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta22` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta23` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta24` text COLLATE utf8mb4_unicode_ci,
  `opt_511_pregunta25` text COLLATE utf8mb4_unicode_ci,
  `opt_511_otros` text COLLATE utf8mb4_unicode_ci,
  `opt_tipo_hallazgo` text COLLATE utf8mb4_unicode_ci,
  `opt_relacionado` text COLLATE utf8mb4_unicode_ci,
  `opt_decripcion_observacion` text COLLATE utf8mb4_unicode_ci,
  `opt_decripcion_adicional` text COLLATE utf8mb4_unicode_ci,
  `opt_correccion` text COLLATE utf8mb4_unicode_ci,
  `opt_evidencia1` text COLLATE utf8mb4_unicode_ci,
  `opt_evidencia2` text COLLATE utf8mb4_unicode_ci,
  `opt_id_usuario` int(11) NOT NULL,
  `opt_fecha_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `opt_fecha_update` datetime DEFAULT NULL,
  `opt_fecha_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usu_id` int(11) NOT NULL,
  `usu_nombre` varchar(100) DEFAULT NULL,
  `usu_usuario` varchar(50) DEFAULT NULL,
  `usu_password` varchar(255) DEFAULT NULL,
  `usu_perfil` varchar(50) DEFAULT NULL,
  `usu_foto` text,
  `usu_estado` int(11) DEFAULT NULL,
  `usu_ultimo_login` datetime DEFAULT NULL,
  `usu_fecha_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usu_fecha_update` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `usu_fecha_delete` datetime DEFAULT NULL,
  `usu_es_master` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Flag: 1=cuenta master con permiso de eliminacion fisica'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usu_id`, `usu_nombre`, `usu_usuario`, `usu_password`, `usu_perfil`, `usu_foto`, `usu_estado`, `usu_ultimo_login`, `usu_fecha_create`, `usu_fecha_update`, `usu_fecha_delete`, `usu_es_master`) VALUES
(1, 'Usuario Administrado', 'admin', '$2a$07$asxx54ahjppf45sd87a5auXBm1Vr2M1NV5t/zNQtGHGpS5fFirrbG', 'Administrador', 'vistas/img/usuarios/admin/254.jpg', 1, '2026-03-19 11:21:26', '2026-03-18 15:45:24', '2026-03-19 16:21:26', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_modulos`
--

CREATE TABLE `usuarios_modulos` (
  `umod_id` int(10) UNSIGNED NOT NULL,
  `usu_id` int(11) NOT NULL,
  `modulo` varchar(80) NOT NULL,
  `umod_fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios_modulos`
--

INSERT INTO `usuarios_modulos` (`umod_id`, `usu_id`, `modulo`, `umod_fecha_creacion`) VALUES
(100, 1, 'usuarios', '2026-03-19 16:49:40'),
(101, 1, 'centro-costo', '2026-03-19 16:49:40'),
(102, 1, 'empresas', '2026-03-19 16:49:40'),
(103, 1, 'vehiculos', '2026-03-19 16:49:40'),
(104, 1, 'sig-opt', '2026-03-19 16:49:40'),
(105, 1, 'areas', '2026-03-19 16:49:40'),
(106, 1, 'cargos', '2026-03-19 16:49:40'),
(107, 1, 'empleados', '2026-03-19 16:49:40'),
(108, 1, 'movimiento-caja', '2026-03-19 16:49:40'),
(109, 1, 'orden-servicio', '2026-03-19 16:49:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `vehic_id` int(11) NOT NULL,
  `vehic_cenco_id` int(11) DEFAULT NULL,
  `vehic_placa` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehic_marca` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehic_modelo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehic_anio` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehic_clase` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehic_numero_vin` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehic_numero_motor` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehic_jefe_operacion` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehic_estado` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehic_propietario` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehic_fecha_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vehic_fecha_update` datetime DEFAULT NULL,
  `vehic_fecha_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`are_id`);

--
-- Indices de la tabla `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`car_id`);

--
-- Indices de la tabla `centro_costo`
--
ALTER TABLE `centro_costo`
  ADD PRIMARY KEY (`cenco_id`);

--
-- Indices de la tabla `config_series`
--
ALTER TABLE `config_series`
  ADD PRIMARY KEY (`conf_seri_id`);

--
-- Indices de la tabla `detalle_movimiento`
--
ALTER TABLE `detalle_movimiento`
  ADD PRIMARY KEY (`deta_movi_id`),
  ADD KEY `deta_movi_movimiento_id` (`deta_movi_movimiento_id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`emple_id`),
  ADD UNIQUE KEY `emple_codigo` (`emple_codigo`),
  ADD KEY `emple_empresa_id` (`emple_empresa_id`),
  ADD KEY `emple_cenco_id` (`emple_cenco_id`),
  ADD KEY `emple_area_id` (`emple_area_id`),
  ADD KEY `emple_cargo_id` (`emple_cargo_id`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`empre_id`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`movi_id`),
  ADD UNIQUE KEY `uq_movimientos_serie_numero` (`movi_tipo`,`movi_moneda`,`movi_serie`,`movi_numero`),
  ADD KEY `movi_emple_id` (`movi_emple_id`);

--
-- Indices de la tabla `opts`
--
ALTER TABLE `opts`
  ADD PRIMARY KEY (`opt_id`),
  ADD KEY `opt_vehiculo_id` (`opt_vehiculo_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usu_id`);

--
-- Indices de la tabla `usuarios_modulos`
--
ALTER TABLE `usuarios_modulos`
  ADD PRIMARY KEY (`umod_id`),
  ADD UNIQUE KEY `uk_usuario_modulo` (`usu_id`,`modulo`),
  ADD KEY `idx_usuarios_modulos_usuario` (`usu_id`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`vehic_id`),
  ADD UNIQUE KEY `vehic_placa` (`vehic_placa`),
  ADD UNIQUE KEY `vehic_numero_vin` (`vehic_numero_vin`),
  ADD UNIQUE KEY `vehic_numero_motor` (`vehic_numero_motor`),
  ADD KEY `vehic_cenco_id` (`vehic_cenco_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `are_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cargos`
--
ALTER TABLE `cargos`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `centro_costo`
--
ALTER TABLE `centro_costo`
  MODIFY `cenco_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `config_series`
--
ALTER TABLE `config_series`
  MODIFY `conf_seri_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `detalle_movimiento`
--
ALTER TABLE `detalle_movimiento`
  MODIFY `deta_movi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `emple_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `empre_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `movi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `opts`
--
ALTER TABLE `opts`
  MODIFY `opt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios_modulos`
--
ALTER TABLE `usuarios_modulos`
  MODIFY `umod_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `vehic_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_movimiento`
--
ALTER TABLE `detalle_movimiento`
  ADD CONSTRAINT `detalle_movimiento_ibfk_1` FOREIGN KEY (`deta_movi_movimiento_id`) REFERENCES `movimientos` (`movi_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`emple_empresa_id`) REFERENCES `empresas` (`empre_id`),
  ADD CONSTRAINT `empleados_ibfk_2` FOREIGN KEY (`emple_cenco_id`) REFERENCES `centro_costo` (`cenco_id`),
  ADD CONSTRAINT `empleados_ibfk_3` FOREIGN KEY (`emple_area_id`) REFERENCES `areas` (`are_id`),
  ADD CONSTRAINT `empleados_ibfk_4` FOREIGN KEY (`emple_cargo_id`) REFERENCES `cargos` (`car_id`);

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_ibfk_1` FOREIGN KEY (`movi_emple_id`) REFERENCES `empleados` (`emple_id`);

--
-- Filtros para la tabla `opts`
--
ALTER TABLE `opts`
  ADD CONSTRAINT `opts_ibfk_1` FOREIGN KEY (`opt_vehiculo_id`) REFERENCES `vehiculos` (`vehic_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios_modulos`
--
ALTER TABLE `usuarios_modulos`
  ADD CONSTRAINT `fk_usuarios_modulos_usuario` FOREIGN KEY (`usu_id`) REFERENCES `usuarios` (`usu_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `vehiculos_ibfk_1` FOREIGN KEY (`vehic_cenco_id`) REFERENCES `centro_costo` (`cenco_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
