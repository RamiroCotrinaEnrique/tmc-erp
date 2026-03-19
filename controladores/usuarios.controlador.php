<?php

require_once __DIR__ . '/../config/accesos.php';

class ControladorUsuarios {

	private static function ctrCargarPermisosModulosSesion($usuarioId, $perfil){
		$privilegios = ModeloUsuarios::mdlObtenerPrivilegiosModulosUsuario((int) $usuarioId);

		$_SESSION['usu_permisos_personalizados'] = isset($privilegios['personalizado']) ? (bool) $privilegios['personalizado'] : false;
		if ($_SESSION['usu_permisos_personalizados']) {
			$_SESSION['usu_modulos_permitidos'] = isset($privilegios['modulos']) && is_array($privilegios['modulos']) ? $privilegios['modulos'] : array();
		} else {
			$_SESSION['usu_modulos_permitidos'] = tmcObtenerModulosPermitidosPorPerfil($perfil);
		}
	}

    /**
     * INGRESO DE USUARIO
     */

    static public function ctrIngresoUsuario() {        

        if (isset($_POST["txtUsuario"])) {
        $txtUsuario = $_POST["txtUsuario"];
        $txtContrasena = $_POST["txtContrasena"];

            if(preg_match('/^[a-zA-Z0-9]+$/', $txtUsuario) && preg_match('/^[a-zA-Z0-9]+$/', $txtContrasena)){
				//$encriptar = crypt($txtContrasena, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
				$encriptar = password_hash($txtContrasena, PASSWORD_BCRYPT);
                $tabla = "usuarios";
                $item = "usu_usuario";
                $valor = $txtUsuario;
                $respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);
    
                if($respuesta["usu_usuario"] == $txtUsuario && password_verify($txtContrasena, $respuesta["usu_password"])){

					if ($respuesta["usu_estado"] == 1) {
						$_SESSION["iniciarSesion"] = "ok";
						$_SESSION["usu_id"] = $respuesta["usu_id"];
						$_SESSION["usu_nombre"] = $respuesta["usu_nombre"];
						$_SESSION["usu_usuario"] = $respuesta["usu_usuario"];
						$_SESSION["usu_perfil"] = $respuesta["usu_perfil"];
						$_SESSION["usu_foto"] = $respuesta["usu_foto"];
						$_SESSION["usu_ultimo_login"] = $respuesta["usu_ultimo_login"];
						$_SESSION['tiempo_ingreso'] = time();
						self::ctrCargarPermisosModulosSesion($respuesta["usu_id"], $respuesta["usu_perfil"]);

						/*=============================================
						REGISTRAR FECHA PARA SABER EL ÚLTIMO LOGIN
						=============================================*/

						date_default_timezone_set('America/Lima');

						$fecha = date('Y-m-d');
						$hora = date('H:i:s');

						$fechaActual = $fecha.' '.$hora;

						$item1 = "usu_ultimo_login";
						$valor1 = $fechaActual;

						$item2 = "usu_id";
						$valor2 = $respuesta["usu_id"];

						$ultimoLogin = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

						if($ultimoLogin == "ok"){
							echo '<script>
								window.location = "inicio";
							</script>';
						}	

					}else{
						echo '<br><div class="alert alert-danger">Usuario aún no esta activado</div>';  
					}      
                }else{
                    echo '<br><div class="alert alert-danger">Error al ingresar, vuelve a intentarlo</div>';
                }                 
            }  
        }
    }

    /**
     * CREAR USUARIO
     */

     static public function ctrCrearUsuario(){

		if(isset($_POST["nuevoUsuario"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoUsuario"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoClave"])){

			   	/*=============================================
				VALIDAR IMAGEN
				=============================================*/

				$ruta = "";

				if( $_FILES["nuevaFoto"]["tmp_name"] != null ){
					list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);
					$nuevoAncho = 500;
					$nuevoAlto = 500;
					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/
					$directorio = "vistas/img/usuarios/".$_POST["nuevoUsuario"];
					mkdir($directorio, 0755);
					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/
					if($_FILES["nuevaFoto"]["type"] == "image/jpeg"){
						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
						$aleatorio = mt_rand(100,999);
						$ruta = "vistas/img/usuarios/".$_POST["nuevoUsuario"]."/".$aleatorio.".jpg";
						$origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);			

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					if($_FILES["nuevaFoto"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/usuarios/".$_POST["nuevoUsuario"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}

				$tabla = "usuarios";

				$encriptar = crypt($_POST["nuevoClave"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				$datos = array("usu_nombre" => $_POST["nuevoNombre"],
					           "usu_usuario" => $_POST["nuevoUsuario"],
					           "usu_password" => $encriptar,
					           "usu_perfil" => $_POST["nuevoPerfil"],
					           "usu_foto"=>$ruta);

				$respuesta = ModeloUsuarios::mdlCrearUsuario($tabla, $datos);
			
				if($respuesta == "ok"){

					echo '<script>

					swal({

						type: "success",
						title: "¡El usuario ha sido guardado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
					}).then(function(result){
						if(result.value){						
							window.location = "usuarios";
						}
					});		
					</script>';
				}	
			}else{
				echo '<script>
					swal({
						type: "error",
						title: "¡El usuario no puede ir vacío o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
					}).then(function(result){
						if(result.value){						
							window.location = "usuarios";
						}
					});			
				</script>';
			}
		}
	}

	/**
     * MOSTRAR USUARIO
     */
	
	static public function ctrMostrarUsuarios($item, $valor){
		$tabla = "usuarios";
		$respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);
		return $respuesta;
	}

	static public function ctrObtenerPrivilegiosModulosUsuario($usuarioId){
		if(!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador'){
			return array(
				'status' => 'error',
				'message' => 'No tiene permisos para revisar privilegios.'
			);
		}

		$usuarioId = (int) $usuarioId;
		if($usuarioId <= 0){
			return array(
				'status' => 'error',
				'message' => 'Usuario invalido.'
			);
		}

		$usuario = self::ctrMostrarUsuarios('usu_id', $usuarioId);
		if(!$usuario){
			return array(
				'status' => 'error',
				'message' => 'Usuario no encontrado.'
			);
		}

		$privilegios = ModeloUsuarios::mdlObtenerPrivilegiosModulosUsuario($usuarioId);
		$modulosEfectivos = isset($privilegios['modulos']) ? $privilegios['modulos'] : array();

		if (empty($modulosEfectivos)) {
			$modulosPerfil = tmcObtenerModulosPermitidosPorPerfil($usuario['usu_perfil']);
			if (in_array('*', $modulosPerfil, true)) {
				$modulosEfectivos = tmcObtenerModulosRegistrados();
			} else {
				$modulosEfectivos = $modulosPerfil;
			}
		}

		return array(
			'status' => 'ok',
			'usuario' => array(
				'usu_id' => $usuario['usu_id'],
				'usu_nombre' => $usuario['usu_nombre'],
				'usu_perfil' => $usuario['usu_perfil']
			),
			'personalizado' => isset($privilegios['personalizado']) ? (bool) $privilegios['personalizado'] : false,
			'modulos' => $modulosEfectivos
		);
	}

	static public function ctrGuardarPrivilegiosModulosUsuario($usuarioId, $modulos){
		if(!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador'){
			return array(
				'status' => 'error',
				'message' => 'No tiene permisos para editar privilegios.'
			);
		}

		$usuarioId = (int) $usuarioId;
		if($usuarioId <= 0){
			return array(
				'status' => 'error',
				'message' => 'Usuario invalido.'
			);
		}

		$usuario = self::ctrMostrarUsuarios('usu_id', $usuarioId);
		if(!$usuario){
			return array(
				'status' => 'error',
				'message' => 'Usuario no encontrado.'
			);
		}

		$modulosRegistrados = tmcObtenerModulosRegistrados();
		$modulosEntrada = is_array($modulos) ? $modulos : array();
		$modulosValidados = array_values(array_unique(array_intersect($modulosEntrada, $modulosRegistrados)));

		if($usuario['usu_perfil'] !== 'Administrador'){
			$modulosValidados = array_values(array_diff($modulosValidados, array('usuarios')));
		}

		$resultado = ModeloUsuarios::mdlGuardarPrivilegiosModulosUsuario($usuarioId, $modulosValidados);

		if(isset($resultado['status']) && $resultado['status'] === 'ok'){
			if(isset($_SESSION['usu_id']) && (int) $_SESSION['usu_id'] === $usuarioId){
				$_SESSION['usu_permisos_personalizados'] = !empty($modulosValidados);
				$_SESSION['usu_modulos_permitidos'] = !empty($modulosValidados)
					? $modulosValidados
					: tmcObtenerModulosPermitidosPorPerfil($usuario['usu_perfil']);
			}
			return array('status' => 'ok');
		}

		return $resultado;
	}

	/*=============================================
	EDITAR USUARIO
	=============================================*/

	static public function ctrEditarUsuario(){

		if(isset($_POST["editarUsuario"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])){

				/*=============================================
				VALIDAR IMAGEN
				=============================================*/

				$ruta = $_POST["fotoActual"];

				if(isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])){

					list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/

					$directorio = "vistas/img/usuarios/".$_POST["editarUsuario"];

					/*=============================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					=============================================*/

					if(!empty($_POST["fotoActual"])){

						unlink($_POST["fotoActual"]);

					}else{

						mkdir($directorio, 0755);

					}	

					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if($_FILES["editarFoto"]["type"] == "image/jpeg"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/usuarios/".$_POST["editarUsuario"]."/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					if($_FILES["editarFoto"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/usuarios/".$_POST["editarUsuario"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}

				$tabla = "usuarios";

				if($_POST["editarClave"] != ""){

					if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarClave"])){

						$encriptar = crypt($_POST["editarClave"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

					}else{

						echo'<script>

								swal({
									  type: "error",
									  title: "¡La contraseña no puede ir vacía o llevar caracteres especiales!",
									  showConfirmButton: true,
									  confirmButtonText: "Cerrar"
									  }).then(function(result){
										if (result.value) {

										window.location = "usuarios";

										}
									})

						  	</script>';

					}

				}else{

					$encriptar = $_POST["claveActual"];

				}

				$datos = array("usu_nombre" => $_POST["editarNombre"],
							   "usu_usuario" => $_POST["editarUsuario"],
							   "usu_password" => $encriptar,
							   "usu_perfil" => $_POST["editarPerfil"],
							   "usu_foto" => $ruta);

				$respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El usuario ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "usuarios";
									}
								})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡El nombre no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "usuarios";
							}
						})
			  	</script>';
			}
		}
	}

	/*=============================================
	BORRAR USUARIO
	=============================================*/

	static public function ctrBorrarUsuario(){

		if(isset($_GET["idUsuario"])){

			$tabla ="usuarios";
			$datos = $_GET["idUsuario"];
			$respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "El usuario ha sido eliminado logicamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "usuarios";
								}
							})
				</script>';
			}else{
				echo'<script>
				swal({
					  type: "error",
					  title: "No se pudo eliminar el usuario o ya estaba eliminado",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
							if (result.value) {
							window.location = "usuarios";
							}
						})
				</script>';
			}
		}
	}






	/*=============================================
	MOSTRAR USUARIOS ELIMINADOS (PAPELERA)
	=============================================*/

	static public function ctrMostrarUsuariosEliminados(){
		$tabla = 'usuarios';
		return ModeloUsuarios::mdlMostrarUsuariosEliminados($tabla);
	}

	/*=============================================
	RESTAURAR USUARIO (SOLO ADMINISTRADOR)
	=============================================*/

	static public function ctrRestaurarUsuario($id){
		if(!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador'){
			return array('status' => 'error', 'message' => 'Sin permisos para restaurar usuarios');
		}
		$id = (int)$id;
		if($id <= 0){
			return array('status' => 'error', 'message' => 'ID de usuario invalido');
		}
		$respuesta = ModeloUsuarios::mdlRestaurarUsuario('usuarios', $id);
		if($respuesta === 'ok'){
			$actorId = isset($_SESSION['usu_id']) ? (int) $_SESSION['usu_id'] : null;
			$detalle = 'Usuario restaurado desde papelera';
			ModeloUsuarios::mdlRegistrarAuditoriaUsuario($actorId, $id, 'RESTAURAR', $detalle);
			return array('status' => 'ok');
		}
		return array('status' => 'error', 'message' => 'No se pudo restaurar el usuario o ya estaba activo');
	}

	/*=============================================
	DEPURAR USUARIO - ELIMINACION FISICA (SOLO ADMINISTRADOR)
	=============================================*/

	static public function ctrDepurarUsuario($id){
		if(!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador'){
			return array('status' => 'error', 'message' => 'Solo los administradores pueden eliminar definitivamente');
		}
		$id = (int)$id;
		if($id <= 0){
			return array('status' => 'error', 'message' => 'ID de usuario invalido');
		}
		if(isset($_SESSION['usu_id']) && (int)$_SESSION['usu_id'] === $id){
			return array('status' => 'error', 'message' => 'No puede eliminar su propia cuenta');
		}
		$respuesta = ModeloUsuarios::mdlDepurarUsuario('usuarios', $id);
		if($respuesta === 'ok'){
			$actorId = isset($_SESSION['usu_id']) ? (int) $_SESSION['usu_id'] : null;
			$detalle = 'Usuario eliminado fisicamente desde papelera';
			ModeloUsuarios::mdlRegistrarAuditoriaUsuario($actorId, $id, 'DEPURAR', $detalle);
			return array('status' => 'ok');
		}
		return array('status' => 'error', 'message' => 'No se pudo eliminar definitivamente al usuario');
	}

}
