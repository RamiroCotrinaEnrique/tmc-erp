<?php
session_start();

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

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

	/*-------------------------------------
	RESTAURAR AREA
	-------------------------------------*/

	public $restaurarAreaId;

	public function ajaxRestaurarArea(){
		$respuesta = ControladorAreas::ctrRestaurarArea($this->restaurarAreaId);
		echo json_encode($respuesta);
	}

	/*-------------------------------------
	DEPURAR AREA
	-------------------------------------*/

	public $depurarAreaId;

	public function ajaxDepurarArea(){
		$respuesta = ControladorAreas::ctrDepurarArea($this->depurarAreaId);
		echo json_encode($respuesta);
	}
}

    /*-------------------------------------
    EDITAR CENTRO DE COSTO
    -------------------------------------*/

if(isset($_POST['depurarAreaId'])){

	$area = new AjaxAreas();
	$area->depurarAreaId = $_POST['depurarAreaId'];
	$area->ajaxDepurarArea();

}elseif(isset($_POST['restaurarAreaId'])){

	$area = new AjaxAreas();
	$area->restaurarAreaId = $_POST['restaurarAreaId'];
	$area->ajaxRestaurarArea();

}elseif(isset($_POST["idArea"])){

	$area = new AjaxAreas();
	$area -> idArea = $_POST["idArea"];
	$area -> ajaxEditarArea();
}
