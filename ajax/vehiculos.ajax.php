<?php
session_start();

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

require_once "../controladores/vehiculos.controlador.php";
require_once "../modelos/vehiculos.modelo.php";

class AjaxVehiculos{
 
	/*-------------------------------------
    EDITAR VEHICULO
    -------------------------------------*/

	public $idVehiculo;

	public function ajaxEditarVehiculo(){
		$item = "vehic_id";
		$valor = $this->idVehiculo;
		$respuesta = ControladorVehiculos::ctrMostrarVehiculos($item, $valor);	
		echo json_encode($respuesta); 
	}
 
	/*-------------------------------------
    VALIDAR NO REPETIR USUARIO
    -------------------------------------*/

	public $validarPlaca;

	public function ajaxValidarUsuario(){
		$item = "vehic_placa";
		$valor = $this->validarPlaca;
		$respuesta = ControladorVehiculos::ctrMostrarVehiculos($item, $valor);
		echo json_encode($respuesta);
	}

	/*-------------------------------------
    VALIDAR NO REPETIR NUMERO VIN
    -------------------------------------*/

	public $validarNumeroVin;

	public function ajaxValidarNumeroVin(){
		$item = "vehic_numero_vin";
		$valor = $this->validarNumeroVin;
		$respuesta = ControladorVehiculos::ctrMostrarVehiculos($item, $valor);
		echo json_encode($respuesta);
	}

	/*-------------------------------------
    VALIDAR NO REPETIR NUMERO MOTOR
    -------------------------------------*/

	public $validarNumeroMotor;

	public function ajaxValidarNumeroMotor(){
		$item = "vehic_numero_motor";
		$valor = $this->validarNumeroMotor;
		$respuesta = ControladorVehiculos::ctrMostrarVehiculos($item, $valor);
		echo json_encode($respuesta);
	}

	/*-------------------------------------
    ACTUALIZAR VEHICULO
    -------------------------------------*/

	public $actualizarVehiculo;
	public $inputEditId;
	public $inputEditCentro;
	public $inputEditPlaca;
	public $inputEditMarca;
	public $inputEditModelo;
	public $inputEditAnio;
	public $inputEditClase;
	public $inputEditTipo;
	public $inputEditNumeroVin;
	public $inputEditNumeroMotor;
	public $inputEditJefeOperacion;
	public $inputEditEstado;
	public $inputEditPropietario;

	public function ajaxActualizarVehiculo(){
		// Registrar los datos recibidos para debugueo
		error_log("Datos para actualizar vehículo: " . print_r(array(
			'id' => $this->inputEditId,
			'centro' => $this->inputEditCentro,
			'placa' => $this->inputEditPlaca
		), true));

		$datos = array(
			'vehic_id' => $this->inputEditId,
			'vehic_cenco_id' => $this->inputEditCentro,
			'vehic_placa' => $this->inputEditPlaca,
			'vehic_marca' => $this->inputEditMarca,
			'vehic_modelo' => $this->inputEditModelo,
			'vehic_anio' => $this->inputEditAnio,
			'vehic_clase' => $this->inputEditClase,
			'vehic_tipo' => $this->inputEditTipo,
			'vehic_numero_vin' => $this->inputEditNumeroVin,
			'vehic_numero_motor' => $this->inputEditNumeroMotor,
			'vehic_jefe_operacion' => $this->inputEditJefeOperacion,
			'vehic_estado' => $this->inputEditEstado,
			'vehic_propietario' => $this->inputEditPropietario
		);

		$respuesta = ControladorVehiculos::ctrEditarVehiculoAjax($datos);
		echo json_encode($respuesta);
	}

	public $restaurarVehiculoId;

	public function ajaxRestaurarVehiculo(){
		$respuesta = ControladorVehiculos::ctrRestaurarVehiculo($this->restaurarVehiculoId);
		echo json_encode($respuesta);
	}

	public $depurarVehiculoId;

	public function ajaxDepurarVehiculo(){
		$respuesta = ControladorVehiculos::ctrDepurarVehiculo($this->depurarVehiculoId);
		echo json_encode($respuesta);
	}

}//Fin Clase

    /*-------------------------------------
    EDITAR EMPRESAS
    -------------------------------------*/

	if(isset($_POST["idVehiculo"])){

		$vehiculo = new AjaxVehiculos();
		$vehiculo -> idVehiculo = $_POST["idVehiculo"];
		$vehiculo -> ajaxEditarVehiculo();
	}

    /*-------------------------------------
    VALIDAR NO REPETIR PLACA
    -------------------------------------*/

	if(isset( $_POST["validarPlaca"])){
		$valPlaca = new AjaxVehiculos();
		$valPlaca -> validarPlaca = $_POST["validarPlaca"];
		$valPlaca -> ajaxValidarUsuario();
	}

    /*-------------------------------------
    VALIDAR NO REPETIR NUMERO VIN
    -------------------------------------*/

	if(isset( $_POST["validarNumeroVin"])){
		$valNumeroVin = new AjaxVehiculos();
		$valNumeroVin -> validarNumeroVin = $_POST["validarNumeroVin"];
		$valNumeroVin -> ajaxValidarNumeroVin();
	}

	/*-------------------------------------
    VALIDAR NO REPETIR NUMERO MOTOR
    -------------------------------------*/

	if(isset( $_POST["validarNumeroMotor"])){
		$valNumeroMotor = new AjaxVehiculos();
		$valNumeroMotor -> validarNumeroMotor = $_POST["validarNumeroMotor"];
		$valNumeroMotor -> ajaxValidarNumeroMotor();
	}

	/*-------------------------------------
    ACTUALIZAR VEHICULO
    -------------------------------------*/

	if(isset($_POST["actualizarVehiculo"])){
		$actualizarVehiculo = new AjaxVehiculos();
		$actualizarVehiculo -> inputEditId = $_POST["inputEditId"];
		$actualizarVehiculo -> inputEditCentro = $_POST["inputEditCentro"];
		$actualizarVehiculo -> inputEditPlaca = $_POST["inputEditPlaca"];
		$actualizarVehiculo -> inputEditMarca = $_POST["inputEditMarca"];
		$actualizarVehiculo -> inputEditModelo = $_POST["inputEditModelo"];
		$actualizarVehiculo -> inputEditAnio = $_POST["inputEditAnio"];
		$actualizarVehiculo -> inputEditClase = $_POST["inputEditClase"];
		$actualizarVehiculo -> inputEditTipo = $_POST["inputEditTipo"];
		$actualizarVehiculo -> inputEditNumeroVin = $_POST["inputEditNumeroVin"];
		$actualizarVehiculo -> inputEditNumeroMotor = $_POST["inputEditNumeroMotor"];
		$actualizarVehiculo -> inputEditJefeOperacion = $_POST["inputEditJefeOperacion"];
		$actualizarVehiculo -> inputEditEstado = $_POST["inputEditEstado"];
		$actualizarVehiculo -> inputEditPropietario = $_POST["inputEditPropietario"];
		$actualizarVehiculo -> ajaxActualizarVehiculo();
	}

	if(isset($_POST["restaurarVehiculoId"])){
		$ajax = new AjaxVehiculos();
		$ajax->restaurarVehiculoId = $_POST["restaurarVehiculoId"];
		$ajax->ajaxRestaurarVehiculo();
	}

	if(isset($_POST["depurarVehiculoId"])){
		$ajax = new AjaxVehiculos();
		$ajax->depurarVehiculoId = $_POST["depurarVehiculoId"];
		$ajax->ajaxDepurarVehiculo();
	}


