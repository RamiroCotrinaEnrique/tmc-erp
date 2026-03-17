<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";
require_once "../config/conexion.php";

class AjaxUsuarios{

	/*=============================================
	EDITAR CATEGORÍA
	=============================================*/	

	public $idUsuario;

	public function ajaxEditarUsuario(){
		$item = "usu_id";
		$valor = $this->idUsuario;
		$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);	
		echo json_encode($respuesta); 		
	}

		/*=============================================
	ACTIVAR USUARIO
	=============================================*/	

	public $activarUsuario;
	public $activarId;


	public function ajaxActivarUsuario(){

		$tabla = "usuarios";

		$item1 = "usu_estado";
		$valor1 = $this->activarUsuario;

		$item2 = "usu_id";
		$valor2 = $this->activarId;

		$respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);
		echo json_encode($respuesta); 	
	}

	
	/*=============================================
	VALIDAR NO REPETIR USUARIO
	=============================================*/	

	public $validarUsuario;

	public function ajaxValidarUsuario(){
		$item = "usu_usuario";
		$valor = $this->validarUsuario;
		$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
		echo json_encode($respuesta);
	}


}

/*=============================================
EDITAR CATEGORÍA
=============================================*/	

if(isset($_POST["idUsuario"])){

	$usuario = new AjaxUsuarios();
	$usuario -> idUsuario = $_POST["idUsuario"];
	$usuario -> ajaxEditarUsuario();
}

/*=============================================
ACTIVAR USUARIO
=============================================*/	

if(isset($_POST["activarUsuario"])){

	$activarUsuario = new AjaxUsuarios();
	$activarUsuario -> activarUsuario = $_POST["activarUsuario"];
	$activarUsuario -> activarId = $_POST["activarId"];
	$activarUsuario -> ajaxActivarUsuario();
}

/*=============================================
VALIDAR NO REPETIR USUARIO
=============================================*/

if(isset( $_POST["validarUsuario"])){
	$valUsuario = new AjaxUsuarios();
	$valUsuario -> validarUsuario = $_POST["validarUsuario"];
	$valUsuario -> ajaxValidarUsuario();
}
