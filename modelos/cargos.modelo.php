<?php

require_once __DIR__ . "/../config/conexion.php";


class ModeloCargos{

    /**
     * MOSTAR CentroCostoS
     */

    static public function mdlMostrarCargos($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND car_fecha_delete IS NULL");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR );
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE car_fecha_delete IS NULL ORDER BY car_id DESC");
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
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET car_fecha_delete = NOW() WHERE car_id = :car_id AND car_fecha_delete IS NULL");
		$stmt -> bindParam(":car_id", $datos, PDO::PARAM_INT);
		if($stmt -> execute() && $stmt->rowCount() > 0){
			return "ok";		
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	MOSTRAR CARGOS ELIMINADOS (PAPELERA)
	=============================================*/

	static public function mdlMostrarCargosEliminados($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE car_fecha_delete IS NOT NULL ORDER BY car_fecha_delete DESC");
		$stmt->execute();
		return $stmt->fetchAll();
	}

	/*=============================================
	RESTAURAR CARGO (REVERTIR BORRADO LÓGICO)
	=============================================*/

	static public function mdlRestaurarCargo($tabla, $id){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET car_fecha_delete = NULL WHERE car_id = :car_id AND car_fecha_delete IS NOT NULL");
		$stmt->bindParam(":car_id", $id, PDO::PARAM_INT);
		if($stmt->execute() && $stmt->rowCount() > 0){
			return "ok";
		}
		return "error";
	}

	/*=============================================
	DEPURAR CARGO - ELIMINACION FISICA
	=============================================*/

	static public function mdlDepurarCargo($tabla, $id){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE car_id = :car_id AND car_fecha_delete IS NOT NULL");
		$stmt->bindParam(':car_id', $id, PDO::PARAM_INT);
		if($stmt->execute() && $stmt->rowCount() > 0){
			return 'ok';
		}
		return 'error';
	}
}// Fin Class
