<?php
require_once __DIR__ . "/../config/conexion.php";
//require_once "config/conexion.php";


class ModeloUsuarios{

	private static function mdlCrearTablaPermisosModulosSiNoExiste($cn) {
		$cn->exec("
			CREATE TABLE IF NOT EXISTS usuarios_modulos (
				umod_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
				usu_id INT NOT NULL,
				modulo VARCHAR(80) NOT NULL,
				umod_fecha_creacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (umod_id),
				UNIQUE KEY uk_usuario_modulo (usu_id, modulo),
				KEY idx_usuarios_modulos_usuario (usu_id)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
		");
	}

	private static function mdlCrearTablaAuditoriaUsuariosSiNoExiste($cn) {
		$cn->exec("
			CREATE TABLE IF NOT EXISTS usuarios_auditoria (
				uaud_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
				actor_usu_id INT NULL,
				objetivo_usu_id INT NOT NULL,
				accion VARCHAR(30) NOT NULL,
				detalle VARCHAR(255) NULL,
				ip_origen VARCHAR(45) NULL,
				uaud_fecha_creacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (uaud_id),
				KEY idx_uaud_actor (actor_usu_id),
				KEY idx_uaud_objetivo (objetivo_usu_id),
				KEY idx_uaud_accion (accion)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
		");
	}

    /**
     * MOSTAR USUARIOS
     */
	static public function mdlMostrarUsuarios($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND usu_fecha_delete IS NULL LIMIT 1");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE usu_fecha_delete IS NULL ORDER BY usu_id DESC");

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
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET usu_estado = 0, usu_fecha_delete = NOW() WHERE usu_id = :usu_id AND usu_fecha_delete IS NULL");
		$stmt -> bindParam(":usu_id", $datos, PDO::PARAM_INT);
		if($stmt -> execute() && $stmt->rowCount() > 0){
			return "ok";		
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}	

	static public function mdlObtenerPrivilegiosModulosUsuario($usuarioId){
		$cn = Conexion::conectar();
		self::mdlCrearTablaPermisosModulosSiNoExiste($cn);

		$stmt = $cn->prepare("SELECT modulo FROM usuarios_modulos WHERE usu_id = :usu_id ORDER BY modulo ASC");
		$stmt->bindParam(':usu_id', $usuarioId, PDO::PARAM_INT);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$modulos = array();
		foreach($rows as $row){
			$modulos[] = $row['modulo'];
		}

		return array(
			'personalizado' => count($modulos) > 0,
			'modulos' => $modulos
		);
	}

	static public function mdlGuardarPrivilegiosModulosUsuario($usuarioId, $modulos){
		$cn = Conexion::conectar();
		self::mdlCrearTablaPermisosModulosSiNoExiste($cn);

		try{
			$cn->beginTransaction();

			$stmtDelete = $cn->prepare("DELETE FROM usuarios_modulos WHERE usu_id = :usu_id");
			$stmtDelete->bindParam(':usu_id', $usuarioId, PDO::PARAM_INT);
			$stmtDelete->execute();

			if(!empty($modulos)){
				$stmtInsert = $cn->prepare("INSERT INTO usuarios_modulos (usu_id, modulo) VALUES (:usu_id, :modulo)");
				foreach($modulos as $modulo){
					$stmtInsert->bindParam(':usu_id', $usuarioId, PDO::PARAM_INT);
					$stmtInsert->bindParam(':modulo', $modulo, PDO::PARAM_STR);
					$stmtInsert->execute();
				}
			}

			$cn->commit();
			return array('status' => 'ok');
		}catch(Exception $e){
			if($cn->inTransaction()){
				$cn->rollBack();
			}
			return array(
				'status' => 'error',
				'message' => 'No se pudieron guardar los privilegios del usuario.'
			);
		}
	}

	/*=============================================
	MOSTRAR USUARIOS ELIMINADOS (PAPELERA)
	=============================================*/

	static public function mdlMostrarUsuariosEliminados($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE usu_fecha_delete IS NOT NULL ORDER BY usu_fecha_delete DESC");
		$stmt->execute();
		return $stmt->fetchAll();
	}

	/*=============================================
	RESTAURAR USUARIO (REVERTIR BORRADO LÓGICO)
	=============================================*/

	static public function mdlRestaurarUsuario($tabla, $id){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET usu_estado = 1, usu_fecha_delete = NULL WHERE usu_id = :usu_id AND usu_fecha_delete IS NOT NULL");
		$stmt->bindParam(":usu_id", $id, PDO::PARAM_INT);
		if($stmt->execute() && $stmt->rowCount() > 0){
			return "ok";
		}
		return "error";
	}



	/*=============================================
	DEPURAR USUARIO - ELIMINACION FISICA (SOLO MASTER)
	=============================================*/

	static public function mdlDepurarUsuario($tabla, $id){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE usu_id = :usu_id");
		$stmt->bindParam(':usu_id', $id, PDO::PARAM_INT);
		if($stmt->execute() && $stmt->rowCount() > 0){
			return 'ok';
		}
		return 'error';
	}

	/*=============================================
	REGISTRAR AUDITORIA DE ACCIONES SOBRE USUARIOS
	=============================================*/

	static public function mdlRegistrarAuditoriaUsuario($actorUsuId, $objetivoUsuId, $accion, $detalle = null){
		$cn = Conexion::conectar();
		self::mdlCrearTablaAuditoriaUsuariosSiNoExiste($cn);

		$ipOrigen = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
		$stmt = $cn->prepare("INSERT INTO usuarios_auditoria (actor_usu_id, objetivo_usu_id, accion, detalle, ip_origen) VALUES (:actor_usu_id, :objetivo_usu_id, :accion, :detalle, :ip_origen)");
		$stmt->bindParam(':actor_usu_id', $actorUsuId, PDO::PARAM_INT);
		$stmt->bindParam(':objetivo_usu_id', $objetivoUsuId, PDO::PARAM_INT);
		$stmt->bindParam(':accion', $accion, PDO::PARAM_STR);
		$stmt->bindParam(':detalle', $detalle, PDO::PARAM_STR);
		$stmt->bindParam(':ip_origen', $ipOrigen, PDO::PARAM_STR);

		return (bool) $stmt->execute();
	}
}
