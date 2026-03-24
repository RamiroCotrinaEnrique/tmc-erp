<?php

require_once __DIR__ . '/../config/conexion.php';

class ModeloAuditoria {

    private static function mdlCrearTablaAuditoriaGeneralSiNoExiste($cn) {
        $cn->exec(
            "CREATE TABLE IF NOT EXISTS auditoria_general (
                aud_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                aud_modulo VARCHAR(80) NOT NULL,
                aud_entidad_tabla VARCHAR(80) NOT NULL,
                aud_entidad_id VARCHAR(80) NOT NULL,
                aud_accion VARCHAR(20) NOT NULL,
                aud_usuario_id INT NULL,
                aud_ip_origen VARCHAR(45) NULL,
                aud_detalle_json LONGTEXT NULL,
                aud_fecha_evento TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (aud_id),
                KEY idx_aud_modulo (aud_modulo),
                KEY idx_aud_tabla (aud_entidad_tabla),
                KEY idx_aud_entidad (aud_entidad_id),
                KEY idx_aud_accion (aud_accion),
                KEY idx_aud_usuario (aud_usuario_id),
                KEY idx_aud_fecha (aud_fecha_evento)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
        );
    }

    static public function mdlRegistrarAuditoriaGeneral($modulo, $entidadTabla, $entidadId, $accion, $usuarioId, $detalleArray = null) {
        $cn = Conexion::conectar();
        self::mdlCrearTablaAuditoriaGeneralSiNoExiste($cn);

        $ipOrigen = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
        $detalleJson = null;
        if ($detalleArray !== null) {
            $json = json_encode($detalleArray, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            $detalleJson = $json !== false ? $json : null;
        }

        $stmt = $cn->prepare(
            'INSERT INTO auditoria_general (
                aud_modulo,
                aud_entidad_tabla,
                aud_entidad_id,
                aud_accion,
                aud_usuario_id,
                aud_ip_origen,
                aud_detalle_json
            ) VALUES (
                :modulo,
                :entidad_tabla,
                :entidad_id,
                :accion,
                :usuario_id,
                :ip_origen,
                :detalle_json
            )'
        );

        $stmt->bindParam(':modulo', $modulo, PDO::PARAM_STR);
        $stmt->bindParam(':entidad_tabla', $entidadTabla, PDO::PARAM_STR);
        $stmt->bindParam(':entidad_id', $entidadId, PDO::PARAM_STR);
        $stmt->bindParam(':accion', $accion, PDO::PARAM_STR);
        if ($usuarioId === null) {
            $stmt->bindValue(':usuario_id', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':usuario_id', (int) $usuarioId, PDO::PARAM_INT);
        }
        $stmt->bindParam(':ip_origen', $ipOrigen, PDO::PARAM_STR);
        $stmt->bindParam(':detalle_json', $detalleJson, PDO::PARAM_STR);

        return (bool) $stmt->execute();
    }

    static public function mdlMostrarAuditoriaGeneral($modulo = null, $limit = 200) {
        $cn = Conexion::conectar();
        self::mdlCrearTablaAuditoriaGeneralSiNoExiste($cn);

        $limit = (int) $limit;
        if ($limit <= 0) {
            $limit = 200;
        }
        if ($limit > 1000) {
            $limit = 1000;
        }

        $sql =
            'SELECT a.*, u.usu_nombre, u.usu_usuario
             FROM auditoria_general a
             LEFT JOIN usuarios u ON u.usu_id = a.aud_usuario_id';

        if ($modulo !== null) {
            $sql .= ' WHERE a.aud_modulo = :modulo';
        }

        $sql .= ' ORDER BY a.aud_id DESC LIMIT ' . $limit;

        $stmt = $cn->prepare($sql);

        if ($modulo !== null) {
            $stmt->bindParam(':modulo', $modulo, PDO::PARAM_STR);
        }

        $stmt->execute();
        $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;

        return $respuesta;
    }
}
