<?php

require_once __DIR__ . "/../config/conexion.php";


class ModeloVehiculos{

    /*-------------------------------------
    LISTAR VEHICULOS
    -------------------------------------*/

    static public function mdlMostrarVehiculos($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND vehic_fecha_delete IS NULL");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR );
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE vehic_fecha_delete IS NULL ORDER BY vehic_id DESC");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}


    /*-------------------------------------
    CREAR VEHICULOS
    -------------------------------------*/

	static public function mdlCrearVehiculos($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(vehic_cenco_id, vehic_placa, vehic_marca, vehic_modelo, vehic_anio, vehic_clase, vehic_tipo, vehic_numero_vin, vehic_numero_motor, vehic_jefe_operacion, vehic_estado, vehic_propietario)  VALUES (:vehic_cenco_id, :vehic_placa, :vehic_marca, :vehic_modelo, :vehic_anio, :vehic_clase, :vehic_tipo, :vehic_numero_vin, :vehic_numero_motor, :vehic_jefe_operacion, :vehic_estado, :vehic_propietario)");

		$stmt->bindParam(":vehic_cenco_id", $datos["vehic_cenco_id"], PDO::PARAM_STR); 
		$stmt->bindParam(":vehic_placa", $datos["vehic_placa"], PDO::PARAM_STR); 
		$stmt->bindParam(":vehic_marca", $datos["vehic_marca"], PDO::PARAM_STR); 
		$stmt->bindParam(":vehic_modelo", $datos["vehic_modelo"], PDO::PARAM_STR); 
		$stmt->bindParam(":vehic_anio", $datos["vehic_anio"], PDO::PARAM_STR); 
		$stmt->bindParam(":vehic_clase", $datos["vehic_clase"], PDO::PARAM_STR); 
		$stmt->bindParam(":vehic_tipo", $datos["vehic_tipo"], PDO::PARAM_STR); 
		$stmt->bindParam(":vehic_numero_vin", $datos["vehic_numero_vin"], PDO::PARAM_STR); 
		$stmt->bindParam(":vehic_numero_motor", $datos["vehic_numero_motor"], PDO::PARAM_STR); 
		$stmt->bindParam(":vehic_jefe_operacion", $datos["vehic_jefe_operacion"], PDO::PARAM_STR); 
		$stmt->bindParam(":vehic_estado", $datos["vehic_estado"], PDO::PARAM_STR); 
		$stmt->bindParam(":vehic_propietario", $datos["vehic_propietario"], PDO::PARAM_STR); 
		//var_dump($stmt);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";		
		}
		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	EDITAR VEHICULO
	=============================================*/

	static public function mdlEditarVehiculo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET vehic_cenco_id = :vehic_cenco_id, vehic_placa = :vehic_placa, vehic_marca = :vehic_marca, vehic_modelo = :vehic_modelo, vehic_anio = :vehic_anio, vehic_clase = :vehic_clase, vehic_tipo = :vehic_tipo, vehic_numero_vin = :vehic_numero_vin, vehic_numero_motor = :vehic_numero_motor, vehic_jefe_operacion = :vehic_jefe_operacion, vehic_estado = :vehic_estado, vehic_propietario = :vehic_propietario,  vehic_fecha_update = :vehic_fecha_update  WHERE vehic_id = :vehic_id");

		$stmt->bindParam(":vehic_cenco_id", $datos["vehic_cenco_id"], PDO::PARAM_STR); 
		$stmt->bindParam(":vehic_placa", $datos["vehic_placa"], PDO::PARAM_STR); 
		$stmt->bindParam(":vehic_marca", $datos["vehic_marca"], PDO::PARAM_STR); 
		$stmt->bindParam(":vehic_modelo", $datos["vehic_modelo"], PDO::PARAM_STR); 
		$stmt->bindParam(":vehic_anio", $datos["vehic_anio"], PDO::PARAM_STR); 
		$stmt->bindParam(":vehic_clase", $datos["vehic_clase"], PDO::PARAM_STR); 
		$stmt->bindParam(":vehic_tipo", $datos["vehic_tipo"], PDO::PARAM_STR); 
		$stmt->bindParam(":vehic_numero_vin", $datos["vehic_numero_vin"], PDO::PARAM_STR); 
		$stmt->bindParam(":vehic_numero_motor", $datos["vehic_numero_motor"], PDO::PARAM_STR); 
		$stmt->bindParam(":vehic_jefe_operacion", $datos["vehic_jefe_operacion"], PDO::PARAM_STR); 
		$stmt->bindParam(":vehic_estado", $datos["vehic_estado"], PDO::PARAM_STR); 
		$stmt->bindParam(":vehic_propietario", $datos["vehic_propietario"], PDO::PARAM_STR); 
		$stmt->bindParam(":vehic_fecha_update", $datos["vehic_fecha_update"], PDO::PARAM_STR); 

		$stmt->bindParam(":vehic_id", $datos["vehic_id"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";
		}else{
			// Retornar el error de PDO para debugueo
			error_log("Error al actualizar vehículo: " . print_r($stmt->errorInfo(), true));
			return "error";		
		}
		$stmt->close();
		$stmt = null;
	}

		/*=============================================
	BORRAR CentroCosto
	=============================================*/

	static public function mdlEliminarVehiculo($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET vehic_fecha_delete = NOW() WHERE vehic_id = :vehic_id AND vehic_fecha_delete IS NULL");
		$stmt -> bindParam(":vehic_id", $datos, PDO::PARAM_INT);
		if($stmt -> execute() && $stmt->rowCount() > 0){
			return "ok";		
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	MOSTRAR VEHICULOS ELIMINADOS (PAPELERA)
	=============================================*/

	static public function mdlMostrarVehiculosEliminados($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE vehic_fecha_delete IS NOT NULL ORDER BY vehic_fecha_delete DESC");
		$stmt->execute();
		return $stmt->fetchAll();
	}

	/*=============================================
	RESTAURAR VEHICULO
	=============================================*/

	static public function mdlRestaurarVehiculo($tabla, $id){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET vehic_fecha_delete = NULL WHERE vehic_id = :vehic_id AND vehic_fecha_delete IS NOT NULL");
		$stmt->bindParam(":vehic_id", $id, PDO::PARAM_INT);
		if($stmt->execute() && $stmt->rowCount() > 0){
			return "ok";
		}
		return "error";
	}

	/*=============================================
	DEPURAR VEHICULO
	=============================================*/

	static public function mdlDepurarVehiculo($tabla, $id){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE vehic_id = :vehic_id AND vehic_fecha_delete IS NOT NULL");
		$stmt->bindParam(':vehic_id', $id, PDO::PARAM_INT);
		if($stmt->execute() && $stmt->rowCount() > 0){
			return 'ok';
		}
		return 'error';
	}
}// Fin Class
