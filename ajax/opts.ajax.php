<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../controladores/opts.controlador.php";
require_once "../modelos/opts.modelo.php";

class AjaxOpts{

	/*=============================================
	EDITAR CATEGORÍA
	=============================================*/	

	public $idOpt;

	public function ajaxEditarOpt(){
		$item = "opt_id";
		$valor = $this->idOpt;
		$respuesta = ControladorOpts::ctrMostrarOpts($item, $valor);	
		echo json_encode($respuesta); 
	}
}

/*=============================================
EDITAR CATEGORÍA
=============================================*/	

if(isset($_POST["idOpt"])){

	$opt = new AjaxOpts();
	$opt -> idOpt = $_POST["idOpt"];
	$opt -> ajaxEditarOpt();
}
