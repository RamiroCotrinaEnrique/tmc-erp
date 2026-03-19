<?php
session_start();

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

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

	/*-------------------------------------
	RESTAURAR CARGO
	-------------------------------------*/

	public $restaurarCargoId;

	public function ajaxRestaurarCargo(){
		$respuesta = ControladorCargos::ctrRestaurarCargo($this->restaurarCargoId);
		echo json_encode($respuesta);
	}

	/*-------------------------------------
	DEPURAR CARGO
	-------------------------------------*/

	public $depurarCargoId;

	public function ajaxDepurarCargo(){
		$respuesta = ControladorCargos::ctrDepurarCargo($this->depurarCargoId);
		echo json_encode($respuesta);
	}
}

    /*-------------------------------------
    EDITAR CENTRO DE COSTO
    -------------------------------------*/

if(isset($_POST['depurarCargoId'])){

	$cargo = new AjaxCargos();
	$cargo->depurarCargoId = $_POST['depurarCargoId'];
	$cargo->ajaxDepurarCargo();

}elseif(isset($_POST['restaurarCargoId'])){

	$cargo = new AjaxCargos();
	$cargo->restaurarCargoId = $_POST['restaurarCargoId'];
	$cargo->ajaxRestaurarCargo();

}elseif(isset($_POST["idCargo"])){

	$cargo = new AjaxCargos();
	$cargo -> idCargo = $_POST["idCargo"];
	$cargo -> ajaxEditarCargo();
}
