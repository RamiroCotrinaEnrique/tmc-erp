-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-03-2026 a las 01:00:11
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

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`are_id`, `are_nombre`, `are_fecha_create`, `are_fecha_update`, `are_fecha_delete`) VALUES
(1, 'SISTEMAS', '2025-04-21 13:38:52', NULL, NULL),
(2, 'RECURSOS HUMANOS', '2025-04-21 13:39:04', NULL, NULL),
(3, '1234', '2025-08-21 21:06:39', '2026-01-15 09:52:46', NULL),
(4, 'SOPROTE INFORMATICO', '2026-01-15 14:52:59', NULL, NULL);

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

--
-- Volcado de datos para la tabla `cargos`
--

INSERT INTO `cargos` (`car_id`, `car_nombre`, `car_fecha_create`, `car_fecha_update`, `car_fecha_delete`) VALUES
(1, 'Supervisor 22', '2025-04-21 13:46:01', '2025-04-21 09:27:51', NULL),
(2, 'supervisor', '2025-10-15 22:36:03', '2025-10-15 17:36:19', NULL),
(3, 'ASITENTE', '2026-01-15 14:55:02', NULL, NULL);

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

--
-- Volcado de datos para la tabla `centro_costo`
--

INSERT INTO `centro_costo` (`cenco_id`, `cenco_codigo`, `cenco_nombre`, `cenco_fecha_create`, `cenco_fecha_update`, `cenco_fecha_delete`) VALUES
(13, '100', 'GERENCIA', '2025-05-14 16:03:05', NULL, NULL),
(14, '200', 'ADMINISTRACIÓN', '2025-05-14 16:03:05', NULL, NULL),
(15, '201', 'CONTABILIDAD', '2025-05-14 16:03:05', NULL, NULL),
(16, '202', 'FINANZAS', '2025-05-14 16:03:05', NULL, NULL),
(17, '300', 'SEGURIDAD', '2025-05-14 16:03:05', NULL, NULL),
(18, '301', 'RECURSOS HUMANOS', '2025-05-14 16:03:05', NULL, NULL),
(19, '400', 'MANTENIMIENTO', '2025-05-14 16:03:05', NULL, NULL),
(20, '500', 'TSE LIMA Y PROVINCIAS - SOLGAS', '2025-05-14 16:03:05', NULL, NULL),
(21, '501', 'CANJE LIMA Y PROVINCIAS - SOLGAS', '2025-05-14 16:03:05', NULL, NULL),
(22, '502', 'TSE HUANCAYO Y PROVINCIAS - SOLGAS', '2025-05-14 16:03:05', NULL, NULL),
(23, '503', 'CANJE HUANCAYO Y PROVINCIAS - SOLGAS', '2025-05-14 16:03:05', NULL, NULL),
(24, '504', 'TSG LIMA Y PROVINCIAS - REPSOL', '2025-05-14 16:03:05', NULL, NULL),
(25, '505', 'TAG PISCO-CALLAO - LIMA GAS', '2025-05-14 16:03:05', NULL, NULL),
(26, '506', 'TTP LIMA - CEMEX', '2025-05-14 16:03:05', NULL, NULL),
(27, '507', 'TSG LIMA Y PROVINCIAS - SOLGAS', '2025-05-14 16:03:05', NULL, NULL),
(28, '508', 'PACKAGED - LIMA - LINDE', '2025-05-14 16:03:05', NULL, NULL),
(29, '509', 'TSG LIMA Y PROVINCIAS - LIMA GAS', '2025-05-14 16:03:05', NULL, NULL),
(30, '510', 'TPG PROVINCIAS - SOLGAS', '2025-05-14 16:03:05', NULL, NULL),
(31, '511', 'TSG LIMA - PRIMAX', '2025-05-14 16:03:05', NULL, NULL),
(32, '600', 'SERVICIO TRANSPORTE VARIOS', '2025-05-14 16:03:05', NULL, NULL),
(33, '601', 'COSTO POR DISTRIBUIR', '2025-05-14 16:03:05', NULL, NULL);

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
(1, 'INGRESO', 'SOLES', '001', 1),
(2, 'INGRESO', 'DOLARES', '001', 1),
(3, 'EGRESO', 'SOLES', '001', 0),
(4, 'EGRESO', 'DOLARES', '001', 1),
(5, 'INGRESO', 'SOLES', '002', 0),
(6, 'EGRESO', 'SOLES', '002', 0),
(7, 'INGRESO', 'SOLES', '003', 1),
(8, 'EGRESO', 'SOLES', '003', 0),
(9, 'EGRESO', 'SOLES', '004', 3);

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

