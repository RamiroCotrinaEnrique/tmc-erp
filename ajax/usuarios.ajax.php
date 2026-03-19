<?php
session_start();

// Los errores PHP no deben imprimirse en respuestas AJAX: corrompen el JSON.
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

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

	/*=============================================
	PRIVILEGIOS DE MÓDULOS
	=============================================*/

	public $idUsuarioPrivilegios;

	public function ajaxObtenerPrivilegiosUsuario(){
		$respuesta = ControladorUsuarios::ctrObtenerPrivilegiosModulosUsuario($this->idUsuarioPrivilegios);
		echo json_encode($respuesta);
	}

	public $modulosPrivilegios;

	public function ajaxGuardarPrivilegiosUsuario(){
		$respuesta = ControladorUsuarios::ctrGuardarPrivilegiosModulosUsuario($this->idUsuarioPrivilegios, $this->modulosPrivilegios);
		echo json_encode($respuesta);
	}

	/*=============================================
	RESTAURAR USUARIO (BORRADO LÓGICO)
	=============================================*/

	public $restaurarUsuarioId;

	public function ajaxRestaurarUsuario(){
		$respuesta = ControladorUsuarios::ctrRestaurarUsuario($this->restaurarUsuarioId);
		echo json_encode($respuesta);
	}

	/*=============================================
	DEPURAR USUARIO - ELIMINACION FISICA (SOLO MASTER)
	=============================================*/

	public $depurarUsuarioId;

	public function ajaxDepurarUsuario(){
		$respuesta = ControladorUsuarios::ctrDepurarUsuario($this->depurarUsuarioId);
		echo json_encode($respuesta);
	}

}

/*=============================================
ENRUTADOR ÚNICO - solo un bloque se ejecuta
=============================================*/

if(isset($_POST['depurarUsuarioId'])){
	// Eliminación física del usuario (solo master)
	$depurar = new AjaxUsuarios();
	$depurar->depurarUsuarioId = $_POST['depurarUsuarioId'];
	$depurar->ajaxDepurarUsuario();

}elseif(isset($_POST['restaurarUsuarioId'])){
	// Restaurar usuario eliminado lógicamente
	$restaurar = new AjaxUsuarios();
	$restaurar->restaurarUsuarioId = $_POST['restaurarUsuarioId'];
	$restaurar->ajaxRestaurarUsuario();

}elseif(isset($_POST['guardarPrivilegiosUsuario'])){
	// Guardar privilegios de módulos del usuario
	$guardar = new AjaxUsuarios();
	$guardar->idUsuarioPrivilegios = isset($_POST['idUsuario']) ? $_POST['idUsuario'] : 0;
	$guardar->modulosPrivilegios = isset($_POST['modulos']) ? $_POST['modulos'] : array();
	$guardar->ajaxGuardarPrivilegiosUsuario();

}elseif(isset($_POST['idUsuarioPrivilegios'])){
	// Obtener privilegios actuales del usuario
	$privilegios = new AjaxUsuarios();
	$privilegios->idUsuarioPrivilegios = $_POST['idUsuarioPrivilegios'];
	$privilegios->ajaxObtenerPrivilegiosUsuario();

}elseif(isset($_POST["idUsuario"])){
	// Cargar datos del usuario para edición
	$usuario = new AjaxUsuarios();
	$usuario->idUsuario = $_POST["idUsuario"];
	$usuario->ajaxEditarUsuario();

}elseif(isset($_POST["activarUsuario"])){
	// Activar / desactivar usuario
	$activarUsuario = new AjaxUsuarios();
	$activarUsuario->activarUsuario = $_POST["activarUsuario"];
	$activarUsuario->activarId = $_POST["activarId"];
	$activarUsuario->ajaxActivarUsuario();

}elseif(isset($_POST["validarUsuario"])){
	// Validar si el usuario ya existe
	$valUsuario = new AjaxUsuarios();
	$valUsuario->validarUsuario = $_POST["validarUsuario"];
	$valUsuario->ajaxValidarUsuario();
}
