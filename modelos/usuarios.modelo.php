<?php
require_once __DIR__ . "/../config/conexion.php";
//require_once "config/conexion.php";


class ModeloUsuarios{

    /**
     * MOSTAR USUARIOS
     */
	static public function mdlMostrarUsuarios($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

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

	/**
	 * CREAR USUARIO
	 */

	static public function mdlCrearUsuario($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(usu_nombre, usu_usuario, usu_password, usu_perfil, usu_foto) VALUES (:usu_nombre, :usu_usuario, :usu_password, :usu_perfil, :usu_foto)");

		$stmt->bindParam(":usu_nombre", $datos["usu_nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":usu_usuario", $datos["usu_usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":usu_password", $datos["usu_password"], PDO::PARAM_STR);
		$stmt->bindParam(":usu_perfil", $datos["usu_perfil"], PDO::PARAM_STR);
		$stmt->bindParam(":usu_foto", $datos["usu_foto"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";	

		}else{

			return "error";
		
		}

		$stmt->close();
		
		$stmt = null;

	}

		/*=============================================
	EDITAR USUARIO
	=============================================*/

	static public function mdlEditarUsuario($tabla, $datos){
	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET usu_nombre = :usu_nombre, usu_password = :usu_password, usu_perfil = :usu_perfil, usu_foto = :usu_foto WHERE usu_usuario = :usu_usuario");

		$stmt -> bindParam(":usu_nombre", $datos["usu_nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":usu_password", $datos["usu_password"], PDO::PARAM_STR);
		$stmt -> bindParam(":usu_perfil", $datos["usu_perfil"], PDO::PARAM_STR);
		$stmt -> bindParam(":usu_foto", $datos["usu_foto"], PDO::PARAM_STR);
		$stmt -> bindParam(":usu_usuario", $datos["usu_usuario"], PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	ACTUALIZAR USUARIO
	=============================================*/

	static public function mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);
		if($stmt -> execute()){
			return "ok";		
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	BORRAR USUARIO
	=============================================*/

	static public function mdlBorrarUsuario($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE usu_id = :usu_id");
		$stmt -> bindParam(":usu_id", $datos, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";		
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}	



}
