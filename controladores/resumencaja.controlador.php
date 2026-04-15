<?php

require_once __DIR__ . '/../modelos/auditoria.modelo.php';

class ControladorResumenCaja {

    static public function ctrMostrarResumenCaja($item, $valor) {
        return ModeloResumenCaja::mdlMostrarResumenCaja($item, $valor);
    }

    static public function ctrListarDetallePorFecha($anio, $mes, $dia) {
        $anio = (int) $anio;
        $mes = (int) $mes;
        $dia = (int) $dia;

        if ($anio < 2000 || $anio > 2100) {
            return array();
        }

        if ($mes < 1 || $mes > 12) {
            return array();
        }

        if ($dia < 1 || $dia > 31) {
            return array();
        }

        return ModeloResumenCaja::mdlListarDetallePorFecha($anio, $mes, $dia);
    }

    static public function ctrMostrarDetalleResumenCaja($resumenId) {
        $resumenId = (int) $resumenId;
        if ($resumenId <= 0) {
            return array();
        }

        return ModeloResumenCaja::mdlMostrarDetalleResumenCaja($resumenId);
    }

    static public function ctrObtenerEstadoFechaCierre($anio, $mes, $dia) {
        $anio = (int) $anio;
        $mes = (int) $mes;
        $dia = (int) $dia;

        if ($anio < 2000 || $anio > 2100 || $mes < 1 || $mes > 12 || $dia < 1 || $dia > 31) {
            return array(
                'valido' => false,
                'mensaje' => 'La fecha del cierre no es valida.'
            );
        }

        if (!checkdate($mes, $dia, $anio)) {
            return array(
                'valido' => false,
                'mensaje' => 'La fecha del cierre no es valida.'
            );
        }

        $fecha = sprintf('%04d-%02d-%02d', $anio, $mes, $dia);
        $estado = ModeloResumenCaja::mdlObtenerEstadoFechaCierre($fecha);
        $estado['valido'] = true;

        if (!empty($estado['cerrado'])) {
            $saldoFinal = isset($estado['resumen_actual']['resc_saldo_final']) ? (float) $estado['resumen_actual']['resc_saldo_final'] : 0;
            $estado['mensaje'] = 'Ya existe un cierre registrado para la fecha ' . $fecha . '. Saldo final: S/ ' . number_format($saldoFinal, 2);
        } else {
            $estado['mensaje'] = '';
        }

        return $estado;
    }

