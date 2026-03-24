<?php

require_once __DIR__ . '/../modelos/auditoria.modelo.php';

class ControladorCentroCostos {

    /*-------------------------------------
    LISTAR CENTRO DE COSTO
    -------------------------------------*/

    static public function ctrMostrarCentroCostos( $item, $valor ) {
        $tabla = 'centro_costo';
        $respuesta = ModeloCentroCostos::mdlMostrarCentroCostos( $tabla, $item, $valor );
        return $respuesta;
    }

    /*-------------------------------------
    CREAR CENTRO DE COSTO
    -------------------------------------*/

    public static function ctrCrearCentroCosto() {

        if ( !isset( $_POST[ 'inputCodigo' ] ) || !isset( $_POST[ 'inputNombre' ] ) ) {
            return;
        }
        // Sanitizar entradas
        $codigo = trim( $_POST[ 'inputCodigo' ] );
        $nombre = trim( $_POST[ 'inputNombre' ] );

        // Validaciones
        if ( !preg_match( '/^[0-9]+$/', $codigo ) ) {
            self::mostrarAlerta( 'error', '¡El campo código solo permite caracteres numéricos!', 'centro-costo' );
            return;
        }


        // Preparar datos
        $tabla = 'centro_costo';
        $datos = array(
            'cenco_codigo' => $codigo,
            'cenco_nombre' => $nombre
        );

        // Insertar datos en la base de datos
        $respuesta = ModeloCentroCostos::mdlCrearCentroCostos( $tabla, $datos );

        // Mensaje de éxito o error
        if ( $respuesta == 'ok' ) {
            self::registrarAuditoriaCentroCostos('CREAR', '0', null, $datos);
            self::mostrarAlerta( 'success', 'El registro se ha realizado correctamente.', 'centro-costo' );
        } else {
            self::mostrarAlerta( 'error', 'Ocurrió un error al guardar los datos. Por favor, intente nuevamente.', 'centro-costo' );
        }
    }

    /*-------------------------------------
    EDITAR CENTRO DE COSTO
    -------------------------------------*/

    public static function ctrEditarCentroCosto() {
        if ( !isset( $_POST[ 'inputEditId' ] ) ) {
            return;
        }

        // Sanitizar entradas
        $id = trim( $_POST[ 'inputEditId' ] );
        $codigo = trim( $_POST[ 'inputEditCodigo' ] );
        $nombre = trim( $_POST[ 'inputEditNombre' ] );

        // Validaciones
        if ( !preg_match( '/^[0-9]+$/', $codigo ) ) {
            self::mostrarAlerta( 'error', '¡El campo código solo permite caracteres numéricos!', 'centro-costo' );
            return;
        }

        // Registrar fecha y hora de actualización
        date_default_timezone_set( 'America/Lima' );
        $fechaActual = date( 'Y-m-d H:i:s' );

        // Preparar datos
        $tabla = 'centro_costo';
        $datos = array(
            'cenco_id' => $id,
            'cenco_codigo' => $codigo,
            'cenco_nombre' => $nombre,
            'cenco_fecha_update' => $fechaActual 
        );

        // Capturar estado antes de editar
        $centroAntes = ModeloCentroCostos::mdlMostrarCentroCostos($tabla, 'cenco_id', $id);

        // Ejecutar actualización
        $respuesta = ModeloCentroCostos::mdlEditarCentroCosto( $tabla, $datos );

        // Mensaje de éxito o error
        if ( $respuesta == 'ok' ) {
            self::registrarAuditoriaCentroCostos('EDITAR', (string) $id, $centroAntes ?: null, $datos);
            self::mostrarAlerta( 'success', 'Los datos del centro de costo han sido actualizados correctamente', 'centro-costo' );
        } else {
            self::mostrarAlerta( 'error', 'Hubo un problema al actualizar los datos', 'centro-costo' );
        }
    }


    /*-------------------------------------
    ELIMINAR CENTRO DE COSTO
    -------------------------------------*/

