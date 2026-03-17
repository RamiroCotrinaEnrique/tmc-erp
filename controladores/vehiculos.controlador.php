<?php

class ControladorVehiculos {

    /*-------------------------------------
    LISTAR VEHICULOS
    -------------------------------------*/

    static public function ctrMostrarVehiculos( $item, $valor ) {
        $tabla = 'vehiculos';
        $respuesta = ModeloVehiculos::mdlMostrarVehiculos( $tabla, $item, $valor );
        return $respuesta;
    }

    /*-------------------------------------
    CREAR VEHICULOS
    -------------------------------------*/

    public static function ctrCrearVehiculo() {

        if ( !isset( $_POST[ 'inputCentro' ] ) ) {
            return;
        }

        // Sanitizar entradas
        $centroId = trim( $_POST[ 'inputCentro' ] );
        $placa = trim( $_POST[ 'inputPlaca' ] );
        $marca = trim( $_POST[ 'inputMarca' ] );
        $modelo = trim( $_POST[ 'inputModelo' ] );
        $anio = trim( $_POST[ 'inputAnio' ] );
        $clase = trim( $_POST[ 'inputClase' ] );
        $numeroVin = trim( $_POST[ 'inputNumeroVin' ] );
        $numeroMotor = trim( $_POST[ 'inputNumeroMotor' ] );
        $jefeOperacion = trim( $_POST[ 'inputJefeOperacion' ] );
        $estado = trim( $_POST[ 'inputEstado' ] );
        $propietario = trim( $_POST[ 'inputPropietario' ] );

        // Validaciones
        if ( !preg_match( '/^[0-9]+$/', $centroId ) ) {
            self::mostrarAlerta( 'error', '¡El campo RUC solo permite caracteres numéricos!', 'empresas' );
            return;
        } 

        // Preparar datos
        $tabla = 'vehiculos';
        $datos = array(
            'vehic_cenco_id' => $centroId,
            'vehic_placa' => $placa,
            'vehic_marca' => $marca,
            'vehic_modelo' => $modelo,
            'vehic_anio' => $anio,
            'vehic_clase' => $clase,
            'vehic_numero_vin' => $numeroVin,
            'vehic_numero_motor' => $numeroMotor,
            'vehic_jefe_operacion' => $jefeOperacion,
            'vehic_estado' => $estado,
            'vehic_propietario' => $propietario 
        );

        // Insertar datos en la base de datos
        $respuesta = ModeloVehiculos::mdlCrearVehiculos( $tabla, $datos );

        // Mensaje de éxito o error
        if ( $respuesta == 'ok' ) {
            self::mostrarAlerta( 'success', 'El registro se ha realizado correctamente.', 'vehiculos' );
        } else {
            self::mostrarAlerta( 'error', 'Ocurrió un error al guardar los datos. Por favor, intente nuevamente.', 'vehiculos' );
        }
    }

    /*-------------------------------------
    EDITAR EMPRESA
    -------------------------------------*/

    public static function ctrEditarVehiculo() {
        if ( !isset( $_POST[ 'inputEditId' ] ) ) {
            return;
        }

        // Sanitizar entradas
        $id = trim( $_POST[ 'inputEditId' ] ); 
        $centroId = trim( $_POST[ 'inputEditCentro' ] );
        $placa = trim( $_POST[ 'inputEditPlaca' ] );
        $marca = trim( $_POST[ 'inputEditMarca' ] );
        $modelo = trim( $_POST[ 'inputEditModelo' ] );
        $anio = trim( $_POST[ 'inputEditAnio' ] );
        $clase = trim( $_POST[ 'inputEditClase' ] );
        $numeroVin = trim( $_POST[ 'inputEditNumeroVin' ] );
        $numeroMotor = trim( $_POST[ 'inputEditNumeroMotor' ] );
        $jefeOperacion = trim( $_POST[ 'inputEditJefeOperacion' ] );
        $estado = trim( $_POST[ 'inputEditEstado' ] );
        $propietario = trim( $_POST[ 'inputEditPropietario' ] );
       
        // Registrar fecha y hora de actualización
        date_default_timezone_set( 'America/Lima' );
        $fechaActual = date( 'Y-m-d H:i:s' );

        // Preparar datos        
        $tabla = 'vehiculos';

        $datos = array(
            'vehic_id' => $id,
            'vehic_cenco_id' => $centroId,
            'vehic_placa' => $placa,
            'vehic_marca' => $marca,
            'vehic_modelo' => $modelo,
            'vehic_anio' => $anio,
            'vehic_clase' => $clase,
            'vehic_numero_vin' => $numeroVin,
            'vehic_numero_motor' => $numeroMotor,
            'vehic_jefe_operacion' => $jefeOperacion,
            'vehic_estado' => $estado,
            'vehic_propietario' => $propietario,            
            'vehic_fecha_update' => $fechaActual  
        );

        // Ejecutar actualización
        $respuesta = ModeloVehiculos::mdlEditarVehiculo( $tabla, $datos );

        // Mensaje de éxito o error
        if ( $respuesta == 'ok' ) {
            self::mostrarAlerta( 'success', 'Los datos se actualizaron correctamente.', 'vehiculos' );
        } else {
            self::mostrarAlerta( 'error', 'Ocurrió un error al intentar actualizar los datos. Por favor, inténtelo nuevamente.', 'vehiculos' );
        }
        
    }

    /*-------------------------------------
    EDITAR VEHICULO VIA AJAX (RETORNA JSON)
    -------------------------------------*/

    public static function ctrEditarVehiculoAjax($datos) {
        try {
            // Validar que todos los campos necesarios existan
            $camposRequeridos = ['vehic_id', 'vehic_cenco_id', 'vehic_placa'];
            foreach($camposRequeridos as $campo) {
                if(empty($datos[$campo])) {
                    file_put_contents('error_actualizacion.log', "Campo requerido vacío: $campo\n", FILE_APPEND);
                    return "error";
                }
            }
            
            // Registrar fecha y hora de actualización
            date_default_timezone_set('America/Lima');
            $fechaActual = date('Y-m-d H:i:s');
            
            // Agregar fecha de actualización
            $datos['vehic_fecha_update'] = $fechaActual;

            // Ejecutar actualización
            $tabla = 'vehiculos';
            file_put_contents('error_actualizacion.log', "Intentando actualizar vehículo ID: " . $datos['vehic_id'] . "\n", FILE_APPEND);
            
            $respuesta = ModeloVehiculos::mdlEditarVehiculo($tabla, $datos);
            
            file_put_contents('error_actualizacion.log', "Respuesta de mdlEditarVehiculo: $respuesta\n", FILE_APPEND);

            // Retornar JSON 
            return $respuesta;
        } catch (Exception $e) {
            file_put_contents('error_actualizacion.log', "Excepción: " . $e->getMessage() . "\n", FILE_APPEND);
            return "error";
        }
    }


    /*-------------------------------------
    ELIMINAR VEHICULO
    -------------------------------------*/

	static public function ctrEliminarVehiculo()
	{
		if (isset($_GET["idVehiculo"])) {

			$tabla = "vehiculos";

			$datos = $_GET["idVehiculo"];

			$respuesta = ModeloVehiculos::mdlEliminarVehiculo($tabla, $datos);

			if ($respuesta == "ok") {
				self::mostrarAlerta( 'success', 'Los datos han sido borrado correctamente', 'vehiculos' );
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