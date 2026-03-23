<?php

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

        $sumaTotal = $peaje + $boletasVarias + $boletasConsumo + $planillaMovilidad + $facturasVarios;
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

        $sumaTotal = $peaje + $boletasVarias + $boletasConsumo + $planillaMovilidad + $facturasVarios;
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

        $respuesta = ModeloHojaLiquidacion::mdlEditarHojaLiquidacion($tabla, $datos);

        if ($respuesta === 'ok') {
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

        $respuesta = ModeloHojaLiquidacion::mdlEliminarHojaLiquidacion($tabla, $id);

        if ($respuesta === 'ok') {
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

        $respuesta = ModeloHojaLiquidacion::mdlRestaurarHojaLiquidacion('hoja_liquidacion', $id);
        if ($respuesta === 'ok') {
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

        $respuesta = ModeloHojaLiquidacion::mdlDepurarHojaLiquidacion('hoja_liquidacion', $id);
        if ($respuesta === 'ok') {
            return array('status' => 'ok');
        }

        return array('status' => 'error', 'message' => 'No se pudo eliminar definitivamente el registro.');
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
