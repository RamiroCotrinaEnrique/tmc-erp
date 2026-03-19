<?php

require_once __DIR__ . "/../config/conexion.php";


class ModeloAreas{

    /**
     * MOSTAR CentroCostoS
     */

    static public function mdlMostrarAreas($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND are_fecha_delete IS NULL");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR );
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE are_fecha_delete IS NULL ORDER BY are_id DESC");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}

	
	/*=============================================
	CREAR CentroCostoS
	=============================================*/

	static public function mdlCrearArea($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(are_nombre)  VALUES (:are_nombre)");
		$stmt->bindParam(":are_nombre", $datos["are_nombre"], PDO::PARAM_STR); 
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

	static public function mdlEditarArea($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  are_nombre = :are_nombre, are_fecha_update = :are_fecha_update  WHERE are_id = :are_id");

		$stmt->bindParam(":are_nombre", $datos["are_nombre"], PDO::PARAM_STR); 
		$stmt->bindParam(":are_fecha_update", $datos["are_fecha_update"], PDO::PARAM_STR); 

		$stmt->bindParam(":are_id", $datos["are_id"], PDO::PARAM_STR);

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

	static public function mdlEliminarArea($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET are_fecha_delete = NOW() WHERE are_id = :are_id AND are_fecha_delete IS NULL");
		$stmt -> bindParam(":are_id", $datos, PDO::PARAM_INT);
		if($stmt -> execute() && $stmt->rowCount() > 0){
			return "ok";		
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	MOSTRAR AREAS ELIMINADAS (PAPELERA)
	=============================================*/

	static public function mdlMostrarAreasEliminadas($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE are_fecha_delete IS NOT NULL ORDER BY are_fecha_delete DESC");
		$stmt->execute();
		return $stmt->fetchAll();
	}

	/*=============================================
	RESTAURAR AREA (REVERTIR BORRADO LÓGICO)
	=============================================*/

	static public function mdlRestaurarArea($tabla, $id){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET are_fecha_delete = NULL WHERE are_id = :are_id AND are_fecha_delete IS NOT NULL");
		$stmt->bindParam(":are_id", $id, PDO::PARAM_INT);
		if($stmt->execute() && $stmt->rowCount() > 0){
			return "ok";
		}
		return "error";
	}

	/*=============================================
	DEPURAR AREA - ELIMINACION FISICA
	=============================================*/

	static public function mdlDepurarArea($tabla, $id){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE are_id = :are_id AND are_fecha_delete IS NOT NULL");
		$stmt->bindParam(':are_id', $id, PDO::PARAM_INT);
		if($stmt->execute() && $stmt->rowCount() > 0){
			return 'ok';
		}
		return 'error';
	}
}// Fin Class
