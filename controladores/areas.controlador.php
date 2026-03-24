<?php

require_once __DIR__ . '/../modelos/auditoria.modelo.php';

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
            self::registrarAuditoriaAreas('CREAR', '0', null, $datos);
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

        // Capturar estado antes de editar
        $areaAntes = ModeloAreas::mdlMostrarAreas($tabla, 'are_id', $id);

        // Ejecutar actualización
        $respuesta = ModeloAreas::mdlEditarArea( $tabla, $datos );

        // Mensaje de éxito o error
        if ( $respuesta == 'ok' ) {
            self::registrarAuditoriaAreas('EDITAR', (string) $id, $areaAntes ?: null, $datos);
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

            $datos = (int) $_GET["idArea"];

            // Capturar estado antes de eliminar
            $areaAntes = ModeloAreas::mdlMostrarAreas($tabla, 'are_id', $datos);

			$respuesta = ModeloAreas::mdlEliminarArea($tabla, $datos);

			if ($respuesta == "ok") {
                self::registrarAuditoriaAreas('ELIMINAR', (string) $datos, $areaAntes ?: null, null);
                self::mostrarAlerta( 'success', 'El área fue enviada a la papelera correctamente.', 'areas' );
            } else {
                self::mostrarAlerta( 'error', 'No se pudo eliminar el área o ya estaba eliminada.', 'areas' );
			}
		}
	}

    /*-------------------------------------
    MOSTRAR AREAS ELIMINADAS
    -------------------------------------*/

    static public function ctrMostrarAreasEliminadas() {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array();
        }

        $tabla = 'areas';
        $respuesta = ModeloAreas::mdlMostrarAreasEliminadas( $tabla );
        return $respuesta;
    }

    /*-------------------------------------
    RESTAURAR AREA
    -------------------------------------*/

    static public function ctrRestaurarArea($id) {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array(
                'status' => 'error',
                'message' => 'Solo los administradores pueden restaurar áreas.'
            );
        }

        $id = (int) $id;
        if ($id <= 0) {
            return array(
                'status' => 'error',
                'message' => 'ID de área inválido.'
            );
        }

        $areaAntes = ModeloAreas::mdlObtenerAreaPorId('areas', $id);

        $respuesta = ModeloAreas::mdlRestaurarArea('areas', $id);

        if ($respuesta === 'ok') {
            $areaDespues = ModeloAreas::mdlMostrarAreas('areas', 'are_id', $id);
            self::registrarAuditoriaAreas('RESTAURAR', (string) $id, $areaAntes ?? null, $areaDespues ?: null);
            return array('status' => 'ok');
        }

        return array(
            'status' => 'error',
            'message' => 'No se pudo restaurar el área o ya estaba activa.'
        );
    }

    /*-------------------------------------
    DEPURAR AREA
    -------------------------------------*/

    static public function ctrDepurarArea($id) {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array(
                'status' => 'error',
                'message' => 'Solo los administradores pueden eliminar áreas definitivamente.'
            );
        }

        $id = (int) $id;
        if ($id <= 0) {
            return array(
                'status' => 'error',
                'message' => 'ID de área inválido.'
            );
        }

        $areaAntes = ModeloAreas::mdlObtenerAreaPorId('areas', $id);

        $respuesta = ModeloAreas::mdlDepurarArea('areas', $id);

        if ($respuesta === 'ok') {
            self::registrarAuditoriaAreas('DEPURAR', (string) $id, $areaAntes ?: null, null);
            return array('status' => 'ok');
        }

        return array(
            'status' => 'error',
            'message' => 'No se pudo eliminar definitivamente el área.'
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

    static public function ctrMostrarAuditoriaAreas($limit = 200) {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array();
        }

        return ModeloAuditoria::mdlMostrarAuditoriaGeneral('areas', (int) $limit);
    }

    private static function registrarAuditoriaAreas($accion, $entidadId, $antes = null, $despues = null) {
        $usuarioActor = isset($_SESSION['usu_id']) ? (int) $_SESSION['usu_id'] : null;

        $camposCambiados = array();
        if (is_array($antes) && is_array($despues)) {
            foreach ($despues as $key => $valueDespues) {
                $valueAntes = array_key_exists($key, $antes) ? $antes[$key] : null;
                if ((string) $valueAntes !== (string) $valueDespues) {
                    $camposCambiados[$key] = array('antes' => $valueAntes, 'despues' => $valueDespues);
                }
            }
        }

        ModeloAuditoria::mdlRegistrarAuditoriaGeneral(
            'areas',
            'areas',
            $entidadId,
            $accion,
            $usuarioActor,
            array('antes' => $antes, 'despues' => $despues, 'campos_cambiados' => $camposCambiados)
        );
    }

}
//Fin Class