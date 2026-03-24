<?php

require_once __DIR__ . '/../modelos/auditoria.modelo.php';

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
        if ( $respuesta == 'ok' ) {            self::registrarAuditoriaEmpresas('CREAR', '0', null, $datos);            self::mostrarAlerta( 'success', 'El registro se ha realizado correctamente.', 'empresas' );
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

        // Snapshot antes de editar
        $empresaAntes = ModeloEmpresas::mdlMostrarEmpresas($tabla, 'empre_id', $id);

        // Ejecutar actualización
        $respuesta = ModeloEmpresas::mdlEditarEmpresa( $tabla, $datos );        

        // Mensaje de éxito o error
        if ( $respuesta == 'ok' ) {
            $empresaDespues = ModeloEmpresas::mdlMostrarEmpresas($tabla, 'empre_id', $id);
            self::registrarAuditoriaEmpresas('EDITAR', $id, $empresaAntes ?: null, $empresaDespues ?: null);
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

            $datos = (int) $_GET["idEmpresa"];

            $empresaAntes = ModeloEmpresas::mdlMostrarEmpresas($tabla, 'empre_id', $datos);

			$respuesta = ModeloEmpresas::mdlEliminarEmpresa($tabla, $datos);

			if ($respuesta == "ok") {
                self::registrarAuditoriaEmpresas('ELIMINAR', $datos, $empresaAntes ?: null, null);
                self::mostrarAlerta( 'success', 'La empresa fue enviada a la papelera correctamente.', 'empresas' );
            } else {
                self::mostrarAlerta( 'error', 'No se pudo eliminar la empresa o ya estaba eliminada.', 'empresas' );
			}
		}
	}

    /*-------------------------------------
    MOSTRAR EMPRESAS ELIMINADAS
    -------------------------------------*/

    static public function ctrMostrarEmpresasEliminadas() {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array();
        }

        $tabla = 'empresas';
        $respuesta = ModeloEmpresas::mdlMostrarEmpresasEliminadas( $tabla );
        return $respuesta;
    }

    /*-------------------------------------
    RESTAURAR EMPRESA
    -------------------------------------*/

    static public function ctrRestaurarEmpresa($id) {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array(
                'status' => 'error',
                'message' => 'Solo los administradores pueden restaurar empresas.'
            );
        }

        $id = (int) $id;
        if ($id <= 0) {
            return array(
                'status' => 'error',
                'message' => 'ID de empresa inválido.'
            );
        }

        $empresaAntes = ModeloEmpresas::mdlObtenerEmpresaPorId('empresas', $id);

        $respuesta = ModeloEmpresas::mdlRestaurarEmpresa('empresas', $id);

        if ($respuesta === 'ok') {
            $empresaDespues = ModeloEmpresas::mdlMostrarEmpresas('empresas', 'empre_id', $id);
            self::registrarAuditoriaEmpresas('RESTAURAR', $id, $empresaAntes ?: null, $empresaDespues ?: null);
            return array('status' => 'ok');
        }

        return array(
            'status' => 'error',
            'message' => 'No se pudo restaurar la empresa o ya estaba activa.'
        );
    }

    /*-------------------------------------
    DEPURAR EMPRESA
    -------------------------------------*/

    static public function ctrDepurarEmpresa($id) {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array(
                'status' => 'error',
                'message' => 'Solo los administradores pueden eliminar empresas definitivamente.'
            );
        }

        $id = (int) $id;
        if ($id <= 0) {
            return array(
                'status' => 'error',
                'message' => 'ID de empresa inválido.'
            );
        }

        $empresaAntes = ModeloEmpresas::mdlObtenerEmpresaPorId('empresas', $id);

        $respuesta = ModeloEmpresas::mdlDepurarEmpresa('empresas', $id);

        if ($respuesta === 'ok') {
            self::registrarAuditoriaEmpresas('DEPURAR', $id, $empresaAntes ?: null, null);
            return array('status' => 'ok');
        }

        return array(
            'status' => 'error',
            'message' => 'No se pudo eliminar definitivamente la empresa.'
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


    /*-------------------------------------
    MOSTRAR AUDITORIA EMPRESAS
    -------------------------------------*/

    public static function ctrMostrarAuditoriaEmpresas($limit = 200) {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array();
        }
        return ModeloAuditoria::mdlMostrarAuditoriaGeneral('empresas', $limit);
    }

    /*-------------------------------------
    REGISTRAR AUDITORIA EMPRESAS (privado)
    -------------------------------------*/

    private static function registrarAuditoriaEmpresas($accion, $entidadId, $antes, $despues) {
        $usuarioId = isset($_SESSION['usu_id']) ? (int)$_SESSION['usu_id'] : null;
        $detalle = array();
        if ($accion === 'EDITAR' && $antes && $despues) {
            $camposCambiados = array();
            $campos = ['empre_ruc','empre_razon_social','empre_nombre_comercial','empre_domicilio_legal','empre_numero_contacto','empre_email_contacto'];
            foreach ($campos as $campo) {
                if (isset($antes[$campo], $despues[$campo]) && (string)$antes[$campo] !== (string)$despues[$campo]) {
                    $camposCambiados[$campo] = array('antes' => $antes[$campo], 'despues' => $despues[$campo]);
                }
            }
            if (!empty($camposCambiados)) {
                $detalle['campos_cambiados'] = $camposCambiados;
            }
        } elseif ($antes) {
            $detalle['antes'] = $antes;
        }
        if ($despues && $accion !== 'EDITAR') {
            $detalle['despues'] = $despues;
        }
        ModeloAuditoria::mdlRegistrarAuditoriaGeneral('empresas', 'empresas', (string)$entidadId, $accion, $usuarioId, $detalle);
    }

}
//Fin Class