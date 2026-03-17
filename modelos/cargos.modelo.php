<?php

require_once __DIR__ . "/../config/conexion.php";


class ModeloCargos{

    /**
     * MOSTAR CentroCostoS
     */

    static public function mdlMostrarCargos($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR );
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}

	
	/*=============================================
	CREAR CentroCostoS
	=============================================*/

	static public function mdlCrearCargo($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(car_nombre)  VALUES (:car_nombre)");
		$stmt->bindParam(":car_nombre", $datos["car_nombre"], PDO::PARAM_STR); 
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
	EDITAR CentroCosto
	=============================================*/

	static public function mdlEditarCargo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  car_nombre = :car_nombre, car_fecha_update = :car_fecha_update  WHERE car_id = :car_id");

		$stmt->bindParam(":car_nombre", $datos["car_nombre"], PDO::PARAM_STR); 
		$stmt->bindParam(":car_fecha_update", $datos["car_fecha_update"], PDO::PARAM_STR); 

		$stmt->bindParam(":car_id", $datos["car_id"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";
		}else{
			return "error";		
		}
		$stmt->close();
		$stmt = null;
	}

		/*=============================================
	BORRAR CentroCosto
	=============================================*/

	static public function mdlEliminarCargo($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE car_id = :car_id");
		$stmt -> bindParam(":car_id", $datos, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";		
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}
}// Fin Class
