<?php

require_once __DIR__ . '/../modelos/auditoria.modelo.php';

class ControladorHojaLiquidacion {

    static public function ctrObtenerSiguienteNumeroRegistro() {
        $tabla = 'hoja_liquidacion';
        return ModeloHojaLiquidacion::mdlObtenerSiguienteNumeroRegistro($tabla);
    }

    static public function ctrMostrarHojasLiquidacion($item, $valor) {
        $tabla = 'hoja_liquidacion';
        return ModeloHojaLiquidacion::mdlMostrarHojasLiquidacion($tabla, $item, $valor);
    }

    public static function ctrCrearHojaLiquidacion() {
        if (!isset($_POST['nuevaFechaSalida'])) {
            return;
        }

        $tabla = 'hoja_liquidacion';
        $numeroRegistro = trim($_POST['inputNumeroRegistro'] ?? '');
        if ($numeroRegistro === '' || strtoupper($numeroRegistro) === 'AUTOMATICO') {
            $numeroRegistro = self::ctrObtenerSiguienteNumeroRegistro();
        }

        $montoRecibido = (float) trim($_POST['inputMontoRecibido']);
        $peaje = (float) trim($_POST['inputPeaje']);
        $boletasVarias = (float) trim($_POST['inputBoletasVarias']);
        $boletasConsumo = (float) trim($_POST['inputBoletasConsumo']);
        $planillaMovilidad = (float) trim($_POST['inputPlanillaMovilidad']);
        $facturasVarios = (float) trim($_POST['inputFacturasVarios']);
        $cargaDescargaLadrillo = (float) trim($_POST['inputCargaDescargaLadrillo']);

        $sumaTotal = $peaje + $boletasVarias + $boletasConsumo + $planillaMovilidad + $facturasVarios + $cargaDescargaLadrillo;
        $diferencia = $montoRecibido - $sumaTotal;
        $vuelto = $diferencia >= 0 ? $diferencia : 0;
        $reintegro = $diferencia < 0 ? abs($diferencia) : 0;

        $datos = array(
            'hoja_numero_registro' => $numeroRegistro,
            'hoja_fecha_salida' => trim($_POST['nuevaFechaSalida']),
            'hoja_fecha_llegada' => trim($_POST['nuevaFechaLlegada']),
            'hoja_vehic_tracto_id' => trim($_POST['inputPlaca']),
            'hoja_vehic_tolva_id' => trim($_POST['inputTolva']),
            'hoja_operacion' => trim($_POST['inputOperacion']),
            'hoja_monto_recibido' => $montoRecibido,
            'hoja_empleado_id' => trim($_POST['inputEmpleado']),
            'hoja_grr_producto' => trim($_POST['inputGRRProducto']),
            'hoja_producto' => trim($_POST['inputProducto']),
            'hoja_grr_servicio_adicional' => trim($_POST['inputGRRServicioAdicional']),
            'hoja_servicio_adicional' => trim($_POST['inputSerAdicional']),
            'hoja_gr_transportista' => trim($_POST['inputGRTransportista']),
            'hoja_peaje' => $peaje,
            'hoja_boletas_varias' => $boletasVarias,
            'hoja_boletas_consumo' => $boletasConsumo,
            'hoja_planilla_movilidad' => $planillaMovilidad,
            'hoja_facturas_varios' => $facturasVarios,
            'hoja_carga_descarga_ladrillo' => $cargaDescargaLadrillo,
            'hoja_reintegro' => $reintegro,
            'hoja_vuelto' => $vuelto,
            'hoja_suma_total' => $sumaTotal,
            'hoja_observaciones' => trim($_POST['inputObservaciones']),
            'hoja_km_salida' => trim($_POST['inputKMSalida']),
            'hoja_km_llegada' => trim($_POST['inputKMLlegada']),
            'hoja_cv_grifo' => trim($_POST['inputCVGrifo']),
            'hoja_cv_eq' => trim($_POST['inputCVEQ']),
            'hoja_total_km' => trim($_POST['inputTotalKM']),
            'hoja_variacion' => trim($_POST['inputVariacion'])
        );

        $respuesta = ModeloHojaLiquidacion::mdlCrearHojaLiquidacion($tabla, $datos);

        if ($respuesta === 'ok') {
            $hojaDespues = ModeloHojaLiquidacion::mdlMostrarHojasLiquidacion('hoja_liquidacion', 'hoja_numero_registro', $numeroRegistro);
            self::registrarAuditoriaHojaLiquidacion('CREAR', (string) ($hojaDespues['hoja_id'] ?? ''), null, $hojaDespues ?: null);
            self::mostrarAlerta('success', 'La hoja de liquidación se registró correctamente.', 'hoja-liquidacion');
        } else {
            self::mostrarAlerta('error', 'No se pudo registrar la hoja de liquidación.', 'hoja-liquidacion');
        }
    }

