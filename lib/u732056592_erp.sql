-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 20, 2026 at 11:39 PM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u732056592_erp`
--

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `are_id` int(11) NOT NULL,
  `are_nombre` text DEFAULT NULL,
  `are_fecha_create` timestamp NOT NULL DEFAULT current_timestamp(),
  `are_fecha_update` datetime DEFAULT NULL,
  `are_fecha_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`are_id`, `are_nombre`, `are_fecha_create`, `are_fecha_update`, `are_fecha_delete`) VALUES
(1, 'RECURSOS HUMANOS', '2026-03-19 23:40:30', NULL, NULL),
(2, 'SSOMA', '2026-03-19 23:40:43', NULL, NULL),
(3, 'GERENCIA', '2026-03-19 23:40:51', NULL, NULL),
(4, 'CONTABILIDAD', '2026-03-19 23:41:03', NULL, NULL),
(5, 'OPERACIONES', '2026-03-19 23:52:00', NULL, NULL),
(6, 'SISTEMAS', '2026-03-20 00:01:04', NULL, NULL),
(7, 'MANTENIMIENTO', '2026-03-20 16:23:59', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cargos`
--

CREATE TABLE `cargos` (
  `car_id` int(11) NOT NULL,
  `car_nombre` text DEFAULT NULL,
  `car_fecha_create` timestamp NOT NULL DEFAULT current_timestamp(),
  `car_fecha_update` datetime DEFAULT NULL,
  `car_fecha_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cargos`
--

INSERT INTO `cargos` (`car_id`, `car_nombre`, `car_fecha_create`, `car_fecha_update`, `car_fecha_delete`) VALUES
(1, 'CONDUCTOR', '2026-03-19 23:39:23', NULL, NULL),
(2, 'ADMINISTRATIVO', '2026-03-19 23:39:35', NULL, NULL),
(3, 'OPERATIVO', '2026-03-19 23:39:45', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `centro_costo`
--

CREATE TABLE `centro_costo` (
  `cenco_id` int(11) NOT NULL,
  `cenco_codigo` text DEFAULT NULL,
  `cenco_nombre` text DEFAULT NULL,
  `cenco_fecha_create` timestamp NOT NULL DEFAULT current_timestamp(),
  `cenco_fecha_update` datetime DEFAULT NULL,
  `cenco_fecha_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `centro_costo`
--

INSERT INTO `centro_costo` (`cenco_id`, `cenco_codigo`, `cenco_nombre`, `cenco_fecha_create`, `cenco_fecha_update`, `cenco_fecha_delete`) VALUES
(1, '01', 'SENDA', '2026-03-19 23:43:39', NULL, NULL),
(2, '02', 'URBANIZA', '2026-03-19 23:44:02', NULL, NULL),
(3, '03', 'ALPAYANA', '2026-03-19 23:44:18', NULL, NULL),
(4, '04', 'CIEMSA', '2026-03-19 23:44:40', NULL, NULL),
(5, '05', 'N/A', '2026-03-19 23:49:43', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `config_series`
--

CREATE TABLE `config_series` (
  `conf_seri_id` int(11) NOT NULL,
  `conf_seri_tipo` varchar(10) DEFAULT NULL,
  `conf_seri_moneda` varchar(10) DEFAULT NULL,
  `conf_seri_serie` varchar(10) DEFAULT NULL,
  `conf_seri_ultimo_numero` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `config_series`
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
(9, 'EGRESO', 'SOLES', '004', 1);

-- --------------------------------------------------------

--
-- Table structure for table `detalle_movimiento`
--

CREATE TABLE `detalle_movimiento` (
  `deta_movi_id` int(11) NOT NULL,
  `deta_movi_movimiento_id` int(11) DEFAULT NULL,
  `deta_movi_item` int(11) DEFAULT NULL,
  `deta_movi_descripcion` varchar(255) DEFAULT NULL,
  `deta_movi_importe` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detalle_movimiento`
--

INSERT INTO `detalle_movimiento` (`deta_movi_id`, `deta_movi_movimiento_id`, `deta_movi_item`, `deta_movi_descripcion`, `deta_movi_importe`) VALUES
(1, 1, 1, 'LIQ.002-275 ATL908 RELACIONADO A 002-248', 250.00);

-- --------------------------------------------------------

--
-- Table structure for table `empleados`
--

CREATE TABLE `empleados` (
  `emple_id` int(11) NOT NULL,
  `emple_codigo` varchar(50) NOT NULL,
  `emple_tipo_documento` varchar(100) DEFAULT NULL,
  `emple_numero_documento` varchar(50) DEFAULT NULL,
  `emple_apellido_paterno` varchar(100) DEFAULT NULL,
  `emple_apellido_materno` varchar(100) DEFAULT NULL,
  `emple_nombres` varchar(100) DEFAULT NULL,
  `emple_fecha_nacimiento` date DEFAULT NULL,
  `emple_nacionalidad` varchar(100) DEFAULT NULL,
  `emple_sexo` varchar(10) DEFAULT NULL,
  `emple_estado_civil` varchar(10) DEFAULT NULL,
  `emple_telefono_movil` varchar(20) DEFAULT NULL,
  `emple_telefono_fijo` varchar(20) DEFAULT NULL,
  `emple_correo` varchar(50) DEFAULT NULL,
  `emple_departamento` varchar(50) DEFAULT NULL,
  `emple_provincia` varchar(50) DEFAULT NULL,
  `emple_distrito` varchar(50) DEFAULT NULL,
  `emple_lugar_residencia` varchar(250) DEFAULT NULL,
  `emple_empresa_id` int(11) NOT NULL,
  `emple_fecha_ingreso` date DEFAULT NULL,
  `emple_categoria_ocupacional` varchar(50) DEFAULT NULL,
  `emple_cenco_id` int(11) NOT NULL,
  `emple_area_id` int(11) NOT NULL,
  `emple_cargo_id` int(11) NOT NULL,
  `emple_estado` varchar(50) DEFAULT NULL,
  `emple_fecha_cese` date DEFAULT NULL,
  `emple_situacion_educativa` varchar(100) DEFAULT NULL,
  `emple_estado_educativa` varchar(50) DEFAULT NULL,
  `emple_tipo_regimen` varchar(50) DEFAULT NULL,
  `emple_tipo_institucion` varchar(100) DEFAULT NULL,
  `emple_institucion` varchar(200) DEFAULT NULL,
  `emple_carrera` varchar(200) DEFAULT NULL,
  `emple_anio` varchar(4) DEFAULT NULL,
  `emple_nombre_familiar` varchar(100) DEFAULT NULL,
  `emple_telefono_familiar` varchar(20) DEFAULT NULL,
  `emple_parentesco` varchar(50) DEFAULT NULL,
  `emple_fecha_vencimiento_documento` date DEFAULT NULL,
  `emple_archivo_documento` varchar(100) DEFAULT NULL,
  `emple_licencia` varchar(5) DEFAULT NULL,
  `emple_fecha_vencimiento_a1` date DEFAULT NULL,
  `emple_archivo_a1` varchar(100) DEFAULT NULL,
  `emple_fecha_vencimiento_a2a` date DEFAULT NULL,
  `emple_archivo_a2a` varchar(100) DEFAULT NULL,
  `emple_fecha_vencimiento_a2b` date DEFAULT NULL,
  `emple_archivo_a2b` varchar(100) DEFAULT NULL,
  `emple_fecha_vencimiento_a3a` date DEFAULT NULL,
  `emple_archivo_a3a` varchar(100) DEFAULT NULL,
  `emple_fecha_vencimiento_a3b` date DEFAULT NULL,
  `emple_archivo_a3b` varchar(100) DEFAULT NULL,
  `emple_fecha_vencimiento_a3c` date DEFAULT NULL,
  `emple_archivo_a3c` varchar(100) DEFAULT NULL,
  `emple_fecha_vencimiento_b1` date DEFAULT NULL,
  `emple_archivo_b1` varchar(100) DEFAULT NULL,
  `emple_fecha_vencimiento_b2a` date DEFAULT NULL,
  `emple_archivo_b2a` varchar(100) DEFAULT NULL,
  `emple_fecha_vencimiento_b2b` date DEFAULT NULL,
  `emple_archivo_b2b` varchar(100) DEFAULT NULL,
  `emple_fecha_vencimiento_b2c` date DEFAULT NULL,
  `emple_archivo_b2c` varchar(100) DEFAULT NULL,
  `emple_id_usuario` int(11) NOT NULL,
  `emple_fecha_create` timestamp NOT NULL DEFAULT current_timestamp(),
  `emple_fecha_update` datetime DEFAULT NULL,
  `emple_fecha_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `empleados`
--

INSERT INTO `empleados` (`emple_id`, `emple_codigo`, `emple_tipo_documento`, `emple_numero_documento`, `emple_apellido_paterno`, `emple_apellido_materno`, `emple_nombres`, `emple_fecha_nacimiento`, `emple_nacionalidad`, `emple_sexo`, `emple_estado_civil`, `emple_telefono_movil`, `emple_telefono_fijo`, `emple_correo`, `emple_departamento`, `emple_provincia`, `emple_distrito`, `emple_lugar_residencia`, `emple_empresa_id`, `emple_fecha_ingreso`, `emple_categoria_ocupacional`, `emple_cenco_id`, `emple_area_id`, `emple_cargo_id`, `emple_estado`, `emple_fecha_cese`, `emple_situacion_educativa`, `emple_estado_educativa`, `emple_tipo_regimen`, `emple_tipo_institucion`, `emple_institucion`, `emple_carrera`, `emple_anio`, `emple_nombre_familiar`, `emple_telefono_familiar`, `emple_parentesco`, `emple_fecha_vencimiento_documento`, `emple_archivo_documento`, `emple_licencia`, `emple_fecha_vencimiento_a1`, `emple_archivo_a1`, `emple_fecha_vencimiento_a2a`, `emple_archivo_a2a`, `emple_fecha_vencimiento_a2b`, `emple_archivo_a2b`, `emple_fecha_vencimiento_a3a`, `emple_archivo_a3a`, `emple_fecha_vencimiento_a3b`, `emple_archivo_a3b`, `emple_fecha_vencimiento_a3c`, `emple_archivo_a3c`, `emple_fecha_vencimiento_b1`, `emple_archivo_b1`, `emple_fecha_vencimiento_b2a`, `emple_archivo_b2a`, `emple_fecha_vencimiento_b2b`, `emple_archivo_b2b`, `emple_fecha_vencimiento_b2c`, `emple_archivo_b2c`, `emple_id_usuario`, `emple_fecha_create`, `emple_fecha_update`, `emple_fecha_delete`) VALUES
(1, 'EMP0001', 'DNI', '46922107', 'ACUÑA', 'ORE', 'SAUL JOSIAS', '2026-03-19', 'PERUANO', 'Masculino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-19', NULL, 5, 5, 1, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-19 23:51:27', '2026-03-19 18:52:21', NULL),
(2, 'EMP0002', 'DNI', '48568887', 'APARCO', 'SALCEDO', 'ABEL LUIS', '2026-03-19', 'PERUANO', 'Masculino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-19', NULL, 5, 5, 1, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-19 23:53:35', NULL, NULL),
(3, 'EMP0003', 'DNI', '42033005', 'CAMPOS', 'ARIAS', 'JESUS', '2026-03-19', 'PERUANO', 'Masculino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-19', NULL, 5, 3, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-19 23:54:53', NULL, NULL),
(4, 'EMP0004', 'DNI', '44778643', 'CARHUAMACA', 'CASIMIRO', 'RAUL EFRAIN', '2026-03-19', 'PERUANO', 'Masculino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-19', NULL, 5, 5, 1, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-19 23:56:01', NULL, NULL),
(5, 'EMP0005', 'DNI', '42361931', 'CASTRO', 'CAMPOS', 'MARITZA CINTHYA', '2026-03-19', 'PERUANO', 'Femenino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-19', NULL, 5, 1, 2, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-19 23:57:45', NULL, NULL),
(6, 'EMP0006', 'DNI', '41660068', 'CASTRO', 'CHACON', 'EDWIN FRANK', '2026-03-19', 'PERUANO', 'Masculino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-19', NULL, 5, 5, 3, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-19 23:59:08', NULL, NULL),
(7, 'EMP0007', 'DNI', '30674962', 'CONDO', 'CHAUPE', 'BRUNO MIGUEL', '2026-03-19', 'PERUANO', 'Masculino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-19', NULL, 5, 5, 3, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20 00:00:31', NULL, NULL),
(8, 'EMP0008', 'DNI', '70064332', 'COTRINA', 'ENRIQUE', 'VICTOR RAMIRO', '2026-03-19', 'PERUANO', 'Masculino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-19', NULL, 5, 6, 2, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20 00:02:11', NULL, NULL),
(9, 'EMP0009', 'DNI', '72581410', 'ECHEVARRIA', 'ROSAS', 'NICOLAS ELI', '2026-03-20', 'PERUANO', 'Masculino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20', NULL, 5, 5, 1, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20 14:47:38', NULL, NULL),
(10, 'EMP0010', 'DNI', '09507517', 'ESTEBAN', 'BARZOLA', 'CARMEN ISABEL', '2026-03-20', 'PERUANO', 'Femenino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20', NULL, 5, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20 14:48:52', NULL, NULL),
(11, 'EMP0011', 'DNI', '76859561', 'JAVIER', 'TORIBIO', 'EDILSON ABEL', '2026-03-20', 'PERUANO', 'Masculino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20', NULL, 5, 5, 1, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20 14:49:54', NULL, NULL),
(12, 'EMP0012', 'DNI', '20578996', 'KRIETE', 'AYLAS', 'ALFREDO FERNANDO', '2026-03-20', 'PERUANO', 'Masculino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20', NULL, 5, 5, 1, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20 14:52:08', NULL, NULL),
(13, 'EMP0013', 'DNI', '04222281', 'MATEO', 'CHAVEZ', 'CLEVER BENJAMIN', '2026-03-20', 'PERUANO', 'Masculino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20', NULL, 5, 5, 1, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20 14:53:30', NULL, NULL),
(14, 'EMP0014', 'DNI', '07115456', 'MELENDEZ', 'CANCHAN', 'JOSE ARNALDO', '2026-03-20', 'PERUANO', 'Masculino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20', NULL, 5, 5, 1, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20 15:09:22', NULL, NULL),
(15, 'EMP0015', 'DNI', '41941335', 'MUJE', 'TAIPE', 'JUDITH', '2026-03-20', 'PERUANO', 'Femenino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20', NULL, 5, 4, 2, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20 15:10:25', NULL, NULL),
(16, 'EMP0016', 'DNI', '71237949', 'QUEZADA', 'BELTRAN', 'KAROL YELINA', '2026-03-20', 'PERUANO', 'Femenino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20', NULL, 5, 2, 2, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20 15:11:34', NULL, NULL),
(17, 'EMP0017', 'DNI', '04032067', 'QUISPE', 'BEDOYA', 'JULIO YSAAC', '2026-03-20', 'PERUANO', 'Masculino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20', NULL, 5, 5, 3, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20 15:16:07', NULL, NULL),
(19, 'EMP0018', 'DNI', '07481798', 'ROQUE', 'MOZOMBITE', 'ROSA MERCEDES', '2026-03-20', 'PERUANO', 'Femenino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20', NULL, 5, 5, 2, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20 15:25:22', NULL, NULL),
(20, 'EMP0019', 'DNI', '25805541', 'SANCHEZ', 'VALENZUELA', 'ALIPIO', '2026-03-20', 'PERUANO', 'Masculino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20', NULL, 5, 5, 1, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20 15:27:53', NULL, NULL),
(21, 'EMP0020', 'DNI', '72004945', 'SILVA', 'CALDERON', 'GILMER', '2026-03-20', 'PERUANO', 'Masculino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20', NULL, 5, 5, 3, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20 16:11:29', NULL, NULL),
(22, 'EMP0021', 'DNI', '46926927', 'TORRES', 'AQUINO', 'GOMER', '2026-03-20', 'PERUANO', 'Masculino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20', NULL, 5, 5, 1, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20 16:12:33', NULL, NULL),
(23, 'EMP0022', 'DNI', '45243385', 'URBANO', 'CALLE', 'MISAEL', '2026-03-20', 'PERUANO', 'Masculino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20', NULL, 5, 5, 1, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20 16:13:30', NULL, NULL),
(24, 'EMP0023', 'DNI', '20902461', 'VASQUEZ', 'URETA', 'ROGER NORMAN', '2026-03-20', 'PERUANO', 'Masculino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20', NULL, 5, 5, 1, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20 16:15:43', NULL, NULL),
(25, 'EMP0024', 'DNI', '72004508', 'YANTAS', 'BASUALDO', 'JHON ALEX', '2026-03-20', 'PERUANO', 'Masculino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20', NULL, 5, 7, 2, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20 16:16:57', '2026-03-20 11:25:00', NULL),
(26, 'EMP0025', 'DNI', '44187588', 'ZANABRIA', 'LUYA', 'MARTHA MONICA', '2026-03-20', 'PERUANO', 'Femenino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20', NULL, 5, 4, 2, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20 16:18:24', NULL, NULL),
(27, 'EMP0026', 'DNI', '70232557', 'ZUÑIGA', 'AROHUILLCA', 'CASIMIRO', '2026-03-20', 'PERUANO', 'Masculino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20', NULL, 5, 5, 1, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20 16:19:41', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `empresas`
--

CREATE TABLE `empresas` (
  `empre_id` int(11) NOT NULL,
  `empre_ruc` text DEFAULT NULL,
  `empre_razon_social` text DEFAULT NULL,
  `empre_nombre_comercial` text DEFAULT NULL,
  `empre_domicilio_legal` text DEFAULT NULL,
  `empre_numero_contacto` text DEFAULT NULL,
  `empre_email_contacto` text DEFAULT NULL,
  `empre_fecha_create` timestamp NOT NULL DEFAULT current_timestamp(),
  `empre_fecha_update` datetime DEFAULT NULL,
  `empre_fecha_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `empresas`
--

INSERT INTO `empresas` (`empre_id`, `empre_ruc`, `empre_razon_social`, `empre_nombre_comercial`, `empre_domicilio_legal`, `empre_numero_contacto`, `empre_email_contacto`, `empre_fecha_create`, `empre_fecha_update`, `empre_fecha_delete`) VALUES
(1, '20160364719', 'EMPRESA DE TRANSPORTES MANUEL JESUS CAMPOS CALLUPE S.R.L.', 'TMC', 'JR. MINERIA NRO. 320 URB. LOS FICUS LIMA LIMA SANTA ANITA', '999999999', 'info@transportescampos.com', '2026-03-19 22:53:53', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `movimientos`
--

CREATE TABLE `movimientos` (
  `movi_id` int(11) NOT NULL,
  `movi_tipo` varchar(10) DEFAULT NULL,
  `movi_serie` varchar(10) DEFAULT NULL,
  `movi_numero` int(11) DEFAULT NULL,
  `movi_moneda` varchar(10) DEFAULT NULL,
  `movi_fecha` date DEFAULT NULL,
  `movi_emple_id` int(11) DEFAULT NULL,
  `movi_total` decimal(10,2) DEFAULT NULL,
  `movi_fecha_create` timestamp NOT NULL DEFAULT current_timestamp(),
  `movi_fecha_update` datetime DEFAULT NULL,
  `movi_fecha_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movimientos`
--

INSERT INTO `movimientos` (`movi_id`, `movi_tipo`, `movi_serie`, `movi_numero`, `movi_moneda`, `movi_fecha`, `movi_emple_id`, `movi_total`, `movi_fecha_create`, `movi_fecha_update`, `movi_fecha_delete`) VALUES
(1, 'EGRESO', '004', 1, 'SOLES', '2026-03-22', 22, 250.00, '2026-03-20 22:12:06', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `opts`
--

CREATE TABLE `opts` (
  `opt_id` int(11) NOT NULL,
  `opt_cenco_codigo` text DEFAULT NULL,
  `opt_vehiculo_id` int(11) DEFAULT NULL,
  `opt_cliente` text DEFAULT NULL,
  `opt_lugar` text DEFAULT NULL,
  `opt_fecha` date NOT NULL,
  `opt_observado` text DEFAULT NULL,
  `opt_observador` text DEFAULT NULL,
  `opt_bps_encontrada` text DEFAULT NULL,
  `opt_500_pregunta1` text DEFAULT NULL,
  `opt_500_pregunta2` text DEFAULT NULL,
  `opt_500_pregunta3` text DEFAULT NULL,
  `opt_500_pregunta4` text DEFAULT NULL,
  `opt_500_pregunta5` text DEFAULT NULL,
  `opt_500_pregunta6` text DEFAULT NULL,
  `opt_500_pregunta7` text DEFAULT NULL,
  `opt_500_pregunta8` text DEFAULT NULL,
  `opt_500_pregunta9` text DEFAULT NULL,
  `opt_500_pregunta10` text DEFAULT NULL,
  `opt_500_pregunta11` text DEFAULT NULL,
  `opt_500_pregunta12` text DEFAULT NULL,
  `opt_500_pregunta13` text DEFAULT NULL,
  `opt_500_pregunta14` text DEFAULT NULL,
  `opt_500_pregunta15` text DEFAULT NULL,
  `opt_500_otros` text DEFAULT NULL,
  `opt_501_pregunta1` text DEFAULT NULL,
  `opt_501_pregunta2` text DEFAULT NULL,
  `opt_501_pregunta3` text DEFAULT NULL,
  `opt_501_pregunta4` text DEFAULT NULL,
  `opt_501_pregunta5` text DEFAULT NULL,
  `opt_501_pregunta6` text DEFAULT NULL,
  `opt_501_pregunta7` text DEFAULT NULL,
  `opt_501_pregunta8` text DEFAULT NULL,
  `opt_501_pregunta9` text DEFAULT NULL,
  `opt_501_pregunta10` text DEFAULT NULL,
  `opt_501_pregunta11` text DEFAULT NULL,
  `opt_501_pregunta12` text DEFAULT NULL,
  `opt_501_pregunta13` text DEFAULT NULL,
  `opt_501_pregunta14` text DEFAULT NULL,
  `opt_501_otros` text DEFAULT NULL,
  `opt_504_pregunta1` text DEFAULT NULL,
  `opt_504_pregunta2` text DEFAULT NULL,
  `opt_504_pregunta3` text DEFAULT NULL,
  `opt_504_pregunta4` text DEFAULT NULL,
  `opt_504_pregunta5` text DEFAULT NULL,
  `opt_504_pregunta6` text DEFAULT NULL,
  `opt_504_pregunta7` text DEFAULT NULL,
  `opt_504_pregunta8` text DEFAULT NULL,
  `opt_504_pregunta9` text DEFAULT NULL,
  `opt_504_pregunta10` text DEFAULT NULL,
  `opt_504_pregunta11` text DEFAULT NULL,
  `opt_504_pregunta12` text DEFAULT NULL,
  `opt_504_pregunta13` text DEFAULT NULL,
  `opt_504_pregunta14` text DEFAULT NULL,
  `opt_504_pregunta15` text DEFAULT NULL,
  `opt_504_pregunta16` text DEFAULT NULL,
  `opt_504_pregunta17` text DEFAULT NULL,
  `opt_504_pregunta18` text DEFAULT NULL,
  `opt_504_pregunta19` text DEFAULT NULL,
  `opt_504_pregunta20` text DEFAULT NULL,
  `opt_504_pregunta21` text DEFAULT NULL,
  `opt_504_pregunta22` text DEFAULT NULL,
  `opt_504_pregunta23` text DEFAULT NULL,
  `opt_504_pregunta24` text DEFAULT NULL,
  `opt_504_pregunta25` text DEFAULT NULL,
  `opt_504_otros` text DEFAULT NULL,
  `opt_506_pregunta1` text DEFAULT NULL,
  `opt_506_pregunta2` text DEFAULT NULL,
  `opt_506_pregunta3` text DEFAULT NULL,
  `opt_506_pregunta4` text DEFAULT NULL,
  `opt_506_pregunta5` text DEFAULT NULL,
  `opt_506_pregunta6` text DEFAULT NULL,
  `opt_506_pregunta7` text DEFAULT NULL,
  `opt_506_pregunta8` text DEFAULT NULL,
  `opt_506_pregunta9` text DEFAULT NULL,
  `opt_506_pregunta10` text DEFAULT NULL,
  `opt_506_pregunta11` text DEFAULT NULL,
  `opt_506_pregunta12` text DEFAULT NULL,
  `opt_506_pregunta13` text DEFAULT NULL,
  `opt_506_otros` text DEFAULT NULL,
  `opt_507_pregunta1` text DEFAULT NULL,
  `opt_507_pregunta2` text DEFAULT NULL,
  `opt_507_pregunta3` text DEFAULT NULL,
  `opt_507_pregunta4` text DEFAULT NULL,
  `opt_507_pregunta5` text DEFAULT NULL,
  `opt_507_pregunta6` text DEFAULT NULL,
  `opt_507_pregunta7` text DEFAULT NULL,
  `opt_507_pregunta8` text DEFAULT NULL,
  `opt_507_pregunta9` text DEFAULT NULL,
  `opt_507_pregunta10` text DEFAULT NULL,
  `opt_507_pregunta11` text DEFAULT NULL,
  `opt_507_pregunta12` text DEFAULT NULL,
  `opt_507_pregunta13` text DEFAULT NULL,
  `opt_507_pregunta14` text DEFAULT NULL,
  `opt_507_pregunta15` text DEFAULT NULL,
  `opt_507_pregunta16` text DEFAULT NULL,
  `opt_507_pregunta17` text DEFAULT NULL,
  `opt_507_pregunta18` text DEFAULT NULL,
  `opt_507_pregunta19` text DEFAULT NULL,
  `opt_507_pregunta20` text DEFAULT NULL,
  `opt_507_pregunta21` text DEFAULT NULL,
  `opt_507_pregunta22` text DEFAULT NULL,
  `opt_507_pregunta23` text DEFAULT NULL,
  `opt_507_pregunta24` text DEFAULT NULL,
  `opt_507_pregunta25` text DEFAULT NULL,
  `opt_507_otros` text DEFAULT NULL,
  `opt_508_pregunta1` text DEFAULT NULL,
  `opt_508_pregunta2` text DEFAULT NULL,
  `opt_508_pregunta3` text DEFAULT NULL,
  `opt_508_pregunta4` text DEFAULT NULL,
  `opt_508_pregunta5` text DEFAULT NULL,
  `opt_508_pregunta6` text DEFAULT NULL,
  `opt_508_pregunta7` text DEFAULT NULL,
  `opt_508_pregunta8` text DEFAULT NULL,
  `opt_508_pregunta9` text DEFAULT NULL,
  `opt_508_pregunta10` text DEFAULT NULL,
  `opt_508_pregunta11` text DEFAULT NULL,
  `opt_508_pregunta12` text DEFAULT NULL,
  `opt_508_pregunta13` text DEFAULT NULL,
  `opt_508_otros` text DEFAULT NULL,
  `opt_509_pregunta1` text DEFAULT NULL,
  `opt_509_pregunta2` text DEFAULT NULL,
  `opt_509_pregunta3` text DEFAULT NULL,
  `opt_509_pregunta4` text DEFAULT NULL,
  `opt_509_pregunta5` text DEFAULT NULL,
  `opt_509_pregunta6` text DEFAULT NULL,
  `opt_509_pregunta7` text DEFAULT NULL,
  `opt_509_pregunta8` text DEFAULT NULL,
  `opt_509_pregunta9` text DEFAULT NULL,
  `opt_509_pregunta10` text DEFAULT NULL,
  `opt_509_pregunta11` text DEFAULT NULL,
  `opt_509_pregunta12` text DEFAULT NULL,
  `opt_509_pregunta13` text DEFAULT NULL,
  `opt_509_pregunta14` text DEFAULT NULL,
  `opt_509_pregunta15` text DEFAULT NULL,
  `opt_509_pregunta16` text DEFAULT NULL,
  `opt_509_pregunta17` text DEFAULT NULL,
  `opt_509_pregunta18` text DEFAULT NULL,
  `opt_509_pregunta19` text DEFAULT NULL,
  `opt_509_pregunta20` text DEFAULT NULL,
  `opt_509_pregunta21` text DEFAULT NULL,
  `opt_509_pregunta22` text DEFAULT NULL,
  `opt_509_pregunta23` text DEFAULT NULL,
  `opt_509_pregunta24` text DEFAULT NULL,
  `opt_509_pregunta25` text DEFAULT NULL,
  `opt_509_otros` text DEFAULT NULL,
  `opt_511_pregunta1` text DEFAULT NULL,
  `opt_511_pregunta2` text DEFAULT NULL,
  `opt_511_pregunta3` text DEFAULT NULL,
  `opt_511_pregunta4` text DEFAULT NULL,
  `opt_511_pregunta5` text DEFAULT NULL,
  `opt_511_pregunta6` text DEFAULT NULL,
  `opt_511_pregunta7` text DEFAULT NULL,
  `opt_511_pregunta8` text DEFAULT NULL,
  `opt_511_pregunta9` text DEFAULT NULL,
  `opt_511_pregunta10` text DEFAULT NULL,
  `opt_511_pregunta11` text DEFAULT NULL,
  `opt_511_pregunta12` text DEFAULT NULL,
  `opt_511_pregunta13` text DEFAULT NULL,
  `opt_511_pregunta14` text DEFAULT NULL,
  `opt_511_pregunta15` text DEFAULT NULL,
  `opt_511_pregunta16` text DEFAULT NULL,
  `opt_511_pregunta17` text DEFAULT NULL,
  `opt_511_pregunta18` text DEFAULT NULL,
  `opt_511_pregunta19` text DEFAULT NULL,
  `opt_511_pregunta20` text DEFAULT NULL,
  `opt_511_pregunta21` text DEFAULT NULL,
  `opt_511_pregunta22` text DEFAULT NULL,
  `opt_511_pregunta23` text DEFAULT NULL,
  `opt_511_pregunta24` text DEFAULT NULL,
  `opt_511_pregunta25` text DEFAULT NULL,
  `opt_511_otros` text DEFAULT NULL,
  `opt_tipo_hallazgo` text DEFAULT NULL,
  `opt_relacionado` text DEFAULT NULL,
  `opt_decripcion_observacion` text DEFAULT NULL,
  `opt_decripcion_adicional` text DEFAULT NULL,
  `opt_correccion` text DEFAULT NULL,
  `opt_evidencia1` text DEFAULT NULL,
  `opt_evidencia2` text DEFAULT NULL,
  `opt_id_usuario` int(11) NOT NULL,
  `opt_fecha_create` timestamp NOT NULL DEFAULT current_timestamp(),
  `opt_fecha_update` datetime DEFAULT NULL,
  `opt_fecha_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `usu_id` int(11) NOT NULL,
  `usu_nombre` varchar(100) DEFAULT NULL,
  `usu_usuario` varchar(50) DEFAULT NULL,
  `usu_password` varchar(255) DEFAULT NULL,
  `usu_perfil` varchar(50) DEFAULT NULL,
  `usu_foto` text DEFAULT NULL,
  `usu_estado` int(11) DEFAULT NULL,
  `usu_ultimo_login` datetime DEFAULT NULL,
  `usu_fecha_create` timestamp NOT NULL DEFAULT current_timestamp(),
  `usu_fecha_update` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `usu_fecha_delete` datetime DEFAULT NULL,
  `usu_es_master` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Flag: 1=cuenta master con permiso de eliminacion fisica'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`usu_id`, `usu_nombre`, `usu_usuario`, `usu_password`, `usu_perfil`, `usu_foto`, `usu_estado`, `usu_ultimo_login`, `usu_fecha_create`, `usu_fecha_update`, `usu_fecha_delete`, `usu_es_master`) VALUES
(1, 'Usuario Administrado', 'admin', '$2a$07$asxx54ahjppf45sd87a5auXBm1Vr2M1NV5t/zNQtGHGpS5fFirrbG', 'Administrador', 'vistas/img/usuarios/admin/254.jpg', 1, '2026-03-20 10:35:37', '2026-03-18 15:45:24', '2026-03-20 15:35:37', NULL, 0),
(4, 'Cinthya Castro Campos', 'ccastro', '$2a$07$asxx54ahjppf45sd87a5auif18O4gzCcDqpF2w4htO8A6rPYLRzBq', 'Usuario', '', 1, '2026-03-20 17:09:12', '2026-03-20 15:33:29', '2026-03-20 22:09:12', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios_modulos`
--

CREATE TABLE `usuarios_modulos` (
  `umod_id` int(10) UNSIGNED NOT NULL,
  `usu_id` int(11) NOT NULL,
  `modulo` varchar(80) NOT NULL,
  `umod_fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usuarios_modulos`
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
(109, 1, 'orden-servicio', '2026-03-19 16:49:40'),
(119, 4, 'centro-costo', '2026-03-20 15:35:58'),
(120, 4, 'empresas', '2026-03-20 15:35:58'),
(121, 4, 'areas', '2026-03-20 15:35:58'),
(122, 4, 'cargos', '2026-03-20 15:35:58'),
(123, 4, 'empleados', '2026-03-20 15:35:58'),
(124, 4, 'movimiento-caja', '2026-03-20 15:35:58');

-- --------------------------------------------------------

--
-- Table structure for table `vehiculos`
--

CREATE TABLE `vehiculos` (
  `vehic_id` int(11) NOT NULL,
  `vehic_cenco_id` int(11) DEFAULT NULL,
  `vehic_placa` varchar(10) NOT NULL,
  `vehic_marca` varchar(50) NOT NULL,
  `vehic_modelo` varchar(50) NOT NULL,
  `vehic_anio` varchar(10) NOT NULL,
  `vehic_clase` varchar(50) NOT NULL,
  `vehic_tipo` varchar(50) NOT NULL,
  `vehic_numero_vin` varchar(50) NOT NULL,
  `vehic_numero_motor` varchar(50) NOT NULL,
  `vehic_jefe_operacion` varchar(50) NOT NULL,
  `vehic_estado` varchar(50) NOT NULL,
  `vehic_propietario` varchar(100) NOT NULL,
  `vehic_fecha_create` timestamp NOT NULL DEFAULT current_timestamp(),
  `vehic_fecha_update` datetime DEFAULT NULL,
  `vehic_fecha_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`are_id`);

--
-- Indexes for table `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `centro_costo`
--
ALTER TABLE `centro_costo`
  ADD PRIMARY KEY (`cenco_id`);

--
-- Indexes for table `config_series`
--
ALTER TABLE `config_series`
  ADD PRIMARY KEY (`conf_seri_id`);

--
-- Indexes for table `detalle_movimiento`
--
ALTER TABLE `detalle_movimiento`
  ADD PRIMARY KEY (`deta_movi_id`),
  ADD KEY `deta_movi_movimiento_id` (`deta_movi_movimiento_id`);

--
-- Indexes for table `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`emple_id`),
  ADD UNIQUE KEY `emple_codigo` (`emple_codigo`),
  ADD KEY `emple_empresa_id` (`emple_empresa_id`),
  ADD KEY `emple_cenco_id` (`emple_cenco_id`),
  ADD KEY `emple_area_id` (`emple_area_id`),
  ADD KEY `emple_cargo_id` (`emple_cargo_id`);

--
-- Indexes for table `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`empre_id`);

--
-- Indexes for table `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`movi_id`),
  ADD UNIQUE KEY `uq_movimientos_serie_numero` (`movi_tipo`,`movi_moneda`,`movi_serie`,`movi_numero`),
  ADD KEY `movi_emple_id` (`movi_emple_id`);

--
-- Indexes for table `opts`
--
ALTER TABLE `opts`
  ADD PRIMARY KEY (`opt_id`),
  ADD KEY `opt_vehiculo_id` (`opt_vehiculo_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usu_id`);

--
-- Indexes for table `usuarios_modulos`
--
ALTER TABLE `usuarios_modulos`
  ADD PRIMARY KEY (`umod_id`),
  ADD UNIQUE KEY `uk_usuario_modulo` (`usu_id`,`modulo`),
  ADD KEY `idx_usuarios_modulos_usuario` (`usu_id`);

--
-- Indexes for table `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`vehic_id`),
  ADD UNIQUE KEY `vehic_placa` (`vehic_placa`),
  ADD UNIQUE KEY `vehic_numero_vin` (`vehic_numero_vin`),
  ADD UNIQUE KEY `vehic_numero_motor` (`vehic_numero_motor`),
  ADD KEY `vehic_cenco_id` (`vehic_cenco_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `are_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cargos`
--
ALTER TABLE `cargos`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `centro_costo`
--
ALTER TABLE `centro_costo`
  MODIFY `cenco_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `config_series`
--
ALTER TABLE `config_series`
  MODIFY `conf_seri_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `detalle_movimiento`
--
ALTER TABLE `detalle_movimiento`
  MODIFY `deta_movi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `empleados`
--
ALTER TABLE `empleados`
  MODIFY `emple_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `empresas`
--
ALTER TABLE `empresas`
  MODIFY `empre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `movi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `opts`
--
ALTER TABLE `opts`
  MODIFY `opt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `usuarios_modulos`
--
ALTER TABLE `usuarios_modulos`
  MODIFY `umod_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `vehic_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detalle_movimiento`
--
ALTER TABLE `detalle_movimiento`
  ADD CONSTRAINT `detalle_movimiento_ibfk_1` FOREIGN KEY (`deta_movi_movimiento_id`) REFERENCES `movimientos` (`movi_id`) ON DELETE CASCADE;

--
-- Constraints for table `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`emple_empresa_id`) REFERENCES `empresas` (`empre_id`),
  ADD CONSTRAINT `empleados_ibfk_2` FOREIGN KEY (`emple_cenco_id`) REFERENCES `centro_costo` (`cenco_id`),
  ADD CONSTRAINT `empleados_ibfk_3` FOREIGN KEY (`emple_area_id`) REFERENCES `areas` (`are_id`),
  ADD CONSTRAINT `empleados_ibfk_4` FOREIGN KEY (`emple_cargo_id`) REFERENCES `cargos` (`car_id`);

--
-- Constraints for table `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_ibfk_1` FOREIGN KEY (`movi_emple_id`) REFERENCES `empleados` (`emple_id`);

--
-- Constraints for table `opts`
--
ALTER TABLE `opts`
  ADD CONSTRAINT `opts_ibfk_1` FOREIGN KEY (`opt_vehiculo_id`) REFERENCES `vehiculos` (`vehic_id`) ON DELETE CASCADE;

--
-- Constraints for table `usuarios_modulos`
--
ALTER TABLE `usuarios_modulos`
  ADD CONSTRAINT `fk_usuarios_modulos_usuario` FOREIGN KEY (`usu_id`) REFERENCES `usuarios` (`usu_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `vehiculos_ibfk_1` FOREIGN KEY (`vehic_cenco_id`) REFERENCES `centro_costo` (`cenco_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
