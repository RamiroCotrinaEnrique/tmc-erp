-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 01, 2026 at 07:26 PM
-- Server version: 11.8.6-MariaDB-log
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
(7, 'MANTENIMIENTO', '2026-03-20 16:23:59', NULL, NULL),
(8, 'N/A', '2026-03-31 19:29:43', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auditoria_general`
--

CREATE TABLE `auditoria_general` (
  `aud_id` bigint(20) UNSIGNED NOT NULL,
  `aud_modulo` varchar(80) NOT NULL,
  `aud_entidad_tabla` varchar(80) NOT NULL,
  `aud_entidad_id` varchar(80) NOT NULL,
  `aud_accion` varchar(20) NOT NULL,
  `aud_usuario_id` int(11) DEFAULT NULL,
  `aud_ip_origen` varchar(45) DEFAULT NULL,
  `aud_detalle_json` longtext DEFAULT NULL,
  `aud_fecha_evento` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `auditoria_general`
--

INSERT INTO `auditoria_general` (`aud_id`, `aud_modulo`, `aud_entidad_tabla`, `aud_entidad_id`, `aud_accion`, `aud_usuario_id`, `aud_ip_origen`, `aud_detalle_json`, `aud_fecha_evento`) VALUES
(1, 'movimiento-caja', 'movimientos', '1', 'CREAR', 6, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":1,\"movi_tipo\":\"INGRESO\",\"movi_serie\":\"002\",\"movi_numero\":1,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-02-19\",\"movi_emple_id\":20,\"movi_total\":\"19.40\",\"movi_fecha_create\":\"2026-03-27 17:34:39\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"LIQUIDACION GV.9262 OP.YAURICOCHA PLACA ATL908 RELACIONADO AL REC 002-17715-17741\",\"deta_movi_importe\":\"19.40\"}]},\"campos_cambiados\":[]}', '2026-03-27 17:34:39'),
(2, 'hoja-liquidacion', 'hoja_liquidacion', '1', 'CREAR', 6, '190.116.23.99', '{\"antes\":null,\"despues\":{\"hoja_id\":1,\"0\":1,\"hoja_numero_registro\":\"GV-000001\",\"1\":\"GV-000001\",\"hoja_fecha_salida\":\"2026-02-21\",\"2\":\"2026-02-21\",\"hoja_fecha_llegada\":\"2026-02-24\",\"3\":\"2026-02-24\",\"hoja_vehic_tracto_id\":1,\"4\":1,\"hoja_vehic_tolva_id\":2,\"5\":2,\"hoja_operacion\":3,\"6\":3,\"hoja_monto_recibido\":\"400.00\",\"7\":\"400.00\",\"hoja_empleado_id\":1,\"8\":1,\"hoja_grr_producto\":\"\",\"9\":\"\",\"hoja_producto\":\"\",\"10\":\"\",\"hoja_grr_servicio_adicional\":\"\",\"11\":\"\",\"hoja_servicio_adicional\":\"\",\"12\":\"\",\"hoja_gr_transportista\":\"\",\"13\":\"\",\"hoja_peaje\":\"209.60\",\"14\":\"209.60\",\"hoja_boletas_varias\":\"197.00\",\"15\":\"197.00\",\"hoja_boletas_consumo\":\"160.00\",\"16\":\"160.00\",\"hoja_planilla_movilidad\":\"0.00\",\"17\":\"0.00\",\"hoja_facturas_varios\":\"0.00\",\"18\":\"0.00\",\"hoja_carga_descarga_ladrillo\":\"0.00\",\"19\":\"0.00\",\"hoja_reintegro\":\"166.60\",\"20\":\"166.60\",\"hoja_vuelto\":\"0.00\",\"21\":\"0.00\",\"hoja_suma_total\":\"566.60\",\"22\":\"566.60\",\"hoja_observaciones\":\"\",\"23\":\"\",\"hoja_km_salida\":\"0.00\",\"24\":\"0.00\",\"hoja_km_llegada\":\"0.00\",\"25\":\"0.00\",\"hoja_cv_grifo\":\"0.00\",\"26\":\"0.00\",\"hoja_cv_eq\":\"0.00\",\"27\":\"0.00\",\"hoja_total_km\":\"0.00\",\"28\":\"0.00\",\"hoja_variacion\":\"0.00\",\"29\":\"0.00\",\"hoja_fecha_create\":\"2026-03-27 17:48:18\",\"30\":\"2026-03-27 17:48:18\",\"hoja_fecha_update\":null,\"31\":null,\"hoja_fecha_delete\":null,\"32\":null},\"campos_cambiados\":[]}', '2026-03-27 17:48:18'),
(3, 'movimiento-caja', 'movimientos', '2', 'CREAR', 6, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":2,\"movi_tipo\":\"INGRESO\",\"movi_serie\":\"001\",\"movi_numero\":1,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-23\",\"movi_emple_id\":15,\"movi_total\":\"1200.06\",\"movi_fecha_create\":\"2026-03-27 22:36:14\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"INGRESO MEDIANTE TRANSFERENCIA 23/03\",\"deta_movi_importe\":\"1200.06\"}]},\"campos_cambiados\":[]}', '2026-03-27 22:36:14'),
(4, 'movimiento-caja', 'movimientos', '3', 'CREAR', 6, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":3,\"movi_tipo\":\"INGRESO\",\"movi_serie\":\"001\",\"movi_numero\":2,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-23\",\"movi_emple_id\":15,\"movi_total\":\"1600.05\",\"movi_fecha_create\":\"2026-03-27 22:37:24\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"INGRESO MEDIANTE TRANSFERENCIA 24/03\",\"deta_movi_importe\":\"1600.05\"}]},\"campos_cambiados\":[]}', '2026-03-27 22:37:24'),
(5, 'movimiento-caja', 'movimientos', '4', 'CREAR', 6, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":4,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"001\",\"movi_numero\":1,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-23\",\"movi_emple_id\":15,\"movi_total\":\"2.00\",\"movi_fecha_create\":\"2026-03-27 22:39:10\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"COMISION POR RETIRO AGENTE\",\"deta_movi_importe\":\"2.00\"}]},\"campos_cambiados\":[]}', '2026-03-27 22:39:10'),
(6, 'movimiento-caja', 'movimientos', '5', 'CREAR', 6, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":5,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":1,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-23\",\"movi_emple_id\":17,\"movi_total\":\"374.85\",\"movi_fecha_create\":\"2026-03-27 22:50:59\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"GASTO ADICIONAL AL REC 002-17970\",\"deta_movi_importe\":\"374.85\"}]},\"campos_cambiados\":[]}', '2026-03-27 22:50:59'),
(7, 'movimiento-caja', 'movimientos', '6', 'CREAR', 6, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":6,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":2,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-23\",\"movi_emple_id\":2,\"movi_total\":\"374.85\",\"movi_fecha_create\":\"2026-03-27 22:52:39\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"GASTO ADICIONAL AL REC 002-17970\",\"deta_movi_importe\":\"374.85\"}]},\"campos_cambiados\":[]}', '2026-03-27 22:52:39'),
(8, 'hoja-liquidacion', 'hoja_liquidacion', '1', 'EDITAR', 1, '2800:200:ee28:97f:4bf9:7e98:18cb:4cc3', '{\"antes\":{\"hoja_id\":1,\"hoja_numero_registro\":\"GV-000001\",\"hoja_fecha_salida\":\"2026-02-21\",\"hoja_fecha_llegada\":\"2026-02-24\",\"hoja_vehic_tracto_id\":1,\"hoja_vehic_tolva_id\":2,\"hoja_operacion\":3,\"hoja_monto_recibido\":\"400.00\",\"hoja_empleado_id\":1,\"hoja_grr_producto\":\"\",\"hoja_producto\":\"\",\"hoja_grr_servicio_adicional\":\"\",\"hoja_servicio_adicional\":\"\",\"hoja_gr_transportista\":\"\",\"hoja_peaje\":\"209.60\",\"hoja_boletas_varias\":\"197.00\",\"hoja_boletas_consumo\":\"160.00\",\"hoja_planilla_movilidad\":\"0.00\",\"hoja_facturas_varios\":\"0.00\",\"hoja_carga_descarga_ladrillo\":\"0.00\",\"hoja_reintegro\":\"166.60\",\"hoja_vuelto\":\"0.00\",\"hoja_suma_total\":\"566.60\",\"hoja_observaciones\":\"\",\"hoja_km_salida\":\"0.00\",\"hoja_km_llegada\":\"0.00\",\"hoja_cv_grifo\":\"0.00\",\"hoja_cv_eq\":\"0.00\",\"hoja_total_km\":\"0.00\",\"hoja_variacion\":\"0.00\",\"hoja_fecha_create\":\"2026-03-27 17:48:18\",\"hoja_fecha_update\":null,\"hoja_fecha_delete\":null},\"despues\":{\"hoja_id\":1,\"hoja_numero_registro\":\"GV-000001\",\"hoja_fecha_salida\":\"2026-02-21\",\"hoja_fecha_llegada\":\"2026-02-24\",\"hoja_vehic_tracto_id\":1,\"hoja_vehic_tolva_id\":2,\"hoja_operacion\":3,\"hoja_monto_recibido\":\"400.00\",\"hoja_empleado_id\":1,\"hoja_grr_producto\":\"\",\"hoja_producto\":\"\",\"hoja_grr_servicio_adicional\":\"\",\"hoja_servicio_adicional\":\"\",\"hoja_gr_transportista\":\"\",\"hoja_peaje\":\"209.60\",\"hoja_boletas_varias\":\"197.00\",\"hoja_boletas_consumo\":\"160.00\",\"hoja_planilla_movilidad\":\"100.00\",\"hoja_facturas_varios\":\"0.00\",\"hoja_carga_descarga_ladrillo\":\"0.00\",\"hoja_reintegro\":\"266.60\",\"hoja_vuelto\":\"0.00\",\"hoja_suma_total\":\"666.60\",\"hoja_observaciones\":\"\",\"hoja_km_salida\":\"0.00\",\"hoja_km_llegada\":\"0.00\",\"hoja_cv_grifo\":\"0.00\",\"hoja_cv_eq\":\"0.00\",\"hoja_total_km\":\"0.00\",\"hoja_variacion\":\"0.00\",\"hoja_fecha_create\":\"2026-03-27 17:48:18\",\"hoja_fecha_update\":\"2026-03-28 10:49:43\",\"hoja_fecha_delete\":null},\"campos_cambiados\":{\"hoja_planilla_movilidad\":{\"antes\":\"0.00\",\"despues\":\"100.00\"},\"hoja_reintegro\":{\"antes\":\"166.60\",\"despues\":\"266.60\"},\"hoja_suma_total\":{\"antes\":\"566.60\",\"despues\":\"666.60\"},\"hoja_fecha_update\":{\"antes\":null,\"despues\":\"2026-03-28 10:49:43\"}}}', '2026-03-28 15:49:43'),
(9, 'hoja-liquidacion', 'hoja_liquidacion', '1', 'EDITAR', 1, '2800:200:ee28:97f:4bf9:7e98:18cb:4cc3', '{\"antes\":{\"hoja_id\":1,\"hoja_numero_registro\":\"GV-000001\",\"hoja_fecha_salida\":\"2026-02-21\",\"hoja_fecha_llegada\":\"2026-02-24\",\"hoja_vehic_tracto_id\":1,\"hoja_vehic_tolva_id\":2,\"hoja_operacion\":3,\"hoja_monto_recibido\":\"400.00\",\"hoja_empleado_id\":1,\"hoja_grr_producto\":\"\",\"hoja_producto\":\"\",\"hoja_grr_servicio_adicional\":\"\",\"hoja_servicio_adicional\":\"\",\"hoja_gr_transportista\":\"\",\"hoja_peaje\":\"209.60\",\"hoja_boletas_varias\":\"197.00\",\"hoja_boletas_consumo\":\"160.00\",\"hoja_planilla_movilidad\":\"100.00\",\"hoja_facturas_varios\":\"0.00\",\"hoja_carga_descarga_ladrillo\":\"0.00\",\"hoja_reintegro\":\"266.60\",\"hoja_vuelto\":\"0.00\",\"hoja_suma_total\":\"666.60\",\"hoja_observaciones\":\"\",\"hoja_km_salida\":\"0.00\",\"hoja_km_llegada\":\"0.00\",\"hoja_cv_grifo\":\"0.00\",\"hoja_cv_eq\":\"0.00\",\"hoja_total_km\":\"0.00\",\"hoja_variacion\":\"0.00\",\"hoja_fecha_create\":\"2026-03-27 17:48:18\",\"hoja_fecha_update\":\"2026-03-28 10:49:43\",\"hoja_fecha_delete\":null},\"despues\":{\"hoja_id\":1,\"hoja_numero_registro\":\"GV-000001\",\"hoja_fecha_salida\":\"2026-02-21\",\"hoja_fecha_llegada\":\"2026-02-24\",\"hoja_vehic_tracto_id\":1,\"hoja_vehic_tolva_id\":2,\"hoja_operacion\":3,\"hoja_monto_recibido\":\"400.00\",\"hoja_empleado_id\":1,\"hoja_grr_producto\":\"\",\"hoja_producto\":\"\",\"hoja_grr_servicio_adicional\":\"\",\"hoja_servicio_adicional\":\"\",\"hoja_gr_transportista\":\"\",\"hoja_peaje\":\"209.60\",\"hoja_boletas_varias\":\"197.00\",\"hoja_boletas_consumo\":\"160.00\",\"hoja_planilla_movilidad\":\"0.00\",\"hoja_facturas_varios\":\"0.00\",\"hoja_carga_descarga_ladrillo\":\"0.00\",\"hoja_reintegro\":\"166.60\",\"hoja_vuelto\":\"0.00\",\"hoja_suma_total\":\"566.60\",\"hoja_observaciones\":\"\",\"hoja_km_salida\":\"0.00\",\"hoja_km_llegada\":\"0.00\",\"hoja_cv_grifo\":\"0.00\",\"hoja_cv_eq\":\"0.00\",\"hoja_total_km\":\"0.00\",\"hoja_variacion\":\"0.00\",\"hoja_fecha_create\":\"2026-03-27 17:48:18\",\"hoja_fecha_update\":\"2026-03-28 10:50:27\",\"hoja_fecha_delete\":null},\"campos_cambiados\":{\"hoja_planilla_movilidad\":{\"antes\":\"100.00\",\"despues\":\"0.00\"},\"hoja_reintegro\":{\"antes\":\"266.60\",\"despues\":\"166.60\"},\"hoja_suma_total\":{\"antes\":\"666.60\",\"despues\":\"566.60\"},\"hoja_fecha_update\":{\"antes\":\"2026-03-28 10:49:43\",\"despues\":\"2026-03-28 10:50:27\"}}}', '2026-03-28 15:50:27'),
(10, 'movimiento-caja', 'movimientos', '1', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":1,\"movi_tipo\":\"INGRESO\",\"movi_serie\":\"001\",\"movi_numero\":2327,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-02\",\"movi_emple_id\":15,\"movi_total\":\"850.04\",\"movi_fecha_create\":\"2026-03-30 15:51:29\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"INGRESO MEDIANTE TRANSFERENCIA\",\"deta_movi_importe\":\"850.04\"}]},\"campos_cambiados\":[]}', '2026-03-30 15:51:29'),
(11, 'movimiento-caja', 'movimientos', '2', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":2,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"001\",\"movi_numero\":1,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-02\",\"movi_emple_id\":15,\"movi_total\":\"12.00\",\"movi_fecha_create\":\"2026-03-30 15:54:04\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"MANTENIMIENTO DE CUENTA\",\"deta_movi_importe\":\"12.00\"}]},\"campos_cambiados\":[]}', '2026-03-30 15:54:04'),
(12, 'movimiento-caja', 'movimientos', '3', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":3,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17877,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-02\",\"movi_emple_id\":12,\"movi_total\":\"137.80\",\"movi_fecha_create\":\"2026-03-30 15:58:28\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"LIQUIDACION GV.9289  OP.ALPAYANA PLACA ATN-750 RELACIONADO AL REC 002- 17825-17835-17839\",\"deta_movi_importe\":\"137.80\"}]},\"campos_cambiados\":[]}', '2026-03-30 15:58:28'),
(13, 'movimiento-caja', 'movimientos', '4', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":4,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17878,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-02\",\"movi_emple_id\":12,\"movi_total\":\"450.00\",\"movi_fecha_create\":\"2026-03-30 15:59:16\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"GASTO DE VIAJE ICA ATN 750\",\"deta_movi_importe\":\"450.00\"}]},\"campos_cambiados\":[]}', '2026-03-30 15:59:16'),
(14, 'movimiento-caja', 'movimientos', '5', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":5,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17879,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-02\",\"movi_emple_id\":22,\"movi_total\":\"300.00\",\"movi_fecha_create\":\"2026-03-30 16:00:48\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"GASTO DE VIAJE HUARAL AWX 892\",\"deta_movi_importe\":\"300.00\"}]},\"campos_cambiados\":[]}', '2026-03-30 16:00:48'),
(15, 'movimiento-caja', 'movimientos', '6', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":6,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17880,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-02\",\"movi_emple_id\":2,\"movi_total\":\"100.00\",\"movi_fecha_create\":\"2026-03-30 16:01:45\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"GASTO ADICIONAL CORRESPONDIENTE AL REC 17869\",\"deta_movi_importe\":\"100.00\"}]},\"campos_cambiados\":[]}', '2026-03-30 16:01:45'),
(16, 'empleados', 'empleados', '0', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"emple_codigo\":\"EMP0027\",\"emple_tipo_documento\":\"DNI\",\"emple_numero_documento\":\"99999999\",\"emple_apellido_paterno\":\"PARI\",\"emple_apellido_materno\":\"VARGAS\",\"emple_nombres\":\"LUIS\",\"emple_fecha_nacimiento\":\"2026-03-30\",\"emple_nacionalidad\":\"PERUANO\",\"emple_sexo\":\"Masculino\",\"emple_estado_civil\":\"Otro\",\"emple_telefono_movil\":null,\"emple_telefono_fijo\":null,\"emple_correo\":\"\",\"emple_departamento\":\"\",\"emple_provincia\":\"\",\"emple_distrito\":\"\",\"emple_lugar_residencia\":\"\",\"emple_empresa_id\":\"1\",\"emple_fecha_ingreso\":\"2026-03-30\",\"emple_categoria_ocupacional\":\"\",\"emple_cenco_id\":\"5\",\"emple_area_id\":\"5\",\"emple_cargo_id\":\"3\",\"emple_estado\":\"\",\"emple_fecha_cese\":null,\"emple_situacion_educativa\":\"\",\"emple_estado_educativa\":\"\",\"emple_tipo_regimen\":\"\",\"emple_tipo_institucion\":\"\",\"emple_institucion\":\"\",\"emple_carrera\":\"\",\"emple_anio\":\"\",\"emple_nombre_familiar\":\"\",\"emple_telefono_familiar\":null,\"emple_parentesco\":\"\",\"emple_fecha_vencimiento_documento\":null,\"emple_licencia\":\"NO\",\"emple_id_usuario\":1,\"emple_archivo_documento\":null,\"emple_fecha_vencimiento_a1\":null,\"emple_archivo_a1\":null,\"emple_fecha_vencimiento_a2a\":null,\"emple_archivo_a2a\":null,\"emple_fecha_vencimiento_a2b\":null,\"emple_archivo_a2b\":null,\"emple_fecha_vencimiento_a3a\":null,\"emple_archivo_a3a\":null,\"emple_fecha_vencimiento_a3b\":null,\"emple_archivo_a3b\":null,\"emple_fecha_vencimiento_a3c\":null,\"emple_archivo_a3c\":null,\"emple_fecha_vencimiento_b1\":null,\"emple_archivo_b1\":null,\"emple_fecha_vencimiento_b2a\":null,\"emple_archivo_b2a\":null,\"emple_fecha_vencimiento_b2b\":null,\"emple_archivo_b2b\":null,\"emple_fecha_vencimiento_b2c\":null,\"emple_archivo_b2c\":null},\"campos_cambiados\":[]}', '2026-03-30 16:40:58'),
(17, 'movimiento-caja', 'movimientos', '7', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":7,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"004\",\"movi_numero\":2019,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-02\",\"movi_emple_id\":28,\"movi_total\":\"90.00\",\"movi_fecha_create\":\"2026-03-30 16:42:06\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"SERVICIO DE VIGILANCIA NOCTURNA BASE MINERIA  01/03\",\"deta_movi_importe\":\"90.00\"}]},\"campos_cambiados\":[]}', '2026-03-30 16:42:06'),
(18, 'movimiento-caja', 'movimientos', '8', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":8,\"movi_tipo\":\"INGRESO\",\"movi_serie\":\"001\",\"movi_numero\":2328,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-03\",\"movi_emple_id\":15,\"movi_total\":\"1500.08\",\"movi_fecha_create\":\"2026-03-30 16:47:06\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"INGRESO MEDIANTE TRANSFERENCIA\",\"deta_movi_importe\":\"1500.08\"}]},\"campos_cambiados\":[]}', '2026-03-30 16:47:06'),
(19, 'movimiento-caja', 'movimientos', '9', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":9,\"movi_tipo\":\"INGRESO\",\"movi_serie\":\"002\",\"movi_numero\":4304,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-03\",\"movi_emple_id\":1,\"movi_total\":\"1.20\",\"movi_fecha_create\":\"2026-03-30 21:50:00\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"LIQUIDACION GV.9302OP.ALPAYANA  PLACA ATN851  RELACIONADO AL REC 002- 17871\",\"deta_movi_importe\":\"1.20\"}]},\"campos_cambiados\":[]}', '2026-03-30 21:50:00'),
(20, 'movimiento-caja', 'movimientos', '10', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":10,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17881,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-03\",\"movi_emple_id\":1,\"movi_total\":\"3.80\",\"movi_fecha_create\":\"2026-03-30 21:54:15\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"LIQUIDACION GV.9301OP.ALPAYANA  PLACA ATN851  RELACIONADO AL REC 002- 17855\",\"deta_movi_importe\":\"3.80\"}]},\"campos_cambiados\":[]}', '2026-03-30 21:54:15'),
(21, 'movimiento-caja', 'movimientos', '11', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":11,\"movi_tipo\":\"INGRESO\",\"movi_serie\":\"002\",\"movi_numero\":4305,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-02\",\"movi_emple_id\":12,\"movi_total\":\"210.00\",\"movi_fecha_create\":\"2026-03-30 21:56:03\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"DESCARGA DE LADRILLOS 6 MILLARES\",\"deta_movi_importe\":\"210.00\"}]},\"campos_cambiados\":[]}', '2026-03-30 21:56:03'),
(22, 'movimiento-caja', 'movimientos', '11', 'ELIMINAR', 1, '190.116.23.99', '{\"antes\":{\"movimiento\":{\"movi_id\":11,\"movi_tipo\":\"INGRESO\",\"movi_serie\":\"002\",\"movi_numero\":4305,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-02\",\"movi_emple_id\":12,\"movi_total\":\"210.00\",\"movi_fecha_create\":\"2026-03-30 21:56:03\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"DESCARGA DE LADRILLOS 6 MILLARES\",\"deta_movi_importe\":\"210.00\"}]},\"despues\":{\"movimiento\":{\"movi_id\":11,\"movi_tipo\":\"INGRESO\",\"movi_serie\":\"002\",\"movi_numero\":4305,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-02\",\"movi_emple_id\":12,\"movi_total\":\"210.00\",\"movi_fecha_create\":\"2026-03-30 21:56:03\",\"movi_fecha_update\":null,\"movi_fecha_delete\":\"2026-03-30 21:56:49\"}},\"campos_cambiados\":{\"movi_fecha_delete\":{\"antes\":null,\"despues\":\"2026-03-30 21:56:49\"},\"detalle\":{\"antes\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"DESCARGA DE LADRILLOS 6 MILLARES\",\"deta_movi_importe\":\"210.00\"}],\"despues\":[]}}}', '2026-03-30 21:56:49'),
(23, 'movimiento-caja', 'movimientos', '11', 'DEPURAR', 1, '190.116.23.99', '{\"antes\":{\"movimiento\":{\"movi_id\":11,\"movi_tipo\":\"INGRESO\",\"movi_serie\":\"002\",\"movi_numero\":4305,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-02\",\"movi_emple_id\":12,\"movi_total\":\"210.00\",\"movi_fecha_create\":\"2026-03-30 21:56:03\",\"movi_fecha_update\":null,\"movi_fecha_delete\":\"2026-03-30 21:56:49\"},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"DESCARGA DE LADRILLOS 6 MILLARES\",\"deta_movi_importe\":\"210.00\"}]},\"despues\":null,\"campos_cambiados\":[]}', '2026-03-30 21:56:58'),
(24, 'movimiento-caja', 'movimientos', '12', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":12,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17882,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-03\",\"movi_emple_id\":12,\"movi_total\":\"210.00\",\"movi_fecha_create\":\"2026-03-30 22:12:46\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"DESCARGA DE LADRILLOS 6 MILLARES\",\"deta_movi_importe\":\"210.00\"}]},\"campos_cambiados\":[]}', '2026-03-30 22:12:46'),
(25, 'movimiento-caja', 'movimientos', '13', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":13,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17883,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-03\",\"movi_emple_id\":1,\"movi_total\":\"320.00\",\"movi_fecha_create\":\"2026-03-30 22:15:55\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"GASTO DE VIAJE ALPAYANA ATN-851  03/03\",\"deta_movi_importe\":\"320.00\"}]},\"campos_cambiados\":[]}', '2026-03-30 22:15:55'),
(26, 'movimiento-caja', 'movimientos', '14', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":14,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17884,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-03\",\"movi_emple_id\":22,\"movi_total\":\"40.00\",\"movi_fecha_create\":\"2026-03-30 22:20:13\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"GASTO ADICIONAL HOSPEDAJE CORRESPONDIENTE AL REC 002-17869\",\"deta_movi_importe\":\"40.00\"}]},\"campos_cambiados\":[]}', '2026-03-30 22:20:13'),
(27, 'movimiento-caja', 'movimientos', '15', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":15,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17885,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-03\",\"movi_emple_id\":2,\"movi_total\":\"450.00\",\"movi_fecha_create\":\"2026-03-30 22:21:17\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"GASTO DE VIAJE ICA  F9D-990\",\"deta_movi_importe\":\"450.00\"}]},\"campos_cambiados\":[]}', '2026-03-30 22:21:17'),
(28, 'movimiento-caja', 'movimientos', '16', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":16,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17886,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-03\",\"movi_emple_id\":21,\"movi_total\":\"10.00\",\"movi_fecha_create\":\"2026-03-30 22:22:57\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"VIATICO EN BASE 27/02\",\"deta_movi_importe\":\"10.00\"}]},\"campos_cambiados\":[]}', '2026-03-30 22:22:57'),
(29, 'empleados', 'empleados', '0', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"emple_codigo\":\"EMP0028\",\"emple_tipo_documento\":\"DNI\",\"emple_numero_documento\":\"99999999\",\"emple_apellido_paterno\":\"YALLI\",\"emple_apellido_materno\":\"LOPEZ\",\"emple_nombres\":\"JHONATAN\",\"emple_fecha_nacimiento\":\"2026-03-31\",\"emple_nacionalidad\":\"PERUANO\",\"emple_sexo\":\"Masculino\",\"emple_estado_civil\":\"Otro\",\"emple_telefono_movil\":null,\"emple_telefono_fijo\":null,\"emple_correo\":\"\",\"emple_departamento\":\"\",\"emple_provincia\":\"\",\"emple_distrito\":\"\",\"emple_lugar_residencia\":\"\",\"emple_empresa_id\":\"1\",\"emple_fecha_ingreso\":\"2026-03-31\",\"emple_categoria_ocupacional\":\"\",\"emple_cenco_id\":\"5\",\"emple_area_id\":\"7\",\"emple_cargo_id\":\"3\",\"emple_estado\":\"\",\"emple_fecha_cese\":null,\"emple_situacion_educativa\":\"\",\"emple_estado_educativa\":\"\",\"emple_tipo_regimen\":\"\",\"emple_tipo_institucion\":\"\",\"emple_institucion\":\"\",\"emple_carrera\":\"\",\"emple_anio\":\"\",\"emple_nombre_familiar\":\"\",\"emple_telefono_familiar\":null,\"emple_parentesco\":\"\",\"emple_fecha_vencimiento_documento\":null,\"emple_licencia\":\"NO\",\"emple_id_usuario\":1,\"emple_archivo_documento\":null,\"emple_fecha_vencimiento_a1\":null,\"emple_archivo_a1\":null,\"emple_fecha_vencimiento_a2a\":null,\"emple_archivo_a2a\":null,\"emple_fecha_vencimiento_a2b\":null,\"emple_archivo_a2b\":null,\"emple_fecha_vencimiento_a3a\":null,\"emple_archivo_a3a\":null,\"emple_fecha_vencimiento_a3b\":null,\"emple_archivo_a3b\":null,\"emple_fecha_vencimiento_a3c\":null,\"emple_archivo_a3c\":null,\"emple_fecha_vencimiento_b1\":null,\"emple_archivo_b1\":null,\"emple_fecha_vencimiento_b2a\":null,\"emple_archivo_b2a\":null,\"emple_fecha_vencimiento_b2b\":null,\"emple_archivo_b2b\":null,\"emple_fecha_vencimiento_b2c\":null,\"emple_archivo_b2c\":null},\"campos_cambiados\":[]}', '2026-03-31 19:22:27'),
(30, 'movimiento-caja', 'movimientos', '17', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":17,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17887,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-03\",\"movi_emple_id\":29,\"movi_total\":\"10.00\",\"movi_fecha_create\":\"2026-03-31 19:23:30\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"VIATICO EN BASE 27/02\",\"deta_movi_importe\":\"10.00\"}]},\"campos_cambiados\":[]}', '2026-03-31 19:23:30'),
(31, 'movimiento-caja', 'movimientos', '18', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":18,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17888,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-03\",\"movi_emple_id\":17,\"movi_total\":\"50.00\",\"movi_fecha_create\":\"2026-03-31 19:24:16\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"GASTO ADICIONAL CORRESPONDIENTE Al REC 002- 17867\",\"deta_movi_importe\":\"50.00\"}]},\"campos_cambiados\":[]}', '2026-03-31 19:24:16'),
(32, 'movimiento-caja', 'movimientos', '19', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":19,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"003\",\"movi_numero\":1062,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-03\",\"movi_emple_id\":6,\"movi_total\":\"159.00\",\"movi_fecha_create\":\"2026-03-31 19:26:50\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"A RENDIR FACTURA\",\"deta_movi_importe\":\"159.00\"}]},\"campos_cambiados\":[]}', '2026-03-31 19:26:50'),
(33, 'empleados', 'empleados', '0', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"emple_codigo\":\"EMP0029\",\"emple_tipo_documento\":\"DNI\",\"emple_numero_documento\":\"99999999\",\"emple_apellido_paterno\":\"ALTAMIRANO\",\"emple_apellido_materno\":\"TOVAR\",\"emple_nombres\":\"VICTOR\",\"emple_fecha_nacimiento\":\"2026-03-31\",\"emple_nacionalidad\":\"PERUANO\",\"emple_sexo\":\"Masculino\",\"emple_estado_civil\":\"Otro\",\"emple_telefono_movil\":null,\"emple_telefono_fijo\":null,\"emple_correo\":\"\",\"emple_departamento\":\"\",\"emple_provincia\":\"\",\"emple_distrito\":\"\",\"emple_lugar_residencia\":\"\",\"emple_empresa_id\":\"1\",\"emple_fecha_ingreso\":\"2026-03-31\",\"emple_categoria_ocupacional\":\"\",\"emple_cenco_id\":\"5\",\"emple_area_id\":\"7\",\"emple_cargo_id\":\"3\",\"emple_estado\":\"\",\"emple_fecha_cese\":null,\"emple_situacion_educativa\":\"\",\"emple_estado_educativa\":\"\",\"emple_tipo_regimen\":\"\",\"emple_tipo_institucion\":\"\",\"emple_institucion\":\"\",\"emple_carrera\":\"\",\"emple_anio\":\"\",\"emple_nombre_familiar\":\"\",\"emple_telefono_familiar\":null,\"emple_parentesco\":\"\",\"emple_fecha_vencimiento_documento\":null,\"emple_licencia\":\"NO\",\"emple_id_usuario\":1,\"emple_archivo_documento\":null,\"emple_fecha_vencimiento_a1\":null,\"emple_archivo_a1\":null,\"emple_fecha_vencimiento_a2a\":null,\"emple_archivo_a2a\":null,\"emple_fecha_vencimiento_a2b\":null,\"emple_archivo_a2b\":null,\"emple_fecha_vencimiento_a3a\":null,\"emple_archivo_a3a\":null,\"emple_fecha_vencimiento_a3b\":null,\"emple_archivo_a3b\":null,\"emple_fecha_vencimiento_a3c\":null,\"emple_archivo_a3c\":null,\"emple_fecha_vencimiento_b1\":null,\"emple_archivo_b1\":null,\"emple_fecha_vencimiento_b2a\":null,\"emple_archivo_b2a\":null,\"emple_fecha_vencimiento_b2b\":null,\"emple_archivo_b2b\":null,\"emple_fecha_vencimiento_b2c\":null,\"emple_archivo_b2c\":null},\"campos_cambiados\":[]}', '2026-03-31 19:29:22'),
(34, 'areas', 'areas', '0', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"are_nombre\":\"N/A\"},\"campos_cambiados\":[]}', '2026-03-31 19:29:43'),
(35, 'cargos', 'cargos', '0', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"car_nombre\":\"N/A\"},\"campos_cambiados\":[]}', '2026-03-31 19:29:52'),
(36, 'empleados', 'empleados', '30', 'EDITAR', 1, '190.116.23.99', '{\"antes\":{\"emple_id\":30,\"emple_codigo\":\"EMP0029\",\"emple_tipo_documento\":\"DNI\",\"emple_numero_documento\":\"99999999\",\"emple_apellido_paterno\":\"ALTAMIRANO\",\"emple_apellido_materno\":\"TOVAR\",\"emple_nombres\":\"VICTOR\",\"emple_fecha_nacimiento\":\"2026-03-31\",\"emple_nacionalidad\":\"PERUANO\",\"emple_sexo\":\"Masculino\",\"emple_estado_civil\":\"Otro\",\"emple_telefono_movil\":null,\"emple_telefono_fijo\":null,\"emple_correo\":null,\"emple_departamento\":null,\"emple_provincia\":null,\"emple_distrito\":null,\"emple_lugar_residencia\":null,\"emple_empresa_id\":1,\"emple_fecha_ingreso\":\"2026-03-31\",\"emple_categoria_ocupacional\":null,\"emple_cenco_id\":5,\"emple_area_id\":7,\"emple_cargo_id\":3,\"emple_estado\":null,\"emple_fecha_cese\":null,\"emple_situacion_educativa\":null,\"emple_estado_educativa\":null,\"emple_tipo_regimen\":null,\"emple_tipo_institucion\":null,\"emple_institucion\":null,\"emple_carrera\":null,\"emple_anio\":null,\"emple_nombre_familiar\":null,\"emple_telefono_familiar\":null,\"emple_parentesco\":null,\"emple_fecha_vencimiento_documento\":null,\"emple_archivo_documento\":null,\"emple_licencia\":\"NO\",\"emple_fecha_vencimiento_a1\":null,\"emple_archivo_a1\":null,\"emple_fecha_vencimiento_a2a\":null,\"emple_archivo_a2a\":null,\"emple_fecha_vencimiento_a2b\":null,\"emple_archivo_a2b\":null,\"emple_fecha_vencimiento_a3a\":null,\"emple_archivo_a3a\":null,\"emple_fecha_vencimiento_a3b\":null,\"emple_archivo_a3b\":null,\"emple_fecha_vencimiento_a3c\":null,\"emple_archivo_a3c\":null,\"emple_fecha_vencimiento_b1\":null,\"emple_archivo_b1\":null,\"emple_fecha_vencimiento_b2a\":null,\"emple_archivo_b2a\":null,\"emple_fecha_vencimiento_b2b\":null,\"emple_archivo_b2b\":null,\"emple_fecha_vencimiento_b2c\":null,\"emple_archivo_b2c\":null,\"emple_id_usuario\":1,\"emple_fecha_create\":\"2026-03-31 19:29:22\",\"emple_fecha_update\":null,\"emple_fecha_delete\":null,\"empre_ruc\":\"20160364719\",\"empre_razon_social\":\"EMPRESA DE TRANSPORTES MANUEL JESUS CAMPOS CALLUPE S.R.L.\",\"cenco_codigo\":\"05\",\"cenco_nombre\":\"N/A\",\"are_nombre\":\"MANTENIMIENTO\",\"car_nombre\":\"OPERATIVO\"},\"despues\":{\"emple_id\":\"30\",\"emple_apellido_paterno\":\"ALTAMIRANO\",\"emple_apellido_materno\":\"TOVAR\",\"emple_nombres\":\"VICTOR\",\"emple_fecha_nacimiento\":\"2026-03-31\",\"emple_nacionalidad\":\"PERUANO\",\"emple_sexo\":\"Masculino\",\"emple_estado_civil\":\"Otro\",\"emple_telefono_movil\":null,\"emple_telefono_fijo\":null,\"emple_correo\":\"\",\"emple_departamento\":\"\",\"emple_provincia\":\"\",\"emple_distrito\":\"\",\"emple_lugar_residencia\":\"\",\"emple_empresa_id\":\"1\",\"emple_fecha_ingreso\":\"2026-03-31\",\"emple_categoria_ocupacional\":\"\",\"emple_cenco_id\":\"5\",\"emple_area_id\":\"8\",\"emple_cargo_id\":\"4\",\"emple_estado\":\"\",\"emple_fecha_cese\":null,\"emple_situacion_educativa\":\"\",\"emple_estado_educativa\":\"\",\"emple_tipo_regimen\":\"\",\"emple_tipo_institucion\":\"\",\"emple_institucion\":\"\",\"emple_carrera\":\"\",\"emple_anio\":\"\",\"emple_nombre_familiar\":\"\",\"emple_telefono_familiar\":null,\"emple_parentesco\":\"\",\"emple_fecha_vencimiento_documento\":null,\"emple_licencia\":\"NO\",\"emple_archivo_documento\":null,\"emple_fecha_vencimiento_a1\":null,\"emple_archivo_a1\":null,\"emple_fecha_vencimiento_a2a\":null,\"emple_archivo_a2a\":null,\"emple_fecha_vencimiento_a2b\":null,\"emple_archivo_a2b\":null,\"emple_fecha_vencimiento_a3a\":null,\"emple_archivo_a3a\":null,\"emple_fecha_vencimiento_a3b\":null,\"emple_archivo_a3b\":null,\"emple_fecha_vencimiento_a3c\":null,\"emple_archivo_a3c\":null,\"emple_fecha_vencimiento_b1\":null,\"emple_archivo_b1\":null,\"emple_fecha_vencimiento_b2a\":null,\"emple_archivo_b2a\":null,\"emple_fecha_vencimiento_b2b\":null,\"emple_archivo_b2b\":null,\"emple_fecha_vencimiento_b2c\":null,\"emple_archivo_b2c\":null,\"emple_fecha_update\":\"2026-03-31 14:30:05\"},\"campos_cambiados\":{\"emple_cargo_id\":{\"antes\":3,\"despues\":\"4\"},\"emple_area_id\":{\"antes\":7,\"despues\":\"8\"}}}', '2026-03-31 19:30:05'),
(37, 'empleados', 'empleados', '29', 'EDITAR', 1, '190.116.23.99', '{\"antes\":{\"emple_id\":29,\"emple_codigo\":\"EMP0028\",\"emple_tipo_documento\":\"DNI\",\"emple_numero_documento\":\"99999999\",\"emple_apellido_paterno\":\"YALLI\",\"emple_apellido_materno\":\"LOPEZ\",\"emple_nombres\":\"JHONATAN\",\"emple_fecha_nacimiento\":\"2026-03-31\",\"emple_nacionalidad\":\"PERUANO\",\"emple_sexo\":\"Masculino\",\"emple_estado_civil\":\"Otro\",\"emple_telefono_movil\":null,\"emple_telefono_fijo\":null,\"emple_correo\":null,\"emple_departamento\":null,\"emple_provincia\":null,\"emple_distrito\":null,\"emple_lugar_residencia\":null,\"emple_empresa_id\":1,\"emple_fecha_ingreso\":\"2026-03-31\",\"emple_categoria_ocupacional\":null,\"emple_cenco_id\":5,\"emple_area_id\":7,\"emple_cargo_id\":3,\"emple_estado\":null,\"emple_fecha_cese\":null,\"emple_situacion_educativa\":null,\"emple_estado_educativa\":null,\"emple_tipo_regimen\":null,\"emple_tipo_institucion\":null,\"emple_institucion\":null,\"emple_carrera\":null,\"emple_anio\":null,\"emple_nombre_familiar\":null,\"emple_telefono_familiar\":null,\"emple_parentesco\":null,\"emple_fecha_vencimiento_documento\":null,\"emple_archivo_documento\":null,\"emple_licencia\":\"NO\",\"emple_fecha_vencimiento_a1\":null,\"emple_archivo_a1\":null,\"emple_fecha_vencimiento_a2a\":null,\"emple_archivo_a2a\":null,\"emple_fecha_vencimiento_a2b\":null,\"emple_archivo_a2b\":null,\"emple_fecha_vencimiento_a3a\":null,\"emple_archivo_a3a\":null,\"emple_fecha_vencimiento_a3b\":null,\"emple_archivo_a3b\":null,\"emple_fecha_vencimiento_a3c\":null,\"emple_archivo_a3c\":null,\"emple_fecha_vencimiento_b1\":null,\"emple_archivo_b1\":null,\"emple_fecha_vencimiento_b2a\":null,\"emple_archivo_b2a\":null,\"emple_fecha_vencimiento_b2b\":null,\"emple_archivo_b2b\":null,\"emple_fecha_vencimiento_b2c\":null,\"emple_archivo_b2c\":null,\"emple_id_usuario\":1,\"emple_fecha_create\":\"2026-03-31 19:22:27\",\"emple_fecha_update\":null,\"emple_fecha_delete\":null,\"empre_ruc\":\"20160364719\",\"empre_razon_social\":\"EMPRESA DE TRANSPORTES MANUEL JESUS CAMPOS CALLUPE S.R.L.\",\"cenco_codigo\":\"05\",\"cenco_nombre\":\"N/A\",\"are_nombre\":\"MANTENIMIENTO\",\"car_nombre\":\"OPERATIVO\"},\"despues\":{\"emple_id\":\"29\",\"emple_apellido_paterno\":\"YALLI\",\"emple_apellido_materno\":\"LOPEZ\",\"emple_nombres\":\"JHONATAN\",\"emple_fecha_nacimiento\":\"2026-03-31\",\"emple_nacionalidad\":\"PERUANO\",\"emple_sexo\":\"Masculino\",\"emple_estado_civil\":\"Otro\",\"emple_telefono_movil\":null,\"emple_telefono_fijo\":null,\"emple_correo\":\"\",\"emple_departamento\":\"\",\"emple_provincia\":\"\",\"emple_distrito\":\"\",\"emple_lugar_residencia\":\"\",\"emple_empresa_id\":\"1\",\"emple_fecha_ingreso\":\"2026-03-31\",\"emple_categoria_ocupacional\":\"\",\"emple_cenco_id\":\"5\",\"emple_area_id\":\"8\",\"emple_cargo_id\":\"4\",\"emple_estado\":\"\",\"emple_fecha_cese\":null,\"emple_situacion_educativa\":\"\",\"emple_estado_educativa\":\"\",\"emple_tipo_regimen\":\"\",\"emple_tipo_institucion\":\"\",\"emple_institucion\":\"\",\"emple_carrera\":\"\",\"emple_anio\":\"\",\"emple_nombre_familiar\":\"\",\"emple_telefono_familiar\":null,\"emple_parentesco\":\"\",\"emple_fecha_vencimiento_documento\":null,\"emple_licencia\":\"NO\",\"emple_archivo_documento\":null,\"emple_fecha_vencimiento_a1\":null,\"emple_archivo_a1\":null,\"emple_fecha_vencimiento_a2a\":null,\"emple_archivo_a2a\":null,\"emple_fecha_vencimiento_a2b\":null,\"emple_archivo_a2b\":null,\"emple_fecha_vencimiento_a3a\":null,\"emple_archivo_a3a\":null,\"emple_fecha_vencimiento_a3b\":null,\"emple_archivo_a3b\":null,\"emple_fecha_vencimiento_a3c\":null,\"emple_archivo_a3c\":null,\"emple_fecha_vencimiento_b1\":null,\"emple_archivo_b1\":null,\"emple_fecha_vencimiento_b2a\":null,\"emple_archivo_b2a\":null,\"emple_fecha_vencimiento_b2b\":null,\"emple_archivo_b2b\":null,\"emple_fecha_vencimiento_b2c\":null,\"emple_archivo_b2c\":null,\"emple_fecha_update\":\"2026-03-31 14:30:18\"},\"campos_cambiados\":{\"emple_cargo_id\":{\"antes\":3,\"despues\":\"4\"},\"emple_area_id\":{\"antes\":7,\"despues\":\"8\"}}}', '2026-03-31 19:30:18'),
(38, 'empleados', 'empleados', '28', 'EDITAR', 1, '190.116.23.99', '{\"antes\":{\"emple_id\":28,\"emple_codigo\":\"EMP0027\",\"emple_tipo_documento\":\"DNI\",\"emple_numero_documento\":\"99999999\",\"emple_apellido_paterno\":\"PARI\",\"emple_apellido_materno\":\"VARGAS\",\"emple_nombres\":\"LUIS\",\"emple_fecha_nacimiento\":\"2026-03-30\",\"emple_nacionalidad\":\"PERUANO\",\"emple_sexo\":\"Masculino\",\"emple_estado_civil\":\"Otro\",\"emple_telefono_movil\":null,\"emple_telefono_fijo\":null,\"emple_correo\":null,\"emple_departamento\":null,\"emple_provincia\":null,\"emple_distrito\":null,\"emple_lugar_residencia\":null,\"emple_empresa_id\":1,\"emple_fecha_ingreso\":\"2026-03-30\",\"emple_categoria_ocupacional\":null,\"emple_cenco_id\":5,\"emple_area_id\":5,\"emple_cargo_id\":3,\"emple_estado\":null,\"emple_fecha_cese\":null,\"emple_situacion_educativa\":null,\"emple_estado_educativa\":null,\"emple_tipo_regimen\":null,\"emple_tipo_institucion\":null,\"emple_institucion\":null,\"emple_carrera\":null,\"emple_anio\":null,\"emple_nombre_familiar\":null,\"emple_telefono_familiar\":null,\"emple_parentesco\":null,\"emple_fecha_vencimiento_documento\":null,\"emple_archivo_documento\":null,\"emple_licencia\":\"NO\",\"emple_fecha_vencimiento_a1\":null,\"emple_archivo_a1\":null,\"emple_fecha_vencimiento_a2a\":null,\"emple_archivo_a2a\":null,\"emple_fecha_vencimiento_a2b\":null,\"emple_archivo_a2b\":null,\"emple_fecha_vencimiento_a3a\":null,\"emple_archivo_a3a\":null,\"emple_fecha_vencimiento_a3b\":null,\"emple_archivo_a3b\":null,\"emple_fecha_vencimiento_a3c\":null,\"emple_archivo_a3c\":null,\"emple_fecha_vencimiento_b1\":null,\"emple_archivo_b1\":null,\"emple_fecha_vencimiento_b2a\":null,\"emple_archivo_b2a\":null,\"emple_fecha_vencimiento_b2b\":null,\"emple_archivo_b2b\":null,\"emple_fecha_vencimiento_b2c\":null,\"emple_archivo_b2c\":null,\"emple_id_usuario\":1,\"emple_fecha_create\":\"2026-03-30 16:40:58\",\"emple_fecha_update\":null,\"emple_fecha_delete\":null,\"empre_ruc\":\"20160364719\",\"empre_razon_social\":\"EMPRESA DE TRANSPORTES MANUEL JESUS CAMPOS CALLUPE S.R.L.\",\"cenco_codigo\":\"05\",\"cenco_nombre\":\"N/A\",\"are_nombre\":\"OPERACIONES\",\"car_nombre\":\"OPERATIVO\"},\"despues\":{\"emple_id\":\"28\",\"emple_apellido_paterno\":\"PARI\",\"emple_apellido_materno\":\"VARGAS\",\"emple_nombres\":\"LUIS\",\"emple_fecha_nacimiento\":\"2026-03-30\",\"emple_nacionalidad\":\"PERUANO\",\"emple_sexo\":\"Masculino\",\"emple_estado_civil\":\"Otro\",\"emple_telefono_movil\":null,\"emple_telefono_fijo\":null,\"emple_correo\":\"\",\"emple_departamento\":\"\",\"emple_provincia\":\"\",\"emple_distrito\":\"\",\"emple_lugar_residencia\":\"\",\"emple_empresa_id\":\"1\",\"emple_fecha_ingreso\":\"2026-03-30\",\"emple_categoria_ocupacional\":\"\",\"emple_cenco_id\":\"5\",\"emple_area_id\":\"8\",\"emple_cargo_id\":\"4\",\"emple_estado\":\"\",\"emple_fecha_cese\":null,\"emple_situacion_educativa\":\"\",\"emple_estado_educativa\":\"\",\"emple_tipo_regimen\":\"\",\"emple_tipo_institucion\":\"\",\"emple_institucion\":\"\",\"emple_carrera\":\"\",\"emple_anio\":\"\",\"emple_nombre_familiar\":\"\",\"emple_telefono_familiar\":null,\"emple_parentesco\":\"\",\"emple_fecha_vencimiento_documento\":null,\"emple_licencia\":\"NO\",\"emple_archivo_documento\":null,\"emple_fecha_vencimiento_a1\":null,\"emple_archivo_a1\":null,\"emple_fecha_vencimiento_a2a\":null,\"emple_archivo_a2a\":null,\"emple_fecha_vencimiento_a2b\":null,\"emple_archivo_a2b\":null,\"emple_fecha_vencimiento_a3a\":null,\"emple_archivo_a3a\":null,\"emple_fecha_vencimiento_a3b\":null,\"emple_archivo_a3b\":null,\"emple_fecha_vencimiento_a3c\":null,\"emple_archivo_a3c\":null,\"emple_fecha_vencimiento_b1\":null,\"emple_archivo_b1\":null,\"emple_fecha_vencimiento_b2a\":null,\"emple_archivo_b2a\":null,\"emple_fecha_vencimiento_b2b\":null,\"emple_archivo_b2b\":null,\"emple_fecha_vencimiento_b2c\":null,\"emple_archivo_b2c\":null,\"emple_fecha_update\":\"2026-03-31 14:30:34\"},\"campos_cambiados\":{\"emple_cargo_id\":{\"antes\":3,\"despues\":\"4\"},\"emple_area_id\":{\"antes\":5,\"despues\":\"8\"}}}', '2026-03-31 19:30:34'),
(39, 'movimiento-caja', 'movimientos', '20', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":20,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"004\",\"movi_numero\":2020,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-03\",\"movi_emple_id\":30,\"movi_total\":\"90.00\",\"movi_fecha_create\":\"2026-03-31 19:31:16\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"SERVICIO DE VIGILANCIA NOCTURNA BASE MINERIA  02/03\",\"deta_movi_importe\":\"90.00\"}]},\"campos_cambiados\":[]}', '2026-03-31 19:31:16'),
(40, 'movimiento-caja', 'movimientos', '21', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":21,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"004\",\"movi_numero\":2021,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-03\",\"movi_emple_id\":28,\"movi_total\":\"90.00\",\"movi_fecha_create\":\"2026-03-31 20:00:39\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"SERVICIO DE VIGILANCIA NOCTURNA BASE MINERIA  03/03\",\"deta_movi_importe\":\"90.00\"}]},\"campos_cambiados\":[]}', '2026-03-31 20:00:39'),
(41, 'movimiento-caja', 'movimientos', '22', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":22,\"movi_tipo\":\"INGRESO\",\"movi_serie\":\"001\",\"movi_numero\":2329,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-04\",\"movi_emple_id\":15,\"movi_total\":\"320.00\",\"movi_fecha_create\":\"2026-03-31 20:06:35\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"INGRESO MEDIANTE TRANSFERENCIA 03/03\",\"deta_movi_importe\":\"320.00\"}]},\"campos_cambiados\":[]}', '2026-03-31 20:06:35'),
(42, 'movimiento-caja', 'movimientos', '23', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":23,\"movi_tipo\":\"INGRESO\",\"movi_serie\":\"001\",\"movi_numero\":2330,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-04\",\"movi_emple_id\":15,\"movi_total\":\"800.04\",\"movi_fecha_create\":\"2026-03-31 20:07:53\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"INGRESO MEDIANTE TRANSFERENCIA 04/03\",\"deta_movi_importe\":\"800.04\"}]},\"campos_cambiados\":[]}', '2026-03-31 20:07:53'),
(43, 'movimiento-caja', 'movimientos', '24', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":24,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"001\",\"movi_numero\":9763,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-04\",\"movi_emple_id\":15,\"movi_total\":\"0.05\",\"movi_fecha_create\":\"2026-03-31 20:09:38\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"IMPUESTO ITF -BCP 03/03\",\"deta_movi_importe\":\"0.05\"}]},\"campos_cambiados\":[]}', '2026-03-31 20:09:38'),
(44, 'movimiento-caja', 'movimientos', '25', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":25,\"movi_tipo\":\"INGRESO\",\"movi_serie\":\"002\",\"movi_numero\":4305,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-04\",\"movi_emple_id\":12,\"movi_total\":\"320.00\",\"movi_fecha_create\":\"2026-03-31 20:34:54\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"GASTO DE VIAJE ALPAYANA ATN-750  03/03\",\"deta_movi_importe\":\"320.00\"}]},\"campos_cambiados\":[]}', '2026-03-31 20:34:54'),
(45, 'movimiento-caja', 'movimientos', '26', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":26,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17890,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-04\",\"movi_emple_id\":22,\"movi_total\":\"220.00\",\"movi_fecha_create\":\"2026-03-31 21:00:43\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"GASTO DE VIAJE HUARAL AWX 892\",\"deta_movi_importe\":\"220.00\"}]},\"campos_cambiados\":[]}', '2026-03-31 21:00:43'),
(46, 'movimiento-caja', 'movimientos', '27', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":27,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17891,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-04\",\"movi_emple_id\":2,\"movi_total\":\"200.00\",\"movi_fecha_create\":\"2026-03-31 21:04:09\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"CARGA DE LADRILLO 24 TONELADAS\",\"deta_movi_importe\":\"200.00\"}]},\"campos_cambiados\":[]}', '2026-03-31 21:04:09'),
(47, 'movimiento-caja', 'movimientos', '28', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":28,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"004\",\"movi_numero\":2022,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-04\",\"movi_emple_id\":30,\"movi_total\":\"90.00\",\"movi_fecha_create\":\"2026-03-31 21:05:23\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"SERVICIO DE VIGILANCIA NOCTURNA BASE MINERIA  04/03\",\"deta_movi_importe\":\"90.00\"}]},\"campos_cambiados\":[]}', '2026-03-31 21:05:23'),
(48, 'movimiento-caja', 'movimientos', '29', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":29,\"movi_tipo\":\"INGRESO\",\"movi_serie\":\"001\",\"movi_numero\":2331,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-05\",\"movi_emple_id\":15,\"movi_total\":\"2000.10\",\"movi_fecha_create\":\"2026-04-01 17:49:26\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"INGRESO MEDIANTE TRANSFERENCIA 05/03\",\"deta_movi_importe\":\"2000.10\"}]},\"campos_cambiados\":[]}', '2026-04-01 17:49:26'),
(49, 'movimiento-caja', 'movimientos', '30', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":30,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"001\",\"movi_numero\":9764,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-05\",\"movi_emple_id\":15,\"movi_total\":\"1.00\",\"movi_fecha_create\":\"2026-04-01 17:51:43\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"COMISION  RETIRO AGENTE\",\"deta_movi_importe\":\"1.00\"}]},\"campos_cambiados\":[]}', '2026-04-01 17:51:43'),
(50, 'movimiento-caja', 'movimientos', '31', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":31,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"001\",\"movi_numero\":9765,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-05\",\"movi_emple_id\":3,\"movi_total\":\"74.00\",\"movi_fecha_create\":\"2026-04-01 17:52:35\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"REEMBOLSO DE FACTURAS\",\"deta_movi_importe\":\"74.00\"}]},\"campos_cambiados\":[]}', '2026-04-01 17:52:35'),
(51, 'movimiento-caja', 'movimientos', '32', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":32,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17892,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-05\",\"movi_emple_id\":2,\"movi_total\":\"210.00\",\"movi_fecha_create\":\"2026-04-01 17:54:28\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"DESCARGA DE LADRILLOS 35 MILLARES\",\"deta_movi_importe\":\"210.00\"}]},\"campos_cambiados\":[]}', '2026-04-01 17:54:28');
INSERT INTO `auditoria_general` (`aud_id`, `aud_modulo`, `aud_entidad_tabla`, `aud_entidad_id`, `aud_accion`, `aud_usuario_id`, `aud_ip_origen`, `aud_detalle_json`, `aud_fecha_evento`) VALUES
(52, 'movimiento-caja', 'movimientos', '33', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":33,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17893,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-05\",\"movi_emple_id\":22,\"movi_total\":\"40.00\",\"movi_fecha_create\":\"2026-04-01 17:55:36\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"GASTO ADICIONAL CORRESPONDIENTE AL REC 002- 17890 (HOTEL)\",\"deta_movi_importe\":\"40.00\"}]},\"campos_cambiados\":[]}', '2026-04-01 17:55:36'),
(53, 'movimiento-caja', 'movimientos', '34', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":34,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17894,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-05\",\"movi_emple_id\":20,\"movi_total\":\"100.00\",\"movi_fecha_create\":\"2026-04-01 17:57:10\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"A RENDIR (PASAJE)\",\"deta_movi_importe\":\"100.00\"}]},\"campos_cambiados\":[]}', '2026-04-01 17:57:10'),
(54, 'movimiento-caja', 'movimientos', '35', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":35,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17895,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-05\",\"movi_emple_id\":22,\"movi_total\":\"220.00\",\"movi_fecha_create\":\"2026-04-01 17:58:44\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"GASTO DE VIAJE HUARAL AWX 892  05/03\",\"deta_movi_importe\":\"220.00\"}]},\"campos_cambiados\":[]}', '2026-04-01 17:58:44'),
(55, 'movimiento-caja', 'movimientos', '36', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":36,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17896,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-05\",\"movi_emple_id\":1,\"movi_total\":\"320.00\",\"movi_fecha_create\":\"2026-04-01 17:59:48\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"GASTO DE VIAJE ALPAYANA ATN-851  05/03\",\"deta_movi_importe\":\"320.00\"}]},\"campos_cambiados\":[]}', '2026-04-01 17:59:48'),
(56, 'movimiento-caja', 'movimientos', '37', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":37,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17897,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-05\",\"movi_emple_id\":20,\"movi_total\":\"50.80\",\"movi_fecha_create\":\"2026-04-01 18:00:49\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"LIQUIDACION GV.9306 OP.ALPAYANA PLACA ATL 908 RELACIONADO AL REC 002- 17833\",\"deta_movi_importe\":\"50.80\"}]},\"campos_cambiados\":[]}', '2026-04-01 18:00:49'),
(57, 'movimiento-caja', 'movimientos', '38', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":38,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17898,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-05\",\"movi_emple_id\":17,\"movi_total\":\"12.60\",\"movi_fecha_create\":\"2026-04-01 18:01:43\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"PEAJES CAMIONETA AMR-892\",\"deta_movi_importe\":\"12.60\"}]},\"campos_cambiados\":[]}', '2026-04-01 18:01:43'),
(58, 'movimiento-caja', 'movimientos', '39', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":39,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17899,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-05\",\"movi_emple_id\":2,\"movi_total\":\"400.00\",\"movi_fecha_create\":\"2026-04-01 18:02:43\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"GASTO DE VIAJE VICUS  ATN- 925 05/03\",\"deta_movi_importe\":\"400.00\"}]},\"campos_cambiados\":[]}', '2026-04-01 18:02:43'),
(59, 'movimiento-caja', 'movimientos', '40', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":40,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17900,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-05\",\"movi_emple_id\":17,\"movi_total\":\"15.00\",\"movi_fecha_create\":\"2026-04-01 19:11:45\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"VIATICO EN BASE\",\"deta_movi_importe\":\"15.00\"}]},\"campos_cambiados\":[]}', '2026-04-01 19:11:45'),
(60, 'movimiento-caja', 'movimientos', '41', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":41,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17901,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-05\",\"movi_emple_id\":14,\"movi_total\":\"10.00\",\"movi_fecha_create\":\"2026-04-01 19:13:19\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"VIATICO EN BASE\",\"deta_movi_importe\":\"10.00\"}]},\"campos_cambiados\":[]}', '2026-04-01 19:13:19'),
(61, 'movimiento-caja', 'movimientos', '42', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":42,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"002\",\"movi_numero\":17902,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-05\",\"movi_emple_id\":7,\"movi_total\":\"20.00\",\"movi_fecha_create\":\"2026-04-01 19:14:16\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"VIATICO BASE\",\"deta_movi_importe\":\"20.00\"}]},\"campos_cambiados\":[]}', '2026-04-01 19:14:16'),
(62, 'movimiento-caja', 'movimientos', '43', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":43,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"003\",\"movi_numero\":1063,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-05\",\"movi_emple_id\":6,\"movi_total\":\"95.50\",\"movi_fecha_create\":\"2026-04-01 19:16:14\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"COMPRA SOLDADURA NAZCA  6011\",\"deta_movi_importe\":\"95.50\"}]},\"campos_cambiados\":[]}', '2026-04-01 19:16:14'),
(63, 'movimiento-caja', 'movimientos', '44', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":44,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"003\",\"movi_numero\":1064,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-05\",\"movi_emple_id\":6,\"movi_total\":\"20.00\",\"movi_fecha_create\":\"2026-04-01 19:17:02\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"GASOLINA MOTO\",\"deta_movi_importe\":\"20.00\"}]},\"campos_cambiados\":[]}', '2026-04-01 19:17:02'),
(64, 'movimiento-caja', 'movimientos', '45', 'CREAR', 1, '190.116.23.99', '{\"antes\":null,\"despues\":{\"movimiento\":{\"movi_id\":45,\"movi_tipo\":\"EGRESO\",\"movi_serie\":\"004\",\"movi_numero\":2023,\"movi_moneda\":\"SOLES\",\"movi_fecha\":\"2026-03-05\",\"movi_emple_id\":28,\"movi_total\":\"90.00\",\"movi_fecha_create\":\"2026-04-01 19:18:09\",\"movi_fecha_update\":null,\"movi_fecha_delete\":null},\"detalle\":[{\"deta_movi_item\":1,\"deta_movi_descripcion\":\"SERVICIO DE VIGILANCIA NOCTURNA BASE MINERIA  05/03\",\"deta_movi_importe\":\"90.00\"}]},\"campos_cambiados\":[]}', '2026-04-01 19:18:09');

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
(3, 'OPERATIVO', '2026-03-19 23:39:45', NULL, NULL),
(4, 'N/A', '2026-03-31 19:29:52', NULL, NULL);

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
(5, '05', 'N/A', '2026-03-19 23:49:43', '2026-03-24 14:52:49', NULL);

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
(1, 'INGRESO', 'SOLES', '001', 2331),
(2, 'INGRESO', 'DOLARES', '001', 0),
(3, 'EGRESO', 'SOLES', '001', 9765),
(4, 'EGRESO', 'DOLARES', '001', 0),
(5, 'INGRESO', 'SOLES', '002', 4304),
(6, 'EGRESO', 'SOLES', '002', 17902),
(7, 'INGRESO', 'SOLES', '003', 0),
(8, 'EGRESO', 'SOLES', '003', 1064),
(9, 'EGRESO', 'SOLES', '004', 2023);

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
(1, 1, 1, 'INGRESO MEDIANTE TRANSFERENCIA', 850.04),
(2, 2, 1, 'MANTENIMIENTO DE CUENTA', 12.00),
(3, 3, 1, 'LIQUIDACION GV.9289  OP.ALPAYANA PLACA ATN-750 RELACIONADO AL REC 002- 17825-17835-17839', 137.80),
(4, 4, 1, 'GASTO DE VIAJE ICA ATN 750', 450.00),
(5, 5, 1, 'GASTO DE VIAJE HUARAL AWX 892', 300.00),
(6, 6, 1, 'GASTO ADICIONAL CORRESPONDIENTE AL REC 17869', 100.00),
(7, 7, 1, 'SERVICIO DE VIGILANCIA NOCTURNA BASE MINERIA  01/03', 90.00),
(8, 8, 1, 'INGRESO MEDIANTE TRANSFERENCIA', 1500.08),
(9, 9, 1, 'LIQUIDACION GV.9302OP.ALPAYANA  PLACA ATN851  RELACIONADO AL REC 002- 17871', 1.20),
(10, 10, 1, 'LIQUIDACION GV.9301OP.ALPAYANA  PLACA ATN851  RELACIONADO AL REC 002- 17855', 3.80),
(12, 12, 1, 'DESCARGA DE LADRILLOS 6 MILLARES', 210.00),
(13, 13, 1, 'GASTO DE VIAJE ALPAYANA ATN-851  03/03', 320.00),
(14, 14, 1, 'GASTO ADICIONAL HOSPEDAJE CORRESPONDIENTE AL REC 002-17869', 40.00),
(15, 15, 1, 'GASTO DE VIAJE ICA  F9D-990', 450.00),
(16, 16, 1, 'VIATICO EN BASE 27/02', 10.00),
(17, 17, 1, 'VIATICO EN BASE 27/02', 10.00),
(18, 18, 1, 'GASTO ADICIONAL CORRESPONDIENTE Al REC 002- 17867', 50.00),
(19, 19, 1, 'A RENDIR FACTURA', 159.00),
(20, 20, 1, 'SERVICIO DE VIGILANCIA NOCTURNA BASE MINERIA  02/03', 90.00),
(21, 21, 1, 'SERVICIO DE VIGILANCIA NOCTURNA BASE MINERIA  03/03', 90.00),
(22, 22, 1, 'INGRESO MEDIANTE TRANSFERENCIA 03/03', 320.00),
(23, 23, 1, 'INGRESO MEDIANTE TRANSFERENCIA 04/03', 800.04),
(24, 24, 1, 'IMPUESTO ITF -BCP 03/03', 0.05),
(25, 25, 1, 'GASTO DE VIAJE ALPAYANA ATN-750  03/03', 320.00),
(26, 26, 1, 'GASTO DE VIAJE HUARAL AWX 892', 220.00),
(27, 27, 1, 'CARGA DE LADRILLO 24 TONELADAS', 200.00),
(28, 28, 1, 'SERVICIO DE VIGILANCIA NOCTURNA BASE MINERIA  04/03', 90.00),
(29, 29, 1, 'INGRESO MEDIANTE TRANSFERENCIA 05/03', 2000.10),
(30, 30, 1, 'COMISION  RETIRO AGENTE', 1.00),
(31, 31, 1, 'REEMBOLSO DE FACTURAS', 74.00),
(32, 32, 1, 'DESCARGA DE LADRILLOS 35 MILLARES', 210.00),
(33, 33, 1, 'GASTO ADICIONAL CORRESPONDIENTE AL REC 002- 17890 (HOTEL)', 40.00),
(34, 34, 1, 'A RENDIR (PASAJE)', 100.00),
(35, 35, 1, 'GASTO DE VIAJE HUARAL AWX 892  05/03', 220.00),
(36, 36, 1, 'GASTO DE VIAJE ALPAYANA ATN-851  05/03', 320.00),
(37, 37, 1, 'LIQUIDACION GV.9306 OP.ALPAYANA PLACA ATL 908 RELACIONADO AL REC 002- 17833', 50.80),
(38, 38, 1, 'PEAJES CAMIONETA AMR-892', 12.60),
(39, 39, 1, 'GASTO DE VIAJE VICUS  ATN- 925 05/03', 400.00),
(40, 40, 1, 'VIATICO EN BASE', 15.00),
(41, 41, 1, 'VIATICO EN BASE', 10.00),
(42, 42, 1, 'VIATICO BASE', 20.00),
(43, 43, 1, 'COMPRA SOLDADURA NAZCA  6011', 95.50),
(44, 44, 1, 'GASOLINA MOTO', 20.00),
(45, 45, 1, 'SERVICIO DE VIGILANCIA NOCTURNA BASE MINERIA  05/03', 90.00);

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
(27, 'EMP0026', 'DNI', '70232557', 'ZUÑIGA', 'AROHUILLCA', 'CASIMIRO', '2026-03-20', 'PERUANO', 'Masculino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20', NULL, 5, 5, 1, 'Activo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-20 16:19:41', '2026-03-24 14:57:44', NULL),
(28, 'EMP0027', 'DNI', '99999999', 'PARI', 'VARGAS', 'LUIS', '2026-03-30', 'PERUANO', 'Masculino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-30', NULL, 5, 8, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-30 16:40:58', '2026-03-31 14:30:34', NULL),
(29, 'EMP0028', 'DNI', '99999999', 'YALLI', 'LOPEZ', 'JHONATAN', '2026-03-31', 'PERUANO', 'Masculino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-31', NULL, 5, 8, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-31 19:22:27', '2026-03-31 14:30:18', NULL),
(30, 'EMP0029', 'DNI', '99999999', 'ALTAMIRANO', 'TOVAR', 'VICTOR', '2026-03-31', 'PERUANO', 'Masculino', 'Otro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-31', NULL, 5, 8, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-31 19:29:22', '2026-03-31 14:30:05', NULL);

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
(1, '20160364719', 'EMPRESA DE TRANSPORTES MANUEL JESUS CAMPOS CALLUPE S.R.L.', 'TMC', 'JR. MINERIA NRO. 320 URB. LOS FICUS LIMA LIMA SANTA ANITA', '99999999', 'info@transportescampos.com', '2026-03-19 22:53:53', '2026-03-26 10:59:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hoja_liquidacion`
--

CREATE TABLE `hoja_liquidacion` (
  `hoja_id` int(11) NOT NULL,
  `hoja_numero_registro` varchar(30) NOT NULL DEFAULT '',
  `hoja_fecha_salida` date NOT NULL,
  `hoja_fecha_llegada` date NOT NULL,
  `hoja_vehic_tracto_id` int(11) NOT NULL,
  `hoja_vehic_tolva_id` int(11) NOT NULL,
  `hoja_operacion` int(11) NOT NULL DEFAULT 0,
  `hoja_monto_recibido` decimal(12,2) NOT NULL DEFAULT 0.00,
  `hoja_empleado_id` int(11) NOT NULL,
  `hoja_grr_producto` varchar(100) NOT NULL,
  `hoja_producto` varchar(150) NOT NULL,
  `hoja_grr_servicio_adicional` varchar(100) NOT NULL,
  `hoja_servicio_adicional` varchar(150) NOT NULL,
  `hoja_gr_transportista` varchar(150) NOT NULL,
  `hoja_peaje` decimal(12,2) NOT NULL DEFAULT 0.00,
  `hoja_boletas_varias` decimal(12,2) NOT NULL DEFAULT 0.00,
  `hoja_boletas_consumo` decimal(12,2) NOT NULL DEFAULT 0.00,
  `hoja_planilla_movilidad` decimal(12,2) NOT NULL DEFAULT 0.00,
  `hoja_facturas_varios` decimal(12,2) NOT NULL DEFAULT 0.00,
  `hoja_carga_descarga_ladrillo` decimal(10,2) NOT NULL DEFAULT 0.00,
  `hoja_reintegro` decimal(12,2) NOT NULL DEFAULT 0.00,
  `hoja_vuelto` decimal(12,2) NOT NULL DEFAULT 0.00,
  `hoja_suma_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `hoja_observaciones` text DEFAULT NULL,
  `hoja_km_salida` decimal(12,2) NOT NULL DEFAULT 0.00,
  `hoja_km_llegada` decimal(12,2) NOT NULL DEFAULT 0.00,
  `hoja_cv_grifo` decimal(12,2) NOT NULL DEFAULT 0.00,
  `hoja_cv_eq` decimal(12,2) NOT NULL DEFAULT 0.00,
  `hoja_total_km` decimal(12,2) NOT NULL DEFAULT 0.00,
  `hoja_variacion` decimal(12,2) NOT NULL DEFAULT 0.00,
  `hoja_fecha_create` timestamp NOT NULL DEFAULT current_timestamp(),
  `hoja_fecha_update` datetime DEFAULT NULL,
  `hoja_fecha_delete` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hoja_liquidacion`
--

INSERT INTO `hoja_liquidacion` (`hoja_id`, `hoja_numero_registro`, `hoja_fecha_salida`, `hoja_fecha_llegada`, `hoja_vehic_tracto_id`, `hoja_vehic_tolva_id`, `hoja_operacion`, `hoja_monto_recibido`, `hoja_empleado_id`, `hoja_grr_producto`, `hoja_producto`, `hoja_grr_servicio_adicional`, `hoja_servicio_adicional`, `hoja_gr_transportista`, `hoja_peaje`, `hoja_boletas_varias`, `hoja_boletas_consumo`, `hoja_planilla_movilidad`, `hoja_facturas_varios`, `hoja_carga_descarga_ladrillo`, `hoja_reintegro`, `hoja_vuelto`, `hoja_suma_total`, `hoja_observaciones`, `hoja_km_salida`, `hoja_km_llegada`, `hoja_cv_grifo`, `hoja_cv_eq`, `hoja_total_km`, `hoja_variacion`, `hoja_fecha_create`, `hoja_fecha_update`, `hoja_fecha_delete`) VALUES
(1, 'GV-000001', '2026-02-21', '2026-02-24', 1, 2, 3, 400.00, 1, '', '', '', '', '', 209.60, 197.00, 160.00, 0.00, 0.00, 0.00, 166.60, 0.00, 566.60, '', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2026-03-27 17:48:18', '2026-03-28 10:50:27', NULL);

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
(1, 'INGRESO', '001', 2327, 'SOLES', '2026-03-02', 15, 850.04, '2026-03-30 15:51:29', NULL, NULL),
(2, 'EGRESO', '001', 9762, 'SOLES', '2026-03-02', 15, 12.00, '2026-03-30 15:54:04', NULL, NULL),
(3, 'EGRESO', '002', 17877, 'SOLES', '2026-03-02', 12, 137.80, '2026-03-30 15:58:28', NULL, NULL),
(4, 'EGRESO', '002', 17878, 'SOLES', '2026-03-02', 12, 450.00, '2026-03-30 15:59:16', NULL, NULL),
(5, 'EGRESO', '002', 17879, 'SOLES', '2026-03-02', 22, 300.00, '2026-03-30 16:00:48', NULL, NULL),
(6, 'EGRESO', '002', 17880, 'SOLES', '2026-03-02', 2, 100.00, '2026-03-30 16:01:45', NULL, NULL),
(7, 'EGRESO', '004', 2019, 'SOLES', '2026-03-02', 28, 90.00, '2026-03-30 16:42:06', NULL, NULL),
(8, 'INGRESO', '001', 2328, 'SOLES', '2026-03-03', 15, 1500.08, '2026-03-30 16:47:06', NULL, NULL),
(9, 'INGRESO', '002', 4304, 'SOLES', '2026-03-03', 1, 1.20, '2026-03-30 21:50:00', NULL, NULL),
(10, 'EGRESO', '002', 17881, 'SOLES', '2026-03-03', 1, 3.80, '2026-03-30 21:54:15', NULL, NULL),
(12, 'EGRESO', '002', 17882, 'SOLES', '2026-03-03', 12, 210.00, '2026-03-30 22:12:46', NULL, NULL),
(13, 'EGRESO', '002', 17883, 'SOLES', '2026-03-03', 1, 320.00, '2026-03-30 22:15:55', NULL, NULL),
(14, 'EGRESO', '002', 17884, 'SOLES', '2026-03-03', 22, 40.00, '2026-03-30 22:20:13', NULL, NULL),
(15, 'EGRESO', '002', 17885, 'SOLES', '2026-03-03', 2, 450.00, '2026-03-30 22:21:17', NULL, NULL),
(16, 'EGRESO', '002', 17886, 'SOLES', '2026-03-03', 21, 10.00, '2026-03-30 22:22:57', NULL, NULL),
(17, 'EGRESO', '002', 17887, 'SOLES', '2026-03-03', 29, 10.00, '2026-03-31 19:23:30', NULL, NULL),
(18, 'EGRESO', '002', 17888, 'SOLES', '2026-03-03', 17, 50.00, '2026-03-31 19:24:16', NULL, NULL),
(19, 'EGRESO', '003', 1062, 'SOLES', '2026-03-03', 6, 159.00, '2026-03-31 19:26:50', NULL, NULL),
(20, 'EGRESO', '004', 2020, 'SOLES', '2026-03-03', 30, 90.00, '2026-03-31 19:31:16', NULL, NULL),
(21, 'EGRESO', '004', 2021, 'SOLES', '2026-03-03', 28, 90.00, '2026-03-31 20:00:39', NULL, NULL),
(22, 'INGRESO', '001', 2329, 'SOLES', '2026-03-04', 15, 320.00, '2026-03-31 20:06:35', NULL, NULL),
(23, 'INGRESO', '001', 2330, 'SOLES', '2026-03-04', 15, 800.04, '2026-03-31 20:07:53', NULL, NULL),
(24, 'EGRESO', '001', 9763, 'SOLES', '2026-03-04', 15, 0.05, '2026-03-31 20:09:38', NULL, NULL),
(25, 'EGRESO', '002', 17889, 'SOLES', '2026-03-04', 12, 320.00, '2026-03-31 20:34:54', NULL, NULL),
(26, 'EGRESO', '002', 17890, 'SOLES', '2026-03-04', 22, 220.00, '2026-03-31 21:00:43', NULL, NULL),
(27, 'EGRESO', '002', 17891, 'SOLES', '2026-03-04', 2, 200.00, '2026-03-31 21:04:09', NULL, NULL),
(28, 'EGRESO', '004', 2022, 'SOLES', '2026-03-04', 30, 90.00, '2026-03-31 21:05:23', NULL, NULL),
(29, 'INGRESO', '001', 2331, 'SOLES', '2026-03-05', 15, 2000.10, '2026-04-01 17:49:26', NULL, NULL),
(30, 'EGRESO', '001', 9764, 'SOLES', '2026-03-05', 15, 1.00, '2026-04-01 17:51:43', NULL, NULL),
(31, 'EGRESO', '001', 9765, 'SOLES', '2026-03-05', 3, 74.00, '2026-04-01 17:52:35', NULL, NULL),
(32, 'EGRESO', '002', 17892, 'SOLES', '2026-03-05', 2, 210.00, '2026-04-01 17:54:28', NULL, NULL),
(33, 'EGRESO', '002', 17893, 'SOLES', '2026-03-05', 22, 40.00, '2026-04-01 17:55:36', NULL, NULL),
(34, 'EGRESO', '002', 17894, 'SOLES', '2026-03-05', 20, 100.00, '2026-04-01 17:57:10', NULL, NULL),
(35, 'EGRESO', '002', 17895, 'SOLES', '2026-03-05', 22, 220.00, '2026-04-01 17:58:44', NULL, NULL),
(36, 'EGRESO', '002', 17896, 'SOLES', '2026-03-05', 1, 320.00, '2026-04-01 17:59:48', NULL, NULL),
(37, 'EGRESO', '002', 17897, 'SOLES', '2026-03-05', 20, 50.80, '2026-04-01 18:00:49', NULL, NULL),
(38, 'EGRESO', '002', 17898, 'SOLES', '2026-03-05', 17, 12.60, '2026-04-01 18:01:43', NULL, NULL),
(39, 'EGRESO', '002', 17899, 'SOLES', '2026-03-05', 2, 400.00, '2026-04-01 18:02:43', NULL, NULL),
(40, 'EGRESO', '002', 17900, 'SOLES', '2026-03-05', 17, 15.00, '2026-04-01 19:11:45', NULL, NULL),
(41, 'EGRESO', '002', 17901, 'SOLES', '2026-03-05', 14, 10.00, '2026-04-01 19:13:19', NULL, NULL),
(42, 'EGRESO', '002', 17902, 'SOLES', '2026-03-05', 7, 20.00, '2026-04-01 19:14:16', NULL, NULL),
(43, 'EGRESO', '003', 1063, 'SOLES', '2026-03-05', 6, 95.50, '2026-04-01 19:16:14', NULL, NULL),
(44, 'EGRESO', '003', 1064, 'SOLES', '2026-03-05', 6, 20.00, '2026-04-01 19:17:02', NULL, NULL),
(45, 'EGRESO', '004', 2023, 'SOLES', '2026-03-05', 28, 90.00, '2026-04-01 19:18:09', NULL, NULL);

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
(1, 'Usuario Administrado', 'admin', '$2a$07$asxx54ahjppf45sd87a5auXBm1Vr2M1NV5t/zNQtGHGpS5fFirrbG', 'Administrador', 'vistas/img/usuarios/admin/254.jpg', 1, '2026-04-01 12:45:44', '2026-03-18 15:45:24', '2026-04-01 17:45:44', NULL, 0),
(4, 'Cinthya Castro Campos', 'ccastro', '$2a$07$asxx54ahjppf45sd87a5auif18O4gzCcDqpF2w4htO8A6rPYLRzBq', 'Usuario', '', 1, '2026-03-20 17:09:12', '2026-03-20 15:33:29', '2026-03-20 22:09:12', NULL, 0),
(5, 'Jesus Campos Arias', 'jcampos', '$2a$07$asxx54ahjppf45sd87a5auZ15XpD3.M4vXZ/O1netEgiNGDiPZIFC', 'Usuario', '', 1, '2026-03-24 18:27:40', '2026-03-24 22:01:54', '2026-03-24 23:27:40', NULL, 0),
(6, 'Martha Zanabria Luya', 'mzanabria', '$2a$07$asxx54ahjppf45sd87a5auK6Y6F9zqJ/ZRa4ytdwBNLbYWEOu6zii', 'Usuario', '', 0, '2026-03-27 17:30:43', '2026-03-27 17:20:34', '2026-03-30 15:46:32', NULL, 0),
(7, 'Judith Muje Taipe', 'jmuje', '$2a$07$asxx54ahjppf45sd87a5auQoOZsk.ZSmGEr9VECbpZqRWqQI0V3dm', 'Usuario', '', NULL, NULL, '2026-03-27 17:29:10', NULL, NULL, 0);

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
(119, 4, 'centro-costo', '2026-03-20 15:35:58'),
(120, 4, 'empresas', '2026-03-20 15:35:58'),
(121, 4, 'areas', '2026-03-20 15:35:58'),
(122, 4, 'cargos', '2026-03-20 15:35:58'),
(123, 4, 'empleados', '2026-03-20 15:35:58'),
(124, 4, 'movimiento-caja', '2026-03-20 15:35:58'),
(125, 1, 'usuarios', '2026-03-23 14:56:34'),
(126, 1, 'centro-costo', '2026-03-23 14:56:34'),
(127, 1, 'empresas', '2026-03-23 14:56:34'),
(128, 1, 'vehiculos', '2026-03-23 14:56:34'),
(129, 1, 'sig-opt', '2026-03-23 14:56:34'),
(130, 1, 'areas', '2026-03-23 14:56:34'),
(131, 1, 'cargos', '2026-03-23 14:56:34'),
(132, 1, 'empleados', '2026-03-23 14:56:34'),
(133, 1, 'movimiento-caja', '2026-03-23 14:56:34'),
(134, 1, 'rendicion-caja-chica', '2026-03-23 14:56:34'),
(135, 1, 'hoja-liquidacion', '2026-03-23 14:56:34'),
(136, 1, 'orden-servicio', '2026-03-23 14:56:34'),
(137, 5, 'movimiento-caja', '2026-03-24 23:26:24'),
(138, 6, 'movimiento-caja', '2026-03-27 17:25:12'),
(139, 6, 'hoja-liquidacion', '2026-03-27 17:25:12');

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
-- Dumping data for table `vehiculos`
--

INSERT INTO `vehiculos` (`vehic_id`, `vehic_cenco_id`, `vehic_placa`, `vehic_marca`, `vehic_modelo`, `vehic_anio`, `vehic_clase`, `vehic_tipo`, `vehic_numero_vin`, `vehic_numero_motor`, `vehic_jefe_operacion`, `vehic_estado`, `vehic_propietario`, `vehic_fecha_create`, `vehic_fecha_update`, `vehic_fecha_delete`) VALUES
(1, 5, 'ASC-801', 'N/A', 'N/A', '2021', 'N/A', 'TRACTO', 'ASC801', 'ASC801', 'N/A', 'OPERATIVA', 'PROPIO', '2026-03-20 23:52:16', '2026-03-23 10:44:16', NULL),
(2, 5, 'AXC-897', 'N/A', 'N/A', '2021', 'N/A', 'TOLVA', 'AXC897', 'AXC897', 'N/A', 'OPERATIVA', 'PROPIO', '2026-03-23 15:55:13', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`are_id`);

--
-- Indexes for table `auditoria_general`
--
ALTER TABLE `auditoria_general`
  ADD PRIMARY KEY (`aud_id`),
  ADD KEY `idx_aud_modulo` (`aud_modulo`),
  ADD KEY `idx_aud_tabla` (`aud_entidad_tabla`),
  ADD KEY `idx_aud_entidad` (`aud_entidad_id`),
  ADD KEY `idx_aud_accion` (`aud_accion`),
  ADD KEY `idx_aud_usuario` (`aud_usuario_id`),
  ADD KEY `idx_aud_fecha` (`aud_fecha_evento`);

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
-- Indexes for table `hoja_liquidacion`
--
ALTER TABLE `hoja_liquidacion`
  ADD PRIMARY KEY (`hoja_id`),
  ADD UNIQUE KEY `uk_hoja_numero_registro` (`hoja_numero_registro`),
  ADD KEY `idx_hoja_tracto` (`hoja_vehic_tracto_id`),
  ADD KEY `idx_hoja_tolva` (`hoja_vehic_tolva_id`),
  ADD KEY `idx_hoja_empleado` (`hoja_empleado_id`),
  ADD KEY `fk_hoja_operacion_cenco` (`hoja_operacion`);

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
  MODIFY `are_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `auditoria_general`
--
ALTER TABLE `auditoria_general`
  MODIFY `aud_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `cargos`
--
ALTER TABLE `cargos`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `deta_movi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `empleados`
--
ALTER TABLE `empleados`
  MODIFY `emple_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `empresas`
--
ALTER TABLE `empresas`
  MODIFY `empre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hoja_liquidacion`
--
ALTER TABLE `hoja_liquidacion`
  MODIFY `hoja_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `movi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `opts`
--
ALTER TABLE `opts`
  MODIFY `opt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `usuarios_modulos`
--
ALTER TABLE `usuarios_modulos`
  MODIFY `umod_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `vehic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- Constraints for table `hoja_liquidacion`
--
ALTER TABLE `hoja_liquidacion`
  ADD CONSTRAINT `fk_hoja_empleado` FOREIGN KEY (`hoja_empleado_id`) REFERENCES `empleados` (`emple_id`),
  ADD CONSTRAINT `fk_hoja_operacion_cenco` FOREIGN KEY (`hoja_operacion`) REFERENCES `centro_costo` (`cenco_id`),
  ADD CONSTRAINT `fk_hoja_tolva` FOREIGN KEY (`hoja_vehic_tolva_id`) REFERENCES `vehiculos` (`vehic_id`),
  ADD CONSTRAINT `fk_hoja_tracto` FOREIGN KEY (`hoja_vehic_tracto_id`) REFERENCES `vehiculos` (`vehic_id`);

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
