<?php

require_once __DIR__ . '/../config/conexion.php';

class ModeloMovimientoCaja {

    /*-------------------------------------
    LISTAR MOVIMIENTOS DE CAJA
    -------------------------------------*/
    static public function mdlMostrarMovimientoCaja($tabla, $item, $valor) {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND movi_fecha_delete IS NULL");
            $stmt->bindParam(':' . $item, $valor, PDO::PARAM_STR);
            $stmt->execute();
            $respuesta = $stmt->fetch();
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE movi_fecha_delete IS NULL ORDER BY movi_id DESC");
            $stmt->execute();
            $respuesta = $stmt->fetchAll();
        }

        $stmt = null;
        return $respuesta;
    }

    /*-------------------------------------
    LISTAR SERIES CONFIGURADAS POR TIPO Y MONEDA
    -------------------------------------*/
    static public function mdlListarSeriesConfiguradas($tipo, $moneda) {
        $stmt = Conexion::conectar()->prepare(
            'SELECT conf_seri_serie
             FROM config_series
             WHERE conf_seri_tipo = :tipo
               AND conf_seri_moneda = :moneda
             ORDER BY conf_seri_serie ASC'
        );

        $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
        $stmt->bindParam(':moneda', $moneda, PDO::PARAM_STR);
        $stmt->execute();

        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;

        return $respuesta;
    }

    /*-------------------------------------
    LISTAR DETALLE POR MOVIMIENTO
    -------------------------------------*/
    static public function mdlMostrarDetalleMovimiento($movimientoId) {
        $stmt = Conexion::conectar()->prepare(
            'SELECT deta_movi_item, deta_movi_descripcion, deta_movi_importe
             FROM detalle_movimiento
             WHERE deta_movi_movimiento_id = :movimiento_id
             ORDER BY deta_movi_item ASC'
        );

        $stmt->bindParam(':movimiento_id', $movimientoId, PDO::PARAM_INT);
        $stmt->execute();

        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;

        return $respuesta;
    }

    /*-------------------------------------
    CREAR MOVIMIENTO + DETALLE CON TRANSACCION
    -------------------------------------*/
    static public function mdlCrearMovimientoCajaConDetalle($cabecera, $detalles) {
        $cn = Conexion::conectar();

        try {
            $cn->beginTransaction();

            $stmtSerie = $cn->prepare(
                'SELECT conf_seri_id, conf_seri_ultimo_numero
                 FROM config_series
                 WHERE conf_seri_tipo = :tipo
                   AND conf_seri_moneda = :moneda
                   AND conf_seri_serie = :serie
                 LIMIT 1
                 FOR UPDATE'
            );
            $stmtSerie->bindParam(':tipo', $cabecera['tipo'], PDO::PARAM_STR);
            $stmtSerie->bindParam(':moneda', $cabecera['moneda'], PDO::PARAM_STR);
            $stmtSerie->bindParam(':serie', $cabecera['serie'], PDO::PARAM_STR);
            $stmtSerie->execute();

            $configSerie = $stmtSerie->fetch(PDO::FETCH_ASSOC);
            if (!$configSerie) {
                $cn->rollBack();
                return array('status' => 'error', 'message' => 'No existe configuracion de serie para tipo/moneda/serie seleccionados.');
            }

            $nuevoNumero = (int) $configSerie['conf_seri_ultimo_numero'] + 1;

            $stmtCab = $cn->prepare(
                'INSERT INTO movimientos (
                    movi_tipo,
                    movi_serie,
                    movi_numero,
                    movi_moneda,
                    movi_fecha,
                    movi_emple_id,
                    movi_total
                ) VALUES (
                    :tipo,
                    :serie,
                    :numero,
                    :moneda,
                    :fecha,
                    :empleado,
                    :total
                )'
            );

            $total = 0;
            foreach ($detalles as $detalle) {
                $total += (float) $detalle['importe'];
            }
            $total = round($total, 2);

            $stmtCab->bindParam(':tipo', $cabecera['tipo'], PDO::PARAM_STR);
            $stmtCab->bindParam(':serie', $cabecera['serie'], PDO::PARAM_STR);
            $stmtCab->bindParam(':numero', $nuevoNumero, PDO::PARAM_INT);
            $stmtCab->bindParam(':moneda', $cabecera['moneda'], PDO::PARAM_STR);
            $stmtCab->bindParam(':fecha', $cabecera['fecha'], PDO::PARAM_STR);
            $stmtCab->bindParam(':empleado', $cabecera['empleado'], PDO::PARAM_INT);
            $stmtCab->bindParam(':total', $total, PDO::PARAM_STR);
            $stmtCab->execute();

            $movimientoId = (int) $cn->lastInsertId();

            $stmtDet = $cn->prepare(
                'INSERT INTO detalle_movimiento (
                    deta_movi_movimiento_id,
                    deta_movi_item,
                    deta_movi_descripcion,
                    deta_movi_importe
                ) VALUES (
                    :movimiento_id,
                    :item,
                    :descripcion,
                    :importe
                )'
            );

            foreach ($detalles as $index => $detalle) {
                $item = $index + 1;
                $descripcion = $detalle['descripcion'];
                $importe = round((float) $detalle['importe'], 2);

                $stmtDet->bindParam(':movimiento_id', $movimientoId, PDO::PARAM_INT);
                $stmtDet->bindParam(':item', $item, PDO::PARAM_INT);
                $stmtDet->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
                $stmtDet->bindParam(':importe', $importe, PDO::PARAM_STR);
                $stmtDet->execute();
            }

            $stmtUpdSerie = $cn->prepare('UPDATE config_series SET conf_seri_ultimo_numero = :numero WHERE conf_seri_id = :id');
            $stmtUpdSerie->bindParam(':numero', $nuevoNumero, PDO::PARAM_INT);
            $stmtUpdSerie->bindParam(':id', $configSerie['conf_seri_id'], PDO::PARAM_INT);
            $stmtUpdSerie->execute();

            $cn->commit();

            return array(
                'status' => 'ok',
                'movi_id' => $movimientoId,
                'movi_numero' => $nuevoNumero,
                'movi_total' => number_format($total, 2, '.', '')
            );
        } catch (Exception $e) {
            if ($cn->inTransaction()) {
                $cn->rollBack();
            }
            return array('status' => 'error', 'message' => 'Error al guardar movimiento: ' . $e->getMessage());
        }
    }

    /*-------------------------------------
    EDITAR MOVIMIENTO DE CAJA (CABECERA)
    -------------------------------------*/
    static public function mdlEditarMovimientoCaja($datos, $detalles) {
        $cn = Conexion::conectar();

        try {
            $cn->beginTransaction();

            $stmtActual = $cn->prepare(
                'SELECT movi_tipo, movi_moneda, movi_serie, movi_numero
                 FROM movimientos
                 WHERE movi_id = :id
                 LIMIT 1
                 FOR UPDATE'
            );
            $stmtActual->bindParam(':id', $datos['movi_id'], PDO::PARAM_INT);
            $stmtActual->execute();
            $actual = $stmtActual->fetch(PDO::FETCH_ASSOC);

            if (!$actual) {
                $cn->rollBack();
                return 'error';
            }

            // tipo, moneda, serie y numero son INMUTABLES una vez creado el movimiento.
            // Solo se permite cambiar fecha, empleado y el detalle.
            $total = 0;
            foreach ($detalles as $detalle) {
                $total += (float) $detalle['importe'];
            }
            $total = round($total, 2);

            $stmtCab = $cn->prepare(
                'UPDATE movimientos
                 SET movi_fecha = :fecha,
                     movi_emple_id = :empleado,
                     movi_total = :total,
                     movi_fecha_update = NOW()
                 WHERE movi_id = :id'
            );

            $stmtCab->bindParam(':fecha', $datos['movi_fecha'], PDO::PARAM_STR);
            $stmtCab->bindParam(':empleado', $datos['movi_emple_id'], PDO::PARAM_INT);
            $stmtCab->bindParam(':total', $total, PDO::PARAM_STR);
            $stmtCab->bindParam(':id', $datos['movi_id'], PDO::PARAM_INT);
            $stmtCab->execute();

            $stmtDelDet = $cn->prepare('DELETE FROM detalle_movimiento WHERE deta_movi_movimiento_id = :movimiento_id');
            $stmtDelDet->bindParam(':movimiento_id', $datos['movi_id'], PDO::PARAM_INT);
            $stmtDelDet->execute();

            $stmtInsDet = $cn->prepare(
                'INSERT INTO detalle_movimiento (
                    deta_movi_movimiento_id,
                    deta_movi_item,
                    deta_movi_descripcion,
                    deta_movi_importe
                ) VALUES (
                    :movimiento_id,
                    :item,
                    :descripcion,
                    :importe
                )'
            );

            foreach ($detalles as $index => $detalle) {
                $item = $index + 1;
                $descripcion = $detalle['descripcion'];
                $importe = round((float) $detalle['importe'], 2);

                $stmtInsDet->bindParam(':movimiento_id', $datos['movi_id'], PDO::PARAM_INT);
                $stmtInsDet->bindParam(':item', $item, PDO::PARAM_INT);
                $stmtInsDet->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
                $stmtInsDet->bindParam(':importe', $importe, PDO::PARAM_STR);
                $stmtInsDet->execute();
            }

            $cn->commit();
            return 'ok';
        } catch (Exception $e) {
            if ($cn->inTransaction()) {
                $cn->rollBack();
            }
            return 'error';
        }
    }

    /*-------------------------------------
    ELIMINAR MOVIMIENTO (BORRADO LOGICO)
    -------------------------------------*/
    static public function mdlEliminarMovimientoCaja($idMovimiento) {
        $stmt = Conexion::conectar()->prepare(
            'UPDATE movimientos
             SET movi_fecha_delete = NOW()
             WHERE movi_id = :id
               AND movi_fecha_delete IS NULL'
        );
        $stmt->bindParam(':id', $idMovimiento, PDO::PARAM_INT);

        if($stmt->execute() && $stmt->rowCount() > 0){
            return 'ok';
        }

        return 'error';
    }

    /*-------------------------------------
    LISTAR MOVIMIENTOS ELIMINADOS
    -------------------------------------*/
    static public function mdlMostrarMovimientoCajaEliminados() {
        $stmt = Conexion::conectar()->prepare(
            'SELECT *
             FROM movimientos
             WHERE movi_fecha_delete IS NOT NULL
             ORDER BY movi_fecha_delete DESC'
        );

        $stmt->execute();
        $respuesta = $stmt->fetchAll();
        $stmt = null;

        return $respuesta;
    }

    /*-------------------------------------
    RESTAURAR MOVIMIENTO
    -------------------------------------*/
    static public function mdlRestaurarMovimientoCaja($idMovimiento) {
        $stmt = Conexion::conectar()->prepare(
            'UPDATE movimientos
             SET movi_fecha_delete = NULL
             WHERE movi_id = :id
               AND movi_fecha_delete IS NOT NULL'
        );
        $stmt->bindParam(':id', $idMovimiento, PDO::PARAM_INT);

        if($stmt->execute() && $stmt->rowCount() > 0){
            return 'ok';
        }

        return 'error';
    }

    /*-------------------------------------
    DEPURAR MOVIMIENTO (ELIMINACION FISICA)
    -------------------------------------*/
    static public function mdlDepurarMovimientoCaja($idMovimiento) {
        $cn = Conexion::conectar();

        try {
            $cn->beginTransaction();

            $stmtMov = $cn->prepare(
                'SELECT movi_id
                 FROM movimientos
                 WHERE movi_id = :id
                   AND movi_fecha_delete IS NOT NULL
                 LIMIT 1
                 FOR UPDATE'
            );
            $stmtMov->bindParam(':id', $idMovimiento, PDO::PARAM_INT);
            $stmtMov->execute();

            if (!$stmtMov->fetch()) {
                $cn->rollBack();
                return 'error';
            }

            $stmtDelDet = $cn->prepare('DELETE FROM detalle_movimiento WHERE deta_movi_movimiento_id = :movimiento_id');
            $stmtDelDet->bindParam(':movimiento_id', $idMovimiento, PDO::PARAM_INT);
            $stmtDelDet->execute();

            $stmtDelMov = $cn->prepare('DELETE FROM movimientos WHERE movi_id = :id AND movi_fecha_delete IS NOT NULL');
            $stmtDelMov->bindParam(':id', $idMovimiento, PDO::PARAM_INT);
            $stmtDelMov->execute();

            $cn->commit();
            return 'ok';
        } catch (Exception $e) {
            if ($cn->inTransaction()) {
                $cn->rollBack();
            }
            return 'error';
        }
    }
}
