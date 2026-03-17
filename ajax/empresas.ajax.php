<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../controladores/empresas.controlador.php";
require_once "../modelos/empresas.modelo.php";


class AjaxEmpresas{

    /*-------------------------------------
    EDITAR EMPRESAS
    -------------------------------------*/

	public $idEmpresa;

	public function ajaxEditarEmpresa(){
		$item = "empre_id";
		$valor = $this->idEmpresa;
		$respuesta = ControladorEmpresas::ctrMostrarEmpresas($item, $valor);	
		echo json_encode($respuesta); 
	}
}

    /*-------------------------------------
    EDITAR EMPRESAS
    -------------------------------------*/

if(isset($_POST["idEmpresa"])){

	$empresa = new AjaxEmpresas();
	$empresa -> idEmpresa = $_POST["idEmpresa"];
	$empresa -> ajaxEditarEmpresa();
}



