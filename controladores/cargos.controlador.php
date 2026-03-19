<?php

class ControladorCargos {

    /*-------------------------------------
    LISTAR CENTRO DE COSTO
    -------------------------------------*/

    static public function ctrMostrarCargos( $item, $valor ) {
        $tabla = 'cargos';
        $respuesta = ModeloCargos::mdlMostrarCargos( $tabla, $item, $valor );
        return $respuesta;
    }

    /*-------------------------------------
    CREAR CENTRO DE COSTO
    -------------------------------------*/

    public static function ctrCrearCargo() {

        if (!isset( $_POST[ 'inputNombre' ] ) ) {
            return;
        }

        // Sanitizar entradas 
        $nombre = trim( $_POST[ 'inputNombre' ] );         

        // Preparar datos
        $tabla = 'cargos';
        $datos = array( 
            'car_nombre' => $nombre
        );

        // Insertar datos en la base de datos
        $respuesta = ModeloCargos::mdlCrearCargo( $tabla, $datos );

        // Mensaje de éxito o error
        if ( $respuesta == 'ok' ) {
            self::mostrarAlerta( 'success', 'El registro se ha realizado correctamente.', 'cargos' );
        } else {
            self::mostrarAlerta( 'error', 'Ocurrió un error al guardar los datos. Por favor, intente nuevamente.', 'cargos' );
        }
    }

    /*-------------------------------------
    EDITAR CARGO
    -------------------------------------*/

    public static function ctrEditarCargo() {
        if ( !isset( $_POST[ 'inputEditId' ] ) ) {
            return;
        }

        // Sanitizar entradas
        $id = trim( $_POST[ 'inputEditId' ] ); 
        $nombre = trim( $_POST[ 'inputEditNombre' ] );

        // Validaciones
        if ( !preg_match( '/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $nombre ) ) {
            self::mostrarAlerta( 'error', '¡El campo nombre no pueden estar vacíos ni llevar caracteres especiales!', 'cargos' );
            return;
        }

        // Registrar fecha y hora de actualización
        date_default_timezone_set( 'America/Lima' );
        $fechaActual = date( 'Y-m-d H:i:s' );

        // Preparar datos
        $tabla = 'cargos';
        $datos = array(
            'car_id' => $id, 
            'car_nombre' => $nombre,
            'car_fecha_update' => $fechaActual 
        );

        // Ejecutar actualización
        $respuesta = ModeloCargos::mdlEditarCargo( $tabla, $datos );

        // Mensaje de éxito o error
        if ( $respuesta == 'ok' ) {
            self::mostrarAlerta( 'success', 'Los datos han sido actualizados correctamente', 'cargos' );
        } else {
            self::mostrarAlerta( 'error', 'Hubo un problema al actualizar los datos', 'cargos' );
        }
    }


    /*-------------------------------------
    ELIMINAR CARGO
    -------------------------------------*/

	static public function ctrEliminarCargo()
	{
		if (isset($_GET["idCargo"])) {

			$tabla = "cargos";

            $datos = (int) $_GET["idCargo"];

			$respuesta = ModeloCargos::mdlEliminarCargo($tabla, $datos);

			if ($respuesta == "ok") {
                self::mostrarAlerta( 'success', 'El cargo fue enviado a la papelera correctamente.', 'cargos' );
            } else {
                self::mostrarAlerta( 'error', 'No se pudo eliminar el cargo o ya estaba eliminado.', 'cargos' );
			}
		}
	}

    /*-------------------------------------
    MOSTRAR CARGOS ELIMINADOS
    -------------------------------------*/

    static public function ctrMostrarCargosEliminados() {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array();
        }

        $tabla = 'cargos';
        $respuesta = ModeloCargos::mdlMostrarCargosEliminados( $tabla );
        return $respuesta;
    }

    /*-------------------------------------
    RESTAURAR CARGO
    -------------------------------------*/

    static public function ctrRestaurarCargo($id) {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array(
                'status' => 'error',
                'message' => 'Solo los administradores pueden restaurar cargos.'
            );
        }

        $id = (int) $id;
        if ($id <= 0) {
            return array(
                'status' => 'error',
                'message' => 'ID de cargo inválido.'
            );
        }

        $respuesta = ModeloCargos::mdlRestaurarCargo('cargos', $id);

        if ($respuesta === 'ok') {
            return array('status' => 'ok');
        }

        return array(
            'status' => 'error',
            'message' => 'No se pudo restaurar el cargo o ya estaba activo.'
        );
    }

    /*-------------------------------------
    DEPURAR CARGO
    -------------------------------------*/

    static public function ctrDepurarCargo($id) {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array(
                'status' => 'error',
                'message' => 'Solo los administradores pueden eliminar cargos definitivamente.'
            );
        }

        $id = (int) $id;
        if ($id <= 0) {
            return array(
                'status' => 'error',
                'message' => 'ID de cargo inválido.'
            );
        }

        $respuesta = ModeloCargos::mdlDepurarCargo('cargos', $id);

        if ($respuesta === 'ok') {
            return array('status' => 'ok');
        }

        return array(
            'status' => 'error',
            'message' => 'No se pudo eliminar definitivamente el cargo.'
        );
    }

	
    // Método para mostrar alertas con SweetAlert
    private static function mostrarAlerta( $tipo, $mensaje, $redireccion ) {
        echo '<script>
            swal({
                type: "' . $tipo . '",
                title: "' . $mensaje . '",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
            }).then(function(result){
                if (result.value) {
                    window.location = "' . $redireccion . '";
                }
            });
        </script>';
    }


}
//Fin Class