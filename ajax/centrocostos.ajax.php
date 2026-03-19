<?php
session_start();

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

require_once "../controladores/centrocostos.controlador.php";
require_once "../modelos/centrocostos.modelo.php";

class AjaxCentroCostos{

    /*-------------------------------------
    EDITAR CENTRO DE COSTO
    -------------------------------------*/

	public $idCentroCosto;

	public function ajaxEditarCentroCosto(){
		$item = "cenco_id";
		$valor = $this->idCentroCosto;
		$respuesta = ControladorCentroCostos::ctrMostrarCentroCostos($item, $valor);	
		echo json_encode($respuesta); 
	}

	/*-------------------------------------
	RESTAURAR CENTRO DE COSTO
	-------------------------------------*/

	public $restaurarCentroCostoId;

	public function ajaxRestaurarCentroCosto(){
		$respuesta = ControladorCentroCostos::ctrRestaurarCentroCosto($this->restaurarCentroCostoId);
		echo json_encode($respuesta);
	}

	/*-------------------------------------
	DEPURAR CENTRO DE COSTO
	-------------------------------------*/

	public $depurarCentroCostoId;

	public function ajaxDepurarCentroCosto(){
		$respuesta = ControladorCentroCostos::ctrDepurarCentroCosto($this->depurarCentroCostoId);
		echo json_encode($respuesta);
	}
}

    /*-------------------------------------
    EDITAR CENTRO DE COSTO
    -------------------------------------*/

if(isset($_POST['depurarCentroCostoId'])){

	$centroCosto = new AjaxCentroCostos();
	$centroCosto->depurarCentroCostoId = $_POST['depurarCentroCostoId'];
	$centroCosto->ajaxDepurarCentroCosto();

}elseif(isset($_POST['restaurarCentroCostoId'])){

	$centroCosto = new AjaxCentroCostos();
	$centroCosto->restaurarCentroCostoId = $_POST['restaurarCentroCostoId'];
	$centroCosto->ajaxRestaurarCentroCosto();

}elseif(isset($_POST["idCentroCosto"])){

	$centroCosto = new AjaxCentroCostos();
	$centroCosto -> idCentroCosto = $_POST["idCentroCosto"];
	$centroCosto -> ajaxEditarCentroCosto();
}
