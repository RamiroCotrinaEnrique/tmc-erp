<?php

require_once __DIR__ . "/../config/conexion.php";


class ModeloEstudiantes{

    /**
     * MOSTAR ESTUDIANTES
     */

    static public function mdlMostrarEstudiantes($tabla, $item, $valor){
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
	CREAR ESTUDIANTES
	=============================================*/

	static public function mdlIngresarEstudiantes($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(est_nombres, est_apellidos, est_fecha_nacimiento, est_genero, est_direccion, est_telefono, est_mail, est_curso_actual) 
		VALUES (:est_nombres, :est_apellidos, :est_fecha_nacimiento, :est_genero, :est_direccion, :est_telefono, :est_mail, :est_curso_actual)");
		$stmt->bindParam(":est_nombres", $datos["est_nombres"], PDO::PARAM_STR);
		$stmt->bindParam(":est_apellidos", $datos["est_apellidos"], PDO::PARAM_STR);
		$stmt->bindParam(":est_fecha_nacimiento", $datos["est_fecha_nacimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":est_genero", $datos["est_genero"], PDO::PARAM_STR);
		$stmt->bindParam(":est_direccion", $datos["est_direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":est_telefono", $datos["est_telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":est_mail", $datos["est_mail"], PDO::PARAM_STR);
		$stmt->bindParam(":est_curso_actual", $datos["est_curso_actual"], PDO::PARAM_STR);
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
	EDITAR ESTUDIANTE
	=============================================*/

	static public function mdlEditarEstudiante($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET 
		est_nombres = :est_nombres, 
		est_apellidos=:est_apellidos, 
		est_fecha_nacimiento=:est_fecha_nacimiento, 
		est_genero=:est_genero, 
		est_direccion=:est_direccion, 
		est_telefono=:est_telefono, 
		est_mail=:est_mail, 
		est_curso_actual=:est_curso_actual 
		WHERE est_id = :est_id");

		$stmt->bindParam(":est_nombres", $datos["est_nombres"], PDO::PARAM_STR);
		$stmt->bindParam(":est_apellidos", $datos["est_apellidos"], PDO::PARAM_STR);
		$stmt->bindParam(":est_fecha_nacimiento", $datos["est_fecha_nacimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":est_genero", $datos["est_genero"], PDO::PARAM_STR);
		$stmt->bindParam(":est_direccion", $datos["est_direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":est_telefono", $datos["est_telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":est_mail", $datos["est_mail"], PDO::PARAM_STR);
		$stmt->bindParam(":est_curso_actual", $datos["est_curso_actual"], PDO::PARAM_STR);
		$stmt->bindParam(":est_id", $datos["est_id"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";		
		}
		$stmt->close();
		$stmt = null;
	}

		/*=============================================
	BORRAR ESTUDIANTE
	=============================================*/

	static public function mdlBorrarEstudiante($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE est_id = :est_id");
		$stmt -> bindParam(":est_id", $datos, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";		
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}
}// Fin Class
