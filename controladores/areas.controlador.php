<?php

class ControladorAreas {

    /*-------------------------------------
    LISTAR CENTRO DE COSTO
    -------------------------------------*/

    static public function ctrMostrarAreas( $item, $valor ) {
        $tabla = 'areas';
        $respuesta = ModeloAreas::mdlMostrarAreas( $tabla, $item, $valor );
        return $respuesta;
    }

    /*-------------------------------------
    CREAR CENTRO DE COSTO
    -------------------------------------*/

    public static function ctrCrearArea() {

        if (!isset( $_POST[ 'inputNombre' ] ) ) {
            return;
        }

        // Sanitizar entradas 
        $nombre = trim( $_POST[ 'inputNombre' ] );         

        // Preparar datos
        $tabla = 'areas';
        $datos = array( 
            'are_nombre' => $nombre
        );

        // Insertar datos en la base de datos
        $respuesta = ModeloAreas::mdlCrearArea( $tabla, $datos );

        // Mensaje de éxito o error
        if ( $respuesta == 'ok' ) {
            self::mostrarAlerta( 'success', 'El registro se ha realizado correctamente.', 'areas' );
        } else {
            self::mostrarAlerta( 'error', 'Ocurrió un error al guardar los datos. Por favor, intente nuevamente.', 'areas' );
        }
    }

    /*-------------------------------------
    EDITAR CENTRO DE COSTO
    -------------------------------------*/

    public static function ctrEditarArea() {
        if ( !isset( $_POST[ 'inputEditId' ] ) ) {
            return;
        }

        // Sanitizar entradas
        $id = trim( $_POST[ 'inputEditId' ] ); 
        $nombre = trim( $_POST[ 'inputEditNombre' ] );

        // Validaciones
        if ( !preg_match( '/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $nombre ) ) {
            self::mostrarAlerta( 'error', '¡El campo nombre no pueden estar vacíos ni llevar caracteres especiales!', 'centro-costo' );
            return;
        }

        // Registrar fecha y hora de actualización
        date_default_timezone_set( 'America/Lima' );
        $fechaActual = date( 'Y-m-d H:i:s' );

        // Preparar datos
        $tabla = 'areas';
        $datos = array(
            'are_id' => $id, 
            'are_nombre' => $nombre,
            'are_fecha_update' => $fechaActual 
        );

        // Ejecutar actualización
        $respuesta = ModeloAreas::mdlEditarArea( $tabla, $datos );

        // Mensaje de éxito o error
        if ( $respuesta == 'ok' ) {
            self::mostrarAlerta( 'success', 'Datos actualizados correctamente', 'areas' );
        } else {
            self::mostrarAlerta( 'error', 'Hubo un problema al actualizar los datos', 'areas' );
        }
    }


    /*-------------------------------------
    ELIMINAR CENTRO DE COSTO
    -------------------------------------*/

	static public function ctrEliminarArea()
	{
		if (isset($_GET["idArea"])) {

			$tabla = "areas";

			$datos = $_GET["idArea"];

			$respuesta = ModeloAreas::mdlEliminarArea($tabla, $datos);

			if ($respuesta == "ok") {
				self::mostrarAlerta( 'success', 'Datos eliminados correctamente', 'areas' );
			}
		}
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