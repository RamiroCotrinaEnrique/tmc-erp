<?php
session_start();

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

require_once "../controladores/movimientocaja.controlador.php";
require_once "../modelos/movimientocaja.modelo.php";

class AjaxMovimientoCaja {

    public $tipo;
    public $moneda;
    public $idMovimiento;
    public $restaurarMovimientoId;
    public $depurarMovimientoId;

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

    public function ajaxRestaurarMovimiento() {
        $id = (int) $this->restaurarMovimientoId;
        $respuesta = ControladorMovimientoCaja::ctrRestaurarMovimientoCaja($id);
        echo json_encode($respuesta);
    }

    public function ajaxDepurarMovimiento() {
        $id = (int) $this->depurarMovimientoId;
        $respuesta = ControladorMovimientoCaja::ctrDepurarMovimientoCaja($id);
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

if (isset($_POST['restaurarMovimientoCajaId'])) {
    $ajax = new AjaxMovimientoCaja();
    $ajax->restaurarMovimientoId = $_POST['restaurarMovimientoCajaId'];
    $ajax->ajaxRestaurarMovimiento();
}

if (isset($_POST['depurarMovimientoCajaId'])) {
    $ajax = new AjaxMovimientoCaja();
    $ajax->depurarMovimientoId = $_POST['depurarMovimientoCajaId'];
    $ajax->ajaxDepurarMovimiento();
}