    public static function ctrEditarHojaLiquidacion() {
        if (!isset($_POST['inputEditId'])) {
            return;
        }

        date_default_timezone_set('America/Lima');
        $fechaActual = date('Y-m-d H:i:s');

        $tabla = 'hoja_liquidacion';

        $montoRecibido = (float) trim($_POST['inputEditMontoRecibido']);
        $peaje = (float) trim($_POST['inputEditPeaje']);
        $boletasVarias = (float) trim($_POST['inputEditBoletasVarias']);
        $boletasConsumo = (float) trim($_POST['inputEditBoletasConsumo']);
        $planillaMovilidad = (float) trim($_POST['inputEditPlanillaMovilidad']);
        $facturasVarios = (float) trim($_POST['inputEditFacturasVarios']);
        $cargaDescargaLadrillo = (float) trim($_POST['inputEditCargaDescargaLadrillo']);

        $sumaTotal = $peaje + $boletasVarias + $boletasConsumo + $planillaMovilidad + $facturasVarios + $cargaDescargaLadrillo;
        $diferencia = $montoRecibido - $sumaTotal;
        $vuelto = $diferencia >= 0 ? $diferencia : 0;
        $reintegro = $diferencia < 0 ? abs($diferencia) : 0;

        $datos = array(
            'hoja_id' => trim($_POST['inputEditId']),
            'hoja_fecha_salida' => trim($_POST['inputEditFechaSalida']),
            'hoja_fecha_llegada' => trim($_POST['inputEditFechaLlegada']),
            'hoja_vehic_tracto_id' => trim($_POST['inputEditPlaca']),
            'hoja_vehic_tolva_id' => trim($_POST['inputEditTolva']),
            'hoja_operacion' => trim($_POST['inputEditOperacion']),
            'hoja_monto_recibido' => $montoRecibido,
            'hoja_empleado_id' => trim($_POST['inputEditEmpleado']),
            'hoja_grr_producto' => trim($_POST['inputEditGRRProducto']),
            'hoja_producto' => trim($_POST['inputEditProducto']),
            'hoja_grr_servicio_adicional' => trim($_POST['inputEditGRRServicioAdicional']),
            'hoja_servicio_adicional' => trim($_POST['inputEditSerAdicional']),
            'hoja_gr_transportista' => trim($_POST['inputEditGRTransportista']),
            'hoja_peaje' => $peaje,
            'hoja_boletas_varias' => $boletasVarias,
            'hoja_boletas_consumo' => $boletasConsumo,
            'hoja_planilla_movilidad' => $planillaMovilidad,
            'hoja_facturas_varios' => $facturasVarios,
            'hoja_carga_descarga_ladrillo' => $cargaDescargaLadrillo,
            'hoja_reintegro' => $reintegro,
            'hoja_vuelto' => $vuelto,
            'hoja_suma_total' => $sumaTotal,
            'hoja_observaciones' => trim($_POST['inputEditObservaciones']),
            'hoja_km_salida' => trim($_POST['inputEditKMSalida']),
            'hoja_km_llegada' => trim($_POST['inputEditKMLlegada']),
            'hoja_cv_grifo' => trim($_POST['inputEditCVGrifo']),
            'hoja_cv_eq' => trim($_POST['inputEditCVEQ']),
            'hoja_total_km' => trim($_POST['inputEditTotalKM']),
            'hoja_variacion' => trim($_POST['inputEditVariacion']),
            'hoja_fecha_update' => $fechaActual
        );

        $hojaAntes = ModeloHojaLiquidacion::mdlObtenerHojaLiquidacionPorId($tabla, (int) $datos['hoja_id']);
        $respuesta = ModeloHojaLiquidacion::mdlEditarHojaLiquidacion($tabla, $datos);

        if ($respuesta === 'ok') {
            $hojaDespues = ModeloHojaLiquidacion::mdlObtenerHojaLiquidacionPorId($tabla, (int) $datos['hoja_id']);
            self::registrarAuditoriaHojaLiquidacion('EDITAR', (string) $datos['hoja_id'], $hojaAntes, $hojaDespues);
            self::mostrarAlerta('success', 'La hoja de liquidación se actualizó correctamente.', 'hoja-liquidacion');
        } else {
            self::mostrarAlerta('error', 'No se pudo actualizar la hoja de liquidación.', 'hoja-liquidacion');
        }
    }

