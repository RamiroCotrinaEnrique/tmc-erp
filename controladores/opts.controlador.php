<?php

require_once __DIR__ . '/../modelos/auditoria.modelo.php';

class ControladorOpts {

    /*-------------------------------------
    LISTAR EMPRESAS
    -------------------------------------*/

    static public function ctrMostrarOpts( $item, $valor ) {
        $tabla = 'opts';
        $respuesta = ModeloOpts::mdlMostrarOpts( $tabla, $item, $valor );
        return $respuesta;
    }

    static public function ctrMostrarOptsEliminados() {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array();
        }

        $tabla = 'opts';
        return ModeloOpts::mdlMostrarOptsEliminados($tabla);
    }

    /*-------------------------------------
    CREAR OPT
    -------------------------------------*/

    public static function ctrCrearOpts() {

        if ( !isset( $_POST[ 'inputOperacion' ] ) || !isset( $_POST[ 'inputPlaca' ] ) ) {
            return;
        }
                /*=============================================
				VALIDAR IMAGEN 01
				=============================================*/
                $ruta1 = "";

                if ($_FILES["nuevaFoto1"]["tmp_name"] != null ) {
                    list($ancho1, $alto1) = getimagesize($_FILES["nuevaFoto1"]["tmp_name"]);
                    $nuevaAncho = 500;
                    $nuevaAlto = 500;

                    /*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/
                    date_default_timezone_set('America/Lima');
                    $fecha = date('Y-m-d');
                    $hora = date('H');
                    $min = date('i');
                    $seg = date('s');
                    $horas = $hora . '-' . $min . '-' . $seg;
                    $nombreCarpeta = $fecha . '_' . $horas; 

                    $directorio = "vistas/img/sig/opt/" . $nombreCarpeta;
 
                    if (!file_exists($directorio)) {
                        mkdir($directorio, 0755);
                    }       

                    /*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/
                    if ($_FILES["nuevaFoto1"]["type"] == "image/jpeg" ) {
                        /*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
                        $aleatorio1 = mt_rand(100, 300);
                        $ruta1 = "vistas/img/sig/opt/" . $nombreCarpeta  . "/" . $aleatorio1 . ".jpg";                        
                        $origen1 = imagecreatefromjpeg($_FILES["nuevaFoto1"]["tmp_name"]);
                        $destino1 = imagecreatetruecolor($nuevaAncho, $nuevaAlto);
                        imagecopyresized($destino1, $origen1, 0, 0, 0, 0, $nuevaAncho, $nuevaAlto, $ancho1, $alto1);
                        imagejpeg($destino1, $ruta1);
                    }

                    if ($_FILES["nuevaFoto1"]["type"] == "image/png" ) {
                        /*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
                        $aleatorio1 = mt_rand(100, 300);
                        $ruta1 = "vistas/img/sig/opt/" . $nombreCarpeta  . "/" . $aleatorio1 . ".png";
                        $origen1 = imagecreatefrompng($_FILES["nuevaFoto1"]["tmp_name"]);
                        $destino1 = imagecreatetruecolor($nuevaAncho, $nuevaAlto);
                        imagecopyresized($destino1, $origen1, 0, 0, 0, 0, $nuevaAncho, $nuevaAlto, $ancho1, $alto1);
                        imagepng($destino1, $ruta1);
                    }
                }
                /*=============================================
				VALIDAR IMAGEN 02
				=============================================*/
                $ruta2 = "";

                if ($_FILES["nuevaFoto2"]["tmp_name"] != null) { 
                    list($ancho2, $alto2) = getimagesize($_FILES["nuevaFoto2"]["tmp_name"]);

                    $nuevaAncho = 500;
                    $nuevaAlto = 500;

                    /*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/
                    date_default_timezone_set('America/Lima');
                    $fecha = date('Y-m-d');
                    $hora = date('H');
                    $min = date('i');
                    $seg = date('s');
                    $horas = $hora . '-' . $min . '-' . $seg;
                    $nombreCarpeta = $fecha . '_' . $horas;

                    $directorio = "vistas/img/sig/opt/" . $nombreCarpeta;

                    if (!file_exists($directorio)) {
                        mkdir($directorio, 0755);
                    }  

                    /*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/
                    if ($_FILES["nuevaFoto2"]["type"] == "image/jpeg") {
                        /*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
                        $aleatorio2 = mt_rand(400, 700);
                        $ruta2 = "vistas/img/sig/opt/" . $nombreCarpeta . "/" . $aleatorio2 . ".jpg";
                        $origen2 = imagecreatefromjpeg($_FILES["nuevaFoto2"]["tmp_name"]);
                        $destino2 = imagecreatetruecolor($nuevaAncho, $nuevaAlto);
                        imagecopyresized($destino2, $origen2, 0, 0, 0, 0, $nuevaAncho, $nuevaAlto, $ancho2, $alto2);
                        imagejpeg($destino2, $ruta2);
                    }

                    if ( $_FILES["nuevaFoto2"]["type"] == "image/png") {
                        /*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
                        $aleatorio2 = mt_rand(400, 700);
                        $ruta2 = "vistas/img/sig/opt/" . $nombreCarpeta . "/" . $aleatorio2 . ".png";
                        $origen2 = imagecreatefrompng($_FILES["nuevaFoto2"]["tmp_name"]);
                        $destino2 = imagecreatetruecolor($nuevaAncho, $nuevaAlto);
                        imagecopyresized($destino2, $origen2, 0, 0, 0, 0, $nuevaAncho, $nuevaAlto, $ancho2, $alto2);
                        imagepng($destino2, $ruta2);
                    }
                }

                // Sanitizar entradas 
                $numero = trim($_POST['inputOperacion']);
                $operacion = str_replace('tabla', '', $numero); 

                $placa = trim( $_POST[ 'inputPlaca' ] );
                $fecha = trim( $_POST[ 'inputFecha' ] );
                $cliente = trim( $_POST[ 'inputCliente' ] );
                $lugar = trim( $_POST[ 'inputLugar' ] );
                $observado = trim( $_POST[ 'inputObservado' ] );
                $observador = trim( $_POST[ 'inputObservador' ] );
                $buenasPracticas = trim( $_POST[ 'inputBuenasPracticas' ] );

                $txt500Pregunta1 = trim( $_POST[ '500_txtPregunta1' ] );
                $txt500Pregunta2 = trim( $_POST[ '500_txtPregunta2' ] );
                $txt500Pregunta3 = trim( $_POST[ '500_txtPregunta3' ] );
                $txt500Pregunta4 = trim( $_POST[ '500_txtPregunta4' ] );
                $txt500Pregunta5 = trim( $_POST[ '500_txtPregunta5' ] );
                $txt500Pregunta6 = trim( $_POST[ '500_txtPregunta6' ] );
                $txt500Pregunta7 = trim( $_POST[ '500_txtPregunta7' ] );
                $txt500Pregunta8 = trim( $_POST[ '500_txtPregunta8' ] );
                $txt500Pregunta9 = trim( $_POST[ '500_txtPregunta9' ] );
                $txt500Pregunta10 = trim( $_POST[ '500_txtPregunta10' ] );
                $txt500Pregunta11 = trim( $_POST[ '500_txtPregunta11' ] );
                $txt500Pregunta12 = trim( $_POST[ '500_txtPregunta12' ] );
                $txt500Pregunta13 = trim( $_POST[ '500_txtPregunta13' ] );
                $txt500Pregunta14 = trim( $_POST[ '500_txtPregunta14' ] );
                $txt500Pregunta15 = trim( $_POST[ '500_txtPregunta15' ] );
                $txt500Otros = trim( $_POST[ '500_txtOtros' ] );

                $txt501Pregunta1 = trim( $_POST[ '501_txtPregunta1' ] );
                $txt501Pregunta2 = trim( $_POST[ '501_txtPregunta2' ] );
                $txt501Pregunta3 = trim( $_POST[ '501_txtPregunta3' ] );
                $txt501Pregunta4 = trim( $_POST[ '501_txtPregunta4' ] );
                $txt501Pregunta5 = trim( $_POST[ '501_txtPregunta5' ] );
                $txt501Pregunta6 = trim( $_POST[ '501_txtPregunta6' ] );
                $txt501Pregunta7 = trim( $_POST[ '501_txtPregunta7' ] );
                $txt501Pregunta8 = trim( $_POST[ '501_txtPregunta8' ] );
                $txt501Pregunta9 = trim( $_POST[ '501_txtPregunta9' ] );
                $txt501Pregunta10 = trim( $_POST[ '501_txtPregunta10' ] );
                $txt501Pregunta11 = trim( $_POST[ '501_txtPregunta11' ] );
                $txt501Pregunta12 = trim( $_POST[ '501_txtPregunta12' ] );
                $txt501Pregunta13 = trim( $_POST[ '501_txtPregunta13' ] );
                $txt501Pregunta14 = trim( $_POST[ '501_txtPregunta14' ] );
                $txt501Otros = trim( $_POST[ '501_txtOtros' ] );

                $txt504Pregunta1 = trim( $_POST[ '504_txtPregunta1' ] );
                $txt504Pregunta2 = trim( $_POST[ '504_txtPregunta2' ] );
                $txt504Pregunta3 = trim( $_POST[ '504_txtPregunta3' ] );
                $txt504Pregunta4 = trim( $_POST[ '504_txtPregunta4' ] );
                $txt504Pregunta5 = trim( $_POST[ '504_txtPregunta5' ] );
                $txt504Pregunta6 = trim( $_POST[ '504_txtPregunta6' ] );
                $txt504Pregunta7 = trim( $_POST[ '504_txtPregunta7' ] );
                $txt504Pregunta8 = trim( $_POST[ '504_txtPregunta8' ] );
                $txt504Pregunta9 = trim( $_POST[ '504_txtPregunta9' ] );
                $txt504Pregunta10 = trim( $_POST[ '504_txtPregunta10' ] );
                $txt504Pregunta11 = trim( $_POST[ '504_txtPregunta11' ] );
                $txt504Pregunta12 = trim( $_POST[ '504_txtPregunta12' ] );
                $txt504Pregunta13 = trim( $_POST[ '504_txtPregunta13' ] );
                $txt504Pregunta14 = trim( $_POST[ '504_txtPregunta14' ] );
                $txt504Pregunta15 = trim( $_POST[ '504_txtPregunta15' ] ); 
                $txt504Pregunta16 = trim( $_POST[ '504_txtPregunta16' ] );
                $txt504Pregunta17 = trim( $_POST[ '504_txtPregunta17' ] );
                $txt504Pregunta18 = trim( $_POST[ '504_txtPregunta18' ] );
                $txt504Pregunta19 = trim( $_POST[ '504_txtPregunta19' ] );
                $txt504Pregunta20 = trim( $_POST[ '504_txtPregunta20' ] );
                $txt504Pregunta21 = trim( $_POST[ '504_txtPregunta21' ] );
                $txt504Pregunta22 = trim( $_POST[ '504_txtPregunta22' ] );
                $txt504Pregunta23 = trim( $_POST[ '504_txtPregunta23' ] );
                $txt504Pregunta24 = trim( $_POST[ '504_txtPregunta24' ] );
                $txt504Pregunta25 = trim( $_POST[ '504_txtPregunta25' ] );
                $txt504Otros = trim( $_POST[ '504_txtOtros' ] );
                
                $txt506Pregunta1 = trim( $_POST[ '506_txtPregunta1' ] );
                $txt506Pregunta2 = trim( $_POST[ '506_txtPregunta2' ] );
                $txt506Pregunta3 = trim( $_POST[ '506_txtPregunta3' ] );
                $txt506Pregunta4 = trim( $_POST[ '506_txtPregunta4' ] );
                $txt506Pregunta5 = trim( $_POST[ '506_txtPregunta5' ] );
                $txt506Pregunta6 = trim( $_POST[ '506_txtPregunta6' ] );
                $txt506Pregunta7 = trim( $_POST[ '506_txtPregunta7' ] );
                $txt506Pregunta8 = trim( $_POST[ '506_txtPregunta8' ] );
                $txt506Pregunta9 = trim( $_POST[ '506_txtPregunta9' ] );
                $txt506Pregunta10 = trim( $_POST[ '506_txtPregunta10' ] );
                $txt506Pregunta11 = trim( $_POST[ '506_txtPregunta11' ] );
                $txt506Pregunta12 = trim( $_POST[ '506_txtPregunta12' ] );
                $txt506Pregunta13 = trim( $_POST[ '506_txtPregunta13' ] ); 
                $txt506Otros = trim( $_POST[ '506_txtOtros' ] );

                $txt507Pregunta1 = trim( $_POST[ '507_txtPregunta1' ] );
                $txt507Pregunta2 = trim( $_POST[ '507_txtPregunta2' ] );
                $txt507Pregunta3 = trim( $_POST[ '507_txtPregunta3' ] );
                $txt507Pregunta4 = trim( $_POST[ '507_txtPregunta4' ] );
                $txt507Pregunta5 = trim( $_POST[ '507_txtPregunta5' ] );
                $txt507Pregunta6 = trim( $_POST[ '507_txtPregunta6' ] );
                $txt507Pregunta7 = trim( $_POST[ '507_txtPregunta7' ] );
                $txt507Pregunta8 = trim( $_POST[ '507_txtPregunta8' ] );
                $txt507Pregunta9 = trim( $_POST[ '507_txtPregunta9' ] );
                $txt507Pregunta10 = trim( $_POST[ '507_txtPregunta10' ] );
                $txt507Pregunta11 = trim( $_POST[ '507_txtPregunta11' ] );
                $txt507Pregunta12 = trim( $_POST[ '507_txtPregunta12' ] );
                $txt507Pregunta13 = trim( $_POST[ '507_txtPregunta13' ] );
                $txt507Pregunta14 = trim( $_POST[ '507_txtPregunta14' ] );
                $txt507Pregunta15 = trim( $_POST[ '507_txtPregunta15' ] ); 
                $txt507Pregunta16 = trim( $_POST[ '507_txtPregunta16' ] );
                $txt507Pregunta17 = trim( $_POST[ '507_txtPregunta17' ] );
                $txt507Pregunta18 = trim( $_POST[ '507_txtPregunta18' ] );
                $txt507Pregunta19 = trim( $_POST[ '507_txtPregunta19' ] );
                $txt507Pregunta20 = trim( $_POST[ '507_txtPregunta20' ] );
                $txt507Pregunta21 = trim( $_POST[ '507_txtPregunta21' ] );
                $txt507Pregunta22 = trim( $_POST[ '507_txtPregunta22' ] );
                $txt507Pregunta23 = trim( $_POST[ '507_txtPregunta23' ] );
                $txt507Pregunta24 = trim( $_POST[ '507_txtPregunta24' ] );
                $txt507Pregunta25 = trim( $_POST[ '507_txtPregunta25' ] );
                $txt507Otros = trim( $_POST[ '507_txtOtros' ] );

                $txt508Pregunta1 = trim( $_POST[ '508_txtPregunta1' ] );
                $txt508Pregunta2 = trim( $_POST[ '508_txtPregunta2' ] );
                $txt508Pregunta3 = trim( $_POST[ '508_txtPregunta3' ] );
                $txt508Pregunta4 = trim( $_POST[ '508_txtPregunta4' ] );
                $txt508Pregunta5 = trim( $_POST[ '508_txtPregunta5' ] );
                $txt508Pregunta6 = trim( $_POST[ '508_txtPregunta6' ] );
                $txt508Pregunta7 = trim( $_POST[ '508_txtPregunta7' ] );
                $txt508Pregunta8 = trim( $_POST[ '508_txtPregunta8' ] );
                $txt508Pregunta9 = trim( $_POST[ '508_txtPregunta9' ] );
                $txt508Pregunta10 = trim( $_POST[ '508_txtPregunta10' ] );
                $txt508Pregunta11 = trim( $_POST[ '508_txtPregunta11' ] );
                $txt508Pregunta12 = trim( $_POST[ '508_txtPregunta12' ] );
                $txt508Pregunta13 = trim( $_POST[ '508_txtPregunta13' ] ); 
                $txt508Otros = trim( $_POST[ '508_txtOtros' ] );

                $txt509Pregunta1 = trim( $_POST[ '509_txtPregunta1' ] );
                $txt509Pregunta2 = trim( $_POST[ '509_txtPregunta2' ] );
                $txt509Pregunta3 = trim( $_POST[ '509_txtPregunta3' ] );
                $txt509Pregunta4 = trim( $_POST[ '509_txtPregunta4' ] );
                $txt509Pregunta5 = trim( $_POST[ '509_txtPregunta5' ] );
                $txt509Pregunta6 = trim( $_POST[ '509_txtPregunta6' ] );
                $txt509Pregunta7 = trim( $_POST[ '509_txtPregunta7' ] );
                $txt509Pregunta8 = trim( $_POST[ '509_txtPregunta8' ] );
                $txt509Pregunta9 = trim( $_POST[ '509_txtPregunta9' ] );
                $txt509Pregunta10 = trim( $_POST[ '509_txtPregunta10' ] );
                $txt509Pregunta11 = trim( $_POST[ '509_txtPregunta11' ] );
                $txt509Pregunta12 = trim( $_POST[ '509_txtPregunta12' ] );
                $txt509Pregunta13 = trim( $_POST[ '509_txtPregunta13' ] );
                $txt509Pregunta14 = trim( $_POST[ '509_txtPregunta14' ] );
                $txt509Pregunta15 = trim( $_POST[ '509_txtPregunta15' ] ); 
                $txt509Pregunta16 = trim( $_POST[ '509_txtPregunta16' ] );
                $txt509Pregunta17 = trim( $_POST[ '509_txtPregunta17' ] );
                $txt509Pregunta18 = trim( $_POST[ '509_txtPregunta18' ] );
                $txt509Pregunta19 = trim( $_POST[ '509_txtPregunta19' ] );
                $txt509Pregunta20 = trim( $_POST[ '509_txtPregunta20' ] );
                $txt509Pregunta21 = trim( $_POST[ '509_txtPregunta21' ] );
                $txt509Pregunta22 = trim( $_POST[ '509_txtPregunta22' ] );
                $txt509Pregunta23 = trim( $_POST[ '509_txtPregunta23' ] );
                $txt509Pregunta24 = trim( $_POST[ '509_txtPregunta24' ] );
                $txt509Pregunta25 = trim( $_POST[ '509_txtPregunta25' ] );
                $txt509Otros = trim( $_POST[ '509_txtOtros' ] );

                $txt511Pregunta1 = trim( $_POST[ '511_txtPregunta1' ] );
                $txt511Pregunta2 = trim( $_POST[ '511_txtPregunta2' ] );
                $txt511Pregunta3 = trim( $_POST[ '511_txtPregunta3' ] );
                $txt511Pregunta4 = trim( $_POST[ '511_txtPregunta4' ] );
                $txt511Pregunta5 = trim( $_POST[ '511_txtPregunta5' ] );
                $txt511Pregunta6 = trim( $_POST[ '511_txtPregunta6' ] );
                $txt511Pregunta7 = trim( $_POST[ '511_txtPregunta7' ] );
                $txt511Pregunta8 = trim( $_POST[ '511_txtPregunta8' ] );
                $txt511Pregunta9 = trim( $_POST[ '511_txtPregunta9' ] );
                $txt511Pregunta10 = trim( $_POST[ '511_txtPregunta10' ] );
                $txt511Pregunta11 = trim( $_POST[ '511_txtPregunta11' ] );
                $txt511Pregunta12 = trim( $_POST[ '511_txtPregunta12' ] );
                $txt511Pregunta13 = trim( $_POST[ '511_txtPregunta13' ] );
                $txt511Pregunta14 = trim( $_POST[ '511_txtPregunta14' ] );
                $txt511Pregunta15 = trim( $_POST[ '511_txtPregunta15' ] ); 
                $txt511Pregunta16 = trim( $_POST[ '511_txtPregunta16' ] );
                $txt511Pregunta17 = trim( $_POST[ '511_txtPregunta17' ] );
                $txt511Pregunta18 = trim( $_POST[ '511_txtPregunta18' ] );
                $txt511Pregunta19 = trim( $_POST[ '511_txtPregunta19' ] );
                $txt511Pregunta20 = trim( $_POST[ '511_txtPregunta20' ] );
                $txt511Pregunta21 = trim( $_POST[ '511_txtPregunta21' ] );
                $txt511Pregunta22 = trim( $_POST[ '511_txtPregunta22' ] );
                $txt511Pregunta23 = trim( $_POST[ '511_txtPregunta23' ] );
                $txt511Pregunta24 = trim( $_POST[ '511_txtPregunta24' ] );
                $txt511Pregunta25 = trim( $_POST[ '511_txtPregunta25' ] );
                $txt511Otros = trim( $_POST[ '511_txtOtros' ] );
                
                $descripcionAdicional = trim( $_POST[ 'inputDescripcionAdicional' ] );
                $tipoHallazgo = trim( $_POST[ 'inputTipoHallazgo' ] );
                $descripcionObservacion = trim( $_POST[ 'inputDescripcionObservacion' ] );
                $relacionado = trim( $_POST[ 'inputRelacionado' ] );
                $correccion = trim( $_POST[ 'inputCorreccion' ] );

                $user = trim( $_POST[ 'inputUser' ] );            

                // Validaciones
            /*  if ( !preg_match( '/^[0-9]+$/', $operacion ) ) {
                    self::mostrarAlerta( 'error', '¡El campo RUC solo permite caracteres numéricos!', 'empresas' );
                    return;
                }

                if ( !preg_match( '/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $razonSocial ) ) {
                    self::mostrarAlerta( 'error', '¡El campo razon social  no puede estar vacío ni contener caracteres especiales!', 'empresas' );
                    return;
                }*/

                // Preparar datos
                $tabla = 'opts';
                $datos = array(
                    'opt_cenco_codigo' => $operacion,
                    'opt_vehiculo_id' => $placa,
                    'opt_cliente' => $cliente,
                    'opt_lugar' => $lugar,
                    'opt_fecha' => $fecha,
                    'opt_observado' => $observado,
                    'opt_observador' => $observador,
                    'opt_bps_encontrada' => $buenasPracticas,
                    
                    'opt_500_pregunta1' => $txt500Pregunta1,
                    'opt_500_pregunta2' => $txt500Pregunta2,
                    'opt_500_pregunta3' => $txt500Pregunta3,
                    'opt_500_pregunta4' => $txt500Pregunta4,
                    'opt_500_pregunta5' => $txt500Pregunta5,
                    'opt_500_pregunta6' => $txt500Pregunta6,
                    'opt_500_pregunta7' => $txt500Pregunta7,
                    'opt_500_pregunta8' => $txt500Pregunta8,
                    'opt_500_pregunta9' => $txt500Pregunta9,
                    'opt_500_pregunta10' => $txt500Pregunta10,
                    'opt_500_pregunta11' => $txt500Pregunta11,
                    'opt_500_pregunta12' => $txt500Pregunta12,
                    'opt_500_pregunta13' => $txt500Pregunta13,
                    'opt_500_pregunta14' => $txt500Pregunta14,
                    'opt_500_pregunta15' => $txt500Pregunta15,
                    'opt_500_otros' => $txt500Otros,  
                    
                    'opt_501_pregunta1' => $txt501Pregunta1,
                    'opt_501_pregunta2' => $txt501Pregunta2,
                    'opt_501_pregunta3' => $txt501Pregunta3,
                    'opt_501_pregunta4' => $txt501Pregunta4,
                    'opt_501_pregunta5' => $txt501Pregunta5,
                    'opt_501_pregunta6' => $txt501Pregunta6,
                    'opt_501_pregunta7' => $txt501Pregunta7,
                    'opt_501_pregunta8' => $txt501Pregunta8,
                    'opt_501_pregunta9' => $txt501Pregunta9,
                    'opt_501_pregunta10' => $txt501Pregunta10,
                    'opt_501_pregunta11' => $txt501Pregunta11,
                    'opt_501_pregunta12' => $txt501Pregunta12,
                    'opt_501_pregunta13' => $txt501Pregunta13,
                    'opt_501_pregunta14' => $txt501Pregunta14,
                    'opt_501_otros' => $txt501Otros,

                    'opt_504_pregunta1' => $txt504Pregunta1,
                    'opt_504_pregunta2' => $txt504Pregunta2,
                    'opt_504_pregunta3' => $txt504Pregunta3,
                    'opt_504_pregunta4' => $txt504Pregunta4,
                    'opt_504_pregunta5' => $txt504Pregunta5,
                    'opt_504_pregunta6' => $txt504Pregunta6,
                    'opt_504_pregunta7' => $txt504Pregunta7,
                    'opt_504_pregunta8' => $txt504Pregunta8,
                    'opt_504_pregunta9' => $txt504Pregunta9,
                    'opt_504_pregunta10' => $txt504Pregunta10,
                    'opt_504_pregunta11' => $txt504Pregunta11,
                    'opt_504_pregunta12' => $txt504Pregunta12,
                    'opt_504_pregunta13' => $txt504Pregunta13,
                    'opt_504_pregunta14' => $txt504Pregunta14,
                    'opt_504_pregunta15' => $txt504Pregunta15,
                    'opt_504_pregunta16' => $txt504Pregunta16,
                    'opt_504_pregunta17' => $txt504Pregunta17,
                    'opt_504_pregunta18' => $txt504Pregunta18,
                    'opt_504_pregunta19' => $txt504Pregunta19,
                    'opt_504_pregunta20' => $txt504Pregunta20,
                    'opt_504_pregunta21' => $txt504Pregunta21,
                    'opt_504_pregunta22' => $txt504Pregunta22,
                    'opt_504_pregunta23' => $txt504Pregunta23,
                    'opt_504_pregunta24' => $txt504Pregunta24,
                    'opt_504_pregunta25' => $txt504Pregunta25, 
                    'opt_504_otros' => $txt504Otros,

                    'opt_506_pregunta1' => $txt506Pregunta1,
                    'opt_506_pregunta2' => $txt506Pregunta2,
                    'opt_506_pregunta3' => $txt506Pregunta3,
                    'opt_506_pregunta4' => $txt506Pregunta4,
                    'opt_506_pregunta5' => $txt506Pregunta5,
                    'opt_506_pregunta6' => $txt506Pregunta6,
                    'opt_506_pregunta7' => $txt506Pregunta7,
                    'opt_506_pregunta8' => $txt506Pregunta8,
                    'opt_506_pregunta9' => $txt506Pregunta9,
                    'opt_506_pregunta10' => $txt506Pregunta10,
                    'opt_506_pregunta11' => $txt506Pregunta11,
                    'opt_506_pregunta12' => $txt506Pregunta12,
                    'opt_506_pregunta13' => $txt506Pregunta13, 
                    'opt_506_otros' => $txt506Otros,

                    'opt_507_pregunta1' => $txt507Pregunta1,
                    'opt_507_pregunta2' => $txt507Pregunta2,
                    'opt_507_pregunta3' => $txt507Pregunta3,
                    'opt_507_pregunta4' => $txt507Pregunta4,
                    'opt_507_pregunta5' => $txt507Pregunta5,
                    'opt_507_pregunta6' => $txt507Pregunta6,
                    'opt_507_pregunta7' => $txt507Pregunta7,
                    'opt_507_pregunta8' => $txt507Pregunta8,
                    'opt_507_pregunta9' => $txt507Pregunta9,
                    'opt_507_pregunta10' => $txt507Pregunta10,
                    'opt_507_pregunta11' => $txt507Pregunta11,
                    'opt_507_pregunta12' => $txt507Pregunta12,
                    'opt_507_pregunta13' => $txt507Pregunta13,
                    'opt_507_pregunta14' => $txt507Pregunta14,
                    'opt_507_pregunta15' => $txt507Pregunta15,
                    'opt_507_pregunta16' => $txt507Pregunta16,
                    'opt_507_pregunta17' => $txt507Pregunta17,
                    'opt_507_pregunta18' => $txt507Pregunta18,
                    'opt_507_pregunta19' => $txt507Pregunta19,
                    'opt_507_pregunta20' => $txt507Pregunta20,
                    'opt_507_pregunta21' => $txt507Pregunta21,
                    'opt_507_pregunta22' => $txt507Pregunta22,
                    'opt_507_pregunta23' => $txt507Pregunta23,
                    'opt_507_pregunta24' => $txt507Pregunta24,
                    'opt_507_pregunta25' => $txt507Pregunta25, 
                    'opt_507_otros' => $txt507Otros,

                    'opt_508_pregunta1' => $txt508Pregunta1,
                    'opt_508_pregunta2' => $txt508Pregunta2,
                    'opt_508_pregunta3' => $txt508Pregunta3,
                    'opt_508_pregunta4' => $txt508Pregunta4,
                    'opt_508_pregunta5' => $txt508Pregunta5,
                    'opt_508_pregunta6' => $txt508Pregunta6,
                    'opt_508_pregunta7' => $txt508Pregunta7,
                    'opt_508_pregunta8' => $txt508Pregunta8,
                    'opt_508_pregunta9' => $txt508Pregunta9,
                    'opt_508_pregunta10' => $txt508Pregunta10,
                    'opt_508_pregunta11' => $txt508Pregunta11,
                    'opt_508_pregunta12' => $txt508Pregunta12,
                    'opt_508_pregunta13' => $txt508Pregunta13, 
                    'opt_508_otros' => $txt508Otros,

                    'opt_509_pregunta1' => $txt509Pregunta1,
                    'opt_509_pregunta2' => $txt509Pregunta2,
                    'opt_509_pregunta3' => $txt509Pregunta3,
                    'opt_509_pregunta4' => $txt509Pregunta4,
                    'opt_509_pregunta5' => $txt509Pregunta5,
                    'opt_509_pregunta6' => $txt509Pregunta6,
                    'opt_509_pregunta7' => $txt509Pregunta7,
                    'opt_509_pregunta8' => $txt509Pregunta8,
                    'opt_509_pregunta9' => $txt509Pregunta9,
                    'opt_509_pregunta10' => $txt509Pregunta10,
                    'opt_509_pregunta11' => $txt509Pregunta11,
                    'opt_509_pregunta12' => $txt509Pregunta12,
                    'opt_509_pregunta13' => $txt509Pregunta13,
                    'opt_509_pregunta14' => $txt509Pregunta14,
                    'opt_509_pregunta15' => $txt509Pregunta15,
                    'opt_509_pregunta16' => $txt509Pregunta16,
                    'opt_509_pregunta17' => $txt509Pregunta17,
                    'opt_509_pregunta18' => $txt509Pregunta18,
                    'opt_509_pregunta19' => $txt509Pregunta19,
                    'opt_509_pregunta20' => $txt509Pregunta20,
                    'opt_509_pregunta21' => $txt509Pregunta21,
                    'opt_509_pregunta22' => $txt509Pregunta22,
                    'opt_509_pregunta23' => $txt509Pregunta23,
                    'opt_509_pregunta24' => $txt509Pregunta24,
                    'opt_509_pregunta25' => $txt509Pregunta25, 
                    'opt_509_otros' => $txt509Otros,

                    'opt_511_pregunta1' => $txt511Pregunta1,
                    'opt_511_pregunta2' => $txt511Pregunta2,
                    'opt_511_pregunta3' => $txt511Pregunta3,
                    'opt_511_pregunta4' => $txt511Pregunta4,
                    'opt_511_pregunta5' => $txt511Pregunta5,
                    'opt_511_pregunta6' => $txt511Pregunta6,
                    'opt_511_pregunta7' => $txt511Pregunta7,
                    'opt_511_pregunta8' => $txt511Pregunta8,
                    'opt_511_pregunta9' => $txt511Pregunta9,
                    'opt_511_pregunta10' => $txt511Pregunta10,
                    'opt_511_pregunta11' => $txt511Pregunta11,
                    'opt_511_pregunta12' => $txt511Pregunta12,
                    'opt_511_pregunta13' => $txt511Pregunta13,
                    'opt_511_pregunta14' => $txt511Pregunta14,
                    'opt_511_pregunta15' => $txt511Pregunta15,
                    'opt_511_pregunta16' => $txt511Pregunta16,
                    'opt_511_pregunta17' => $txt511Pregunta17,
                    'opt_511_pregunta18' => $txt511Pregunta18,
                    'opt_511_pregunta19' => $txt511Pregunta19,
                    'opt_511_pregunta20' => $txt511Pregunta20,
                    'opt_511_pregunta21' => $txt511Pregunta21,
                    'opt_511_pregunta22' => $txt511Pregunta22,
                    'opt_511_pregunta23' => $txt511Pregunta23,
                    'opt_511_pregunta24' => $txt511Pregunta24,
                    'opt_511_pregunta25' => $txt511Pregunta25, 
                    'opt_511_otros' => $txt511Otros,
 
                    'opt_tipo_hallazgo' => $tipoHallazgo, 
                    'opt_relacionado' => $relacionado, 
                    'opt_decripcion_observacion' => $descripcionObservacion, 
                    'opt_decripcion_adicional' => $descripcionAdicional, 
                    'opt_correccion' => $correccion, 
                    'opt_evidencia1' => $ruta1, 
                    'opt_evidencia2' => $ruta2, 
                    'opt_id_usuario' => $user 

                );   

                // Insertar datos en la base de datos
                $respuesta = ModeloOpts::mdlCrearOpts( $tabla, $datos );
        
                // Mensaje de éxito o error
                if ( $respuesta == 'ok' ) {
                    self::registrarAuditoriaOpts('CREAR', '0', null, $datos);
                    self::mostrarAlerta( 'success', 'El registro se ha realizado correctamente.', 'sig-opt' );
                } else {
                    self::mostrarAlerta( 'error', 'Ocurrió un error al guardar los datos. Por favor, intente nuevamente.', 'sig-opt' );
                } 
    }

    /*-------------------------------------
    EDITAR EMPRESA
    -------------------------------------*/

    public static function ctrEditarOpt() {

        if ( !isset( $_POST[ 'inputEditarOperacion' ] ) || !isset( $_POST[ 'inputEditarPlaca' ] ) ) {
            return;
        }

                /*=============================================
				VALIDAR IMAGEN 01
				=============================================*/
                $ruta1 = $_POST["fotoActual1"];;

                if ($_FILES["editarFoto1"]["tmp_name"] != null ) {
                    list($ancho1, $alto1) = getimagesize($_FILES["editarFoto1"]["tmp_name"]);
                    $nuevaAncho = 500;
                    $nuevaAlto = 500;

                    /*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/
                    date_default_timezone_set('America/Lima');
                    $fecha = date('Y-m-d');
                    $hora = date('H');
                    $min = date('i');
                    $seg = date('s');
                    $horas = $hora . '-' . $min . '-' . $seg;
                    $nombreCarpeta = $fecha . '_' . $horas; 

                    $directorio = "vistas/img/sig/opt/" . $nombreCarpeta;
 
                    if (!file_exists($directorio)) {
                        mkdir($directorio, 0755);
                    }       

                    /*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/
                    if ($_FILES["editarFoto1"]["type"] == "image/jpeg" ) {
                        /*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
                        $aleatorio1 = mt_rand(100, 300);
                        $ruta1 = "vistas/img/sig/opt/" . $nombreCarpeta  . "/" . $aleatorio1 . ".jpg";                        
                        $origen1 = imagecreatefromjpeg($_FILES["editarFoto1"]["tmp_name"]);
                        $destino1 = imagecreatetruecolor($nuevaAncho, $nuevaAlto);
                        imagecopyresized($destino1, $origen1, 0, 0, 0, 0, $nuevaAncho, $nuevaAlto, $ancho1, $alto1);
                        imagejpeg($destino1, $ruta1);
                    }

                    if ($_FILES["editarFoto1"]["type"] == "image/png" ) {
                        /*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
                        $aleatorio1 = mt_rand(100, 300);
                        $ruta1 = "vistas/img/sig/opt/" . $nombreCarpeta  . "/" . $aleatorio1 . ".png";
                        $origen1 = imagecreatefrompng($_FILES["editarFoto1"]["tmp_name"]);
                        $destino1 = imagecreatetruecolor($nuevaAncho, $nuevaAlto);
                        imagecopyresized($destino1, $origen1, 0, 0, 0, 0, $nuevaAncho, $nuevaAlto, $ancho1, $alto1);
                        imagepng($destino1, $ruta1);
                    }
                }
                /*=============================================
				VALIDAR IMAGEN 02
				=============================================*/
                $ruta2 = $_POST["fotoActual2"];

                if ($_FILES["editarFoto2"]["tmp_name"] != null) { 
                    list($ancho2, $alto2) = getimagesize($_FILES["editarFoto2"]["tmp_name"]);

                    $nuevaAncho = 500;
                    $nuevaAlto = 500;

                    /*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/
                    date_default_timezone_set('America/Lima');
                    $fecha = date('Y-m-d');
                    $hora = date('H');
                    $min = date('i');
                    $seg = date('s');
                    $horas = $hora . '-' . $min . '-' . $seg;
                    $nombreCarpeta = $fecha . '_' . $horas;

                    $directorio = "vistas/img/sig/opt/" . $nombreCarpeta;

                    if (!file_exists($directorio)) {
                        mkdir($directorio, 0755);
                    }  

                    /*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/
                    if ($_FILES["editarFoto2"]["type"] == "image/jpeg") {
                        /*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
                        $aleatorio2 = mt_rand(400, 700);
                        $ruta2 = "vistas/img/sig/opt/" . $nombreCarpeta . "/" . $aleatorio2 . ".jpg";
                        $origen2 = imagecreatefromjpeg($_FILES["editarFoto2"]["tmp_name"]);
                        $destino2 = imagecreatetruecolor($nuevaAncho, $nuevaAlto);
                        imagecopyresized($destino2, $origen2, 0, 0, 0, 0, $nuevaAncho, $nuevaAlto, $ancho2, $alto2);
                        imagejpeg($destino2, $ruta2);
                    }

                    if ( $_FILES["editarFoto2"]["type"] == "image/png") {
                        /*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
                        $aleatorio2 = mt_rand(400, 700);
                        $ruta2 = "vistas/img/sig/opt/" . $nombreCarpeta . "/" . $aleatorio2 . ".png";
                        $origen2 = imagecreatefrompng($_FILES["editarFoto2"]["tmp_name"]);
                        $destino2 = imagecreatetruecolor($nuevaAncho, $nuevaAlto);
                        imagecopyresized($destino2, $origen2, 0, 0, 0, 0, $nuevaAncho, $nuevaAlto, $ancho2, $alto2);
                        imagepng($destino2, $ruta2);
                    }
                }
        
        // Sanitizar entradas 
        $numero = trim($_POST['inputEditarOperacion']);
        $operacion = str_replace('tablaEdit', '', $numero); 

        $placa = trim( $_POST[ 'inputEditarPlaca' ] );
        $fecha = trim( $_POST[ 'inputEditarFecha' ] );
        $cliente = trim( $_POST[ 'inputEditarCliente' ] );
        $lugar = trim( $_POST[ 'inputEditarLugar' ] );
        $observado = trim( $_POST[ 'inputEditarObservado' ] );
        $observador = trim( $_POST[ 'inputEditarObservador' ] );
        $buenasPracticas = trim( $_POST[ 'inputEditarBuenasPracticas' ] );

        $txt500Pregunta1 = trim( $_POST[ '500_edit_txtPregunta1' ] );
        $txt500Pregunta2 = trim( $_POST[ '500_edit_txtPregunta2' ] );
        $txt500Pregunta3 = trim( $_POST[ '500_edit_txtPregunta3' ] );
        $txt500Pregunta4 = trim( $_POST[ '500_edit_txtPregunta4' ] );
        $txt500Pregunta5 = trim( $_POST[ '500_edit_txtPregunta5' ] );
        $txt500Pregunta6 = trim( $_POST[ '500_edit_txtPregunta6' ] );
        $txt500Pregunta7 = trim( $_POST[ '500_edit_txtPregunta7' ] );
        $txt500Pregunta8 = trim( $_POST[ '500_edit_txtPregunta8' ] );
        $txt500Pregunta9 = trim( $_POST[ '500_edit_txtPregunta9' ] );
        $txt500Pregunta10 = trim( $_POST[ '500_edit_txtPregunta10' ] );
        $txt500Pregunta11 = trim( $_POST[ '500_edit_txtPregunta11' ] );
        $txt500Pregunta12 = trim( $_POST[ '500_edit_txtPregunta12' ] );
        $txt500Pregunta13 = trim( $_POST[ '500_edit_txtPregunta13' ] );
        $txt500Pregunta14 = trim( $_POST[ '500_edit_txtPregunta14' ] );
        $txt500Pregunta15 = trim( $_POST[ '500_edit_txtPregunta15' ] );
        $txt500Otros = trim( $_POST[ '500_edit_txtOtros' ] );

        $txt501Pregunta1 = trim( $_POST[ '501_edit_txtPregunta1' ] );
        $txt501Pregunta2 = trim( $_POST[ '501_edit_txtPregunta2' ] );
        $txt501Pregunta3 = trim( $_POST[ '501_edit_txtPregunta3' ] );
        $txt501Pregunta4 = trim( $_POST[ '501_edit_txtPregunta4' ] );
        $txt501Pregunta5 = trim( $_POST[ '501_edit_txtPregunta5' ] );
        $txt501Pregunta6 = trim( $_POST[ '501_edit_txtPregunta6' ] );
        $txt501Pregunta7 = trim( $_POST[ '501_edit_txtPregunta7' ] );
        $txt501Pregunta8 = trim( $_POST[ '501_edit_txtPregunta8' ] );
        $txt501Pregunta9 = trim( $_POST[ '501_edit_txtPregunta9' ] );
        $txt501Pregunta10 = trim( $_POST[ '501_edit_txtPregunta10' ] );
        $txt501Pregunta11 = trim( $_POST[ '501_edit_txtPregunta11' ] );
        $txt501Pregunta12 = trim( $_POST[ '501_edit_txtPregunta12' ] );
        $txt501Pregunta13 = trim( $_POST[ '501_edit_txtPregunta13' ] );
        $txt501Pregunta14 = trim( $_POST[ '501_edit_txtPregunta14' ] );
        $txt501Otros = trim( $_POST[ '501_edit_txtOtros' ] );

        $txt504Pregunta1 = trim( $_POST[ '504_edit_txtPregunta1' ] );
        $txt504Pregunta2 = trim( $_POST[ '504_edit_txtPregunta2' ] );
        $txt504Pregunta3 = trim( $_POST[ '504_edit_txtPregunta3' ] );
        $txt504Pregunta4 = trim( $_POST[ '504_edit_txtPregunta4' ] );
        $txt504Pregunta5 = trim( $_POST[ '504_edit_txtPregunta5' ] );
        $txt504Pregunta6 = trim( $_POST[ '504_edit_txtPregunta6' ] );
        $txt504Pregunta7 = trim( $_POST[ '504_edit_txtPregunta7' ] );
        $txt504Pregunta8 = trim( $_POST[ '504_edit_txtPregunta8' ] );
        $txt504Pregunta9 = trim( $_POST[ '504_edit_txtPregunta9' ] );
        $txt504Pregunta10 = trim( $_POST[ '504_edit_txtPregunta10' ] );
        $txt504Pregunta11 = trim( $_POST[ '504_edit_txtPregunta11' ] );
        $txt504Pregunta12 = trim( $_POST[ '504_edit_txtPregunta12' ] );
        $txt504Pregunta13 = trim( $_POST[ '504_edit_txtPregunta13' ] );
        $txt504Pregunta14 = trim( $_POST[ '504_edit_txtPregunta14' ] );
        $txt504Pregunta15 = trim( $_POST[ '504_edit_txtPregunta15' ] ); 
        $txt504Pregunta16 = trim( $_POST[ '504_edit_txtPregunta16' ] );
        $txt504Pregunta17 = trim( $_POST[ '504_edit_txtPregunta17' ] );
        $txt504Pregunta18 = trim( $_POST[ '504_edit_txtPregunta18' ] );
        $txt504Pregunta19 = trim( $_POST[ '504_edit_txtPregunta19' ] );
        $txt504Pregunta20 = trim( $_POST[ '504_edit_txtPregunta20' ] );
        $txt504Pregunta21 = trim( $_POST[ '504_edit_txtPregunta21' ] );
        $txt504Pregunta22 = trim( $_POST[ '504_edit_txtPregunta22' ] );
        $txt504Pregunta23 = trim( $_POST[ '504_edit_txtPregunta23' ] );
        $txt504Pregunta24 = trim( $_POST[ '504_edit_txtPregunta24' ] );
        $txt504Pregunta25 = trim( $_POST[ '504_edit_txtPregunta25' ] );
        $txt504Otros = trim( $_POST[ '504_edit_txtOtros' ] );
        
        $txt506Pregunta1 = trim( $_POST[ '506_edit_txtPregunta1' ] );
        $txt506Pregunta2 = trim( $_POST[ '506_edit_txtPregunta2' ] );
        $txt506Pregunta3 = trim( $_POST[ '506_edit_txtPregunta3' ] );
        $txt506Pregunta4 = trim( $_POST[ '506_edit_txtPregunta4' ] );
        $txt506Pregunta5 = trim( $_POST[ '506_edit_txtPregunta5' ] );
        $txt506Pregunta6 = trim( $_POST[ '506_edit_txtPregunta6' ] );
        $txt506Pregunta7 = trim( $_POST[ '506_edit_txtPregunta7' ] );
        $txt506Pregunta8 = trim( $_POST[ '506_edit_txtPregunta8' ] );
        $txt506Pregunta9 = trim( $_POST[ '506_edit_txtPregunta9' ] );
        $txt506Pregunta10 = trim( $_POST[ '506_edit_txtPregunta10' ] );
        $txt506Pregunta11 = trim( $_POST[ '506_edit_txtPregunta11' ] );
        $txt506Pregunta12 = trim( $_POST[ '506_edit_txtPregunta12' ] );
        $txt506Pregunta13 = trim( $_POST[ '506_edit_txtPregunta13' ] ); 
        $txt506Otros = trim( $_POST[ '506_edit_txtOtros' ] );

        $txt507Pregunta1 = trim( $_POST[ '507_edit_txtPregunta1' ] );
        $txt507Pregunta2 = trim( $_POST[ '507_edit_txtPregunta2' ] );
        $txt507Pregunta3 = trim( $_POST[ '507_edit_txtPregunta3' ] );
        $txt507Pregunta4 = trim( $_POST[ '507_edit_txtPregunta4' ] );
        $txt507Pregunta5 = trim( $_POST[ '507_edit_txtPregunta5' ] );
        $txt507Pregunta6 = trim( $_POST[ '507_edit_txtPregunta6' ] );
        $txt507Pregunta7 = trim( $_POST[ '507_edit_txtPregunta7' ] );
        $txt507Pregunta8 = trim( $_POST[ '507_edit_txtPregunta8' ] );
        $txt507Pregunta9 = trim( $_POST[ '507_edit_txtPregunta9' ] );
        $txt507Pregunta10 = trim( $_POST[ '507_edit_txtPregunta10' ] );
        $txt507Pregunta11 = trim( $_POST[ '507_edit_txtPregunta11' ] );
        $txt507Pregunta12 = trim( $_POST[ '507_edit_txtPregunta12' ] );
        $txt507Pregunta13 = trim( $_POST[ '507_edit_txtPregunta13' ] );
        $txt507Pregunta14 = trim( $_POST[ '507_edit_txtPregunta14' ] );
        $txt507Pregunta15 = trim( $_POST[ '507_edit_txtPregunta15' ] ); 
        $txt507Pregunta16 = trim( $_POST[ '507_edit_txtPregunta16' ] );
        $txt507Pregunta17 = trim( $_POST[ '507_edit_txtPregunta17' ] );
        $txt507Pregunta18 = trim( $_POST[ '507_edit_txtPregunta18' ] );
        $txt507Pregunta19 = trim( $_POST[ '507_edit_txtPregunta19' ] );
        $txt507Pregunta20 = trim( $_POST[ '507_edit_txtPregunta20' ] );
        $txt507Pregunta21 = trim( $_POST[ '507_edit_txtPregunta21' ] );
        $txt507Pregunta22 = trim( $_POST[ '507_edit_txtPregunta22' ] );
        $txt507Pregunta23 = trim( $_POST[ '507_edit_txtPregunta23' ] );
        $txt507Pregunta24 = trim( $_POST[ '507_edit_txtPregunta24' ] );
        $txt507Pregunta25 = trim( $_POST[ '507_edit_txtPregunta25' ] );
        $txt507Otros = trim( $_POST[ '507_edit_txtOtros' ] );

        $txt508Pregunta1 = trim( $_POST[ '508_edit_txtPregunta1' ] );
        $txt508Pregunta2 = trim( $_POST[ '508_edit_txtPregunta2' ] );
        $txt508Pregunta3 = trim( $_POST[ '508_edit_txtPregunta3' ] );
        $txt508Pregunta4 = trim( $_POST[ '508_edit_txtPregunta4' ] );
        $txt508Pregunta5 = trim( $_POST[ '508_edit_txtPregunta5' ] );
        $txt508Pregunta6 = trim( $_POST[ '508_edit_txtPregunta6' ] );
        $txt508Pregunta7 = trim( $_POST[ '508_edit_txtPregunta7' ] );
        $txt508Pregunta8 = trim( $_POST[ '508_edit_txtPregunta8' ] );
        $txt508Pregunta9 = trim( $_POST[ '508_edit_txtPregunta9' ] );
        $txt508Pregunta10 = trim( $_POST[ '508_edit_txtPregunta10' ] );
        $txt508Pregunta11 = trim( $_POST[ '508_edit_txtPregunta11' ] );
        $txt508Pregunta12 = trim( $_POST[ '508_edit_txtPregunta12' ] );
        $txt508Pregunta13 = trim( $_POST[ '508_edit_txtPregunta13' ] ); 
        $txt508Otros = trim( $_POST[ '508_edit_txtOtros' ] );

        $txt509Pregunta1 = trim( $_POST[ '509_edit_txtPregunta1' ] );
        $txt509Pregunta2 = trim( $_POST[ '509_edit_txtPregunta2' ] );
        $txt509Pregunta3 = trim( $_POST[ '509_edit_txtPregunta3' ] );
        $txt509Pregunta4 = trim( $_POST[ '509_edit_txtPregunta4' ] );
        $txt509Pregunta5 = trim( $_POST[ '509_edit_txtPregunta5' ] );
        $txt509Pregunta6 = trim( $_POST[ '509_edit_txtPregunta6' ] );
        $txt509Pregunta7 = trim( $_POST[ '509_edit_txtPregunta7' ] );
        $txt509Pregunta8 = trim( $_POST[ '509_edit_txtPregunta8' ] );
        $txt509Pregunta9 = trim( $_POST[ '509_edit_txtPregunta9' ] );
        $txt509Pregunta10 = trim( $_POST[ '509_edit_txtPregunta10' ] );
        $txt509Pregunta11 = trim( $_POST[ '509_edit_txtPregunta11' ] );
        $txt509Pregunta12 = trim( $_POST[ '509_edit_txtPregunta12' ] );
        $txt509Pregunta13 = trim( $_POST[ '509_edit_txtPregunta13' ] );
        $txt509Pregunta14 = trim( $_POST[ '509_edit_txtPregunta14' ] );
        $txt509Pregunta15 = trim( $_POST[ '509_edit_txtPregunta15' ] ); 
        $txt509Pregunta16 = trim( $_POST[ '509_edit_txtPregunta16' ] );
        $txt509Pregunta17 = trim( $_POST[ '509_edit_txtPregunta17' ] );
        $txt509Pregunta18 = trim( $_POST[ '509_edit_txtPregunta18' ] );
        $txt509Pregunta19 = trim( $_POST[ '509_edit_txtPregunta19' ] );
        $txt509Pregunta20 = trim( $_POST[ '509_edit_txtPregunta20' ] );
        $txt509Pregunta21 = trim( $_POST[ '509_edit_txtPregunta21' ] );
        $txt509Pregunta22 = trim( $_POST[ '509_edit_txtPregunta22' ] );
        $txt509Pregunta23 = trim( $_POST[ '509_edit_txtPregunta23' ] );
        $txt509Pregunta24 = trim( $_POST[ '509_edit_txtPregunta24' ] );
        $txt509Pregunta25 = trim( $_POST[ '509_edit_txtPregunta25' ] );
        $txt509Otros = trim( $_POST[ '509_edit_txtOtros' ] );

        $txt511Pregunta1 = trim( $_POST[ '511_edit_txtPregunta1' ] );
        $txt511Pregunta2 = trim( $_POST[ '511_edit_txtPregunta2' ] );
        $txt511Pregunta3 = trim( $_POST[ '511_edit_txtPregunta3' ] );
        $txt511Pregunta4 = trim( $_POST[ '511_edit_txtPregunta4' ] );
        $txt511Pregunta5 = trim( $_POST[ '511_edit_txtPregunta5' ] );
        $txt511Pregunta6 = trim( $_POST[ '511_edit_txtPregunta6' ] );
        $txt511Pregunta7 = trim( $_POST[ '511_edit_txtPregunta7' ] );
        $txt511Pregunta8 = trim( $_POST[ '511_edit_txtPregunta8' ] );
        $txt511Pregunta9 = trim( $_POST[ '511_edit_txtPregunta9' ] );
        $txt511Pregunta10 = trim( $_POST[ '511_edit_txtPregunta10' ] );
        $txt511Pregunta11 = trim( $_POST[ '511_edit_txtPregunta11' ] );
        $txt511Pregunta12 = trim( $_POST[ '511_edit_txtPregunta12' ] );
        $txt511Pregunta13 = trim( $_POST[ '511_edit_txtPregunta13' ] );
        $txt511Pregunta14 = trim( $_POST[ '511_edit_txtPregunta14' ] );
        $txt511Pregunta15 = trim( $_POST[ '511_edit_txtPregunta15' ] ); 
        $txt511Pregunta16 = trim( $_POST[ '511_edit_txtPregunta16' ] );
        $txt511Pregunta17 = trim( $_POST[ '511_edit_txtPregunta17' ] );
        $txt511Pregunta18 = trim( $_POST[ '511_edit_txtPregunta18' ] );
        $txt511Pregunta19 = trim( $_POST[ '511_edit_txtPregunta19' ] );
        $txt511Pregunta20 = trim( $_POST[ '511_edit_txtPregunta20' ] );
        $txt511Pregunta21 = trim( $_POST[ '511_edit_txtPregunta21' ] );
        $txt511Pregunta22 = trim( $_POST[ '511_edit_txtPregunta22' ] );
        $txt511Pregunta23 = trim( $_POST[ '511_edit_txtPregunta23' ] );
        $txt511Pregunta24 = trim( $_POST[ '511_edit_txtPregunta24' ] );
        $txt511Pregunta25 = trim( $_POST[ '511_edit_txtPregunta25' ] );
        $txt511Otros = trim( $_POST[ '511_edit_txtOtros' ] );
        
        $descripcionAdicional = trim( $_POST[ 'inputEditarDescripcionAdicional' ] );
        $descripcionObservacion = trim( $_POST[ 'inputEditarDescripcionObservacion' ] );
        $tipoHallazgo = trim( $_POST[ 'inputEditarTipoHallazgo' ] );
        $relacionado = trim( $_POST[ 'inputEditarRelacionado' ] );
        $correccion = trim( $_POST[ 'inputEditarCorreccion' ] );

        $opt_id = trim( $_POST[ 'inputEditarIdOpt' ] );

        $usuario_id = trim( $_POST[ 'inputEditarUser' ] );

        // Validaciones
       /* if ( !preg_match( '/^[0-9]+$/', $ruc ) ) {
            self::mostrarAlerta( 'error', '¡El campo RUC solo permite caracteres numéricos!', 'empresas' );
            return;
        }

        if ( !preg_match( '/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $razonSocial ) ) {
            self::mostrarAlerta( 'error', '¡El campo razón social no pueden estar vacíos ni llevar caracteres especiales!', 'empresas' );
            return;
        }*/

        // Registrar fecha y hora de actualización
        date_default_timezone_set( 'America/Lima' );
        $fechaActual = date( 'Y-m-d H:i:s' );

        // Preparar datos
        $tabla = 'opts';
        $datos = array(
            'opt_cenco_codigo' => $operacion,
            'opt_vehiculo_id' => $placa,
            'opt_cliente' => $cliente,
            'opt_lugar' => $lugar ,
            'opt_fecha' => $fecha ,
            'opt_observado' => $observado ,
            'opt_observador' => $observador ,
            'opt_bps_encontrada' => $buenasPracticas ,

            'opt_500_pregunta1' => $txt500Pregunta1 ,
            'opt_500_pregunta2' => $txt500Pregunta2 ,
            'opt_500_pregunta3' => $txt500Pregunta3 ,
            'opt_500_pregunta4' => $txt500Pregunta4 ,
            'opt_500_pregunta5' => $txt500Pregunta5 ,
            'opt_500_pregunta6' => $txt500Pregunta6 ,
            'opt_500_pregunta7' => $txt500Pregunta7 ,
            'opt_500_pregunta8' => $txt500Pregunta8 ,
            'opt_500_pregunta9' => $txt500Pregunta9 ,
            'opt_500_pregunta10' => $txt500Pregunta10 ,
            'opt_500_pregunta11' => $txt500Pregunta11 ,
            'opt_500_pregunta12' => $txt500Pregunta12 ,
            'opt_500_pregunta13' => $txt500Pregunta13 ,
            'opt_500_pregunta14' => $txt500Pregunta14 ,
            'opt_500_pregunta15' => $txt500Pregunta15 ,
            'opt_500_otros' => $txt500Otros ,

            'opt_501_pregunta1' => $txt501Pregunta1 ,
            'opt_501_pregunta2' => $txt501Pregunta2 ,
            'opt_501_pregunta3' => $txt501Pregunta3 ,
            'opt_501_pregunta4' => $txt501Pregunta4 ,
            'opt_501_pregunta5' => $txt501Pregunta5 ,
            'opt_501_pregunta6' => $txt501Pregunta6 ,
            'opt_501_pregunta7' => $txt501Pregunta7 ,
            'opt_501_pregunta8' => $txt501Pregunta8 ,
            'opt_501_pregunta9' => $txt501Pregunta9 ,
            'opt_501_pregunta10' => $txt501Pregunta10 ,
            'opt_501_pregunta11' => $txt501Pregunta11 ,
            'opt_501_pregunta12' => $txt501Pregunta12 ,
            'opt_501_pregunta13' => $txt501Pregunta13 ,
            'opt_501_pregunta14' => $txt501Pregunta14 ,
            'opt_501_otros' => $txt501Otros ,
            
            'opt_504_pregunta1' => $txt504Pregunta1 ,
            'opt_504_pregunta2' => $txt504Pregunta2 ,
            'opt_504_pregunta3' => $txt504Pregunta3 ,
            'opt_504_pregunta4' => $txt504Pregunta4 ,
            'opt_504_pregunta5' => $txt504Pregunta5 ,
            'opt_504_pregunta6' => $txt504Pregunta6 ,
            'opt_504_pregunta7' => $txt504Pregunta7 ,
            'opt_504_pregunta8' => $txt504Pregunta8 ,
            'opt_504_pregunta9' => $txt504Pregunta9 ,
            'opt_504_pregunta10' => $txt504Pregunta10 ,
            'opt_504_pregunta11' => $txt504Pregunta11 ,
            'opt_504_pregunta12' => $txt504Pregunta12 ,
            'opt_504_pregunta13' => $txt504Pregunta13 ,
            'opt_504_pregunta14' => $txt504Pregunta14 ,
            'opt_504_pregunta15' => $txt504Pregunta15 ,
            'opt_504_pregunta16' => $txt504Pregunta16 ,
            'opt_504_pregunta17' => $txt504Pregunta17 ,
            'opt_504_pregunta18' => $txt504Pregunta18 ,
            'opt_504_pregunta19' => $txt504Pregunta19 ,
            'opt_504_pregunta20' => $txt504Pregunta20 ,
            'opt_504_pregunta21' => $txt504Pregunta21 ,
            'opt_504_pregunta22' => $txt504Pregunta22 ,
            'opt_504_pregunta23' => $txt504Pregunta23 ,
            'opt_504_pregunta24' => $txt504Pregunta24 ,
            'opt_504_pregunta25' => $txt504Pregunta25 ,
            'opt_504_otros' => $txt504Otros ,

            'opt_506_pregunta1' => $txt506Pregunta1 ,
            'opt_506_pregunta2' => $txt506Pregunta2 ,
            'opt_506_pregunta3' => $txt506Pregunta3 ,
            'opt_506_pregunta4' => $txt506Pregunta4 ,
            'opt_506_pregunta5' => $txt506Pregunta5 ,
            'opt_506_pregunta6' => $txt506Pregunta6 ,
            'opt_506_pregunta7' => $txt506Pregunta7 ,
            'opt_506_pregunta8' => $txt506Pregunta8 ,
            'opt_506_pregunta9' => $txt506Pregunta9 ,
            'opt_506_pregunta10' => $txt506Pregunta10 ,
            'opt_506_pregunta11' => $txt506Pregunta11 ,
            'opt_506_pregunta12' => $txt506Pregunta12 ,
            'opt_506_pregunta13' => $txt506Pregunta13 ,
            'opt_506_otros' => $txt506Otros ,

            'opt_507_pregunta1' => $txt507Pregunta1 ,
            'opt_507_pregunta2' => $txt507Pregunta2 ,
            'opt_507_pregunta3' => $txt507Pregunta3 ,
            'opt_507_pregunta4' => $txt507Pregunta4 ,
            'opt_507_pregunta5' => $txt507Pregunta5 ,
            'opt_507_pregunta6' => $txt507Pregunta6 ,
            'opt_507_pregunta7' => $txt507Pregunta7 ,
            'opt_507_pregunta8' => $txt507Pregunta8 ,
            'opt_507_pregunta9' => $txt507Pregunta9 ,
            'opt_507_pregunta10' => $txt507Pregunta10 ,
            'opt_507_pregunta11' => $txt507Pregunta11 ,
            'opt_507_pregunta12' => $txt507Pregunta12 ,
            'opt_507_pregunta13' => $txt507Pregunta13 ,
            'opt_507_pregunta14' => $txt507Pregunta14 ,
            'opt_507_pregunta15' => $txt507Pregunta15 ,
            'opt_507_pregunta16' => $txt507Pregunta16 ,
            'opt_507_pregunta17' => $txt507Pregunta17 ,
            'opt_507_pregunta18' => $txt507Pregunta18 ,
            'opt_507_pregunta19' => $txt507Pregunta19 ,
            'opt_507_pregunta20' => $txt507Pregunta20 ,
            'opt_507_pregunta21' => $txt507Pregunta21 ,
            'opt_507_pregunta22' => $txt507Pregunta22 ,
            'opt_507_pregunta23' => $txt507Pregunta23 ,
            'opt_507_pregunta24' => $txt507Pregunta24 ,
            'opt_507_pregunta25' => $txt507Pregunta25 ,
            'opt_507_otros' => $txt507Otros ,

            'opt_508_pregunta1' => $txt508Pregunta1 ,
            'opt_508_pregunta2' => $txt508Pregunta2 ,
            'opt_508_pregunta3' => $txt508Pregunta3 ,
            'opt_508_pregunta4' => $txt508Pregunta4 ,
            'opt_508_pregunta5' => $txt508Pregunta5 ,
            'opt_508_pregunta6' => $txt508Pregunta6 ,
            'opt_508_pregunta7' => $txt508Pregunta7 ,
            'opt_508_pregunta8' => $txt508Pregunta8 ,
            'opt_508_pregunta9' => $txt508Pregunta9 ,
            'opt_508_pregunta10' => $txt508Pregunta10 ,
            'opt_508_pregunta11' => $txt508Pregunta11 ,
            'opt_508_pregunta12' => $txt508Pregunta12 ,
            'opt_508_pregunta13' => $txt508Pregunta13 ,
            'opt_508_otros' => $txt508Otros ,

            'opt_509_pregunta1' => $txt509Pregunta1 ,
            'opt_509_pregunta2' => $txt509Pregunta2 ,
            'opt_509_pregunta3' => $txt509Pregunta3 ,
            'opt_509_pregunta4' => $txt509Pregunta4 ,
            'opt_509_pregunta5' => $txt509Pregunta5 ,
            'opt_509_pregunta6' => $txt509Pregunta6 ,
            'opt_509_pregunta7' => $txt509Pregunta7 ,
            'opt_509_pregunta8' => $txt509Pregunta8 ,
            'opt_509_pregunta9' => $txt509Pregunta9 ,
            'opt_509_pregunta10' => $txt509Pregunta10 ,
            'opt_509_pregunta11' => $txt509Pregunta11 ,
            'opt_509_pregunta12' => $txt509Pregunta12 ,
            'opt_509_pregunta13' => $txt509Pregunta13 ,
            'opt_509_pregunta14' => $txt509Pregunta14 ,
            'opt_509_pregunta15' => $txt509Pregunta15 ,
            'opt_509_pregunta16' => $txt509Pregunta16 ,
            'opt_509_pregunta17' => $txt509Pregunta17 ,
            'opt_509_pregunta18' => $txt509Pregunta18 ,
            'opt_509_pregunta19' => $txt509Pregunta19 ,
            'opt_509_pregunta20' => $txt509Pregunta20 ,
            'opt_509_pregunta21' => $txt509Pregunta21 ,
            'opt_509_pregunta22' => $txt509Pregunta22 ,
            'opt_509_pregunta23' => $txt509Pregunta23 ,
            'opt_509_pregunta24' => $txt509Pregunta24 ,
            'opt_509_pregunta25' => $txt509Pregunta25 ,
            'opt_509_otros' => $txt509Otros ,

            'opt_511_pregunta1' => $txt511Pregunta1 ,
            'opt_511_pregunta2' => $txt511Pregunta2 ,
            'opt_511_pregunta3' => $txt511Pregunta3 ,
            'opt_511_pregunta4' => $txt511Pregunta4 ,
            'opt_511_pregunta5' => $txt511Pregunta5 ,
            'opt_511_pregunta6' => $txt511Pregunta6 ,
            'opt_511_pregunta7' => $txt511Pregunta7 ,
            'opt_511_pregunta8' => $txt511Pregunta8 ,
            'opt_511_pregunta9' => $txt511Pregunta9 ,
            'opt_511_pregunta10' => $txt511Pregunta10 ,
            'opt_511_pregunta11' => $txt511Pregunta11 ,
            'opt_511_pregunta12' => $txt511Pregunta12 ,
            'opt_511_pregunta13' => $txt511Pregunta13 ,
            'opt_511_pregunta14' => $txt511Pregunta14 ,
            'opt_511_pregunta15' => $txt511Pregunta15 ,
            'opt_511_pregunta16' => $txt511Pregunta16 ,
            'opt_511_pregunta17' => $txt511Pregunta17 ,
            'opt_511_pregunta18' => $txt511Pregunta18 ,
            'opt_511_pregunta19' => $txt511Pregunta19 ,
            'opt_511_pregunta20' => $txt511Pregunta20 ,
            'opt_511_pregunta21' => $txt511Pregunta21 ,
            'opt_511_pregunta22' => $txt511Pregunta22 ,
            'opt_511_pregunta23' => $txt511Pregunta23 ,
            'opt_511_pregunta24' => $txt511Pregunta24 ,
            'opt_511_pregunta25' => $txt511Pregunta25 ,
            'opt_511_otros' => $txt511Otros ,

            'opt_tipo_hallazgo' => $tipoHallazgo ,
            'opt_relacionado' => $relacionado ,
            'opt_decripcion_observacion' => $descripcionObservacion,
            'opt_decripcion_adicional' => $descripcionAdicional ,
            'opt_correccion' => $correccion ,
            'opt_evidencia1' => $ruta1, 
            'opt_evidencia2' => $ruta2, 
            'opt_id_usuario' => $usuario_id,            
            'opt_fecha_update' => $fechaActual,
            'opt_id' => $opt_id,  
        );

        // Ejecutar actualización
        $optAntes = ModeloOpts::mdlObtenerOptPorId($tabla, (int) $opt_id);
        $respuesta = ModeloOpts::mdlEditarOpt( $tabla, $datos );

        // Mensaje de éxito o error
        if ( $respuesta == 'ok' ) {
            self::registrarAuditoriaOpts('EDITAR', (string) $opt_id, $optAntes ?: null, $datos);
            self::mostrarAlerta( 'success', 'Los datos han sido actualizados correctamente', 'sig-opt' );
        } else {
            self::mostrarAlerta( 'error', 'Hubo un problema al actualizar los datos', 'sig-opt' );
        }
    }


    /*-------------------------------------
    ELIMINAR CENTRO DE COSTO
    -------------------------------------*/

    static public function ctrEliminarOpt(){

        if (isset($_GET["idOpt"])) {

            $tabla = "opts";
            $datos = $_GET["idOpt"];

            $optAntes = ModeloOpts::mdlObtenerOptPorId($tabla, (int) $datos);

            $respuesta = ModeloOpts::mdlEliminarOpt($tabla, $datos);

            if ($respuesta == "ok") {
                self::registrarAuditoriaOpts('ELIMINAR', (string) $datos, $optAntes ?: null, null);
                echo '<script>
				swal({
					  type: "success",
					  title: "Los datos fueron enviados a la papelera",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "sig-opt";
								}
							})
				</script>';
            }
        }
    }

    static public function ctrRestaurarOpt($idOpt){
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array('status' => 'error', 'message' => 'Solo los administradores pueden restaurar OPT.');
        }

        $tabla = 'opts';
        $idOpt = (int) $idOpt;
        if ($idOpt <= 0) {
            return array('status' => 'error', 'message' => 'Identificador invalido.');
        }

        $optAntes = ModeloOpts::mdlObtenerOptPorId($tabla, $idOpt);

        $respuesta = ModeloOpts::mdlRestaurarOpt($tabla, $idOpt);
        if ($respuesta === 'ok') {
            $optDespues = ModeloOpts::mdlMostrarOpts($tabla, 'opt_id', $idOpt);
            self::registrarAuditoriaOpts('RESTAURAR', (string) $idOpt, $optAntes ?? null, $optDespues ?: null);
            return array('status' => 'ok');
        }

        return array('status' => 'error', 'message' => 'No se pudo restaurar el registro o ya estaba activo.');
    }

    static public function ctrDepurarOpt($idOpt){
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array('status' => 'error', 'message' => 'Solo los administradores pueden eliminar definitivamente.');
        }

        $tabla = 'opts';
        $idOpt = (int) $idOpt;
        if ($idOpt <= 0) {
            return array('status' => 'error', 'message' => 'Identificador invalido.');
        }

        $opt = ModeloOpts::mdlObtenerOptPorId($tabla, $idOpt);
        if (!$opt || empty($opt['opt_fecha_delete'])) {
            return array('status' => 'error', 'message' => 'El registro debe estar en papelera para depurarlo.');
        }

        $respuesta = ModeloOpts::mdlDepurarOpt($tabla, $idOpt);
        if ($respuesta !== 'ok') {
            return array('status' => 'error', 'message' => 'No se pudo depurar el registro.');
        }

        self::registrarAuditoriaOpts('DEPURAR', (string) $idOpt, $opt, null);
        self::eliminarEvidenciaOpt($opt['opt_evidencia1']);
        self::eliminarEvidenciaOpt($opt['opt_evidencia2']);

        return array('status' => 'ok');
    }

    private static function eliminarEvidenciaOpt($rutaArchivo){
        if (empty($rutaArchivo)) {
            return;
        }

        if (file_exists($rutaArchivo)) {
            @unlink($rutaArchivo);
        }

        $directorio = dirname($rutaArchivo);
        if (
            $directorio !== '.' &&
            $directorio !== DIRECTORY_SEPARATOR &&
            is_dir($directorio)
        ) {
            $contenido = @scandir($directorio);
            if (is_array($contenido) && count($contenido) <= 2) {
                @rmdir($directorio);
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

    static public function ctrMostrarAuditoriaOpts($limit = 200) {
        if (!isset($_SESSION['usu_perfil']) || $_SESSION['usu_perfil'] !== 'Administrador') {
            return array();
        }

        return ModeloAuditoria::mdlMostrarAuditoriaGeneral('opts', (int) $limit);
    }

    private static function registrarAuditoriaOpts($accion, $entidadId, $antes = null, $despues = null) {
        $usuarioActor = isset($_SESSION['usu_id']) ? (int) $_SESSION['usu_id'] : null;

        $camposCambiados = array();
        if (is_array($antes) && is_array($despues)) {
            $camposAuditar = ['opt_id', 'opt_cenco_codigo', 'opt_vehiculo_id', 'opt_cliente',
                'opt_lugar', 'opt_fecha', 'opt_observado', 'opt_observador'];
            foreach ($camposAuditar as $key) {
                $valueAntes = array_key_exists($key, $antes) ? $antes[$key] : null;
                $valueDespues = array_key_exists($key, $despues) ? $despues[$key] : null;
                if ((string) $valueAntes !== (string) $valueDespues) {
                    $camposCambiados[$key] = array('antes' => $valueAntes, 'despues' => $valueDespues);
                }
            }
        }

        ModeloAuditoria::mdlRegistrarAuditoriaGeneral(
            'opts',
            'opts',
            $entidadId,
            $accion,
            $usuarioActor,
            array('antes' => $antes, 'despues' => $despues, 'campos_cambiados' => $camposCambiados)
        );
    }

}
//Fin Class