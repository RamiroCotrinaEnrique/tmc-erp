<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../controladores/areas.controlador.php";
require_once "../modelos/areas.modelo.php";

class AjaxAreas{

    /*-------------------------------------
    EDITAR CENTRO DE COSTO
    -------------------------------------*/

	public $idArea;

	public function ajaxEditarArea(){
		$item = "are_id";
		$valor = $this->idArea;
		$respuesta = ControladorAreas::ctrMostrarAreas($item, $valor);	
		echo json_encode($respuesta); 
	}
}

    /*-------------------------------------
    EDITAR CENTRO DE COSTO
    -------------------------------------*/

if(isset($_POST["idArea"])){

	$area = new AjaxAreas();
	$area -> idArea = $_POST["idArea"];
	$area -> ajaxEditarArea();
}