    static public function ctrEliminarHojaLiquidacion() {
        if (!isset($_GET['idHojaLiquidacion'])) {
            return;
        }

        $tabla = 'hoja_liquidacion';
        $id = (int) $_GET['idHojaLiquidacion'];
        $hojaAntes = ModeloHojaLiquidacion::mdlObtenerHojaLiquidacionPorId($tabla, $id);

        $respuesta = ModeloHojaLiquidacion::mdlEliminarHojaLiquidacion($tabla, $id);

        if ($respuesta === 'ok') {
            $hojaDespues = ModeloHojaLiquidacion::mdlObtenerHojaLiquidacionPorId($tabla, $id);
            self::registrarAuditoriaHojaLiquidacion('ELIMINAR', (string) $id, $hojaAntes, $hojaDespues);
            self::mostrarAlerta('success', 'La hoja de liquidación fue enviada a la papelera.', 'hoja-liquidacion');
        } else {
            self::mostrarAlerta('error', 'No se pudo eliminar la hoja de liquidación o ya estaba eliminada.', 'hoja-liquidacion');
        }
    }

    static public function ctrMostrarHojasLiquidacionEliminadas() {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array();
        }

        return ModeloHojaLiquidacion::mdlMostrarHojasLiquidacionEliminadas('hoja_liquidacion');
    }

    static public function ctrRestaurarHojaLiquidacion($id) {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array('status' => 'error', 'message' => 'Solo los administradores pueden restaurar registros.');
        }

        $id = (int) $id;
        if ($id <= 0) {
            return array('status' => 'error', 'message' => 'ID inválido.');
        }

        $hojaAntes = ModeloHojaLiquidacion::mdlObtenerHojaLiquidacionPorId('hoja_liquidacion', $id);
        $respuesta = ModeloHojaLiquidacion::mdlRestaurarHojaLiquidacion('hoja_liquidacion', $id);
        if ($respuesta === 'ok') {
            $hojaDespues = ModeloHojaLiquidacion::mdlObtenerHojaLiquidacionPorId('hoja_liquidacion', $id);
            self::registrarAuditoriaHojaLiquidacion('RESTAURAR', (string) $id, $hojaAntes, $hojaDespues);
            return array('status' => 'ok');
        }

        return array('status' => 'error', 'message' => 'No se pudo restaurar el registro.');
    }

    static public function ctrDepurarHojaLiquidacion($id) {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array('status' => 'error', 'message' => 'Solo los administradores pueden eliminar definitivamente.');
        }

        $id = (int) $id;
        if ($id <= 0) {
            return array('status' => 'error', 'message' => 'ID inválido.');
        }

        $hojaAntes = ModeloHojaLiquidacion::mdlObtenerHojaLiquidacionPorId('hoja_liquidacion', $id);
        $respuesta = ModeloHojaLiquidacion::mdlDepurarHojaLiquidacion('hoja_liquidacion', $id);
        if ($respuesta === 'ok') {
            self::registrarAuditoriaHojaLiquidacion('DEPURAR', (string) $id, $hojaAntes, null);
            return array('status' => 'ok');
        }

        return array('status' => 'error', 'message' => 'No se pudo eliminar definitivamente el registro.');
    }

    private static function registrarAuditoriaHojaLiquidacion($accion, $entidadId, $antes = null, $despues = null) {
        $usuarioActor = isset($_SESSION['usu_id']) ? (int) $_SESSION['usu_id'] : null;

        $camposCambiados = array();
        if (is_array($antes) && is_array($despues)) {
            foreach ($despues as $key => $valueDespues) {
                $valueAntes = array_key_exists($key, $antes) ? $antes[$key] : null;
                if ((string) $valueAntes !== (string) $valueDespues) {
                    $camposCambiados[$key] = array('antes' => $valueAntes, 'despues' => $valueDespues);
                }
            }
        }

        $detalle = array(
            'antes' => $antes,
            'despues' => $despues,
            'campos_cambiados' => $camposCambiados
        );

        ModeloAuditoria::mdlRegistrarAuditoriaGeneral(
            'hoja-liquidacion',
            'hoja_liquidacion',
            $entidadId,
            $accion,
            $usuarioActor,
            $detalle
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

    static public function ctrMostrarAuditoriaHojaLiquidacion($limit = 200) {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array();
        }

        return ModeloAuditoria::mdlMostrarAuditoriaGeneral('hoja-liquidacion', (int) $limit);
    }
}
