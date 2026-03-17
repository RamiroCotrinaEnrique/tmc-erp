<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../controladores/cargos.controlador.php";
require_once "../modelos/cargos.modelo.php";

class AjaxCargos{

    /*-------------------------------------
    EDITAR CENTRO DE COSTO 
    -------------------------------------*/

	public $idCargo;

	public function ajaxEditarCargo(){
		$item = "car_id";
		$valor = $this->idCargo;
		$respuesta = ControladorCargos::ctrMostrarCargos($item, $valor);	
		echo json_encode($respuesta); 
	}
}

    /*-------------------------------------
    EDITAR CENTRO DE COSTO
    -------------------------------------*/

if(isset($_POST["idCargo"])){

	$cargo = new AjaxCargos();
	$cargo -> idCargo = $_POST["idCargo"];
	$cargo -> ajaxEditarCargo();
}
