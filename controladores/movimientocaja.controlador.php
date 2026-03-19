<?php

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

        $respuesta = ModeloMovimientoCaja::mdlEditarMovimientoCaja($datos, $detalles);

        if ($respuesta === 'ok') {
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

        $respuesta = ModeloMovimientoCaja::mdlEliminarMovimientoCaja($idMovimiento);

        if ($respuesta === 'ok') {
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

        $respuesta = ModeloMovimientoCaja::mdlRestaurarMovimientoCaja($idMovimiento);
        if ($respuesta === 'ok') {
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

        $respuesta = ModeloMovimientoCaja::mdlDepurarMovimientoCaja($idMovimiento);
        if ($respuesta === 'ok') {
            return array('status' => 'ok');
        }

        return array('status' => 'error', 'message' => 'No se pudo eliminar definitivamente el movimiento.');
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
