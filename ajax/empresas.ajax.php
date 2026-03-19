<?php
session_start();

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

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

	/*-------------------------------------
	RESTAURAR EMPRESA
	-------------------------------------*/

	public $restaurarEmpresaId;

	public function ajaxRestaurarEmpresa(){
		$respuesta = ControladorEmpresas::ctrRestaurarEmpresa($this->restaurarEmpresaId);
		echo json_encode($respuesta);
	}

	/*-------------------------------------
	DEPURAR EMPRESA
	-------------------------------------*/

	public $depurarEmpresaId;

	public function ajaxDepurarEmpresa(){
		$respuesta = ControladorEmpresas::ctrDepurarEmpresa($this->depurarEmpresaId);
		echo json_encode($respuesta);
	}
}

    /*-------------------------------------
    EDITAR EMPRESAS
    -------------------------------------*/

if(isset($_POST['depurarEmpresaId'])){

	$empresa = new AjaxEmpresas();
	$empresa->depurarEmpresaId = $_POST['depurarEmpresaId'];
	$empresa->ajaxDepurarEmpresa();

}elseif(isset($_POST['restaurarEmpresaId'])){

	$empresa = new AjaxEmpresas();
	$empresa->restaurarEmpresaId = $_POST['restaurarEmpresaId'];
	$empresa->ajaxRestaurarEmpresa();

}elseif(isset($_POST["idEmpresa"])){

	$empresa = new AjaxEmpresas();
	$empresa -> idEmpresa = $_POST["idEmpresa"];
	$empresa -> ajaxEditarEmpresa();
}



