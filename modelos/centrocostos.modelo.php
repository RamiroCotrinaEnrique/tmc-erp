<?php

require_once __DIR__ . "/../config/conexion.php";


class ModeloCentroCostos{

    /**
     * MOSTAR CentroCostoS
     */

    static public function mdlMostrarCentroCostos($tabla, $item, $valor){
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

	static public function mdlCrearCentroCostos($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(cenco_codigo, cenco_nombre)  VALUES (:cenco_codigo, :cenco_nombre)");
		$stmt->bindParam(":cenco_codigo", $datos["cenco_codigo"], PDO::PARAM_STR); 
		$stmt->bindParam(":cenco_nombre", $datos["cenco_nombre"], PDO::PARAM_STR); 
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

	static public function mdlEditarCentroCosto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET 
		cenco_codigo = :cenco_codigo, cenco_nombre = :cenco_nombre, cenco_fecha_update = :cenco_fecha_update  WHERE cenco_id = :cenco_id");

		$stmt->bindParam(":cenco_codigo", $datos["cenco_codigo"], PDO::PARAM_STR); 
		$stmt->bindParam(":cenco_nombre", $datos["cenco_nombre"], PDO::PARAM_STR); 
		$stmt->bindParam(":cenco_fecha_update", $datos["cenco_fecha_update"], PDO::PARAM_STR); 

		$stmt->bindParam(":cenco_id", $datos["cenco_id"], PDO::PARAM_STR);

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

	static public function mdlEliminarCentroCosto($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE cenco_id = :cenco_id");
		$stmt -> bindParam(":cenco_id", $datos, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";		
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}
}// Fin Class