    static public function ctrCrearResumenCaja() {
        if (!isset($_POST['nuevoAnioResumen']) || !isset($_POST['nuevoMesResumen']) || !isset($_POST['nuevoDia'])) {
            return;
        }

        $anio = (int) $_POST['nuevoAnioResumen'];
        $mes = (int) $_POST['nuevoMesResumen'];
        $dia = (int) $_POST['nuevoDia'];
        $dni = trim((string) $_POST['nuevoDNI']);
        $responsable = trim((string) $_POST['nuevaApellidosNombres']);
        $observacion = trim((string) $_POST['nuevaObservacion']);
        $saldoInicial = isset($_POST['inputSaldoFondoFijo']) ? (float) $_POST['inputSaldoFondoFijo'] : 0;

        if ($anio < 2000 || $anio > 2100 || $mes < 1 || $mes > 12 || $dia < 1 || $dia > 31) {
            self::mostrarAlerta('error', 'La fecha del cierre no es valida.', 'resumen-caja');
            return;
        }

        if (!checkdate($mes, $dia, $anio)) {
            self::mostrarAlerta('error', 'La fecha del cierre no es valida.', 'resumen-caja');
            return;
        }

        if ($dni === '' || $responsable === '') {
            self::mostrarAlerta('error', 'Complete los datos del responsable del cierre.', 'resumen-caja');
            return;
        }

        if ($saldoInicial < 0) {
            self::mostrarAlerta('error', 'El saldo inicial no puede ser negativo.', 'resumen-caja');
            return;
        }

        $fecha = sprintf('%04d-%02d-%02d', $anio, $mes, $dia);

        $detalleMovimientos = self::ctrListarDetallePorFecha($anio, $mes, $dia);
        if (empty($detalleMovimientos)) {
            self::mostrarAlerta('error', 'No existen movimientos para generar el cierre en la fecha seleccionada.', 'resumen-caja');
            return;
        }

        $totalIngresos = 0;
        $totalEgresos = 0;
        $detalleResumen = array();

        foreach ($detalleMovimientos as $index => $item) {
            $importe = isset($item['deta_movi_importe']) ? round((float) $item['deta_movi_importe'], 2) : 0;
            $tipo = isset($item['movi_tipo']) ? strtoupper((string) $item['movi_tipo']) : '';
            $ingreso = 0;
            $egreso = 0;

            if ($tipo === 'INGRESO') {
                $ingreso = $importe;
                $totalIngresos += $importe;
            } else {
                $egreso = $importe;
                $totalEgresos += $importe;
            }

            $detalleResumen[] = array(
                'item' => $index + 1,
                'movimiento_id' => isset($item['movi_id']) ? (int) $item['movi_id'] : null,
                'tipo_movimiento' => $tipo,
                'fecha_documento' => isset($item['movi_fecha']) ? $item['movi_fecha'] : $fecha,
                'responsable' => isset($item['movi_empleado_nombre']) ? trim((string) $item['movi_empleado_nombre']) : '',
                'serie' => isset($item['movi_serie']) ? (string) $item['movi_serie'] : '',
                'numero' => isset($item['movi_numero']) ? (string) $item['movi_numero'] : '',
                'tipo_doc' => isset($item['deta_movi_tipo_doc']) ? trim((string) $item['deta_movi_tipo_doc']) : '',
                'nro_doc' => isset($item['deta_movi_nro_doc']) ? trim((string) $item['deta_movi_nro_doc']) : '',
                'razon_social' => isset($item['deta_movi_razon_social']) ? trim((string) $item['deta_movi_razon_social']) : '',
                'concepto' => isset($item['deta_movi_descripcion']) ? (string) $item['deta_movi_descripcion'] : '',
                'ingreso' => $ingreso,
                'egreso' => $egreso
            );
        }

        $datosResumen = array(
            'fecha' => $fecha,
            'anio' => $anio,
            'mes' => $mes,
            'dia' => $dia,
            'dni' => $dni,
            'responsable' => $responsable,
            'observacion' => $observacion,
            'saldo_inicial' => round($saldoInicial, 2),
            'total_ingresos' => round($totalIngresos, 2),
            'total_egresos' => round($totalEgresos, 2),
            'saldo_final' => round($saldoInicial + $totalIngresos - $totalEgresos, 2),
            'total_items' => count($detalleResumen)
        );

        $respuesta = ModeloResumenCaja::mdlCrearResumenCajaConDetalle($datosResumen, $detalleResumen);

        if (isset($respuesta['status']) && $respuesta['status'] === 'ok') {
            $resumenCreado = ModeloResumenCaja::mdlMostrarResumenCaja('resc_id', (int) $respuesta['resumen_id']);
            self::registrarAuditoriaResumenCaja('CREAR', (string) $respuesta['resumen_id'], null, $resumenCreado ?: $datosResumen);
            self::mostrarAlerta('success', 'Cierre de caja registrado correctamente.', 'resumen-caja');
            return;
        }

        $mensaje = isset($respuesta['message']) ? $respuesta['message'] : 'No se pudo registrar el cierre de caja.';
        self::mostrarAlerta('error', $mensaje, 'resumen-caja');
    }

    static public function ctrEditarResumenCaja() {
        if (!isset($_POST['inputEditResumenCajaId'])) {
            return;
        }

        $idResumen = (int) $_POST['inputEditResumenCajaId'];
        $dni = trim((string) $_POST['inputEditDniResumenCaja']);
        $responsable = trim((string) $_POST['inputEditResponsableResumenCaja']);
        $observacion = trim((string) $_POST['inputEditObservacionResumenCaja']);

        if ($idResumen <= 0) {
            self::mostrarAlerta('error', 'El cierre seleccionado no es valido.', 'resumen-caja');
            return;
        }

        if ($dni === '' || $responsable === '') {
            self::mostrarAlerta('error', 'DNI y responsable son obligatorios.', 'resumen-caja');
            return;
        }

        if (!preg_match('/^[0-9]{8,20}$/', $dni)) {
            self::mostrarAlerta('error', 'El DNI debe contener solo numeros.', 'resumen-caja');
            return;
        }

        date_default_timezone_set('America/Lima');
        $fechaActual = date('Y-m-d H:i:s');

        $datos = array(
            'resc_id' => $idResumen,
            'resc_dni' => $dni,
            'resc_responsable' => $responsable,
            'resc_observacion' => $observacion,
            'resc_fecha_update' => $fechaActual
        );

        $antes = ModeloResumenCaja::mdlMostrarResumenCaja('resc_id', $idResumen);
        $respuesta = ModeloResumenCaja::mdlEditarResumenCaja('resumen_caja', $datos);

        if ($respuesta === 'ok') {
            $despues = ModeloResumenCaja::mdlMostrarResumenCaja('resc_id', $idResumen);
            self::registrarAuditoriaResumenCaja('EDITAR', (string) $idResumen, $antes ?: null, $despues ?: $datos);
            self::mostrarAlerta('success', 'Cierre de caja actualizado correctamente.', 'resumen-caja');
            return;
        }

        self::mostrarAlerta('error', 'No se pudo actualizar el cierre de caja.', 'resumen-caja');
    }

