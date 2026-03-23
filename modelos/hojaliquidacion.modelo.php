<?php

require_once __DIR__ . '/../config/conexion.php';

class ModeloHojaLiquidacion {

    static public function mdlObtenerSiguienteNumeroRegistro($tabla) {
        $stmt = Conexion::conectar()->prepare("SELECT COALESCE(MAX(CAST(SUBSTRING_INDEX(hoja_numero_registro, '-', -1) AS UNSIGNED)), 0) + 1 AS siguiente FROM $tabla");
        $stmt->execute();
        $respuesta = $stmt->fetch();

        $siguiente = isset($respuesta['siguiente']) ? (int) $respuesta['siguiente'] : 1;
        return 'GV-' . str_pad((string) $siguiente, 6, '0', STR_PAD_LEFT);
    }

    static public function mdlMostrarHojasLiquidacion($tabla, $item, $valor) {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND hoja_fecha_delete IS NULL");
            $stmt->bindParam(':' . $item, $valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        }

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE hoja_fecha_delete IS NULL ORDER BY hoja_id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function mdlCrearHojaLiquidacion($tabla, $datos) {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(
            hoja_numero_registro,
            hoja_fecha_salida,
            hoja_fecha_llegada,
            hoja_vehic_tracto_id,
            hoja_vehic_tolva_id,
            hoja_operacion,
            hoja_monto_recibido,
            hoja_empleado_id,
            hoja_grr_producto,
            hoja_producto,
            hoja_grr_servicio_adicional,
            hoja_servicio_adicional,
            hoja_gr_transportista,
            hoja_peaje,
            hoja_boletas_varias,
            hoja_boletas_consumo,
            hoja_planilla_movilidad,
            hoja_facturas_varios,
            hoja_reintegro,
            hoja_vuelto,
            hoja_suma_total,
            hoja_observaciones,
            hoja_km_salida,
            hoja_km_llegada,
            hoja_cv_grifo,
            hoja_cv_eq,
            hoja_total_km,
            hoja_variacion
        ) VALUES (
            :hoja_numero_registro,
            :hoja_fecha_salida,
            :hoja_fecha_llegada,
            :hoja_vehic_tracto_id,
            :hoja_vehic_tolva_id,
            :hoja_operacion,
            :hoja_monto_recibido,
            :hoja_empleado_id,
            :hoja_grr_producto,
            :hoja_producto,
            :hoja_grr_servicio_adicional,
            :hoja_servicio_adicional,
            :hoja_gr_transportista,
            :hoja_peaje,
            :hoja_boletas_varias,
            :hoja_boletas_consumo,
            :hoja_planilla_movilidad,
            :hoja_facturas_varios,
            :hoja_reintegro,
            :hoja_vuelto,
            :hoja_suma_total,
            :hoja_observaciones,
            :hoja_km_salida,
            :hoja_km_llegada,
            :hoja_cv_grifo,
            :hoja_cv_eq,
            :hoja_total_km,
            :hoja_variacion
        )");

        foreach ($datos as $campo => $valor) {
            $stmt->bindParam(':' . $campo, $datos[$campo], PDO::PARAM_STR);
        }

        if ($stmt->execute()) {
            return 'ok';
        }
        return 'error';
    }

    static public function mdlEditarHojaLiquidacion($tabla, $datos) {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET
            hoja_fecha_salida = :hoja_fecha_salida,
            hoja_fecha_llegada = :hoja_fecha_llegada,
            hoja_vehic_tracto_id = :hoja_vehic_tracto_id,
            hoja_vehic_tolva_id = :hoja_vehic_tolva_id,
            hoja_operacion = :hoja_operacion,
            hoja_monto_recibido = :hoja_monto_recibido,
            hoja_empleado_id = :hoja_empleado_id,
            hoja_grr_producto = :hoja_grr_producto,
            hoja_producto = :hoja_producto,
            hoja_grr_servicio_adicional = :hoja_grr_servicio_adicional,
            hoja_servicio_adicional = :hoja_servicio_adicional,
            hoja_gr_transportista = :hoja_gr_transportista,
            hoja_peaje = :hoja_peaje,
            hoja_boletas_varias = :hoja_boletas_varias,
            hoja_boletas_consumo = :hoja_boletas_consumo,
            hoja_planilla_movilidad = :hoja_planilla_movilidad,
            hoja_facturas_varios = :hoja_facturas_varios,
            hoja_reintegro = :hoja_reintegro,
            hoja_vuelto = :hoja_vuelto,
            hoja_suma_total = :hoja_suma_total,
            hoja_observaciones = :hoja_observaciones,
            hoja_km_salida = :hoja_km_salida,
            hoja_km_llegada = :hoja_km_llegada,
            hoja_cv_grifo = :hoja_cv_grifo,
            hoja_cv_eq = :hoja_cv_eq,
            hoja_total_km = :hoja_total_km,
            hoja_variacion = :hoja_variacion,
            hoja_fecha_update = :hoja_fecha_update
            WHERE hoja_id = :hoja_id");

        foreach ($datos as $campo => $valor) {
            $stmt->bindParam(':' . $campo, $datos[$campo], PDO::PARAM_STR);
        }

        if ($stmt->execute()) {
            return 'ok';
        }
        return 'error';
    }

    static public function mdlEliminarHojaLiquidacion($tabla, $id) {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET hoja_fecha_delete = NOW() WHERE hoja_id = :hoja_id AND hoja_fecha_delete IS NULL");
        $stmt->bindParam(':hoja_id', $id, PDO::PARAM_INT);
        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return 'ok';
        }
        return 'error';
    }

    static public function mdlMostrarHojasLiquidacionEliminadas($tabla) {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE hoja_fecha_delete IS NOT NULL ORDER BY hoja_fecha_delete DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function mdlRestaurarHojaLiquidacion($tabla, $id) {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET hoja_fecha_delete = NULL WHERE hoja_id = :hoja_id AND hoja_fecha_delete IS NOT NULL");
        $stmt->bindParam(':hoja_id', $id, PDO::PARAM_INT);
        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return 'ok';
        }
        return 'error';
    }

    static public function mdlDepurarHojaLiquidacion($tabla, $id) {
        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE hoja_id = :hoja_id AND hoja_fecha_delete IS NOT NULL");
        $stmt->bindParam(':hoja_id', $id, PDO::PARAM_INT);
        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return 'ok';
        }
        return 'error';
    }
}
