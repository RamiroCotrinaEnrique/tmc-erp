<?php
session_start();

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

require_once "../controladores/opts.controlador.php";
require_once "../modelos/opts.modelo.php";

class AjaxOpts{

	/*=============================================
	EDITAR CATEGORÍA
	=============================================*/	

	public $idOpt;
	public $restaurarOptId;
	public $depurarOptId;

	public function ajaxEditarOpt(){
		$item = "opt_id";
		$valor = $this->idOpt;
		$respuesta = ControladorOpts::ctrMostrarOpts($item, $valor);	
		echo json_encode($respuesta); 
	}

	public function ajaxRestaurarOpt(){
		$id = (int) $this->restaurarOptId;
		$respuesta = ControladorOpts::ctrRestaurarOpt($id);
		echo json_encode($respuesta);
	}

	public function ajaxDepurarOpt(){
		$id = (int) $this->depurarOptId;
		$respuesta = ControladorOpts::ctrDepurarOpt($id);
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

if(isset($_POST["restaurarOptId"])){
	$opt = new AjaxOpts();
	$opt->restaurarOptId = $_POST["restaurarOptId"];
	$opt->ajaxRestaurarOpt();
}

if(isset($_POST["depurarOptId"])){
	$opt = new AjaxOpts();
	$opt->depurarOptId = $_POST["depurarOptId"];
	$opt->ajaxDepurarOpt();
}