--
-- Volcado de datos para la tabla `detalle_movimiento`
--

INSERT INTO `detalle_movimiento` (`deta_movi_id`, `deta_movi_movimiento_id`, `deta_movi_item`, `deta_movi_descripcion`, `deta_movi_importe`) VALUES
(23, 13, 1, 'TACOS', '16.50'),
(24, 14, 1, 'DGGF', '54.00'),
(25, 15, 1, 'ingreso', '2000.00'),
(26, 16, 1, 'aaddddd', '2000.00'),
(27, 17, 1, 'PASAJE PARA COMPRAR IMPERSORA', '15.00'),
(28, 18, 1, 'ASDDDDD ADA  ADAD AADASDASFAASSF AS FASF', '200.00'),
(29, 18, 2, 'FFHHA AHBDIA  ABUDH ABIA UI FIABOF', '500.00'),
(30, 18, 3, 'JDJJFUE UJDJKD  UDJLKSF EJE', '680.00'),
(31, 18, 4, 'UIOIJI  JSHF JJJD AJDN HHFF  JF  JFP', '980.00');

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

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`emple_id`, `emple_codigo`, `emple_tipo_documento`, `emple_numero_documento`, `emple_apellido_paterno`, `emple_apellido_materno`, `emple_nombres`, `emple_fecha_nacimiento`, `emple_nacionalidad`, `emple_sexo`, `emple_estado_civil`, `emple_telefono_movil`, `emple_telefono_fijo`, `emple_correo`, `emple_departamento`, `emple_provincia`, `emple_distrito`, `emple_lugar_residencia`, `emple_empresa_id`, `emple_fecha_ingreso`, `emple_categoria_ocupacional`, `emple_cenco_id`, `emple_area_id`, `emple_cargo_id`, `emple_estado`, `emple_fecha_cese`, `emple_situacion_educativa`, `emple_estado_educativa`, `emple_tipo_regimen`, `emple_tipo_institucion`, `emple_institucion`, `emple_carrera`, `emple_anio`, `emple_nombre_familiar`, `emple_telefono_familiar`, `emple_parentesco`, `emple_fecha_vencimiento_documento`, `emple_archivo_documento`, `emple_licencia`, `emple_fecha_vencimiento_a1`, `emple_archivo_a1`, `emple_fecha_vencimiento_a2a`, `emple_archivo_a2a`, `emple_fecha_vencimiento_a2b`, `emple_archivo_a2b`, `emple_fecha_vencimiento_a3a`, `emple_archivo_a3a`, `emple_fecha_vencimiento_a3b`, `emple_archivo_a3b`, `emple_fecha_vencimiento_a3c`, `emple_archivo_a3c`, `emple_fecha_vencimiento_b1`, `emple_archivo_b1`, `emple_fecha_vencimiento_b2a`, `emple_archivo_b2a`, `emple_fecha_vencimiento_b2b`, `emple_archivo_b2b`, `emple_fecha_vencimiento_b2c`, `emple_archivo_b2c`, `emple_id_usuario`, `emple_fecha_create`, `emple_fecha_update`, `emple_fecha_delete`) VALUES
(1, 'EMP0001', 'DNI', '70064332', 'COTRINA', 'ENRIQUE', 'VICTOR', '2026-03-03', 'PERUANO', 'Masculino', 'Soltero', '51946515190', '017778874', 'VCOTRINA@GMAIL.COM', 'LIMA', 'LIMA', 'SMP', 'AV. MAYO 2134', 1, '2026-03-04', 'Ejecutivo', 13, 1, 1, 'Activo', NULL, 'Eduación Especial', 'Completa', 'No aplica', 'Educación Superior de Formación Artistica', 'IBEROTEC', 'INFORMAATICA Y SISTEMAS', '2017', 'NOA', '51946515190', 'AMIGA', '2026-03-04', 'documento_70064332_20260304171927.pdf', 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 18:06:35', '2026-03-17 15:40:24', NULL),
(2, 'EMP0002', 'DNI', '70064332', 'COCO', 'ENRIQUE', 'VICTOR', '2002-02-27', 'PERUANO', 'Masculino', 'Soltero', '9999999999', '999999999', 'VCOTRINA@GMAIL.COM', 'LIMA', 'LIMA', 'SMP', 'AV. MAYO 2134', 1, '2025-08-20', 'Obrero', 14, 1, 1, 'Activo', NULL, 'Educación Superior de Formación Artistica', NULL, 'Pública', NULL, 'IBEROTEC', 'INFORMAATICA Y SISTEMAS', '2025', 'NOA', '9999999999', 'AMIGA', '2025-08-20', 'EMP0002/emple_archivo_documento_70064332.pdf', 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 22:08:29', NULL, NULL),
(3, 'EMP0003', 'DNI', '1234567', 'COTRINA', 'ENRIQUE', 'VICTOR', '2005-07-30', 'PERUANO', 'Masculino', 'Soltero', '5112345678', '011234567', 'VCOTRINA@GMAIL.COM', 'LIMA', 'LIMA', 'SMP', 'AV. MAYO 2134', 1, '2025-08-19', 'Ejecutivo', 15, 2, 1, 'Activo', NULL, 'Eduación Especial', 'Completa', 'Privada', 'Escuela e Institutos de Educación Superior Tecnológicos de las Fuerzas Armadas', 'IBEROTEC', '  bn mnbjkhnbm', NULL, 'NOA', '0112345678', 'AMIGA', '2025-08-05', 'EMP0003/emple_archivo_documento_1234567.pdf', 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 22:37:13', NULL, NULL),
(4, 'EMP0004', 'DNI', '70064332', 'COTRINA', 'ENRIQUE', 'VICTOR', '2006-08-19', 'PERUANO', 'Masculino', 'Soltero', '5194651519', '011234567', 'VCOTRINA@GMAIL.COM', 'LIMA', 'LIMA', 'SMP', 'AV. MAYO 2134', 1, '2025-08-19', 'Ejecutivo', 16, 1, 1, 'Activo', NULL, 'Titulado', 'Completa', 'Pública', 'Educación Superior de Formación Artistica', 'IBEROTEC', 'INFORMAATICA Y SISTEMAS', '2018', 'NOA', '5194651519', 'AMIGA', '2025-08-19', 'documento_70064332.pdf', 'SI', '2025-08-19', 'a1_70064332.pdf', '2025-08-20', 'a2a_70064332.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 23:19:54', NULL, NULL),
(5, 'EMP0005', 'DNI', '70064332', 'COTRINA', 'ENRIQUE', 'VICTOR', '1997-02-27', 'PERUANO', 'Masculino', 'Casado', '51946515190', '011234567', 'VCOTRINA@GMAIL.COM', 'LIMA', 'LIMA', 'SMP', 'AV. MAYO 2134', 1, '2025-08-20', 'Ejecutivo', 16, 2, 1, 'Activo', NULL, 'Estudio de Maestría', 'Completa', 'Privada', 'Escuela e Institutos de Educación Superior Tecnológicos de las Fuerzas Armadas', 'IBEROTEC', 'INFORMAATICA Y SISTEMAS', '2026', 'NOA', '51946515190', 'AMIX', '2025-08-21', 'EMP0005/documento_70064332.pdf', 'SI', '2026-07-15', 'a1_70064332_20260304165452.pdf', '2026-05-06', 'a2a_70064332_20260304165452.jpeg', '2025-08-22', 'EMP0005/a2b_70064332.pdf', '2026-12-15', 'a3a_70064332_20260304172105.jpeg', '2025-08-24', 'EMP0005/a3b_70064332.pdf', '2025-08-25', 'EMP0005/a3c_70064332.pdf', '2025-08-26', 'EMP0005/b1_70064332.pdf', '2025-08-27', 'EMP0005/b2a_70064332.pdf', '2025-08-28', 'EMP0005/b2b_70064332.pdf', '2025-10-15', 'EMP0005/b2c_70064332.pdf', 1, '2025-08-20 16:13:41', '2026-03-04 11:21:05', NULL),
(15, 'EMP0006', 'DNI', '70064331', 'COTRINA', 'ENRIQUE', 'VICTOR', '2025-08-21', 'PERUANO', 'Masculino', 'Viudo', '99999999999', '999999999', 'VCOTRINA@GMAIL.COM', 'LIMA', 'LIMA', 'SMP', 'AV. MAYO 2134', 1, '2025-08-21', 'Ejecutivo', 14, 1, 1, 'Activo', NULL, 'Sin educación formal', 'Incompleta', 'Pública', 'Escuela e Institutos de Educación Superior Tecnológicos de las Fuerzas Armadas', 'ncg vnb vnbmnb,k', 'INFORMAATICA Y SISTEMAS', '2025', 'kkkkkkkkkk', '99999999999', 'iiiiii', '2025-08-13', 'EMP0006/documento_70064331.pdf', 'NO', NULL, 'EMP0006/', NULL, 'EMP0006/', NULL, 'EMP0006/', NULL, 'EMP0006/', NULL, 'EMP0006/', NULL, 'EMP0006/', NULL, 'EMP0006/', NULL, 'EMP0006/', NULL, 'EMP0006/', NULL, 'EMP0006/', 1, '2025-08-21 16:46:49', NULL, NULL),
(20, 'EMP0008', 'DNI', '70064331', 'COTRINA', 'ENRIQUE', 'VICTOR', '2025-12-10', 'PERUANO', 'Femenino', 'Soltero', '9999999999', '999999999', 'VCOTRINA@GMAIL.COM', 'LIMA', 'LIMA', 'Usuario', 'AV. MAYO 2134', 1, '2025-10-15', 'Ejecutivo', 13, 1, 1, 'Activo', NULL, 'Sin educación formal', 'Completa', 'No aplica', 'Educación Superior de Formación Artistica', 'IBEROTEC', 'INFORMAATICA Y SISTEMAS', '2025', 'kkkkkkkkkk', '99999999999', 'AMIX', '2025-12-10', 'EMP0008/documento_70064331.pdf', 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-12-10 16:29:04', NULL, NULL),
(22, 'EMP0009', 'DNI', '70064332', 'ZAPATA', 'ENRIQUE', 'VICTORdd', '2026-03-03', 'PERUANO', 'Masculino', 'Soltero', '51946515190', '017778874', 'VCOTRINA@GMAIL.COM', 'LIMA', 'LIMA', 'SMP', 'AV. MAYO 2134', 1, '2026-03-04', 'Ejecutivo', 13, 1, 1, 'Activo', NULL, 'Eduación Especial', 'Completa', 'No aplica', 'Educación Superior de Formación Artistica', 'IBEROTEC', 'INFORMAATICA Y SISTEMAS', '2017', 'NOA', '51946515190', 'AMIGA', '2026-03-04', 'documento_70064332_20260304160524.pdf', 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 23:06:35', '2026-03-17 15:41:22', NULL),
(23, 'EMP0007', 'DNI', '70064332', 'COTRINA', 'ENRIQUE', 'VICTORdd', '2026-03-03', 'PERUANO', 'Masculino', 'Soltero', '51946515190', '017778874', 'VCOTRINA@GMAIL.COM', 'LIMA', 'LIMA', 'SMP', 'AV. MAYO 2134', 1, '2026-03-04', 'Ejecutivo', 13, 1, 1, 'Activo', NULL, 'Eduación Especial', 'Completa', 'No aplica', 'Educación Superior de Formación Artistica', 'IBEROTEC', 'INFORMAATICA Y SISTEMAS', '2017', 'NOA', '51946515190', 'AMIGA', '2026-03-04', 'documento_70064332_20260304160524.pdf', 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 23:06:35', '2026-03-04 10:05:24', NULL),
(25, 'EMP0010', 'DNI', '123456789', 'COTRINA', 'ENRIQUE', 'VICTOR RAMIRO', '2026-03-01', 'PERUANO', 'Masculino', 'Soltero', '51946515190', '014789546', 'cotrinaramiro@gmil.com', 'lima', 'lima', 'Santa Anita', 'av. manues de la tores', 1, '2026-03-04', 'Ejecutivo', 13, 1, 1, 'Activo', NULL, 'Sin educación formal', 'Incompleta', 'Privada', 'Educación Superior de Formación Artistica', '13', 'chistemas', '2012', '<xx', '99999999999', 'xxxx', '2026-03-04', 'documento_123456789_20260304164859.pdf', 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-04 15:48:25', '2026-03-04 10:48:59', NULL),
(26, 'EMP0011', 'DNI', '70064335', 'COTRINA', 'ENRIQUE', 'VICTOR RAMIRO', '2026-03-04', 'PERUANO', 'Masculino', 'Soltero', '51946515190', '014789546', 'cotrinaramiro@gmil.com', 'lima', 'lima', 'Santa Anita', 'av. manues de la tores', 1, '2026-03-04', 'Ejecutivo', 13, 1, 2, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-04 16:32:45', NULL, NULL);

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

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`empre_id`, `empre_ruc`, `empre_razon_social`, `empre_nombre_comercial`, `empre_domicilio_legal`, `empre_numero_contacto`, `empre_email_contacto`, `empre_fecha_create`, `empre_fecha_update`, `empre_fecha_delete`) VALUES
(1, '20510976887', 'REPARTO PERU S.A.C.', 'REPARTO PERU', 'Av. Manuel de la Torre Nro. 183 (Frente a la Reniec Santa Anita)', '99999999', 'sistemas@repartoperu.com', '2024-03-15 23:05:49', NULL, NULL),
(2, '20556466948', 'VOLANS PERU S.A.C.', 'vlans', 'AV. MANUEL DE LA TORRE NRO. 183 URB. LOS FICUS LIMA LIMA SANTA ANITA', '946512233', 'ses@gmail.com', '2026-01-15 18:04:50', '2026-01-15 15:24:45', NULL),
(3, '20122545687', 'ttt', 'ft', 'dad', '946512233', 'ses@gmail.com', '2026-01-15 19:14:04', NULL, NULL);

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

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`movi_id`, `movi_tipo`, `movi_serie`, `movi_numero`, `movi_moneda`, `movi_fecha`, `movi_emple_id`, `movi_total`, `movi_fecha_create`, `movi_fecha_update`, `movi_fecha_delete`) VALUES
(13, 'EGRESO', '004', 2, 'SOLES', '2026-03-17', 22, '16.50', '2026-03-18 00:10:49', NULL, NULL),
(14, 'EGRESO', '004', 3, 'SOLES', '2026-03-17', 22, '54.00', '2026-03-18 00:13:12', NULL, NULL),
(15, 'INGRESO', '003', 1, 'SOLES', '2026-03-17', 1, '2000.00', '2026-03-18 00:16:03', NULL, NULL),
(16, 'INGRESO', '001', 1, 'SOLES', '2026-03-17', 25, '2000.00', '2026-03-18 00:21:55', NULL, NULL),
(17, 'EGRESO', '001', 1, 'DOLARES', '2026-03-18', 1, '15.00', '2026-03-18 19:40:45', NULL, NULL),
(18, 'INGRESO', '001', 1, 'DOLARES', '2026-03-10', 3, '2360.00', '2026-03-18 19:52:59', NULL, NULL);

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

--
-- Volcado de datos para la tabla `opts`
--

INSERT INTO `opts` (`opt_id`, `opt_cenco_codigo`, `opt_vehiculo_id`, `opt_cliente`, `opt_lugar`, `opt_fecha`, `opt_observado`, `opt_observador`, `opt_bps_encontrada`, `opt_500_pregunta1`, `opt_500_pregunta2`, `opt_500_pregunta3`, `opt_500_pregunta4`, `opt_500_pregunta5`, `opt_500_pregunta6`, `opt_500_pregunta7`, `opt_500_pregunta8`, `opt_500_pregunta9`, `opt_500_pregunta10`, `opt_500_pregunta11`, `opt_500_pregunta12`, `opt_500_pregunta13`, `opt_500_pregunta14`, `opt_500_pregunta15`, `opt_500_otros`, `opt_501_pregunta1`, `opt_501_pregunta2`, `opt_501_pregunta3`, `opt_501_pregunta4`, `opt_501_pregunta5`, `opt_501_pregunta6`, `opt_501_pregunta7`, `opt_501_pregunta8`, `opt_501_pregunta9`, `opt_501_pregunta10`, `opt_501_pregunta11`, `opt_501_pregunta12`, `opt_501_pregunta13`, `opt_501_pregunta14`, `opt_501_otros`, `opt_504_pregunta1`, `opt_504_pregunta2`, `opt_504_pregunta3`, `opt_504_pregunta4`, `opt_504_pregunta5`, `opt_504_pregunta6`, `opt_504_pregunta7`, `opt_504_pregunta8`, `opt_504_pregunta9`, `opt_504_pregunta10`, `opt_504_pregunta11`, `opt_504_pregunta12`, `opt_504_pregunta13`, `opt_504_pregunta14`, `opt_504_pregunta15`, `opt_504_pregunta16`, `opt_504_pregunta17`, `opt_504_pregunta18`, `opt_504_pregunta19`, `opt_504_pregunta20`, `opt_504_pregunta21`, `opt_504_pregunta22`, `opt_504_pregunta23`, `opt_504_pregunta24`, `opt_504_pregunta25`, `opt_504_otros`, `opt_506_pregunta1`, `opt_506_pregunta2`, `opt_506_pregunta3`, `opt_506_pregunta4`, `opt_506_pregunta5`, `opt_506_pregunta6`, `opt_506_pregunta7`, `opt_506_pregunta8`, `opt_506_pregunta9`, `opt_506_pregunta10`, `opt_506_pregunta11`, `opt_506_pregunta12`, `opt_506_pregunta13`, `opt_506_otros`, `opt_507_pregunta1`, `opt_507_pregunta2`, `opt_507_pregunta3`, `opt_507_pregunta4`, `opt_507_pregunta5`, `opt_507_pregunta6`, `opt_507_pregunta7`, `opt_507_pregunta8`, `opt_507_pregunta9`, `opt_507_pregunta10`, `opt_507_pregunta11`, `opt_507_pregunta12`, `opt_507_pregunta13`, `opt_507_pregunta14`, `opt_507_pregunta15`, `opt_507_pregunta16`, `opt_507_pregunta17`, `opt_507_pregunta18`, `opt_507_pregunta19`, `opt_507_pregunta20`, `opt_507_pregunta21`, `opt_507_pregunta22`, `opt_507_pregunta23`, `opt_507_pregunta24`, `opt_507_pregunta25`, `opt_507_otros`, `opt_508_pregunta1`, `opt_508_pregunta2`, `opt_508_pregunta3`, `opt_508_pregunta4`, `opt_508_pregunta5`, `opt_508_pregunta6`, `opt_508_pregunta7`, `opt_508_pregunta8`, `opt_508_pregunta9`, `opt_508_pregunta10`, `opt_508_pregunta11`, `opt_508_pregunta12`, `opt_508_pregunta13`, `opt_508_otros`, `opt_509_pregunta1`, `opt_509_pregunta2`, `opt_509_pregunta3`, `opt_509_pregunta4`, `opt_509_pregunta5`, `opt_509_pregunta6`, `opt_509_pregunta7`, `opt_509_pregunta8`, `opt_509_pregunta9`, `opt_509_pregunta10`, `opt_509_pregunta11`, `opt_509_pregunta12`, `opt_509_pregunta13`, `opt_509_pregunta14`, `opt_509_pregunta15`, `opt_509_pregunta16`, `opt_509_pregunta17`, `opt_509_pregunta18`, `opt_509_pregunta19`, `opt_509_pregunta20`, `opt_509_pregunta21`, `opt_509_pregunta22`, `opt_509_pregunta23`, `opt_509_pregunta24`, `opt_509_pregunta25`, `opt_509_otros`, `opt_511_pregunta1`, `opt_511_pregunta2`, `opt_511_pregunta3`, `opt_511_pregunta4`, `opt_511_pregunta5`, `opt_511_pregunta6`, `opt_511_pregunta7`, `opt_511_pregunta8`, `opt_511_pregunta9`, `opt_511_pregunta10`, `opt_511_pregunta11`, `opt_511_pregunta12`, `opt_511_pregunta13`, `opt_511_pregunta14`, `opt_511_pregunta15`, `opt_511_pregunta16`, `opt_511_pregunta17`, `opt_511_pregunta18`, `opt_511_pregunta19`, `opt_511_pregunta20`, `opt_511_pregunta21`, `opt_511_pregunta22`, `opt_511_pregunta23`, `opt_511_pregunta24`, `opt_511_pregunta25`, `opt_511_otros`, `opt_tipo_hallazgo`, `opt_relacionado`, `opt_decripcion_observacion`, `opt_decripcion_adicional`, `opt_correccion`, `opt_evidencia1`, `opt_evidencia2`, `opt_id_usuario`, `opt_fecha_create`, `opt_fecha_update`, `opt_fecha_delete`) VALUES
(1, '500', 1, 'VOLVO', 'VOLVO', '2026-03-02', 'VOLVO', 'Coordinador SIG-SSOMA', 'VOLVO', 'SI', 'SI', 'SI', 'SI', 'SI', 'SI', 'NO', 'SI', 'NO', 'SI', 'NO', 'SI', 'NO', 'SI', 'NO', 'oppppp', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Auditoría', 'Seguridad', 'VOLVO', 'VOLVO', 'VOLVO', 'vistas/img/sig/opt/2026-03-02_15-04-34/179.png', 'vistas/img/sig/opt/2026-03-02_15-04-34/658.jpg', 1, '2026-03-02 20:04:34', '2026-03-04 12:57:19', NULL);

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
(1, 'Usuario Administrado', 'admin', '$2a$07$asxx54ahjppf45sd87a5auXBm1Vr2M1NV5t/zNQtGHGpS5fFirrbG', 'Administrador', 'vistas/img/usuarios/admin/994.png', 0, '2026-03-18 17:19:30', '2026-03-18 15:45:24', '2026-03-18 23:58:46', '2026-03-18 18:58:46', 0),
(2, 'Victor Cotrina Enrique', 'vcotrina', '$2a$07$asxx54ahjppf45sd87a5auaK2UuY9I3HoWrDp0X6p.3tlEWlvSpv.', 'Usuario', 'vistas/img/usuarios/vcotrina/143.png', 1, '2026-03-18 18:28:14', '2026-03-18 21:41:18', '2026-03-18 23:28:14', NULL, 0),
(3, 'Ramiro Cotrina Enrique', 'rcotrina', '$2a$07$asxx54ahjppf45sd87a5auSCG6EtWTOSpeybRK.d3z3BAMJt.7teO', 'Usuario', 'vistas/img/usuarios/rcotrina/410.png', 1, '2025-01-15 16:30:58', '2026-03-18 21:34:09', NULL, NULL, 0);

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
(63, 1, 'inicio', '2026-03-18 21:17:12'),
(64, 1, 'usuarios', '2026-03-18 21:17:12'),
(65, 1, 'centro-costo', '2026-03-18 21:17:12'),
(66, 1, 'empresas', '2026-03-18 21:17:12'),
(67, 1, 'vehiculos', '2026-03-18 21:17:12'),
(68, 1, 'sig-opt', '2026-03-18 21:17:12'),
(69, 1, 'areas', '2026-03-18 21:17:12'),
(70, 1, 'empleados', '2026-03-18 21:17:12'),
(71, 1, 'movimiento-caja', '2026-03-18 21:17:12'),
(93, 2, 'centro-costo', '2026-03-18 23:28:52'),
(94, 2, 'vehiculos', '2026-03-18 23:28:52'),
(95, 2, 'orden-servicio', '2026-03-18 23:28:52');

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
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`vehic_id`, `vehic_cenco_id`, `vehic_placa`, `vehic_marca`, `vehic_modelo`, `vehic_anio`, `vehic_clase`, `vehic_numero_vin`, `vehic_numero_motor`, `vehic_jefe_operacion`, `vehic_estado`, `vehic_propietario`, `vehic_fecha_create`, `vehic_fecha_update`, `vehic_fecha_delete`) VALUES
(1, 20, 'ABC-900', 'VOLVO', 'VOLVO', '2012', 'VOLVOs', 'VOLVO123', 'VOLVO', 'VOLVO', 'OPERATIVA', 'VOLVO', '2026-03-06 20:57:56', '2026-03-16 12:37:41', NULL),
(2, 32, 'AUX938', 'volvo', 'volvo', '2021', 'ddf', 'DDAAAAAAAA', '544A44S', 'aad', 'OPERATIVA', 'reparto peru', '2026-03-06 20:57:56', NULL, NULL),
(3, 21, 'AMA790', 'volvo', 'volvo', 'volvo', 'volvo', 'DADADZZD', 'ADASS', 'aad', 'OPERATIVA', 'reparto peru', '2026-03-06 21:00:33', NULL, NULL),
(4, 30, 'ANO987', 'volvo', 'volvo', '2020', 'volvo', 'GGGGGGGFFFFFFFFFF', 'DFDFDF', 'JE', 'OPERATIVA', 'reparto peru', '2026-03-16 17:37:28', NULL, NULL);

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
  MODIFY `are_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cargos`
--
ALTER TABLE `cargos`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `centro_costo`
--
ALTER TABLE `centro_costo`
  MODIFY `cenco_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `config_series`
--
ALTER TABLE `config_series`
  MODIFY `conf_seri_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `detalle_movimiento`
--
ALTER TABLE `detalle_movimiento`
  MODIFY `deta_movi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `emple_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `empre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `movi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `opts`
--
ALTER TABLE `opts`
  MODIFY `opt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios_modulos`
--
ALTER TABLE `usuarios_modulos`
  MODIFY `umod_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `vehic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
