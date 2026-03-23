<?php
session_start();

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

require_once '../controladores/hojaliquidacion.controlador.php';
require_once '../modelos/hojaliquidacion.modelo.php';

class AjaxHojaLiquidacion {

    public $idHojaLiquidacion;

    public function ajaxEditarHojaLiquidacion() {
        $item = 'hoja_id';
        $valor = $this->idHojaLiquidacion;
        $respuesta = ControladorHojaLiquidacion::ctrMostrarHojasLiquidacion($item, $valor);
        echo json_encode($respuesta);
    }

    public $restaurarHojaLiquidacionId;

    public function ajaxRestaurarHojaLiquidacion() {
        $respuesta = ControladorHojaLiquidacion::ctrRestaurarHojaLiquidacion($this->restaurarHojaLiquidacionId);
        echo json_encode($respuesta);
    }

    public $depurarHojaLiquidacionId;

    public function ajaxDepurarHojaLiquidacion() {
        $respuesta = ControladorHojaLiquidacion::ctrDepurarHojaLiquidacion($this->depurarHojaLiquidacionId);
        echo json_encode($respuesta);
    }
}

if (isset($_POST['depurarHojaLiquidacionId'])) {
    $ajax = new AjaxHojaLiquidacion();
    $ajax->depurarHojaLiquidacionId = $_POST['depurarHojaLiquidacionId'];
    $ajax->ajaxDepurarHojaLiquidacion();
} elseif (isset($_POST['restaurarHojaLiquidacionId'])) {
    $ajax = new AjaxHojaLiquidacion();
    $ajax->restaurarHojaLiquidacionId = $_POST['restaurarHojaLiquidacionId'];
    $ajax->ajaxRestaurarHojaLiquidacion();
} elseif (isset($_POST['idHojaLiquidacion'])) {
    $ajax = new AjaxHojaLiquidacion();
    $ajax->idHojaLiquidacion = $_POST['idHojaLiquidacion'];
    $ajax->ajaxEditarHojaLiquidacion();
}
