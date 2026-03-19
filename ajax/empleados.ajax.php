<?php
session_start();

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

require_once "../controladores/empleados.controlador.php";
require_once "../modelos/empleados.modelo.php";

class AjaxEmpleados{

    /*-------------------------------------
    MOSTRAR REPORTE EMPLEADOS
    -------------------------------------*/
    public $idEmpleadoReporte;

    public function ajaxMostrarEmpleadoReporte() {
        
        $item = "emple_id";
        $valor = $this->idEmpleadoReporte;

        $respuesta = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);

        echo json_encode($respuesta);
    }

    /*-------------------------------------
    EDITAR EMPLEADO 
    -------------------------------------*/

	public $idEmpleado;

	public function ajaxEditarEmpleado(){
		$item = "emple_id";
		$valor = $this->idEmpleado;
		$respuesta = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);	
		echo json_encode($respuesta); 
	}

    public $restaurarEmpleadoId;

    public function ajaxRestaurarEmpleado(){
        $respuesta = ControladorEmpleados::ctrRestaurarEmpleado($this->restaurarEmpleadoId);
        echo json_encode($respuesta);
    }

    public $depurarEmpleadoId;

    public function ajaxDepurarEmpleado(){
        $respuesta = ControladorEmpleados::ctrDepurarEmpleado($this->depurarEmpleadoId);
        echo json_encode($respuesta);
    }

}

    /*-------------------------------------
    MOSTRAR REPROTE EMPLEADOS
    -------------------------------------*/
if (isset($_POST["idEmpleadoReporte"])) {
    $reporte = new AjaxEmpleados();
    $reporte->idEmpleadoReporte = $_POST["idEmpleadoReporte"];
    $reporte->ajaxMostrarEmpleadoReporte();
}

/*-------------------------------------
ACTUALIZAR EMLEADO (POST desde modal editar)
-------------------------------------*/
// Si vienen campos de edición, delegamos al controlador para que procese la actualización
if(isset($_POST["editarApellidoPaterno"]) || isset($_POST["editarNombres"])){
    // Controller handles validation, files, etc. It will echo JSON
    ControladorEmpleados::ctrEditarEmpleado();
    exit;
}

/*-------------------------------------
ELIMINAR EMPLEADO (POST AJAX)
-------------------------------------*/
if(isset($_POST["idEmpleadoEliminar"])){
    // ctrEliminarEmpleado manejará tanto POST como GET y sabrá devolver JSON
    ControladorEmpleados::ctrEliminarEmpleado();
    exit;
}

/*-------------------------------------
RESTAURAR EMPLEADO (POST AJAX)
-------------------------------------*/
if(isset($_POST["restaurarEmpleadoId"])){
    $ajax = new AjaxEmpleados();
    $ajax->restaurarEmpleadoId = $_POST["restaurarEmpleadoId"];
    $ajax->ajaxRestaurarEmpleado();
    exit;
}

/*-------------------------------------
DEPURAR EMPLEADO (POST AJAX)
-------------------------------------*/
if(isset($_POST["depurarEmpleadoId"])){
    $ajax = new AjaxEmpleados();
    $ajax->depurarEmpleadoId = $_POST["depurarEmpleadoId"];
    $ajax->ajaxDepurarEmpleado();
    exit;
}

/*-------------------------------------
EDITAR EMPLEADO (cargar datos)
-------------------------------------*/
if(isset($_POST["idEmpleado"])){
	$editar = new AjaxEmpleados();
	$editar->idEmpleado = $_POST["idEmpleado"];
	$editar->ajaxEditarEmpleado();
}

