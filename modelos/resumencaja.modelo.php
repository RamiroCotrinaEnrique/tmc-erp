<?php

require_once __DIR__ . '/../config/conexion.php';

class ModeloResumenCaja {

    private static function mdlTablaResumenPermitida($tabla) {
        return $tabla === 'resumen_caja';
    }

    private static function mdlColumnaResumenPermitida($columna) {
        $permitidas = array(
            'resc_id',
            'resc_fecha',
            'resc_anio',
            'resc_mes',
            'resc_dia',
            'resc_dni',
            'resc_responsable',
            'resc_observacion'
        );

        return in_array($columna, $permitidas, true);
    }

    private static function mdlAsegurarColumna($cn, $tabla, $columna, $definicion) {
        $stmt = $cn->prepare('SHOW COLUMNS FROM ' . $tabla . ' LIKE :columna');
        $stmt->bindValue(':columna', $columna, PDO::PARAM_STR);
        $stmt->execute();
        $existe = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null;

        if (!$existe) {
            $cn->exec('ALTER TABLE ' . $tabla . ' ADD COLUMN ' . $columna . ' ' . $definicion);
        }
    }

    private static function mdlCrearTablasResumenCajaSiNoExiste($cn) {
        $cn->exec(
            'CREATE TABLE IF NOT EXISTS resumen_caja (
                resc_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
                resc_fecha DATE NOT NULL,
                resc_anio SMALLINT NOT NULL,
                resc_mes TINYINT NOT NULL,
                resc_dia TINYINT NOT NULL,
                resc_dni VARCHAR(20) NOT NULL,
                resc_responsable VARCHAR(180) NOT NULL,
                resc_observacion TEXT NULL,
                resc_saldo_inicial DECIMAL(10,2) NOT NULL DEFAULT 0,
                resc_total_ingresos DECIMAL(10,2) NOT NULL DEFAULT 0,
                resc_total_egresos DECIMAL(10,2) NOT NULL DEFAULT 0,
                resc_saldo_final DECIMAL(10,2) NOT NULL DEFAULT 0,
                resc_total_items INT NOT NULL DEFAULT 0,
                resc_fecha_create TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                resc_fecha_update DATETIME NULL,
                resc_fecha_delete DATETIME NULL,
                PRIMARY KEY (resc_id),
                KEY idx_resumen_caja_fecha (resc_fecha),
                KEY idx_resumen_caja_delete (resc_fecha_delete)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
        );

        $cn->exec(
            'CREATE TABLE IF NOT EXISTS resumen_caja_detalle (
                rescd_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
                rescd_resumen_id INT UNSIGNED NOT NULL,
                rescd_item INT NOT NULL,
                rescd_movimiento_id INT NULL,
                rescd_tipo_movimiento VARCHAR(10) NOT NULL,
                rescd_fecha_documento DATE NOT NULL,
                rescd_responsable VARCHAR(180) NOT NULL,
                rescd_serie VARCHAR(20) NULL,
                rescd_numero VARCHAR(20) NULL,
                rescd_tipo_doc VARCHAR(50) NULL,
                rescd_nro_doc VARCHAR(50) NULL,
                rescd_razon_social VARCHAR(200) NULL,
                rescd_concepto VARCHAR(255) NOT NULL,
                rescd_ingreso DECIMAL(10,2) NOT NULL DEFAULT 0,
                rescd_egreso DECIMAL(10,2) NOT NULL DEFAULT 0,
                PRIMARY KEY (rescd_id),
                KEY idx_resumen_caja_detalle_resumen (rescd_resumen_id),
                CONSTRAINT fk_resumen_caja_detalle_resumen FOREIGN KEY (rescd_resumen_id) REFERENCES resumen_caja(resc_id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
        );

        self::mdlAsegurarColumna($cn, 'detalle_movimiento', 'deta_movi_tipo_doc', 'VARCHAR(50) NULL');
        self::mdlAsegurarColumna($cn, 'detalle_movimiento', 'deta_movi_nro_doc', 'VARCHAR(50) NULL');
        self::mdlAsegurarColumna($cn, 'detalle_movimiento', 'deta_movi_razon_social', 'VARCHAR(200) NULL');

        self::mdlAsegurarColumna($cn, 'resumen_caja_detalle', 'rescd_tipo_doc', 'VARCHAR(50) NULL');
        self::mdlAsegurarColumna($cn, 'resumen_caja_detalle', 'rescd_nro_doc', 'VARCHAR(50) NULL');
        self::mdlAsegurarColumna($cn, 'resumen_caja_detalle', 'rescd_razon_social', 'VARCHAR(200) NULL');
    }

    static public function mdlMostrarResumenCaja($item, $valor) {
        $cn = Conexion::conectar();
        self::mdlCrearTablasResumenCajaSiNoExiste($cn);

        if ($item !== null) {
            if (!self::mdlColumnaResumenPermitida($item)) {
                return false;
            }

            $stmt = $cn->prepare(
                "SELECT *
                 FROM resumen_caja
                 WHERE $item = :valor
                   AND resc_fecha_delete IS NULL
                 LIMIT 1"
            );
            $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
            $stmt->execute();
            $respuesta = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt = $cn->prepare(
                'SELECT *
                 FROM resumen_caja
                 WHERE resc_fecha_delete IS NULL
                 ORDER BY resc_fecha DESC, resc_id DESC'
            );
            $stmt->execute();
            $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        $stmt = null;
        return $respuesta;
    }

    static public function mdlEditarResumenCaja($tabla, $datos) {
        if (!self::mdlTablaResumenPermitida($tabla)) {
            return 'error';
        }

        $cn = Conexion::conectar();
        self::mdlCrearTablasResumenCajaSiNoExiste($cn);

        $stmt = $cn->prepare(
            'UPDATE resumen_caja
             SET resc_dni = :dni,
                 resc_responsable = :responsable,
                 resc_observacion = :observacion,
                 resc_fecha_update = :fecha_update
             WHERE resc_id = :id
               AND resc_fecha_delete IS NULL'
        );

        $stmt->bindValue(':dni', $datos['resc_dni'], PDO::PARAM_STR);
        $stmt->bindValue(':responsable', $datos['resc_responsable'], PDO::PARAM_STR);
        $stmt->bindValue(':observacion', $datos['resc_observacion'], PDO::PARAM_STR);
        $stmt->bindValue(':fecha_update', $datos['resc_fecha_update'], PDO::PARAM_STR);
        $stmt->bindValue(':id', (int) $datos['resc_id'], PDO::PARAM_INT);

        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return 'ok';
        }

        return 'error';
    }

    static public function mdlEliminarResumenCaja($tabla, $id) {
        if (!self::mdlTablaResumenPermitida($tabla)) {
            return 'error';
        }

        $cn = Conexion::conectar();
        self::mdlCrearTablasResumenCajaSiNoExiste($cn);

        $stmt = $cn->prepare(
            'UPDATE resumen_caja
             SET resc_fecha_delete = NOW()
             WHERE resc_id = :id
               AND resc_fecha_delete IS NULL'
        );
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);

        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return 'ok';
        }

