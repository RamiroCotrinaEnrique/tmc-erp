<?php
session_start();

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

require_once "../controladores/resumencaja.controlador.php";
require_once "../modelos/resumencaja.modelo.php";
require_once "../controladores/empleados.controlador.php";
require_once "../modelos/empleados.modelo.php";

class AjaxResumenCaja {

    public $anio;
    public $mes;
    public $dia;
    public $idResumenCaja;
    public $restaurarResumenCajaId;
    public $depurarResumenCajaId;
    public $dniEmpleado;

    public function ajaxListarDetallePorFecha() {
        $anio = (int) $this->anio;
        $mes = (int) $this->mes;
        $dia = (int) $this->dia;

        $respuesta = ControladorResumenCaja::ctrListarDetallePorFecha($anio, $mes, $dia);
        echo json_encode($respuesta);
    }

    public function ajaxMostrarResumenCaja() {
        $idResumen = (int) $this->idResumenCaja;
        $respuesta = ControladorResumenCaja::ctrMostrarResumenCaja('resc_id', $idResumen);
        echo json_encode($respuesta ? $respuesta : array());
    }

    public function ajaxMostrarDetalleResumenCaja() {
        $idResumen = (int) $this->idResumenCaja;
        $respuesta = ControladorResumenCaja::ctrMostrarDetalleResumenCaja($idResumen);
        echo json_encode($respuesta);
    }

    public function ajaxObtenerEstadoFechaCierre() {
        $anio = (int) $this->anio;
        $mes = (int) $this->mes;
        $dia = (int) $this->dia;

        $respuesta = ControladorResumenCaja::ctrObtenerEstadoFechaCierre($anio, $mes, $dia);
        echo json_encode($respuesta);
    }

    public function ajaxRestaurarResumenCaja() {
        $idResumen = (int) $this->restaurarResumenCajaId;
        $respuesta = ControladorResumenCaja::ctrRestaurarResumenCaja($idResumen);
        echo json_encode($respuesta);
    }

    public function ajaxDepurarResumenCaja() {
        $idResumen = (int) $this->depurarResumenCajaId;
        $respuesta = ControladorResumenCaja::ctrDepurarResumenCaja($idResumen);
        echo json_encode($respuesta);
    }

    public function ajaxBuscarEmpleadoPorDni() {
        $dni = trim((string) $this->dniEmpleado);

        if (!preg_match('/^[0-9]{8,20}$/', $dni)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'DNI invalido.'
            ));
            return;
        }

        $empleado = ControladorEmpleados::ctrMostrarEmpleados('emple_numero_documento', $dni);

        if (!$empleado) {
            echo json_encode(array(
                'status' => 'not_found'
            ));
            return;
        }

        $apellidoPaterno = isset($empleado['emple_apellido_paterno']) ? trim((string) $empleado['emple_apellido_paterno']) : '';
        $apellidoMaterno = isset($empleado['emple_apellido_materno']) ? trim((string) $empleado['emple_apellido_materno']) : '';
        $nombres = isset($empleado['emple_nombres']) ? trim((string) $empleado['emple_nombres']) : '';
        $nombreCompleto = trim(preg_replace('/\s+/', ' ', $apellidoPaterno . ' ' . $apellidoMaterno . ' ' . $nombres));

        echo json_encode(array(
            'status' => 'ok',
            'dni' => isset($empleado['emple_numero_documento']) ? (string) $empleado['emple_numero_documento'] : $dni,
            'nombre' => $nombreCompleto,
            'empleado_id' => isset($empleado['emple_id']) ? (int) $empleado['emple_id'] : 0
        ));
    }
}

if (isset($_POST['listarDetalleResumen']) && isset($_POST['anio']) && isset($_POST['mes']) && isset($_POST['dia'])) {
    $ajax = new AjaxResumenCaja();
    $ajax->anio = $_POST['anio'];
    $ajax->mes = $_POST['mes'];
    $ajax->dia = $_POST['dia'];
    $ajax->ajaxListarDetallePorFecha();
}

if (isset($_POST['idResumenCaja'])) {
    $ajax = new AjaxResumenCaja();
    $ajax->idResumenCaja = $_POST['idResumenCaja'];
    $ajax->ajaxMostrarResumenCaja();
}

if (isset($_POST['idResumenCajaDetalle'])) {
    $ajax = new AjaxResumenCaja();
    $ajax->idResumenCaja = $_POST['idResumenCajaDetalle'];
    $ajax->ajaxMostrarDetalleResumenCaja();
}

if (isset($_POST['estadoFechaResumen']) && isset($_POST['anio']) && isset($_POST['mes']) && isset($_POST['dia'])) {
    $ajax = new AjaxResumenCaja();
    $ajax->anio = $_POST['anio'];
    $ajax->mes = $_POST['mes'];
    $ajax->dia = $_POST['dia'];
    $ajax->ajaxObtenerEstadoFechaCierre();
}

if (isset($_POST['restaurarResumenCajaId'])) {
    $ajax = new AjaxResumenCaja();
    $ajax->restaurarResumenCajaId = $_POST['restaurarResumenCajaId'];
    $ajax->ajaxRestaurarResumenCaja();
}

if (isset($_POST['depurarResumenCajaId'])) {
    $ajax = new AjaxResumenCaja();
    $ajax->depurarResumenCajaId = $_POST['depurarResumenCajaId'];
    $ajax->ajaxDepurarResumenCaja();
}

if (isset($_POST['buscarEmpleadoPorDni']) && isset($_POST['dni'])) {
    $ajax = new AjaxResumenCaja();
    $ajax->dniEmpleado = $_POST['dni'];
    $ajax->ajaxBuscarEmpleadoPorDni();
}