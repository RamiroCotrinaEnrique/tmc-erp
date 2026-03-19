<?php

require_once __DIR__ . "/../config/conexion.php";


class ModeloCentroCostos{

    /**
     * MOSTAR CentroCostoS
     */

    static public function mdlMostrarCentroCostos($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND cenco_fecha_delete IS NULL");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR );
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE cenco_fecha_delete IS NULL ORDER BY cenco_id DESC");
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
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET cenco_fecha_delete = NOW() WHERE cenco_id = :cenco_id AND cenco_fecha_delete IS NULL");
		$stmt -> bindParam(":cenco_id", $datos, PDO::PARAM_INT);
		if($stmt -> execute() && $stmt->rowCount() > 0){
			return "ok";		
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	MOSTRAR CENTROS DE COSTO ELIMINADOS (PAPELERA)
	=============================================*/

	static public function mdlMostrarCentroCostosEliminados($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE cenco_fecha_delete IS NOT NULL ORDER BY cenco_fecha_delete DESC");
		$stmt->execute();
		return $stmt->fetchAll();
	}

	/*=============================================
	RESTAURAR CENTRO DE COSTO (REVERTIR BORRADO LÓGICO)
	=============================================*/

	static public function mdlRestaurarCentroCosto($tabla, $id){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET cenco_fecha_delete = NULL WHERE cenco_id = :cenco_id AND cenco_fecha_delete IS NOT NULL");
		$stmt->bindParam(":cenco_id", $id, PDO::PARAM_INT);
		if($stmt->execute() && $stmt->rowCount() > 0){
			return "ok";
		}
		return "error";
	}

	/*=============================================
	DEPURAR CENTRO DE COSTO - ELIMINACION FISICA
	=============================================*/

	static public function mdlDepurarCentroCosto($tabla, $id){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE cenco_id = :cenco_id AND cenco_fecha_delete IS NOT NULL");
		$stmt->bindParam(':cenco_id', $id, PDO::PARAM_INT);
		if($stmt->execute() && $stmt->rowCount() > 0){
			return 'ok';
		}
		return 'error';
	}
}// Fin Class
