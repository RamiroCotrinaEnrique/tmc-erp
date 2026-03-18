<?php

require_once "../controladores/movimientocaja.controlador.php";
require_once "../modelos/movimientocaja.modelo.php";

class AjaxMovimientoCaja {

    public $tipo;
    public $moneda;
    public $idMovimiento;

    public function ajaxListarSeriesConfiguradas() {
        $tipo = trim((string) $this->tipo);
        $moneda = trim((string) $this->moneda);

        if ($tipo === '' || $moneda === '') {
            echo json_encode(array());
            return;
        }

        $respuesta = ControladorMovimientoCaja::ctrListarSeriesConfiguradas($tipo, $moneda);
        echo json_encode($respuesta);
    }

    public function ajaxObtenerMovimientoPorId() {
        $id = (int) $this->idMovimiento;

        if ($id <= 0) {
            echo json_encode(array());
            return;
        }

        $respuesta = ControladorMovimientoCaja::ctrMostrarMovimientoCaja('movi_id', $id);
        echo json_encode($respuesta);
    }

    public function ajaxObtenerDetalleMovimiento() {
        $id = (int) $this->idMovimiento;

        if ($id <= 0) {
            echo json_encode(array());
            return;
        }

        $respuesta = ControladorMovimientoCaja::ctrMostrarDetalleMovimiento($id);
        echo json_encode($respuesta);
    }
}

if (isset($_POST['listarSeries']) && isset($_POST['tipo']) && isset($_POST['moneda'])) {
    $ajax = new AjaxMovimientoCaja();
    $ajax->tipo = $_POST['tipo'];
    $ajax->moneda = $_POST['moneda'];
    $ajax->ajaxListarSeriesConfiguradas();
}

if (isset($_POST['idMovimientoCaja'])) {
    $ajax = new AjaxMovimientoCaja();
    $ajax->idMovimiento = $_POST['idMovimientoCaja'];
    $ajax->ajaxObtenerMovimientoPorId();
}

if (isset($_POST['idMovimientoCajaDetalle'])) {
    $ajax = new AjaxMovimientoCaja();
    $ajax->idMovimiento = $_POST['idMovimientoCajaDetalle'];
    $ajax->ajaxObtenerDetalleMovimiento();
}
