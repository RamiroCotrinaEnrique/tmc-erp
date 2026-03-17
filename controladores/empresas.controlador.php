<?php

class ControladorEmpresas {

    /*-------------------------------------
    LISTAR EMPRESAS
    -------------------------------------*/

    static public function ctrMostrarEmpresas( $item, $valor ) {
        $tabla = 'empresas';
        $respuesta = ModeloEmpresas::mdlMostrarEmpresas( $tabla, $item, $valor );
        return $respuesta;
    }

    /*-------------------------------------
    CREAR EMPRESAS
    -------------------------------------*/

    public static function ctrCrearEmpresa() {

        if ( !isset( $_POST[ 'inputRuc' ] ) || !isset( $_POST[ 'inputRazonSocial' ] ) ) {
            return;
        }


        // Sanitizar entradas
        $ruc = trim( $_POST[ 'inputRuc' ] );
        $razonSocial = trim( $_POST[ 'inputRazonSocial' ] );
        $nombreComercial = trim( $_POST[ 'inputNombreComercial' ] );
        $domicilioLegal = trim( $_POST[ 'inputDomicilioLegal' ] );
        $contacto = trim( $_POST[ 'inputNumeroContacto' ] );
        $email = trim( $_POST[ 'inputEmail' ] );

        // Validaciones
        if ( !preg_match( '/^[0-9]+$/', $ruc ) ) {
            self::mostrarAlerta( 'error', '¡El campo RUC solo permite caracteres numéricos!', 'empresas' );
            return;
        }

        if ( empty( $razonSocial ) ) {
            self::mostrarAlerta( 'error', '¡El campo razón social no puede estar vacío!', 'empresas' );
            return;
        }

        // Preparar datos
        $tabla = 'empresas';
        $datos = array(
            'empre_ruc' => $ruc,
            'empre_razon_social' => $razonSocial,
            'empre_nombre_comercial' => $nombreComercial,
            'empre_domicilio_legal' => $domicilioLegal,
            'empre_numero_contacto' => $contacto,
            'empre_email_contacto' => $email
        );

        // Insertar datos en la base de datos
        $respuesta = ModeloEmpresas::mdlCrearEmpresas( $tabla, $datos );

        // Mensaje de éxito o error
        if ( $respuesta == 'ok' ) {
            self::mostrarAlerta( 'success', 'El registro se ha realizado correctamente.', 'empresas' );
        } else {
            self::mostrarAlerta( 'error', 'Ocurrió un error al guardar los datos. Por favor, intente nuevamente.', 'empresas' );
        }
    }

    /*-------------------------------------
    EDITAR EMPRESA
    -------------------------------------*/

    public static function ctrEditarEmpresa() {
        if ( !isset( $_POST[ 'inputEditId' ] ) ) {
            return;
        }

        // Sanitizar entradas
        $id = trim( $_POST[ 'inputEditId' ] ); 
        $ruc = trim( $_POST[ 'inputEditRuc' ] );
        $razonSocial = trim( $_POST[ 'inputEditRazonSocial' ] );
        $nombreComercial = trim( $_POST[ 'inputEditNombreComercial' ] );
        $domicilioLegal = trim( $_POST[ 'inputEditDomicilioLegal' ] );
        $contacto = trim( $_POST[ 'inputEditNumeroContacto' ] );
        $email = trim( $_POST[ 'inputEditEmail' ] );

        // Validaciones
        if ( !preg_match( '/^[0-9]+$/', $ruc ) ) {
            self::mostrarAlerta( 'error', '¡El campo RUC solo permite caracteres numéricos!', 'empresas' );
            return;
        }

        if ( empty( $razonSocial ) ) {
            self::mostrarAlerta( 'error', '¡El campo razón social no puede estar vacío!', 'empresas' );
            return;
        }

        // Registrar fecha y hora de actualización
        date_default_timezone_set( 'America/Lima' );
        $fechaActual = date( 'Y-m-d H:i:s' );

        // Preparar datos
        $tabla = 'empresas';
        $datos = array(
            'empre_id' => $id,
            'empre_ruc' => $ruc,
            'empre_razon_social' => $razonSocial,
            'empre_nombre_comercial' => $nombreComercial,
            'empre_domicilio_legal' => $domicilioLegal,
            'empre_numero_contacto' => $contacto,
            'empre_email_contacto' => $email,
            'empre_fecha_update' => $fechaActual 
        );

        // Ejecutar actualización
        $respuesta = ModeloEmpresas::mdlEditarEmpresa( $tabla, $datos );

        // Mensaje de éxito o error
        if ( $respuesta == 'ok' ) {
            self::mostrarAlerta( 'success', 'Los datos de la empresa han sido actualizados correctamente', 'empresas' );
        } else {
            self::mostrarAlerta( 'error', 'Hubo un problema al actualizar los datos', 'empresas' );
        }
    }


    /*-------------------------------------
    ELIMINAR CENTRO DE COSTO
    -------------------------------------*/

	static public function ctrEliminarEmpresa()
	{
		if (isset($_GET["idEmpresa"])) {

			$tabla = "empresas";

			$datos = $_GET["idEmpresa"];

			$respuesta = ModeloEmpresas::mdlEliminarEmpresa($tabla, $datos);

			if ($respuesta == "ok") {
				self::mostrarAlerta( 'success', 'Datos de la empresa ha sido borrado correctamente', 'empresas' );
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