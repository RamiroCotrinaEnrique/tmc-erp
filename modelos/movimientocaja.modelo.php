<?php

require_once __DIR__ . "/../config/conexion.php";


class ModeloMovimientoCaja{

    /*-------------------------------------
    LISTAR EMPRESAS
    -------------------------------------*/

    static public function mdlMostrarMovimientoCaja($tabla, $item, $valor){
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


    /*-------------------------------------
    CREAR EMPRESAS
    -------------------------------------*/

	static public function mdlCrearEmpresas($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(empre_ruc, empre_razon_social, empre_nombre_comercial, empre_domicilio_legal, empre_numero_contacto, empre_email_contacto)  VALUES (:empre_ruc, :empre_razon_social, :empre_nombre_comercial, :empre_domicilio_legal, :empre_numero_contacto, :empre_email_contacto)");

		$stmt->bindParam(":empre_ruc", $datos["empre_ruc"], PDO::PARAM_STR); 
		$stmt->bindParam(":empre_razon_social", $datos["empre_razon_social"], PDO::PARAM_STR); 
		$stmt->bindParam(":empre_nombre_comercial", $datos["empre_nombre_comercial"], PDO::PARAM_STR); 
		$stmt->bindParam(":empre_domicilio_legal", $datos["empre_domicilio_legal"], PDO::PARAM_STR); 
		$stmt->bindParam(":empre_numero_contacto", $datos["empre_numero_contacto"], PDO::PARAM_STR); 
		$stmt->bindParam(":empre_email_contacto", $datos["empre_email_contacto"], PDO::PARAM_STR); 
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

	static public function mdlEditarEmpresa($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET 
		empre_ruc = :empre_ruc, empre_razon_social = :empre_razon_social, empre_nombre_comercial = :empre_nombre_comercial, empre_domicilio_legal = :empre_domicilio_legal, empre_numero_contacto = :empre_numero_contacto, empre_email_contacto = :empre_email_contacto,  empre_fecha_update = :empre_fecha_update  WHERE empre_id = :empre_id");

		$stmt->bindParam(":empre_ruc", $datos["empre_ruc"], PDO::PARAM_STR); 
		$stmt->bindParam(":empre_razon_social", $datos["empre_razon_social"], PDO::PARAM_STR); 
		$stmt->bindParam(":empre_nombre_comercial", $datos["empre_nombre_comercial"], PDO::PARAM_STR); 
		$stmt->bindParam(":empre_domicilio_legal", $datos["empre_domicilio_legal"], PDO::PARAM_STR); 
		$stmt->bindParam(":empre_numero_contacto", $datos["empre_numero_contacto"], PDO::PARAM_STR); 
		$stmt->bindParam(":empre_email_contacto", $datos["empre_email_contacto"], PDO::PARAM_STR); 
		$stmt->bindParam(":empre_fecha_update", $datos["empre_fecha_update"], PDO::PARAM_STR); 

		$stmt->bindParam(":empre_id", $datos["empre_id"], PDO::PARAM_STR);

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

	static public function mdlEliminarEmpresa($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE empre_id = :empre_id");
		$stmt -> bindParam(":empre_id", $datos, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";		
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}
}// Fin Class