	static public function ctrEliminarCentroCosto()
	{
		if (isset($_GET["idCentroCosto"])) {

			$tabla = "centro_costo";

            $datos = (int) $_GET["idCentroCosto"];

            // Capturar estado antes de eliminar
            $centroAntes = ModeloCentroCostos::mdlMostrarCentroCostos($tabla, 'cenco_id', $datos);

			$respuesta = ModeloCentroCostos::mdlEliminarCentroCosto($tabla, $datos);

			if ($respuesta == "ok") {
                self::registrarAuditoriaCentroCostos('ELIMINAR', (string) $datos, $centroAntes ?: null, null);
                self::mostrarAlerta( 'success', 'El centro de costo fue enviado a la papelera correctamente.', 'centro-costo' );
            } else {
                self::mostrarAlerta( 'error', 'No se pudo eliminar el centro de costo o ya estaba eliminado.', 'centro-costo' );
			}
		}
	}

    /*-------------------------------------
    MOSTRAR CENTROS DE COSTO ELIMINADOS
    -------------------------------------*/

    static public function ctrMostrarCentroCostosEliminados() {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array();
        }

        $tabla = 'centro_costo';
        $respuesta = ModeloCentroCostos::mdlMostrarCentroCostosEliminados( $tabla );
        return $respuesta;
    }

    /*-------------------------------------
    RESTAURAR CENTRO DE COSTO
    -------------------------------------*/

    static public function ctrRestaurarCentroCosto($id) {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array(
                'status' => 'error',
                'message' => 'Solo los administradores pueden restaurar centros de costo.'
            );
        }

        $id = (int) $id;
        if ($id <= 0) {
            return array(
                'status' => 'error',
                'message' => 'ID de centro de costo inválido.'
            );
        }

        $centroAntes = ModeloCentroCostos::mdlObtenerCentroCostoPorId('centro_costo', $id);

        $respuesta = ModeloCentroCostos::mdlRestaurarCentroCosto('centro_costo', $id);

        if ($respuesta === 'ok') {
            $centroDespues = ModeloCentroCostos::mdlMostrarCentroCostos('centro_costo', 'cenco_id', $id);
            self::registrarAuditoriaCentroCostos('RESTAURAR', (string) $id, $centroAntes ?: null, $centroDespues ?: null);
            return array('status' => 'ok');
        }

        return array(
            'status' => 'error',
            'message' => 'No se pudo restaurar el centro de costo o ya estaba activo.'
        );
    }

    /*-------------------------------------
    DEPURAR CENTRO DE COSTO
    -------------------------------------*/

    static public function ctrDepurarCentroCosto($id) {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array(
                'status' => 'error',
                'message' => 'Solo los administradores pueden eliminar centros de costo definitivamente.'
            );
        }

        $id = (int) $id;
        if ($id <= 0) {
            return array(
                'status' => 'error',
                'message' => 'ID de centro de costo inválido.'
            );
        }

        $centroAntes = ModeloCentroCostos::mdlObtenerCentroCostoPorId('centro_costo', $id);

        $respuesta = ModeloCentroCostos::mdlDepurarCentroCosto('centro_costo', $id);

        if ($respuesta === 'ok') {
            self::registrarAuditoriaCentroCostos('DEPURAR', (string) $id, $centroAntes ?: null, null);
            return array('status' => 'ok');
        }

        return array(
            'status' => 'error',
            'message' => 'No se pudo eliminar definitivamente el centro de costo.'
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

    static public function ctrMostrarAuditoriaCentroCostos($limit = 200) {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array();
        }

        return ModeloAuditoria::mdlMostrarAuditoriaGeneral('centrocostos', (int) $limit);
    }

    private static function registrarAuditoriaCentroCostos($accion, $entidadId, $antes = null, $despues = null) {
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
            'centrocostos',
            'centro_costo',
            $entidadId,
            $accion,
            $usuarioActor,
            array('antes' => $antes, 'despues' => $despues, 'campos_cambiados' => $camposCambiados)
        );
    }

}
//Fin Class
//Fin Class