        return 'error';
    }

    static public function mdlMostrarResumenesCajaEliminados($tabla) {
        if (!self::mdlTablaResumenPermitida($tabla)) {
            return array();
        }

        $cn = Conexion::conectar();
        self::mdlCrearTablasResumenCajaSiNoExiste($cn);

        $stmt = $cn->prepare(
            'SELECT *
             FROM resumen_caja
             WHERE resc_fecha_delete IS NOT NULL
             ORDER BY resc_fecha_delete DESC'
        );
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function mdlRestaurarResumenCaja($tabla, $id) {
        if (!self::mdlTablaResumenPermitida($tabla)) {
            return 'error';
        }

        $cn = Conexion::conectar();
        self::mdlCrearTablasResumenCajaSiNoExiste($cn);

        $stmt = $cn->prepare(
            'UPDATE resumen_caja
             SET resc_fecha_delete = NULL,
                 resc_fecha_update = NOW()
             WHERE resc_id = :id
               AND resc_fecha_delete IS NOT NULL'
        );
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);

        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return 'ok';
        }

        return 'error';
    }

    static public function mdlDepurarResumenCaja($tabla, $id) {
        if (!self::mdlTablaResumenPermitida($tabla)) {
            return 'error';
        }

        $cn = Conexion::conectar();
        self::mdlCrearTablasResumenCajaSiNoExiste($cn);

        $stmt = $cn->prepare(
            'DELETE FROM resumen_caja
             WHERE resc_id = :id
               AND resc_fecha_delete IS NOT NULL'
        );
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);

        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return 'ok';
        }

        return 'error';
    }

    static public function mdlObtenerResumenCajaPorId($tabla, $id) {
        if (!self::mdlTablaResumenPermitida($tabla)) {
            return false;
        }

        $cn = Conexion::conectar();
        self::mdlCrearTablasResumenCajaSiNoExiste($cn);

        $stmt = $cn->prepare(
            'SELECT *
             FROM resumen_caja
             WHERE resc_id = :id
             LIMIT 1'
        );
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    static public function mdlListarDetallePorFecha($anio, $mes, $dia) {
        $cn = Conexion::conectar();
        self::mdlCrearTablasResumenCajaSiNoExiste($cn);

        $stmt = $cn->prepare(
            'SELECT
                m.movi_id,
                m.movi_tipo,
                m.movi_serie,
                m.movi_numero,
                m.movi_fecha,
                TRIM(CONCAT_WS(" ", e.emple_apellido_paterno, e.emple_apellido_materno, e.emple_nombres)) AS movi_empleado_nombre,
                d.deta_movi_item,
                d.deta_movi_tipo_doc,
                d.deta_movi_nro_doc,
                d.deta_movi_razon_social,
                d.deta_movi_descripcion,
                d.deta_movi_importe
             FROM movimientos m
             INNER JOIN detalle_movimiento d ON d.deta_movi_movimiento_id = m.movi_id
             LEFT JOIN empleados e ON e.emple_id = m.movi_emple_id
             WHERE YEAR(m.movi_fecha) = :anio
               AND MONTH(m.movi_fecha) = :mes
               AND DAY(m.movi_fecha) = :dia
               AND m.movi_fecha_delete IS NULL
             ORDER BY m.movi_numero ASC, d.deta_movi_item ASC'
        );

        $stmt->bindParam(':anio', $anio, PDO::PARAM_INT);
        $stmt->bindParam(':mes', $mes, PDO::PARAM_INT);
        $stmt->bindParam(':dia', $dia, PDO::PARAM_INT);
        $stmt->execute();

        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;

        return $respuesta;
    }

    static public function mdlMostrarDetalleResumenCaja($resumenId) {
        $cn = Conexion::conectar();
        self::mdlCrearTablasResumenCajaSiNoExiste($cn);

        $stmt = $cn->prepare(
            'SELECT *
             FROM resumen_caja_detalle
             WHERE rescd_resumen_id = :resumen_id
             ORDER BY rescd_item ASC'
        );
        $stmt->bindParam(':resumen_id', $resumenId, PDO::PARAM_INT);
        $stmt->execute();

        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;

        return $respuesta;
    }

    static public function mdlObtenerUltimoResumenAntesDeFecha($fecha) {
        $cn = Conexion::conectar();
        self::mdlCrearTablasResumenCajaSiNoExiste($cn);

        $stmt = $cn->prepare(
            'SELECT resc_id, resc_fecha, resc_saldo_final
             FROM resumen_caja
             WHERE resc_fecha < :fecha
               AND resc_fecha_delete IS NULL
             ORDER BY resc_fecha DESC, resc_id DESC
             LIMIT 1'
        );

        $stmt->bindValue(':fecha', $fecha, PDO::PARAM_STR);
        $stmt->execute();

        $respuesta = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null;

        return $respuesta ? $respuesta : array();
    }

    static public function mdlObtenerEstadoFechaCierre($fecha) {
        $resumenActual = self::mdlMostrarResumenCaja('resc_fecha', $fecha);
        $ultimoAnterior = self::mdlObtenerUltimoResumenAntesDeFecha($fecha);

        $saldoSugerido = 0;
        if (!empty($ultimoAnterior) && isset($ultimoAnterior['resc_saldo_final'])) {
            $saldoSugerido = (float) $ultimoAnterior['resc_saldo_final'];
        }

        return array(
            'fecha' => $fecha,
            'cerrado' => !empty($resumenActual),
            'resumen_actual' => $resumenActual ? $resumenActual : array(),
            'saldo_inicial_sugerido' => round($saldoSugerido, 2),
            'cierre_anterior' => !empty($ultimoAnterior) ? $ultimoAnterior : array()
        );
    }

    static public function mdlCrearResumenCajaConDetalle($resumen, $detalle) {
        $cn = Conexion::conectar();

        try {
            self::mdlCrearTablasResumenCajaSiNoExiste($cn);

            $cn->beginTransaction();

            $stmtExiste = $cn->prepare(
                'SELECT resc_id
                 FROM resumen_caja
                 WHERE resc_fecha = :fecha
                   AND resc_fecha_delete IS NULL
                 LIMIT 1
                 FOR UPDATE'
            );
            $stmtExiste->bindParam(':fecha', $resumen['fecha'], PDO::PARAM_STR);
            $stmtExiste->execute();

            if ($stmtExiste->fetch(PDO::FETCH_ASSOC)) {
                $cn->rollBack();
                return array('status' => 'error', 'message' => 'Ya existe un cierre de caja registrado para esa fecha.');
            }

            $stmtResumen = $cn->prepare(
                'INSERT INTO resumen_caja (
                    resc_fecha,
                    resc_anio,
                    resc_mes,
                    resc_dia,
                    resc_dni,
                    resc_responsable,
                    resc_observacion,
                    resc_saldo_inicial,
                    resc_total_ingresos,
                    resc_total_egresos,
                    resc_saldo_final,
                    resc_total_items
                ) VALUES (
                    :fecha,
                    :anio,
                    :mes,
                    :dia,
                    :dni,
                    :responsable,
                    :observacion,
                    :saldo_inicial,
                    :total_ingresos,
                    :total_egresos,
                    :saldo_final,
                    :total_items
                )'
            );

            $stmtResumen->bindValue(':fecha', $resumen['fecha'], PDO::PARAM_STR);
            $stmtResumen->bindValue(':anio', (int) $resumen['anio'], PDO::PARAM_INT);
            $stmtResumen->bindValue(':mes', (int) $resumen['mes'], PDO::PARAM_INT);
            $stmtResumen->bindValue(':dia', (int) $resumen['dia'], PDO::PARAM_INT);
            $stmtResumen->bindValue(':dni', $resumen['dni'], PDO::PARAM_STR);
            $stmtResumen->bindValue(':responsable', $resumen['responsable'], PDO::PARAM_STR);
            $stmtResumen->bindValue(':observacion', $resumen['observacion'], PDO::PARAM_STR);
            $stmtResumen->bindValue(':saldo_inicial', $resumen['saldo_inicial']);
            $stmtResumen->bindValue(':total_ingresos', $resumen['total_ingresos']);
            $stmtResumen->bindValue(':total_egresos', $resumen['total_egresos']);
            $stmtResumen->bindValue(':saldo_final', $resumen['saldo_final']);
            $stmtResumen->bindValue(':total_items', (int) $resumen['total_items'], PDO::PARAM_INT);
            $stmtResumen->execute();

            $resumenId = (int) $cn->lastInsertId();

            $stmtDetalle = $cn->prepare(
                'INSERT INTO resumen_caja_detalle (
                    rescd_resumen_id,
                    rescd_item,
                    rescd_movimiento_id,
                    rescd_tipo_movimiento,
                    rescd_fecha_documento,
                    rescd_responsable,
                    rescd_serie,
                    rescd_numero,
                    rescd_tipo_doc,
                    rescd_nro_doc,
                    rescd_razon_social,
                    rescd_concepto,
                    rescd_ingreso,
                    rescd_egreso
                ) VALUES (
                    :resumen_id,
                    :item,
                    :movimiento_id,
                    :tipo_movimiento,
                    :fecha_documento,
                    :responsable,
                    :serie,
                    :numero,
                    :tipo_doc,
                    :nro_doc,
                    :razon_social,
                    :concepto,
                    :ingreso,
                    :egreso
                )'
            );

            foreach ($detalle as $fila) {
                $movimientoId = isset($fila['movimiento_id']) && $fila['movimiento_id'] ? (int) $fila['movimiento_id'] : null;
                $stmtDetalle->bindValue(':resumen_id', $resumenId, PDO::PARAM_INT);
                $stmtDetalle->bindValue(':item', (int) $fila['item'], PDO::PARAM_INT);
                if ($movimientoId === null) {
                    $stmtDetalle->bindValue(':movimiento_id', null, PDO::PARAM_NULL);
                } else {
                    $stmtDetalle->bindValue(':movimiento_id', $movimientoId, PDO::PARAM_INT);
                }
                $stmtDetalle->bindValue(':tipo_movimiento', $fila['tipo_movimiento'], PDO::PARAM_STR);
                $stmtDetalle->bindValue(':fecha_documento', $fila['fecha_documento'], PDO::PARAM_STR);
                $stmtDetalle->bindValue(':responsable', $fila['responsable'], PDO::PARAM_STR);
                $stmtDetalle->bindValue(':serie', $fila['serie'], PDO::PARAM_STR);
                $stmtDetalle->bindValue(':numero', $fila['numero'], PDO::PARAM_STR);
                $stmtDetalle->bindValue(':tipo_doc', isset($fila['tipo_doc']) ? $fila['tipo_doc'] : '', PDO::PARAM_STR);
                $stmtDetalle->bindValue(':nro_doc', isset($fila['nro_doc']) ? $fila['nro_doc'] : '', PDO::PARAM_STR);
                $stmtDetalle->bindValue(':razon_social', isset($fila['razon_social']) ? $fila['razon_social'] : '', PDO::PARAM_STR);
                $stmtDetalle->bindValue(':concepto', $fila['concepto'], PDO::PARAM_STR);
                $stmtDetalle->bindValue(':ingreso', $fila['ingreso']);
                $stmtDetalle->bindValue(':egreso', $fila['egreso']);
                $stmtDetalle->execute();
            }

            $cn->commit();
            return array('status' => 'ok', 'resumen_id' => $resumenId);
        } catch (Exception $e) {
            if ($cn->inTransaction()) {
                $cn->rollBack();
            }

            return array('status' => 'error', 'message' => 'Error al guardar el cierre de caja: ' . $e->getMessage());
        }
    }
}