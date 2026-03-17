<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
}

    /*-------------------------------------
    EDITAR CENTRO DE COSTO
    -------------------------------------*/

if(isset($_POST["idCentroCosto"])){

	$centroCosto = new AjaxCentroCostos();
	$centroCosto -> idCentroCosto = $_POST["idCentroCosto"];
	$centroCosto -> ajaxEditarCentroCosto();
}
