<?php

require_once __DIR__ . '/../modelos/auditoria.modelo.php';

class ControladorMovimientoCaja {

    /*-------------------------------------
    LISTAR MOVIMIENTOS DE CAJA
    -------------------------------------*/
    static public function ctrMostrarMovimientoCaja($item, $valor) {
        $tabla = 'movimientos';
        return ModeloMovimientoCaja::mdlMostrarMovimientoCaja($tabla, $item, $valor);
    }

    /*-------------------------------------
    LISTAR SERIES CONFIGURADAS
    -------------------------------------*/
    static public function ctrListarSeriesConfiguradas($tipo, $moneda) {
        return ModeloMovimientoCaja::mdlListarSeriesConfiguradas($tipo, $moneda);
    }

    /*-------------------------------------
    LISTAR DETALLE DE MOVIMIENTO
    -------------------------------------*/
    static public function ctrMostrarDetalleMovimiento($movimientoId) {
        return ModeloMovimientoCaja::mdlMostrarDetalleMovimiento($movimientoId);
    }

    static public function ctrMostrarMovimientoCajaEliminados() {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array();
        }

        return ModeloMovimientoCaja::mdlMostrarMovimientoCajaEliminados();
    }

    static public function ctrMostrarAuditoriaMovimientoCaja($limit = 200) {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array();
        }

        return ModeloAuditoria::mdlMostrarAuditoriaGeneral('movimiento-caja', (int) $limit);
    }

    /*-------------------------------------
    CREAR MOVIMIENTO DE CAJA + DETALLE
    -------------------------------------*/
    public static function ctrCrearMovimientoCaja() {

        if (!isset($_POST['inputTipo']) || !isset($_POST['inputSerie']) || !isset($_POST['inputMoneda']) || !isset($_POST['inputEmpleado']) || !isset($_POST['fecha'])) {
            return;
        }

        $tipo = trim($_POST['inputTipo']);
        $serie = trim($_POST['inputSerie']);
        $moneda = trim($_POST['inputMoneda']);
        $fecha = trim($_POST['fecha']);
        $empleado = (int) $_POST['inputEmpleado'];

        $tiposPermitidos = array('INGRESO', 'EGRESO');
        $monedasPermitidas = array('SOLES', 'DOLARES');

        if ($tipo === '' || $serie === '' || $moneda === '' || $fecha === '' || $empleado <= 0) {
            self::mostrarAlerta('error', 'Complete los datos obligatorios del movimiento.', 'movimiento-caja');
            return;
        }

        if (!in_array($tipo, $tiposPermitidos, true)) {
            self::mostrarAlerta('error', 'El tipo de movimiento seleccionado no es valido.', 'movimiento-caja');
            return;
        }

        if (!preg_match('/^\d{3}$/', $serie)) {
            self::mostrarAlerta('error', 'La serie del movimiento no es valida.', 'movimiento-caja');
            return;
        }

        if (!in_array($moneda, $monedasPermitidas, true)) {
            self::mostrarAlerta('error', 'La moneda seleccionada no es valida.', 'movimiento-caja');
            return;
        }

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
            self::mostrarAlerta('error', 'La fecha del movimiento no es valida.', 'movimiento-caja');
            return;
        }

        $descripciones = isset($_POST['detalle_descripcion']) && is_array($_POST['detalle_descripcion']) ? $_POST['detalle_descripcion'] : array();
        $importes = isset($_POST['detalle_importe']) && is_array($_POST['detalle_importe']) ? $_POST['detalle_importe'] : array();

        $detalles = array();
        $cantidad = min(count($descripciones), count($importes));

        for ($i = 0; $i < $cantidad; $i++) {
            $descripcion = trim((string) $descripciones[$i]);
            $importe = (float) str_replace(',', '.', (string) $importes[$i]);

            if ($descripcion === '') {
                continue;
            }

            if ($importe <= 0) {
                self::mostrarAlerta('error', 'El importe de cada detalle debe ser mayor a cero.', 'movimiento-caja');
                return;
            }

            $detalles[] = array(
                'descripcion' => $descripcion,
                'importe' => round($importe, 2)
            );
        }

        if (empty($detalles)) {
            self::mostrarAlerta('error', 'Debe agregar al menos un detalle para registrar el movimiento.', 'movimiento-caja');
            return;
        }

        $cabecera = array(
            'tipo' => $tipo,
            'serie' => $serie,
            'moneda' => $moneda,
            'fecha' => $fecha,
            'empleado' => $empleado
        );

        $respuesta = ModeloMovimientoCaja::mdlCrearMovimientoCajaConDetalle($cabecera, $detalles);

        if (isset($respuesta['status']) && $respuesta['status'] === 'ok') {
            $movimientoCreado = ModeloMovimientoCaja::mdlObtenerMovimientoCajaPorId((int) $respuesta['movi_id']);
            $detalleCreado = ModeloMovimientoCaja::mdlMostrarDetalleMovimiento((int) $respuesta['movi_id']);
            self::registrarAuditoriaMovimientoCaja(
                'CREAR',
                (int) $respuesta['movi_id'],
                null,
                array(
                    'movimiento' => $movimientoCreado,
                    'detalle' => $detalleCreado
                )
            );

            self::mostrarAlerta('success', 'Movimiento guardado correctamente. Nro: ' . $respuesta['movi_numero'], 'movimiento-caja');
        } else {
            $mensaje = isset($respuesta['message']) ? $respuesta['message'] : 'No se pudo guardar el movimiento.';
            self::mostrarAlerta('error', $mensaje, 'movimiento-caja');
        }
    }

    /*-------------------------------------
    EDITAR MOVIMIENTO DE CAJA (CABECERA)
    -------------------------------------*/
    public static function ctrEditarMovimientoCaja() {

        if (!isset($_POST['inputEditId']) || !isset($_POST['inputEditFecha']) || !isset($_POST['inputEditEmpleado'])) {
            return;
        }

        $id = (int) $_POST['inputEditId'];
        $fecha = trim($_POST['inputEditFecha']);
        $empleado = (int) $_POST['inputEditEmpleado'];

        if ($id <= 0 || $fecha === '' || $empleado <= 0) {
            self::mostrarAlerta('error', 'Complete los datos obligatorios para editar el movimiento.', 'movimiento-caja');
            return;
        }

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
            self::mostrarAlerta('error', 'La fecha del movimiento no es valida.', 'movimiento-caja');
            return;
        }

        $descripciones = isset($_POST['inputEditDetalleDescripcion']) && is_array($_POST['inputEditDetalleDescripcion']) ? $_POST['inputEditDetalleDescripcion'] : array();
        $importes = isset($_POST['inputEditDetalleImporte']) && is_array($_POST['inputEditDetalleImporte']) ? $_POST['inputEditDetalleImporte'] : array();

        $detalles = array();
        $cantidad = min(count($descripciones), count($importes));

        for ($i = 0; $i < $cantidad; $i++) {
            $descripcion = trim((string) $descripciones[$i]);
            $importe = (float) str_replace(',', '.', (string) $importes[$i]);

            if ($descripcion === '') {
                continue;
            }

            if ($importe <= 0) {
                self::mostrarAlerta('error', 'El importe de cada detalle debe ser mayor a cero.', 'movimiento-caja');
                return;
            }

            $detalles[] = array(
                'descripcion' => $descripcion,
                'importe' => round($importe, 2)
            );
        }

        if (empty($detalles)) {
            self::mostrarAlerta('error', 'Debe registrar al menos un detalle en la edicion.', 'movimiento-caja');
            return;
        }

        $datos = array(
            'movi_id'       => $id,
            'movi_fecha'    => $fecha,
            'movi_emple_id' => $empleado
        );

        $movimientoAntes = ModeloMovimientoCaja::mdlObtenerMovimientoCajaPorId($id);
        $detalleAntes = ModeloMovimientoCaja::mdlMostrarDetalleMovimiento($id);

        $respuesta = ModeloMovimientoCaja::mdlEditarMovimientoCaja($datos, $detalles);

        if ($respuesta === 'ok') {
            $movimientoDespues = ModeloMovimientoCaja::mdlObtenerMovimientoCajaPorId($id);
            $detalleDespues = ModeloMovimientoCaja::mdlMostrarDetalleMovimiento($id);

            self::registrarAuditoriaMovimientoCaja(
                'EDITAR',
                $id,
                array(
                    'movimiento' => $movimientoAntes,
                    'detalle' => $detalleAntes
                ),
                array(
                    'movimiento' => $movimientoDespues,
                    'detalle' => $detalleDespues
                )
            );

            self::mostrarAlerta('success', 'Movimiento actualizado correctamente.', 'movimiento-caja');
        } else {
            self::mostrarAlerta('error', 'No se pudo actualizar el movimiento.', 'movimiento-caja');
        }
    }

    /*-------------------------------------
    ELIMINAR MOVIMIENTO DE CAJA
    -------------------------------------*/
    public static function ctrEliminarMovimientoCaja() {

        if (!isset($_GET['idMovimientoCaja'])) {
            return;
        }

        $idMovimiento = (int) $_GET['idMovimientoCaja'];

        if ($idMovimiento <= 0) {
            self::mostrarAlerta('error', 'Identificador de movimiento invalido.', 'movimiento-caja');
            return;
        }

        $movimientoAntes = ModeloMovimientoCaja::mdlObtenerMovimientoCajaPorId($idMovimiento);
        $detalleAntes = ModeloMovimientoCaja::mdlMostrarDetalleMovimiento($idMovimiento);

        $respuesta = ModeloMovimientoCaja::mdlEliminarMovimientoCaja($idMovimiento);

        if ($respuesta === 'ok') {
            $movimientoDespues = ModeloMovimientoCaja::mdlObtenerMovimientoCajaPorId($idMovimiento);
            self::registrarAuditoriaMovimientoCaja(
                'ELIMINAR',
                $idMovimiento,
                array(
                    'movimiento' => $movimientoAntes,
                    'detalle' => $detalleAntes
                ),
                array(
                    'movimiento' => $movimientoDespues
                )
            );

            self::mostrarAlerta('success', 'Movimiento enviado a papelera correctamente.', 'movimiento-caja');
        } else {
            self::mostrarAlerta('error', 'No se pudo eliminar el movimiento o ya estaba eliminado.', 'movimiento-caja');
        }
    }

    public static function ctrRestaurarMovimientoCaja($idMovimiento) {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array('status' => 'error', 'message' => 'Solo los administradores pueden restaurar movimientos.');
        }

        $idMovimiento = (int) $idMovimiento;
        if ($idMovimiento <= 0) {
            return array('status' => 'error', 'message' => 'Identificador de movimiento invalido.');
        }

        $movimientoAntes = ModeloMovimientoCaja::mdlObtenerMovimientoCajaPorId($idMovimiento);
        $detalleAntes = ModeloMovimientoCaja::mdlMostrarDetalleMovimiento($idMovimiento);

        $respuesta = ModeloMovimientoCaja::mdlRestaurarMovimientoCaja($idMovimiento);
        if ($respuesta === 'ok') {
            $movimientoDespues = ModeloMovimientoCaja::mdlObtenerMovimientoCajaPorId($idMovimiento);
            self::registrarAuditoriaMovimientoCaja(
                'RESTAURAR',
                $idMovimiento,
                array(
                    'movimiento' => $movimientoAntes,
                    'detalle' => $detalleAntes
                ),
                array(
                    'movimiento' => $movimientoDespues,
                    'detalle' => $detalleAntes
                )
            );

            return array('status' => 'ok');
        }

        return array('status' => 'error', 'message' => 'No se pudo restaurar el movimiento o ya estaba activo.');
    }

    public static function ctrDepurarMovimientoCaja($idMovimiento) {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array('status' => 'error', 'message' => 'Solo los administradores pueden eliminar movimientos definitivamente.');
        }

        $idMovimiento = (int) $idMovimiento;
        if ($idMovimiento <= 0) {
            return array('status' => 'error', 'message' => 'Identificador de movimiento invalido.');
        }

        $movimientoAntes = ModeloMovimientoCaja::mdlObtenerMovimientoCajaPorId($idMovimiento);
        $detalleAntes = ModeloMovimientoCaja::mdlMostrarDetalleMovimiento($idMovimiento);

        $respuesta = ModeloMovimientoCaja::mdlDepurarMovimientoCaja($idMovimiento);
        if ($respuesta === 'ok') {
            self::registrarAuditoriaMovimientoCaja(
                'DEPURAR',
                $idMovimiento,
                array(
                    'movimiento' => $movimientoAntes,
                    'detalle' => $detalleAntes
                ),
                null
            );

            return array('status' => 'ok');
        }

        return array('status' => 'error', 'message' => 'No se pudo eliminar definitivamente el movimiento.');
    }

    private static function registrarAuditoriaMovimientoCaja($accion, $entidadId, $antes = null, $despues = null) {
        $usuarioActor = isset($_SESSION['usu_id']) ? (int) $_SESSION['usu_id'] : null;

        $detalle = array(
            'antes' => $antes,
            'despues' => $despues,
            'campos_cambiados' => self::obtenerCamposCambiadosMovimiento($antes, $despues)
        );

        ModeloAuditoria::mdlRegistrarAuditoriaGeneral(
            'movimiento-caja',
            'movimientos',
            (string) $entidadId,
            $accion,
            $usuarioActor,
            $detalle
        );
    }

    private static function obtenerCamposCambiadosMovimiento($antes, $despues) {
        if (!is_array($antes) || !is_array($despues)) {
            return array();
        }

        $movAntes = isset($antes['movimiento']) && is_array($antes['movimiento']) ? $antes['movimiento'] : array();
        $movDesp = isset($despues['movimiento']) && is_array($despues['movimiento']) ? $despues['movimiento'] : array();

        $campos = array();
        foreach ($movDesp as $key => $valueDespues) {
            $valueAntes = array_key_exists($key, $movAntes) ? $movAntes[$key] : null;
            if ((string) $valueAntes !== (string) $valueDespues) {
                $campos[$key] = array('antes' => $valueAntes, 'despues' => $valueDespues);
            }
        }

        $detAntes = isset($antes['detalle']) && is_array($antes['detalle']) ? $antes['detalle'] : array();
        $detDesp = isset($despues['detalle']) && is_array($despues['detalle']) ? $despues['detalle'] : array();
        if (json_encode($detAntes) !== json_encode($detDesp)) {
            $campos['detalle'] = array('antes' => $detAntes, 'despues' => $detDesp);
        }

        return $campos;
    }
    

    private static function mostrarAlerta($tipo, $mensaje, $redireccion) {
        echo '<script>
            swal({
                type: "' . $tipo . '",
                title: "' . $mensaje . '",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
            }).then(function(result){
                if (result.value) {
                    window.location = "' . $redireccion . '";
                }
            });
        </script>';
    }
}