    static public function ctrEliminarResumenCaja() {
        if (!isset($_GET['idResumenCaja'])) {
            return;
        }

        $idResumen = (int) $_GET['idResumenCaja'];
        if ($idResumen <= 0) {
            self::mostrarAlerta('error', 'El cierre seleccionado no es valido.', 'resumen-caja');
            return;
        }

        $antes = ModeloResumenCaja::mdlMostrarResumenCaja('resc_id', $idResumen);
        $respuesta = ModeloResumenCaja::mdlEliminarResumenCaja('resumen_caja', $idResumen);

        if ($respuesta === 'ok') {
            self::registrarAuditoriaResumenCaja('ELIMINAR', (string) $idResumen, $antes ?: null, null);
            self::mostrarAlerta('success', 'El cierre fue enviado a la papelera.', 'resumen-caja');
            return;
        }

        self::mostrarAlerta('error', 'No se pudo eliminar el cierre o ya estaba eliminado.', 'resumen-caja');
    }

    static public function ctrMostrarResumenesCajaEliminados() {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array();
        }

        return ModeloResumenCaja::mdlMostrarResumenesCajaEliminados('resumen_caja');
    }

    static public function ctrRestaurarResumenCaja($id) {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array(
                'status' => 'error',
                'message' => 'Solo los administradores pueden restaurar cierres.'
            );
        }

        $idResumen = (int) $id;
        if ($idResumen <= 0) {
            return array(
                'status' => 'error',
                'message' => 'ID invalido.'
            );
        }

        $antes = ModeloResumenCaja::mdlObtenerResumenCajaPorId('resumen_caja', $idResumen);
        $respuesta = ModeloResumenCaja::mdlRestaurarResumenCaja('resumen_caja', $idResumen);

        if ($respuesta === 'ok') {
            $despues = ModeloResumenCaja::mdlMostrarResumenCaja('resc_id', $idResumen);
            self::registrarAuditoriaResumenCaja('RESTAURAR', (string) $idResumen, $antes ?: null, $despues ?: null);
            return array('status' => 'ok');
        }

        return array(
            'status' => 'error',
            'message' => 'No se pudo restaurar el cierre.'
        );
    }

    static public function ctrDepurarResumenCaja($id) {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array(
                'status' => 'error',
                'message' => 'Solo los administradores pueden depurar cierres.'
            );
        }

        $idResumen = (int) $id;
        if ($idResumen <= 0) {
            return array(
                'status' => 'error',
                'message' => 'ID invalido.'
            );
        }

        $antes = ModeloResumenCaja::mdlObtenerResumenCajaPorId('resumen_caja', $idResumen);
        if (!$antes || empty($antes['resc_fecha_delete'])) {
            return array(
                'status' => 'error',
                'message' => 'El cierre debe estar en papelera para depurarlo.'
            );
        }

        $respuesta = ModeloResumenCaja::mdlDepurarResumenCaja('resumen_caja', $idResumen);

        if ($respuesta === 'ok') {
            self::registrarAuditoriaResumenCaja('DEPURAR', (string) $idResumen, $antes, null);
            return array('status' => 'ok');
        }

        return array(
            'status' => 'error',
            'message' => 'No se pudo depurar el cierre.'
        );
    }

    static public function ctrMostrarAuditoriaResumenCaja($limit = 200) {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array();
        }

        return ModeloAuditoria::mdlMostrarAuditoriaGeneral('resumen-caja', (int) $limit);
    }

    private static function registrarAuditoriaResumenCaja($accion, $entidadId, $antes = null, $despues = null) {
        $usuarioActor = isset($_SESSION['usu_id']) ? (int) $_SESSION['usu_id'] : null;

        $camposCambiados = array();
        if (is_array($antes) && is_array($despues)) {
            $camposAuditar = array(
                'resc_fecha',
                'resc_dni',
                'resc_responsable',
                'resc_observacion',
                'resc_saldo_inicial',
                'resc_total_ingresos',
                'resc_total_egresos',
                'resc_saldo_final',
                'resc_total_items'
            );

            foreach ($camposAuditar as $key) {
                $valueAntes = array_key_exists($key, $antes) ? $antes[$key] : null;
                $valueDespues = array_key_exists($key, $despues) ? $despues[$key] : null;
                if ((string) $valueAntes !== (string) $valueDespues) {
                    $camposCambiados[$key] = array('antes' => $valueAntes, 'despues' => $valueDespues);
                }
            }
        }

        ModeloAuditoria::mdlRegistrarAuditoriaGeneral(
            'resumen-caja',
            'resumen_caja',
            $entidadId,
            $accion,
            $usuarioActor,
            array('antes' => $antes, 'despues' => $despues, 'campos_cambiados' => $camposCambiados)
        );
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